<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyFollow extends CI_Controller {

	public function index(){
    //关注首页
	$this->load->model('WeTrueConfig');
	$Configdata = $this->WeTrueConfig->WETConfig();
	$this->load->view('header',$Configdata);
	$this->load->view('MyFollow');
	}

    public function Content(){
    //关注内容
        $pageNum = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
        $sendid_id = $this->input->get_post('sendid_id');
        $this->load->model('Judge');
        $Jsendid_id=$this->Judge->hashAndID($sendid_id);
        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
            $this->load->model('MyFollows'); 
            $data = $this->MyFollows->GetPosts($pageNum,$pageLimit,$Jsendid_id);
            echo $data;
        }else{
            echo "NULL";
        }
    }

}