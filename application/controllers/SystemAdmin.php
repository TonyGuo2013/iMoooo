<?php
/*
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-7-5
 * Time: 下午22:03:
 */

class SystemAdminController extends BaseController{

    protected $userModel = NULL;

    public function init(){
        parent::init();
        $this->userModel = new AccountModel();
    }
    public function indexAction()
    {
        RETURN TRUE;
    }

    public function LoginAction()
    {

        if($this->getRequest()->isPost()){
            $params['username'] = $this->getLegalParam('username','str');
            $params['password'] = $this->getLegalParam('password','str');
            if(empty($params['username']) || empty($params['password'])){
                echo "Please check username Or Password!";
                return false;
            }else{
                    $user = $this->userModel->checkLogin($params['username'],$params['password']);
                    if($user){
                        SessionModel::Login($user);
                        echo 1;
                        return false;
                    }else{
                        echo  "username Or password Error ~!";
                        return false;
                    }
            }
        }else{
            echo "POST_ERROR";
            return false;
        }
    }
    public function HomeAction(){
        return true;
    }
}
?>