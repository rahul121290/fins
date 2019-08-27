<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prospectus_model extends CI_Model {
    
    function sellingProspectus($p_id,$data){
        
        $this->db->trans_begin();
        
        if(!empty($p_id)){
            //---------update-----------
            $this->db->where('p_id',$p_id);
            $this->db->update('prospectus',$data);
            
            //-----------log report---------------
            $event = 'Update Prospectus Record';
            $user = $this->session->userdata('user_id');
            $table_name = 'prospectus';
            $table_id = $p_id;
            $this->my_function->add_log($user,$event,$table_name,$table_id);
            
        }else{
            //---------insert----------
            $this->db->insert('prospectus',$data);
            
            //-----------log report---------------
            $event = 'Add Prospectus Record';
            $user = $this->session->userdata('user_id');
            $table_name = 'prospectus';
            $table_id = $this->db->insert_id();
            $this->my_function->add_log($user,$event,$table_name,$table_id);
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