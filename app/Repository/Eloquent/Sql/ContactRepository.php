<?php

namespace App\Repository\Eloquent\Sql;

use App\Facade\Support\Core\Crud;
use App\Facade\Support\Tools\CrudMessage;
use App\Models\Contact;
use App\Repository\Contracts\IContactRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactRepository extends BaseRepository implements IContactRepository
{
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }

    public function contacts(): View
    {
        return view('Back.Contacts.index', ['contacts' => $this->class::with(['subject.translation'])->paginate(), 'search' => false]);
    }

    public function showMessageDetails($id): JsonResponse|string
    {
        if (! $message = $this->find($id)) return CrudMessage::fails(trans('responseMessages.product-not-exist'));

        $message->update(['is_seen' => 1]);

        return view('Back.Contacts.messageDetailsModal', compact('message'))->render();
    }

    public function sendUserMessage($id)
    {
        if (! $message = $this->find($id)) return CrudMessage::fails(trans('back.message-not-exists'));

        return view('Back.Contacts.sendUserMessageModal', compact('message'));
    }

    public function sendUserReplayMessage(Request $request): RedirectResponse
    {
        return Contact::sendUserReplayMessage($request);
    }

    public function deleteMessage(Request $request)
    {
        return Crud::delete($this->class, $request->id);
    }
}
