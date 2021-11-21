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

    //下载远程文件到本地指定目录并重命名
    public static function getFileToLocal($url, $save_dir = '', $filename = '', $type = 0) {
        if (trim($url) == '') {
            return false;
        }
        if (trim($save_dir) == '') {
            $save_dir = './';
        }
        if (0 !== strrpos($save_dir, '/')) {
            $save_dir.= '/';
        }
        //创建保存目录
        if (!file_exists($save_dir) && !mkdir($save_dir, 0777, true)) {
            return false;
        }
        //获取远程文件所采用的方法
        if ($type) {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $content = curl_exec($ch);
            curl_close($ch);
        } else {
            ob_start();
            readfile($url);
            $content = ob_get_contents();
            ob_end_clean();
        }
        //echo $content;
        $size = strlen($content);
        //文件大小
        $fp2 = @fopen($save_dir . $filename, 'a');
        fwrite($fp2, $content);
        fclose($fp2);
        unset($content, $url);
        return array(
            'file_name' => $filename,
            'save_path' => $save_dir . $filename,
            'file_size' => $size
        );
    }
}
