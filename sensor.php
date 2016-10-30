
<!DOCTYPE html>
<!-- saved from url=(0071)http://www.gbtags.com/technology/democenter/20120823-gauge-justgage-js/ -->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=GBK">
        <title>AplexOS</title>

        // 载入jQuery库的最佳方法: http://www.cnblogs.com/public/archive/2011/05/15/2047063.html
        <script>window.jQuery || document.write('<script src="http://cdn.gbtags.com/jquery/1.7.1/jquery.min.js"><\/script>')</script>

        <script src="./js/jquery.min.js"></script>
        <link type="text/css" rel="stylesheet" href="./css/meshcms.css">
        <link type="text/css" rel="stylesheet" href="./css/main.css">
        <style>
            body {
                text-align: center;
                font-family: Arial;
            }
            #g1,#g2,#g3,#g4,#g5,#g6{
                width: 400px;
                height: 320px;
                display: inline-block;
                margin: 1em;
                border: 1px soild #202020;
                box-shadow: 0px 0px 15px #101010;
                margin-top: 30px;
                border-radius: 8px;
            }
            p {
                display: block;
                width: 400px;
                margin: 2em auto;
                text-align: center;
                border-top: 1px soild #CCC;
                border-bottom: 1px soild #CCC;
                background: #333333;
                padding: 10px 0px;
                color: #CCC;
                text-shadow: 1px 1px 25px #000000;
                border-radius: 0px 0px 5px 5px;
                box-shadow: 0px 0px 10px #202020;
            }
        </style>
        
        <script src="./js/raphael.2.1.0.min.js"></script>
        <script src="./js/justgage.1.0.1.min.js"></script>
        <script>

            var g1,g2,g3,g4,g5,g6;
            var host;
            
            // 从sensordata.php中获取传感器的数据，并刷新UI上对应的数据
            function getSensorInfo(){

                // 这里后缀补上当前时间的原因是防止浏览器对请求缓存
                var uri = "sensordata.php?data=" + new Date().getTime();

                // 获取get请求
                $.get(uri, function(data){

                    // alert(data);
                    
                    // 把json字符串解析成json对象;
                    var jsonData = JSON.parse(data);
                    var code = jsonData['code'];
                    var mysqlData = jsonData['data'];

                     
                    // 200表示一切正常
                    if(code == 200){
                        var value = "";
                        for (var key in mysqlData){

                            // 获取key对应的value
                            value = mysqlData[key];

                            switch (key) {
                            case "temperature":
                                //alert(value);    
                                g1.refresh(value);
                               break;
                            case "humidity":
                               g2.refresh(value);    
                                break;
                            case "brightness":
                                g3.refresh(value);    
                               break;
                            case "noise":
                                value = value; 
                                g4.refresh(value);    
                                break;
                            case "pm2dot5":
                                g5.refresh(value);    
                                break;
                            case "airPress":
                                g6.refresh(value);    
                                break;
                            default:
                                break;
                            }
                        }
                    }
                }); 
            }
            
            // 界面加载完成后创建所有Guage对象
            $(document).ready(function() {

                var isExt = false;

                // 获取get请求中的id参数，这个id相当于房间号
                var param_id = "<?php echo $_GET["id"]?>";

                // 解析room配置信息，只有room配置信息存在，才能去生成Guage设备
                $.getJSON("json/room.json",function(data){

                    $.each(data,function(i,item){
                        if(item['id']==param_id){

                            // 这部分内容这个页面没有用到
                              
                            host = item['host'];
                            // alert(host);
                            isExt = true;
                        }
                    });

                    // 接下来创建6个传感器设备
                    
                    g1 = new JustGage({
                        id: "g1", 
                        value: 0, 
                        min: 0,
                           max: 100,
                        title: "temperature",
                        label: "℃",
                    });
                      
                    g2 = new JustGage({
                        id: "g2", 
                        value: 0, 
                        min: 0,
                        max: 100,
                        title: "humidity",
                        label: "%",
                        levelColors: [
                            "#222222",
                            "#555555",
                            "#CCCCCC"
                        ]    
                    });

                    g3 = new JustGage({
                        id: "g3", 
                        value: 0, 
                        min: 0,
                        max: 100,
                        title: "brightness",
                        label: "L",
                        levelColors: [
                            "#222222",
                            "#555555",
                            "#CCCCCC"
                        ]    
                    });

                    g4 = new JustGage({
                        id: "g4", 
                        value: 0, 
                        min: 30,
                        max: 120,
                        title: "noise",
                        label: "dB",
                        levelColors: [
                            "#222222",
                            "#555555",
                            "#CCCCCC"
                        ]
                    });

                    g5 = new JustGage({
                        id: "g5", 
                        value: 0, 
                        min: 0,
                        max: 250,
                        title: "pm2dot5",
                        label: "μg/m³",
                    }); 

                    g6 = new JustGage({
                        id: "g6", 
                        value: 0, 
                        min: 30,
                        max: 110,
                        title: "ATM",
                        label: "kpa",
                        levelColors: [
                            "#222222",
                            "#555555",
                            "#CCCCCC"
                        ]    
                    }); 

                    getSensorInfo();

                    // 每隔3s获取一次传感器信息
                    window.setInterval("getSensorInfo()",3000);
                });    
            });
        
        </script>
    </head>

    <body>

        <section>
            <div id="g1"></div>
            <div id="g2"></div>
            <div id="g3"></div>
            <div id="g4"></div>
            <div id="g5"></div>
            <div id="g6"></div>
        </section>

        <script src="./js/h.js" type="text/javascript"></script>

    </body>

    <div></div>

</html>
