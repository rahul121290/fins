<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prospectus_model extends CI_Model {
    
    function sellingProspectus($p_id,$data){
        
        $this->db->trans_begin();
        
        if(!empty($p_id)){
            //---------update-----------
            $this->db->where('p_id',$p_id);
            $this->db->update('prospectus',$data);
        }else{
            //---------insert----------
            $this->db->insert('prospectus',$data);
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