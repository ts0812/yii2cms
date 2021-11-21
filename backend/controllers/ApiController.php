<?php
namespace backend\controllers;

use common\common\CacheKey;
use common\common\ErrCode;
use common\models\mini\User;
use yii\rest\Controller;
use yii\filters\VerbFilter;
use Yii;

/**
 * Class ApiController
 * @package modules\api\controllers
 */
class ApiController extends Controller
{
    //是否开启yii接口验证
    public $enableCsrfValidation = false;
    //不验证token的链接地址
    protected $_arrUrl = [
        'api/login/qq-login',
        'api/login/login-by-openid',
	    'api/login/logout',
        'rbac/route/index',
    ];
    //用户数据
    protected $_userData = null;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }
    /**
     * 初始化 验证token
     * @SuppressWarnings(PHPMD)
     */
    public function init()
    {
        //是否需要验证token
        if (!in_array(Yii::$app->request->getPathInfo() , $this->_arrUrl)){
            // 返回 Accept header 值
            $token = Yii::$app->request->headers->get('token', Yii::$app->request->get('token',''));
            if(!$token)
                $this->errCode(1007);
            $this->_userData = Yii::$app->cache->get(CacheKey::tokenUserId($token));
            if(!$this->_userData)
                    $this->errCode(1007);
        }
    }

    /**
     * 接口返回信息
     * @param int $code
     * @param array|string $data
     * @return mixed
     */
    protected function errCode($code = 1 , $data = null)
    {
        $errCode = ErrCode::code($code);
        $errCode['data'] = $data;
        header("errCode: $code");
        if($code === 0){
            $errCode['data'] = null;
            $errCode['message'] = $this->getErrorsMessage($data);
        }
        die(json_encode($errCode));
    }

    /**
     * 获取yii 验证错误 的msg
     * @param $errors
     */
    protected function getErrorsMessage($errors)
    {
        if(is_array($errors) && $errors){
            $firstError = array_shift($errors);
            return array_shift($firstError);
        }
        return $errors;
    }
//下载远程文件到本地指定目录并重命名
    protected function getFileToLocal($url, $save_dir = '', $filename = '', $type = 0) {
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
