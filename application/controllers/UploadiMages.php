<?php
/*
 * Created by PhpStorm.
 * User: YexuanGuo
 * Date: 15-7-3
 * Time: 下午2015年07月03日23:51:45
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
            $isSuccessBool = $this->iMagesModel->UploadiMagesToDir($_FILES['pictures'],$_POST);
            if($isSuccessBool){
                echo "<script>alert('Sweet! Success!!');window.location.href='/systemadmin/home'</script>";
            }else{
                echo "<script>alert('Nopo! Error!! Please check it Or Send EMail:guoyeuxan@imoooo.com.Tnx u .');</script>";
            }
        }
        return false;
    }
}
?>