<?php
//PayPal configuration
define('PAYPAL_ID', 'sb-dkgeu46532064@business.example.com');
define('PAYPAL_SANDBOX', TRUE);

//redirect page
define('PAYPAL_RETURN_URL', 'http://localhost/A2_Q1/successPayPal.php'); 
define('PAYPAL_CANCEL_URL', 'http://localhost/A2_Q1/cart.php'); 
define('PAYPAL_NOTIFY_URL', 'http://localhost/A2_Q1/ipn.php');

//define currency
define('PAYPAL_CURRENCY', 'AUD');

//define paypal url
define('PAYPAL_URL', (PAYPAL_SANDBOX == true)? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://www.paypal.com/cgi-bin/webscr");
?>