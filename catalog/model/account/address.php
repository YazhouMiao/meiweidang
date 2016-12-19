<?php
class ModelAccountAddress extends Model {
	public function addAddress($data) {
		$this->event->trigger('pre.customer.add.address', $data);
        // myzhou 2015/6/3 添加telephone/service_zone_id/delivery_area_id/city_id字段
		$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$this->customer->getId() . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '', telephone = '" . $this->db->escape($data['telephone']) . "', company = '', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '', postcode = '', city = '', zone_id = '0', country_id = '0', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? serialize($data['custom_field']) : '') . "', service_zone_id = '" . (int)$data['service_zone_id'] . "',delivery_area_id = 0,city_id = '" . (int)$data['city'] . "'");

		$address_id = $this->db->getLastId();

		if (!empty($data['default'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		}

		$this->event->trigger('post.customer.add.address', $address_id);

		return $address_id;
	}

	public function editAddress($address_id, $data) {
		$this->event->trigger('pre.customer.edit.address', $data);
		// myzhou 2015/6/7 edit telephone/service_zone_id/delivery_area_id
		$this->db->query("UPDATE " . DB_PREFIX . "address SET firstname = '" . $this->db->escape($data['firstname']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', company = '" . $this->db->escape($data['company']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', city = '', service_zone_id = '" . (int)$this->db->escape($data['service_zone_id']) . "', delivery_area_id = '" . (int)$this->db->escape($data['delivery_area_id']) . "', city_id = '" . (int)$this->db->escape($data['city_id']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? serialize($data['custom_field']) : '') . "' WHERE address_id  = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");

		if (!empty($data['default'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		}

		$this->event->trigger('post.customer.edit.address', $address_id);
	}

	public function deleteAddress($address_id) {
		$this->event->trigger('pre.customer.delete.address', $address_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");

		$this->event->trigger('post.customer.delete.address', $address_id);
	}

	public function getAddress($address_id) {
		$address_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");

		if ($address_query->num_rows) {
			/* myzhou 2015/6/7 delete country/zone
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$address_query->row['country_id'] . "'");

			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$address_query->row['zone_id'] . "'");

			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				$zone_code = '';
			} */
			$zone = '';
			$zone_code = '';
			$country = '';
			$iso_code_2 = '';
			$iso_code_3 = '';
			$address_format = '';
			
			// myzhou 2015/5/29  add city/service_zone/delivery_area/city_id
			$city_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "city` WHERE city_id = '" . (int)$address_query->row['city_id'] . "'");
			if ($city_query->num_rows) {
				$city_id = $city_query->row['city_id'];
				$city_name = $city_query->row['city_name'];
			} else {
				$city_id = '';
				$city_name = '';
			}

			$service_zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "service_zone` WHERE service_zone_id = '" . (int)$address_query->row['service_zone_id'] . "'");
			if ($service_zone_query->num_rows) {
				$service_zone_name = $service_zone_query->row['service_zone_name'];
				$service_zone_code = $service_zone_query->row['service_zone_code'];
			} else {
				$service_zone_name = '';
				$service_zone_code = '';
			}
			
			$delivery_area_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "delivery_area` WHERE delivery_area_id = '" . (int)$address_query->row['delivery_area_id'] . "'");
			if ($delivery_area_query->num_rows) {
				$delivery_area_name = $delivery_area_query->row['delivery_area_name'];
			} else {
				$delivery_area_name = '';
			}

			$address_data = array(
				'address_id'     => $address_query->row['address_id'],
				'firstname'      => $address_query->row['firstname'],
				'lastname'       => $address_query->row['lastname'],
				'company'        => $address_query->row['company'],
				'address_1'      => $address_query->row['address_1'],
				'address_2'      => $address_query->row['address_2'],
				'postcode'       => $address_query->row['postcode'],
				'city_id'        => $city_id,
				'city'           => $city_name,
				'zone_id'        => $address_query->row['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $zone_code,
				'country_id'     => $address_query->row['country_id'],
				'country'        => $country,
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format,
				'custom_field'   => unserialize($address_query->row['custom_field']),
				'telephone'      => $address_query->row['telephone'],
				'service_zone_id'   => $address_query->row['service_zone_id'],
				'service_zone_name' => $service_zone_name,
				'service_zone_code' => $service_zone_code,
				'delivery_area_id'  => $address_query->row['delivery_area_id'],
				'delivery_area_name' => $delivery_area_name
			);

			return $address_data;
		} else {
			return false;
		}
	}

	// myzhou 2015/8/12 添加$flag判断是否需要添加service_zone_id条件
	public function getAddresses($flag = false) {
		$address_data = array();

		if($flag === false){
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		} else {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$this->customer->getId() . "' AND service_zone_id = '" . (int)$this->session->data['service_zone_id'] . "'");
		}

		foreach ($query->rows as $result) {
			// myzhou 2015/6/3 delete country/zone
			/*
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$result['country_id'] . "'");

			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else { 
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$result['zone_id'] . "'");

			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}
			*/
			$country = '';
			$iso_code_2 = '';
			$iso_code_3 = '';
			$address_format = '';
			$zone = '';
			$zone_code = '';

			$city_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "city` WHERE city_id = '" . (int)$query->row['city_id'] . "'");
			if ($city_query->num_rows) {
				$city_id = $city_query->row['city_id'];
				$city_name = $city_query->row['city_name'];
			} else {
				$city_id = '';
				$city_name = '';
			}

			$service_zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "service_zone` WHERE service_zone_id = '" . (int)$result['service_zone_id'] . "'");
			if ($service_zone_query->num_rows) {
				$service_zone_name = $service_zone_query->row['service_zone_name'];
				$service_zone_code = $service_zone_query->row['service_zone_code'];
			} else {
				$service_zone_name = '';
				$service_zone_code = '';
			}

			$delivery_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "delivery_area WHERE delivery_area_id = '" .(int)$result['delivery_area_id']. "'");
			if ($delivery_query->num_rows) {
				$delivery_area_name = $delivery_query->row['delivery_area_name'];
			} else {
				$delivery_area_name = '';
			}

			$address_data[$result['address_id']] = array(
				'address_id'     => $result['address_id'],
				'firstname'      => $result['firstname'],
				'lastname'       => $result['lastname'],
				'company'        => $result['company'],
				'address_1'      => $result['address_1'],
				'address_2'      => $result['address_2'],
				'postcode'       => $result['postcode'],
				'city_id'        => $city_id,
				'city'           => $city_name,
				'zone_id'        => $result['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $zone_code,
				'country_id'     => $result['country_id'],
				'country'        => $country,
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format,
				'custom_field'   => unserialize($result['custom_field']),
				'telephone'      => $result['telephone'],
				'company'        => $result['company'],
				'service_zone_id'  => $result['service_zone_id'],
				'service_zone_name' => $service_zone_name,
				'delivery_area_id'  => $result['delivery_area_id'],
				'delivery_area_name' => $delivery_area_name
			);
		}

		return $address_data;
	}

	public function getTotalAddresses() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		return $query->row['total'];
	}
}