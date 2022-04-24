<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Promote extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Promote_model', 'promote');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------优惠卷管理-----------------------------------------------------*/
	/**
	 * 优惠卷列表页
	 */
	public function promote_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->promote->getPromoteAllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->promote->getPromoteAll($page, $user_name);

		$data["user_name1"] = $user_name;
		$this->display("promote/promote_list", $data);
	}

	/**
	 * 优惠卷删除
	 */
	public function promote_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->promote->promote_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}

	
	/**
	 * 优惠卷添加页
	 */
	public function promote_add()
	{
		$data = array();
		$ridlist = $this->promote->getRole();
		$data['ridlist'] = $ridlist;
		$this->display("promote/promote_add", $data);

	}
	
		/**
     * 优惠卷添加页
     */
    public function promote_save()
    {
        if (empty($_SESSION['user_name'])) {
            echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
            return;
        }

        $name = isset($_POST["name"]) ? $_POST["name"] : '';

        $starttime = isset($_POST["starttime"]) ? $_POST["starttime"] : '';
		$starttime =strtotime($starttime);
		$endtime = isset($_POST["endtime"]) ? $_POST["endtime"] : '';
		$endtime =strtotime($endtime);

        $price = isset($_POST["price"]) ? $_POST["price"] : '';
		$area = isset($_POST["area"]) ? $_POST["area"] : '';
		$state = isset($_POST["state"]) ? $_POST["state"] : '';
		$addtime = time();


        $user_info = $this->promote->getpromotename($name);
        if (!empty($user_info)) {
            echo json_encode(array('error' => true, 'msg' => "该优惠卷已经存在。"));
            return;
        }

		$result = $this->promote->promote_save($name,$starttime,$endtime,$price,$area,$state,$addtime);
        if ($result) {
            echo json_encode(array('success' => true, 'msg' => "操作成功。"));
        } else {
            echo json_encode(array('error' => false, 'msg' => "操作失败"));
        }
    }
	
		/**
	 * 优惠卷修改显示
	 */
	public function promote_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->promote->getRole();
		$data['ridlist'] = $ridlist;

		$member_info = $this->promote->getpromotelist($uid);
		$data['id'] = $uid;
		$data['name'] = $member_info['promote_name'];
		$data['starttime'] = $member_info['promote_starttime'];
		$data['endtime'] = $member_info['promote_endtime'];
		$data['area'] = $member_info['promote_area'];
		$data['price'] = $member_info['promote_price'];
		$data['state'] = $member_info['promote_state'];

		$this->display("promote/promote_edit", $data);
	}

	/**
	 * 优惠卷修改提交
	 */
	public function promote_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$name = isset($_POST["name"]) ? $_POST["name"] : '';
		$name1 = isset($_POST["name1"]) ? $_POST["name1"] : '';

		$starttime = isset($_POST["starttime"]) ? $_POST["starttime"] : '';
		$starttime =strtotime($starttime);
		$endtime = isset($_POST["endtime"]) ? $_POST["endtime"] : '';
		$endtime =strtotime($endtime);

		$price = isset($_POST["price"]) ? $_POST["price"] : '';
		$area = isset($_POST["area"]) ? $_POST["area"] : '';
		$state = isset($_POST["state"]) ? $_POST["state"] : '';

		if($name<>$name1){
			$user_info = $this->promote->getpromotename($name);
			if (!empty($user_info)) {
				echo json_encode(array('error' => true, 'msg' => "该优惠卷已经存在。"));
				return;
			}
		}

		$result = $this->promote->promote_save_edit($uid, $name, $starttime, $endtime,$price,$area,$state);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}


	/**-----------------------------------赠送商品管理-----------------------------------------------------*/
	/**
	 * 优惠卷列表页
	 */
	public function couple_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->promote->getCoupleAllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->promote->getCoupleAll($page, $user_name);

		$data["user_name1"] = $user_name;
		$this->display("promote/couple_list", $data);
	}

	/**
	 * 优惠卷删除
	 */
	public function couple_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->promote->couple_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}


	/**
	 * 优惠卷添加页
	 */
	public function couple_add()
	{
		$data = array();
		$ridlist = $this->promote->getRole();
		$data['ridlist'] = $ridlist;
		$this->display("promote/couple_add", $data);

	}

	/**
	 * 优惠卷添加页
	 */
	public function couple_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$name = isset($_POST["name"]) ? $_POST["name"] : '';
		$gimg = isset($_POST["gimg"]) ? $_POST["gimg"] : '';
		$num = isset($_POST["num"]) ? $_POST["num"] : '';
		$addtime = date("Y-m-d",time());

		$user_info = $this->promote->getcouplename($name);
		if (!empty($user_info)) {
			echo json_encode(array('error' => true, 'msg' => "该礼品已经存在。"));
			return;
		}

		$result = $this->promote->couple_save($name,$gimg,$num,$addtime);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**
	 * 优惠卷修改显示
	 */
	public function couple_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->promote->getRole();
		$data['ridlist'] = $ridlist;

		$member_info = $this->promote->getcouplelist($uid);
		$data['id'] = $uid;
		$data['name'] = $member_info['couple_goodsname'];
		$data['gimg'] = $member_info['couple_goodsimg'];
		$data['num'] = $member_info['couple_num'];

		$this->display("promote/couple_edit", $data);
	}

	/**
	 * 优惠卷修改提交
	 */
	public function couple_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = $_POST["uid"];
		$name = isset($_POST["name"]) ? $_POST["name"] : '';
		$gimg = isset($_POST["gimg"]) ? $_POST["gimg"] : '';
		$num = isset($_POST["num"]) ? $_POST["num"] : '';
		$name1 = isset($_POST["name"]) ? $_POST["name"] : '';

		if($name<>$name1){
			$user_info = $this->promote->getcouplename($name);
			if (!empty($user_info)) {
				echo json_encode(array('error' => true, 'msg' => "该礼品已经存在。"));
				return;
			}
		}

		$result = $this->promote->couple_save_edit($uid, $name, $gimg, $num);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

}
