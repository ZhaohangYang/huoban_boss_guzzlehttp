<?php

namespace Boss;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Exception\ServerException;

use Boss\Models\BossAuthorization;

class Boss
{
   public static $client;

   public static $appType;
   public static $applicationId;
   public static $applicationSecret;

   public static $initParams;
   public static $tmpParams;

   public static $ticket;
   public static $expired = 1209600;

   /**
    * 初始化
    *
    * @param [type] $params
    * @return void
    */
   public static function init($params)
   {
      self::$initParams = $params;

      self::$applicationId = $params['application_id'] ?? null;
      self::$applicationSecret = $params['application_secret'] ?? null;

      self::setClient();
      //如果ticket存在并且不为空 直接启用传入的ticket;
      $authorization = (isset($params['authorization']) && !empty($params['authorization'])) ?  $params['authorization'] : BossAuthorization::get(self::$applicationId, self::$applicationSecret);
      self::setAuthorization($authorization);
   }
   private static function setClient()
   {
      self::$client =  new Client([
         'base_uri' =>  constant("TEST") ? 'http://api.dev.huoban.com' : 'https://api.huoban.com',
         'timeout'  => 5.0,
      ]);
   }
   private static function setAuthorization($authorization)
   {
      // self::$client->config['headers']['Authorization'] = 'Bearer ' . $authorization;
      self::$client->config['headers']['Cookie'] = 'HUOBAN_SESSIONID=a8e8fa000d0296151251493d843d4cfe; HUOBAN_SYNC=674b87WDy5DU0QGhmXZJfJ2wll0%2BuanFFLG60TTQAwX0m%2FyHLw3fdQXuHsWSNIop%2Fr%2BHZ5sfnpKQyg; access_token=jH4FOXaTapMWq5f0HBIMbDxA1aQGb5tuNxYMiRSk001; xsrf=f7cdcb5f8eae83e8a5ddbb1769f3195d; hb_dev_host=dev03; HUOBAN_AUTH=5984ab6f570d0cca04a6afc0d84cd2c1; HUOBAN_DATA=JIFs5kxDZ%2F6UY0XDtSmESvmqlb8nMJ%2FnmEb4dMeHOLcJlK2o35N9sQUrE0lpvhoZxzosSmL0dJjUmEzluOIg6Q%3D%3D; HUOBAN_SESSIONID_DEVELOPMENT=8cb4ca3893dfabc60647b4c883cc284d; HUOBAN_AUTH_DEVELOPMENT=815191e29289205fbb280acf0cb5591b; HUOBAN_DATA_DEVELOPMENT=gC56p7W8ExNtLQSSslg8HD%2BfrtlPDlH%2F5bSiKvrwez3l3YcBP6DHS6IXrzrn3swc97lsMTJ6tShFV7sBY5PycQ%3D%3D';
      // self::$client->config['headers']['X-Huoban-Return-Alias-Space-Id'] = $space_id;
      self::$client->config['headers']['X-Huoban-Ticket'] = $authorization;
   }
   public static function format($url, $body = [], $options = [])
   {
      $url = self::formatUrl($url, $options);
      $headers = self::formatHeader($options);
      $body = self::formatBody($body, $headers);

      return ['url' => $url, 'headers' => $headers, 'body' => $body];
   }
   public static function formatUrl($url, $options)
   {
      $version = isset($options['version']) ? '/' . $options['version'] : (isset($options['passVersion']) ? '' : '/v2');
      return "$version$url";
   }
   public static function formatHeader($options)
   {
      $headers = $options['headers'] ?? [];
      $headers['content-type'] = $headers['content-type'] ?? 'application/json';

      return $headers;
   }
   public static function formatBody($body, $headers)
   {
      switch ($headers['content-type']) {
         case 'application/json':
            $body = json_encode($body);
            break;
         default:
            break;
      }
      return $body;
   }
   public static function requestJsonSync($request)
   {
      try {
         $response = self::$client->send($request);
      } catch (ServerException $e) {
         $response = $e->getResponse();
      }
      return  json_decode($response->getBody(), true);
   }
   public static function requestAsync($request)
   {
      try {
         $response = self::$client->send($request);
      } catch (ServerException $e) {
         $response = $e->getResponse();
      }
      return  json_decode($response->getBody(), true);
   }
   public static function requestJsonPool($requests, $concurrency = 5)
   {

      $success_data = [];
      $error_data = [];

      $pool = new Pool(self::$client, $requests, [
         'concurrency' => $concurrency,
         'fulfilled' => function ($response, $index) use (&$success_data) {
            $success_data[] = [
               'index' => $index,
               'response' => json_decode($response->getBody(), true),
            ];
         },
         'rejected' => function ($response, $index) use (&$error_data) {
            $error_data[] = [
               'index' => $index,
               'response' => $response,
            ];
         },
      ]);
      $promise = $pool->promise();
      $promise->wait();

      return ['success_data' => $success_data, 'error_data' => $error_data];
   }
   /**
    * 临时切换权限
    *
    * @param [type] $tmp_params
    * @return void
    */
   public static function switchTmpAuth($tmp_params)
   {
      self::init($tmp_params);
   }
   /**
    * 临时原有权限
    *
    * @param [type] $tmp_params
    * @return void
    */
   public static function switchFormerAuth()
   {
      self::init(self::$initParams);
   }
}
