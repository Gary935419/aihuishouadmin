<?php


class Lable_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->date = time();
        $this->load->database();
    }
	
	//----------------------------list列表-------------------------------------
	
	//获取标签页数
	public function getLableAllPage($user_name)
	{
		$sqlw = " where 1=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( ltitle like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `lable` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取标签信息
	public function getLableAll($pg, $user_name)
	{
		$sqlw = " where 1=1";
		if (!empty($user_name)) {
			$sqlw .= " and ( ltitle like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `lable` " . $sqlw . " order by laid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}
	
	    //标签delete
    public function lable_delete($id)
    {
        $id = $this->db->escape($id);
		$sql = "DELETE FROM lable WHERE laid = $id";
        return $this->db->query($sql);
    }
	
	//----------------------------add添加-------------------------------------
	
	    //判断是否有重复信息
    public function getlablename($user_name)
    {
        $user_name = $this->db->escape($user_name);
        $sql = "SELECT * FROM `lable` where ltitle = $user_name ";
        return $this->db->query($sql)->row_array();
    }

    //标签save
    public function lable_save($ltitle)
    {
		$ltitle = $this->db->escape($ltitle);
        $sql = "INSERT INTO `lable` (ltitle) VALUES ($ltitle)";
        return $this->db->query($sql);
    }

	//----------------------------edit更新-------------------------------------
	
	    //根据id获取标签信息
    public function getlablelist($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM `lable` where laid=$id ";
        return $this->db->query($sql)->row_array();
    }

	//标签更新
	public function lable_save_edit($uid, $ltitle)
	{
		$uid = $this->db->escape($uid);
		$ltitle = $this->db->escape($ltitle);

		$sql = "UPDATE `lable` SET ltitle=$ltitle WHERE laid = $uid";
		return $this->db->query($sql);
	}

	//获取角色列表
	public function getRole()
	{
		$sql = "SELECT * FROM `role` order by rid desc";
		return $this->db->query($sql)->result_array();
	}

	//根据账号
	public function getlableById($user_name)
	{
		$user_name = $this->db->escape($user_name);
		$sql = "SELECT * FROM `lable` where ltitle = $user_name ";
		return $this->db->query($sql)->row_array();
	}

}
