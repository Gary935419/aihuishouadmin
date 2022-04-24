<?php


class Promote_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->date = time();
        $this->load->database();
    }

	//获取角色列表
	public function getRole()
	{
		$sql = "SELECT * FROM `role` order by rid desc";
		return $this->db->query($sql)->result_array();
	}
	//----------------------------优惠卷列表-------------------------------------
	
	//获取优惠卷页数
	public function getPromoteAllPage($user_name)
	{
		$sqlw = " where 1=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( promote_name like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `promote` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取优惠卷信息
	public function getPromoteAll($pg, $user_name)
	{
		$sqlw = " where 1=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( promote_name like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `promote` " . $sqlw . " order by pid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}


	    //优惠卷delete
    public function promote_delete($id)
    {
        $id = $this->db->escape($id);
		$sql = "DELETE FROM promote WHERE pid = $id";
        return $this->db->query($sql);
    }
	
	//----------------------------添加骑手------------------------------------
	
	    //判断优惠卷账号是否重复
    public function getpromotename($user_name)
    {
        $user_name = $this->db->escape($user_name);
        $sql = "SELECT * FROM `promote` where promote_name = $user_name ";
        return $this->db->query($sql)->row_array();
    }

	//优惠卷save
    public function promote_save($name,$starttime,$endtime,$price,$area,$state,$addtime)
    {
		$name = $this->db->escape($name);
		$starttime = $this->db->escape($starttime);
		$endtime = $this->db->escape($endtime);
		$price = $this->db->escape($price);
		$area = $this->db->escape($area);
		$state = $this->db->escape($state);
		$addtime = $this->db->escape($addtime);

        $sql = "INSERT INTO `promote` (promote_name,promote_starttime,promote_endtime,promote_area,promote_price,promote_state,addtime) VALUES ($name,$starttime,$endtime,$area,$price,$state,$addtime)";
        return $this->db->query($sql);
    }



	//----------------------------修改优惠卷详情-------------------------------------
	
	    //根据id获取优惠卷信息
    public function getpromotelist($id)
    {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM `promote` where pid=$id ";
        return $this->db->query($sql)->row_array();
    }

	//优惠卷users_save_edit
	public function promote_save_edit($uid, $name, $starttime, $endtime,$price,$area,$state)
	{
		$uid = $this->db->escape($uid);
		$name = $this->db->escape($name);
		$starttime = $this->db->escape($starttime);
		$endtime = $this->db->escape($endtime);
		$area = $this->db->escape($area);
		$price = $this->db->escape($price);
		$state = $this->db->escape($state);

		$sql = "UPDATE `promote` SET promote_name=$name,promote_starttime=$starttime,promote_endtime=$endtime,promote_area=$area,promote_price=$price,promote_state=$state WHERE pid = $uid";
		return $this->db->query($sql);
	}

	//----------------------------赠送礼品列表-------------------------------------

	//赠送礼品卷页数
	public function getCoupleAllPage($user_name)
	{
		$sqlw = " where 1=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( couple_goodsname like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `couple` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取赠送礼品信息
	public function getCoupleAll($pg, $user_name)
	{
		$sqlw = " where 1=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( couple_goodsname like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `couple` " . $sqlw . " order by cid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}


	//赠送礼品delete
	public function couple_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM couple WHERE cid = $id";
		return $this->db->query($sql);
	}

	//----------------------------添加礼品------------------------------------

	//判断优惠卷账号是否重复
	public function getcouplename($user_name)
	{
		$user_name = $this->db->escape($user_name);
		$sql = "SELECT * FROM `couple` where couple_goodsname = $user_name ";
		return $this->db->query($sql)->row_array();
	}

	//优惠卷save
	public function couple_save($name,$gimg,$num,$addtime)
	{
		$name = $this->db->escape($name);
		$gimg = $this->db->escape($gimg);
		$num = $this->db->escape($num);
		$addtime = $this->db->escape($addtime);

		$sql = "INSERT INTO `couple` (couple_goodsname,couple_goodsimg,couple_num,addtime) VALUES ($name,$gimg,$num,$addtime)";
		return $this->db->query($sql);
	}

	//----------------------------修改礼品详情-------------------------------------

	//根据id获取优惠卷信息
	public function getcouplelist($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `couple` where cid=$id ";
		return $this->db->query($sql)->row_array();
	}

	//优惠卷users_save_edit
	public function couple_save_edit($uid, $name, $gimg, $num)
	{
		$uid = $this->db->escape($uid);
		$name = $this->db->escape($name);
		$gimg = $this->db->escape($gimg);
		$num = $this->db->escape($num);

		$sql = "UPDATE `couple` SET couple_goodsname=$name,couple_goodsimg=$gimg,couple_num=$num WHERE cid = $uid";
		return $this->db->query($sql);
	}

}
