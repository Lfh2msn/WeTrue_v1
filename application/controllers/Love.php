<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Love extends CI_Controller {

    public function Content(){
    //主帖点赞
        $hash = $this->input->get_post('txhash');
        $sender_id = $this->input->get_post('sender_id');
        $this->load->model('Judge');
        $Jhash=$this->Judge->hashAndID($hash);
        $Jsender_id=$this->Judge->hashAndID($sender_id);
        $this->load->model('Loves');
        $data=$this->Loves->Lovezan($Jhash,$Jsender_id);
        return $data;
        $this->load->view('null',$data,true);
    }

    public function Comment(){
    //评论点赞
        $hash = $this->input->get_post('txhash');
        $sender_id = $this->input->get_post('sender_id');
        $this->load->model('Judge');
        $Jhash=$this->Judge->hashAndID($hash);
        $Jsender_id=$this->Judge->hashAndID($sender_id);
        $this->load->model('Loves');
        $data=$this->Loves->CommLovezan($Jhash,$Jsender_id);
        return $data;
        $this->load->view('null',$data,true);
    }

}
