<?php
include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");
// include_once(DIR_URL."cls/clsSupplier.php");


// Initialize class (or retrieve from session)
//$clsSupplier = new ClassSupplier();

// $clsSupplier = new ClassSupplier();


$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$userBranchState = $_SESSION['branch_state'];
$field2 =  "";


if (isset($_POST['al_customer_name'])) {
  $customerName = $_POST['al_customer_name'];
  $qry_search = "SELECT * FROM customers WHERE customer_name='$customerName' && branch_id = '$userBranchId'";
  $search_res = $con->query($qry_search);
  $customerDa = $search_res->fetch_assoc();
  if ($search_res->num_rows == 0) {
    $qry = "INSERT INTO customers (customer_name, state, user_id, branch_id) values('$customerName','$userBranchState',$userId,$userBranchId)";
    $con->query($qry);
    $qry_search = "SELECT * FROM customers WHERE customer_name='$customerName' && branch_id = '$userBranchId'";
    $search_res = $con->query($qry_search);
    $customerDa = $search_res->fetch_assoc();
    echo $customerDa['id'];

    exit;
  } else {
    echo $customerDa['id'];

    exit;
  }
} elseif (isset($_POST['al_customer_details'])) {
  $customerData = json_decode($_POST['al_customer_details']);

  $queryUpdateCustomerMobile = "update customers set mobile = '$customerData[1]'
  where id='$customerData[0]' && branch_id = '$userBranchId'";
  $resultUpdateCustomerMobile = $con->query($queryUpdateCustomerMobile);
  if ($resultUpdateCustomerMobile) {

    echo $customerData[0];
    exit;
  }
}


if (isset($_POST['al_product'])) {


  /* This block of code is handling form data submitted via POST method. Here's what each line is
    doing: */
  $product = htmlspecialchars($_POST['al_product']);
  $qry_search = "SELECT * FROM products WHERE product_name='$product' && branch_id = '$userBranchId'";
  $search_res = $con->query($qry_search);
  if ($search_res->num_rows == 0) {
    $qry = "INSERT INTO products (product_name, user_id, branch_id) values('$product',$userId,$userBranchId)";
    $con->query($qry);
  }
} elseif (isset($_POST['al_brand'])) {
  $brand = htmlspecialchars($_POST['al_brand']);
  $qry_search = "SELECT * FROM brands WHERE brand_name='$brand' && branch_id = '$userBranchId'";
  $search_res = $con->query($qry_search);
  if ($search_res->num_rows == 0) {
    $qry = "INSERT INTO brands (brand_name, user_id, branch_id) values('$brand',$userId,$userBranchId)";
    $con->query($qry);
  }
} elseif (isset($_POST['al_design'])) {
  $design = htmlspecialchars($_POST['al_design']);
  $qry_search = "SELECT * FROM designs WHERE design_name='$design' && branch_id = '$userBranchId'";
  $search_res = $con->query($qry_search);
  if ($search_res->num_rows == 0) {
    $qry = "INSERT INTO designs (design_name, user_id, branch_id) values('$design',$userId,$userBranchId)";
    $con->query($qry);
  }
} elseif (isset($_POST['al_color'])) {
  $color = htmlspecialchars($_POST['al_color']);
  $qry_search = "SELECT * FROM colors WHERE color_name='$color' && branch_id = '$userBranchId'";
  $search_res = $con->query($qry_search);
  if ($search_res->num_rows == 0) {
    $qry = "INSERT INTO colors (color_name, user_id, branch_id) values('$color',$userId,$userBranchId)";
    $con->query($qry);
  }
} elseif (isset($_POST['al_batch'])) {
  $batch = htmlspecialchars($_POST['al_batch']);
  $qry_search = "SELECT * FROM batches WHERE batch_name='$batch' && branch_id = '$userBranchId'";
  $search_res = $con->query($qry_search);
  if ($search_res->num_rows == 0) {
    $qry = "INSERT INTO batches (batch_name, user_id, branch_id) values('$batch',$userId,$userBranchId)";
    $con->query($qry);
  }
} elseif (isset($_POST['al_category'])) {
  $category = htmlspecialchars($_POST['al_category']);
  $qry_search = "SELECT * FROM categories WHERE category_name='$category' && branch_id = '$userBranchId'";
  $search_res = $con->query($qry_search);
  if ($search_res->num_rows == 0) {
    $qry = "INSERT INTO categories (category_name, user_id, branch_id) values('$category',$userId,$userBranchId)";
    $con->query($qry);
  }
} elseif (isset($_POST['al_hsnCode'])) {
  $hsnCode = htmlspecialchars($_POST['al_hsnCode']);
  $qry_search = "SELECT * FROM hsn_codes WHERE hsn_code='$hsnCode' && branch_id = '$userBranchId'";
  $search_res = $con->query($qry_search);
  if ($search_res->num_rows == 0) {
    $qry = "INSERT INTO hsn_codes (hsn_code, user_id, branch_id) values('$hsnCode',$userId,$userBranchId)";
    $con->query($qry);
  }
} elseif (isset($_POST['al_tax'])) {
  // $tax = htmlspecialchars($_POST['al_tax']);
  // $qry_search = "SELECT * FROM taxes WHERE tax_code='$tax' && branch_id = '$userBranchId'";
  // $search_res = $con->query($qry_search);
  // if($search_res->num_rows==0){
  //     $qry = "INSERT INTO taxes (tax_code, user_id, branch_id) values('$tax',$userId,$userBranchId)";
  //     $con->query($qry);

  // }

} elseif (isset($_POST['al_size'])) {
  $size = htmlspecialchars($_POST['al_size']);
  $qry_search = "SELECT * FROM sizes WHERE size_name='$size' && branch_id = '$userBranchId'";
  $search_res = $con->query($qry_search);
  if ($search_res->num_rows == 0) {
    $qry = "INSERT INTO sizes (size_name, user_id, branch_id) values('$size',$userId,$userBranchId)";
    $con->query($qry);
  }
} elseif (isset($_POST['al_mrp'])) {
  $mrp = htmlspecialchars($_POST['al_mrp']);
  $qry_search = "SELECT * FROM mrps WHERE mrp='$mrp' && branch_id = '$userBranchId'";
  $search_res = $con->query($qry_search);
  if ($search_res->num_rows == 0) {
    $qry = "INSERT INTO mrps (mrp, user_id, branch_id) values('$mrp',$userId,$userBranchId)";
    $con->query($qry);
  }
} elseif (isset($_POST['al_sellingPrice'])) {
} elseif (isset($_POST['al_rate'])) {
} elseif (isset($_POST['al_qty'])) {
} elseif (isset($_POST['al_amount'])) {
}


