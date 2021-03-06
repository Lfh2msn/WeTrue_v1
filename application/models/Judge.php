<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Judge extends CI_Model {
  
    public function hash($hash,$source){
    //对接收hash预处理
		//调用Config
		$this->load->model('WeTrueConfig');
		$wetConfig = $this->WeTrueConfig->Config();

        //写入临时数据库
        $sql_in_tp="INSERT INTO wet_temporary(tp_hash,tp_source) VALUES ('$hash','$source')";
        $this->db->query($sql_in_tp);

        $url = $wetConfig['backendServiceNode'].'v2/transactions/'.$hash;

        //屏蔽错误,防止节点暴露（屏蔽符：@ ）
        @$json = file_get_contents($url);

        //过滤无效hash
        if(empty($json)){
        	echo 'Node报错，无Hash记录';
        return;
        }

        $arr = (array) json_decode($json,true);

        //过滤无效预设钱包
        if(empty($arr['tx']['recipient_id']==$wetConfig['receivingAccount'])){
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
        $mburl =$wetConfig['backendServiceNode'].'v2/micro-blocks/hash/'.$microblock.'/header';
        $mbjson = file_get_contents($mburl);
        $mbarr = (array) json_decode($mbjson,true);
        $arr['block_time']=$mbarr['time'];
    return $arr;
    }

    public function GetActiveGrade($num){
    //等级划分
        if($num>="10000"){
            $Grade = '<i class="widget-numbers text-warning">V7</i>';
            return $Grade;

        }elseif($num>="5000"){
            $Grade = '<i class="widget-numbers text-alternate">V6</i>';
            return $Grade;

        }elseif ($num>="2000") {
            $Grade = '<i class="widget-numbers text-danger">V5</i>';
            return $Grade;

        }elseif ($num>="500") {
            $Grade = '<i class="widget-numbers text-success">V4</i>';
            return $Grade;

        }elseif ($num>="100") {
            $Grade = '<i class="widget-numbers text-info">V3</i>';
            return $Grade;
        }elseif ($num>="50") {
            $Grade = '<i class="widget-numbers text-primary">V2</i>';
            return $Grade;
        }else{
            $Grade = '<i class="widget-numbers text-secondary">V1</i>';
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

	public function Ip_Bloom($ip){
    //过滤IP
        $this->load->database();
        $sql="SELECT bf_ip FROM wet_bloom WHERE bf_ip='$ip' LIMIT 1";
        //查询hash是否存在
        $querytx = $this->db->query($sql);
        if($querytx->num_rows()==0){
            $hash_filter = "ok";
        }else{
            $hash_filter = "filter";
        }
        return $hash_filter;
    }

	public function get_real_ip(){
	//获取IP
		$ip=FALSE;
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
			if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
			for ($i = 0; $i < count($ips); $i++) {
				if (!eregi ("^(10│172.16│192.168).", $ips[$i])) {
					$ip = $ips[$i];
					break;
				}
			}
		}
		return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
	}

	public function NewUserActive($sendid_id,$ip){
	//新用户活动领取AE
		//调用Config
		$this->load->model('WeTrueConfig');
		$wetConfig = $this->WeTrueConfig->Config();

		//过滤IP
		$Judge_IP = $this->Ip_Bloom($ip);
		if($Judge_IP=="filter"){
			$this->input->set_cookie("NewUser","Repeat_IP",time()+365*24*60*60);
			return "Repeat!";
		}
		//查询账户链上记录是否为空
        $url = $wetConfig['backendServiceNode'].'v2/accounts/'.$sendid_id;
        //读取节点查询账户
        @$GetUrl = file_get_contents($url);
        //过滤链上记录
        if(empty($GetUrl)){
			$AeasyApiUrl = $wetConfig['AeasyApiUrl'];//aeasy API
			$post_data = array(
				'app_id'     => $wetConfig['AeasyApp_id'],
				'address'    => $sendid_id,
				'amount'     => $wetConfig['AeasyAmount'],
				'signingKey' => $wetConfig['AeasySecretKey'],
			);
			$postdata = http_build_query($post_data);
			$options = array(
							'http' => array(
							'method' => 'POST',
							'header' => 'Content-type:application/x-www-form-urlencoded',
							'content' => $postdata,
							'timeout' => 15 * 60 // 超时时间（单位:s）
						));
			$context = stream_context_create($options);
			$result = file_get_contents($AeasyApiUrl, false, $context);
			$arr = (array) json_decode($result,true);
			$code = $arr['code'];
			if($code == '200'){
				$this->load->database();
				$this->input->set_cookie("NewUser","Receive",time()+365*24*60*60);
				$insert_bloom = "INSERT INTO wet_bloom(bf_ip,bf_reason) VALUES ('$ip','NewUserActive')";
				$this->db->query($insert_bloom);
				return 'ok，'.$amount.'AE';
			}else{
				return '活动结束';
			}
        }else{
			echo 'ERROR!';
		}
    }
}