<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class News extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('News_model', 'news');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------信息管理-----------------------------------------------------*/
	/**
	 * 信息列表页
	 */
	public function news_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->news->getnewsAllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->news->getNewsAll($page, $user_name);

		$data["user_name1"] = $user_name;
		$this->display("news/news_list", $data);
	}

	/**
	 * 信息删除
	 */
	public function news_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->news->news_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}


	/**
	 * 信息添加页
	 */
	public function news_add()
	{
		$data = array();
		$ridlist = $this->news->getRole();
		$data['ridlist'] = $ridlist;
		$this->display("news/news_add", $data);

	}

	/**
	 * 信息添加页
	 */
	public function news_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$ntitle = isset($_POST["ntitle"]) ? $_POST["ntitle"] : '';
		$url = isset($_POST["url"]) ? $_POST["url"] : '';
		$contents = isset($_POST["gcontent"]) ? $_POST["gcontent"] : '';
		$addtime = time();

		$user_info = $this->news->getnewsname($ntitle);
		if (!empty($user_info)) {
			echo json_encode(array('error' => true, 'msg' => "该信息已经存在。"));
			return;
		}

		$result = $this->news->news_save($ntitle,$url,$contents,$addtime);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**
	 * 信息修改显示
	 */
	public function news_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->news->getRole();
		$data['ridlist'] = $ridlist;

		$member_info = $this->news->getnewslist($uid);
		$data['id'] = $uid;
		$data['ntitle'] = $member_info['ntitle'];
		$data['url'] = $member_info['url'];
		$data['gcontent'] = $member_info['contents'];

		$this->display("news/news_edit", $data);
	}

	/**
	 * 信息修改提交
	 */
	public function news_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$ntitle = isset($_POST["ntitle"]) ? $_POST["ntitle"] : '';
		$ntitle1 = isset($_POST["ntitle1"]) ? $_POST["ntitle1"] : '';
		$url = isset($_POST["cturl"]) ? $_POST["cturl"] : '';
		$gcontent = isset($_POST["gcontent"]) ? $_POST["gcontent"] : '';

		if($ntitle<>$ntitle1){
			$user_info = $this->news->getnewsname($ntitle);
			if (!empty($user_info)) {
				echo json_encode(array('error' => true, 'msg' => "该信息已经存在。"));
				return;
			}
		}

		$result = $this->news->news_save_edit($uid, $ntitle, $url, $gcontent);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}




	/**-----------------------------------banner图片管理----------------------------*/
	/**
	 * banner图片列表页
	 */
	public function banners_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->news->getBannersAllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->news->getBannersAll($page, $user_name);

		$data["user_name1"] = $user_name;
		$this->display("news/banners_list", $data);
	}

	/**
	 * banner图片删除
	 */
	public function banners_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->news->banners_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}


	/**
	 * banner图片添加页
	 */
	public function banners_add()
	{
		$data = array();
		$ridlist = $this->news->getRole();
		$data['ridlist'] = $ridlist;
		$this->display("news/banners_add", $data);

	}

	/**
	 * banner图片添加页
	 */
	public function banners_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$bannername = isset($_POST["bannername"]) ? $_POST["bannername"] : '';
		$bannersimg = isset($_POST["gimg"]) ? $_POST["gimg"] : '';
		$addtime = time();

		$user_info = $this->news->getbannersname($bannername);
		if (!empty($user_info)) {
			echo json_encode(array('error' => true, 'msg' => "该信息已经存在。"));
			return;
		}

		$result = $this->news->banners_save($bannername,$bannersimg,$addtime);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**
	 * banner图片修改显示
	 */
	public function banners_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->news->getRole();
		$data['ridlist'] = $ridlist;

		$member_info = $this->news->getBannerslist($uid);
		$data['id'] = $uid;
		$data['bannername'] = $member_info['bannername'];
		$data['bannersimg'] = $member_info['bannerimg'];

		$this->display("news/banners_edit", $data);
	}

	/**
	 * banner图片修改提交
	 */
	public function banners_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$bannername = isset($_POST["bannername"]) ? $_POST["bannername"] : '';
		$bannersimg = isset($_POST["gimg"]) ? $_POST["gimg"] : '';

		$result = $this->news->banners_save_edit($uid, $bannername, $bannersimg);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}


	/**-----------------------------------hezuo图片管理----------------------------*/
	/**
	 * banner图片列表页
	 */
	public function hezuo_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->news->getHezuoAllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->news->getHezuoAll($page, $user_name);

		$data["user_name1"] = $user_name;
		$this->display("news/hezuo_list", $data);
	}

	/**
	 * banner图片删除
	 */
	public function hezuo_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->news->hezuo_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}


	/**
	 * banner图片添加页
	 */
	public function hezuo_add()
	{
		$data = array();
		$ridlist = $this->news->getRole();
		$data['ridlist'] = $ridlist;
		$this->display("news/hezuo_add", $data);

	}

	/**
	 * banner图片添加页
	 */
	public function hezuo_save()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
			return;
		}

		$bannername = isset($_POST["bannername"]) ? $_POST["bannername"] : '';
		$bannersimg = isset($_POST["gimg"]) ? $_POST["gimg"] : '';
		$addtime = time();

		$user_info = $this->news->gethezuoname($bannername);
		if (!empty($user_info)) {
			echo json_encode(array('error' => true, 'msg' => "该信息已经存在。"));
			return;
		}

		$result = $this->news->hezuo_save($bannername,$bannersimg,$addtime);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**
	 * banner图片修改显示
	 */
	public function hezuo_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->news->getRole();
		$data['ridlist'] = $ridlist;

		$member_info = $this->news->getHezuolist($uid);
		$data['id'] = $uid;
		$data['bannername'] = $member_info['bannername'];
		$data['bannersimg'] = $member_info['bannerimg'];

		$this->display("news/hezuo_edit", $data);
	}

	/**
	 * banner图片修改提交
	 */
	public function hezuo_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$bannername = isset($_POST["bannername"]) ? $_POST["bannername"] : '';
		$bannersimg = isset($_POST["gimg"]) ? $_POST["gimg"] : '';

		$result = $this->news->hezuo_save_edit($uid, $bannername, $bannersimg);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}
}
