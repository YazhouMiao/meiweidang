<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-11
 * 描述: 配送安排相关的DB处理 model
 */
class ModelDeliverySchedule extends Model {
	public function addDeliverySchedule($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "delivery_schedule SET delivery_area_id = '" . (int)$this->db->escape($data['delivery_area_id']) . "', delivery_staff_id = '" . (int)$this->db->escape($data['delivery_staff_id']) . "', start_date = '" . $this->db->escape($data['start_date']) . "', end_date = '" . $this->db->escape($data['end_date']) . "', start_time = '" . $this->db->escape($data['start_time']) . "', end_time = '" . $this->db->escape($data['end_time']) . "', status = '" . (int)$data['status'] . "'");
	}

	public function editDeliverySchedule($delivery_schedule_id, $data) {
		
		$this->db->query("UPDATE " . DB_PREFIX . "delivery_schedule SET delivery_area_id = '" . (int)$this->db->escape($data['delivery_area_id']) . "', delivery_staff_id = '" . (int)$this->db->escape($data['delivery_staff_id']) . "', start_date = '" . $this->db->escape($data['start_date']) . "', end_date = '" . $this->db->escape($data['end_date']) . "', start_time = '" . $this->db->escape($data['start_time']) . "', end_time = '" . $this->db->escape($data['end_time']) . "', status = '" . (int)$data['status'] . "' WHERE delivery_schedule_id = '" . (int)$delivery_schedule_id . "'");
	}

	public function deleteDeliverySchedule($delivery_schedule_id) {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "delivery_schedule WHERE delivery_schedule_id = '" . (int)$delivery_schedule_id . "'");
	}

	public function getDeliverySchedule($delivery_schedule_id) {

		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "delivery_schedule WHERE delivery_schedule_id = '" . (int)$delivery_schedule_id . "'");

		return $query->row;
	}

	public function getDeliverySchedules($data = array()) {
		$sql = "SELECT dsc.delivery_schedule_id, dsc.start_date, dsc.end_date, dsc.start_time, dsc.end_time, dsc.status, ds.delivery_staff_name AS name, ds.telephone, c.city_name AS city, sz.service_zone_name AS service_zone, da.delivery_area_name AS delivery_area FROM " . DB_PREFIX . "delivery_schedule AS dsc LEFT JOIN " . DB_PREFIX . "delivery_area AS da ON dsc.delivery_area_id = da.delivery_area_id LEFT JOIN " . DB_PREFIX . "delivery_staff AS ds ON dsc.delivery_staff_id = ds.delivery_staff_id LEFT JOIN " . DB_PREFIX . "service_zone AS sz ON da.service_zone_id = sz.service_zone_id LEFT JOIN " . DB_PREFIX . "city AS c ON sz.city_id = c.city_id";
		$implode = array();

		if (!empty($data['filter_city_id'])) {
			$implode[] = "c.city_id = '" . (int)$this->db->escape($data['filter_city_id']) . "'";
		}
		
		if (!empty($data['filter_service_zone_id'])) {
			$implode[] = "ds.service_zone_id = '" . (int)$this->db->escape($data['filter_service_zone_id']) . "'";
		}
		
		if (!empty($data['filter_delivery_area_id'])) {
			$implode[] = "da.delivery_area_id = '" . (int)$this->db->escape($data['filter_delivery_area_id']) . "'";
		}

		if (!empty($data['filter_name'])) {
			$implode[] = "ds.delivery_staff_name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "dsc.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_start_date'])) {
			$implode[] = "dsc.start_date >= '" . $this->db->escape($data['filter_start_date']) . "'";
		}
		
		if (!empty($data['filter_end_date'])) {
			$implode[] = "dsc.end_date <= '" . $this->db->escape($data['filter_end_date']) . "'";
		}
		
		if (!empty($data['filter_start_time'])) {
			$implode[] = "dsc.start_time >= '" . $this->db->escape($data['filter_start_time']) . "'";
		}
		
		if (!empty($data['filter_end_time'])) {
			$implode[] = "dsc.end_time <= '" . $this->db->escape($data['filter_end_time']) . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$sort_data = array(
				'dsc.start_date',
				'dsc.end_date',
				'dsc.start_time',
				'dsc.end_time',
				'ds.delivery_staff_name',
				'da.delivery_area_name'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY da.delivery_area_name";
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

	public function getTotalDeliverySchedules($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "delivery_schedule AS dsc LEFT JOIN " . DB_PREFIX . "delivery_area AS da ON dsc.delivery_area_id = da.delivery_area_id LEFT JOIN " . DB_PREFIX . "delivery_staff AS ds ON dsc.delivery_staff_id = ds.delivery_staff_id LEFT JOIN " . DB_PREFIX . "service_zone AS sz ON da.service_zone_id = sz.service_zone_id LEFT JOIN " . DB_PREFIX . "city AS c ON sz.city_id = c.city_id";

		$implode = array();

		if (!empty($data['filter_city_id'])) {
			$implode[] = "c.city_id = '" . (int)$this->db->escape($data['filter_city_id']) . "'";
		}
		
		if (!empty($data['filter_service_zone_id'])) {
			$implode[] = "ds.service_zone_id = '" . (int)$this->db->escape($data['filter_service_zone_id']) . "'";
		}
		
		if (!empty($data['filter_delivery_area_id'])) {
			$implode[] = "da.delivery_area_id = '" . (int)$this->db->escape($data['filter_delivery_area_id']) . "'";
		}

		if (!empty($data['filter_name'])) {
			$implode[] = "ds.delivery_staff_name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "dsc.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_start_date'])) {
			$implode[] = "dsc.start_date >= '" . $this->db->escape($data['filter_start_date']) . "'";
		}
		
		if (!empty($data['filter_end_date'])) {
			$implode[] = "dsc.end_date <= '" . $this->db->escape($data['filter_end_date']) . "'";
		}
		
		if (!empty($data['filter_start_time'])) {
			$implode[] = "dsc.start_time >= '" . $this->db->escape($data['filter_start_time']) . "'";
		}
		
		if (!empty($data['filter_end_time'])) {
			$implode[] = "dsc.end_time <= '" . $this->db->escape($data['filter_end_time']) . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getTotalDeliverySchedulesByDeliveryStaffId($delivery_staff_id){
		$query = $this->db->query("SELECT count(*) AS total FROM " . DB_PREFIX . "delivery_schedule WHERE delivery_staff_id = '" .(int)$delivery_staff_id."'");
	
		return $query->row['total'];
	}
}