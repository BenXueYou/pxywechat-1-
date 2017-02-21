<?php

require_once "lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";



$url = $_SERVER['REQUEST_URI'];
//echo $url;

$arr = parse_url($url);
//var_dump($arr);

$arr_query = convertUrlQuery($arr['query']);

//var_dump($arr_query['openid']);
//var_dump($arr_query['cpid']);


$cpId = $arr_query['cpid'];


/**
 * 将字符串参数变为数组
 * @param $query
 * @return array array (size=10)
                    'm' => string 'content' (length=7)
                    'c' => string 'index' (length=5)
                    'a' => string 'lists' (length=5)
                    'catid' => string '6' (length=1)
                    'area' => string '0' (length=1)
                    'author' => string '0' (length=1)
                    'h' => string '0' (length=1)
                    'region' => string '0' (length=1)
                    's' => string '1' (length=1)
                    'page' => string '1' (length=1)
 */
function convertUrlQuery($query)
{
    $queryParts = explode('&', $query);
    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    return $params;
}
 

  $cpid = "070100400200101200";
  //$openId = "o0CsBw_0oxuji1dmw8aACKJz4kiY";


//统一下单
//①、获取用户openid
$tools = new JsApiPay();


 $cpid = "070100400200101200";
// $openId = "o0CsBw_0oxuji1dmw8aACKJz4kiY";


$openId = $arr_query['openid'];



//②、统一下单
function UnifiedOrder($total_fee){

	$input = new WxPayUnifiedOrder();
    $input->SetBody("山西龙吉伟业电力科技有限公司");
    $input->SetAttach("test");
    $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
    $input->SetTotal_fee($total_fee);
    $input->SetTime_start(date("YmdHis"));
    $input->SetTime_expire(date("YmdHis", time() + 600));
    $input->SetGoods_tag("test");
    $input->SetNotify_url("http://pxywechat.applinzi.com/html/SMCharging/chargePay.html");
    $input->SetTrade_type("JSAPI");
    $input->SetOpenid($openId);


    //var_dump($input);

    $order = WxPayApi::unifiedOrder($input);

    $jsApiParameters = $tools->GetJsApiParameters($order);
    $obj = json_decode($jsApiParameters);
    //echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';

    //var_dump($order);
    //var_dump($obj);


    $out_trade_no = $input->GetOut_trade_no();
    //$out_trage_no = $out_trade_n->out_trade_no;

    //print_r($out_trade_no);



    $appid = $obj->appId;
    $appid = "wxbf0346df51c10983";
    $nonceStr = $obj->nonceStr;
    $package = $obj->package;
    $signType = $obj->signType;
    $paySign = $obj->paySign;
    $timeStamp = $obj->timeStamp;
    //var_dump($appid);

    //获取共享收货地址js函数参数
    $editAddress = $tools->GetEditAddressParameters();




}



