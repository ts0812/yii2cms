<?php

namespace common\models\social;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\social\User;

/**
 * UserSearch represents the model behind the search form of `common\models\social\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public $adminId;
    public function rules()
    {
        return [
            [['id', 'status','sex'], 'integer'],
            [['adminId','name', 'phone', 'phone2', 'birthday','next_birthday', 'photo', 'address', 'death_time', 'create_time', 'update_time'], 'safe'],
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
        $query = User::find();
        $adminInfo = \Yii::$app->user->identity;

        $adminId =$adminInfo->id;
        //管理员检索用户添加的人
        if($adminInfo->username =='admin')
            $adminId = $params['UserSearch']['adminId'];

        if($adminId)
            $query = $query->joinWith('adminUser as t1')->where(['t1.admin_id'=>$adminId]);
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
            'birthday' => $this->birthday,
            'status' => $this->status,
            'sex' => $this->sex,
            'death_time' => $this->death_time,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'phone2', $this->phone2])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
