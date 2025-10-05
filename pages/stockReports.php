<!-- when i press f2 in salesNumber text field , aalesSummaryTable popup using ajax showing purchase summary of different grn numbers. when i select any particular row from salesItemTable all the data from purchase_item pertaining to  that grn number should display  in itemGrid.this code i have written for one row but i want all rows to be append in the itemGrid automatically -->
<style>
#exportForm{
display: flex;
gap:2px;
position: absolute;
top:190px;
left:1058px;

}
#exportButton{
width: 150px;
padding-left:9px;
margin-left:-170px;
}
#billType {
            appearance: none; /* Remove default arrow */
            -moz-appearance: none;
            -webkit-appearance: none;
            background: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"%3E%3Cpolyline points="6 9 12 15 18 9"%3E%3C/polyline%3E%3C/svg%3E') no-repeat right 10px center;
            background-color: #fff;
            background-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px 40px 5px 10px;
            font-size: 11.50px;
            font-weight: bold;
            cursor: pointer;
        }

        /* For better appearance in older browsers */
        select::-ms-expand {
            display: none;
        }

        /* Optional: Add hover effect */
        #billType:hover {
            border-color:#007bff ;
}
</style>
<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

use function PHPSTORM_META\type;
ob_start();
include_once("../config/config.php");
include_once(DIR_URL."/includes/header.php");
include_once(DIR_URL."/db/dbConnection.php");
include_once(DIR_URL."/includes/navbar.php");
include_once(DIR_URL."/includes/sidebar.php");
// include_once(DIR_URL."includes/itemMaster.php");



$d=1;
$userId= $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$financial_year = $_SESSION['financial_year'];
$companyState = $_SESSION['company_state'];



if(isset($_POST['exportButton'])){
    // extract($_POST);
    
        header("Location:".BASE_URL."/exportFile/excelFileFormatStockReports.php");
 
}



if(isset($_POST['searchButton'])){

       $_SESSION['productName'] = $productName  = isset($_POST['productName']) ? $_POST['productName'] : "";
       $_SESSION['brandName']   = $brandName    = isset($_POST['brandName']) ? $_POST['brandName'] : "";
       $_SESSION['designName']  = $designName   = isset($_POST['designName']) ? $_POST['designName'] : "";
       $_SESSION['colorName']   = $colorName    = isset($_POST['colorName']) ? $_POST['colorName'] : "";
       $_SESSION['categoryName']   = $categoryName    = isset($_POST['categoryName']) ? $_POST['categoryName'] : "";
       $_SESSION['sizeName']    = $sizeName     = isset($_POST['sizeName']) ? $_POST['sizeName'] : "";
        
            
        $fromDate = $_SESSION['fromDate'] = $_POST['fromDate'];
        $toDate = $_SESSION['toDate'] = $_POST['toDate'];
        $productId = $_SESSION['productId'] =$_POST['productId'];
        $salesNumber = $_SESSION['salesNumber'] = isset($_POST['salesNumber']) ? $_POST['salesNumber'] : "";
        $salesReturnNumber = $_SESSION['salesReturnNumber'] = isset($_POST['salesReturnNumber']) ? $_POST['salesReturnNumber'] : "";
        
        // $querySearchSalesItem = "select i.*,sb.*
        //                          from items as i
        //                          join stock_balance as sb on sb.item_id = i.id
        //                          where ((i.product_name like '%$productName%')
        //                          or (i.brand_name like '%$brandName%')
        //                          or (i.design_name like '%$designName%')
        //                          or (i.color_name like '%$colorName%')
        //                          or (i.batch_name like '%$batchName%')
        //                          or (i.size_name like '%$sizeName%'))
        //                          and ( i.branch_id = '$userBranchId' and sb.item_qty != 0)";
       
        $querySearchSalesItem = "SELECT i.*, sb.*
                         FROM items AS i
                         JOIN stock_balance AS sb ON sb.item_id = i.id
                         WHERE ((
                             i.product_name = '$productName'
                             OR i.brand_name = '$brandName'
                             OR i.design_name = '$designName'
                             OR i.color_name = '$colorName'
                             OR i.category_name = '$categoryName'
                             OR i.size_name = '$sizeName') 
                        OR
                             ( i.product_name like '%$productName%'
                                AND i.brand_name like '%$brandName%'
                                AND i.design_name like '%$designName%'
                                AND i.color_name like '%$colorName%'
                                AND i.category_name like '%$categoryName%'
                                AND i.size_name like '%$sizeName%')
                        ) 
                         AND (i.branch_id = '$userBranchId' AND sb.item_qty != 0)";

                                 
        $searchResultSalesItem = $con->query($querySearchSalesItem);
        
}


