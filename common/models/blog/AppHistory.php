<?php

namespace common\models\blog;

use Yii;

/**
 * This is the model class for table "app_history".
 *
 * @property int $id
 * @property string $content 历程内容
 * @property string $addtime
 */
class AppHistory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_history';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('blog');
    }
    public static $_status=['关闭','显示'];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['addtime'], 'safe'],
            [['content'], 'string', 'max' => 255],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => '历程内容',
            'status' => '状态',
            'addtime' => '添加时间',
        ];
    }
}
