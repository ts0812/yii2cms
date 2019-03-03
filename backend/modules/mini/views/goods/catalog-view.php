<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\mini\GoodsCatalog */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Goods Catalogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
    .goods-catalog-view{
        width: 70%;
        margin: 0 15%;
        padding-top:5% ;
    }
</style>
<div class="goods-catalog-view">



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            ['attribute'=>'status','value'=>function($model){
                return (\common\models\mini\GoodsCatalog::$_status)[$model->status];
            }],
            'create_time',
        ],
    ]) ?>
    <p>
        <?= Html::a('修改', ['catalog', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <a>
        <?= Html::a('删除', '#', [
            'class' => 'btn btn-danger',
            'onclick'=>"catalogDel($model->id)"
        ]) ?>
    </p>

</div>
<?php
$js = <<<JS
layui.use('layer', function(){
  let layer = layui.layer;
});              
      
    function catalogDel(id=''){
        layer.confirm('确认要删除吗？', {
            btn : [ '确定', '取消' ]//按钮
        }, function(index) {
            layer.close(index);
            $.ajax({
                url: "catalog-delete",
                type: "POST",        //请求类型
                data: {id:id},
                dataType: "json",
                success: function (res) {
                        if(res.status==1){
                            layer.msg('删除成功');
                            let index2 = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                            parent.layer.close(index2); //再执行关闭  
                        }
                        else
                            layer.msg(res.message);
                        },
                error: function () {
                    //当请求错误之后，自动调用
                }
            });
           
        });
    }
JS;
$this->registerJs($js,\yii\web\View::POS_END);
?>
