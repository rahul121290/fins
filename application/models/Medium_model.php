<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medium_model extends CI_Model{
    public function submitData($id,$data){
        
        if($id != ''){
                $this->db->where('med_id',$id);
                return $this->db->update('medium',$data);
        }else{
             return $this->db->insert('medium',$data);
        }
        
    }
    
    public function delete_record($delete_id){
           return  $this->db->where('med_id',$delete_id)->update('medium',array('status'=>0));
        }
    
}