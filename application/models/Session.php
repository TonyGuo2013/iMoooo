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
        if(!$user){
            return ;
        }
        if(!self::HasLogin()){
            $_SESSION['uid']       = $user['id'];
            $_SESSION['username '] = $user['username'];
        }
    }
    /*
     * 登出
     */
    static public function Logout(){
        session_destroy();
    }
}
?>