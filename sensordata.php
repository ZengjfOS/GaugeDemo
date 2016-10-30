<?php header("Access-Control-Allow-Origin: *") ?>

<?php
    // $file_path = "/etc/sensor.conf";
    // if (file_exists($file_path)) {
    //     $fp = fopen($file_path, "r");
    //     $str = fread($fp, filesize($file_path)); // 指定读取大小，这里把整个文件内容读取出来
    //     echo $str;
    // }
    
    // 数据库用户名
    $user="root";
    // 数据库密码
    $password="your passwd to machine";
    // 数据库名
    $database="sensor";

    // 连接数据
    $mysqli = new mysqli("127.0.0.1", $user, $password, $database);
    // 执行sql查询
    $aresult = $mysqli->query("select * from SensorBaseInfo order by id desc limit 0,1");

    // 获取一行数据
    $row = $aresult->fetch_assoc();
    //echo $row["pwd"];
    // 合成返回json数据
    if($row>0){
        echo '{"code":200,"data":{'.'"airPress":'.$row["AirPress"].',"temperature":'.$row["Temperature"].',"humidity":'.$row["Humidity"].',"noise" :'.$row["Noise"].',"pm2dot5":'.$row["Pm2dot5"].'}}';
    }else{
        echo '{"code":400}';
    }

    /* free result set */
    // 释放查询结果
    $aresult->free();
    /* close connection */
    // 释放连接
    $mysqli->close();
?>
