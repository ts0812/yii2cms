<?php

namespace common\models\blog;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $author 作者
 * @property string $ccontent_id 文章内容ID
 * @property string $title 标题
 * @property string $keywords 关键词
 * @property string $description 描述
 * @property int $type 1原创 2投稿 3转载
 * @property string $status 0 待审核 1 开放访问  2 关闭访问
 * @property int $sort 排序
 * @property string $uptime 更新时间
 * @property string $addtime 创建时间
 *
 * @property ArticleToLabel[] $articleToLabels
 */
class Article extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }
    public static $_type=[1=>'原创',2=>'投稿',3=>'转载'];
    public static $_status=['待审核','公布','关闭访问'];
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
            [['title','image'], 'required'],
            [['type', 'status', 'sort','content_id'], 'integer'],
            [['uptime', 'addtime'], 'safe'],
            [['author', 'title', 'keywords', 'description','image'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author' => '作者',
            'content_id' => '文章ID',
            'title' => '标题',
            'keywords' => '关键词',
            'description' => '描述',
            'type' => '类型',
            'status' => '状态',
            'sort' => '排序',
            'uptime' => '更新时间',
            'addtime' => '添加时间',
            'image'=>'展示图片',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleToLabels()
    {
        return $this->hasMany(ArticleToLabel::className(), ['article_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleContent()
    {
        return $this->hasMany(ArticleContent::className(), ['id' => 'content_id']);
    }

}
