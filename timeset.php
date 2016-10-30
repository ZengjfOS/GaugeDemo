<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/datedropper.css">
        <link rel="stylesheet" type="text/css" href="css/timedropper.min.css">
        <style type="text/css">
            .demo{margin:80px auto 40px auto;width:320px}
            .input{padding:6px;border:1px solid #d3d3d3}
        </style>
    </head>
    
    <body>
        <div id="main">
            <div class="demo">
                <p>请选择日期：<input type="text" class="input" id="pickdate" /></p><br/>
                <p>请选择时间：<input type="text" class="input" id="picktime" /></p><br/>
                <p><button id="settings" onclick="setting()">设置</button></p>
            </div>
        </div>
        
        <script type="text/javascript" src="js/jquery-1.12.3.min.js"></script>
        <script src="js/datedropper.min.js"></script>
        <script src="js/timedropper.min.js"></script>

        <script>
            // 设置日期格式
            $("#pickdate").dateDropper({
                animate: false,
                format: 'Y-m-d',
                maxYear: '2020'
            });

            // 设置时间格式
            $("#picktime").timeDropper({
                meridians: false,
                format: 'HH:mm',
            });

            function setting(){
            
                if(confirm("确定要设置数据")) {

                    # 获取数据并生成uri
                    var uri = "timedata.php?data="+$("#pickdate").val()+"&time="+$("#picktime").val();

                    $.post(uri, function(data){
                        // 通过判断返回值中是否存在UTC字符来判断时间设定是否正常
                        var bool = data.indexOf("UTC");
                        // 返回大于等于0的整数值，若不包含"Text"则返回"-1。
                        if(bool>0){
                            alert("设置成功！");
                        }else{
                            alert("设置失败，请联系管理员!");
                        }
                    });
                }
            }
        </script>
    </body>
</html>
