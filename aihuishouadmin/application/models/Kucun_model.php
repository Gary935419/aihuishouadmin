<?php


class Orders_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->date = time();
		$this->load->database();
	}

	//----------------------------未完成订单列表-------------------------------------

	//获取订单页数
	public function getOrdersAllPage($user_name,$ostate)
	{
		$sqlw = " where ostate=$ostate ";
		if (!empty($user_name)) {
			$sqlw .= " and ( qs_name like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `orders` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取订单信息
	public function getOrdersAll($pg, $user_name,$ostate)
	{
		$sqlw = " where ostate=$ostate ";
		if (!empty($user_name)) {
			$sqlw .= " and ( qs_name like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `orders` " . $sqlw . " order by addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//获取订单货物信息
	public function getOrdersgoods($oid)
	{
		$sqlw = " where oid=$oid ";
		$sql = "SELECT * FROM `orders_goods` " . $sqlw;
		return $this->db->query($sql)->result_array();
	}



	//根据账号
	public function getOrdersmename($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT mename FROM `merchants` where meid = $id ";
		return $this->db->query($sql)->row_array();
	}

	//会員delete
	public function orders_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM orders WHERE qs_id = $id";
		return $this->db->query($sql);
	}

	//获取信息列表
	public function getRole()
	{
		$sql = "SELECT * FROM `role` order by rid desc";
		return $this->db->query($sql)->result_array();
	}

	//----------------------------修改订单详情-------------------------------------

	//根据id获取订单信息
	public function getorderslist($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `orders_goods` where oid=$id";
		return $this->db->query($sql)->result_array();
	}

	//会員users_save_edit
	public function orders_save_edit($uid,$qsname,$account,$password,$qstel,$meids,$state)
	{
		$uid = $this->db->escape($uid);
		$qsname = $this->db->escape($qsname);
		$account = $this->db->escape($account);
		$password = $this->db->escape($password);
		$qstel = $this->db->escape($qstel);
		$meids = $this->db->escape($meids);
		$state = $this->db->escape($state);

		$sql = "UPDATE `orders` SET qs_name=$qsname,qs_account=$account,qs_password=$password,qs_tel=$qstel,qs_meids=$meids,qs_state=$state WHERE qs_id = $uid";
		return $this->db->query($sql);
	}

}



