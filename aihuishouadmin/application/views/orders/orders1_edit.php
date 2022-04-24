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

	/**-----------------------------------订单管理-----------------------------------------------------*/
	/**
	 * 订单列表页
	 */
	public function member1_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->member->getMemberAllPage($user_name,0);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->member->getMemberAll($page, $user_name,0);

		//获取用户卖的所有货物
		foreach ($data["list"] as $num => $once) {
			$oid=$once['oid'];
			$goodsarr[]=null;
			$goodsarr = $this->member->getMembergoods($oid);
			foreach ($goodsarr as $num1 => $once1) {
				$goodsarr[$num1]=$once1['ct_name']."(".$once1['weight'].")";
			}
			$goods = implode($goodsarr," / ");
			$data["list"][$num]['$goodsname']=$goods;
		}

		$data["user_name1"] = $user_name;
		$this->display("member/member1_list", $data);
	}

	/**
	 * 订单修改显示
	 */
	public function member1_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->member->getRole();
		$data['ridlist'] = $ridlist;
		$data["list"] = $this->member->getmemberlist($uid);

		$this->display("member/member1_edit", $data);
	}

	/**
	 * 订单修改提交
	 */
	public function member_save_edit()
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
			$user_info = $this->member->getmembername($ntitle);
			if (!empty($user_info)) {
				echo json_encode(array('error' => true, 'msg' => "该订单已经存在。"));
				return;
			}
		}

		$result = $this->member->member_save_edit($uid, $ntitle, $gimg, $gcontent);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}
}
