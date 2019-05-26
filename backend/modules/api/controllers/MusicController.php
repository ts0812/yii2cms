<?php

namespace backend\modules\api\controllers;
use common\models\music\Music;
use common\common\Curl;
use common\common\ErrCode;
use Yii;
use yii\web\Controller;
/**
 * ConfigController implements the CRUD actions for Config model.
 */
class MusicController extends Controller
{

    //http://www.mlwei.com/1446.html 搜索来自名流互联
    //https://api.mlwei.com/music/api/wy/?key=523077333&cache=1&type=songlist&id=1335350269  搜索来自名流互联
    //http://music.163.com/song/media/outer/url?id=1335350269.mp3    来自网易云音乐 歌曲链接
    //http://music.163.com/api/song/lyric?os=pc&id=1335350269&lv=-1&kv=-1&tv=-1 歌词lrc
    public $enableCsrfValidation = false;
    public $musicUrl = 'http://106.13.115.15:82/index.php?id=';  //音乐地址
    /**
     * @inheritdoc
     */
    /**
     * @OA\Get(
     *     path="/api/music/search",
     *     summary="音乐搜索",
     *     tags={"音乐api"},
     *     description="音乐数据来自网易，调用名流互联api， //http://www.mlwei.com/1446.html",

     *      @OA\Parameter(
     *         description="搜索歌曲名",
     *         in="query",
     *         name="songName",
     *         required=true,
     *         @OA\Schema(
     *           type="string",
     *           default="生儿为人"
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="搜索数目",
     *         in="query",
     *         name="nu",
     *         @OA\Schema(
     *           type="integer",
     *              default=10
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function actionSearch(){
        $songName=yii::$app->request->get('songName','');
        $nu=(int)yii::$app->request->get('nu',10);
        $data = \backend\modules\api\models\music::SearchSong($songName,$nu);
        if(!$data||!isset($data['Code'])||$data['Code']!='OK'||!isset($data['Body'])||!$data['Body'])
            ErrCode::errCode(9999);
        ErrCode::errCode(1,$data['Body']);
    }
    /*
     * 根据网易音乐id获取lrc
     */
    /**
     * @OA\Get(
     *     path="/api/music/get-lrc",
     *     summary="获取lrc歌词",
     *     tags={"音乐api"},
     *     description="根据网易音乐id获取lrc，音乐数据来自网易，调用名流互联api，https://api.mlwei.com/music/api/wy/?key=523077333&cache=1&type=lrc&id=1335350269",


     *      @OA\Parameter(
     *         description="网易音乐id",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *              default=1335350269
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function actionGetLrc(){
        $id=yii::$app->request->get('id','');
        if(!(int)$id)
            ErrCode::errCode(1009);
        $url='https://api.mlwei.com/music/api/wy/?key=523077333&cache=1&type=lrc&id='.$id;
        $data = Curl::get($url);
        if(!$data)
            ErrCode::errCode(9999);
        ErrCode::errCode(1,$data);
    }

    function get_tag_data($str,$tag='',$attrname='',$value=''){ //返回值为数组 ,查找到的标签内的内容
        $regex = "/<$tag.*?$attrname=\".*?$value.*?\".*?>(.*?)<\/$tag>/is";
        var_dump($regex);
        preg_match_all($regex,$str,$matches,PREG_PATTERN_ORDER); return $matches[1];
    }
    /**
     * @OA\Get(
     *     path="/api/music/get-music-list",
     *     summary="获取音乐列表",
     *     tags={"音乐api"},
     *     description="调用本站开放的数据库音乐",
     *     @OA\Parameter(
     *         description="歌曲名 搜索",
     *         in="query",
     *         name="name",
     *         @OA\Schema(
     *           type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="请求页码",
     *         in="query",
     *         name="page",
     *         @OA\Schema(
     *           type="integer",
     *              default=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="页码的页数，最多20条",
     *         in="query",
     *         name="size",
     *         @OA\Schema(
     *           type="integer",
     *              default=10
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function actionGetMusicList(){
        $page=(int)yii::$app->request->get('page',1);
        $size=(int)yii::$app->request->get('size',10);
        $name= yii::$app->request->get('name','');
        $type=(int)yii::$app->request->get('type',0);  //暂无用
        if($size>20)
            $size=20;
        $where = ['>','state',0];
        $select=['id','image','title'];
        $query = Music::find()->where($where);
        if($name)
            $query->andWhere(['like','song',$name]);
        $musicList = $query->select($select)->offset(($page-1)*$size)->limit($size)->asArray()->all();
        foreach ($musicList as $k=>$v)
                $musicList[$k]['url']=$this->musicUrl . $v['id'];

        ErrCode::errCode(1,$musicList);
    }
    /*
     * 切换歌 $switch 0 上一首 1 下一首
     */
    /**
     * @OA\Get(
     *     path="/api/music/switch-music",
     *     summary="切换音乐",
     *     tags={"音乐api"},
     *     description="调用本站开放的数据库音乐，歌单首尾循环",

     *      @OA\Parameter(
     *         description="当前音乐id",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *              default=1
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="切换动作 0 上一首 1 下一首 默认1",
     *         in="query",
     *         name="switch",
     *         @OA\Schema(
     *           type="integer",
     *              default=1
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function actionSwitchMusic(){
        $id=(int)yii::$app->request->get('id',0);
        $switch=(int)yii::$app->request->get('switch',1);
        if(!$id || !in_array($switch,[0,1]))
            ErrCode::errCode(1009);
        $select=['id','image','title'];
        $where=['>','state',0];
        $model = Music::find()->select($select)->where($where)->asArray();
        if($switch==0)
            $model->andWhere(['<','id',$id]);
        else
            $model->andWhere(['>','id',$id]);
        $musicList =  $model ->one();
        if(!$musicList){
            $model = Music::find()->select($select)->where($where)->asArray();
            if($switch==0)
                $model->orderBy('id DESC');
            else
                $model->orderBy('id ASC');
            $musicList =  $model->one();
        }
        if($musicList['id'])
            $musicList['url']=$this->musicUrl . $musicList['id'];
        ErrCode::errCode(1,$musicList);
    }
}
