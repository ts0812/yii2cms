<?php

namespace backend\modules\api\controllers;
use Yii;
use yii\web\Controller;
require_once(Yii::getAlias("@common")."/API/qqConnectAPI.php");
/**
 * ConfigController implements the CRUD actions for Config model.
 */
class LoginController extends Controller
{
    public $enableCsrfValidation = false;
    function actionQqLogin(){
        $code = yii::$app->request->get('code','');
        $state = yii::$app->request->get('state','');
        $qc = new \QC();
        if($code&&$state){
            //获取令牌AccessToken
            $accessToken = $qc->qq_callback();
            //获取用户openid
            $openId = $qc->get_openid();
            $qc = new \QC($accessToken,$openId);
            $info = $qc->get_user_info();
            if($info &&$info['ret']==0){
                var_dump($info);die;
            }
                var_dump($info);die;
        }else{
            $qc->qq_login();
        }
    }
}
