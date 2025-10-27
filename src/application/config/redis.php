<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['socket_type']  = 'tcp'; //`tcp` or `unix`
$config['socket']       = ''; // in case of `unix` socket type
$config['host']         = '172.16.102.51';
$config['password']     = 'redisp3ln1';
$config['port']         = 6379;
$config['timeout']      = 0;