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
            $token = Yii::$app->request->headers('token', Yii::$app->request->get('token',''));
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
        Yii::$app->end(json_encode($errCode));
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

}
