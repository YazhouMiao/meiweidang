<?php
/**
 * 作者: myzhou
 * 时间: 2015-7-20
 * 描述: 微信公众号支付接口实现 Controller
 * 流程：
 * 1、取得用户openid
 * 2、配置订单信息，统一下单
 * 3、在支持成功回调通知中处理成功之后的事宜
 */
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "lib/WxPay.Api.php";
require_once "lib/WxPay.JsApiPay.php";

class ControllerPaymentWxpayJsapi extends Controller {
	public function index(){
		$log = new Log('wx_jsapi.log');
		$params = array();
		
		//①、获取用户openid
		$log->write('openid:'.$this->session->data['openid']);
		
		if (isset($this->session->data['openid'])) {
			$params['openId'] = $this->session->data['openid'];
		} else {
			return;
		}
		
		// 通过config接口注入权限验证配置
		$data['wx_version'] = $this->weixin->getWxVersion();
		$data['appId']      = $this->weixin->getAppid();
		$data['wx_timestamp']  = time();
		$data['wx_nonceStr']   = 'abacdefafa';
		$data['wx_ticket']     = $this->weixin->getJsapiTicket();
		$data['wx_url']        = $this->url->link('checkout/checkout', '', 'SSL');
		$data['wxOri']         = sprintf("jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s", $data['wx_ticket'], $data['wx_nonceStr'], $data['wx_timestamp'], $data['wx_url']);
		$data['wx_signature']  = sha1($data['wxOri']);
		
		$log->write('appid:'.$data['appId']);
		
		$data['success_url'] = $this->url->link('checkout/success', '', 'SSL');
		
		$this->load->model('checkout/order');
		
		$order_id = $this->session->data['order_id'];
		
		$order_info = $this->model_checkout_order->getOrder($order_id);
		
		// 商品描述
		$params['body'] = $this->config->get('config_name').'订单：'.$order_id;
		// 附加数据
		$params['attach'] = '请在一个小时内完成支付!';
		// 订单号
		$params['out_trade_no'] = $order_id;
		// 总金额(整数/分)
		$params['total_fee'] = number_format($order_info['total'], 2, '.', '') * 100;
		// 商品标记
		$params['goods_tag'] = 'NORMAL';
		// 通知地址
		$params['notify_url'] = HTTP_SERVER . 'catalog/controller/payment/wxpay_notify_index.php';;
		// 商品ID
		$params['product_id'] = $order_id;
		
		// Log
		foreach($params as $key => $value){
			$this->log->write($key.':'.$value);
		}
		
		//②、统一下单
		$result = $this->getJsapiParameters($params);
		// Log
		foreach($result as $key => $value){
			$this->log->write($key.':'.$value);
		}
		if(!empty($result)){
			// $data['jsApiParameters'] = $jsApiParameters;
			$data['timestamp'] = $result['timeStamp'];
			$data['nonceStr']  = $result['nonceStr'];
			$data['package']   = $result['package'];
			$data['signType']  = $result['signType'];
			$data['paySign']   = $result['paySign'];
		} else {
			return;
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/wxpay_jsapi.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/wxpay_jsapi.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/wxpay_jsapi.tpl', $data);
		}
	}
	
	/*
	 * 统一下单,取得js调用微信支付所需的参数
	 * @param 参数
	 * @return js调用微信支付所需参数
	 */
	protected function getJsapiParameters($params = array()) {
		
		$input = new WxPayUnifiedOrder();
		$input->SetBody($params['body']);
		$input->SetAttach($params['attach']);
		$input->SetOut_trade_no($params['out_trade_no']);
		$input->SetTotal_fee($params['total_fee']);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 3600));
		$input->SetGoods_tag($params['goods_tag']);
		$input->SetNotify_url($params['notify_url']);
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($params['openId']);
		$result = WxPayApi::unifiedOrder($input);
		
		$tools = new JsApiPay();
		
		if(($result['result_code'] == 'SUCCESS') && ($result['return_code'] == 'SUCCESS')){
			$jsApiParameters = $tools->GetJsApiParameters($result);
		} else {
			$jsApiParameters = '';
			// Log
			foreach($result as $key => $value){
				$this->log->write($key.':'.$value);
			}
		}
		
		return $jsApiParameters;
	}
	
	/**
	 *
	 * 产生随机字符串，不长于32位
	 * @param int $length
	 * @return 产生的随机字符串
	 */
	public function getNonceStr($length = 32)
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {
			$str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
		}
		return $str;
	}
}