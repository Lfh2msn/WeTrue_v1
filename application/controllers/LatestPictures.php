<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LatestPictures extends CI_Controller {

	public function index(){
	//最新图片页
		$this->load->model('WeTrueConfig');
		$Configdata = $this->WeTrueConfig->WETConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('LatestPictures');
	}

    public function Content(){
    //最新图片-内容
        $pageNum = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');

        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
            $this->load->model('LatestImg'); 
            $data = $this->LatestImg->GetImg($pageNum,$pageLimit);
            
            echo $data;
            
        }else{
            echo "NULL";
        }
    }
}
