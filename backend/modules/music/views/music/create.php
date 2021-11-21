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
        $model->background='https://gimg2.baidu.com/image_search/src=http%3A%2F%2Fi1.hdslb.com%2Fbfs%2Farchive%2Fd3741988e296c7ce957319778046a1488447ed67.jpg&refer=http%3A%2F%2Fi1.hdslb.com&app=2002&size=f9999,10000&q=a80&n=0&g=0n&fmt=jpeg?sec=1640090369&t=46e7e4b5ea98e41a4d838a9f7b08f012';
    ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
