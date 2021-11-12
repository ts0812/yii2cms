<?php

namespace backend\modules\social\controllers;

use common\models\social\AdminUser;
use Yii;
use common\models\social\User;
use common\models\social\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
include_once(dirname(__FILE__). '/LunarSolarConverter.class.php');
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param string $id
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            $this->addNextBirthday($model);
                $adminUserModel = new AdminUser();

                if($model->save()){
                    $adminUserModel->admin_id = Yii::$app->user->id;
                    $adminUserModel->user_id = $model->id;
                    $adminUserModel->save();
                    return $this->redirect('index');
                }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    //判断今年生日是否已过
    function checkNextBirthday($time=0){
        if($time<time())
            return false;
        return  date('Y-m-d',$time);
    }
    //判断添加下一个生日时间（公历）
    function addNextBirthday($model){
        if($model->birthday){
            $time = strtotime($model->birthday);
            $thisYearBirTime = mktime(0,0,0,date('m',$time),date('d',$time),date('Y'));
            //过阴历生日
            if( $model->birthday_type==0){
                $lunar= new \Lunar();
                for ($i=0;$i<2;$i++){
                    $lunar->lunarYear = date('Y')+$i;
                    $lunar->lunarMonth = date('m',$thisYearBirTime);
                    $lunar->lunarDay = date('d',$thisYearBirTime);
                    //阴历转阳历
                    $birthday_solar = \LunarSolarConverter::LunarToSolar($lunar);
                    //判断今年的生日是否已过，返回正确的下一个阳历生日
                    $next_birthday_solar = $this->checkNextBirthday(mktime(0,0,0,$birthday_solar->solarMonth,$birthday_solar->solarDay,$lunar->lunarYear ));
                    if($next_birthday_solar)
                        break;
                }
            }else{
                if(!$next_birthday_solar = $this->checkNextBirthday($thisYearBirTime))
                    $next_birthday_solar = date('Y-m-d',mktime(0,0,0,date('m',$thisYearBirTime),date('d',$thisYearBirTime),date('Y')+1));
            }
            $model->next_birthday = $next_birthday_solar;
        }
    }
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $this->addNextBirthday($model);
            if($model->save())
                return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $uid = Yii::$app->user->id;
        $m = AdminUser::find()->where(['admin_id'=>$uid,'user_id'=>$id])->one();
        if($m&&$m->id)
            $m->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
