function selectProduct(productname) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        document.getElementById("modeldev").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "ajax/load_model.php?productname="+productname, true);
    xhttp.send();
    }

    //
    function selectModel(model,productname) {
        
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("manufacturerdev").innerHTML = this.responseText;
        }
      };
      xhttp.open("GET", "ajax/load_manufacturer.php?model="+model+"&productname="+productname, true);
      xhttp.send();
    }

    // function selectManufaturer(manufacturer,model,productname) {
    //     var xhttp = new XMLHttpRequest();
    //     xhttp.onreadystatechange = function() {
    //       if (this.readyState == 4 && this.status == 200) {
    //         document.getElementById("priceDiv").innerHTML = this.responseText;
            
    //       }
    //     };
    //     xhttp.open("GET", "ajax/load_price.php?manufacturer="+manufacturer+"&model="+model+"&productname="+productname, true);
    //     xhttp.send();
    //   }

     
      function loadDoc(productname,model,manufacturer) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("demo").innerHTML = this.responseText;
            
          }
        };
        xhttp.open("GET", "ajax/load_quantity.php?manufacturer="+manufacturer+"&model="+model+"&productname="+productname, true);
        xhttp.send();
      
        }

        function quantity(qty) {
          
          document.getElementById("total").value = eval(document.getElementById("qty").value) * eval(document.getElementById("price").value)
      }
      
      function addIntoCart(){
          
        var productname = document.getElementById("productname").value;
          var model = document.getElementById("model").value;
          var manufacturer = document.getElementById("manufacturer").value;
          var quantity = document.getElementById("qty").value;
          var price = document.getElementById("price").value;
          var total = document.getElementById("total").value;
          var product_id = document.getElementById("product_id").value;
          var qty_db = document.getElementById("qty_db").value;
          var xhttp = new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              if (this.respondText == ""){
                loadBillingProduct();
              }else{
                loadBillingProduct();
              }
            }
        };
        xhttp.open("GET", "ajax/load_cart.php?manufacturer="+manufacturer+"&model="+model+"&productname="+productname+"&quantity="+quantity+"&price="+price+"&total="+total+"&product_id="+product_id+"&qty_db="+qty_db, true);
        xhttp.send(); 
      }

      function loadBillingProduct() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("load_billing").innerHTML = this.responseText;
          }
        };
        xhttp.open("GET", "ajax/load_bill_product.php", true);
        xhttp.send();
    }
    function updateQty(quantity,productname,model,manufacturer,price,amount){
      
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            if (this.respondText == ""){
              loadBillingProduct();
            }else{
              loadBillingProduct();
            }
          }
      };
    
      xhttp.open("GET", "ajax/update_quantity.php?manufacturer="+manufacturer+"&model="+model+"&productname="+productname+"&quantity="+quantity+"&price="+price+"&amount="+amount, true);
      xhttp.send(); 
    }
    function deleteItem(id){

      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          if (this.respondText == ""){
            
            loadBillingProduct();
          }else{
            
            loadBillingProduct();
          }
        }
    };
  
    xhttp.open("GET", "ajax/delete_item.php?id="+id, true);
    xhttp.send(); 
  }

function transferCalc(transfer,cash) {
    
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("paid").innerHTML = this.responseText;
      
    }
  };
  xhttp.open("GET", "ajax/load_deposit.php?cash="+cash+"&transfer="+transfer, true);
  xhttp.send(); 
   
}
function cashCalc(transfer,cash) {
    
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("paid").innerHTML = this.responseText;
      
    }
  };
  xhttp.open("GET", "ajax/load_deposit.php?cash="+cash+"&transfer="+transfer, true);
  xhttp.send(); 
   
}
function balanceCalc(total,deposit) {

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("balance").value = this.responseText;
    }
  };
  xhttp.open("GET", "ajax/load_balance.php?deposit="+deposit+"&total="+total, true);
  xhttp.send(); 
   
}


    loadBillingProduct()
    
      