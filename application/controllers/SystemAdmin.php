<?php
/*
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-5-8
 * Time: 上午9:19
 */

class SystemAdminController extends BaseController{

    public function indexAction()
    {
        RETURN TRUE;
    }

    public function LoginAction()
    {
        if($this->getRequest()->isPost()){
            $params['usernmae'] = $this->getLegalParam('username','str');
            $params['password'] = $this->getLegalParam('password','str');
//            $r = new AccountModel();
//            print_R($r->Login());
//            die;
            return false;
        }else{
            echo "POST_ERROR";
            return false;
        }
    }
}
?>