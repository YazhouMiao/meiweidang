<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-22
 * 描述: 微信用户相关DB操作类  model
 */
class ModelWeixinWxcustomer extends Model {

	/**
	 * 添加微信用户
	 *
	 * @param 公众平台推送的用户信息
	 * @return customer_id
	 */
	public function addWxCustomer($data) {
		if (isset($data['customer_group_id'])) {
			$customer_group_id = $data['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}
		// 添加到普通用户表： customer_group_id=2; firstname为微信用户昵称;其他为默认值/空值
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET customer_group_id = '" . (int)$customer_group_id . "', store_id = '" . (int)$this->config->get('config_store_id') . "', firstname = '" . $data['nickname'] . "', lastname = '', email = '', telephone = '', fax = '', custom_field = '', salt = '', password = '', newsletter = 0, ip = '', status = '1', approved = 0, date_added = NOW()");

		$customer_id = $this->db->getLastId();
		// 添加到微信用户表
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_weixin SET customer_id = '" . (int)$customer_id . "', openid = '" . $data['openid'] . "', nickname = '" . $data['nickname'] . "', sex = '" . (int)$data['sex'] . "', city = '" . $data['city'] . "', province = '" . $data['province'] . "', country = '" . $data['country'] . "', remark = '" . $data['remark'] . "', groupid = '" . $data['groupid'] . "', subscribe = '" . (int)$data['subscribe'] . "', date_added = NOW(), date_modified = NOW()");

		return $customer_id;
	}
	
	/**
	 * 通过openid获取用户信息
	 *
	 * @param openid
	 * @return 检索结果： customer表和cusomer_weixin表的检索结果集
	 */
	public function getWxCustomerByOpenid($openid) {
		// customer表和cusomer_weixin表
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_weixin AS a LEFT JOIN " . DB_PREFIX . "customer AS b ON a.customer_id = b.customer_id WHERE a.openid = '" . $openid . "'");
		return $query->row;
	}

	/**
	 * 通过customer_id获取用户信息
	 *
	 * @param customer_id
	 * @return cusomer_weixin表的检索结果集
	 */
	public function getWxCustomerByCustomerId($customer_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_weixin WHERE customer_id = '" . (int)$customer_id . "'");
		return $query->row;
	}

	/**
	 * 通过customer_weixin_id获取用户信息
	 *
	 * @param customer_weixin_id
	 * @return cusomer_weixin表的检索结果集
	 */
	public function getWxCustomer($customer_weixin_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_weixin WHERE customer_weixin_id = '" . (int)$customer_weixin_id . "'");
		return $query->row;
	}

	/**
	 * 通过openid，更新subscribe字段
	 *
	 * @param openid
	 * @param is_subscribe true:重新关注  false:取消关注
	 */
	public function updateSubscribe($openid, $is_subscribe = true) {
		if ($is_subscribe) {
			$query = $this->db->query("UPDATE " . DB_PREFIX . "customer_weixin SET subscribe = 1 ,date_modified = NOW() WHERE openid = '" . $openid . "'");
		} else {
			$query = $this->db->query("UPDATE " . DB_PREFIX . "customer_weixin SET subscribe = 0 ,date_modified = NOW() WHERE openid = '" . $openid . "'");
		}
	}
}