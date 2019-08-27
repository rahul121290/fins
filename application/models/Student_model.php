<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Student_model extends CI_Model{
    
    public function add_student($std_id,$old_image,$data){
        
        if($data['sch_id'] == 1){
            $path = 'assets/images/shakuntala/students/';
        }else{
            $path = 'assets/images/sharda/students/';
        }
        
        //$path1 = 'assets/images/students/temp/';
        
        $this->db->trans_begin();
        if(!empty($_FILES['std_image']['name'])){
            
            if(!empty($old_image) && file_exists("$path".$old_image))
            {
                unlink($path.$old_image);
                //unlink($path1.$old_image);
            }
            //---------uploading process----------------
            $imagename=$_FILES['std_image']['name'];//get file name
            $ext=pathinfo($imagename,PATHINFO_EXTENSION); // get file extention--
            $var_img_name=$data['adm_no'].".".$ext; // replace name acording to admission number
            $temp=$_FILES['std_image']['tmp_name'];
            move_uploaded_file($temp,$path.$var_img_name);
            
            //----------crop image and save temp folder---------
//             require_once(APPPATH.'third_party/resize.php');
//             $resizeObj1 = new resize($path.$var_img_name);
//             //$resizeObj1 ->resizeImage(192,'crop');
//             $resizeObj1 -> resizeImage(100, 200, 'auto');
//             $resizeObj1 -> saveImage($path1.$var_img_name, 200);
        }
        elseif(empty($_FILES['std_image']['name'])){
            $var_img_name = $old_image;
        }
        
        $data['photo'] = $var_img_name;
        
        if(!empty($std_id)){
            $this->db->where('std_id',$std_id);
            $this->db->update('students',$data);
            
            $event = 'Update Student';
            $user = $this->session->userdata('user_id');
            $table_name = 'students';
            $table_id = $std_id;
            $this->my_function->add_log($user,$event,$table_name,$table_id);
            
        }else{
            $this->db->insert('students',$data);
            
            $event = 'Add New Student';
            $user = $this->session->userdata('user_id');
            $table_name = 'students';
            $table_id = $this->db->insert_id();
            $this->my_function->add_log($user,$event,$table_name,$table_id);
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
    
    public function deleteRecord($delete_id){
        $this->db->where('std_id',$delete_id);
         $this->db->update('students',array('status'=>0));
        
        $event = 'Delete Student';
        $user = $this->session->userdata('user_id');
        $table_name = 'students';
        $table_id = $delete_id;
        $this->my_function->add_log($user,$event,$table_name,$table_id);
        
        return true;
    }


}