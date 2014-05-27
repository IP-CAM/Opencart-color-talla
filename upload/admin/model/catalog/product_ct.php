<?php
class ModelCatalogProductCt extends Model {
	public function addOption($data) {

		$this->db->query("INSERT INTO `" . DB_PREFIX . "option` SET type = '" . $this->db->escape($data['type']) . "', sort_order = '" . (int)$data['sort_order'] . "'");

		$option_id = $this->db->getLastId();

		foreach ($data['option_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "option_description SET option_id = '" . (int)$option_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		if (isset($data['option_value'])) {
			foreach ($data['option_value'] as $option_value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "option_value SET option_id = '" . (int)$option_id . "', image = '" . $this->db->escape(html_entity_decode($option_value['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$option_value['sort_order'] . "'");

				$option_value_id = $this->db->getLastId();

				foreach ($option_value['option_value_description'] as $language_id => $option_value_description) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "option_value_description SET option_value_id = '" . (int)$option_value_id . "', language_id = '" . (int)$language_id . "', option_id = '" . (int)$option_id . "', name = '" . $this->db->escape($option_value_description['name']) . "'");
				}
			}
		}
	}

	public function addOptionValue($data){

		$this->db->query("INSERT INTO `" . DB_PREFIX . "option_value` SET option_id = '" . $this->db->escape($data['option_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', image = '" . $data['image'] . "'");

		$option_value_id = $this->db->getLastId();

		foreach ($data['option_value_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "option_value_description SET option_value_id = '" . (int)$option_value_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', option_id = '" . $this->db->escape($data['option_id']) . "'");
		}

		$this->db->query("INSERT INTO `" . DB_PREFIX . "option_value_color_talla` 
				SET option_value_id = '" . (int)$option_value_id . "', 
				barcode = '" . $this->db->escape($data['barcode']) . "', 
				sku = '" . $this->db->escape($data['sku']) . "', 
				color_id = '" . $this->db->escape($data['color_id']) . "', 
				product_id = '" . $this->db->escape($data['product_id']) . "', 
				talla_id = '" . $this->db->escape($data['talla_id']) . "' ");
		return $data['option_id'];
	}


	public function editOptionValue($data){

		$this->db->query("UPDATE `" . DB_PREFIX . "option_value` SET option_id = '" . $this->db->escape($data['option_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', image = '" . $data['image'] . "' WHERE option_value_id = '".(int)$data['option_value_id']."'");

		$this->db->query("DELETE FROM ".DB_PREFIX."option_value_description where option_value_id = '".(int)$data['option_value_id']."' ");

		foreach ($data['option_value_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "option_value_description SET option_value_id = '" . (int)$data['option_value_id'] . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', option_id = '" . $this->db->escape($data['option_id']) . "'");
		}

		$this->db->query("UPDATE `" . DB_PREFIX . "option_value_color_talla` 
				SET barcode = '" . $this->db->escape($data['barcode']) . "', 
				sku = '" . $this->db->escape($data['sku']) . "', 
				color_id = '" . $this->db->escape($data['color_id']) . "', 
				product_id = '" . $this->db->escape($data['product_id']) . "', 
				talla_id = '" . $this->db->escape($data['talla_id']) . "' where option_value_id = '".(int)$data['option_value_id']."'");

		return $data['option_id'];
	}

	public function editOption($option_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "option` SET type = '" . $this->db->escape($data['type']) . "', sort_order = '" . (int)$data['sort_order'] . "' WHERE option_id = '" . (int)$option_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "option_description WHERE option_id = '" . (int)$option_id . "'");

		foreach ($data['option_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "option_description SET option_id = '" . (int)$option_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		// $this->db->query("DELETE FROM " . DB_PREFIX . "option_value WHERE option_id = '" . (int)$option_id . "'");
		// $this->db->query("DELETE FROM " . DB_PREFIX . "option_value_description WHERE option_id = '" . (int)$option_id . "'");

		// if (isset($data['option_value'])) {
		// 	foreach ($data['option_value'] as $option_value) {
		// 		if ($option_value['option_value_id']) {
		// 			$this->db->query("INSERT INTO " . DB_PREFIX . "option_value SET option_value_id = '" . (int)$option_value['option_value_id'] . "', option_id = '" . (int)$option_id . "', image = '" . $this->db->escape(html_entity_decode($option_value['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$option_value['sort_order'] . "'");
		// 		} else {
		// 			$this->db->query("INSERT INTO " . DB_PREFIX . "option_value SET option_id = '" . (int)$option_id . "', image = '" . $this->db->escape(html_entity_decode($option_value['image'], ENT_QUOTES, 'UTF-8')) . "', sort_order = '" . (int)$option_value['sort_order'] . "'");
		// 		}

		// 		$option_value_id = $this->db->getLastId();

		// 		foreach ($option_value['option_value_description'] as $language_id => $option_value_description) {
		// 			$this->db->query("INSERT INTO " . DB_PREFIX . "option_value_description SET option_value_id = '" . (int)$option_value_id . "', language_id = '" . (int)$language_id . "', option_id = '" . (int)$option_id . "', name = '" . $this->db->escape($option_value_description['name']) . "'");
		// 		}
		// 	}
		// }
	}

	public function deleteOption($option_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "option` WHERE option_id = '" . (int)$option_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "option_description WHERE option_id = '" . (int)$option_id . "'");	
		$this->db->query("DELETE FROM " . DB_PREFIX . "option_value WHERE option_id = '" . (int)$option_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "option_value_description WHERE option_id = '" . (int)$option_id . "'");
	}


	public function deleteOptionValue($option_value_id) {
		if(isset($option_value_id)){
			$this->db->query("DELETE FROM " . DB_PREFIX . "option_value WHERE option_value_id = '" . (int)$option_value_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "option_value_description WHERE option_value_id = '" . (int)$option_value_id . "'");
			$this->db->query("DELETE FROM " . DB_PREFIX . "option_value_color_talla WHERE option_value_id = '" . (int)$option_value_id . "'");	
			return 1;
		} return 0;
	}

	public function getOption($option_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "option` o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE o.option_id = '" . (int)$option_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getOptions($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "option` o LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE od.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$sql .= " AND od.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " AND o.type = 'select_ct'";

		$sort_data = array(
			'od.name',
			'o.type',
			'o.sort_order'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY od.name";	
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

	public function getOptionDescriptions($option_id) {
		$option_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_description WHERE option_id = '" . (int)$option_id . "'");

		foreach ($query->rows as $result) {
			$option_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $option_data;
	}

	public function getOptionValue($option_value_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_value_id = '" . (int)$option_value_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getOptionValues($option_id) {
		$option_value_data = array();
		$sql = "SELECT * FROM " . DB_PREFIX . "option_value ov LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE ov.option_id = '" . (int)$option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order ASC";
		$option_value_query = $this->db->query($sql);

		foreach ($option_value_query->rows as $option_value) {
			$option_value_data[] = array(
				'option_value_id' => $option_value['option_value_id'],
				'name'            => $option_value['name'],
				'image'           => $option_value['image'],
				'sort_order'      => $option_value['sort_order']
			);
		}

		return $option_value_data;
	}

	public function getOptionValueDescriptions($option_id) {
		$option_value_data = array();

		$sql = "SELECT * FROM " . DB_PREFIX . "option_value ov JOIN " . DB_PREFIX . "option_value_color_talla ovct ON ovct.option_value_id = ov.option_value_id WHERE option_id = '" . (int)$option_id . "'";
		$option_value_query = $this->db->query($sql);

		foreach ($option_value_query->rows as $option_value) {
			$option_value_description_data = array();
			$option_value_color_talla_data = array(
				'barcode'	  => $option_value['barcode'],
				'sku'		  => $option_value['sku'],
				'color_id'	  => $option_value['color_id'],
				'talla_id'	  => $option_value['talla_id'],
				'product_id'  => $option_value['product_id'],
			);


			$sql = "SELECT * FROM " . DB_PREFIX . "option_value_description ovd WHERE ovd.option_value_id = '" . (int)$option_value['option_value_id'] . "'";
			$option_value_description_query = $this->db->query($sql);

			foreach ($option_value_description_query->rows as $option_value_description) {
				$option_value_description_data[$option_value_description['language_id']] = array('name' => $option_value_description['name']);
			}

			$option_value_data[] = array(
				'option_value_id'          => $option_value['option_value_id'],
				'option_value_description' => $option_value_description_data,
				'image'                    => $option_value['image'],
				'sort_order'               => $option_value['sort_order'],
				'option_value_color_talla' => $option_value_color_talla_data
			);
		}

		return $option_value_data;
	}

	public function getTotalOptions() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "option`");

		return $query->row['total'];
	}


	public function getOptionValueInfo($option_value_id){

		$sql = "SELECT * FROM pixel_option_value AS ov INNER JOIN pixel_option_value_color_talla AS ovct ON ov.option_value_id = ovct.option_value_id WHERE ov.option_value_id = '".(int)$option_value_id."'";
		$query = $this->db->query($sql);
		return $query->row;

	}		

	public function getOptionValueIdDescriptions($ovid){

		$option_data = array();
		$sql = "SELECT * FROM " . DB_PREFIX . "option_value_description WHERE option_value_id = '" . (int)$ovid . "'";
		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$option_data[$result['language_id']] = array('name' => $result['name']);
		}

		return $option_data;

	}
}
?>