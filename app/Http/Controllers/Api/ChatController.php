<?php

namespace App\Http\Controllers\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\GetChatRequest;
use App\Http\Requests\Api\SetChatMessageRequest;
use App\Http\Resources\ChatListResource;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends PARENT_API
{
    public function getChatsList(Request $request)
    {
        $chats = $request->user()->chats->sortByDesc('last_message_date');

        return ApiResponse::pagination($request, $chats, ChatListResource::class);
    }

    public function getUserChatContent(GetChatRequest $request)
    {
        return Chat::apiGetChatContentByChatId($request);
    }

    public function chatOpen(Request $request)
    {
        return Chat::apiChatOpen($request);
    }

    public function chatClose(Request $request)
    {
        return Chat::apiChatClose($request);
    }

    public function setChatMessage(SetChatMessageRequest $request)
    {
        return Chat::apiSetChatMessage($request);
    }
}
