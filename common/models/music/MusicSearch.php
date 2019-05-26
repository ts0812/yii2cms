<?php

namespace common\models\music;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\music\Music;

/**
 * MusicSearch represents the model behind the search form of `common\models\music\music`.
 */
class MusicSearch extends Music
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'sort'], 'integer'],
            [['qq', 'object', 'song', 'mp3', 'lrc', 'image', 'ttf', 'color1', 'color2', 'color3', 'background', 'title', 'keywords', 'description', 'small_image', 'playlist', 'state', 'create_time'], 'safe'],
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
        $query = music::find();

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
            'uid' => $this->uid,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'object', $this->object])
            ->andFilterWhere(['like', 'song', $this->song])
            ->andFilterWhere(['like', 'mp3', $this->mp3])
            ->andFilterWhere(['like', 'lrc', $this->lrc])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'ttf', $this->ttf])
            ->andFilterWhere(['like', 'color1', $this->color1])
            ->andFilterWhere(['like', 'color2', $this->color2])
            ->andFilterWhere(['like', 'color3', $this->color3])
            ->andFilterWhere(['like', 'background', $this->background])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'small_image', $this->small_image])
            ->andFilterWhere(['like', 'playlist', $this->playlist])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'create_time', $this->create_time]);

        return $dataProvider;
    }
}
