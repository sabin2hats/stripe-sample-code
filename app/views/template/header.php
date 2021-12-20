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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="<?= URLROOT ?>public/js/config.js" defer></script>
</head>

<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="<?= URLROOT ?>">Ecommerce Site</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="<?= URLROOT ?>">Home</a></li>
                <?php if (isset($_SESSION['user'])) { ?>
                    <li><a href="<?= URLROOT ?>orders">Orders</a></li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Settings <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?= URLROOT ?>settings/apiKey">API Key</a></li>
                            <li><a href="<?= URLROOT ?>settings/redlistEmails">Redlist Emails</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] == 1) { ?>
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?= $_SESSION['user']['name'] ?></a></li>
                    <li><a href="<?= URLROOT ?>user/logout"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
                <?php } else { ?>
                    <li><a href="<?= URLROOT ?>user/"><span class="glyphicon glyphicon-user"></span> Sign in</a></li>

                <?php } ?>

            </ul>
        </div>
    </nav>