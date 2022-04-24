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
	public function orders1_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->orders->getOrdersAllPage($user_name,0);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->orders->getOrdersAll($page, $user_name,0);

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

		$data["user_name1"] = $user_name;
		$this->display("orders/orders1_list", $data);
	}

	public function orders2_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->orders->getOrdersAllPage($user_name,2);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->orders->getOrdersAll($page, $user_name,2);

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

		$data["user_name1"] = $user_name;
		$this->display("orders/orders2_list", $data);
	}

	public function orders3_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->orders->getOrdersAllPage($user_name,3);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->orders->getOrdersAll($page, $user_name,3);

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

		$data["user_name1"] = $user_name;
		$this->display("orders/orders3_list", $data);
	}


	/**
	 * 订单修改显示
	 */
	public function orders1_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->orders->getRole();
		$data['ridlist'] = $ridlist;
		$data["list"] = $this->orders->getorderslist($uid);

		$this->display("orders/orders1_edit", $data);
	}

	/**
	 * 订单修改提交
	 */
	public function orders_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$ntitle = isset($_POST["ntitle"]) ? $_POST["ntitle"] : '';
		$ntitle1 = isset($_POST["ntitle1"]) ? $_POST["ntitle1"] : '';
		$gimg = isset($_POST["gimg"]) ? $_POST["gimg"] : '';
		$gcontent = isset($_POST["gcontent"]) ? $_POST["gcontent"] : '';

		if($ntitle<>$ntitle1){
			$user_info = $this->orders->getordersname($ntitle);
			if (!empty($user_info)) {
				echo json_encode(array('error' => true, 'msg' => "该订单已经存在。"));
				return;
			}
		}

		$result = $this->orders->orders_save_edit($uid, $ntitle, $gimg, $gcontent);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}
}
