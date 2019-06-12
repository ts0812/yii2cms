<?php

namespace common\models\blog;

use Yii;

/**
 * This is the model class for table "push".
 *
 * @property string $id
 * @property string $content
 * @property int $sort 排序
 * @property string $url url链接
 * @property string $status 推送状态 1待推  2推送
 * @property string $label 标签 1趣味笑话 2情感 3心灵鸡汤 4生活常识 5新闻
 * @property string $addtime
 */
class Push extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'push';
    }
    public static $_status=[1=>'待推',2=>'推送'];
    public static $_label = [1=>'趣味笑话', 2=>'情感', 3=>'心灵鸡汤', 4=>'生活常识', 5=>'新闻'];
    //缓存redis名称
    public static $_redisName = 'push';
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
            [['content'], 'string'],
            [['sort', 'status', 'label'], 'integer'],
            [['addtime'], 'safe'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '内容',
            'sort' => '排序',
            'url' => 'Url',
            'status' => '状态',
            'label' => '标签',
            'addtime' => '添加时间',
        ];
    }
}
