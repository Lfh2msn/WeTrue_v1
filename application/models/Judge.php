<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Judge extends CI_Model {
  
    public function hash($hash,$source){
    //对接收hash预处理

		//hash进入预先实体化，防止初步注入
        $hashen = $this->hashAndID($hash);

        //写入临时数据库
        $sql_in_tp="INSERT INTO wet_temporary(tp_hash,tp_source) VALUES ('$hashen','$source')";
        $this->db->query($sql_in_tp);

        $url = PUBLIC_NODE.'v2/transactions/'.$hash;

        //屏蔽错误,防止节点暴露（屏蔽符：@ ）
        @$json = file_get_contents($url);

        //过滤无效hash
        if(empty($json)){
        	echo 'Node报错，无Hash记录';
        return;
        }

        $arr = (array) json_decode($json,true);

        //过滤无效预设钱包
        if(empty($arr['tx']['recipient_id']=='ak_dMyzpooJ4oGnBVX35SCvHspJrq55HAAupCwPQTDZmRDT5SSSW')){
        	//删除临时缓存
	        $sql_del_tp="DELETE FROM wet_temporary WHERE tp_hash='$hash'";
	        $this->db->query($sql_del_tp);
	        echo '非法提交';
        return;
        }

        //过滤非常规 SpendTx
        if(empty($arr['tx']['type']=='SpendTx')){
        	//删除临时缓存
	        $sql_del_tp="DELETE FROM wet_temporary WHERE tp_hash='$hash'";
	        $this->db->query($sql_del_tp);
        	echo '非法SpendTx';
        return;
        }

        //过滤空或无效Payload
        if($arr['tx']['payload']===null||$arr['tx']['payload']==="ba_Xfbg4g=="){
        	//删除临时缓存
	        $sql_del_tp="DELETE FROM wet_temporary WHERE tp_hash='$hash'";
	        $this->db->query($sql_del_tp);
        	echo '非法 Payload';
        return;
        }

        //TX获取UTC时间
        $microblock = $arr['block_hash'];
        $mburl =PUBLIC_NODE.'v2/micro-blocks/hash/'.$microblock.'/header';
        $mbjson = file_get_contents($mburl);
        $mbarr = (array) json_decode($mbjson,true);
        $arr['block_time']=$mbarr['time'];
    return $arr;
    }

    public function GetActiveGrade($num){
    //等级划分
        if($num>="10000"){
            $Grade = '<button class="badge btn btn-dashed btn-outline-warning disabled mb-0">LV 7</button>';
            return $Grade;

        }elseif($num>="5000"){
            $Grade = '<button class="badge btn btn-dashed btn-outline-alternate disabled mb-0">LV 6</button>';
            return $Grade;

        }elseif ($num>="2000") {
            $Grade = '<button class="badge btn btn-dashed btn-outline-danger disabled mb-0">LV 5</button>';
            return $Grade;

        }elseif ($num>="500") {
            $Grade = '<button class="badge btn btn-dashed btn-outline-success disabled mb-0">LV 4</button>';
            return $Grade;

        }elseif ($num>="100") {
            $Grade = '<button class="badge btn btn-dashed btn-outline-info disabled mb-0">LV 3</button>';
            return $Grade;
        }elseif ($num>="50") {
            $Grade = '<button class="badge btn btn-dashed btn-outline-primary disabled mb-0">LV 2</button>';
            return $Grade;
        }else{
            $Grade = '<button class="badge btn btn-dashed btn-outline-secondary disabled mb-0">LV 1</button>';
            return $Grade;
        }
    }

    public function TxBloom($txhash){
    //过滤
        $this->load->database();
        $sql="SELECT bf_hash FROM wet_bloom WHERE bf_hash='$txhash' LIMIT 1";
        //查询hash是否存在
        $querytx = $this->db->query($sql);
        if($querytx->num_rows()==0){
            $hash_filter = "ok";
        }else{
            $hash_filter = "filter";
        }
        return $hash_filter;
    }


    public function HexPayload($payload){
    //解码Payload内容
        $strpl = bin2hex(base64_decode(str_replace("ba_","",$payload)));
        $hex_Payload = hex2bin(substr($strpl,0,strlen($strpl)-8));
        return $hex_Payload;
    }

    public function hashAndID($str){
    //钱包ID或hash过滤
        $hashen =htmlentities($str);
        $strbl = preg_replace( '/[^a-zA-Z0-9][ak_][th_]/', '', $hashen);
        $ak_hash= "do".$strbl;
        if(strlen($ak_hash)>=50 && stripos($ak_hash,"ak_")!=0 || stripos($ak_hash,"th_")!=0){
            return $strbl;
        }else{
            echo "It doesn't work here.";
            return;
        }
    }
}