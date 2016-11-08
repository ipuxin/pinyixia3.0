<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 数据接口配置 */
$config['db_api_base'] = 'http://tapi.pingoing.cn/';
$config['db_api_type'] = 'restful.';
$config['db_table_prefix'] = 'PYX3_';
$config['db_api_action'] = array('select'=>'Query','create'=>'Create','update'=>'Update','save'=>'Save','delete'=>'Delete');
$config['db_max_query_time'] = 5; 
$config['db_log_query_time'] = 1; 

/* 微信配置 */
// $config['wx_appid'] = 'wx032ee768936f17d3';
// $config['wx_secret'] = 'df15a117460067781749ae7d38cb90e0';
// $config['wx_token'] = 'D25qFgENJxdzdpPrx2MA';
// $config['wx_jsapi_path'] = 'application/data/jsapi.txt';
// $config['wx_token_path'] = 'application/data/token.txt';


/* 微信配置测试 */
$config['wx_appid'] = 'wx0daad8d2c3f9a9f9';
$config['wx_secret'] = 'd82287ebbc1e33f9daaa5a4a80edd364';
$config['wx_token'] = 'raincai';
$config['wx_jsapi_path'] = 'application/data/jsapi.txt';
$config['wx_token_path'] = 'application/data/token.txt';

/* 页面配置 */
$config['pg_version_open'] = TRUE;
//$config['pg_version'] = '201607290001';
$config['pg_version'] = time();

/* 店铺配置 */
//$config['order_choucheng'] = 0.5; //订单抽成金额

/* 店铺配置 */
$config['order_choucheng_type'] = 1; //订单抽成方式 1，百分比 2，实际金额
$config['order_choucheng_admin'] = 1; //总部订单抽成金额
$config['order_choucheng_hehuo'] = 1; //合伙人订单抽成金额
