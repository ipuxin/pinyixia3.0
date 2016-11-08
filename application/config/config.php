<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* ��վ���� */
//$config['base_url'] = 'http://new.pingoing.cn/';
//$config['res_url'] = 'http://adm.pingoing.cn';
//$config['share_url'] = 'http://new.pingoing.cn/';
$config['base_url'] = 'http://twx.pingoing.cn/';
$config['res_url'] = 'http://adm.pingoing.cn';
$config['share_url'] = 'http://twx.pingoing.cn/';

$config['file_path'] = dirname(dirname(dirname(__FILE__)));
$config['data_log_path'] = $config['file_path'].'/data/logs/';
$config['static_file_path'] = '/data/file/';

/* �������� */
$config['index_page'] = '';
$config['uri_protocol']	= 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language']	= 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';

/* �������� */
$config['composer_autoload'] = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['allow_get_array'] = TRUE;
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

/* log���� */
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';

/* cache���� */
$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
$config['encryption_key'] = 'faa6ddfe2b4aPYX3.015a6fds830dwer14';

/* session���� */
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 3600*24*365;
$config['sess_save_path'] = $config['file_path'].'/data/session';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 3600*24;
$config['sess_regenerate_destroy'] = TRUE;

/* cookie���� */
$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;


$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;

/* csrf���� */
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;

$config['proxy_ips'] = '';
