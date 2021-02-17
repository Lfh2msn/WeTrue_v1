<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contents extends CI_Model {

    public function GetContent($pageNum,$pageLimit,$sort){
    //分页数据-最新发布、最新回复
        if($pageNum<1){$pageNum=1;}
        if($pageLimit<1){$pageLimit=1;}
        if($sort=="Comment"){
            $NewSort = "wet_comment";
        }else{
            $NewSort = "wet_content";
        }

        $pageNum=$pageNum; //第几页
        $pageLimit=$pageLimit; //几条

        $this->load->database();
        $sql="SELECT count(*) from $NewSort";
        $query = $this->db->query($sql);
        $row = $query->row();
        $totalSize=$row->count;//总数量
        $totalPage=ceil($totalSize/$pageLimit);//总页数
        $sql="SELECT * from $NewSort order by utctime desc LIMIT $pageLimit offset ".($pageNum-1)*$pageLimit;
        $query = $this->db->query($sql);

        $todata['pageNum'] = $pageNum;//数量
        $todata['pageLimit'] = $pageLimit;//数量
        $todata['totalPage'] = $totalPage;//总页数
        $todata['totalSize'] = $totalSize;//总数

        foreach ($query->result() as $row){
            $hash = $row->hash;
            $todata['hash'] = $hash;
            if($sort=="Comment"){$todata['to_hash'] = $row->to_hash;}
            $sender_id = $row->sender_id;
            $todata['sender_id'] = $sender_id;
            $todata['sender_id_show'] = substr($sender_id,-5);
            $this->load->model('Judge');
            $Judge_Hash = $this->Judge->TxBloom($hash);
            if($Judge_Hash=="ok"){
				$inpayload = $row->payload;
                $mbpayload = mb_substr($inpayload,0,80);
                $todata['payload'] = html_entity_decode($mbpayload);
                $paylen = mb_strlen($mbpayload,'UTF8');
                if($paylen>=80){$todata['payload'].=" ...";}
                $imgtx_sc = $row->imgtx;
                $todata['imgtx'] =  htmlentities($imgtx_sc);
            }else{
                $todata['payload'] = "Details Tx_Hash：&#13;{$hash}";
                $todata['imgtx']   = "";
            }

            $todata['utctime'] = $row->utctime;
            $todata['commsum'] = $row->commsum;
            $todata['love'] = $row->love;

            $this->load->model('Users');
			$todata['users'] = $this->Users->GetUser($sender_id);

            $atodata[] = $todata;//返回内容
            $data = json_encode($atodata);
        }
        return $data;
    }

    public function TxContent($hash){
    //主文获取页面，及评论展示
        $this->load->database();
        
        $sql="SELECT * FROM wet_content WHERE hash='$hash' LIMIT 1";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0){

            $row = $query->row(); 
            $data['txhash'] = $row->hash;
            $sender_id = $row->sender_id;
            $data['sender_id'] = $sender_id;
            $data['sender_id_show'] = substr($sender_id,-5);
            $this->load->model('Judge');
            $Judge_Hash = $this->Judge->TxBloom($hash);
            if($Judge_Hash=="ok"){
				$inpayload = $row->payload;
				$imgtx = $row->imgtx;
                $data['payload']   = html_entity_decode($inpayload);
                if($imgtx!=""){
                    $data['imgtx'] = '<div class="autoimg_div imgLoading"><img class="autoimg_img clickMaxImg" src="/assets/images/wet-loading.jpg" data-src="/Tools/hashToimg/'.$imgtx.'"></div>';
                }else{
                    $data['imgtx'] = "";
                }
            }else{
                $data['payload']   = "Details TX_Hash：&#13;{$hash}";
                $data['imgtx']   = "";
            }

            $data['utctime'] = $row->utctime;
            $data['commsum'] = $row->commsum;
            $data['love']  = $row->love;

            $this->load->model('Users');
			$data['users'] = $this->Users->GetUser($sender_id);
        }else{
            $sql="SELECT * FROM wet_comment WHERE hash='$hash' LIMIT 1";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0){

            $row = $query->row(); 
            $data['txhash'] = $row->hash;
            $sender_id = $row->sender_id;
            $data['sender_id'] = $sender_id;
            $data['sender_id_show'] = substr($sender_id,-5);
            $this->load->model('Judge');
            $Judge_Hash = $this->Judge->TxBloom($hash);
            if($Judge_Hash=="ok"){
				$inpayload = $row->payload;
				$imgtx = $row->imgtx;
                $data['to_hash'] = 'Reply To: <a href="/Content/Tx/'.$row->to_hash.'">'.substr($row->to_hash,0,9).'****'.substr($row->to_hash,-14).'</a>';
                $data['payload']   = html_entity_decode($inpayload);
                $data['imgtx'] = "";
            }else{
                $data['payload']   = "Details TX_Hash：&#13;{$hash}";
                $data['imgtx']   = "";
            }

            $data['utctime'] = $row->utctime;
            $data['commsum'] = $row->commsum;
            $data['love']  = $row->love;

            $this->load->model('Users');
			$data['users'] = $this->Users->GetUser($sender_id);

            }else{
                $data['txhash'] = "";
                $data['sender_id'] = "";
                $data['sender_id_show'] = "";
                $data['payload'] = "无效hash";
                $data['username'] = "匿名";
                $data['uactive'] = "0";
                $data['utctime'] = "0";
                $data['portrait'] = "/assets/images/avatars/null.jpg";
                $data['commsum'] = "0";
                $data['love']  = "0";
            }
        }
    return $data;
    }
    
    public function inContent($hash){
    //写入主帖
        $this->load->database();
        //查询hash是否存在
        $sql_sel_tx="SELECT hash FROM wet_content WHERE hash='$hash' LIMIT 1";
        $counttx = $this->db->query($sql_sel_tx);
        if($counttx->num_rows()==0){

            //对接收内容解析
            $this->load->model('Judge');
            $wetjson = $this->Judge->hash($hash,'Content');
            $wethash = !empty($wetjson['hash'])?$wetjson['hash']:null;
            $wetsend = !empty($wetjson['tx']['sender_id'])?$wetjson['tx']['sender_id']:null;
            $wetrecp = !empty($wetjson['tx']['recipient_id'])?$wetjson['tx']['recipient_id']:null;
            $wetamot = !empty($wetjson['tx']['amount'])?$wetjson['tx']['amount']:null;
            $wettime = !empty($wetjson['block_time'])?$wetjson['block_time']:null;

            $wetjspl = !empty($wetjson['tx']['payload'])?$wetjson['tx']['payload']:null;
            $paylhex = $this->Judge->HexPayload($wetjspl);
            $wetarr = (array) json_decode($paylhex,true);
            
            $wettype = !empty($wetarr['content_type'])?$wetarr['content_type']:null;
            $wetpaylo = !empty($wetarr['wet_content'])?$wetarr['wet_content']:null;
            $wetpayl = htmlspecialchars($wetpaylo,ENT_QUOTES);

            $wetimg = !empty($wetarr['img_list'])?$wetarr['img_list']:null;
            if($wetimg!=null){$wetimgtx=$wethash;}else{$wetimgtx="";}
            
            //入库
            $sql_in_content="INSERT INTO wet_content(hash,sender_id,recipient_id,utctime,amount,content_type,payload,imgtx) VALUES ('$wethash','$wetsend','$wetrecp','$wettime','$wetamot','$wettype','$wetpayl','$wetimgtx')";
            $this->db->query($sql_in_content);

			//用户活跃搜索及入库
			$this->load->model('Users');
			$this->Users->userActive($wetsend,$uactive=5);
            
        //入库行为记录
        $sql_in_beh="INSERT INTO wet_behavior(address,hash,thing,influence,toaddress) VALUES ('$wetsend','$wethash','$wettype','5','$wetrecp')";
        $this->db->query($sql_in_beh);

        //删除临时缓存
        $sql_del_tp="DELETE FROM wet_temporary WHERE tp_hash='$hash'";
        $this->db->query($sql_del_tp);
        }else{
            //删除临时缓存
            $sql_del_tp="DELETE FROM wet_temporary WHERE tp_hash='$hash'";
            $this->db->query($sql_del_tp);
            echo "重复提交";
        }
    }

}