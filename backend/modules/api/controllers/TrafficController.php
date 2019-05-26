<?php

namespace backend\modules\api\controllers;
use common\common\ErrCode;
use common\models\blog\Traffic;
use Yii;
use yii\web\Controller;
/**
 * ConfigController implements the CRUD actions for Config model.
 */
class TrafficController extends Controller
{
    public $enableCsrfValidation = false;
    /*
     * 收集流量
     */
    /**
     * @OA\POST(
     *     path="/api/traffic/index",
     *     summary="收录链接流量",
     *     tags={"流量统计api"},
     *     description="采集网页访问流量",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="url",
     *                     type="string",
     *                 ),
     *                 example={"url": "127.0.0.1"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function actionIndex()
    {
        //解析js post请求类型 data-form payload
        $request_body = file_get_contents('php://input');
        $data = json_decode($request_body, true);
        $url =$data['url']??'';
        //解析js post 请求 类型 data-form
        if(!$url)
            $url=yii::$app->request->post('url','');
        if($url){
            $headers =Yii::$app->request->headers;
            $model = new Traffic();
            $model->referer=$headers['referer']??'';
            $model->user_agent=$headers['user-agent']??'';
            $model->ip=Yii::$app->request->userIP;
            $model->url=$url;
            if($model->save())
                ErrCode::errCode(1,'流量统计中');
        }
        ErrCode::errCode(0,'流量统计失败');

    }
    /*
     * @param $url 统计地址 $startTime 开始时间 (时间戳)$endTime 截至时间(时间戳)
     */
    /**
     * @OA\POST(
     *     path="/api/traffic/traffic",
     *     summary="页面流量分析",
     *     tags={"流量统计api"},
     *     description="未指定url，返回所有收录链接数据",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="url",
     *                     type="string",
     *                 ),
     *                 example={"url": "127.0.0.1"}
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="开始时间(时间戳)",
     *         in="query",
     *         name="startTime",
     *         @OA\Schema(
     *           type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="截至时间(时间戳) ",
     *         in="query",
     *         name="endTime",
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

    public function actionTraffic(){
        $url=yii::$app->request->post("url",'');
        $startTime=(int)yii::$app->request->get('startTime','');
        $endTime=(int)yii::$app->request->get('endTime','');
        if($startTime>$endTime)
            ErrCode::errCode(0,'截至时间不能小于开始时间');
        $model = Traffic::find()->select('url,ip');
        if($url)
            $model->andWhere(['url'=>$url]);
        if($startTime)
            $model->andWhere(['>','addtime',date('Y-m-d H:i:s',$startTime)]);
        if($endTime)
            $model->andWhere(['<','addtime',date('Y-m-d H:i:s',$endTime)]);
        $TrafficData = $model->asArray()->all();
        $data = [];
        foreach ($TrafficData as $k=>$v)
            $data[$v['url']][]=$v['ip'];
        $resArr=[];
        $i=0;
        foreach ($data as $k=>$v){
            $resArr[$i]['url']=$k;
            $resArr[$i]['pv']=count($v);
            $resArr[$i]['uv']=count(array_unique($v));
            $i++;
        }
        ErrCode::errCode(1,$resArr);
    }
}
