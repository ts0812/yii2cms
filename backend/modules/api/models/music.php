<?php
namespace backend\modules\api\models;
use common\common\Curl;

class music{
    public static function SearchSong($songName,$nu)
    {
        $url='https://api.mlwei.com/music/api/wy/?key=523077333&id='.$songName.'&type=so&cache=1&nu='.$nu;
        $data = Curl::get($url);
        $data=json_decode($data,true);
        return $data;
    }
}
