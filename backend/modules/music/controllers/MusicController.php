<?php

namespace backend\modules\music\controllers;

use common\models\music\CommentSearch;
use common\models\music\Music;
use common\models\music\MusicSearch;
use common\models\music\PvSearch;
use Yii;
use common\models\Config;
use common\common\FilePath;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
/**
 * ConfigController implements the CRUD actions for Config model.
 */
class MusicController extends Controller
{
    /**
     * @inheritdoc
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

    /**
     * Lists all Config models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MusicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionSonglist(){
        $songName=yii::$app->request->get('songName','');
        $nu=(int)yii::$app->request->get('nu',10);
        $songList='';
        if($songName){
            $data=\backend\modules\api\models\music::SearchSong($songName,$nu);
            $songList = $data['songs']??[];
            $songDataLite=[];
            $mp3Url=\backend\modules\api\models\music::$mp3Url;
            foreach ($songList as $k=>$v){
                $songDataLite[$k]['title']=$v['name']??'';
                $songDataLite[$k]['singer']=$v['ar'][0]['name']??'';
                $songDataLite[$k]['cover']=$v['al'][0]['picUrl']??'';
                $songDataLite[$k]['src']=$v['id']?$mp3Url.$v['id'].'.mp3':'';
                $songDataLite[$k]['songid']=$v['id']??'';
            }
            $songDataLite=json_encode($songDataLite);
        }
        return $this->render('songlist', [
            'songList' => $songDataLite
        ]);
    }

    /**
     * Lists all Config models.
     * @return mixed
     */
    public function actionPv()
    {
        $searchModel = new PvSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('pv', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /*
     * 歌词编辑
     */
    public function actionLrc($id)
    {
        $model = $this->findModel($id);
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            if($data && $model->load($data)){
                if( $model->save())
                    return json_encode(['code'=>200,"msg"=>"修改成功"]);
                else{
                    $errors = $model->firstErrors;
                    return json_encode(['code'=>400,"msg"=>reset($errors)]);
                }
            }else
                return json_encode(['code'=>400,"msg"=>"请选择数据"]);
        }
        return $this->render('lrc', [
            'model' => $model,
        ]);
    }
    /**
     * 评论列表
     */
    public function actionComment()
    {
        $searchModel = new CommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('comment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
        /**
     * Displays a single Config model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Config model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Music();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Config model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				return $this->redirect(['index']);
			}
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Config model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->delete()){
            return json_encode(['code'=>200,"msg"=>"删除成功"]);
        }else{
            $errors = $model->firstErrors;
            return json_encode(['code'=>400,"msg"=>reset($errors)]);
        }
    }

    public function actionDeleteAll(){
        $data = Yii::$app->request->post();
        if($data){
            $model = new Music();

            $count = $model->deleteAll(["in","id",$data['keys']]);
            if($count>0){
                return json_encode(['code'=>200,"msg"=>"删除成功"]);
            }else{
				$errors = $model->firstErrors;
                return json_encode(['code'=>400,"msg"=>reset($errors)]);
            }
        }else{
            return json_encode(['code'=>400,"msg"=>"请选择数据"]);
        }
    }
    /**
     * Finds the Config model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Config the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Music::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}