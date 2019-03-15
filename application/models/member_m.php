<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Member_m extends CI_model {
	
	/**
	 * 로그인
	 */
	public function do_login($param)
	{
		//유저정보
		$user = $this->get_user_info($param['id']);
		
		if(!empty($user)){
			
			//유저정보의 비밀번호와 입력된 비밀번호 확인
			if($user['pw'] == md5($param['pw']))
			{
		
				//로그인키가 생성되어 있지 않거나 로그아웃함
				if($this->get_count_user($param) == 0){
					
					//인증키생성
					$auth_key = random_string(10);
		
					//중복된경우 않은 인증키 생성
					while($this->compare_key($auth_key,$param['type']) != 0)
					{
						$auth_key = random_string(10);
					}
					
					//인증키 등록
					$sql = "INSERT INTO gh_authkey (id, type, authkey) VALUES (?, ?, ?)";
					$sql_param = array($param['id'], $param['type'], $auth_key);
					$this->db->query($sql, $sql_param);
		
					if($this->db->affected_rows() >= 1) {
						return return_data(true,$auth_key);
					} else
						return return_data(false,'','인증번호 생성에 실패 하였습니다.');
				}
				else {
					return return_data(true,$this->get_login_auth_key($param));
				}
			}
			else{
				return_data(false,'','비밀번호가 맞지 않습니다.');
			}
		}
		else{
			return_data(false,'','아이디를 확인하여 주십시오.');
		}
	}
	
	
	/**
	 * 계정정보 불러오기
	 */
	public function compare_key($key,$type)
	{
		$sql = "SELECT COUNT(*) cnt FROM gh_authkey WHERE authkey = '{$key}' and type = '{$type}'";
		$cnt = $this->db->query($sql)->row()->cnt;
		return $cnt;
	}
	
	
	/**
	 * 인증키 불러오기
	 */
	public function get_login_auth_key($param)
	{
		$sql = "SELECT authkey FROM gh_authkey WHERE id = '{$param['id']}'";
		$result = $this->db->query($sql)->row()->authkey;
		return $result;
	}
	
	/**
	 * id에 따른 인증키 생성여부
	 */
	public function get_count_user($param)
	{
		$sql = "SELECT count(*) cnt FROM gh_authkey WHERE id = '{$param['id']}'";
		$result = $this->db->query($sql)->row()->cnt;
		return $result;
	}
	
	
	/**
	 * 계정정보 불러오기
	 */
	public function get_user_info($id = '')
	{
		if(!$id) $id = get_user_info('id');
		$data = $this->db->query("SELECT * FROM gh_member WHERE id = ? ", $id)->row_array();
		return $data;
	}
	
	
	/**
	 * 로그아웃
	 */
	public function do_logout($param)
	{
		$sql = "DELETE FROM gh_authkey WHERE authkey = ? AND type = ?";
		$binding_param = array($param['authkey'], $param['type']);
		$this->db->query($sql, $binding_param);
	
		if($this->db->_error_number() >= 1) {
			return return_data(false,'','로그아웃에 실패했습니다.');
		} else
			return return_data(true);
	}
	
	/**
	 * authkey값 이용하여 id값 불러오기
	 */
	public function get_authkey_info($param)
	{
		error_reporting(0);
		$id = $this->db->query("SELECT id FROM gh_authkey WHERE authkey = ? and type = 'login' ", $param['authkey'])->row()->id;
	
		if(empty($id))
			return return_data(false,'','로그인이 만료 되었습니다.');
	
		return $id;
	}
	
	
	/**
	 * 회원가입
	 */
	public function reg_member($param)
	{
		//변수처리
		extract($param);
	
		$id = strtolower($param['id']);
	
		if(preg_match("/[-.#\&\+\%@=\/\\\:;,\'\"\^`~\_|\!\?\*$# ()\[\]\{\}]/i", $id))
			return return_data(false,'','아이디에 특수 기호를 사용할수 없습니다.');
	
		if($pw != $pw_chk)
			return return_data(false,'','비밀번호와 비밀번호 확인 항목이 서로 다릅니다.');
	
		// 중복 체크 id
		$chk_result = $this->chk_overwrap('id', $id);
		if($chk_result != true) return $chk_result;
		
		// 중복 체크 email
		$chk_result = $this->chk_overwrap('email', $email);
		if($chk_result != true) return $chk_result;
	
		// 중복 체크 name
		$chk_result = $this->chk_overwrap('name', trim($name));
		if($chk_result != true) return $chk_result;
	
		$sql = "INSERT INTO gh_member SET id = ?, pw = ?, name = ?, email = ?, level = ?";
	
		$sql_param = array($id, md5($pw), trim($name), $email, $level);
		$this->db->query($sql, $sql_param);
	
		if($this->db->affected_rows() >= 1) {
			return return_data(true);
		} else
			return return_data(false,'','회원 가입 데이터 입력에 실패했습니다.');
	}
	
	
	/**
	 * 회원정보 수정
	 */
	public function reg_modify($param)
	{
		extract($param);
		
		$user = $this->get_user_info($id);

		// 중복 체크 한번더
		if($pw != $pw_chk)
			return return_data(false,'','비밀번호와 비밀번호 확인 항목이 서로 다릅니다.');
	
		if($email != $user['email']){
			$chk_result = $this->chk_overwrap('email', $email);
			if($chk_result != true) return $chk_result;
		}
	
		if(trim($name) != $user['name']){
			$chk_result = $this->chk_overwrap('name', trim($name));
			if($chk_result != true) return $chk_result;
		}
	
		$pw = ($pw) ? md5($pw) : $user['pw'];
		$name = ($name) ? $name : $user['name'];
		$email = ($email) ? $email : $user['email'];

		$sql = "UPDATE gh_member SET pw = ?, name = ?, email = ? WHERE id = ?";
		$sql_param = array($pw, trim($name), $email, $id);
		$this->db->query($sql, $sql_param);
	
		if($this->db->_error_number() >= 1) {
			return return_data(false,'','회원 정보 수정에 실패했습니다.');
		} else
			return return_data(true);
	}
	
	
	/**
	 * 중복검사
	 */
	public function chk_overwrap($key, $val)
	{
		$sql = "SELECT COUNT(*) cnt FROM gh_member WHERE {$key} = ? ";
		$tmp = $this->db->query($sql, $val)->row()->cnt;
	
		if($tmp) {
			if($key == 'id')
				return return_data(false,'',$val.'는 이미 쓰이고 있는 아이디입니다.');
			else if($key == 'email')
				return return_data(false,'',$val.'는 이미 쓰이고 있는 메일주소입니다.');
			else if($key == 'name')
				return return_data(false,'',$val.'는 이미 쓰이고 있는 이름입니다.');
		} else
			return true;
	}	
}

?>