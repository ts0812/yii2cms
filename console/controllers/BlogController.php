<?php
namespace console\controllers;

use common\models\blog\Push;
use common\models\blog\Traffic;
use yii\console\Controller;
use Yii;
class BlogController extends Controller{
    //统计访问流量
    function actionTraffic(){
        $n =60;
        $arr = [];  //数据集合
        $redis=Yii::$app->redis;
        while ($n--) {
            $num = 100;
            while ($num--) {
                $redisRow = $redis->rpop('traffic');
                if (!$redisRow) continue;
                $arr[] = json_decode($redisRow, true);
            }
            if($arr){
                $tableName=Traffic::tableName();
                $attributeArr=array_keys($arr[0]);
                Yii::$app->blog->createCommand()->batchInsert(
                    $tableName,
                    $attributeArr,
                    $arr
                )->execute();
            }
            sleep(1);
        }

    }
    //每日推送 降序 排序 24点更新
    public function actionPush(){
        $where = ['status'=>1];
        $model = Push::find()->where($where)->orderBy('sort desc')->one();
        if($model){
            $model->status=2;
	    $model->pushtime = date('Y-m-d H:i:s');
            if($model->save()){
                $data['content']=$model->content;
                $data['url']=$model->url;
                $data['label']=$model->label;
		$redisName = Push::$_redisName;
                Yii::$app->redis->setex($redisName,60*60*24,json_encode($data,JSON_UNESCAPED_UNICODE));
            }
        }
    }

}
