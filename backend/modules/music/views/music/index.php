<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\LayuiAsset;
use yii\grid\GridView;
LayuiAsset::register($this);
$this->registerJs($this->render('js/index.js'));
/* @var $this yii\web\View */
/* @var $searchModel common\models\searchs\ConfigSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<blockquote class="layui-elem-quote" style="font-size: 14px;">
		    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
	</blockquote>
<div class="config-index layui-form news_list">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => ['class' => 'grid-view','style'=>'overflow:auto', 'id' => 'grid'],
		'tableOptions'=> ['class'=>'layui-table'],
		'pager' => [
			'options'=>['class'=>'layuipage pull-right'],
				'prevPageLabel' => '上一页',
				'nextPageLabel' => '下一页',
				'firstPageLabel'=>'首页',
				'lastPageLabel'=>'尾页',
				'maxButtonCount'=>5,
        ],
		'columns' => [
			[
				'class' => 'backend\widgets\CheckboxColumn',
				'checkboxOptions' => ['lay-skin'=>'primary','lay-filter'=>'choose'],
				'headerOptions' => ['width'=>'50','style'=> 'text-align: center;'],
				'contentOptions' => ['style'=> 'text-align: center;']
			],
           'id',
            [
				'attribute' => 'title',
				'headerOptions' => [
					'width' => '10%',
				],
                'format'=>'raw',
                'value'=>function($model){
                    return '<a href="http://music.mybdxc.cn/index.php?id='.$model['id'].'" target="_blank" title="'.$model['title'].'" >'.$model['title'].'</a>';
                }
			],
            [
				'attribute' => 'song',
				'headerOptions' => [
					'width' => '10%'
				],
                'format'=>'raw',
                'value'=>function($model){
                    return '<a href="'.$model['mp3'].'" target="_blank" title="'.$model['song'].'">'.$model['song'].'</a>';
                }
			],
            [
                'attribute' => 'image',
                'format'=>'raw',
                'value'=>function($model){
                    return '<img width="80" height="80" src="'.$model['image'].'"/>';
                }

            ],

            [
                'attribute' => 'background',
                'format'=>'raw',
                'value'=>function($model){
                    return '<a href="'.$model['background'].'" target="_blank" title="'.$model['background'].'" class="layui-btn layui-btn-xs">查看</a>';
                }
            ],
            [
				'attribute' => 'object',
                'format'=>'raw',
                'value'=>function($model){
                    return '<a title="'.$model['qq'].'" class="layui-btn layui-btn-xs">'.$model['object'].'</a>';
                }
			],
            [
                'attribute' => 'lrc',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a('编辑', Url::to(['lrc','id'=>$model->id]), ['class' => "layui-btn layui-btn-danger layui-btn-xs layui-default-lrc"]);
                }
            ],
            [
                'attribute' => 'playlist',
                'value'=>function($model){
                    return (\common\models\music\Music::$_playlist)[$model['playlist']] ?? '';}
            ],
            [
                'attribute' => 'pv',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a('查看', Url::to(['pv/index','PvSearch[music_id]'=>$model->id]), ['class' => "layui-btn layui-btn-xs layui-default-pv"]);
                }
            ],
            [
                'attribute' => '评论',
                'format'=>'raw',
                'value'=>function($model){
                    return Html::a('查看', Url::to(['comment/index',"CommentSearch[music_id]"=>$model->id]), ['class' => "layui-btn layui-btn-xs layui-default-comment"]);
                }
            ],
			'create_time',
			[
				'attribute' => 'state',
				'format' => 'html',
				'value' => function($model) {
                    return (\common\models\music\Music::$_state)[$model['state']] ?? '';
                }
			],
            [
				'header' => '操作',
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['class'=>'text-center'],
				'headerOptions' => [
					'width' => '10%',
					'style'=> 'text-align: center;'
				],
				'template' =>'{update} {delete}',
				'buttons' => [
                    'update' => function ($url, $model, $key) {
						return Html::a('修改', Url::to(['update','id'=>$model->id]), ['class' => "layui-btn layui-btn-normal layui-btn-xs "]);
                    },
					'delete' => function ($url, $model, $key) {
						return Html::a('删除', Url::to(['delete','id'=>$model->id]), ['class' => "layui-btn layui-btn-danger layui-btn-xs layui-default-delete"]);
					}
				]
			],
        ],
    ]); ?>
</div>

