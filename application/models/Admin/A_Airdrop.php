<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class A_Airdrop extends CI_Model {

	public function UpdateLastActive($e=''){
	//更新用户活跃、写入txt
		if($e){
			//带参则重写lists.txt
			$File = fopen("airdrop/lists/".date("Y-m-d").".txt","w");
			$Text = "";
			fwrite($File, $Text);
			fclose($File);
		}

		$this->load->database();
		$sql="SELECT address,uactive,last_active FROM wet_users";
        $query = $this->db->query($sql);
		foreach ($query->result() as $row){
			if($row->uactive != $row->last_active){
				$uactive    = $row->uactive;
				$lastActive = $row->last_active;
				$address = $row->address;
				if($address!=''){
					$textFile = fopen("airdrop/lists/".date("Y-m-d").".txt","a");
					$appendText = $address.":".(($uactive-$lastActive) * 10)."\r\n";
					fwrite($textFile, $appendText);
					fclose($textFile);
				}
				$sql_update="UPDATE wet_users SET last_active=uactive WHERE address='$address'";
				$this->db->query($sql_update);
			}
		}
		echo '<br><br>';
		$readFile=file("airdrop/lists/".date("Y-m-d").".txt"); //返回数组的内容
		foreach($readFile as $v){
			echo $v.'<br>';
		}
	}

}