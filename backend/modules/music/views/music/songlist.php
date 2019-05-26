
<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
$this->registerCss($this->render('css/smusic.css'));

$this->registerJs($this->render('js/smusic.min.js'));

$this->registerJs("
  var musicList = $songList;
 
//var musicList = [
//        {
//            title : 'Sugar',
//            singer : 'Maroon 5',
//            cover  : 'images/Maroon5.jpg',
//            src    : 'https://api.mlwei.com/music/api/wy/?key=523077333&cache=0&type=url&id=1335350269'
//        },
//        {
//            title : '洋葱',
//            singer : '平安',
//            cover  : 'images/yangcong.jpg',
//            src    : 'https://api.mlwei.com/music/api/wy/?key=523077333&cache=0&type=url&id=1335350269'
//        },
//        {
//            title : '她说',
//            singer : '张碧晨',
//            cover  : 'images/yangcong.jpg',
//            src    : 'https://api.mlwei.com/music/api/wy/?key=523077333&cache=0&type=url&id=1335350269'
//        },
//        {
//            title : '海阔天空',
//            singer : 'beyond',
//            cover  : 'images/yangcong.jpg',
//            src    : 'https://api.mlwei.com/music/api/wy/?key=523077333&cache=0&type=url&id=1335350269'
//        }
//    ];
    new SMusic({
        musicList:musicList
    });");


?>
<style>
    .aa{
        font-size: 20px; color: #1E9FFF; margin:5px 0 0 5px;
    }
</style>
    <div class="grid-music-container f-usn">
        <div class="m-music-play-wrap">
            <div class="u-cover"></div>
            <div class="m-now-info">
                <h1 class="u-music-title"><strong>标题</strong><small>歌手</small>
                    <a class="download-song" >
                        <i title="下载歌曲" class="download-song layui-icon layui-icon-download-circle aa" ></i>
                    </a>
                    <a onclick="usesong()" ><i title="应用歌曲" song-id='' class="use-song layui-icon layui-icon-add-circle-fine aa"></i></a>
                </h1>
                <div class="m-now-controls">
                    <div class="u-control u-process">
                        <span class="buffer-process"></span>
                        <span class="current-process"></span>
                    </div>
                    <div class="u-control u-time">00:00/00:00</div>
                    <div class="u-control u-volume">
                        <div class="volume-process" data-volume="0.50">
                            <span class="volume-current"></span>
                            <span class="volume-bar"></span>
                            <span class="volume-event"></span>
                        </div>
                        <a class="volume-control"></a>
                    </div>
                </div>
                <div class="m-play-controls">
                    <a class="u-play-btn prev" title="上一曲"></a>
                    <a class="u-play-btn ctrl-play play" title="暂停"></a>
                    <a class="u-play-btn next" title="下一曲"></a>
                    <a class="u-play-btn mode mode-list current" title="列表循环"></a>
                    <a class="u-play-btn mode mode-random" title="随机播放"></a>
                    <a class="u-play-btn mode mode-single" title="单曲循环"></a>
                </div>
            </div>
        </div>
        <div class="f-cb">&nbsp;</div>
        <div class="m-music-list-wrap"></div>
    </div>
<?php $this->beginBlock('js') ?>
        function usesong(songId){
            if(songId){
            setCookie('songId',songId,60);
            }
            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
            parent.layer.close(index);//关闭弹出的子页面窗口
        }
        function setCookie(cname,cvalue,second){
            var d = new Date();
            d.setTime(d.getTime()+second*1000+8*60*1000*60);
            var expires = "expires="+d.toGMTString();
            document.cookie = cname+"="+cvalue+"; "+expires;
        }



<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['js'], \yii\web\View::POS_END); ?>

