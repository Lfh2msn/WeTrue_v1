<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminConfig extends CI_Model {

    public function Manage($ak){
	//管理员校验
		$this->load->model('Config');
		$wetConfig = $this->Config->WetConfig();
        $admin_1 = $wetConfig['adminUser_1'];
		$admin_2 = $wetConfig['adminUser_2'];
		$admin_3 = $wetConfig['adminUser_3'];

        if(($ak==$admin_1 && $admin_1 != "") || ($ak==$admin_2 && $admin_2 != "") || ($ak==$admin_3 && $admin_3 != "")){
            return "ok";
        } else {
            return "err";
        }
    }
}