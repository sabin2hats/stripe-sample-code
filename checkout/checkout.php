<!DOCTYPE html>
<html lang="en">
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require '../vendor/autoload.php';
require_once('../actions/product.php');
require_once('../actions/connection.php');
$pdt = new Product($conn);
$all_pdt = $pdt->readOne($_POST['product_id']);
// print_r($all_pdt);
// die;
?>

<head>
  <meta charset="utf-8" />
  <title>Accept a payment</title>
  <meta name="description" content="A demo of a payment on Stripe" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../assets/css/checkout.css" />
  <script src="https://js.stripe.com/v3/"></script>
  <script src="../assets/js/checkout.js" defer></script>
  <script src="../assets/js/actions.js" defer></script>
</head>

<body>
  <!-- <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="#">Ecommerce Site</a>
      </div>
      <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Page 1-1</a></li>
                        <li><a href="#">Page 1-2</a></li>
                        <li><a href="#">Page 1-3</a></li>
                    </ul>
                </li>
                <li><a href="#">Page 2</a></li>
            </ul> 
  <ul class="nav navbar-nav navbar-right">
    <?php if (isset($_SESSION['user'])) { ?>
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?= $_SESSION['user']['name'] ?></a></li>
      <li><a href="users/logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    <?php } else { ?>
      <li><a href="users/login.php"><span class="glyphicon glyphicon-user"></span> Sign in</a></li>

    <?php } ?>

  </ul>
  </div>
  </nav> -->

  <div class="row">
    <div class="col-md-6" style="margin-top: 200px;">
      <div class="card">
        <img src="../assets/images/<?= $all_pdt['image'] ?>" alt="Product Image" style="height:250px;width250px;">
        <h3><?= $all_pdt['name'] ?></h3>
        <input type="hidden" id="product_id" value="<?= $all_pdt['id'] ?>">
        <p class="price">Rs <?= $all_pdt['description'] ?></p>
        <p class="price">Rs <?= $all_pdt['price'] ?></p>
        <p>

      </div>
    </div>
    <div class="col-md-6" style="margin-top: 20px;">
      <!-- Display a payment form -->
      <form id="payment-form">
        <div class="form-group">
          <label class="custom_inlabel">Card Holders Name</label>
          <input type="text" class="form-control" name="name" id="cst_name">
        </div>
        <div class="form-group">
          <label class="custom_inlabel">Email</label>
          <input type="email" class="form-control" name="email" id="cst_email">
        </div>
        <div id="payment-element">
          <!--Stripe.js injects the Payment Element-->
        </div>
        <div class="form-group">
          <label class="custom_inlabel">Address Line1</label>
          <input type="text" class="form-control" name="line1" id="line1">
        </div>
        <div class="form-group">
          <label class="custom_inlabel">Address Line2</label>
          <input type="text" class="form-control" name="line2" id="line2">
        </div>
        <div class="row">
          <div class="col-md-6 form-group">
            <label class="custom_inlabel">City</label>
            <input type="text" class="form-control" name="city" id="city">
          </div>
          <div class="col-md-6 form-group">
            <label class="custom_inlabel">PIN/ZIP</label>
            <input type="text" class="form-control" name="zip" id="zip">
          </div>
        </div>
        <div class="form-group">
          <label class="custom_inlabel">State</label>
          <select class="form-control" name="state" id="state">
            <option value="">Select</option>
          </select>
        </div>
        <button id="submit">
          <div class="spinner hidden" id="spinner"></div>
          <span id="button-text">Pay now</span>
        </button>
        <div id="payment-message" class="hidden"></div>
      </form>
    </div>
  </div>

</body>

</html>