?>

<script>

    
</script>


<?php 
// $resultSearchSalesItem= ""; 

if(isset($_POST['salesNumberSearchButton'])){

    extract($_POST);
    echo $productId;
    // echo "<br>";
    // echo "grn Number = ".$salesNumber;
    // echo "<br>";
    // echo $salesNumber;
    // echo "<br>";
    // echo ;
    // echo "<br>";
    // echo $totalQty;
    // echo '<br>';
    // echo $totalAmount;
    // echo "<br>";
    // echo $cgstAmount;
    // echo "<br>";
    // echo $dcNumber;
    // echo "<br>";
    // echo $fromDate;
    // echo "<br>";
    // echo $salesReturnNumber;
    // echo "<br>";
    // echo $toDate;
    
    
    
}    




?>
<script>
// function calculateAmount(){
//     let rate = document.querySelector(".rate-field").value;
//     let qty = document.querySelector(".qty-field").value;
//     document.querySelector(".amount-field").value =rate*qty;

// }

</script>
<style>




  .custom-toast {
    position: absolute;
    bottom: 60px;
    left: 1160px;
    width: 90%;
    height: 40px;
    padding-top: 6px;
    font-weight: bolder;
  }

  #liveToast {
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    color: white;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
  }

  .toast-header {
    background: none;
    border-bottom: none;
  }

  .btn-close-white {
    filter: invert(1);
  }

#serialNumber_1{

    background-color:#212529;
    color: white;
}


.items {
    display: table-row-group;
    row-gap: 2px; /* Adjust the value as needed */
}
.table-dark tbody tr td {
    padding: 0px !important;
}
.form-floating{
    padding-top: 1px;
    color:#2B86C5;
    font-size: 13px;
}

#itemTable{
    
    color:white;
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}





#product{
    margin-top:20px;
    margin-left:12px;
    width: 150px;
    font-size: 10px;
    font-weight: bold;
    text-transform: capitalize;
    height: 40px;
    background-color:blanchedalmond;
}

#brand{
    margin-top:20px;
    width: 150px;
    font-size: 10px;
    font-weight: bold;
    text-transform: capitalize;
    height: 40px;
    background-color:blanchedalmond;
}
#design{
    margin-top:20px;
    width: 150px;
    font-size: 10px;
    font-weight: bold;
    text-transform: capitalize;
    height: 40px;
    background-color:blanchedalmond;
}
#color{
    margin-top:20px;
    width: 150px;
    font-size: 10px;
    font-weight: bold;
    text-transform: capitalize;
    height: 40px;
    background-color:blanchedalmond;
}
#category{
    margin-top:20px;
    width: 150px;
    font-size: 10px;
    font-weight: bold;
    text-transform: capitalize;
    height: 40px;
    background-color:blanchedalmond;
}
#size{
    margin-top:20px;
    width: 150px;
    font-size: 10px;
    font-weight: bold;
    text-transform: capitalize;
    height: 40px;
    background-color:blanchedalmond;
}

#productId{
    /* margin-top:100px; */
    /* margin-left:300px; */
    display: none;
    border: 1px solid black;
    width: 80px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
    
}

