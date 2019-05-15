<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Production_ctrl extends CI_Controller{
    public function __construct(){
        parent :: __construct();
        $this->load->model('production_model');
        $this->load->model(array('Mid_marksheet_model','Final_marksheet_model'));
    }
    
    public function marks_entry_check(){
        $data['session'] = $this->session->userdata('session_id');
        $data['school'] = $this->session->userdata('school_id');
        $data['exam_type'] = $this->input->post('exam_type');
        $data['medium'] = $this->input->post('medium');
        $data['class'] = $this->input->post('class');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['section'] = $this->input->post('section');
        
        $result = $this->production_model->marks_entry_check($data);
        
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'something getting worong.','status'=>500));
        }
    }
    
    public function export_excel(){
        $data['session'] = $this->session->userdata('session_id');
        $data['school'] = $this->session->userdata('school_id');
        $data['exam_type'] = $this->input->post('exam_type');
        $data['medium'] = $this->input->post('medium');
        $data['class_name'] = $this->input->post('class_name');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['section'] = $this->input->post('section');
        
        $result = $this->production_model->export_excel($data);
        if($result){
            echo json_encode(array('file_path'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'something wrong.','status'=>500));
        }
    }
    
    
    public function furd_report(){
        $data['session'] = $this->session->userdata('session_id');
        $data['school'] = $this->session->userdata('school_id');
        $data['exam_type'] = $this->input->post('exam_type');
        $data['medium'] = $this->input->post('medium');
        $data['class'] = $this->input->post('class');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['section'] = $this->input->post('section');
        $furd_report = $this->production_model->students_report($data);
        
        if(empty($furd_report)){
            echo json_encode(array('feedback'=>'Please check Entry','status'=>500));
            die;
        }
        
        $subjects = $furd_report['subjects'];
        $student_data = $furd_report['furd'];
        $division = $furd_report['division'];
        
        //----------class 9th and 10th--------------------------------
        if($data['class'] == 12 && $data['exam_type'] == 2 || $data['class'] == 12 && $data['exam_type'] == 4 || $data['class'] == 13 && $data['exam_type'] == 2 || $data['class'] == 13 && $data['exam_type'] == 4){ // 12 is 9th and 13 is 10th for FIT/Computer application subjects
            if($data['exam_type'] == 2){
                $mid_extra_result = $this->Mid_marksheet_model->midExtra($data);
            }else{
                $mid_extra_result = $this->Final_marksheet_model->finalExtra($data);
            }
            
            $extra_sub = array();
            foreach($mid_extra_result['subjects'] as $subject){
                $temp = array();
                $temp['sa_id'] = $subject['sa_id'];
                $temp['sub_id'] = $subject['sub_id'];
                $temp['sub_name'] = $subject['sub_name'];
                $temp['teacher_name'] = $subject['teacher_name'];
                $temp['out_of'] = $subject['out_of'];
                $temp['notappear'] = $subject['notappear'];
                $extra_sub[] = $temp;
            }
            $subjects =  array_merge($subjects,$extra_sub);
            
            $student_data = array();
            foreach($furd_report['furd'] as $std_record){
                foreach($mid_extra_result['extra_sub'] as $extra_sub){
                    if($std_record['adm_no'] == $extra_sub['adm_no']){
                        foreach ($mid_extra_result['subjects'] as $subject){
                            $std_record[$subject['sub_name']] = $extra_sub[$subject['sub_name']];
                        }
                    }
                }
                $student_data[] = $std_record;
            }
        }
        
       //--------------class abstract---------------------------------
        $class_abstract = array();
        foreach($subjects as $subject){
            $total_std = 0;
            $pass = 0;
            $fail = 0;
            $first_div = 0;
            $secord_div = 0;
            $third_div = 0;
            $max_marks_get = 0;
            $max_marks_std = 0;
            $total_marks = 0;
            
            foreach($student_data as $furd){
                
                $total_std = $total_std+1;
                $sub_marks = $furd[$subject['sub_name']];
                $total_marks += (int)$sub_marks;
                $sub_marks_per = ((int)($sub_marks) * 100)/$subject['out_of'];
                
                
                if($max_marks_get < $sub_marks && $sub_marks != 'A'){
                    $max_marks_get = $sub_marks;
                    $max_marks_std = 1;
                }elseif($max_marks_get == $sub_marks && $sub_marks != 'A'){
                    $max_marks_std = $max_marks_std+1;
                }
                
                //----------greter then 32-----------------------------------
                if($sub_marks_per > $division[3]['max_no']){
                    $pass = $pass+1;
                    //------------grether then 59---------------------------
                    if($sub_marks_per > $division[1]['max_no']){
                        $first_div = $first_div+1;
                      //----------less greter then 44 and less then 60--------------------
                    }elseif($sub_marks_per > $division[2]['max_no'] && $sub_marks_per < $division[0]['min_no']){
                        $secord_div = $secord_div+1;
                    }
                    //---------- greter then 32 and less then 45-------------------- 
                    elseif($sub_marks_per > $division[3]['max_no'] && $sub_marks_per < $division[1]['min_no']){
                        $third_div = $third_div+1;
                    }
                    //--------------less then 33----------------------------------
                }elseif($sub_marks_per < $division[2]['min_no']){ 
                        $fail = $fail+1;
                    }
            } //----------end of second loop------------------
                $temp = array();
                $temp['teacher_name'] = $subject['teacher_name'];
                $temp['sub_name'] = $subject['sub_name'];
                $temp['total_student'] = $total_std;
                
                $temp['total_appear'] = $total_std- $subject['notappear'];
                $temp['total_pass'] = $pass;
                $temp['pass_percent'] = round(($pass * 100)/($total_std - $subject['notappear']) );//--pass in percentage--
                $temp['first_div'] = $first_div;
                if($pass > 0){
                    $temp['first_percent'] = round(($first_div * 100)/$pass);	////--first div in percentage--
                }else{
                    $temp['first_percent'] = 0;
                }
                $temp['second_div'] = $secord_div;
                $temp['third_div'] = $third_div;
                $temp['fail'] = $fail;
                $temp['out_of'] = $subject['out_of'];
                $temp['notapper'] = $subject['notappear'];
                $temp['max_marks'] = $max_marks_get;
                $temp['max_marks_std'] = $max_marks_std;
                $temp['pi'] = round(($total_marks / (($total_std - $subject['notappear']) * $subject['out_of']))*100,2);
                $class_abstract[] = $temp;
                $result['class_abstract'] = $class_abstract;    
                
        }
        $result['subjects'] = $subjects;
        $result['furd'] = $student_data;
        $result['org_details'] = $this->production_model->org_details($data);
        
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
        
    }
    
    //-----------------------------teacher abstract ------------------------------------------------
    public function getTeachers() {
        $medium = $this->input->post('medium');
        
        $this->db->select('t.t_id,t.teacher_name');
        $this->db->join('subject_allocation sa','sa.sa_id=st.sa_id');
        $this->db->join('teacher t','t.t_id=st.t_id');
        $this->db->where('sa.med_id',$medium);
        $this->db->where('sa.st_id IN (1,3,4)');
        $this->db->group_by('t.t_id');
        $result = $this->db->get_where('sub_teacher st',array('st.status'=>1))->result_array();
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    
    public function TeacherAbstract(){
        $data['session'] = $this->session->userdata('session_id');
        $data['school'] = $this->session->userdata('school_id');
        $data['exam_type'] = $this->input->post('exam_type');
        $data['medium'] = $this->input->post('medium');
        $data['teacher'] = $this->input->post('teacher');
        
        $result = $this->production_model->TeacherAbstract($data);
        if(count($result)>0){
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'record not found.','status'=>500));
        }
    }
    //------------------------****************---------------------------------------------------
    
    public function midMarksheetGenerate(){
        $data['session'] = $this->input->post('session');
        $data['school'] = $this->session->userdata('school_id');
        
        $data['medium'] = $this->input->post('medium');
        $data['class'] = $this->input->post('class_name');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['section'] = $this->input->post('section');
        $data['std_id'] = $this->input->post('std_id');
        
        $pre_result = $this->Mid_marksheet_model->preResult($data);
        $mid_result = $this->Mid_marksheet_model->midResult($data);
        
        $co_scholistic = $this->Mid_marksheet_model->midCoScholistic($data);
        //---------9th,10th FOIT or Computer application--------------------
        if($data['class'] == 12 || $data['class'] == 13){
            $mid_extra_result = $this->Mid_marksheet_model->midExtra($data);
            $result['extra_sub'] = $mid_extra_result['subjects'];
        } 
        //--------------get scholistic and co-scholistic subjects-----------
           $result['pre_sub'] = $pre_result['subjects'];    
           $result['mid_sub'] = $mid_result['subjects'];
           $result['co_scholistic_sub'] = $co_scholistic['subjects'];     
        
        $final = array();
        foreach($pre_result['pre'] as $pre){
            foreach ($mid_result['mid'] as $mid){
                foreach($co_scholistic['co_scholistc'] as $co_scholistc){
                    if($pre['adm_no'] == $mid['adm_no'] && $pre['adm_no'] == $co_scholistc['adm_no']){
                        $temp = array();
                        $temp['elective_id'] = $pre['elective'];
                        $temp['std_id'] = $pre['std_id'];
                        $temp['adm_no'] = $pre['adm_no'];
                        $temp['roll_no'] = $pre['roll_no'];
                        $temp['name'] = ucwords($pre['name']);
                        $temp['class_name'] = $pre['class_name'];
                        $temp['section_name'] = $pre['section_name'];
                        $temp['dob'] = $pre['dob'];
                        $temp['m_name'] = ucwords($pre['m_name']);
                        $temp['f_name'] = ucwords($pre['f_name']);
                        $temp['contact_no'] = $pre['contact_no'];
                        $temp['aadhar_no'] = $pre['aadhar_no'];
                        $temp['address'] = ucwords($pre['address']);
                        $temp['photo'] = $pre['photo'];
                        
                        //----get pre and mid subjects marks in temp--------------
                        foreach($result['mid_sub'] as $subject){
                            if($subject['st_id'] = 1){
                                $temp['pre_'.$subject['sub_name']] = $pre[$subject['sub_name']];
                                $temp['mid_'.$subject['sub_name']] = $mid[$subject['sub_name']];
                                $temp[$subject['sub_name'].'_notebook'] = $mid[$subject['sub_name'].'_notebook'];
                                $temp[$subject['sub_name'].'_enrichment'] = $mid[$subject['sub_name'].'_enrichment'];
                            }else if($subject['st_id'] = 3 && $subject['st_id'] == $pre['elective']){
                                $temp['pre_'.$subject['sub_name']] = $pre[$subject['sub_name']];
                                $temp['mid_'.$subject['sub_name']] = $mid[$subject['sub_name']];
                                $temp[$subject['sub_name'].'_notebook'] = $mid[$subject['sub_name'].'_notebook'];
                                $temp[$subject['sub_name'].'_enrichment'] = $mid[$subject['sub_name'].'_enrichment'];
                            }
                            
                            if($data['class'] > 13){
                                $temp[$subject['sub_name'].'_practical'] = $mid[$subject['sub_name'].'_practical'];
                            }
                        }
                        
                        //-----------get co-scholistic subject in temp------------------
                        foreach($co_scholistic['subjects'] as $co_sch_sub){
                            $temp[$co_sch_sub['sub_name']] = $co_scholistc[$co_sch_sub['sub_name']];
                        }
                       
                        //------------get attendance in temp------------------
                        if($mid_result['attendance']){
                            foreach($mid_result['attendance'] as $attendance){
                                if($pre['adm_no'] == $attendance['adm_no']){
                                    $temp['total_days'] = $attendance['total_days'];
                                    $temp['present_days'] = $attendance['present_days'];
                                }
                            }
                        }
                        
                        //------------get extra subject in temp------------------
                        if(!empty($mid_extra_result['extra_sub'])){
                            foreach($mid_extra_result['extra_sub'] as $extra_sub){
                                if($pre['adm_no'] == $extra_sub['adm_no']){
                                    foreach($mid_extra_result['subjects'] as $mid_extra_sub){
                                        $temp[$mid_extra_sub['sub_name']] = $extra_sub[$mid_extra_sub['sub_name']];
                                        $temp['grade_'.$mid_extra_sub['sub_name']] = $extra_sub['grade_'.$mid_extra_sub['sub_name']];
                                    }
                                }
                            }
                        }
                        $final[] = $temp;
                        $result['final'] =$final;
                    }
                }
            }
        }
        
        $result['org_details'] = $this->production_model->org_details($data);
        
        if(count($result) > 0){
           // print_r($result);die;
            echo json_encode(array('result'=>$result,'status'=>200));
        }else{
            echo json_encode(array('feedback'=>'something getting wrong.','status'=>500));
        }
    }
     
    function finalMarkSheetGenerate(){
        $data['session'] = $this->input->post('session');
        $data['school'] = $this->session->userdata('school_id');
        
        $data['medium'] = $this->input->post('medium');
        $data['class'] = $this->input->post('class_name');
        $data['sub_group'] = $this->input->post('sub_group');
        $data['section'] = $this->input->post('section');
        $data['std_id'] = $this->input->post('std_id');
        
        //----------pre mid result-----------------------------------------
        $pre_result = $this->Mid_marksheet_model->preResult($data);
        $mid_result = $this->Mid_marksheet_model->midResult($data);
        $mid_co_scholistic = $this->Mid_marksheet_model->midCoScholistic($data);
        //-----------post final result---------------------------------------
        $post_result = $this->Final_marksheet_model->postResult($data);
        $final_result = $this->Final_marksheet_model->finalResult($data);
        $final_co_scholistic = $this->Final_marksheet_model->finalCoScholistic($data);
        print_r($final_co_scholistic);die;
        //---------9th,10th FOIT or Computer application--------------------
        if($data['class'] == 12 || $data['class'] == 13){
            $mid_extra = $this->Mid_marksheet_model->midExtra($data);
            $final_extra = $this->Final_marksheet_model->finalExtra($data);
            $extra_sub = $mid_extra['subjects'];
        }
        
        //--------------get scholistic and co-scholistic subjects-----------
        $result['pre_sub'] = $pre_result['subjects'];
        $result['mid_sub'] = $mid_result['subjects'];
        $result['co_scholistic_sub'] = $mid_co_scholistic['subjects']; 
        
        
        
        
    }
}