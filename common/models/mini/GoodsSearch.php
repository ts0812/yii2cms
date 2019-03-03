<?php

namespace common\models\mini;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\mini\Goods;

/**
 * GoodsSearch represents the model behind the search form of `common\models\mini\Goods`.
 */
class GoodsSearch extends Goods
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'catalog_id', 'or_price', 'pr_price', 'status', 'admin_id', 'num'], 'integer'],
            [['name', 'img', 'show_img','label_ids'], 'safe'],
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
        $query = Goods::find()->joinWith('label');
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if($this->label_ids){
            $query->andFilterWhere(['label.id'=>$this->label_ids]);
        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'catalog_id' => $this->catalog_id,
            'or_price' => $this->or_price,
            'pr_price' => $this->pr_price,
            'status' => $this->status,
            'admin_id' => $this->admin_id,
            'num' => $this->num,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
