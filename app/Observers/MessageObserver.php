<?php

namespace App\Observers;

use App\Facade\Support\Core\Firebase;
use App\Models\Message;

class MessageObserver
{
    public function created(Message $message): void
    {
        $chat = $message->chat;

        $fcms = request('sender_type') == 'user'
            ? $chat->trainer->fcm->pluck('fcm')->toArray()
            : $chat->user->fcm->pluck('fcm')->toArray();

        if ($chat->user_status == 0 || $chat->trainer_status == 0) {
            if (count($fcms) > 0) {
                Firebase::pushNotification(self::setNotificationData($message, $chat, $fcms));
            }
        }
    }

    private static function setNotificationData($message, $chat, $fcms): array
    {
        $sender_name = request('sender_type') == 'user' ? $chat->user->name : $chat->trainer->name;

        return [
            'title'      => $sender_name,
            'body'       => self::getBodyContent($message),
            'type'       => 'chat',
            'fcm_tokens' => $fcms,
            'type_id'    => $chat->id,
        ];
    }

    private static function getBodyContent($message): string
    {
        return match ($message->type) {
            'image' => trans('back.image-file'),
            'pdf'   => trans('back.pdf-file'),
            'audio' => trans('back.audio-file'),
            default => $message->message,
        };
    }
}
