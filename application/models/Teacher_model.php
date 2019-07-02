<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_model extends CI_Model{
    
    public function submitTeacherData($tid,$data,$ct_id,$class_teacher){
        $path = 'assets/images/sharda/teachers/';
        if($this->session->userdata('school_id') == 1){
            $path = 'assets/images/shakuntala/teachers/';
        }
        //$path1 = 'assets/images/teacher/temp/';
        
        $this->db->trans_begin();
        
        if(!empty($_FILES['image']['name']))
        {
            if(!empty($data['old_image']) && file_exists("$path".$data['old_image']))
            {
                unlink($path.$data['old_image']);
                //unlink($path1.$data['old_image']);
            }
            
            //---------uploading process----------------
            $imagename=$_FILES['image']['name'];//get file name
            $ext=pathinfo($imagename,PATHINFO_EXTENSION); // get file extention--
            $var_img_name=time().".".$ext; // replace name acording a time
            $temp=$_FILES['image']['tmp_name'];
            move_uploaded_file($temp,$path.$var_img_name);
            
            //----------crop image and save temp folder---------
//             require_once(APPPATH.'third_party/resize.php');
//             $resizeObj1 = new resize($path.$var_img_name);
//             //$resizeObj1 ->resizeImage(192,'crop');
//             $resizeObj1 -> resizeImage(100, 200, 'auto');
//             $resizeObj1 -> saveImage($path1.$var_img_name, 200);
        }
        elseif(empty($_FILES['image']['name'])){
            $var_img_name = $data['old_image'];
        }
        
        $submitdata['teacher_name'] = $data['teacher_name'];
        $submitdata['gender'] = $data['gender'];
        $submitdata['dob'] = $data['dob'];
        $submitdata['email'] = $data['email'];
        $submitdata['prmt_address'] = $data['prmt_address'];
        $submitdata['alter_address'] = $data['alter_address'];
        $submitdata['designation'] = $data['designation'];
        $submitdata['qualifications'] = $data['qualifications'];
        $submitdata['image'] = $var_img_name;
        $submitdata['created_by'] = $this->session->userdata('user_id');
        $submitdata['created_at'] = date('Y-m-d H:i:s');
        
        if($tid != ''){
            //---------update--------------
            $this->db->where('t_id',$tid);
            $this->db->update('teacher',$submitdata);
            
        }else{
            //--------insert--------------
            $this->db->insert('teacher',$submitdata);
        }
        
        
        //---------------insert/update class teacher table---------------------------------
        if($class_teacher['class_teacher'] == 'yes'){
           
            if($tid != ''){
                $ct_data['t_id'] = $tid;
            }else{
                $ct_data['t_id'] = $this->db->insert_id();
            }
            $ct_data['ses_id'] = $this->session->userdata('session_id');
            $ct_data['sch_id'] = $this->session->userdata('school_id');
            $ct_data['med_id'] = $class_teacher['medium'];
            $ct_data['class_id'] = $class_teacher['class'];
            $ct_data['sec_id'] = $class_teacher['section'];
            if(!empty($class_teacher['sub_group'])){
                $ct_data['sg_id'] = $class_teacher['sub_group'];
            }
            $ct_data['created_by'] = $this->session->userdata('user_id');
            $ct_data['created_at'] = date('Y-m-d H:i:s');
            $ct_data['status'] = 1;
            
            if($ct_id != ''){
                //--------update--------------
                $this->db->where('ct_id',$ct_id);
                $this->db->update('class_teacher',$ct_data);
            }else{
                //--------insert-------------
                $this->db->insert('class_teacher',$ct_data);
            }
            
        }elseif($class_teacher['class_teacher'] == 'no'){
            if($ct_id){
                //-------status 0-----------------
                $this->db->where('ct_id',$ct_id);
                $this->db->update('class_teacher',array('status'=>0));
            }
        }
        
        //---------------end of process class teacher insert/update----------------------------
        
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
    
    public function deleteRecord($delete_id){
        $path = 'assets/images/teacher/';
        //$path1 = 'assets/images/teacher/temp/';
        $this->db->trans_begin();
        $result = $this->db->select('image')->get_where('teacher',array('t_id'=>$delete_id))->result_array();
       
        if(count($result) > 0 && file_exists($path.$result[0]['image'])){
           // unlink($path.$result[0]['image']);
            //unlink($path1.$result[0]['image']); 
        }
        $this->db->where('t_id',$delete_id);
        $this->db->update('teacher',array('status'=>0));
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
    
    public function allocateSubjectTeacher($data){
        $this->db->trans_begin();
        $result = $this->db->select('st_id,status')->get_where('sub_teacher',array('sa_id'=>$data['sa_id']))->result_array();
        
        if(count($result) > 0 ){
            if($data['t_id']){
                //---------------update-------------------
                $this->db->where('st_id',$result[0]['st_id']);
                $this->db->update('sub_teacher',array('t_id'=>$data['t_id'],'status'=>1));
            }else{
                //---------------cancle agigned teachers-------------------
                $this->db->where('st_id',$result[0]['st_id']);
                $this->db->update('sub_teacher',array('status'=>0));
            }
            
        }else{
            //--------insert--------------------
            $this->db->insert('sub_teacher',$data);
        }
        
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
    
    
    function updateProfile($data){
        
        $path = 'assets/images/sharda/teachers/';
        if($this->session->userdata('school_id') == 1){
            $path = 'assets/images/shakuntala/teachers/';
        }
        $user_id = $this->session->userdata('user_id');
        
        $this->db->trans_begin();
        
        if(!empty($_FILES['image']['name']))
        {
            
            if(!empty($data['old_image']) && file_exists("$path".$data['old_image']))
            {
                unlink($path.$data['old_image']);
                //unlink($path1.$data['old_image']);
            }
            
            //---------uploading process----------------
            $imagename=$_FILES['image']['name'];//get file name
            $ext=pathinfo($imagename,PATHINFO_EXTENSION); // get file extention--
            $var_img_name=time().".".$ext; // replace name acording a time
            $temp=$_FILES['image']['tmp_name'];
            move_uploaded_file($temp,$path.$var_img_name);
            
            //----------crop image and save temp folder---------
            //             require_once(APPPATH.'third_party/resize.php');
            //             $resizeObj1 = new resize($path.$var_img_name);
            //             //$resizeObj1 ->resizeImage(192,'crop');
            //             $resizeObj1 -> resizeImage(100, 200, 'auto');
            //             $resizeObj1 -> saveImage($path1.$var_img_name, 200);
        }
        elseif(empty($_FILES['image']['name'])){
            $var_img_name = $data['old_image'];
        }
        unset($data['old_image']);
        $data['image'] = $var_img_name;
        
        $this->db->where('id',$user_id);
        $this->db->update('users',array('email'=>$data['email']));
        
        $this->db->where('t_id = (SELECT t_id FROM users WHERE id = '.$user_id.')');
        $this->db->update('teacher',$data);
        
        
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