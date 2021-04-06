<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Searchs extends CI_Model {
  
    public function CheckContent($pageNum,$pageLimit,$Type,$sort){
    //搜索查询
		if($pageNum<1){$pageNum=1;}
        if($pageLimit<1){$pageLimit=1;}
		if($sort=="Comment"){
            $NewSort = "wet_comment";
        }else{
            $NewSort = "wet_content";
        }
        $this->load->database();
		$sql="SELECT count(hash) FROM $NewSort WHERE payload ilike '%$Type%'";
        $query = $this->db->query($sql);
        $row = $query->row();
        
        $totalSize=$row->count;//总数量
        $totalPage=ceil($totalSize/$pageLimit);//总页数
		$todata['pageNum'] = $pageNum;//数量
		$todata['pageLimit'] = $pageLimit;//数量
		$todata['totalPage'] = $totalPage;//总页数
		$todata['totalSize'] = $totalSize;//总数量

		$sql="SELECT hash,sender_id,utctime,payload,imgtx,love,commsum FROM $NewSort WHERE payload ilike '%$Type%' order by utctime desc LIMIT $pageLimit offset ".($pageNum-1)*$pageLimit;
		$query = $this->db->query($sql);

		foreach ($query->result() as $row){
			$hash = $row->hash;
			$todata['hash'] = $hash;
			$sender_id = $row->sender_id;
			$todata['sender_id'] = $sender_id;
			$todata['sender_id_show'] = substr($sender_id,-5);
			$this->load->model('Judge');
			$Judge_Hash = $this->Judge->TxBloom($hash);
			if($Judge_Hash=="ok"){
				$inpayload = $row->payload;
				$inpayload = $row->payload;
				$mbpayload = mb_substr($inpayload,0,80);
				$todata['payload'] = $mbpayload;
				$paylen = mb_strlen($mbpayload,'UTF8');
				if($paylen>=80){$todata['payload'].=" ...";}
				$imgtx_sc = $row->imgtx;
				$todata['imgtx'] = htmlentities($imgtx_sc);
			}else{
				$todata['payload'] = "Details TX_Hash：&#13;{$hash}";
				$todata['imgtx']   = "";
			}

			$todata['utctime'] = $row->utctime;
			$todata['commsum'] = $row->commsum;
			$todata['love'] = $row->love;

			$this->load->model('Users');
			$todata['users'] = $this->Users->GetUser($sender_id);

			$atodata[] = $todata;//返回内容
			$data = json_encode($atodata);
		}
		return $data;
    }

    //搜索用户
    public function SearchUser($pageNum,$pageLimit,$Type){

        if($pageNum<1){$pageNum=1;}
        if($pageLimit<1){$pageLimit=1;}
        
        $pageNum=$pageNum; //第几页
        $pageLimit=$pageLimit; //几条
          
        $this->load->database();
        $ssql="SELECT count(username) FROM wet_users WHERE username ilike '%$Type%'";
        $squery = $this->db->query($ssql);
        $srow = $squery->row();
        $totalSize=$srow->count;//总数量
        $totalPage=ceil($totalSize/$pageLimit);//总页数
        $todata['pageNum'] = $pageNum;//数量
        $todata['pageLimit'] = $pageLimit;//数量
        $todata['totalPage'] = $totalPage;//总页数
        $todata['totalSize'] = $totalSize;//总数

        $sql="SELECT * from wet_users WHERE username ilike '%$Type%' order by uid desc LIMIT $pageLimit offset ".($pageNum-1)*$pageLimit;
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0){
				foreach ($query->result() as $row){
					$UserId = $row->address;
					$todata['UserId'] = $UserId;
					$todata['UserId_show'] = substr($UserId,0,3).'****'.substr($UserId,-4);
					$username_sc = $row->username;
					$todata['username'] =  htmlentities($username_sc);
					$uactive_sc = $row->uactive;
					$todata['active'] = $uactive_sc;
					$this->load->model('Judge');
					$todata['uactive'] = $this->Judge->GetActiveGrade($uactive_sc);
					$portrait_sc = $row->portrait;

					if($portrait_sc==''){
						$todata['portrait'] = "/assets/images/avatars/null.jpg";
					}else{
						$todata['portrait'] =  htmlentities($portrait_sc);
					}
					$atodata[] = $todata;//返回内容
				}
			}else{
				$todata['UserId'] = "null";
				$todata['UserId_show'] = "null";
				$todata['active'] = "0";
				$todata['uactive'] = "0";
				$todata['username']= "匿名";
				$todata['portrait'] = "/assets/images/avatars/null.jpg";
				$atodata[] = $todata;//返回内容
			}
		$data = json_encode($atodata);
        return $data;
    }
}