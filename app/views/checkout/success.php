<div class="container">
    <h2>Payment Status</h2>
    <?php if ($_GET['redirect_status'] == 'succeeded') { ?>
        <div class="alert alert-success">
            <strong>Success!</strong> Your Payment is Success.
        </div>
    <?php } else { ?>

        <div class="alert alert-danger">
            <strong>Payment Failed!</strong>
        </div>
    <?php } ?>
    <div align="center">
        <button class="btn btn-primary" onclick="location.href='<?= URLROOT ?>product';">Continue Shopping</button>
    </div>

</div>