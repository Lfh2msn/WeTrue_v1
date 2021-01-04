<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

    public function Tx(){
    //用户举报
        $rp_hash = $this->input->get_post('rp_hash');
        $rp_sender_id = $this->input->get_post('rp_sender_id');
        $informant = $this->input->get_post('informant');
        $this->load->model('Judge');
        $Jhash=$this->Judge->hashAndID($rp_hash);
        $Jsender_id=$this->Judge->hashAndID($rp_sender_id);
        $Jinformant=$this->Judge->hashAndID($informant);
        $this->load->model('Reports');
        $data = $this->Reports->RpTx($Jhash,$Jsender_id,$Jinformant);
    }

}