#searchButton{
    background-color:#2B86C5;
}



#fromDate,#toDate{
    margin-top:-2px;
    /* margin-left:10px; */
    width: 150px;
    font-size: 13px;
    font-weight: bold;
    text-transform: capitalize;
    height: 40px;
}

</style>
<!-- Bootstrap Toast -->

<?php 
    if(isset($_SESSION['notification'])){
        
    }else{
    
        $_SESSION['notification'] = "";
    }
?>
<?php if(isset($_SESSION['notification']) && $_SESSION['notification'] != ''){?>
<div class="toast-container custom-toast">
  <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto text-white">Notification</strong>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <?php echo $_SESSION['notification'];
            unset($_SESSION['notification']);
      ?>
    </div>
  </div>
</div>

<?php }?>






<!-- JavaScript to trigger toast on form submission -->



<div id="response_message">
        
</div>


<div id="response_message_product_form">

</div>



<form action="" id="frm" method="post" style="display:flex;justify-content:center;">
<div class="" style="margin-left:270px;border:1px solid black;width:1020px;height:160px;margin-top:5px;">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab">Stock Report</button>
            </li>
            <li class="nav-item">
                <label style="margin-top:8px;margin-left:5px;">Press F2 For Info</label>
            </li>
            
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                
                    <div style="margin-top:-20px;margin-left:12px">
                    
                    <div style="display: flex;gap:12px">
                        <div class="form-floating">
                            <input type="text"  name="productName" autocomplete="off" id="product"  class="form-control"  value="">
                            <label for="productName" style="padding-left:40px;padding-top:30px;font-weight:bolder;">Product Info</label>
                        </div>
                        <div class="form-floating">
                            <input type="text"  name="brandName" autocomplete="off" id="brand"  class="form-control"  value="">
                            <label for="brandName" style="padding-left:40px;padding-top:30px;font-weight:bolder;">Brand Info</label>
                        </div>
                        <div class="form-floating">
                            <input type="text"  name="designName" autocomplete="off" id="design"  class="form-control"  value="">
                            <label for="designName" style="padding-left:40px;padding-top:30px;font-weight:bolder;">Design Info</label>
                        </div>
                        <div class="form-floating">
                            <input type="text"  name="colorName" autocomplete="off" id="color"  class="form-control"  value="">
                            <label for="colorName" style="padding-left:40px;padding-top:30px;font-weight:bolder;">Color Info</label>
                        </div>
                        <div class="form-floating">
                            <input type="text"  name="categoryName" autocomplete="off" id="category"  class="form-control"  value="">
                            <label for="categoryName" style="padding-left:40px;padding-top:30px;font-weight:bolder;">Category Info</label>
                        </div>
                        <!--<div class="form-floating">-->
                        <!--    <input type="text"  name="batchName" autocomplete="off" id="batch"  class="form-control"  value="">-->
                        <!--    <label for="batchName" style="padding-left:40px;padding-top:30px;font-weight:bolder;">Batch Info</label>-->
                        <!--</div>-->
                        <div class="form-floating">
                            <input type="text"  name="sizeName" autocomplete="off" id="size"  class="form-control"  value="">
                            <label for="sizeName" style="padding-left:40px;padding-top:30px;font-weight:bolder;">Size Info</label>
                        </div>
                        
                    </div>
                    
                    
                        <div style="margin-top:22px;display:flex;gap:0px;margin-left:175px">
                            <div class="form-floating" hidden>
                                <input  type="date" name="fromDate" id="fromDate" class="form-control" placeholder="DC Date" value="" autocomplete="off" maxlength="20">
                                <label for="fromDate" style="margin-top:-10px">From Date</label>
                            </div>          
                            <div class="form-floating" hidden>
                                <input type="date" name="toDate" id="toDate" class="form-control" placeholder="Invoice Date" value="" autocomplete="off">
                                <label for="toDate" style="margin-top:-10px;">To Date</label>
                            </div>          
                            
                            <div style="margin-top:0px;margin-left:160px;">
                                    <button type="submit" name="searchButton" id="searchButton" class="btn btn-primary" style="width: 150px;">Search</button>
                            </div>
                            <input type="text" name="productId" id="productId" class="form-control">
                        </div>
                            
                    
                    
                </div>
                        <!-- <div style="display:flex;margin-left:20px;margin-top:-5px">
                                
                        </div> -->
                        
                    
                
            
            </div>
            </div>
            
