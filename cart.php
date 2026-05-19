<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Include configuration file
include_once "routes/PayPal/config.php";
// Include hypothetical database
include_once "db/data.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Rubik" rel="stylesheet" >
    <link href="assets/ItemSlider/css/main-style.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- JavaScript -->
    <script defer src="assets/js/jquery-1.10.2.js"></script>
    <script defer src="assets/js/bootstrap.js"></script>
    <script defer src="assets/ItemSlider/js/modernizr.custom.63321.js"></script>
    <script defer src="assets/ItemSlider/js/jquery.catslider.js"></script>
    <script defer>
        $(function () {
            $('#mi-slider').catslider();
        });
	</script>
    <script defer>
        let submitButton = null;
        $('#cartForm button[type="submit"]').click(function() {
            submitButton = this;
        });
        $('#cartForm').submit(function(e) {
            if (submitButton) {
                if ($(submitButton).is('#updateCart')) {
                    $(':checkbox', this).prop('disabled', true);
                } else if ($(submitButton).is('#removeItem')) {
                    $(':number', this).prop('disabled', true);
                }
            }
            return true;
        });
    </script>
    <style>
        .cart-container {
            width: 80%;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
        }
        .cart-header, .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .cart-header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .cart-item {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .cart-item img {
            max-width: 100px;
        }
        .cart-item p {
            margin: 0;
        }
        .cart-item .description {
            flex: 2;
            padding: 0 10px;
        }
        .cart-item .price, .cart-item .qty, .cart-item .total {
            flex: 1;
            text-align: center;
        }
        .cart-item .qty input {
            width: 50px;
            text-align: center;
        }
        .update-btn, .remove-btn {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateCart'])) {
        $cartInfo = [];
        foreach ($_POST['qty'] as $id => $qty) {
            $cartInfo[] = ['id' => $id, 'qty' => $qty];
        }
        foreach ($_SESSION['cart'] as $key => $cartItem) {
            foreach ($cartInfo as $info) {
                if ($cartItem['id'] == $info['id']) {
                    $_SESSION['cart'][$key]['qty'] = $info['qty'];
                    break;
                }
            }
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeItem'])) {
        if (!empty($_POST['checkbox'])) {
            $removedIDs = $_POST['checkbox'];
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function($cartItem) use ($removedIDs) {
                return !in_array($cartItem['id'], $removedIDs);
            });
        }
    }
    $grandTotal = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $cartItem) {
            foreach ($item as $product) {
                if ($product['id'] == $cartItem['id']) {
                    $grandTotal += $product['price'] * $cartItem['qty'];
                    break;
                }
            }
        }
    }
    $_SESSION['grandTotal'] = $grandTotal;
    ?>
