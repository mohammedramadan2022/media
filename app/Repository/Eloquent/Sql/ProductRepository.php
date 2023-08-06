<?php

namespace App\Repository\Eloquent\Sql;

use App\Casts\Status;
use App\Facade\Support\Core\Crud;
use App\Facade\Support\Tools\{Ajax, CrudMessage};
use App\Mail\SendAdminMail;
use App\Models\{Category, City, Product, Provider, Section};
use App\Repository\Contracts\IProductRepository;
use Exception;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\{DB, Mail};
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ProductRepository extends BaseRepository implements IProductRepository
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function index(): View
    {
        $query = $this->model::query()->with(['images', 'section.translation', 'category.translation', 'city.translation', 'translation', 'category.translation']);

        $query->has('category');

        return view('Back.Products.index', [
            'products' => $query->latest()->paginate(10),
            'cities'   => City::getInSelectForm(),
            'sections' => Section::getInSelectForm(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $data = except($this->model::beTranslated(), ['options', 'ownership']);

            $product = Crud::storeTranslatedModelWithCreated($this->class, $data, [
                'is_accepted' => 1,
                'status'      => Status::ACTIVE,
                'type'        => $request->ownership == 'rental' ? null : Provider::class,
                'type_id'     => $request->ownership == 'rental' ? null : $request->owner_id,
            ]);

            if ($product instanceof JsonResponse) return CrudMessage::fails($product);

            $product->section()->increment($request->ownership == 'rental' ? 'products' : 'store_products');

            $product->city()->increment($request->ownership == 'rental' ? 'products' : 'store_products');

            $product->saveOptionsAndSpecs($request->options, $request->specs);

            DB::commit();

            return CrudMessage::successResponse();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public function accept(Product $product): RedirectResponse
    {
        $product->update(['is_accepted' => 1]);

        if ($product->type == Provider::class)
        {
            $message = 'تم قبول المنتج الخاص بكم بنجاح من قبل إدارة الموقع';

            Mail::to($product->provider->email)->send(new SendAdminMail($message, 'المنتجات'));
        }

        return CrudMessage::success();
    }

    public function reject(Product $product): RedirectResponse
    {
        $product->update(['is_accepted' => 0]);

        if ($product->type == Provider::class)
        {
            $message = 'تم رفض طلب ضم المنتج الخاص بكم من قبل إدارة الموقع برجاء التواصل مع إدارة الموقع لمزيد من المعلومات';

            Mail::to($product->provider->email)->send(new SendAdminMail($message, 'المنتجات'));
        }

        return CrudMessage::success();
    }

    public function forceDelete($id): RedirectResponse
    {
        $currentModel = Product::onlyTrashed()->where('id', $id)->first();

        modelForceDelete($this->class, $id);

        $currentModel->section()->decrement(is_null($currentModel->type) ? 'products' : 'store_products');

        $currentModel->city()->decrement(is_null($currentModel->type) ? 'products' : 'store_products');

        return CrudMessage::remove($this->name);
    }

    public function getCategoriesBySectionId(Request $request): JsonResponse
    {
        $data = Category::active()->withTranslation()->whereSectionId($request->section_id)->get();

        $categories = [];

        foreach ($data as $category)
        {
            $categories[$category->id] = $category->name;
        }

        return Ajax::response($categories);
    }

    public function formFields($type = 'create', $currentModel = null): array
    {
        $data = parent::formFields($type, $currentModel);

        $data['sections'] = Section::getInSelectForm();

        $data['cities'] = City::getInSelectForm();

        $data['providers'] = Provider::getInSelectForm();

        return $data;
    }

    public function update(Request $request, $currentModel)
    {
        DB::beginTransaction();
        try
        {
            $modelData = except($this->model::beTranslated(), ['ownership', 'specs', 'options']);

            $product = Crud::updateTranslatedModel($this->class, $modelData, $currentModel, true, [
                'type'     => $request->ownership == 'rental' ? null : Provider::class,
                'type_id'  => $request->ownership == 'rental' ? null : $request->owner_id,
                'owner_id' => $request->ownership == 'rental' ? null : $request->owner_id,
            ]);

            $product->updateOptionsAndSpecs(Arr::wrap($request->options), Arr::wrap($request->specs));

            DB::commit();

            return CrudMessage::edit('product');
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public function search($request): View
    {
        $sorting = $request->sorting == 'newer-to-older' ? 'DESC' : 'ASC';

        $query = $this->model::query();

        $query->has('category')->with(['translation', 'category.translation', 'section.translation']);

        $query = $request->filled('term') ? $query->search($request->term) : $query;

        $query = $request->filled('city_id') ? $query->where('city_id', $request->city_id) : $query;
        $query = $request->filled('category_id') ? $query->where('category_id', $request->category_id) : $query;
        $query = $request->filled('section_id') ? $query->where('section_id', $request->section_id) : $query;

        $collection = $query->orderBy('id', $sorting)->paginate(10);

        return view('Back.Products.index', [
            'products' => $collection,
            'cities'   => City::getInSelectForm(),
            'sections' => Section::getInSelectForm(),
        ]);
    }

    public function getOptionsByCategoryId(Request $request): JsonResponse|string
    {
        DB::beginTransaction();
        try
        {
            $specs = [];

            $currentModel = Product::find($request->product_id);

            $category = Category::with(['translation', 'specs.translation', 'specs.options'])->whereId($request->category_id)->first();

            foreach ($category->specs as $i => $spec) {
                $specs[$i] = [
                    'spec'    => [
                        'id'       => $spec->id,
                        'type'     => $spec->type,
                        'dropdown' => $spec->dropdown,
                        'name'     => $spec->name,
                    ],
                    'options' => $spec->getOptions(),
                ];
            }

            DB::commit();

            return view('Back.Products.dynamic-inputs', compact('specs', 'currentModel'))->render();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return Ajax::response(status: false, message: getFormattedException($e), code: Response::HTTP_BAD_REQUEST);
        }
    }
}
