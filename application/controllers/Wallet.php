<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallet extends CI_Controller {

	public function ID($ak=""){
	//用户中心首页
		if(strpos($ak,"ak_")!== false){
			$this->load->model('Config');
			$Configdata = $this->Config->articleConfig();
			$this->load->view('header',$Configdata);
	        //获取AK数据
	        $data['sendid_id'] = $ak;
	        $this->load->view('Wallet',$data);
		}else{
	        echo 'WeTrue Tips：Err Url---<a href="#" onClick="javascript :history.back(-1);">Back</a>';
	        return;
		}
	}

    public function Content(){
    //用户中心内容
        $pageNum   = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
        $sendid_id = $this->input->get_post('sendid_id');
        $this->load->model('Judge');
        $Jsendid_id=$this->Judge->hashAndID($sendid_id);
        
        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
        	$sort = "Content";
            $this->load->model('Wallets'); 
            $data = $this->Wallets->getIdContent($pageNum,$pageLimit,$Jsendid_id,$sort);
            echo $data;
        }else{
            echo "NULL";
        }
    }

    public function Comment(){
    //用户中心评论
        $pageNum = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
        $sendid_id = $this->input->get_post('sendid_id');
        $this->load->model('Judge');
        $Jsendid_id=$this->Judge->hashAndID($sendid_id);
        
        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
        	$sort = "Comment";
            $this->load->model('Wallets'); 
            $data = $this->Wallets->getIdContent($pageNum,$pageLimit,$Jsendid_id,$sort);
            echo $data;
        }else{
            echo "NULL";
        }
    }

    public function Follow(){
    //关注用户
        $wing_id = $this->input->get_post('wing_id');
        $wers_id = $this->input->get_post('wers_id');
        $this->load->model('Judge');
        $Jwing_id = $this->Judge->hashAndID($wing_id);
        $Jwers_id = $this->Judge->hashAndID($wers_id);
        if($Jwing_id == $Jwers_id){
            echo "无法关注自己";
            return;
        }
        $this->load->model('Wallets');
        $data = $this->Wallets->Follow($Jwing_id,$Jwers_id);
    }

    public function Following(){
    //获取关注列表
        $pageNum   = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
        $sendid_id = $this->input->get_post('sendid_id');
        $this->load->model('Judge');
        $Jsendid_id=$this->Judge->hashAndID($sendid_id);
        
        if(is_numeric($pageNum) && is_numeric($pageLimit)){
            $sort = "following";
            $this->load->model('Wallets'); 
            $data = $this->Wallets->Following($pageNum,$pageLimit,$Jsendid_id,$sort);
            
            echo $data;
            
        }else{
            echo "NULL";
        }
    }

    public function Followers(){
    //获取被关注列表
        $pageNum   = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
        $sendid_id = $this->input->get_post('sendid_id');
        $this->load->model('Judge');
        $Jsendid_id=$this->Judge->hashAndID($sendid_id);
        
        if(is_numeric($pageNum) && is_numeric($pageLimit)){
            $sort = "followers";
            $this->load->model('Wallets'); 
            $data = $this->Wallets->Following($pageNum,$pageLimit,$Jsendid_id,$sort);
            
            echo $data;
            
        }else{
            echo "NULL";
        }
    }

	public function NewUserActivity(){
    //新用户领AE活动
		if(empty($_COOKIE['NewUser'])){
			$sendid_id = $this->input->get_post('sender_id');
			$this->load->model('Judge');
			$ip = $this->Judge->get_real_ip();
			$Jsendid_id = $this->Judge->hashAndID($sendid_id);
			$data = $this->Judge->NewUserActive($Jsendid_id,$ip);
			echo $data;
		}else{
			echo "Repeat!";
		}
    }


}
