<?php
/**
 * Created by JetBrains PhpStorm.
 * User: YexuanGuo
 * Date: 15-2-8
 * Time: 下午6:46
 * To change this template use File | Settings | File Templates.
 */

class BaseController extends YafController
{
    public function init()
    {
    }

    public function doInit()
    {

    }

    public function jumpDirect($url='/')
    {
        header('Location: '.$url);
    }
    /**
     * @param $time
     * @return bool|string
     * 根据时间显示刚刚,几分钟前,几小时前
     * @author yexuan.guo@yolu-inc.com
     */

    public function tranTime($time)
    {
        $rtime = date("m-d H:i",$time);
        $htime = date("H:i",$time);

        $time = time() - $time;

        if ($time < 60)
        {
            $str = '刚刚';
        }
        elseif ($time < 60 * 60)
        {
            $min = floor($time/60);
            $str = $min.'分钟前';
        }
        elseif ($time < 60 * 60 * 24)
        {
            $h = floor($time/(60*60));
            $str = $h.'小时前 '.$htime;
        }
        elseif ($time < 60 * 60 * 24 * 3)
        {
            $d = floor($time/(60*60*24));
            if($d==1)
                $str = '昨天 '.$rtime;
            else
                $str = '前天 '.$rtime;
        }
        else
        {
            $str = $rtime;
        }
        return $str;
    }
    /***
     * @return bool
     * 判断是手机访问还是电脑访问
     * @author yexuan.guo@yolu-inc.com
     */

    public function isMobile(){
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])){
            return true;
        }
        //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            //找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        //脑残判断手机发送的客户端标志,兼容性有待提高,有新设备直接添加USERAGENT到数组就OK
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array (
                'nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        //协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;


    }

    /**
     * @param $user_agent
     * @return bool
     * 判断是否在微信浏览器打开
     * @author yexuan.guo@yolu-inc.com
     */
    public function isWechat($user_agent)
    {
        $is_wechat = strpos($user_agent, 'MicroMessenger');
        if ($is_wechat)
        {
            return true;
        }
        else
        {
            // get wechat version.
            // preg_match('/.*?(MicroMessenger\/([0-9.]+))\s*/', $user_agent, $matches);
            // echo '<br>Version:'.$matches[2];
            return false;
        }
    }

    /**
     * @param $data
     * @param $key
     * @return mixed
     * URL参数加密
     * @author yexuan.guo@yolu-inc.com
     */
    public function encrypt($data, $key)
    {
        $key = md5($key);
        $x   = 0;
        $len = strlen($data);
        $l   = strlen($key);

        $char = '';
        $str = '';
        for ($i = 0; $i < $len; $i++)         //前缀KEY
        {
            if($x == $l)
            {
                $x = 0;
            }
            $char .= $key[$x];
            $x++;
        }
        for($i = 0; $i < $len; $i++)          //用户UID
        {
            $str .= chr(ord($data[$i]) + (ord($char[$i])) % 256);
        }
        return str_replace('=',"",base64_encode($str));
    }

    /**
     * @param $data
     * @param $key
     * @return string
     * URL 参数解密
     * @author yexuan.guo@yolu-inc.com
     */
    public function decrypt($data, $key)
    {
        $key = md5($key);
        $x = 0;
        $data = base64_decode($data);
        $len = strlen($data);
        $l = strlen($key);
        $char = '';
        $str  = '';
        for ($i = 0; $i < $len; $i++)
        {
            if ($x == $l)
            {
                $x = 0;
            }
            $char .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++)
        {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
            {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            }
            else
            {
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return $str;
    }

    /**
     * 算法,另外还有192和256两种长度
     */
    const CIPHER = MCRYPT_RIJNDAEL_128;
    /**
     * 模式
     */
    const MODE = MCRYPT_MODE_ECB;

    /**
     * 加密
     * @param string $key	密钥
     * @param string $str	需加密的字符串
     * @return type
     * @author yexuan.guo@yolu-inc.com
     */
    static public function encode($key, $str ){

        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB, $iv));

    }
    /**
     * 解密
     * @param type $key
     * @param type $str
     * @return type
     * @author yexuan.guo@yolu-inc.com
     */
    static public function decode($key,$str){
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        return mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$key,base64_decode($str),MCRYPT_MODE_ECB,$iv);
    }

    /**
     * @param $before
     * @param $after
     * @return string
     * 时间戳计算年龄
     * @author yexuan.guo@yolu-inc.com
     */

    static public function FormatBirthday($before, $after)
    {
        if ($before>$after){
            $b = getdate($after);
            $a = getdate($before);
        }
        else {
            $b = getdate($before);
            $a = getdate($after);
        }
        $n = array(1=>31,2=>28,3=>31,4=>30,5=>31,6=>30,7=>31,8=>31,9=>30,10=>31,11=>30,12=>31);
        $y=$m=$d=0;
        if ($a['mday']>=$b['mday']) { //天相减为正
            if ($a['mon']>=$b['mon']) {//月相减为正
                $y=$a['year']-$b['year'];$m=$a['mon']-$b['mon'];
            }
            else { //月相减为负，借年
                $y=$a['year']-$b['year']-1;$m=$a['mon']-$b['mon']+12;
            }
            $d=$a['mday']-$b['mday'];
        }
        else {  //天相减为负，借月
            if ($a['mon']==1) { //1月，借年
                $y=$a['year']-$b['year']-1;$m=$a['mon']-$b['mon']+12;$d=$a['mday']-$b['mday']+$n[12];
            }
            else {
                if ($a['mon']==3) { //3月，判断闰年取得2月天数
                    $d=$a['mday']-$b['mday']+($a['year']%4==0?29:28);
                }
                else {
                    $d=$a['mday']-$b['mday']+$n[$a['mon']-1];
                }
                if ($a['mon']>=$b['mon']+1) { //借月后，月相减为正
                    $y=$a['year']-$b['year'];$m=$a['mon']-$b['mon']-1;
                }
                else { //借月后，月相减为负，借年
                    $y=$a['year']-$b['year']-1;$m=$a['mon']-$b['mon']+12-1;
                }
            }
        }
        // return ($y==0?'':$y.'岁').($m==0?'':$m.'个月').($d==0?'':$d.'天');
        return ($y==0?'0岁':$y.'岁');
    }
}