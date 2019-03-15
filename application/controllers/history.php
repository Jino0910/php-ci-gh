<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class History extends CI_Controller {
	
	function __construct()
	{	
		parent::__construct();
		$this->load->model('member_m');
		$this->load->model('history_m');
	}
	
	
	/**
	 * 열어본목록 불러오기
	 */
	function get_visit_list(){
	
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'type' => 'visit',
				'start' => ($this->input->get_post('start') != '') ? $this->input->get_post('start') : '0',
				'limit' => ($this->input->get_post('limit') != '') ? $this->input->get_post('limit') : '20'
		);
	
		$param['id'] = $this->member_m->get_authkey_info($param);
	
		$data = $this->history_m->get_visit_list($param);
		return_data(true, $data);
	}
	
	
	/**
	 * 열어본목록 등록하기
	 */
	function reg_visit(){
	
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'shop_no' => ($this->input->get_post('shop_no') != '') ? $this->input->get_post('shop_no') : check_param('shop_no'),
				'type' => 'visit'
		);
	
		$param['id'] = $this->member_m->get_authkey_info($param);
	
		$this->history_m->reg_visit($param);
	}
	
	
	/**
	 * 열어본목록 삭제
	 */
	function remove_visit(){
	
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'no' => ($this->input->get_post('no') != '') ? $this->input->get_post('no') : check_param('no')
		);
	
		$param['id'] = $this->member_m->get_authkey_info($param);
	
		$this->history_m->remove_visit($param);
	}
	
	
	/**
	 * 전화기록 불러오기
	 */
	function get_call_list(){
	
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'type' => 'call',
				'start' => ($this->input->get_post('start') != '') ? $this->input->get_post('start') : '0',
				'limit' => ($this->input->get_post('limit') != '') ? $this->input->get_post('limit') : '20'
		);
	
		$param['id'] = $this->member_m->get_authkey_info($param);
	
		$data = $this->history_m->get_call_list($param);
		return_data(true, $data);
	}
	
	
	/**
	 * 전화기록 등록하기
	 */
	function reg_call(){
	
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'shop_no' => ($this->input->get_post('shop_no') != '') ? $this->input->get_post('shop_no') : check_param('shop_no'),
				'type' => 'call'
		);
	
		$param['id'] = $this->member_m->get_authkey_info($param);
	
		$this->history_m->reg_call($param);
	}
	
	
	/**
	 * 전화기록 삭제하기
	 */
	function remove_call(){
	
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'no' => ($this->input->get_post('no') != '') ? $this->input->get_post('no') : check_param('no')
		);
	
		$param['id'] = $this->member_m->get_authkey_info($param);
	
		$this->history_m->remove_call($param);
	}
	
	
	/**
	 * 전화기록 메모수정삭제
	 */
	function edit_call_memo(){
	
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'memo' => $this->input->get_post('memo'),
				'no' => ($this->input->get_post('no') != '') ? $this->input->get_post('no') : check_param('no')
		);
	
		$param['id'] = $this->member_m->get_authkey_info($param);
	
		$this->history_m->edit_call_memo($param);
	}
}

?>