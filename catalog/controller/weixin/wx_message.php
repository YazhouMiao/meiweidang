<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-26
 * 描述: 公众号主动向微信用户发送消息 controller
 */
class ControllerWeixinWxmessage extends Controller {

	/**
	 * 新订单提醒,微信通知配送人员和商家
	 * @param $order_id 新订单id
	 */
	public function newOrderNotify($order_id){
		$this->load->language('weixin/wx_message');

		// 订单基本信息
		$order_info = array();
		$this->load->model('checkout/order');
		$query_result = $this->model_checkout_order->getOrder($order_id);
		
		if($query_result){
			$order_info['id']                 = $order_id;
			$order_info['name']               = $query_result['firstname'];
			$order_info['telephone']          = $query_result['telephone'];
			$order_info['company']            = $query_result['payment_company'];
			$order_info['address']            = $query_result['payment_address_1'];
			$order_info['service_zone_id']    = $query_result['service_zone_id'];
			$order_info['service_zone_name']  = $query_result['service_zone_name'];
			$order_info['delivery_area_id']   = $query_result['delivery_area_id'];
			$order_info['delivery_area_name'] = $query_result['delivery_area_name'];
			$order_info['products']           = $this->getProductInfo($order_id);
		} else {
			// doing nothing
			return;
		}
		
		// admin
		$admin = $this->getAdmin($order_info['service_zone_id']);
		
		// error message
		$ps_err_msg = sprintf($this->language->get('ps_err_msg'), $order_info['id']);
		$sj_err_msg = sprintf($this->language->get('sj_err_msg'), $order_info['id']);
		
		// language
		$ps_lang = array();
		$sj_lang = array();
		$ps_lang['tpl_first'] = $this->language->get('ps_tpl_first');
		$ps_lang['tpl_remark'] = $this->language->get('ps_tpl_remark');
		$ps_lang['sj_name'] = $this->language->get('sj_name');
		$ps_lang['sj_address'] = $this->language->get('sj_address');
		$ps_lang['sj_telephone'] = $this->language->get('sj_telephone');
		$ps_lang['pt_info'] = $this->language->get('pt_info');
		$ps_lang['pt_name'] = $this->language->get('pt_name');
		$ps_lang['pt_quantity'] = $this->language->get('pt_quantity');
		$ps_lang['pt_unit'] = $this->language->get('pt_unit');
		
		$sj_lang['tpl_first']  = $this->language->get('sj_tpl_first');
		$sj_lang['tpl_remark'] = $this->language->get('sj_tpl_remark');
		$sj_lang['ps'] = $this->language->get('ps');
		$sj_lang['ps_empty'] = $this->language->get('ps_empty');
		$sj_lang['pt_unit'] = $this->language->get('pt_unit');

		// 1.给配送人员发送消息(模板消息)
 		$staff = $this->getDeliverierStaff($order_info['delivery_area_id']);
// 		$ps_param = $this->getParamToDeliverier($ps_lang, $order_info);
// 		if (!empty($staff['openid']) && $this->weixin->sendTempleteMessageToDeliverer($staff['openid'], $ps_param)) {
// 			// 添加到delivery_history表中
// 			$this->load->model('delivery/history');
// 			$this->model_delivery_history->addDeliveryHistory($order_info['id'], $staff['delivery_staff_id']);
// 		} else {
// 			// 通知管理员
// 			$this->weixin->sendTextMessage($admin['openid'], $ps_err_msg);
// 		}

		// 2.给商家发送消息
		foreach ($order_info['products'] as $business){
			$sj_param = $this->getParamToBusiness($sj_lang, $order_info, $business, $staff);
			$failedOpenid = array();
			$flag = 0;
			// 每个商家最多3个openid
			if($business[0]['openid_1']){
				$flag++;
				if(!$this->weixin->sendTempleteMessageToBusiness($business[0]['openid_1'], $sj_param)){
					array_push($failedOpenid, $business[0]['openid_1']);
				}
			}
			if($business[0]['openid_2']){
				$flag++;
				if(!$this->weixin->sendTempleteMessageToBusiness($business[0]['openid_2'], $sj_param)){
					array_push($failedOpenid, $business[0]['openid_2']);
				}
			}
			if($business[0]['openid_3']){
				$flag++;
				if(!$this->weixin->sendTempleteMessageToBusiness($business[0]['openid_3'], $sj_param)){
					array_push($failedOpenid, $business[0]['openid_3']);
				}
			}
			// 全发送失败,通知管理员
			if($flag == count($failedOpenid)){
				$sj_err_msg .= ','.$business[0]['business_id'].','.$business[0]['business_name'];
				$this->weixin->sendTextMessage($admin['openid'], $sj_err_msg);
	
				// 将发送失败的消息添加到历史记录表 TODO:
// 				foreach($failedOpenid as $openid){
// 					$this->addMessageRecord($openid, $sj_param);
// 				}
			}
		}
	}

