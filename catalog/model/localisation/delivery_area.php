<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-3
 * 描述: 配送范围的DB相关处理类  model
 * TODO: 考虑使用cache
 */
class ModelLocalisationDeliveryArea extends Model {
	public function getDeliveryArea($delivery_area_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery_area WHERE delivery_area_id = '" .(int)$delivery_area_id. "'");

		return $query->row;
	}

	public function getDeliveryAreasByServiceZone($service_zone_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery_area WHERE service_zone_id = '" .(int)$service_zone_id. "' AND status = '1'");

		return $query->rows;
	}
	
	public function getDeliveryAreasByServiceZoneName($service_zone) {
		$results = array();
		
		$query = $this->db->query("SELECT da.delivery_area_id, da.delivery_area_name, da.description FROM " . DB_PREFIX . "delivery_area AS da LEFT JOIN " . DB_PREFIX . "service_zone AS sz ON da.service_zone_id = sz.service_zone_id WHERE sz.service_zone_name = '" .$service_zone. "' AND da.status = '1'");
	
		foreach($query->rows as $result){
			$results[] = array(
				'id'           => $result['delivery_area_id'],
				'name'         => $result['delivery_area_name'],
				'description'  => $result['description']
			);
		}
		
		return $results;
	}
}