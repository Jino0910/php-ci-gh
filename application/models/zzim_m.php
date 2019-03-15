<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Zzim_m extends CI_model {
	
	
	/**
	 * 찜목록 불러오기
	 */
	function get_zzim_list($param){

		$addLimit = ($param['start'] != '') ? ' LIMIT '.($param['start'] * $param['limit']).','.$param['limit'] : '';
		$dddWhere = '';
		if($param['type'] == 'shop'){
			$dddWhere .= "and type = 'shop'"; 
		}
		else if ($param['type'] == 'product'){
			$dddWhere .= "and type = 'product'";
		}
		$sql = "SELECT * FROM gh_zzim WHERE id = '{$param['id']}' $dddWhere ORDER BY date desc $addLimit ";
		$data = $this->db->query($sql)->result_array();
		$result['list'] = $data;
	 	
		$sql = "SELECT count(*) cnt FROM gh_zzim WHERE id = '{$param['id']}' $dddWhere";
 		$cnt = $this->db->query($sql)->row()->cnt;
 		$result['total'] = $cnt;
 		$result['page'] = $param['start'];
	
 		return $result;
	}
	
	
	function reg_like($param){
		
		$count = $this->status_like($param);
		
		if($count > 0) return return_data(false,'','이미 좋아요된 글입니다.');
		
		if ($param['type'] == 'shop'){
			$sql = "INSERT INTO gh_zzim (shop_no, id, type) VALUES (?, ?, ?) ";
			$binding_param = array($param['shop_no'], $param['id'], $param['type']);
		}
		else if ($param['type'] == 'product'){
			$sql = "INSERT INTO gh_zzim (shop_no, id, product_no, type) VALUES (?, ?, ?, ?) ";
			$binding_param = array($param['shop_no'], $param['id'], $param['product_no'], $param['type']);
		}
		else {
			return return_data(false,'','타입값을 잘못 입력 하셨습니다.');
		}
		
		$this->db->query($sql, $binding_param);
	
		if($this->db->affected_rows() >= 1) {
			return return_data(true);
		} else
			return return_data(false,'','좋아요가 저장되지 않았습니다.');
	}
	
	function reg_unlike($param){
	
		$count = $this->status_like($param);
	
		if($count == 0) return return_data(false,'','좋아요 되지 않은 글입니다.');
	
		if ($param['type'] == 'shop'){
			$sql = "DELETE FROM gh_zzim WHERE shop_no = ? and id = ?";
			$binding_param = array($param['shop_no'], $param['id']);
		}
		else if ($param['type'] == 'product'){
			$sql = "DELETE FROM gh_zzim WHERE shop_no = ? and id = ? and product_no = ?";
			$binding_param = array($param['shop_no'], $param['id'],  $param['product_no']);
		}
		else{
			return return_data(false,'','타입값을 잘못 입력 하셨습니다.');
		}
		$this->db->query($sql, $binding_param);
	
		if($this->db->affected_rows() >= 1) {
			return return_data(true);
		} else
			return return_data(false,'','좋아요가 삭제되지 않았습니다.');
	}
	
	
	function status_like($param){
	
		$addWhere = '';
		if ($param['type'] == 'product') $addWhere = "and product_no =".$param['product_no'];
		
		$sql = "SELECT count(*) cnt FROM gh_zzim WHERE shop_no = ? $addWhere and id = ?";
		
		$binding_param = array($param['shop_no'], $param['id']);
		$cnt = $this->db->query($sql, $binding_param)->row()->cnt;

		return($cnt);
	}
}