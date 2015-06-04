<?php
/*
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-5-8
 * Time: 上午9:19
 */

class SystemAdminController extends BaseController{

    protected $userModel = NULL;

    public function init(){
        parent::init();
        $this->userModel = new AccountModel();
        if(empty($this->uid)){
            $this->redirect('index');
            return false;
        }

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
                        print_R($_COOKIE);
                        print_R($user);
                        die;
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