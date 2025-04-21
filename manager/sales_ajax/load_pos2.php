<select class="form-control" name="pos_type" id="pos_type" required>
    <option value="" disabled selected>Select POS</option>
    <option value="Opay"> Opay</option>
    <option value="Monie Point">Monie Point</option>
</select>


<div class="form-inline">
<label for="">Charges</label>&nbsp;&nbsp;
<input class="form-control" type="radio" name="pos_charges" id="pos_charges" onclick="addCharges(this.value,document.getElementById('transfer').value,document.getElementById('pos').value,document.getElementById('cash').value)" value="50"> <label for="">50</label>&nbsp;&nbsp;&nbsp;&nbsp;
<input class="form-control" type="radio" name="pos_charges" id="pos_charges" onclick="addCharges(this.value,document.getElementById('transfer').value,document.getElementById('pos').value,document.getElementById('cash').value)" value="100"> <label for="">100</label>
</div>
