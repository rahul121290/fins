<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School_ctrl extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('school_model');
    }
    
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
    public function submit_data(){
        $this->form_validation->set_rules('school_name','session name','required');
        $this->form_validation->set_rules('address','address','required');
        $this->form_validation->set_rules('affiliation_no','affiliation no','required');
        $this->form_validation->set_rules('school_no','school no','required');
        $this->form_validation->set_rules('principal_name','principal name','required');
        
        if($this->form_validation->run()){
            $id = $this->input->post('id');
            $data['school_name'] = $this->input->post('school_name');
            $data['address'] = $this->input->post('address');
            $data['affiliation_no'] = $this->input->post('affiliation_no');
            $data['school_no'] = (int)$this->input->post('school_no');
            $data['principal_name'] = $this->input->post('principal_name');
            $data['old_principal_image'] = $this->input->post('old_principal_image');
            $data['old_image'] = $this->input->post('old_image');
            if($id != ''){
                $this->_ShowMsgs(
                    $this->school_model->school_insert($id,$data),"School Record Update Successfully","School Record Failed to Update, Please Try Again."
                    );
            }else{
                $this->_ShowMsgs(
                    $this->school_model->school_insert($id,$data),"School Record Insert Successfully","School Record Failed to Insert, Please Try Again."
                    );
            }
        }else{
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }
        
    }//end of function----
    
    public function schoolList(){
        $result = $this->db->select('sch_id,school_name,address,affiliation_no,school_no,school_image,set_school')
                           ->where('status',1)->get('school')
                           ->result_array();
        //print_r($this->db->last_query()); die;
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found.','status'=>500));
        }
    }//---end of function----
    
    public function deleteRow(){
        $delete_id = $this->input->post('delete_id');
        $this->_ShowMsgs(
            $this->school_model->deleteRow($delete_id),
            "Record Delete Successfully","This Record  run on Your Session, First you can change Set Data."
            );
    }
    
    public function editRow(){
        $edit_id = $this->input->post('edit_id');
        $result = $this->db->select('*')
                 ->get_where('school',array('sch_id'=>$edit_id,'status'=>1))
                 ->result_array();
       if(count($result) > 0 ){
           echo json_encode(array('result'=>$result,'status'=>200));
       }else{
       echo json_encode(array('msg'=>'record not found.','status'=>500));
       }
    }
    
    public function setInSession(){
        $set_id = $this->input->post('set_id');
        $this->_ShowMsgs(
            $this->school_model->setInSession($set_id),
            "Session Update Successfully.","Session Failed to Update, Please Try Again."
            );
    }
    ////////////////////////////////////////// vivartaa //////////////////////////////////////
    
    function school_create(){
            $result = array();
            $data['sch_id'] = $this->post('sch_id');
            $data['school_name'] = $this->post('school_name');
            $data['medium'] = $this->post('medium');
            $data['website'] = $this->post('school_url');
            $data['contact_no'] = $this->post('school_contact_no');
            $data['alternet_no'] = $this->post('school_contact_no');
            $data['state'] = $this->post('state');
            $data['city'] = $this->post('city');
            $data['address'] = $this->post('address');
            
            
            
            $data['uname'] = $this->post('uname');
            $data['email'] = $this->post('email');
            $data['password'] = $this->post('password');
            $result = $this->ion_auth->school_create($data);
            if($result){
                $this->response(array('school_id'=>$result,'msg'=>'server done.'), 200);
            }else {
                $this->response(array('msg'=>'server error.'), 500);
            }
        
    }
}