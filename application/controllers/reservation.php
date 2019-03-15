<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('member_m');
		$this->load->model('reservation_m');
	}
	
	function insert(){
		$params['shop_no'] = $this->input->get_post('shop_no');
		//$params['product_no'] = $this->input->get_post('product_no');
		$params['comment'] = $this->input->get_post('comment');
		$params['reservation_date'] = $this->input->get_post('reservation_date');
		
		$params['authkey'] = $this->input->get_post('authkey');
		$params['id'] = $this->member_m->get_authkey_info($params);
		
		$inserted_row_no = $this->reservation_m->insert_reservation($params);
        
		if($inserted_row_no == 1) return_data(true, '', "정상적으로 예약되었습니다.");
		else return_data(false, '', "예약에 문제가 있습니다.");
	}
	
	function update(){
		$params['no'] = $this->input->get_post('reservation_no');
		$params['status'] = $this->input->get_post('status');
		$params['authkey'] = $this->input->get_post('authkey');
		$params['id'] = $this->member_m->get_authkey_info($params);
		
		$updated_row_no = $this->reservation_m->update_reservation($params);
		
		if($updated_row_no == 1) return_data(true, '', "정상적으로 수정되었습니다.");
		else return_data(false, '', "수정에 문제가 있습니다.");
	}
	
	function select(){
		
		
	}
	
	
	
}

?>