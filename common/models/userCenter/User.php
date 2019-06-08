<?php

namespace common\models\userCenter;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $nickname 昵称
 * @property int $sex 性别 0未知 1 男 2女
 * @property string $province 省份
 * @property string $city 城市
 * @property int $age 年龄
 * @property string $image 头像
 * @property string $phone 电话
 * @property string $qq qq
 * @property string $openid 用户开放id
 * @property string $update 修改时间
 * @property string $addtime 新增时间
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('userCenter');
    }
    public static $_sex=['未知','男','女'];
    public static $_status=['禁用','正常'];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sex', 'age','status'], 'integer'],
            [['openid'], 'string'],
            [['update', 'addtime'], 'safe'],
            [['username', 'password', 'nickname', 'image'], 'string', 'max' => 255],
            [['province', 'city'], 'string', 'max' => 10],
            [['phone', 'qq'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '账号',
            'password' => '密码',
            'nickname' => '昵称',
            'sex' => '性别',
            'province' => '身份',
            'city' => '城市',
            'age' => '年龄',
            'image' => '头像',
            'phone' => '电话',
            'qq' => 'qq',
            'openid' => 'Openid',
            'status'=>'状态',
            'update' => '修改时间',
            'addtime' => '添加时间',
        ];
    }
}
