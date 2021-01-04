<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MyFollows extends CI_Model {

    public function GetPosts($pageNum,$pageLimit,$sender_id){
    //分页数据-关注文章
        if($pageNum<1){$pageNum=1;}
        if($pageLimit<1){$pageLimit=1;}

        $this->load->database();
        $fwsql="SELECT count(wet_content.hash) FROM wet_content 
                INNER JOIN wet_follow ON wet_content.sender_id=wet_follow.following AND wet_follow.followers='$sender_id'";
        $fwquery = $this->db->query($fwsql);
        $fwResult = $fwquery->row();
        
        $totalSize=$fwResult->count;//总数量
        $totalPage=ceil($totalSize/$pageLimit);//总页数

        $sql = "SELECT wet_content.hash,wet_content.sender_id,wet_content.utctime,wet_content.payload,wet_content.imgtx,wet_content.love,wet_content.commsum FROM wet_content 
                INNER JOIN wet_follow ON wet_content.sender_id=wet_follow.following AND wet_follow.followers='$sender_id' 
                order by wet_content.uid desc LIMIT $pageLimit offset ".($pageNum-1)*$pageLimit;

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