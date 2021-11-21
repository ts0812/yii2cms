<?php

namespace common\models\social;

use Yii;

/**
 * This is the model class for table "event_type".
 *
 * @property string $id
 * @property string $name 类型名
 */
class EventType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_type';
    }

    /*
     * 所有类型
     */
    public static function allEventType(){
        $allEventType = static::find()->asArray()->select('id,name')->all();
        return $allEventType?array_column($allEventType,'name','id'):[];
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
            [['name'], 'string', 'max' => 255],
            [['name'],'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '类型',
        ];
    }
}
