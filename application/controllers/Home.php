<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index(){
    //首页
	$this->load->model('WeTrueConfig');
	$Configdata = $this->WeTrueConfig->WETConfig();
	$this->load->view('header',$Configdata);
	$this->load->view('index');
	}

    public function Content(){
    //首页内容
        $pageNum = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
        $sort = $this->input->get_post('sort');

        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
            $this->load->model('Contents'); 
            $data = $this->Contents->GetContent($pageNum,$pageLimit,$sort);
            echo $data;
        }else{
            echo "NULL";
        }
    }

}
