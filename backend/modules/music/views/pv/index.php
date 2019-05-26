<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\music\PvSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '流量记录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pv-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'ip_id',
                'format'=>'raw',
                'value'=>function($model){
                    if($model['ip']['ip']){
                        $isp=$model['ip']['isp']?'('.$model['ip']['isp'].')':'';
                        return $model['ip']['ip'].'<br>'.$model['ip']['country'].$model['ip']['prov'].$model['ip']['city'].$model['ip']['district']
                            .$isp;
                    }
                    return '';
                }
            ],
            [
                'attribute' => 'jiazai_time',
                'format'=>'raw',
                'value'=>function($model){
                    $min=floor($model['jiazai_time']/(1000*60));
                    $time=$model['jiazai_time']%(1000*60);
                    $second = floor($time/1000);
                    return ($min?$min.'分':'').($second?$second.'秒':'').$time%1000;
                }
            ],
            [
                'attribute' => 'zaixian_time',
                'format'=>'raw',
                'value'=>function($model){
                    $min=floor($model['zaixian_time']/(1000*60));
                    $time=$model['zaixian_time']%(1000*60);
                    $second = floor($time/1000);
                    return ($min?$min.'分':'').($second?$second.'秒':'').$time%1000;
                }
            ],
            'create_time',
            [ 'header' => '操作',
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class'=>'text-center'],
                'headerOptions' => [
                    'width' => '10%',
                    'style'=> 'text-align: center;'
                ],
            ],
        ],
    ]); ?>
</div>