<?php
/**
 * 作者: myzhou
 * 时间: 2015-7-23
 * 描述: 微信支付异步通知处理  Controller
 */

ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';

class ControllerPaymentWxpayNotify extends Controller {
	public function index(){
		$flag = true;
		$notify = new WxPayNotify();
		$msg = "OK";
		
		//获取微信支付返回的通知数据
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		$data = WxPayResults::Init($xml);
		
		if(!array_key_exists('transaction_id', $data)){
			$msg = "返回参数不正确";
			
			// 返回信息
			$notify->Handle(false);
			$this->log->write($msg.":".'transaction_id不存在');
		}
		
		//查询订单，判断订单真实性
		$result = $this->Queryorder($data['transaction_id']);
		
		if(($result['return_code'] == 'SUCCESS') && ($result['result_code'] == 'SUCCESS')){
			$this->log->write("Wxpay order_id :: ".$result['out_trade_no']." trade_status = ".$result['trade_state']);
			
			// 返回成功信息
			$notify->Handle(false);
			
			if($result['trade_state'] == 'SUCCESS'){
				$this->load->model('checkout/order');
				
				//单位:分转为元
				$total_fee = $result['total_fee'] / 100;
				$order_id  = $result['out_trade_no'];
				
				$order_info = $this->model_checkout_order->getOrder($order_id);
	
	            if ($order_info) {
	                $order_status_id = $order_info["order_status_id"];
	                $this->log->write("Wxpay order_id :: ".$order_id." order_status_id = ".$order_status_id." , trade_status :: ".$result['trade_state']);
	
	                $total = $order_info['total'];
	                // 确定支付和订单额度一致
	                $this->log->write("Wxpay total_fee :: ".$total_fee.",total :: ".$total);
	                if ($total <= $total_fee) {
	                    // 根据接口类型动态使用支付方法
	                	if($result['trade_type'] == 'JSAPI'){
	                		$new_status = $this->config->get('wxpay_jsapi_order_status_id');
	                	} else if($result['trade_type'] == 'NATIVE'){
	                		$new_status = $this->config->get('wxpay_native_order_status_id');
	                	}
	                    if ($new_status > $order_status_id) {
	                    	$this->log->write("Wxpay order_id :: ".$order_id." update start!!!!!");
	                    	$this->model_checkout_order->addOrderHistory($order_id, $new_status);
	                        $this->log->write("Wxpay order_id :: ".$order_id." update order_status_id to ".$new_status);
	                    	// 发送新订单提醒 
	                    	$this->load->controller('weixin/wx_message/newOrderNotify', $order_id);
	                    }
	                }
	            } else {
	               $this->log->write("Wxpay No Order Found. Order_id ::".$order_id);
           	    }
			}
		} else {
			$msg = "返回参数不正确";
			
			// 返回信息
			$notify->Handle(false);
			foreach($result as $key => $value){
				$this->log->write($key.":".$value);
			}
		}
	}
	
	/*
	 * 查询订单
	 * @param $transaction_id 微信订单号
	 * @return $result 订单的查询结果
	 */
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		
		return $result;
	}
}

class PayNotifyCallBack extends WxPayNotify
{
	
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		return true;
	}
}