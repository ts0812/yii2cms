<?php

namespace backend\modules\api\controllers;
use common\common\ErrCode;
use common\models\blog\AppHistory;
use common\models\blog\Article;
use common\models\blog\ArticleContent;
use common\models\blog\Index;
use common\models\blog\Push;
use common\models\blog\Navigation;
use Yii;
use yii\web\Controller;
/**
 * ConfigController implements the CRUD actions for Config model.
 */
class BlogController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    /**
     * @OA\Get(
     *     path="/api/blog/index",
     *     summary="首页展现作品",
     *     tags={"博客api"},
     *     description="展现在首页的作品,按sort升序排列",
     *      @OA\Parameter(
     *         description="请求页码",
     *         in="query",
     *         name="page",
     *         @OA\Schema(
     *           type="integer",
     *              default=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="页码的页数，最多20条",
     *         in="query",
     *         name="size",
     *         @OA\Schema(
     *           type="integer",
     *              default=10
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function actionIndex(){
        $page=(int)yii::$app->request->get('page',1);
        $size=(int)yii::$app->request->get('size',10);
        if($size>20)
            $size=20;
        $where['status'] = 1;
        $select=['image','type','title','url','description'];
        $indexList = Index::find()->select($select)->where($where)
            ->offset(($page-1)*$size)->limit($size)->orderBy('sort asc')->asArray()->all();
        foreach ($indexList as $k=>$v)
            $indexList[$k]['type']=Index::$_type[$v['type']]??'';
        ErrCode::errCode(1,$indexList);
    }

    /**
     * @OA\Get(
     *     path="/api/blog/nav",
     *     summary="博客目录",
     *     tags={"博客api"},
     *     description="博客展现目录 升序排列",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function actionNav(){
        $where['status'] = 1;
        $select=['icon','title','url'];
        $navList = Navigation::find()->select($select)->where($where)->orderBy('sort asc')
            ->asArray()->all();
        ErrCode::errCode(1,$navList);
    }
    /**
     * @OA\Get(
     *     path="/api/blog/get-article",
     *     summary="获取文章内容",
     *     tags={"博客api"},
     *     description="根据文章id获取内容",


     *      @OA\Parameter(
     *         description="文章id",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *              default=10002
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function actionGetArticle(){
        $id=yii::$app->request->get('id','');
        if(!(int)$id)
            ErrCode::errCode(1009);
        $where = ['content_id'=>$id];
	$model=Article::findOne($where);
        if($model){
	   $model->view_num = (int)($model->view_num)+1;
	   if(!$model->save())
		ErrCode::errCode(0,$model->getErrors());
	   $select=['author','title','type','keywords','description','addtime','image','view_num'];
           $article = Article::find()->select($select)->where($where)->asArray()->one();

           $ArticleContent= ArticleContent::findOne($id);
           $article['content']=$ArticleContent['content']??'';
           $article['type']=(Article::$_type)[$article['type']]??'';
        }
        ErrCode::errCode(1,$article);
    }
    /**
     * @OA\Get(
     *     path="/api/blog/get-article-list",
     *     summary="获取文章列表",
     *     tags={"博客api"},
     *     description="获取文章列表,按sort升序排列",
     *      @OA\Parameter(
     *         description="请求页码",
     *         in="query",
     *         name="page",
     *         @OA\Schema(
     *           type="integer",
     *              default=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="页码的页数，最多20条",
     *         in="query",
     *         name="size",
     *         @OA\Schema(
     *           type="integer",
     *              default=10
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="1原创 2投稿 3转载 ",
     *         in="query",
     *         name="type",
     *         @OA\Schema(
     *           type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function actionGetArticleList(){
        $page=(int)yii::$app->request->get('page',1);
        $size=(int)yii::$app->request->get('size',10);
        $type=(int)yii::$app->request->get('type');
        if($size>20)
            $size=20;
        $where['status'] = 1;
        $select=['title','type','author','content_id','description','addtime','image'];
        $model = Article::find()->select($select)->where($where);
        if($type)
            $model->andWhere(['article.type'=>$type]);
        $indexList=$model->offset(($page-1)*$size)->limit($size)
            ->orderBy('sort asc')->asArray()->all();
        foreach ($indexList as $k=>$v)
            $indexList[$k]['type']=Article::$_type[$v['type']]??'';
        ErrCode::errCode(1,$indexList);
    }
    /**
     * @OA\Get(
     *     path="/api/blog/get-history-list",
     *     summary="获取博客历程",
     *     tags={"博客api"},
     *     description="获取博客历程,按时间降序排列",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function actionGetHistoryList(){
        $where = ['status'=>1];
        $select = ['content','addtime'];
        $historyList = AppHistory::find()->where($where)->select($select)
            ->orderBy('addtime desc')->asArray()->all();
        foreach ($historyList as $k=>$v){
            $time = strtotime($v['addtime']);
            $historyList[$k]['year']=date('Y',$time);
            $historyList[$k]['md']=date('m. d',$time);
        }
        ErrCode::errCode(1,$historyList);

    }
    public function actionPush(){
	$redisName = Push::$_redisName;   
	$res = Yii::$app->redis->get($redisName);
	$data = [];
	if($res)
	    $data = json_decode($res,true);
	ErrCode::errCode(1,$data);	
    }
}
