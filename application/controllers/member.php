<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('member_m');
	}
	
	/**
	 * 로그인
	 * 경로 : http://setaro.cafe24.com/guesthouse/member/do_login
	 */
	function do_login()
	{
		$param = array(
				'id' => ($this->input->get_post('id') != '') ? $this->input->get_post('id') : check_param('id'),
				'pw' => ($this->input->get_post('pw') != '') ? $this->input->get_post('pw') : check_param('pw'),
				'type' => 'login'
		);
		$data = $this->member_m->do_login($param);
	}
	
	
	
	/**
	 * 로그아웃
	 * 경로 : http://setaro.cafe24.com/guesthouse/member/do_logout
	 */
	function do_logout()
	{
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'type' => 'login'
		);
	
		$data = $this->member_m->do_logout($param);
	}
	
	
	
	/**
	 * 회원가입
	 * 경로 : http://setaro.cafe24.com/guesthouse/member/reg_member
	 */
	function reg_member()
	{
		$param = array(
				'id' => ($this->input->get_post('id') != '') ? $this->input->get_post('id') : check_param('id'),
				'pw' => ($this->input->get_post('pw') != '') ? $this->input->get_post('pw') : check_param('pw'),
				'pw_chk' => ($this->input->get_post('pw_chk') != '') ? $this->input->get_post('pw_chk') : check_param('pw_chk'),
				'name' => ($this->input->get_post('name') != '') ? $this->input->get_post('name') : check_param('name'),
				'email' => ($this->input->get_post('email') != '') ? $this->input->get_post('email') : check_param('email'),
				'level' => ($this->input->get_post('level') != '') ? $this->input->get_post('level') : check_param('level')
		);
	
		$this->member_m->reg_member($param);
	}
	
	
	/**
	 * 회원정보 수정
	 * 경로 : http://setaro.cafe24.com/guesthouse/member/reg_modify
	 */
	function reg_modify()
	{
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
				'pw' => ($this->input->get_post('pw') != '') ? $this->input->get_post('pw') : check_param('pw'),
				'pw_chk' => ($this->input->get_post('pw_chk') != '') ? $this->input->get_post('pw_chk') : check_param('pw_chk'),
				'name' => ($this->input->get_post('name') != '') ? $this->input->get_post('name') : check_param('name'),
				'email' => ($this->input->get_post('email') != '') ? $this->input->get_post('email') : check_param('email')
		);

		$param['id'] = $this->member_m->get_authkey_info($param);

		$this->member_m->reg_modify($param);
	}
	
	
	/**
	 * 회원정보 불러오기
	 * 경로 : http://setaro.cafe24.com/guesthouse/member/get_modify
	 */
	function get_user_info()
	{
		$param = array(
				'authkey' => ($this->input->get_post('authkey') != '') ? $this->input->get_post('authkey') : check_param('authkey'),
		);
	
		$data = $this->member_m->get_user_info($this->member_m->get_authkey_info($param));
		return_data(true, $data);
	}
	
	function temp(){
		
		// AES256 공용 암호화 라이브러리 사용
		$this->load->library('aes256_lib');
		$encode_str = $this->aes256_lib->AES_Encode('str');
	}
}

?>