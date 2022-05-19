<?php


class Stock_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->date = time();
		$this->load->database();
	}

	//获取信息列表
	public function getRole()
	{
		$sql = "SELECT * FROM `role` order by rid desc";
		return $this->db->query($sql)->result_array();
	}
	//----------------------------信息列表-------------------------------------

	//获取信息页数
	public function getStockAllPage($ctid)
	{
		$sqlw = " where 1=1 ";
		if (!empty($ctid)) {
			$sqlw .= " and ct_id=$ctid ";
		}
		$sql = "SELECT count(1) as number FROM `stock` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取信息
	public function getStockAll($pg, $ctid)
	{
		$sqlw = " where 1=1 ";
		if (!empty($ctid)) {
			$sqlw .= " and ct_id=$ctid ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `stock` " . $sqlw . " order by id desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//获取商品分类
	public function getctname()
	{
		$sql = "SELECT * FROM `class_two`";
		return $this->db->query($sql)->result_array();
	}

	//----------------------------修改信息详情-------------------------------------

	//根据id获取信息信息
	public function getStocklist($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `stock` where id=$id ";
		return $this->db->query($sql)->row_array();
	}

	//stock_save_edit
	public function stock_save_edit($uid,$ctid,$ctname,$stocknum,$outnum,$addtime)
	{
		$uid = $this->db->escape($uid);
		$ctid = $this->db->escape($ctid);
		$ctname = $this->db->escape($ctname);
		$outnum = $this->db->escape($outnum);
		$stocknum = $this->db->escape($stocknum);
		$addtime=$this->db->escape($addtime);

		$sql = "UPDATE `stock` SET stockoutnum=stockoutnum+$outnum,stocknum=$stocknum WHERE id = $uid";
		$this->db->query($sql);

		$sqlstr="INSERT INTO `stock_order` (ct_id,ct_name,stockoutnum,stockover,addtime) VALUES ($ctid,$ctname,$outnum,$stocknum,$addtime)";
		return $this->db->query($sqlstr);

	}

	//----------------------------库存列表-------------------------------------

	//获取库存列表页数
	public function getStockorderAllPage($date,$ctid)
	{
		$sqlw = " where ct_id=$ctid ";
		if (!empty($date)) {
			$sqlw .= " and addtime='".$date."'";
		}
		$sql = "SELECT count(1) as number FROM `stock_order` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取banner图片信息
	public function getStockorderAll($pg, $date,$ctid)
	{
		$sqlw = " where ct_id=$ctid ";
		if (!empty($date)) {
			$sqlw .= " and addtime='".$date."'";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `stock_order` " . $sqlw . " order by id desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
}

