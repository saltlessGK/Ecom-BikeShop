<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Payment Success</title>
    <!-- CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href="assets/ItemSlider/css/main-style.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- JavaScript -->
    <script defer src="assets/js/jquery-1.10.2.js"></script>
    <script defer src="assets/js/bootstrap.js"></script>
    <script defer src="assets/ItemSlider/js/modernizr.custom.63321.js"></script>
    <script defer src="assets/ItemSlider/js/jquery.catslider.js"></script>
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
		<h1>Payment Info</h1>
		<div class="container">
	    	<div class="status">
	            <h3 class="success">Payment Successful</h3>
	            <p><b>Paid Amount:</b> $<?php echo $_SESSION['grandTotal']; ?></p>
	        	<?php unset($_SESSION['cart']); ?>
	    	</div>
	    	<a href="index.php"><button class="btn btn-primary">Back to Home</button></a>
		</div>
	</div>
</body>
</html>