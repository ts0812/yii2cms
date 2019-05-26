layui.config({
	base : "js/"
}).use(['form','layer','jquery','layedit','laydate'],function(){
			$('.search_button').click(function () {
				let songName = $(this).parent().find('input').val();
				let url = 'songlist?songName=' + songName;
				if (!songName)
					return false;
				var index = layui.layer.open({
					title: songName,
					type: 2,
					area: ['600px', '500px'], //宽高
					content: url,
					success: function (index) {

						layer.iframeAuto(index);
					},
                    end: function () {//无论是确认还是取消，只要层被销毁了，end都会执行，不携带任何参数。layer.open关闭事件
                        let songId=getCookie('songId');
                        if(songId){
                            url='https://api.mlwei.com/music/api/wy/?key=523077333&cache=1&type=url&id='+songId;
                            $("#music-mp3").val(url);
                            url='https://api.mlwei.com/music/api/wy/?key=523077333&cache=0&type=pic&id='+songId;
                            $("#music-image").val(url);
                            $("#music-small_image").val(url);
                            $.ajax({
                                url:'/api/music/get-lrc?id=' + songId,
                                type:'get',
                                dataType:'json',
                                success:function(data){
                                    if(data.status==1){
                                        $("#music-lrc").val(data.data);
                                    }else{
                                        layer.msg(data.message);
                                    }
                                },
                                error:function () {
                                    layer.msg('系统错误');
                                }
                            })
                        }
                    }
				});
				return false;
			});
    function getCookie(cname){
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(name)==0) { return c.substring(name.length,c.length); }
        }
        return "";
    }
})
