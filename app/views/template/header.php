<!DOCTYPE html>
<html lang="en">
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<head>
    <title>Ecommerce</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="<?= URLROOT ?>public/js/config.js" defer></script>
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
                    <li><a href="<?= URLROOT ?>user/logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                <?php } else { ?>
                    <li><a href="<?= URLROOT ?>user/"><span class="glyphicon glyphicon-user"></span> Sign in</a></li>

                <?php } ?>

            </ul>
        </div>
    </nav>