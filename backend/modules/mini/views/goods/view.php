<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\mini\Goods */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
    img{
        width: 100px;
        margin: 0 10px;
    }
    .label{
        background-color:#00FF00;
        margin: 0 3px;
    }
</style>
<div class="goods-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute'=>'catalog_id','value'=>function($model){
                return \common\models\mini\GoodsCatalog::getCatalogName($model->catalog_id);
            }],
            'name',
            ['attribute'=>'img','value'=>function($model){
                return '<img src="'.$model->img.'"/>';
                },
                'format'=>'raw'
            ],
            ['attribute'=>'show_img','value'=>function($model){
                $img='';
                $show_img=json_decode($model->show_img)??[];
                if(is_array($show_img)){
                    foreach ($show_img as $k){
                        $img.='<img src="'.$k.'"/>';
                    }
                }
                return $img;
            },
                'format'=>'raw'
            ],
            'or_price',
            'pr_price',
            ['attribute'=>'status','value'=>function($model){
                    return \common\models\mini\Goods::$_status[$model->status];
                },
            ],
            ['attribute'=>'admin_id','value'=>function($model){
                    return \rbac\models\User::getUsername($model->admin_id);
                },
            ],
            'num',
            ['attribute'=>'label_ids','value'=>function($model){
                if($labels=$model->label_ids){
                    $label='';
                    if(is_array($labels)){
                        foreach ($labels as $k){
                            $label.='<span class="label">'.\common\models\mini\Label::getLabelName($k).'</span>';
                        }
                    }
                    return $label;
                }
            },'format'=>'raw'],
        ],
    ]) ?>

</div>
