<?php


class Proclass_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->date = time();
		$this->load->database();
	}

	//----------------------------一级分类list列表-------------------------------------

	//获取标签页数
	public function getProclass1AllPage($user_name)
	{
		$sqlw = " where 1=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( co_name like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `class_one` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取标签信息
	public function getProclass1All($pg, $user_name)
	{
		$sqlw = " where 1=1";
		if (!empty($user_name)) {
			$sqlw .= " and ( co_name like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `class_one` " . $sqlw . " order by co_id desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//标签delete
	public function proclass1_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM class_one WHERE co_id = $id";
		return $this->db->query($sql);
	}

	//----------------------------一级分类add添加-------------------------------------

	//判断是否有重复信息
	public function getprocalss1name($user_name)
	{
		$user_name = $this->db->escape($user_name);
		$sql = "SELECT * FROM `class_one` where co_name = $user_name ";
		return $this->db->query($sql)->row_array();
	}

	//标签save
	public function proclass1_save($name,$state,$pic,$time)
	{
		$name = $this->db->escape($name);
		$state = $this->db->escape($state);
		$pic = $this->db->escape($pic);
		$time = $this->db->escape($time);

		$sql = "INSERT INTO `class_one` (co_name,co_state,co_img,co_addtime) VALUES ($name,$state,$pic,$time)";
		return $this->db->query($sql);
	}

	//----------------------------一级edit更新-------------------------------------

	//根据id获取标签信息
	public function getproclass1list($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `class_one` where co_id=$id ";
		return $this->db->query($sql)->row_array();
	}

	//标签更新
	public function proclass1_save_edit($uid, $name,$state,$pic)
	{
		$uid = $this->db->escape($uid);
		$name = $this->db->escape($name);
		$state = $this->db->escape($state);
		$pic = $this->db->escape($pic);

		$sql = "UPDATE `class_one` SET co_name=$name,co_state=$state,co_img=$pic WHERE co_id = $uid";
		return $this->db->query($sql);
	}

	//根据账号
	public function getproclass1ById($user_name)
	{
		$user_name = $this->db->escape($user_name);
		$sql = "SELECT * FROM `class_one` where co_name = $user_name ";
		return $this->db->query($sql)->row_array();
	}



	//----------------------------二级分类list列表-------------------------------------

	//获取标签页数
	public function getProclass2AllPage($user_name)
	{
		$sqlw = " where 1=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( ct_name like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `class_two` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取标签信息
	public function getProclass2All($pg, $user_name)
	{
		$sqlw = " where 1=1";
		if (!empty($user_name)) {
			$sqlw .= " and ( ct_name like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `class_two` as a,`class_one` as b " . $sqlw . " and a.co_id=b.co_id order by ct_id desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}

	//标签delete
	public function proclass2_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM class_two WHERE ct_id = $id";
		return $this->db->query($sql);
	}

	//----------------------------二级分类add添加-----------s--------------------------

	//获取一级分类信息
	public function getproclass1s()
	{
		$sql = "SELECT * FROM `class_one`";
		return $this->db->query($sql)->result_array();
	}


	//判断是否有重复信息
	public function getprocalss2name($user_name)
	{
		$user_name = $this->db->escape($user_name);
		$sql = "SELECT * FROM `class_two` where ct_name = $user_name ";
		return $this->db->query($sql)->row_array();
	}

	//标签save
	public function proclass2_save($coid,$name,$state,$pic,$price,$time,$danwei,$title)

	{
		$coid = $this->db->escape($coid);
		$name = $this->db->escape($name);
		$state = $this->db->escape($state);
		$pic = $this->db->escape($pic);
		$price = $this->db->escape($price);
		$time = $this->db->escape($time);
		$danwei = $this->db->escape($danwei);
		$title = $this->db->escape($title);

		$sql = "INSERT INTO `class_two` (ct_name,ct_state,ct_img,ct_price,ct_addtime,co_id,ct_danwei,ct_title) VALUES ($name,$state,$pic,$price,$time,$coid,$danwei,$title)";
		return $this->db->query($sql);
	}

	//----------------------------二级edit更新-------------------------------------

	//根据id获取标签信息
	public function getproclass2list($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `class_two` where ct_id=$id ";
		return $this->db->query($sql)->row_array();
	}

	//标签更新
	public function proclass2_save_edit($coid,$uid,$name,$state,$pic,$price,$danwei,$title)
	{
		$coid = $this->db->escape($coid);
		$uid = $this->db->escape($uid);
		$name = $this->db->escape($name);
		$state = $this->db->escape($state);
		$pic = $this->db->escape($pic);
		$price = $this->db->escape($price);
		$danwei = $this->db->escape($danwei);
		$title = $this->db->escape($title);

		$sql = "UPDATE `class_two` SET ct_name=$name,ct_state=$state,ct_img=$pic,ct_price=$price,co_id=$coid,ct_danwei=$danwei,ct_title=$title WHERE ct_id = $uid";
		return $this->db->query($sql);
	}

	//根据账号
	public function getproclass2ById($user_name)
	{
		$user_name = $this->db->escape($user_name);
		$sql = "SELECT * FROM `class_two` where ct_name = $user_name ";
		return $this->db->query($sql)->row_array();
	}

	//获取角色列表
	public function getRole()
	{
		$sql = "SELECT * FROM `role` order by rid desc";
		return $this->db->query($sql)->result_array();
	}

}
