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
    <form class="form-inline" action="<?= URLROOT ?>settings/saveApikey" method="POST">
        <div class="form-group">
            <label for="email">API Key:</label>
            <input type="text" class="form-control" id="apiKey" name="apiKey" value="<?= $data['apikey'][0]['apikey'] ?>">
        </div>


        <button type="submit" class="btn btn-default">UPDATE</button>
    </form>
</div>