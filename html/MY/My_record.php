<?php

require_once "../../php/jssdk.php";
 
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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
    <meta http-equiv="X-UA-Compatible" content="IE=8">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta http-equiv="Cache" content="no-cache">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <link rel="icon" href="../../img/logo.png" type="image/x-icon"/>
	
	<meta name="format-detection" content="telephone=no">
	<meta name="format-detection" content="email=no">
	<title>充电记录</title>
    <link href="../../JS/common_2.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../JS/jquery-3.0.0.min.js" ></script>
    <script type="text/javascript" src="../../JS/date.js" ></script>
    <script type="text/javascript" src="../../JS/iscroll.js" ></script>
	<script type="text/javascript">
	$(function(){
	
		$('#beginTime').date();
	
		$('#endTime').date({theme:"datetime"});
	
	});
	
	</script>

</head>

<body>   

	<style type="text/css">
        *{
        padding:0;
            margin:0;
            background-color:rgb(255,255,255);
        
        };
	.demo{width:300px;margin:20px auto 0 auto;; position: relative;}
	.demo .lie{margin:0 0 20px 0;}
        .demo .kbtn{border:1px solid lightgray;line-height:25px}
	.demo button{
		width: 50px;
		height: 30px;
		position: absolute;
		top: 30%;
		right: 10px;
		background-color: white;
		border-radius: 5px;	
		border: 1px solid lightgray;	
	}
        h3{text-align: center; margin:30px 0}
	.record_list{
            font-size:15px;
	}
	.record_li{
		width: 98%;
		margin: 5px auto;
		
		list-style-type: none;
		overflow: hidden;
        border-top:1px solid lightgray;
	}
	.record_li img{
		width: 60px;
		height: 60px;
		background-clip: content-box;
		background-origin: content-box;
		background-size: cover;
		float: left;
		margin: 15px 10px;
		border-radius: 30px;
	}
	.record_txt{
		width:calc(100% - 80px);
		float: left;
		padding: 10px 0px;
		/*background-color: blue;*/
	}
	
	.record_txt_div{
		overflow: hidden;
		
	}
	.record_txt_div{
		margin: 10px auto;
		overflow: hidden;
		/*background-color: red;*/
	}
	.record_txt_div div{
		width: 50%;
		float: left;
		
	}
	.record_address{
		width: 98%;
		text-align: center;
		font-size: 15px;
		float: left;
		margin:0 auto 10px;
		/*background-color: red;*/
	}
        
        .cell{
        	background-color:white;
            width:96%;
            margin:0px 1%;
            padding:5px 8px;
            border-bottom:1px solid gray;
        }
        .cell-p{
        	background-color:white;
            padding:0px 8px;
        }
        .hidden{
        	display:none;
        }
        .none{
        
        
        }
        
	</style>
	
	<h3 style="display:none">充电记录</h3>
	
	
    
    
    <div id="con"><div class="no hidden"><h3>你还没有充电记录</h3></div></div>
   
  
</body>
<script type="text/javascript"> 
    
      var urlM = "http://116.236.237.244:8080/SBM_longkeep/";
      var userId = '<?php echo $openid;?>';
    
     //alert(userId);
       getRecord();
    
     function getRecord(){
    
    
    	var Ajax = $.ajax({
            
        		type:"GET", // 请求方式
				url: urlM + "userManager/chargeRecorderByUserId", // 请求地址
				dataType:'json',
				data:{                    
                    //userId:userId,
                    userId:userId,
                    platform:1
				},
				success: function(data) { //data就是返回的json数据
                    
					
                   console.log("json="+JSON.stringify(data));
                    
                  // alert("json="+JSON.stringify(data));
                    
                    if(data.returnCode==0){
                    	
                        var arr = data.detail;
                        var chargeRecorder = arr.chargeRecorder;
                      
                        
                        for(var i = 0;i < chargeRecorder.length;i++){
                         
                            
                            console.log(chargeRecorder);
                            
                           // alert(chargeRecorder[i]);
                            
                            var obj = chargeRecorder[i];
                            
                             //获取div  
                             var div = document.getElementById("con");  

                            //换行  
                            var br = document.createElement("br");  
                            div.appendChild(br);  

                            //添加label ，存放指标名称  
                            var div2 = document.createElement("div"); 
                            div2.setAttribute('class', 'cell');  

                            div.appendChild(div2);  

                            //添加text ，存放指标权重  
                            var p = document.createElement("p");  
                            p.setAttribute('class', 'cellp');  
                            p.innerHTML = "充电桩："+obj.cpName; 
                            div2.appendChild(p);  
                          //添加text ，存放指标权重  
                            var p = document.createElement("p");  
                            p.setAttribute('class', 'cellp');
                            
                            var ttt = obj.chargeTimeSpan / 60;
                            
                            var tt = ttt.toFixed(0);
                            
                            p.innerHTML = "充电时长(分)："+tt; 
                            div2.appendChild(p);  


                          //添加text ，存放指标权重  
                            var p = document.createElement("p");  
                            p.setAttribute('class', 'cellp');  
                            p.innerHTML = "充电电量(度)："+obj.chargeQuantity; 
                            div2.appendChild(p);  

                          //添加text ，存放指标权重  
                            var p = document.createElement("p");  
                            p.setAttribute('class', 'cellp');  
                            p.innerHTML = "充电金额(元)："+obj.chargeMoney; 
                            div2.appendChild(p);  

                          //添加text ，存放指标权重  
                            var p = document.createElement("p");  
                            p.setAttribute('class', 'cellp');  
                            p.innerHTML = "开始时间："+obj.chargeStartTime; 
                            div2.appendChild(p);  

                            //换行  
                            var br = document.createElement("br");  
                            div.appendChild(br);   
                         
    				   }
    
                        
                    
                    }else if(data.returnCode==1){
                   
                    	$(".no").removeClass('hidden') 
                        
                    }else{
                    	
                       
                    }  				
				},
				error: function(jqXHR) {
                    
                     
                    alert("请求用户充电记录发生错误,服务器异常："+ jqXHR.status);
                   
        		},
        
        
        
        });
    

    }
    
</script>       
</html>

