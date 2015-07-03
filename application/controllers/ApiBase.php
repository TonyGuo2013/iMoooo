<?php
/*
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-7-3
 * Time: 下午10:34
 */

class ApiBaseController extends YafController{

    /*
     * 设置Json返回格式为:Text/json
     */
    public function  init(){
        header('Content-type:text/json');
    }
}

?>