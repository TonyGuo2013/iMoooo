<?php
/*
 * ApiController
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-7-3
 * Time: 下午10:05
 */

class ApiController extends ApiBaseController{

    public function init(){
    }

    /*
     * 获取HTTP头信息
     */
    public function getDeviceInfoAction(){
        if($this->getRequest()->isPost()){
            echo json_encode($_SERVER);
        }else{
            echo json_encode('请用POST对接!Thanks u~');
        }
    }


}

?>