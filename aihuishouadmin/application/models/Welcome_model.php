<?php


class Welcome_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->date = time();
        $this->load->database();
    }
	
	//----------------------------商家列表-------------------------------------
	
	//获取用户数
	public function getyonghunum()
	{
		$sqlw = " where 1=1 ";
		$sql = "SELECT count(1) as number FROM `member` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	
	//获取商家数
	public function getshangjianum()
	{
		$sqlw = " where 1=1 ";
		$sql = "SELECT count(1) as number FROM `merchants` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}

	//获取骑手数
	public function getqishounum()
	{
		$sqlw = " where 1=1 ";
		$sql = "SELECT count(1) as number FROM `qishou` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	

		//获取用户数
	public function getdingdannum()
	{
		$sqlw = " where date(delivery_date)=CURDATE() ";
		$sql = "SELECT count(1) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	

	//获取商家数
	public function getquhuonum()
	{
		$sqlw = " where date(delivery_date)=CURDATE() ";
		$sql = "SELECT count(distinct mid) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}

	//获取骑手数
	public function getzhongliangnum()
	{
		$sqlw = " where date(datetime)=CURDATE() ";
		$sql = "SELECT sum(m_weight) as number FROM `orders_merchants` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}

	//获取骑手数
	public function getzongnum()
	{
		$sqlw = "where 1=1";
		$sql = "SELECT count(1) as number FROM `orders` " . $sqlw;
		$number = $this->db->query($sql)->row()->number;
		return $number;
	}
	
}
