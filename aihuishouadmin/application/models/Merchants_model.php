<?php


class Merchants_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->date = time();
        $this->load->database();
    }
	
	//----------------------------商家列表-------------------------------------
	
	//获取商家页数
	public function getMerchantsAllPage($user_name)
	{
		$sqlw = " where 1=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( mename like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `merchants` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取商家信息
	public function getMerchantsAll($pg, $user_name)
	{
		$sqlw = " where merchants_stop=0 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( mename like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `merchants` " . $sqlw . " order by meid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	
	    //会員delete
    public function merchants_delete($id)
    {
        $id = $this->db->escape($id);
		$sql = "UPDATE `merchants` SET `merchants_stop` =  1 WHERE meid = $id";
        return $this->db->query($sql);
    }
	
	//----------------------------添加商家-------------------------------------
	
	    //根据账号
    public function getmerchantsname($user_name)
    {
        $user_name = $this->db->escape($user_name);
        $sql = "SELECT * FROM `merchants` where mename = $user_name ";
        return $this->db->query($sql)->row_array();
    }

    //会員save
    public function merchants_save($mename,$account,$password,$contactname,$metel,$lid,$merchants_state,$add_time)
	//public function merchants_addsave($mename)
    {
	    $mename = $this->db->escape($mename);
        $password = $this->db->escape($password);
		$account = $this->db->escape($account);
        $contactname = $this->db->escape($contactname);
        $metel = $this->db->escape($metel);
        $lid = $this->db->escape($lid);
        $merchants_state = $this->db->escape($merchants_state);
        $add_time = $this->db->escape($add_time);

        $sql = "INSERT INTO `merchants` (mename,account,password,contactname,metel,lid,merchants_state,add_time,merchants_stop) VALUES ($mename,$account,$password,$contactname,$metel,$lid,$merchants_state,$add_time,0)";
        return $this->db->query($sql);
    }

	//----------------------------查看商家详情-------------------------------------
	
	    //根据id获取商家信息
    public function getmerchantslist($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM `merchants` where meid=$id ";
        return $this->db->query($sql)->row_array();
    }

	//会員users_save_edit
	public function merchants_save_edit($uid, $mename, $account, $password, $contactname,$metel,$lid,$laid,$merchants_state)
	//public function merchants_save_edit($uid, $mename,$laid)
	{
		$uid = $this->db->escape($uid);
		$mename = $this->db->escape($mename);
		$account = $this->db->escape($account);
		$password = $this->db->escape($password);
		$contactname = $this->db->escape($contactname);
		$metel = $this->db->escape($metel);
		$lid = $this->db->escape($lid);
		$laid = $this->db->escape($laid);
		$merchants_state = $this->db->escape($merchants_state);

		$sql = "UPDATE `merchants` SET mename=$mename,account=$account,password=$password,contactname=$contactname,metel=$metel,lid=$lid,laid=$laid,merchants_state=$merchants_state WHERE meid = $uid";

		//$sql = "UPDATE `merchants` SET mename=$mename,laid=$laid WHERE meid = $uid";
		return $this->db->query($sql);
	}

	//获取商家标签
	public function getMerchantslables()
	{
		$sql = "SELECT * FROM `lable` where 1=1 ";
		return $this->db->query($sql)->result_array();
	}

    //登录账号密码验证
    public function isPass($name, $pwd)
    {

        $name = $this->db->escape($name);
        $pwd = md5($pwd);
        $sql = "SELECT * FROM `admin_user` WHERE username= $name AND userpwd = '$pwd' ";

        $rest = $this->db->query($sql);

        if ($rest->num_rows() > 0) {
            return $this->db->query($sql)->row_array();
        } else {
            return false;
        }
    }
    //查询一条用户信息
    public function getUserById($user_name, $passold)
    {
        $user_name = $this->db->escape($user_name);
        $passold = $this->db->escape($passold);
        $sql = "SELECT * FROM `admin_user` where username=$user_name and userpwd = md5($passold)";
        return $this->db->query($sql)->row_array();
    }
    //根据user_id获取用户是否注册
    public function getUserByUserId($uid)
    {
        $uid = $this->db->escape($uid);
        $sql = "SELECT * FROM `admin_user` where id=$uid";
        return $this->db->query($sql)->row_array();
    }
    //修改密码保存
    public function userpassportsave($user_name, $pass)
    {
        if (!empty($user_name)) {
            $user_name = $this->db->escape($user_name);
            $upass = md5($pass);
            $upass = $this->db->escape($upass);
            $sql = "UPDATE `admin_user` SET `userpwd` =  $upass WHERE username = $user_name";
            return $this->db->query($sql);
        }
    }
    //会员录入
    public function usersave($user_name, $user_pass, $user_state, $rid)
    {
        $user_name = $this->db->escape($user_name);
        $user_pass = $this->db->escape($user_pass);
        $user_state = $this->db->escape($user_state);
        $rid = $this->db->escape($rid);
        $add_time = time();
        $sql = "INSERT INTO `admin_user` (username,userpwd,user_state,rid,add_time) VALUES ($user_name,$user_pass,$user_state,$rid,$add_time);";
        return $this->db->query($sql);
    }
    //获取管理员信息
    public function getUserAllPage($user_name)
    {
        $sqlw = " where 1=1 ";
        if (!empty($user_name)) {
            $sqlw .= " and ( username like '%" . $user_name . "%' ) ";
        }
        $sql = "SELECT count(1) as number FROM `admin_user` " . $sqlw;
        $number = $this->db->query($sql)->row()->number;
        return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
    }
    //获取管理员信息
    public function getUserAll($pg, $user_name)
    {
        $sqlw = " where 1=1 ";
        if (!empty($user_name)) {
            $sqlw .= " and ( u.username like '%" . $user_name . "%' ) ";
        }
        $start = ($pg - 1) * 10;
        $stop = 10;
        $sql = "SELECT u.*,r.rname as rname FROM `admin_user` u left join `role` r on u.rid=r.rid " . $sqlw . " order by u.id desc LIMIT $start, $stop";
        return $this->db->query($sql)->result_array();
    }
    //获取角色列表
    public function getRole()
    {
        $sql = "SELECT * FROM `role` order by rid desc";
        return $this->db->query($sql)->result_array();
    }
    //根据账号
    public function getmemberById($user_name)
    {
        $user_name = $this->db->escape($user_name);
        $sql = "SELECT * FROM `admin_user` where username = $user_name ";
        return $this->db->query($sql)->row_array();
    }
    //根据账号和id
    public function getmemberById2($user_name,$uid)
    {
		$user_name = $this->db->escape($user_name);
        $uid = $this->db->escape($uid);
        $sql = "SELECT * FROM `admin_user` where username = $user_name and id !=$uid";
        return $this->db->query($sql)->row_array();
    }
    //根据id
    public function getUserByIdnew($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM `admin_user` where id=$id ";
        return $this->db->query($sql)->row_array();
    }
    //会員save
    public function member_save($user_name, $user_pass, $rid, $user_state, $add_time,$pwd)
    {
        $user_name = $this->db->escape($user_name);
        $user_pass = $this->db->escape($user_pass);
        $rid = $this->db->escape($rid);
        $user_state = $this->db->escape($user_state);
        $add_time = $this->db->escape($add_time);
		$pwd = $this->db->escape($pwd);
        $sql = "INSERT INTO `admin_user` (username,userpwd,rid,user_state,add_time,pwd) VALUES ($user_name,$user_pass,$rid,$user_state,$add_time,$pwd)";
        return $this->db->query($sql);
    }
    //会員delete
    public function users_delete($id)
    {
        $id = $this->db->escape($id);
        $sql = "DELETE FROM admin_user WHERE id = $id";
        return $this->db->query($sql);
    }
    //会員users_save_edit
    public function users_save_edit($uid, $user_name, $user_pass, $rid, $user_state)
    {
        $uid = $this->db->escape($uid);
        $user_name = $this->db->escape($user_name);
        $user_pass = $this->db->escape($user_pass);
        $rid = $this->db->escape($rid);
        $user_state = $this->db->escape($user_state);

        $sql = "UPDATE `admin_user` SET username=$user_name,userpwd=$user_pass,rid=$rid,user_state=$user_state WHERE id = $uid";
        return $this->db->query($sql);
    }


	//----------------------------商家提现列表-------------------------------------

	//获取商家页数
	public function getWithdrawalAllPage($user_name,$state,$date)
	{
		$sqlw = " where state=0";
		if (!empty($user_name)) {
			$sqlw .= " and ( mename like '%" . $user_name . "%' ) ";
		}
		if (!empty($state)) {
			$sqlw .= " and ( state like '%" . $state . "%' ) ";
		}

		$sql = "FROM `withdrawal` as a,`merchants` as b " . $sqlw . " and a.meid=b.meid";
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取商家信息
	public function getWithdrawalAll($pg, $user_name)
	{
		$sqlw = " where state=0";
		if (!empty($user_name)) {
			$sqlw .= " and ( mename like '%" . $user_name . "%' ) ";
		}
		if (!empty($state)) {
			$sqlw .= " and ( state like '%" . $state . "%' ) ";
		}

		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT wid,money,bankname,bankcard,username,state,addtime,a.meid,mename FROM `withdrawal` as a,`merchants` as b " . $sqlw . " and a.meid=b.meid order by addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//打款完成
	public function withdrawal_delete($id,$state)
	{
		$time = time();
		$id = $this->db->escape($id);
		$state = $this->db->escape($state);
		$sql = "UPDATE `withdrawal` SET state =  $state,updatetime=$time WHERE wid = $id";
		return $this->db->query($sql);
	}
}
