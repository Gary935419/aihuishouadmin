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
		$listimg = isset($_POST["gimg"]) ? $_POST["gimg"] : '';
		$contents = isset($_POST["gcontent"]) ? $_POST["gcontent"] : '';
		$addtime = time();

        $user_info = $this->news->getnewsname($ntitle);
        if (!empty($user_info)) {
            echo json_encode(array('error' => true, 'msg' => "该信息已经存在。"));
            return;
        }

		$result = $this->news->news_save($ntitle,$listimg,$contents,$addtime);
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
		$data['gimg'] = $member_info['listimg'];
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
		$gimg = isset($_POST["gimg"]) ? $_POST["gimg"] : '';
		$gcontent = isset($_POST["gcontent"]) ? $_POST["gcontent"] : '';

		if($ntitle<>$ntitle1){
			$user_info = $this->news->getnewsname($ntitle);
			if (!empty($user_info)) {
				echo json_encode(array('error' => true, 'msg' => "该信息已经存在。"));
				return;
			}
		}

		$result = $this->news->news_save_edit($uid, $ntitle, $gimg, $gcontent);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}
}
