<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ContAll extends CI_Controller {

	public function index(){
	//最新回复页
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('Admin/header',$Configdata);
		$this->load->model('Admin/A_ManualIn');
		$data = $this->A_ManualIn->TP_Content();
		$this->load->view('Admin/ManualInContent',$data);
	}

    public function InContent($hash){
    //手动主帖写入
    	$this->load->model('Judge');
		$Jhash=$this->Judge->hashAndID($hash);
        $this->load->model('Admin/A_ManualIn');
        $data = $this->A_ManualIn->InJContent($Jhash);
        $this->load->view('null',$data,true);
    }
}
