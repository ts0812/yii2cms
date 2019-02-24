<?php
namespace common\common;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class Upload extends Model
{
    public function actionUpload()
    {
        $file = $_FILES;
        $file_name = $file['file']['name'];
        $file_tmp_path =$file['file']['tmp_name'];
        $dir = Yii::getAlias('@webroot')."/uploads/".date("Ymd");
        if (!is_dir($dir)){
            mkdir($dir,0777,true);
        }
        $type = substr(strrchr($file_name, '.'), 1);
        $mo = Config::findOne(['name'=>'WEB_SITE_ALLOW_UPLOAD_TYPE']);
        $allow_type = explode(',', $mo->value);
        if(!in_array($type, $allow_type)){
            die("请上传允许的文件格式");
        }
        $file_save_name = date("YmdHis",time()) . mt_rand(1000, 9999) . '.' . $type;
        move_uploaded_file($file_tmp_path, $dir.'/'.$file_save_name);
        echo json_encode(array("code"=>"200","data"=>$dir.'/'.$file_save_name);
    }
}
