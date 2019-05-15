<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_model extends CI_Model{
    
    public function submitData($id,$data){
        if($id != ''){
            return $this->db->where('c_id',$id)->update('class',$data);
        }else{
            return $this->db->insert('class',$data);
        }
    }
    
    public function deleteData($delete_id) {
        return $this->db->where('c_id',$delete_id)->update('class',array('status'=>0));
    }
    
   /*----------------section area------------------------------------*/
    public function deleteSection($sec_id){
        return $this->db->where('sec_id',$sec_id)->update('section',array('status'=>0));
    }
    
    public  function submitSectionData($sectionid,$data){
        if($sectionid != ''){
            return $this->db->where('sec_id',$sectionid)->update('section',$data);
        }else{
            return $this->db->insert('section',$data);
        }
    }
    
}