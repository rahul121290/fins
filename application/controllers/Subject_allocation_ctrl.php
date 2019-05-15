<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_allocation_ctrl extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('subject_allocation_model','sub_allocation');
    }
    
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
    public function getSubjectData(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $data['medium'] = $this->input->post('medium');
        $data['class'] = $this->input->post('class');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['section'] = $this->input->post('section');
        $data['sub_type'] = $this->input->post('sub_type');
        
        $condition = '';
        if(!empty($session)){
            $condition .= ' AND sa.ses_id='.$session;
        }
        if(!empty($school)){
            $condition .= ' AND sa.sch_id='.$school;
        }
        if(!empty($data['medium'])){
            $condition .= ' AND sa.med_id='.$data['medium'];
        }
        if(!empty($data['class'])){
            $condition .= ' AND sa.class_id='.$data['class'];
        }
        if(!empty($data['sub_group'])){
            $condition .= ' AND sa.sg_id='.$data['sub_group'];
        }
        if(!empty($data['section'])){
            $condition .= ' AND sa.sec_id='.$data['section'];
        }
        if(!empty($data['sub_type'])){
            $condition .= ' AND sa.st_id='.$data['sub_type'];
        }
        
        $this->db->select('s1.sub_id,s1.sub_name,IF(IsNULL(t1.sub_id),"NO","checked") as active');
        $this->db->join('subject s1','s1.sub_id = t1.sub_id','RIGHT');
        $this->db->where('s1.st_id',$data['sub_type']);
        $result = $this->db->get_where('(SELECT * FROM subject s WHERE s.sub_id = ANY (SELECT sub_id FROM subject_allocation sa WHERE sa.sub_id = s.sub_id'.$condition.' AND sa.status=1)) as t1')->result_array();
        
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.!','status'=>500));
        }
    }
    
//     public function subjetsList_ctrl(){
//         $session = $this->session->userdata('session_id');
//         $school = $this->session->userdata('school_id');
        
//         $this->db->select('med_name,class_name,section_name,st_name,sg_name');
//         $this->db->join('medium m','m.med_id=sa.med_id');
//         $this->db->join('class c','c.c_id=sa.class_id');
//         $this->db->join('section se','se.sec_id=sa.sec_id');
//         $this->db->join('sub_type st','st.st_id=sa.st_id');
//         $this->db->join('sub_group sg','sg.sg_id=sa.sg_id');
//         $this->db->join('subject s','s.sub_id=sa.sub_id');
//         $result = $this->db->get_where('subject_allocation sa',array('sa.ses_id'=>$session,'sa.sch_id'=>$school,'sa.med_id'=>2,'sa.status'=>1));
//         print_r($this->db->last_query()); die;
//     }
    
    public function list_of_exam_marks_entry(){
        //----------get post data-------------------------------
        $ses_id = (int)$this->session->userdata('session_id');
        $sch_id = (int)$this->session->userdata('school_id');
        $med_id = (int)$this->input->post('medium');
        $class_id = (int)$this->input->post('class');
        $sg_id = (int)$this->input->post('sub_group');
        $sec_id = (int)$this->input->post('section');
        $st_id = (int)$this->input->post('sub_type');
        
        //--------------get subject allocation list---------------------------------
        $this->db->select("sa.sa_id,sa.sub_id,sub_name,
                            MAX(IF(et.et_id = 1, om.out_of, '')) as pre,
                            MAX(IF(et.et_id = 2, om.out_of, '')) as mid,
                            MAX(IF(et.et_id = 2, om.practical, '')) as mid_practical,
                            MAX(IF(et.et_id = 3, om.out_of, '')) as post,
                            MAX(IF(et.et_id = 4, om.out_of, '')) as final,
                            MAX(IF(et.et_id = 4, om.practical, '')) as final_practical
                         ");
        $this->db->join('subject sub','sub.sub_id=sa.sub_id');
        $this->db->join('out_of_marks om','om.sa_id=sa.sa_id','left');
        $this->db->join('exam_type et','et.et_id=om.et_id','left');
        $this->db->group_by('sa.sa_id');
        
        if(!empty($sg_id)){
            $this->db->where('sa.sg_id',$sg_id);
        }
        $result = $this->db->get_where('subject_allocation sa',array('sa.ses_id'=>$ses_id,'sa.sch_id'=>$sch_id,'sa.med_id'=>$med_id,'sa.class_id'=>$class_id,'sa.st_id'=>$st_id,'sa.status'=>1))->result_array();
        //------------get exam type list------------------------------------------
        $this->db->select('et_id,et_name');
        $exam_type = $this->db->get_where('exam_type',array('ses_id'=>$ses_id,'status'=>1))->result_array();
        
        $this->db->select('*');
        $data = $this->db->get_where('out_of_marks',array('status'=>1))->result_array();
        
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'exam_type'=>$exam_type,'data'=>$data,'status'=>200));
        }else{
            echo json_encode(array('feedback','record not found!','status'=>500));
        }
        
    }
    
    public function entryOutOfMarks(){
        $this->form_validation->set_rules('out_of','out_of','trim');
        if($this->form_validation->run()){
            $data['sa_id'] = $this->input->post('sa_id');
            $data['et_id'] = $this->input->post('exam_type');
            $data['out_of'] = $this->input->post('out_of');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->_ShowMsgs(
                $this->sub_allocation->entry_ouf_of_marks($data),"Insert Successfully","Failed to Insert,Please try again."
                );
        }else{
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }
    }
    
    public function outOfPracticalMarks(){
        $this->form_validation->set_rules('practical','practical','required|trim');
        if($this->form_validation->run()){
            $data['sa_id'] = $this->input->post('sa_id');
            $data['et_id'] = $this->input->post('exam_type');
            $data['practical'] = $this->input->post('practical');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->_ShowMsgs(
                $this->sub_allocation->outOfPracticalMarks($data),"Insert Successfully","Failed to Insert,Please try again."
                );
        }else{
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }
        
    }
    
    public function subject_allocate(){
        $this->form_validation->set_rules('medium','medium','required|trim');
        $this->form_validation->set_rules('class','class','required|trim');
        $this->form_validation->set_rules('sub_group','sub_group','trim');
        $this->form_validation->set_rules('sub_type','sub_type','required|trim');
        $this->form_validation->set_rules('subject','subject','required');
        
        if($this->form_validation->run()){
            //-----get form data --------------------------------------
            $data['ses_id'] = (int)$this->session->userdata('session_id');
            $data['sch_id'] = (int)$this->session->userdata('school_id');
            $data['med_id'] = (int)$this->input->post('medium');
            $data['class_id'] = (int)$this->input->post('class');
            
            if(!empty($this->input->post('sub_group'))){
                $data['sg_id'] = (int)$this->input->post('sub_group');
            }
            $data['st_id'] = (int)$this->input->post('sub_type');
            $data['sub_id'] = (int)$this->input->post('subject');
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->_ShowMsgs(
                $this->sub_allocation->subject_allocate($data),"Subject allocate successfully.","Subject failed to allocate, please try again. "
                );
        }else{
            echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        }
        
    }
    
}