</head>
<body>

    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><strong>ALICE'S</strong> ELECTRONIC BIKE Shop</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Track Order</a></li>
                    <li><a href="cart.php">View Cart</a></li>
                    <li><a href="#">Login</a></li>
                    <li><a href="#">Signup</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">24x7 Support <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><strong>Call:</strong> +61-000-000-000</a></li>
                            <li><a href="#"><strong>Mail:</strong> info@alicebikeshop.com</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><strong>Address:</strong>
                                <div>
                                    Melbourne,<br />
                                    VIC 3000, AUSTRALIA
                                </div>
                            </a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-right" role="search">
                    <div class="form-group">
                        <input type="text" placeholder="Enter Keyword Here ..." class="form-control">
                    </div>
                    &nbsp; 
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div class="cart-container">
        <h1>Shopping Cart</h1>
        <?php
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
            <form id="cartForm" method="post" action="cart.php">
                <table>
                    <tr class="cart-header">
                        <th class="checkbox"></th>
                        <th class="image">Image</th>
                        <th class="description">Product Description</th>
                        <th class="price">Price</th>
                        <th class="qty">Quantity</th>
                        <th class="total">Total</th>
                    </tr>

                    <?php
                    foreach ($_SESSION['cart'] as $cartItem) {
                        $cartDetails = null;
                        $itemDetails = null;
                        foreach ($item as $product) {
                            if ($product['id'] == $cartItem['id']) {
                                $cartDetails = $cartItem;
                                $itemDetails = $product;
                                break;
                            }
                        }
                        if ($cartDetails) { ?>
                            <tr class="cart-item">
                                <td class="checkbox" ><input type="checkbox" name="checkbox[]" value="<?php echo $cartDetails['id']; ?>"></td>
                                <td class="image"><img src="<?php echo $itemDetails['image']; ?>" alt="<?php echo $itemDetails['alt']; ?>"></td>
                                <td class="description">
                                    <p><strong><?php echo $itemDetails['name']; ?></strong></p>
                                    <p><?php echo $itemDetails['description']; ?></p>
                                    <p>Availability: <span style="color:green;"><?php echo $itemDetails['availability']; ?></span></p>
                                    <p>Delivery: <span style="color:blue;"><?php echo $itemDetails['delivery']; ?></span></p>
                                </td>
                                <td class="price">$<?php echo number_format($itemDetails['price'], 2); ?></td>
                                <td class="qty"><input type="number" name="qty[<?php echo $cartDetails['id']; ?>]" value="<?php echo $cartDetails['qty']; ?>" placeholder="<?php echo $cartDetails['qty']; ?>" min="1"></td>
                                <td class="total">$<?php echo number_format($itemDetails['price'] * $cartDetails['qty'], 2); ?></td>
                            </tr>
                        <?php }
                    } ?>

                    <tr class="cart-total">
                        <td class="total" colspan="6" style="text-align:right; height:40px; font-size: 1.2em;">
                            <strong>Grand Total: $<?php echo number_format($grandTotal, 2); ?></strong>
                        </td>
                </table>
                <button type="submit" class="update-btn" name="updateCart" id="updateCart">UPDATE</button>
                <button type="submit" class="remove-btn" name="removeItem" id="removeItem">REMOVE</button>
            </form>
            <div>
                <br>
                <h4>Proceed to any of the following payment methods:</h4>
                <div style="display: flex; align-items: center; gap: 20px;">
                    <form action="<?php echo PAYPAL_URL; ?>" method="post" style="padding: 0; margin: 0;">
                        <input type="hidden" name="cmd" value="_xclick" />
                        <input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>" />
                        <input type="hidden" name="item_name" value="<?php echo $itemDetails['name']; ?>" />
                        <input type="hidden" name="item_quantity" value="<?php echo $cartDetails['qty']; ?>" />
                        <input type="hidden" name="amount" value="<?php echo $grandTotal; ?>" />
                        <input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>" />
                        <input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
                        <input type="hidden" name="notify_url" value="<?php echo PAYPAL_NOTIFY_URL; ?>">
                        <input type="image" name="submit" src="assets/img/paypal-logo.jpg" style="margin: 10px; height: 60px; border-radius: 4px;">
                    </form>
                    <div id="container" style="display: flex; align-items: center;">
                        <div class="row">
                            <script>
                                var grandTotal = <?php echo $grandTotal; ?>;
                            </script>
                            <script src="routes/GooglePay/index.js"></script>
                            <script async src="https://pay.google.com/gp/p/js/pay.js" onload="onGooglePayLoaded()"></script>
                        </div>
                    </div>
                    <form method="post" action="routes/Stripe/checkout.php" style="padding: 0; margin: 0;">
                        <input type="image" name="submit" src="assets/img/stripe-logo.jpg" style="margin: 10px; height: 50px; border-radius: 4px;">
                    </form>
                    <form method="post" action="routes/VNPay/checkout.php" style="padding: 0; margin: 0;">
                        <input type="image" name="submit" src="assets/img/vnpay-logo.png" style="margin: 10px; height: 50px; border-radius: 4px;">
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <h4>Your cart is empty.</h4>
        <?php } ?>


    </div>

</body>
</html>
