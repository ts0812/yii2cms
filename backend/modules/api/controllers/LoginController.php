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
    //qq_login与请求必须在同一域名下，暂时用不了
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
            //已注册的qq用户
            if($model){
                $userinfo = $model->attributes;
                unset($userinfo['password']);
                $token = CacheKey::setToken($model->id,$userinfo);
                if($token){
                    $data = [
                        'token'=>$token,
                        'image'=>$model->image,
                        'nickname'=>$model->nickname
                    ];
                    $this->errCode(1,$data);
                }
            }else{  //未注册
                $qc = new \QC($accessToken,$openId);
                $info = $qc->get_user_info();
                if($info &&$info['ret']==0){
                    $model = new User();
                    $model->nickname=$info['nickname']??'';
                    $model->sex=array_search($info['gender'],User::$_sex)??0;
                    $model->province=$info['province']??'';
                    $model->city=$info['city']??'';
                    $model->age=(int)date('Y')-(int)$info['year'];
                    $model->openid=$openId;
                    $model->image=$info['figureurl_qq_2']??'';
                    if($model->save()){
                        $userinfo = $model->attributes;
                        unset($userinfo['password']);
                        $token = CacheKey::setToken($model->id,$userinfo);
                        if($token){
                            $data = [
                                'token'=>$token,
                                'image'=>$model->image,
                                'nickname'=>$model->nickname
                            ];
                            $this->errCode(1,$data);
                        }
                    }
                }
            }
            $this->errCode(9999);
        }else{
            $qc->qq_login();
        }
    }
    //openid登录验证
    public function actionLoginByOpenid(){
        $openId = yii::$app->request->get('openid','');
        $model = User::findOne(['openid'=>$openId]);
        if($model){
            $userinfo = $model->attributes;
            unset($userinfo['password']);
            $token = CacheKey::setToken($model->id,$userinfo);
            if($token){
                $data = [
                    'token'=>$token,
                    'image'=>$model->image,
                    'nickname'=>$model->nickname
                ];
                $this->errCode(1,$data);
            }
        }
        $this->errCode(1000);
    }
}
