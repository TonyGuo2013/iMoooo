<?php
/**
 * Created by PhpStorm.
 * User: YexuanGuo@gmail.com
 * Date: 15-2-9
 * Time: 下午7:08
 */

class AboutmeController extends BaseController
{

    /**
     * @return bool
     * default reason page
     * time 2015年02月09日19:10:14
     */
    public function indexAction()
    {
//        $ip = $_SERVER['REMOTE_ADDR'];
//        $visitor = json_decode(file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=".$ip),TRUE);
//
//        $country =  $visitor['data']['country'];
//        $ip      =  $visitor['data']['ip'];

        if($this->isMobile())
        {
            if(preg_match("/(" .'iphone' . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                $this->_view->title = '郭烨轩的简历iPhone版';
            }
            else if(preg_match("/(" .'android' . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                $this->_view->title = '郭烨轩的简历Android版';
            }
            else if(preg_match("/(" .'ipad' . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                $this->_view->title = '郭烨轩的简历iPad版';
            }
            else
            {
                $this->_view->title = '您正在移动设上查看郭烨轩的简历..';
            }
            return true;
        }
        else
        {
            $this->_view->title = '郭烨轩简历预览';
            return true;
        }
    }
}
?>