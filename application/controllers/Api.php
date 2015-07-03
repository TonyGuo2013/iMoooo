<?php
/*
 * ApiController
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-7-3
 * Time: 下午10:05
 */

class ApiController extends BaseController{

    public function init(){}

    public function getDeviceInfoAction(){
        if($this->getRequest()->isPost()){
            return json_encode($_SERVER);
        }else{
            return json_encode('请用POST对接!Thanks u~');
        }
    }
}

?>