<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Reservation_m extends CI_model {
	
	function insert_reservation($params){
		
		$sql = "INSERT INTO
					gh_reservation(id, shop_no, product_no, reservation_date, status, comment, create_date)
				VALUES (?, ?, ?, ?, ?, ?, NOW())";
				
		$binding_args = array($params['id'], $params['shop_no'], $params['product_no'], $params['reservation_date'], 'standby', $params['comment']);
		$this->db->query($sql, $binding_args);
		
		return $this->db->affected_rows();
	}
	
	function update_reservation($params){
		$sql = "UPDATE gh_reservation SET status = '{$params['status']}' WHERE id = '{$params['id']}' AND no = {$params['no']}";
		$this->db->query($sql);
		
		return $this->db->affected_rows();
	}
	
}
?>