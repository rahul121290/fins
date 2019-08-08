<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_fee_model extends CI_Model{
  
    function fee_payment($data,$pay_method){
        
        $this->db->trans_begin();
        $this->db->insert('student_fee',$data);
        $sf_id = $this->db->insert_id();
        
        $final = [];
        foreach($pay_method as $key => $method){
            $final[] = $method;
            $final[$key]['sf_id'] = $sf_id;
        }
        
        $this->db->insert_batch('fee_pay_method',$final);
        
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }
}