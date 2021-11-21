<?php

namespace common\models\social;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\social\Event;

/**
 * EventSearch represents the model behind the search form of `common\models\social\Event`.
 */
class EventSearch extends Event
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type_id', 'status'], 'integer'],
            [['description', 'create_time', 'update_time', 'event_time','owner_id', ], 'safe'],
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
        $query = Event::find()->joinWith(['user','eventType']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'type_id' => $this->type_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'event_time' => $this->event_time,
            'event.status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description]);
        $query->andFilterWhere(['like', 'user.name', $this->owner_id]);
        return $dataProvider;
    }
}
