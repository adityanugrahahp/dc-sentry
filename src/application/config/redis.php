<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['socket_type']  = 'tcp'; //`tcp` or `unix`
$config['socket']       = ''; // in case of `unix` socket type
$config['host']         = '172.16.252.51';
$config['password']     = NULL;
$config['port']         = 6379;
$config['timeout']      = 0;