<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends CI_Model {

    public function GetComment($pageNum,$pageLimit,$hash){
    //分页数据-获取评论
        if($pageNum<1){$pageNum=1;}
        if($pageLimit<1){$pageLimit=1;}
        $pageNum=$pageNum; //第几页
        $pageLimit=$pageLimit; //几条

        $this->load->database();
        $sql="SELECT count(*) from wet_comment WHERE to_hash='$hash'";
        $query = $this->db->query($sql);
        $row = $query->row();
        $totalSize=$row->count;//总数量
        $totalPage=ceil($totalSize/$pageLimit);//总页数

        $to_data['pageNum'] = $pageNum;//数量
        $to_data['pageLimit'] = $pageLimit;//数量
        $to_data['totalPage'] = $totalPage;//总页数
        $to_data['totalSize'] = $totalSize;//总数
		$query->free_result();  //释放$query

        $sql="SELECT * from wet_comment WHERE to_hash='$hash' order by uid desc";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            $sender_id = $row->sender_id;
            $to_data['sender_id'] = $sender_id;
            $to_data['sender_id_show'] = substr($sender_id,-5);
            $rp_hash = $row->hash;
			$this->load->model('Judge');
            $Judge_Hash = $this->Judge->TxBloom($rp_hash);
            if($Judge_Hash=="ok"){
				$payload_Passed = $row->payload;
                $to_data['payload']   = html_entity_decode($payload_Passed);
            }else{
                $to_data['payload']   = "Details TX_Hash：&#13;{$hash}";
            }
            $to_data['utctime'] = $row->utctime;
            $to_data['commsum'] = $row->commsum;
            $to_data['hash'] = $rp_hash;
            $to_data['love'] = $row->love;
			$this->load->model('Users');
			$to_data['users'] = $this->Users->GetUser($sender_id);
            $arr_data[] = $to_data;//返回内容
            $data = json_encode($arr_data);
        }
    return $data;
    }

    public function inComment($hash){
    //写入评论
        //查询hash是否存在
        $this->load->database();
        $sql_sel_tx="SELECT hash FROM wet_comment WHERE hash='$hash' LIMIT 1";
        $counttx = $this->db->query($sql_sel_tx);

        if($counttx->num_rows()==0){
            //对接收内容解析
            $this->load->model('Judge');
            $wet_json = $this->Judge->hash($hash,'Comment');
            $wet_hash = !empty($wet_json['hash'])?$wet_json['hash']:null;
			$wet_time = !empty($wet_json['block_time'])?$wet_json['block_time']:null;
			$wet_amount = !empty($wet_json['tx']['amount'])?$wet_json['tx']['amount']:null;
            $wet_sender_id = !empty($wet_json['tx']['sender_id'])?$wet_json['tx']['sender_id']:null;
            $wet_recipient_id = !empty($wet_json['tx']['recipient_id'])?$wet_json['tx']['recipient_id']:null;

            $json_payload = !empty($wet_json['tx']['payload'])?$wet_json['tx']['payload']:null;
            $hex_payload = $this->Judge->HexPayload($json_payload);
            $wet_array = (array) json_decode($hex_payload,true);
            
            $wet_to_hash = !empty($wet_array['to_hash'])?$wet_array['to_hash']:null;
            $wet_type = !empty($wet_array['content_type'])?$wet_array['content_type']:null;
            $wet_payload_content = !empty($wet_array['wet_content'])?$wet_array['wet_content']:null;
            $wet_payload = htmlspecialchars($wet_payload_content,ENT_QUOTES);

            //查询评论目标hash是否存在主帖
            $sql="SELECT hash FROM wet_content WHERE hash='$wet_to_hash' LIMIT 1";
            $query_sql = $this->db->query($sql);

            if($query_sql->num_rows()==0){
                //查询评论目标hash是否存在
                $sql="SELECT hash,to_hash FROM wet_comment WHERE hash='$wet_to_hash' LIMIT 1";
                $comment_to_hash = $this->db->query($sql);
                    
                if($comment_to_hash->num_rows()==0){
                    echo "No Content";
                    return;
                }else{

                    //评论主贴计数+1
                    $sql_update="UPDATE wet_comment SET commsum=commsum+1 WHERE hash='$wet_to_hash'";
                    $this->db->query($sql_update);
                    //一级表关联查询
                    $sql_join = "SELECT wet_content.hash,wet_comment.to_hash FROM wet_comment 
                    			INNER JOIN wet_content ON wet_comment.to_hash=wet_content.hash 
                    			AND wet_comment.hash='$wet_to_hash'";
                    $query = $this->db->query($sql_join);
                    if($query->num_rows()==0){
                    }else{
                        //主贴评论计数+1
	                    $to_hash = $query->result()[0]->to_hash;
		                $sql_update="UPDATE wet_content SET commsum=commsum+1 WHERE hash='$tohash'";
		                $this->db->query($sql_update);
                        $this->output->delete_cache('/Content/Tx/'.$to_hash);
                        $this->output->delete_cache('/Comment/Tx/'.$to_hash);
                    }
                }
            }else{

                //主贴评论计数+1
                $sql_update="UPDATE wet_content SET commsum=commsum+1 WHERE hash='$wet_to_hash'";
                $this->db->query($sql_update);
            }

            //入库评论
            $sql_insert="INSERT INTO wet_comment(hash,to_hash,sender_id,recipient_id,utctime,amount,content_type,payload) VALUES ('$wet_hash','$wet_to_hash','$wet_sender_id','$wet_recipient_id','$wet_time','$wet_amount','$wet_type','$wet_payload')";
            $this->db->query($sql_insert);

            //用户活跃搜索及入库
			$this->load->model('Users');
			$this->Users->userActive($wet_sender_id,$active=2);

            //入库行为记录
            $sql_insert_behavior="INSERT INTO wet_behavior(address,hash,thing,influence,toaddress) VALUES ('$wet_sender_id','$wet_hash','$wet_type','2','$wet_recipient_id')";
            $this->db->query($sql_insert_behavior);

            //删除临时缓存
            $sql_del="DELETE FROM wet_temporary WHERE tp_hash='$hash'";
            $this->db->query($sql_del);
            $this->output->delete_cache('/Content/Tx/'.$wet_to_hash);
            $this->output->delete_cache('/Comment/Tx/'.$wet_to_hash);
        }else{
            //删除临时缓存
            $sql_del="DELETE FROM wet_temporary WHERE tp_hash='$hash'";
            $this->db->query($sql_del);
            echo "重复提交";
        }
    }
}