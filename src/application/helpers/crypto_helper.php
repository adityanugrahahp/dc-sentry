<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * crypto_helper
 * Helper untuk enkripsi dan dekripsi
 * 
 * @package		visitor-management
 * @author		Dimas Wicaksono
 * @since		2020-05
 */

/**
 * Encrypt (enkripsi statis)
 * 
 * @param   string $string Plain text
 * @return  string
 */
if ( ! function_exists('encrypt')){
    function encrypt($string, $custom_iv = null) {
        // you may change these values to your own
        $secret_key     = PK_SECRET;
        $secret_iv      = $custom_iv;
    
        $output         = false;
        $encrypt_method = "AES-256-CBC";

        $key    = hash('sha256', $secret_key);
        $iv     = substr(hash('sha256', $secret_iv), 0, 16);

        $str    = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        $output = str_replace(array('+', '/', '='), array('-', '_', '~'), $str);
        
        return $output;
    }
}

/**
 * Decrypt (dekripsi statis)
 * 
 * @param   string $string Encoded text
 * @return  string
 */
if ( ! function_exists('decrypt')){
    function decrypt($string, $custom_iv = null) {
        // you may change these values to your own
        $secret_key     = PK_SECRET;
        $secret_iv      = $custom_iv;
    
        $output         = false;
        $encrypt_method = "AES-256-CBC";

        $key    = hash('sha256', $secret_key);
        $iv     = substr(hash('sha256', $secret_iv), 0, 16);

        $str    = str_replace(array('-', '_', '~'), array('+', '/', '='), $string);
        $output = openssl_decrypt(base64_decode($str), $encrypt_method, $key, 0, $iv);
        
        return $output;
    }
}