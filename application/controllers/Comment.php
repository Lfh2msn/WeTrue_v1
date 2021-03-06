<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends CI_Controller {

	public function Tx($hash=""){
	//评论首页
		$this->load->model('Judge');
		$Jhash=$this->Judge->hashAndID($hash);
		$this->load->model('Contents');
		$data = $this->Contents->TxContent($Jhash);
		$data['hash'] = $hash;
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('Comment/Home',$data);
		$this->output->cache(10080);
	}

	
    public function Post($hash){
    //发评论页
		$this->load->model('Judge');
		$Jhash=$this->Judge->hashAndID($hash);
		$data['tohash'] = $Jhash;
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
		$this->load->view('Comment/Post',$data);
    }

    
	public function insertComment(){
	//评论写入
		$hash = $this->input->get_post('hash');
		$this->load->model('Judge');
		$Jhash=$this->Judge->hashAndID($hash);
		$this->load->model('Comments');
		$data = $this->Comments->inComment($Jhash);
		$this->load->view('null',$data,true);
	}

	public function GetComment(){
    //主帖评论
        $pageNum = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
        $hash = $this->input->get_post('hash');
        $this->load->model('Judge');
		$Jhash=$this->Judge->hashAndID($hash);
		
        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
            $this->load->model('Comments'); 
            $data = $this->Comments->GetComment($pageNum,$pageLimit,$Jhash);
            
            echo $data;
            
        }else{
            echo "NULL";
        }
    }

}
