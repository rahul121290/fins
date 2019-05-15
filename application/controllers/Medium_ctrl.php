<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medium_ctrl extends CI_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->model('medium_model');
    }
    
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
    public function showList(){
        $result = $this->db->select('med_id,med_name')
                           ->where('status',1)
                           ->get_where('medium')->result_array();
         if(count($result) > 0){
             echo json_encode(array('result'=>$result,'status'=>200));
         }else{
             echo json_encode(array('feedback'=>'record not found.','status'=>500));
         }
    }
    
    public function delete_record(){
        $delete_id = $this->input->post('delete_id');
        $this->_ShowMsgs(
            $this->medium_model->delete_record($delete_id),"Record Delete Successfully","Medium is setted please change after delete."
            );
    }
    
    public function editrecord(){
        $edit_id = $this->input->post('edit_id');
        $result = $this->db->select('med_id,med_name')->get_where('medium',array('med_id'=>$edit_id,'status'=>1))->result_array();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function submitData(){
        $this->form_validation->set_rules('medium_name','Medium Name','required');

        if($this->form_validation->run()){
            $id = $this->input->post('id');
            $data['med_name'] = $this->input->post('medium_name');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d h:i:s');
            
            if($id != ''){
                $this->_ShowMsgs(
                    $this->medium_model->submitData($id,$data),"Medium Update Successfully","Medium Failed to Update, Please try again."
                    );
            }else{
                $this->_ShowMsgs(
                    $this->medium_model->submitData($id,$data),"Medium Insert Successfully","Medium Failed to Insert, Please try again."
                   );
            }
            
        }else{
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }
    }
    
}