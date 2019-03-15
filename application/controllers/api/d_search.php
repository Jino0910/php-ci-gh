<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class d_search extends CI_Controller {
	
	function __construct() {
		parent::__construct ();
	}
	
	public function index() {
		
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		
		$base_url = "http://apis.daum.net/local/geo/addr2coord";
		$api_key = "9e62a8853127f27bbb6769cf129398fb188f6c33";
		$param_url = "q=".urlencode($this->input->get_post('q'))."&output=json";
	
		echo json_encode(address_con_wgs84($base_url, $api_key, $param_url));

	}
	
} 