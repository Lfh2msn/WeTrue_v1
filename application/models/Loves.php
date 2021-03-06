<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loves extends CI_Model {

    public function Lovezan($hash,$sender_id) {
    //主帖点赞入库
        $this->load->database();

        //查询点赞目标hash是否存在
        $sql_sel_totx="SELECT hash FROM wet_content WHERE hash='$hash' LIMIT 1";
        $counttotx = $this->db->query($sql_sel_totx);

        if($counttotx->num_rows()==0){
            echo "ERROR";
        }else{

            $senderid_sql="SELECT hash FROM wet_love WHERE hash='$hash' and sender_id='$sender_id' LIMIT 1";
            $count = $this->db->query($senderid_sql);

            if($count->num_rows()==0){ //如果没有记录

                $sql_update="UPDATE wet_content SET love=love+1 WHERE hash='$hash'";
                $this->db->query($sql_update);

                $sql_in="INSERT INTO wet_love(hash,sender_id) VALUES ('$hash','$sender_id')";
                $this->db->query($sql_in);

                //用户活跃搜索及入库
			$this->load->model('Users');
			$this->Users->userActive($sender_id,$active=1);

            //入库行为记录
            $sql_in_beh="INSERT INTO wet_behavior(address,thing,influence,toaddress) VALUES ('$sender_id','con_zan','1','$hash')";
            $this->db->query($sql_in_beh);

                $sql="SELECT love FROM wet_content WHERE hash='$hash' LIMIT 1";
                $query = $this->db->query($sql)->row_array();
                $love = $query['love'];
                $this->output->delete_cache('/Content/Tx/'.$hash);
                $this->output->delete_cache('/Comment/Tx/'.$hash);
                echo $love;
            }
            else{
                echo "已赞";
            }
        }
    }

    public function CommLovezan($hash,$sender_id) {
    //评论点赞入库
        $this->load->database();

        //查询点赞目标hash是否存在
        $sql_sel_totx="SELECT hash FROM wet_comment WHERE hash='$hash' LIMIT 1";
        $counttotx = $this->db->query($sql_sel_totx);

        if($counttotx->num_rows()==0){
            echo "ERROR";
        }else{

            $senderid_sql="SELECT hash FROM wet_love WHERE hash='$hash' and sender_id='$sender_id' LIMIT 1";
            $count = $this->db->query($senderid_sql);

            if($count->num_rows()==0){ //如果没有记录

                $sql_update="UPDATE wet_comment SET love=love+1 WHERE hash='$hash'";
                $this->db->query($sql_update);

                //一级表关联查询
                $sql_join = "SELECT wet_content.hash,wet_comment.to_hash FROM wet_comment 
                                INNER JOIN wet_content ON wet_comment.to_hash=wet_content.hash 
                                AND wet_comment.hash='$hash'";
                $query = $this->db->query($sql_join);
                if($query->num_rows()==0){
                    
                }else{
                    //主贴点赞计数+1
                    $tohash = $query->result()[0]->to_hash;
                    $sql_update="UPDATE wet_content SET love=love+1 WHERE hash='$tohash'";
                    $this->db->query($sql_update);
                    $this->output->delete_cache('/Content/Tx/'.$tohash);
                    $this->output->delete_cache('/Comment/Tx/'.$tohash);
                }

                $sql_in="INSERT INTO wet_love(hash,sender_id) VALUES ('$hash','$sender_id')";
                $this->db->query($sql_in);

                //用户活跃搜索及入库
				$this->load->model('Users');
				$this->Users->userActive($sender_id,$uactive=1);

				//入库行为记录
				$sql_in_beh="INSERT INTO wet_behavior(address,thing,influence,toaddress) VALUES ('$sender_id','com_zan','1','$hash')";
				$this->db->query($sql_in_beh);

                $sql="SELECT love FROM wet_comment WHERE hash='$hash' LIMIT 1";
                $query = $this->db->query($sql)->row_array();
                $love = $query['love'];
                $this->output->delete_cache('/Content/Tx/'.$hash);
                $this->output->delete_cache('/Comment/Tx/'.$hash);
                echo $love;
            }
            else{
                echo "已赞";
            }
        }
    }
}