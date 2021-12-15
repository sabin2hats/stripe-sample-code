<link rel="stylesheet" href="<?= URLROOT ?>public/css/checkout.css" />
<div class="col-md-10 col-md-offset-1">
    <div class="row">

        <!-- Shipping Address -->

        <div class="col-md-4">
            <div class="panel panel-default panel-custom shipping-div">
                <h3>Shipping Address</h3>
                <div class="form-group">
                    <label class="custom-inlabel">Name</label>
                    <input type="text" class="form-control" name="ship_name" id="ship_name" value="<?= (!empty($data['user_det']) ? $data['user_det']->name : '') ?>" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Phone</label>
                    <input type="email" class="form-control" name="ship_phone" id="ship_phone" value="<?= (!empty($data['user_det']) ? $data['user_det']->phone : '') ?>" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Address Line1</label>
                    <input type="text" class="form-control" name="ship_line1" id="ship_line1" value="<?= (!empty($data['user_det']) ? $data['user_det']->line1 : '') ?>" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Address Line2</label>
                    <input type="text" class="form-control" name="ship_line2" id="ship_line2" value="<?= (!empty($data['user_det']) ? $data['user_det']->line2 : '') ?>" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Country</label>
                    <select class="form-control" name="ship_country" id="ship_country" required onchange="getState(this.value,'ship_state')" required>
                        <option value="">Select</option>
                        <?php foreach ($data['countries'] as $row) { ?>
                            <option value="<?= $row['sortname'] ?>" <?= (!empty($data['user_det']) && ($data['user_det']->country_code == $row['sortname'])) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                        <?php } ?>

                    </select>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">State</label>
                    <select class="form-control" name="ship_state" id="ship_state" required>
                        <option value="">Select</option>
                        <?php foreach ($data['states'] as $row) { ?>
                            <option value="<?= $row['name'] ?>" <?= (!empty($data['user_det']) && ($data['user_det']->state == $row['name'])) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                        <?php } ?>
                    </select>
                    <span class="valid-address"></span>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="custom-inlabel">City</label>
                        <input type="text" class="form-control" name="ship_city" id="ship_city" value="<?= (!empty($data['user_det']) ? $data['user_det']->city : '') ?>" required>
                        <span class="valid-address"></span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-inlabel">PIN/ZIP</label>
                        <input type="text" class="form-control" name="ship_zip" id="ship_zip" value="<?= (!empty($data['user_det']) ? $data['user_det']->zipcode : '') ?>" required>
                        <span class="valid-address"></span>
                    </div>
                </div>
                </form>

            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="" id="copy_address">Use Shipping Address as Billing Address</label>
            </div>
        </div>
        <!-- Billing Address -->

        <div class="col-md-4">
            <div class="panel panel-default panel-custom billing-div">
                <h3>Billing Address</h3>
                <div class="form-group">
                    <label class="custom-inlabel">Name</label>
                    <input type="text" class="form-control" name="bill_name" id="bill_name" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Phone</label>
                    <input type="email" class="form-control" name="bill_phone" id="bill_phone" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Address Line1</label>
                    <input type="text" class="form-control" name="bill_line1" id="bill_line1" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Address Line2</label>
                    <input type="text" class="form-control" name="bill_line2" id="bill_line2" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Country</label>
                    <select class="form-control" name="bill_country" id="bill_country" required onchange="getState(this.value,'bill_state')" required>
                        <option value="">Select</option>
                        <?php foreach ($data['countries'] as $row) { ?>
                            <option value="<?= $row['sortname'] ?>"><?= $row['name'] ?></option>
                        <?php } ?>

                    </select>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">State</label>
                    <select class="form-control" name="bill_state" id="bill_state" required>
                        <option value="">Select</option>
                    </select>
                    <span class="valid-address"></span>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="custom-inlabel">City</label>
                        <input type="text" class="form-control" name="bill_city" id="bill_city" required>
                        <span class="valid-address"></span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-inlabel">PIN/ZIP</label>
                        <input type="text" class="form-control" name="bill_zip" id="bill_zip" required>
                        <span class="valid-address"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Display a payment form -->
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-6 form-group">
                    <img src="<?= URLROOT ?>public/images/<?= $data['all_pdt']['image'] ?>" alt="Product Image" style="height:250px;width250px;">
                </div>
                <div class="col-md-4">
                    <div class="card">

                        <h3><?= $data['all_pdt']['name'] ?></h3>
                        <input type="hidden" id="product_id" value="<?= $data['all_pdt']['id'] ?>">
                        <p class="price"><?= $data['all_pdt']['description'] ?></p>
                        <p class="price">Rs <?= $data['all_pdt']['price'] ?></p>
                        <p>

                    </div>
                </div>
            </div>


            <form id="payment-form">
                <div class="form-group">
                    <label class="custom-inlabel">Card Holders Name</label>
                    <input type="text" class="form-control" name="name" id="cst_name" required>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Email</label>
                    <input type="email" class="form-control" name="email" id="cst_email" required>
                </div>
                <div id="payment-element">
                    <!--Stripe.js injects the Payment Element-->
                </div>
                <button class="chekout-button" id="submit">
                    <div class="spinner hidden" id="spinner"></div>
                    <span id="button-text">Pay now</span>
                </button>
                <div id="payment-message" class="hidden"></div>
            </form>
        </div>
    </div>
</div>


<script src="<?= URLROOT ?>public/js/checkout.js" defer></script>
<script src="https://js.stripe.com/v3/"></script>