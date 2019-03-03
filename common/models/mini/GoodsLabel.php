<?php

namespace common\models\mini;

use Yii;

/**
 * This is the model class for table "goods_label".
 *
 * @property int $goods_id
 * @property int $label_id
 */
class GoodsLabel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods_label';
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
            [['goods_id'], 'required'],
            [['goods_id', 'label_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => 'Goods ID',
            'label_id' => 'Label ID',
        ];
    }

}
