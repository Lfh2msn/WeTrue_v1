<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class A_ManualIn extends CI_Model {

    public function TP_Content(){
        $data['tpContent']="";
        $this->load->database();
        $sql="SELECT uid, tp_hash, tp_source, tp_time from wet_temporary order by tp_time desc";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            $uid=$row->uid;
            $tp_hash= $row->tp_hash;
            $tp_source= $row->tp_source;
            $tp_time= $row->tp_time;
            $data['tpContent'].="<tr><th scope='row'>$uid</th><td>$tp_hash</td><td>$tp_source</td><td>$tp_time</td></tr>";
            }
        return $data;
    }

    public function InJContent($hash){

        $this->load->database();
        $sql="SELECT tp_hash, tp_source from wet_temporary WHERE tp_hash='$hash'";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0){
            $tp_source = $query->row_array()['tp_source'];
            if($tp_source == "Content"){
                $this->load->model('Contents');
                $data=$this->Contents->inContent($hash);
            }
            if($tp_source == "Comment"){
                $this->load->model('Comments');
                $data=$this->Comments->inComment($hash);
            }
            if($tp_source == "UserName"){
                $this->load->model('NickNames');
                $data=$this->NickNames->inName($hash);
            }
            if($tp_source == "Portrait"){
                $this->load->model('Portraits');
                $data=$this->Portraits->inPortrait($hash);
            }
            return $data;
        }else{
			//对接收hash预处理
			$this->load->model('Judge');
			//hash进入预先实体化，防止初步注入
			$this->load->model('Config');
			$wetConfig = $this->Config->WetConfig();
			$hashen = $this->Judge->hashAndID($hash);
			$url = $wetConfig['backendServiceNode'].'v2/transactions/'.$hashen;
			//屏蔽错误,防止节点暴露（屏蔽符：@ ）
			@$json = file_get_contents($url);
			//过滤无效hash
			if(empty($json)){
				echo 'Node报错，无Hash记录';
			return;
			}
			$arr = (array) json_decode($json,true);
			$this->load->model('Judge');
			$payload = $arr['tx']['payload'];
			$paylhex = $this->Judge->HexPayload($payload);
			$payarr = (array) json_decode($paylhex,true);
			$wettype = !empty($payarr['content_type'])?$payarr['content_type']:null;
			//写入临时数据库
			$sql_in_tp="INSERT INTO wet_temporary(tp_hash,tp_source) VALUES ('$hashen','$wettype')";
			$this->db->query($sql_in_tp);

            echo "提交失败，已重新解析，请再次点击提交";
        }
    }
}