?>

<?php

if (isset($_POST['lb_supplier_name'])) {

  $supplierName = $_POST['lb_supplier_name'];

  $querySearchSuppInfo = "select*from suppliers where supplier_name like '%$supplierName%' && branch_id = '$userBranchId' order by supplier_name";
  $resultSearchSuppInfo = $con->query($querySearchSuppInfo);

  // while($suppData = $resultSearchSuppInfo->fetch_assoc()){


  // }


}




if (isset($_POST['get_item_f4'])) {

  $search = $_POST['get_item_f4'];
  $querySearchItem = "select*from items where (product_name like '%$search%' || brand_name like '%$search%' || design_name like '%$search%' || color_name like '%$search%') && branch_id = '$userBranchId' order by product_name, brand_name, design_name";

  $resultSearchItem = $con->query($querySearchItem);
}

if (isset($_POST['lb_qry_product'])) {
  $qry_search = $_POST['lb_qry_product'];
  $res_search = $con->query($qry_search);
  $category = "product";
  $fieldName = "product_name";
  $navigate_text_box = "brand";

  // print_r($res_pro_search);
} elseif (isset($_POST['lb_qry_brand'])) {
  $qry_search = $_POST['lb_qry_brand'];
  $res_search = $con->query($qry_search);
  $category = "brand";
  $fieldName = "brand_name";
  $navigate_text_box = "design";
} elseif (isset($_POST['lb_qry_design'])) {
  $qry_search = $_POST['lb_qry_design'];
  $res_search = $con->query($qry_search);
  $category = "design";
  $fieldName = "design_name";
  $navigate_text_box = "color";
} elseif (isset($_POST['lb_qry_color'])) {
  $qry_search = $_POST['lb_qry_color'];
  $res_search = $con->query($qry_search);
  $category = "color";
  $fieldName = "color_name";
  $navigate_text_box = "batch";
} elseif (isset($_POST['lb_qry_batch'])) {
  $qry_search = $_POST['lb_qry_batch'];
  $res_search = $con->query($qry_search);
  $category = "batch";
  $fieldName = "batch_name";
  $navigate_text_box = "category";
} elseif (isset($_POST['lb_qry_category'])) {
  $qry_search = $_POST['lb_qry_category'];
  $res_search = $con->query($qry_search);
  $category = "category";
  $fieldName = "category_name";
  $navigate_text_box = "hsnCode";
} elseif (isset($_POST['lb_qry_hsnCode'])) {
  $qry_search = $_POST['lb_qry_hsnCode'];
  $res_search = $con->query($qry_search);
  $category = "hsnCode";
  $fieldName = "hsn_code";
  $navigate_text_box = "tax";
} elseif (isset($_POST['lb_qry_tax'])) {
  $qry_search = $_POST['lb_qry_tax'];
  $res_search = $con->query($qry_search);
  $category = "tax";
  $fieldName = "tax_code";
  $field2 = "tax_description";
  $navigate_text_box = "size";
} elseif (isset($_POST['lb_qry_size'])) {
  $qry_search = $_POST['lb_qry_size'];
  $res_search = $con->query($qry_search);
  $category = "size";
  $fieldName = "size_name";
  $navigate_text_box = "mrp";
} elseif (isset($_POST['lb_qry_mrp'])) {
  $qry_search = $_POST['lb_qry_mrp'];
  $res_search = $con->query($qry_search);
  $category = "mrp";
  $fieldName = "mrp";
  $navigate_text_box = "sellingPrice";
}

