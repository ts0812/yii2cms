<?php

namespace common\models\social;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $name 人名
 * @property string $phone 电话1
 * @property string $phone2 电话2
 * @property string $birthday 生日（阴历）
 * @property string $photo 照片url
 * @property string $address 住址
 * @property int $status 0 死亡 1正常
 * @property string $death_time 死亡时间
 * @property string $create_time
 * @property string $update_time CURRENT_TIMESTAMP
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
    public static function userStatus(){
        return ['正常','死亡'];
    }
    public static function userSex(){
        return ['男','女','保密'];
    }
    public static function userBirthdayType(){
        return ['阴历','阳历'];
    }
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('social');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'sex'], 'required'],
            [['status', 'sex','birthday_type'], 'integer'],
            [['birthday','next_birthday', 'death_time', 'create_time', 'update_time',], 'safe'],
            [['name', 'phone', 'phone2', 'photo', 'address'], 'string', 'max' => 254],
        ];
    }
    /*
     * 获取所有用户name
     */
    public static function  getUserListByName(){
        $userList  = self::find()->asArray()->select('id,name')->all();
        return $userList?array_column($userList,'name','id'):[];
    }

    /*
    * 根据id获取用户信息
    */
    public static function  getUserListById($id=0){
        $userList  = self::find()->asArray()->where(['id'=>$id])->one();
        return $userList?:[];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '名字',
            'phone' => '电话',
            'phone2' => '电话2',
            'birthday' => '出生日',
            'birthday_type' => '过生日类型',
            'next_birthday' => '下个生日',
            'photo' => '照片',
            'address' => '地址',
            'status' => '状态',
            'sex' => '性别',
            'death_time' => '离去时间',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
    public function getAdminUser(){
        return $this->hasMany(AdminUser::className(), ['user_id' => 'id']);
    }
}

