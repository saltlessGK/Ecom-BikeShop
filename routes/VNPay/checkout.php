<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['localRate'])) {
    $json_response = curl_init('https://v6.exchangerate-api.com/v6/ed07bbb757c573f48b3d8b05/pair/AUD/VND');
    curl_setopt($json_response, CURLOPT_RETURNTRANSFER, true);
    $conversion_json = curl_exec($json_response);
    curl_close($json_response);
    $conversion_data = json_decode($conversion_json, true);
    if ($conversion_data['result'] === 'success' && isset($conversion_data['conversion_rate'])) {
        $_SESSION['localRate'] = $conversion_data['conversion_rate'];
    } else {
        $_SESSION['localRate'] = 18500;
    }
}
$amount = $_SESSION['grandTotal'] * $_SESSION['localRate']; // Convert to VND for VNPay
$roundedAmount = round($amount); // Round to nearest whole number
$_SESSION['amount'] = $roundedAmount; // Store the rounded amount to forward to VNPay API
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Create Order</title>
        <link href="../../assets/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="../../assets/css/jumbotron-narrow.css" rel="stylesheet">  
        <script src="../../assets/js/jquery-1.11.3.min.js"></script>
    </head>

    <body>
        <?php require_once("./config.php"); ?>             
        <div class="container">
        <h3>Create Order</h3>
            <div class="table-responsive">
                <form action="./vnpay_txn.php" id="frmCreateOrder" method="post">        
                    <div>
                        <h3>Amount to be paid:</h3>
                        <h4 class="grandTotal" id="amount" name="amount"><?php echo number_format($roundedAmount); ?> VND</h4>
                    </div>
                    <div class="form-group">
                        <h5>Choose payment method:</h5>
                        <input type="radio" Checked="True" id="bankCode" name="bankCode" value="">
                        <label for="bankCode">VNPay Payment Portal</label><br>
                    </div>
                    <div class="form-group">
                        <h5>Choose language for payment:</h5>
                        <input type="radio" id="language" Checked="True" name="language" value="vn">
                        <label for="language">Tiếng Việt</label><br>
                        <input type="radio" id="language" name="language" value="en">
                        <label for="language">English</label><br>
                    </div>
                    <button type="submit" class="btn btn-default" href>Proceed</button>
                </form>
            </div>
            <p>
                &nbsp;
            </p>
            <footer class="footer">
                <p>&copy; VNPAY 2020</p>
            </footer>
        </div>  
    </body>
</html>
