<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// APPLICATION SPECIFICS
$route['logout']                = 'login/logout';
$route['new_visitor/(:any)']    = 'contactless_guest/index/$1';