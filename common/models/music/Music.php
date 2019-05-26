<?php

namespace common\models\music;

use Yii;

/**
 * This is the model class for table "music".
 *
 * @property int $id
 * @property int $uid 上传人
 * @property string $qq 临时
 
 对话QQ
 * @property string $object 
 
 对象，给谁
 * @property string $song 歌
 
 名
 * @property string $mp3 音
 
 乐url
 * @property string $lrc 歌词lrc
 * @property string $image 
 
 音乐图片
 * @property string $ttf 字
 
 体ttf
 * @property string $color1 其
 
 他歌词颜色
 * @property string $color2 
 
 当前歌词颜色
 * @property string $color3 
 
 歌名颜色
 * @property string $background 背景
 * @property string $title 
 
 标题
 * @property string $keywords 关键字
 * @property string $description 描述
 * @property string $small_image 分享缩略图100x100
 * @property string $playlist 是否添为歌单 0 否 1 是
 * @property int $sort 排序
 * @property string $state 0关闭访问 
 
 1正常 2关闭评论
 * @property string $create_time
 */
class Music extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'music';
    }
    public static $_state=['关闭访问','正常','关闭评论'];
    public static $_playlist=['否','是'];

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
            [['uid', 'sort'], 'integer'],
            [['lrc', 'description'], 'string'],
            [['state'], 'required'],
            [['qq', 'small_image', 'state', 'create_time'], 'string', 'max' => 100],
            [['object', 'song', 'mp3', 'image', 'ttf', 'color1', 'color2', 'color3', 'background', 'title'], 'string', 'max' => 200],
            [['keywords', 'playlist'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '上传人',
            'qq' => '临时对话QQ',
            'object' => '作品对象',
            'song' => '歌名',
            'mp3' => '音乐链接',
            'lrc' => '歌词lrc',
            'image' => '音乐图片',
            'ttf' => '字体Ttf',
            'color1' => '其他歌词颜色',
            'color2' => '当前歌词颜色',
            'color3' => '歌名颜色',
            'background' => '背景链接',
            'title' => '标题',
            'keywords' => '关键字',
            'description' => '描述',
            'small_image' => '分享缩略图100x100',
            'playlist' => '是否添为歌单',
            'sort' => '排序',
            'state' => '状态',
            'create_time' => '创建时间',
        ];
    }
    public static function getAllMusicList(){
        $model = self::find()->orderBy(" CONVERT (title USING gbk)")->select('id,title')->where([])->all();
        return $model?array_column($model,'title','id'):[];
    }
}
