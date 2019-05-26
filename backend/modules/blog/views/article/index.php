<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel common\models\blog\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

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
            'author',
            ['attribute'=>'image','value'=>function($model){
                return '<img width="80" height="80" src="'.$model->image.'"/>';
            },
                'format'=>'raw'
            ],
            'title',
            'keywords',
            'description',
            ['attribute'=>'type','value'=>function($model){
                return (\common\models\blog\Article::$_type)[$model->type]??'';
            },
                'format'=>'raw',
                'filter'=> \common\models\blog\Article::$_type
            ],
            ['attribute'=>'status','value'=>function($model){
                return (\common\models\blog\Article::$_status)[$model->status]??'';
            },
                'format'=>'raw',
                'filter'=>\common\models\blog\Article::$_status
            ],
            'sort',
            'uptime',
            'addtime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
