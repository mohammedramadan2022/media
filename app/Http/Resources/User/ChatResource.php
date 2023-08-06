<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'chat_id'  => $this->id,
            'user'     => self::getUser($this->user),
            'provider' => self::getUser($this->provider),
            'messages' => MessageResource::collection($this->messages->sortByDesc('created_at')),
        ];
    }

    private static function getUser($user)
    {
        return [
            'id'    => $user->id,
            'name'  => $user->name,
            'image' => $user->image_url
        ];
    }
}
