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
		$status = isset($_GET['status']) ? $_GET['status'] : '1';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->member->getMemberAllPage($user_name,$status);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$membersarr = $this->member->getMemberAll($page, $user_name,$status);

		foreach ($membersarr as $key => $value){
		    $arrs = $this->member->getMemberOrderAll($value['mid']);   
		    $membersarr[$key]['name']=$arrs['uname'];
		    $membersarr[$key]['utel']=$arrs['utel'];
		}
        $data['list']=$membersarr;
		$data["user_name1"] = $user_name;
		$data["status"] = $status;
		$this->display("member/member_list", $data);
	}

	/**
	 * 账号停用
	 */
	public function member_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$status = $_POST['status']==1 ? 2 : 1;

		if ($this->member->member_delete($id,$status)) {
			echo json_encode(array('success' => true, 'msg' => "操作成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "操作失败"));
		}
	}

	/**
	 * 开通上门回收
	 */
	public function member_getpro()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$getpro = $_POST['getpro']==0 ? 1 : 0;

		if ($this->member->member_getpro($id,$getpro)) {
			echo json_encode(array('success' => true, 'msg' => "操作成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "操作失败"));
		}
	}

	/**-----------------------------------地址管理-----------------------------------------------------*/
	/**
	 * 用户列表页
	 */
	public function address_list()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->member->getAddressAllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->member->getAddressAll($page, $user_name,$uid);

		$data["user_name1"] = $user_name;
		$this->display("member/address_list", $data);
	}

	/**-----------------------------------个人订单管理-----------------------------------------------------*/
	/**
	 * 用户列表页
	 */
	public function userorder_list()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$start = isset($_GET['start']) ? strtotime($_GET['start']) : strtotime(date('Y-m-d'));
		$end = isset($_GET['end']) ? strtotime($_GET['end']) : "";
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->member->getUserOrderAllPage($uid,$start,$end);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;

		$ordersarr=$this->member->getUserOrderAll($page,$uid,$start,$end);
		foreach ($ordersarr as $key => $value){
			$oid=$value['oid'];
			$meid=$value['meid'];
			$orderprosarr=$this->member->getUserOrderProAll($oid);
			$proname="";
			$moneys=0;
			foreach ($orderprosarr as $value){
				$proname=$proname." / ".$value['ct_name']."(".$value['weight'].")";
				$moneys=$moneys+$value['og_price'];
			}
			$ordersarr[$key]['proname']=$proname;
			$ordersarr[$key]['moneys']=$moneys;

			//获取商家名称
			$merchantsname=$this->member->getMerchantsname($meid);

			$ordersarr[$key]['merchantsname']=$merchantsname['mename'];
		}

		$data["list"] = $ordersarr;
		$data["start"] = date("Y-m-d",$start);
		if($end) {
			$data["end"] = date("Y-m-d", $end);
		}else{
			$data["end"] =$end;
		}
		$data["uid"] = $uid;
		$this->display("member/userorder_list", $data);
	}

}