</div>
</form>

<form action="" id="exportForm" method="post" target="">
<!-- <select name="billType" id="billType" class="form-control" style="width:155px;">
<option value="">--Select File Type--</option>
<option value="salesSummary">Sales Summary</option>
<option value="salesReturnSummary">Sales Return Summary</option>
</select> -->
<button type="submit" name="exportButton" id="exportButton" class="btn btn-primary">Export</button>
</form>

<?php ?>

<form action="">
<!-- <label for=""  id="purchaseReport">PURCHASE REPORT</label> -->

<div id="salesItemTable" style="margin-top:-10px">
    
<div style="margin-left: 265px; font-size: 11px;">
    <div style="width: 1248px; height: 460px; overflow-y: auto;overflow-x:auto" id="itemTable">
        <table class="table text-white" style="border-collapse: collapse; width: 1245px;font-size:11px">
            <thead>
                <tr style="position: sticky; z-index: 1; top: 0; background-color: #FF3CAC;">
                    <th style="">S.No.</th>
                    <th style="">Product</th>
                    <th style="">Brand</th>
                    <th style="">Design</th>
                    <th style="">Color</th>
                    <th style="">Batch</th>
                    <th style="">Category</th>
                    <th style="">HSN Code</th>
                    <th style="">Tax</th>
                    <th style="">Size</th>
                    <th style="text-align:right">MRP</th>
                    <th style="text-align:right">Selling Price</th>
                    <th style="text-align:right">Rate</th>
                    <th style="text-align:right">Qty</th>
                    <th style="text-align:right">Value</th>
                    <th style="text-align:right">Item Id</th>
                    <th style="text-align:right">User Id</th>
                </tr>
            </thead>
            <tbody id="table_body" class="items">
                <?php 
                if(isset($searchResultSalesItem)) {
                    $sno = 1;
                    $itemTotalQty = 0;
                    $itemTotalRate = 0;
                    while ($salesItemData = $searchResultSalesItem->fetch_assoc()) { ?>
                        <!-- <tr onclick="itemDetails('<?php echo $salesItemData['sales_number']; ?>', '<?php echo $salesItemData['product_id'] ?>')"> -->
                            <td><?php echo $sno++; ?></td>
                            <?php $itemTotalQty = $itemTotalQty+$salesItemData['item_qty'];
                                  $itemTotalRate = $itemTotalRate+($salesItemData['rate']*$salesItemData['item_qty']);  
                            ?>
                            <td style="width:130px;"><?php echo htmlspecialchars($salesItemData['product_name']); ?></td>
                            <td style="width:120px;"><?php echo htmlspecialchars($salesItemData['brand_name']); ?></td>
                            <td style="width:150px;"><?php echo htmlspecialchars($salesItemData['design_name']); ?></td>
                            <td style="width:150px;"><?php echo htmlspecialchars($salesItemData['color_name']); ?></td>
                            <td style=""><?php echo htmlspecialchars($salesItemData['batch_name']); ?></td>
                            <td style=""><?php echo htmlspecialchars($salesItemData['category_name']); ?></td>
                            <td style="width:150px;"><?php echo htmlspecialchars($salesItemData['hsn_code']); ?></td>
                            <td style=""><?php echo htmlspecialchars($salesItemData['tax_code']); ?></td>
                            <td style=""><?php echo htmlspecialchars($salesItemData['size_name']); ?></td>
                            <td style="text-align: right;"><?php echo htmlspecialchars($salesItemData['mrp']); ?></td>
                            <td style="text-align: right;width:150px;"><?php echo htmlspecialchars($salesItemData['selling_price']); ?></td>
                            <td style="text-align: right;"><?php echo htmlspecialchars($salesItemData['rate']); ?></td>
                            <td style="text-align: right;"><?php echo htmlspecialchars($salesItemData['item_qty']); ?></td>
                            <td style="text-align: right;"><?php echo htmlspecialchars($salesItemData['rate']*$salesItemData['item_qty']); ?></td>
                            <td style="text-align: right;width:100px;"><?php echo htmlspecialchars($salesItemData['id']); ?></td>
                            <td style="text-align: right;width:100px;"><?php echo htmlspecialchars($salesItemData['user_id']); ?></td>
                            
                        </tr>
                <?php } 
                }?>
                <tr>
                <td style="font-size:20px;font-weight:bolder;">Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-size:15px;font-weight:bolder;text-align:right"><?php echo isset($itemTotalQty)?$itemTotalQty:""; ?></td>
                <td style="font-size:15px;font-weight:bolder;text-align:right"><?php echo isset($itemTotalRate)?$itemTotalRate:""; ?></td>
                <td></td>
                <td></td>
                </tr>
                </tbody>
            </table>
     
