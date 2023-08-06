<?php

namespace App\Repository\Eloquent\Sql;

use App\Enums\SpecsEnum;
use App\Facade\Support\Core\Crud;
use App\Facade\Support\Tools\{Ajax, CrudMessage};
use App\Http\Traits\Other\HasDynamicMultiTrans;
use App\Models\Spec;
use App\Repository\Contracts\ISpecRepository;
use Exception;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SpecRepository extends BaseRepository implements ISpecRepository
{
    use HasDynamicMultiTrans;

    public function __construct(Spec $model)
    {
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $modelData = except($this->model::beTranslated(), ['names_ar', 'names_en']);

            $spec = Crud::storeTranslatedModel($this->class, $modelData, true);

            if ($request->type == SpecsEnum::SELECT)
            {
                DB::table('options')->insert(self::setOptions($request, $spec));

                DB::table('option_names')->insert(self::setRows($spec->options,'option_id'));

                $formNamesTranslatedAttrs = self::getLangData($request,'ar','names') + self::getLangData($request,'en','names');

                DB::table('option_name_translations')->insert(self::setTranslatedRows($formNamesTranslatedAttrs, $spec->options, 'option_name_id', 'name'));
            }

            DB::commit();

            return CrudMessage::successResponse();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public function update(Request $request, $currentModel)
    {
        DB::beginTransaction();
        try
        {
            $modelData = except($this->model::beTranslated(), ['names_ar', 'colors', 'names_en']);

            $spec = Crud::updateTranslatedModel($this->class, $modelData, $currentModel, true);

            if ($request->type == SpecsEnum::SELECT)
            {
                DB::table('options')->where('spec_id', $spec->id)->delete();

                DB::table('options')->insert(self::setOptions($request, $spec));

                DB::table('option_names')->insert(self::setRows($spec->options, 'option_id'));

                $formNamesTranslatedAttrs = self::getLangData($request, 'ar', 'names') + self::getLangData($request, 'en', 'names');

                DB::table('option_name_translations')->insert(self::setTranslatedRows($formNamesTranslatedAttrs, $spec->options, 'option_name_id', 'name'));
            }

            DB::commit();

            return CrudMessage::successResponse();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public function formFields($type = 'create', $currentModel = null): array
    {
        $data = parent::formFields($type, $currentModel);

        $data['types'] = Spec::types();

        $data['dropdown'] = Spec::dropdown();

        return $data;
    }

    private static function setOptions($request, $spec): array
    {
        $options = [];

        $colors = $request->dropdown == SpecsEnum::COLOR ? $request->colors : [];

        foreach ($request['names_ar'] as $i => $name)
        {
            $options[$i] = [
                'spec_id'    => $spec->id,
                'value'      => count($colors) > 0 ? $colors[$i] : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $options;
    }

    public function trashed(): View
    {
        $trashes = $this->model::onlyTrashed()->with(['translation'])->get();

        return view('Back.'.$this->folder.'.trashed', compact('trashes'));
    }

    public function removeOptionById(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            DB::table('options')->where('id', $request->id)->delete();

            DB::commit();

            return Ajax::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return Ajax::fails($e->getMessage());
        }
    }
}
