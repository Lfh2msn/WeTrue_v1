<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index(){
	//登录
		$this->load->model('WeTrueConfig');
		$Configdata = $this->WeTrueConfig->WETConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('Login');
	}

	public function GET(){
	//登录获取昵称、头像
		$ak = trim($this->input->post('publicKey'));
		$this->load->model('Judge');
		$Jhash=$this->Judge->hashAndID($ak);
		$this->load->model('Logins');
		$data=$this->Logins->GetUserData($Jhash);
		echo $data;
    	
	}

}
