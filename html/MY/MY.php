<?php

 	$APPID='wxbf0346df51c10983';
 $REDIRECT_URI='http://pxywechat.applinzi.com/html/MY/My_record.php';
   
    $scope='snsapi_base';
            //$scope='snsapi_userinfo';//需要授权
    $url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
       		//header("Location:".$url);
            
    header("Location:".$url);



?>