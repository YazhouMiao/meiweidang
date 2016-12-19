<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-22
 * 描述: 微信用户关注公众号时,同时注册爱佰味账号功能  controller
 */
class ControllerWeixinWxregister extends Controller {

	public function index($user_info) {
		// 从公众平台推送消息中获取用户信息
		$data['subscribe']     = $user_info['subscribe'];
		$data['openid']        = $user_info['openid'];
		$data['nickname']      = $user_info['nickname'];
		$data['sex']           = $user_info['sex'];
		$data['city']          = $user_info['city'];
		$data['province']      = $user_info['province'];
		$data['country']       = $user_info['country'];
		$data['remark']        = $user_info['remark'];
		$data['groupid']       = $user_info['groupid'];
		// 客户所属群组
		$data['customer_group_id'] = $this->config->get('weixin_customer_group_id');

		$this->load->model('weixin/wx_customer');
		// 判断是否已经存在该用户
		$customer_info = $this->model_weixin_wx_customer->getWxCustomerByOpenid($data['openid']);
		if ($customer_info) {
			// 重新关注
			$this->model_weixin_wx_customer->updateSubscribe($data['openid'], true);
		} else {
			// 添加微信用户
			$customer_id = $this->model_weixin_wx_customer->addWxCustomer($data);
			
			$this->session->data['account'] = 'register';
			
			// Add to activity log
			$this->load->model('account/activity');
			
			$activity_data = array(
					'customer_id' => $customer_id,
					'name'        => $data['nickname']
			);
			
			$this->model_account_activity->addActivity('subscribe', $activity_data);
		}
	}

	/**
	 * 微信用户取消关注处理方法
	 *
	 * @param openid
	 * @return 处理结果
	 */
	public function cancel($openid) {
		$this->load->model('weixin/wx_customer');
		// 取消微信关注
		$this->model_weixin_wx_customer->updateSubscribe($openid, false);
	}
}