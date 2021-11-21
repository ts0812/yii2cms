<?php
namespace backend\modules\api\models;
use common\common\Curl;
use common\common\ErrCode;
class music{
    private static $apiUrl="http://127.0.0.1:3000/"; //网易云api本地nodejs服务地址
    private static $lrcUrl="http://127.0.0.1:3000/lyric?id="; // 歌词地址
    private static $detailUrl="http://127.0.0.1:3000/song/detail?ids=";//歌曲详情
    public static $mp3Url="https://music.163.com/song/media/outer/url?id="; //网易云指定songId歌曲播放地址
    //搜索歌曲
    public static function SearchSong($songName,$nu)
    {
        //中文url编码
        $songName=urlencode($songName);
        //$url='https://api.mlwei.com/music/api/wy/?key=523077333&id='.$songName.'&type=so&cache=1&nu='.$nu;
//        必选参数 : keywords : 关键词
//        可选参数 : limit : 返回数量 , 默认为 30 offset : 偏移数量，用于分页 , 如 : 如 :( 页数 -1)*30, 其中 30 为 limit 的值 , 默认为 0
//        type: 搜索类型；默认为 1 即单曲 , 取值意义 : 1: 单曲, 10: 专辑, 100: 歌手, 1000: 歌单, 1002: 用户, 1004: MV, 1006: 歌词, 1009: 电台, 1014: 视频, 1018:综合
        $reqUrl = self::$apiUrl.'cloudsearch?keywords='.$songName.'&type=1&limit='.$nu.'&offset=0';
        $data = Curl::get($reqUrl);
        $data=json_decode($data,true);
        return $data['result'];
    }
    //获取网易云歌词
    public static function getLrc($songId=0){
        if(!$songId)
            ErrCode::errCode(0);
        $lrcUrl = self::$lrcUrl.$songId;
        $data = Curl::get($lrcUrl);
        $data=json_decode($data,true);
        ErrCode::errCode(1,$data);
    }
    //获取网易云指定音乐歌曲详情{歌名，作者，图片，MP3地址，lrc}
    public static function getMusicDetail($songId=0){
        if(!$songId)
            ErrCode::errCode(0);
        $detailUrl=self::$detailUrl.$songId;
        $data = Curl::get($detailUrl);

        $data=json_decode($data,true);
        $returnData['name']=$data["songs"][0]["name"]??'';
        $returnData['author']=$data["songs"][0]["ar"][0]["name"]??'';
        $returnData['picUrl']=$data["songs"][0]["al"]["picUrl"]??'';
        $returnData['mp3Url']=self::$mp3Url.$songId.'.mp3'??'';

        $lrcUrl = self::$lrcUrl.$songId;
        $data = Curl::get($lrcUrl);
        $data=json_decode($data,true);;
        $returnData['lrc']=$data['lrc']['lyric']??'';
        ErrCode::errCode(1,$returnData);
    }

}
