<?php
/*
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-6-10
 * Time: 下午8:17
 */
class UploadiMagesController extends BaseController{

    protected $iMagesModel = NULL;

    public function init(){
        $this->iMagesModel = new UploadiMagesModel();
    }

    public function indexAction(){
        if($_FILES['pictures']['error'] > 0){
            echo  'error:'.$this->iMagesModel->checkUploadiMagesByError($_FILES['pictures']['error']);
            return false;
        }else{
            $this->iMagesModel->UploadiMagesToDir($_FILES['pictures'],$_POST);
        }
        die;
    }
}
?>