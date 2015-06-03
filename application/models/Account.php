<?php
/*
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-5-8
 * Time: 下午4:05
 */
class AccountModel extends HaloModel{

    /*
     * 验证用户登录
     */
    public function checkLogin($usernmae,$password){
        return  $this->getRowByCondition('im_account',sprintf("username='%s' AND password='%s'", $usernmae,md5($password)));
    }
}
?>