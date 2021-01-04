<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NickName extends CI_Controller {

	public function index(){
	//昵称修改首页
		$this->load->model('WeTrueConfig');
		$Configdata = $this->WeTrueConfig->WETConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('NickName');
	}

	
	public function checkName($Name){
	//接收昵称动态校验
		$urlName = urldecode($Name);
		$urlDecodeName = htmlspecialchars($urlName,ENT_QUOTES);
		$this->load->model('NickNames');
		$isExist = $this->NickNames->CheckName($urlDecodeName);
		if($isExist=="YES"){
	    	echo '<font color="green">"'.$urlName.'" ，<span id="regnm">Good</span>可以使用</font>';
	    }else{
	    	echo '<font color="red"> "'.$urlName.'" ，<span id="regnm">ERROR</span>已重复</font>';
	    }
	}
	
	public function insertNickName(){
	//昵称写入
		$hash = $this->input->get_post('hash');
		$this->load->model('Judge');
		$Jhash=$this->Judge->hashAndID($hash);
		$this->load->model('NickNames');
		$data = $this->NickNames->inName($Jhash);
		$this->load->view('null',$data,true);
	}

}