<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fee_structure_model extends CI_Model {
    
    function submit_fee($master,$final){
        
        $this->db->trans_begin();
        $this->db->select('fs_id');
        $check_master = $this->db->get_where('fee_structure_master',$master)->result_array();
        if(count($check_master) > 0){
            //---------update master -----------------------------
            $this->db->where($master);
            $this->db->update('fee_structure_master',array('status'=>0));
            
            //----------new insert--------------------------------
            $master['created_at'] = date('Y-m-d H:i:s');
            $master['created_by'] = $this->session->userdata('user_id');
            
            $this->db->insert('fee_structure_master',$master);
            
            $fs_id = $this->db->insert_id();
            
            $insert_data = [];
            foreach($final as $key => $fin){
                $insert_data[] = $fin;
                $insert_data[$key]['fsm_id'] = $fs_id;
                
            }
            $this->db->insert_batch('class_fee_structure',$insert_data);
            
        }else{
            $master['created_at'] = date('Y-m-d H:i:s');
            $master['created_by'] = $this->session->userdata('user_id');
            
            $this->db->insert('fee_structure_master',$master);
            
            $fs_id = $this->db->insert_id();
            
            $insert_data = [];
            foreach($final as $key => $fin){
                $insert_data[] = $fin;
                $insert_data[$key]['fsm_id'] = $fs_id;
                
            }
            
            $this->db->insert_batch('class_fee_structure',$insert_data);
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