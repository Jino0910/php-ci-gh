<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends CI_Controller {
	
	function __construct()
	{	
		parent::__construct();
		$this->load->model('sms_m');
	}
	
	function send_verify_sms(){
		
		$params['send_number'] = "0200000000";
		$params['receive_number'] = $this->input->get_post('to');

		$r = $this->sms_m->select_sign_up_lastest_sms($params['receive_number']);
		
		if($r){
			$now = time();
			$time = strtotime($r['send_time']);
			
			$diff = $now - $time;
			
			if($diff < 30) {
				return_data(false, '', '인증번호를 받은지 30초 이후에 재 발송 가능합니다. ');
			}
		}
		
		$number = rand(100000, 999999);
		$params['message'] = "인증번호는 [{$number}] 입니다.";
		
		$cnt = $this->sms_m->send_sms($params);
		
		if($cnt == 1) return_data(true, '', "성공적으로 발송되었습니다.");
		else return_data(false, '', "발송에 실패하였습니다.");
		
	}
	
	function verify_sms(){
		
		$to = $this->input->get_post('to');
		$auth_no = $this->input->get_post('auth_no');
		
		$row = $this->sms_m->select_sign_up_lastest_sms($to);
		
		if($row){
			$now = time();
			$time = strtotime($row['send_time']);
				
			$diff = $now - $time;
				
			if($diff < 180) {
				$no = preg_replace("/[^0-9]/", "", $row['message']);
				if($no == $auth_no) return_data(true, '', "인증에 성공하셨습니다.");
			} else {
				return_data(false, '', "인증 문자를 받은지 3분 이내에 인증하셔야합니다.");
			}
		}
		
		return_data(false, '', "인증에 실패하습니다.");
	}
	
}

?>