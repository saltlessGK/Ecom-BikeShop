<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../vendor/autoload.php";

$stripe_secret_key = "sk_test_51SDvTnE5XnCSXErganJTCvhZwa6Zi8ov5p7lVYKTcoVI61rOUN1rfJ7uqwff8scejoZIW2xCgMkbdncLabtGcNTp00fBVsE5Dd";
\Stripe\Stripe::setApiKey($stripe_secret_key);

// Use 4242 4242 4242 4242 (Visa) or 5555 5555 5555 4444 (MasterCard) for testing
$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/A2_Q1/success.php",
    "cancel_url" => "http://localhost/A2_Q1/cart.php",
    "locale" => "auto",
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "aud",
                "unit_amount" => $_SESSION['grandTotal'] * 100,
                "product_data" => [
                    "name" => "Grand Total"
                ]
            ]
        ]  
    ]
]);

http_response_code(303);
header("Location: " . $checkout_session->url);