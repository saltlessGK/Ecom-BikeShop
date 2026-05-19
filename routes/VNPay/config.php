<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
  
$vnp_TmnCode = "FBRZSH0H";
$vnp_HashSecret = "ZDYCWW7J7TIT6STTF0V0M054U8VESR6V"; //Secret key
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
$vnp_Returnurl = "http://localhost/A2_Q1/routes/VNPay/vnpay_return.php";
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
$apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";

//Config input format
//Expire
$startTime = date("YmdHis");
$expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
?>