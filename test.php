<?php
require_once __DIR__ . "/vendor/autoload.php";
// 根目录执行
use Boss\Boss;
use Boss\Models\BossAuthorization;
use Boss\Models\BossPackage;

defined('TEST') or define('TEST', true);

$application_id = '';
$application_secret = '';

Boss::init([
    "application_id" => $application_id,
    "application_secret" => $application_secret
]);
$body = [];
// // 列表数据接口
// 接口地址：/v2/situo/get/package/list
// 请求方式：POST
// 参数：
// audit_status            审核状态     非必传     默认 pending
// status                  上下线状态   非必传   
// platform                平台        非必传
// industry_category_id    行业分类ID   非必传
// function_category_id    功能分类ID   非必传
// search                  搜索         非必传
// offset                  分页起始位置  非必传     默认 0
// limit                   页面展示条数  非必传     默认 50
// $list = BossPackage::getList($body);

// // 详情接口
// $info = BossPackage::getInfo(1000012);

// $body = [
//     'package_version_id' => '1000010',   // 当前版本ID   必传
//     'upload_user_id' => '11001',   // 审核人员ID   必传
//     'package_status' => 'online',   //  上下线状态   必传
//     'package_name' => 'gogogotest', //表格包名称 必传
//     'industry_type' => '0', // 行业分类ID 必传
//     'industry_category_order' => '', //行业分类排序 非必传 默认 0
//     'function_type' => '0', // 功能分类ID 必传
//     'function_category_order' => '', //功能分类排序 非必传 默认 0
//     'platform_web' => '1', //所属平台web非必传 web 和 app 必须有一个 可以多选
//     'platform_app' => '', //所属平台app非必传 
//     'recommend_type' => '', //推荐类型必传
//     'old_screenshots_web' => 'https://dev-hb-public-img.huoban.com/market_package_screenshot/1002725/0', //原web截图列表非必传数组形式
//     'old_screenshots_ios' => 'https://dev-hb-public-img.huoban.com/market_package_screenshot/188284250/0', //原ios截图列表非必传数组形式
//     'old_screenshots_android' => 'https://dev-hb-public-img.huoban.com/market_package_screenshot/188284251/0', //原android截图非必传数组形式
//     'screenshots_web' => '', //新增web截图列表非必传fromfile数组形式
//     'screenshots_ios' => '', //新增ios截图列表非必传fromfile数组形式
//     'screenshots_android' => '',  //  新增android截图列表  非必传 from file 数组形式
// ];

// $pass = BossPackage::pass($body);

// 审核拒绝接口
// $body = [
//     "package_version_id" => "1000013",
//     "audit_failed_reason" => "ddabaaaaa"
// ];

// $nopass = BossPackage::nopass($body);

// // 表格包安装接口
// $body = [
//     "package_version_id" => "1000010",
//     "upload_user_id" => "11001",
//     "space_id" => "4000000001000557"
// ];

// $install = BossPackage::install($body);

// 表格包下线接口
$body = [
    "package_ids" => ["1000003", "1000004"]
];

$offline = BossPackage::offline($body);
var_dump($offline);
