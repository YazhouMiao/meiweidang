<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-9
 * 描述: TODO
 */
class ModelLocalisationServiceZone extends Model {
	public function addServiceZone($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "service_zone SET service_zone_name = '" . $this->db->escape($data['name']) . "', service_zone_code = '" . $this->db->escape($data['code']) . "', city_id = '" . (int)$data['city_id'] . "', admin_name = '" . $this->db->escape($data['admin_name']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', openid = '" . $this->db->escape($data['openid']) . "', description = '" . $this->db->escape($data['description']) . "', status = '" . (int)($data['status']) . "'");
	
		$this->cache->delete('service_zone');
	}

	public function editServiceZone($service_zone_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "service_zone SET service_zone_name = '" . $this->db->escape($data['name']) . "', service_zone_code = '" . $this->db->escape($data['code']) . "', city_id = '" . (int)$data['city_id'] . "', admin_name = '" . $this->db->escape($data['admin_name']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', openid = '" . $this->db->escape($data['openid']) . "', description = '" . $this->db->escape($data['description']) . "', status = '" . (int)($data['status']) . "' WHERE service_zone_id = '" .(int)$service_zone_id. "'");
		
		$this->cache->delete('service_zone');
	}
	
	public function deleteServiceZone($service_zone_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "service_zone WHERE service_zone_id = '" . (int)$service_zone_id . "'");
	
		$this->cache->delete('service_zone');
	}
	
	public function getServiceZone($service_zone_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_zone WHERE service_zone_id = '" . (int)$service_zone_id . "' AND status = '1'");

		return $query->row;
	}

	public function getServiceZoneByName($name) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_zone WHERE name = '" . $name . "' AND status = '1'");

		return $query->row;
	}

	public function getServiceZonesByCity($city_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_zone WHERE city_id = '" . $city_id . "' AND status = '1'");

		return $query->rows;
	}
	
	public function getTotalServiceZonesByCity($city_id) {
		$query = $this->db->query("SELECT count(*) AS total FROM " . DB_PREFIX . "service_zone WHERE city_id = '" . $city_id . "' AND status = '1'");
	
		return $query->row['total'];
	}

	public function getServiceZones($data = array()) {
		$sql = "SELECT sz.service_zone_id, sz.service_zone_code, sz.service_zone_name,sz.status, c.city_name AS city FROM " . DB_PREFIX . "service_zone AS sz LEFT JOIN " . DB_PREFIX . "city AS c ON sz.city_id = c.city_id";
	
		$sort_data = array(
				'c.city_name',
				'sz.service_zone_name',
				'sz.service_zone_code'
		);
	
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY c.city_name";
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

	public function getTotalServiceZones(){
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "service_zone");
		
		return $query->row['total'];
	}
}