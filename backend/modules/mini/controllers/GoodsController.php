<?php

namespace backend\modules\mini\controllers;

use common\common\ArrayHelper;
use common\common\ErrCode;
use common\models\mini\GoodsCatalog;
use common\models\mini\GoodsLabel;
use common\models\mini\Label;
use Yii;
use common\models\mini\Goods;
use common\models\mini\GoodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
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

    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $LabelIds=ArrayHelper::map(GoodsLabel::findAll(['goods_id'=>$model->id]),'label_id','label_id');
        $model->label_ids=$LabelIds;
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goods();
        if ($model->load(Yii::$app->request->post())) {
                $model->admin_id=yii::$app->user->id;
                $model->show_img=json_encode($model->show_img);
                if($model->save()){
                    $nowLabel=empty($model->label_ids)?[]:$model->label_ids;
                    $this->updateLabel($model->id,$nowLabel,[]);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new GoodsCatalog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCatalog($id='')
    {
        if($id)  //修改
            $model=$this->findCatalogModel($id);
        else  //新增
            $model = new GoodsCatalog();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['catalog-view', 'id' => $model->id]);
        }

        return $this->render('catalog', [
            'model' => $model,
        ]);
    }
    public function actionCatalogView($id='')
    {
        return $this->render('catalog-view', [
            'model' => $this->findCatalogModel($id),
        ]);
    }
    public function actionCatalogDelete()
    {
        $id=yii::$app->request->post('id');
        if($id){
            if(GoodsCatalog::findOne($id)->delete())
                ErrCode::errCode(1);
        }
        ErrCode::errCode(1009);
    }
    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $LabelIds=ArrayHelper::map(GoodsLabel::findAll(['goods_id'=>$model->id]),'label_id','label_id');
        $model->label_ids=$LabelIds;
        if ($model->load(Yii::$app->request->post()) ) {
            $model->show_img=json_encode($model->show_img);
            $nowLabel=empty($model->label_ids)?[]:$model->label_ids;
            $this->updateLabel($model->id,$nowLabel,$LabelIds);
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    private function updateLabel(int $id, array $nowLabelIds, array $LabelIds)
    {
        //要添加的权限
        $add = array_diff($nowLabelIds, $LabelIds);
        //要取消的权限
        $delete = array_diff($LabelIds, $nowLabelIds);
        //添加权限 插入数据
        $model = new GoodsLabel();
        if ($add) {
            foreach ($add as $labelId) {
                $model->isNewRecord = true;
                $model->setAttributes(['label_id' => $labelId, 'goods_id' => $id]);
                $model->save() && $model->id = 0;;
            }
        }
        //取消权限 删除数据
        if ($delete) {
            foreach ($delete as $labelId) {
                $model=GoodsLabel::find()->where(['label_id' => $labelId, 'goods_id' => $id])->one();
                if($model)
                    $model->delete();
            }
        }
    }
    /**
     * Deletes an existing Goods model.
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
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * Finds the GoodsCatalog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GoodsCatalog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findCatalogModel($id)
    {
        if (($model = GoodsCatalog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
