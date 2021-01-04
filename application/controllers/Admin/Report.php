<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {


	public function index(){
	$this->load->model('WeTrueConfig');
	$Configdata = $this->WeTrueConfig->WETConfig();
	$this->load->view('Admin/header',$Configdata);
	$this->load->view('Admin/index');
	}

	public function Manage(){
	$this->load->model('WeTrueConfig');
	$Configdata = $this->WeTrueConfig->WETConfig();
	$this->load->view('Admin/header',$Configdata);
	$this->load->view('Admin/Report');
	}

	//获取举报帖
	public function GetReport(){
		$pageNum = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
            $this->load->model('Admin/A_Report'); 
            $data = $this->A_Report->Rp_Content($pageNum,$pageLimit);
            echo $data;
        }else{
            echo "NULL";
        }
	}


	//管理员屏蔽
	public function Admin_Report(){
		$rp_hash	  = $this->input->get_post('rp_hash');
		$rp_sender_id = $this->input->get_post('rp_sender_id');
		$informant	  = $this->input->get_post('informant');
		$this->load->model('Judge');
		$Jhash=$this->Judge->hashAndID($rp_hash);
		$Jsender_id=$this->Judge->hashAndID($rp_sender_id);
		$Jinformant=$this->Judge->hashAndID($informant);
		$this->load->model('Admin/AdminConfig');
		$JudgeID	  = $this->AdminConfig->Manage($Jinformant);
		if($JudgeID=="ok"){
			$this->load->model('Admin/A_Report');
			$this->A_Report->RpTx($Jhash,$Jsender_id,$Jinformant);
		}else{
			echo "非法操作，IP已记录";
		}
	}

	//管理员取消屏蔽
	public function Admin_UnReport(){
		$rp_hash	  = $this->input->get_post('rp_hash');
		$rp_sender_id = $this->input->get_post('rp_sender_id');
		$informant	  = $this->input->get_post('informant');
		$this->load->model('Judge');
		$Jhash=$this->Judge->hashAndID($rp_hash);
		$Jsender_id=$this->Judge->hashAndID($rp_sender_id);
		$Jinformant=$this->Judge->hashAndID($informant);
		$this->load->model('Admin/AdminConfig');
		$JudgeID	  = $this->AdminConfig->Manage($Jinformant);
		if($JudgeID=="ok"){
			$this->load->model('Admin/A_Report');
			$this->A_Report->UnRpTx($Jhash,$Jsender_id,$Jinformant);
		}else{
			echo "非法操作，IP已记录";
		}
	}

	//已屏蔽页面
	public function Bloom(){
	$this->load->model('WeTrueConfig');
	$Configdata = $this->WeTrueConfig->WETConfig();
	$this->load->view('Admin/header',$Configdata);
	$this->load->view('Admin/Report_Bloom');
	}

	//获取已屏蔽帖
	public function GetBloom(){
		$pageNum = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
            $this->load->model('Admin/A_Report'); 
            $data = $this->A_Report->Rp_Bloom($pageNum,$pageLimit);
            echo $data;
        }else{
            echo "NULL";
        }
	}
}
