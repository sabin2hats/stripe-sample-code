<div class="container">
    <h2>Products</h2>
    <hr>
    <div class="row">
        <?php foreach ($data['products'] as $key) { ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="<?= URLROOT ?>public/images/<?= $key['image'] ?>" alt="Product Image" style="height:250px;width250px;">
                    <h3><?= $key['name'] ?></h3>
                    <p class="price">Rs <?= $key['price'] ?></p>
                    <p>
                    <form method="post" action="<?= URLROOT ?>checkout">
                        <input type="hidden" name="product_id" value="<?= $key['id'] ?>">
                        <button type="submit" class=" btn btn-success">Buy Now</button></p>
                    </form>
                </div>
            </div>
        <?php } ?>

    </div>
</div>