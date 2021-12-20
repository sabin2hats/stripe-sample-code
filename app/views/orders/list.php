<div class="container-fluid">
    <?php if (isset($_GET['status'])) {

        if ($_GET['status'] == "Success") { ?>
            <div class="alert alert-success">
                <strong>Updated Successfully</strong>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger">
                <strong>Some Error Occured</strong>
            </div>
    <?php }
    } ?>
    <h2>All Orders</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Email</th>
                <th>Amount</th>
                <th>Shipping Name</th>
                <th>Shipping Address</th>
                <th>Order Status</th>
                <th>Ordered at</th>
                <th>Risk factor</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['allOrders'] as $key) {
                if ($key['email']) { ?>
                    <tr>

                        <td><?= $key['product_name'] ?></td>
                        <td><?= $key['email'] ?></td>
                        <td><?= $key['order_amount'] ?></td>
                        <td><?= $key['ship_name'] ?></td>
                        <td><?= ($key['ship_line1']) ? ($key['ship_line1'] . ',' . ($key['ship_line2'] ? ($key['ship_line2'] . ',') : '')  . '<br>' . ',' . $key['ship_city'] . ','
                                . $key['ship_state'] . ','  . '<br>' .  $key['country_name'] . ' - ' . $key['ship_zip']) : '' ?></td>
                        <td><?= $key['order_status'] ?></td>
                        <td><?= $key['created_at'] ?></td>
                        <td>
                            <?php if ($key['risk_status']) {
                                $orderRisk = array();
                                $orderRisk['riskStatus'] = $key['risk_status'];
                                $orderRisk['emailStructure'] = $key['email_structure'];
                                $orderRisk['emailDomain'] = $key['email_domain'];
                                $orderRisk['emailRedlisted'] = $key['email_redlisted'];
                                $orderRisk['validShippingAddress'] = $key['valid_shipping_address']; ?>
                                <textarea style="display: none;" id="riskID<?= $key['id'] ?>"><?= json_encode($orderRisk) ?></textarea>
                                <button type="button" class="btn btn-primary" onClick="showRiskStatus('<?= $key['id'] ?>')"> <?= $key['risk_status'] . '%' ?></button>
                            <?php } else { ?>
                                <i class="fa fa-check" style="font-size:36px;color:green"></i>
                            <?php } ?>
                        </td>
                        <td>
                            <form method="post" action="<?= URLROOT ?>orders/editOrder">
                                <input type="hidden" name="orderID" value="<?= $key['id'] ?>">
                                <button type="submit" class="btn btn-success">Edit</button>
                            </form>
                        </td>

                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Order Risk Status <span class="risk-p" id="riskStatus"></span></h4>
                </div>
                <div class="modal-body">
                    <h3 class="modal-title">Risk Factors</h3>
                    <p>E-mail Structure : <span class="risk-p" id="validEmail"></span></p>
                    <p>E-mail Domain : <span class="risk-p" id="validateDomain"></span></p>
                    <p>E-main Redlisted : <span class="risk-p" id="redListedEmail"></span></p>
                    <p>Valid Shipping Address : <span class="risk-p" id="validAddress"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>