<div class="container" style="margin-top:10px" id="itemGrid">

        
        <div>
            <?php
                // if(isset($_SESSION['product'])){
                //     print_r($_SESSION['product']);
                // }
            ?>
        </div>
        <div style="display:flex" hidden>
        <label for=""   style="margin-left:200px;">User Id</label>
        <input type="text" name="userId" readonly id="userId" class="form-control" value="<?php echo $userId;?>" style="width:250px;">
        <label for="">Branch Id</label>
        <input type="text" name="userBranchId" readonly id="userBranchId" class="form-control" value="<?php echo $userBranchId;?>" style="width:250px;">
        </div>
        
       
        
</div>


</form>

<?php ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    
    function itemDetails(salesNumber,productName){
        
        let salesNumber_productName = [salesNumber,productName];
        
        let salesData = new FormData();
        salesData.append('aj_sales_sr_details',JSON.stringify(salesNumber_productName));
        let ajaxSales = new XMLHttpRequest();
        ajaxSales.open("post","ajaxGetItemDetailsOfSales.php", true);
        ajaxSales.send(salesData);
        
        ajaxSales.onreadystatechange = function(){
            if(ajaxSales.status === 200 && ajaxSales.readyState === 4){
            
                document.getElementById('response_message').innerHTML = ajaxSales.responseText;
            }
        }
        
        
    }
    
    window.onload = function(){
        localStorage.setItem("row_index",1);
        localStorage.setItem("row_deleted",0);
        
    }
    
    
    

    document.addEventListener("keydown",function(event){
        if(event.key === "F5"){
            event.preventDefault();
            
            let confirmRefresh = confirm("Are you sure you want to refresh? Your unsaved data will be lost.");
            if(confirmRefresh){
                location.reload();
            }
        }
    })
    
    // document.getElementById("salesNumber").addEventListener("keydown", function(event){
    //         let target  = event.target;
    //         let productId = document.getElementById("productId").value || '';
    //         let fromDate = document.getElementById('fromDate').value || '';
    //         let toDate = document.getElementById('toDate').value || '';
            
    //         if(event.key === "F2"){
    //             event.preventDefault();
    //             let salesNumber = new FormData();
    //             let data = [target.value,productId,fromDate,toDate]
                
    //             salesNumber.append("lb_sales_number",JSON.stringify(data));
    //             let aj_grn = new XMLHttpRequest();
    //             aj_grn.open("POST","ajaxSalesReport.php",true);
    //             aj_grn.send(salesNumber);
    //             aj_grn.onreadystatechange = function(){
    //                 if(aj_grn.status === 200 && aj_grn.readyState === 4){
    //                         document.getElementById("response_message").innerHTML = aj_grn.responseText;
                             
                
    //                 }
    //             }
                
    //         }
            
    // })
    
    // document.getElementById("salesReturnNumber").addEventListener("keydown", function(event){
    //         let target  = event.target;
    //         let productId = document.getElementById('productId').value;
    //         let fromDate = document.getElementById('fromDate').value || '';
    //         let toDate = document.getElementById('toDate').value || '';
            
    //         if(event.key === "F2"){
    //             event.preventDefault();
    //             let salesNumber = new FormData();
    //             let data = [target.value, productId,fromDate,toDate]
    //             salesNumber.append("lb_sales_return_number", JSON.stringify(data));
    //             let aj_grn = new XMLHttpRequest();
    //             aj_grn.open("POST","ajaxSalesReport.php",true);
    //             aj_grn.send(salesNumber);
    //             aj_grn.onreadystatechange = function(){
    //                 if(aj_grn.status === 200 && aj_grn.readyState === 4){
    //                         document.getElementById("response_message").innerHTML = aj_grn.responseText;
                             
                
    //                 }
    //             }
                
    //         }
            
    // })
    
    
    

