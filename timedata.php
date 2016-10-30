<?php
    // 获取请求中的date、time信息
    $data = $_GET["data"];
    $time = $_GET["time"];

    // 执行shell命令，设置时间
    $result = exec("date -s '".$data." ".$time."'");

    // 返回设置同时命令行的输出信息给页面，用于判断是否设置成功
    echo '{result:'.$result.'}';
?>
