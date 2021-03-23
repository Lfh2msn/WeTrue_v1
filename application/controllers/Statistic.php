<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistic extends CI_Controller {

	public function index(){
    //首页
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('Statistic');
	}

	public function Total(){
    //统计数据
		$this->load->model('Statistics');
		$data = $this->Statistics->Total();
		$this->output->cache(720);
		echo $data;
	}

}
