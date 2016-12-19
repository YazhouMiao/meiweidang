<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-9
 * 描述: 城市管理相关的DB处理  model
 */
class ModelLocalisationCity extends Model {
	public function addCity($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "city SET city_name = '" . $this->db->escape($data['name']) . "', zone_id = '" . (int)$this->db->escape($data['zone_id']) . "', code = '" . $this->db->escape($data['code']) . "',service_zone_id = '" . (int)$this->db->escape($data['service_zone_id']). "', status = '" . (int)$data['status'] . "'");

		$this->cache->delete('city');
	}

	public function editCity($city_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "city SET city_name = '" . $this->db->escape($data['name']) . "', zone_id = '" . (int)$this->db->escape($data['zone_id']) . "', code = '" . $this->db->escape($data['code']) . "',service_zone_id = '" . (int)$this->db->escape($data['service_zone_id']). "', status = '" . (int)$data['status'] . "' WHERE city_id = '" . (int)$city_id . "'");

		$this->cache->delete('city');
	}

	public function deleteCity($city_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "city WHERE city_id = '" . (int)$city_id . "'");

		$this->cache->delete('city');
	}

	public function getCity($city_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "city WHERE city_id = '" . (int)$city_id . "'");

		return $query->row;
	}

	public function getCities($data = array()) {
		if ($data) {
			$sql = "SELECT * FROM " . DB_PREFIX . "city";

			$sort_data = array(
					'city_name',
					'code',
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
			} else {
				$sql .= " ORDER BY city_name";
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
			$city_data = $this->cache->get('city');

			if (!$city_data) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "city ORDER BY city_id ASC");

				$city_data = $query->rows;

				$this->cache->set('city', $city_data);
			}

			return $city_data;
		}
	}

	public function getTotalCities() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "city");

		return $query->row['total'];
	}
}