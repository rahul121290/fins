<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marks_entry_ctrl extends CI_Controller{
  
    public function __construct(){
        parent::__construct();
        $this->load->model('marks_entry_model');
        $this->load->library(array('ion_auth'));
    }
    
    private function _ShowMsgs($successfull, $successMsg, $failureMsg){
        if($successfull){
            echo json_encode(array('feedback'=>$successMsg,'feedback_class'=>'alert-success','status'=>200));
        }else{
            echo json_encode(array('feedback'=>$failureMsg,'feedback_class'=>'alert-danger','status'=>500));
        }
    }
    
    public function getSubjects(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $exam_type = $this->input->post('exam_type');
        
        $medium = $this->input->post('medium');
        $class = $this->input->post('class_name');
        $sub_group = $this->input->post('sub_group');
        $section = $this->input->post('section');
        $sub_type = $this->input->post('sub_type');
        
        if($this->ion_auth->is_admin()){ //-----------login member is admin---------------------
            $this->db->select('sa.sub_id,s.sub_name,st.st_name');
            $this->db->join('subject s','s.sub_id=sa.sub_id');
            $this->db->join('sub_type st','st.st_id=s.st_id');
            if(!empty($sub_group)){
                $this->db->where('sa.sg_id',$sub_group);
            }
            $this->db->order_by('s.short_order','ASC');
            $result = $this->db->get_where('subject_allocation sa',array('sa.ses_id'=>$session,'sa.sch_id'=>$school,'sa.med_id'=>$medium,'sa.class_id'=>$class,'sa.st_id'=>$sub_type,'sa.status'=>1))->result_array();
        }else{
            //-------------check login member is teacher--------------------
            $this->db->select('t_id,email');
            $this->db->where('email=(SELECT `email` FROM `users` WHERE `id` ='.$this->session->userdata('user_id').')');
            $teacher = $this->db->get_where('teacher')->result_array();
            
            if(count($teacher)>0){
                //-----------get teacher subjects-------------------------
                $this->db->select('sa.sub_id,s.sub_name,subt.st_name');
                $this->db->join('subject_allocation sa','sa.sa_id=st.sa_id');
                $this->db->join('subject s','s.sub_id=sa.sub_id');
                $this->db->join('sub_type subt','subt.st_id=s.st_id');
                $this->db->where('st.t_id',$teacher[0]['t_id']);
                $this->db->where(array('sa.ses_id'=>$session,'sa.sch_id'=>$school,'sa.med_id'=>$medium,'sa.class_id'=>$class,'sa.st_id'=>$sub_type,'sa.status'=>1));
                if(!empty($sub_group)){
                    $this->db->where('sa.sg_id',$sub_group);
                }
                $this->db->order_by('s.short_order','ASC');
                $result = $this->db->get_where('sub_teacher st',array('st.status'=>1))->result_array();
            }
        }
        
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'This class not allotted any subjecs.','status'=>500));
        }
    }
   
    public function getStudentsRecords(){
        $session = $this->session->userdata('session_id');
        $school = $this->session->userdata('school_id');
        $exam_type = $this->input->post('exam_type');
        $medium = $this->input->post('medium');
        $class_name = $this->input->post('class_name');
        $sub_group = $this->input->post('sub_group');
        $section = $this->input->post('section');
        $sub_type = $this->input->post('sub_type');
        $subject = $this->input->post('subject'); 
       
        $this->db->select('mm_id,status');
        $this->db->order_by('mm_id','DESC')->limit(1);
        if(!empty($sub_group)){
            $this->db->where('sg_id',$sub_group);
        }
        $mark_master = $this->db->get_where('marks_master',array('ses_id'=>$session,'sch_id'=>$school,'et_id' =>$exam_type,'med_id' =>$medium,'class_id'=>$class_name,'sec_id'=>$section,'st_id'=>$sub_type,'sub_id'=>$subject,'status'=> 1))->result_array(); 
        
        $mm_id = 'mm_id=0';
        if(count($mark_master) > 0){
           $mm_id = 'mm_id='.$mark_master[0]['mm_id'];
        }
        //--------------get studdet records with marks--------------------------------------
        $this->db->select('sd.std_id,sd.name,sd.adm_no,sd.roll_no,c.class_name, sec.section_name, IFNULL(sm.sub_marks,"") as sub_marks,IFNULL(sm.practical,"") as practical,IFNULL(sm.notebook,"") as notebook,IFNULL(sm.enrichment,"") as enrichment,IFNULL(sm.acadmic,"") as acadmic');
        $this->db->join('class c','c.c_id=sd.class_id');
        $this->db->join('section sec','sec.sec_id=sd.sec_id');
        $this->db->join('(SELECT * FROM student_marks WHERE '.$mm_id.') sm','sm.std_id=sd.std_id','LEFT');
        if(!empty($sub_group)){
           $this->db->where('sd.sub_group',$sub_group);
        }
        if($class_name >= 14 && $sub_type == 3){
            $this->db->where('sd.elective',$subject);
        }
        $this->db->group_by('sd.std_id');
        $students = $this->db->get_where('students sd',array('sd.ses_id'=>$session,'sd.sch_id'=>$school,'sd.medium'=>$medium,'sd.class_id'=>$class_name,'sd.sec_id'=>$section,'sd.status'=>1))->result_array();
        //print_r($this->db->last_query());die;
        
        //------------get max marks------------------------------------------------------
        $this->db->select('om.out_of as sub_marks,IFNULL(om.practical,"") as practical');
        $this->db->join('out_of_marks om','om.sa_id=sa.sa_id');
        if(!empty($sub_group)){
           $this->db->where('sa.sg_id',$sub_group);
        }
        $this->db->where('om.et_id',$exam_type);
        $max_marks = $this->db->get_where('subject_allocation sa',array('sa.ses_id'=>$session,'sa.sch_id'=>$school,'sa.med_id'=>$medium,'sa.class_id'=>$class_name,'sa.st_id'=>$sub_type,'sa.sub_id'=>$subject,'sa.status'=>1))->result_array();
       
        if(count($max_marks) < 1){
            echo json_encode(array('feedback'=>'This Class/Subject MAX marks not define.','status'=>500));
            die;
        }
        
        if(count($students)>0){
           echo json_encode(array('students'=>$students,'max_marks'=>$max_marks,'status'=>200));
        }else{
           echo json_encode(array('feedback'=>'Students not found..!','status'=>500));
        }
    }
    
    public function marksEntry(){
        $data['session'] = $this->session->userdata('session_id');
        $data['school'] = $this->session->userdata('school_id');
        $data['exam_type'] = $this->input->post('exam_type');
        $data['medium'] = $this->input->post('medium');
        $data['class'] = $this->input->post('class_name');
        if(!empty($this->input->post('sub_group'))){
            $data['sub_group'] = $this->input->post('sub_group');
        }else{
            $data['sub_group'] = '';
        }
        $data['section'] = $this->input->post('section');
        $data['sub_type'] = $this->input->post('sub_type');
        $data['subject'] = $this->input->post('subject');
        
        $std_id = $this->input->post('std_id');
        $roll_no = $this->input->post('roll_no');
        $adm_no = $this->input->post('adm_no');
        $sub_marks = $this->input->post('subject_marks');
        $practical = $this->input->post('practical_marks');
        $notebook = $this->input->post('notebook_marks');
        $enrichment = $this->input->post('enrichment_marks');
        $acadmic = $this->input->post('acadmic_marks');
        
        $final = array();
        foreach($std_id as $std_id_key => $std_id_val){
            foreach($roll_no as $roll_no_key => $roll_no_val){
                foreach($adm_no as $adm_no_key => $adm_no_val){
                    foreach($sub_marks as $std_marks_key => $std_marks_val){
                        if($std_id_key == $roll_no_key && $std_id_key == $adm_no_key && $std_id_key == $std_marks_key){
                            $temp = array();
                            $temp['std_id'] = $std_id_val;
                            $temp['roll_no'] = $roll_no_val;
                            $temp['adm_no'] = $adm_no_val;
                            $temp['sub_marks'] = $std_marks_val;
                            
                            if(count($practical) > 0){
                                foreach($practical as $practical_key => $practical_val){
                                    if($std_id_key == $practical_key){
                                        $temp['practical'] = $practical_val;
                                    }
                                }
                            }
                            
                            if(count($notebook) > 0){
                                foreach($notebook as $notebook_key => $notebook_val){
                                    if($std_id_key == $notebook_key){
                                        $temp['notebook'] = $notebook_val;
                                    }
                                }
                            }
                            if(count($enrichment) > 0){
                                foreach($enrichment as $enrichment_key => $enrichment_val){
                                    if($std_id_key == $enrichment_key){
                                        $temp['enrichment'] = $enrichment_val;
                                    }
                                }
                            }
                            if(count($acadmic) > 0){
                                foreach($acadmic as $acadmic_key => $acadmic_val){
                                    if($std_id_key == $acadmic_key){
                                        $temp['acadmic'] = $acadmic_val;
                                    }
                                }
                            }
                           
                            $final[] = $temp;//----------add all temp data in final array----------------
                        }//---end of first if condition
                    }
                }
            }
        }//--------------end of all foreach loops---------------------------
        
        $this->_ShowMsgs(
            $this->marks_entry_model->marks_entry($data,$final),"Marks Entry Successfully.","Falied Proccess Marks Entry, Please try again."
            );       
    }
    
    public function download_sample(){
        $data['session'] = $this->session->userdata('session_id');
        $data['school'] = $this->session->userdata('school_id');
        $data['medium'] = $this->input->post('medium');
        $data['class_name'] = $this->input->post('class_name');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['section'] = $this->input->post('section');
        
        $this->db->select('std_id,adm_no,roll_no');
        if(!empty($data['sub_group'])){
            $this->db->where('sub_group',$data['sub_group']);
        }
        $result = $this->db->get_where('students',array('ses_id'=>$data['session'],'sch_id'=>$data['school'],'medium'=>$data['medium'],'class_id'=>$data['class_name'],'sec_id'=>$data['section'],'status'=>1))->result_array();
        
        //-------------generate csv file------------------------
        $phpExcel = new PHPExcel();
        $prestasi = $phpExcel->setActiveSheetIndex(0);
        
        //----------put index name-------------------
        $prestasi->setCellValue('A1', 'std_id');
        $prestasi->setCellValue('B1', 'adm_no');
        $prestasi->setCellValue('C1', 'roll_no');
        $prestasi->setCellValue('D1', 'sub_marks');
        $prestasi->setCellValue('E1', 'practical');
        $prestasi->setCellValue('F1', 'notebook');
        $prestasi->setCellValue('G1', 'enrichment');
        $prestasi->setCellValue('H1', 'acadmic');
        
        //---------------------put data in excel----------------------------
        $no=0;
        $rowexcel = 1;
        foreach($result as $row){
            $no++;
            $rowexcel++;
            $prestasi->setCellValue('A'.$rowexcel, $row["std_id"]);
            $prestasi->setCellValue('B'.$rowexcel, $row["adm_no"]);
            $prestasi->setCellValue('C'.$rowexcel,  $row["roll_no"]);
        }
        
        $date =date('U');
        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        
        if(!is_dir('./assets/sample_data/marks_entry')){
            mkdir('./assets/sample_data/marks_entry');
        }
        $sg_name= '';
        if(!empty($data['sub_group'])){
            $sg_name= '_Group_'.$data['sub_group'];
        }
        $filename = "assets/sample_data/marks_entry/Class".$data['class_name']."_Sec_".$data['section']."_".$sg_name.".xlsx";
        //----------save excel file----------------------------
        $objWriter->save($filename);
        //-----------------------------------------------------
        if($filename){
            echo json_encode(array('file_path'=>$filename,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'something wrong.','status'=>500));
        }    
    }
    
    public function marks_csv_import(){
        $data['session'] = $this->session->userdata('session_id');
        $data['school'] = $this->session->userdata('school_id');
        $data['exam_type'] = $this->input->post('exam_type');
        $data['medium'] = $this->input->post('medium');
        $data['class'] = $this->input->post('class_name');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['section'] = $this->input->post('section');
        $data['sub_type'] = $this->input->post('sub_type');
        $data['subject'] = $this->input->post('subject');
        
        $result = $this->marks_entry_model->marks_csv_import($data);
        if($result){
            echo json_encode(array('feedback'=>'Import Successfully.','status'=>200));
        }else{
            echo json_encode(array('feedback'=>'Something Wrong.','status'=>500));
        }
    }
    
}