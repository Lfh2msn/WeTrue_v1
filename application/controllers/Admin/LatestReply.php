<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LatestReply extends CI_Controller {

	public function index(){
	//最新回复页
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('Admin/header',$Configdata);
		$this->load->view('Admin/LatestReply');
	}

    public function Content(){
    //最新回复内容
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
