<?php


class Member_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->date = time();
		$this->load->database();
	}

	//----------------------------未完成订单列表-------------------------------------

	//获取订单页数
	public function getMemberAllPage($user_name,$status)
	{
		$sqlw = " where status=$status";
		if (!empty($user_name)) {
			$sqlw .= " and ( truename like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `member` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取订单信息
	public function getMemberAll($pg, $user_name,$status)
	{
		$sqlw = " where status=$status";
		if (!empty($user_name)) {
			$sqlw .= " and ( truename like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `member` " . $sqlw . " order by mid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//获取用户信息
	public function getMemberOrderAll($mid)
	{
		$sql = "SELECT * FROM `orders` where mid=$mid order by mid desc LIMIT 0,1";
		return $this->db->query($sql)->row_array();
	}

	//会員delete
	public function member_delete($id,$status)
	{
		$id = $this->db->escape($id);
		$status = $this->db->escape($status);

		$sql = "UPDATE `member` SET status = $status WHERE mid = $id";
		return $this->db->query($sql);
	}

	//开通上门回收
	public function member_getpro($id,$getpro)
	{
		$id = $this->db->escape($id);
		$getpro = $this->db->escape($getpro);

		$sql = "UPDATE `member` SET getpro = $getpro WHERE mid = $id";
		return $this->db->query($sql);
	}

	//获取信息列表
	public function getRole()
	{
		$sql = "SELECT * FROM `role` order by rid desc";
		return $this->db->query($sql)->result_array();
	}


	//----------------------------地址列表-------------------------------------

	//获取订单页数
	public function getAddressAllPage($user_name)
	{
		$sqlw = " where 1=1";
		if (!empty($user_name)) {
			$sqlw .= " and ( name like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `address` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取订单信息
	public function getAddressAll($pg, $user_name,$uid)
	{
		$sqlw = " where mid=$uid";
		if (!empty($user_name)) {
			$sqlw .= " and ( name like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `address` " . $sqlw . " order by a_id desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}


	//----------------------------个人订单列表-------------------------------------

	//获取订单页数
	public function getUserOrderAllPage($uid,$start,$end)
	{
		$sqlw = " where mid=$uid";
		if (!empty($start)) {
			$sqlw .= " and addtime>=$start";
		}
		if (!empty($end)) {
			$sqlw .= " and addtime<=$end";
		}
		$sql = "SELECT count(1) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取订单信息
	public function getUserOrderAll($pg,$uid,$start,$end)
	{
		$sqlw = " where mid=$uid";
		if (!empty($start)) {
			$sqlw .= " and addtime>=$start";
		}
		if (!empty($end)) {
			$sqlw .= " and addtime<=$end";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `orders` " . $sqlw . " order by oid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//获取订单产品信息
	public function getUserOrderProAll($oid)
	{
		$sqlw = " where oid=$oid";
		$sql = "SELECT * FROM `orders_goods` " . $sqlw . " order by ogid desc";
		return $this->db->query($sql)->result_array();
	}

	//获取商家信息
	public function getMerchantsname($mid)
	{
		$sqlw = " where meid=$mid";
		$sql = "SELECT mename FROM `merchants` " . $sqlw ;
		return $this->db->query($sql)->row_array();
	}
}



