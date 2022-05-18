<?php


class Mini_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->date = time();
        $this->load->database();
    }
	public function getsettinginfo()
	{
		$sql = "SELECT * FROM `seting` where sid = 1 ";
		return $this->db->query($sql)->row_array();
	}
	//根据token查看详情
	public function getMemberInfotoken($token)
	{
		$token = $this->db->escape($token);
		$sql = "SELECT * FROM `member` where token = $token ";
		return $this->db->query($sql)->row_array();
	}
	public function getMemberInfomid($mid)
	{
		$mid = $this->db->escape($mid);
		$sql = "SELECT * FROM `member` where mid = $mid ";
		return $this->db->query($sql)->row_array();
	}
	public function getmerchantsInfomeid($token)
	{
		$token = $this->db->escape($token);
		$sql = "SELECT * FROM `merchants` where token = $token ";
		return $this->db->query($sql)->row_array();
	}
	public function getqishouInfomeid($token)
	{
		$token = $this->db->escape($token);
		$sql = "SELECT * FROM `qishou` where qs_token = $token ";
		return $this->db->query($sql)->row_array();
	}
	public function getmerchantsInfomeidnew($meid)
	{
		$meid = $this->db->escape($meid);
		$sql = "SELECT * FROM `merchants` where meid = $meid ";
		return $this->db->query($sql)->row_array();
	}

	public function getsettingone()
	{
		$sql = "SELECT * FROM `seting` where sid = 1 ";
		return $this->db->query($sql)->row_array();
	}

	public function getaddressInfoaid($a_id)
	{
		$a_id = $this->db->escape($a_id);
		$sql = "SELECT * FROM `address` where a_id = $a_id ";
		return $this->db->query($sql)->row_array();
	}
	public function getaddressInfoaidmoren($mid)
	{
		$mid = $this->db->escape($mid);
		$sql = "SELECT * FROM `address` where mid = $mid and status=1";
		return $this->db->query($sql)->row_array();
	}
	//根据token查看详情
	public function getMerchantsInfotoken($token)
	{
		$token = $this->db->escape($token);
		$sql = "SELECT * FROM `merchants` where token = $token ";
		return $this->db->query($sql)->row_array();
	}
	public function getMerchantsInfotorder($uname,$utel)
	{
		$uname = $this->db->escape($uname);
		$utel = $this->db->escape($utel);
		$sql = "SELECT * FROM `address` where mobile=$utel and name=$uname ";
		return $this->db->query($sql)->row_array();
	}
	public function getMerchantsInfotmeid($meid)
	{
		$meid = $this->db->escape($meid);
		$sql = "SELECT * FROM `merchants` where meid=$meid ";
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

		$start = ($pg - 1) * 200;
		$stop = 200;

		$sql = "SELECT m.* FROM `class_one` m " . $sqlw . " LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	public function getclassonetypeAll($pg)
	{
		$sqlw = " where 1=1 and co_state=1 or co_state=2 ";

		$start = ($pg - 1) * 200;
		$stop = 200;

		$sql = "SELECT * FROM `class_one` " . $sqlw . " LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	public function getclasstwotypeAll($co_id)
	{
		$sqlw = " where 1=1 and co_id = $co_id";
		$sql = "SELECT * FROM `class_two` " . $sqlw;
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
		$meid = $this->db->escape($meid);
		$sqlw = " where 1=1 ";
		$sqlw .= " and meid = " . $meid;

		$start = ($pg - 1) * 20;
		$stop = 20;

		$sql = "SELECT * FROM `orders`" . $sqlw . " order by addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	public function getmemberaddressAll($pg,$mid)
	{
		$mid = $this->db->escape($mid);
		$sqlw = " where 1=1 ";
		$sqlw .= " and mid = " . $mid;

		$start = ($pg - 1) * 200;
		$stop = 200;

		$sql = "SELECT * FROM `address`" . $sqlw . " order by addtime desc LIMIT $start, $stop";

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

	public function qishounew_del($ordernumber)
	{
		$ordernumber = $this->db->escape($ordernumber);
		$sql = "DELETE FROM orders_qishou WHERE ordernumber = $ordernumber";
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
	public function getqioshou($account,$password)
	{
		$account = $this->db->escape($account);
		$password = $this->db->escape($password);
		$sql = "SELECT * FROM `qishou` where qs_account = $account and qs_password = $password";
		return $this->db->query($sql)->row_array();
	}
	public function getmerchantsInfo($openid)
	{
		$openid = $this->db->escape($openid);
		$sql = "SELECT * FROM `merchants` where openid = $openid ";
		return $this->db->query($sql)->row_array();
	}
	public function getqishouInfo($openid)
	{
		$openid = $this->db->escape($openid);
		$sql = "SELECT * FROM `qishou` where qs_openid = $openid ";
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
	public function qishou_edit($qs_id,$token,$avater,$nickname,$openid)
	{
		$qs_id = $this->db->escape($qs_id);
		$token = $this->db->escape($token);
		$avater = $this->db->escape($avater);
		$nickname = $this->db->escape($nickname);
		$openid = $this->db->escape($openid);
		$sql = "UPDATE `qishou` SET qs_token=$token,qs_avater=$avater,qs_nickname=$nickname,qs_openid=$openid WHERE qs_id = $qs_id";
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
	public function member_edit_wallet($mid,$wallet)
	{
		$mid = $this->db->escape($mid);
		$wallet = $this->db->escape($wallet);
		$sql = "UPDATE `member` SET wallet=$wallet WHERE mid = $mid";
		return $this->db->query($sql);
	}
	public function member_edit_wallet_me($meid,$membernewmoney)
	{
		$meid = $this->db->escape($meid);
		$membernewmoney = $this->db->escape($membernewmoney);
		$sql = "UPDATE `merchants` SET me_wallet=$membernewmoney WHERE meid = $meid";
		return $this->db->query($sql);
	}
	public function register($birthday,$wallet,$status,$token,$openid,$nickname,$avater,$add_time)
	{
		$birthday = $this->db->escape($birthday);
		$wallet = $this->db->escape($wallet);
		$status = $this->db->escape($status);
		$token = $this->db->escape($token);
		$openid = $this->db->escape($openid);
		$nickname = $this->db->escape($nickname);
		$avater = $this->db->escape($avater);
		$add_time = $this->db->escape($add_time);
		$sql = "INSERT INTO `member` (birthday,sex,getpro,wallet,status,token,openid,nickname,avater,add_time) VALUES ($birthday,0,0,$wallet,$status,$token,$openid,$nickname,$avater,$add_time)";
		return $this->db->query($sql);
	}
	public function getordersstatecishu($meid,$ostate)
	{
		$meid = $this->db->escape($meid);
//		$ostate = $this->db->escape($ostate);
//		$sqlw = " where ostate = " . $ostate;
//		$sqlw .= " and meid = " . $meid;

		$sqlw = " where meid = " . $meid;
		$sql = "SELECT count(1) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}

	public function getordersstate123($meid,$delivery_date)
	{
		$meid = $this->db->escape($meid);
		$delivery_date = $this->db->escape($delivery_date);
		$sqlw = " where delivery_date = " . $delivery_date;
		$sqlw .= " and meid = " . $meid;
		$sql = "SELECT count(1) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
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
//		$sqlw = " where 1=1 and ostate = 2 ";
		$sqlw = " where 1=1 ";
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
		$sqlw = " where 2 = 2 ";
//		$sqlw = " where ostate = 2 ";
		$sqlw .= " and mid = " . $mid;
		$sql = "SELECT sum(sum_price) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	public function getordersstatejine_merchants($meid)
	{
		$meid = $this->db->escape($meid);
//		$sqlw = " where ostate = 2 ";
		$sqlw = " where meid = " . $meid;
		$sql = "SELECT sum(sum_price) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	public function getordersstatetixian_merchants($meid)
	{
		$meid = $this->db->escape($meid);
		$sqlw = " where state = 1 ";
		$sqlw .= " and meid = " . $meid;
		$sql = "SELECT sum(money) as number FROM `withdrawal` " . $sqlw;
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
	public function getnoticeAllnew()
	{
		$sql = "SELECT * FROM `notice` order by n_addtime desc";
		return $this->db->query($sql)->result_array();
	}
	public function getbannerAll()
	{
		$sql = "SELECT * FROM `banners` order by addtime desc";
		return $this->db->query($sql)->result_array();
	}
	public function member_address_status_save($mid)
	{
		$mid = $this->db->escape($mid);
		$sql = "UPDATE `address` SET status=0 WHERE mid = $mid";
		return $this->db->query($sql);
	}

	public function getmerchantslist($pg,$testinfo)
	{
		$sqlw = " and 1=1 ";
		if (!empty($testinfo)) {
			$sqlw .= " and ( mename like '%" . $testinfo . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `merchants` where is_business = 1 and merchants_state = 0 " . $sqlw . " order by add_time desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	public function getmerchantslistseach($pg,$testinfo)
	{
		$sqlw = " and 1=1 ";
		if (!empty($testinfo)) {
			$sqlw .= " and ( mename like '%" . $testinfo . "%' ) ";
		}
		$start = ($pg - 1) * 1000;
		$stop = 1000;
		$sql = "SELECT * FROM `merchants` where is_business = 1 and merchants_state = 0 " . $sqlw . " order by add_time desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	public function getmerchantslistlable($laidarr)
	{
		$sql = "SELECT * FROM `lable` where laid IN $laidarr";
		return $this->db->query($sql)->result_array();
	}
	public function getmerchantslistclasstwo($str)
	{
		$sql = "SELECT * FROM `class_two` where ct_id IN $str";
		return $this->db->query($sql)->result_array();
	}

	public function order_save($order_status,$ostate,$addtime,$sum_price,$note,$delivery_date,$delivery_time,$uname,$utel,$muser,$maddress,$mid,$meid,$otype)
	{
		$ostate = $this->db->escape($ostate);
		$addtime = $this->db->escape($addtime);
		$sum_price = $this->db->escape($sum_price);
		$note = $this->db->escape($note);
		$delivery_date = $this->db->escape($delivery_date);
		$delivery_time = $this->db->escape($delivery_time);
		$uname = $this->db->escape($uname);
		$utel = $this->db->escape($utel);
		$muser = $this->db->escape($muser);
		$maddress = $this->db->escape($maddress);
		$mid = $this->db->escape($mid);
		$meid = $this->db->escape($meid);
		$otype = $this->db->escape($otype);
		$order_status = $this->db->escape($order_status);
		$sql = "INSERT INTO `orders` (order_status,ostate,addtime,sum_price,note,delivery_date,delivery_time,uname,utel,muser,maddress,mid,meid,otype) VALUES ($order_status,$ostate,$addtime,$sum_price,$note,$delivery_date,$delivery_time,$uname,$utel,$muser,$maddress,$mid,$meid,$otype)";
		$this->db->query($sql);
		$oid=$this->db->insert_id();
		return $oid;
	}

	public function order_goods_save($oid,$ct_name,$ct_id,$ct_img,$ct_price,$og_price,$weight)
	{
		$oid = $this->db->escape($oid);
		$ct_name = $this->db->escape($ct_name);
		$ct_id = $this->db->escape($ct_id);
		$ct_img = $this->db->escape($ct_img);
		$ct_price = $this->db->escape($ct_price);
		$og_price = $this->db->escape($og_price);
		$weight = $this->db->escape($weight);

		$sql = "INSERT INTO `orders_goods` (oid,ct_name,ct_id,ct_img,ct_price,og_price,weight) VALUES ($oid,$ct_name,$ct_id,$ct_img,$ct_price,$og_price,$weight)";
		$this->db->query($sql);
		$oid=$this->db->insert_id();
		return $oid;
	}

	public function merchants_editnew($meid,$is_business,$meaddress,$latitude,$longitude,$contactname,$metel,$mename,$meimg)
	{
		$meid = $this->db->escape($meid);
		$is_business = $this->db->escape($is_business);
		$meaddress = $this->db->escape($meaddress);
		$latitude = $this->db->escape($latitude);
		$longitude = $this->db->escape($longitude);
		$contactname = $this->db->escape($contactname);
		$metel = $this->db->escape($metel);
		$mename = $this->db->escape($mename);
		$meimg = $this->db->escape($meimg);
		$sql = "UPDATE `merchants` SET is_business=$is_business,meaddress=$meaddress,latitude=$latitude,longitude=$longitude,contactname=$contactname,metel=$metel,mename=$mename,meimg=$meimg WHERE meid = $meid";
		return $this->db->query($sql);
	}

	public function order_withdrawal_save($meid,$addtime,$state,$bankname,$username,$bankcard,$money)
	{
		$meid = $this->db->escape($meid);
		$addtime = $this->db->escape($addtime);
		$state = $this->db->escape($state);
		$bankname = $this->db->escape($bankname);
		$username = $this->db->escape($username);
		$bankcard = $this->db->escape($bankcard);
		$money = $this->db->escape($money);

		$sql = "INSERT INTO `withdrawal` (meid,addtime,state,bankname,username,bankcard,money) VALUES ($meid,$addtime,$state,$bankname,$username,$bankcard,$money)";
		$this->db->query($sql);
		$oid=$this->db->insert_id();
		return $oid;
	}

	public function merchants_edit_me_wallet($meid,$me_wallet)
	{
		$meid = $this->db->escape($meid);
		$me_wallet = $this->db->escape($me_wallet);
		$sql = "UPDATE `merchants` SET me_wallet=$me_wallet WHERE meid = $meid";
		return $this->db->query($sql);
	}

	public function merchantslist($meid,$pg)
	{
		$meid = $this->db->escape($meid);
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `withdrawal` where meid = $meid order by addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	public function merchantsorderlistgoods($meid,$pg,$datenew)
	{
		$sqlw = " and 1=1 ";
		if (!empty($datenew)) {
			$datenew = $this->db->escape($datenew);
			$sqlw .= " and datetime = " . $datenew;
		}
		$meid = $this->db->escape($meid);
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `orders_merchants` where meid = $meid ".$sqlw." order by addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	public function merchantsorderlist($meid,$pg,$datenew)
	{
		$sqlw = " and 1=1 ";
		if (!empty($datenew)) {
			$datenew = $this->db->escape($datenew);
			$sqlw .= " and delivery_date = " . $datenew;
		}
		$meid = $this->db->escape($meid);
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `orders` where meid = $meid ".$sqlw." order by addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	public function qishouorderlist($meid,$datetime,$pg)
	{
		$sqlw = " and 1=1 ";
		if (!empty($datetime)) {
			$datetime = $this->db->escape($datetime);
			$sqlw .= " and datetime = " . $datetime;
		}
		$meid = $this->db->escape($meid);
		$start = ($pg - 1) * 1000;
		$stop = 1000;
		$sql = "SELECT * FROM `orders_merchants` where meid = $meid ".$sqlw." order by addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	public function qishouorderlist1($meid,$datetime,$pg)
	{
		$sqlw = " and 1=1 ";
		if (!empty($datetime)) {
			$datetime = $this->db->escape($datetime);
			$sqlw .= " and datetime = " . $datetime;
		}
		$meid = $this->db->escape($meid);
		$start = ($pg - 1) * 1000;
		$stop = 1000;
		$sql = "SELECT * FROM `orders_merchants` where meid = $meid ".$sqlw." group by meid ";

		return $this->db->query($sql)->result_array();
	}
	public function merchantsordergoodslist($pg,$oid)
	{
		$sqlw = " 1=1 ";
		if (!empty($oid)) {
			$oid = $this->db->escape($oid);
			$sqlw .= " and oid =" . $oid;
		}
		$start = ($pg - 1) * 1000;
		$stop = 1000;
		$sql = "SELECT * FROM `orders_goods` where  ".$sqlw." order by ogid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	public function merchantsordergoodslistnewonw($pg,$omid)
	{
		$sqlw = " 1=1 ";
		if (!empty($omid)) {
			$omid = $this->db->escape($omid);
			$sqlw .= " and omid =" . $omid;
		}
		$start = ($pg - 1) * 1000;
		$stop = 1000;
		$sql = "SELECT * FROM `orders_merchants` where  ".$sqlw." order by omid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	public function getordergoodsinfo($ogid)
	{
		$ogid = $this->db->escape($ogid);
		$sql = "SELECT * FROM `orders_goods` where ogid = $ogid ";
		return $this->db->query($sql)->row_array();
	}

	public function ordergoodsupdate($ogid,$weight,$og_price)
	{
		$ogid = $this->db->escape($ogid);
		$weight = $this->db->escape($weight);
		$og_price = $this->db->escape($og_price);
		$sql = "UPDATE `orders_goods` SET weight=$weight,og_price=$og_price WHERE ogid = $ogid";
		return $this->db->query($sql);
	}

	public function ordergoodsupdatesum($oid,$sum_price)
	{
		$oid = $this->db->escape($oid);
		$sum_price = $this->db->escape($sum_price);;
		$sql = "UPDATE `orders` SET sum_price=$sum_price,ostate=1 WHERE oid = $oid";
		return $this->db->query($sql);
	}

	public function merchantsordergoodslistnew2($omid,$omtype,$q_weight,$qs_id,$ordernumber)
	{
		$omid = $this->db->escape($omid);
		$omtype = $this->db->escape($omtype);
		$q_weight = $this->db->escape($q_weight);
		$qs_id = $this->db->escape($qs_id);
		$ordernumber = $this->db->escape($ordernumber);
		$sql = "UPDATE `orders_merchants` SET omtype=$omtype,q_weight=$q_weight,qs_id=$qs_id,ordernumber=$ordernumber WHERE omid = $omid";
		return $this->db->query($sql);
	}


	public function merchantsordergoodslistnew1($omid)
	{
		$sqlw = " 1=1 ";
		if (!empty($omid)) {
			$omid = $this->db->escape($omid);
			$sqlw .= " and omid =" . $omid;
		}
		$sql = "SELECT * FROM `orders_merchants` where  ".$sqlw." order by omid desc ";
		return $this->db->query($sql)->result_array();
	}

	public function merchantsordergoodslistnew($oid)
	{
		$sqlw = " 1=1 ";
		if (!empty($oid)) {
			$oid = $this->db->escape($oid);
			$sqlw .= " and oid =" . $oid;
		}
		$sql = "SELECT * FROM `orders_goods` where  ".$sqlw." order by ogid desc ";
		return $this->db->query($sql)->result_array();
	}

	public function getordergoodsone($ct_id,$oid)
	{
		$ct_id = $this->db->escape($ct_id);
		$oid = $this->db->escape($oid);
		$sql = "SELECT * FROM `orders_goods` where ct_id = $ct_id and oid = $oid";
		return $this->db->query($sql)->row_array();
	}
	public function getindexnewlist()
	{
		$sqlw = " where 1=1";
		$sql = "SELECT * FROM `news` " . $sqlw . " order by addtime desc";
		return $this->db->query($sql)->result_array();
	}
	public function goodsdetails($gid)
	{
		$gid = $this->db->escape($gid);
		$sql = "SELECT * FROM `news` where nid=$gid ";
		return $this->db->query($sql)->row_array();
	}
	public function getorderone($oid)
	{
		$oid = $this->db->escape($oid);
		$sql = "SELECT * FROM `orders` where oid = $oid";
		return $this->db->query($sql)->row_array();
	}
	public function getorders_merchants($ct_id,$meid,$datetime)
	{
		$ct_id = $this->db->escape($ct_id);
		$meid = $this->db->escape($meid);
		$datetime = $this->db->escape($datetime);
		$sql = "SELECT * FROM `orders_merchants` where ct_id = $ct_id and omtype = 0 and meid = $meid and datetime = $datetime";
		return $this->db->query($sql)->row_array();
	}

	public function getorders_merchants_save($omtype,$meid,$mename,$ct_id,$ct_name,$m_weight,$q_weight,$price,$addtime,$datetime)
	{
		$omtype = $this->db->escape($omtype);
		$meid = $this->db->escape($meid);
		$mename = $this->db->escape($mename);
		$ct_id = $this->db->escape($ct_id);
		$ct_name = $this->db->escape($ct_name);
		$m_weight = $this->db->escape($m_weight);
		$q_weight = $this->db->escape($q_weight);
		$price = $this->db->escape($price);
		$addtime = $this->db->escape($addtime);
		$datetime = $this->db->escape($datetime);

		$sql = "INSERT INTO `orders_merchants` (omtype,meid,mename,ct_id,ct_name,m_weight,q_weight,price,addtime,datetime) VALUES ($omtype,$meid,$mename,$ct_id,$ct_name,$m_weight,$q_weight,$price,$addtime,$datetime)";
		$this->db->query($sql);
		$omid=$this->db->insert_id();
		return $omid;
	}

	public function getorders_merchants_save_new($qsid,$qstype,$desc,$addtime,$number,$meid,$mename,$ordernumber)
	{
		$qsid = $this->db->escape($qsid);
		$qstype = $this->db->escape($qstype);
		$desc = $this->db->escape($desc);
		$addtime = $this->db->escape($addtime);
		$number = $this->db->escape($number);
		$meid = $this->db->escape($meid);
		$mename = $this->db->escape($mename);
		$ordernumber = $this->db->escape($ordernumber);

		$sql = "INSERT INTO `orders_qishou` (qsid,qstype,remarks,addtime,grade,meid,mename,ordernumber) VALUES ($qsid,$qstype,$desc,$addtime,$number,$meid,$mename,$ordernumber)";
		$this->db->query($sql);
		$id=$this->db->insert_id();
		return $id;
	}

	public function getorders_merchants_edit($ct_id,$meid,$datetime,$m_weightnew)
	{
		$ct_id = $this->db->escape($ct_id);
		$meid = $this->db->escape($meid);
		$datetime = $this->db->escape($datetime);
		$m_weightnew = $this->db->escape($m_weightnew);
		$sql = "UPDATE `orders_merchants` SET m_weight=$m_weightnew WHERE ct_id = $ct_id and meid = $meid and datetime = $datetime";
		return $this->db->query($sql);
	}

	public function opinion_goods_save($mid,$op_contents,$addtime)
	{
		$mid = $this->db->escape($mid);
		$op_contents = $this->db->escape($op_contents);
		$addtime = $this->db->escape($addtime);
		$sql = "INSERT INTO `opinion` (mid,op_contents,addtime) VALUES ($mid,$op_contents,$addtime)";
		$this->db->query($sql);
		$opid=$this->db->insert_id();
		return $opid;
	}

	public function merchandise_fullflg_update($meid)
	{
		$meid = $this->db->escape($meid);
		$sql = "UPDATE `merchants` SET full_flg=1 WHERE meid = $meid";
		return $this->db->query($sql);
	}

	public function goods_edit_order_me_ostate($meid,$datetime)
	{
		$meid = $this->db->escape($meid);
		$datetime = $this->db->escape($datetime);
		$sql = "UPDATE `orders` SET ostate=2 WHERE meid = $meid and $datetime = $datetime";
		return $this->db->query($sql);
	}
}