if (isset($_POST['lb_row_index'])) {
  $selected_row_index = $_POST['lb_row_index'];
  // echo $selected_row_index;

}
if (!isset($_SESSION['purchase_item'])) {
  $_SESSION['purchase_item'] = [];
}
if (
  isset($_POST['lb_product_value']) && isset($_POST['lb_brand_value']) && isset($_POST['lb_design_value'])
  && isset($_POST['lb_mrp_value']) && isset($_POST['lb_cost_value']) && isset($_POST['lb_qty_value'])
  && isset($_POST['lb_value_value'])
) {
  if ($_POST) {
    $_SESSION['purchase_item'][] = $_POST;
  }


  // Display all stored data
  // echo "<h1>All Submitted Data:</h1>";
  // foreach ($_SESSION['purchase_item'] as $entry) {
  //     echo "Product: " . $entry['lb_product_value'] . "<br>";
  //     echo "Brand: " . $entry['lb_brand_value'] . "<br>";
  //     echo "Design: " . $entry['lb_design_value'] . "<br>";
  //     echo "MRP: " . $entry['lb_mrp_value'] . "<br>";
  //     echo "Cost: " . $entry['lb_cost_value'] . "<br>";
  //     echo "Quantity: " . $entry['lb_qty_value'] . "<br>";
  //     echo "Value: " . $entry['lb_value_value'] . "<br>";
  //     echo "<hr>";
  // }
  // echo "<br>";
  // echo "<h1>";
  // echo "product = ".$lb_product_value;
  // echo "brand   = ".$lb_brand_value;
  // echo "design  = ".$lb_design_value;
  // echo "mrp     = ".$lb_mrp_value;
  // echo "cost    = ".$lb_cost_value;
  // echo "qty     = ".$lb_qty_value;
  // echo "value   = ".$lb_value_value;
  // echo "</h1>";


}


// if(isset($_POST['lb_f2_row_index'])){
//   $row_index = $_POST['lb_f2_row_index'];
//   echo "number of row created = ".$row_index;
//   // $_SESSION['row_index'] = $row_index;



// }

