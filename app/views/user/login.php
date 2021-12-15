<link rel="stylesheet" href="../public/css/login.css">
<div class="container">
    <?php if (isset($_GET['success'])) {

        if ($_GET['success'] == 1) { ?>
            <div class="alert alert-success">
                <strong>Registered Successfully</strong>
            </div>
        <?php } elseif ($_GET['success'] == 2) { ?>
            <div class="alert alert-warning">
                <strong>Email and Password Mismatch</strong>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger">
                <strong>Some Error Occured</strong>
            </div>
    <?php }
    } ?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2>Ecommerce</h2>

            <form action="<?= URLROOT ?>user/processLoginRequest" method="post">
                <div class="imgcontainer">
                    <img src="../public/images/img_avatar2.png" alt="Avatar" class="avatar">
                </div>

                <div class="form-group">
                    <label for="uname"><b>Email</b></label>
                    <input type="text" placeholder="Enter Email" name="email" required>

                    <label for="psw"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="psw" required>

                    <button type="submit">Login</button>

                </div>

                <div class="form-group" style="background-color:#f1f1f1">
                    <a href="<?= URLROOT ?>user/register/">Create New Account</a>
                </div>
            </form>
        </div>
    </div>
</div>