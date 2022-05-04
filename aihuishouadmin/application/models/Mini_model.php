<?php


class Mini_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->date = time();
        $this->load->database();
    }
	//根据token查看详情
	public function getMemberInfotoken($token)
	{
		$token = $this->db->escape($token);
		$sql = "SELECT * FROM `member` where token = $token ";
		return $this->db->query($sql)->row_array();
	}
	//根据token查看详情
	public function getMerchantsInfotoken($token)
	{
		$token = $this->db->escape($token);
		$sql = "SELECT * FROM `merchants` where token = $token ";
		return $this->db->query($sql)->row_array();
	}
	public function getnewsAll($pg)
	{
		$sqlw = " where 1=1 ";

		$start = ($pg - 1) * 20;
		$stop = 20;

		$sql = "SELECT m.* FROM `news` m " . $sqlw . " order by m.addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	public function getnoticeAll($pg)
	{
		$sqlw = " where 1=1 ";

		$start = ($pg - 1) * 20;
		$stop = 20;

		$sql = "SELECT m.* FROM `notice` m " . $sqlw . " order by m.n_addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	public function getclassoneAll($pg)
	{
		$sqlw = " where 1=1 ";

		$start = ($pg - 1) * 20;
		$stop = 20;

		$sql = "SELECT m.* FROM `class_one` m " . $sqlw . " order by m.co_addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	public function getclasstwoAll($pg,$co_id)
	{
		$sqlw = " where 1=1 ";

		if (!empty($co_id)) {
			$co_id = $this->db->escape($co_id);
			$sqlw .= " and (co_id = " . $co_id . ")";
		}

		$start = ($pg - 1) * 20;
		$stop = 20;

		$sql = "SELECT m.* FROM `class_two` m " . $sqlw . " order by m.ct_addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	public function getordersmemberAll($pg,$mid)
	{
		$sqlw = " where 1=1 ";

		if (!empty($mid)) {
			$mid = $this->db->escape($mid);
			$sqlw .= " and (m.mid = " . $mid . ")";
		}

		$start = ($pg - 1) * 20;
		$stop = 20;

		$sql = "SELECT m.* FROM `orders` m " . $sqlw . " order by m.addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	public function getordersmembergoodsAll($oid)
	{
		$sqlw = " where 1=1 ";

		if (!empty($oid)) {
			$oid = $this->db->escape($oid);
			$sqlw .= " and (m.oid = " . $oid . ")";
		}

		$sql = "SELECT m.* FROM `orders_goods` m " . $sqlw;
		return $this->db->query($sql)->result_array();
	}

	public function getordersmerchantsAll($pg,$meid)
	{
		$sqlw = " where 1=1 ";

		if (!empty($meid)) {
			$meid = $this->db->escape($meid);
			$sqlw .= " and (m.meid = " . $meid . ")";
		}

		$start = ($pg - 1) * 20;
		$stop = 20;

		$sql = "SELECT m.* FROM `orders` m " . $sqlw . " order by m.addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	public function getmemberaddressAll($pg)
	{
		$sqlw = " where 1=1 ";

		if (!empty($mid)) {
			$mid = $this->db->escape($mid);
			$sqlw .= " and (m.mid = " . $mid . ")";
		}

		$start = ($pg - 1) * 20;
		$stop = 20;

		$sql = "SELECT m.* FROM `address` m " . $sqlw . " order by m.addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	public function member_address_add_save($mid,$longitude,$latitude,$province,$city,$area,$address,$name,$mobile,$status,$addtime)
	{
		$mid = $this->db->escape($mid);
		$longitude = $this->db->escape($longitude);
		$latitude = $this->db->escape($latitude);
		$province = $this->db->escape($province);
		$city = $this->db->escape($city);
		$area = $this->db->escape($area);
		$address = $this->db->escape($address);
		$name = $this->db->escape($name);
		$mobile = $this->db->escape($mobile);
		$status = $this->db->escape($status);
		$addtime = $this->db->escape($addtime);
		$sql = "INSERT INTO `address` (mid,longitude,latitude,province,city,area,address,name,mobile,status,addtime) VALUES ($mid,$longitude,$latitude,$province,$city,$area,$address,$name,$mobile,$status,$addtime)";
		return $this->db->query($sql);
	}

	public function member_address_del($mid,$a_id)
	{
		$mid = $this->db->escape($mid);
		$a_id = $this->db->escape($a_id);
		$sql = "DELETE FROM address WHERE mid = $mid and a_id = $a_id";
		return $this->db->query($sql);
	}

	public function member_address_detail($mid,$a_id)
	{
		$mid = $this->db->escape($mid);
		$a_id = $this->db->escape($a_id);
		$sql = "SELECT * FROM `address` where a_id = $a_id and mid = $mid";
		return $this->db->query($sql)->row_array();
	}

	public function getmerchants($account,$password)
	{
		$account = $this->db->escape($account);
		$password = $this->db->escape($password);
		$sql = "SELECT * FROM `merchants` where account = $account and password = $password";
		return $this->db->query($sql)->row_array();
	}

	public function getmerchantsInfo($openid)
	{
		$openid = $this->db->escape($openid);
		$sql = "SELECT * FROM `merchants` where openid = $openid ";
		return $this->db->query($sql)->row_array();
	}

	public function merchants_edit($meid,$token,$avater,$nickname,$openid)
	{
		$meid = $this->db->escape($meid);
		$token = $this->db->escape($token);
		$avater = $this->db->escape($avater);
		$nickname = $this->db->escape($nickname);
		$openid = $this->db->escape($openid);
		$sql = "UPDATE `merchants` SET token=$token,avater=$avater,nickname=$nickname,openid=$openid WHERE meid = $meid";
		return $this->db->query($sql);
	}
	public function getMemberInfo($openid)
	{
		$openid = $this->db->escape($openid);
		$sql = "SELECT * FROM `member` where openid = $openid ";
		return $this->db->query($sql)->row_array();
	}
	public function member_edit($mid, $token)
	{
		$mid = $this->db->escape($mid);
		$token = $this->db->escape($token);
		$sql = "UPDATE `member` SET token=$token WHERE mid = $mid";
		return $this->db->query($sql);
	}
	public function register($wallet,$status,$token,$openid,$nickname,$avater,$add_time)
	{
		$wallet = $this->db->escape($wallet);
		$status = $this->db->escape($status);
		$token = $this->db->escape($token);
		$openid = $this->db->escape($openid);
		$nickname = $this->db->escape($nickname);
		$avater = $this->db->escape($avater);
		$add_time = $this->db->escape($add_time);
		$sql = "INSERT INTO `member` (wallet,status,token,openid,nickname,avater,add_time) VALUES ($wallet,$status,$token,$openid,$nickname,$avater,$add_time)";
		return $this->db->query($sql);
	}
	public function getordersstate($mid,$ostate)
	{
		$mid = $this->db->escape($mid);
		$ostate = $this->db->escape($ostate);
		$sqlw = " where ostate = " . $ostate;
		$sqlw .= " and mid = " . $mid;
		$sql = "SELECT count(1) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	public function getordersstatecanyu($mid)
	{
		$mid = $this->db->escape($mid);
		$sqlw = " where mid = " . $mid;
		$sql = "SELECT count(1) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	public function getordersstateshangpin($mid)
	{
		$sqlw = " where 1=1 and ostate = 2 ";
		if (!empty($mid)) {
			$mid = $this->db->escape($mid);
			$sqlw .= " and (m.mid = " . $mid . ")";
		}
		$sql = "SELECT m.* FROM `orders` m " . $sqlw . " order by m.addtime desc ";
		return $this->db->query($sql)->result_array();
	}
	public function getordersstateshangpin1($oid)
	{
		$oid = $this->db->escape($oid);
		$sqlw = " where oid = " . $oid;
		$sql = "SELECT count(1) as number FROM `orders_goods` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	public function getordersstatejine($mid)
	{
		$mid = $this->db->escape($mid);
		$sqlw = " where ostate = 2 ";
		$sqlw .= " and mid = " . $mid;
		$sql = "SELECT sum(sum_price) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	public function memberinfo_edit($mid,$sex,$truename,$email,$mobile,$birthday)
	{
		$mid = $this->db->escape($mid);
		$sex = $this->db->escape($sex);
		$truename = $this->db->escape($truename);
		$email = $this->db->escape($email);
		$mobile = $this->db->escape($mobile);
		$birthday = $this->db->escape($birthday);
		$sql = "UPDATE `member` SET sex=$sex,truename=$truename,email=$email,mobile=$mobile,birthday=$birthday WHERE mid = $mid";
		return $this->db->query($sql);
	}

	public function getorderlist($mid,$pg,$ostate)
	{
		$mid = $this->db->escape($mid);
		$start = ($pg - 1) * 10;
		$stop = 10;
		if ($ostate == 999){
			$sql = "SELECT * FROM `orders` where mid = $mid order by addtime desc LIMIT $start, $stop";
		}elseif ($ostate == 1){
			$sql = "SELECT * FROM `orders` where mid = $mid and ostate = 0 order by addtime desc LIMIT $start, $stop";
		}elseif ($ostate == 2){
			$sql = "SELECT * FROM `orders` where mid = $mid and ostate = 1 order by addtime desc LIMIT $start, $stop";
		}elseif ($ostate == 3){
			$sql = "SELECT * FROM `orders` where mid = $mid and ostate = 2 order by addtime desc LIMIT $start, $stop";
		}elseif ($ostate == 4){
			$sql = "SELECT * FROM `orders` where mid = $mid and ostate = 3 order by addtime desc LIMIT $start, $stop";
		}else{
			$sql = "SELECT * FROM `orders` where mid = $mid order by addtime desc LIMIT $start, $stop";
		}
		return $this->db->query($sql)->result_array();
	}

	public function getorderdetails($oid)
	{
		$oid = $this->db->escape($oid);
		$sql = "SELECT * FROM `orders_goods` where oid = $oid";
		return $this->db->query($sql)->result_array();
	}

	public function orderostate_edit($mid,$oid)
	{
		$mid = $this->db->escape($mid);
		$oid = $this->db->escape($oid);
		$sql = "UPDATE `orders` SET ostate = 3 WHERE mid = $mid and oid = $oid";
		return $this->db->query($sql);
	}

	public function getbannerAll()
	{
		$sql = "SELECT * FROM `banners` order by addtime desc";
		return $this->db->query($sql)->result_array();
	}
}
