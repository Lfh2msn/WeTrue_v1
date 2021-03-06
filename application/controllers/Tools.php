<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tools extends CI_Controller {

	public function Aktoimg($ak=NULL){
	//生成二维码
		$this->load->library('Qrcode'); 
		echo $this->qrcode->png($ak);
	}

    public function hashToimg($hash){
	//Tx转照片
		$this->load->model('Config');
		$wetConfig = $this->Config->articleConfig();
        $url = $wetConfig['backendServiceNode'].'v2/transactions/'.$hash;

		//检测是否th_开头
        $inhash = "tt".$hash;
        if(stripos($inhash,"th_")<1 || strlen($inhash)<48){ 
			echo '无效Hash';
			return;
        }

		//屏蔽错误,防止节点暴露（屏蔽符：@ ）
        @$json = file_get_contents($url);

		//过滤无效hash
        if(empty($json)){
			echo 'Node报错，无Hash记录';
			return;
        }

        $hasharr = (array) json_decode($json,true);

        //过滤空或无效Payload
        if($hasharr['tx']['payload']===null||$hasharr['tx']['payload']==="ba_Xfbg4g=="){
			echo '非法Hash';
			return;
        }

        $wetPayload = !empty($hasharr['tx']['payload'])?$hasharr['tx']['payload']:null;
        $strpl = bin2hex(base64_decode(str_replace("ba_","",$wetPayload)));
        $hexPayload = hex2bin(substr($strpl,0,strlen($strpl)-8));

        $wetArr = (array) json_decode($hexPayload,true);
        $wetBase64Img = !empty($wetArr['img_list'])?$wetArr['img_list']:null;
        $RemovalHead = str_replace("data:image/jpeg;base64,","",$wetBase64Img);
    	$wetImg = base64_decode($RemovalHead);
    	header("Expires:".date(DATE_RFC822,strtotime("7 day")));
		header('Content-type: image/jpeg');
    	echo $wetImg;

    }

    public function getAccounts($address){
	//获取账户信息
        //获取节点数据（屏蔽符：@ ）
		$this->load->model('Config');
		$wetConfig = $this->Config->articleConfig();
		$url = $wetConfig['backendServiceNode'].'v2/accounts/'.$address;
        @$json = file_get_contents($url);
		//无效账户
        if(empty($json)){
			echo '{"reason":"Invalid public key","balances":"0","id":"null"}';
        }
    	echo $json;
    }
}
