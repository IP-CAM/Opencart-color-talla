<?php
class ModelCatalogProductTalla extends Model {

	public function getData($data){

		$sql = "SELECT * from ".DB_PREFIX."tallas t ";

		$sql .= " WHERE 1 "; 

		if (!empty($data['filter_name'])) {
			$sql .= " AND t.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_code'])) {
			$sql .= " AND t.talla_id LIKE '" . $this->db->escape($data['filter_talla_id']) . "%'";
		}


		$sql .= " GROUP BY t.talla_id";

		$sort_data = array(
			't.talla_id',
			't.name',
			't.sort_order',
			't.equivalencia',
			't.type',
			't.store_id'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY t.name";	
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getDataTotal($data = array()){
		$sql = "SELECT COUNT(t.talla_id) AS total FROM " . DB_PREFIX . "tallas t WHERE 1 ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND t.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_talla_id'])) {
			$sql .= " AND t.talla_id LIKE '" . $this->db->escape($data['filter_talla_id']) . "%'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}


	public function getInfo($talla_id){
		$sql = "SELECT * from ".DB_PREFIX."tallas where talla_id = '".$talla_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}


	public function edit($talla_id, $data){
		$sql = "UPDATE ".DB_PREFIX."tallas set name='".$data['name']."', sort_order = '".$data['sort_order']."', type = '".$data['type']."', equivalencia = '".$data['equivalencia']."' where talla_id = '".$talla_id."' limit 1";
		$this->db->query($sql);
	}

	public function add($data){
		$sql = "INSERT INTO ".DB_PREFIX."tallas set talla_id = '".$data['talla_id']."', name='".$data['name']."', sort_order = '".$data['sort_order']."', type = '".$data['type']."', equivalencia = '".$data['equivalencia']."'";
		$this->db->query($sql);

	}

	public function delete($talla_id){
		$this->db->query("DELETE FROM ".DB_PREFIX."tallas where talla_id = '".$talla_id."'");
	}
}
?>