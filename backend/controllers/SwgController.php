<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
/**
 * Site controller
 */
class SwgController extends Controller
{
    /**
     * Displays homepage.
     * @return string
     */
    public function actionIndex()
    {
        $projectRoot = Yii::getAlias('@backend');
        $projectRoot = $projectRoot.'/modules/api';
        $swagger = \OpenApi\scan($projectRoot);
        header('Content-Type: application/x-yaml');
        yii::$app->end($swagger->toYaml());
    }
}
