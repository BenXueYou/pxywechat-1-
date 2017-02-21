
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
		<title>实时支付</title>
         <link rel="icon" href="../../../img/logo.png" type="image/x-icon"/>
         <link href="jvhua/circle.css" rel="stylesheet" type="text/css"/>
		<script type="text/javascript" src="../../JS/jquery-3.0.0.min.js" ></script>
        <script type="text/javascript" src="../../JS/cookie.js" ></script>
		<style type="text/css">
			*{padding: 0;margin: 0;}
			body{
				background-color:#D3D3D3;
                position:relative;
			}
			
			.middle{
				
				background-color:white ;
				color: black;
				margin:15px 5px;
				padding:5px 15px  20px;
			}
			.money button,.top_menu button{
				margin: 10px 0.8%;
				width: 30%;
				height: 40px;
				background-color: white;
				border: 1px solid lightgrey;
                border-radius:5px;
			}
            .topTitle{
            	
                  padding:10px 8px 5px;
            }
            
            .middie_menu{
            	 padding:8px;
            }
            #middle_input{
            	width:60%;
                line-height:30px;
                border: 1px solid lightgrey;
                border-radius:5px;
                text-align: center;
              
            }
             
            .middleTitle{
                margin:10px 5px;
                
            }
			.middleDetail{
             	
                margin:10px 10%;
			}
			#pointOut{
				color: darkorange;
				padding: 15px;
			}
			#bottom{
				
				width: 50%;
				height: 50px;
				margin:0 25%;
				background-color: orange;
                padding:8px;
				font-size:20px ;
				color: white;
			}
            .money{
            	 background-color: white;
            }
			.money .active{
                color: orange;
                border: 1px solid orange;
                background-color: white;
            }
			
			
			.money_input{
				/*background-color: red;*/
				margin: 10px;
				text-align: center;
			}
            
            .check{
                text-align:right;
            }
            .check span{
            
                color:gray;
                font-size:13px;
                
            }
            #saveCookie{
            
                width:25px;
                margin:5px;
            }
            
			.money_input input{
				width: 60%;
				/*background-color: blue;*/
				margin: 5px;
				text-align: center;
				line-height: 30px;
                border: 1px solid lightgrey;
                border-radius:5px;
			}
			.hidden{
				display: none;
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
        
		
		<div class="middie_menu">
			
				<div class="top money" id="chagerWay1">
				<p class="topTitle money">请选择金额</p>
				  <div class="money">
					<button class="btn">10元</button>
					<button class="btn">20元</button>
					<button class="btn">30元</button>
				  </div>
				</div>
			
		</div>
		<div class="middle">
			<p class="middleTitle">自定义金额</p>
			<span class="middleDetail"><input placeholder="请输入" id="middle_input"><span id="middle_input_span">元</span></span>
		</div>
		<p id="pointOut">如电量已充满或者其他意外情而停止充电，导致充电未完成系统会自动退回剩余充电金额到您的支付账户。</p>
		<button id="bottom">确定</button>
	</body>
	<script type="text/javascript">
        
        
        //全局变量    
        	var index;
			var money;
			var chargeWayIndex=0;
         	var cpid;
            var urlM = "http://116.236.237.244:8080/SBM_longkeep/";
            var openId;
            var payMode;
        

           var appid = "wxbf0346df51c10983";
           var nonceStr;
           var  package;
           var signType;
           var paySign;
           var timeStamp;
           var chargeState=0;         
           var outTradeNo=0;
        
       //获取参数
        function GetRequest() {
            
            //alert("hello world");
          var url = location.search;   
          var theRequest = new Object();  
          if (url.indexOf("?") != -1) {  
            var str = url.substr(1);  
            console.log("111111111"+str);  
            var strs= new Array();     
             strs = str.split('&');  

             cpid=strs[0].substring(5).trim();
             openId=strs[1].substring(7).trim();
             chargeState=strs[2].substring(13).trim();  

             // alert("cpid="+cpid+"+++openid="+openId+"++chargeState="+chargeState);
      	}  
	}  
	GetRequest();  
	
        
      

   
        
        
	  
    //点击确定按钮发起订单支付流程。 
		$(document).ready(function()
		{ 
			$("#bottom").click(function()
			{ 
                if(chargeWayIndex == 0){//是否选择自动充满
						
                    
                   if(index == undefined){
                   
                   		alert("你还未设置充电金额");
                       
                   }else{

                        if(index == 3){//自定义输入
                              var inputData = document.getElementById("middle_input").value;
                              money = inputData.substring(0,2);
                        }else{
                               var x = $(".btn");//二级菜单对象
                                //console.log(x);console.log("index:"+index);console.log(x[index]);
                                var indexy = index + chargeWayIndex*4;//二级菜单被选中的标记
                                //console.log(indexy);
                                var xhtmlObj = x[indexy];//二级菜单中携带信息
                               // console.log(xhtmlObj);

                               var xhtml = xhtmlObj.innerHTML;
                                //console.log(xhtml); 
                                //console.log(xhtml.substring(0,xhtml.length-1));
                              money = xhtml.substring(0,xhtml.length-1);
                        }
                       
                       
                       
                       if(isInteger(money) && money != 0 && money != ""){
				
                        //统一下单
                         
                        getOrderToWechat(money);
                      		
                        }else{
                                  alert("支付金额只能为整数");


                        }

                   }

                    
                }else{
                    
                    alert("自动充满");       

                  	//登录账号验证信息
                    checkLoginMsg();
                }
				
			});
			
 //下单   
            
         getOrderToWechat("1");
            
        // $openId = "o0CsBw_0oxuji1dmw8aACKJz4kiY";   
         function getOrderToWechat(e){
         
            //alert(money+'===='+openId);
             
         	var ajax = $.ajax({
                
                type:"GET",
            	url:"refund_2.php",
                dataType:"json",
                data:{
                	
                   
                    openId:openId,
                    total_fee:money
                },
                success:function(data){
            
            		
            	    //alert("下单成功："+JSON.stringify(data));
                    
                    console.log(data);
                    
                     outTradeNo = data[0];
                    var order = data[1];
                    
                   
                   
                    
                    appid = order.appId;
                   
            		//ppid = "wxbf0346df51c10983";
            		nonceStr = order.nonceStr;
                    package = order.package;
                    signType = order.signType;
                    paySign = order.paySign;
                    timeStamp = order.timeStamp;
                    
                    
                   // console.log(appid+"=="+nonceStr+"=="+paySign);
                    
                    
                    sendPay();
                    
            
                },
                error: function(jqXHR) {
                
            		 alert("下单发生错误："+JSON.stringify(jqXHR));
                }
            
            });
         
         }        
            
         function sendPay(){

            function onBridgeReady(){
                
                   WeixinJSBridge.invoke(
                       'getBrandWCPayRequest', {
                           
                           "appId": appid,     //公众号名称，由商户传入     
                           "timeStamp": timeStamp,         //时间戳，自1970年以来的秒数     
                           "nonceStr" : nonceStr, //随机串     
                           "package" :  package,     
                           "signType" : "MD5",         //微信签名方式：     
                           "paySign" : paySign //微信签名 
                       },
                       function(res){
                           
                           console.log(res);
                           if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                           
                           //支付成功
                               //alert("返回成功，跳转开始充电");
                               
                               $("#mask").removeClass("hidden");
                               
                               location.href='../SMCharging/charging.html?cpid='+cpid+'&openId='+openId+"&chargeState="+chargeState+"&payMode="+payMode+"&money="+money+"&outTradeNo="+outTradeNo;

                           
                           } // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回    ok，但并不保证它绝对可靠。
                           else{
								 $("#mask").addClass("hidden");
                               //alert("json="+JSON.stringify(res));
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
           
    
       $(".middleDetail input").focus(function(){
       
         index=3;
       	 $(".btn").removeClass("active");
       
       });
       //$("input").blur(function(){
       
       
       
      // }) 
            

 //点击菜单设置充电方式
            
		   $(".btn").on("click",function(){
			$(this).addClass("active").siblings().removeClass("active");
              var sbtitle=$(".middle");
				if($(this).index() == "3"){

	     			if(sbtitle.length){
                        
	       				sbtitle.show();	
                        
					}
               }else{
                   
                    $("#middle_input").attr("value","");//sbtitle.hide();
                }
                index = $(this).index();
			});
		});
		
//点击菜单设置充电信息	
		 $(".menu_btn").on("click",function(){
		 	
			$(this).addClass("active").siblings().removeClass("active");
			
              var sbtitle=$(".top");
             
               chargeWayIndex  = $(this).index();
				
               alert(chargeWayIndex);
               showtopmenu(0);
			});

        
        
        
		function showtopmenu(i){
			
				$(".top").hide();
				//$(".middle").hide();
				$(".btn").removeClass("active");
				switch(i){
					case 0:
						//alert("电量");
						var visible = $("#chagerWay1");
						visible.show();
//						document.getElementsByClassName("middleTitle").innerHTML = "自定义充电金额";
						$(".middleTitle").html("自定义充电金额");
						$("#middle_input_span").html("元");
						break;
					case 1:
						//alert("时间");
//						$("middleTitle").innerText="自定义充电时长";
						var visible = $("#chagerWay2");
						visible.show();
//						document.getElementsByClassName("middleTitle").val = "自定义充电时长";
						 var a = document.getElementById("middleTitle");
            				$(".middleTitle").html("自定义充电时长");
            				$("#middle_input_span").html("小时");
						break;
					case 2:
						//alert("电量");
						var visible = $("#chagerWay3");
						//visible.show();
//						document.getElementsByClassName("middleTitle").innerHTML = "自定义充电电量";
						$(".middleTitle").html("自定义充电电量"); 
						$("#middle_input_span").html("度");
						break;
					default:
						//alert("充满");
						var visible = $("#chagerWay4");
						visible.show();
						var sbtitle=$(".middle");
						sbtitle.hide();
                        loadID();
						break;
			}
		}
		
		
         function loadID(){
         
          //分析cookie值，显示上次的登陆信息
          var userNameValue = getCookieValue("userName");
           $("userName").value = userNameValue;
          var passwordValue = getCookieValue("password");
           $("password").value = passwordValue;  
           
        }
  
        
        //新建cookie。
        //hours为空字符串时,cookie的生存期至浏览器会话结束。hours为数字0时,建立的是一个失效的cookie,这个cookie会覆盖已经建立过的同名、同path的cookie（如果这个cookie存在）。
        function setCookie(name,value,hours,path){
          var name = escape(name);
          var value = escape(value);
          var expires = new Date();
           expires.setTime(expires.getTime() + hours*3600000);
           path = path == "" ? "" : ";path=" + path;
           _expires = (typeof hours) == "string" ? "" : ";expires=" + expires.toUTCString();
           document.cookie = name + "=" + value + _expires + path;
           
        
        }
        //获取cookie值
        function getCookieValue(name){
          var name = escape(name);
          //读cookie属性，这将返回文档的所有cookie
          var allcookies = document.cookie;    
          //查找名为name的cookie的开始位置
           name += "=";
          var pos = allcookies.indexOf(name);  
          //如果找到了具有该名字的cookie，那么提取并使用它的值
          if (pos != -1){                       //如果pos值为-1则说明搜索"version="失败
            var start = pos + name.length;         //cookie值开始的位置
            var end = allcookies.indexOf(";",start);    //从cookie值开始的位置起搜索第一个";"的位置,即cookie值结尾的位置
            if (end == -1) end = allcookies.length;    //如果end值为-1说明cookie列表里只有一个cookie
            var value = allcookies.substring(start,end); //提取cookie的值
            return (value);              //对它解码   
             }  
          else return "";                //搜索失败，返回空字符串
        }
        //删除cookie
        function deleteCookie(name,path){
          var name = escape(name);
          var expires = new Date(0);
           path = path == "" ? "" : ";path=" + path;
           document.cookie = name + "="+ ";expires=" + expires.toUTCString() + path;
        }
                
  
            //验证服务器登录信息
            function checkLoginMsg(){
            
            	  var userNameValue = $("userName").value;
                    var passwordValue = $("password").value;                    
                    //上传服务器验证账号密码
       
                    //服务器验证（模拟）  
                    var isAdmin = userNameValue == "admin" && passwordValue =="123456";
                    
                    var isUserA = userNameValue == "userA" && passwordValue =="userA";
                      
                    var isMatched = isAdmin || isUserA;
                    if(isMatched){
                      if( $("saveCookie").checked)
                      { 
                          //写入账号密码
                         setCookie("userName",$("userName").value,24*30,"/");
                         setCookie("password",$("password").value,24*30,"/");
                       }  
                       alert("登陆成功,欢迎你," + userNameValue + "!");
                       location.href='../SMCharging/charging.html?cpid='+cpid+'&money='+money;
                      
                     }else{
                         
                        alert("用户名或密码错误，请重新输入！");  
                     }        
            	
            
            
            }
        function isInteger(obj) {
            
            return obj%1 === 0
        }
isInteger(3) // true
isInteger(3.3) // false　
	</script>
</html>
