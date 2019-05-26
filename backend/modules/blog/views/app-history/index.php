<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel common\models\blog\AppHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '时光历程';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-history-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加历程', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'content',
            ['attribute'=>'status','value'=>function($model){
                return (\common\models\blog\AppHistory::$_status)[$model->status]??'';
            },
                'format'=>'raw',
                'filter'=>\common\models\blog\AppHistory::$_status
            ],
            'addtime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
