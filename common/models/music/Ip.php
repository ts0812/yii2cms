<?php

namespace common\models\music;

use Yii;

/**
 * This is the model class for table "ip".
 *
 * @property int $id
 * @property string $ip
 * @property string $country 国家
 * @property string $prov 省
 * @property string $city 城市
 * @property string $district 区
 * @property string $isp   运营商
 * @property string $create_time
 */
class Ip extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ip';
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
            [['ip', 'country', 'prov', 'city', 'district', 'isp', 'create_time'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'country' => 'Country',
            'prov' => 'Prov',
            'city' => 'City',
            'district' => 'District',
            'isp' => 'Isp',
            'create_time' => 'Create Time',
        ];
    }
}
