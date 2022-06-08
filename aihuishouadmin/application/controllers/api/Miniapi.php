<?php
/**
 * **********************************************************************
 * サブシステム名  ： MINI
 * 機能名         ：API
 * 作成者        ： Gary
 * **********************************************************************
 */
require_once 'vendor/autoload.php';
use GuzzleHttp\Exception\RequestException;
use WechatPay\GuzzleMiddleware\WechatPayMiddleware;
use WechatPay\GuzzleMiddleware\Util\PemUtil;
class Miniapi extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// 加载数据库类
		$this->load->model('Mini_model', 'mini');
	}
    /**
     * 资讯列表页
     */
    public function news_list()
    {
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		$page = isset($_POST["page"]) ? $_POST["page"] : 1;
		$list = $this->mini->getnewsAll($page);
		foreach ($list as $k=>$v){
			$list[$k]['addtime'] = date("Y-m-d",$v['addtime']);
		}
		$data["list"] = $list;
		$this->back_json(200, '操作成功', $data);
    }

	/**
	 * 公告列表页
	 */
	public function notice_list()
	{
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		$page = isset($_POST["page"]) ? $_POST["page"] : 1;
		$list = $this->mini->getnoticeAll($page);
		foreach ($list as $k=>$v){
			$list[$k]['addtime'] = date("Y-m-d",$v['n_addtime']);
		}
		$data["list"] = $list;
		$this->back_json(200, '操作成功', $data);
	}

	/**
	 * 一级分类列表
	 */
	public function class_one_list()
	{
		$page = isset($_POST["page"]) ? $_POST["page"] : 1;
		$list = $this->mini->getclassoneAll($page);
		foreach ($list as $k=>$v){
			$list[$k]['addtime'] = date("Y-m-d",$v['co_addtime']);
		}
		$data["list"] = $list;
		$this->back_json(200, '操作成功', $data);
	}

	public function class_one_list_type()
	{
		$page = isset($_POST["page"]) ? $_POST["page"] : 1;
		$list = $this->mini->getclassonetypeAll($page);
		foreach ($list as $k=>$v){
			$list[$k]['addtime'] = date("Y-m-d",$v['co_addtime']);
		}
		$data["list"] = $list;
		$this->back_json(200, '操作成功', $data);
	}

	public function class_two_list_type()
	{
		$co_id = isset($_POST["co_id"]) ? $_POST["co_id"] : 1;
		$clidarr = isset($_POST["clidarr"]) ? $_POST["clidarr"] : array();
		$clidarr = explode(",", $clidarr);
		$orderlist = $this->mini->getclasstwotypeAll($co_id);
		foreach ($orderlist as $k=>$v){
			if ($v['ct_state']==0){
				$orderlist[$k]['ct_state'] = "";
			}elseif ($v['ct_state']==1){
				$orderlist[$k]['ct_state'] = "热门";
			}elseif ($v['ct_state']==2){
				$orderlist[$k]['ct_state'] = "已开放";
			}elseif ($v['ct_state']==3){
				$orderlist[$k]['ct_state'] = "暂未开放";
			}
			$boolvalue = in_array($v['ct_id'],$clidarr);
			if ($boolvalue){
				$orderlist[$k]['check_state'] = 1;
			}else{
				$orderlist[$k]['check_state'] = 0;
			}
		}
		$data["list"] = $orderlist;
		$this->back_json(200, '操作成功', $data);
	}

	/**
	 * 二级分类列表
	 */
	public function class_two_list()
	{
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		if (!isset($_POST['co_id']) || empty($_POST['co_id'])) {
			$this->back_json(201, '缺少一级分类id！');
		}
		$co_id = $_POST['co_id'];
		$page = isset($_POST["page"]) ? $_POST["page"] : 1;
		$list = $this->mini->getclasstwoAll($page,$co_id);
		foreach ($list as $k=>$v){
			$list[$k]['addtime'] = date("Y-m-d",$v['ct_addtime']);
		}
		$data["list"] = $list;
		$this->back_json(200, '操作成功', $data);
	}

	/**
	 * 订单列表（用户）
	 */
	public function orders_member_list()
	{
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		$mid = $member['mid'];

		$page = isset($_POST["page"]) ? $_POST["page"] : 1;
		$list = $this->mini->getordersmemberAll($page,$mid);
		foreach ($list as $k=>$v){
			$list[$k]['addtime'] = date("Y-m-d",$v['addtime']);
			$goodslist = $this->mini->getordersmembergoodsAll($v['oid']);
			$list[$k]['goodslist'] = $goodslist;
		}
		$data["list"] = $list;
		$this->back_json(200, '操作成功', $data);
	}

	/**
	 * 订单列表（商家）
	 */
	public function orders_merchants_list()
	{
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMerchantsInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		$meid = $member['meid'];

		$page = isset($_POST["page"]) ? $_POST["page"] : 1;
		$list = $this->mini->getordersmerchantsAll($page,$meid);
		foreach ($list as $k=>$v){
			$list[$k]['addtime'] = date("Y-m-d",$v['addtime']);
			$goodslist = $this->mini->getordersmembergoodsAll($v['oid']);
			$list[$k]['goodslist'] = $goodslist;
		}
		$data["list"] = $list;
		$this->back_json(200, '操作成功', $data);
	}

	/**
	 * 用户地址列表
	 */
	public function member_address_list()
	{
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		$page = isset($_POST["page"]) ? $_POST["page"] : 1;
		$list = $this->mini->getmemberaddressAll($page,$member['mid']);
		foreach ($list as $k=>$v){
			$list[$k]['addtime'] = date("Y-m-d",$v['addtime']);
		}
		$data["list"] = $list;
		$this->back_json(200, '操作成功', $data);
	}

	/**
	 * 用户地址添加
	 */
	public function member_address_add()
	{
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		$mid = $member['mid'];

		if (!isset($_POST['name']) || empty($_POST['name'])) {
			$this->back_json(205, '请您填写联系人姓名！');
		}
		if (!isset($_POST['mobile']) || empty($_POST['mobile'])) {
			$this->back_json(205, '请您填写联系人电话！');
		}
		$longitude = isset($_POST["longitude"]) ? $_POST["longitude"] : '';
		$latitude = isset($_POST["latitude"]) ? $_POST["latitude"] : '';
		$province = isset($_POST["province"]) ? $_POST["province"] : '';
		$city = isset($_POST["city"]) ? $_POST["city"] : '';
		$area = isset($_POST["area"]) ? $_POST["area"] : '';
		$address = isset($_POST["address"]) ? $_POST["address"] : '';
		$name = isset($_POST["name"]) ? $_POST["name"] : '';
		$mobile = isset($_POST["mobile"]) ? $_POST["mobile"] : '';

		$list = $this->mini->getmemberaddressAll(1,$mid);
		if ($_POST["status"] === 'true'){
			$status = 1;
			$this->mini->member_address_status_save($mid);
		}else{
			$status = 0;
		}
		$addtime = time();
		if (empty($list)){
			$status = 1;
		}
		$this->mini->member_address_add_save($mid,$longitude,$latitude,$province,$city,$area,$address,$name,$mobile,$status,$addtime);

		if (!empty($_POST["a_id"])){
			$this->mini->member_address_del($mid,$_POST["a_id"]);
		}

		$this->back_json(200, '操作成功');
	}

	/**
	 * 用户地址删除
	 */
	public function member_address_del()
	{
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		$mid = $member['mid'];

		if (!isset($_POST['a_id']) || empty($_POST['a_id'])) {
			$this->back_json(201, '缺少地址id！');
		}
		$a_id = isset($_POST["a_id"]) ? $_POST["a_id"] : '';

		$this->mini->member_address_del($mid,$a_id);

		$this->back_json(200, '操作成功');
	}

	/**
	 * 用户地址修改
	 */
	public function member_address_mod()
	{
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		$mid = $member['mid'];
		$longitude = isset($_POST["longitude"]) ? $_POST["longitude"] : '';
		$latitude = isset($_POST["latitude"]) ? $_POST["latitude"] : '';
		$province = isset($_POST["province"]) ? $_POST["province"] : '';
		$city = isset($_POST["city"]) ? $_POST["city"] : '';
		$area = isset($_POST["area"]) ? $_POST["area"] : '';
		$address = isset($_POST["address"]) ? $_POST["address"] : '';
		$name = isset($_POST["name"]) ? $_POST["name"] : '';
		$mobile = isset($_POST["mobile"]) ? $_POST["mobile"] : '';
		$status = isset($_POST["status"]) ? $_POST["status"] : 0;
		$addtime = time();

		if (!isset($_POST['a_id']) || empty($_POST['a_id'])) {
			$this->back_json(201, '缺少地址id！');
		}
		$a_id = isset($_POST["a_id"]) ? $_POST["a_id"] : '';

		$this->mini->member_address_del($mid,$a_id);

		$this->mini->member_address_add_save($mid,$longitude,$latitude,$province,$city,$area,$address,$name,$mobile,$status,$addtime);

		$this->back_json(200, '操作成功');
	}

	/**
	 * 用户地址详情
	 */
	public function member_address_detail()
	{
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		$mid = $member['mid'];

		if (!isset($_POST['a_id']) || empty($_POST['a_id'])) {
			$this->back_json(201, '缺少地址id！');
		}
		$a_id = isset($_POST["a_id"]) ? $_POST["a_id"] : '';

		$data = array();
		$data['member_address_detail'] = $this->mini->member_address_detail($mid,$a_id);

		$this->back_json(200, '操作成功', $data);
	}

	/**
	 * 个人中心
	 */
	public function memberinfo(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}
		if (empty($member['email'])){
			$member['email'] = "";
		}
		if (empty($member['mobile'])){
			$member['mobile'] = "";
		}
		$sendyourself_arr = array();
		$sendyourself_arr[0]['name']="自己送货";
		$sendyourself_arr[0]['value']="0";
		$sendyourself_arr[0]['checked']="true";

		if ($member['getpro'] == 1){
			$sendyourself_arr = array();
			$sendyourself_arr[0]['name']="自己送货";
			$sendyourself_arr[0]['value']="0";
			$sendyourself_arr[0]['checked']="true";
			$sendyourself_arr[1]['name']="上门取货";
			$sendyourself_arr[1]['value']="1";
		}
		$data['sendyourself_arr'] = $sendyourself_arr;
		$data['member'] = $member;
		$this->back_json(200, '操作成功', $data);
	}

	public function merchantsinfo(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$token = isset($_POST["token"]) ? $_POST["token"] : '';
		$merchantsinfo = $this->mini->getmerchantsInfomeid($token);
		if (empty($merchantsinfo)) {
			$this->back_json(206, '请您先去授权商家登录！');
		}
		$lid = $merchantsinfo['lid'];
		$levelInfo = $this->mini->getlevelInfo($lid);
		$merchantsinfo['level_name'] = empty($levelInfo['lname'])?'':$levelInfo['lname'];
		$merchantsinfo['level_bili'] = empty($levelInfo['lcontents'])?0:$levelInfo['lcontents'];
		$merchantsinfo['level_limg'] = empty($levelInfo['limg'])?0:$levelInfo['limg'];
		$data['merchants'] = $merchantsinfo;
		$this->back_json(200, '操作成功', $data);
	}
	public function qishouinfo(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权司机登录！');
		}
		$token = isset($_POST["token"]) ? $_POST["token"] : '';
		$merchantsinfo = $this->mini->getqishouInfomeid($token);
		if (empty($merchantsinfo)) {
			$this->back_json(206, '请您先去授权司机登录！');
		}
		$data['qishou'] = $merchantsinfo;
		$this->back_json(200, '操作成功', $data);
	}
	public function merchantsinfonew(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		$meid = isset($_POST["meid"]) ? $_POST["meid"] : '';
		$merchantsinfo = $this->mini->getmerchantsInfomeidnew($meid);
		if (empty($merchantsinfo)) {
			$this->back_json(206, '数据错误！');
		}
		$getsettingone = $this->mini->getsettingone();
		$sendyourself_arr = array();
		$sendyourself_arr[0]['name']="自己送货";
		$sendyourself_arr[0]['value']="0";
		$sendyourself_arr[0]['checked']="true";

		if ($member['getpro'] == 1){
			$sendyourself_arr = array();
			$sendyourself_arr[0]['name']="自己送货";
			$sendyourself_arr[0]['value']="0";
			$sendyourself_arr[0]['checked']="true";
			$sendyourself_arr[1]['name']="上门取货";
			$sendyourself_arr[1]['value']="1";
		}
		$data['sendyourself_arr'] = $sendyourself_arr;
		$data['merchants'] = $merchantsinfo;
		$this->back_json(200, '操作成功', $data);
	}

	public function addressinfo(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		if (!isset($_POST['a_id']) || empty($_POST['a_id'])) {
			$this->back_json(206, '缺少地址id！');
		}
		$a_id = isset($_POST["a_id"]) ? $_POST["a_id"] : '';
		$addressinfo = $this->mini->getaddressInfoaid($a_id);
		$data['addressinfo'] = $addressinfo;
		$this->back_json(200, '操作成功', $data);
	}

	public function member_address_muren(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}
		$addressinfo = $this->mini->getaddressInfoaidmoren($member['mid']);
		$data['a_id'] = empty($addressinfo)?'':$addressinfo['a_id'];
		$this->back_json(200, '操作成功', $data);
	}

	/**
	 * 个人中心  数据信息
	 */
	public function infoshujuxinxi(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		//已预约
		$data['shujusum']['sum1'] = $this->mini->getordersstate($member['mid'],0);
		//待回收
		$data['shujusum']['sum2'] = $this->mini->getordersstate($member['mid'],1);
		//已完成
		$data['shujusum']['sum3'] = $this->mini->getordersstate($member['mid'],2);
		//已取消
		$data['shujusum']['sum4'] = $this->mini->getordersstate($member['mid'],3);
		//基金
		$data['shujusum']['sum5'] = 5;
		//碳排放
		$data['shujusum']['sum6'] = 6;
		//参与回收
		$data['shujusum']['sum7'] = $this->mini->getordersstatecanyu($member['mid']);
		$ordersarr = $this->mini->getordersstateshangpin($member['mid']);
		if (empty($ordersarr)){
			//回收商品
			$data['shujusum']['sum8'] = 0;
		}else{
			$count = 0;
			foreach ($ordersarr as $k=>$v){
				$countsum = $this->mini->getordersstateshangpin1($v['oid']);
				$count = $count + $countsum;
			}
			//回收商品
			$data['shujusum']['sum8'] = $count;
		}
		//回收金额
		$data['shujusum']['sum9'] = empty($this->mini->getordersstatejine($member['mid']))?0:$this->mini->getordersstatejine($member['mid']);
		$this->back_json(200, '操作成功', $data);
	}

	public function infoshujuxinxi_merchants(){
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMerchantsInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权商家登录！');
		}

		$meid = $member['meid'];
		$lid = $member['lid'];
		$levelInfo = $this->mini->getlevelInfo($lid);
		//回收次数
		$data['shujusum']['sum1'] = empty($this->mini->getordersstatecishu($meid,2))?0:$this->mini->getordersstatecishu($meid,2);
		//回收金额
		$data['shujusum']['sum2'] = empty($member['huishou_price'])?0:$member['huishou_price'];
		//赚取金额
		$data['shujusum']['sum3'] = empty($member['huishou_price'])?0:$member['huishou_price'] * $levelInfo['lcontents'] / 100;
		//提现金额
		$data['shujusum']['sum4'] = empty($this->mini->getordersstatetixian_merchants($meid))?0:$this->mini->getordersstatetixian_merchants($meid);
		$this->back_json(200, '操作成功', $data);
	}

	public function withdrawal_user(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}
		if (!isset($_POST['money']) || empty($_POST['money'])) {
			$this->back_json(202, '请输入提现金额！');
		}
		$money = empty($_POST['money'])?'':$_POST['money'];
		$data['member'] = $member;
		$this->back_json(200, '直接提现到微信零钱程序正在开发中~~~', $data);
	}

	public function withdrawal_merchants(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$token = isset($_POST["token"]) ? $_POST["token"] : '';
		$merchantsinfo = $this->mini->getmerchantsInfomeid($token);
		if (empty($merchantsinfo)) {
			$this->back_json(206, '请您先去授权商家登录！');
		}
//		if (!isset($_POST['money']) || empty($_POST['money'])) {
//			$this->back_json(202, '请输入提现金额！');
//		}
//		$money = empty($_POST['money'])?'':$_POST['money'];

		if (!isset($_POST['bankcard']) || empty($_POST['bankcard'])) {
			$this->back_json(202, '请输入银行卡号！');
		}
		$bankcard = empty($_POST['bankcard'])?'':$_POST['bankcard'];

		if (!isset($_POST['username']) || empty($_POST['username'])) {
			$this->back_json(202, '请输入账户名！');
		}
		$username = empty($_POST['username'])?'':$_POST['username'];

		if (!isset($_POST['bankname']) || empty($_POST['bankname'])) {
			$this->back_json(202, '请输入银行名！');
		}
		$bankname = empty($_POST['bankname'])?'':$_POST['bankname'];

//		if ($money>$merchantsinfo['me_wallet']){
//			$this->back_json(202, '请输入金额已经超出账户余额！');
//		}

		$lid = $merchantsinfo['lid'];
		$levelInfo = $this->mini->getlevelInfo($lid);
		$level_bili = empty($levelInfo['lcontents'])?0:$levelInfo['lcontents'];
		$money = floatval($merchantsinfo['huishou_price']) * floatval($level_bili) / 100;
		$state = 0;
		$addtime = time();
		$meid = $merchantsinfo['meid'];
		$this->mini->order_withdrawal_save($meid,$addtime,$state,$bankname,$username,$bankcard,$money);
		$this->mini->merchants_edit_me_wallet($meid,0);

		$this->back_json(200, '操作成功');
	}

	public function memberinfo_modify(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}
		$sex = isset($_POST["sex"]) ? $_POST["sex"] : '';
		$mobile = isset($_POST["mobile"]) ? $_POST["mobile"] : '';
		$email = isset($_POST["email"]) ? $_POST["email"] : '';
		$truename = isset($_POST["truename"]) ? $_POST["truename"] : '';
		$birthday = isset($_POST["birthday"]) ? $_POST["birthday"] : '';

		$this->mini->memberinfo_edit($member['mid'],$sex,$truename,$email,$mobile,$birthday);
		$this->back_json(200, '更新成功');
	}

	public function orders_list(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}
		$ostate = isset($_POST["ostate"]) && !empty($_POST["ostate"]) ? $_POST["ostate"] : 999;
		$mid = $member['mid'];

		$page = $_POST['page'];
		$orderlist = $this->mini->getorderlist($mid,$page,$ostate);
		foreach ($orderlist as $k=>$v){
			$orderlist[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
			if ($v['ostate']==0){
				$orderlist[$k]['ostatestr'] = "已预约";
			}elseif ($v['ostate']==1){
				$orderlist[$k]['ostatestr'] = "待回收";
			}elseif ($v['ostate']==2){
				$orderlist[$k]['ostatestr'] = "已完成";
			}elseif ($v['ostate']==3){
				$orderlist[$k]['ostatestr'] = "已取消";
			}
		}
		$data['list'] = $orderlist;
		$this->back_json(200, '操作成功', $data);
	}

	public function withdrawal_list(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMerchantsInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权商家登录！');
		}

		$meid = $member['meid'];

		$page = $_POST['page'];
		$orderlist = $this->mini->merchantslist($meid,$page);

		foreach ($orderlist as $k=>$v){
			$orderlist[$k]['addtime'] = date('Y-m-d H:i',$v['addtime']);
			if ($v['state']==0){
				$orderlist[$k]['state'] = "申请中";
			}elseif ($v['state']==1){
				$orderlist[$k]['state'] = "已处理";
			}elseif ($v['state']==2){
				$orderlist[$k]['state'] = "已驳回";
			}
		}
		$data['list'] = $orderlist;
		$this->back_json(200, '操作成功', $data);
	}

	public function merchants_order_list(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMerchantsInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$meid = $member['meid'];
		$page = $_POST['page'];
		$datenew = empty($_POST['date'])?date('Y-m-d',time()):$_POST['date'];
		$orderlist = $this->mini->merchantsorderlist($meid,$page,$datenew);
		foreach ($orderlist as $k=>$v){
			$orderlist[$k]['addtime'] = date('Y-m-d H:i',$v['addtime']);
			$uname=$v['uname'];
			$utel=$v['utel'];
			$memberinfoaddress = $this->mini->getMerchantsInfotorder($uname,$utel);
			$orderlist[$k]['address'] = empty($memberinfoaddress['address'])?'':$memberinfoaddress['address'];

			if ($v['ostate']==0){
				$orderlist[$k]['ostate'] = "已预约";
			}elseif ($v['ostate']==1){
				$orderlist[$k]['ostate'] = "待回收";
			}elseif ($v['ostate']==2){
				$orderlist[$k]['ostate'] = "已完成";
			}elseif ($v['ostate']==3){
				$orderlist[$k]['ostate'] = "已取消";
			}
		}
		$data['list'] = $orderlist;
		$data['date'] = $datenew;
		$this->back_json(200, '操作成功', $data);
	}

	public function qishou_order_list(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权司机登录！');
		}
		$token = isset($_POST["token"]) ? $_POST["token"] : '';
		$member = $this->mini->getqishouInfomeid($token);
		if (empty($member)) {
			$this->back_json(206, '请您先去授权司机登录！');
		}
		$meid = empty($_POST['meid'])?'':$_POST['meid'];
		$page = $_POST['page'];
		$datetime = empty($_POST['date']) || $_POST['date'] == 'undefined'?date('Y-m-d',time()):$_POST['date'];
		$qs_meids = $member['qs_meids'];
		$meids = explode(',',$qs_meids);
		$orderlist = array();
		if ($meid != 'undefined'){
			$orderlistnew = $this->mini->qishouorderlist($meid,$datetime,$page);
			$orderlist = array_merge($orderlist,$orderlistnew);
		}else{
			foreach ($meids as $k=>$v){
				$meid = $v;
				$orderlistnew = $this->mini->qishouorderlist($meid,$datetime,$page);
				$orderlist = array_merge($orderlist,$orderlistnew);
			}
		}
		foreach ($orderlist as $k=>$v){
			$memberinfoaddress = $this->mini->getMerchantsInfotmeid($v['meid']);
			$orderlist[$k]['meaddress'] = empty($memberinfoaddress['meaddress'])?'':$memberinfoaddress['meaddress'];
			if ($v['omtype']==0){
				$orderlist[$k]['omtype'] = "待回收";
			}elseif ($v['omtype']==1){
				$orderlist[$k]['omtype'] = "已回收";
			}
		}
		$data['list'] = $orderlist;
		$data['date'] = $datetime;
		$this->back_json(200, '操作成功', $data);
	}

	public function qishou_order_list1(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权司机登录！');
		}
		$token = isset($_POST["token"]) ? $_POST["token"] : '';
		$member = $this->mini->getqishouInfomeid($token);
		if (empty($member)) {
			$this->back_json(206, '请您先去授权司机登录！');
		}
		$datetime = empty($_POST['date'])?date('Y-m-d',time()):$_POST['date'];
		$qs_meids = $member['qs_meids'];
		$my_str_arr = '('.$qs_meids.')';
		$orderlist = $this->mini->getmerchantslistqishou($my_str_arr);

		foreach ($orderlist as $k=>$v){
			$orderlist[$k]['manchang'] = empty($v['full_flg'])?"未满仓":"已满仓";
			$orderlist[$k]['dingdanliang'] = $this->mini->getordersstate123($v['meid'],$datetime);
			$orderlist[$k]['meaddress'] = empty($v['meaddress'])?'':$v['meaddress'];
			$orderlistnew = $this->mini->qishouorderlist1($v['meid'],$datetime);
			if (empty($orderlistnew)){
				$orderlist[$k]['q_weight'] = 1;
			}else{
				$orderlist[$k]['q_weight'] = 0;
			}
		}

