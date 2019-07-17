<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marks_entry_model extends CI_Model{
    
    public function marks_entry($data,$final){
        $master['ses_id'] = $data['session'];
        $master['sch_id'] = $data['school'];
        $master['et_id'] = $data['exam_type'];
        $master['med_id'] = $data['medium'];
        $master['class_id'] = $data['class'];
        if(!empty($data['sub_group'])){
            $master['sg_id'] = $data['sub_group'];
        }
        $master['sec_id'] = $data['section'];
        $master['st_id'] = $data['sub_type'];
        $master['sub_id'] = $data['subject'];
        $master['created_by'] = $this->session->userdata('user_id');
        $master['created_at'] = date('Y-m-d H:i:s');
        
        $this->db->trans_begin();
        $this->db->select('mm_id,status');
        if(!empty($master['sg_id'])){
            $this->db->where('sg_id',$master['sg_id']);
        }
        $result_master = $this->db->get_where('marks_master',array('ses_id'=>$master['ses_id'],'sch_id'=>$master['sch_id'],'et_id'=>$master['et_id'],'med_id'=>$master['med_id'],'class_id'=>$master['class_id'],'sec_id'=>$master['sec_id'],'st_id'=>$master['st_id'],'sub_id'=>$master['sub_id'],'status'=>1))->result_array();
        
        if(count($result_master)>0){
            $this->db->where(array('ses_id'=>$master['ses_id'],'sch_id'=>$master['sch_id'],'et_id'=>$master['et_id'],'med_id'=>$master['med_id'],'class_id'=>$master['class_id'],'sec_id'=>$master['sec_id'],'st_id'=>$master['st_id'],'sub_id'=>$master['sub_id'],'status'=>1));
            if(!empty($master['sg_id'])){
                $this->db->where('sg_id',$master['sg_id']); 
            }
            $this->db->update('marks_master',array('status'=>0));
            
            $this->db->insert('marks_master',$master);//--------------insert marks master table---------
            $last_mm_id = $this->db->insert_id();//----------get last insert id-----------------------
        }else{
            $this->db->insert('marks_master',$master);//--------------insert marks master table---------
            $last_mm_id = $this->db->insert_id();//----------get last insert id-----------------------
        }
        
        $marks = array();
        foreach($final as $final_marks){
            $temp = array(); 
            $temp['mm_id'] = $last_mm_id;
            $temp['std_id'] = $final_marks['std_id'];
            $temp['roll_no'] = $final_marks['roll_no'];
            $temp['adm_no'] = $final_marks['adm_no'];
            $temp['sub_marks'] = $final_marks['sub_marks'];
            $temp['practical'] = $final_marks['practical'];
            $temp['notebook'] = $final_marks['notebook'];
            $temp['enrichment'] = $final_marks['enrichment'];
            $temp['acadmic'] = $final_marks['acadmic'];
            $temp['created_by'] = $this->session->userdata('user_id');
            $temp['created_at'] = date('Y-m-d H:i:s');
            $marks[] = $temp;
        }
        
        //-------------generate excel file------------------------
        $phpExcel = new PHPExcel();
        $prestasi = $phpExcel->setActiveSheetIndex(0);
        
        //----------put index name-------------------
        $prestasi->setCellValue('A1', 'S. No.');
        $prestasi->setCellValue('B1', 'mm_id');
        $prestasi->setCellValue('C1', 'std_id');
        $prestasi->setCellValue('D1', 'roll_no');
        $prestasi->setCellValue('E1', 'adm_no');
        $prestasi->setCellValue('F1', 'sub_marks');
        $prestasi->setCellValue('G1', 'practical');
        $prestasi->setCellValue('H1', 'notebook');
        $prestasi->setCellValue('I1', 'enrichment');
        $prestasi->setCellValue('J1', 'acadmic');
        $prestasi->setCellValue('K1', 'created_by');
        $prestasi->setCellValue('L1', 'created_at');
        
        //---------------------put data in excel----------------------------
        $no=0;
        $rowexcel = 1;
        foreach($marks as $row){
            $no++;
            $rowexcel++;
            $prestasi->setCellValue('A'.$rowexcel, $no);
            $prestasi->setCellValue('B'.$rowexcel, $row["mm_id"]);
            $prestasi->setCellValue('C'.$rowexcel, $row["std_id"]);
            $prestasi->setCellValue('D'.$rowexcel, $row["roll_no"]);
            $prestasi->setCellValue('E'.$rowexcel, $row["adm_no"]);
            $prestasi->setCellValue('F'.$rowexcel, $row["sub_marks"]);
            $prestasi->setCellValue('G'.$rowexcel, $row["practical"]);
            $prestasi->setCellValue('H'.$rowexcel, $row["notebook"]);
            $prestasi->setCellValue('I'.$rowexcel, $row["enrichment"]);
            $prestasi->setCellValue('J'.$rowexcel, $row["acadmic"]);
            $prestasi->setCellValue('K'.$rowexcel, $row["created_by"]);
            $prestasi->setCellValue('L'.$rowexcel, $row["created_at"]);
        }
        
        $date =date('U');
        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        
        if(!is_dir('./mark_entry_csv')){
            mkdir('./mark_entry_csv');
        }
        $sg_name= '';
        if(!empty($data['sub_group'])){
            $sg_name= '_Group_'.$data['sub_group'];
        }
        $filename = "mark_entry_csv/Marks_Records_Class_".$data['class']."_Sec_".$data['section']."_".$sg_name."_".$date.".xlsx";
        //----------save excel file----------------------------
        $objWriter->save($filename);
        //-----------------------------------------------------
        
        //--------store marks array in mm_id-----------------------
        $this->db->insert_batch('student_marks',$marks); 
        //---------------------------------------------------------
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }
    
    public function marks_csv_import($data){
        $this->db->select('std_id,adm_no,roll_no');
        if(!empty($data['sub_group'])){
            $this->db->where('sub_group',$data['sub_group']);
        }
        $total_students = $this->db->get_where('students',array('ses_id'=>$data['session'],'sch_id'=>$data['school'],'medium'=>$data['medium'],'class_id'=>$data['class'],'sec_id'=>$data['section'],'status'=>1))->result_array();
        
        
        $master['ses_id'] = $data['session'];
        $master['sch_id'] = $data['school'];
        $master['et_id'] = $data['exam_type'];
        $master['med_id'] = $data['medium'];
        $master['class_id'] = $data['class'];
        if(!empty($data['sub_group'])){
            $master['sg_id'] = $data['sub_group'];
        }
        $master['sec_id'] = $data['section'];
        $master['st_id'] = $data['sub_type'];
        $master['sub_id'] = $data['subject'];
        $master['created_by'] = $this->session->userdata('user_id');
        $master['created_at'] = date('Y-m-d H:i:s');
        
        $this->db->trans_begin();
        $this->db->select('mm_id,status');
        if(!empty($master['sg_id'])){
            $this->db->where('sg_id',$master['sg_id']);
        }
        $result_master = $this->db->get_where('marks_master',array('ses_id'=>$master['ses_id'],'sch_id'=>$master['sch_id'],'et_id'=>$master['et_id'],'med_id'=>$master['med_id'],'class_id'=>$master['class_id'],'sec_id'=>$master['sec_id'],'st_id'=>$master['st_id'],'sub_id'=>$master['sub_id'],'status'=>1))->result_array();
        
        if(count($result_master)>0){
            $this->db->where(array('ses_id'=>$master['ses_id'],'sch_id'=>$master['sch_id'],'et_id'=>$master['et_id'],'med_id'=>$master['med_id'],'class_id'=>$master['class_id'],'sec_id'=>$master['sec_id'],'st_id'=>$master['st_id'],'sub_id'=>$master['sub_id'],'status'=>1));
            if(!empty($master['sg_id'])){
                $this->db->where('sg_id',$master['sg_id']);
            }
            $this->db->update('marks_master',array('status'=>0));
           
            $this->db->insert('marks_master',$master);//--------------insert marks master table---------
            $last_mm_id = $this->db->insert_id();//----------get last insert id-----------------------
        }else{
            $this->db->insert('marks_master',$master);//--------------insert marks master table---------
            $last_mm_id = $this->db->insert_id();//----------get last insert id-----------------------
        }
        
        if(!empty($_FILES['marks_csv']['name'])){
            $path = $_FILES['marks_csv']['tmp_name'];
            $object = PHPExcel_IOFactory::load($path);

            foreach($object->getWorksheetIterator() as $worksheet){
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                
                $final = array();
                foreach($total_students as $students){
                    for($row=2; $row <= $highestRow; $row++){
                        $col = 0;
                        if($students['std_id'] == $worksheet->getCellByColumnAndRow($col++, $row)->getValue()){
                            $col = 0;
                            $temp = array();
                            $temp['mm_id'] = $last_mm_id;
                            $temp['std_id'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['adm_no'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['roll_no'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['sub_marks'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['practical'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['notebook'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['enrichment'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['acadmic'] = $worksheet->getCellByColumnAndRow($col++, $row)->getValue();
                            $temp['created_by'] = $master['created_by'];
                            $temp['created_at'] = $master['created_at'];
                            $final[] = $temp;
                        }
                        
                    }
                }
            }
            
            $this->db->insert_batch('student_marks',$final);
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                return false;
            }
            else
            {
                $this->db->trans_commit();
                return true;
            }
        }
    }
    
}
  