<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
function check_mob_login($type){ 
$CI= & get_instance();		
$CI->load->library('session');
$CI->load->helper('url');
$check=$CI->session->userdata('user_type');
if($check==''){
if($type==0){
redirect(base_url().'master');
}else{
redirect(base_url().'login');
}
}else if($check!=$type){
$page=($check==0)?'master/dashboard':'student/dashboard';
redirect(base_url().$page);
}
}
function check_login_page($type){ 
$CI= & get_instance();		
$CI->load->library('session');
$CI->load->helper('url');
$check=$CI->session->userdata('user_type');
if($check!=''){
if($type==0){
redirect(base_url().'master/dashboard');
}else{
redirect(base_url().'student/dashboard');
}
}
}
function Calculate_Marks($tot_m,$pos_m,$wrong_m,$neg_m){
$total=($tot_m*$pos_m)-($wrong_m*$neg_m);
return round($total,2);
}
function Average_Calculate($all,$count){
if($all!='' && $all!=0){
$final=round($all/$count);
}else{
$final='';
}
return $final;
}

function Genearate_Student_Id($lastId,$last_user_details){
if($lastId){
if(!empty($last_user_details) && $last_user_details['registration_no'] != '' ){
	$reg_id = $last_user_details['registration_no'];
	$str1 = substr($last_user_details['registration_no'],0,3);
	$str2 = substr($last_user_details['registration_no'],3,15);
	$strData = $str2+1;
	if(strlen($str2+1) == 1){
		$registration_no = $str1.'00000'.$strData;
	}else if(strlen($str2+1) == 2){
		$registration_no =  $str1.'0000'.$strData;
	}else if(strlen($str2+1) == 3){
		$registration_no =  $str1.'000'.$strData;
	}else if(strlen($str2+1) == 4){
		$registration_no =  $str1.'00'.$strData;
	}else if(strlen($str2+1) == 5){
		$registration_no =  $str1.'0'.$strData;
	}else if(strlen($str2+1) == 6){
		$registration_no =  $str1.$strData;
	}
	
}else{
	$registration_no = 'DPA000001';
}
}
return $registration_no;
}
function get_dynamic_id($string,$last_id){
if (strlen($last_id) == 1) {
	$dynamic_id   = $string. '0000' . $last_id;
 } else if (strlen($last_id) == 2) {
	$dynamic_id   = $string. '000' . $last_id;
  
} else if (strlen($last_id) == 3) {
	$dynamic_id   = $string. '00' . $last_id;
  
} else if (strlen($last_id) == 4) {
	$dynamic_id   = $string. '0' . $last_id;
  
} else if (strlen($last_id) == 5) {
	$dynamic_id   = $string. $last_id;
}
return  $dynamic_id;
}
function d_m_y_conversion($getdate){
return date("d-m-Y", strtotime($getdate));
}
function y_m_d_conversion($getdate){
return date("Y-m-d", strtotime($getdate));
}
function birthday($getdate){
$final=date("Y-m-d", strtotime($getdate));
if($final!='1970-01-01'){
return $final;
}else{ 
return '';
}
}
function DateTimeconversion($getdate){
if(trim($getdate)!='0000-00-00 00:00:00' && trim($getdate)!=''){
return date('d-M-Y (h:i A)', strtotime($getdate));
}else{
return '';
}
}
function Exam_Date($getdate){
return date('Y-M-d', strtotime($getdate));
}
function Write_Exam_Date($getdate){
if(trim($getdate)!=''){
return date('d-M-Y', strtotime($getdate));
}else{
return '';	
}
}
function Dateconversion($getdate){
if(trim($getdate)!='0000-00-00'){
return date('d-M-Y', strtotime($getdate));
}else{
return '';
}
}
function Timeconversion($getdate){
if(trim($getdate)!='00:00:00' && trim($getdate)!=''){
return date('(h:i A)', strtotime($getdate));
}else{
return '';
}
}
function Datebreakconversion($getdate){
if(trim($getdate)!='0000-00-00 00:00:00'){
return date('d-m-Y', strtotime($getdate)).'<br>'.date('(h:i A)', strtotime($getdate));
}else{
return '';
}
}
function encode($str){
for($i=0; $i<5;$i++){
$str=strrev(base64_encode($str));
}
return $str;
}
function decode($str){
for($i=0; $i<5; $i++){
$str=base64_decode(strrev($str));
}		
return $str;
}
function Get_Unique_id(){
return random_string('alnum',6);
}
function Get_DynamicId($string,$id){
return $string.$id;
}
function get_otp(){
$otp    = substr(rand(1,1000000),0,6); 
return $otp;
}

