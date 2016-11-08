<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*** *** 通用控制器基类

创建 2016-01-13 刘深远

*** ***/

class MY_Controller extends CI_Controller {

	public $_page_title; //页面名称
	private $_member_login;
	public $_member_userId;
	public $_member_unionId;
	public $_member_openId;
	public $_member_nickName;
	public $_member_account;
	public $_member_headimgurl;
	public $_member_favorites;
	public $_member_addresses;

	public $_user_districtcode;
	public $_user_districtname;
	public $_user_citycode;
	public $_user_cityname;
	public $_user_provincecode;
	public $_user_provincename;

	public $_user_districtcode_loc;
	public $_user_districtname_loc;
	public $_user_citycode_loc;
	public $_user_cityname_loc;
	public $_user_provincecode_loc;
	public $_user_provincename_loc;

	private $_wx_appid;
	private $_wx_secret;
	private $_wx_token;
	public $_wx_code;
	public $_wx_openId;
	public $_wx_access_token;
	public $_wx_expires_in;
	public $_wx_need_jsapi;

	public $_page_login_new; //从微信菜单，APP重新进入页面
	
	public function __construct(){
		header("Content-Type: text/html; charset=UTF-8");
		parent::__construct();
		
		$this->load->model('weixin_model');
		$this->load->model('user_model');
		
		$this->init();
		$this->checkWebBaseUrl();

		if($_GET['loginout'] && $_GET['loginout']==1){
			$this->session->sess_destroy();
		}

		if($_GET['logintest'] && $_GET['logintest']==1){
			$this->session->set_userdata('UserId','57c99a85a0904d129492e305');
			$this->session->set_userdata('OpenId','opY33snJ-zA9Sat9kVIixa1ieDUs');
			$this->session->set_userdata('NickName','dwerdwer');

			//$this->session->set_userdata('UserId','d9a4b2a53731e6a134c0da4ccbaaa301');
			//$this->session->set_userdata('OpenId','dwerdwer');
		}

		if($_GET['newlogin'] && $_GET['newlogin']==1){
			$this->_page_login_new = 1;
		}

		$this->checkLogin();
	}

	function init(){
		$this->_wx_appid = $this->config->item('wx_appid');
		$this->_wx_secret = $this->config->item('wx_secret');
		$this->_wx_token = $this->config->item('wx_token');
		$this->_wx_need_jsapi = 0;
		
		/* 当前城市坐标 */
		$this->_user_citycode = $this->session->userdata('CityCode');	
		$this->_user_cityname = $this->session->userdata('CityName');
		$this->_user_provincecode = $this->session->userdata('ProvinceCode');
		$this->_user_provincename = $this->session->userdata('ProvinceName');
		
		/* 定位城市坐标 */
		$this->_user_citycode_loc = $this->session->userdata('CityCode_loc');
		$this->_user_cityname_loc = $this->session->userdata('CityName_loc');
		$this->_user_provincecode_loc = $this->session->userdata('ProvinceCode_loc');
		$this->_user_provincename_loc = $this->session->userdata('ProvinceName_loc');
	}

	function checkWebBaseUrl(){
		if($this->config->item('base_url')=='http://'.$_SERVER['HTTP_HOST'].'/'){
			return;
		}else{
			redirect($_SERVER['REQUEST_URI']);
			exit();
		}
	}

	function checkLogin(){
		if($this->uri->segment(1)=='wxpay' && $this->uri->segment(2)=='orderNotify'){return;}
		if($this->uri->segment(1)=='weixin'){return;}
		if($this->uri->segment(1)=='dingshi'){return;}
		if($this->uri->segment(1)=='ajax' && $this->uri->segment(2)=='CreatShopShenqing'){return;}
		if($this->uri->segment(1)=='ajax' && $this->uri->segment(2)=='PostDateToApi'){return;}

		$this->_member_openId = $this->weixin_model->getOpenId();

		if($this->session->userdata('UserId')){
			$this->_member_login = TRUE;
			$this->_member_userId = $this->session->userdata('UserId');
			$this->_member_unionId = $this->session->userdata('UnionId');
			$this->_member_nickName = $this->session->userdata('NickName');
			$this->_member_headimgurl = $this->session->userdata('Thumbnail');

			if(!$this->_member_headimgurl){$this->_member_headimgurl = $this->config->item('static_file_path')."images/user.png";}
			if(!$this->_member_nickName){$this->_member_nickName = '游客';}
			if(!$this->_member_addresses){$this->_member_addresses=array();}

			if($_GET['newlogin']==1 && (!$this->session->userdata('NickName') || !$this->session->userdata('UnionId'))){
				$user = $this->weixin_model->getUserInfo();
				if($user['openid']){
					$this->user_model->resetUser($user);
				}
			}
		}else{
			$user = $this->weixin_model->getUserInfo();
			if($user['openid']){
				$this->user_model->loginUser($user);
			}
			$this->checkLogin();
		}
	}
	
