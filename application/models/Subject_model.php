<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_model extends CI_Model {
    
    /*--------------------subject group-----------------------------------*/
   
    public function submitSubGroup($id,$data){
        if($id !=''){
            //------------update subject gorup-----------------
            return $this->db->where('sg_id',$id)->update('sub_group',$data);
        }else{
            //------------insert subject gorup-----------------
            return $this->db->insert('sub_group',$data);
        }
    }
    
    public function deleteSubGroup($delete_id){
        //------------delete subject gorup-----------------
        return $this->db->where('sg_id',$delete_id)->update('sub_group',array('status'=>0));
    }
   
    /*--------------------subject type-------------------------------*/
    public function submitSubjectType($st_id,$data){
        if($st_id != ''){
            //------------update subject gorup-----------------
            return $this->db->where('st_id',$st_id)->update('sub_type',$data);
        }else{
            //------------insert subject gorup-----------------
            return $this->db->insert('sub_type',$data);
        }
    }
    
    public function deleteSubType($delete_id){
        //------------delete subject gorup-----------------
        return $this->db->where('st_id',$delete_id)->update('sub_type',array('status'=>0));
        
    }
    
    
    
    
    
   /*-------------------subject------------------------------------*/
    public function subjectSubmit($sub_id,$data){
        if($sub_id != ''){
            //------------update subject gorup-----------------
            return $this->db->where('sub_id',$sub_id)->update('subject',$data);
        }else{
            //------------insert subject gorup-----------------
            return $this->db->insert('subject',$data);
        }
    }
    
    public function delete_subject($sub_id){
        //------------delete subject gorup-----------------
        return $this->db->where('sub_id',$sub_id)->update('subject',array('status'=>0));
    }
    
}