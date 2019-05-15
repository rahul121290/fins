<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School_model extends CI_Model {
    
    public function school_insert($id,$data){
        $path = 'assets/images/';
        $path1 = 'assets/images/temp/';
        
        $this->db->trans_begin();
        if(!empty($_FILES['school_image']['name']))
        {
            if(!empty($data['old_image']) && file_exists($path.$data['old_image']))
            {
                unlink($path.$data['old_image']);
                //unlink($path1.$data['old_image']);
            }
            
            //---------uploading process----------------
            $imagename=$_FILES['school_image']['name'];//get file name
            $ext=pathinfo($imagename,PATHINFO_EXTENSION); // get file extention--
            $var_img_name = 'sch'.time().".".$ext; // replace name acording a time 
            $temp=$_FILES['school_image']['tmp_name'];
            move_uploaded_file($temp,$path.$var_img_name);
            
            //----------crop image and save temp folder---------
//             require_once(APPPATH.'third_party/resize.php');
//             $resizeObj1 = new resize($path.$var_img_name);
//             //$resizeObj1 ->resizeImage(192,'crop');
//             $resizeObj1 -> resizeImage(100, 200, 'auto');
//             $resizeObj1 -> saveImage($path1.$var_img_name, 200);
        }
        elseif(empty($_FILES['school_image']['name'])){
            $var_img_name = $data['old_image'];
        }
        
        
        if(!empty($_FILES['principal_image']['name']))
        {
            if(!empty($data['old_principal_image']) && file_exists($path.$data['old_principal_image']))
            {
                unlink($path.$data['old_principal_image']);
                //unlink($path1.$data['old_image']);
            }
            
            //---------uploading process----------------
            $imagename=$_FILES['principal_image']['name'];//get file name
            $ext=pathinfo($imagename,PATHINFO_EXTENSION); // get file extention--
            $pri_img_name = 'prin'.time().".".$ext; // replace name acording a time
            $temp=$_FILES['principal_image']['tmp_name'];
            move_uploaded_file($temp,$path.$pri_img_name);
            
            //----------crop image and save temp folder---------
            //             require_once(APPPATH.'third_party/resize.php');
            //             $resizeObj1 = new resize($path.$var_img_name);
            //             //$resizeObj1 ->resizeImage(192,'crop');
            //             $resizeObj1 -> resizeImage(100, 200, 'auto');
            //             $resizeObj1 -> saveImage($path1.$var_img_name, 200);
        }
        elseif(empty($_FILES['principal_image']['name'])){
            $pri_img_name = $data['old_principal_image'];
        }
        
        unset($data['old_principal_image']);
        unset($data['old_image']);
        
         $data['principal_sign']= $pri_img_name;
         $data['school_image']= $var_img_name;
         $data['created_by'] = $this->session->userdata('user_id');
         $data['created_at'] = date('Y-m-d h:i:s');
        
         if($id != ''){
             //----update in database--------------------
             $this->db->where('sch_id',$id);
             $this->db->update('school',$data);
             //print_r($this->db->last_query()); die;
         }else{
             //-----insert in database-------------------
             $this->db->insert('school',$data);
             //print_r($this->db->last_query()); die;
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
    
    public function deleteRow($delete_id){
        $seted_school_id = $this->db->select('set_school')->where('sch_id',$delete_id)->get('school')->result_array();
        $seted_school = $seted_school_id[0]['set_school'];
        if($seted_school == 0){
            return  $this->db->where('sch_id',$delete_id)->update('school',array('status'=>0));
        }else{
            return false;
        }
    }
    
    public function setInSession($set_id){
        $this->db->trans_begin();
        $this->db->update('school',array('set_school'=>0));
        $this->db->where('sch_id',$set_id)->update('school',array('set_school'=>1));
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
    }
    
    
}