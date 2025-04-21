<?php
include "../../../autoload/loader.php";
$total = 0;
?>
<div class="card-body table-responsive p-0">
    <table class="table table-hover" id="billingTable">
        <thead>
            <tr>
                <thead>
                    <tr>
                        <th style="width: 5%;">S/N</th>
                        <th style="width: 10%;">Quantity</th>
                        <th style="width: 30%;">Product Name</th>
                        <th style="width: 15%;">Model</th>
                        <th style="width: 15%;">Manufacturer</th>
                        <th style="width: 10%;">Price</th>
                        <th style="width: 10%;">Amount</th>
                        <th style="width: 5%;">Delete</th>
                    </tr>
                </thead>

            </tr>
        </thead>
        <tbody>
            <?php if (isset($_SESSION["cart"])): ?>
                <?php foreach ($_SESSION["cart"] as $i => $item):
                    $amount = (int)$item["quantity"] * (int)$item["price"];
                    $total += $amount;
                ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td>
                           
                            <input
                                type="number"
                                class="form-control qty-field"
                                value="<?= $item['quantity'] ?>"
                                data-index="<?= $i ?>"
                                data-name="<?= $item['productname'] ?>"
                                data-model="<?= $item['model'] ?>"
                                data-manufacturer="<?= $item['manufacturer'] ?>"
                                data-price="<?= $item['price'] ?>"
                                oninput="calculateTotals()"
                                onchange="updateQtyFromField(this)">

                        </td>
                        <td><?= $item['productname'] ?></td>
                        <td><?= $item['model'] ?></td>
                        <td><?= $item['manufacturer'] ?></td>
                        <td><?= $item['price'] ?></td>
                        <td class="amount-cell"><?= $amount ?></td>
                        <td><i class="fas fa-trash text-danger" style="cursor:pointer" onclick="deleteItem('<?= $i ?>')"></i></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2">
                    <label for="check">Check Deposit</label>
                    <input type="checkbox" id="check" onclick="checkDeposit()">
                </td>
                <td colspan="2">
                    <label for="add_transport">Add Transport</label>
                    <input type="checkbox" id="add_transport" onchange="toggleTransportField()">
                </td>
                <td colspan="2" style="text-align: right;">Total Amount: ₦</td>
                <td><span id="totalDisplay"><?= number_format($total, 2) ?></span></td>
                <input type="hidden" id="tot" name="tot" value="<?= $total ?>">
            </tr>

            <tr id="depositRow" style="display: none;">
                <td colspan="4"></td>
                <td>Old Deposit</td>
                <td colspan="2">
                    <input type="number" class="form-control" name="old_deposit" id="old_deposit" value="0" onclick="select()" readonly>
                </td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td>Cash</td>
                <td colspan="2">
                    <input type="number" class="form-control" name="cash" id="cash" value="0" onclick="select()" oninput="calculateTotals()">
                </td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td>Transfer</td>
                <td colspan="2">
                    <input type="number" class="form-control" name="transfer" id="transfer" value="0" onclick="select()" oninput="calculateTotals(); showBankSelect()">
                </td>
                <td id="bank_select" style="min-width:150px;"></td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td>POS</td>
                <td colspan="2">
                    <input type="number" class="form-control" name="pos" id="pos" value="0" onclick="select()" oninput="calculateTotals(); showPosSelect()">
                </td>
                <td id="pos_select" style="min-width:150px;"></td>
            </tr>
            <tr id="transportRow" style="display: none;">
                <td colspan="4"></td>
                <td>Transport</td>
                <td colspan="2">
                    <input type="number" class="form-control" name="transport" id="transport" value="0" onclick="select()" oninput="calculateTotals()">
                </td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td>Paid</td>
                <td colspan="2">
                    <input type="number" class="form-control" name="deposit" id="deposit" name="deposit" readonly>
                </td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td>Balance</td>
                <td colspan="2">
                    <input type="number" class="form-control" name="balance" id="balance" name="balance" readonly>
                </td>
            </tr>
        </tfoot>
    </table>
</div>