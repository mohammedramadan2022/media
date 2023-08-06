<?php

namespace App\Http\Traits;

use App\Facade\Support\Core\ApiResponse;
use App\Facade\Support\Tools\CrudMessage;
use App\Http\Scopes\ContactScopes;
use App\Mail\SendAdminMail;
use App\Models\Contact;
use Exception;
use Illuminate\Http\{JsonResponse, Request, RedirectResponse};
use Illuminate\Support\Facades\Mail;

trait ContactTrait
{
    use BasicTrait, ContactScopes;

    public static function createMessage($request): RedirectResponse
    {
        Contact::create($request->validated());

        return CrudMessage::success(trans('back.contact-us-response-message'));
    }

    public static function apiCreateContactMessage($request): JsonResponse
    {
        Contact::create($request->validated());

        return ApiResponse::success();
    }

    public static function sendUserReplayMessage(Request $request): RedirectResponse
    {
        return self::sendEmail($request);
    }

    public static function sendEmail($request): RedirectResponse
    {
        try {
            if (is_null($request->title)) {
                return CrudMessage::warningWithInput(trans('api.title-field-is-required'), $request->all());
            }

            if (is_null($request->message)) {
                return CrudMessage::warningWithInput(trans('api.message-field-is-required'), $request->all());
            }

            Mail::to($request->email)->send(new SendAdminMail($request->message, $request->title));

            return CrudMessage::success();
        } catch (Exception $e) {
            return CrudMessage::error($e);
        }
    }
}
