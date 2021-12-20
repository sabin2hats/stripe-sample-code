<link rel="stylesheet" href="<?= URLROOT ?>public/css/<?= CHECKOUT_SCRIPT ?>.css" />
<div class="col-md-10 col-md-offset-1">
    <div class="row">

        <!-- Shipping Address -->

        <div class="col-md-4">
            <div class="panel panel-default panel-custom shipping-div">
                <h3>Shipping Address</h3>
                <div class="form-group">
                    <label class="custom-inlabel">Name</label>
                    <input type="text" class="form-control" name="shipName" id="shipName" value="<?= (!empty($data['userDetails']) ? $data['userDetails']->name : '') ?>" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Phone</label>
                    <input type="text" class="form-control" name="shipPhone" id="shipPhone" value="<?= (!empty($data['userDetails']) ? $data['userDetails']->phone : '') ?>" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Address Line1</label>
                    <input type="text" class="form-control" name="shipLine1" id="shipLine1" value="<?= (!empty($data['userDetails']) ? $data['userDetails']->line1 : '') ?>" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Address Line2( optional )</label>
                    <input type="text" class="form-control" name="shipLine2" id="shipLine2" value="<?= (!empty($data['userDetails']) ? $data['userDetails']->line2 : '') ?>">
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Country</label>
                    <select class="form-control" name="shipCountry" id="shipCountry" required onchange="getState(this.value,'shipState')" required>
                        <option value="">Select</option>
                        <?php foreach ($data['countries'] as $row) { ?>
                            <option value="<?= $row['sortname'] ?>" <?= (!empty($data['userDetails']) && ($data['userDetails']->country_code == $row['sortname'])) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                        <?php } ?>

                    </select>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">State</label>
                    <select class="form-control" name="shipState" id="shipState" required>
                        <option value="">Select</option>
                        <?php foreach ($data['states'] as $row) { ?>
                            <option value="<?= $row['name'] ?>" <?= (!empty($data['userDetails']) && ($data['userDetails']->state == $row['name'])) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                        <?php } ?>
                    </select>
                    <span class="valid-address"></span>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="custom-inlabel">City</label>
                        <input type="text" class="form-control" name="shipCity" id="shipCity" value="<?= (!empty($data['userDetails']) ? $data['userDetails']->city : '') ?>" required>
                        <span class="valid-address"></span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-inlabel">PIN/ZIP</label>
                        <input type="text" class="form-control" name="shipZip" id="shipZip" value="<?= (!empty($data['userDetails']) ? $data['userDetails']->zipcode : '') ?>" required>
                        <span class="valid-address"></span>
                    </div>
                </div>
                </form>

            </div>
            <div class="checkbox">
                <label><input type="checkbox" value="" id="copyAddress">Use Shipping Address as Billing Address</label>
            </div>
        </div>
        <!-- Billing Address -->

        <div class="col-md-4">
            <div class="panel panel-default panel-custom billing-div">
                <h3>Billing Address</h3>
                <div class="form-group">
                    <label class="custom-inlabel">Name</label>
                    <input type="text" class="form-control" name="billName" id="billName" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Phone</label>
                    <input type="text" class="form-control" name="billPhone" id="billPhone" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Address Line1</label>
                    <input type="text" class="form-control" name="billLine1" id="billLine1" required>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Address Line2 ( optional )</label>
                    <input type="text" class="form-control" name="billLine2" id="billLine2">
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Country</label>
                    <select class="form-control" name="billCountry" id="billCountry" required onchange="getState(this.value,'billState')" required>
                        <option value="">Select</option>
                        <?php foreach ($data['countries'] as $row) { ?>
                            <option value="<?= $row['sortname'] ?>"><?= $row['name'] ?></option>
                        <?php } ?>

                    </select>
                    <span class="valid-address"></span>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">State</label>
                    <select class="form-control" name="billState" id="billState" required>
                        <option value="">Select</option>
                    </select>
                    <span class="valid-address"></span>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label class="custom-inlabel">City</label>
                        <input type="text" class="form-control" name="billCity" id="billCity" required>
                        <span class="valid-address"></span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label class="custom-inlabel">PIN/ZIP</label>
                        <input type="text" class="form-control" name="billZip" id="billZip" required>
                        <span class="valid-address"></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Display a payment form -->
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-6 form-group">
                    <img src="<?= URLROOT ?>public/images/<?= $data['allPdt']['image'] ?>" alt="Product Image" style="height:250px;width250px;">
                </div>
                <div class="col-md-4">
                    <div class="card">

                        <h3><?= $data['allPdt']['name'] ?></h3>
                        <input type="hidden" id="productId" value="<?= $data['allPdt']['id'] ?>">
                        <p class="price"><?= $data['allPdt']['description'] ?></p>
                        <p class="price">Rs <?= $data['allPdt']['price'] ?></p>
                        <p>

                    </div>
                </div>
            </div>


            <form id="payment-form">
                <div class="form-group">
                    <label class="custom-inlabel">Card Holders Name</label>
                    <input type="text" class="form-control" name="name" id="cstName" required>
                </div>
                <div class="form-group">
                    <label class="custom-inlabel">Email</label>
                    <input type="email" class="form-control" name="email" id="cstEmail" required>
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


<script src="<?= URLROOT ?>public/js/<?= CHECKOUT_SCRIPT ?>.js" defer></script>
<script src="https://js.stripe.com/v3/"></script>