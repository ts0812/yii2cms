<?php
use backend\assets\LayuiAsset;
LayuiAsset::register($this);

?>
<div class="config-create">
    <?php
        $model->qq='1352645017';
        $model->object='自己';
        $model->color3= 'color:bule';
        $model->color2='color:bule';
        $model->title='遇见知音';
        $model->keywords='年少的我，满腔热血，那是我失去的青春！';
        $model->description='年少的我，满腔热血，那是我失去的青春！';
        $model->playlist=1;
        $model->state=1;
    ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
