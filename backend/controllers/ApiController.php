<?php
namespace backend\controllers;

use common\common\CacheKey;
use common\common\ErrCode;
use models\Token;
use models\User;
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
            $token = Yii::$app->request->headers->get('token', Yii::$app->request->get('token'));
            if(!$token) Yii::$app->end(json_encode($this->errCode(1007)));
            $this->_userData = Yii::$app->cache->get(CacheKey::tokenUserId($token));
            if(!$this->_userData){
                $tokenModel = Token::findOne(['token' => $token]);
                //token状态为 正常 时间失效 则是 token过期失效
                if(!isset($tokenModel->openid) || !$tokenModel->openid  || time() - strtotime($tokenModel->addtime) >= TOKEN_OUT_TIME)
                    Yii::$app->end(json_encode($this->errCode(1002)));

                //用户存在 或 用户已被停用
                $this->_userData = User::findOne(['openid' => $tokenModel->openid]);
                if(!isset($this->_userData->status) || !$this->_userData->status == 1)
                    Yii::$app->end(json_encode($this->errCode(1003)));
            }
            //语言
            Yii::$app->language = $this->_userData->lang;
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
        Yii::$app->response->format=Response::FORMAT_JSON;
        $errCode = ErrCode::code($code);
        $errCode['data'] = $data;
        header("errCode: $code");
        if($code === 0){
            $errCode['data'] = null;
            $errCode['message'] = $this->getErrorsMessage($data);
        }
        return $errCode;
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
