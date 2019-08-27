<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_fee_model extends CI_Model{
  
    function fee_payment($data,$pay_method){
        $this->db->trans_begin();
        $this->db->insert('student_fee',$data);
        
        //-----------log report---------------
        $event = 'Fee Payment';
        $user = $this->session->userdata('user_id');
        $table_name = 'student_fee';
        $table_id = $this->db->insert_id();
        $this->my_function->add_log($user,$event,$table_name,$table_id);
        
        $this->db->insert_batch('fee_pay_method',$pay_method);
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
    }
}