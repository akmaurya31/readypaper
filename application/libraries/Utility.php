<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}
include_once 'confiq.php';
class Utility {
	
	public function otp_send($mobile_number) {
		$otp='';
		for($i=2;$i>0;$i--){
			$otp=$otp.rand(100,999);
		}
		$message='Your OTP for signing up with '.$otp.' is '.$otp.'OTP is valid till '.$otp.' Do not share with anyone Arvizon Global.';
		
		$api_key=SMS_API_KEY;
		$username=SMS_USER_NAME;
		$password=SMS_PASSWORD;	
		$sender=SMS_SENDER_ID;	
		$template_id=SMS_TEMPLATE_ID;	
		$pe_id=SMS_PE_ID;
		
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, "");//http://sms.aahananetworking.com/app/smsapi/index.php
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
        "username=".$username."&password=".$password."&campaign=12032&routeid=101682&type=text&contacts=".urlencode($mobile_number)."&senderid=".urlencode($sender)."&msg=".urlencode($message)."&template_id=".$template_id."&pe_id=".$pe_id);
        $curl_scraped_page=curl_exec($ch);
        		curl_close($ch);
        return $otp;

	}



	
	
}
