<?php
/**
 * 作者: myzhou
 * 时间: 2015-6-4
 * 描述: 配送信息历史记录相关的DB操作 model
 */
class ModelDeliveryHistory extends Model {
	/**
	 * 将配送信息添加到配送历史表中
	 * @param $order_id 订单id
	 * @param $delivery_staff_id 配送员id
	 * @param $status 0:准备取单  1:已经取单  2:已经送达  3:送回商家
	 * @return 配送历史id
	 */
	public function addDeliveryHistory($order_id, $delivery_staff_id, $status = 0) {
		$query = $this->db->query("INSERT INTO " . DB_PREFIX ."delivery_history SET order_id = '" . (int)$order_id . "', delivery_staff_id = '" . (int)$delivery_staff_id . "', status = '" . (int)$status . "', add_time = NOW()");
	
		return $this->db->getLastId();
	}

	/**
	 * 检索当前时间段内,配送人员已经收到的订单总量
	 *
	 * @param $delivery_staff_id 配送员id
	 * @param $start_time 起始时间
	 * @param $end_time   结束时间
	 * @return 已接到的订单量
	 */
	public function getDeliveryTotal($delivery_staff_id, $start_time, $end_time) {
		$query = $this->db->query("SELECT count(DISTINCT(order_id)) AS total FROM " . DB_PREFIX . "delivery_history WHERE add_time >= '" .$start_time. "' AND add_time < '" .$end_time. "' AND delivery_staff_id = '" .$delivery_staff_id. "'");

		return $query->row['total'];
	}

}