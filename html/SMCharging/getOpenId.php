<?php
class GETCODE {
    
     private $appId;
     private $appSecret;
     private $code;
	 
     public function __construct($appId, $appSecret,$code) {
     $this->appId = $appId;
     $this->appSecret = $appSecret;
         $this->$code = $code;
    // $this->$code = $this->$_GET["code"];  
  }
	// $appid = "wx0a766465ad74001e";
	// $secret = "49b67f9262e29328f83da924b68c1982";
  	// session_start();
	
    
    
    public function getOpenId(){
        
    
    
    $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$this->appId.'&secret='.$this->appSecret.'&code='.$code.'&grant_type=authorization_code';  



    $ch = curl_init();  

    curl_setopt($ch,CURLOPT_URL,$get_token_url);  

    curl_setopt($ch,CURLOPT_HEADER,0);  

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );  

    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  

    $res = curl_exec($ch);  

    curl_close($ch);  

   
   
 //	解析json
  $user_obj = $this->json_decode($res,true);
  


 //print_r($user_obj);
 
   $openid = $this->$user_obj['openid'];

//存入Session中
	
   $_SESSION['user'] = $openid;
        
        return $openid;
 }
   // print_r($openid);

	//echo "openid=".$openid."session=".$_SESSION['user'];


	//$openUrl = "http://1.pxywechat.applinzi.com/html/SMCharging/scanCode.php",	

	//header("Location".$openUrl);


//调用接口处理openID
  private function postOpenId(){
      
  	$wechatUrl = "http://116.236.237.245:8080/SBM_longkeep/wechatUserManager/registerUser?openId=".$openid;
	$obj = $this->httpGet($wechatUrl);

	
	//echo var_dump($obj);
	//echo $openid;
  
  
  
  }
	
	


  private function httpGet($url) {
      
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