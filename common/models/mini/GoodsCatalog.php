<?php

namespace common\models\mini;

use common\common\ArrayHelper;
use Yii;

/**
 * This is the model class for table "goods_catelog".
 *
 * @property int $id
 * @property string $name 分类名称
 * @property int $status 0 禁用 1正常
 * @property int $create_time
 */
class GoodsCatalog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_catalog';
    }
    static $_status=['禁用','正常'];
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
            [['status'], 'integer'],
            [['name', 'create_time'], 'string', 'max' => 255],
            [['name'], 'unique'],
            ['status', 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '类名',
            'status' => '状态',
            'create_time' => '添加时间',
        ];
    }
    static function getAllGoodsCatalog(){
        $list = self::findAll(['status'=>1]);
        return ArrayHelper::map($list,'id','name');
    }
    static function getCatalogName($id=''){
        $list = self::findOne(['status'=>1,'id'=>$id]);
        return $list->name??'';
    }
}

