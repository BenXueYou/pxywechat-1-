<?php



require_once "lib/WxPay.Api.php"; 
   
$out_trade_no = "143933040220170215152532";
$refund_fee="1";
$total_fee = "1";
		


    $input = new WxPayRefund();
    $input->SetOut_trade_no($out_trade_no);
	$input->SetTotal_fee($total_fee);
	$input->SetRefund_fee($refund_fee);
    $input->SetOut_refund_no(WxPayConfig::MCHID.date("YmdHis"));
    $input->SetOp_user_id(WxPayConfig::MCHID);

	$order = WxPayApi::refund($input);

    var_dump($order);	
	
echo "123";

?>