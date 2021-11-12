<?php

namespace common\models\social;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property string $id
 * @property string $type_id 类型id
 * @property string $owner_id 当事人id
 * @property string $description 事件描述
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @property string $event_time 事件时间
 * @property string $status 0 预备 1进行 2 已过
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }
    public static $_status = ['预备','进行','已过'];
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
            [['type_id', 'owner_id', 'event_time'], 'required'],
            [['type_id', 'owner_id', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['description'], 'string', 'max' => 254],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => '事件类型',
            'owner_id' => '当事人',
            'description' => '描述',
            'create_time' => '添加时间',
            'update_time' => '修改时间',
            'event_time' => '事件时间',
            'status' => '状态',
        ];
    }

    // 获取当事人信息
    public function getUser()
    {
        //同样第一个参数指定关联的子表模型类名
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    // 获取事件类型
    public function getEventType()
    {
        //同样第一个参数指定关联的子表模型类名
        return $this->hasOne(EventType::className(), ['id' => 'type_id']);
    }
}
