<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class n_blogcafe extends CI_Controller {
	
	function __construct() {
		parent::__construct ();
	}
	
	public function index() {
		ini_set("memory_limit" , -1);
		error_reporting(0);
		
		$base_url = "http://openapi.naver.com/search";
		$api_key = "9d019cf17f0af67c53cd7b87d56bfc1a"; 
		
		$query_string = "?key={$api_key}&";
		$query_string .= urldecode ( $this->input->server ( 'QUERY_STRING' ) )."&sort=sim&target=blog";
		$query_string = $query_string;
		
		$full_url = $base_url . $query_string;

		$xml_data = simplexml_load_string(curl_get_file_contents($full_url));
		$xml_data = json_encode($xml_data);
		$xml_data = json_decode($xml_data,true);
		
		try{
			if($xml_data['channel']['item']['title'])
			{
				$xml_data['channel']['item'] = array( $xml_data['channel']['item'] );
			}
			
			if(!$xml_data['channel']['item'])
			{
				$xml_data['channel']['item']= array();
			}
		}catch(Exception $e)
		{
		}


		exit(json_encode($xml_data));
	}
	
} 