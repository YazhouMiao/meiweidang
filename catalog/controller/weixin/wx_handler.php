<?php
/**
 * 作者: myzhou
 * 时间: 2015-5-21
 * 描述: 微信开发平台对接接口,专门处理来自公众号的用户消息  controller
 */
class ControllerWeixinWxhandler extends Controller {

	public function index() {
		//test 公众平台验证网站有效性使用的方法
// 		$this->valid();

		//获取公众号接收的消息
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
	
		//extract post data
		if (!empty($postStr)){
	
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$RX_TYPE = trim($postObj->MsgType);
	
			switch($RX_TYPE)
			{   //文本消息
				case "text":
					$resultStr = $this->handleText($postObj);
					break;
				//事件推送
				case "event":
					$resultStr = $this->handleEvent($postObj);
					break;
				default:
					$resultStr = "Unknow msg type: ".$RX_TYPE;
					break;
			}
			echo $resultStr;
		}else {
			echo "";
			exit;
		}
	}
	
	/**
	 * 文本消息处理函数
	 *
	 * @param 公众平台推送的用户文本消息
	 * @return 与用户对话消息
	 */
	public function handleText($postObj) {
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		$keyword = trim($postObj->Content);
		$time = time();
		$textTpl = "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>0</FuncFlag>
                </xml>";
		if(!empty( $keyword ))
		{
			$msgType = "text";
			$contentStr = "您好！很高兴为您服务！";
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			echo $resultStr;
		}else{
			echo "Input something...";
		}
	}
	
	/**
	 * 事件消息处理函数
	 *
	 * @param 公众平台推送的用户事件消息
	 * @return 处理结果
	 */
	public function handleEvent($postObj) {
		$contentStr = "";
		switch ($postObj->Event)
		{   // 关注公众号
			case "subscribe":
				// 获取用户信息
				$user_info = $this->getUserInfo($postObj->FromUserName);
				// 新微信用户自动注册
				$this->load->controller('weixin/wx_register', $user_info);
				// 返回消息内容
				$contentStr = "感谢您关注【美味当】公众号！"."\n".
				              "美味当，为您提供韩式铁板烤肉拌饭外卖服务，美味送到您的寝室哟！"."\n".
				              "您已经成为美味当会员，可通过公众号进入官方网站完善个人信息。";
				break;

			// 取消关注公众号
			case "unsubscribe":
				$this->load->controller('weixin/wx_register/cancel', $postObj->FromUserName);
				$contentStr = "";

			default :
				echo "";
				exit();
		}
		
		// 返回文本消息
		$resultStr = $this->responseText($postObj, $contentStr);
		return $resultStr;
	}

	/**
	 * 发送文本消息模板
	 *
	 * @param $object 公众平台推送的消息包
	 * @param $content 文本消息内容
	 * @param $flag 消息内容
	 * @return 消息字符串
	 */
	public function responseText($object, $content) {
		$textTpl = "<xml>
	                <ToUserName><![CDATA[%s]]></ToUserName>
	                <FromUserName><![CDATA[%s]]></FromUserName>
	                <CreateTime>%s</CreateTime>
	                <MsgType><![CDATA[text]]></MsgType>
	                <Content><![CDATA[%s]]></Content>
	                </xml>";
		$resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
		return $resultStr;
	}
	
	/**
	 * 获取用户基本信息
	 * @param openid
	 * @return user_info
	 */
	private function getUserInfo($openid) {
		$access_token = $this->weixin->getAccessToken();

	    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" .$access_token. "&openid=" .$openid. "&lang=zh_CN";
		$res = file_get_contents($url); //获取文件内容或获取网络请求的内容
		$user_info = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量

		return $user_info;
	}

	/**
	 * 返回验证字符串
	 *
	 * @return 公众平台随机字符串
	 */
	public function valid() {
		$echoStr = $_GET["echostr"];
	
		//valid signature , option
		if($this->checkSignature()) {
			echo $echoStr;
			exit;
		}
	}

	/**
	 * 服务器有效性验证
	 *
	 * @return true:成功   false:失败
	 */
	private function checkSignature() {
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];
	
		$token = $this->weixin->getToken();
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode($tmpArr);
		$tmpStr = sha1($tmpStr);
	
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}