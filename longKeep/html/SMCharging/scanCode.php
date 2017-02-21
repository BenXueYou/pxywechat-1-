  <?php
    
        require_once "../../php/jssdk.php";
        $jssdk = new JSSDK("wx0a766465ad74001e", "49b67f9262e29328f83da924b68c1982");
        $signPackage = $jssdk->GetSignPackage();
		

        if(isset($_SESSION['user'])){ 
            
         print_r($_SESSION['user']);
    	 $openid = isset($_SESSION['user']);
        exit;
                      
        }else{
       	 	$APPID='wx0a766465ad74001e';
        	$REDIRECT_URI='http://1.pxywechat.applinzi.com/getCode.php';
        	$scope='snsapi_base';
        //$scope='snsapi_userinfo';//需要授权
        	$url='https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$APPID.'&redirect_uri='.urlencode($REDIRECT_URI).'&response_type=code&scope='.$scope.'&state='.$state.'#wechat_redirect';
       		 header("Location:".$url);

        }
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
        <script type="text/javascript" src="../../JS/jquery-3.0.0.min.js" ></script>
        <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
        <script type="text/javascript" src="../../JS/cookie.js" ></script>
		<title>扫码充电</title>
		<style type="text/css">
			body{padding: 0;margin: 0;}
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
		</style>
	</head>
	<body>
        

		<h2>扫描桩上的二维码启动充电</h2>
        <div class="middle_image"></div>
		<button></button>
        <p class="middle_input">或<a href="../SMCharging/scan_input.html">输入桩编号</a></p>

	</body>
    
    
    <script type="text/javascript">
        
     
        
      $userId = $openid;
      //请求用户状态
      
        function getUserState(){
        
        ajax = $.ajax({
				type: "POST", // 请求方式
				url: "http://116.236.237.245:8080/SBM_longkeep/WechatUserManager/getUserState", // 请求地址
				dataType:'json',        			
				data:{
                    userId:"o6Ge5v8S1urEXf7xLL09vOQ1KXHk"
                    
				},
				success: function(data) { //data就是返回的json数据
                    //alert("请求成功")
					console.log("data"+data);
					console.log("detail+++++"+ data.detail);
					
					if(data.detail != null) {
						var array = data.detail;
					    var obj = array[0];
                        
                        console.log("请求返回的数据"+obj);
				
                        
						
					} else {
					
                        
					}
				},
				error: function(jqXHR) {
                    
                   
                   // alert("发生错误,服务器异常："+ jqXHR.status);
                   
        		},
      	 });	
     }
    
    
            wx.config({

                     debug: false,
                     appId: '<?php echo $signPackage["appId"];?>',
    				 timestamp: '<?php echo $signPackage["timestamp"];?>',
    				 nonceStr: '<?php echo $signPackage["nonceStr"];?>',
   					 signature: '<?php echo $signPackage["signature"];?>',
                     jsApiList: [

                           // 所有要调用的 API 都要加到这个列表中
                           "scanQRCode",

                       ]
                  });
        
          
  			$("button").click(function(){

                	//获取用户充电状态
                
                
                   //alert("扫码~~~");
                    wx.ready(function () {

                         //alert("扫码");
                         wx.scanQRCode({
                             
                                needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                                success: function (res) {
                                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果

                                    //alert(result);
                                    //var cpid = result.substr(result.length-1,1);
                                    //alert(cpid);
                                    var cpid = result;

                                    if(cpid == 3100100703){

                                        //扫码请求
                                        
                                        
                                        
                                        location.href='../SMCharging/chargePay.html?cpid='+cpid;
                                        
                                    }else{
                                        
                                        
                                        alert("二维码错误"); 
                                    }

                                    // requestCheck(result);


                            }

                        });
                    });
            
        });

     </script>
</html>

	
