<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class d_roadmap extends CI_Controller {
	
	function __construct() {
		parent::__construct ();
	}
	
	public function index() {
		$data['h'] = $this->input->get('h');
		$this->load->view("shop/roadmap_v", $data);
	}
	
} 