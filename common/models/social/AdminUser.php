<?php

namespace common\models\social;

use Yii;

/**
 * This is the model class for table "admin_user".
 *
 * @property int $id
 * @property int $admin_id 管理员id
 * @property int $user_id 用户id
 */
class   AdminUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_user';
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
            [['admin_id', 'user_id'], 'required'],
            [['admin_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'admin_id' => 'Admin ID',
            'user_id' => 'User ID',
        ];
    }
}
