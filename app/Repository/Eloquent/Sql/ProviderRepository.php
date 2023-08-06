<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\Crud;
use App\Facade\Support\Core\Uploaded;
use App\Facade\Support\Tools\CrudMessage;
use App\Models\{City, Provider};
use App\Repository\Contracts\IProviderRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProviderRepository extends BaseRepository implements IProviderRepository
{
    public function __construct(Provider $model)
    {
        parent::__construct($model);
    }

    public function update(Request $request, $currentModel)
    {
        $modelData = $request->except(['branches']);

        if ($request->has('branches')) $currentModel->demand->update(['branches' => json_encode($request->branches)]);

        if ($request->hasFile('logo'))
        {
            storage_unlink('demands', $currentModel->logo);

            $modelData['logo'] = Uploaded::image($request->logo,'demand');

            $currentModel->demand->update(['logo' => $modelData['logo']]);
        }

        return Crud::update($this->class, $modelData, $currentModel);
    }

    public function formFields($type = 'create', $currentModel = null): array
    {
        $data = parent::formFields($type, $currentModel);

        $data['cities'] = City::getInSelectForm();

        $data['branches'] = City::getInSelectForm();

        return $data;
    }

    public function forceDelete($id): RedirectResponse
    {
        $provider = DB::table('providers')->where('id', $id)->first();

        Schema::disableForeignKeyConstraints();

        DB::table('demands')->where('email', $provider->email)->where('phone', $provider->phone)->delete();

        modelForceDelete($this->class, $id);

        Schema::enableForeignKeyConstraints();

        return CrudMessage::remove($this->name);
    }
}
