<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Sms_m extends CI_model {
	
	function send_sms($params){
		
		$sql = "INSERT INTO gh_sms_history(send_number, receive_number, message, send_time, type)
				VALUES ('{$params['send_number']}', '{$params['receive_number']}', '{$params['message']}', NOW(), 'sign_up')";
		
		$this->db->query($sql);
		
		return $this->db->affected_rows();
	}
	
	function select_sign_up_lastest_sms($number){
		
		$sql = "SELECT * FROM gh_sms_history WHERE receive_number = '{$number}' AND type = 'sign_up' ORDER BY send_time DESC";
		
		return $this->db->query($sql)->row_array();
	}
	
    
}

?>