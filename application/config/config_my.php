<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* ���ݽӿ����� */
$config['db_api_base'] = 'http://tapi.pingoing.cn/';
$config['db_api_type'] = 'restful.';
$config['db_table_prefix'] = 'PYX3_';
$config['db_api_action'] = array('select'=>'Query','create'=>'Create','update'=>'Update','save'=>'Save','delete'=>'Delete');
$config['db_max_query_time'] = 5; 
$config['db_log_query_time'] = 1; 

/* ΢������ */
// $config['wx_appid'] = 'wx032ee768936f17d3';
// $config['wx_secret'] = 'df15a117460067781749ae7d38cb90e0';
// $config['wx_token'] = 'D25qFgENJxdzdpPrx2MA';
// $config['wx_jsapi_path'] = 'application/data/jsapi.txt';
// $config['wx_token_path'] = 'application/data/token.txt';


/* ΢�����ò��� */
$config['wx_appid'] = 'wx0daad8d2c3f9a9f9';
$config['wx_secret'] = 'd82287ebbc1e33f9daaa5a4a80edd364';
$config['wx_token'] = 'raincai';
$config['wx_jsapi_path'] = 'application/data/jsapi.txt';
$config['wx_token_path'] = 'application/data/token.txt';

/* ҳ������ */
$config['pg_version_open'] = TRUE;
//$config['pg_version'] = '201607290001';
$config['pg_version'] = time();

/* �������� */
//$config['order_choucheng'] = 0.5; //������ɽ��

/* �������� */
$config['order_choucheng_type'] = 1; //������ɷ�ʽ 1���ٷֱ� 2��ʵ�ʽ��
$config['order_choucheng_admin'] = 1; //�ܲ�������ɽ��
$config['order_choucheng_hehuo'] = 1; //�ϻ��˶�����ɽ��
