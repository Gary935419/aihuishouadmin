<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Stock extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Stock_model', 'stock');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------信息管理-----------------------------------------------------*/
	/**
	 * 信息列表页
	 */
	public function stock_list()
	{
		$ctname = isset($_GET['ctname']) ? $_GET['ctname'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->stock->getStockAllPage($ctname);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->stock->getStockAll($page,$ctname);

		$data["ctlist"] = $this->stock->getctname();
		$data["ctid"] = $ctname;
		$this->display("stock/stock_list", $data);
	}

	/**
	 * 信息修改显示
	 */
	public function stock_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->stock->getRole();
		$data['ridlist'] = $ridlist;

		$member_info = $this->stock->getStocklist($uid);
		$data['id'] = $uid;
		$data['ctid'] = $member_info['ct_id'];
		$data['ctname'] = $member_info['ct_name'];
		$data['stocknum'] = $member_info['stocknum'];
		$this->display("stock/stock_edit", $data);
	}

	/**
	 * 信息修改提交
	 */
	public function stock_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}

		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$ctid = isset($_POST["ctid"]) ? $_POST["ctid"] : '';
		$ctname = isset($_POST["ctname"]) ? $_POST["ctname"] : '';
		$outnum = isset($_POST["outnum"]) ? $_POST["outnum"] : 0;
		$stocknum = $_POST["stocknum"]-$outnum;
		$addtime=date('Y-m-d');

		if ($stocknum<0) {
			echo json_encode(array('error' => true, 'msg' => "出库小于零，请重新输入。"));
			return;
		}

		$result = $this->stock->stock_save_edit($uid,$ctid,$ctname,$stocknum,$outnum,$addtime);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}


	/**-----------------------------------出库订单详情-----------------------------------------------------*/
	/**
	 * 信息列表页
	 */
	public function stockorder_list()
	{
		$date = isset($_GET['start']) ? $_GET['start'] : '';
		$ctid = isset($_GET['id']) ? $_GET['id'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->stock->getStockorderAllPage($date,$ctid);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->stock->getStockorderAll($page,$date,$ctid);

		$data["start"] = $date;
		$data["ctid"] = $ctid;
		$this->display("stock/stockorder_list", $data);
	}



}
