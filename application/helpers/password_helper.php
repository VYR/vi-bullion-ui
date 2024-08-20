<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	#-----------------------------------
	# To Generate Random Password
	#-----------------------------------
	function password(){
		return rand(10000000,99999999);
	}    	#-----------------------------------
	# To Encrypt Password $this->load->helper('pwdencdec_helper'); $encpwd = encode5t("asdasd");
	#-----------------------------------
	function encode5t($str){
			for($i=0; $i<5;$i++){
			$str=strrev(base64_encode($str));
			//apply base64 first and then reverse the string
		}
		return $str;
	}
	#-----------------------------------
	# To Decrypt Password $this->load->helper('pwdencdec_helper'); $encpwd = decode5t("asdasd");
	#-----------------------------------
	function decode5t($str){
		
		for($i=0; $i<5; $i++){
			$str=base64_decode(strrev($str));
			
			//apply base64 first and then reverse the string
		}	
	
		return $str;
	}
?>
