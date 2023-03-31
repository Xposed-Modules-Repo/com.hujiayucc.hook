<?php
/*
 * @Author: hujiayucc
 * @Date: 2023-03-29 00:29:07
 * @Description: Fuck AD应用更新以及热更新后端接口
 */

/**
 * Nginx 伪静态规则
 * 
 * location / {
 *    index version.php;
 *	    if (!-e $request_filename) {
 *		    rewrite ^/(.*)$ /version.php last;
 *	    }
 *   }
 */

// 禁用缓存
header("Pragma:no-cache");
// 软件版本
$versionCode = 2020;
// Dex版本 用于版本校验
$hotFixVersion = 2001;
// 热更新版本名
$hotFixName = "1.2.1";
// APK下载地址
$url = "https://hujiayucc.lanzoum.com/ifXBG0rq60hc";
// Dex文件名
$dexName = $hotFixVersion . ".dex";
// 获取Dex文件数据
$dex = file_get_contents($dexName);
// 更新日志
$updateLog = file_get_contents("Update Log.txt");

$array = [
    "versionCode"   =>  $versionCode,
    "url"           =>  $url,
    "hotFixVersion" =>  $hotFixVersion,
    "hotFixName"    =>  $hotFixName,
    "dexMd5"        =>  md5($dex),
    "dexUrl"        =>  getScheme() . $_SERVER['HTTP_HOST'] . "/" . $dexName,
    "updateLog"     =>  $updateLog
];

printStrToJson($array);

/**
 * 输出字符串数组为JSON
 * @param array $jsonStr 字符串数组
 * @return void
 * @author hujiayucc
 * @link https://github.com/Xposed-Modules-Repo/com.hujiayucc.hook
 */
function printStrToJson(array  $jsonStr)
{
    $json = json_encode($jsonStr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    // JSON Mine Type
    header('content-type:application/json;charset=utf8');
    echo ($json);
}

/**
 * 获取当前访问协议
 * @return string Scheme
 */
function getScheme(): string
{
    if (isset($_SERVER['HTTP_X_CLIENT_SCHEME'])) {
        return ($_SERVER['HTTP_X_CLIENT_SCHEME'] . '://');
    } elseif (isset($_SERVER['REQUEST_SCHEME'])) {
        return ($_SERVER['REQUEST_SCHEME'] . '://');
    } else {
        return 'http://';
    }
}