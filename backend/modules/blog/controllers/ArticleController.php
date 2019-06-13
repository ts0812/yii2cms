<?php

namespace backend\modules\blog\controllers;

use common\models\blog\ArticleContent;
use Yii;
use common\models\blog\Article;
use common\models\blog\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actions(){
        return [
            'ueditor'=>[
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //自定义文件保存绝对目录
                    'uploadFilePath'=>dirname(dirname(Yii::$app->BasePath)),
                    //自定义第三方服务器域名（或本域名）
                    'resourceUrl'=>'http://resource.mybdxc.cn',
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }
    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $article = new ArticleContent();
        $data = Yii::$app->request->post();

        $transaction = Yii::$app->blog->beginTransaction();  //开启事务
        try {
            if($article->load($data) && $article->save()){
                $model->content_id=$article->id;
                if ($model->load($data) && $model->save()) {
                    // 提交记录(执行事务)
                    $transaction->commit();
                    return $this->redirect('index');
                }
            }
        } catch (Exception $e) {
             // 记录回滚（事务回滚）
            $transaction->rollBack();
        }
        return $this->render('create', [
            'model' => $model,
            'article'=>$article,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $article = ArticleContent::findOne($model->content_id);
        if ($model->load(Yii::$app->request->post()) && $model->save()&&$article->load(Yii::$app->request->post()) && $article->save()) {
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
            'article'=>$article
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
