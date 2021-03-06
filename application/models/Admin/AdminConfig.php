<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminConfig extends CI_Model {

    public function Config(){
	//配置
		return $data = array(
			'adminUser_1'    => 'ak_2kxt6D65giv4yNt4oa44SjW4jEXfoHMviPFvAreSEXvz25Q3QQ', // Admin User 1
			'adminUser_2'    => 'ak_2kxt6D65giv4yNt4oa44SjW4jEXfoHMviPFvAreSEXvz25Q3QQ',
			'adminUser_3'    => 'ak_2kxt6D65giv4yNt4oa44SjW4jEXfoHMviPFvAreSEXvz25Q3QQ',
		);
    }

    public function Manage($ak){
	//管理员校验
		$this->load->model('Admin/AdminConfig');
		$adminConfig = $this->AdminConfig->Config();
        $admin_1 = $adminConfig['adminUser_1'];
		$admin_2 = $adminConfig['adminUser_2'];
		$admin_3 = $adminConfig['adminUser_3'];

        if(($ak==$admin_1 && $admin_1 != "") || ($ak==$admin_2 && $admin_2 != "") || ($ak==$admin_3 && $admin_3 != "")){
            return "ok";
        } else {
            return "err";
        }
    }
}