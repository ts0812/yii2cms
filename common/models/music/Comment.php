<?php

namespace common\models\music;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property int $music_id 音乐id
 * @property string $content 评语
 * @property string $state 
 
 状态
 * @property string $create_time
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('music');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['music_id'], 'integer'],
            [['content', 'create_time'], 'string'],
            [['state'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'music_id' => '音乐作品',
            'content' => '评论内容',
            'state' => '状态',
            'create_time' => '创建时间',
        ];
    }
    public function getMusic(){
        return $this->hasOne(Music::className(),['id'=>'music_id'])->select('music.title,music.id');
    }
}
