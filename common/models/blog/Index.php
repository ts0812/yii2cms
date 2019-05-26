<?php

namespace common\models\blog;

use Yii;

/**
 * This is the model class for table "index".
 *
 * @property string $id
 * @property string $url 链接地址
 * @property string $image 展现图片
 * @property string $title 标题
 * @property string $description 描述
 * @property int $status 是否展现到首页 0 关闭 1展现
 * @property int $type 类型 0最新 1推荐 2火爆
 * @property int $sort 排序
 * @property string $addtime 添加时间
 */
class Index extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'index';
    }
    public static $_status=['关闭','展现'];
    public static $_type=['最新','推荐','火爆'];
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('blog');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status','type', 'sort'], 'integer'],
            [['addtime'], 'safe'],
            [['url', 'image', 'title', 'description'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'url地址',
            'image' => '展现图片',
            'title' => '标题',
            'description' => '描述',
            'status' => '状态',
            'sort' => '排序',
            'type'=>'类型',
            'addtime' => '添加时间',
        ];
    }
}
