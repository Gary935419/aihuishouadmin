<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Merchants extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Merchants_model', 'merchants');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------商家账号管理-----------------------------------------------------*/
	/**
	 * 商家列表页
	 */
	public function merchants_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->merchants->getMerchantsAllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->merchants->getMerchantsAll($page, $user_name);
		$data["user_name1"] = $user_name;
		$this->display("merchants/merchants_list", $data);
	}
	
	/**
	 * 商家添加页
	 */
	public function merchants_add()
	{
		$data = array();
		$ridlist = $this->merchants->getRole();
		$data['ridlist'] = $ridlist;
		$data['level'] = $this->merchants->getgradename();
		$data["lablelist"] = $this->merchants->getMerchantslables();
		$this->display("merchants/merchants_add", $data);
	}
	
		/**
     * 商家添加页
     */
    public function merchants_save()
    {
        if (empty($_SESSION['user_name'])) {
            echo json_encode(array('error' => false, 'msg' => "无法添加数据"));
            return;
        }

        $mename = isset($_POST["mename"]) ? $_POST["mename"] : '';
        $account = isset($_POST["account"]) ? $_POST["account"] : '';
        $password = isset($_POST["password"]) ? $_POST["password"] : '';
		$password = md5($password);
		
		$contactname = isset($_POST["contactname"]) ? $_POST["contactname"] : '';
        $metel = isset($_POST["metel"]) ? $_POST["metel"] : '';
        $lid = isset($_POST["lid"]) ? $_POST["lid"] : '';
        $merchants_state = isset($_POST["merchants_state"]) ? $_POST["merchants_state"] : 1;
        
		$laid = isset($_POST["laid"]) ? $_POST["laid"] : '';
		$laid =implode($laid,",");
        $morder = isset($_POST["morder"]) ? $_POST["morder"] : 100;
        $zhibiaoliang = isset($_POST["zhibiaoliang"]) ? $_POST["zhibiaoliang"] : 100;
        
        $add_time = time();
        $user_info = $this->merchants->getmerchantsname($mename);
        if (!empty($user_info)) {
            echo json_encode(array('error' => true, 'msg' => "该商户名已经存在。"));
            return;
        }
        $result = $this->merchants->merchants_save($mename,$account,$password,$contactname,$metel,$lid,$laid,$merchants_state,$add_time,$morder,$zhibiaoliang);
		//$result = $this->merchants->merchants_addsave($mename);
        if ($result) {
            echo json_encode(array('success' => true, 'msg' => "操作成功。"));
        } else {
            echo json_encode(array('error' => false, 'msg' => "操作失败"));
        }
    }

	/**
	 * 管理员删除
	 */
	public function merchants_delete()
	{
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		if ($this->merchants->merchants_delete($id)) {
			echo json_encode(array('success' => true, 'msg' => "删除成功"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "删除失败"));
		}
	}
	
		/**
	 * 管理员修改
	 */
	public function merchants_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->merchants->getRole();
		$data['ridlist'] = $ridlist;

		$member_info = $this->merchants->getmerchantslist($uid);
		
		$data['nickname'] = $member_info['nickname'];
		$data['me_wallet'] = $member_info['me_wallet'];
		$data['account'] = $member_info['account'];
		
		$data['password'] = $member_info['password'];
		$data['meaddress'] = $member_info['meaddress'];
		$data['mename'] = $member_info['mename'];
		
		$data['metel'] = $member_info['metel'];		
		$data['is_business'] = $member_info['is_business'];
		$data['contactname'] = $member_info['contactname'];		
		
		$data['lid'] = $member_info['lid'];
		$data['laid'] = explode(",",$member_info['laid']);
		$data['merchants_state'] = $member_info['merchants_state'];
		
		$data['morder'] = $member_info['morder'];
		$data['zhibiaoliang'] = $member_info['mubiaoliang'];
		
		$data['meimg'] = $member_info['meimg'];
		$data['merchantsid'] = $uid;

		$data['level'] = $this->merchants->getgradename();
		$data["lablelist"] = $this->merchants->getMerchantslables();
		$this->display("merchants/merchants_edit", $data);
	}

	/**
	 * 商家修改提交
	 */
	public function merchants_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}
		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$mename = isset($_POST["mename"]) ? $_POST["mename"] : '';
		$mename1 = isset($_POST["mename1"]) ? $_POST["mename1"] : '';
		$account = isset($_POST["account"]) ? $_POST["account"] : '';
		$password = !empty($_POST["password"]) ? md5($_POST["password"]) : $_POST["pwsd"];
		$contactname = isset($_POST["contactname"]) ? $_POST["contactname"] : '';
		$metel = isset($_POST["metel"]) ? $_POST["metel"] : '';
		$lid = isset($_POST["lid"]) ? $_POST["lid"] : '';

		$laid = isset($_POST["laid"]) ? $_POST["laid"] : '';
		$laid =implode($laid,",");
		
		$morder = isset($_POST["morder"]) ? $_POST["morder"] : 100;
        $zhibiaoliang = isset($_POST["zhibiaoliang"]) ? $_POST["zhibiaoliang"] : 100;

		$merchants_state = isset($_POST["merchants_state"]) ? $_POST["merchants_state"] : '1';

		if($mename1<>$mename){
			$user_info = $this->merchants->getmerchantsname($mename);
			if (!empty($user_info)) {
				echo json_encode(array('error' => true, 'msg' => "该商户名已经存在。"));
				return;
			}
		}
		$result = $this->merchants->merchants_save_edit($uid, $mename, $account, $password, $contactname,$metel,$lid,$laid,$merchants_state,$morder,$zhibiaoliang);
		//$result = $this->merchants->merchants_save_edit($uid,$mename,$laid);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}

	/**-----------------------------------商家体现管理-----------------------------------------------------*/
	/**
	 * 商家提现申请
	 */
	public function withdrawal_list()
	{
		$user_name = isset($_GET['user_name']) ? $_GET['user_name'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->merchants->getMerchantsAllPage($user_name);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->merchants->getWithdrawalAll($page, $user_name);
		$data["user_name1"] = $user_name;
		$this->display("merchants/withdrawal_list", $data);
	}

	/**
	 * 商家提现完成
	 */
	public function withdrawal_delete()
	{
		$id = $_POST['id'];
		$state = $_POST['state'];
		$time = time();
		if($state==0){
			$state=1;
		}else{
			$state=0;
		}

		if ($this->merchants->withdrawal_delete($id,$state)) {
			echo json_encode(array('success' => true, 'msg' => "提现完成"));
		} else {
			echo json_encode(array('success' => false, 'msg' => "提现错误"));
		}
	}

}
