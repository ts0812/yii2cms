<?php
namespace console\controllers;

use backend\models\Push;
use backend\models\blog\TrafficStatistics;
use yii\console\Controller;
use Yii;
class BlogController extends Controller{
    //统计访问流量
    function actionTraffic(){
        $n =1;
        $arr = [];  //数据集合
        $redis=Yii::$app->redis;
        while ($n--) {
            $num = 3;
            while ($num--) {
                $redisRow = $redis->rpop('traffic');
                if (!$redisRow) continue;
                $arr[] = json_decode($redisRow, true);
            }
        }
        if($arr){
            $tableName=TrafficStatistics::tableName();
            $attributeArr=array_keys($arr[0]);
            Yii::$app->db->createCommand()->batchInsert(
                $tableName,
                $attributeArr,
                $arr
            )->execute();
        }
    }
    //每日推送 降序 排序 24点更新
    public function actionPush(){
        $where = ['status'=>1];
        $model = Push::find()->where($where)->orderBy('sort desc')->one();
        if($model){
            $model->status=2;
            if($model->save()){
                $data['content']=$model->content;
                $data['url']=$model->url;
                $data['label']=$model->label;
                Yii::$app->redis->setex('push',60*60*24,json_encode($data,JSON_UNESCAPED_UNICODE));
            }
        }
    }

}