//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
     	

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
			.top,.top_menu{
				background-color:white ;
				color: black;
				padding:10px 10px 15px;
				margin:15px 5px;
			}
			.middle{
				display: none;
				background-color:white ;
				color: black;
				margin:15px 5px;
				padding:5px 15px  20px;
			}
			.money button,.top_menu button{
				margin: 10px 0.8%;
				width: 22%;
				height: 40px;
				background-color: white;
				border: 1px solid lightgrey;
                border-radius:5px;
			}
            #middle_input{
            	width:60%;
                line-height:25px;
                border: 1px solid lightgrey;
                border-radius:5px;
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
				font-size:20px ;
				color: white;
			}
			.money .active{color: orange;border: 1px solid orange;background-color: white;}
			
			.middie_menu li{
				list-style-type: none;
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
				line-height: 25px;
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
        
		<div class="top_menu" style="display:none">
			<p class="topTitle">请选择充电方式</p>
			<div class="money">
				<button class="menu_btn active">按金额充电</button>
				<button class="menu_btn">按时间充电</button>
				<button class="menu_btn">按电量充电</button>
				<button class="menu_btn" value="4">自动充满</button>
			</div>
		</div>
		<div class="middie_menu">
			<ul>
				<li><div class="top" id="chagerWay1">
				<p class="topTitle">请选择金额</p>
				  <div class="money">
					<button class="btn active">10元</button>
					<button class="btn">20元</button>
					<button class="btn">30元</button>
					<button class="btn" value="4">自定义</button>
				  </div>
				</div></li>
				
				
				<li><div class="top hidden" id="chagerWay2">
				<p class="topTitle">请时间电量</p>
				  <div class="money">
					<button class="btn">0.5时</button>
					<button class="btn">1.0小时</button>
					<button class="btn">1.5小时</button>
					<button class="btn" value="4">自定义</button>
				  </div>
				</div></li>
				
				
				<li><div class="top hidden" id="chagerWay3">
				<p class="topTitle">请选择电量</p>
				  <div class="money">
					<button class="btn">10度</button>
					<button class="btn">20度</button>
					<button class="btn">30度</button>
					<button class="btn" value="4">自定义</button>
				  </div>
				</div></li>
				
				
				<li><div class="top hidden" id="chagerWay4">
				<p class="topTitle">请输入账号/充电卡号</p>
				  <div class="money_input">
				  	<span>账号：</span><input id = "userName" type="" name="" id="" value="" />
				  	<br />
				  	<span>密码：</span><input id = "password" type="" name="" id="" value="" />
              
				  </div>
                    <div class="check"><span>记住账号密码</span><input id = "saveCookie" type="checkbox" name="" id="" value="" /><span>(有效期一个月)</span></div>
				</div></li>
			</ul>
		</div>
		<div class="middle">
			<p class="middleTitle">自定义金额</p>
			<span class="middleDetail"><input placeholder="请输入" id="middle_input"><span id="middle_input_span">元</span></span>
		</div>
		<p id="pointOut">如电量已充满或者其他意外情而停止充电，导致充电未完成系统会自动退回剩余充电金额到您的支付账户。</p>
		<button id="bottom">确定</button>
	</body>
	<script type="text/javascript">
        
     
        
        var appid = "<?php echo $appid;?>";
        var nonceStr = "<?php echo $nonceStr;?>";
        var package = "<?php echo $package;?>";
        var signType = "<?php echo $signType;?>";
        var paySign = "<?php echo $paySign;?>";
        var timeStamp = "<?php echo $timeStamp;?>";
        var outTradeNo = "<?php echo $out_trade_no;?>";
        
        console.log("appid======"+appid);
        
       
        
        
        //全局变量    
        	var index=0;
			var money=10;
			var chargeWayIndex=0;
         	var cpid;
            var urlM = "http://116.236.237.244:8080/SBM_longkeep/";
            var openId;
            var payMode;
        
          
        
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
             openId=strs[1].substring(8).trim();
             chargeState=strs[2].substring(13).trim();  

             // alert("cpid="+cpid+"+++openid="+openId+"++chargeState="+chargeState);
      	}  
	}  
	GetRequest();  
	
        
       // if(!outTradeNo){
          //alert("openId"+openId);
        	//saveOut_trade_no();
        //}

   
        function saveOut_trade_no(){
        
            
            var ajax = $.ajax({
            
				type: "GET", // 请求方式
				url: urlM+"scanCharge/setOpenIdSerialNo", // 请求地址
				dataType:'json',  //jsonp:'callback', 
				data:{            
                    openId:openId,
                    pattern:0, //pattern为0 时则为保存数据，1则为读取数据
                    serialNo:outTradeNo
				},
				success: function(data) { //data就是返回的json数据
                    
				
                    
                    alert("json="+JSON.stringify(data));
					console.log("json="+JSON.stringify(data));
                    
					if(data.returnCode == 0) {
						         
       			         	alert("商户号保存成功"+data.message);
                          
						
					}else if(data.returnCode == 2){
                        
                          alert("商户号保存参数错误"); 
                        
                    }else {
						 alert("异常数据"); 
					}
				},
				error: function(jqXHR) {
                    
                    alert("发生错误json="+JSON.stringify(jqXHR));
       		    },
       		});	
        
        
        }
        
        
	  
    //点击确定按钮发起订单支付流程。 
		$(document).ready(function()
		{ 
			$("#bottom").click(function()
			{ 
                if(chargeWayIndex < 3){//是否选择自动充满
						
                    
                    //alert("非自动充满");
                    var y =  $(".menu_btn");//获取方式按钮的数组
                    console.log($(".menu_btn"));console.log($(".btn .active"));console.log(y[chargeWayIndex]);
                    var btn = y[chargeWayIndex];//被选中的对象
                    var yhtml = btn.innerHTML;//被选中的对象携带信息
                    
                    console.log(btn.innerHTML);
                    
                    var x = $(".btn");//二级菜单对象
                    console.log(x);console.log("index:"+index);console.log(x[index]);
                    
                    var indexy = index + chargeWayIndex*4;//二级菜单被选中的标记
                    console.log(indexy);
                    
                    var xhtmlObj = x[indexy];//二级菜单中携带信息
                    console.log(xhtmlObj);
                    var xhtml = xhtmlObj.innerHTML;
                    console.log(xhtml); 
                    console.log(xhtml.substring(0,xhtml.length-1));
                    
                    
                    if(index >= 3){//自定义输入// alert("非自动充满 自定义");
                        
                          var inputData = document.getElementById("middle_input").value;
                       
                          money = inputData.substring(0,2);
                          alert(inputData);
                        
                        if(inputData){
               				 alert("alert+"+inputData);
                      		 location.href='../SMCharging/charging.html?cpid='+cpid+'&money='+money+"&chargeState="+chargeState;
                             index = 0;
                       		 chargeWayIndex = 0;
                            
                        }else{alert("你还未选择完");}
    
                    }else{
                        
                       money = xhtml.substring(0,xhtml.length-1)
					   alert(money);
                       if(isInteger(money)){
                       		
                           //微信支付接口 
                        // alert("返回成功，跳转开始充电");
                        //location.href='../SMCharging/charging.html?cpid='+cpid+'&openId='+openId+"&chargeState="+chargeState+"&payMode="+payMode+"&money="+money;
                      		sendPay();
                         
                       
                       }else{
                        	  alert("支付金额只能为整数");
                     
                       }
                        
                    }
                    
                }else{//alert("自动充满");       

                  	//登录账号验证信息
                    checkLoginMsg();
                }
				
			});
			
 
         function sendPay(obj){

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
                               alert("json="+JSON.stringify(res));
                               alert("支付失败"+res.err_msg);
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
           
    

            

 //点击菜单设置充电方式
            
		   $(".btn").on("click",function(){
			$(this).addClass("active").siblings().removeClass("active");
              var sbtitle=$(".middle");
				if($(this).index() == "3"){

	     			if(sbtitle.length){
	       				sbtitle.show();	
					}
               }else{
                    sbtitle.hide();
                }
                index = $(this).index();
			});
		});
		
//点击菜单设置充电信息	
		 $(".menu_btn").on("click",function(){
		 	
			$(this).addClass("active").siblings().removeClass("active");
			
              var sbtitle=$(".top");
               chargeWayIndex  = $(this).index();
//             alert(chargeWayIndex);
			//	$(".btn").removeClass("active");
               showtopmenu(chargeWayIndex);
			});

        
        
        
		function showtopmenu(i){
			
				$(".top").hide();
				$(".middle").hide();
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
						visible.show();
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
