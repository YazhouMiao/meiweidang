<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-26
 * 描述: 创建微信公众平台相关的基本操作 library
 */
final class Weixin {
	private $registry;
	private $app_id;
	private $app_secret;
	private $token;
	private $EncodingAESKey;
	private $debug;
	private $logger;
	
	public function __construct($registry) {
		$this->registry    = $registry;

		$this->app_id      = $this->config->get('weixin_app_id');
		$this->app_secret  = $this->config->get('weixin_app_secret');
		$this->token       = $this->config->get('weixin_token');
		$this->logging     = $this->config->get('weixin_debug');
		$this->EncodingAESKey = $this->config->get('weixin_EncodingAESKey');
		
		$this->load->library('log');

		$this->logger = new Log('weixin.log');
	}

	public function __get($name) {
		return $this->registry->get($name);
	}

	/**
	 * 获取普通access_token
	 *
	 * @return access_token
	 */
	public function getAccessToken() {
		// 先从缓存中获取
		$access_token = $this->cache->get('weixin_access_token');

		if (!$access_token) {
			//缓存中取不到
			$token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->app_id . "&secret=" . $this->app_secret;
			$res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
			$result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
			$access_token = $result['access_token'];
		
			$this->cache->set('weixin_access_token', $access_token);
		}
		
		return $access_token;
	}

	/**
	 * 通过code换取网页授权信息(包括：access_token/openid)
	 * @param code 网页授权code
	 * @return 网页授权信息
	 */
	public function getOauthInfo($code) {
		// 网页授权 URL
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $this->app_id . "&secret=" . $this->app_secret ."&code=" . $code ."&grant_type=authorization_code";
		$res = file_get_contents($url); //获取文件内容或获取网络请求的内容
		$result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量
	
		$this->logger->write('access_token:'.$result['access_token']);
		return $result;
	}
	
	/**
	 * 公众号发送客服消息(文本消息)
	 * @param $openid 接收者openid
	 * @param $text 消息内容
	 */
	public function sendTextMessage($openid, $text) {
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $this->getAccessToken();
		// 注意：消息格式不能变
		$message = '{"touser":"' . $openid .'",
					 "msgtype":"text",
					 "text":{"content":"' .$text. '"}}';
		
		$res = $this->https_post($url, $message);
		$result = json_decode($res, true);
		
