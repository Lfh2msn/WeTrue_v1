<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wallets extends CI_Model {

    //用户id获取内容
    public function getIdContent($pageNum,$pageLimit,$sender_id,$sort){

        if($pageNum<1){$pageNum=1;}
        if($pageLimit<1){$pageLimit=1;}
        if($sort=="Comment"){
            $NewSort = "wet_comment";
        }else{
            $NewSort = "wet_content";
        }
        
        $pageNum=$pageNum; //第几页
        $pageLimit=$pageLimit; //几条
        $sender_id=$sender_id;//用户id
          
        $this->load->database();
        $sql="SELECT count(sender_id) FROM $NewSort WHERE sender_id='$sender_id'";
        $query = $this->db->query($sql);
        $row = $query->row();
        $totalSize=$row->count;//总数量
        $totalPage=ceil($totalSize/$pageLimit);//总页数
        
        $todata['pageNum'] = $pageNum;//数量
        $todata['pageLimit'] = $pageLimit;//数量
        $todata['totalPage'] = $totalPage;//总页数
        $todata['totalSize'] = $totalSize;//总数

        $sql="SELECT * from $NewSort where sender_id='$sender_id' order by uid desc LIMIT $pageLimit offset ".($pageNum-1)*$pageLimit;
        $query = $this->db->query($sql);
        
            $row = $query->row();
            $counter=0;

            foreach ($query->result() as $row){
                $counter++;
                $hash = $row->hash;
                $todata['hash'] = $hash;
                $sender_id = $row->sender_id;
                $todata['sender_id'] = $sender_id;
                $todata['sender_id_show'] = substr($sender_id,-5);
                $this->load->model('Judge');
                $Judge_Hash = $this->Judge->TxBloom($hash);
                if($Judge_Hash=="ok"){
					$inpayload = $row->payload;
                    $mbpayload = mb_substr($inpayload,0,80);
                    $todata['payload'] = html_entity_decode($mbpayload);
                    $paylen = mb_strlen($mbpayload,'UTF8');
                    if($paylen>=80){$todata['payload'].=" ...";}
                    $imgtx_sc = $row->imgtx;
                    $todata['imgtx'] =  htmlentities($imgtx_sc);
                }else{
                    $todata['payload'] = "内容某因素不可见，详情TX_Hash：&#13;{$hash}";
                    $todata['imgtx']   = "";
                }
                $todata['utctime'] = $row->utctime;
                $todata['commsum'] = $row->commsum;
                $todata['love']  = $row->love;

                $sql="SELECT * from wet_users WHERE address='$sender_id' LIMIT 1";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0){

                    $row = $query->row();
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
                }else{
                    $todata['username']= "匿名";
                    $todata['portrait'] = "/assets/images/avatars/null.jpg";
                }

            $atodata[] = $todata;//返回内容
            $data = json_encode($atodata);
            }
        return $data;
    }

    //关注与取消关注
    public function Follow($Jwing_id,$Jwers_id){
        $this->load->database();
        //查询是否已关注
        $sql_qy="SELECT following,followers FROM wet_follow WHERE following='$Jwing_id' And followers='$Jwers_id' LIMIT 1";
        $qyfw = $this->db->query($sql_qy);

        if($qyfw->num_rows()==0){
            //入库
            $sql_in="INSERT INTO wet_follow(following,followers) VALUES ('$Jwing_id','$Jwers_id')";
            $this->db->query($sql_in);
            //入库行为记录
            $sql_in_beh="INSERT INTO wet_behavior(address,thing,toaddress) VALUES ('$Jwers_id','Follow','$Jwing_id')";
            $this->db->query($sql_in_beh);
            echo "关注成功";
        }else{
            $sql_del_fw="DELETE FROM wet_follow WHERE following='$Jwing_id' AND followers='$Jwers_id'";
            $this->db->query($sql_del_fw);
            echo "已取消关注";
        }
    }

    //关注、被关注列表
    public function Following($pageNum,$pageLimit,$sender_id,$sort){

        if($pageNum<1){$pageNum=1;}
        if($pageLimit<1){$pageLimit=1;}
        if($sort=="following"){
            $NewSort = "followers";
        }else{
            $NewSort = "following";
        }
        
        $pageNum=$pageNum; //第几页
        $pageLimit=$pageLimit; //几条
        $sender_id=$sender_id;//用户id
          
        $this->load->database();
        $sql="SELECT count($NewSort) FROM wet_follow WHERE $NewSort='$sender_id'";
        $query = $this->db->query($sql);
        $row = $query->row();
        $totalSize=$row->count;//总数量
        $totalPage=ceil($totalSize/$pageLimit);//总页数
        
        $todata['pageNum'] = $pageNum;//数量
        $todata['pageLimit'] = $pageLimit;//数量
        $todata['totalPage'] = $totalPage;//总页数
        $todata['totalSize'] = $totalSize;//总数

        $sql="SELECT following,followers from wet_follow WHERE $NewSort='$sender_id' order by uid desc LIMIT $pageLimit offset ".($pageNum-1)*$pageLimit;
        $query = $this->db->query($sql);
        foreach ($query->result() as $row){

            $address_id = $row->$sort;
            $todata['follow'] = $address_id;
            $todata['follow_show'] = substr($address_id,0,3).'****'.substr($address_id,-4);

            $sql="SELECT * from wet_users WHERE address='$address_id' LIMIT 1";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
                $row = $query->row();
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
            }else{
                $todata['username']= "匿名";
                $todata['portrait'] = "/assets/images/avatars/null.jpg";
            }

        $atodata[] = $todata;//返回内容
        $data = json_encode($atodata);
        }
        return $data;
    }

}