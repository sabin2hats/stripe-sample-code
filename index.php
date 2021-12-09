<!DOCTYPE html>
<html lang="en">
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';
require_once('actions/product.php');
require_once('actions/connection.php');
$pdt = new Product($conn);
$all_pdt = $pdt->read_all();
// print_r($all_pdt);
// die;
?>

<head>
    <title>Ecommerce</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Ecommerce Site</a>
            </div>
            <!-- <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Page 1-1</a></li>
                        <li><a href="#">Page 1-2</a></li>
                        <li><a href="#">Page 1-3</a></li>
                    </ul>
                </li>
                <li><a href="#">Page 2</a></li>
            </ul> -->
            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($_SESSION['user'])) { ?>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?= $_SESSION['user']['name'] ?></a></li>
                    <li><a href="users/logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                <?php } else { ?>
                    <li><a href="users/login.php"><span class="glyphicon glyphicon-user"></span> Sign in</a></li>

                <?php } ?>

            </ul>
        </div>
    </nav>
    <div class="container">
        <h2>Products</h2>
        <hr>
        <div class="row">
            <?php foreach ($all_pdt as $key) { ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="assets/images/<?= $key['image'] ?>" alt="Product Image" style="height:250px;width250px;">
                        <h3><?= $key['name'] ?></h3>
                        <p class="price">Rs <?= $key['price'] ?></p>
                        <p>
                        <form method="post" action="checkout/checkout.php">
                            <input type="hidden" name="product_id" value="<?= $key['id'] ?>">
                            <button type="submit" class=" btn btn-success">Buy Now</button></p>
                        </form>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

</body>

</html>