<?php
class ModelCatalogProductColor extends Model {

	public function getColores($data){

		$sql = "SELECT * from ".DB_PREFIX."colors c";

		$sql .= " WHERE c.language_id = '" . (int)$this->config->get('config_language_id') . "'"; 

		if (!empty($data['filter_name'])) {
			$sql .= " AND c.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_code'])) {
			$sql .= " AND c.code LIKE '" . $this->db->escape($data['filter_code']) . "%'";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND c.manufacturer_id LIKE '" . $this->db->escape($data['filter_manufacturer_id']) . "%'";
		}

		$sql .= " GROUP BY c.code";

		$sort_data = array(
			'c.name',
			'c.code',
			'c.manufacturer_id'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY c.name";	
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

	public function getColoresTotal($data = array()){
		$sql = "SELECT COUNT(DISTINCT c.code) AS total FROM " . DB_PREFIX . "colors c WHERE c.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND c.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_code'])) {
			$sql .= " AND c.code LIKE '" . $this->db->escape($data['filter_code']) . "%'";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND c.manufacturer_id LIKE '" . $this->db->escape($data['filter_manufacturer_id']) . "%'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}


	public function getColor($color_id){
		$sql = "SELECT * from ".DB_PREFIX."colors where code = '".$color_id."'";
		$query = $this->db->query($sql);
		return $query->row;
	}



	public function editColor($code, $data){
		$sql = "UPDATE ".DB_PREFIX."colors set name='".$data['name']."', image = '".$data['image']."', manufacturer_id = '".$data['manufacturer_id']."' where code = '".$code."' limit 1";
		$this->db->query($sql);
	}

	public function addColor($data){
		$sql = "INSERT INTO ".DB_PREFIX."colors set code = '".$data['code']."', name = '".$this->db->escape($data['name'])."', image = '".$this->db->escape($data['image'])."', manufacturer_id = '".$this->db->escape($data['manufacturer_id'])."'";
		$this->db->query($sql);

	}

	public function deleteColor($code){
		$this->db->query("DELETE FROM ".DB_PREFIX."colors where code = '".$code."'");
	}
}
?>