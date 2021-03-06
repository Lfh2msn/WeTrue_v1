<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends CI_Controller {

	public function index(){
	//创建助记词页面
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('Create');
	}

}