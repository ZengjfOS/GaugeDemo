
<!-- Access-Control-Allow-Origin与跨域: http://www.tuicool.com/articles/7FVnMz -->
<?php header('Access-Control-Allow-Origin:http://192.168.1.147/'); ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Insert title here</title>
        <script type="text/javascript" src=js/svg.js></script>
        <script type="text/javascript" src=js/svg.min.js></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript">

            // Jquery中"$(document).ready(function(){ })"函数的使用详解: http://www.jb51.net/article/45002.htm
            $(document).ready(function(){ 

                // 得到图形将被绘制的div标签
                var draw = SVG('drawing').size(1134, 680);

                // 获取公司平面json数据，里面是绘制svg图形的数据
                $.getJSON("json/company_1.json",function(data){

                    // 对所有的数据进行for each迭代
                    $.each(data,function(i,item){

                        // 1. 这里需要考虑先画后画 后画的会覆盖先画的
                        // 2. 如下是其中一个item中的数据
                        //    {
                        //        "id":"ck",
                        //        "name":"仓库",
                        //        "path":"M3 5L3 327L271 327L271 5L3 5Z",
                        //        "textX":120,
                        //        "textY":165,
                        //        "door":[{"doorOpen":"M271 327L221 208","doorClose":"M271 327L271 190"}]
                        //    },
            
                        // 绘制方框
                        var rect = draw.path(item['path']).attr({ fill: '#B7B4BC' ,stroke:'#000'});
                        // 绘制方框中的文字
                        var text = draw.text(item['name']).font({ family:'Microsoft YaHei',size: 16}).move(item['textX'],item['textY']);    
                        // 当鼠标移入方框中，回调函数
                        rect.mouseover(function() {
                            this.attr({ fill: '#868191' });
                            this.transform({ scaleX : 1,scaleY : 1 });
                        });

                        // 当鼠标移出方框中，回调函数
                        rect.mouseout(function() {
                            this.attr({ fill: '#B7B4BC' });
                            this.transform({ scaleX : 1 ,scaleY : 1});
                        });

                        // 当鼠标点击方框中时，回调函数
                        rect.click(function() {

                           // 这个相当于图形标示符
                           var id = item['id'];
                           // 图形是否已经存在
                           var idExistence = false;

                           // 获取房间json数据
                           $.getJSON("json/room.json",function(data){

                               // 对所有的数据进行for each迭代
                               $.each(data,function(i,room_item){
                                   if(room_item['id']==id){
                                      idExistence = true;
                                   }
                               });

                               // 如果房间正好存在对应的设备，那么跳转到传感器设备处，如果不存在，那么给出提示信息，id相当于房间号
                               if(idExistence){
                                   window.location.href="sensor.php?id="+id;
                               }else{
                                   alert("this room without device");
                               }
                           });    
                           
                        });
                    });

                    // 再次对所有的数据进行迭代
                    $.each(data,function(i,item){

                        // 获取item中door对应的字段
                        var arr = item['door'];

                        // 迭代door数组，有些房间有两个门
                        $.each(arr,function(j,sub_item){
                            draw.path(sub_item['doorOpen']).attr({ stroke:'#000'}).stroke({ width: 2 });
                            draw.path(sub_item['doorClose']).attr({ stroke:'#B7B4BC'}).stroke({ width: 2 });
                        });
                    });
                });     
            });
        </script>

        <style type="text/css">
            /* 通过全局css设定body居中对齐 */
            body{
                 text-align:center; 
                /* width: 1440px; */ 
                /* height:900px;  */ 
            }
        </style>

    </head>

    <body>
        <!-- 图形会被绘制在这个div中 -->
        <div id="drawing" style="margin-top:50px;"></div>
    </body>

</html>
