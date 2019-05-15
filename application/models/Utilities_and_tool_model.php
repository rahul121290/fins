<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Utilities_and_tool_model extends CI_Model{
    
    public function InsertDivision($data){
        return $this->db->insert('division',$data);
    }
    
    public  function updateDivision($id,$data){
        $this->db->where('div_id',$id);
        return $this->db->update('division',$data);
    }
    public function deleteRow($id){
        $this->db->where('div_id',$id);
        return $this->db->update('division',array('status'=>0));
    }
    
    public function updateGrade($id,$data){
        $this->db->where('g_id',$id);
        return $this->db->update('grade',$data);
    }
    
    public function insertGrade($data){
        return $this->db->insert('grade',$data);
    }
    
    public function deleteGrade($delete_id){
        
        $this->db->where('g_id',$delete_id);
        return $this->db->update('grade',array('status'=>0));
    }
}