if (isset($res_search)) {




?>
  <style>
    #myform {
      color: white;

      /* background-color: #FF3CAC;
                background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%); */

      position: fixed;
      top: 500px;
      left: 500px;
    }
  </style>

  <html>

  <body>

    <div id="message">
    </div>



    <form action=""
      style="position:absolute;top:510px;z-index:1000;width:200px;max-height:200px;overflow-x:auto;overflow-y:auto;"
      id="myform" onkeypress="">
      <table class="table" id="selection_table" style="font-size:11px;">
        <thead>
          <tr>
            <th style="position:sticky;z-index:1;top:0;background-color:#2B86C5">
              <button class="btn-close" type="button" onclick="
                  let row_index =localStorage.getItem('row_index');
                  document.getElementById('myform').style.display='none';
                  document.getElementById('<?php echo htmlspecialchars($category) ?>_'+row_index).focus();
                  ">
              </button>
              <?php echo $category; ?>
            </th>
            <?php if ($field2 != "") { ?>
              <th style="position:sticky;z-index:1;top:0;background-color:#2B86C5">
                <?php echo $field2; ?>
              </th>
            <?php } ?>
          </tr>
        </thead>
        <tbody class="table-secondary" id="table-body">

          <?php
          if ($res_search) {
            $popUpRowCount = 1;
            while ($row = $res_search->fetch_assoc()) {
              //   echo '<tr onclick=alert_message()><td>' . htmlspecialchars($row['name']) . '</td></tr>';


          ?>

              <tr onclick="
                  
                    let rowIndex  = parseInt(localStorage.getItem('row_index'),10) || 0;
                    let row_deleted = parseInt(localStorage.getItem('row_deleted'));
                    
                    
                      // if(row_deleted != 1)
                      // {
                        document.getElementById('<?php echo htmlspecialchars(string: $category); ?>_'+rowIndex).value = '<?php echo htmlspecialchars($row[$fieldName]); ?>'
                        document.getElementById('myform').style.display = 'none';
                        document.getElementById('<?php echo htmlspecialchars($navigate_text_box); ?>_'+rowIndex).focus();
                        document.getElementById('<?php echo htmlspecialchars($navigate_text_box); ?>_'+rowIndex).select();      
                        
                      // }else if(row_deleted == 1){
                      //   let rowindex = rowIndex+1;
                      //   document.getElementById('message').innerHTML ='deleted row'+'<?php echo htmlspecialchars($category) ?>'+rowindex;
                      //   document.getElementById('<?php echo htmlspecialchars(string: $category); ?>_'+rowindex).value = '<?php echo htmlspecialchars($row[$fieldName]); ?>'
                      //   // document.getElementById('myform').style.display = 'none';
                      //   document.getElementById('<?php echo htmlspecialchars($navigate_text_box); ?>_'+rowindex).focus();
                      //   document.getElementById('<?php echo htmlspecialchars($navigate_text_box); ?>_'+rowindex).select();      
                      
                      // }
                
                        
                  
                  
                " style="font-size:15px">


                <td style="color:white;
                    background-color: #FF3CAC;
                    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
                  <?php echo $row[$fieldName]; ?></td>
                <?php if ($field2 != "") { ?>
                  <td>
                    <?php echo $row[$field2]; ?>
                  </td>
                <?php } ?>
              </tr>
            <?php
            }
            ?>

        </tbody>
      </table>
    </form>




  <?php
          }
        } elseif (isset($resultSearchSuppInfo)) {




  ?>
  <style>
    #supplierInformationTable {
      color: white;
      background-color: #FF3CAC;
      background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    }

    .supplierInputField {
      color: white;
      background: none;
      border: none;

    }

    .supplierNameField {
      color: white;
      background: none;
      border: none;
      outline: none;
    }

    .supplierInputField:focus {

      background-color: #FF3CAC;
      outline: none;
    }
  </style>
  <!-- Supplier Information Start -->



  <form
    style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
    <div style="max-height: 300px; overflow-y: auto; width: 720px;">
      <table id="supplierInformationTable" class="table"
        style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px;">
        <thead>
          <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
            <th><button class="btn-close" type="button" onclick="
            document.getElementById('supplierInformationTable').style.display = 'none';
          " style="background-color:#FF3CAC;"></button></th>
            <th style="width: 25px;"> </th>
            <th style="width: 60px;">Id</th>
            <th style="width: 150px;">Supplier Name</th>
            <th style="width: 120px;">Address1</th>
            <th style="width: 120px;">Address2</th>
            <th style="width: 180px;">Address3</th>
            <th style="width: 100px;">Locality</th>
            <th style="width: 100px;">City</th>
            <th style="width: 80px;">PinCode</th>
            <th style="width: 100px;">State</th>
            <th style="width: 100px;">Landline</th>
            <th style="width: 100px;">Mobile</th>
            <th style="width: 150px;">Email</th>
            <th style="width: 150px;">GST No.</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1;
          while ($suppData = $resultSearchSuppInfo->fetch_assoc()) { ?>
            <tr style="font-size: 12px;" onclick="
             
             
                     let supplierState = '<?php echo htmlspecialchars($suppData['state']); ?>';
                    // localStorage.setItem('supplier_state',supplierState);
           
        // Send supplier name to PHP using AJAX
        // fetch('supplierSession.php', {
        //     method: 'POST',
        //     headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        //     body: 'supplierState=' + encodeURIComponent(supplierState)
        // }).then(response => response.text())
        // .then(data => console.log(data)); // Debugging output

              let companyState = '<?php echo $_SESSION['company_state']; ?>';
              // let supplierState1 = localStorage.getItem('supplier_state');


 var cgstAmount = document.getElementById('cgstAmount');
 var sgstAmount = document.getElementById('sgstAmount');
 var igstAmount = document.getElementById('igstAmount');
 if (cgstAmount && sgstAmount && igstAmount) {
     if (supplierState === companyState) {
        //  cgstAmount.setAttribute('readonly','false');
        //  sgstAmount.setAttribute('readonly','false');
        
        //  igstAmount.setAttribute('readonly','true');
         cgstAmount.disabled = false;
         sgstAmount.disabled = false;
         igstAmount.disabled = true;
         igstAmount.value = 0;
         cgstAmount.style.background = 'none';
         sgstAmount.style.background = 'none';
         igstAmount.style.background = 'gainsboro';
     } else {
         cgstAmount.disabled = true;
         sgstAmount.disabled = true;
         igstAmount.disabled = false;
          // cgstAmount.setAttribute('readonly','true');
          // sgstAmount.setAttribute('readonly','true');
          // igstAmount.removeAttribute('readonly','true');
          
         cgstAmount.value = 0;
         sgstAmount.value = 0;
         cgstAmount.style.background = 'gainsboro';
         sgstAmount.style.background = 'gainsboro';
         igstAmount.style.background = 'none';
     }
 } else {
     console.error('Error: One or more elements not found in the DOM.');
 }
 
           
             
            
             document.getElementById('supplierName').value = '<?php echo htmlspecialchars($suppData['supplier_name']); ?>'
             document.getElementById('supplierId').value = '<?php echo htmlspecialchars($suppData['id']); ?>'
             document.getElementById('supplierInformationTable').style.display='none';
             document.getElementById('design_1').focus();
             document.getElementById('design_1').select();
             
             
             ">
              <td> <?php echo " "; ?> </td>
              <td> <?php echo " "; ?> </td>
              <td><input type="text" class="supplierInputField" value="<?php echo $suppData['id']; ?>"
                  readonly></td>
              <td><input type="text" class="supplierInputField supplierNameField"
                  id="supplierNameField_<?php echo $i; ?>"
                  value="<?php echo $suppData['supplier_name']; ?>"></td>
              <td><input type="text" class="supplierInputField" value="<?php echo $suppData['address1']; ?>"
                  readonly></td>
              <td><input type="text" class="supplierInputField" value="<?php echo $suppData['address2']; ?>"
                  readonly></td>
              <td><input type="text" class="supplierInputField" value="<?php echo $suppData['address3']; ?>"
                  readonly></td>
              <td><input type="text" class="supplierInputField" value="<?php echo $suppData['locality']; ?>"
                  readonly></td>
              <td><input type="text" class="supplierInputField" value="<?php echo $suppData['city']; ?>"
                  readonly></td>
              <td><input type="text" class="supplierInputField" value="<?php echo $suppData['pincode']; ?>"
                  readonly></td>
              <td><input type="text" class="supplierInputField" value="<?php echo $suppData['state']; ?>"
                  readonly></td>
              <td><input type="text" class="supplierInputField" value="<?php echo $suppData['landline']; ?>"
                  readonly></td>
              <td><input type="text" class="supplierInputField" value="<?php echo $suppData['mobile']; ?>"
                  readonly></td>
              <td><input type="text" class="supplierInputField" value="<?php echo $suppData['email']; ?>"
                  readonly></td>
              <td><input type="text" class="supplierInputField" value="<?php echo $suppData['gst_no']; ?>"
                  readonly></td>
            </tr>

          <?php $i++;
          }

          ?>
        </tbody>
      </table>
    </div>
  </form>






  <!-- Supplier Information End -->


