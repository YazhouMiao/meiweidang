<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-11
 * 描述: 配送历史记录相关的DB操作 model
 */
class ModelDeliveryHistory extends Model {
	public function getDeliveryHistories($data = array()) {
		// 取符合检索条件的最大status对应个记录
		$sql = "SELECT dh.order_id, dh.status AS status, dh.add_time AS add_time, o.shipping_company AS company, o.shipping_firstname AS shipping_name, o.telephone AS shipping_telephone, o.shipping_city AS city, o.service_zone_name AS service_zone, o.delivery_area_name AS delivery_area, o.shipping_address_1 AS address, ds.delivery_staff_name AS delivery_name, ds.telephone AS delivery_telephone FROM " . DB_PREFIX . "delivery_history AS dh LEFT JOIN " . DB_PREFIX . "order AS o ON dh.order_id = o.order_id LEFT JOIN " . DB_PREFIX . "delivery_staff AS ds ON dh.delivery_staff_id = ds.delivery_staff_id LEFT JOIN " . DB_PREFIX . "city AS c ON o.shipping_city = c.city_name WHERE dh.status = (select max(dh2.status) from " . DB_PREFIX . "delivery_history AS dh2 where dh2.order_id = dh.order_id)";
		$implode = array();

		if (!empty($data['filter_city_id'])) {
			$implode[] = "c.city_id = '" . (int)$this->db->escape($data['filter_city_id']) . "'";
		}
		
		if (!empty($data['filter_service_zone_id'])) {
			$implode[] = "o.service_zone_id = '" . (int)$this->db->escape($data['filter_service_zone_id']) . "'";
		}
		
		if (!empty($data['filter_delivery_area_id'])) {
			$implode[] = "o.delivery_area_id = '" . (int)$this->db->escape($data['filter_delivery_area_id']) . "'";
		}

		if (!empty($data['filter_delivery_name'])) {
			$implode[] = "ds.delivery_staff_name LIKE '%" . $this->db->escape($data['filter_delivery_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "dh.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_start_time'])) {
			$implode[] = "dh.add_time >= '" . $this->db->escape($data['filter_start_time']) . "'";
		}
		
		if (!empty($data['filter_end_time'])) {
			$implode[] = "dh.add_time <= '" . $this->db->escape($data['filter_end_time']) . "'";
		}
		
		if (!empty($data['filter_order_id'])) {
			$implode[] = "dh.order_id = '" . $this->db->escape($data['filter_order_id']) . "'";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
				'dh.order_id',
				'ds.delivery_staff_name',
				'dh.add_time',
				'dh.status'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY dh.order_id, dh.status";
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

	public function getTotalDeliveryHistories($data = array()) {
		$sql = "SELECT count(*) total FROM " . DB_PREFIX . "delivery_history AS dh LEFT JOIN " . DB_PREFIX . "order AS o ON dh.order_id = o.order_id LEFT JOIN " . DB_PREFIX . "delivery_staff AS ds ON dh.delivery_staff_id = ds.delivery_staff_id LEFT JOIN " . DB_PREFIX . "city AS c ON o.shipping_city = c.city_name WHERE dh.status = (select max(dh2.status) from " . DB_PREFIX . "delivery_history AS dh2 where dh2.order_id = dh.order_id)";
		$implode = array();

		if (!empty($data['filter_city_id'])) {
			$implode[] = "c.city_id = '" . (int)$this->db->escape($data['filter_city_id']) . "'";
		}
		
		if (!empty($data['filter_service_zone_id'])) {
			$implode[] = "o.service_zone_id = '" . (int)$this->db->escape($data['filter_service_zone_id']) . "'";
		}
		
		if (!empty($data['filter_delivery_area_id'])) {
			$implode[] = "o.delivery_area_id = '" . (int)$this->db->escape($data['filter_delivery_area_id']) . "'";
		}

		if (!empty($data['filter_delivery_name'])) {
			$implode[] = "ds.delivery_staff_name LIKE '%" . $this->db->escape($data['filter_delivery_name']) . "%'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "dh.status = '" . (int)$data['filter_status'] . "'";
		}

		if (!empty($data['filter_start_time'])) {
			$implode[] = "dh.add_time >= '" . $this->db->escape($data['filter_start_time']) . "'";
		}
		
		if (!empty($data['filter_end_time'])) {
			$implode[] = "dh.add_time <= '" . $this->db->escape($data['filter_end_time']) . "'";
		}
		
		if (!empty($data['filter_order_id'])) {
			$implode[] = "dh.order_id = '" . $this->db->escape($data['filter_order_id']) . "'";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getDeliveryHistoriesByOrderId($order_id) {
		$sql = "SELECT dh.order_id, dh.status AS status, dh.add_time AS add_time, ds.delivery_staff_name AS delivery_name, ds.telephone AS delivery_telephone FROM " . DB_PREFIX . "delivery_history AS dh LEFT JOIN " . DB_PREFIX . "delivery_staff AS ds ON dh.delivery_staff_id = ds.delivery_staff_id WHERE dh.order_id = '" .$order_id. "' ORDER BY dh.status";
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}

}
