<?php

namespace common\models\blog;

use Yii;

/**
 * This is the model class for table "article_to_label".
 *
 * @property string $id
 * @property int $article_id 文章id
 * @property string $label_id 标签id
 *
 * @property Article $article
 */
class ArticleToLabel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_to_label';
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
            [['article_id'], 'required'],
            [['article_id', 'label_id'], 'integer'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'label_id' => 'Label ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }
}
