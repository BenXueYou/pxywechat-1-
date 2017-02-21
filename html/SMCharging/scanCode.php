  <?php
    
    require_once "../../php/jssdk.php";
 
	$appid = "wxbf0346df51c10983";
    $secret =  "ca9d609ac4341007bda1d5d59866cdb5";
 	//session_start();
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

    
	if($openid == null){
    	
        $openId = 0;
        exit;
        
    }

//调用接口处理openID

	
	$wechatUrl = "http://116.236.237.244:8080/SBM_longkeep/wechatUserManager/registerUser?openId=".$openid;
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

        $appid = "wxbf0346df51c10983";
        $secret = "ca9d609ac4341007bda1d5d59866cdb5";
        $jssdk = new JSSDK("wxbf0346df51c10983","ca9d609ac4341007bda1d5d59866cdb5");
        $signPackage = $jssdk->GetSignPackage();

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
			body{padding: 0;margin: 0;position:relative;}
			h2{
                margin-top:30px;
				text-align: center;
				color: #299DFF;
				
			}
			.middle_image{
                margin:60px auto 0px;
                width:150px;
                height:180px;
                background:white url(../../img/scan_charging_img_2.png) no-repeat;
                background-origin: content-box;
				background-clip: content-box;
				background-size: 100% 100%;
				text-align: center;
			}
			button{
				height: 60px;
                background: url(../../img/扫描.png) no-repeat center;
				background-clip: content-box;
				background-origin: content-box;
				background-size: contain;
				line-height: 50px;
				width: 40%;
				outline: none;
				border: 1px solid #299DFF;
				border-radius: 5px;
				margin: 50px 30% 10px;
				font-size: 20px;
				padding: 10px 0;
			}
			p{
				text-align: center;
				color:rgb(105,105,105);
			}
            .hidden{
            	display:none;
            }
             #mask{
            	position:absolute;
                
                left:0px;
                top:-20px;
                
                width:100%;
                height:600px;
                
                background-color:rgba(80,80,80,0.3);
            }
		</style>
	</head>
	<body>
        

		<h2>扫描桩上的二维码启动充电</h2>
        <div class="middle_image"></div>
		<button></button>
        <!--<p class="middle_input">或<a href="../SMCharging/scan_input.html">输入桩编号</a></p>-->
        <div class="hidden" id="mask">
            <div class="m-load2">
                <div class="line">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class="circlebg"></div>
            </div>
        </div>

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
      
        
        if(openId =="" || openId == null || openId == undefined){
            
        	location.href = "../SMCharging/Home.php";
           
        }
        
        
        
        
        
        
       //监听扫码按钮

  		$("button").click(function(){

             //获取用户充电状态
            $("#mask").removeClass("hidden");
			  getUserState(openId);
            
        });

        //请求用户状态      
       function getUserState(openId){ 
           
        ajax = $.ajax({
            
				type:"GET", // 请求方式
				url:urlM+"wechatUserManager/getUserState", // 请求地址
				dataType:'json',
				data:{                    
                    openId:openId                    
				},
				success: function(data) { //data就是返回的json数据
                    
					//alert("");
                    if(data.returnCode==0){
                    	
                        if(data.chargeState == "1") {//用户正在充电状态
                            
                            
							chargeState = data.chargeState;
                            
                            getCpid();                            
                            
                        	$("#mask").addClass("hidden");
                            
						
                        } else{
							chargeState = data.chargeState;
                            $("#mask").addClass("hidden");
                            wxScanAPI();
                        }
                    
                    }else if(data.returnCode==1){
                    $("#mask").addClass("hidden");      
                     	alert("未匹配到openId");
                    
                    }else{
                    	
                        $("#mask").addClass("hidden");      
                    	alert("参数错误999");
                      
                    }  				
				},
				error: function(jqXHR) {
                    
                    console.log("发生错误"+jqXHR.status);
                    $("#mask").addClass("hidden");      
                    alert("请求用户状态发生错误,服务器异常："+ jqXHR.status);
                   
        		},
      	 });	
     }
       
    
        //获取cpid
        
        function getCpid(){
        	
            
            var ajax = $.ajax({
            
            	type:"GET",
                url:urlM+"scanCharge/getPileBaseInfo",
            	data:{
                	userId:openId,
                    platform:1
                },
            	success:function(data){
                    
                	if(data.returnCode == 0){
                        
                        var detail = data.detail;
                        var cp = detail.cp;
                        var obj = cp[0];
                        
                        chargeState = 1;
                        cpid = obj.cpid;
                        //alert("跳转之前+cpid="+cpid);
                        var state = 1;
                        
location.href='../SMCharging/charging.php?cpid='+cpid+'&openid='+openId+'&chargeState='+chargeState+'&payMode=3&money=0'+'&out_trade_no=0';
                        
                       
                        
                    }else{
                        $("#mask").addClass("hidden");
                    	alert("没有找到充电桩");
                    
                    }
                
                
                },
                error: function(jqXHR) {
                    
                    console.log("发生错误"+jqXHR.status);
                    alert("请求桩编号发生错误："+ JSON.stringify(jqXHR));
                    $("#mask").addClass("hidden");      
                   
        		},
            
            });

        }
        
        
        
             function changeCpid(){
        	
            
            var ajax = $.ajax({
            
            	type:"GET",
                url:urlM+"scanCharge/getPileBaseInfo",
            	data:{
                	userId:openId,
                    platform:1
                },
            	success:function(data){
                    
                	if(data.returnCode == 0){
                        
                        var detail = data.detail;
                        var cp = detail.cp;
                        var obj = cp[0];
                        
                        chargeState = 1;
                        cpid = obj.cpid;
                        //alert("跳转之前+cpid="+cpid);
                        var state = 1;

                        
                    }else{
                        $("#mask").addClass("hidden");
                    	alert("没有找到充电桩");
                    
                    }
                
                
                },
                error: function(jqXHR) {
                    
                    console.log("发生错误"+jqXHR.status);
                    alert("请求桩编号发生错误："+ JSON.stringify(jqXHR));
                    $("#mask").addClass("hidden");      
                   
        		},
            
            });
            
        }
        
        
        //调起微信扫码接口
        
        function wxScanAPI(){
             wx.config({

                  debug: false,
                  appId: '<?php echo $signPackage["appId"];?>',
    			  timestamp: '<?php echo $signPackage["timestamp"];?>',
    			  nonceStr: '<?php echo $signPackage["nonceStr"];?>',
   			      signature: '<?php echo $signPackage["signature"];?>',
                  jsApiList: [// 所有要调用的 API 都要加到这个列表中     
                           "scanQRCode",
                       ]
                  });
              wx.ready(function () {
                  
             	 wx.scanQRCode({
                             
                         needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                         scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                         success: function (res) {
                                    
                                 var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果

                                 //alert(result);
                                 //var cpid = result.substr(result.length-1,1);//截取字符串最后一位
                                 
                                var deviceId = result+"00";
                                 if(deviceId.length >= 18){
                                     //扫码请求 
                                     $("#mask").removeClass("hidden");
                                     sendCpIdToSever(deviceId);
  
                                 }else{
                                                                                
                                        alert("二维码错误"); 
                                 }
                         }
                  });       
              });
            wx.error(function(res){
                // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
            	
                alert("扫码错误"+JSON.stringify(res));
                
            });
            
            
            
            
        }
 
        //请求桩的状态
        
        function sendCpIdToSever(deviceId){
        
        	 ajax = $.ajax({
            
				type:"GET", // 请求方式
				url:urlM+"scanCharge/isChargePile", // 请求地址
				dataType:'json',
				data:{                    
                    deviceId:deviceId                    
				},
				success: function(data) { //data就是返回的json数据                     

					
                       //alert("请求桩的状态："+JSON.stringify(data));
                    
                    if(data.returnCode==0){
 
                    	$("#mask").addClass("hidden");                
                        //alert("跳转之前"+deviceId);
location.href='../SMCharging/chargePay.php?cpid='+deviceId+'&openid='+openId+'&chargeState='+chargeState+'&payMode=3'+'&money=0';
                        
                    
                    }else if(data.returnCode==4){
                        
                    	$("#mask").addClass("hidden");      
                     	alert("没有插枪");
                    
                    }else if(data.returnCode==5){
                        $("#mask").addClass("hidden");      
                    
                     	alert("没有授权");
                    
                    }else if(data.returnCode==2){
                        $("#mask").addClass("hidden");
                     	alert("其他错误");
                    
                    }else if(data.returnCode==3){
                        
                        $("#mask").addClass("hidden");      
                    
                     	alert("该桩正在被使用");
                    
                    }else{
                    	$("#mask").addClass("hidden");      
                    	alert("参数错误");
                    }  
					
				},
				error: function(jqXHR) {
                    
                    console.log("发生错误"+jqXHR.status);
                    alert("请求桩状态发生错误："+ jqXHR.status);
                    $("#mask").addClass("hidden");      
                   
        		},
      	 });	  
        
     }
        
        
        


     </script>
</html>

	
