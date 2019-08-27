<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Utilities_and_tool_model extends CI_Model{
    
    public function InsertDivision($data){
        $this->db->insert('division',$data);
        
        //-----------log report---------------
        $event = 'Add Division';
        $user = $this->session->userdata('user_id');
        $table_name = 'division';
        $table_id = $this->db->insert_id();
        $this->my_function->add_log($user,$event,$table_name,$table_id);
        return true;
    }
    
    public  function updateDivision($id,$data){
        $this->db->where('div_id',$id);
        $this->db->update('division',$data);
        
        //-----------log report---------------
        $event = 'Update Division';
        $user = $this->session->userdata('user_id');
        $table_name = 'division';
        $table_id = $id;
        $this->my_function->add_log($user,$event,$table_name,$table_id);
        return true;
    }
    public function deleteRow($id){
        $this->db->where('div_id',$id);
        $this->db->update('division',array('status'=>0));
        //-----------log report---------------
        $event = 'Delete Division';
        $user = $this->session->userdata('user_id');
        $table_name = 'division';
        $table_id = $id;
        $this->my_function->add_log($user,$event,$table_name,$table_id);
        return true;
    }
    
    public function updateGrade($id,$data){
        $this->db->where('g_id',$id);
        $this->db->update('grade',$data);
        //-----------log report---------------
        $event = 'Update Grade';
        $user = $this->session->userdata('user_id');
        $table_name = 'grade';
        $table_id = $id;
        $this->my_function->add_log($user,$event,$table_name,$table_id);
        return true;
    }
    
    public function insertGrade($data){
        $this->db->insert('grade',$data);
        //-----------log report---------------
        $event = 'Add Grade';
        $user = $this->session->userdata('user_id');
        $table_name = 'grade';
        $table_id = $this->db->insert_id();
        $this->my_function->add_log($user,$event,$table_name,$table_id);
        return true;
    }
    
    public function deleteGrade($delete_id){
        
        $this->db->where('g_id',$delete_id);
        $this->db->update('grade',array('status'=>0));
        
        //-----------log report---------------
        $event = 'Delete Grade';
        $user = $this->session->userdata('user_id');
        $table_name = 'grade';
        $table_id = $delete_id;
        $this->my_function->add_log($user,$event,$table_name,$table_id);
        return true;
    }
}