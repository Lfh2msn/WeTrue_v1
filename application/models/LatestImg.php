<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LatestImg extends CI_Model {

    public function GetImg($pageNum,$pageLimit){
    //获取 最新图片
        if($pageNum<1){$pageNum=1;}
        if($pageLimit<1){$pageLimit=1;}

        $this->load->database();
        $sql="SELECT count(*) from wet_content WHERE imgtx <> ''";
        $query = $this->db->query($sql);
        $row = $query->row();
        $totalSize=$row->count;//总数量
        $totalPage=ceil($totalSize/$pageLimit);//总页数
        $sql="SELECT hash,imgtx from wet_content WHERE imgtx <> '' order by utctime desc LIMIT $pageLimit offset ".($pageNum-1)*$pageLimit;
        $query = $this->db->query($sql);

        $todata['pageNum'] = $pageNum;//数量
        $todata['pageLimit'] = $pageLimit;//数量
        $todata['totalPage'] = $totalPage;//总页数
        $todata['totalSize'] = $totalSize;//总数

        foreach ($query->result() as $row){
            $hash = $row->hash;
            $todata['hash'] = $hash;
            $this->load->model('Judge');
            $Judge_Hash = $this->Judge->TxBloom($hash);
            if($Judge_Hash=="ok"){
                $imgtx_sc = $row->imgtx;
                $todata['imgtx'] =  htmlentities($imgtx_sc);
            }else{
                $todata['imgtx']   = "";
            }
            $atodata[] = $todata;//返回内容
            $data = json_encode($atodata);
        }
        return $data;
    }

}