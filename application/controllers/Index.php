<?php
/*
 * @name IndexController
 * @author yexuan.guo@gmail.com
 * @desc 默认控制器
 * @lastModify 2015年04月29日16:45:16 Review Code.
 */
class IndexController extends BaseController {

	public function indexAction() {
        if(parent::isMobile()){
            echo '手机版照片墙敬请期待..'."<br /><br />";
            echo 'Version:2015年06月15日20:08:24'."<br /><br />";
            echo 'Author:TonyGuo'."<br /><br />";;
            echo 'Email:GuoYexuan@imoooo.cn';
            return false;
        }else{
            return true;
        }
	}

    public function getImagesPathAction(){
        echo "<pre>";
        print_R($_SERVER);
        return false;
    }
}
