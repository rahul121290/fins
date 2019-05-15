<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_ctrl extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('class_model');
    }
    
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
    public function classList(){
        $result = $this->db->select('c_id,class_name')->order_by('c_id','ASC')->get_where('class',array('status'=>1))->result_array();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'Record not found.','status'=>500));
        }
    }
    
    public function deleteData(){
        $delete_id = $this->input->post('delete_id');
        $result = $this->class_model->deleteData($delete_id);
        if($result){
            echo json_encode(array('feedback'=>'Record Delete Successfully','status'=>200));
        }else{
            echo json_encode(array('feedback'=>'Record Delete to Failed, Please try again.','status'=>500));
        }
    }
    
    public function getEditData(){
        $edit_id  = $this->input->post('edit_id');
        
        $result = $this->db->select('c_id,class_name')->get_where('class',array('c_id'=>$edit_id,'status'=>1))->result_array();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function submitData() {
        $this->form_validation->set_rules('class_name','Class Name','required');
        
        if($this->form_validation->run()){
            $id = $this->input->post('id');
            $data['class_name'] = $this->input->post('class_name');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            
            if($id != ''){
                $this->_ShowMsgs(
                    $this->class_model->submitData($id,$data),"Class Update Successfully","Class Failed to Update, Please try again."
                    );
            }else{
                $this->_ShowMsgs(
                    $this->class_model->submitData($id,$data),"Class Insert Successfully","Class Failed to Insert, Please try again."
                    );
            }
        }else{
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }
    }
 /*--------------------------end class area--------------------------------------------------------*/
 
 /*--------------------------start section area--------------------------------------------------------*/
    
    public function SectionList() {
        $result = $this->db->select('sec_id,section_name')->order_by('section_name','ASC')->get_where('section',array('status'=>1))->result_array();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('status'=>500));
        }
    }
    
    public function editSecId(){
        $editSecId = $this->input->post('editSecId');
        $result = $this->db->select('*')->get_where('section',array('sec_id'=>$editSecId))->result_array();
        
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'Record not found.','status'=>500));
        }
    }
    
    public function deleteSection(){
        $sec_id = $this->input->post('sec_id');
        $result = $this->class_model->deleteSection($sec_id);
        if($result){
           echo json_encode(array('feedback'=>'Delete Successfully','status'=>200)); 
        }else{
            echo json_encode(array('feedback'=>'Delete Proccess Falied, Please try again.','status'=>500));
        }
    }
    
    
    public function submitSectionData(){
        
        $this->form_validation->set_rules('section_name','Section Name','required');
        
        if($this->form_validation->run()){
            $sectionid = $this->input->post('sectionid');
            $data['section_name'] = strtoupper($this->input->post('section_name'));
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            
            if($sectionid != ''){
                $this->_ShowMsgs(
                    $this->class_model->submitSectionData($sectionid,$data),"Section Update Successfully","Section Failed to Update, Please try again."
                    );
            }else{
                $this->_ShowMsgs(
                    $this->class_model->submitSectionData($sectionid,$data),"Section Insert Successfully","Section Failed to Insert, Please try again."
                    );
            }
        }else{
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }
        
    }
    
}