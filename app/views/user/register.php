<?php
@session_start();
if (isset($_SESSION['user'])) {
    header("Location: " . URLROOT . "");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?= URLROOT ?>public/css/login.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="<?= URLROOT ?>public/js/actions.js"></script>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h2>Register to Ecommerce</h2>
                <form action="<?= URLROOT ?>user/createNewUser" method="post">
                    <div class="imgcontainer">
                        <!-- <img src="../assets/images/img_avatar2.png" alt="Avatar" class="avatar"> -->
                    </div>

                    <div class="form-group">
                        <label for="name"><b>Name</b></label>
                        <input class="form-control" type="text" placeholder="Enter Username" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="uname"><b>Email</b></label>
                        <input class="form-control" type="email" placeholder="Enter Email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="uname"><b>Phone</b></label>
                        <input class="form-control" type="number" placeholder="Enter Mobile No" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label>Address Line1</label>
                        <input type="text" class="form-control" name="line1" id="line1">
                    </div>
                    <div class="form-group">
                        <label>Address Line2</label>
                        <input type="text" class="form-control" name="line2" id="line2">
                    </div>
                    <div class="form-group">
                        <label class="custom_inlabel">Country</label>
                        <select class="form-control" name="country" id="country" required onchange="getState(this.value,'state')">
                            <option value="">Select</option>
                            <?php foreach ($data['countries'] as $row) { ?>
                                <option value="<?= $row['sortname'] ?>"><?= $row['name'] ?></option>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label class="custom_inlabel">State</label>
                        <select class="form-control" name="state" id="state">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" name="city" id="city">
                    </div>
                    <div class="form-group">
                        <label>PIN/ZIP</label>
                        <input type="text" class="form-control" name="zipcode" id="zipcode">
                    </div>

                    <div class="form-group">
                        <label for="psw"><b>Password</b></label>
                        <input class="form-control" type="password" placeholder="Enter Password" name="psw" required>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-success" type="submit">Register</button>

                    </div>

                    <div class="form-group" style="background-color:#f1f1f1">
                        <p>Already have an account? <a href="<?= URLROOT ?>user/login">Sign in</a>.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>