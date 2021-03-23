<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends CI_Controller {

	public function index(){
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('FAQ/Cost');
		$this->output->cache(10080);
	}

	public function Cost(){
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('FAQ/Cost');
		$this->output->cache(10080);
	}

	public function Help0(){
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('FAQ/Help_0');
		$this->output->cache(10080);
	}

	public function Help1(){
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('FAQ/Help_1');
		$this->output->cache(10080);
	}

	public function Help2(){
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('FAQ/Help_2');
		$this->output->cache(10080);
	}

	public function Help3(){
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('FAQ/Help_3');
	}

	public function UpdateLog(){
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('FAQ/UpdateLog');
	}

	public function AlmostReadyToGo(){
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('FAQ/AlmostReadyToGo');
		$this->output->cache(10080);
	}

}