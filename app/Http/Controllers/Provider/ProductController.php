<?php

namespace App\Http\Controllers\Provider;

use App\Facade\Support\Tools\Ajax;
use App\Facade\Support\Core\Crud;
use App\Facade\Support\Tools\CrudMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\{CreateProductRequest, EditProductRequest};
use App\Models\{Category, City, Image, Product, Provider, Section};
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $provider = (object) auth()->guard('provider')->user();

        $products = Product::query()
            ->whereNotNull('type')
            ->whereTypeId($provider->id)
            ->where('owner', Provider::class)
            ->where('owner_id', $provider->id)
            ->paginate(10);

        return view('Provider.products.index', compact('products'));
    }

    public function rentalProducts(): View
    {
        $provider_id = auth()->guard('provider')->id();

        $products = Product::query()
            ->withTranslation()
            ->whereNotNull('type')
            ->whereTypeId($provider_id)
            ->paginate(10);

        return view('Provider.products.rental-products', compact('products'));
    }

    public function create(): View
    {
        return view('Provider.products.create', [
            'cities'   => City::getInSelectForm(),
            'sections' => Section::getInSelectForm(),
        ]);
    }

    public function edit(Product $product): View
    {
        Crud::load_translated_attrs($product);

        return view('Provider.products.edit', [
            'currentModel' => $product,
            'cities'       => City::getInSelectForm(),
            'sections'     => Section::getInSelectForm(),
        ]);
    }

    public function store(CreateProductRequest $request)
    {
        DB::beginTransaction();
        try
        {
            if (is_null($request->user()->address)) return CrudMessage::warningTrans('api.sorry-you-do-not-have-an-address');

            DB::table('sections')->where('id', $request->section_id)->increment('store_products');

            DB::table('cities')->where('id', $request->city_id)->increment('store_products');

            $product = Crud::storeTranslatedModelWithCreated(Product::class, $request, [
                'type'     => $request->ownership == 'rental' ? null : Provider::class,
                'type_id'  => $request->ownership == 'rental' ? null : $request->user()->id,
                'owner'    => Provider::class,
                'owner_id' => $request->user()->id,
            ]);

            if ($product instanceof JsonResponse) return CrudMessage::fails($product);

            $product->section()->increment($request->ownership == 'rental' ? 'products' : 'store_products');

            $product->city()->increment($request->ownership == 'rental' ? 'products' : 'store_products');

            $product->saveOptionsAndSpecs($request->options, $request->specs);

            DB::commit();

            return CrudMessage::successResponse('الطلب تم بنجاح برجاء انتظار موافقة الإدارة علي المنتج الخاص بكم !');
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public function update(EditProductRequest $request, Product $product)
    {
        $product = Crud::updateTranslatedModel(Product::class, $request, $product,true, [
            'type'    => $request->ownership == 'rental' ? null : Provider::class,
            'type_id' => $request->ownership == 'rental' ? null : $request->user()->id,
        ]);

        $product->updateOptionsAndSpecs(Arr::wrap($request->options), Arr::wrap($request->specs));

        return CrudMessage::successResponse();
    }

    public function delete(Request $request)
    {
        DB::table('sections')->where('id', $request->section_id)->decrement('store_products');

        DB::table('cities')->where('id', $request->city_id)->decrement('store_products');

        return Crud::delete(Product::class, $request->id);
    }

    public function show(Product $product): View
    {
        return view('Provider.products.show', compact('product'));
    }

    public function search(Request $request)
    {
        //
    }

    public function removeImageFromList(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            if (! $image = Image::find($request->id)) return Ajax::fails('image not found');

            storage_unlink('products', $image->image);

            $image->delete();

            DB::commit();

            return Ajax::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return Ajax::fails(getFormattedException($e));
        }
    }

    public function getCategoriesBySectionId(Request $request): JsonResponse
    {
        $categories = [];

        $cats = Category::whereSectionId($request->section_id)->with(['translation'])->active()->get();

        foreach ($cats as $category)
        {
            $categories[$category->id] = $category->name;
        }

        return Ajax::response($categories);
    }
}
