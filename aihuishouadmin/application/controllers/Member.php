<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Member extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Member_model', 'member');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------用户管理-----------------------------------------------------*/
	/**
	 * 用户列表页
	 */
	public function member_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->member->getMemberAllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->member->getMemberAll($page, $user_name);

		$data["user_name1"] = $user_name;
		$this->display("member/member_list", $data);
	}

	/**
	 * 管理员删除
	 */
	public function member_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$status = $_POST['status']==1 ? 0 : 1;

		if ($this->member->member_delete($id,$status)) {
			echo json_encode(array('success' => true, 'msg' => "操作成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "操作失败"));
		}
	}

}
