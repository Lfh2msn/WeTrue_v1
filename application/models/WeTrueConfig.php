<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WeTrueConfig extends CI_Model {

    //资料设置
    public function WETConfig(){

        $data['WeTrue'] = "0.7.0"; //版本号
        $data['toConAmount'] = "0"; //发帖金额 1e17 = 0.1ae
        $data['toComAmount'] = "0"; //评论金额 1e16 = 0.01ae
        $data['toNameAmount'] = "0"; //昵称金额 5e18 = 5ae
        $data['toPortraitAmount'] = "0"; //头像金额 3e18 = 3ae
        $data['toRecid'] = "ak_dMyzpooJ4oGnBVX35SCvHspJrq55HAAupCwPQTDZmRDT5SSSW"; //接收账户
        $data['toSendNode'] = PUBLIC_NODE; //发送及金额查询节点
        //AE价格获取
        $AeInfo = $this->GetAeLast();
        $data['AeLast'] = $AeInfo['last'];//$AeInfo['last']; //价格
        $data['AepercentChange'] = $AeInfo['percentChange'];//$AeInfo['percentChange']; //涨跌百分比
        $data['Aehigh24hr'] = $AeInfo['high24hr'];//$AeInfo['high24hr']; //24小时最高
        $data['Aelow24hr'] = $AeInfo['low24hr'];//$AeInfo['low24hr']; //24小时最低

    return $data;
    }

    //资料设置
    public function GetAeLast(){

        $url = "https://data.gateapi.io/api2/1/ticker/ae_usdt";
        @$json = file_get_contents($url);
        //过滤无效hash
        if(empty($json)){
        echo '远端报错，无没有读取到价格';
        return;
        }

        $arr = (array) json_decode($json,true);
        $data['last'] = !empty($arr['last'])?$arr['last']:null;
        $data['percentChange'] = !empty($arr['percentChange'])?$arr['percentChange']:null;
        $data['high24hr'] = !empty($arr['high24hr'])?$arr['high24hr']:null;
        $data['low24hr'] = !empty($arr['low24hr'])?$arr['low24hr']:null;
    return $data;
    }


}

