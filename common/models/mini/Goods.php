<?php

namespace common\models\mini;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property int $id
 * @property int $catalog_id 类别id
 * @property string $name 名称
 * @property string $img 缩略图
 * @property string $show_img 展现图
 * @property int $or_price 原价
 * @property int $pr_price 售价 
 * @property int $status 0下架 1正常
 * @property int $admin_id 创建人id
 * @property int $num 剩余数目
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('mini');
    }
    static $_status=['下架','上架'];
    public $label_ids;  //标签id

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['catalog_id', 'name'], 'required'],
            [['catalog_id', 'or_price', 'pr_price', 'status', 'admin_id', 'num'], 'integer'],
            [['show_img','create_time'], 'string'],
            [['name', 'img'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['label_ids'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalog_id' => '类别',
            'name' => '名称',
            'img' => '缩略图',
            'show_img' => '展现图',
            'or_price' => '原价',
            'pr_price' => '售价',
            'status' => '状态',
            'admin_id' => '创建人',
            'num' => '库存',
            'create_time'=>'添加时间',
            'label_ids'=>'标签'
        ];
    }
    public function getAdmin(){
        return $this->hasOne(\rbac\models\User::className(),['id'=>'admin_id']);
    }
    public function getLabel(){
            return $this->hasMany(Label::className(), ['id' => 'label_id'])
                ->viaTable('goods_label', ['goods_id' => 'id']);
    }
}