function split_str($str) 
{
if(!empty($str)){
$url_name=	strtolower($str);
$url_name1 = stripslashes(str_replace("'", '', $url_name));
$url_name2 = str_replace(str_split('~[\\\\/:&+*?"<>|]~'), '-', $url_name1);
$url_name2 = str_replace(str_split('()'), '', $url_name2);
$url_name3 = preg_replace('/[^A-Za-z0-9]/', '-',$url_name2);
$url_name3 = stripslashes(str_replace("---", '-', $url_name3));
}
return $url_name3;	
}
function str_preg_replace($string){
$string = str_replace(array('[\', \']'), '', $string);
$string = preg_replace('/\[.*\]/U', '', $string);
$string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
$string = htmlentities($string, ENT_COMPAT, 'utf-8');
$string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
$string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
return (trim($string, '-'));
}
function Get_Inference($perc,$tot=1){
if($tot!=0){
return ($perc<=25)?'<span class="red bold">Poor</span>':(($perc>25 && $perc<=50)?'<span class="yellow bold">Average</span>':(($perc>50 && $perc<=75)?'<span class="blue bold">Good</span>':'<span class="green bold">V.Good</span>'));
}else{
return '';	
}
}


function check_cus_login(){ 
$CI= & get_instance();		
$CI->load->library('session');
$CI->load->helper('url');
$user_type=$CI->session->userdata('user_type');
$customer_id=$CI->session->userdata('customer_id');
if($customer_id==''){
redirect(base_url().'login');
}
}

function check_job_seeker_login(){ 
$CI= & get_instance();		
$CI->load->library('session');
$CI->load->helper('url');
$user_type=$CI->session->userdata('user_type');
$job_seeker_id=$CI->session->userdata('job_seeker_id');
if($job_seeker_id==''){
redirect(base_url().'job_seeker/login/');
}
}



function check_emply_login(){ 
$CI= & get_instance();		
$CI->load->library('session');
$CI->load->helper('url');
$user_type=$CI->session->userdata('user_type');
$employer_id=$CI->session->userdata('employer_id');

if($employer_id==''){
redirect(base_url().'employers/login/');
}
}
function Genearate_Password(){
$pwddigt  =  substr(rand(1,1000000),0,4); 
$password =   'PWD'.$pwddigt;
return $password;	
}
function Genearate_job_seeker_id($lastId){
if (strlen($lastId) == 1) {
					$reference_id = 'JSKR'.'000000' .$lastId;
				} else if (strlen($lastId) == 2) {
					$reference_id = 'JSKR'.'00000'.$lastId;
				} else if (strlen($lastId) == 3) {
					$reference_id = 'JSKR'.'0000'.$lastId;
				} else if (strlen($lastId) == 4) {
					$reference_id = 'JSKR'.'000'.$lastId;
				}
				else if (strlen($lastId) == 5) {
					$reference_id = 'JSKR'.'00'.$last_id;
				}
				else if (strlen($last_id) == 6) {
					$reference_id = 'JSKR'.'0'.$last_id;
				}
				else {
					$reference_id = 'JSKR'.$last_id;
				}
	return $reference_id;
}

function Genearate_employer_id($lastId){
if (strlen($lastId) == 1) {
					$reference_id = 'JSKR'.'000000' .$lastId;
				} else if (strlen($lastId) == 2) {
					$reference_id = 'EMPY'.'00000'.$lastId;
				} else if (strlen($lastId) == 3) {
					$reference_id = 'EMPY'.'0000'.$lastId;
				} else if (strlen($lastId) == 4) {
					$reference_id = 'EMPY'.'000'.$lastId;
				}
				else if (strlen($lastId) == 5) {
					$reference_id = 'EMPY'.'00'.$last_id;
				}
				else if (strlen($last_id) == 6) {
					$reference_id = 'EMPY'.'0'.$last_id;
				}
				else {
					$reference_id = 'EMPY'.$last_id;
				}
	return $reference_id;
}

function Genearate_employer_job_id($lastId){
if (strlen($lastId) == 1) {
					$reference_id = 'EJOB'.'000000' .$lastId;
				} else if (strlen($lastId) == 2) {
					$reference_id = 'EJOB'.'00000'.$lastId;
				} else if (strlen($lastId) == 3) {
					$reference_id = 'EJOB'.'0000'.$lastId;
				} else if (strlen($lastId) == 4) {
					$reference_id = 'EJOB'.'000'.$lastId;
				}
				else if (strlen($lastId) == 5) {
					$reference_id = 'EJOB'.'00'.$last_id;
				}
				else if (strlen($last_id) == 6) {
					$reference_id = 'EJOB'.'0'.$last_id;
				}
				else {
					$reference_id = 'EJOB'.$last_id;
				}
	return $reference_id;
}
function Genearate_search_id($lastId){
if (strlen($lastId) == 1) {
					$reference_id = 'SRCH'.'000000' .$lastId;
				} else if (strlen($lastId) == 2) {
					$reference_id = 'SRCH'.'00000'.$lastId;
				} else if (strlen($lastId) == 3) {
					$reference_id = 'SRCH'.'0000'.$lastId;
				} else if (strlen($lastId) == 4) {
					$reference_id = 'SRCH'.'000'.$lastId;
				}
				else if (strlen($lastId) == 5) {
					$reference_id = 'SRCH'.'00'.$last_id;
				}
				else if (strlen($last_id) == 6) {
					$reference_id = 'SRCH'.'0'.$last_id;
				}
				else {
					$reference_id = 'SRCH'.$last_id;
				}
	return $reference_id;
}
function Round_Perc($p){
return round($p,2);
}
function Exam_Tot_Marks($noq,$mrks){
return $noq*$mrks;
}
function Slash_Replace($string){ 
return str_replace(array('\n', '<li>n</li>'), '', $string); 
}