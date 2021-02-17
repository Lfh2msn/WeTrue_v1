<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portraits extends CI_Model {
  
    //头像修改入库
    public function inPortrait($hash){
    
        //查询hash是否存在
        $this->load->database();
        $sql_sel_tx="SELECT hash FROM wet_behavior WHERE hash='$hash' LIMIT 1";
        $counttx = $this->db->query($sql_sel_tx);

        if($counttx->num_rows()==0){
            //对接收内容解析
            $this->load->model('Judge');
            $wetjson = $this->Judge->hash($hash,'Portrait');
            $wethash = !empty($wetjson['hash'])?$wetjson['hash']:null;
            $wetsend = !empty($wetjson['tx']['sender_id'])?$wetjson['tx']['sender_id']:null;
            $wetrecp = !empty($wetjson['tx']['recipient_id'])?$wetjson['tx']['recipient_id']:null;
            $wetamot = !empty($wetjson['tx']['amount'])?$wetjson['tx']['amount']:null;
            $wettime = !empty($wetjson['block_time'])?$wetjson['block_time']:null;

            $wetjspl = !empty($wetjson['tx']['payload'])?$wetjson['tx']['payload']:null;
            $paylhex = $this->Judge->HexPayload($wetjspl);
            $wetarr = (array) json_decode($paylhex,true);
            
            
            $wettype = !empty($wetarr['content_type'])?$wetarr['content_type']:null;
            $wetpaylo = !empty($wetarr['img_list'])?$wetarr['img_list']:null;
            $wetplmin = $wetpaylo[0]['minimg'];
            $wetpayin = htmlspecialchars($wetplmin,ENT_QUOTES);

            //用户活跃搜索及入库
			$this->load->model('Users');
			$this->Users->userActive($wetsend,$uactive=1);

            //入库行为记录
            $sql_in_beh="INSERT INTO wet_behavior(address,hash,thing,influence,toaddress) VALUES ('$wetsend','$wethash','$wettype','1','$wetrecp')";
            $this->db->query($sql_in_beh);

            //删除临时缓存
            $sql_del_tp="DELETE FROM wet_temporary WHERE tp_hash='$hash'";
            $this->db->query($sql_del_tp);
            
        }else{
            echo "重复提交";
            //删除临时缓存
            $sql_del_tp="DELETE FROM wet_temporary WHERE tp_hash='$hash'";
            $this->db->query($sql_del_tp);
        }
    }

}