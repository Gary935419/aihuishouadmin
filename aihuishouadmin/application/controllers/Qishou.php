<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Qishou extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Qishou_model', 'qishou');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------骑手账号管理-----------------------------------------------------*/
	/**
	 * 骑手列表页
	 */
	public function qishou_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->qishou->getQishouAllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->qishou->getQishouAll($page, $user_name);

		//获取骑手管理的店铺
		foreach ($data["list"] as $num => $once) {
			$meids=$once['qs_meids'];
			if($meids){
				$menames=null;
				$meidarr=explode(",",$meids);
				foreach ($meidarr as $num1 => $once1) {
					$mename= $this->qishou->getQishoumename($once1);
					$menames=$menames.','.$mename['mename'];
				}
			}
			$data["list"][$num]['qs_menames']=substr($menames,1);
		}

		$data["user_name1"] = $user_name;
		$this->display("qishou/qishou_list", $data);
	}

	/**
	 * 骑手账号删除
	 */
	public function qishou_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->qishou->qishou_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}

	
	/**
	 * 骑手账号添加页
	 */
	public function qishou_add()
	{
		$data = array();
		$ridlist = $this->qishou->getRole();
		$data['ridlist'] = $ridlist;
		$data['menames'] = $this->qishou->getMerchantsMename();

		$this->display("qishou/qishou_add", $data);

	}
	
		/**
     * 骑手账号添加页
     */
    public function qishou_save()
    {
        if (empty($_SESSION['user_name'])) {
            echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
            return;
        }

        $account = isset($_POST["account"]) ? $_POST["account"] : '';
        $password = isset($_POST["password"]) ? $_POST["password"] : '';
		$password = md5($password);

		$qsname = isset($_POST["qsname"]) ? $_POST["qsname"] : '';
        $qstel = isset($_POST["qstel"]) ? $_POST["qstel"] : '';
		$meids = isset($_POST["meids"]) ? $_POST["meids"] : '';
		$meids =implode($meids,",");

		$state = isset($_POST["state"]) ? $_POST["state"] : '';

        $user_info = $this->qishou->getqishouname($account);
        if (!empty($user_info)) {
            echo json_encode(array('error' => true, 'msg' => "该骑手账号已经存在。"));
            return;
        }

		$result = $this->qishou->qishou_save($account,$password,$qsname,$qstel,$meids,$state);
        if ($result) {
            echo json_encode(array('success' => true, 'msg' => "操作成功。"));
        } else {
            echo json_encode(array('error' => false, 'msg' => "操作失败"));
        }
    }
	
		/**
	 * 骑手账号修改显示
	 */
	public function qishou_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->qishou->getRole();
		$data['ridlist'] = $ridlist;

		$member_info = $this->qishou->getqishoulist($uid);
		$data['id'] = $uid;
		$data['account'] = $member_info['qs_account'];
		$data['password'] = $member_info['qs_password'];
		$data['qsname'] = $member_info['qs_name'];
		$data['qstel'] = $member_info['qs_tel'];
		$data['state'] = $member_info['qs_state'];

		$data['meids'] = explode(",",$member_info['qs_meids']);
		$data['menames'] = $this->qishou->getMerchantsMename();

		$this->display("qishou/qishou_edit", $data);
	}

	/**
	 * 商家修改提交
	 */
	public function qishou_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$qsname = isset($_POST["qsname"]) ? $_POST["qsname"] : '';
		$account1 = isset($_POST["account1"]) ? $_POST["account1"] : '';
		$account = isset($_POST["account"]) ? $_POST["account"] : '';
		$password = !empty($_POST["password"]) ? md5($_POST["password"]) : $_POST["pwsd"];
		$qstel = isset($_POST["qstel"]) ? $_POST["qstel"] : '';
		$meids = isset($_POST["meids"]) ? $_POST["meids"] : '';
		$meids =implode($meids,",");
		$state = isset($_POST["state"]) ? $_POST["state"] : '';

		if($account1<>$account){
			$user_info = $this->qishou->getqishouname($account);
			if (!empty($user_info)) {
				echo json_encode(array('error' => true, 'msg' => "该商户名已经存在。"));
				return;
			}
		}

		$result = $this->qishou->qishou_save_edit($uid, $qsname, $account, $password,$qstel,$meids,$state);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}
}
