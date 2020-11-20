<?php

namespace Boss\Models;

use GuzzleHttp\Psr7\Request;
use Boss\Boss;

class BossPackage
{

    // 列表筛选项接口
    public static function getListFilters()
    {
        $url = "/situo/get/package/list/filters";

        $format_data = Boss::format($url);

        $request = new Request('GET', $format_data['url'], $format_data['headers'], $format_data['body']);

        if (isset($options['res_type']) && $options['res_type'] == 'request') {
            return  $request;
        }

        $response = Boss::requestJsonSync($request);

        return $response;
    }

    // 列表数据接口
    public static function getList($body)
    {

        $url = "/situo/get/package/list";

        $format_data = Boss::format($url, $body);


        $request = new Request('POST', $format_data['url'], $format_data['headers'], $format_data['body']);

        if (isset($options['res_type']) && $options['res_type'] == 'request') {
            return  $request;
        }

        $response = Boss::requestJsonSync($request);

        return $response;
    }


    // 详情接口
    public static function getInfo($package_version_id)
    {
        $url = "/situo/get/package/info/{$package_version_id}";

        $format_data = Boss::format($url);

        $request = new Request('GET', $format_data['url'], $format_data['headers'], $format_data['body']);

        if (isset($options['res_type']) && $options['res_type'] == 'request') {
            return  $request;
        }

        $response = Boss::requestJsonSync($request);

        return $response;
    }

    // 审核通过接口
    public static function pass($body)
    {
        $url = "/situo/package/audit/pass";

        $format_data = Boss::format($url, $body);


        $request = new Request('POST', $format_data['url'], $format_data['headers'], $format_data['body']);

        if (isset($options['res_type']) && $options['res_type'] == 'request') {
            return  $request;
        }

        $response = Boss::requestJsonSync($request);

        return $response;
    }

    // 审核拒绝接口
    public static function nopass($body)
    {
        $url = "/situo/package/audit/deny";

        $format_data = Boss::format($url, $body);


        $request = new Request('POST', $format_data['url'], $format_data['headers'], $format_data['body']);

        if (isset($options['res_type']) && $options['res_type'] == 'request') {
            return  $request;
        }

        $response = Boss::requestJsonSync($request);

        return $response;
    }

    // 审核拒绝接口
    public static function install($body)
    {
        $url = "/situo/package/install";

        $format_data = Boss::format($url, $body);


        $request = new Request('POST', $format_data['url'], $format_data['headers'], $format_data['body']);

        if (isset($options['res_type']) && $options['res_type'] == 'request') {
            return  $request;
        }

        $response = Boss::requestJsonSync($request);

        return $response;
    }

    // 表格包下线接口
    public static function offline($body)
    {
        $url = "/situo/package/offline";

        $format_data = Boss::format($url, $body);


        $request = new Request('POST', $format_data['url'], $format_data['headers'], $format_data['body']);

        if (isset($options['res_type']) && $options['res_type'] == 'request') {
            return  $request;
        }

        $response = Boss::requestJsonSync($request);

        return $response;
    }
}
