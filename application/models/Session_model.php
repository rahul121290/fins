<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_model extends CI_Model{
    
    public function session_insert($data){
        return $this->db->insert('session',$data);
    }
    
    public function session_update($id,$data){
        return  $this->db->where('ses_id',$id)->update('session',$data);
        
    }
    
    public function delete_session($delete_id) {
        $seted_ses_id = $this->db->select('set_ses')->where('ses_id',$delete_id)->get('session')->result_array();
        $seted_session = $seted_ses_id[0]['set_ses'];
        if($seted_session == 0){
            return  $this->db->where('ses_id',$delete_id)->update('session',array('status'=>0));
        }else{
            return false;
        }
    }
    
    public function session_set($id,$seted_value){
        $this->db->trans_begin();
        
        $this->db->update('session',array('set_ses'=>0));
        $this->db->where('ses_id',$id)->update('session',array('set_ses'=>1));
        
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
