<?php

 //$appid = "wx0a766465ad74001e";
 //$secret = "49b67f9262e29328f83da924b68c1982";
$appid = "wxbf0346df51c10983";
$secret =  "ca9d609ac4341007bda1d5d59866cdb5";

 session_start();



    $code = $_GET["code"];  

    $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';  



    $ch = curl_init();  

    curl_setopt($ch,CURLOPT_URL,$get_token_url);  

    curl_setopt($ch,CURLOPT_HEADER,0);  

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );  

    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  

    $res = curl_exec($ch);  

    curl_close($ch);  

   
   
 //	解析json
  $user_obj = json_decode($res,true);
  
 //print_r($user_obj);
 
   $openid = $user_obj['openid'];

//存入Session中 注意此时SAE中SESSION不可用。
	
   $_SESSION['user'] = $openid;

    //print_r($openid);
	print_r("正在验证信息请稍后。。。");
	echo "<script>window.location='../html/SMCharging/scanCode.php?openid=$openid';</script>";
	
	

//调用接口处理openID

	
	$wechatUrl = "http://116.236.237.245:8080/SBM_longkeep/wechatUserManager/registerUser?openId=".$openid;
	$obj = httpGet($wechatUrl);

    function httpGet($url) {
      
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 2);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);

        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        //echo var_dump($res);
        return $res;
  }


	






?>