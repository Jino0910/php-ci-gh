<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class sm extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('layout', 'layouts/shop_v');
		$this->layout->setLayout("layouts/shop_v");
	}
	
	function index(){
		$this->layout->view('shop/test_v');
	}
	
	function login(){
		$this->load->view('shop/login_v');
	}
	
	function sign_up(){
		$this->load->view('shop/sign_up_v');		
	}
}