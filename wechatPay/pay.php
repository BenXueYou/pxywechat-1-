


<?php


	$cpid = $_GET["cpid"];
	$money = $_GET["money"];
    
	  
     require_once "WxPay.Api.php";
     require_once "WxPay.JsApiPay.php";
  
    $appid = "wxbf0346df51c10983";
    $secret =  "ca9d609ac4341007bda1d5d59866cdb5";

 



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


     


        //①、获取用户openid
        $tools = new JsApiPay();
        $openId = $tools->GetOpenid();

        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody("test");
        $input->SetAttach("test");
        $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("http://paysdk.weixin.qq.com/example/notify.php");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);

        $order = WxPayApi::unifiedOrder($input);
        
        printf_info($order);

        $jsApiParameters = $tools->GetJsApiParameters($order);

        $obj = json_decode($jsApiParameters);
		//var_dump($order);

		//var_dump($jsApiParameters->appId);


//$jsApiParameters->appId
//$jsApiParameters->appId
//$jsApiParameters->appId

       //3.

?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=8">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-control" content="no-cache">
        <meta http-equiv="Cache" content="no-cache">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
		<link rel="icon" href="../../../img/logo.png" type="image/x-icon"/> 
        <link href="jvhua/circle.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="../../JS/jquery-3.0.0.min.js" ></script>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script type="text/javascript" src="../../JS/cookie.js" ></script>
		<title>扫码充电</title>
		<style type="text/css">
		</style>
	</head>
	<body>
        
        <h2>扫码支付</h2>
		
	</body>
    

    <script type="text/javascript">
        
        //全局变量
       var urlM = "http://116.236.237.244:8080/SBM_longkeep/";
       var openId = '<?php echo $openid;?>';
       var cpid;
       //var openId = "o0CsBw_0oxuji1dmw8aACKJz4kiY";
       //var cpid = "070100400200101200";
     
       var deviceId = cpid;
       var chargeState = 0;
       var money = 0;
       
       
       aendPay();
        
        var obj= "<?php echo $obj;?>";
        
       function sendPay(){

            function onBridgeReady(){
                
                   WeixinJSBridge.invoke(
                       'getBrandWCPayRequest', {
                           
                           "appId": obj.appid,     //公众号名称，由商户传入     
                           "timeStamp": obj.timeStamp,         //时间戳，自1970年以来的秒数     
                           "nonceStr" : obj.nonceStr, //随机串     
                           "package" :  obj.package,     
                           "signType" : "MD5",         //微信签名方式：     
                           "paySign" : obj.paySign //微信签名 
                       },
                       function(res){
                           
                           console.log(res);
                           if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                           
                           //支付成功
                               alert("返回成功，跳转开始充电");
                               
                               $("#mask").removeClass("hidden");
                               alert("跳转之前chargeState="+chargeState+"money="+money);
                               location.href='../SMCharging/charging.html?cpid='+cpid+'&openId='+openId+"&chargeState="+chargeState+"&payMode="+payMode+"&money="+money+"&outTradeNo="+outTradeNo;

                           
                           } // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
                           else{
								 $("#mask").addClass("hidden");
                               alert("json="+JSON.stringify(res));
                               alert("支付失败,取消支付");
                           }
                       }
                   ); 
                }
                if (typeof WeixinJSBridge == "undefined"){
                   if( document.addEventListener ){
                       
                       document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
                       
                   }else if (document.attachEvent){
                       
                       document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
                       document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
                   }
                }else{
                    
                   onBridgeReady();
                    
                }
            
            }

     </script>
</html>