<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_ctrl extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('subject_model');
    }
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
   /*------------------------subject group---------------------------------------------------*/
    public function subGroupList(){
        $result = $this->db->select('sg_id,sg_name')->where('status',1)->get('sub_group')->result_array();
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('status'=>500));
        }
    }
    
    public function getSubGroupData() {
        $sg_id = $this->input->post('sg_id');
        $result = $this->db->select('sg_id,sg_name')->get_where('sub_group',array('sg_id'=>$sg_id))->result_array();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('status'=>500));
        }
    }
    
    public function deleteSubGroup(){
        $delete_id = $this->input->post('delete_id');
        $result = $this->subject_model->deleteSubGroup($delete_id);
        if($result){
            echo json_encode(array('status'=>200));
        }else{
            echo json_encode(array('feedback'=>'Delete Process failed,please try again.','status'=>500));
        }
    }
    
    
    public function submitSubGroup(){
        $this->form_validation->set_rules('sg_name','sg_name','required');
        if($this->form_validation->run()){
            $id = $this->input->post('sg_id');
            $data['sg_name'] = $this->input->post('sg_name');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            
            if($id != ''){
                $this->_ShowMsgs(
                    $this->subject_model->submitSubGroup($id,$data),"Subject Group Update Successfully","Subject Group failed to Update, Please try again."
                    );
            }else{
                $this->_ShowMsgs(
                    $this->subject_model->submitSubGroup($id,$data),"Subject Group Insert Successfully","Subject Group failed to Insert, Please try again."
                    );
            }
        }else{
            //--------user error-------------------
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }    
    }
    
    
    
 /*---------------------subject Type section----------------------------------------------*/ 
    public function subjectTypeList(){
        $result = $this->db->select('st_id,st_name')->where('status',1)->get('sub_type')->result_array();
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function getSubTypeData(){
        $st_id = $this->input->post('st_id');
        $result = $this->db->select('st_id,st_name')->where('st_id',$st_id)->get('sub_type')->result_array();
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function deleteSubType(){
        $delete_id = $this->input->post('delete_id');
        $result = $this->subject_model->deleteSubType($delete_id);
        if($result){
            echo json_encode(array('status'=>200));
        }else{
            echo json_encode(array('status'=>500));
        }
        
    }
    
    public function submitSubjectType(){
        $this->form_validation->set_rules('st_name','st name','required');
        if($this->form_validation->run()){
            $st_id = $this->input->post('st_id');
            $data['st_name'] = $this->input->post('st_name');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            
            if($st_id != ''){
                $this->_ShowMsgs(
                    $this->subject_model->submitSubjectType($st_id,$data),"Subject Type Update Successfully","Subject Type failed to Update, Please try again."
                    );
            }else{
                $this->_ShowMsgs(
                    $this->subject_model->submitSubjectType($st_id,$data),"Subject Type Insert Successfully","Subject Type failed to Insert, Please try again."
                    );
            }
        }else{
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }
    }
    
  /*--------------------subject sectioon--------------------------------------------------*/
    public function subjectList(){
        $result = $this->db->select('sub_id,st_name,sub_name,short_order')
                            ->join('sub_type st','st.st_id=s.st_id','inner')
                            ->where('s.status',1)
                            ->order_by('st.st_id ASC','s.short_order ASC')
                            ->get('subject s')->result_array();
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('status'=>500));
        }
    }
    
    public function delete_subject(){
        $sub_id = $this->input->post('sub_id');
        $result = $this->subject_model->delete_subject($sub_id);
        if($result){
            echo json_encode(array('status'=>200));
        }else{
            echo json_encode(array('status'=>500));
        }
    }
    
    public function editSubject(){
        $edit_id = $this->input->post('edit_id');
        $result = $this->db->select('sub_id,st_id,sub_name,short_order')->where('sub_id',$edit_id)->get('subject')->result_array();
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'Record not found.','status'=>500));
        }
    }
    
    public function subjectSubmit(){
        $this->form_validation->set_rules('subject_name','Subject Name','required');
        $this->form_validation->set_rules('short_order','Short Oder','required|trim');
        
        if($this->form_validation->run()){
            $sub_id = $this->input->post('sub_id');
            $data['st_id'] = $this->input->post('sub_type');
            $data['sub_name'] = $this->input->post('subject_name');
            $data['short_order'] = $this->input->post('short_order');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            
            if($sub_id != ''){
                $this->_ShowMsgs(
                    $result = $this->subject_model->subjectSubmit($sub_id,$data),"Subject Update Successfully","Subject failed to Update, Please try again."
                    );
            }else{
                $this->_ShowMsgs(
                    $result = $this->subject_model->subjectSubmit($sub_id,$data),"Subject Insert Successfully","Subject failed to Insert, Please try again."
                    );
            }
        }else{
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }
        
    }
    
}