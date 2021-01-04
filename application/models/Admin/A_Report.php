<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class A_Report extends CI_Model {

    //分页数据-被举报
    public function Rp_Content($pageNum,$pageLimit){

        if($pageNum<1){$pageNum=1;}
        if($pageLimit<1){$pageLimit=1;}

        $pageNum=$pageNum; //第几页
        $pageLimit=$pageLimit; //几条

        $this->load->database();
        $sql="SELECT count(*) from wet_report";
        $query = $this->db->query($sql);
        $row = $query->row();
        $totalSize=$row->count;//总数量
        $totalPage=ceil($totalSize/$pageLimit);//总页数
        $rsql="SELECT * from wet_report order by uid desc LIMIT $pageLimit offset ".($pageNum-1)*$pageLimit;
        $rquery = $this->db->query($rsql);

        $todata['pageNum'] = $pageNum;//数量
        $todata['pageLimit'] = $pageLimit;//数量
        $todata['totalPage'] = $totalPage;//总页数
        $todata['totalSize'] = $totalSize;//总数

        foreach ($rquery->result() as $row){
            $rp_hash = $row->rp_hash;
            $todata['hash'] = $rp_hash;
            $sender_id = $row->rp_sender_id;
            $todata['sender_id'] = $sender_id;
            $todata['sender_id_show'] = substr($sender_id,-5);
            $cnsql="SELECT * from wet_content WHERE hash='$rp_hash' LIMIT 1";
            $cnquery = $this->db->query($cnsql);
            if ($cnquery->num_rows() > 0){
            	$nrow = $cnquery->row(); 
            	$payload_sc = mb_substr($nrow->payload,0,80);
                $todata['payload'] = html_entity_decode($payload_sc);
                $imgtx_sc = $nrow->imgtx;
                $todata['imgtx'] =  htmlentities($imgtx_sc);
            	$todata['utctime'] = $nrow->utctime;
	            $todata['commsum'] = $nrow->commsum;
	            $todata['love']    = $nrow->love;
            }else{
            	$cmsql="SELECT * from wet_comment WHERE hash='$rp_hash' LIMIT 1";
            	$cmquery = $this->db->query($cmsql);
            	$mrow    = $cmquery->row(); 
            	$payload_sc = mb_substr($mrow->payload,0,80);
                $todata['payload'] = html_entity_decode($payload_sc);
                $todata['imgtx']   = "";
            	$todata['utctime'] = $mrow->utctime;
	            $todata['commsum'] = $mrow->commsum;
	            $todata['love']    = $mrow->love;
            }


            $sql="SELECT * from wet_users WHERE address='$sender_id' LIMIT 1";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
                $row = $query->row(); 
                $todata['username'] = htmlentities($row->username);
                $uactive_sc = $row->uactive;
                $this->load->model('Judge');
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

    //分页数据-被过滤
    public function Rp_Bloom($pageNum,$pageLimit){

        if($pageNum<1){$pageNum=1;}
        if($pageLimit<1){$pageLimit=1;}

        $pageNum=$pageNum; //第几页
        $pageLimit=$pageLimit; //几条

        $this->load->database();
        $sql="SELECT count(*) from wet_bloom";
        $query = $this->db->query($sql);
        $row = $query->row();
        $totalSize=$row->count;//总数量
        $totalPage=ceil($totalSize/$pageLimit);//总页数
        $bfsql="SELECT bf_hash from wet_bloom order by uid desc LIMIT $pageLimit offset ".($pageNum-1)*$pageLimit;
        $bfquery = $this->db->query($bfsql);

        $todata['pageNum'] = $pageNum;//数量
        $todata['pageLimit'] = $pageLimit;//数量
        $todata['totalPage'] = $totalPage;//总页数
        $todata['totalSize'] = $totalSize;//总数

        foreach ($bfquery->result() as $row){
            $bf_hash = $row->bf_hash;
            $todata['hash'] = $bf_hash;
            $cnsql="SELECT * from wet_content WHERE hash='$bf_hash' LIMIT 1";
            $cnquery = $this->db->query($cnsql);
            if ($cnquery->num_rows() > 0){
            	$nrow = $cnquery->row();
                $sender_id = $nrow->sender_id;
                $todata['sender_id'] = $sender_id;
                $todata['sender_id_show'] = substr($sender_id,-5);
                $payload_sc = mb_substr($nrow->payload,0,80);
                $todata['payload'] = html_entity_decode($payload_sc);
                $imgtx_sc = $nrow->imgtx;
                $todata['imgtx'] =  htmlentities($imgtx_sc);
            	$todata['utctime'] = $nrow->utctime;
	            $todata['commsum'] = $nrow->commsum;
	            $todata['love']    = $nrow->love;
            }else{
            	$cmsql="SELECT * from wet_comment WHERE hash='$bf_hash' LIMIT 1";
            	$cmquery = $this->db->query($cmsql);
            	$mrow    = $cmquery->row();
                $sender_id = $mrow->sender_id;
                $todata['sender_id'] = $sender_id;
                $todata['sender_id_show'] = substr($sender_id,-5);
            	$payload_sc = mb_substr($mrow->payload,0,80);
                $todata['payload'] = html_entity_decode($payload_sc);
                $todata['imgtx']   = "";
            	$todata['utctime'] = $mrow->utctime;
	            $todata['commsum'] = $mrow->commsum;
	            $todata['love']    = $mrow->love;
            }


            $sql="SELECT * from wet_users WHERE address='$sender_id' LIMIT 1";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){
                $row = $query->row(); 
                $todata['username'] = $row->username;
                $uactive_sc = $row->uactive;
                $this->load->model('Judge');
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

    //接收屏蔽数据
    public function RpTx($rp_hash,$rp_sender_id,$informant){
    $this->load->database();
    $sql_qy_bf="SELECT bf_hash FROM wet_bloom WHERE bf_hash='$rp_hash' LIMIT 1";
    //查询是否已屏蔽
    $qybf = $this->db->query($sql_qy_bf);
    if($qybf->num_rows()==0){
        //屏蔽入库
        $sql_in_bf="INSERT INTO wet_bloom(bf_hash,bf_reason) VALUES ('$rp_hash','admin_bf')";
        $this->db->query($sql_in_bf);
        //删除举报记录
        $sql_del_rp="DELETE FROM wet_report WHERE rp_hash='$rp_hash'";
        $this->db->query($sql_del_rp);
        //行为记录
        $sql_in_beh="INSERT INTO wet_behavior(address,hash,thing,toaddress) VALUES ('$informant','$rp_hash','Admin_BF','$rp_sender_id')";
        $this->db->query($sql_in_beh);
        echo "屏蔽成功...";
        $this->output->delete_cache('/Content/Tx/'.$rp_hash);
        $this->output->delete_cache('/Comment/Tx/'.$rp_hash);
    }else{
        $sql_del_rp="DELETE FROM wet_report WHERE rp_hash='$rp_hash'";
        $this->db->query($sql_del_rp);
        echo "已屏蔽过...";
        }
    }

    //接收取消屏蔽数据
    public function UnRpTx($rp_hash,$rp_sender_id,$informant){
    $this->load->database();
    $sql_qy_bf="SELECT bf_hash FROM wet_bloom WHERE bf_hash='$rp_hash' LIMIT 1";
    //查询是否已屏蔽
    $qybf = $this->db->query($sql_qy_bf);
    if($qybf->num_rows()==0){
        //删除举报记录
        $sql_del_rp="DELETE FROM wet_report WHERE rp_hash='$rp_hash'";
        $this->db->query($sql_del_rp);
        echo "未屏蔽...";
    }else{
        $sql_del_bf="DELETE FROM wet_bloom WHERE bf_hash='$rp_hash'";
        $this->db->query($sql_del_bf);

        $sql_del_rp="DELETE FROM wet_report WHERE rp_hash='$rp_hash'";
        $this->db->query($sql_del_rp);
        echo "已取消屏蔽...";
        $this->output->delete_cache('/Content/Tx/'.$rp_hash);
        $this->output->delete_cache('/Comment/Tx/'.$rp_hash);
        }
    }

}