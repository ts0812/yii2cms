<?php

namespace backend\modules\api;

/**
 * article module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @OA\Info(
     *     version="1.0",
     *     title="本站开放接口"
     * )
     */


    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\api\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
