<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Tools\CrudMessage;
use App\Models\{Demand, Provider};
use App\Repository\Contracts\IDemandRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DemandRepository extends BaseRepository implements IDemandRepository
{
    public function __construct(Demand $model)
    {
        parent::__construct($model);
    }

    public function index(): View
    {
        $query = $this->model::query();

        $data = [(string) $this->folder->camel() => $query->where('is_accepted','!=',1)->orWhereNull('is_accepted')->latest()->paginate(10)];

        return view('Back.'.$this->folder.'.index', $data);
    }

    public static function accept(Demand $demand): RedirectResponse
    {
        DB::beginTransaction();
        try
        {
            $demand->update(['is_accepted' => 1]);

            $password = Provider::getCreatedProviderPassword($demand);

            Provider::sendAcceptEmail($demand, $password);

            DB::commit();

            return CrudMessage::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::error($e);
        }
    }

    public static function reject(Demand $demand): RedirectResponse
    {
        DB::beginTransaction();
        try
        {
            Provider::sendRejectMail($demand);

            $demand->delete();

            DB::commit();

            return CrudMessage::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return CrudMessage::error($e);
        }
    }

    public function forceDelete($id): RedirectResponse
    {
        DB::table('providers')->where('demand_id', $id)->update(['demand_id' => null]);

        DB::table('demands')->where('id', $id)->delete();

        return CrudMessage::remove($this->name);
    }
}
