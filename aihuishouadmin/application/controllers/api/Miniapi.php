<?php
/**
 * **********************************************************************
 * サブシステム名  ： MINI
 * 機能名         ：API
 * 作成者        ： Gary
 * **********************************************************************
 */
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
			$orderlist[$k]['checked'] = false;
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
		$list = $this->mini->getmemberaddressAll($page);
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
		$longitude = isset($_POST["longitude"]) ? $_POST["longitude"] : '';
		$latitude = isset($_POST["latitude"]) ? $_POST["latitude"] : '';
		$province = isset($_POST["province"]) ? $_POST["province"] : '';
		$city = isset($_POST["city"]) ? $_POST["city"] : '';
		$area = isset($_POST["area"]) ? $_POST["area"] : '';
		$address = isset($_POST["address"]) ? $_POST["address"] : '';
		$name = isset($_POST["name"]) ? $_POST["name"] : '';
		$mobile = isset($_POST["mobile"]) ? $_POST["mobile"] : '';

		$list = $this->mini->getmemberaddressAll(1);
		if ($_POST["status"]){
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
		$data['member'] = $member;
		$this->back_json(200, '操作成功', $data);
	}

	public function merchantsinfo(){
		//验证loginCode是否传递
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		if (!isset($_POST['meid']) || empty($_POST['meid'])) {
			$this->back_json(206, '缺少商家id！');
		}
		$meid = isset($_POST["meid"]) ? $_POST["meid"] : '';
		$merchantsinfo = $this->mini->getmerchantsInfomeid($meid);
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
		$this->back_json(200, '操作成功', $data);
	}

	public function orders_details(){
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
		$orderlist = $this->mini->getmerchantslist($page,$testinfo);
		foreach ($orderlist as $k=>$v){
			$my_str_arr = '('.$v['laid'].')';
			$orderlist[$k]['lablearr'] = $this->mini->getmerchantslistlable($my_str_arr);
		}
		$data['list'] = $orderlist;
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
		$orderlist = $this->mini->getmerchantslistseach($page,$testinfo);
		foreach ($orderlist as $k=>$v){
			$my_str_arr = '('.$v['laid'].')';
			$orderlist[$k]['lablearr'] = $this->mini->getmerchantslistlable($my_str_arr);
		}
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
		$ct_ids_arr = json_decode($ct_ids,true);
		$str = "";
		foreach ($ct_ids_arr as $k=>$v){
			if ($v['checked']){
				if (empty($str)){
					$str = $str.$v['ct_id'];
				}else{
					$str = $str.','.$v['ct_id'];
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
		if (!isset($_POST['ct_ids']) || $_POST['ct_ids']=='[]') {
			$this->back_json(202, '请选择回收分类！');
		}
		$ct_ids = empty($_POST['ct_ids'])?'':$_POST['ct_ids'];
		$ct_ids_arr = json_decode($ct_ids,true);
		$str = "";
		foreach ($ct_ids_arr as $k=>$v){
			if ($v['checked']){
				if (empty($str)){
					$str = $str.$v['ct_id'];
				}else{
					$str = $str.','.$v['ct_id'];
				}
			}
		}
		$my_str_arr = '('.$str.')';
		$classlist = $this->mini->getmerchantslistclasstwo($my_str_arr);
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

		if (!isset($_POST['uname']) || empty($_POST['uname'])) {
			$this->back_json(202, '请选择联系人！');
		}
		$uname = empty($_POST['uname'])?'':$_POST['uname'];

		if (!isset($_POST['utel']) || empty($_POST['utel'])) {
			$this->back_json(202, '请选择电话！');
		}
		$utel = empty($_POST['utel'])?'':$_POST['utel'];

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
		$ostate = 0;
		$addtime = time();
		$mid = $member['mid'];
		$sum_price = 0;
		$otype = 0;
		$order_status = 0;
		$oid = $this->mini->order_save($order_status,$ostate,$addtime,$sum_price,$note,$delivery_date,$delivery_time,$uname,$utel,$muser,$maddress,$mid,$meid,$otype);

		foreach ($classlist as $k=>$v){
			$ct_name = $v['ct_name'];
			$ct_id = $v['ct_id'];
			$ct_img = $v['ct_img'];
			$ct_price = $v['ct_price'];
			$og_price = 0;
			$weight = 0;
			$this->mini->order_goods_save($oid,$ct_name,$ct_id,$ct_img,$ct_price,$og_price,$weight);
		}
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

		if (!isset($_POST['uname']) || empty($_POST['uname'])) {
			$this->back_json(202, '请选择联系人！');
		}
		$uname = empty($_POST['uname'])?'':$_POST['uname'];

		if (!isset($_POST['utel']) || empty($_POST['utel'])) {
			$this->back_json(202, '请选择电话！');
		}
		$utel = empty($_POST['utel'])?'':$_POST['utel'];

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
		$ostate = 0;
		$addtime = time();
		$mid = $member['mid'];
		$sum_price = 0;
		$otype = 0;
		$order_status = 1;
		$this->mini->order_save($order_status,$ostate,$addtime,$sum_price,$note,$delivery_date,$delivery_time,$uname,$utel,$muser,$maddress,$mid,$meid,$otype);

		$this->back_json(200, '操作成功');
	}
}
