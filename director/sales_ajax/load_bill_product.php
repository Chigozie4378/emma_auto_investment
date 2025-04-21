<?php
session_start();
?>
<div class="card-body table-responsive p-0">
    <table class="table table-hover">
        <tr>
            <th>S/N</th>
            <th>Quantity</th>
            <th>Product Name</th>
            <th>Model</th>
            <th>Manufacturer</th>
            <th>Price</th>
            <th>Amount</th>
            <th>Delete</th>
        </tr>
        <?php
        $id = 1;
        $qty_found = 0;
        $max = 0;
        $quantity_session = 0;
        $total = 0;

        if (isset($_SESSION["cart"])) {
            $max = sizeof($_SESSION['cart']);
        }

        for ($i = 0; $i < $max; $i++) {
            $productname_session = "";
            $model_session = "";
            $manufacturer_session = "";

            if (isset($_SESSION['cart'][$i])) {
                foreach ($_SESSION["cart"][$i] as $key => $val) {
                    if ($key == "productname") {
                        $productname_session = $val;
                    } elseif ($key == "model") {
                        $model_session = $val;
                    } elseif ($key == "manufacturer") {
                        $manufacturer_session = $val;
                    } elseif ($key == "quantity") {
                        $quantity_session = $val;
                    } elseif ($key == "price") {
                        $price_session = $val;
                    }
                }

                $total = $total + (int)$quantity_session * (int)$price_session;
                $amount = (int)$quantity_session * (int)$price_session;
                if (!empty($productname_session)) {
        ?>
                    <tr>
                        <td><?php echo $id++ ?></td>
                        <td style="width:10%;text-align:center"> <input class="form-control" style="width:100%;box-sizing:border-box" type="number" id="qty<?php echo $i ?>" value="<?php echo $quantity_session ?>"><span style="cursor:pointer" onclick="updateQty(document.getElementById('qty<?php echo $i ?>').value,'<?php echo $productname_session ?>','<?php echo $model_session ?>','<?php echo $manufacturer_session ?>','<?php echo $price_session ?>','<?php echo $amount ?>')" class="badge badge-pill badge-info">Refresh</span></td>
                        <td><?php echo $productname_session ?></td>
                        <td><?php echo $model_session ?></td>
                        <td><?php echo $manufacturer_session ?></td>
                        <td><?php echo $price_session ?></td>
                        <td><?php echo $amount ?></td>
                        <td><i style="cursor:pointer; color:red;" onclick="deleteItem('<?php echo $i ?>')" class="fas fa-trash"></i>
                        </td>
                    </tr>

        <?php
                }
            }
        }
        ?>

        <tr>
            <td colspan="2"><label for="check">Check Deposit </label> <input type="checkbox" name="" id="check" onpointerout="cashCalc(this.value,document.getElementById('pos').value,document.getElementById('transfer').value,document.getElementById('tot').value,document.getElementById('old_deposit').value)" onclick="checkDeposit(document.getElementById('title').value,document.getElementById('customer_name').value,document.getElementById('address').value)"></td>
            <td colspan="2"><label for="check">Add Transport </label> <input type="checkbox" name="" id="add_transport" onclick="addTransport()"></td>
            <td colspan="2">
                <p style="float:right;font-weight:bold">Total Amount: # </p>
            </td>
            <td>
                <p style="font-weight:bold"><span id="total"><?php echo  number_format($total, 2) ?></span></p>
            </td>
            <input type="hidden" name="tot" id="tot" value="<?php echo $total ?>">
            <td></td>
            <input type="hidden" name="pos_charges" id="pos_charges" value="0">
        </tr>
        <tr id="deposit_amount">
            <td style="display: none;" colspan="1"></td>
            <td style="display: none;">Deposit Amount</td>
            <td style="width:15%;text-align:center;display: none;"><input class="form-control" style="width:100%;box-sizing:border-box" name="old_deposit" id="old_deposit" value="0" required></td>
            <td style="width:15%;text-align:center;display: none;"><input class="form-control" style="width:100%;box-sizing:border-box" name="pos_charges" id="pos_charges" value="0" required></td>
            

        </tr>


        <tr>
            <td colspan="4"></td>
            <td>Cash</td>
            <td colspan="2" style="width:15%;text-align:center"><input class="form-control" style="width:100%;box-sizing:border-box" onkeyup="cashCalc(this.value,document.getElementById('pos').value,document.getElementById('transfer').value,document.getElementById('tot').value,document.getElementById('old_deposit').value,document.getElementById('transport').value,document.getElementById('pos_charges').value)" onclick="this.select()" type="text" name="cash" id="cash" value="0" required></td>
            <td></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td>Transfer</td>
            <td colspan="2" style="width:15%;text-align:center"><input onkeydown="selectBank()" class="form-control" style="width:100%;box-sizing:border-box" onkeyup="transferCalc(this.value,document.getElementById('pos').value,document.getElementById('cash').value,document.getElementById('tot').value,document.getElementById('old_deposit').value,document.getElementById('transport').value,document.getElementById('pos_charges').value)" onclick="this.select()" type="text" name="transfer" id="transfer" value="0" required></td>
            <td id="select_bank" style="width:20%;text-align:center"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td>POS</td>
            <td colspan="2" style="width:15%;text-align:center"><input onkeydown="selectPos()" class="form-control" style="width:100%;box-sizing:border-box" onkeyup="posCalc(this.value,document.getElementById('transfer').value,document.getElementById('cash').value,document.getElementById('tot').value,document.getElementById('old_deposit').value,document.getElementById('transport').value,document.getElementById('pos_charges').value)" onclick="this.select()" type="text" name="pos" id="pos" value="0" required></td>
            <td id="select_pos" style="width:20%;text-align:center"></td>
            <!-- <td id="pos_charges">
            
            </td> -->
        </tr>
        <tr id="transportDiv">
            <td style="display: none;" colspan="1"></td>
            <td style="display: none;">Transport</td>
            <td style="width:15%;text-align:center;display: none;"><input class="form-control" style="width:100%;box-sizing:border-box" name="transport" id="transport" value="0" required></td>

        </tr>
        <tbody id="depositBal">

            <tr>
                <td colspan="4"></td>
                <td>Paid</td>
                <td colspan="2" style="width:15%;text-align:center"><input class="form-control" name="deposit" id="deposit" style="width:100%;box-sizing:border-box" type="number" readonly value="0"></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td>Balance</td>
                <td colspan="2" style="width:15%;text-align:center"><input class="form-control" style="width:100%;box-sizing:border-box;" type="number" name="balance" id="balance" value="<?php echo $total ?>" readonly></td>
                <td></td>
            </tr>
        </tbody>

    </table>
</div>