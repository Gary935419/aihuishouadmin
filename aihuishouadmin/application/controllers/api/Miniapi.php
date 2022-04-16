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
		if (!isset($_POST['token']) || empty($_POST['token'])) {
			$this->back_json(205, '请您先去授权登录！');
		}
		$token = $_POST['token'];
		$member = $this->mini->getMemberInfotoken($token);
		if (empty($member)){
			$this->back_json(205, '请您先去授权登录！');
		}

		$page = isset($_POST["page"]) ? $_POST["page"] : 1;
		$list = $this->mini->getclassoneAll($page);
		foreach ($list as $k=>$v){
			$list[$k]['addtime'] = date("Y-m-d",$v['co_addtime']);
		}
		$data["list"] = $list;
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
		$status = isset($_POST["status"]) ? $_POST["status"] : 0;
		$addtime = time();

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
}
