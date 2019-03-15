<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('member_m');
		$this->load->model('shop_m');
	}
	
	/**
	 * 업체등록
	 * 경로 : http://setaro.cafe24.com/guesthouse/shop/reg_shop
	 */
	function reg_shop()
	{
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'name' => ($this->input->get_post('name') != '') ? $this->input->get_post('name') : check_param('name'),
				'address' => ($this->input->get_post('address') != '') ? $this->input->get_post('address') : check_param('address'),
				'comment' => ($this->input->get_post('comment') != '') ? $this->input->get_post('comment') : check_param('comment'),
				'manager_name' => ($this->input->get_post('manager_name') != '') ? $this->input->get_post('manager_name') : check_param('manager_name'),
				'tel' => ($this->input->get_post('tel') != '') ? $this->input->get_post('tel') : check_param('tel'),
				'latitude' => ($this->input->get_post('latitude') != '') ? $this->input->get_post('latitude') : check_param('latitude'),
				'longitude' => ($this->input->get_post('longitude') != '') ? $this->input->get_post('longitude') : check_param('longitude'),
				'price' => ($this->input->get_post('price') != '') ? $this->input->get_post('price') : '1.2.3.4.5.6',
				'target' => ($this->input->get_post('target') != '') ? $this->input->get_post('target') : '1',
				'etc' => ($this->input->get_post('etc') != '') ? $this->input->get_post('etc') : 'S.T.C.P.W'
		);
		
		$param['id'] = $this->member_m->get_authkey_info($param);
		
// 		$file = $_FILES['file'];	
// 		if($file)
// 		{
// 			$param['no'] = $this->shop_m->get_shop_no();
// 			// 파일 삽입
// 			$this->shop_m->put_image($param, $file);
// 		}
		
		$this->shop_m->reg_shop($param);
	}
	
	
	/**
	 * 업체수정
	 * 주소 : http://setaro.cafe24.com/guesthouse/shop/mod_shop
	 */
	function mod_shop()
	{
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'no' => ($this->input->get_post('no') != '') ? $this->input->get_post('no') : check_param('no'),
				'name' => ($this->input->get_post('name') != '') ? $this->input->get_post('name') : '',
				'address' => ($this->input->get_post('address') != '') ? $this->input->get_post('address') : '',
				'comment' => ($this->input->get_post('comment') != '') ? $this->input->get_post('comment') : '',
				'tel' => ($this->input->get_post('tel') != '') ? $this->input->get_post('tel') : '',
				'latitude' => ($this->input->get_post('latitude') != '') ? $this->input->get_post('latitude') : '',
				'longitude' => ($this->input->get_post('longitude') != '') ? $this->input->get_post('longitude') : '',
				'price' => $this->input->get_post('price'),
				'target' => $this->input->get_post('target'),
				'etc' => $this->input->get_post('etc')
		);
	
		$param['id'] = $this->member_m->get_authkey_info($param);
	
		$this->shop_m->mod_shop($param);
	}
	
	
	/**
	 * 업체 핀정보 
	 * 주소 : http://setaro.cafe24.com/guesthouse/shop/get_shop_pin
	 */
	function get_shop_pin()
	{
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'type' => ($this->input->get_post('type') != '') ? $this->input->get_post('type') : 'map',
				'radius' => ($this->input->get_post('radius') != '') ? $this->input->get_post('radius') : '1000',
				'latitude' => ($this->input->get_post('latitude') != '') ? $this->input->get_post('latitude') : '',
				'longitude' => ($this->input->get_post('longitude') != '') ? $this->input->get_post('longitude') : '',
				'start' => ($this->input->get_post('start') != '') ? $this->input->get_post('start') : '0',
				'limit' => ($this->input->get_post('limit') != '') ? $this->input->get_post('limit') : '20'
		);
	
		$param['id'] = $this->member_m->get_authkey_info($param);

		$data = $this->shop_m->get_shop_pin($param);
		return_data(true, $data);
		
	}
}