<?php
/**
 * @author Aaron Zhanglong <815818648@qq.com>
 * 多图上传组件
 * @Date: 2017-07-14
 */
use yii\helpers\Url;
use \common\models\Config;
$dir = "../../../resources/mini/".date("Ymd");
if (!is_dir($dir)){
    mkdir($dir,0777,true);
}

//$file_save_name = date("YmdHis",time()) . mt_rand(1000, 9999) . '.' . $type;
$url = Config::findOne(['name'=>'WEB_SITE_RESOURCES_URL'])->value .'/mini/'.date("Ymd");  //图片域名 目录
return [
    /* 上传图片配置项 */
    'fieldName' => "fileData", /* 提交的图片表单名称 */
    'maxSize' => 2097152, /* 上传大小限制，单位B */
    'allowFiles'=> [".png", ".jpg"], /* 上传图片格式显示 */
    'pathFormat'=> $url, /* 图片路径 目录 用户前端显示*/
    'uploadFilePath' => $dir, /* 文件保存绝对路径 目录   */
    'uploadType' => 'upload', //remote远程图片   base64 base64编码 upload 正常的上传方法,
    'serverUrl' => Url::to('/upload/upload_more'),
    'trueDelete' => 'true' //为TRUE是，点确定后， 将会把真实图片删除，为false时， 只会把父元素移除， 不会删除真实图片
];