<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-11
 * 描述: 配送员工管理相关 model
 */
class ModelDeliveryStaff extends Model {
	public function addDeliveryStaff($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "delivery_staff SET service_zone_id = '" . (int)$data['service_zone_id'] . "', delivery_staff_name = '" . $this->db->escape($data['name']) . "', openid = '" . $this->db->escape($data['openid']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', delivery_amount = '" . $this->db->escape($data['amount']) . "', description = '" . $this->db->escape($data['description']) . "', status = '" . (int)$data['status'] . "', add_time = NOW()");
	}

	public function editDeliveryStaff($delivery_staff_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "delivery_staff SET delivery_staff_name = '" . $this->db->escape($data['name']) . "', openid = '" . $this->db->escape($data['openid']) . "', service_zone_id = '" . (int)$this->db->escape($data['service_zone_id']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', description = '" . $this->db->escape($data['description']) . "', status = '" . (int)$data['status'] . "', delivery_amount = '" . (int)$data['amount'] . "' WHERE delivery_staff_id = '" . (int)$delivery_staff_id . "'");
	}

	public function deleteDeliveryStaff($delivery_staff_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "delivery_staff WHERE delivery_staff_id = '" . (int)$delivery_staff_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "delivery_history WHERE delivery_staff_id = '" . (int)$delivery_staff_id . "'");
	}

	public function getDeliveryStaff($delivery_staff_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "delivery_staff WHERE delivery_staff_id = '" . (int)$delivery_staff_id . "'");

		return $query->row;
	}
	
	public function getDeliveryStaffsByServiceZoneId($service_zone_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery_staff WHERE service_zone_id = '" . (int)$service_zone_id . "'");
	
		return $query->rows;
	}

	public function getDeliveryStaffs($data = array()) {
		$sql = "SELECT ds.delivery_staff_id, ds.delivery_staff_name AS name,ds.telephone AS telephone,ds.delivery_amount AS amount, ds.openid AS openid, ds.status AS status, ds.add_time AS add_time, c.city_name AS city, sz.service_zone_name AS service_zone FROM " . DB_PREFIX . "delivery_staff ds LEFT JOIN " . DB_PREFIX . "service_zone sz ON (ds.service_zone_id = sz.service_zone_id) LEFT JOIN " . DB_PREFIX . "city AS c ON (sz.city_id = c.city_id) WHERE 1=1";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "ds.delivery_staff_name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_city_id']) && empty($data['filter_service_zone_id'])) {
			$implode[] = "c.city_id = '" . (int)$this->db->escape($data['filter_city_id']) . "'";
		} else if (!empty($data['filter_city_id']) && !empty($data['filter_service_zone_id'])) {
			$implode[] = "sz.service_zone_id = '" . $this->db->escape($data['filter_service_zone_id']) . "'";
		}

		if (!empty($data['filter_openid'])) {
			$implode[] = "ds.openid LIKE '%" . $data['filter_openid'] . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "ds.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(ds.add_time) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
				'ds.delivery_staff_name',
				'sz.service_zone_name',
				'ds.openid',
				'ds.delivery_amount',
				'ds.add_time'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY ds.delivery_staff_name";
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

	public function getTotalDeliveryStaffs($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "delivery_staff AS ds ";

		$implode = array();
		
		if (!empty($data['filter_city_id']) && empty($data['filter_service_zone_id'])) {
			$implode[] = "c.city_id = '" . (int)$this->db->escape($data['filter_city_id']) . "'";
		} else if (!empty($data['filter_city_id']) && !empty($data['filter_service_zone_id'])) {
			$implode[] = "ds.service_zone_id = '" . (int)$this->db->escape($data['filter_service_zone_id']) . "'";
		}

		if (!empty($data['filter_name'])) {
			$implode[] = "ds.delivery_staff_name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_openid']) && !is_null($data['filter_openid'])) {
			$implode[] = "ds.openid = '" . $this->db->escape($data['filter_openid']) . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "ds.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(ds.add_time) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			if (!empty($data['filter_city_id']) && empty($data['filter_service_zone_id'])) {
				$sql .= "LEFT JOIN " . DB_PREFIX . "service_zone AS sz ON ds.service_zone_id = sz.service_zone_id LEFT JOIN " . DB_PREFIX . "city AS c ON c.city_id = sz.city_id";
			}
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}