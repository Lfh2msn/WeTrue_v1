<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portrait extends CI_Controller {

	public function index(){
	//头像修改首页
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('Portrait');
	}


	public function insertPortrait($hash){
	//头像写入
		$this->load->model('Judge');
        $Jhash=$this->Judge->hashAndID($hash);
		$this->load->model('Portraits');
		$data = $this->Portraits->inPortrait($Jhash);
		$this->load->view('null',$data,true);
	}

}