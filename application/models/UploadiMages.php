<?php
/*
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-6-12
 * Time: 下午2:31
 * LastModify:2015年07月02日14:28:13
 */
class UploadiMagesModel extends HaloModel{

    private $arrType = NULL;
    protected $_permited = array(
        'image/gif',
        'image/jpeg',
        'image/jpg',
        'image/bmp',
        'image/pjpeg',
        'image/x-png'
    );
    protected $maxsize = 21000000;  //2MB
    /*
     * 创建目录
     */
    public function CreateUploadDirByTime(){
        $data['file_path'] = $_SERVER['DOCUMENT_ROOT'].'uploads/images/'.date("Y").'/'.date("m").'/'.date("d").'/';
        $data['file_name'] = date("Ymd").date("his").rand(1,999999).rand(1,999999);
        return $data;
    }

    /*
     * 检测上传文件状态
     */
    public function checkUploadiMagesByError($error){
        switch($error){
            case 0  : return true;
            case 1  : return '上传文件过大PHP';
            case 2  : return '上传文件过大HTML';
            case 3  : return '文件只有部分被上传';
            case 4  : return '没有文件上上传啊';
            case 5  : return '找不到临时文件夹';
            case 7  : return '文件写入失败';
            default : return '未知错误,请从新上传文件';
        }
    }

    /*
     * 判断图片类型
     */
    public function checkType($filename){
        if (!in_array(strtolower($filename), $this->_permited)){
//            return "该文件类型是不被允许的上传类型";
             return false;
        }else {
            return true;
        }
    }

    /*
     * 创建图片上传目录
     */
    public function mkdirByTime($path){
        if(is_dir($path)){
            return true;
        }
        //父目录存在或者是需要创建才能调用mkdir
        return is_dir(dirname($path)) || self::mkdirByTime(dirname($path)) ? mkdir($path) : false;
    }

    /*
     * 处理文件
     */
    public function UploadiMagesToDir($Picture,$Formdesc){
        $picExtension['extension'] = pathinfo($Picture['name'])['extension'];
        if($Picture['size'] > $this->maxsize || !$this->checkType($Picture['type'])){
             return 'Please check U upload file type.Thank u ~';
        }
        if($this->checkUploadiMagesByError($Picture['error'])){
             if($this->checkType($Picture['type'])){
                 $path = $this->CreateUploadDirByTime();
                 $this->mkdirByTime($path['file_path']);
                 /*文件夹赋权限*/
                 @chmod($path['file_path'],0777);

                 if(move_uploaded_file($Picture['tmp_name'],$path['file_path'].$path['file_name'].".".$picExtension['extension'])){

                     $Formdesc['pic_name']      = $path['file_name'].".".$picExtension['extension'];
                     $Formdesc['pic_desc']      = $Formdesc['con_desc'];
                     $Formdesc['camera_device'] = $Formdesc['device'];
                     $Formdesc['add_time']      = time();
                     $Formdesc['opertion_user_id'] = $_SESSION['uid'];
                     unset($Formdesc['con_desc'],$Formdesc['device'],$Formdesc['device']);

                     $UploadPicId = $this->insertTable('im_feed',$Formdesc);
                     if($UploadPicId){
                         return 200;
                     }

                 }else{
                     return 'Move Pic Error~:(';
                 }
             }else{
                 exit('File Type Error ~ Please check it.');
             }
        }
    }
}
?>