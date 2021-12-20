<link rel="stylesheet" href="<?= URLROOT ?>public/css/<?= CHECKOUT_SCRIPT ?>.css" />
<div class="col-md-10 col-md-offset-1">
    <form method="post" action="<?= URLROOT ?>orders/updateOrder">
        <input type="hidden" name="orderID" value="<?= $data['order']->id ?>">
        <div class="row">

            <!-- Shipping Address -->

            <div class="col-md-4">
                <div class="panel panel-default panel-custom shipping-div">
                    <h3>Shipping Address</h3>
                    <div class="form-group">
                        <label class="custom-inlabel">Name</label>
                        <input type="text" class="form-control" name="shipName" id="shipName" value="<?= (!empty($data['order']) ? $data['order']->ship_name : '') ?>" required>
                        <span class="valid-address"></span>
                    </div>
                    <div class="form-group">
                        <label class="custom-inlabel">Phone</label>
                        <input type="text" class="form-control" name="shipPhone" id="shipPhone" value="<?= (!empty($data['order']) ? $data['order']->ship_phone : '') ?>" required>
                        <span class="valid-address"></span>
                    </div>
                    <div class="form-group">
                        <label class="custom-inlabel">Address Line1</label>
                        <input type="text" class="form-control" name="shipLine1" id="shipLine1" value="<?= (!empty($data['order']) ? $data['order']->ship_line1 : '') ?>" required>
                        <span class="valid-address"></span>
                    </div>
                    <!-- <div class="form-group">
                        <label class="custom-inlabel">Address Line2( optional )</label>
                        <input type="text" class="form-control" name="shipLine2" id="shipLine2" value="<?= (!empty($data['order']) ? $data['order']->ship_line2 : '') ?>">
                        <span class="valid-address"></span>
                    </div> -->
                    <div class="form-group">
                        <label class="custom-inlabel">Country</label>
                        <select class="form-control" name="shipCountry" id="shipCountry" required onchange="getState(this.value,'shipState')" required>
                            <option value="">Select</option>
                            <?php foreach ($data['countries'] as $row) { ?>
                                <option value="<?= $row['sortname'] ?>" <?= (!empty($data['order']) && ($data['order']->ship_country == $row['sortname'])) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                            <?php } ?>

                        </select>
                        <span class="valid-address"></span>
                    </div>
                    <div class="form-group">
                        <label class="custom-inlabel">State</label>
                        <select class="form-control" name="shipState" id="shipState" required>
                            <option value="">Select</option>
                            <?php foreach ($data['shipStates'] as $row) { ?>
                                <option value="<?= $row['name'] ?>" <?= (!empty($data['order']) && ($data['order']->ship_state == $row['name'])) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="valid-address"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="custom-inlabel">City</label>
                            <input type="text" class="form-control" name="shipCity" id="shipCity" value="<?= (!empty($data['order']) ? $data['order']->ship_city : '') ?>" required>
                            <span class="valid-address"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="custom-inlabel">PIN/ZIP</label>
                            <input type="text" class="form-control" name="shipZip" id="shipZip" value="<?= (!empty($data['order']) ? $data['order']->ship_zip : '') ?>" required>
                            <span class="valid-address"></span>
                        </div>
                    </div>


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
                        <input type="text" class="form-control" name="billName" id="billName" value="<?= (!empty($data['order']) ? $data['order']->bill_name : '') ?>" required>
                        <span class="valid-address"></span>
                    </div>
                    <div class="form-group">
                        <label class="custom-inlabel">Phone</label>
                        <input type="text" class="form-control" name="billPhone" id="billPhone" value="<?= (!empty($data['order']) ? $data['order']->bill_phone : '') ?>" required>
                        <span class="valid-address"></span>
                    </div>
                    <div class="form-group">
                        <label class="custom-inlabel">Address Line1</label>
                        <input type="text" class="form-control" name="billLine1" id="billLine1" value="<?= (!empty($data['order']) ? $data['order']->bill_line1 : '') ?>" required>
                        <span class="valid-address"></span>
                    </div>
                    <!-- <div class="form-group">
                        <label class="custom-inlabel">Address Line2 ( optional )</label>
                        <input type="text" class="form-control" name="billLine2" id="billLine2" value="<?= (!empty($data['order']) ? $data['order']->bill_line2 : '') ?>">
                        <span class="valid-address"></span>
                    </div> -->
                    <div class="form-group">
                        <label class="custom-inlabel">Country</label>
                        <select class="form-control" name="billCountry" id="billCountry" required onchange="getState(this.value,'billState')" required>
                            <option value="">Select</option>
                            <?php foreach ($data['countries'] as $row) { ?>
                                <option value="<?= $row['sortname'] ?>" <?= (!empty($data['order']) && ($data['order']->bill_country == $row['sortname'])) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                            <?php } ?>

                        </select>
                        <span class="valid-address"></span>
                    </div>
                    <div class="form-group">
                        <label class="custom-inlabel">State</label>
                        <select class="form-control" name="billState" id="billState" required>
                            <?php foreach ($data['billStates'] as $row) { ?>
                                <option value="<?= $row['name'] ?>" <?= (!empty($data['order']) && ($data['order']->bill_state == $row['name'])) ? 'selected' : '' ?>><?= $row['name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="valid-address"></span>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="custom-inlabel">City</label>
                            <input type="text" class="form-control" name="billCity" id="billCity" value="<?= (!empty($data['order']) ? $data['order']->bill_city : '') ?>" required>
                            <span class="valid-address"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="custom-inlabel">PIN/ZIP</label>
                            <input type="text" class="form-control" name="billZip" id="billZip" value="<?= (!empty($data['order']) ? $data['order']->bill_zip : '') ?>" required>
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
                <div class="panel panel-default panel-custom">
                    <div class="form-group">
                        <label class="custom-inlabel">E-mail</label>
                        <input type="text" class="form-control" name="email" id="email" required value="<?= $data['order']->email ?>">
                        <span class="valid-address"></span>
                    </div>
                    <div class="form-group">
                        <label class="custom-inlabel">Order Status</label>
                        <select class="form-control" name="orderStatus" id="orderStatus" required>
                            <option value="">Select</option>
                            <option value="Pending" <?= ($data['order']->order_status == "Pending") ? 'selected' : '' ?>>Pending</option>
                            <option value="Success" <?= ($data['order']->order_status == "Success") ? 'selected' : '' ?>>Success</option>
                            <option value="Failed" <?= ($data['order']->order_status == "Failed") ? 'selected' : '' ?>>Failed</option>
                        </select>
                        <span class="valid-address"></span>
                    </div>
                    <div class="form-group">
                        <label class="custom-inlabel">Amount</label>
                        <input type="text" class="form-control" name="amount" id="amount" required value="<?= $data['order']->order_amount ?>">
                        <span class="valid-address"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>