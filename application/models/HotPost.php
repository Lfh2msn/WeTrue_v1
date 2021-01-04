<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HotPost extends CI_Model {

    public function GetHotPosts($pageNum,$pageLimit){
    //分页数据-最新发布、最新回复
        if($pageNum<1){$pageNum=1;}
        if($pageLimit<1){$pageLimit=1;}

        $this->load->database();
        $FifteenTime = (time()-86400*10)*1000;//86400秒*10天*1000毫秒
        $sql="SELECT count(*) from wet_content WHERE utctime >= $FifteenTime";
        $query = $this->db->query($sql);
        $row = $query->row();
        $totalSize=$row->count;//总数量
        $totalPage=ceil($totalSize/$pageLimit);//总页数
        $sql = "SELECT hash,sender_id,utctime,payload,imgtx,love,commsum FROM wet_content 
                WHERE utctime >= $FifteenTime ORDER BY (love+commsum) DESC 
                LIMIT $pageLimit offset ".($pageNum-1)*$pageLimit;

        $query = $this->db->query($sql);
        $todata['pageNum'] = $pageNum;//数量
        $todata['pageLimit'] = $pageLimit;//数量
        $todata['totalPage'] = $totalPage;//总页数
        $todata['totalSize'] = $totalSize;//总数

        foreach ($query->result() as $row){
            $hash = $row->hash;
            $todata['hash'] = $hash;
            $sender_id = $row->sender_id;
            $todata['sender_id'] = $sender_id;
            $todata['sender_id_show'] = substr($sender_id,-5);
            $inpayload = $row->payload;

            $this->load->model('Judge');
            $Judge_Hash = $this->Judge->TxBloom($hash);
            if($Judge_Hash=="ok"){
                $mbpayload = mb_substr($inpayload,0,80);
                $todata['payload'] = html_entity_decode($mbpayload);
                $paylen = mb_strlen($mbpayload,'UTF8');
                if($paylen>=80){$todata['payload'].=" ...";}
                $imgtx_sc = $row->imgtx;
                $todata['imgtx'] = htmlentities($imgtx_sc);
            }else{
                $todata['payload'] = "内容某因素不可见，详情TX_Hash：&#13;{$hash}";
                $todata['imgtx']   = "";
            }

            $todata['utctime'] = $row->utctime;
            $todata['commsum'] = $row->commsum;
            $todata['love'] = $row->love;


            $sql="SELECT username,uactive,portrait,address from wet_users WHERE address='$sender_id' LIMIT 1";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
                $row = $query->row(); 
                $username_sc = $row->username;
                $todata['username'] = htmlentities($username_sc);
                $uactive_sc = $row->uactive;
                $todata['uactive'] = $this->Judge->GetActiveGrade($uactive_sc);
               $portrait_sc = $row->portrait;
               if($portrait_sc==''){
                    $todata['portrait'] = "/assets/images/avatars/null.jpg";
                }else{
                    $todata['portrait'] =  htmlentities($portrait_sc);
                }

            }else{
                $todata['username'] = "匿名";
                $todata['portrait'] = "/assets/images/avatars/null.jpg";
            }

            $atodata[] = $todata;//返回内容
            $data = json_encode($atodata);
        }
        return $data;
    }

}