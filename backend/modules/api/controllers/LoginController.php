<?php

namespace backend\modules\api\controllers;
use backend\controllers\ApiController;
use common\common\CacheKey;
use common\models\userCenter\User;
use common\models\userCenter\LoginLog;
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
	    if($model->status!=1)
		$this->errCode(1003);
	    //记录上次登录ip与时间
            $logModel = LoginLog::find()->where(['user_id'=>$model->id])->orderBy('id desc')->one();
            if($logModel){
                $model->lastLoginTime=$logModel->addtime;
                $model->lastLoginIp = $logModel->ip;
                $model->save();
            }
            $userinfo = $model->attributes;
            unset($userinfo['password']);
            $token = CacheKey::setToken($model->id,$userinfo);
            if($token){
		//记录当前登录ip与时间
		$loginLog=new LoginLog();
		$loginLog->ip=Yii::$app->request->userIP;
		$loginLog->user_id=$model->id;
		if(!$loginLog->save())
		    $this->errCode(0,$loginLog->getErrors());
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
    //token身份退出
    public function actionLogout(){
	$token = yii::$app->request->get('token','');   
	CacheKey::delToken($token);
	$this->errCode(1);	
    }
    //获取用户信息
    public function actionGetUserInfo(){
	$data = [
		 'username'=>$this->_userData['username']??'',
		 'nickname'=>$this->_userData['nickname']??'',
		 'sex'=>User::$_sex[$this->_userData['sex']]??'未知物种',
		 'image'=>$this->_userData['image']??'',
		 'description'=>$this->_userData['description']??'',
		 'lastLoginTime'=>$this->_userData['lastLoginTime']??'',
		 'lastLoginIp'=>$this->_userData['lastLoginIp']??'',
		];
	$this->errCode(1,$data);
    }
	
}
