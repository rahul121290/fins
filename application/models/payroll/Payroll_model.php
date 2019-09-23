<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll_model extends CI_Model {
    
    function emp_attendance($data,$final){
        $this->db->trans_begin();
        $this->db->select('pam_id');
        $this->db->where($data);
        $check = $this->db->get_where('payroll_attendance_master',array('status'=>1))->result_array();
        if(count($check) > 0){
            //-----------update status ----------------
            $this->db->where($data);
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->update('payroll_attendance_master',array('status'=>0));
            
            $this->db->insert('payroll_attendance_master',$data);
            $pam_id = $this->db->insert_id();
            
            $atten = [];
            foreach($final as $key=> $fnl){
                $atten[] = $fnl;
                $atten[$key]['pam_id'] = $pam_id;
            }
            $this->db->insert_batch('payroll_attendance',$atten);
            
        }else{
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('payroll_attendance_master',$data);
            $pam_id = $this->db->insert_id();
            
            $atten = [];
            foreach($final as $key=> $fnl){
                $atten[] = $fnl;
                $atten[$key]['pam_id'] = $pam_id;
            }
            $this->db->insert_batch('payroll_attendance',$atten);
        }
        
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
    
    
    
    function master_entry($id,$data){
        $this->db->trans_begin();
        if(!empty($id)){
               //--------update-----------------
               $this->db->where('pm_id',$id);
               $this->db->update('payroll_master',$data);
        }else{
            //--------------insert--------------
            $this->db->insert('payroll_master',$data);
        }
        
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
    
    function submit_new_employee($id,$data){
        $this->db->trans_begin();
        
        if(isset($id)){
            $this->db->where('emp_id',$id);
            $this->db->update('payroll_employee_details',$data);
        }else{
            $this->db->insert('payroll_employee_details',$data);
        }
        
        
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