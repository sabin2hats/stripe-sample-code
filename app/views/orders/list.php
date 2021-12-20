<div class="container-fluid">
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
                        <td><?= ($key['ship_line1']) ? ($key['ship_line1'] . ',' . $key['ship_line2'] . ',' . '<br>' . ',' . $key['ship_city'] . ','
                                . $key['ship_state'] . ','  . '<br>' .  $key['country_name'] . ' - ' . $key['ship_zip']) : '' ?></td>
                        <td><?= $key['order_status'] ?></td>
                        <td><?= $key['created_at'] ?></td>
                        <td>
                            <?php if ($key['orderRisk']['riskStatus']) { ?>
                                <textarea style="display: none;" id="riskID<?= $key['id'] ?>"><?= json_encode($key['orderRisk']) ?></textarea>
                                <button type="button" class="btn btn-primary" onClick="showRiskStatus('<?= $key['id'] ?>')"> <?= $key['orderRisk']['riskStatus'] ?></button>
                            <?php } ?>
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
                    <h4 class="modal-title">Order Risk Status</h4>
                </div>
                <div class="modal-body">
                    <h3 class="modal-title">Risk Factors</h3>
                    <p class="risk-p" id="validEmail"></p>
                    <p class="risk-p" id="validateDomain"></p>
                    <p class="risk-p" id="redListedEmail"></p>
                    <p class="risk-p" id="validAddress"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</div>