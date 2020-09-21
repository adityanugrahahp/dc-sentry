<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists('app_menu_list')){
    function app_menu_list(){
        return [
            1 => 'Visitor Management|'.base_url().'|fa-users',
            2 => 'Absensi QR|'.base_url('absenqr').'|fa-qrcode'
        ];
    }
}

if(! function_exists('app_generate_menu')){
    function app_generate_menu($allowed_menu = []){
        
        $result = [];

        $available_menu = app_menu_list();

        foreach($allowed_menu as $v){
            if(array_key_exists($v, $available_menu)){
                $result[$v] = $available_menu[$v];
            }
        }

        return $result;
    }
}
if(! function_exists('app_check_access')){
    function app_check_access($menu_id = null){

        $is_allowed = false;

        $existed_menu = explode(', ', $_SESSION['access']);
        
        // cek apakah menu ID ini ada dalam session (access) user?
        if(in_array($menu_id, $existed_menu)){
            $is_allowed = true;
        }
    
        return $is_allowed;
    }
}