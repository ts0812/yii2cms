<?php

namespace common\models\blog;

use Yii;

/**
 * This is the model class for table "navigation".
 *
 * @property string $id
 * @property string $title 标题
 * @property string $keywords 关键词
 * @property string $description 描述
 * @property string $image 图片
 * @property string $icon inco图标
 * @property string $status 1开启 0关闭
 * @property string $sort 排序
 * @property string $addtime 添加时间
 */
class Navigation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'navigation';
    }
    public static $_status=['否','是'];
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
            [['title'], 'required'],
            [['id', 'status', 'sort'], 'integer'],
            [['addtime'], 'safe'],
            [['url','title', 'keywords', 'description', 'image', 'icon'], 'string', 'max' => 255],
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
            'url'=>'导航地址',
            'title' => '标题',
            'keywords' => '关键词',
            'description' => '描述',
            'image' => '展现图片',
            'icon' => 'icon图标',
            'status' => '是否作为导航',
            'sort' => '排序',
            'addtime' => '添加时间',
        ];
    }
}
