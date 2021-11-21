<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\social\User;
/* @var $this yii\web\View */
/* @var $searchModel common\models\social\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户人情';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            ['attribute'=>'sex','value'=>function($model){
                return (User::userSex())[$model->sex]??'';
            },
                'format'=>'raw',
                'filter'=>User::userSex()
            ],
            'phone',
            'phone2',
            'birthday',
            'next_birthday',
            'address',
            ['attribute'=>'status','value'=>function($model){
                return (User::userStatus())[$model->status]??'';
            },
                'format'=>'raw',
                'filter'=>User::userStatus()
            ],
            //'death_time',
            //'create_time',
            //'update_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