	function view($page,$data){
		if($this->config->item('pg_version_open')){
			$data['version'] = $this->config->item('pg_version');
		}
		$data['resUrl'] = $this->config->item('res_url');
		$data['shareUrl'] = $this->config->item('share_url');
		$data['staticPath'] = $this->config->item('static_file_path');
		$data['title'] = $this->_page_title;

		$data['pageName'] = $page;
		$data['headimgurl'] = $this->_member_headimgurl;
		$data['userId'] = $this->_member_userId;
		$data['nickname'] = $this->_member_nickName;

		$data['cityName'] = $this->_user_cityname;
		$data['cityCode'] = $this->_user_citycode;
		$data['provinceName'] = $this->_user_provincename;
		$data['provinceCode'] = $this->_user_provincecode;

		$data['cityName_loc'] = $this->_user_cityname_loc;
		$data['cityCode_loc'] = $this->_user_citycode_loc;
		$data['provinceName_loc'] = $this->_user_provincename_loc;
		$data['provinceCode_loc'] = $this->_user_provincecode_loc;

		$data['newlogin'] = $this->_page_login_new;

		if($this->_wx_need_jsapi==1){
			$data['ShareConfig']['appid'] = $this->_wx_appid;
			$data['ShareConfig']['timestamp'] = time();
			$data['ShareConfig']['nonceStr'] = $this->getRandStr(24);
			$data['ShareConfig']['ticket'] = $this->weixin_model->getJsapiTicket();
			$data['ShareConfig']['pageUrl'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
			$data['ShareConfig']['signature'] = $this->weixin_model->getSignature($data['ShareConfig']);
		}

		$this->load->view('templates/header',$data);
		$this->load->view($page,$data);
		$this->load->view('templates/footer',$data);
	}

	function getcurl($url,$data=array(),$log=0){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT,5);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		// 这一句是最主要的
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec($ch);
		//$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($log){
		$fileName = $this->config->item('log_path').date('Y-m-d').'.txt';
		$word = 'Key:'.$time."\r\n";
		$word .= 'URL:'.$url."\r\n";
		$word .= 'Respond:'.$response."\r\n";
		$fp = fopen($fileName,"a");
		flock($fp, LOCK_EX);
		fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\r\n".$word."\r\n");
		flock($fp, LOCK_UN);
		fclose($fp);
		}

		curl_close($ch);
		return json_decode($response,TRUE);
	}

	/*** 获取二维码图片url ***/
	function getSceneQRCodeImg($sceneId = ''){
		$this->getAccessToken();
		$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->_wx_access_token;
		$data = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$sceneId.'"}}}';
		$res = $this->getcurl($url,$data);
		if($res['errcode']>0){$this->getAccessToken('new');}
		$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->_wx_access_token;
		$data = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$sceneId.'"}}}';
		$res = $this->getcurl($url,$data);
		return $res;
	}

	function sendMoban($type,$user,$info){
		$this->load->model('moban_model');
		$this->getAccessToken();
		$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->_wx_access_token;
		if($type=='couponGetSuccess'){$msg = $this->moban_model->SendCouponGetSuccess($user,$info);}
		if($type=='orderPayed'){$msg = $this->moban_model->SendOrderPayed($user,$info);}
		if($type=='orderNotPay'){$msg = $this->moban_model->SendOrderNotPay($user,$info);}
		if($type=='teamBegin'){$msg = $this->moban_model->SendTeamBegin($user,$info);}
		if($type=='returnMoney'){$msg = $this->moban_model->SendReturnMoney($user,$info);}
		if($type=='teamFinish'){$msg = $this->moban_model->SendTeamFinish($user,$info);}
		if($type=='productSend'){$msg = $this->moban_model->SendProductSend($user,$info);}
		$res = $this->getcurl($url,$msg,1);
		if($res['errcode']==0){
			
		}else{
			
		}
	}

	function getRandStr($length = 8) {  
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';  
		$password = '';  
		for($i = 0;$i<$length;$i++){  
			$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];  
		}  
		return $password;
	}
	
	//type，s = success ,f = fail
	public function returnJson($data,$type='s'){
		if($type=='s'){
			if(!$data['Code'])$data['Code'] = 0;
			if(!$data['Success'])$data['Success'] = true;
			if(!$data['Message'])$data['Message'] = 'Success';
		}else{
			if(!$data['Code'])$data['Code'] = 500;
			if(!$data['Success'])$data['Success'] = true;
			if(!$data['Message'])$data['Message'] = '未定义的错误';
		}
		echo json_encode($data);
	}

}