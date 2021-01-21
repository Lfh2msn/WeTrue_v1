<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminConfig extends CI_Model {

    //管理员
    public function Manage($ak){
        $admin_1 = "ak_2kxt6D65giv4yNt4oa44SjW4jEXfoHMviPFvAreSEXvz25Q3QQ";//Admin User 1
        $admin_2 = "";//Admin User 2
        $admin_3 = "";//Admin User 3
        $admin_4 = "";
        $admin_5 = "";

        if($ak==$admin_1||$ak==$admin_2||$ak==$admin_3){
            return "ok";
        }else{
            return "err";
        }
    }
}