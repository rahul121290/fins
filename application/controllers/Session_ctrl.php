<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_ctrl extends CI_Controller{
  
    public function __construct(){
        parent::__construct();
        $this->load->model('session_model');
    }
    
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
    public function session_insert(){
        $this->form_validation->set_rules('session_name','session name','required|trim');
        
        if($this->form_validation->run()){
            $id = $this->input->post('id');
            $data['session_name'] = $this->input->post('session_name');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d h:i:s');
            if($id != ''){
                $this->_ShowMsgs(
                    $this->session_model->session_update($id,$data),
                    "Session Update Successfully",
                    "Session Failed to Update, Please Try Again."
                    );
            }else{
            $this->_ShowMsgs(
                $this->session_model->session_insert($data),
                "Session Insert Successfully",
                "Session Failed to Insert, Please Try Again."
                );
            }//end else condition
        }else{
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }
    }
    
    public function get_session(){
        $result = $this->db->select('ses_id,session_name,set_ses')
                           ->get_where('session',array('status'=>1))->result_array();
                           
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }
    }
    
    public function delete_session(){
        $delete_id = $this->input->post('delete_id');
        
        $this->_ShowMsgs(
            $this->session_model->delete_session($delete_id),
            "Delete Successfully",
            "Session is Setted, First you change to session year."
        );
    }
    
    public function edit_data(){
        $edit_id = $this->input->post('edit_id');
        $result = $this->db->select('ses_id,session_name')->get_where('session',array('ses_id'=>$edit_id,'status'=>1))->result_array();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'Something getting wrong.','feedback_class'=>'alert-danger','status'=>500));
        }
    }
    public function session_set(){
        $id =  $this->input->post('id');
        $seted_value =  $this->input->post('session_set');
        $this->_ShowMsgs(
            $this->session_model->session_set($id,$seted_value),"Set Session Successfully","Session Failed to Set, Please Try Again."
            );
    }
    
}