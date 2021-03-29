<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics extends CI_Model {
  
    public function Total(){

		$this->load->database();
    //Total Content
		$sql="SELECT count(hash) FROM wet_content";
        $query = $this->db->query($sql);
        $row = $query->row();
        $data['totalContent'] = $row->count;
	//Total Comment
		$sql="SELECT count(hash) FROM wet_comment";
        $query = $this->db->query($sql);
        $row = $query->row();
        $data['totalComment'] = $row->count;
	//Active User
		$sql="SELECT count(address) FROM wet_users";
        $query = $this->db->query($sql);
        $row = $query->row();
        $data['activeUser'] = $row->count;
	//Total User
		$sql="SELECT count(distinct address) FROM wet_behavior";
        $query = $this->db->query($sql);
        $row = $query->row();
        $data['totalUser'] = $row->count;
	//Total Like
		$sql="SELECT count(hash) FROM wet_love";
        $query = $this->db->query($sql);
        $row = $query->row();
        $data['totalLike'] = $row->count;
	//Total Active
		$sql="SELECT SUM(uactive) FROM wet_users";
        $query = $this->db->query($sql);
        $row = $query->row();
        $data['totalActivity'] = $row->sum;
	//Statistics Time
		$data['statisticsTime'] = strtotime("now")*1000;
		return json_encode($data);
    }

}