<?php } elseif (isset($resultSearchItem)) {


?>
  <style>
    #itemInformationTable {
      color: white;
      background-color: #FF3CAC;
      background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
      font-size: 11px
    }
  </style>
  <form
    style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
    <div style="max-height: 300px; overflow-y: auto; width: 750px;">
      <table id="itemInformationTable" class="table"
        style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px;">
        <thead>
          <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
            <th><button class="btn-close" type="button" onclick="
            document.getElementById('itemInformationTable').style.display = 'none';
            
          " style="background-color:#FF3CAC;"></button></th>
            <th style="width:30px;"></th>

            <th style="width:60px;">Item ID</th>
            <th style="width:160px">Product</th>
            <th style="width:150px">Brand</th>
            <th style="width:210px">Design</th>
            <th style="width:150px">Color</th>
            <th style="width:150px">Batch</th>
            <th style="width:150px">Category</th>
            <th style="width:80px">HSN Code</th>
            <th style="width:50px">Tax</th>
            <th style="width:50px">Size</th>
            <th style="width:100px">Mrp</th>
            <th style="width:100px">Selling Price</th>
            <th style="width:100px">Rate</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1;
          while ($itemData = $resultSearchItem->fetch_assoc()) { ?>
            <tr onclick="
                  let i =localStorage.getItem('row_index');
                  document.getElementById('product_'+i).value ='<?php echo htmlspecialchars($itemData['product_name']); ?>';
                  document.getElementById('brand_'+i).value ='<?php echo htmlspecialchars($itemData['brand_name']); ?>';
                  document.getElementById('design_'+i).value ='<?php echo htmlspecialchars($itemData['design_name']); ?>';
                  document.getElementById('color_'+i).value ='<?php echo htmlspecialchars($itemData['color_name']); ?>';
                  document.getElementById('batch_'+i).value ='<?php echo htmlspecialchars($itemData['batch_name']); ?>';
                  document.getElementById('category_'+i).value ='<?php echo htmlspecialchars($itemData['category_name']); ?>';
                  document.getElementById('hsnCode_'+i).value ='<?php echo htmlspecialchars($itemData['hsn_code']); ?>';
                  document.getElementById('tax_'+i).value ='<?php echo htmlspecialchars($itemData['tax_code']); ?>';
                  document.getElementById('size_'+i).value ='<?php echo htmlspecialchars($itemData['size_name']); ?>';
                  document.getElementById('mrp_'+i).value ='<?php echo htmlspecialchars($itemData['mrp']); ?>';
                  document.getElementById('sellingPrice_'+i).value ='<?php echo htmlspecialchars($itemData['selling_price']); ?>';
                  document.getElementById('rate_'+i).value ='<?php echo htmlspecialchars($itemData['rate']); ?>';
                  document.getElementById('id_'+i).value ='<?php echo htmlspecialchars($itemData['id']); ?>';
                  document.getElementById('qty_'+i).focus();
                  document.getElementById('itemInformationTable').style.display = 'none';
                  
                                                              
                ">
              <td><?php echo " "; ?></td>
              <td><?php echo " "; ?></td>

              <td><?php echo $itemData['id']; ?></td>
              <td><?php echo $itemData['product_name']; ?></td>
              <td><?php echo $itemData['brand_name']; ?></td>
              <td><?php echo $itemData['design_name']; ?></td>
              <td><?php echo $itemData['color_name']; ?></td>
              <td><?php echo $itemData['batch_name']; ?></td>
              <td><?php echo $itemData['category_name']; ?></td>
              <td><?php echo $itemData['hsn_code']; ?></td>
              <td><?php echo $itemData['tax_code']; ?></td>
              <td><?php echo $itemData['size_name']; ?></td>
              <td><?php echo $itemData['mrp']; ?></td>
              <td><?php echo $itemData['selling_price']; ?></td>
              <td><?php echo $itemData['rate']; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
  </form>


<?php }; ?>






<?php



?>













  </body>


  </html>