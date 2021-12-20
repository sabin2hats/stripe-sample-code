<div class="container">
    <?php
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'Success') { ?>
            <div class="alert alert-success">
                <strong>Success!</strong>
            </div>
        <?php } else { ?>

            <div class="alert alert-danger">
                <strong>Failed!</strong>
            </div>
    <?php }
    } ?>
    <form action="<?= URLROOT ?>settings/saveRedlistedemails" method="POST">
        <div class="form-group">
            <label for="email">Enter E-mails:</label>
            <textarea rows="4" columns="4" class="form-control" name="emails"><?= $data['emails'][0]['emails'] ?></textarea>
        </div>


        <button type="submit" class="btn btn-default">UPDATE</button>
    </form>
</div>