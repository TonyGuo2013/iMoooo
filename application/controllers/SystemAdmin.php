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
                return "Please check username Or Password!";
            }else{
                if(empty($params['username'])){
                    return "Please enter username";
                }elseif(empty($params['password'])){
                    return "Please enter password";
                }else{
                    $user = $this->userModel->checkLogin($params['username'],$params['password']);
                    if($user){
                        SessionModel::Login($user);
                        parent::jumpDirect('/systemadmin/home');
                    }
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