		if($result['errcode'] == 0){
			$logMessage = "客服文本消息发送成功！openid:". $openid ."   message:" . $text;
			$this->log($logMessage, true);
			return true;
		} else {
			$logMessage = "客服文本消息发送失败！openid:". $openid ."   message:" . $text;
			$this->log($logMessage, true);
			return false;
		}
	}
	
	/**
	 * 公众号给配送人员发送消息(模板消息)
	 * @param $openid 配送员openid
	 * @param $param 符合微信模板消息参数规则
	 */
	public function sendTempleteMessageToDeliverer($openid, $param) {
		$request_url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $this->getAccessToken();
	
		// 配送人员消息的templete_id/url
		$templete_id = $this->config->get('weixin_new_order_deliverer_template_id');
		$url_str = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=0#wechat_redirect';
		$redirect_uri = urlencode($this->config->get('weixin_new_order_deliverer_url') . '&order_id=' . $param['keyword1']);
		$url = sprintf($url_str, $this->app_id, $redirect_uri);
		// 注意：消息格式不能变,keynote1:订单号/keynote2:联系人信息 /keynote3:配送地址/keynote4:订单信息
		$message = '{"touser":"'.$openid.'",
					 "template_id":"'.$templete_id.'",
					 "url":"'.$url.'",
					 "topcolor":"#FFFFFF",
					 "data":{
					 	"first":{"value":"'.$param['first'].'","color":"#173177"},
					 	"keyword1":{"value":"'.$param['keyword1'].'","color":"#173177"},
					 	"keyword2":{"value":"'.$param['keyword2'].'","color":"#173177"},
					 	"keyword3":{"value":"'.$param['keyword3'].'","color":"#173177"},
					 	"keyword4":{"value":"'.$param['keyword4'].'","color":"#173177"},
					 	"remark":{"value":"'.$param['remark'].'","color":"#173177"}
					 }}';
		
		$res = $this->https_post($request_url, $message);
		$result = json_decode($res, true);
	
		if($result['errcode'] == 0){
			$logMessage = '发送给配送人员的模板消息发送成功！openid:'. $openid .'   message:'. $message;
			$this->log($logMessage, true);
			return true;
		} else {
			$logMessage = '发送给配送人员的模板消息发送失败！errcode:'.$result['errcode'].'   openid:'. $openid .'   message:' . $message;
			$this->log($logMessage, true);
			return false;
		}
	}
	
	/**
	 * 公众号给商家发送消息(模板消息)
	 * @param $param 符合微信模板消息参数规则
	 */
	public function sendTempleteMessageToBusiness($openid,$param) {
		$request_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $this->getAccessToken();
	
		// 商家消息的templete_id/url
		$templete_id = $this->config->get('weixin_new_order_business_template_id');
		$url = $this->config->get('weixin_new_order_business_url');
		// 注意：消息格式不能变 keynote1:订单号 /keynote2:订单内容/keynote3:配送员信息
		$message = '{"touser":"'.$openid.'",
					 "template_id":"'.$templete_id.'",
					 "url":"'.$url.'",
					 "topcolor":"#FFFFFF",
					 "data":{
					 	"first":{"value":"'.$param['first'].'","color":"#173177"},
					 	"keyword1":{"value":"'.$param['keyword1'].'","color":"#173177"}, 
					 	"keyword2":{"value":"'.$param['keyword2'].'","color":"#173177"},
					 	"keyword3":{"value":"'.$param['keyword3'].'","color":"#173177"},
					 	"keyword4":{"value":"'.$param['keyword4'].'","color":"#173177"},
					 	"keyword5":{"value":"'.$param['keyword5'].'","color":"#173177"},
					 	"remark":{"value":"'.$param['remark'].'","color":"#173177"}
					 }}';
	
		$res = $this->https_post($request_url, $message);
		$result = json_decode($res, true);
	
		if($result['errcode'] == 0){
			$logMessage = '发送给商家的模板消息发送成功！openid:'. $openid .'   message:'. $message;
			$this->log($logMessage, true);
			return true;
		} else {
			$logMessage = '发送给商家的模板消息发送失败！errcode:'.$result['errcode'].'   openid:'. $openid .'   message:' . $message;
			$this->log($logMessage, true);
			return false;
		}
	}
	
	/*
	 * 获取jsapi的ticket;jsapi_ticket是公众号用于调用微信JS接口的临时票据
	 */
	public function getJsapiTicket(){

		$ticket = $this->cache->get('weixin_jsapi_ticket');
		
		if (empty($ticket)) {
			$token = $this->getAccessToken();
			
			$url = sprintf("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi",	$token);
			$res = file_get_contents($url);
			$result = json_decode($res, true);
			$ticket = $result['ticket'];
			$this->cache->set('weixin_jsapi_ticket', $ticket);
		}
		
		return $ticket;
	}

	/**
	 * 公众号开发相关的log写入方法
	 * @param $data 需要写入的数据
	 * @param $write 是否写入
	 */
	public function log($data, $write = true) {
		if ($this->logging == 1) {
			if (function_exists('getmypid')) {
				$process_id = getmypid();
				$data = $process_id . ' - ' . $data;
			}

			if ($write == true) {
				$this->logger->write($data);
			}
		}
	}
	
	/**
	 * 获取token
	 */
	public function getToken() {
		return $this->token;
	}

	/**
	 * 获取app_id
	 */
	public function getAppid() {
		return $this->app_id;
	}

	/**
	 * 获取app_secret
	 */
	public function getAppsecret() {
		return $this->app_secret;
	}

	/**
	 * curl方式传输数据
	 * @param $url curl的url
	 * @param $data curl的数据内容
	 * @return 返回执行结果  true:成功  false:失败
	 */
	private function https_post($url, $data){
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//SSL证书认证
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);//严格认证
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
		curl_setopt($curl, CURLOPT_POST,1); // post方式传输数据
		curl_setopt($curl, CURLOPT_POSTFIELDS,$data);// 传输数据
		$result = curl_exec($curl);
		curl_close($curl);
		
		return $result;
	}
	
	/*
	 * 判断请求是否来自微信客户端,并返回微信版本号
	 */
	function getWxVersion() {
		if (isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			// 获取版本号
   			preg_match('/.*?(MicroMessenger\/([0-9.]+))\s*/', $_SERVER['HTTP_USER_AGENT'], $matches);
    		return $matches[2];
		}
		return false;
	}
}