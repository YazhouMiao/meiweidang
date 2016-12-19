<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-16
 * 描述: 配送任务相关处理的model
 */
class ModelDeliveryTask extends Model {

	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT dh.status AS delivery_status, dh.add_time, dh.delivery_staff_id, o.invoice_no, o.telephone AS customer_telephone, o.payment_firstname AS customer_name, o.payment_company AS company, o.payment_address_1 AS customer_address, o.payment_address_format, o.payment_method, o.payment_code, o.shipping_method, o.comment, o.total, o.order_status_id, o.currency_id, o.currency_code, o.currency_value, o.date_added, o.service_zone_id, o.service_zone_name AS service_zone, o.delivery_area_id, o.delivery_area_name AS delivery_area, ds.delivery_staff_name AS delivery_name, ds.telephone AS delivery_telephone FROM " . DB_PREFIX . "delivery_history AS dh LEFT JOIN " . DB_PREFIX ."order AS o ON dh.order_id = o.order_id LEFT JOIN " . DB_PREFIX . "delivery_staff AS ds ON dh.delivery_staff_id = ds.delivery_staff_id WHERE dh.status = (select max(dh2.status) from " . DB_PREFIX . "delivery_history AS dh2 where dh2.order_id = '" . $order_id . "') AND dh.order_id = '" . $order_id . "'");
		
		if ($order_query->num_rows) {
			return $order_query->row;
		} else {
			return false;
		}
	}
	
	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");
	
		return $query->rows;
	}
	
	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");
	
		return $query->rows;
	}
	
	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");
	
		return $query->rows;
	}
	
	public function getDeliveryTasks($data = array()) {
		$sql = "SELECT o.order_id, o.payment_address_1 AS address, o.delivery_area_name AS delivery_area, o.date_added, o.payment_company AS company, dh.status, ma.name AS business_name, pd.name AS product_name, op.quantity
				FROM " . DB_PREFIX . "delivery_history AS dh
				LEFT JOIN " . DB_PREFIX . "order AS o ON dh.order_id = o.order_id
				LEFT JOIN " . DB_PREFIX . "order_product AS op ON o.order_id = op.order_id
				LEFT JOIN " . DB_PREFIX . "product AS p ON op.product_id = p.product_id
				LEFT JOIN " . DB_PREFIX . "manufacturer as ma ON p.manufacturer_id = ma.manufacturer_id
				LEFT JOIN " . DB_PREFIX . "product_description AS pd ON p.product_id = pd.product_id
				WHERE 
  					dh.status = (SELECT max(dh2.status) FROM " . DB_PREFIX . "delivery_history AS dh2 WHERE dh2.order_id = dh.order_id)
				AND
					DATE(dh.add_time) = CURDATE()";
		if(isset($data['delivery_staff_id'])){
			$sql .= " AND dh.delivery_staff_id = '" . $data['delivery_staff_id'] . "'";
		}

		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND dh.status = '" . $data['filter_status'] . "'";
		}

		$sort_data = array(
			'dh.order_id',
			'ma.name',
			'op.quantity',
			'o.date_added'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY dh.order_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}
	
	public function addOrderHistory($order_id, $order_status_id) {
		$this->event->trigger('pre.order.history.add', $order_id);
	
		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int)$order_status_id . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
	
		$this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int)$order_id . "', order_status_id = '" . (int)$order_status_id . "', date_added = NOW()");
	}
}