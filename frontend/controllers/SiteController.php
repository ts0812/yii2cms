<?php
namespace frontend\controllers;
use common\common\CacheKey;
use common\models\mini\User;
use yii;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class SiteController extends ApiController
{
	public $enableCsrfValidation = false;

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        echo 'hello world!';
    }
    /*
     * 登录
     */
    public function actionLogin()
    {
        $username = Yii::$app->request->post('username','');
        $password = Yii::$app->request->post('password','');
        $userList = User::findOne(['username'=>$username]);

        if($userList){
            if(Yii::$app->security->validatePassword($password, $userList->password_hash)){
                if($token=User::createToken($userList))
                    $this->errCode(1,$token);
            }
        }
        $this->errCode(1001);
    }
    public function actionLogout()
    {
        $userData = $this->_userData;
        Yii::$app->cache->delete(CacheKey::tokenUserId($userData->token));
        $userList = User::findOne($userData->id);
        $userList->token='';
        $userList->save();
        $this->errCode(1);
    }
}
