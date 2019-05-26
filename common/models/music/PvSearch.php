<?php

namespace common\models\music;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\music\Pv;

/**
 * PvSearch represents the model behind the search form of `common\models\music\pv`.
 */
class PvSearch extends Pv
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'music_id'], 'integer'],
            [['ip_id', 'jiazai_time', 'zaixian_time', 'create_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = pv::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => [
                    'create_time' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'music_id' => $this->music_id,
        ]);

        $query->andFilterWhere(['like', 'ip_id', $this->ip_id])
            ->andFilterWhere(['like', 'jiazai_time', $this->jiazai_time])
            ->andFilterWhere(['like', 'zaixian_time', $this->zaixian_time])
            ->andFilterWhere(['like', 'create_time', $this->create_time]);

        return $dataProvider;
    }
}
