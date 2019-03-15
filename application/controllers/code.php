<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Code extends CI_Controller {
	
	function __construct()
	{	
		parent::__construct();
		$this->load->model('code_m');
	}
	
	/**
	 * 경로 : http://setaro.cafe24.com/guesthouse/code/get_subway_regions
	 */
	function get_subway_regions(){        
		$region_keys = $this->code_m->get_subway_regions();
        
        return_data(true, $region_keys);
	}
    
	/**
	 * 경로 : http://setaro.cafe24.com/guesthouse/code/get_subway
	 */
	function get_subway(){	
		$keyword = $this->input->get_post('keyword');
		$subway = $this->code_m->get_subway($keyword);
		
		return_data(true, $subway);
	}
	
	/**
	 * 경로 : http://setaro.cafe24.com/guesthouse/code/get_subway_list
	 */
	function get_subway_list(){
		$params['line'] = $this->input->get_post('line');
		$params['region_type'] = $this->input->get_post('region_type');
		
		$result = $this->code_m->get_subway_list($params);
		
		return_data(true, $result);
	}
	
	/**
	 * 경로 : http://setaro.cafe24.com/guesthouse/code/get_university_list
	 */
	function get_university_list(){
		$keyword = $this->input->get_post('keyword');
		$result_array = $this->code_m->get_university_list($keyword);
		
		return_data(true, $result_array);
	}
	
	/**
	 * 경로 : http://setaro.cafe24.com/guesthouse/code/get_area
	 */
	function get_area(){
		$parent_no = intval($this->input->get_post('parent_no'));
		$data = $this->code_m->get_area($parent_no);
		
		return_data(true, $data);
	}
	
}

?>