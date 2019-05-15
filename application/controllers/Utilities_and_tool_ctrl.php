<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Utilities_and_tool_ctrl extends CI_Controller{
    public function __construct(){
        parent :: __construct();
        $this->load->model('Utilities_and_tool_model','utilities_model');
    }
    
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
    public function listOfDivision(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $result = $this->db->select('div_id,med_id,min_no,max_no,division')->get_where('division',array('ses_id'=>$session,'sch_id'=>$school,'status'=>1))->result_array();
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
        
    }
    
    public function getEditData(){
        $id = $this->input->post('edit_id');
        $result = $this->db->select('div_id,med_id,min_no,max_no,division')->get_where('division',array('div_id'=>$id,'status'=>1))->result_array();
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'somthing getting wrong.','status'=>500));
        }
        
    }
    
    public function deleteRow(){
        $id = $this->input->post('delete_id');
        $this->_ShowMsgs(
            $this->utilities_model->deleteRow($id),"Record Delete Successfully","Record Failed to Delete,Please try agan."
            );
    }
    
    public function InsertDivision(){
        $this->form_validation->set_rules('medium','medium','required');
        $this->form_validation->set_rules('min_no','min_no','required|numeric|trim');
        $this->form_validation->set_rules('max_no','max_no','required|numeric|trim');
        $this->form_validation->set_rules('division','division','required');
        
        if($this->form_validation->run()){
            $id = $this->input->post('id');
            $data['ses_id'] = $this->session->userdata('session_id');
            $data['sch_id'] = $this->session->userdata('school_id');
            $data['med_id'] = $this->input->post('medium');
            $data['min_no'] = $this->input->post('min_no');
            $data['max_no'] = $this->input->post('max_no');
            $data['division'] = $this->input->post('division');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            
            if(!empty($id)){
                $this->_ShowMsgs(
                    $this->utilities_model->updateDivision($id,$data),"Division Update Successfully.","Division Failed to Update, Please try again."
                    );
            }else{
                $this->_ShowMsgs(
                    $this->utilities_model->InsertDivision($data),"Division Insert Successfully.","Division Failed to Insert, Please try again."
                    );
            }
        }else{
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }
    }
    
    //-----------------------grade section ---------------------------------------
    
    
    public function listOfGrade(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $result = $this->db->select('g_id,med_id,min_no,max_no,grade,grade_point')->get_where('grade',array('ses_id'=>$session,'sch_id'=>$school,'status'=>1))->result_array();
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function GetGradeEditData(){
        $id = $this->input->post('edit_id');
        $result = $this->db->select('g_id,med_id,min_no,max_no,grade,grade_point')->get_where('grade',array('status'=>1))->result_array();
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function deleteGrade(){
        $delete_id = $this->input->post('delete_id');
        $this->_ShowMsgs(
            $this->utilities_model->deleteGrade($delete_id),"Grade Delete Successfully.","Grade delete to failed, please try again."
            );
    }
    
    public function GradeSubmit(){
        $this->form_validation->set_rules('medium','medium','required');
        $this->form_validation->set_rules('min_no','min_no','required|numeric|trim');
        $this->form_validation->set_rules('max_no','max_no','required|numeric|trim');
        $this->form_validation->set_rules('grade','grade','required');
        $this->form_validation->set_rules('grade_point','grade_point','required');
        
        if($this->form_validation->run()){
            $id = $this->input->post('id');
            $data['ses_id'] = $this->session->userdata('session_id');
            $data['sch_id'] = $this->session->userdata('school_id');
            $data['med_id'] = $this->input->post('medium');
            $data['min_no'] = $this->input->post('min_no');
            $data['max_no'] = $this->input->post('max_no');
            $data['grade'] = $this->input->post('grade');
            $data['grade_point'] = $this->input->post('grade_point');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            
            if(!empty($id)){
                $this->_ShowMsgs(
                    $this->utilities_model->updateGrade($id,$data),"Grade Update Successfully.","Grade Failed to Update, Please try again."
                    );
            }else{
                $this->_ShowMsgs(
                    $this->utilities_model->insertGrade($data),"Grade Insert Successfully.","Grade Failed to Insert, Please try again."
                    );
            }
        }else{
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }
    }
    
    
}