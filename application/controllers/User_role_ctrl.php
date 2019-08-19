<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_role_ctrl extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('user_role_model');
        $this->load->library(array('ion_auth'));
    }
    
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
    public function getemail(){
        $tid = (int)$this->input->post('tid');
        $this->db->select('t.email,IF(ct.t_id IS NULL,"2","3") class_teacher');
        $this->db->join('class_teacher ct','ct.t_id = t.t_id','LEFT');
        $result = $this->db->get_where('teacher t',array('t.t_id'=>$tid,'t.status'=>1))->result_array();
       // print_r($this->db->last_query());die;
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function deleteRecord(){
        $delete_id = $this->input->post('delete_id');
        $this->_ShowMsgs(
            $this->user_role_model->deleteRecord($delete_id),"Delete Successfully","Faild to Delete Process,Please try again."
            );
    }
    
    
    public function getEditData(){
        $id = $this->input->post('editId');
        $users = $this->db->select('id,t_id,permission,email,username,pass_hint')->get_where('users',array('id'=>$id))->result_array();
        if(count($users) > 0){
            $teacher = $this->db->select('t_id,teacher_name')->get_where('teacher',array('t_id'=>$users[0]['t_id'],'email'=>$users[0]['email']))->result_array();
            
			$this->db->select('ug.id as ug_id,g.id,g.name');
            $this->db->join('users u','u.id = ug.user_id');
            $this->db->join('groups g','g.id = ug.group_id');
            $groups = $this->db->get_where('users_groups ug',array('u.id'=>$id))->result_array();
            
            $data['id'] = $users[0]['id'];
            $data['teacher'] = $teacher[0]['t_id'];
            $data['email'] = $users[0]['email'];
            $data['permission'] = $users[0]['permission'];
            $data['username'] = $users[0]['username'];
            $data['pass_hint'] = $users[0]['pass_hint'];
            $data['ug_id'] = $groups[0]['ug_id'];
            $data['group'] = $groups[0]['id'];
            
            echo json_encode(array('data'=>$data,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
        
    }
    
    
    
    public function userRollSubmit(){
        $id = $this->input->post('id');
        $ug_id = $this->input->post('ug_id');
        $group = $this->input->post('group');
        $data['t_id'] = $this->input->post('teacher');
        $data['username'] = $this->input->post('username');
        $data['password'] = $this->ion_auth_model->hash_password($this->input->post('confirm_password'),FALSE,FALSE);
        $data['permission'] = $this->input->post('permission');
        $data['email'] = $this->input->post('email');;
        $data['school_id'] = $this->session->userdata('school_id');
        $data['pass_hint'] = $this->input->post('confirm_password');
        $data['active'] = 1;
        if($id != ''){
            $this->_ShowMsgs(
                $this->user_role_model->userRollSubmit($id,$ug_id,$group,$data),"Update Successfully","Failed to Update,Please try again."
                );
        }else{
            $this->_ShowMsgs(
                $this->user_role_model->userRollSubmit($id,$ug_id,$group,$data),"Insert Successfully.","Failed to Insert,Please try again."
                );
        }
    }
    
    
    function checkUsername(){
        $username = $this->input->post('username');
        $result = $this->db->select('username')->get_where('users',array('status'=>1,'username'=>$username))->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('data'=>'record not found.','status'=>500));
        }
    }
    
    
    
}