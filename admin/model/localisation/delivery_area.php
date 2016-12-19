<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-9
 * 描述: TODO
 */
class ModelLocalisationDeliveryArea extends Model {
	public function getDeliveryArea($delivery_area_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery_area WHERE delivery_area_id = '" .(int)$delivery_area_id. "'");

		return $query->row;
	}
	
	public function addDeliveryArea($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "delivery_area SET delivery_area_name = '" . $this->db->escape($data['name']) . "', service_zone_id = '" . (int)$this->db->escape($data['service_zone_id']) . "', description = '" . $this->db->escape($data['description']) . "', status = '" . (int)($data['status']) . "'");
	
		$this->cache->delete('delivery_area');
	}

	public function editDeliveryArea($delivery_area_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "delivery_area SET delivery_area_name = '" . $this->db->escape($data['name']) . "', service_zone_id = '" . (int)$this->db->escape($data['service_zone_id']) . "', description = '" . $this->db->escape($data['description'])  . "', status = '" . (int)$data['status'] . "' WHERE delivery_area_id = '" . (int)$delivery_area_id . "'");
	
		$this->cache->delete('delivery_area');
	}

	public function deleteDeliveryArea($delivery_area_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "delivery_area WHERE delivery_area_id = '" . (int)$delivery_area_id . "'");
	
		$this->cache->delete('delivery_area');
	}

	public function getDeliveryAreasByServiceZone($service_zone_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery_area WHERE service_zone_id = '" .(int)$service_zone_id. "'");

		return $query->rows;
	}
	
	public function getTotalDeliveryAreaByServiceZone($service_zone_id) {
		$query = $this->db->query("SELECT count(*) AS total FROM " . DB_PREFIX . "delivery_area WHERE service_zone_id = '" .(int)$service_zone_id. "' AND status = '1'");
	
		return $query->row['total'];
	}
	
	public function getDeliveryAreas($data = array()) {
		$sql = "SELECT da.delivery_area_id, da.delivery_area_name, sz.service_zone_name AS service_zone, c.city_name AS city FROM " . DB_PREFIX . "delivery_area AS da LEFT JOIN " . DB_PREFIX . "service_zone AS sz ON da.service_zone_id = sz.service_zone_id LEFT JOIN " . DB_PREFIX . "city AS c ON sz.city_id = c.city_id";
	
		$sort_data = array(
				'c.city_name',
				'sz.service_zone_name',
				'da.delivery_area_name'
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
	
	public function getTotalDeliveryAreas(){
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "delivery_area");
	
		return $query->row['total'];
	}
}