document.getElementById("product").addEventListener("keydown", function(event){
        let target = event.target;
        
    if(event.key === "F2"){
        event.preventDefault();
        let productName1 = document.getElementById("product").value;
        let branchId = document.getElementById('userBranchId').value; 
        $query = `select*from products where product_name like '%${productName1}%' and branch_id = '${branchId}' order by product_name`; 
        let productName = new FormData();
        productName.append("lb_qry_product",$query);
        let aj_product =  new XMLHttpRequest();
        aj_product.open("POST","ajaxAttributesFetchingForStockReport.php",true);
        aj_product.send(productName);
        
        aj_product.onreadystatechange = function(){
            if(aj_product.status === 200 && aj_product.readyState === 4){
            document.getElementById("response_message").innerHTML = aj_product.responseText;
            document.getElementById("response_message").style.display = "block";

                
            }
        }
        
    
    }

})


document.getElementById("brand").addEventListener("keydown", function(event){
        let target = event.target;
        
    if(event.key === "F2"){
        event.preventDefault();
        let brandName1 = document.getElementById('brand').value;
        let branchId = document.getElementById('userBranchId').value; 
        $query = `select*from brands where brand_name like '%${brandName1}%' and branch_id = '${branchId}' order by brand_name`; 
        let brandName = new FormData();
        brandName.append("lb_qry_brand",$query);
        let aj_brand =  new XMLHttpRequest();
        aj_brand.open("POST","ajaxAttributesFetchingForStockReport.php",true);
        aj_brand.send(brandName);
        
        aj_brand.onreadystatechange = function(){
            if(aj_brand.status === 200 && aj_brand.readyState === 4){
            document.getElementById("response_message").innerHTML = aj_brand.responseText;
            document.getElementById("response_message").style.display = "block";

                
            }
        }
        
    
    }

})


document.getElementById("design").addEventListener("keydown", function(event){
        let target = event.target;
        
    if(event.key === "F2"){
        event.preventDefault();
        let designName1 = document.getElementById('design').value;
        let branchId = document.getElementById('userBranchId').value; 
        $query = `select*from designs where design_name like '%${designName1}%' and branch_id = '${branchId}' order by design_name`; 
        let designName = new FormData();
        designName.append("lb_qry_design",$query);
        let aj_design =  new XMLHttpRequest();
        aj_design.open("POST","ajaxAttributesFetchingForStockReport.php",true);
        aj_design.send(designName);
        
        aj_design.onreadystatechange = function(){
            if(aj_design.status === 200 && aj_design.readyState === 4){
            document.getElementById("response_message").innerHTML = aj_design.responseText;
            document.getElementById("response_message").style.display = "block";

                
            }
        }
        
    
    }

})


