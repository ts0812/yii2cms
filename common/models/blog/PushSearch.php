<?php

namespace common\models\blog;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\blog\Push;

/**
 * PushSearch represents the model behind the search form of `common\models\blog\Push`.
 */
class PushSearch extends Push
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sort', 'status', 'label'], 'integer'],
            [['content', 'url', 'addtime'], 'safe'],
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
        $query = Push::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
           'pagination' => [
                'pageSize' => PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
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
            'sort' => $this->sort,
            'status' => $this->status,
            'label' => $this->label,
            'addtime' => $this->addtime,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
