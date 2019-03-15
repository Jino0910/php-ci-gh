<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Zzim extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('member_m');
		$this->load->model('zzim_m');
	}
	
	
	/**
	 * 찜목록 불러오기
	 */
	function get_zzim_list(){
	
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'type' => ($this->input->get_post('type') != '') ? $this->input->get_post('type') : '',
				'start' => ($this->input->get_post('start') != '') ? $this->input->get_post('start') : '0',
				'limit' => ($this->input->get_post('limit') != '') ? $this->input->get_post('limit') : '20'
		);
	
		$param['id'] = $this->member_m->get_authkey_info($param);
	
		$data = $this->zzim_m->get_zzim_list($param);
		return_data(true, $data);
	}
	
	/**
	 * 찜 하기
	 */
	function reg_like(){
	
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'shop_no' => ($this->input->get_post('shop_no') != '') ? $this->input->get_post('shop_no') : check_param('shop_no'),
				'product_no' => ($this->input->get_post('product_no') != '') ? $this->input->get_post('product_no') : '',
				'type' => ($this->input->get_post('type') != '') ? $this->input->get_post('type') : check_param('type')
		);
	
		$param['id'] = $this->member_m->get_authkey_info($param);
	
		$this->zzim_m->reg_like($param);
	}
	
	/**
	 * 찜 취소
	 */
	function reg_unlike(){
	
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'shop_no' => ($this->input->get_post('shop_no') != '') ? $this->input->get_post('shop_no') : check_param('shop_no'),
				'product_no' => ($this->input->get_post('product_no') != '') ? $this->input->get_post('product_no') : '',
				'type' => ($this->input->get_post('type') != '') ? $this->input->get_post('type') : check_param('type')
		);
	
		$param['id'] = $this->member_m->get_authkey_info($param);
	
		$this->zzim_m->reg_unlike($param);
	}
}