	/**
	 * 获取接收新订单提醒消息的配送人员
	 * 
	 * @param $delivery_area_id 配送区域id
	 * @return $staff 配送人员的信息
	 */
	private function getDeliverierStaff($delivery_area_id){
		$this->load->model("delivery/schedule");
		$delivery_query = $this->model_delivery_schedule->getDeliveryStaffsByCurrentMoment($delivery_area_id);
		if ($delivery_query) {
			// 当前日期
			$curDate = date("Y-m-d");
			foreach ($delivery_query as $delivery) {
				// 起始时间
				$startTime = $curDate .' '. $delivery['start_time'];
				// 截止时间
				$endTime   = $curDate .' '. $delivery['end_time'];
				if($this->checkEnable($delivery['delivery_staff_id'], $startTime, $endTime)){
					$this->load->model("delivery/staff");
					$staff = $this->model_delivery_staff->getDeliveryStaff($delivery['delivery_staff_id']);
					return $staff;
				}
			}
			return '';
		} else {
			return '';
		}
	}
	
	/**
	 * 获取接收新订单提醒消息的管理人员
	 * 
	 * @param $service_zone_id 管理员所在服务区id
	 * @return $result 管理人员的信息
	 */
	private function getAdmin($service_zone_id){
		$this->load->model('localisation/service_zone');

		$result = $this->model_localisation_service_zone->getServiceZone($service_zone_id);
		
		if ($result) {
			return $result;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取发送给配送人员的消息内容
	 * @param $sj_tpl_first
	 * @param $sj_tpl_remark
	 * @param $order_info 订单的基本信息
	 * @param $product_info 按商家分组的商品信息
	 * @return $message 信息内容
	 */
	private function getParamToDeliverier($ps_lang, $order_info){
		// 使用微信消息模板
		$msg['first']  = $ps_lang['tpl_first'];
		$msg['remark'] = $ps_lang['tpl_remark'];
		// 订单号
		$msg['keyword1'] = $order_info['id'];
		// 下单人信息
		$msg['keyword2'] = $order_info['name'].','.$order_info['telephone'];
		// 配送地址
		$msg['keyword3'] = $order_info['service_zone_name'].','.$order_info['address'].','.$order_info['company'];
		// 商品信息
		$content = '\n';
		$option_info = array();
		foreach ($order_info['products'] as $business) {
			$content .= $ps_lang['sj_name'].$business[0]['business_name'].'\n';
			foreach($business as $product){
				$content .= $ps_lang['pt_info'].'\n'.$product['name'].', '.$product['model'].', '.$product['quantity'].$ps_lang['pt_unit'].'\n';
				if(!empty($product['option'])){
					foreach($product['option'] as $option){
						$option_info[] = $option['name'].':'.$option['value'];
					}
					if(!empty($option_info)){
						$content .= '(' . implode(',', $option_info) .')\n';
					}
				}
			}
			$content .= '\n';
		}
		$msg['keyword4'] = $content;

		return $msg;
	}
	
	/**
	 * 获取发送给商家的模板消息参数
	 * @param $sj_lang 商家消息模板需要的固定文字
	 * @param $order_info 订单的基本内容
	 * @param $business 该商家订单的消息
	 * @return $openid 管理人员的openid
	 */
	private function getParamToBusiness($sj_lang, $order_info, $business, $staff){
		// 使用微信消息模板
		$msg['first']  = $sj_lang['tpl_first'];
		$msg['remark'] = $sj_lang['tpl_remark'];
		// 订单号
		$msg['keyword1'] = $order_info['id'];
		// 联系信息(配送人员消息)
// 		if(!empty($staff)){
// 			$msg['keyword2'] = $staff['delivery_staff_name'].', '.$staff['telephone'].$sj_lang['ps'];
// 		} else {
// 			$msg['keyword2'] = $sj_lang['ps_empty'];
// 		}
		// 联系信息(用户)
		$msg['keyword2'] = $order_info['name'].', '.$order_info['telephone'];
		// 订单内容
		$counter = 1;
		$content = '\n';
		$option_info = array();
		foreach($business as $product){
			$content .= $counter.'、'.$product['name'].', '.$product['model'].', '.$product['quantity'].$sj_lang['pt_unit'];
			if(!empty($product['option'])){
				foreach($product['option'] as $option){
					$option_info[] = $option['name'].':'.$option['value'];
				}
				
				if(!empty($option_info)){
					$content .= '(' . implode(',', $option_info) .')\n';
				}
			}
			$counter++;
		}
		$msg['keyword3'] = $content;
		// 订单地址
		$msg['keyword4'] = $order_info['service_zone_name'].','.$order_info['address'].','.$order_info['company'];
		// 预计送达时间  TODO:处理送达时间(半小时)
		$msg['keyword5'] = date('Y-m-d H:i',time()+1800);
		
		return $msg;
	}
	
	/**
	 * 检查配送人员在某个时间段内是否可以继续接单(有没有超过最大配送量)
	 *
	 * @param $delivery_staff_id 配送人员id
	 * @return true:可用  false:不可用
	 */
	private function checkEnable($delivery_staff_id, $start_time, $end_time){
		$this->load->model('delivery/staff');
		$this->load->model('delivery/history');
		
		$staff = $this->model_delivery_staff->getDeliveryStaff($delivery_staff_id);
		$total = $this->model_delivery_history->getDeliveryTotal($delivery_staff_id, $start_time, $end_time);
		// 当前配送量 < 最大配送量  true
		if (!empty($staff) && $total < $staff['delivery_amount']) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * 获取订单详细信息,并按照商家的不同进行分组
	 * @param $order_id 订单号
	 * @return $result 按商家分组后的订单信息
	 */
	private function getProductInfo($order_id){
		$order_data = array();
		$this->load->model('delivery/task');
		$this->load->model('catalog/manufacturer');

		$products = $this->model_delivery_task->getOrderProducts($order_id);
		
		$option_data = array();
		foreach ($products as $product) {
			$options = $this->model_delivery_task->getOrderOptions($order_id, $product['order_product_id']);
			
			foreach ($options as $option) {
				$value = $option['value'];

				$option_data[] = array(
					'name'  => $option['name'],
					'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
				);
			}

			$manufacturer = $this->model_catalog_manufacturer->getManufacturerByProductId($product['product_id']);

			$order_data[] = array(
				'product_id' => $product['product_id'],
				'name'       => $product['name'],
				'model'      => $product['model'],
				'option'     => $option_data,
				'quantity'   => $product['quantity'],
				'price'      => $product['price'],
				'total'      => $product['total'],
				'reward'     => $product['reward'],
				'business_id' => $manufacturer['manufacturer_id'],
				'business_name' => $manufacturer['name'],
				'address'    => $manufacturer['address'],
				'telephone'  => $manufacturer['telephone'],
				'openid_1'   => $manufacturer['openid_1'],
				'openid_2'   => $manufacturer['openid_2'],
				'openid_3'   => $manufacturer['openid_3']
			);
		}
		
		// 按business_id分组
		$result = array();
		foreach($order_data as $k => $value){
    		$result[$value['business_id']][]    =   $value;
		}
		
		return $result;
	}
}