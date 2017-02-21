<?php
$appid = "wx0a766465ad74001e";
$appsecret = "49b67f9262e29328f83da924b68c1982";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";

$output = https_request($url);
$jsoninfo = json_decode($output, true);

$access_token = $jsoninfo["access_token"];


$jsonmenu = '{
      "button":[
       {
           "name":"充电",
           "sub_button":[
            {
               "type":"view",
               "name":"扫码充电",
               "url":"http://pxywechat.applinzi.com/html/charging.html"
            },
            {
               "type":"view",
               "name":"下载APP",
               "url":"http://www.shqiangchen.com"
            }]
       },
       {
           "name":"商城",
           "sub_button":[
            {
               "type":"view",
               "name":"商城主页",
               "url":"http://pxywechat.applinzi.com/html/shopHome/shopHome.html"
            },
            {
               "type":"click",
               "name":"精品必备",
               "key":"即将上线，敬请期待！！！"
            },
            {
                "type":"click",
                "name":"热点推荐",
                "key":"即将上线，敬请期待！！！"
            }]
       },
       {
            "name":"车友圈",
            "sub_button":[
            {
                "type":"view",
                "name":"精英",
                "url":"http://pxywechat.applinzi.com/html/hotArtcle.html"
            },
            {
                "type":"view",
                "name":"资讯",
                "url":"http://pxywechat.applinzi.com/html/hotArtcle.html"
            },
            {
                "type":"view",
                "name":"视频",
                "url":"http://pxywechat.applinzi.com/html/AVideo.html"
            }]
        }]
    }';
    

$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
$result = https_request($url, $jsonmenu);
var_dump($result);

function https_request($url,$data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

?>