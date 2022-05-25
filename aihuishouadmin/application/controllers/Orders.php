<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Orders extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Orders_model', 'orders');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------订单管理-----------------------------------------------------*/
	/**
	 * 订单列表页
	 */
	public function orders_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$ostate = isset($_GET['ostate']) ? $_GET['ostate'] : '0';
		$start = isset($_GET['start']) ? strtotime($_GET['start']) : strtotime(date('Y-m-d'));
		$end = isset($_GET['end']) ? strtotime($_GET['end']) : "";
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->orders->getOrdersAllPage($user_name,$ostate,$start,$end);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->orders->getOrdersAll($page, $user_name,$ostate,$start,$end);

		//获取用户卖的所有货物
		foreach ($data["list"] as $num => $once) {
			$oid=$once['oid'];
			$goodsarr[]=null;
			$goodsarr = $this->orders->getOrdersgoods($oid);
			foreach ($goodsarr as $num1 => $once1) {
				$goodsarr[$num1]=$once1['ct_name']."(".$once1['weight'].")";
			}
			$goods = implode($goodsarr," / ");
			$data["list"][$num]['goodsname']=$goods;
		}

		$data["start"] = date("Y-m-d",$start);
		if($end) {
			$data["end"] = date("Y-m-d", $end);
		}else{
			$data["end"] =$end;
		}
		$data["ostate"] = $ostate;
		$data["user_name1"] = $user_name;
		$this->display("orders/order_list", $data);
	}



	/**-----------------------------------订单详情管理-----------------------------------------------------*/
	/**
	 * 订单列表页
	 */
	public function order_show()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$name = $this->orders->getmerchants($uid);
		$data["list"] = $this->orders->getorderslist($uid);
		$data["name"] =$name['muser'];
		$this->display("orders/order_show", $data);
	}

	/**-----------------------------------订单修改-----------------------------------------------------*/
	/**
	 * 订单修改
	 */

	public function order_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$member_info = $this->orders->getordergoods($uid);
		$data['id'] = $uid;
		$data['name'] = $member_info['ct_name'];
		$data['weight'] = $member_info['weight'];

		$this->display("orders/order_edit", $data);
	}

	/**
	 * banner图片修改提交
	 */
	public function order_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$weight = isset($_POST["weight"]) ? $_POST["weight"] : 0;
		$result = $this->orders->order_save_edit($uid, $weight);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}


	/**-----------------------------------商家统计管理-----------------------------------------------------*/
	/**
	 * 订单列表页
	 */
	public function ordermerchants_list()
	{
		//获取所有商家信息
		$meid = isset($_GET['meid']) ? $_GET['meid'] : 0;
		$start = isset($_GET['start']) ? strtotime($_GET['start']) : strtotime(date('Y-m-d'));
		$end = isset($_GET['end']) ? strtotime($_GET['end']) : "";
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$data["merchantslist"] = $this->orders->getmerchantsname();

		$allpage = $this->orders->getMerchantsOrderAllPage($meid, $start, $end);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->orders->getMerchantsOrdersAll($page, $meid, $start, $end);

		$data["start"] = date("Y-m-d",$start);
		if($end) {
			$data["end"] = date("Y-m-d", $end);
		}else{
			$data["end"] =$end;
		}
		$data["meid"] =$meid;
		$this->display("orders/ordermerchants_list", $data);
	}


	/**-----------------------------------司机统计管理-----------------------------------------------------*/
	/**
	 * 订单列表页
	 */
	public function orderqishou_list()
	{
		//获取所有商家信息
		$qsid = isset($_GET['qsid']) ? $_GET['qsid'] : 0;
		$start = isset($_GET['start']) ? strtotime($_GET['start']) : strtotime(date('Y-m-d'));
		$end = isset($_GET['end']) ? strtotime($_GET['end']) : "";
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$data["qishoulist"] = $this->orders->getqishouname();

		$allpage = $this->orders->getQishouOrderAllPage($qsid, $start, $end);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->orders->getQishouOrdersAll($page, $qsid, $start, $end);

		$data["start"] = date("Y-m-d",$start);
		if($end) {
			$data["end"] = date("Y-m-d", $end);
		}else{
			$data["end"] =$end;
		}
		$data["qsid"] =$qsid;
		$this->display("orders/orderqishou_list", $data);
	}

	/**-----------------------------------司机入库管理-----------------------------------------------------*/
	/**
	 * 订单列表页
	 */

	public function orderqishou_edit()
	{
//获取所有商家信息
		$qsid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data["list"] = $this->orders->getOrderMerchantsAll($qsid);
		$this->display("orders/orderqishou_edit", $data);
	}
	/**-----------------------------------司机入库管理-----------------------------------------------------*/
	/**
	 * 订单列表页
	 */

	public function stcok_add()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$arrm=$this->orders->getOrderMerchantsAll($id);
		foreach ($arrm as $key => $value){
			//获取商品分类
			$ctid=$value['ct_id'];
			if($this->orders->getStockAll($ctid)){
				$this->orders->stock_edit($ctid,$value);
			}else{
				$this->orders->stock_add($ctid,$value);
			}
		}
		if ($this->orders->orderqishou_edit($id)) {
			echo json_encode(array('success' => true, 'msg' => "入库成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "入库失败"));
		}
	}


}
