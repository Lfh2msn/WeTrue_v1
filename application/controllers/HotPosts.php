<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HotPosts extends CI_Controller {

	public function index(){
    //首页
	$this->load->model('WeTrueConfig');
	$Configdata = $this->WeTrueConfig->WETConfig();
	$this->load->view('header',$Configdata);
	$this->load->view('HotPosts');
	}

    public function Content(){
    //首页内容
        $pageNum = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');

        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
            $this->load->model('HotPost'); 
            $data = $this->HotPost->GetHotPosts($pageNum,$pageLimit);
            echo $data;
        }else{
            echo "NULL";
        }
    }

}
