<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Model {

    public function RpTx($rp_hash,$rp_sender_id,$informant){
        $this->load->database();
        $sql_qy_bf="SELECT bf_hash FROM wet_bloom WHERE bf_hash='$rp_hash' LIMIT 1";
        $sql_sel_tx="SELECT rp_hash,rp_count FROM wet_report WHERE rp_hash='$rp_hash' LIMIT 1";
        //查询hash是否存在
	    $counttx = $this->db->query($sql_sel_tx);
	    //查询是否已屏蔽
        $qybf = $this->db->query($sql_qy_bf);
        if($qybf->num_rows()==0){
	        if($counttx->num_rows()==0){
	        	//入库
	            $sql_in="INSERT INTO wet_report(rp_hash,rp_sender_id,rp_count) VALUES ('$rp_hash','$rp_sender_id','1')";
	            $this->db->query($sql_in);
	            //入库行为记录
	            $sql_in_beh="INSERT INTO wet_behavior(address,hash,thing,toaddress) VALUES ('$informant','$rp_hash','Report','$rp_sender_id')";
	            $this->db->query($sql_in_beh);
	            echo "举报成功";
	        }else{
	        	//更新记录
	            $sql_up="UPDATE wet_report SET rp_count=rp_count+1 WHERE rp_hash='$rp_hash'";
	            $this->db->query($sql_up);
	            //入库行为记录
	            $sql_in_beh="INSERT INTO wet_behavior(address,hash,thing,toaddress) VALUES ('$informant','$rp_hash','Report','$rp_sender_id')";
	            
	            echo "已举报,受理中...";
	        }
		}else{
			if($counttx->num_rows()==0){
				echo "已屏蔽，请勿提交！";
			}else{
				$sql_del_rp="DELETE FROM wet_report WHERE rp_hash='$rp_hash'";
	            $this->db->query($sql_del_rp);
	            echo "已屏蔽，请勿再提交！";
			}
		}
    }
}