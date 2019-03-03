<?php

namespace common\models\mini;

use common\common\ArrayHelper;
use Yii;

/**
 * This is the model class for table "label".
 *
 * @property int $id
 * @property string $name 标签
 * @property int $create_time
 */
class Label extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'label';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('mini');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['create_time'], 'string'],
            [['name'], 'string', 'max' => 10],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'create_time' => 'Create Time',
        ];
    }
    static function getAllLabel(){
        $list = self::find()->all();
        return ArrayHelper::map($list,'id','name');
    }
    static function getLabelName($id=''){
        $list = self::findOne($id);
        return ($list->name)??'';
    }
}
