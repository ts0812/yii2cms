<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel common\models\blog\TrafficSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '流量记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traffic-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'url:url',
            'ip',
            'referer',
            'user_agent',
            'addtime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
