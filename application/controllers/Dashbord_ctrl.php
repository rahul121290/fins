<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashbord_ctrl extends CI_Controller {
    
    function __construct(){
        parent :: __construct();
        $this->load->library(array('ion_auth'));
    }
  
    function index(){
        
    }
}
