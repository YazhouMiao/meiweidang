<?php
class ModelCatalogManufacturer extends Model {
	public function getManufacturer($manufacturer_id) {
		// myzhou 2015/8/13 添加 ['service_zone']检索条件
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) LEFT JOIN " . DB_PREFIX . "manufacturer_to_service_zone m2sz ON (m.manufacturer_id = m2sz.manufacturer_id) WHERE m.manufacturer_id = '" . (int)$manufacturer_id . "' AND m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND m2sz.service_zone_id = '" . (int)$this->session->data['service_zone_id'] . "'");

		return $query->row;
	}

	public function getManufacturers($data = array()) {
		if ($data) {
			// myzhou 2015/8/13 添加 ['service_zone']检索条件
			$sql = "SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) LEFT JOIN " . DB_PREFIX . "manufacturer_to_service_zone m2sz ON (m.manufacturer_id = m2sz.manufacturer_id) WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND m2sz.service_zone_id = '" . (int)$this->session->data['service_zone_id'] . "'";

			$sort_data = array(
				'name',
				'sort_order'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY name";
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
		} else {
			// myzhou 2015/8/13 添加 ['service_zone']检索条件
			$manufacturer_data = $this->cache->get('manufacturer.' . (int)$this->config->get('config_store_id') . (int)$this->session->data['service_zone_id']);

			if (!$manufacturer_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "manufacturer m LEFT JOIN " . DB_PREFIX . "manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) LEFT JOIN " . DB_PREFIX . "manufacturer_to_service_zone m2sz ON (m.manufacturer_id = m2sz.manufacturer_id) WHERE m2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND m2sz.service_zone_id = '" . (int)$this->session->data['service_zone_id'] . "' ORDER BY name");

				$manufacturer_data = $query->rows;

				$this->cache->set('manufacturer.' . (int)$this->config->get('config_store_id') . (int)$this->session->data['service_zone_id'], $manufacturer_data);
			}

			return $manufacturer_data;
		}
	}
	
	// myzhou 2015/6/6  通过product_id取得商家信息
	public function getManufacturerByProductId($product_id) {
		$query = $this->db->query("SELECT m.manufacturer_id, m.name, m.address, m.description, m.image, m.telephone, m.openid_1, m.openid_2, m.openid_3, m.status FROM " . DB_PREFIX . "manufacturer AS m LEFT JOIN " . DB_PREFIX . "product AS p ON m.manufacturer_id = p.manufacturer_id WHERE p.product_id = '" .$product_id. "'");

		return $query->row;
	}
}