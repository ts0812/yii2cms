<?php

namespace common\common;

use Yii;

/**
 * This is the model class for table "{{%token}}".
 *
 * @property string $id
 * @property string $openid 用户id
 * @property string $token 验证信息
 * @property string $status 状态
 * @property string $addtime 添加时间
 */
class Token extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%token}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid', 'token'], 'required'],
            [['addtime'], 'safe'],
            [['openid', 'token'], 'string', 'max' => 32],
            [['token'], 'unique'],
            [['status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => '用户id',
            'token' => '验证信息',
            'status' => '状态(0:失效 1为正常)',
            'addtime' => '添加时间',
        ];
    }

    /**
     * @param string $openid
     * @return string
     */
    public static function createToken(string $openid )
    {
        $model = self::find()->where(['openid' => $openid , 'status' => 1])->andWhere(['<' ,'addtime' ,date('Y-m-d H:i:s',time()-TOKEN_OUT_TIME)])->all();
        if ($model) {
            foreach ($model as $row){
                $row->status = 0;
                $row->save();
            }
        }
        $tokenModel = new Token();
        $tokenModel->openid = $openid;
        $tokenModel->token = md5(base64_encode(md5($openid) . md5(date('Y-m-d H:i:s')) .md5(SECRET_SALT)));
        $tokenModel->save();
        return $tokenModel->token;
    }

    /**
     * @param string $opend
     * @return string
     */
    public static function getToken(string $opend)
    {
        $token = self::findOne(['openid' => $opend, 'status' => 1]);
        return isset($token->token) ? $token->token : '';
    }

    /**
     * 获取验证 salt
     * @param string $openid
     * @param string $hostInfo
     * @return string
     */
    public static function getSalt(string $openid , string $hostInfo)
    {
        return md5(md5($openid . md5(MMC_APP_KEY) . md5($hostInfo)) . md5(date('YmdH')));
    }

}
