<?php

use yii\helpers\Html;
use backend\assets\LayuiAsset;
use yii\grid\GridView;
LayuiAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel common\models\blog\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '导航列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="navigation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'title',
                'headerOptions' => [
                    'width' => '10%',
                ],
                'format'=>'raw',
                'value'=>function($model){
                    return '<a href="'.$model['url'].'" target="_blank" title="'.$model['title'].'" >'.$model['title'].'</a>';
                }
            ],
            ['attribute'=>'image','value'=>function($model){
                return '<img width="80" height="80" src="'.$model->image.'"/>';
            },
                'format'=>'raw'
            ],
            'keywords',
            'description',
            ['attribute'=>'icon','value'=>function($model){
                return $model->icon;
            },
                'format'=>'raw',
            ],
            ['attribute'=>'status','value'=>function($model){
                return (\common\models\blog\Navigation::$_status)[$model->status]??'';
            },
                'format'=>'raw',
                'filter'=>\common\models\blog\Navigation::$_status
            ],
            'sort',
            'addtime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
