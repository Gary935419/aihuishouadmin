<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * **********************************************************************
 * サブシステム名  ： TASK
 * 機能名         ：登录
 * 作成者        ： Gary
 * **********************************************************************
 */
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// 加载数据库类
		$this->load->model('Mini_model', 'mini');
	}

	/**
	 * 商家、司机登录
	 */
	public function register_merchants()
	{
		if (!isset($_POST['account']) || empty($_POST['account'])) {
			$this->back_json(201, '请输入账号！');
		}
		if (!isset($_POST['password']) || empty($_POST['password'])) {
			$this->back_json(201, '请输入密码！');
		}
		if ($_POST['user_type'] == 1){
			//司机
			$Member = $this->mini->getqioshou($_POST['account'], md5($_POST['password']));
			if (empty($Member)) {
				$this->back_json(201, '抱歉!账号或密码错误!');
			}
			if ($Member['qs_state'] == 1){
				$this->back_json(201, '抱歉!当前账号已经被停用!');
			}
			$qs_id = $Member['qs_id'];
            //验证loginCode是否传递
			if (!isset($_POST['loginCode']) || empty($_POST['loginCode'])) {
				$this->back_json(201, '未传递loginCode');
			}
			//验证nickname是否传递
			if (!isset($_POST['nickname']) || empty($_POST['nickname'])) {
				$this->back_json(201, '未传递nickname');
			}
			//验证avatarurl是否传递
			if (!isset($_POST['avatarurl']) || empty($_POST['avatarurl'])) {
				$this->back_json(201, '未传递avatarurl');
			}
			if (empty($_POST['avatarurl']) || $_POST['nickname'] == "微信用户") {
				$this->back_json(201, '数据错误请重新授权！');
			}
			// 取得信息
			$loginCode = $_POST['loginCode'];
			//获得昵称
			$nickname = $_POST['nickname'];
			//获得图像
			$avater = $_POST['avatarurl'];
			// 取得登录凭证
			$resultnew = $this->get_code2Session($this->appid, $this->secret, $loginCode);

			//openid设置2
			$openid = $resultnew['openid'];
			if (empty($resultnew['openid'])) {
				$this->back_json(205, '数据错误', array());
			}
			/**登录操作*/
			$token = $this->_get_token($qs_id);
			$this->mini->qishou_edit($qs_id,$token,$avater,$nickname,$openid);
			$member_info = $this->mini->getqishouInfoqsid($qs_id);
			$member_info['session_key'] = $resultnew['session_key'];
		}else{
			//商家
			$Member = $this->mini->getmerchants($_POST['account'], md5($_POST['password']));
			if (empty($Member)) {
				$this->back_json(201, '抱歉!账号或密码错误!');
			}
			if ($Member['merchants_state'] == 1){
				$this->back_json(201, '抱歉!当前账号已经被停用!');
			}
			$meid = $Member['meid'];
			//验证loginCode是否传递
			if (!isset($_POST['loginCode']) || empty($_POST['loginCode'])) {
				$this->back_json(201, '未传递loginCode');
			}
			//验证nickname是否传递
			if (!isset($_POST['nickname']) || empty($_POST['nickname'])) {
				$this->back_json(201, '未传递nickname');
			}
			//验证avatarurl是否传递
			if (!isset($_POST['avatarurl']) || empty($_POST['avatarurl'])) {
				$this->back_json(201, '未传递avatarurl');
			}
			if (empty($_POST['avatarurl']) || $_POST['nickname'] == "微信用户") {
				$this->back_json(201, '数据错误请重新授权！');
			}
			// 取得信息
			$loginCode = $_POST['loginCode'];
			//获得昵称
			$nickname = $_POST['nickname'];
			//获得图像
			$avater = $_POST['avatarurl'];
			// 取得登录凭证
			$resultnew = $this->get_code2Session($this->appid, $this->secret, $loginCode);

			//openid设置2
			$openid = $resultnew['openid'];
			if (empty($resultnew['openid'])) {
				$this->back_json(205, '数据错误', array());
			}
			/**登录操作*/
			$token = $this->_get_token($meid);
			$this->mini->merchants_edit($meid,$token,$avater,$nickname,$openid);
			$member_info = $this->mini->getmerchantsInfomeidnew($meid);
			$member_info['session_key'] = $resultnew['session_key'];
		}

		$this->back_json(200, '操作成功', $member_info);
	}

	/**
	 * 用户登录
	 */
	public function register_member()
	{
		//验证loginCode是否传递
		if (!isset($_POST['loginCode']) || empty($_POST['loginCode'])) {
			$this->back_json(201, '未传递loginCode');
		}
		//验证nickname是否传递
		if (!isset($_POST['nickname']) || empty($_POST['nickname'])) {
			$this->back_json(201, '未传递nickname');
		}
		//验证avatarurl是否传递
		if (!isset($_POST['avatarurl']) || empty($_POST['avatarurl'])) {
			$this->back_json(201, '未传递avatarurl');
		}
		if (empty($_POST['avatarurl']) || $_POST['nickname'] == "微信用户"){
			$this->back_json(201, '数据错误请重新授权！');
		}
		// 取得信息
		$loginCode = $_POST['loginCode'];
		//获得昵称
		$nickname = $_POST['nickname'];
		//获得图像
		$avatarurl = $_POST['avatarurl'];

		// 取得登录凭证
		$resultnew = $this->get_code2Session($this->appid, $this->secret, $loginCode);

		//openid设置2
		$openid = $resultnew['openid'];
		if (empty($resultnew['openid'])){
			$this->back_json(205, '数据错误',array());
		}
		//用户是否注册判断
		$member_info_one = $this->mini->getMemberInfo($openid);
		//验证会员
		if (empty($member_info_one)) {
			$avater = $avatarurl;
			$token = $this->_get_token(666);
			$add_time = time();
			$wallet = 0;
			$status = 1;
			$birthday = date('Y-m-d',$add_time);
			// 注册操作
			$this->mini->register($birthday,$wallet,$status,$token,$openid,$nickname,$avater,$add_time);
			$member_newinfo = $this->mini->getMemberInfo($openid);
			$member_newinfo['session_key'] = $resultnew['session_key'];
			$this->back_json(200, '操作成功',$member_newinfo);
		} else {
			/**登录操作*/
			$token = $this->_get_token($member_info_one['mid']);
			$this->mini->member_edit($member_info_one['mid'], $token);
			$member_info_one = $this->mini->getMemberInfo($openid);
			$this->back_json(200, '操作成功',$member_info_one);
		}
	}

	function GetRandStr($length)
	{
		//字符组合
		$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$len = strlen($str) - 1;
		$randstr = '';
		for ($i = 0; $i < $length; $i++) {
			$num = mt_rand(0, $len);
			$randstr .= $str[$num];
		}
		return $randstr;
	}

	/**
	 * 登录生成token
	 */
	private function _get_token($member_id)
	{
		//生成新的token
		$token = md5($member_id . strval(time()) . strval(rand(0, 999999)));
		return $token;
	}

	/**
	 * 获得临时登录凭
	 * @param type $appid 小程序 appId
	 * @param type $secret 小程序 appSecret
	 * @param type $loginCode 登录时获取的 code
	 *
	 * @return Array 用户信息
	 */
	function get_code2Session($appid, $secret, $loginCode)
	{
		$url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret=' . $secret . '&grant_type=authorization_code&js_code=' . $loginCode;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//禁止调用时就输出获取到的数据
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$result = curl_exec($ch);
		curl_close($ch);
		$resultnew = json_decode($result, true);
		return $resultnew;
	}
}
