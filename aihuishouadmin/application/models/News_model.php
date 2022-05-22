<?php


class News_model extends CI_Model
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
	public function getNewsAllPage($user_name)
	{
		$sqlw = " where 1=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( ntitle like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `promote` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取信息
	public function getNewsAll($pg, $user_name)
	{
		$sqlw = " where 1=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( ntitle like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `news` " . $sqlw . " order by nid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}


	//信息delete
	public function news_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM news WHERE nid = $id";
		return $this->db->query($sql);
	}

	//----------------------------添加信息------------------------------------

	//判断信息是否重复
	public function getnewsname($user_name)
	{
		$user_name = $this->db->escape($user_name);
		$sql = "SELECT * FROM `news` where ntitle = $user_name ";
		return $this->db->query($sql)->row_array();
	}

	//信息save
	public function news_save($ntitle,$listimg,$contents,$addtime)
	{
		$ntitle = $this->db->escape($ntitle);
		$listimg = $this->db->escape($listimg);
		$contents = $this->db->escape($contents);
		$addtime = $this->db->escape($addtime);

		$sql = "INSERT INTO `news` (ntitle,listimg,contents,addtime) VALUES ($ntitle,$listimg,$contents,$addtime)";
		return $this->db->query($sql);
	}


	//----------------------------修改信息详情-------------------------------------

	//根据id获取信息信息
	public function getnewslist($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `news` where nid=$id ";
		return $this->db->query($sql)->row_array();
	}

	//信息users_save_edit
	public function news_save_edit($uid,$ntitle,$gimg,$gcontent)
	{
		$uid = $this->db->escape($uid);
		$ntitle = $this->db->escape($ntitle);
		$listimg = $this->db->escape($gimg);
		$contents = $this->db->escape($gcontent);

		$sql = "UPDATE `news` SET ntitle=$ntitle,listimg=$listimg,contents=$contents WHERE nid = $uid";
		return $this->db->query($sql);
	}






	//----------------------------banner图片列表-------------------------------------

	//获取banner图片页数
	public function getBannersAllPage($user_name)
	{
		$sqlw = " where type=0 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( bannersname like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `banners` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取banner图片信息
	public function getBannersAll($pg, $user_name)
	{
		$sqlw = " where 1=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( bannersname like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `banners` " . $sqlw . " order by bid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}


	//banner图片delete
	public function banners_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM banners WHERE bid = $id";
		return $this->db->query($sql);
	}

	//----------------------------添加信息------------------------------------

	//判断banner图片是否重复
	public function getbannersname($user_name)
	{
		$user_name = $this->db->escape($user_name);
		$sql = "SELECT * FROM `banners` where bannername = $user_name ";
		return $this->db->query($sql)->row_array();
	}

	//banner图片save
	public function banners_save($bannername,$bannersimg,$addtime)
	{
		$bannername = $this->db->escape($bannername);
		$bannersimg = $this->db->escape($bannersimg);
		$addtime = $this->db->escape($addtime);

		$sql = "INSERT INTO `banners` (bannername,bannerimg,addtime,type) VALUES ($bannername,$bannersimg,$addtime,0)";
		return $this->db->query($sql);
	}


	//----------------------------修改信息详情-------------------------------------

	//根据id获取banner图片信息
	public function getBannerslist($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `banners` where bid=$id ";
		return $this->db->query($sql)->row_array();
	}

	//banner图片users_save_edit
	public function banners_save_edit($uid,$bannername,$bannersimg)
	{
		$uid = $this->db->escape($uid);
		$bannername = $this->db->escape($bannername);
		$bannersimg = $this->db->escape($bannersimg);

		$sql = "UPDATE `banners` SET bannername=$bannername,bannerimg=$bannersimg WHERE bid = $uid";
		return $this->db->query($sql);
	}


	//----------------------------合作企业列表-------------------------------------

	//获取合作图片页数
	public function getHezuoAllPage($user_name)
	{
		$sqlw = " where type=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( bannersname like '%" . $user_name . "%' ) ";
		}
		$sql = "SELECT count(1) as number FROM `banners` " . $sqlw;

		$number = $this->db->query($sql)->row()->number;
		return ceil($number / 10) == 0 ? 1 : ceil($number / 10);
	}

	//获取合作图片信息
	public function gethezuoAll($pg, $user_name)
	{
		$sqlw = " where type=1 ";
		if (!empty($user_name)) {
			$sqlw .= " and ( bannersname like '%" . $user_name . "%' ) ";
		}
		$start = ($pg - 1) * 10;
		$stop = 10;
		$sql = "SELECT * FROM `banners` " . $sqlw . " order by bid desc LIMIT $start, $stop";
		return $this->db->query($sql)->result_array();
	}


	//合作图片delete
	public function hezuo_delete($id)
	{
		$id = $this->db->escape($id);
		$sql = "DELETE FROM banners WHERE bid = $id";
		return $this->db->query($sql);
	}

	//----------------------------添加信息------------------------------------

	//判断合作图片是否重复
	public function gethezuoname($user_name)
	{
		$user_name = $this->db->escape($user_name);
		$sql = "SELECT * FROM `banners` where bannername = $user_name ";
		return $this->db->query($sql)->row_array();
	}

	//合作图片save
	public function hezuo_save($bannername,$bannersimg,$addtime)
	{
		$bannername = $this->db->escape($bannername);
		$bannersimg = $this->db->escape($bannersimg);
		$addtime = $this->db->escape($addtime);

		$sql = "INSERT INTO `banners` (bannername,bannerimg,addtime,type) VALUES ($bannername,$bannersimg,$addtime,1)";
		return $this->db->query($sql);
	}


	//----------------------------修改信息详情-------------------------------------

	//根据id获取合作图片信息
	public function gethezuolist($id)
	{
		$id = $this->db->escape($id);
		$sql = "SELECT * FROM `banners` where bid=$id";
		return $this->db->query($sql)->row_array();
	}

	//hezuo图片users_save_edit
	public function hezuo_save_edit($uid,$bannername,$bannersimg)
	{
		$uid = $this->db->escape($uid);
		$bannername = $this->db->escape($bannername);
		$bannersimg = $this->db->escape($bannersimg);

		$sql = "UPDATE `banners` SET bannername=$bannername,bannerimg=$bannersimg WHERE bid = $uid";
		return $this->db->query($sql);
	}
}

