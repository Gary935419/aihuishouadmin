<?php
/**
 * **********************************************************************
 * サブシステム名  ： ADMIN
 * 機能名         ：管理员
 * 作成者        ： Gary
 * **********************************************************************
 */
class Shop extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['user_name'])) {
			header("Location:" . RUN . '/login/logout');
		}
		$this->load->model('Shop_model', 'shop');
		header("Content-type:text/html;charset=utf-8");
	}

	/**-----------------------------------信息管理-----------------------------------------------------*/
	/**
	 * 信息列表页
	 */
	public function shop_list()
	{
		$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m', time());
		//获取所有店铺信息
		$list=array();
		$merchants = $this->shop->getMerchantsAll();
		foreach ($merchants as $key => $value) {
			$meid = $value['meid'];
			$mename = $value['mename'];
			$mubiao = $value['mubiaoliang'];
			$lcontents= $value['lcontents'];

			$arrnumber = $this->shop->getMerchantsorderAll($meid, $month);
			//订单总收入
			$arrmoney = $this->shop->getMerchantsMoneyAll($meid, $month);
			//提现金额
			$arrtixian = $this->shop->getMerchantsTixianAll($meid, $month);
			//订单误差
			$arrwucha = $this->shop->getMerchantsWuchaAll($meid, $month);

			//总下单量
			$dingdanliang = count($arrnumber);
			//总用户量（去掉重复）
			$yonghuliang = count(array_unique(array_column($arrnumber, 'mid')));
			//目标完成比
			if ($mubiao > 0) {
				$mubiaobi = round($yonghuliang / $mubiao, 2);
			}else{
				$mubiaobi =0;
			}
			if ($yonghuliang > 0) {
				//人均下单次数
				$renjunshu = round($dingdanliang / $yonghuliang, 2);
			}else{
				$renjunshu =0;
			}
			//总收入
			$money=$arrmoney['num'];
			if ($dingdanliang > 0) {
				//用户均单价
				$renjunmoney = round($money / $dingdanliang, 2);
			}else{
				$renjunmoney = 0;
			}
			//总分佣金额
			$fandian=$lcontents*$money/100;

			//已提现金额
			if($arrtixian['num']){
				$tixian=$arrtixian['num'];
			}else{
				$tixian=0;
			}

			if($arrwucha['mnum']>0) {
				//订单误差
				$wucha = round(($arrwucha['pnum'] - $arrwucha['mnum']) / $arrwucha['mnum'] * 100,2);
			}else{
				$wucha =0;
			}
			$list[$key]['meid']=$meid;
			$list[$key]['mename']=$mename;
			$list[$key]['time']=$month;
			$list[$key]['yonghuliang']=$yonghuliang;
			$list[$key]['mubiao']=$mubiao;
			$list[$key]['mubiaobi']=$mubiaobi;
			$list[$key]['dingdanliang']=$dingdanliang;
			$list[$key]['renjunshu']=$renjunshu;
			$list[$key]['renjunmoney']=$renjunmoney;
			$list[$key]['fandian']=$fandian;
			$list[$key]['tixian']=$tixian;
			$list[$key]['wucha']=$wucha;
		}
		

		$data['list']=$list;

		$years=date('Y', time());
		$mon=date('Y-m', time());
		for($i=1;$i<13;$i++){
			if($i<10){
				$months="0".$i;
			}else{
				$months=$i;
			}
			$dates[$i-1]=$years."-".$months;
		}
		//print_r($dates);
		$data['dates']=$dates;
		$data['month']=$month;
		$this->display("shop/shop_list", $data);
	}

	/**
	 * 信息修改显示
	 */
	public function shop_edit()
	{
		$uid = isset($_GET['id']) ? $_GET['id'] : 0;
		$data = array();
		$ridlist = $this->shop->getRole();
		$data['ridlist'] = $ridlist;

		$member_info = $this->shop->getshoplist($uid);
		$data['id'] = $uid;
		$data['ctid'] = $member_info['ct_id'];
		$data['ctname'] = $member_info['ct_name'];
		$data['shopnum'] = $member_info['shopnum'];
		$this->display("shop/shop_edit", $data);
	}

	/**
	 * 信息修改提交
	 */
	public function shop_save_edit()
	{
		if (empty($_SESSION['user_name'])) {
			echo json_encode(array('error' => false, 'msg' => "无法修改数据"));
			return;
		}

		$uid = isset($_POST["uid"]) ? $_POST["uid"] : '';
		$ctid = isset($_POST["ctid"]) ? $_POST["ctid"] : '';
		$ctname = isset($_POST["ctname"]) ? $_POST["ctname"] : '';
		$outnum = isset($_POST["outnum"]) ? $_POST["outnum"] : 0;
		$shopnum = $_POST["shopnum"]-$outnum;
		$addtime=date('Y-m-d');

		if ($shopnum<0) {
			echo json_encode(array('error' => true, 'msg' => "出库小于零，请重新输入。"));
			return;
		}

		$result = $this->shop->shop_save_edit($uid,$ctid,$ctname,$shopnum,$outnum,$addtime);
		if ($result) {
			echo json_encode(array('success' => true, 'msg' => "操作成功。"));
		} else {
			echo json_encode(array('error' => false, 'msg' => "操作失败"));
		}
	}


	/**-----------------------------------出库订单详情-----------------------------------------------------*/
	/**
	 * 信息列表页
	 */
	public function shoporder_list()
	{
		$date = isset($_GET['start']) ? $_GET['start'] : '';
		$ctid = isset($_GET['id']) ? $_GET['id'] : '';
		$page = isset($_GET["page"]) ? $_GET["page"] : 1;
		$allpage = $this->shop->getshoporderAllPage($date,$ctid);
		$page = $allpage > $page ? $page : $allpage;
		$data["pagehtml"] = $this->getpage($page, $allpage, $_GET);
		$data["page"] = $page;
		$data["allpage"] = $allpage;
		$data["list"] = $this->shop->getshoporderAll($page,$date,$ctid);

		$data["start"] = $date;
		$data["ctid"] = $ctid;
		$this->display("shop/shoporder_list", $data);
	}



}