document.getElementById("color").addEventListener("keydown", function(event){
        let target = event.target;
        
    if(event.key === "F2"){
        event.preventDefault();
        let colorName1 = document.getElementById('color').value;
        let branchId = document.getElementById('userBranchId').value; 
        $query = `select*from colors where color_name like '%${colorName1}%' and branch_id = '${branchId}' order by color_name`; 
        let colorName = new FormData();
        colorName.append("lb_qry_color",$query);
        let aj_color =  new XMLHttpRequest();
        aj_color.open("POST","ajaxAttributesFetchingForStockReport.php",true);
        aj_color.send(colorName);
        
        aj_color.onreadystatechange = function(){
            if(aj_color.status === 200 && aj_color.readyState === 4){
            document.getElementById("response_message").innerHTML = aj_color.responseText;
            document.getElementById("response_message").style.display = "block";

                
            }
        }
        
    
    }

})


document.getElementById('category').addEventListener('keydown',function(event){
        let target = event.target;
        if(event.key === "F2"){
            event.preventDefault();
            let categoryName1 = document.getElementById('category').value;
            let branchId = document.getElementById('userBranchId').value;
            let query = `select*from categories where category_name like '%${categoryName1}%' and branch_id = '${branchId}' order by category_name`;
            let categoryName = new FormData();
            categoryName.append("lb_qry_category",query);
            let aj_category = new XMLHttpRequest();
            aj_category.open("post","ajaxAttributesFetchingForStockReport.php",true);
            aj_category.send(categoryName);
            aj_category.onreadystatechange = function(){
                if(aj_category.status === 200 && aj_category.readyState === 4){
                    document.getElementById('response_message').innerHTML = aj_category.responseText;
                }
            }
            
        }
})

// document.getElementById("batch").addEventListener("keydown", function(event){
//         let target = event.target;
        
//     if(event.key === "F2"){
//         event.preventDefault();
//         let batchName1 = document.getElementById('batch').value;
//         let branchId = document.getElementById('userBranchId').value; 
//         $query = `select*from batches where batch_name like '%${batchName1}%' and branch_id = '${branchId}' order by batch_name`; 
//         let batchName = new FormData();
//         batchName.append("lb_qry_batch",$query);
//         let aj_batch =  new XMLHttpRequest();
//         aj_batch.open("POST","ajaxAttributesFetchingForStockReport.php",true);
//         aj_batch.send(batchName);
        
//         aj_batch.onreadystatechange = function(){
//             if(aj_batch.status === 200 && aj_batch.readyState === 4){
//             document.getElementById("response_message").innerHTML = aj_batch.responseText;
//             document.getElementById("response_message").style.display = "block";

                
//             }
//         }
        
    
//     }

// })


