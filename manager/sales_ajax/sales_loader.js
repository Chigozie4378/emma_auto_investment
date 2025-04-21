 //JQuery Ajax for productname
 function selectProduct(value) {
  $(document).ready(function() {
    var productname = value;
    alert(productname)
    if (productname != "") {
      $.ajax({
        url: "ajax/load_model.php",
        method: "POST",
        data: {
          productname: productname
        },
        success: function(data) {
          $("#modeldev").html(data);
        }
      });
    } else {
      $("#modeldev").css("display", "none");
    }
  });

}

//JQuery Ajax for model
function selectModel(value1, value2) {
  $(document).ready(function() {
    var model = value1;
    var productname = value2;
    if (model && productname != "") {
      $.ajax({
        url: "ajax/load_manufacturer.php",
        method: "POST",
        data: {
          model: model,
          productname: productname
        },
        success: function(data) {
          $("#manufacturerdev").html(data);
        }
      });
    } else {
      $("#manufacturerdev").css("display", "none");
    }
  });
}



//JQuery Ajax for load Qty
function loadDoc(value1, value2, value3) {
  $(document).ready(function() {
    var manufacturer = value3;
    var model = value2;
    var productname = value1;
    if (manufacturer && model && productname != "") {
      $.ajax({
        url: "ajax/load_quantity.php",
        method: "POST",
        data: {
          manufacturer: manufacturer,
          model: model,
          productname: productname
        },
        success: function(data) {
          $("#demo").html(data);
        }
      });
    } else {
      $("#demo").css("display", "none");
    }
  });

}

function quantity(qty) {

  document.getElementById("total").value = eval(document.getElementById("qty").value) * eval(document.getElementById("price").value)
}

function addIntoCart() {

  var productname = document.getElementById("productname").value;
  var model = document.getElementById("model").value;
  var manufacturer = document.getElementById("manufacturer").value;
  var quantity = document.getElementById("qty").value;
  var price = document.getElementById("price").value;
  var total = document.getElementById("total").value;
  var product_id = document.getElementById("product_id").value;
  var qty_db = document.getElementById("qty_db").value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.respondText == "") {
        loadBillingProduct();
      } else {
        loadBillingProduct();
      }
    }
  };
  xhttp.open("GET", "ajax/load_cart.php?manufacturer=" + manufacturer + "&model=" + model + "&productname=" + productname + "&quantity=" + quantity + "&price=" + price + "&total=" + total + "&product_id=" + product_id + "&qty_db=" + qty_db, true);
  xhttp.send();
}

// function loadBillingProduct() {
//   var xhttp = new XMLHttpRequest();
//   xhttp.onreadystatechange = function () {
//     if (this.readyState == 4 && this.status == 200) {
//       document.getElementById("load_billing").innerHTML = this.responseText;
//     }
//   };
//   xhttp.open("GET", "ajax/load_bill_product.php", true);
//   xhttp.send();
// }

//JQuery Ajax for update cart Qty
function loadBillingProduct(){
  $(document).ready(function() {
      $.ajax({
        url: "ajax/load_bill_product.php",
        method: "POST",
        success: function(data) {
          $("#load_billing").html();
        }
      });
    
  });

}

// function updateQty(quantity, productname, model, manufacturer, price, amount) {

//   var xhttp = new XMLHttpRequest();
//   xhttp.onreadystatechange = function () {
//     if (this.readyState == 4 && this.status == 200) {
//       if (this.respondText == "") {
//         loadBillingProduct();
//       } else {
//         loadBillingProduct();
//       }
//     }
//   };

//   xhttp.open("GET", "ajax/update_quantity.php?manufacturer=" + manufacturer + "&model=" + model + "&productname=" + productname + "&quantity=" + quantity + "&price=" + price + "&amount=" + amount, true);
//   xhttp.send();
// }

//JQuery Ajax for update cart Qty
function updateQty(value1, value2, value3, value4, value5, value6) {
  $(document).ready(function() {
    var quantity = value1;
    var productname = value2;
    var model = value3;
    var manufacturer = value4;
    var price = value5;
    var amount = value6;
    if (quantity && productname && model && manufacturer && price && amount != "") {
      $.ajax({
        url: "ajax/update_quantity1.php",
        method: "POST",
        data: {
          quantity:quantity,
          productname: productname,
          model: model,
          manufacturer: manufacturer,
          price:price,
          amount:amount
        },
        success: function(data) {
          loadBillingProduct();
        }
      });
    } else {
      loadBillingProduct();
    }
  });

}

function deleteItem(id) {

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      if (this.respondText == "") {

        loadBillingProduct();
      } else {

        loadBillingProduct();
      }
    }
  };

  xhttp.open("GET", "ajax/delete_item.php?id=" + id, true);
  xhttp.send();
}

function transferCalc(transfer, cash) {

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("paid").innerHTML = this.responseText;

    }
  };
  xhttp.open("GET", "ajax/load_deposit.php?cash=" + cash + "&transfer=" + transfer, true);
  xhttp.send();

}
function cashCalc(transfer, cash) {

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("paid").innerHTML = this.responseText;

    }
  };
  xhttp.open("GET", "ajax/load_deposit.php?cash=" + cash + "&transfer=" + transfer, true);
  xhttp.send();

}
function balanceCalc(total, deposit) {

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("balance").value = this.responseText;
    }
  };
  xhttp.open("GET", "ajax/load_balance.php?deposit=" + deposit + "&total=" + total, true);
  xhttp.send();

}


loadBillingProduct()

