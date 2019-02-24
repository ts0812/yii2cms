<?php
namespace common\common;

use Yii;
class FilePath
{

    //保护的目录
    public static $_path = '/var/file/';

    //获取标注key
    public static function inspectionFilePath(string $path)
    {
        return self::$_path .'inspection/' . date('Ymd').'/'.$path.'/';
    }
    //获取服务文件地址
    public static function ServiceFilePath()
    {
        return Yii::getAlias('@web').'/service-file/' . date('Ymd').'/';
    }
    //获取图片地址
    public static function resourcePath()
    {
        return self::$_path .'resource/' . date('Ymd').'/';
    }

    /**CrontabsController
     * 创建文件夹
     * @param string $path 文件夹
     */
    public static function makeDir(string $path)
    {
        $path = dirname($path);
        if (!is_dir($path)) mkdir($path,0777 ,true);
    }

    /**
     * 获取文件
     * @param string $file
     */
    public static function getFile(string $file)
    {
        if (!file_exists($file)) Yii::$app->end(json_encode(ErrCode::code(1019)));
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        \Yii::$app->end();
    }
}
