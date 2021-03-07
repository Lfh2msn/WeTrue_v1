<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HotPost extends CI_Model {

    public function GetHotPosts($pageNum,$pageLimit){
    //分页数据-热点推荐
        if($pageNum<1){$pageNum=1;}
        if($pageLimit<1){$pageLimit=1;}

        $this->load->database();
		$this->load->model('Config');
		$wetConfig = $this->Config->WetConfig();
        $FifteenTime = (time()-60 * 60 *24 * $wetConfig['hotPostDay'])*1000;//86400秒*x天*1000毫秒
        $sql="SELECT count(*) from wet_content WHERE utctime >= $FifteenTime";
        $query = $this->db->query($sql);
        $row = $query->row();
        $totalSize=$row->count;//总数量
        $totalPage=ceil($totalSize/$pageLimit);//总页数
        
        $todata['pageNum'] = $pageNum;//数量
        $todata['pageLimit'] = $pageLimit;//数量
        $todata['totalPage'] = $totalPage;//总页数
        $todata['totalSize'] = $totalSize;//总数
		$query->free_result();  //释放$query

		$sql = "SELECT hash,sender_id,utctime,payload,imgtx,love,commsum FROM wet_content 
                WHERE utctime >= $FifteenTime ORDER BY (love+commsum) DESC 
                LIMIT $pageLimit offset ".($pageNum-1)*$pageLimit;
        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            $hash = $row->hash;
            $todata['hash'] = $hash;
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
                $todata['imgtx'] = htmlentities($imgtx_sc);
            }else{
                $todata['payload'] = "Details TX_Hash：&#13;{$hash}";
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

}