<?php



    require_once "lib/WxPay.Api.php";
   
	
   $out_trade_no = $_GET["out_trade_no"];
   $total_fee = $_GET["refrund_fee"];
   $total = $_GET["total_fee"];

    $out_trade_no = "143933040220170220155952";


    $input = new WxPayRefund();
    $input->SetOut_trade_no($out_trade_no);
    $input->SetTotal_fee('100');
    $input->SetRefund_fee('100');
    $input->SetOut_refund_no(WxPayConfig::MCHID.date("YmdHis"));
    $input->SetOp_user_id(WxPayConfig::MCHID);
    printf_info(WxPayApi::refund($input));

    function printf_info($data)
    {
       echo json_encode($data);
    }


?>