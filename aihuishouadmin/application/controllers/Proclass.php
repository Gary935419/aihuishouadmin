<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Proclass extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Proclass_model', 'proclass');
		header("Content-type:text/html;charset=utf-8");
	}

	//----------------------------一级分类ist列表-------------------------------------
	/**
	 * 标签列表页
	 */
	public function proclass1_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->proclass->getProclass1AllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->proclass->getProclass1All($page, $user_name);
		$data["user_name1"] = $user_name;
		$this->display("proclass/proclass1_list", $data);
	}

	/**
	 * 管理员删除
	 */
	public function proclass1_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->proclass->proclass1_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}

	//---------------------------一级分类add添加-------------------------------------
	/**
	 * 商家添加页
	 */
	public function proclass1_add()
	{
		$data = array();
		$ridlist = $this->proclass->getRole();
		$data['ridlist'] = $ridlist;
		$this->display("proclass/proclass1_add", $data);
	}
	
		/**
     * 商家添加页
     */
    public function proclass1_save()
    {
        if (empty($_SESSION['user_name'])) {
            echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
            return;
        }

        $name = isset($_POST["name"]) ? $_POST["name"] : '';
		$user_info = $this->proclass->getprocalss1name($name);

        if (!empty($user_info)) {
            echo json_encode(array('error' => true, 'msg' => "该分类已经存在。"));
            return;
        }
		$state = isset($_POST["state"]) ? $_POST["state"] : 3;
		$pic = isset($_POST["gimg"]) ? $_POST["gimg"] : '';
		$time = time();

        $result = $this->proclass->proclass1_save($name,$state,$pic,$time);
        if ($result) {
            echo json_encode(array('success' => true, 'msg' => "操作成功。"));
        } else {
            echo json_encode(array('error' => false, 'msg' => "操作失败"));
        }
    }


	//---------------------------一级edit更新-------------------------------------
	
	 /**
	 *标签修改显示
	 */
	public function proclass1_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->proclass->getRole();
		$data['ridlist'] = $ridlist;
		$member_info = $this->proclass->getproclass1list($uid);
		$data['id'] = $uid;
		$data['name'] = $member_info['co_name'];
		$data['state'] = $member_info['co_state'];
		$data['gimg'] = $member_info['co_img'];
		$this->display("proclass/proclass1_edit", $data);
	}

	/**
	 * 标签修改提交
	 */
	public function proclass1_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$name = isset($_POST["name"]) ? $_POST["name"] : '';
		$state = isset($_POST["state"]) ? $_POST["state"] : '';
		$pic = isset($_POST["gimg"]) ? $_POST["gimg"] : '';
		$name1 = isset($_POST["name1"]) ? $_POST["name1"] : '';

		if($name<>$name1) {
			$user_info = $this->proclass->getproclass1ById($name);
			if (!empty($user_info)) {
				echo json_encode(array('error' => true, 'msg' => "该标签已经存在。"));
				return;
			}
		}

		$result = $this->proclass->proclass1_save_edit($uid,$name,$state,$pic);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}


	//----------------------------二级分类ist列表-------------------------------------
	/**
	 * 标签列表页
	 */
	public function proclass2_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->proclass->getProclass2AllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->proclass->getProclass2All($page, $user_name);
		$data["user_name1"] = $user_name;
		$this->display("proclass/proclass2_list", $data);
	}

	/**
	 * 管理员删除
	 */
	public function proclass2_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->proclass->proclass2_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}

	//---------------------------二级分类add添加-------------------------------------
	/**
	 * 商家添加页
	 */
	public function proclass2_add()
	{
		$data = array();
		$ridlist = $this->proclass->getRole();
		$data['ridlist'] = $ridlist;
		$data['class1'] = $this->proclass->getproclass1s();
		$this->display("proclass/proclass2_add", $data);
	}

	/**
	 * 商家添加页
	 */
	public function proclass2_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}
		$coid = isset($_POST["coid"]) ? $_POST["coid"] : '';
		$name = isset($_POST["name"]) ? $_POST["name"] : '';
		$state = isset($_POST["state"]) ? $_POST["state"] : '';
		$pic = isset($_POST["gimg"]) ? $_POST["gimg"] : '';
		$price = isset($_POST["price"]) ? $_POST["price"] : '';
		$time = time();

		$user_info = $this->proclass->getprocalss2name($name);

		if (!empty($user_info)) {
			echo json_encode(array('error' => true, 'msg' => "该分类已经存在。"));
			return;
		}

		$result = $this->proclass->proclass2_save($coid,$name,$state,$pic,$price,$time);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	//---------------------------二级edit更新-------------------------------------

	/**
	 *标签修改显示
	 */
	public function proclass2_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->proclass->getRole();
		$data['ridlist'] = $ridlist;
		$member_info = $this->proclass->getproclass2list($uid);
		$data['id'] = $uid;
		$data['coid'] = $member_info['co_id'];
		$data['name'] = $member_info['ct_name'];
		$data['state'] = $member_info['ct_state'];
		$data['gimg'] = $member_info['ct_img'];
		$data['price'] = $member_info['ct_price'];
		$data['class1'] = $this->proclass->getproclass1s();
		$this->display("proclass/proclass2_edit", $data);
	}

	/**
	 * 标签修改提交
	 */
	public function proclass2_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$name = isset($_POST["name"]) ? $_POST["name"] : '';
		$state = isset($_POST["state"]) ? $_POST["state"] : '';
		$pic = isset($_POST["gimg"]) ? $_POST["gimg"] : '';
		$price = isset($_POST["price"]) ? $_POST["price"] : '';
		$coid = isset($_POST["coid"]) ? $_POST["coid"] : '';
		$name1 = isset($_POST["name1"]) ? $_POST["name1"] : '';

		if($name<>$name1) {
			$user_info = $this->proclass->getproclass2ById($name);
			if (!empty($user_info)) {
				echo json_encode(array('error' => true, 'msg' => "该标签已经存在。"));
				return;
			}
		}

		$result = $this->proclass->proclass2_save_edit($coid,$uid,$name,$state,$pic,$price);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}
}