//		$orderlist = array();
//		foreach ($meids as $k=>$v){
//			$meid = $v;
//			$orderlistnew = $this->mini->qishouorderlist1($meid,$datetime,$page);
//			$orderlist = array_merge($orderlist,$orderlistnew);
//		}
//		foreach ($orderlist as $k=>$v){
//			$memberinfoaddress = $this->mini->getMerchantsInfotmeid($v['meid']);
//			$orderlist[$k]['manchang'] = empty($memberinfoaddress['full_flg'])?"未满仓":"已满仓";
//			$orderlist[$k]['dingdanliang'] = $this->mini->getordersstate123($meid,$datetime);
//			$orderlist[$k]['meaddress'] = empty($memberinfoaddress['meaddress'])?'':$memberinfoaddress['meaddress'];
//			if ($v['omtype']==0){
//				$orderlist[$k]['omtype'] = "待回收";
//			}elseif ($v['omtype']==1){
//				$orderlist[$k]['omtype'] = "已回收";
//			}
//		}



		$data['list'] = $orderlist;
		$data['date'] = $datetime;
		$this->back_json(200, '操作成功', $data);
	}

	public function merchants_order_list_goods(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMerchantsInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$meid = $member['meid'];
		$page = $_POST['page'];
		$datenew = empty($_POST['date'])?date('Y-m-d',time()):$_POST['date'];
		$orderlist = $this->mini->merchantsorderlistgoods($meid,$page,$datenew);
		$price = 0;
		foreach ($orderlist as $k=>$v){
			$money = floatval($v['m_weight']) * floatval($v['price']);
			$price = floatval($price) + floatval($money);
		}
		$data['date'] = $datenew;
		$data['price'] = $price;
		$data['list'] = $orderlist;
		$this->back_json(200, '操作成功', $data);
	}

	public function orders_details(){
		//验证loginCode是否传递
//		if (!isset($_POST['token']) || empty($_POST['token'])) {
//			$this->back_json(205, '请您先去授权登录！');
//		}
//		$token = $_POST['token'];
//		$member = $this->mini->getMemberInfotoken($token);
//		if (empty($member)){
//			$this->back_json(205, '请您先去授权登录！');
//		}
		if (!isset($_POST['oid']) || empty($_POST['oid'])) {
			$this->back_json(202, '数据错误！');
		}
		$oid = empty($_POST['oid'])?'':$_POST['oid'];
		$orderdetails = $this->mini->getorderdetails($oid);
		$data['orderdetails'] = $orderdetails;
		$this->back_json(200, '操作成功', $data);
	}

	public function order_modify_ostate(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}
		if (!isset($_POST['oid']) || empty($_POST['oid'])) {
			$this->back_json(202, '数据错误！');
		}
		$oid = empty($_POST['oid'])?'':$_POST['oid'];

		$this->mini->orderostate_edit($member['mid'],$oid);
		$this->back_json(200, '取消成功');
	}

	public function banner_list()
	{
		$list = $this->mini->getbannerAll();
		$data["list"] = $list;
		$list1 = $this->mini->getbannerAll1();
		$data["list1"] = $list1;
		$listnotice = $this->mini->getnoticeAllnew();
		$noticemsg = "";
		if (empty($listnotice)){
			$noticemsg = "暂无公告信息~~~";
		}else{
			foreach ($listnotice as $k=>$v){
				$num = $k+1;
				$noticemsg = $noticemsg.$num.".".$v['n_msg'];
			}
		}
		$data["noticemsg"] = $noticemsg;
		$this->back_json(200, '操作成功', $data);
	}
	public function merchants_list(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}
		$testinfo = empty($_POST['testinfo'])?'':$_POST['testinfo'];
		$page = $_POST['page'];

		if (!isset($_POST['a_id']) || empty($_POST['a_id'])) {
			$this->back_json(202, '请先选择您的地址信息！');
		}
		$a_id = empty($_POST['a_id'])?'':$_POST['a_id'];
		$member_address_detail = $this->mini->member_address_detail($member['mid'],$a_id);
		//经度
		$longitude = $member_address_detail['longitude'];
		//纬度
		$latitude = $member_address_detail['latitude'];

		$orderlist = $this->mini->getmerchantslist($page,$testinfo);
		foreach ($orderlist as $k=>$v){
			$my_str_arr = '('.$v['laid'].')';
			$orderlist[$k]['lablearr'] = $this->mini->getmerchantslistlable($my_str_arr);
			$distance = $this->getDistance($latitude,$longitude,$v['latitude'],$v['longitude']);
			$orderlist[$k]['distancesum'] = $distance;
			$orderlist[$k]['isshow'] = 1;
			if ($distance > 3000){
				$orderlist[$k]['isshow'] = 0;
			}
			if ($distance<1000){
				$orderlist[$k]['distance'] = $distance."米";
			}
			if ($distance>=1000){
				$orderlist[$k]['distance'] = round($distance/1000)."千米";
			}
		}
		$sort = array_column($orderlist, 'distancesum');
		array_multisort($sort, SORT_ASC, $orderlist);
		$data['list'] = $orderlist;
		$data['openstatus'] = empty($orderlist[0]['isshow'])?0:1;
		$this->back_json(200, '操作成功', $data);
	}

	public function merchants_list_index(){
		$orderlist = $this->mini->getmerchantslistindex();
		$data['list'] = empty($orderlist)?array():$orderlist;
		$this->back_json(200, '操作成功', $data);
	}

	public function merchants_list_seach(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}
		$testinfo = empty($_POST['testinfo'])?'':$_POST['testinfo'];
		$page = $_POST['page'];

		if (!isset($_POST['a_id']) || empty($_POST['a_id'])) {
			$this->back_json(202, '数据错误！');
		}
		$a_id = empty($_POST['a_id'])?'':$_POST['a_id'];
		$member_address_detail = $this->mini->member_address_detail($member['mid'],$a_id);
		//经度
		$longitude = $member_address_detail['longitude'];
		//纬度
		$latitude = $member_address_detail['latitude'];

		$orderlist = $this->mini->getmerchantslistseach($page,$testinfo);
		foreach ($orderlist as $k=>$v){
			$my_str_arr = '('.$v['laid'].')';
			$orderlist[$k]['lablearr'] = $this->mini->getmerchantslistlable($my_str_arr);
			$distance = $this->getDistance($latitude,$longitude,$v['latitude'],$v['longitude']);
			$orderlist[$k]['distancesum'] = $distance;
			if ($distance<1000){
				$orderlist[$k]['distance'] = $distance."米";
			}
			if ($distance>=1000){
				$orderlist[$k]['distance'] = round($distance/1000)."千米";
			}
		}
		$sort = array_column($orderlist, 'distancesum');
		array_multisort($sort, SORT_ASC, $orderlist);
		$data['list'] = $orderlist;
		$this->back_json(200, '操作成功', $data);
	}

	public function classtwoinfo(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}
		$ct_ids = empty($_POST['ct_ids'])?'':$_POST['ct_ids'];
		$ct_ids = json_decode($ct_ids,true);
		$str = "";
		if (!empty($ct_ids)){
			foreach($ct_ids as $k=>$v){
				if (empty($str)){
					$str = $str.$v;
				}else{
					$str = $str.','.$v;
				}
			}
		}
		$my_str_arr = '('.$str.')';
		$data['list'] = $this->mini->getmerchantslistclasstwo($my_str_arr);
		$this->back_json(200, '操作成功', $data);
	}

	public function order_insert(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}
		$order_status = 0;
		if (!isset($_POST['ct_ids']) || $_POST['ct_ids']=='[]') {
			$order_status = 1;
		}
		if (!isset($_POST['note']) || empty($_POST['note'])) {
			$this->back_json(202, '请填写订单备注！');
		}
		$note = empty($_POST['note'])?'':$_POST['note'];

		if (!isset($_POST['delivery_time']) || empty($_POST['delivery_time'])) {
			$this->back_json(202, '请选择时间！');
		}
		$delivery_time = empty($_POST['delivery_time'])?'':$_POST['delivery_time'];

		if (!isset($_POST['delivery_date']) || empty($_POST['delivery_date'])) {
			$this->back_json(202, '请选择日期！');
		}
		$delivery_date = empty($_POST['delivery_date'])?'':$_POST['delivery_date'];

		$datecheck = strtotime($delivery_date . " 15:00:00");
		$datechecknew = strtotime($delivery_date . $delivery_time);
		if ($datechecknew >= $datecheck){
			$this->back_json(202, '请重新选择预约下单时间，不可超过每天的下午四点。');
		}
		if ($datechecknew <= time()){
			$this->back_json(202, '请选择大于当前时间的日期信息。');
		}
		if (!isset($_POST['uname']) || empty($_POST['uname'])) {
			$this->back_json(202, '请选择联系人！');
		}
		$uname = empty($_POST['uname'])?'':$_POST['uname'];

		if (!isset($_POST['utel']) || empty($_POST['utel'])) {
			$this->back_json(202, '请选择电话！');
		}
		$utel = empty($_POST['utel'])?'':$_POST['utel'];
		$otype = empty($_POST['otype'])?0:$_POST['otype'];
		if($otype!=1){
			if (!isset($_POST['muser']) || empty($_POST['muser'])) {
				$this->back_json(202, '请填写商家名称！');
			}
			$muser = empty($_POST['muser'])?'':$_POST['muser'];

			if (!isset($_POST['maddress']) || empty($_POST['maddress'])) {
				$this->back_json(202, '请填写商家地址！');
			}
			$maddress = empty($_POST['maddress'])?'':$_POST['maddress'];

			if (!isset($_POST['meid']) || empty($_POST['meid'])) {
				$this->back_json(202, '请选择商家！');
			}
			$meid = empty($_POST['meid'])?'':$_POST['meid'];
		}else{
			$muser = "上门取货商家";
			$maddress = "上门取货商家地址";
			$meid = 999999;
		}

		$ostate = 0;
		$addtime = time();
		$mid = $member['mid'];
		$sum_price = 0;
		$oid = $this->mini->order_save($order_status,$ostate,$addtime,$sum_price,$note,$delivery_date,$delivery_time,$uname,$utel,$muser,$maddress,$mid,$meid,$otype);

		$ct_ids = empty($_POST['ct_ids'])?'':$_POST['ct_ids'];
		if ($ct_ids != '[]'){
			$ct_ids = json_decode($ct_ids,true);
			$str = "";
			if (!empty($ct_ids)){
				foreach($ct_ids as $k=>$v){
					if (empty($str)){
						$str = $str.$v;
					}else{
						$str = $str.','.$v;
					}
				}
			}
			$my_str_arr = '('.$str.')';
			$classlist = $this->mini->getmerchantslistclasstwo($my_str_arr);
			foreach ($classlist as $k=>$v){
				$ct_name = $v['ct_name'];
				$ct_id = $v['ct_id'];
				$ct_img = $v['ct_img'];
				$ct_price = $v['ct_price'];
				$ct_danwei = $v['ct_danwei'];
				$og_price = 0;
				$weight = 0;
				$this->mini->order_goods_save($oid,$ct_name,$ct_id,$ct_img,$ct_price,$og_price,$weight,$ct_danwei);
			}
		}
		$this->back_json(200, '操作成功');
	}

	public function opinion_insert(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		if (!isset($_POST['note']) || empty($_POST['note'])) {
			$this->back_json(202, '请填写反馈信息！');
		}
		$op_contents = empty($_POST['note'])?'':$_POST['note'];
		$addtime = time();
		$this->mini->opinion_goods_save($member['mid'],$op_contents,$addtime);
		$this->back_json(200, '操作成功');
	}

	public function order_insert_go(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		if (!isset($_POST['note']) || empty($_POST['note'])) {
			$this->back_json(202, '请填写订单备注！');
		}
		$note = empty($_POST['note'])?'':$_POST['note'];

		if (!isset($_POST['delivery_time']) || empty($_POST['delivery_time'])) {
			$this->back_json(202, '请选择时间！');
		}
		$delivery_time = empty($_POST['delivery_time'])?'':$_POST['delivery_time'];

		if (!isset($_POST['delivery_date']) || empty($_POST['delivery_date'])) {
			$this->back_json(202, '请选择日期！');
		}
		$delivery_date = empty($_POST['delivery_date'])?'':$_POST['delivery_date'];

		$datecheck = strtotime($delivery_date . " 13:00:00");
		$datechecknew = strtotime($delivery_date . $delivery_time);
		if ($datechecknew >= $datecheck){
			$this->back_json(202, '请重新选择预约下单时间！');
		}
		if (!isset($_POST['uname']) || empty($_POST['uname'])) {
			$this->back_json(202, '请选择联系人！');
		}
		$uname = empty($_POST['uname'])?'':$_POST['uname'];

		if (!isset($_POST['utel']) || empty($_POST['utel'])) {
			$this->back_json(202, '请选择电话！');
		}
		$utel = empty($_POST['utel'])?'':$_POST['utel'];
		$otype = empty($_POST['otype'])?0:$_POST['otype'];
		if($otype!=1){
			if (!isset($_POST['muser']) || empty($_POST['muser'])) {
				$this->back_json(202, '请填写商家名称！');
			}
			$muser = empty($_POST['muser'])?'':$_POST['muser'];

			if (!isset($_POST['maddress']) || empty($_POST['maddress'])) {
				$this->back_json(202, '请填写商家地址！');
			}
			$maddress = empty($_POST['maddress'])?'':$_POST['maddress'];

			if (!isset($_POST['meid']) || empty($_POST['meid'])) {
				$this->back_json(202, '请选择商家！');
			}
			$meid = empty($_POST['meid'])?'':$_POST['meid'];
		}else{
			$muser = "上门取货商家";
			$maddress = "上门取货商家地址";
			$meid = 999999;
		}

		$ostate = 0;
		$addtime = time();
		$mid = $member['mid'];
		$sum_price = 0;
		$order_status = 0;
		$this->mini->order_save($order_status,$ostate,$addtime,$sum_price,$note,$delivery_date,$delivery_time,$uname,$utel,$muser,$maddress,$mid,$meid,$otype);

		$this->back_json(200, '操作成功');
	}
	/**
	 * 计算两个经纬度距离
	 */
	public function getDistance($lat1, $lng1, $lat2, $lng2){
		$earthRadius = 6367000;
		$lat1 = ($lat1 * pi() ) / 180;
		$lng1 = ($lng1 * pi() ) / 180;
		$lat2 = ($lat2 * pi() ) / 180;
		$lng2 = ($lng2 * pi() ) / 180;
		$calcLongitude = $lng2 - $lng1;
		$calcLatitude = $lat2 - $lat1;
		$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
		$stepTwo = 2 * asin(min(1, sqrt($stepOne)));
		$calculatedDistance = $earthRadius * $stepTwo;
		return round($calculatedDistance);
	}
	public function merchants_modify(){
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMerchantsInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		$meid = $member['meid'];

		$is_business = isset($_POST["is_business"]) && !empty($_POST["is_business"]) ? $_POST["is_business"] : $member['is_business'];
		$meaddress = isset($_POST["meaddress"]) && !empty($_POST["meaddress"]) ? $_POST["meaddress"] : $member['meaddress'];
		$latitude = isset($_POST["latitude"]) && !empty($_POST["latitude"]) ? $_POST["latitude"] : $member['latitude'];
		$longitude = isset($_POST["longitude"]) && !empty($_POST["longitude"]) ? $_POST["longitude"] : $member['longitude'];
		$contactname = isset($_POST["contactname"]) && !empty($_POST["contactname"]) ? $_POST["contactname"] : $member['contactname'];
		$metel = isset($_POST["metel"]) && !empty($_POST["metel"]) ? $_POST["metel"] : $member['metel'];
		$mename = isset($_POST["mename"]) && !empty($_POST["mename"]) ? $_POST["mename"] : $member['mename'];
		$meimg = isset($_POST["meimg"]) && !empty($_POST["meimg"]) ? $_POST["meimg"] : $member['meimg'];

		$this->mini->merchants_editnew($meid,$is_business,$meaddress,$latitude,$longitude,$contactname,$metel,$mename,$meimg);
		$this->back_json(200, '更新成功');
	}

	public function orders_goods_list(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMerchantsInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$page = $_POST['page'];
		$oid = empty($_POST['oid'])?'':$_POST['oid'];
		$orderlist = $this->mini->merchantsordergoodslist($page,$oid);
		$data['list'] = $orderlist;
		$this->back_json(200, '操作成功', $data);
	}

	public function orders_goods_list_new_one(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权司机登录！');
		}
		$token = isset($_POST["token"]) ? $_POST["token"] : '';
		$merchantsinfo = $this->mini->getqishouInfomeid($token);
		if (empty($merchantsinfo)) {
			$this->back_json(206, '请您先去授权司机登录！');
		}
		if (!isset($_POST['omid']) || empty($_POST['omid'])) {
			$this->back_json(205, '数据错误omid！');
		}
		$omid = empty($_POST['omid'])?'':$_POST['omid'];
		$orderlist = $this->mini->merchantsordergoodslistnewonw(1,$omid);
		$data['list'] = $orderlist;
		$this->back_json(200, '操作成功', $data);
	}

	public function orders_goods_list_new_all(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权司机登录！');
		}
		$token = isset($_POST["token"]) ? $_POST["token"] : '';
		$merchantsinfo = $this->mini->getqishouInfomeid($token);
		if (empty($merchantsinfo)) {
			$this->back_json(206, '请您先去授权司机登录！');
		}
		if (!isset($_POST['meid']) || empty($_POST['meid'])) {
			$this->back_json(205, '数据错误meid！');
		}
		$meid = empty($_POST['meid'])?'':$_POST['meid'];

		$date = empty($_POST['date'])?date('Y-m-d',time()):$_POST['date'];
		$orderlist = $this->mini->merchantsordergoodslistnewall(1,$meid,$date);
		$data['list'] = $orderlist;
		$data['date'] = $date;
		$this->back_json(200, '操作成功', $data);
	}

	public function sum_orders_goods_update_qishou(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权司机登录！');
		}
		$token = isset($_POST["token"]) ? $_POST["token"] : '';
		$merchantsinfo = $this->mini->getqishouInfomeid($token);
		if (empty($merchantsinfo)) {
			$this->back_json(206, '请您先去授权司机登录！');
		}
		$datetime = empty($_POST['date'])?date('Y-m-d',time()):$_POST['date'];
		if (!isset($_POST['meid']) || empty($_POST['meid'])) {
			$this->back_json(205, '数据错误meid！');
		}
		$meid = empty($_POST['meid'])?'':$_POST['meid'];

		$desc = empty($_POST['desc'])?'':$_POST['desc'];
		$orderlist = $this->mini->merchantsordergoodslistnew1($meid,$datetime);

		if (empty($orderlist)){
			$this->back_json(205, '数据错误。');
		}
		$sum_price = 0;
		foreach ($orderlist as $k=>$v){
			$omid = $v['omid'];
			$omtype = 1;
			$qs_id = $merchantsinfo['qs_id'];
			$ordernumber = time();
			$this->mini->merchantsordergoodslistnew2($omid,$omtype,$qs_id,$ordernumber);
			$this->mini->qishounew_del($ordernumber);

			$qsid = $qs_id;
			$qstype = 1;
			$remarks = $desc;
			$addtime = time();
			$grade = 0;
			$mename = $v['mename'];
			$this->mini->getorders_merchants_save_new($qsid,$qstype,$remarks,$addtime,$grade,$meid,$mename,$ordernumber);

			$sum_price = floatval($sum_price) + floatval($v['m_weight']) * floatval($v['price']);
		}

		$orderlistold = $this->mini->merchantsordergoodslistnew1old($meid,$datetime);

		foreach ($orderlistold as $kk=>$vv){
			$oid = $vv['oid'];
			$orderone = $this->mini->getorderone($oid);
			$mid = $orderone['mid'];
			$sum_price1 = $orderone['sum_price'];
			$MemberInfomid = $this->mini->getMemberInfomid($mid);
			$membernewmoney = floatval($sum_price1) + floatval($MemberInfomid['wallet']);
			$this->mini->member_edit_wallet($mid,$membernewmoney);

			$isdir = $_SERVER['DOCUMENT_ROOT']."/cert/";//证书位置;绝对路径
			$keypem = $isdir . 'apiclient_key.pem';
			$certpem = $isdir . 'wechatpay_3CBA5A0DFCA8CB9765288493F21E57863296B3C3.pem';

			// 商户相关配置
			$merchantId = '1622453928'; // 商户号
			$merchantSerialNumber = '3A86E55A5138C1A9868C2C114802A590576546B7'; // 商户API证书序列号
			$PemUtil = new PemUtil();
			$merchantPrivateKey = $PemUtil->loadPrivateKey($keypem); // 商户私钥
			// 微信支付平台配置
			$wechatpayCertificate = $PemUtil->loadCertificate($certpem); // 微信支付平台证书

			// 构造一个WechatPayMiddleware
			$wechatpayMiddleware = WechatPayMiddleware::builder()
				->withMerchant($merchantId, $merchantSerialNumber, $merchantPrivateKey) // 传入商户相关配置
				->withWechatPay([ $wechatpayCertificate ]) // 可传入多个微信支付平台证书，参数类型为array
				->build();

			// 将WechatPayMiddleware添加到Guzzle的HandlerStack中
			$stack = GuzzleHttp\HandlerStack::create();
			$stack->push($wechatpayMiddleware, 'wechatpay');

			// 创建Guzzle HTTP Client时，将HandlerStack传入
			$client = new GuzzleHttp\Client(['handler' => $stack]);

			// 接下来，正常使用Guzzle发起API请求，WechatPayMiddleware会自动地处理签名和验签
			try {
				$resp = $client->request('POST', 'https://api.mch.weixin.qq.com/v3/transfer/batches', [
					'json' => [ // JSON请求体
						'appid' => 'wx8be053f4e70ec431',
						'out_batch_no' => 'aihuishou'.time(),
						'batch_name' => '用户提现',
						'batch_remark' => '用户提现',
						'total_amount' => $sum_price1 * 100,
						'total_num' => 1,
						'transfer_detail_list' => [
							'0' => [ // JSON请求体
								'out_detail_no' =>  'aihuishounew'.time(),
								'transfer_amount' => $sum_price1 * 100,
								'transfer_remark' => '用户提现',
								'openid' => $MemberInfomid['openid']
							]
						]
					],
					'headers' => [ 'Accept' => 'application/json' ]
				]);
				if ($resp->getStatusCode() != 200){
					$this->back_json(205, $resp->getStatusCode().' '.$resp->getReasonPhrase()."\n".$resp->getBody()."\n");
				}
			} catch (RequestException $e) {
				// 进行错误处理
				echo $e->getMessage()."\n";
				if ($e->hasResponse()) {
					echo $e->getResponse()->getStatusCode().' '.$e->getResponse()->getReasonPhrase()."\n";
					echo $e->getResponse()->getBody();
				}
				return;
			}
		}

		$this->mini->goods_edit_order_me_ostate($meid,$datetime);
		$MemberInfomid = $this->mini->getmerchantsInfomeidnew($meid);
		$membernewmoney = floatval($sum_price) + floatval($MemberInfomid['huishou_price']);
		$this->mini->member_edit_wallet_me($meid,$membernewmoney);

		$this->back_json(200, '操作成功');
	}

	public function orders_goods_update(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMerchantsInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权商家登录！');
		}
		if (!isset($_POST['weight']) || empty($_POST['weight'])) {
			$this->back_json(205, '请录入重量信息。');
		}
		if (!is_numeric($_POST['weight'])){
			$this->back_json(205, '请录入数字信息。');
		}
		$weight = $_POST['weight'];
		$ogid = $_POST['ogid'];
		$ordergoodsinfo = $this->mini->getordergoodsinfo($ogid);
		$ct_price = $ordergoodsinfo['ct_price'];
		$og_price = floatval($weight) * floatval($ct_price);
		$this->mini->ordergoodsupdate($ogid,$weight,$og_price);
		$this->back_json(200, '操作成功');
	}

	public function orders_goods_update_qishou(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权司机登录！');
		}
		$token = isset($_POST["token"]) ? $_POST["token"] : '';
		$merchantsinfo = $this->mini->getqishouInfomeid($token);
		if (empty($merchantsinfo)) {
			$this->back_json(206, '请您先去授权司机登录！');
		}
		if (!isset($_POST['weight']) || empty($_POST['weight'])) {
			$this->back_json(205, '请录入重量信息。');
		}
		if (!is_numeric($_POST['weight'])){
			$this->back_json(205, '请录入数字信息。');
		}
		$weight = $_POST['weight'];
		$omid = $_POST['omid'];
		$qs_id = $merchantsinfo['qs_id'];
		$ordernumber = time();
		$ordergoodsinfo = $this->mini->getordergoodsinfoqishou($omid);

		$this->mini->ordergoodsupdateqishou($omid,$weight,$qs_id,$ordernumber);
		$this->back_json(200, '操作成功');
	}

	public function sum_orders_goods_update(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMerchantsInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$oid = $_POST['oid'];
		$orderlist = $this->mini->merchantsordergoodslistnew($oid);
		if (empty($orderlist)){
			$this->back_json(205, '数据错误。');
		}
		$sum_price = 0;
		foreach ($orderlist as $k=>$v){
			$sum_price = $sum_price + $v['og_price'];
			$omtype = 0;
			$meid = $member['meid'];
			$mename = $member['mename'];
			$ct_id = $v['ct_id'];
			$ct_name = $v['ct_name'];
			$ct_danwei = $v['ct_danwei'];
			$m_weight = $v['weight'];
			$q_weight = 0;
			$price = $v['ct_price'];
			$addtime = time();
			$datetime = date('Y-m-d',time());

			$getorders_merchants = $this->mini->getorders_merchants($ct_id,$meid,$datetime);
			if (empty($getorders_merchants)){
				$this->mini->getorders_merchants_save($omtype,$meid,$mename,$ct_id,$ct_name,$m_weight,$q_weight,$price,$addtime,$datetime,$ct_danwei);
			}else{
				$gm_weight = $getorders_merchants['m_weight'];
				$m_weightnew = floatval($gm_weight) + floatval($m_weight);
				$this->mini->getorders_merchants_edit($ct_id,$meid,$datetime,$m_weightnew);
			}
		}
		$date1 = date('Y-m-d',time());
		$date2 = date('H:i',time());
		$this->mini->ordergoodsupdatesum($oid,$sum_price,$date1,$date2);

		$this->back_json(200, '操作成功');
	}

	/**
	 * [xmltoarray xml格式转换为数组]
	 * @param [type] $xml [xml]
	 * @return [type]  [xml 转化为array]
	 */
	function xmltoarray($xml) {
		//禁止引用外部xml实体
		libxml_disable_entity_loader(true);
		$xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
		$val = json_decode(json_encode($xmlstring),true);
		return $val;
	}

	/**
	 * [arraytoxml 将数组转换成xml格式（简单方法）:]
	 * @param [type] $data [数组]
	 * @return [type]  [array 转 xml]
	 */
	function arraytoxml($data){
		$str='<xml>';
		foreach($data as $k=>$v) {
			$str.='<'.$k.'>'.$v.'</'.$k.'>';
		}
		$str.='</xml>';
		return $str;
	}

	/**
	 * [createNoncestr 生成随机字符串]
	 * @param integer $length [长度]
	 * @return [type]   [字母大小写加数字]
	 */
	function createNoncestr($length =32){
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYabcdefghijklmnopqrstuvwxyz0123456789";
		$str ="";

		for($i=0;$i<$length;$i++){
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
		}
		return $str;
	}

	/**
	 * [curl_post_ssl 发送curl_post数据]
	 * @param [type] $url  [发送地址]
	 * @param [type] $xmldata [发送文件格式]
	 * @param [type] $second [设置执行最长秒数]
	 * @param [type] $aHeader [设置头部]
	 * @return [type]   [description]
	 */
	function curl_post_ssl($url, $xmldata, $second = 30, $aHeader = array()){
		$isdir = $_SERVER['DOCUMENT_ROOT']."/cert/";//证书位置;绝对路径

		$ch = curl_init();//初始化curl

		curl_setopt($ch, CURLOPT_TIMEOUT, $second);//设置执行最长秒数
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// 终止从服务端进行验证
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');//证书类型
		curl_setopt($ch, CURLOPT_SSLCERT, $isdir . 'apiclient_cert.pem');//证书位置
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');//CURLOPT_SSLKEY中规定的私钥的加密类型
		curl_setopt($ch, CURLOPT_SSLKEY, $isdir . 'apiclient_key.pem');//证书位置
		curl_setopt($ch, CURLOPT_CAINFO, 'PEM');
		curl_setopt($ch, CURLOPT_CAINFO, $isdir . 'rootca.pem');
		if (count($aHeader) >= 1) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);//设置头部
		}
		curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xmldata);//全部数据使用HTTP协议中的"POST"操作来发送

		$data = curl_exec($ch);//执行回话
		if ($data) {
			curl_close($ch);
			return $data;
		} else {
			$error = curl_errno($ch);
			echo "call faild, errorCode:$error\n";
			curl_close($ch);
			return false;
		}
	}

	public function order_update_goods(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$token = isset($_POST["token"]) ? $_POST["token"] : '';
		$merchantsinfo = $this->mini->getmerchantsInfomeid($token);
		if (empty($merchantsinfo)) {
			$this->back_json(206, '请您先去授权商家登录！');
		}

		if (!isset($_POST['oid']) || empty($_POST['oid'])) {
			$this->back_json(205, '数据错误oid！');
		}
		$oid = empty($_POST['oid'])?'':$_POST['oid'];
		$this->mini->orders_goods_del($oid);
		$ct_ids = empty($_POST['ct_ids'])?'':$_POST['ct_ids'];
		if ($ct_ids != '[]'){
			$ct_ids = json_decode($ct_ids,true);
			$str = "";
			if (!empty($ct_ids)){
				foreach($ct_ids as $k=>$v){
					if (empty($str)){
						$str = $str.$v;
					}else{
						$str = $str.','.$v;
					}
				}
			}
			$my_str_arr = '('.$str.')';
			$classlist = $this->mini->getmerchantslistclasstwo($my_str_arr);
			foreach ($classlist as $k=>$v){
				$ct_name = $v['ct_name'];
				$ct_id = $v['ct_id'];
				$ct_img = $v['ct_img'];
				$ct_price = $v['ct_price'];
				$ct_danwei = $v['ct_danwei'];
				$ordergoodsone = $this->mini->getordergoodsone($ct_id,$oid);
				if (!empty($ordergoodsone)){
					continue;
				}
				$og_price = 0;
				$weight = 0;
				$this->mini->order_goods_save($oid,$ct_name,$ct_id,$ct_img,$ct_price,$og_price,$weight,$ct_danwei);
			}
		}
		$this->back_json(200, '操作成功');
	}
	public function indexnewlist(){
		$indexnewlist = $this->mini->getindexnewlist();
		if (!empty($indexnewlist)){
			foreach ($indexnewlist as $k=>$v){
				$indexnewlist[$k]['addtime']=date('Y-m-d',$v['addtime']);
			}
			$data['indexnewlist'] = $indexnewlist;
		}else{
			$data['indexnewlist'] = array();
		}
		$this->back_json(200, '操作成功', $data);
	}
	public function goodsdetails(){

		$nid = $_POST['nid'];
		$goodsdetails = $this->mini->goodsdetails($nid);
		$goodsdetails['addtime']=date('Y-m-d',$goodsdetails['addtime']);
		$data['goodsdetails'] = $goodsdetails;
		$this->back_json(200, '操作成功', $data);
	}
	public function get_set_info(){
		$data['setarr'] = $this->mini->getsettinginfo();
		$this->back_json(200, '操作成功',$data);
	}
	public function goodsdetailssetting(){
		if (!isset($_POST['sid']) || empty($_POST['sid'])) {
			$this->back_json(205, '数据错误sid！');
		}
		$setarr = $this->mini->getsettinginfo();
		$goodsdetails = array();
		if ($_POST['sid'] == 1){
			$goodsdetails['contents'] = empty($setarr['aboutus'])?'':$setarr['aboutus'];
		}elseif ($_POST['sid'] == 2){
			$goodsdetails['contents'] = empty($setarr['recruiting'])?'':$setarr['recruiting'];
		}
		$data['goodsdetails'] = $goodsdetails;
		$this->back_json(200, '操作成功',$data);
	}

	public function merchandise_fullflg_update(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权商家登录！');
		}
		$token = isset($_POST["token"]) ? $_POST["token"] : '';
		$merchantsinfo = $this->mini->getmerchantsInfomeid($token);
		if (empty($merchantsinfo)) {
			$this->back_json(206, '请您先去授权商家登录！');
		}

		if ($merchantsinfo['full_flg'] == 1){
			$this->back_json(206, '当前已经是满仓状态！请勿重复点击！');
		}
		$this->mini->merchandise_fullflg_update($merchantsinfo['meid']);
		$this->back_json(200, '操作成功');
	}
}
