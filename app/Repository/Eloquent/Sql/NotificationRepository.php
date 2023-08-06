<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\{Crud, Firebase};
use App\Facade\Support\Tools\CrudMessage;
use App\Models\{Admin, User, Notification};
use App\Repository\Contracts\INotificationRepository;
use Exception;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class NotificationRepository extends BaseRepository implements INotificationRepository
{
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function index(): View
    {
        $collection = $this->model->latest()->paginate(10);

        $data = [(string) $this->folder->camel() => $collection];

        DB::table('notifications')->where('notificationable_type', Admin::class)->update(['is_seen' => 1]);

        return view('Back.'.(string) $this->folder.'.index', $data);
    }

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $collection = User::query()
                ->whereHas('fcm', fn ($query) => $query->where('fcm', '!=', null))
                ->get()
                ->map(function ($model) use ($request) {
                    Firebase::saveOnly($request->ar['title'], $request->ar['body'], $model);

                    return $model;
                });

            $tokens = $collection->map->fcm->pluck('fcm')->toArray();

            Firebase::sendToGroup($request['ar']['title'], $request['ar']['body'], $tokens);

            //            Notification::sendGroupNotification($request->en['title'], $request->en['body'], $tokens);

            DB::commit();

            return CrudMessage::add('notification');
        } catch (Exception $e) {
            DB::rollBack();

            return CrudMessage::fails($e);
        }
    }

    public function create(): View
    {
        return view('Back.Crud.create', self::formFields());
    }

    public function getListByType($request): JsonResponse
    {
        //        $class = ($request->selected == 'user') ? User::class : Doctor::class;

        $data = Crud::getModelWithTokens(User::class);

        return response()->json(['data' => $data, 'type' => $request->selected, 'status' => true, 'message' => 'success'], 200);
    }

    public function formFields($type = 'create', $currentModel = null): array
    {
        $data = parent::formFields($type, $currentModel);

        $data['types'] = $this->class::types();

        return $data;
    }
}
