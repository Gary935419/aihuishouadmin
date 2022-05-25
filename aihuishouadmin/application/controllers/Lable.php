<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Lable extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Lable_model', 'lable');
		header("Content-type:text/html;charset=utf-8");
	}

	//----------------------------list列表-------------------------------------
	/**
	 * 标签列表页
	 */
	public function lable_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->lable->getLableAllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->lable->getLableAll($page, $user_name);
		$data["user_name1"] = $user_name;
		$this->display("lable/lable_list", $data);
	}

	/**
	 * 管理员删除
	 */
	public function lable_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->lable->lable_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}

	//----------------------------add添加-------------------------------------
	/**
	 * 商家添加页
	 */
	public function lable_add()
	{
		$data = array();
		$ridlist = $this->lable->getRole();
		$data['ridlist'] = $ridlist;
		$this->display("lable/lable_add", $data);
	}
	
		/**
     * 商家添加页
     */
    public function lable_save()
    {
        if (empty($_SESSION['user_name'])) {
            echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
            return;
        }

        $ltitle = isset($_POST["ltitle"]) ? $_POST["ltitle"] : '';
		$user_info = $this->lable->getlableById($ltitle);

        if (!empty($user_info)) {
            echo json_encode(array('error' => true, 'msg' => "该标签已经存在。"));
            return;
        }
        $result = $this->lable->lable_save($ltitle);
        if ($result) {
            echo json_encode(array('success' => true, 'msg' => "操作成功。"));
        } else {
            echo json_encode(array('error' => false, 'msg' => "操作失败"));
        }
    }

	//----------------------------edit更新-------------------------------------
	
	 /**
	 *标签修改显示
	 */
	public function lable_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->lable->getRole();
		$data['ridlist'] = $ridlist;
		$member_info = $this->lable->getlablelist($uid);
		$data['ltitle'] = $member_info['ltitle'];
		$data['laid'] = $member_info['laid'];
		$this->display("lable/lable_edit", $data);
	}

	/**
	 * 标签修改提交
	 */
	public function lable_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$ltitle = isset($_POST["ltitle"]) ? $_POST["ltitle"] : '';
		$user_info = $this->lable->getlableById($ltitle);

		if (!empty($user_info)) {
			echo json_encode(array('error' => true, 'msg' => "该标签已经存在。"));
			return;
		}

		$result = $this->lable->lable_save_edit($uid, $ltitle);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}


	//----------------------------grade列表-------------------------------------
	/**
	 * 标签列表页
	 */
	public function grade_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->lable->getGradeAllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->lable->getGradeAll($page,$user_name);
		$data["user_name1"] = $user_name;
		$this->display("lable/grade_list", $data);
	}

	/**
	 * 管理员删除
	 */
	public function grade_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->lable->grade_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}

	//----------------------------add添加-------------------------------------
	/**
	 * 商家添加页
	 */
	public function grade_add()
	{
		$data = array();
		$ridlist = $this->lable->getRole();
		$data['ridlist'] = $ridlist;
		$this->display("lable/grade_add", $data);
	}

	/**
	 * 商家添加页
	 */
	public function grade_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$lname = isset($_POST["lname"]) ? $_POST["lname"] : '';
		$lcontents = isset($_POST["lcontents"]) ? $_POST["lcontents"] : '';
		$limg = isset($_POST["gimg"]) ? $_POST["gimg"] : '';
		$user_info = $this->lable->getgradeById($lname);

		if (!empty($user_info)) {
			echo json_encode(array('error' => true, 'msg' => "该标签已经存在。"));
			return;
		}
		$result = $this->lable->grade_save($lname,$lcontents,$limg);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	//----------------------------edit更新-------------------------------------

	/**
	 *标签修改显示
	 */
	public function grade_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->lable->getRole();
		$data['ridlist'] = $ridlist;
		$member_info = $this->lable->getgradelist($uid);
		$data['lid'] = $member_info['lid'];
		$data['lname'] = $member_info['lname'];
		$data['lcontents'] = $member_info['lcontents'];
		$data['limg'] = $member_info['limg'];
		$this->display("lable/grade_edit", $data);
	}

	/**
	 * 标签修改提交
	 */
	public function grade_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$lname = isset($_POST["lname"]) ? $_POST["lname"] : '';
		$lcontents = isset($_POST["lcontents"]) ? $_POST["lcontents"] : 0;
		$limg = isset($_POST["gimg"]) ? $_POST["gimg"] : '';

		$result = $this->lable->grade_save_edit($uid, $lname,$lcontents,$limg);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

}