document.getElementById("size").addEventListener("keydown", function(event){
        let target = event.target;
        
    if(event.key === "F2"){
        event.preventDefault();
        let sizeName1 = document.getElementById('size').value;
        let branchId = document.getElementById('userBranchId').value; 
        $query = `select*from sizes where size_name like '%${sizeName1}%' and branch_id = '${branchId}' order by size_name`; 
        let sizeName = new FormData();
        sizeName.append("lb_qry_size",$query);
        let aj_size =  new XMLHttpRequest();
        aj_size.open("POST","ajaxAttributesFetchingForStockReport.php",true);
        aj_size.send(sizeName);
        
        aj_size.onreadystatechange = function(){
            if(aj_size.status === 200 && aj_size.readyState === 4){
            document.getElementById("response_message").innerHTML = aj_size.responseText;
            document.getElementById("response_message").style.display = "block";

                
            }
        }
        
    
    }

})

    
    
    document.getElementById('product').addEventListener('keydown',function(e){
       
        if(e.key === "Enter"){
            e.preventDefault();
            document.getElementById('fromDate').focus();
        }
    })

    document.getElementById('fromDate').addEventListener('keydown',function(e){
    
        if(e.key === "Enter"){
            e.preventDefault();
            document.getElementById('toDate').focus();
        }
    })
    document.getElementById('toDate').addEventListener('keydown',function(e){
        
        let grn  = document.getElementById('salesNumber');
        let invoice  = document.getElementById('salesReturnNumber');
        
        if(e.key === "Enter"){
            e.preventDefault();
            // Focus on the first enabled field
        if (!grn.disabled) {
            grn.focus();
        } else if (!invoice.disabled) {
            invoice.focus();
        }
        }
    })
    // document.getElementById('salesNumber').addEventListener('keydown',function(e){
        
    //     if(e.key === "Enter"){
    //         e.preventDefault();
    //         document.getElementById('searchButton').focus();
    //     }
    // })
    
    // document.getElementById('salesReturnNumber').addEventListener('keydown',function(e){
        
    //     if(e.key === "Enter"){
    //         e.preventDefault();
    //         document.getElementById('searchButton').focus();
    //     }
    // })
    
    
    window.onload = function(){
        
        // document.getElementById("product").value = "";
        document.getElementById("product").focus();
        
        
        
        
        
        
        
        
        
        
        let productName = document.getElementById("product").value;
        
        
        
        
        
        
        
        
        localStorage.setItem("total_rows",1);
        let myDate = new Date();
        
        let fromDate = myDate.getFullYear() + "-" + 
                         (myDate.getMonth() + 1).toString().padStart(2, "0") + "-" + "01";
                          
        let currentDate = myDate.getFullYear() + "-" + 
                         (myDate.getMonth() + 1).toString().padStart(2, "0") + "-" + 
                          myDate.getDate().toString().padStart(2, "0");
        // document.getElementById("salesDate").value = currentDate;
        document.getElementById("fromDate").value =fromDate;
        document.getElementById("toDate").value =currentDate;
        
        
        
        
    }
    let rowIndex =localStorage.getItem("row_index");
    
    
    




// document.getElementById('salesNumber').addEventListener('keypress', function (event) {
        
//         const charCode = event.which || event.keyCode; // Get the character code
//         const charStr = String.fromCharCode(charCode); // Convert to a string

//         // Allow digits (0-9) and a single decimal point
//         if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
//             event.preventDefault(); // Prevent input if not a number or extra decimal
//         }
//     });

//     document.getElementById('salesNumber').addEventListener('input', function () {
//         // Prevent any invalid characters that might slip through (e.g., copy-paste)
//         this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
// });


// document.getElementById('salesReturnNumber').addEventListener('keypress', function (event) {
        
//         const charCode = event.which || event.keyCode; // Get the character code
//         const charStr = String.fromCharCode(charCode); // Convert to a string

//         // Allow digits (0-9) and a single decimal point
//         if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
//             event.preventDefault(); // Prevent input if not a number or extra decimal
//         }
//     });

//     document.getElementById('salesReturnNumber').addEventListener('input', function () {
//         // Prevent any invalid characters that might slip through (e.g., copy-paste)
//         this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
// });


setTimeout(() => {
   var alertBox = document.getElementById("liveToast");
    if(alertBox){
        alertBox.style.display='none';
    }
}, 2000);






</script>

</body>
</html>

<?php
    

    

?>


<?php ob_end_flush(); ?>
<?php include_once(DIR_URL."/includes/footer.php");?>












<style>
#purchaseReport{

margin-left:650px;margin-top:-10px;
width: 500px;
font-size: 15px;
font-weight: bold;
text-transform: capitalize;
padding: 4px 130px;
height: 30px;
font-family: Verdana, Geneva, Tahoma, sans-serif;
letter-spacing:5px;
font-weight:bolder;
background-color: #FF3CAC;
background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
color: white;
border-radius: 5px;
box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}
</style>
