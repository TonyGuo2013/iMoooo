<?php
/*
 * @name IndexController
 * @author yexuan.guo@gmail.com
 * @desc 默认控制器
 * @lastModify 2015年04月29日16:45:16 Review Code.
 */
class IndexController extends BaseController {

	public function indexAction() {
        return TRUE;
	}

    public function aaAction()
    {
        print_R($_SERVER);
    }

    public function infoAction()
    {
        phpinfo();
    }
}
