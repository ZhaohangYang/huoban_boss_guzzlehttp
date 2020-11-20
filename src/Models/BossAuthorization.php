<?php

namespace Boss\Models;

use GuzzleHttp\Psr7\Request;
use Boss\Boss;

class BossAuthorization
{
    public static function get($application_id, $application_secret)
    {
        $body = [
            "application_id" => $application_id,
            "application_secret" => $application_secret
        ];

        $url = "/space/app/ticket";
        $format_data = Boss::format($url, $body, $options = [
            'headers' => [
                'cookie' =>  'hb_dev_host=dev03'
            ],
        ]);

        $request = new Request('POST', $format_data['url'], $format_data['headers'], $format_data['body']);

        if (isset($options['res_type']) && $options['res_type'] == 'request') {
            return  $request;
        }
        $response = Boss::requestJsonSync($request);
        // var_dump($response);
        // exit;
        return $response['ticket'];
    }
}
