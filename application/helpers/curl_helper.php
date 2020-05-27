<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * app_helper
 * Helper untuk aplikasi
 * 
 * @package		wisata-frontend
 * @author		Dimas Wicaksono
 * @since		2019-06-12
 */

if ( ! function_exists('curl_req')){
    function curl_req($type = 'get', $endpoint, $query_string = [], $http_header = [], $user_agent = null){
        $CI =& get_instance();

        $output = null;
        $ch     = curl_init(); 

        // ini untuk menggabungkan antara url endpoint dengan query string yang ada
        $url = $endpoint;

        if(! empty($query_string)){
            if($type == 'get'){
                $first = true;
                foreach($query_string as $i => $v){ 
                    if($first){ $first = false; $url .= '?'; }else{ $url .= '&'; }
                    $url .= $i.'='.$v; 
                }
            }else{
                $d_post = [];
                foreach ($query_string as $i => $v) {
                    $d_post[] = $i.'='.$v;
                }
                curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $d_post));
            }
        }

        curl_setopt($ch, CURLOPT_URL, $url); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);

        if($type == 'post'){ curl_setopt($ch, CURLOPT_POST, 1); }

        if(! empty($http_header)){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header); 
        }

        
        $output      = curl_exec($ch); 
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch); 
        
        return ['code' => $http_status, 'content' => json_decode($output, true)];
    }
}

if ( ! function_exists('curl_output')){
    function curl_output($content = [], $type = 'application/json'){
        $CI =& get_instance();

        $CI->output->set_content_type($type)->set_output(json_encode($content));
    }
}