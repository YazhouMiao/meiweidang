<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-18
 * 描述: 支付宝即时到账接口实现 Controller
 */
require_once("lib/alipay_submit.class.php");
require_once("lib/alipay_notify.class.php");

class ControllerPaymentAlipayDirect extends Controller {
	
    public function index() {
        $data['button_confirm'] = $this->language->get('button_confirm');
        $data['button_back'] = $this->language->get('button_back');

        $data['return'] = HTTPS_SERVER . 'index.php?route=checkout/success';

        $data['custom'] = $this->encryption->encrypt($this->session->data['order_id']);

        $this->load->model('checkout/order');

        $order_id = $this->session->data['order_id'];

        $order_info = $this->model_checkout_order->getOrder($order_id);

        //支付类型
        $payment_type = '1';

        //订单信息
        $item_name = $this->config->get('config_name');
        $customer_name = $order_info['payment_firstname'];

        //付款金额,格式化保留两位小数
        $total_fee = number_format($order_info['total'], 2, '.', '');

        //服务器异步通知页面路径,不能添加自定义参数
        $notify_url = HTTP_SERVER . 'catalog/controller/payment/alipay_direct_notify_url.php';

        //页面跳转同步通知页面路径,不能添加自定义参数
        $return_url = $this->url->link('payment/alipay_direct/returnUrl', '', 'SSL');
        
        //商品展示地址
        $show_url = "";
        
        //防钓鱼时间戳,若要使用请调用类文件submit中的query_timestamp函数
        $anti_phishing_key = "";
        
        //客户端的IP地址,非局域网的外网IP地址，如：221.0.0.1
        $exter_invoke_ip = "";
        //构造要请求的参数数组，无需改动
        
        $alipay_config = $this->getConfig();
        
        $parameter = array(
       		"service"           => "create_direct_pay_by_user",
       		"partner"           => trim($alipay_config['partner']),
       		"seller_email"      => trim($alipay_config['seller_email']),
       		"payment_type" 	    => $payment_type,
       		"notify_url" 	    => $notify_url,
       		"return_url" 	    => $return_url,
       		"out_trade_no" 	    => $order_id,
       		"subject"	        => $item_name.'订单：' . $order_id ,
       		"total_fee"	        => $total_fee,
       		"body"	            => 'Owner： ' . $customer_name .' ',
       		"show_url"	        => $show_url,
       		"anti_phishing_key"	=> $anti_phishing_key,
       		"exter_invoke_ip"	=> $exter_invoke_ip,
       		"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
        );

        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $data['action'] = $alipaySubmit->buildRequestForm($parameter, 'POST', '');

        return $data['action'];
    }

    /**
     * 支付宝同步通知回调方法：
     * 根据支付状态,跳转到不同页面
     */
    public function returnUrl() {
    	$alipay_config = $this->getConfig();

    	$get_temp = $_GET;
    	unset($_GET['route']);
    	//调用支付宝验证签名接口
    	$alipayNotify = new AlipayNotify($alipay_config);
    	$verify_result = $alipayNotify->verifyReturn();
    	//恢复$_GET数组
    	$_GET = $get_temp;
    	unset($get_temp);
    	
    	if($verify_result){
    		//交易状态
    		$trade_status = $_GET['trade_status'];
    		
    		if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
    			$this->response->redirect($this->url->link('checkout/success'));
    		}
    		else {
    			$this->response->redirect($this->url->link('checkout/failure'));
    		}
    	}
    }
    
    /**
	 * 支付宝异步通知回调方法：
	 * 1、修改订单状态
	 * 2、支付成功后,发出通知
	 */
	public function notifyUrl() {
		$this->log->write("Alipay_direct :: exciting callback function.");
	
		$oder_success = FALSE;
	
		$alipay_config = $this->getConfig();

		//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();
	
		$this->log->write("Alipay_direct :: verify_result  = ".$verify_result);
		if($verify_result) {
			echo "success";
			
			$order_id     = $this->request->post['out_trade_no'];
			$trade_status = $this->request->post['trade_status'];
			$this->log->write("Alipay_direct order_id :: ".$order_id." trade_status == ".$trade_status);
			if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
				 
				$this->load->model('checkout/order');
				$order_info = $this->model_checkout_order->getOrder($order_id);
	
				if ($order_info) {
					$order_status_id = $order_info["order_status_id"];
					$this->log->write("Alipay_direct order_id :: ".$order_id." order_status_id = ".$order_status_id." , trade_status :: ".$trade_status);
	
					$total = $order_info['total'];
					$total_fee = $this->request->post['total_fee'];
					// 确定支付和订单额度一致
					$this->log->write("Alipay_direct total_fee :: ".$this->request->post['total_fee'].",total :: ".$total);
					if ($total <= $total_fee) {
						// 根据接口类型动态使用支付方法
						if ($this->config->get('alipay_direct_order_status_id') > $order_status_id) {
							$this->log->write("Alipay_direct order_id :: ".$order_id." update start!!!!!");
							$this->model_checkout_order->addOrderHistory($order_id, $this->config->get('alipay_direct_order_status_id'));
							$this->log->write("Alipay_direct order_id :: ".$order_id." update order_status_id to ".$this->config->get('alipay_direct_order_status_id'));
							// 发送新订单提醒
							$this->load->controller('weixin/wx_message/newOrderNotify', $order_id);
						}
					}
				} else {
					$this->log->write("Alipay_direct No Order Found. Order_id ::".$order_id);
				}
			}
		} else {
			echo "fail";
		}
	}
	
	protected function getConfig(){
		$alipay_config = array();

		//合作身份者id
		$alipay_config['partner'] = $this->config->get('alipay_partner');
		
		//收款支付宝账号
		$alipay_config['seller_email'] = $this->config->get('alipay_seller_email');
		
		//安全检验码
		$alipay_config['key'] = $this->config->get('alipay_security_code');
		
		//签名方式 不需修改
		$alipay_config['sign_type'] = strtoupper('MD5');
		
		//字符编码格式utf-8
		$alipay_config['input_charset'] = strtolower('utf-8');
		
		//ca证书路径地址
		$alipay_config['cacert'] = dirname(__FILE__).'/cert/cacert.pem';
		
		//访问模式
		$alipay_config['transport'] = 'http';
		
		return $alipay_config;
	}
}
