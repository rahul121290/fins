<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Final_marksheet_model extends CI_Model{
    public function postResult($data){
        $session = $data['session'];
        $school = $data['school'];
        $exam_type = 3;//-----------3 is exam type post mid
        $medium = $data['medium'];
        $class_name = $data['class'];
        $sub_group = $data['sub_group'];
        $section = $data['section'];
        
        $sub_allocation = '';
        $marks_master = ' AND mm.status=1';
        
        if($session){
            $sub_allocation.=' AND sa.ses_id='.$session;
            $marks_master.=' AND mm.ses_id='.$session;
        }
        if($school){
            $sub_allocation.=' AND sa.sch_id='.$school;
            $marks_master.=' AND mm.sch_id='.$school;
        }
        if($medium){
            $sub_allocation.=' AND sa.med_id='.$medium;
            $marks_master.=' AND mm.med_id='.$medium;
        }
        if($class_name){
            $sub_allocation.=' AND sa.class_id='.$class_name;
            $marks_master.=' AND mm.class_id='.$class_name;
        }
        if($sub_group){
            $sub_allocation.=' AND sa.sg_id='.$sub_group;
            $marks_master.=' AND mm.sg_id='.$sub_group;
            $marks_master.=' AND mm.st_id IN(1,3)';
        }else{
            $marks_master.=' AND mm.st_id IN(1)';
        }
        if($section){
            //$sub_allocation.=' AND sa.sec_id='.$section;
            $marks_master.=' AND mm.sec_id='.$section;
        }
        if($exam_type){
            $sub_allocation.=' AND om.et_id='.$exam_type;
            $marks_master.=' AND mm.et_id='.$exam_type;
        }
        //-----------------------------------***********----------------------------------------------------------------
        $this->db->select('s.st_id,sa.sa_id,sa.sub_id,s.sub_name,t1.teacher_name,om.out_of,IFNULL(np.notappear,"0") as notappear');
        if(!empty($sub_group)){
            $this->db->where('sa.sg_id',$sub_group);
            $this->db->where('sa.st_id IN(1,3)');
        }else{
            $this->db->where('sa.st_id',1);
        }
        $this->db->join('subject s','s.sub_id=sa.sub_id');
        $this->db->join('sub_teacher st','st.sa_id=sa.sa_id','LEFT');
        $this->db->join('teacher t1','t1.t_id=st.t_id','LEFT');
        $this->db->join('out_of_marks om','om.sa_id=sa.sa_id');
        $this->db->join('(SELECT mm.sub_id, COUNT(sub_marks) as notappear FROM student_marks sm JOIN marks_master mm ON mm.mm_id= sm.mm_id WHERE sm.sub_marks = "A" '.$marks_master.') np','np.sub_id=sa.sub_id','LEFT');
        $this->db->where('1=1'.$sub_allocation);
        $this->db->order_by('s.short_order','ASC');
        $result['subjects'] = $this->db->get_where('subject_allocation sa')->result_array();
        
        //-----------------------------------***********----------------------------------------------------------------
        $con_sg_st = '';
        $out_of_mark= '';
        
        if(!empty($sub_group)){
            $con_sg_st .=' AND mm.sg_id='.$sub_group;
            $con_sg_st .=' AND mm.st_id IN(1,3)'; //-----------if get 11th and 12th furd then count elective subject---1 is scholostic and 3 is elective---------
            $out_of_mark .=' AND sg_id='.$sub_group;
            $out_of_mark .=' AND st_id IN(1,3)';
        }else{
            $con_sg_st .=' AND mm.st_id IN(1)'; //-------------select only scholistic subjects-------------------------
            $out_of_mark .=' AND st_id IN(1)';
        }
        $con_sg_st.=' AND mm.ses_id='.$session;
        $con_sg_st.=' AND mm.sch_id='.$school;
        $con_sg_st.=' AND mm.med_id='.$medium;
        $con_sg_st.=' AND mm.class_id='.$class_name;
        $con_sg_st.=' AND mm.sec_id='.$section;
        $con_sg_st.=' AND mm.status=1';
        
        $out_of_mark.=' AND ses_id='.$session;
        $out_of_mark.=' AND sch_id='.$school;
        $out_of_mark.=' AND med_id='.$medium;
        $out_of_mark.=' AND class_id='.$class_name;
        // $out_of_mark.=' AND sec_id='.$section;
        $out_of_mark.=' AND status=1';
        
        $this->db->select('out_of');
        $this->db->where('sa_id IN(SELECT sa_id FROM subject_allocation WHERE 1=1'.$out_of_mark.')');
        $out_of_marks = $this->db->get_where('out_of_marks',array('et_id'=>$exam_type,'status'=>1))->result_array();
        $outOfMarks = $out_of_marks[0]['out_of'];
        
        if($class_name < 14){
            $outOfPre = 10;
        }else{
            $outOfPre = 5;
        }
        
        if(count($result['subjects'])>0){
            $condition = '';
            foreach($result['subjects'] as $subject){
                $condition.="MAX(IF(sub.sub_id ='".$subject['sub_id']."',t1.sub_marks, '')) as '". $subject['sub_name']."'," ;
            }
            $this->db->select('s.elective,s.std_id,s.adm_no,s.roll_no,s.name,c.class_name,sec.section_name,DATE_FORMAT(dob, "%d-%m-%Y") as dob,m_name,f_name,contact_no,aadhar_no,address,photo,'.$condition);
            $this->db->join('(SELECT sm.*,mm.sub_id FROM student_marks sm JOIN marks_master mm ON mm.mm_id=sm.mm_id  WHERE mm.et_id='.$exam_type.$con_sg_st.') t1','t1.std_id=s.std_id','LEFT');
            $this->db->join('subject sub','sub.sub_id=t1.sub_id','LEFT');
            $this->db->join('class c','c.c_id=s.class_id');
            $this->db->join('section sec','sec.sec_id=s.sec_id');
            $this->db->group_by('s.std_id');
            $this->db->order_by('s.adm_no','ASC');
            if(!empty($sub_group)){
                $this->db->where('s.sub_group',$sub_group);
            }
            if(!empty($data['std_id'])){
                $this->db->where('s.std_id',$data['std_id']);
            }
            $result['pre'] = $this->db->get_where('students s',array('s.ses_id'=>$session,'s.sch_id'=>$school,'s.medium'=>$medium,'s.class_id'=>$class_name,'s.sec_id'=>$section,'s.status'=>1))->result_array();
            return $result;
        }
        
    }
    
    public function finalResult($data){
        
            $session = $data['session'];
            $school = $data['school'];
            $exam_type = 4;//-----------4 is exam type final
            $medium = $data['medium'];
            $class_name = $data['class'];
            $sub_group = $data['sub_group'];
            $section = $data['section'];
            
            $sub_allocation = '';
            $con_att = ' AND am.status=1';
            if($session){
                $sub_allocation.=' AND sa.ses_id='.$session;
                $con_att .= ' AND am.ses_id='.$session;
            }
            if($school){
                $sub_allocation.=' AND sa.sch_id='.$school;
                $con_att.=' AND am.sch_id='.$school;
            }
            if($medium){
                $sub_allocation.=' AND sa.med_id='.$medium;
                $con_att.=' AND am.med_id='.$medium;
            }
            if($class_name){
                $sub_allocation.=' AND sa.class_id='.$class_name;
                $con_att.=' AND am.class_id='.$class_name;
            }
            if($sub_group){
                $sub_allocation.=' AND sa.sg_id='.$sub_group;
                $con_att.=' AND am.sg_id='.$sub_group;
                $sub_allocation.= ' AND sa.st_id IN(1,3)';
            }else{
                $sub_allocation.= ' AND sa.st_id IN(1)';
            }
            //         if($section){
            //             $sub_allocation.=' AND sa.sec_id='.$section;
            //         }
            if($exam_type){
                $con_att.=' AND am.et_id='.$exam_type;
            }
            //-----------------------------------------attendance------------------------------------------------
            $this->db->select('sa.std_id,sa.adm_no,sa.roll_no,am.total_days,sa.present_days,sa.absent_days');
            $this->db->join('attendance_master am','am.am_id=sa.am_id');
            $this->db->where('1=1'.$con_att);
            $result['attendance'] = $this->db->get_where('std_attendance sa',array('sa.status'=>1))->result_array();
            
            //-------------------------------****************************------------------------------------------
            $this->db->select('sa.sa_id,sa.sub_id,s.sub_name,s.st_id,om.out_of');
            $this->db->join('subject s','s.sub_id=sa.sub_id');
            $this->db->join('out_of_marks om','om.sa_id=sa.sa_id');
            $this->db->where('1=1'.$sub_allocation);
            $this->db->order_by('sa.st_id','ASC');
            $this->db->order_by('s.short_order','ASC');
            $result['subjects'] = $this->db->get_where('subject_allocation sa',array('sa.status'=>1,'om.et_id'=>$exam_type))->result_array();
            
            //-----------------------------------***********----------------------------------------------------------------
            $con_sg_st = '';
            if(!empty($sub_group)){
                $con_sg_st .=' AND mm.sg_id='.$sub_group;
                $con_sg_st .=' AND mm.st_id IN(1,3)'; //-----------if get 11th and 12th furd then count elective subject--------1 is scholostic and 3 is elective-----------
            }else{
                $con_sg_st .=' AND mm.st_id IN(1)'; //-------------select only scholistic subjects-------------------------
            }
            $con_sg_st.=' AND mm.ses_id='.$session;
            $con_sg_st.=' AND mm.sch_id='.$school;
            $con_sg_st.=' AND mm.med_id='.$medium;
            $con_sg_st.=' AND mm.class_id='.$class_name;
            $con_sg_st.=' AND mm.sec_id='.$section;
            $con_sg_st.=' AND mm.status=1';
            
            if(count($result['subjects'])>0){
                $condition = '';
                foreach($result['subjects'] as $subject){
                    $condition.="MAX(IF(sub.sub_id ='".$subject['sub_id']."', t1.sub_marks, '')) as '". $subject['sub_name']."'," ;
                    $condition.="MAX(IF(sub.sub_id ='".$subject['sub_id']."', t1.notebook, '')) as '". $subject['sub_name'].'_notebook'."'," ;
                    $condition.="MAX(IF(sub.sub_id ='".$subject['sub_id']."', t1.enrichment, '')) as '". $subject['sub_name'].'_enrichment'."'," ;
                    if($class_name > 13){
                        $condition.="MAX(IF(sub.sub_id ='".$subject['sub_id']."', t1.practical, '')) as '". $subject['sub_name'].'_practical'."'," ;
                    }
                }
                
                $this->db->select('s.elective,s.std_id,s.adm_no,s.roll_no,'.$condition);
                $this->db->join('(SELECT sm.*,mm.sub_id FROM student_marks sm JOIN marks_master mm ON mm.mm_id=sm.mm_id  WHERE mm.et_id='.$exam_type.$con_sg_st.') t1','t1.std_id=s.std_id','LEFT');
                $this->db->join('subject sub','sub.sub_id=t1.sub_id','LEFT');
                $this->db->group_by('s.std_id');
                $this->db->order_by('s.adm_no','ASC');
                if(!empty($sub_group)){
                    $this->db->where('s.sub_group',$sub_group);
                }
                if(!empty($data['std_id'])){
                    $this->db->where('s.std_id',$data['std_id']);
                }
                $result['mid'] = $this->db->get_where('students s',array('s.ses_id'=>$session,'s.sch_id'=>$school,'s.medium'=>$medium,'s.class_id'=>$class_name,'s.sec_id'=>$section,'s.status'=>1))->result_array();
                //print_r($this->db->last_query());die;
                
                return $result;
            }
        }
    
    public function finalCoScholistic($data){
        $session = $data['session'];
        $school = $data['school'];
        $exam_type = 4;//-----------4 is exam type Final
        $medium = $data['medium'];
        $class_name = $data['class'];
        $sub_group = $data['sub_group'];
        $section = $data['section'];
        
        $sub_allocation = '';
        if($session){
            $sub_allocation.=' AND sa.ses_id='.$session;
        }
        if($school){
            $sub_allocation.=' AND sa.sch_id='.$school;
        }
        if($medium){
            $sub_allocation.=' AND sa.med_id='.$medium;
        }
        if($class_name){
            $sub_allocation.=' AND sa.class_id='.$class_name;
        }
        if($sub_group){
            $sub_allocation.=' AND sa.sg_id='.$sub_group;
            $sub_allocation.= ' AND sa.st_id IN(2)';
        }else{
            $sub_allocation.= ' AND sa.st_id IN(2)';
        }
        //         if($section){
        //             $sub_allocation.=' AND sa.sec_id='.$section;
        //         }
        
        $this->db->select('sa.sa_id,sa.sub_id,s.sub_name');
        $this->db->join('subject s','s.sub_id=sa.sub_id');
        $this->db->where('1=1'.$sub_allocation);
        $this->db->order_by('sa.st_id','ASC');
        $this->db->order_by('s.short_order','ASC');
        $result['subjects'] = $this->db->get_where('subject_allocation sa')->result_array();
        
        //-----------------------------------***********----------------------------------------------------------------
        $con_sg_st = '';
        if(!empty($sub_group)){
            $con_sg_st .=' AND mm.sg_id='.$sub_group;
            $con_sg_st .=' AND mm.st_id IN(2)'; //-----------co-scholistic subject group-----------
        }else{
            $con_sg_st .=' AND mm.st_id IN(2)'; //-----------co-scholistic subject group-----------
        }
        $con_sg_st.=' AND mm.ses_id='.$session;
        $con_sg_st.=' AND mm.sch_id='.$school;
        $con_sg_st.=' AND mm.med_id='.$medium;
        $con_sg_st.=' AND mm.class_id='.$class_name;
        $con_sg_st.=' AND mm.sec_id='.$section;
        $con_sg_st.=' AND mm.status=1';
        
        if(count($result['subjects'])>0){
            $condition = '';
            if($class_name < 12){ //--------less then class 9th----------
                foreach($result['subjects'] as $subject){
                    $condition.="MAX(IF(sub.sub_id ='".$subject['sub_id']."',(CASE WHEN (t1.sub_marks) = 3 THEN 'A'
                                                                               WHEN (t1.sub_marks) = 2 THEN 'B'
                                                                               WHEN (t1.sub_marks) = 1 THEN 'C'
                                                                               WHEN (t1.sub_marks) = 'A' THEN '-' END), '-')) as '". $subject['sub_name']."'," ;
                }
            }else if($class_name > 11){//----greter then class 8th--------
                foreach($result['subjects'] as $subject){
                    $condition.="MAX(IF(sub.sub_id ='".$subject['sub_id']."',(CASE WHEN (t1.sub_marks) = 5 THEN 'A'
                                                                               WHEN (t1.sub_marks) = 4 THEN 'B'
                                                                               WHEN (t1.sub_marks) = 3 THEN 'C'
                                                                               WHEN (t1.sub_marks) = 2 THEN 'D'
                                                                               WHEN (t1.sub_marks) = 1 THEN 'E'
                                                                               WHEN (t1.sub_marks) = 'A' THEN '-' END), '-')) as '". $subject['sub_name']."'," ;
                }
            }
            
            $this->db->select('s.std_id,s.adm_no,s.roll_no,'.$condition);
            $this->db->join('(SELECT sm.*,mm.sub_id FROM student_marks sm JOIN marks_master mm ON mm.mm_id=sm.mm_id  WHERE mm.et_id='.$exam_type.$con_sg_st.') t1','t1.std_id=s.std_id','LEFT');
            $this->db->join('subject sub','sub.sub_id=t1.sub_id','LEFT');
            $this->db->group_by('s.std_id');
            $this->db->order_by('s.adm_no','ASC');
            if(!empty($sub_group)){
                $this->db->where('s.sub_group',$sub_group);
            }
            if(!empty($data['std_id'])){
                $this->db->where('s.std_id',$data['std_id']);
            }
            $result['co_scholistc'] = $this->db->get_where('students s',array('s.ses_id'=>$session,'s.sch_id'=>$school,'s.medium'=>$medium,'s.class_id'=>$class_name,'s.sec_id'=>$section,'s.status'=>1))->result_array();
            //print_r($this->db->last_query());die;
            return $result;
        }
    }
        
    
    public function finalExtra($data){
            $session = $data['session'];
            $school = $data['school'];
            $exam_type = 4;//-----------1 is exam type pre
            $medium = $data['medium'];
            $class_name = $data['class'];
            $sub_group = $data['sub_group'];
            $section = $data['section'];
            
            $sub_allocation = '';
            $marks_master = ' AND mm.status=1';
            
            if($session){
                $sub_allocation.=' AND sa.ses_id='.$session;
                $marks_master.=' AND mm.ses_id='.$session;
            }
            if($school){
                $sub_allocation.=' AND sa.sch_id='.$school;
                $marks_master.=' AND mm.sch_id='.$school;
            }
            if($medium){
                $sub_allocation.=' AND sa.med_id='.$medium;
                $marks_master.=' AND mm.med_id='.$medium;
            }
            if($class_name){
                $sub_allocation.=' AND sa.class_id='.$class_name;
                $marks_master.=' AND mm.class_id='.$class_name;
            }
            if($sub_group){
                $sub_allocation.=' AND sa.sg_id='.$sub_group;
                $marks_master.=' AND mm.sg_id='.$sub_group;
                $marks_master.=' AND mm.st_id IN(4)';
            }else{
                $marks_master.=' AND mm.st_id IN(4)';
            }
            if($section){
                //$sub_allocation.=' AND sa.sec_id='.$section;
                $marks_master.=' AND mm.sec_id='.$section;
            }
            if($exam_type){
                $sub_allocation.=' AND om.et_id='.$exam_type;
                $marks_master.=' AND mm.et_id='.$exam_type;
                
            }
            
            //-----------------------------------***********----------------------------------------------------------------
            $this->db->select('sa.sa_id,sa.sub_id,s.sub_name,t1.teacher_name,om.out_of,IFNULL(np.notappear,"0") as notappear');
            if(!empty($sub_group)){
                $this->db->where('sa.sg_id',$sub_group);
                $this->db->where('sa.st_id IN(4)');
            }else{
                $this->db->where('sa.st_id IN(4)');
            }
            $this->db->join('subject s','s.sub_id=sa.sub_id');
            $this->db->join('sub_teacher st','st.sa_id=sa.sa_id');
            $this->db->join('teacher t1','t1.t_id=st.t_id');
            $this->db->join('out_of_marks om','om.sa_id=sa.sa_id');
            $this->db->join('(SELECT mm.sub_id, COUNT(sub_marks) as notappear FROM student_marks sm JOIN marks_master mm ON mm.mm_id= sm.mm_id WHERE sm.sub_marks = "A" '.$marks_master.') np','np.sub_id=sa.sub_id','LEFT');
            $this->db->where('1=1'.$sub_allocation);
            $this->db->order_by('s.short_order','ASC');
            $result['subjects'] = $this->db->get_where('subject_allocation sa')->result_array();
            
            $out_of = $result['subjects'][0]['out_of'];
            
            //-----------------------------------***********----------------------------------------------------------------
            $con_sg_st = '';
            if(!empty($sub_group)){
                $con_sg_st .=' AND mm.sg_id='.$sub_group;
                $con_sg_st .=' AND mm.st_id IN(4)'; //-----------co-scholistic subject group-----------
            }else{
                $con_sg_st .=' AND mm.st_id IN(4)'; //-----------co-scholistic subject group-----------
            }
            $con_sg_st.=' AND mm.ses_id='.$session;
            $con_sg_st.=' AND mm.sch_id='.$school;
            $con_sg_st.=' AND mm.med_id='.$medium;
            $con_sg_st.=' AND mm.class_id='.$class_name;
            $con_sg_st.=' AND mm.sec_id='.$section;
            $con_sg_st.=' AND mm.status=1';
            
            $this->db->select('grade');
            $this->db->order_by('g_id','ASC');
            $grade = $this->db->get_where('grade',array('ses_id'=>$session,'sch_id'=>$school,'med_id'=>$medium))->result_array();
            
            if(count($result['subjects'])>0){
                $condition = '';
                foreach($result['subjects'] as $subject){
                    $condition.="t1.sub_marks as ".$subject['sub_name'].", MAX(IF(sub.sub_id ='".$subject['sub_id']."',CASE
                                    WHEN (((t1.sub_marks)/'$out_of')*100) > 90 THEN '".$grade[0]['grade']."'
                                    WHEN (((t1.sub_marks)/'$out_of')*100) > 80 THEN '".$grade[1]['grade']."'
                                    WHEN (((t1.sub_marks)/'$out_of')*100) > 70 THEN '".$grade[2]['grade']."'
                                    WHEN (((t1.sub_marks)/'$out_of')*100) > 60 THEN '".$grade[3]['grade']."'
                                    WHEN (((t1.sub_marks)/'$out_of')*100) > 50 THEN '".$grade[4]['grade']."'
                                    WHEN (((t1.sub_marks)/'$out_of')*100) > 40 THEN '".$grade[4]['grade']."'
                                    WHEN (((t1.sub_marks)/'$out_of')*100) > 32 THEN '".$grade[6]['grade']."'
                                    WHEN (((t1.sub_marks)/'$out_of')*100) > 0 THEN '".$grade[7]['grade']."'  END, '')) as 'grade_".$subject['sub_name']."'," ;
                }
                $this->db->select('s.std_id,s.adm_no,s.roll_no,'.$condition);
                $this->db->join('(SELECT sm.*,mm.sub_id FROM student_marks sm JOIN marks_master mm ON mm.mm_id=sm.mm_id  WHERE mm.et_id='.$exam_type.$con_sg_st.') t1','t1.std_id=s.std_id','LEFT');
                $this->db->join('subject sub','sub.sub_id=t1.sub_id','LEFT');
                $this->db->group_by('s.std_id');
                $this->db->order_by('s.adm_no','ASC');
                if(!empty($sub_group)){
                    $this->db->where('s.sub_group',$sub_group);
                }
                if(!empty($data['std_id'])){
                    $this->db->where('s.std_id',$data['std_id']);
                }
                $result['extra_sub'] = $this->db->get_where('students s',array('s.ses_id'=>$session,'s.sch_id'=>$school,'s.medium'=>$medium,'s.class_id'=>$class_name,'s.sec_id'=>$section,'s.status'=>1))->result_array();
                return $result;
            }
        }
}