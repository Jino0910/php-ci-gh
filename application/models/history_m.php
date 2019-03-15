<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class History_m extends CI_model {
	

	/**
	 * 열어본목록 불러오기
	 */
	function get_visit_list($param){
	
		$addLimit = ($param['start'] != '') ? ' LIMIT '.($param['start'] * $param['limit']).','.$param['limit'] : '';

		$sql = "SELECT h.*, s.name, s.address, s.tel, s.latitude, s.longitude FROM gh_history as h
				JOIN gh_shop as s ON (h.shop_no = s.no)
				WHERE id = '{$param['id']}' and type = ? ORDER BY date desc $addLimit ";
		$binding_param = array($param['type']);
		$data = $this->db->query($sql, $binding_param)->result_array();
		$result['list'] = $data;
// 		debug($this->db->last_query());exit;
		$sql = "SELECT count(*) cnt FROM gh_history WHERE id = '{$param['id']}' and type = ?";
		$cnt = $this->db->query($sql, $binding_param)->row()->cnt;
		$result['total'] = $cnt;
		$result['page'] = $param['start'];
	
		return $result;
	}
	
	
	/**
	 * 열어본목록 등록하기
	 */
	function reg_visit($param){
		
		$count = $this->status_visit($param);
		if($count > 0){
			
			$no = $this->db->query("SELECT * FROM gh_history WHERE shop_no = ? and type = ?", $binding_param = array($param['shop_no'], $param['type']))->row()->no;

			$sql = "UPDATE gh_history SET date = now() WHERE no = ?";
			$binding_param = array($no);
			$this->db->query($sql, $binding_param);
			return return_data(true);
		}
		else{
			$sql = "INSERT INTO gh_history (shop_no, id, type) VALUES (?, ?, ?) ";
			$binding_param = array($param['shop_no'], $param['id'], $param['type']);
			$this->db->query($sql, $binding_param);
		}
	
		if($this->db->affected_rows() >= 1) {
			return return_data(true);
		} else
			return return_data(false,'','목록에 등록 실패하였습니다.');
	}
	
	
	/**
	 * 열어본목록 삭제하기
	 */
	function remove_visit($param){
	
		$count = $this->db->query("SELECT count(*) cnt FROM gh_history WHERE no = ? ", $param['no'])->row()->cnt;

		if($count > 0){
			$sql = "DELETE FROM gh_history WHERE no = ?";
			$binding_param = array($param['no']);
		}
		else{
			return return_data(false,'','열어본목록이 없는 업체입니다.');
		}
		$this->db->query($sql, $binding_param);
	
		if($this->db->affected_rows() >= 1) {
			return return_data(true);
		} else
			return return_data(false,'','목록을 삭제 실패하였습니다.');
	}
	
	function status_visit($param){
	
		$sql = "SELECT count(*) cnt FROM gh_history WHERE shop_no = ? and id = ? and type = ?";
	
		$binding_param = array($param['shop_no'], $param['id'], $param['type']);
		$cnt = $this->db->query($sql, $binding_param)->row()->cnt;
	
		return($cnt);
	}
	
	
	
	/**
	 * 전화기록 불러오기
	 */
	function get_call_list($param){
	
		$addLimit = ($param['start'] != '') ? ' LIMIT '.($param['start'] * $param['limit']).','.$param['limit'] : '';
	
		$sql = "SELECT h.*, s.name, s.address, s.tel, s.latitude, s.longitude FROM gh_history as h
					JOIN gh_shop as s ON (h.shop_no = s.no)
				WHERE id = '{$param['id']}' and type = ? ORDER BY date desc $addLimit ";
		$binding_param = array($param['type']);
		$data = $this->db->query($sql, $binding_param)->result_array();
			$result['list'] = $data;
				
		$sql = "SELECT count(*) cnt FROM gh_history WHERE id = '{$param['id']}' and type = ?";
		$cnt = $this->db->query($sql, $binding_param)->row()->cnt;
		$result['total'] = $cnt;
		$result['page'] = $param['start'];
	
		return $result;
	}
	
	
	/**
	 * 전화기록하기
	 */
	function reg_call($param){
	
		$sql = "INSERT INTO gh_history (shop_no, id, type) VALUES (?, ?, ?) ";
		$binding_param = array($param['shop_no'], $param['id'], $param['type']);
		$this->db->query($sql, $binding_param);
	
		if($this->db->affected_rows() >= 1) {
			return return_data(true);
		} else
			return return_data(false,'','전화기록을 실패하였습니다.');
	}
	
	
	/**
	 * 전화기록 삭제하기
	 */
	function remove_call(){
	
		$count = $this->db->query("SELECT count(*) cnt FROM gh_history WHERE no = ? ", $param['no'])->row()->cnt;
	
		if($count > 0){
			$sql = "DELETE FROM gh_history WHERE no = ?";
			$binding_param = array($param['no']);
		}
		else{
			return return_data(false,'','전화기록에 없는 업체입니다.');
		}
		$this->db->query($sql, $binding_param);
	
		if($this->db->affected_rows() >= 1) {
			return return_data(true);
		} else
			return return_data(false,'','전화기록을 삭제 실패하였습니다.');
	}
	
	
	/**
	 * 전화기록 메모수정삭제
	 */
	function edit_call_memo($param){
	
		$sql = "UPDATE gh_history SET memo = ? WHERE no = ?";
		$binding_param = array($param['memo'], $param['no']);
		$this->db->query($sql, $binding_param);
		return return_data(true);
	}
}

?>