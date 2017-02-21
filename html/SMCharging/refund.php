 <?php
    require_once "lib/WxPay.Api.php";
   
	
   $out_trade_no = $_GET["out_trade_no"];
   $total = $_GET["refrund_fee"];
   $total_fee = $_GET["total_fee"];

//$out_trade_no = "143933040220170220115504";
//$total_fee = '100';

//$total = '100';

    $input = new WxPayRefund();
    $input->SetOut_trade_no($out_trade_no);
    $input->SetTotal_fee($total_fee);
    $input->SetRefund_fee($total);
    $input->SetOut_refund_no(WxPayConfig::MCHID.date("YmdHis"));
    $input->SetOp_user_id(WxPayConfig::MCHID);
    printf_info(WxPayApi::refund($input));


    
			

    function printf_info($data)
        
    {
        $arr = array();
	    array_push($arr, $out_trade_no);
        array_push($arr, $total);
        array_push($arr, $total_fee);
        array_push($arr, $data);

           // var_dump($arr);
       echo json_encode($arr);
    }

?>

  