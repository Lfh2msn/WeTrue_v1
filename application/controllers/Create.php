<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Create extends CI_Controller {

	public function index(){

	$this->load->model('WeTrueConfig');
	$Configdata = $this->WeTrueConfig->WETConfig();
	$this->load->view('header',$Configdata);
	$this->load->view('Create');
	}

}