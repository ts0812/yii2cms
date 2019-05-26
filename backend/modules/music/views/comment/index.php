<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\music\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '音乐评论';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('添加评论', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'title',
                'format'=>'raw',
                'value'=>function($model){
                    return '<a href="'.$model['music']['id'].'" target="_blank" title="'.$model['music']['title'].'" >'.$model['music']['title'].'</a>';
                }
            ],
            'content',
            'create_time',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>