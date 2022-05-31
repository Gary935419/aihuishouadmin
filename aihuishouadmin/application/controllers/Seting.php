<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Seting extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Seting_model', 'seting');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------信息管理-----------------------------------------------------*/
	/**
	 * 信息列表页
	 */
	public function seting_edit()
	{
		$list = $this->seting->getSetingAll();
		$data['list']=$list;
		$this->display("seting/seting_edit", $data);
	}


	/**
	 * 信息修改提交
	 */
	public function seting_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}

		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$name = isset($_POST["name"]) ? $_POST["name"] : '';
		$tel = isset($_POST["tel"]) ? $_POST["tel"] : '';
		$aboutus = isset($_POST["aboutus"]) ? $_POST["aboutus"] : '';
		$recruiting = isset($_POST["recruiting"]) ? $_POST["recruiting"] : '';

		$jianyi = isset($_POST["jianyi"]) ? $_POST["jianyi"] : '';
		$beizhu = isset($_POST["beizhu"]) ? $_POST["beizhu"] : '';
		$tishi = isset($_POST["recruiting"]) ? $_POST["tishi"] : '';
		
		$result = $this->seting->seting_save_edit($uid,$name,$tel,$aboutus,$recruiting,$jianyi,$beizhu,$tishi);
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
	public function shoporder_list()
	{
		$date = isset($_GET['start']) ? $_GET['start'] : '';
		$ctid = isset($_GET['id']) ? $_GET['id'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->shop->getshoporderAllPage($date,$ctid);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->shop->getshoporderAll($page,$date,$ctid);

		$data["start"] = $date;
		$data["ctid"] = $ctid;
		$this->display("shop/shoporder_list", $data);
	}



}
