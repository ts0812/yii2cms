<?php

namespace backend\modules\api\controllers;
use backend\controllers\ApiController;
use common\common\CacheKey;
use common\models\userCenter\User;
use Yii;
require_once(Yii::getAlias("@common")."/API/qqConnectAPI.php");
/**
 * ConfigController implements the CRUD actions for Config model.
 */
class LoginController extends ApiController
{
    public $enableCsrfValidation = false;
    function actionQqLogin(){
        $code = yii::$app->request->get('code','');
        $state = yii::$app->request->get('state','');
        $qc = new \QC();
        if($code&&$state){
            //获取令牌AccessToken
            $accessToken = $qc->qq_callback();
            //获取用户openid 平台唯一标志符
            $openId = $qc->get_openid();
            $model = User::findOne(['openid'=>$openId]);
            if($model){
                $userinfo = $model->attributes;
                unset($userinfo['password']);
                $token = CacheKey::setToken($model->id,$userinfo);
                if($token)
                    $this->errCode(1,$token);
            }else{
                $qc = new \QC($accessToken,$openId);
                $info = $qc->get_user_info();
                if($info &&$info['ret']==0){
                    $model = new User();
                    $model->nickname=$info['nickname']??'';
                    $model->sex=array_search($model::$_sex,$info['gender'])??0;
                    $model->province=$info['province']??'';
                    $model->city=$info['city']??'';
                    $model->age=(int)date('Y')-(int)$info['year'];
                    $model->openid=$openId;
                    $model->image=$info['figureurl_qq_2']??'';
                    if($model->save()){
                        $userinfo = $model->attributes;
                        unset($userinfo['password']);
                        $token = CacheKey::setToken($model->id,$userinfo);
                        if($token)
                            $this->errCode(1,$token);
                    }
                }
            }
            $this->errCode(9999);
        }else{
            $qc->qq_login();
        }
    }
}
