<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class Code_m extends CI_model {
	
    function get_subway_regions(){
        $sql = "SELECT region_type FROM gh_subway GROUP BY region_type";
        $result_array = $this->db->query($sql)->result_array();
        return $result_array;
    }
    
    function get_subway($name){
        $sql = "SELECT * FROM gh_subway WHERE name LIKE '%{$name}%'";
		return $this->db->query($sql)->result_array();
    }
	
	function get_subway_list($params){
		$sql = "select
					*
				from
					gh_subway
				where
					region_type = '{$params['region_type']}'
					and line like '%{$params['line']}%'
				order by name";
				
		return $this->db->query($sql)->result_array();
	}
    
    function get_university_list($letter){
    	$sql = "SELECT * FROM gh_university WHERE ";

    	switch ($letter){
    		case "가": $sql .= "(name RLIKE '^(ㄱ|ㄲ)' OR ( name >= '가' AND name < '나' ))"; 	break;
    		case "나": $sql .= "(name RLIKE '^ㄴ' OR ( name >= '나' AND name < '다' ))"; 		break;
    		case "다": $sql .= "(name RLIKE '^(ㄷ|ㄸ)' OR ( name >= '다' AND name < '라' ))";	break;
    		case "라": $sql .= "(name RLIKE '^ㄹ' OR ( name >= '라' AND name < '마' ))"; 		break;
    		case "마": $sql .= "(name RLIKE '^ㅁ' OR ( name >= '마' AND name < '바' ))";		break;
    		case "바": $sql .= "(name RLIKE '^ㅂ' OR ( name >= '바' AND name < '사' ))";		break;
    		case "사": $sql .= "(name RLIKE '^(ㅅ|ㅆ)' OR ( name >= '사' AND name < '아' ))"; 	break;
    		case "아": $sql .= "(name RLIKE '^ㅇ' OR ( name >= '아' AND name < '자' ))"; 		break;
    		case "자": $sql .= "(name RLIKE '^(ㅈ|ㅉ)' OR ( name >= '자' AND name < '차' ))"; 	break;
    		case "차": $sql .= "(name RLIKE '^ㅊ' OR ( name >= '차' AND name < '카' ))"; 		break;
    		case "카": $sql .= "(name RLIKE '^ㅋ' OR ( name >= '카' AND name < '타' ))";		break;
    		case "타": $sql .= "(name RLIKE '^ㅌ' OR ( name >= '타' AND name < '파' ))"; 		break;
    		case "파": $sql .= "(name RLIKE '^ㅍ' OR ( name >= '파' AND name < '하' ))";		break;
    		case "하": $sql .= "(name RLIKE '^ㅎ' OR ( name >= '하'))";				  		break;
    	}
    	
    	return $this->db->query($sql)->result_array();
    }
	
	function get_area($parent_no){
		$sql = "SELECT * FROM gh_area WHERE parent_no = ?";
		return $this->db->query($sql, $parent_no)->result_array();
	}
    
}

?>