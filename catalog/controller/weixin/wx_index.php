<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-21
 * 描述: 处理通过微信网页授权页面访问爱佰味网页的 controller
 */
class ControllerWeixinWxindex extends Controller {
	// url中的state参数
	private $state;
	// url中的code参数
	private $code;
	// url中的route参数
	private $route = 'common/home';
	// url中的其他参数(不包括url中的state/code/route)
	private $params = array();
	private $openid;
	private $web_access_token;

	public function index() {
		$this->init();

		if(isset($this->openid)) {
			$this->session->data['openid'] = $this->openid;

			// 自动登录
			if (!$this->customer->isLogged()) {
				$this->load->controller('weixin/wx_login', $this->openid);
			}
		}

		// URL参数
		$params_str = '';
		while(list($key, $value) = each($this->params)){
			$params_str .= '&'.$key.'='.$value;
		}
		
		// 重定向
		$this->response->redirect($this->url->link($this->route, $params_str, 'SSL'));
	}

	/**
	 * 初期化方法
	 * 重点是将参数中的'/?'或'?'分割开
	 * (因为微信授权重定向的时候会在自定义的URL后面添加'/?code=CODE&state=STATE'或'?code=CODE&state=STATE')
	 */
	private function init() {
		if (!isset($this->request->get['state']) || (!isset($this->request->get['code']) && !isset($this->request->get['route']))) {
			// 重定向到首页
			$this->response->redirect($this->url->link('common/home', '', 'SSL'));
		}

		// 获取参数
		$params = array();
		while(list($key, $value) = each($this->request->get)){
			if(substr_count($value, '/?')){
				list($k, $v) = explode('/?',$value);
				$params[$key] = $k;
				
				list($m, $n) = explode('=', $v);
				
				$params[$m] = $n;
			} else if(substr_count($value, '?')){
				list($k, $v) = explode('?',$value);
				$params[$key] = $k;
				
				list($m, $n) = explode('=', $v);
				
				$params[$m] = $n;
			} else {
				$params[$key] = $value;
			}
		}
		
		$this->state = $params['state'];
		$this->code  = $params['code'];
		if(isset($params['route'])){
			$this->route = $params['route'];
		}
		
		unset($params['state']);
		unset($params['code']);
		unset($params['route']);
		$this->params = $params;

		// 获取网页授权信息
		$result = $this->weixin->getOauthInfo($this->code);
		$this->web_access_token = $result['access_token'];
		$this->openid = $result['openid'];
	}
}