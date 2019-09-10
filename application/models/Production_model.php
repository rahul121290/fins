<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Production_model extends CI_Model {

    function org_details($data){
        
        $result['session'] = $this->db->select('session_name')->get_where('session',array('ses_id'=>$data['session'],'status'=>1))->result_array();
        
        $result['school'] = $this->db->select('school_name,address,affiliation_no,school_no,school_image,principal_name,principal_sign')->get_where('school',array('sch_id'=>$data['school'],'status'=>1))->result_array();
        if(!empty($data['exam_type'])){
            $result['exam_type'] = $this->db->select('et_name')->get_where('exam_type',array('et_id'=>$data['exam_type'],'status'=>1))->result_array();
        }
        $result['medium'] = $this->db->select('med_name')->get_where('medium',array('med_id'=>$data['medium'],'status'=>1))->result_array();
        
        if(!empty($data['class'])){
            $result['class'] = $this->db->select('class_name')->get_where('class',array('c_id'=>$data['class'],'status'=>1))->result_array();
        }
        
        if(!empty($data['section'])){
            $result['section'] = $this->db->select('section_name')->get_where('section',array('sec_id'=>$data['section'],'status'=>1))->result_array();
        }
        
        if(!empty($data['sub_group'])){
            $result['sub_group'] = $this->db->select('sg_name')->get_where('sub_group',array('sg_id'=>$data['sub_group'],'status'=>1))->result_array();
        }
        return $result;
    }
    
    function marks_entry_check($data){
        $condition = '';
        $condition.=' AND status=1';
        if(!empty($data['session'])){
            $condition.=' AND ses_id='.$data['session'];
        }
        if(!empty($data['school'])){
            $condition.=' AND sch_id='.$data['school'];
        }
        if(!empty($data['medium'])){
            $condition.=' AND med_id='.$data['medium'];
        }
        if(!empty($data['class'])){
            $condition.=' AND class_id='.$data['class'];
        }
        if(!empty($data['sub_group'])){
            $condition.=' AND sg_id='.$data['sub_group'];
        }
        if(!empty($data['exam_type'])){
            $exam_type = ' AND et_id='.$data['exam_type'];
        }
        
        $this->db->select('s.sub_name,st.st_name,IF(IsNULL(t2.sub_id),"no","yes") as entry');
        $this->db->join('(SELECT * FROM marks_master WHERE 1=1 AND sec_id='.$data['section'].$condition.$exam_type.' GROUP BY sub_id) as t2','t2.sub_id = t1.sub_id','LEFT');
        $this->db->join('subject s','s.sub_id = t1.sub_id');
        $this->db->join('sub_type st','st.st_id = t1.st_id');
       
        if($data['exam_type'] == 1 || $data['exam_type'] == 3){
            $this->db->where('st.st_id IN(1,3)'); //for scholistic and elective subjects
        }
        
        $result = $this->db->get_where('(SELECT * FROM subject_allocation WHERE 1=1'.$condition.' GROUP BY sub_id) as t1',array())->result_array();
        return $result;
    }
    
    public function export_excel($data){
          $session = $data['session'];
          $school = $data['school'];
          $exam_type = $data['exam_type'];
          $medium = $data['medium'];
          $class_name = $data['class_name'];
          $sub_group = $data['sub_group'];
          $section = $data['section'];
          if($sub_group){
              $sg_group = ' AND sa.sg_id = '.$sub_group;
          }else{
              $sg_group = '';
          }
          
          $this->db->select('sm.adm_no,sm.roll_no,s.st_id,s.sub_id,sm.sub_marks,sm.practical,om.out_of,om.practical practical_out_of');
          $this->db->join('marks_master mm','mm.mm_id = sm.mm_id');
          $this->db->join('subject s','s.sub_id=mm.sub_id');
          $this->db->join('subject_allocation sa','sa.sub_id = s.sub_id AND sa.ses_id = '.$session.' AND sa.sch_id = '.$school.' AND sa.med_id = '.$medium.' AND sa.class_id = '.$class_name.' AND sa.st_id = s.st_id'.$sg_group.'');
          $this->db->join('out_of_marks om','om.sa_id = sa.sa_id AND om.et_id = '.$exam_type.'');
          if(!empty($sub_group)){
              $this->db->where('mm.sg_id',$sub_group);
          }
          $this->db->where(array('mm.ses_id' =>$session,'mm.sch_id' =>$school, 'mm.et_id' =>$exam_type,'mm.med_id' =>$medium,'mm.class_id' =>$class_name,'mm.sec_id' =>$section,'mm.status' => 1));
          $result = $this->db->get_where('student_marks sm',array('sm.status'=>1))->result_array();
          
          
          //-------------generate csv file------------------------
          $phpExcel = new PHPExcel();
          $prestasi = $phpExcel->setActiveSheetIndex(0);
          
          //----------put index name-------------------
          $prestasi->setCellValue('A1', 'session');
          $prestasi->setCellValue('B1', 'school');
          $prestasi->setCellValue('C1', 'medium');
          $prestasi->setCellValue('D1', 'exam_type');
          $prestasi->setCellValue('E1', 'class');
          $prestasi->setCellValue('F1', 'subject_group');
          $prestasi->setCellValue('G1', 'section');
		  $prestasi->setCellValue('H1', 'admission_no');
		  $prestasi->setCellValue('I1', 'sub_type');
          $prestasi->setCellValue('J1', 'subject_id');
          $prestasi->setCellValue('K1', 'sub_marks');
          $prestasi->setCellValue('L1', 'practical');
          $prestasi->setCellValue('M1', 'marks_out_of');
          $prestasi->setCellValue('N1', 'practical_out_of');
          
          
          //---------------------put data in excel----------------------------
          $no=0;
          $rowexcel = 1;
          foreach($result as $row){
              $no++;
              $rowexcel++;
              $prestasi->setCellValue('A'.$rowexcel, $session);
              $prestasi->setCellValue('B'.$rowexcel, $school);
              $prestasi->setCellValue('C'.$rowexcel, $medium);
              $prestasi->setCellValue('D'.$rowexcel, $exam_type);
              $prestasi->setCellValue('E'.$rowexcel,  $class_name);
              $prestasi->setCellValue('F'.$rowexcel,  $sub_group);
              $prestasi->setCellValue('G'.$rowexcel,  $section);
              $prestasi->setCellValue('H'.$rowexcel,  $row['adm_no']);
              $prestasi->setCellValue('I'.$rowexcel,  $row['st_id']);
              $prestasi->setCellValue('J'.$rowexcel,  $row['sub_id']);
              $prestasi->setCellValue('K'.$rowexcel,  $row['sub_marks']);
              $prestasi->setCellValue('L'.$rowexcel,  $row['practical']);
              $prestasi->setCellValue('M'.$rowexcel,  $row['out_of']);
              $prestasi->setCellValue('N'.$rowexcel,  $row['practical_out_of']);
          }
          
          $date =date('U');
          $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
          
          if(!is_dir('./export_marks_excel')){
              mkdir('./export_marks_excel');
          }
          $sg_name= '';
          if(!empty($data['sub_group'])){
              $sg_name= '_Group_'.$data['sub_group'];
          }
          $filename = "export_marks_excel/Class".$data['class_name']."_Sec_".$data['section']."_".$sg_name."_".$date.".xlsx";
          //----------save excel file----------------------------
           $objWriter->save($filename);
           return $filename;
    }
    
    public function students_report($data){
        $session = $data['session'];
        $school = $data['school'];
        $exam_type = $data['exam_type'];
        $medium = $data['medium'];
        $class_name = $data['class'];
        $sub_group = $data['sub_group'];
        $section = $data['section'];
        
        $sub_allocation = ' AND sa.status=1';
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
            $marks_master.=' AND mm.sec_id='.$section;
        }
        if($exam_type){
            $sub_allocation.=' AND om.et_id='.$exam_type;
            $marks_master.=' AND mm.et_id='.$exam_type;
        }
        
        
        //-----------------------------------***********----------------------------------------------------------------
        $this->db->select('s.st_id,sa.sa_id,sa.sub_id,s.sub_name,IFNULL(t1.teacher_name,"Teacher not assign") teacher_name,om.out_of,IFNULL(np.notappear,"0") as notappear,s.st_id');
        if(!empty($sub_group)){
            $this->db->where('sa.sg_id',$sub_group);
            $this->db->where('sa.st_id IN(1,3)');
        }else{
            $this->db->where('sa.st_id',1);
        }
        $this->db->join('subject s','s.sub_id=sa.sub_id AND s.status = 1');
        $this->db->join('sub_teacher st','st.sa_id=sa.sa_id AND st.sec_id = '.$section.' AND st.status = 1','LEFT');
        $this->db->join('teacher t1','t1.t_id=st.t_id AND t1.status = 1','LEFT');
        $this->db->join('out_of_marks om','om.sa_id=sa.sa_id AND om.status = 1');
        $this->db->join('(SELECT mm.sub_id, COUNT(sub_marks) as notappear FROM student_marks sm JOIN marks_master mm ON mm.mm_id= sm.mm_id WHERE sm.sub_marks = "A" '.$marks_master.' GROUP BY mm.sub_id) np','np.sub_id=sa.sub_id','LEFT');
        $this->db->where('1=1'.$sub_allocation);
        $this->db->order_by('s.short_order','ASC');
        $result['subjects'] = $this->db->get_where('subject_allocation sa')->result_array();
        //print_r($this->db->last_query());die;
        
        //-----------------------------------***********----------------------------------------------------------------
        $result['division'] = $this->db->select('min_no,max_no,division')->get_where('division',array('ses_id'=>$session,'status'=>1))->result_array();
        
        
        $con_sg_st = '';
        if(!empty($sub_group)){
            $con_sg_st .=' AND mm.sg_id='.$sub_group;
            $con_sg_st .=' AND mm.st_id IN(1,3)'; 
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
                $condition.="MAX(IF(sub.sub_id ='".$subject['sub_id']."', t1.sub_marks, '-')) as '". $subject['sub_name']."'," ;
            }
            
            $std_result = 'IFNULL((CASE WHEN ';
            $std_percent = 'IFNULL((CASE WHEN ';
            $division= 'IFNULL((CASE WHEN ';
            
            foreach($result['subjects'] as $subject){
                if($subject['st_id']  == 3){
                    $std_result.='MAX((IF(sub.sub_id = s.elective, `t1`.`sub_marks`, "")/IF(sub.sub_id = s.elective, `om`.`out_of`, ""))*100) > IF(sub.sub_id =s.elective, '.$result['division'][3]['max_no'].', "") && ';
                    $std_percent.='MAX((IF(sub.sub_id = s.elective, `t1`.`sub_marks`, "")/IF(sub.sub_id = s.elective, `om`.`out_of`, ""))*100) > IF(sub.sub_id =s.elective, '.$result['division'][3]['max_no'].', "") && ';
                    $division.='MAX((IF(sub.sub_id = s.elective, `t1`.`sub_marks`, "")/IF(sub.sub_id = s.elective, `om`.`out_of`, ""))*100) > IF(sub.sub_id =s.elective, '.$result['division'][3]['max_no'].', "") && ';
                }else{
                    $std_result.='MAX((IF(sub.sub_id ='.$subject['sub_id'].', `t1`.`sub_marks`, "")/IF(sub.sub_id ='.$subject['sub_id'].', `om`.`out_of`, ""))*100) > '.$result['division'][3]['max_no'].' && ';
                    $std_percent.='MAX((IF(sub.sub_id ='.$subject['sub_id'].', `t1`.`sub_marks`, "")/IF(sub.sub_id ='.$subject['sub_id'].', `om`.`out_of`, ""))*100) > '.$result['division'][3]['max_no'].' && ';
                    $division.='MAX((IF(sub.sub_id ='.$subject['sub_id'].', `t1`.`sub_marks`, "")/IF(sub.sub_id ='.$subject['sub_id'].', `om`.`out_of`, ""))*100) > '.$result['division'][3]['max_no'].' && ';
                }
            }
            $std_result.='((sum(t1.sub_marks)*sum(om.out_of))/100) > '.$result['division'][3]['max_no'].' THEN "Pass" END),"Fail") AS result';
            $std_percent.='((sum(t1.sub_marks)*sum(om.out_of))/100) > '.$result['division'][3]['max_no'].' THEN (ROUND((sum(t1.sub_marks)*100)/sum(om.out_of),2))   END),"Fail") AS percentage';
            
            $division .='((sum(t1.sub_marks)*sum(om.out_of))/100) > '.$result['division'][3]['max_no'].' THEN (CASE
                WHEN (sum(t1.sub_marks)*100)/sum(om.out_of) < '.$result['division'][2]['min_no'].' THEN "Fail"
                WHEN (sum(t1.sub_marks)*100)/sum(om.out_of) > '.$result['division'][3]['max_no'].' && (sum(t1.sub_marks)*100)/sum(om.out_of) < '.$result['division'][1]['min_no'].' THEN "3rd"
                WHEN (sum(t1.sub_marks)*100)/sum(om.out_of) > '.$result['division'][2]['max_no'].' && (sum(t1.sub_marks)*100)/sum(om.out_of) < '.$result['division'][0]['min_no'].' THEN "2nd"
                WHEN (sum(t1.sub_marks)*sum(om.out_of))/100 > '.$result['division'][1]['max_no'].' THEN "1st" END) END),"Fail") AS division';
            
            $this->db->select('s.adm_no,s.roll_no,s.name,c.class_name,sec.section_name,'.$condition.'SUM(t1.sub_marks) AS total,'.$std_percent.','.$std_result.','.$division);
            $this->db->join('(SELECT sm.*,mm.sub_id FROM student_marks sm JOIN marks_master mm ON mm.mm_id=sm.mm_id  WHERE mm.et_id='.$exam_type.$con_sg_st.') t1','t1.std_id=s.std_id','LEFT');
            $this->db->join('subject sub','sub.sub_id=t1.sub_id','LEFT');
            $this->db->join('class c','c.c_id=s.class_id');
            $this->db->join('section sec','sec.sec_id=s.sec_id');
            $this->db->join('subject_allocation sa','sa.sub_id = t1.sub_id AND sa.ses_id ='.$session.' AND sa.sch_id = '.$school.' AND sa.med_id = '.$medium.' AND sa.class_id ='.$class_name.' AND sa.status = 1');
            $this->db->join('out_of_marks om','om.sa_id = sa.sa_id AND om.status = 1 AND om.et_id = '.$exam_type);
            if($sub_group){
                $this->db->last_query('sa.sg_id',$sub_group);
            }
            $this->db->group_by('s.std_id');
            if(!empty($sub_group)){
                $this->db->where('s.sub_group',$sub_group);
            }
            $this->db->order_by('percentage','DESC');
            $students_report = $this->db->get_where('students s',array('s.ses_id'=>$session,'s.sch_id'=>$school,'s.medium'=>$medium,'s.class_id'=>$class_name,'s.sec_id'=>$section,'s.status'=>1))->result_array();
            //print_r($this->db->last_query());die;
            
            $rank = 0;
            $previousValue = null;
            $final = array();
            
            foreach($students_report as $percent_order){
                if($percent_order['percentage'] != 'Fail'){
                    if($percent_order['percentage'] == $previousValue){
                        $percent_order['rank'] = $rank;
                    }else{
                        $rank = $rank+1;
                        $percent_order['rank'] = $rank;
                    }
                }else{
                    $percent_order['rank'] = 'Fail';
                }
                $previousValue = $percent_order['percentage'];
                $final[] = $percent_order;
            }
            function cmpare_roll_no($a, $b) {
                return $a['roll_no'] - $b['roll_no'];
            }
            usort($final,"cmpare_roll_no");
           
            $result['furd'] = $final;
            return $result;
        }
    }
    
    
    public function TeacherAbstract($data){
        $session = $data['session'];
        $school = $data['school'];
        $exam_type = $data['exam_type'];
        $medium = $data['medium'];
        $teacher = $data['teacher'];
        
        $result['division'] = $this->db->select('min_no,max_no,division')->get_where('division',array('ses_id'=>$session,'med_id'=>$medium,'status'=>1))->result_array();
        
        $this->db->select('c.class_name,sec.section_name,sub.sub_name,t.teacher_name,sa.class_id,st.sec_id,sa.st_id,sa.sg_id,sa.sub_id,IFNULL(sg.sg_name,"-") AS sg_name');
        $this->db->join('subject_allocation sa','sa.sa_id=st.sa_id');
        $this->db->join('teacher t','t.t_id=st.t_id');
        $this->db->join('class c','c.c_id=sa.class_id');
        $this->db->join('section sec','sec.sec_id=st.sec_id');
        $this->db->join('subject sub','sub.sub_id=sa.sub_id');
        $this->db->join('sub_group sg','sg.sg_id=sa.sg_id','LEFT');
        $this->db->join('marks_master mm','mm.sub_id = sa.sub_id AND mm.ses_id = '.$session.' AND mm.sch_id = '.$school.' AND mm.med_id = '.$medium.' AND mm.status = 1');
        $this->db->where(array('sa.ses_id'=>$data['session'],'sa.sch_id'=>$data['school'],'sa.med_id'=>$data['medium'],'sa.status'=>1));
        if($exam_type == 1 || $exam_type == 3){
            $this->db->where('sa.st_id NOT IN(2,4)');
        }else{
            $this->db->where('sa.st_id NOT IN(2)');
        }
        $this->db->group_by('sa.class_id');
        $this->db->order_by('c.class_name');
        $teacher_and_subjets = $this->db->get_where('sub_teacher st',array('st.t_id'=>$data['teacher'],'st.status'=>1))->result_array();
        
        //print_r($this->db->last_query());die;
        
        $final=array();
        foreach($teacher_and_subjets as $sub_teacher){
            $class_name = '';
            $section = '';
            $sub_group = '';
            $subject = '';
            if(!empty($sub_teacher['class_id'])){
                $class_name = $sub_teacher['class_id'];
            }
            if(!empty($sub_teacher['sec_id'])){
                $section = $sub_teacher['sec_id'];
            }
            if(!empty($sub_teacher['sg_id'])){
                $sub_group = $sub_teacher['sg_id'];
            }
            if(!empty($sub_teacher['sub_id'])){
                $subject = $sub_teacher['sub_id'];
            }
            
            $students = ' AND status = 1';
            $marks_master = ' AND mm.status=1';
            $con_sg_st = ' AND status=1';
            
            if($session){
                $students.=' AND ses_id='.$session;
                $marks_master.=' AND mm.ses_id='.$session;
                $con_sg_st.=' AND ses_id='.$session;
            }
            if($school){
                $students.=' AND sch_id='.$school;
                $marks_master.=' AND mm.sch_id='.$school;
                $con_sg_st.=' AND sch_id='.$school;
            }
            if($medium){
                $students.=' AND medium='.$medium;
                $marks_master.=' AND mm.med_id='.$medium;
                $con_sg_st.=' AND med_id='.$medium;
            }
            if($class_name){
                $students.=' AND class_id='.$class_name;
                $marks_master.=' AND mm.class_id='.$class_name;
                $con_sg_st.=' AND class_id='.$class_name;
            }
            if($sub_group){
                $students.=' AND sub_group='.$sub_group;
                $marks_master.=' AND mm.sg_id='.$sub_group;
                $marks_master.=' AND mm.st_id IN(1,3)';
                $con_sg_st .=' AND sg_id='.$sub_group;
                $con_sg_st .=' AND st_id IN(1,3)';//--------1 scholistic subjects, 3 elective subjects---------
            }else{
                $marks_master.=' AND mm.st_id IN(1,4)';//--------1 scholistic subjects, 4 extra subjects---------
                $con_sg_st .=' AND st_id IN(1,4)';//--------1 scholistic subjects, 4 extra subjects---------
            }
            
            if($section){
                $students.=' AND sec_id='.$section;
                $marks_master.=' AND mm.sec_id='.$section;
                //$con_sg_st.=' AND sec_id='.$section;
            }
            if($exam_type){
                $marks_master.=' AND mm.et_id='.$exam_type;
            }
            if($subject){
                $con_sg_st.=' AND sub_id='.$subject;
                $marks_master.=' AND mm.sub_id='.$subject;
                
            }
            
            $this->db->select('out_of');
            $this->db->where('sa_id IN(SELECT sa_id FROM subject_allocation WHERE 1=1'.$con_sg_st.')');
            $outOfMarks = $this->db->get_where('out_of_marks',array('et_id'=>$data['exam_type'],'status'=>1))->result_array();
            //print_r($this->db->last_query());
            
            $this->db->select('COUNT(*) as total_std');
            $this->db->where('1=1'.$students);
            $total_std = $this->db->get_where('students')->result_array();
            
            $this->db->select('IFNULL(SUM(sub_marks),"0") as not_appear');
            $this->db->where('mm_id = (SELECT mm_id FROM marks_master mm WHERE 1=1'.$marks_master.')');
            $not_appear = $this->db->get_where('student_marks',array('sub_marks'=>"A"))->result_array();
            
            $this->db->select('SUM(sub_marks) as total_marks');
            $this->db->where('mm_id = (SELECT mm_id FROM marks_master mm WHERE 1=1'.$marks_master.')');
            $total_marks = $this->db->get_where('student_marks')->result_array();
            
            $this->db->select('sub_marks');
            $this->db->where('mm_id = (SELECT mm_id FROM marks_master mm WHERE 1=1'.$marks_master.')');
            $all_marks = $this->db->get_where('student_marks')->result_array();
            
            $pass = 0;
            $fail = 0;
            $first_div = 0;
            $secord_div = 0;
            $third_div = 0;
            $max_marks_get = 0;
            $max_marks_std = 0;
            foreach($all_marks as $all_mark){
                
                $sub_marks = $all_mark['sub_marks'];
                $sub_marks_per = ((int)($sub_marks) * 100)/$outOfMarks[0]['out_of'];
                
                if($sub_marks_per > $result['division'][3]['max_no']){
                    $pass = $pass+1;
                }
                if($sub_marks_per < $result['division'][2]['min_no']){
                    $fail = $fail+1;
                }
                if($sub_marks_per > $result['division'][1]['max_no']){
                    $first_div = $first_div+1;
                }elseif($sub_marks_per > $result['division'][2]['max_no'] && $sub_marks_per < $result['division'][0]['min_no']){
                    $secord_div = $secord_div+1;
                }elseif($sub_marks_per > $result['division'][3]['max_no'] && $sub_marks_per < $result['division'][1]['min_no']){
                    $third_div = $third_div+1;
                }
                if($max_marks_get < $sub_marks && $sub_marks  != 'A'){
                    $max_marks_get = $sub_marks;
                    $max_marks_std = 1;
                }elseif($max_marks_get == $sub_marks  && $sub_marks != 'A'){
                    $max_marks_std = $max_marks_std+1;
                }
            }
            
            $temp = array();
            $temp['teacher_name'] = $sub_teacher['teacher_name'];
            $temp['class_name'] = $sub_teacher['class_name'];
            $temp['section'] = $sub_teacher['section_name'];
            $temp['sub_name'] = $sub_teacher['sub_name'];
            $temp['sg_name'] = $sub_teacher['sg_name'];
            $temp['total_student'] = $total_std[0]['total_std'];
            $temp['total_appear'] = ($total_std[0]['total_std'] - $not_appear[0]['not_appear']);
            $temp['total_pass'] = $pass;
            $temp['pass_percent'] = round(($pass * 100)/($total_std[0]['total_std'] - $not_appear[0]['not_appear']));//--pass in percentage--
            $temp['first_div'] = $first_div;
            $temp['second_div'] = $secord_div;
            $temp['third_div'] = $third_div;
            if($pass > 0){
                $temp['first_percent'] = round(($first_div * 100)/$pass);	////--first div in percentage--
            }else{
                $temp['first_percent'] = 0;
            }
            $temp['fail'] = $fail;
            $temp['out_of'] = $outOfMarks[0]['out_of'];
            $temp['notapper'] = $not_appear[0]['not_appear'];
            $temp['max_marks'] = $max_marks_get;
            $temp['max_marks_std'] = $max_marks_std;
            $temp['pi'] = round(($total_marks[0]['total_marks'] / (($total_std[0]['total_std'] - $not_appear[0]['not_appear']) * $outOfMarks[0]['out_of']))*100,2);
            $final[] = $temp;
        }//-----end of foreach loop---------------
        return $final;
    }
}