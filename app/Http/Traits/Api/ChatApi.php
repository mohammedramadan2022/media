<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\{ApiResponse, Uploaded};
use App\Http\Resources\User\MessageResource;
use App\Models\Chat;
use App\Models\Token;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait ChatApi
{
    public static function apiSetChatMessage($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $chat = Chat::find($request->chat_id);

            $message = $chat->messages()->create(self::setChatMessageData($request, $chat));

            $chat->update(self::updateChatLastMessage($message));

            DB::commit();

            return ApiResponse::response(MessageResource::make($message));
        }
        catch(Exception $e)
        {
            DB::rollBack();
            return ApiResponse::exceptionFails($e);
        }
    }

    public static function apiUploadChatFile($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $chat = Chat::find($request->chat_id);

            $type = setFileType($request->file->getMimeType());

            $file = self::getUploadedFileName($request, $type);

            $chat->update(['last_message' => $file, 'type' => $type, 'last_message_date' => now()]);

            DB::commit();

            return ApiResponse::response(['file_name' => $file]);
        }
        catch (Exception $e)
        {
            DB::rollBack();
            return ApiResponse::exceptionFails($e);
        }
    }

    public static function apiGetChatContentByChatId($request): JsonResponse
    {
        $chat = Chat::find($request->chat_id);

        DB::table('messages')->where('chat_id', $chat->id)->update(['is_seen' => 1]);

        return ApiResponse::pagination($chat->messages()->paginate(),MessageResource::class);
    }

    public static function apiChatOpen($request): JsonResponse
    {
        return self::setChatData($request,1);
    }

    public static function apiChatClose($request): JsonResponse
    {
        return self::setChatData($request,0);
    }

    // Private functions

    private static function setChatMessageData($request, $chat): array
    {
        return [
            'message'     => $request->message,
            'type'        => $request->message_type,
            'sender_type' => $request->sender_type,
            'duration'    => $request->duration,
            'sender_id'   => $request->sender_type == 'user' ? $chat->user_id : $chat->doctor_id,
        ];
    }

    private static function updateChatLastMessage($message): array
    {
        return [
            'last_message'      => $message->message,
            'type'              => $message->type,
            'last_message_date' => $message->created_at
        ];
    }

    private static function getUploadedFileName($request, $type): ?string
    {
        return match ($type) {
            'image' => Uploaded::image($request->file, 'chat'),
            'pdf'   => Uploaded::file($request->file, 'pdf', 'chats'),
            'audio' => Uploaded::file($request->file, 'audio', 'chats'),
            default => null,
        };
    }

    private static function setChatData($request, $status): JsonResponse
    {
        $tokenable = Token::whereJwt($request->api_token)->first();

        if(!$tokenable) return ApiResponse::response(['chat_id' => 0]);

        $type = getModelFromClass($tokenable->tokenable_type);

        DB::table('chats')->where('id', $request->chat_id)->update([$type.'_status' => $status]);

        if($status == 1) return ApiResponse::response(['chat_id' => (int)$request->chat_id]);

        return ApiResponse::success();
    }
}
