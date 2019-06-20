<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

// superclass aplikasi
class MY_Controller extends CI_Controller {
    
    /** Constructor */
    public function __construct(){
        parent::__construct();
        
        // default timezone
        date_default_timezone_set('Asia/Jakarta');
    }
}

// untuk subclass dengan pengecekan login
class Management_Controller extends MY_Controller {

    /** Constructor */
    public function __construct(){
        parent::__construct();
    }
}

// untuk subclass tanpa pengecekan login
class Kiosk_Controller extends MY_Controller {

    /** Cnstructor */
    public function __construct(){
        parent::__construct();
    }
}