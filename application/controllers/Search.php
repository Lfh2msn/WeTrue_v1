<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	public function KeyWord($Key){
    //首页
		$this->load->model('Config');
		$Configdata = $this->Config->articleConfig();
		$this->load->view('header',$Configdata);
	//获取关键词
		$data['KeyWord'] = $Key;
		$this->load->view('Search',$data);
	}

    public function Content(){
    //搜索主贴
        $pageNum = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
		$WKey = $this->input->get_post('KeyWord');
		$urlKey = urldecode($WKey);
		$CheckKey = htmlspecialchars($urlKey,ENT_QUOTES);
        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
            $this->load->model('Searchs');
			$sort = "Content";
            $data = $this->Searchs->CheckContent($pageNum,$pageLimit,$CheckKey,$sort);
			echo $data;
        }else{
            echo "NULL";
        }
    }

	public function Comment(){
    //搜索评论
        $pageNum = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
		$WKey = $this->input->get_post('KeyWord');
		$urlKey = urldecode($WKey);
		$CheckKey = htmlspecialchars($urlKey,ENT_QUOTES);
        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
            $this->load->model('Searchs');
			$sort = "Comment";
            $data = $this->Searchs->CheckContent($pageNum,$pageLimit,$CheckKey,$sort);
			echo $data;
        }else{
            echo "NULL";
        }
    }

	public function User(){
    //搜索用户
        $pageNum = $this->input->get_post('pageNum');
        $pageLimit = $this->input->get_post('pageLimit');
		$WKey = $this->input->get_post('KeyWord');
		$urlKey = urldecode($WKey);
		$CheckKey = htmlspecialchars($urlKey,ENT_QUOTES);
        if(is_numeric($pageNum)&&is_numeric($pageLimit)){
            $this->load->model('Searchs');
            $data = $this->Searchs->SearchUser($pageNum,$pageLimit,$CheckKey);
			echo $data;
        }else{
            echo "NULL";
        }
    }
}
