<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Airdrop extends CI_Controller {
	
	public function index(){
	//空投首页
		$this->load->model('WeTrueConfig');
		$Configdata = $this->WeTrueConfig->WETConfig();
		$this->load->view('Admin/header',$Configdata);
		$this->load->view('Admin/airdrop');
	}

	public function ActivateAirdrop($e=''){
	//获取空投列表
		$adminId = $this->input->get_post('adminId');
		$this->load->model('Admin/AdminConfig');
		$judgeAdmin = $this->AdminConfig->Manage($adminId);
		if($judgeAdmin == "ok"){
			$this->load->model('Admin/A_Airdrop');
			$this->A_Airdrop->UpdateLastActive($e);
		} else {
			echo "非法操作，IP已记录";
		}
	}
}
