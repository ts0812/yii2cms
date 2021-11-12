<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\social\User;
/* @var $this yii\web\View */
/* @var $model common\models\social\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

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
            'name',
            ['attribute'=>'sex','value'=>function($model){
                return (User::userSex())[$model->sex]??'';
            }
            ],
            'phone',
            'phone2',
            'birthday',
            ['attribute'=>'photo','value'=>function($model){
                return '<img width="80" height="80" src="'.$model->photo.'"/>';
            },
                'format'=>'raw'
            ],
            'address',
            ['attribute'=>'status','value'=>function($model){
                return (\common\models\social\User::userStatus())[$model->status]??'';
            }
            ],
            'death_time',
            'create_time',
            'update_time',
        ],
    ]) ?>

</div>
