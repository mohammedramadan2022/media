<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'message'      => self::getMessage($this),
            'message_type' => $this->type,
            'sender_type'  => $this->sender_type,
            'duration'     => (int)$this->duration,
            'sender'       => self::getModelObject(self::getObject($this, 'user')),
            'receiver'     => self::getModelObject(self::getObject($this, 'doctor')),
            'created_at'   => $this->since,
        ];
    }

    private static function getObject($message, $condition)
    {
        return $message->sender_type == $condition ? $message->chat->user : $message->chat->doctor;
    }

    private static function getMessage($message)
    {
        if ($message->type == 'text') return $message->message;

        elseif ($message->type == 'image') return $message->image_url;

        else return $message->file_url;
    }

    private static function getModelObject($object)
    {
        return [
            'id'    => $object->id,
            'fname' => $object->fname,
            'lname' => $object->lname,
            'image' => $object->image_url
        ];
    }
}
