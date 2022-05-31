<?php


class Seting_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->date = time();
        $this->load->database();
    }

    //查询信息
    public function getSetingAll()
    {
        $sqlw = " where 1=1 ";
        $sql = "SELECT * FROM `seting` " . $sqlw;
		return $this->db->query($sql)->row_array();
    }
 
    //角色save_edit
    public function seting_save_edit($uid,$name,$tel,$aboutus,$recruiting,$jianyi,$beizhu,$tishi)
    {
        $uid = $this->db->escape($uid);
        $name = $this->db->escape($name);
        $tel = $this->db->escape($tel);
        $aboutus = $this->db->escape($aboutus);
        $recruiting = $this->db->escape($recruiting);
        
        $jianyi = $this->db->escape($jianyi);
        $beizhu = $this->db->escape($beizhu);
        $tishi = $this->db->escape($tishi);

        $sql = "UPDATE `seting` SET name=$name,customer_tel=$tel,aboutus=$aboutus,recruiting=$recruiting,jianyi=$jianyi,beizhu=$beizhu,tishi=$tishi WHERE sid = $uid";
        return $this->db->query($sql);
    }
}
