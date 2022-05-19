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
	public function getOrdersAllPage($user_name,$ostate,$start,$end)
	{
		$sqlw = " where ostate=$ostate ";
		if (!empty($user_name)) {
			$sqlw .= " and ( uname like '%" . $user_name . "%' ) ";
		}
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
	public function getOrdersAll($pg, $user_name,$ostate,$start,$end)
	{
		$sqlw = " where ostate=$ostate ";
		if (!empty($user_name)) {
			$sqlw .= " and ( uname like '%" . $user_name . "%' ) ";
		}
		if (!empty($start)) {
			$sqlw .= " and addtime>=$start";
		}
		if (!empty($end)) {
			$sqlw .= " and addtime<=$end";
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

	//----------------------------查看订单详情-------------------------------------

	//根据id获取收货商家信息
	public function getmerchants($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `orders` where oid=$id";
		return $this->db->query($sql)->result_array();
	}


	//根据id获取订单信息
	public function getorderslist($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `orders_goods` where oid=$id";
		return $this->db->query($sql)->result_array();
	}

	//----------------------------获取商家订单列表-------------------------------------

	//获取订单页数
	public function getMerchantsOrderAllPage($meid,$start,$end)
	{
		$sqlw = " where meid=$meid";
		if (!empty($start)) {
			$sqlw .= " and addtime>=$start";
		}
		if (!empty($end)) {
			$sqlw .= " and addtime<=$end";
		}
		$sql = "SELECT count(1) as number FROM `orders_merchants` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取订单信息
	public function getMerchantsOrdersAll($pg, $meid,$start,$end)
	{
		$sqlw = " where meid=$meid ";
		if (!empty($start)) {
			$sqlw .= " and addtime>=$start";
		}
		if (!empty($end)) {
			$sqlw .= " and addtime<=$end";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `orders_merchants` " . $sqlw . " order by addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//获取订单货物信息
	public function getmerchantsname()
	{
		$sql = "SELECT * FROM `merchants` ";
		return $this->db->query($sql)->result_array();
	}


	//----------------------------获取骑手订单列表-------------------------------------

	//获取订单页数
	public function getQishouOrderAllPage($qsid,$start,$end)
	{
		$sqlw = " where qsid=$qsid";
		if (!empty($start)) {
			$sqlw .= " and addtime>=$start";
		}
		if (!empty($end)) {
			$sqlw .= " and addtime<=$end";
		}
		$sql = "SELECT count(1) as number FROM `orders_qishou` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取司机订单信息
	public function getQishouOrdersAll($pg, $qsid,$start,$end)
	{
		$sqlw = " where qsid=$qsid ";
		if (!empty($start)) {
			$sqlw .= " and addtime>=$start";
		}
		if (!empty($end)) {
			$sqlw .= " and addtime<=$end";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `orders_qishou` " . $sqlw . " order by addtime desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//获取司机信息
	public function getqishouname()
	{
		$sql = "SELECT * FROM `qishou` ";
		return $this->db->query($sql)->result_array();
	}

	//修改商品入库
	public function orderqishou_edit($id)
	{
		$id = $this->db->escape($id);
		$sql = "UPDATE `orders_qishou` SET qstype=2 WHERE ordernumber = $id";
		return $this->db->query($sql);
	}

	//查询商家订单表
	public function getOrderMerchantsAll($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `orders_merchants` where ordernumber=$id";
		return $this->db->query($sql)->result_array();
	}

	//查询库存表
	public function getStockAll($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT id FROM `stock` where ct_id=$id";
		return $this->db->query($sql)->row_array();
	}

	//修改商品入库
	public function stock_edit($stockid,$value)
	{
		$id = $this->db->escape($stockid);
		$list = $this->db->escape($value);
		$stockaddnum=$list['q_weight'];
		$sql = "UPDATE `stock` SET stocknum=stocknum+$stockaddnum,stockaddnum=$stockaddnum,stockover=stockover+$stockaddnum WHERE ct_id = $id";
		return $this->db->query($sql);
	}

	//修改商品入库
	public function stock_add($id,$value)
	{
		$list = $this->db->escape($value);
		$ctid=$list['ct_id'];
		$ctname=$list['ct_name'];
		$stocknum=$list['q_weight'];
		$stockaddnum=$list['q_weight'];
		$stockoutnum=0;
		$sql = "INSERT INTO `stock` (ct_id,ct_name,stocknum,stockaddnum,stockoutnum) VALUES ($ctid,$ctname,$stocknum,$stockaddnum,$stockoutnum)";
		return $this->db->query($sql);
	}


}



