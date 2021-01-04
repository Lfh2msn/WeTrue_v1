<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logins extends CI_Model {
  
    public function GetUserData($address){
        //登录调用昵称、头像
        $this->load->database();
        $sql="SELECT * FROM wet_users WHERE address='$address' LIMIT 1";
        $query = $this->db->query($sql);
        if($query->num_rows()==0){
            $data="{\"username\":\"匿名\",\"portrait\":\"/assets/images/avatars/null.jpg\"}";
            //新用户登录登记
            $sql_in_beh="INSERT INTO wet_behavior(address,thing) VALUES ('$address','newUserLogin')";
            $this->db->query($sql_in_beh);
            return $data;
        }else{
            $data="{\"username\":\"".$query->row()->username."\",\"portrait\":\"".$query->row()->portrait."\"}";
            //老用户登录登记
            $sql_in_beh="INSERT INTO wet_behavior(address,thing) VALUES ('$address','oldUserLogin')";
            $this->db->query($sql_in_beh);
        }   return $data;
    }

}