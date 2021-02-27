<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model {
  
    public function GetUser($address){
	//获取用户头像、昵称、等级
		$this->load->database();
		$sql="SELECT * from wet_users WHERE address='$address' LIMIT 1";
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
			$row = $query->row(); 
			$username_sc = $row->username;
			if($username_sc==''){
				$data['username'] = "Null";
			}else{
				$data['username'] = htmlentities($username_sc);
			}
			$uactive_sc = $row->uactive;
            $data['active'] = $uactive_sc;
			$this->load->model('Judge');
			$data['uactive'] = $this->Judge->GetActiveGrade($uactive_sc);
			$portrait_sc = $row->portrait;
			if($portrait_sc==''){
				$data['portrait'] = "/assets/images/avatars/null.jpg";
			}else{
				$data['portrait'] =  htmlentities($portrait_sc);
			}
		}else{
			$data['username'] = "匿名";
			$data['portrait'] = "/assets/images/avatars/null.jpg";
		}
		return $data;
	}

	public function userActive($address,$uactive){
	//用户活跃搜索及入库
		$sql_select_address="SELECT address FROM wet_users WHERE address='$address' LIMIT 1";
		$count_address = $this->db->query($sql_select_address);
		if($count_address->num_rows()==0){ //如果没有记录
			$sql_insert="INSERT INTO wet_users(address) VALUES ('$address')";
			$this->db->query($sql_insert);
			$sql_update="UPDATE wet_users SET uactive=uactive+$uactive WHERE address='$address'";
			$this->db->query($sql_update);
		}else{
			$sql_update="UPDATE wet_users SET uactive=uactive+$uactive WHERE address='$address'";
			$this->db->query($sql_update);
		}
	}
}