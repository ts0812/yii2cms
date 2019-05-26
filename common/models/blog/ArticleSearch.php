<?php

namespace common\models\blog;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\blog\Article;

/**
 * ArticleSearch represents the model behind the search form of `common\models\blog\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'content_id', 'type', 'status', 'sort'], 'integer'],
            [['author', 'title', 'keywords', 'description', 'uptime', 'addtime'], 'safe'],
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
        $query = Article::find();

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
            'content_id' => $this->content_id,
            'type' => $this->type,
            'status' => $this->status,
            'sort' => $this->sort,
            'uptime' => $this->uptime,
            'addtime' => $this->addtime,
        ]);

        $query->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'keywords', $this->keywords])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
