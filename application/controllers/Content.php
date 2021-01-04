<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Content extends CI_Controller {

	public function Tx($hash=""){
	//主帖
		$this->load->model('Contents');
		$this->load->model('Judge');
		$Jhash=$this->Judge->hashAndID($hash);
		$data = $this->Contents->TxContent($Jhash);
		$data['hash'] = $Jhash;
		$this->load->model('WeTrueConfig');
		$Configdata = $this->WeTrueConfig->WETConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('Content/Home',$data);
		$this->output->cache(10080);
	}

    public function Post(){
    //发主帖页
		$this->load->model('WeTrueConfig');
		$Configdata = $this->WeTrueConfig->WETConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('Content/Post');
    }

	public function insertContent(){
	//主帖写入
		$hash = $this->input->get_post('hash');
		$this->load->model('Judge');
		$Jhash=$this->Judge->hashAndID($hash);
		$this->load->model('Contents');
		$data = $this->Contents->inContent($Jhash);
		$this->load->view('null',$data,true);
	}

    //获取主帖列表
    public function GetContent(){

        $pageNum = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
        $sort = $this->input->get_post('sort');

        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
            $this->load->model('GetPage'); 
            $data = $this->GetPage->GetContent($pageNum,$pageLimit,$sort);
            
            echo $data;
            
        }else{
            echo "NULL";
        }
    }
}
