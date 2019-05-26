<?php

namespace common\models\music;

use Yii;

/**
 * This is the model class for table "pv".
 *
 * @property int $id
 * @property int $music_id
 * @property string $ip_id ip表id
 * @property string $jiazai_time 页面加载时间 0表示未加载完毕就离开
 * @property string $zaixian_time 打开网页时间 刷新算离开
 * @property string $create_time
 */
class Pv extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pv';
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
            [['ip_id', 'jiazai_time', 'zaixian_time', 'create_time'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'music_id' => '音乐',
            'ip_id' => 'ip',
            'jiazai_time' => '加载时间',
            'zaixian_time' => '在线时间',
            'create_time' => '创建时间',
        ];
    }
    public function getIp(){
        return $this->hasOne(Ip::className(),['id'=>'ip_id']);
    }
}
