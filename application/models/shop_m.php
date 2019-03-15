<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Shop_m extends CI_model {
	
	
	/**
	 * 업체 등록
	 */
	function reg_shop($param)
	{
		$member_no = $this->db->query("SELECT no FROM gh_member WHERE id = ?", $param['id'])->row()->no;
		
		$sql = "INSERT INTO
					gh_shop (member_no, name, address, comment, manager_name, tel, latitude, longitude, create_date)
				VALUES
					(?, ?, ?, ?, ?, ?, ?, ?, now())
		";
		$binding_param = array(
				$member_no, $param['name'], $param['address'], $param['comment'], $param['manager_name'], $param['tel'], $param['latitude'], $param['longitude']
		);
		$this->db->query($sql, $binding_param);
		
		$sql = "INSERT INTO
					gh_shop_option (shop_no, price, target, etc)
				VALUES
					(?, ?, ?, ?)
		";
		$binding_param = array(
				$this->db->insert_id(), $param['price'], $param['target'], $param['etc']
		);
		$this->db->query($sql, $binding_param);
		
		
		return_data(true);
	}
	
	
	/**
	 * 업체 수정
	 */
	function mod_shop($param)
	{
		$shop_info = $this->db->query("SELECT * FROM gh_shop WHERE no = ? ", $param['no'])->row_array();

		$sql = "UPDATE gh_shop SET
					name = ?, address = ?, comment = ?, manager_name = ?, tel = ?, latitude = ?, longitude = ?
				WHERE
					no = ?
		";
		$binding_param = array(
				(($param['name'])?$param['name']:$shop_info['name']), (($param['address'])?$param['address']:$shop_info['address']), 
				(($param['comment'])?$param['comment']:$shop_info['comment']), (($param['manager_name'])?$param['manager_name']:$shop_info['manager_name']), 
				(($param['tel'])?$param['tel']:$shop_info['tel']), (($param['latitude'])?$param['latitude']:$shop_info['latitude']), 
				(($param['longitude'])?$param['longitude']:$shop_info['longitude']), $param['no']
		);
		$this->db->query($sql, $binding_param);
		
		$shop_info = $this->db->query("SELECT * FROM gh_shop_option WHERE shop_no = ? ", $param['no'])->row_array();
		
		$sql = "UPDATE gh_shop_option SET
					price = ?, target = ?, etc = ?
				WHERE
					shop_no = ?
		";
		$binding_param = array(
				(($param['price'])?$param['price']:$shop_info['price']), (($param['target'])?$param['target']:$shop_info['target']),
				(($param['etc'])?$param['etc']:$shop_info['etc']), $param['no']
		);
		
		
		$this->db->query($sql, $binding_param);
		return_data(true);
	}
	
	
	
	/**
	 * 입력될 업체 no
	 */
	public function get_shop_no($param)
	{
		$no = $this->db->query("SELECT max(no) as no FROM gh_shop")->row()->no;
		return($no);
	}

	
	/**
     * 업로드한 사진으로 파일테이블에 삽입
     */
    public function insert_file($param, $file_info){
    	$sql = "INSERT INTO gh_file (`shop_no`, 'type', `file_name`, `original_file_name`, `path`, `file_length`, `image_width`, `image_height`, `extension`)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    	$binding_param = array($param['no'], $param['type'], $file_info['name'], $file_info['original_name'], $file_info['folder'], $file_info['size'], $file_info['width'], $file_info['height'], $file_info['extension']);
    	$this->db->query($sql, $binding_param);
    }
    
    
    /**
     * 업로드한 사진으로 파일테이블에 수정
     */
    public function update_file($param, $file_info){
    	$sql = "UPDATE gh_file SET `file_name` = ?, `original_file_name` = ?, `path` = ?, `file_length` = ?, `image_width` = ?, `image_height` = ?, `extension` = ?
    				WHERE `no` = ? and type = ?";
    	$binding_param = array($file_info['name'], $file_info['original_name'], $file_info['folder'], $file_info['size'], $file_info['width'], $file_info['height'], $file_info['extension'], $param['no'], $param['type']);
    	$this->db->query($sql, $binding_param);
    
    	return $this->db->affected_rows();
    }
    
    
    /**
     * 파일번호에 해당하는 파일 삭제
     */
    public function delete_file($param){
    	$sql = "DELETE FROM gh_file WHERE no = ? AND shop_no = ?";
    	$binding_param = array($param['no'], $param['shop_no']);
    	$this->db->query($sql, $binding_param);
    
    	return $this->db->affected_rows();
    }
    
    
    /**
     * 파일정보를 가저온다.
     */
    public function select_file($shop_no, $file_no=''){
    	
    	$returnValue = '';
    	
    	if($file_no){
    		$addWhere = ' AND `no` = ?';
	    	$binding_param = array($shop_no, $file_no);
    	} else {
    		$addWhere = '';
    		$binding_param = array($shop_no);
    	}
    	
    	$sql = "SELECT * FROM gh_file WHERE shop_no = ?".$addWhere." ORDER BY no ASC";
    	
    	$rs = $this->db->query($sql, $binding_param);
    	
    	if($file_no){
    		$returnValue = $rs->row_array();
    	} else {
    		$returnValue = $rs->result_array();
    	}
    	 
    	return $returnValue;
    }
    
    
    /**
     * 파일 등록
     */
    public function put_image($param, $files, $limit = 10){
    	 
    	$returnValue = true;
    	 
    	$image = $this->get_image($param['no']);
    	$image_count = count($image);
    	
    	if($image_count < $limit){
    		$file_info = $this->upload_image_file($param['id'], $files);

    		if($file_info['result'])  $this->insert_file($param, $file_info);
    		
    	} else {
    		return return_data(false,'','한번에 올릴수 있는 이미지는 10장으로 제한되어 있습니다.');
    	}

    }
    

    public function get_image($no){
    	$files = $this->select_file($no);
    	return $files;
    }
	
    /**
     * 이미지를 업로드한다.
     * ['original_name'] 	=> 원래 파일이름
     * ['name'] 			=> 새로운 파일이름
     * ['extension'] 		=> 확장자
     * ['size'] 			=> 파일 크기
     * ['folder'] 			=> 업로드 될 폴더
     * ['path'] 			=> 파일 절대 주소
     * ['width'] 			=> 이미지 너비
     * ['height'] 			=> 이미지 높이
     * ['result'] 			=> 업로드 결과
     * ['error'] 			=> 에러
     * ['thumb']			=> 썸네일 절대 주소
     *
     * @param string $user_id 유저 아이디
     * @param string $file 파일
     * @return array 파일정보가 들어있는 배열
     */
	private function upload_image_file($user_id, $file){
    
    	$data = array();
    	// 파일 이름
    	$data['original_name'] = $file['name'];
    	// 확장자 구하기
    	$data['extension'] = substr(strrchr($file['name'], '.'), 1);
    	// 파일 크기
    	$data['size'] = $file['size'];
    	// 에러
    	$data['error'] = $file['error'];
    
    	// 업로드 폴더
    	$data['folder'] = "/home/hosting_users/setaro/www/guesthouse/image/{$user_id}/";
    	// 없는 경우 생성
    	if(!is_dir($data['folder'])) @mkdir($data['folder'], 0777);
    
    	// 새로운 파일명 (시간으로 생성)
    	$unique_time = preg_replace("/\s+/", "", microtime());
    	$data['name'] = $unique_time.".".$data['extension'];
    
    	// 업로드된 파일이 위치할 절대 주소
    	$data['path'] = $data['folder'] . $data['name'];
    	$data['thumb'] = $data['folder'] . "t_".$data['name'];
    
    	// 업로드에 성공하면 디비에 입력
    	if (move_uploaded_file($file['tmp_name'], $data['path'])) {
    
    		$data['folder'] = "/guesthouse/image/{$user_id}/";
    
    		// 이미지 크기 정보 구하기
    		$image_info = getimagesize($data['path']);
    
    		$data['width'] = $image_info[0];
    		$data['height'] = $image_info[1];
    
    		$data['result'] = true;
    
    		GlistThumb($data['path'], $data['thumb'], 100);
    	} else {
    		$data['result'] = false;
    	}
    
    	return $data;
    }
    
    
    /**
     * 지도 정보들
     */
 	public function get_shop_pin($param){
 		
 		//위치정보 등록
 		if(!empty($param['latitude']) && !empty($param['longitude'])){
 			//기존의 위치정보 데이터확인
 			$cnt = $this->db->query("SELECT * FROM gh_location WHERE id = '{$param['id']}'")->row()->cnt;
 		
 			if ($cnt>0) {
 				$sql = "UPDATE gh_location SET latitude = ? , longitude = ? WHERE id = ?";
				$binding_param = array($param['latitude'], $param['longitude'], $param['id']);
 				$this->db->query($sql, $binding_param);
 			}
 			else{
 				$sql = "INSERT INTO gh_location (id, latitude, longitude) VALUES (?, ?, ?)";
 				$binding_param = array($param['id'], $param['latitude'], $param['longitude']);
 				$this->db->query($sql, $binding_param);
 			}
 		}
 		
 		$my_location = $this->db->query("SELECT * FROM gh_location WHERE id = '{$param['id']}'")->row_array();
 		
 		if ($param['type'] != 'map')
 		$addWhere = ($param['start'] != '') ? ' LIMIT '.($param['start'] * $param['limit']).','.$param['limit'] : '';
 		// * 상수 3959 = 마일 단위  6371 = 킬로미터 단위
  		$sql = "SELECT	
 					*, ( 6371 * acos( cos( radians(?) ) * cos( radians(latitude) ) * cos( radians(longitude)
 						 - radians(?) ) + sin( radians(?) ) * sin( radians(latitude) ) ) ) AS distance
  				FROM gh_shop
  					HAVING distance < ?
  					ORDER BY distance
  				$addWhere;

 				";
  		$binding_param = array($my_location['latitude'], $my_location['longitude'], $my_location['latitude'], $param['radius']);
 		$data = $this->db->query($sql, $binding_param)->result_array();
 		$result['list'] = $data;
// 		debug($this->db->last_query());
 		$sql = "SELECT count(*) cnt FROM (SELECT
			 		( 6371 * acos( cos( radians(?) ) * cos( radians(latitude) ) * cos( radians(longitude)
		 			- radians(?) ) + sin( radians(?) ) * sin( radians(latitude) ) ) ) AS distance
				FROM gh_shop
					HAVING distance < ?) as rst";
		$cnt = $this->db->query($sql, $binding_param)->row()->cnt;
		$result['total'] = $cnt;
		$result['page'] = $param['start'];
			
		return $result;
 		
 	}
 	
}