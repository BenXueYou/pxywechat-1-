<?php

        require_once "lib/WxPay.Api.php";
        require_once "WxPay.JsApiPay.php";

		
		
		$openId = $_GET["openId"];
		$total_fee = $_GET["total_fee"];
	    $total_fee = $total_fee *100;
        // $cpid = "070100400200101200";
         //$openId = "o0CsBw_0oxuji1dmw8aACKJz4kiY";
	     //$total_fee = "1";

   		//var_dump($cpId."===".$openId."===".$total_fee);

		
	   
        //②、统一下单
        
			$tools = new JsApiPay();
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
            $order = WxPayApi::unifiedOrder($input);
            $jsApiParameters = $tools->GetJsApiParameters($order);

            //$obj = json_decode($jsApiParameters);
			//var_dump($order);
			$Out_trade_no = $input->GetOut_trade_no();
                
			$arr = array();
			array_push($arr, $Out_trade_no);
			array_push($arr, json_decode($jsApiParameters));
			

			 
			$obj = json_encode($arr);

           // echo $jsApiParameters;
            
			echo $obj;
          
    

?>