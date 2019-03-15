<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class n_direction extends CI_Controller {
	
	function __construct() {
		parent::__construct ();
	}
	
	public function index() {
		$data['sname'] = $this->input->get('sname');
		$data['ename'] = $this->input->get('ename');
		$data['sx'] = $this->input->get('sx');
		$data['sy'] = $this->input->get('sy');
		$data['ex'] = $this->input->get('ex');
		$data['ey'] = $this->input->get('ey');
		
		
		header("Location:http://m.map.naver.com/route.nhn?menu=route&sname={$data['sname']}&sx={$data['sx']}&sy={$data['sy']}&ename={$data['ename']}&ex={$data['ex']}&ey={$data['ey']}&pathType=1&subMenu=recommend&searchType=0&showMap=true&idx=0");
	}
} 