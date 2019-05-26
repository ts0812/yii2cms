<?php

namespace common\models\blog;

use Yii;

/**
 * This is the model class for table "article_content".
 *
 * @property string $id
 * @property string $content 文章内容
 * @property string $uptime 更新时间
 * @property string $addtime 添加时间
 */
class ArticleContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_content';
    }

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
            [['uptime', 'addtime'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '文章内容',
            'uptime' => '更新时间',
            'addtime' => '添加时间',
        ];
    }
}
