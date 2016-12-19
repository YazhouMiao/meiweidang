<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-29
 * 描述: 城市DB处理相关 model
 * TODO: 考虑使用cache
 */
class ModelLocalisationCity extends Model {
	public function getCity($city_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city WHERE city_id = '" . (int)$city_id . "' AND status = '1'");

		return $query->row;
	}
	
	public function getCities() {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city WHERE status = '1'");
	
		return $query->rows;
	}

	public function getCityByName($city_name) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city WHERE city_name = '" . $city_name . "' AND status = '1'");

		return $query->row;
	}
	
	public function getDefaultServiceZoneByCityName($city_name) {
		$query = $this->db->query("SELECT sz.service_zone_id, sz.service_zone_name, sz.service_zone_code, sz.description FROM " . DB_PREFIX . "city AS c left join " . DB_PREFIX . "service_zone AS sz on c.service_zone_id = sz.service_zone_id WHERE c.city_name = '" . $city_name . "' AND c.status = '1' AND sz.status = '1'");
		
		return $query->row;
	}
}