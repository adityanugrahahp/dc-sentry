<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['logout'] = 'login/logout';
$route['new_visitor/(:any)'] = 'contactless_guest/index/$1';

$route['data_center_form/(:any)'] = 'data_center/form/$1';
$route['data_center_form'] = 'data_center/generate_form_url';
$route['data_center_it']       = 'data_center/index_staff';
$route['data_center_mg']       = 'data_center/index_manager';

$route['data_center/simpan']   = 'data_center/simpan_permohonan';
$route['data_center/detail/(:num)'] = 'data_center/get_detail/$1';

// Data Center Auth Routes
$route['dc-auth'] = 'DCAuth';
$route['dc-auth/login'] = 'DCAuth/login';
$route['dc-auth/logout'] = 'DCAuth/logout';
$route['dc-auth/switch/(:any)'] = 'DCAuth/switch_page/$1';
$route['preview/file/(:any)/(:any)'] = 'data_center/preview_file/$1/$2';
$route['data_center/download_detail_txt/(:num)'] = 'data_center/download_detail_txt/$1';

// Custom auth constants
define('AUTH_COOKIE_NAME', 'dc_auth_token');
define('AUTH_EXPIRE', 7200); // 2 jam