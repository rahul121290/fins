<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_function{
    
    protected $CI;
    
    public function __construct()
    {
        $this->CI =& get_instance();
    }
    
    
    function add_log($user,$event_name,$table_name,$table_id){
        $CI =& get_instance();
        $CI->load->database();
        
        $data['user_id'] = $user;
        $data['user_ip'] = $CI->input->ip_address();
        $data['event_name'] = $event_name;
        $data['event_time'] = date('Y-m-d H:i:s');
        $data['table_name'] = $table_name;
        $data['table_id'] = $table_id;
        return $res = $CI->db->insert('log_report',$data);
    }
    
    
    public function permission_link(){
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->database();
        $user_id = $CI->session->userdata('user_id');
        
        $CI->db->select('g.name');
        $CI->db->join('users u','u.id = ug.user_id');
        $CI->db->join('groups g','g.id = ug.group_id');
        $result = $CI->db->get_where('users_groups ug',array('u.id'=>$user_id))->result_array();
        return $result[0]['name'];
    }
    
    
    
    public function user_permission(){
        $CI =& get_instance();
        $CI->load->library('session');
        $CI->load->database();
        $user_id = $CI->session->userdata('user_id');
        
        $CI->db->select('permission');
        $result = $CI->db->get_where('users',array('id'=>$user_id))->result_array();
        
        $data = $result[0]['permission'];
        $data = explode(",",$data);
        return $data;
        //return $result;
    }
 
    function send_sms($mobile,$sms){
        $api_key = '25D105E607A4B8';
        $contacts = $mobile;
        $from = 'SHKVID';
        $sms_text = urlencode($sms);
        //Submit to server
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "http://login.aronixcreativepoint.com/app/smsapi/index.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=0&routeid=31=TRANS(31)&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
        $response = curl_exec($ch);
        curl_close($ch);
        return true;
    }
    
    function generateNumericOTP() {
        $generator = "1357902468";
        $result = "";
        for ($i = 1; $i <= 4; $i++) {
            $result .= substr($generator, (rand()%(strlen($generator))), 1);
        }
        return $result;
    }
    
    
    function number_to_word($amount){
        $number = $amount;
        $no = round($number);
        $point = round($no - $number, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] .
                " " . $digits[$counter] . $plural . " " . $hundred
                :
                $words[floor($number / 10) * 10]
                . " " . $words[$number % 10] . " "
                    . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
        }
        $str = array_reverse($str);
        $result = implode('', $str);
        //print_r($point);die;
        $points = ($point) ? "." . $words[$point / 10] . " " . $words[$point = $point % 10] : '';
        
        return $result . "Rupees" ;
    }
    
    
    
}
