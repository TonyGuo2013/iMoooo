<?php
/*
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-6-3
 * Time: 下午4:29
 */
class SessionModel extends HaloModel{

    static public function HasLogin(){
        return empty($_SESSION['uid']);
    }

    static public function Login($user){
        if(empty($user)){
            return ;
        }
        setcookie('uid',$user['id'],time()+1800);
        setcookie('username',$user['username'],time()+1800);
    }
    /*
     * 登出
     */
    static public function Logout(){
//        session_destroy();
        setcookie("uid", "",time()-3600);
        setcookie("username", "",time()-3600);
    }
}
?>