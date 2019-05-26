<?php

namespace common\models\blog;

use Yii;

/**
 * This is the model class for table "traffic_statistics".
 *
 * @property string $id
 * @property string $url 访问链接
 * @property string $ip 访问ip
 * @property string $addtime 添加时间
 * @property string $referer 访问来源地址
 * @property string $user_agent 用户代理
 */
class Traffic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'traffic_statistics';
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
            [['addtime'], 'safe'],
            [['url', 'ip', 'referer', 'user_agent'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => '收录链接',
            'ip' => 'Ip',
            'referer' => 'Referer',
            'user_agent' => 'User Agent',
            'addtime' => '添加时间',

        ];
    }
}
