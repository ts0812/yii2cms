<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel common\models\blog\IndexSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '首页列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="index-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加列表', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'url:url',
            ['attribute'=>'image','value'=>function($model){
                return '<img width="80" height="80" src="'.$model->image.'"/>';
            },
                'format'=>'raw'
            ],
            'title',
            'description',
            ['attribute'=>'status','value'=>function($model){
                return (\common\models\blog\Index::$_status)[$model->status]??'';
            },
                'format'=>'raw',
                'filter'=>\common\models\blog\Index::$_status
            ],
            ['attribute'=>'type','value'=>function($model){
                return (\common\models\blog\Index::$_type)[$model->type]??'';
            },
                'format'=>'raw',
                'filter'=>\common\models\blog\Index::$_type
            ],
            'sort',
            'addtime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
