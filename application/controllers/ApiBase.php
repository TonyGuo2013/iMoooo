<?php
/*
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-7-3
 * Time: 2015年07月03日23:50:35
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