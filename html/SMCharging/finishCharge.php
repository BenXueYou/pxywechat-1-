<?php
 require_once "../../php/jssdk.php";
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
		<title>充电完成</title>
        <script type="text/javascript" src="../../JS/jquery-3.0.0.js" ></script>
        <script type="text/javascript" src="../../JS/jquery-3.0.0.min.js" ></script>
         <script type="text/javascript" src="../../JS/cookie.js" ></script>
		<style type="text/css">
			body{background-color: rgb(245,245,245);}
			#top{
				margin: 0 auto;
				width: 250px;
				height: 190px;
                
			}
			#label{
				
                 background:no-repeat;
                background-image: url(../../img/charging03.png);
				height: 100%;
				overflow: hidden;
				text-align: center;
				/*vertical-align: middle;*/
			}
			#top #label div{
				/*background-color:red ;*/
				margin-top: 165px;
			}
			span{
				font-size: 20px;
				color: black;
				font: '微软雅黑'; 
				/*line-height: 30px;*/
			}
			
			#mid{
				margin-top: 5%;
				background-color:rgb(251,251,251) ;
				text-align: center;
				overflow: hidden;
               
			}
			.ch{
				width: 90%;
				float: left;
				margin:1% 0 1% 10%;
                overflow: hidden;
                position:relative;
				/*padding: 5%;*/
                
			}
			.ch span{
				display: block;
				float: left;
				/*background-color: red;*/
				margin-left:0px;
				margin-top: 1%;
				font-size: 18px;
                text-align: center;
               
			}
            
            /*#date{
                display:block;
                line-height:20px; 
                font-size: 18px;
                
            }
            */
            .ch_span{
                float:right;
                position:absolute;
                right:30%;
                 
            }
            
            
            .value{
            	line-height:20px;
            }
            
			#bot{
				text-align: center;
				margin-top: 5%;
				/*background-color: blue;*/
			}
			#drop{
				text-align: center;
				overflow: hidden;
				
			}
			#stop{
				display: block;
				padding: 15px 1%;
				width: 20%;
                font-size:18px;
			 	color: black;
				/*background-color:rgb(247,192,68) ;*/
				float: left;
			}
			#clink{
				float: left;
				width: 60%;
				background-color:rgb(106,142,244) ;
                position: relative;
			}
			.XX{
					
					margin:10px;
					float: left;
					height:20px;
					width: 20px;
                	position:absolute;
                    bottom:1px;
                    background-image: url(../../img/assess.png);
					background-color: red;
			}
			
			.selDiv{
					display: block;
					margin:10px;
					float: left;
					height:20px;
					width: 20px;
                	background-image: url(../../img/assess_select.png);
			}
			#accessA{
				
				width: 80%;
				height: 100px;
				margin:10px auto;
				background-color:rgb(251,251,251) ;
				font-size: 15px;
			}
			#upload{
				text-align: center;
			}
			#upload button{
				background-color: orange;
				width: 40%;
				height: 50px;
				line-height: 30px;
				margin: 50px auto;
				font-size: 18px;
			}
		</style>
	</head>
	<body>
       
        
		<div id="top">
			<div id="label">
				<div class = "text"><span>充电完成</span></div>
			</div>
		</div>
		<div id="mid">
			
            <div class="ch" ><span>账单编号：</span><span class="value" id="bill" style="font-size:14px">----</span></div>
            <div class="ch" ><span>支付金额：</span><span class="value" id="money">0.00</span><span class="ch_span">元</span></div>
			<div class="ch" ><span>充电时长：</span><span class="value" id="time">0</span><span class="ch_span">分钟</span></div>
			<div class="ch" ><span>充电电量：</span><span class="value" id="quantity">0.0</span><span class="ch_span">度</span></div>
            <div class="ch" ><span>已充金额：</span><span class="value" id="chargeMoney">0.00</span><span class="ch_span">元</span></div>  
            <div class="ch" ><span>退回金额：</span><span class="value" id="refund_fee">0.00</span><span class="ch_span">元</span></div>
            <div class="ch" ><span>开始时间：</span><span class="value" id="date" style="font-size:14px;">--.--.-- --:--:--</span></div>
			
		</div>
		<div id="upload" style="display:none">
			<button id="botBtn" onclick="stepfun()">完成</button>
		</div>
     
	</body>
    <script type="text/javascript">
        
  //全局变量
        var money = 0;//支付金额
        var serialNo;//流水号
        
        
        
    function GetRequest() {
            
            //alert("hello world");
       var url = location.search;   
       var theRequest = new Object();  
       if (url.indexOf("?") != -1) {  
            var str = url.substr(1);  
            console.log("111111111"+str); 
             
            var strs= new Array();     
            strs = str.split('&');  
            serialNo =strs[0].substring(9).trim();
           
            
            userId = strs[1].substring(7).trim(); 
           
           //alert("serialNo="+serialNo+"user="+userId);
      
      	}  
	 }  
        GetRequest();  
        refreshView();
        
                 //点击提交跳转 
        function stepfun(){
				
            
            alert("关闭窗口");
            wx.config({
              	  debug: false,
                  appId: '<?php echo $signPackage["appId"];?>',
    			  timestamp: '<?php echo $signPackage["timestamp"];?>',
    			  nonceStr: '<?php echo $signPackage["nonceStr"];?>',
   			      signature: '<?php echo $signPackage["signature"];?>',
                  jsApiList: [// 所有要调用的 API 都要加到这个列表中     
                           "closeWindow",
                       ]
            });
            
            
            // config信息验证后会执行ready方法，
            //所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，
            //所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。
            //对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
       
            	wx.closeWindow();
            
           
            wx.error(function(res){
                // config信息验证失败会执行error函数，如签名过期导致验证失败，具体错误信息可以打开config的debug模式查看，也可以在返回的res参数中查看，对于SPA可以在这里更新签名。
            	alert("关闭窗口错误"+JSON.stringify(res));
            });

            
            
            location.href='../SMCharging/scanCode.php';
 
        }
        
        
        function refreshView(){
         ajax = $.ajax({
            
				type: "GET", // 请求方式
				url: "http://116.236.237.244:8080/SBM_longkeep/scanCharge/chargeRecorder", // 请求地址
				dataType:'json',  //jsonp:'callback', 
				data:{
                    
                    serialNo:serialNo,
                    userId:userId,
                    platform:1
                    
				},
				success: function(data) { //data就是返回的json数据
                    
                   
					//alert("请求成功")
                    
                    //alert("json="+JSON.stringify(data));
					console.log("json="+JSON.stringify(data));
                    
					if(data.returnCode == 0) {
                        
                        var dto = data.dto;

                        var cpId = dto.cpId;
                        var chargeStartTime = dto.chargeStartTime;
                        var chargeTimeSpan = dto.chargeTimeSpan;
                        var chargeQuantity = dto.chargeQuantity;
                        var chargeMoney = dto.chargeMoney;
                        var transationId = dto.transationId;
                        var totalfee = dto.totalFee;
	
                        if(totalfee-chargeMoney){
                            
                        var refund = totalfee - chargeMoney;
                        document.getElementById("refund_fee").innerHTML = refund.toFixed(2);	
                            
                         
                        }else{
                          document.getElementById("refund_fee").innerHTML = 0;	
                        }
                        
                        if(chargeTimeSpan>60){
                            var min = chargeTimeSpan/60;
                            var h = 0;
                            if(min > 60){
                            	min = min % 60;
                                h = min / 60;
                                h = h.toFixed(0);
                            }
                            var s = chargeTimeSpan % 60;
                           
                            var ts = min + h*60;
                            var t = ts.toFixed(0);
                            
                            //alert("t="+t+"ts="+ts+"min="+min+"chargeTimeSpan="+chargeTimeSpan);
                            
                        	document.getElementById("time").innerHTML = t;
                            
                        }else{
                        	
                            var t = chargeTimeSpan / 60;
                            t = t.toFixed(0);
                        	document.getElementById("time").innerHTML = t;
                        }
                        
                        
						document.getElementById("bill").innerHTML = transationId;
                        document.getElementById("money").innerHTML = totalfee; 
                        document.getElementById("quantity").innerHTML = chargeQuantity;
                        document.getElementById("chargeMoney").innerHTML = chargeMoney;
                        document.getElementById("date").innerHTML = chargeStartTime;
        				
                        
                        
                        
                        
						
					}else if(data.returnCode == 1){

                          alert("充电桩超时，订单将会以充电记录的形式出现");
                        
                    }else {
						
					}
				},
				error: function(jqXHR) {
                    
                    alert("json="+JSON.stringify(jqXHR));
       		    },
       });	
           
        
        
        }
        
      
        
        
        pushHistory();
        function pushHistory() {
          var state = {
              title: "title",
              url: "#"
            };
          window.history.pushState(state, "title", "#");
        }
        if (typeof window.addEventListener != "undefined") {
          window.addEventListener("popstate", function (e) {
            WeixinJSBridge.call('closeWindow');
          }, false);
        } else {
          window.attachEvent("popstate", function (e) {
            WeixinJSBridge.call('closeWindow');
          });
        }
            pushHistory();
            function pushHistory() {
              var state = {
                title: "title",
                url: "#"
              };
              window.history.pushState(state, "title", "#");
            }
            $(function() {
              wx.config({
                 debug: false,
                  appId: '<?php echo $signPackage["appId"];?>',
    			  timestamp: '<?php echo $signPackage["timestamp"];?>',
    			  nonceStr: '<?php echo $signPackage["nonceStr"];?>',
   			      signature: '<?php echo $signPackage["signature"];?>',
                  jsApiList: [// 所有要调用的 API 都要加到这个列表中     
                           "closeWindow",
                       ]
              });
              wx.ready(function() {
                wx.hideOptionMenu();
              });
              if (typeof window.addEventListener != "undefined") {
                window.addEventListener("popstate", function(e) {
                  wx.closeWindow();
                }, false);
              } else {
                window.attachEvent("popstate", function(e) {
                  wx.closeWindow();
                });
              }
            });

						
      
 
	</script>
</html>
