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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Alice Bike Shop - Main Page</title>
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
    <script defer>
        $(function () {
            $('#mi-slider').catslider();
        });
	</script>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addToCart'])) {
            $itemID = $_POST['addToCart'];
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            if (!empty($itemID)) {
                if (!in_array($itemID, array_column($_SESSION['cart'], 'id'))) {
                    $_SESSION['cart'][] = array('id' => $itemID, 'qty' => 1);
                } else {
                    foreach ($_SESSION['cart'] as $key => $cartItem) {
                        if ($cartItem['id'] == $itemID) {
                            $_SESSION['cart'][$key]['qty']++;
                            break;
                        }
                    }
                }
            }
        }
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
                            <li><a href="#"><strong>Call: </strong>+61-000-000-000</a></li>
                            <li><a href="#"><strong>Mail: </strong>info@alicebikeshop.com</a></li>
                            <li class="divider"></li>
                            <li><a href="#"><strong>Address: </strong>
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
    <div class="container">

        <div class="row">
            <div class="col-md-9">
                <div>
                    <ol class="breadcrumb">

                        <li class="active">Vehicles</li>
                    </ol>
                </div>
                <!-- /.div -->
                <div class="row">
                    <div class="btn-group alg-right-pad">
                        <button type="button" class="btn btn-default"><strong><?php echo count($item); ?></strong> items</button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                                Sort Products &nbsp;
                            <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">By Price Low</a></li>
                                <li class="divider"></li>
                                <li><a href="#">By Price High</a></li>
                                <li class="divider"></li>
                                <li><a href="#">By Popularity</a></li>
                                <li class="divider"></li>
                                <li><a href="#">By Reviews</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <?php foreach($item as $key=>$value){ ?>
                        <div class="col-md-4 text-center col-sm-6 col-xs-6">
                            <div class="thumbnail product-box">
                                <img class="product-img" src="<?php echo $value['image']; ?>" alt="<?php echo $value['alt']; ?>">
                                <div class="caption">
                                    <h3><a href="#"><?php echo $value['name']; ?></a></h3>
                                    <h4>Price: <strong>$<?php echo $value['price'] . ' ' . PAYPAL_CURRENCY; ?></strong></h4>
                                    <p><?php echo $value['description']; ?></p>
                                    <p>Availability: <span style="color:green;"><?php echo $value['availability']; ?></span></p>
                                    <p>Delivery: <span style="color:blue;"><?php echo $value['delivery']; ?></span></p>
                                    <form method="post" style="display:inline;">
                                        <button type="submit" name="addToCart" value="<?php echo $value['id']; ?>" class="btn btn-success">Add To Cart</button>
                                    </form>
                                    <a href="#" class="btn btn-primary" role="button">See Details</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                </div>
                <!-- /.row -->
                
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
    

    <!--Footer -->
    <div class="col-md-12 footer-box">

            <div class="col-md-4">
                <strong>Our Location</strong>
                <hr>
                <p>
                    Swanston St, Melbourne,<br />
                    VIC 3000, Australia<br />
                    Call: +61-000-000-000<br>
                    Email: info@alicebikeshop.com<br>
                </p>
                2020 www.alicebikeshop.com | All Right Reserved
            </div>
        </div>
        <hr>
    </div>
    <!-- /.col -->
    <div class="col-md-12 end-box ">
        &copy; 2020 | &nbsp; All Rights Reserved | &nbsp; www.alicebikeshop.com | &nbsp; 24x7 support | &nbsp; Email us: info@alicebikeshop.com
    </div>
    <!-- /.col -->
    
</body>
</html>
