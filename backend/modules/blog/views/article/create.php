<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\blog\Article */

$this->title = '新增文章';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        $model->author='知音';
        $model->type=1;
        $model->status=1;
    ?>
    <?= $this->render('_form', [
        'model' => $model,
        'article'=>$article
    ]) ?>

</div>
