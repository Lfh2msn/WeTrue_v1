<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model {
  
    public function GetUser($address,$e=''){
	//获取用户头像、昵称、等级
		$this->load->database();
		$sql="SELECT * from wet_users WHERE address='$address' LIMIT 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			$row = $query->row(); 
			$userName = $row->username;
			if(!$userName){
				$data['username'] = "Null";
			}else{
				$data['username'] = htmlentities($userName);
			}
			$uActive = $row->uactive;
            $data['active'] = $uActive;
			$this->load->model('Judge');
			$data['uactive'] = $this->Judge->GetActiveGrade($uActive);
			if($e){
				$this->load->model('Config');
				$wetConfig = $this->Config->WetConfig();
				$data['lastActive'] = ($uActive - $row->last_active) * $wetConfig['airdropWttRatio'];
			}
			$portrait = $row->portrait;
			if(!$portrait){
				$data['portrait'] = "/assets/images/avatars/null.jpg";
			}else{
				$data['portrait'] =  htmlentities($portrait);
			}
		}else{
			$data['username'] = "匿名";
			$data['portrait'] = "/assets/images/avatars/null.jpg";
		}
		return $data;
	}

	public function userActive($address,$active){
	//用户活跃搜索及入库
		$sql_select_address="SELECT address FROM wet_users WHERE address='$address' LIMIT 1";
		$count_address = $this->db->query($sql_select_address);
		if($count_address->num_rows()==0){ //如果没有记录
			$sql_insert="INSERT INTO wet_users(address) VALUES ('$address')";
			$this->db->query($sql_insert);
			$sql_update="UPDATE wet_users SET uactive=uactive+'$active' WHERE address='$address'";
			$this->db->query($sql_update);
		}else{
			$sql_update="UPDATE wet_users SET uactive=uactive+'$active' WHERE address='$address'";
			$this->db->query($sql_update);
		}
	}
}