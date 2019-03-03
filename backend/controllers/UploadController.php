<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/1
 * Time: 23:19
 */
namespace backend\controllers;
use yii\web\Controller;

class UploadController extends Controller{
    public function actions() {
        return [
            'upload_more'=>[
                'class' => 'common\widgets\batch_upload\UploadAction'
            ]
        ];
    }

    public function actionUploadMore(){
    }
}
