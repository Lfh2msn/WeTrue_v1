<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Model {

    public function WetConfig(){
	//全站配置
		return array(
			'version' => '1.0.7', //版本号
			'contentAmount'      => '1e14', //发帖费用 1e17 = 0.1ae
			'commentAmount'      => '1e14', //评论费用
			'userNameAmount'     => '1e14', //昵称金额
			'portraitAmount'     => '1e14', //头像费用
			'articleSendNode'    => PUBLIC_NODE, //内容发送节点
			'backendServiceNode' => PUBLIC_NODE, //内容发送节点
			'receivingAccount'   => 'ak_dMyzpooJ4oGnBVX35SCvHspJrq55HAAupCwPQTDZmRDT5SSSW', //接收账户
			'adminUser_1'        => 'ak_2kxt6D65giv4yNt4oa44SjW4jEXfoHMviPFvAreSEXvz25Q3QQ', // Admin User 1
			'adminUser_2'        => 'ak_2kxt6D65giv4yNt4oa44SjW4jEXfoHMviPFvAreSEXvz25Q3QQ', // Admin User 2
			'adminUser_3'        => 'ak_2kxt6D65giv4yNt4oa44SjW4jEXfoHMviPFvAreSEXvz25Q3QQ', // Admin User 3
			'gateioApiUrl'        => 'https://data.gateapi.io/api2/1/ticker/ae_usdt', //Gate.io AE API
			'AeasyApiUrl'        => 'https://aeasy.io/api/wallet/transfer', //Aeasy.io API
			'AeasyApp_id'        => '', //Aeasy.io appid
			'AeasyAmount'        => '0.1', //活动金额
			'AeasySecretKey'     => '', //私钥
			'airdropWttRatio'    => '5', //WTT空投比例
		);
    }

    public function articleConfig(){	
	 //前端设置
		$this->load->model('Config');
		$wetConfig = $this->Config->WetConfig();
		$aePrice = $this->GetAeLast();

		return array(
			'WeTrue'           => $wetConfig['version'],
			'toConAmount'      => $wetConfig['contentAmount'],
			'toComAmount'      => $wetConfig['commentAmount'],
			'toNameAmount'     => $wetConfig['userNameAmount'],
			'toPortraitAmount' => $wetConfig['portraitAmount'],
			'toRecid'          => $wetConfig['receivingAccount'],
			'toSendNode'       => $wetConfig['articleSendNode'],

			'AeLast'           => $aePrice['last'], //AE价格
			'AepercentChange'  => $aePrice['percentChange'], //涨跌百分比
			'Aehigh24hr'       => $aePrice['high24hr'], //24小时最高
			'Aelow24hr'        => $aePrice['low24hr'], //24小时最低
		);
    }

    public function GetAeLast(){
	//AE价格获取
		$this->load->model('Config');
		$wetConfig = $this->Config->WetConfig();
        @$json = file_get_contents($wetConfig['gateioApiUrl']);
        if(empty($json)){
			echo '远端报错，无没有读取到价格';
			return;
        }
        $arr = (array) json_decode($json,true);
		return array(
			'last'           => !empty($arr['last'])?$arr['last']:null, //AE价格
			'percentChange'  => !empty($arr['percentChange'])?$arr['percentChange']:null, //涨跌百分比
			'high24hr'       => !empty($arr['high24hr'])?$arr['high24hr']:null, //24小时最高
			'low24hr'        => !empty($arr['low24hr'])?$arr['low24hr']:null, //24小时最低
		);
    }
}

