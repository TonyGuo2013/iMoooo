<?php
/*
 * @name IndexController
 * @author yexuan.guo@gmail.com
 * @desc 默认控制器
 * @lastModify 2015年04月29日16:45:16 Review Code.
 */

class SampleModel {
    public function __construct() {
    }   
    
    public function selectSample() {
        return 'Hello World!';
    }

    public function insertSample($arrInfo) {
        return true;
    }
}
