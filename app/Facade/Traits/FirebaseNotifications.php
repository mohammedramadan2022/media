<?php

namespace App\Facade\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

trait FirebaseNotifications
{
    public static function create_http_notification($to, $data)
    {
        $request_body = self::setRequestBody($to, self::getData($data));

        return Http::withToken(config('fcm.notification_key'))->post(self::url(), $request_body)->object();
    }

    public static function create_web_http($to, $data)
    {
        $body = ['to' => $to, 'notification' => self::getWebData($data)];

        return Http::withToken(config('fcm.notification_key'))->post(self::url(), $body)->object();
    }

    public static function create_topic_http($topic, $data)
    {
        $url = '';

        $body = ['to' => "/$topic/", 'notification' => self::getData($data)];

        return Http::withToken(config('fcm.notification_key'))->post($url, $body)->object();
    }

    public static function create_group_http($data): object
    {
        $headers = ['project_id' => config('fcm.project_id'), 'Authorization' => 'Bearer ' . config('fcm.notification_key')];

        $request_body = ['registration_ids' => Arr::wrap($data['fcm_tokens']), 'notification' => self::getWebData($data)];

        return Http::withHeaders($headers)->post(self::url(), $request_body)->object();
    }

    private static function getData($data): array
    {
        return [
            'title'                 => $data['title'],
            'body'                  => $data['body'],
            'notificationable_type' => $data['type'],
            'notificationable_id'   => $data['type_id'],
            'sound'                 => 'default',
            //            'click_action'          => 'FCM_PLUGIN_ACTIVITY',
        ];
    }

    private static function getWebData($data): array
    {
        return ['title' => $data['title'], 'body' => $data['body'], 'icon' => $data['icon']];
    }

    private static function setPushNotificationData($data): array
    {
        return ['data' => $data, 'notification' => $data, 'priority' => 'high'];
    }

    private static function setRequestBody($to, $data): array
    {
        return ['to' => $to, 'data' => $data, 'notification' => $data];
    }

    private static function url(): string
    {
        return 'https://fcm.googleapis.com/fcm/send';
    }
}
