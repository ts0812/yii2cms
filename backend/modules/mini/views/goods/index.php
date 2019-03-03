<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\mini\Goods;
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel common\models\mini\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '添加商品';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>

    .grid-view{
        width: 80%;
        float: left;
    }
    .catalog{
        float: left;
        width: 8%;
        margin: 0 2% 0 2%;
        border: 1px solid #000;
        background-color: #d6e9c6;
        border-radius:15px;
        min-height: 300px;
    }
    dl dt{
        font-size:16px ;
        color: #1E9FFF;
        padding: 5px 0 0 5px;
    }
    .layui-icon-add-1{
        font-size:20px ;
        cursor: pointer;
        margin-left: 5px;
    }
    .layui-icon{
    }
    cite{
        font-size: 16px;
    }
    dd{
        margin-left:15%;
    }
    img{
        width: 50px;
        margin: 0 10px;
    }
    .label{
        background-color:#00FF00;
        margin: 0 2px;
    }
</style>
<div class="goods-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div style="margin:20px 10px;">
    <p>
        <?= Html::a('添加商品', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    </div>
    <div class="catalog">
        <dl>
            <dt><i>商品分类</i><i class="layui-icon layui-icon-add-1" title="添加"></i></dt>
            <?php
                $catalogList = (\common\models\mini\GoodsCatalog::getAllGoodsCatalog())??[];
                foreach ($catalogList as $k=>$v){
            ?>
            <dd class="catalog-name" data-id="<?=$k?>"><a href="javascript:;" ><i class="layui-icon">&#xe67a;</i>  <cite><?=$v?></cite></a></dd>
            <?php  } ?>
        </dl>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['attribute'=>'catalog_id','value'=>function($model){
                return \common\models\mini\GoodsCatalog::getCatalogName($model->catalog_id);
            }],
            'name',
            ['attribute'=>'label_ids','value'=>function($model){
                if($labels=$model->label){
                    $label='';
                    foreach ($labels as $k){
                        $label.='<span class="label">'.$k['name'].'</span>';
                    }
                    return $label;
                }
                },
                'filter' => \common\models\mini\Label::getAllLabel() ,
                'headerOptions' => ['max-width' => '100'],'format'=>'raw'
            ],
            ['attribute'=>'img','value'=>function($model){
                return '<img src="'.$model->img.'"/>';
            },
                'format'=>'raw'
            ],
            'or_price',
            'pr_price',
            ['attribute'=>'status','value'=>function($model){
                return (Goods::$_status)[$model->status];
                },
                'filter' => Goods::$_status ,//重点在这里，传入一个数组，会下拉框显示
                'headerOptions' => ['width' => '100']
            ],
            ['attribute'=>'admin_id','value'=>function($model){
                return \rbac\models\User::getUsername($model->admin_id);
            },
            ],
            'num',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
            ]
        ],
    ]); ?>
</div>
<?php
$js = <<<JS
layui.use('layer', function(){
  var layer = layui.layer;
});              
      
$(".layui-icon-add-1").on('click', function(){  
    layer.open({
        type: 2,
        title:'新增分类',
        skin: 'layui-layer-rim', //加上边框
        area: ['400px', '300px'], //宽高
        content: "catalog",  //调到新增页面
        end: function () {//无论是确认还是取消，只要层被销毁了，end都会执行，不携带任何参数。layer.open关闭事件
            location.reload();　　//layer.open关闭刷新
        }
    });
})
$(".catalog-name").on('click', function(){  
    let id=$(this).attr('data-id');
    layer.open({
        type: 2,
        title:'商品类名',
        skin: 'layui-layer-rim', //加上边框
        area: ['400px', '300px'], //宽高
        content: "catalog-view?id="+id,  //调到新增页面
        end: function () {//无论是确认还是取消，只要层被销毁了，end都会执行，不携带任何参数。layer.open关闭事件
            location.reload();　　//layer.open关闭刷新
        }
    });
})

JS;
$this->registerJs($js,\yii\web\View::POS_END);
?>
