<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_ctrl extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('teacher_model');
    }
    
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
    function export_teacher_records(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        
        $this->db->select('*');
        $this->db->order_by('teacher_name','ASC');
        $result = $this->db->get_where('teacher',array('status'=>1,'session_id'=>$session,'school_id'=>$school))->result_array();
        
        if(count($result) > 0){
            
            $phpExcel = new PHPExcel();
            $prestasi = $phpExcel->setActiveSheetIndex(0);
            
            //----------put index name-------------------
            $prestasi->setCellValue('A1', 'S. No.');
            $prestasi->setCellValue('B1', 'Teacher Name');
            $prestasi->setCellValue('C1', 'Gender');
            $prestasi->setCellValue('D1', 'Date of Birth');
            $prestasi->setCellValue('E1', 'Phone');
            $prestasi->setCellValue('F1', 'Email');
            $prestasi->setCellValue('G1', 'Prmt Address');
            $prestasi->setCellValue('H1', 'Alter Address');
            $prestasi->setCellValue('I1', 'Designation');
            $prestasi->setCellValue('J1', 'Qualifications');
            
            //---------------------put data in excel----------------------------
            $no=0;
            $rowexcel = 1;
            foreach($result as $row){
                $no++;
                $rowexcel++;
                $prestasi->setCellValue('A'.$rowexcel, $no);
                $prestasi->setCellValue('B'.$rowexcel, $row["teacher_name"]);
                $prestasi->setCellValue('C'.$rowexcel, $row["gender"]);
                $prestasi->setCellValue('D'.$rowexcel, $row["dob"]);
                $prestasi->setCellValue('E'.$rowexcel, $row["phone"]);
                $prestasi->setCellValue('F'.$rowexcel, $row["email"]);
                $prestasi->setCellValue('G'.$rowexcel, $row["prmt_address"]);
                $prestasi->setCellValue('H'.$rowexcel, $row["alter_address"]);
                $prestasi->setCellValue('I'.$rowexcel, $row["designation"]);
                $prestasi->setCellValue('J'.$rowexcel, $row["qualifications"]);
            }
            
            $date =date('U');
            $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
            
            if(!is_dir('./teacher_record')){
                mkdir('./teacher_record');
            }
            if($school == 1){
                $sch_name = 'shakuntala';
            }else if($school == 2){
                $sch_name = 'sharda';
            }else{
                $sch_name = 'cg-board';
            }
            $filename = "teacher_record/".$sch_name."_teacher_record_".time().".xlsx";
            //----------save excel file----------------------------
            $res = $objWriter->save($filename);
            if($filename){
                echo json_encode(array('file'=>$filename,'status'=>200));
            }else{
                echo json_encode(array('msg'=>'something went wrong','status'=>500));
            }
        }
        
    }
    
    public function eidtData(){
        $id = $this->input->post('id');
        $result = $this->db->select('*')->get_where('teacher',array('t_id'=>$id,'status'=>1))->result_array();
        
        $ct_data = $this->db->select('*')->get_where('class_teacher',array('t_id'=>$id,'status'=>1))->result_array();
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'ct_data'=>$ct_data,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function deleteRecord(){
        $delete_id = $this->input->post('delete_id');
        $this->_ShowMsgs(
            $this->teacher_model->deleteRecord($delete_id),"Delete Record Successfully.","Failed Delete Record,Please try again."
            );
    }
    
    public function checkUniqueEmail(){
        $emailId = $this->input->post('emailId');
        $result = $this->db->select('email')->get_where('teacher',array('email'=>$emailId,'status'=>1))->result_array();
        
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('result'=>'email id not found.','status'=>500));
        }
    }
    
    public function submitTeacherData(){
      //  if($this->input->post('class_teacher') == 'yes'){
        //    $this->form_validation->set_rules('medium','medium','required');
          //  $this->form_validation->set_rules('class','class','required');
      //      if($this->input->post('class') >= '14'){
       //         $this->form_validation->set_rules('sub_group','sub_group','required');
      //      }
      //      $this->form_validation->set_rules('section','section','required');
     //   }
        
        //$this->form_validation->set_rules('teacher_name','teacher_name','required');
        //$this->form_validation->set_rules('gender','gender','required');
        //$this->form_validation->set_rules('dob','dob','required');
        //$this->form_validation->set_rules('email','email','required');
        //$this->form_validation->set_rules('prmt_address','prmt_address','required');
        //$this->form_validation->set_rules('alter_address','alter_address','required');
        //$this->form_validation->set_rules('designation','designation','required');
        //$this->form_validation->set_rules('qualifications','qualifications','required');
        
      //  if($this->form_validation->run()){
            
            $ct_id = $this->input->post('ct_id');
            $class_teacher['class_teacher'] = $this->input->post('class_teacher');
            $class_teacher['medium'] = $this->input->post('medium');
            $class_teacher['class'] = $this->input->post('class');
            $class_teacher['section'] = $this->input->post('section');
            
            if(!empty($this->input->post('sub_group'))){
                $class_teacher['sub_group'] = $this->input->post('sub_group');
            }
            
            $tid = $this->input->post('t_id');
            $data['teacher_name'] = $this->input->post('teacher_name');
            $data['gender'] = $this->input->post('gender');
            $data['dob'] = $this->input->post('dob');
            $data['phone'] = $this->input->post('phone');
            $data['email'] = $this->input->post('email');
            $data['prmt_address'] = $this->input->post('prmt_address');
            $data['alter_address'] = $this->input->post('alter_address');
            $data['designation'] = $this->input->post('designation');
            $data['qualifications'] = $this->input->post('qualifications');
            $data['old_image'] = $this->input->post('old_image');
            if($tid != ''){
                $this->_ShowMsgs(
                    $this->teacher_model->submitTeacherData($tid,$data,$ct_id,$class_teacher),"Teacher record updated!","Teacher Data Failed to Update, Please try again."
                    );
            }else{
                $this->_ShowMsgs(
                    $this->teacher_model->submitTeacherData($tid,$data,$ct_id,$class_teacher),"New Teacher added!","Teacher Data Failed to Insert, Please try again."
                    );    
            }
            
       // }else{
        //    echo json_encode(array('validation_errors'=>validation_errors(),'status'=>400));
        //}
        
    }
    
    public function getSubjects(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $medium = $this->input->post('medium');
        $class_name = $this->input->post('class_name');
        $sub_group = $this->input->post('sub_group');
        $sub_type = $this->input->post('sub_type');
        $section = $this->input->post('section');
        
        $this->db->select('st.st_id,sa.sa_id,s.sub_name,st.t_id, st.status');
        $this->db->join('sub_teacher st','st.sa_id = sa.sa_id AND st.sec_id = '.$section.'','LEFT');
        $this->db->join('subject s','s.sub_id=sa.sub_id');
        $this->db->order_by('s.short_order','ASC');
        if(!empty($sub_group)){
            $this->db->where('sa.sg_id',$sub_group);
        }
        $result = $this->db->get_where('subject_allocation sa',array('sa.ses_id'=>$session,'sa.sch_id'=>$school,'sa.med_id'=>$medium,'sa.class_id'=>$class_name,'sa.st_id'=>$sub_type,'sa.status'=>1))->result_array();
        //print_r($this->db->last_query());die;
		
        $teachers = $this->db->select('t_id,teacher_name')->order_by('teacher_name','ASC')->get_where('teacher',array('school_id'=>$school,'status'=>1))->result_array();
        
        if(count($result) > 0){
            echo json_encode(array('result'=>$result,'teachers'=>$teachers,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function allocateSubjectTeacher(){
        $data['t_id'] = $this->input->post('t_id');
        $data['sa_id'] = $this->input->post('sa_id');
        $data['sec_id'] = $this->input->post('section');
        $data['created_by'] = $this->session->userdata('user_id');
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->_ShowMsgs(
            $this->teacher_model->allocateSubjectTeacher($data),"teacher allocate subject successfully"," falied to teacher allocate subject, please try again."
            );
    }
    
    public function ListOfSubjectTeacher(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $medium = $this->input->post('medium');
        $class_name = $this->input->post('class_name');
        $sub_group = $this->input->post('sub_group');
        $section = $this->input->post('section');
        
        $condition = '';
        if($session){
            $condition.=' AND sa.ses_id='.$session;
        }
        if($school){
            $condition.=' AND sa.sch_id='.$school;
        }
        if($medium){
            $condition.=' AND sa.med_id='.$medium;
        }
        if($class_name){
            $condition.=' AND sa.class_id='.$class_name;
        }
        if($sub_group){
            $condition.=' AND sa.sg_id='.$sub_group;
        }
        
        if(!empty($sub_group)){
            $this->db->select('sec.section_name,c.class_name,sg.sg_name,sub_t.st_name,sub.sub_name,t1.teacher_name');
        }else{
            $this->db->select('sec.section_name,c.class_name,sub_t.st_name,sub.sub_name,t1.teacher_name');
        }
        $this->db->join('subject_allocation sa','sa.sa_id=st.sa_id AND sa.status = 1');
        $this->db->join('class c','c.c_id = sa.class_id AND c.status = 1');
        $this->db->join('sub_type sub_t','sub_t.st_id=sa.st_id AND sub_t.status = 1');
        $this->db->join('section sec','sec.sec_id = st.sec_id AND sec.status = 1');
        if(!empty($sub_group)){
            $this->db->join('sub_group sg','sg.sg_id=sa.sg_id AND sg.status = 1');
        }
        $this->db->join('subject sub','sub.sub_id = sa.sub_id AND sub.status = 1');
        $this->db->join('teacher t1','t1.t_id=st.t_id AND t1.status = 1','LEFT');
        $this->db->where('1=1 '.$condition);
        $result = $this->db->get_where('sub_teacher st',array('st.status'=>1,'st.sec_id'=>$section))->result_array();
       // print_r($this->db->last_query());die;
        if(count($result) > 0 ){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    function student_feedback(){
       $data['ses_id'] = $this->session->userdata('session_id');
       $data['sch_id'] = $this->session->userdata('school_id');
       $data['medium'] = $this->input->post('medium');
       $data['class_id'] = $this->input->post('class_id');
       $data['sec_id'] = $this->input->post('section');
       
       $condition = 's.status = 1';
       if($data['ses_id']){
           $condition .= ' AND s.ses_id ='.$data['ses_id'];
       }
       if($data['sch_id']){
           $condition .= ' AND s.sch_id ='.$data['sch_id'];
       }
       if($data['medium']){
           $condition .= ' AND s.medium ='.$data['medium'];
       }
       if($data['class_id']){
           $condition .= ' AND s.class_id ='.$data['class_id'];
       }
       if($data['sec_id']){
           $condition .= ' AND s.sec_id ='.$data['sec_id'];
       }
       
       $this->db->select('s.std_id,s.medium,s.adm_no,s.roll_no,s.name,c.class_name,sec.section_name,
                IFNULL((SELECT MAX(warning_no) FROM student_feedback WHERE ses_id = '.$data['ses_id'].' AND sch_id = '.$data['sch_id'].' AND med_id = '.$data['medium'].' AND adm_no = s.adm_no),"-") warning_no
         ');
       $this->db->join('class c','c.c_id = s.class_id');
       $this->db->join('section sec','sec.sec_id = s.sec_id');
       $this->db->where($condition);
       $this->db->order_by('s.roll_no','ASC');
       $result = $this->db->get_where('students s')->result_array();
       if(count($result) > 0){
           echo json_encode(array('data'=>$result,'status'=>200));
       }else{
           echo json_encode(array('msg'=>'Record not found.','status'=>500));
       }
    }
    
    function warning_list(){
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->session->userdata('school_id');
        $data['medium'] = $this->input->post('medium');
        $data['adm_no'] = $this->input->post('adm_no');
        
        $this->db->select('MAX(warning_no) warning_no');
        $this->db->where(array('ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id'],'med_id'=>$data['medium'],'adm_no'=>$data['adm_no']));
        $warning_no = $this->db->get_where('student_feedback',array('status'=>1))->result_array();
        
        $see_warning = 1;
        if($warning_no[0]['warning_no'] > 0){
            $see_warning = $warning_no[0]['warning_no']+1;
        }
        
        $this->db->select('*');
        $result = $this->db->get_where('warning_no',array('status'=>1,'w_id <= '=>$see_warning))->result_array();
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found.','status'=>500));
        }
        
    }
    
    
    function feedback_list(){
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->session->userdata('school_id');
        $data['medium'] = $this->input->post('medium');
        $data['adm_no'] = $this->input->post('adm_no');
        $data['warning_no'] = $this->input->post('warning_no');
        
        $this->db->select('*');
        $result['feedback_list'] = $this->db->get_where('assessment_feedback',array('status'=>1,'medium'=>$data['medium']))->result_array();
        
        $this->db->select('*');
        $result['action_taken'] = $this->db->get_where('action_taken',array('status'=>1))->result_array();
        
        $this->db->select('feedback_ids,action_taken,custom_msg');
        $this->db->where(array('ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id'],'med_id'=>$data['medium'],'adm_no'=>$data['adm_no'],'warning_no'=>$data['warning_no']));
        $student_feedback = $this->db->get_where('student_feedback',array('status'=>1))->result_array();
        
        
        if(count($student_feedback) > 0){
            $result['custom_msg'] = $student_feedback[0]['custom_msg'];
            
            $result['student_feedback'] = $student_feedback[0]['feedback_ids'];
            $result['teacher_action_taken'] = $student_feedback[0]['action_taken'];
        }else{
            $result['student_feedback'] = '';
            $result['teacher_action_taken'] = '';
            $result['custom_msg'] = '';
        }
        
        if(count($result) > 0){
            echo json_encode(array('data'=>$result,'status'=>200));
        }else{
            echo json_encode(array('msg'=>'Record not found.','status'=>500));
        }
    }
    
    function submit_feedback(){
        $data['ses_id'] = $this->session->userdata('session_id');
        $data['sch_id'] = $this->session->userdata('school_id');
        $data['med_id'] = $this->input->post('medium');
        $data['adm_no'] = $this->input->post('adm_no');
        $data['warning_no'] = $this->input->post('warning_no');
        $data['feedback_ids'] = $this->input->post('assesment_feedback');
        $data['action_taken'] = $this->input->post('action_taken');
        $data['custom_msg'] = $this->input->post('custom_msg');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['created_by'] = $this->session->userdata('user_id');
        
        $this->db->trans_begin();
        $this->db->select('sfb_id');
        $this->db->where(array('ses_id'=>$data['ses_id'],'sch_id'=>$data['sch_id'],'med_id'=>$data['med_id'],'adm_no'=>$data['adm_no'],'warning_no'=>$data['warning_no']));
        $check = $this->db->get_where('student_feedback',array('status'=>1))->result_array();
        
        if(count($check) > 0){
            //-------------update------------
            $this->db->where('sfb_id',$check[0]['sfb_id']);
            $this->db->update('student_feedback',$data);
        }else{
            //-------------insert------------
            $this->db->insert('student_feedback',$data);
        }
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            echo json_encode(array('msg'=>'Feedback Adding Faild, Please try again.','status'=>500));
        }
        else{
            $this->db->trans_commit();
            echo json_encode(array('msg'=>'Feedback Added Successfully','status'=>200));
        }
        
        
        
    }
    
}