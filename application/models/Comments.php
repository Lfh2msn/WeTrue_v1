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

        $todata['pageNum'] = $pageNum;//数量
        $todata['pageLimit'] = $pageLimit;//数量
        $todata['totalPage'] = $totalPage;//总页数
        $todata['totalSize'] = $totalSize;//总数


        $sql="SELECT * from wet_comment WHERE to_hash='$hash' order by uid desc";
        $query = $this->db->query($sql);

        foreach ($query->result() as $row){
            $sender_id = $row->sender_id;
            $todata['sender_id'] = $sender_id;
            $todata['sender_id_show'] = substr($sender_id,-5);
            $rp_hash = $row->hash;
            $this->load->model('Judge');
            $Judge_Hash = $this->Judge->TxBloom($rp_hash);
            if($Judge_Hash=="ok"){
				$inpayload = $row->payload;
                $todata['payload']   = html_entity_decode($inpayload);
            }else{
                $todata['payload']   = "Details TX_Hash：&#13;{$hash}";
            }
            $todata['utctime'] = $row->utctime;
            $todata['commsum'] = $row->commsum;
            $todata['hash'] = $rp_hash;
            $todata['love'] = $row->love;

            $sql="SELECT * from wet_users WHERE address='$sender_id' LIMIT 1";
            $query = $this->db->query($sql);
                if ($query->num_rows() > 0){

                    $row = $query->row(); 
                    $username_sc = $row->username;
                    if($username_sc==''){
						$todata['username'] = "Null";
					}else{
						$todata['username'] = htmlentities($username_sc);
					}
                    $uactive_sc = $row->uactive;
                    $todata['uactive'] = $this->Judge->GetActiveGrade($uactive_sc);
                    $portrait_sc = $row->portrait;
                    if($portrait_sc==''){
                        $todata['portrait'] = "/assets/images/avatars/null.jpg";
                    }else{
                        $todata['portrait'] =  htmlentities($portrait_sc);
                    }
                }else{
                    $todata['username'] = "匿名";
                    $todata['portrait'] = "/assets/images/avatars/null.jpg";
                }
            $atodata[] = $todata;//返回内容
            $data = json_encode($atodata);
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
            $wetjson = $this->Judge->hash($hash,'Comment');
            $wethash = !empty($wetjson['hash'])?$wetjson['hash']:null;
            $wetsend = !empty($wetjson['tx']['sender_id'])?$wetjson['tx']['sender_id']:null;
            $wetrecp = !empty($wetjson['tx']['recipient_id'])?$wetjson['tx']['recipient_id']:null;
            $wetamot = !empty($wetjson['tx']['amount'])?$wetjson['tx']['amount']:null;
            $wettime = !empty($wetjson['block_time'])?$wetjson['block_time']:null;

            $wetjspl = !empty($wetjson['tx']['payload'])?$wetjson['tx']['payload']:null;
            $paylhex = $this->Judge->HexPayload($wetjspl);
            $wetarr = (array) json_decode($paylhex,true);
            
            $wettotx = !empty($wetarr['to_hash'])?$wetarr['to_hash']:null;
            $wettype = !empty($wetarr['content_type'])?$wetarr['content_type']:null;
            $wetpaylo = !empty($wetarr['wet_content'])?$wetarr['wet_content']:null;
            $wetpayl = htmlspecialchars($wetpaylo,ENT_QUOTES);

            //查询评论目标hash是否存在主帖
            $sql_sel_totx="SELECT hash FROM wet_content WHERE hash='$wettotx' LIMIT 1";
            $conTotx = $this->db->query($sql_sel_totx);

            if($conTotx->num_rows()==0){
                //查询评论目标hash是否存在
                $sql_sel_totx="SELECT hash,to_hash FROM wet_comment WHERE hash='$wettotx' LIMIT 1";
                $comTotx = $this->db->query($sql_sel_totx);
                    
                if($comTotx->num_rows()==0){
                    echo "帖子不存在";
                    return;
                }else{

                    //评论主贴计数+1
                    $sql_update="UPDATE wet_comment SET commsum=commsum+1 WHERE hash='$wettotx'";
                    $this->db->query($sql_update);
                    //一级表关联查询
                    $sql_join = "SELECT wet_content.hash,wet_comment.to_hash FROM wet_comment 
                    			INNER JOIN wet_content ON wet_comment.to_hash=wet_content.hash 
                    			AND wet_comment.hash='$wettotx'";
                    $query = $this->db->query($sql_join);
                    if($query->num_rows()==0){
                    }else{
                        //主贴评论计数+1
	                    $tohash = $query->result()[0]->to_hash;
		                $sql_update="UPDATE wet_content SET commsum=commsum+1 WHERE hash='$tohash'";
		                $this->db->query($sql_update);
                        $this->output->delete_cache('/Content/Tx/'.$tohash);
                        $this->output->delete_cache('/Comment/Tx/'.$tohash);
                    }
                }
            }else{

                //主贴评论计数+1
                $sql_update="UPDATE wet_content SET commsum=commsum+1 WHERE hash='$wettotx'";
                $this->db->query($sql_update);
            }

            //入库评论
            $sql_in="INSERT INTO wet_comment(hash,to_hash,sender_id,recipient_id,utctime,amount,content_type,payload) VALUES ('$wethash','$wettotx','$wetsend','$wetrecp','$wettime','$wetamot','$wettype','$wetpayl')";
            $this->db->query($sql_in);

            //用户活跃搜索及入库
            $sql_sel_add="SELECT address FROM wet_users WHERE address='$wetsend' LIMIT 1";
            $countadd = $this->db->query($sql_sel_add);

                if($countadd->num_rows()==0){ //如果没有记录

                    $sql_in_users="INSERT INTO wet_users(address) VALUES ('$wetsend')";
                    $this->db->query($sql_in_users);
                    $sql_up_users="UPDATE wet_users SET uactive=uactive+5 WHERE address='$wetsend'";
                    $this->db->query($sql_up_users);
                }else{
                    $sql_up_users="UPDATE wet_users SET uactive=uactive+5 WHERE address='$wetsend'";
                    $this->db->query($sql_up_users);
                }

            //入库行为记录
            $sql_in_beh="INSERT INTO wet_behavior(address,hash,thing,influence,toaddress) VALUES ('$wetsend','$wethash','$wettype','5','$wetrecp')";
            $this->db->query($sql_in_beh);

            //删除临时缓存
            $sql_del_tp="DELETE FROM wet_temporary WHERE tp_hash='$hash'";
            $this->db->query($sql_del_tp);
            $this->output->delete_cache('/Content/Tx/'.$wettotx);
            $this->output->delete_cache('/Comment/Tx/'.$wettotx);
        }else{
            //删除临时缓存
            $sql_del_tp="DELETE FROM wet_temporary WHERE tp_hash='$hash'";
            $this->db->query($sql_del_tp);
            echo "重复提交";
        }
    }
}