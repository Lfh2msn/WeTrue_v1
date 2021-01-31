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
}