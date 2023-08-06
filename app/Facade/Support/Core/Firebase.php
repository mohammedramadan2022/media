<?php

namespace App\Facade\Support\Core;

use App\Facade\Traits\FirebaseNotifications;
use App\Models\{Admin, Notification};
use Edujugon\PushNotification\PushNotification;
use Illuminate\Support\Facades\Log;

class Firebase
{
    use FirebaseNotifications;

    public static function pushNotification($data): object
    {
        $response = self::create_http_notification($data['fcm_token'], $data);

        if (!$response) return (object)['status' => false, 'message' => 'some error happen'];

        if ($response->failure != 0) return self::exception($response);

        return (object)['status' => true, 'message' => 'success'];
    }

    public static function combine($title, $body, $model, $type = 'dash', $id = 0): object
    {
        if ($model->web_fcm_token)
        {
            $res = self::web($model->web_fcm_token, $title, $body);

            if (!$res->status) return self::exception($res);
        }

        if ($model->fcm_token)
        {
            $response = self::sendOnly($title, $body, $model, $type, $id);

            if (!$response->status) return self::exception($response);
        }

        self::saveOnly($title, $body, $model, $type, $id);

        return (object)['status' => true, 'message' => 'success'];
    }

    public static function pushWebNotification($data): object
    {
        $data['icon'] = get_settings_image('site_logo');

        $response = self::create_web_http($data['fcm_tokens'], $data);

        if ($response->failure != 0) return self::exception($response);

        return (object)['status' => true, 'message' => 'success'];
    }

    public static function web($fcm_tokens, $title, $body): object
    {
        return self::pushWebNotification(['fcm_tokens' => $fcm_tokens, 'title' => $title, 'body' => $body]);
    }

    public static function push($title, $body, $model, $type = 'dash', $id = 0): object
    {
        return self::sendAndSave($title, $body, $model, true, $type, $id);
    }

    public static function sendOnly($title, $body, $model, $type = 'dash', $type_id = 0): object
    {
        return self::sendAndSave($title, $body, $model, false, $type, $type_id);
    }

    public static function saveOnly($title, $body, $model, $type = 'dash', $type_id = 0): void
    {
        $model->notifications()->create(self::setNotificationData($title, $body, $type, $type_id));
    }

    public static function sendToGroup($title, $body, $tokens, $type = 'dash', $type_id = 0): void
    {
        self::send([
            'title'      => $title,
            'body'       => $body,
            'type'       => $type,
            'type_id'    => $type_id,
            'fcm_tokens' => $tokens,
        ]);
    }

    public static function sendAndSaveWebNotification($title, $body, $model, $save = true, $type = 'dash', $id = 0): void
    {
        $data = ['title' => $title, 'body' => $body, 'icon' => $model->image_url];

        $data['fcm_tokens'] = $model->web_token;

        if ($save) $model->notifications()->create(array_merge($data, ['type' => $type, 'type_id' => $id]));

        self::pushWebNotification($data);
    }

    public static function setNotificationData($title, $body, $type = 'dash', $id = 0): array
    {
        return ['title' => $title, 'body' => $body, 'type' => $type, 'type_id' => $id];
    }

    public static function combineLangByTopic($request, $tokens, $topic): void
    {
        self::byTopic($request->title_ar, $request->body_ar, $tokens, $topic, 'ar');

        self::byTopic($request->title_en, $request->body_en, $tokens, $topic, 'en');
    }

    public static function byTopic($title, $body, $tokens, $topic, $lang): void
    {
        self::sendByTopic(self::setTopicData($title, $body, $tokens, $topic . '_' . $lang));
    }

    public static function sendWebGroupNotification($title, $body, $tokens): void
    {
        self::pushWebNotification([
            'title'      => $title,
            'body'       => $body,
            'icon'       => get_settings_image('site_logo'),
            'fcm_tokens' => $tokens,
        ]);
    }

    public static function sendAdminError($title, $message)
    {
        return Notification::create([
            'title'                 => $title,
            'body'                  => $message,
            'notificationable_type' => Admin::class,
            'notificationable_id'   => 1,
        ]);
    }

    private static function sendAndSave($title, $body, $model, $save = true, $type = 'dash', $id = 0): object
    {
        $data = self::setNotificationData($title, $body, $type, $id);

        if ($save) $model->notifications()->create($data);

        return self::pushNotification(array_merge($data, ['fcm_token' => $model?->fcm_token]));
    }

    private static function setTopicData($title, $body, $tokens, $topic): array
    {
        return [
            'title'      => $title,
            'body'       => $body,
            'type'       => 'dash',
            'type_id'    => 0,
            'topic'      => $topic,
            'fcm_tokens' => $tokens,
        ];
    }

    private static function exception($response): object
    {
        $message = $response->results[0]->error ?? 'unknown';

        Log::warning('Firebase Error : ' . $message);

        return (object)['status' => false, 'message' => $message];
    }
}
