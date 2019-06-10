<?php

namespace common\models\userCenter;

use Yii;

/**
 * This is the model class for table "login_log".
 *
 * @property string $id
 * @property string $user_id 用户id
 * @property string $addtime 添加时间
 * @property string $ip 登录ip
 */
class LoginLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'login_log';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('userCenter');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['addtime'], 'safe'],
            [['ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'addtime' => 'Addtime',
            'ip' => 'Ip',
        ];
    }
}

