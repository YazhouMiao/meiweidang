<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-29
 * 描述: 服务区DB相关处理 model
 * TODO: 考虑使用cache
 */
class ModelLocalisationServiceZone extends Model {
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
	
	public function getServiceZonesByCityName($city_name) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "service_zone AS sz LEFT JOIN ". DB_PREFIX . "city AS c on c.city_id = sz.city_id WHERE c.city_name = '" . $city_name . "' AND c.status = '1' AND sz.status = '1'");
	
		return $query->rows;
	}
	
	public function getServiceZoneByAddressId($address_id) {
		$query = $this->db->query("SELECT sz.service_zone_id, sz.service_zone_name, sz.service_zone_code, sz.description, a.city FROM " . DB_PREFIX . "service_zone AS sz LEFT JOIN " . DB_PREFIX . "address AS a ON sz.service_zone_id = a.service_zone_id WHERE a.address_id = '" .(int)$address_id ."' AND sz.status = '1'");
	
		return $query->row;
	}
}