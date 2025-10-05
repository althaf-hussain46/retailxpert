<!-- when i press f2 in grnNumber text field , purchaseSummaryTable popup using ajax showing purchase summary of different grn numbers. when i select any particular row from purchaseSummaryTable all the data from purchase_item pertaining to  that grn number should display  in itemGrid.this code i have written for one row but i want all rows to be append in the itemGrid automatically -->
<style>
#exportForm{
display: flex;
gap:2px;
position: absolute;
top:198px;
left:1285px;

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
    extract($_POST);
    if($billType == "purchaseBill"){
        header("Location:".BASE_URL."/exportFile/excelFileFormatPurchaseBill.php");
             
    }elseif($billType == "purchaseSummary"){
        // $_SESSION['item_id'] = "Product Id";
        header("Location:".BASE_URL."/exportFile/excelFileFormatPurchaseSummary.php");
        // header("Location:".BASE_URL."/exportFile/excelFileFormat.php");
    }elseif($billType == "purchaseItem"){
        header("Location:".BASE_URL."/exportFile/excelFileFormatPurchaseItem.php");
    }else{
        echo "Please Select File Type";
    }
    

}





if(isset($_POST['searchButton']))
{       $_SESSION['supplierName'] = $_POST['supplierName'];
        $optionSelected = $_SESSION['optionSelected'] = $_POST['option'];
        $fromDate = $_SESSION['fromDate'] = $_POST['fromDate'];
        $toDate = $_SESSION['toDate'] = $_POST['toDate'];
        $supplierId = $_SESSION['supplierId'] =$_POST['supplierId'];
        $grnNumber = $_SESSION['grnNumber'] = isset($_POST['grnNumber']) ? $_POST['grnNumber'] : "";
        $invoiceNumber = $_SESSION['invoiceNumber'] = isset($_POST['invoiceNumber']) ? $_POST['invoiceNumber'] : "";
        $dcNumber = $_SESSION['dcNumber'] = isset($_POST['dcNumber']) ? $_POST['dcNumber'] : "";
        
        
        
        if($optionSelected=="grnRadio"){
            $querySearchPurchaseSum = "
            SELECT ps.*, s.* 
            FROM purchase_summary AS ps
            JOIN suppliers AS s ON s.id = ps.supplier_id
            WHERE ps.grn_number LIKE '%$grnNumber%' AND ps.supplier_id LIKE '%$supplierId%'
            AND ps.branch_id = '$userBranchId' AND (date(grn_date)  BETWEEN '$fromDate' AND '$toDate') order by grn_number";    
            
            $queryTotalPurchaseSummary = "select sum(total_qty) as tqty , sum(total_amount) as tamount,
             sum(cgst_amount) as tcgst, sum(sgst_amount) as tsgst, sum(igst_amount) as tigst,
             sum(addon) as taddon, sum(deduction) as tdeduction, sum(net_amount) as tnetamount 
             from purchase_summary WHERE grn_number LIKE '%$grnNumber%' AND supplier_id LIKE '%$supplierId%'
            AND branch_id = '$userBranchId' AND (date(grn_date)  BETWEEN '$fromDate' AND '$toDate')";
        
        }elseif($optionSelected=="invoiceRadio"){
        
            $querySearchPurchaseSum = "
            SELECT ps.*, s.* 
            FROM purchase_summary AS ps
            JOIN suppliers AS s ON s.id = ps.supplier_id
            WHERE ps.invoice_number LIKE '%$invoiceNumber%' AND ps.supplier_id LIKE '%$supplierId%'
            AND ps.branch_id = '$userBranchId' AND (date(invoice_date)  BETWEEN '$fromDate' AND '$toDate') order by grn_number";
            
            $queryTotalPurchaseSummary = "select sum(total_qty) as tqty , sum(total_amount) as tamount,
             sum(cgst_amount) as tcgst, sum(sgst_amount) as tsgst, sum(igst_amount) as tigst,
             sum(addon) as taddon, sum(deduction) as tdeduction, sum(net_amount) as tnetamount 
             from purchase_summary WHERE invoice_number LIKE '%$invoiceNumber%' AND supplier_id LIKE '%$supplierId%'
            AND branch_id = '$userBranchId' AND (invoice_date  BETWEEN '$fromDate' AND '$toDate')";
            
        }elseif($optionSelected=="dcRadio"){
            $querySearchPurchaseSum = "
            SELECT ps.*, s.* 
            FROM purchase_summary AS ps
            JOIN suppliers AS s ON s.id = ps.supplier_id
            WHERE (ps.dc_number LIKE '%$dcNumber%') AND ps.supplier_id LIKE '%$supplierId%'
            AND ps.branch_id = '$userBranchId' AND (dc_date  BETWEEN '$fromDate' AND '$toDate') order by grn_number";
            
            $queryTotalPurchaseSummary = "select sum(total_qty) as tqty , sum(total_amount) as tamount,
             sum(cgst_amount) as tcgst, sum(sgst_amount) as tsgst, sum(igst_amount) as tigst,
             sum(addon) as taddon, sum(deduction) as tdeduction, sum(net_amount) as tnetamount 
             from purchase_summary WHERE dc_number LIKE '%$dcNumber%' AND supplier_id LIKE '%$supplierId%'
            AND branch_id = '$userBranchId' AND (dc_date  BETWEEN '$fromDate' AND '$toDate')";
        }
        
        
        $resultSearchPurchaseSum = $con->query($querySearchPurchaseSum);
        $resultTotalPurchaseSummary = $con->query($queryTotalPurchaseSummary);
        
        
        
    
}


?>

<script>

    
</script>






<?php 
$querySearchSnoMaster = "select*from sno_master where financial_year = '$financial_year'
                         && branch_id='$userBranchId'";
$resultSearchSnoMaster  = $con->query($querySearchSnoMaster)->fetch_assoc();
$purchase_no = $resultSearchSnoMaster['purchase_no'];
$purchase_no = $purchase_no+1;

if(isset($purchase_no)){
    
}else{
    $purchase_no = "";
}
$supplierName = "";

$grnNumber = "";
$grnDate = "";
$grnAmount = "";
$dcNumber = "";
$fromDate = "";
$invoiceNumber = "";
$toDate = ""; 
$totalQty = "";
$totalAmount = "";
$cgstAmount = "";
$sgstAmount = "";
$igstAmount = "";
$addOnAmount = "";
$deductionAmount = "";
$netAmount = "";
// $resultSearchPurchaseItem= ""; 

if(isset($_POST['grnNumberSearchButton'])){

    extract($_POST);
    echo $supplierId;
    // echo "<br>";
    // echo "grn Number = ".$grnNumber;
    // echo "<br>";
    // echo $grnNumber;
    // echo "<br>";
    // echo $grnAmount;
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
    // echo $invoiceNumber;
    // echo "<br>";
    // echo $toDate;
    
    $querySearchPurchaseItem  = "SELECT 
                                purchase_item.*, 
                                items.*
                                FROM purchase_item
                                INNER JOIN items ON purchase_item.item_id = items.id
                                WHERE purchase_item.grn_number = '$grnNumber' 
                                AND purchase_item.branch_id = '$userBranchId'";
    $resultSearchPurchaseItem = $con->query($querySearchPurchaseItem);
    $_SESSION['resultSearchPurchaseSummaryItem'] = $resultSearchPurchaseItem->fetch_all(MYSQLI_ASSOC);
    
    while($data = $resultSearchPurchaseItem->fetch_assoc()){
        $id[] = $data['item_id'];
        $product[] = $data['product_name'];
        $brand[] = $data['brand_name'];
        $design[] = $data['design_name'];
        $batch[] = $data['batch_name'];
        $color[] = $data['color_name'];
        $category[]  = $data['category_name'];
        $hsnCode[] =  $data['hsn_code'];
        $tax[] = $data['tax_code'];
        $size[] = $data['size_name'];
        $mrp[] = $data['mrp'];
        $sellingP[] = $data['selling_price'];
        $rate[] = $data['rate'];
        $qty[] = $data['item_qty'];
        $amount[] = $data['item_amount'];
        
        
        echo $data['grn_number']." ".$data['item_id']." ".$data['product_name']." ".$data['batch_name']." ".$data['color_name'];
        
        echo "<br>";
     
    }
    
}    



$querySearchTax = "select*from taxes where branch_id = '$userBranchId'";
$resultSearchTax = $con->query($querySearchTax);
?>
<script>
// function calculateAmount(){
//     let rate = document.querySelector(".rate-field").value;
//     let qty = document.querySelector(".qty-field").value;
//     document.querySelector(".amount-field").value =rate*qty;

// }

</script>
<style>


#purchaseDelete{

    margin-left:5px;margin-top:-120px;
    width: 340px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    padding: 4px 53px;
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

/* #totalQty{
    background-color:gainsboro;
}
#totalAmount{
    background-color:gainsboro;
}
#netAmount{
    background-color:gainsboro;
} */
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

#supplierName{
    margin-top:20px;
    margin-left:30px;
    width: 440px;
    font-size: 15px;
    font-weight: bolder;
    text-transform: capitalize;
    height: 40px;
    background-color:blanchedalmond;
}

#supplierId{
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

#grnNumber{
    margin-top:20px;
    margin-left: 5px;
    width: 150px;
    font-size: 13px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
    background-color:blanchedalmond;
}

#invoiceNumber{
    margin-top:-2px;
    margin-left:-5px;
    width: 150px;
    font-size: 13px;
    font-weight: bold;
    text-transform: capitalize;
    height: 40px;
    background-color:blanchedalmond;
}
#dcNumber{
    margin-top:-2px;
    margin-left:-5px;
    width: 150px;
    font-size: 13px;
    font-weight: bold;
    text-transform: capitalize;
    height: 40px;
    background-color:blanchedalmond;
}

#fromDate,#toDate{
    margin-top:-2px;
    margin-left:10px;
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


<div id="response_message_supplier_form">

</div>



<form action="" id="frm" method="post">
<div class="" style="margin-left:480px;border:1px solid black;width:800px;height:160px;margin-top:5px;">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab">Purchase Report</button>
            </li>
            
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <div style="margin-top:-20px;margin-left:-12px">
                    <div style="display:flex;gap:12px">
                            <div class="form-floating">
                            <input type="text"  name="supplierName" autocomplete="off" id="supplierName"  class="form-control"  value="">
                            <label for="supplierName" style="padding-left:40px;padding-top:30px;font-weight:bolder">Supplier Info</label>
                            </div>
                            
                            <input type="text" name="supplierId" id="supplierId" class="form-control">
                            
                            <div style="margin-top:22px;display:flex;">
                            
                            
                            <div class="form-floating">
                                <input type="date" name="fromDate" id="fromDate" class="form-control" placeholder="DC Date" value="" autocomplete="off" maxlength="20">
                                <label for="fromDate" style="margin-top:-10px">From Date</label>
                            </div>          
                            <div class="form-floating">
                                <input type="date" name="toDate" id="toDate" class="form-control" placeholder="Invoice Date" value="" autocomplete="off">
                                <label for="toDate" style="margin-top:-10px;">To Date</label>
                            </div>          
                            </div>
                    </div>
                    </div>
                        <div style="display:flex;margin-left:20px;margin-top:-5px">
                        <input type="radio" name="option" id="radio1" value="grnRadio" checked style="margin-top:22px">
                        

                                <div class="form-floating" style="font-size: 12px;">
                                    <input type="text" name="grnNumber" id="grnNumber"  class="form-control" placeholder="Press F2 For GRN Info" style="height: 40px;font-size:12px;font-weight:bolder;padding-left:3px" autocomplete="off"  maxlength="11" value="">
                                    <label for="grnNumber" style="margin-top:14px;">GRN </label>
                                </div>
                                
                                <!-- hidden search button is used to trigger click event through code to fetch grn number-->
                                <!-- <button type="submit" name="grnNumberSearchButton" id="grnSearchButton" style="width:22px;height:25px;position:absolute;right:20px;top:130px;">S</button> -->
                                <div style="display:flex;gap:10px;margin-top:22px">
                                <input type="radio" name="option" id="radio2" value="invoiceRadio" style="margin-left:30px">
                                    <div class="form-floating">
                                        <input type="text" name="invoiceNumber" id="invoiceNumber"  class="form-control" placeholder="Invoice Number" value="" autocomplete="off"  maxlength="30">
                                        <label for="invoiceNumber" style="margin-top:-10px">Invoice Number </label>
                                    </div>          
                                    <input type="radio" name="option" id="radio3" value="dcRadio" style="margin-left:20px">
                                    <div class="form-floating">
                                        
                                        <input type="text" name="dcNumber"  id="dcNumber" class="form-control" placeholder="DC Number" value="" autocomplete="off" maxlength="20">
                                        <label for="DCNumber" style="margin-top:-10px">DC Number </label>
                                    </div>          
                                    <button type="submit" name="searchButton" id="searchButton" class="btn btn-primary" style="width: 200px;">Search</button>
                                </div>
                                
                        </div>
                        
                    
                
            
            </div>
            </div>
            
</div>
</form>

<form action="" id="exportForm" method="post" target="">
<select name="billType" id="billType" class="form-control" style="width:155px;">
<!-- <option value="">--Select File Type--</option> -->
<option value="purchaseBill">Purchase Bill</option>
<option value="purchaseSummary">Purchase Summary</option>
<option value="purchaseItem">Purchase Item</option>
</select>
<button type="submit" name="exportButton" class="btn btn-primary" style="width: 65px;padding-left:9px">Export</button>
</form>

<form action="">
<!-- <label for=""  id="purchaseReport">PURCHASE REPORT</label> -->

<div id="purchaseSummaryTable" style="margin-top:-10px">
    
<div style="margin-left: 265px; font-size: 11px;">
    <div style="width: 1240px; height: 260px; overflow-y: auto;overflow-x:auto" id="itemTable">
        <table class="table text-white" style="border-collapse: collapse; width: 1800px; text-align: center;font-size:12px">
            <thead>
                <tr style="position: sticky; z-index: 1; top: 0; background-color: #FF3CAC;">
                    <th style="width: 20px;">S.No.</th>
                    <th style="width: 50px; text-align: left;">GRN</th>
                    <th style="width: 250px;">GRN Date</th>
                    <th style="width: 300px;">Supplier Name</th>
                    <th style="width: 180px;">Invoice Number</th>
                    <th style="width: 130px;">Invoice Date</th>
                    <th style="width: 150px;">DC Number</th>
                    <th style="width: 140px;">DC Date</th>
                    <th style="width: 5px;">Qty</th>
                    <th style="width: 200px;">Taxable Amount</th>
                    <th style="width: 180px;">CGST Amount</th>
                    <th style="width: 180px;">SGST Amount</th>
                    <th style="width: 160px;">IGST Amount</th>
                    <th style="width: 120px;">Add On</th>
                    <th style="width: 120px;">Deduction</th>
                    <th style="width: 120px;">Net Amount</th>
                </tr>
            </thead>
            <tbody id="table_body" class="items">
                <?php 
                if(isset($resultSearchPurchaseSum)) {
                    $sno = 1;
                    while ($purchaseSumDat = $resultSearchPurchaseSum->fetch_assoc()) { ?>
                        <tr onclick="itemDetails('<?php echo $purchaseSumDat['grn_number']; ?>', '<?php echo $purchaseSumDat['supplier_id'] ?>')">
                            <td><?php echo $sno++; ?></td>
                            
                            <td style="text-align: left;"><?php echo htmlspecialchars($purchaseSumDat['grn_number']); ?></td>
                            <td><?php echo htmlspecialchars(date("d-m-Y h:i:s A",strtotime($purchaseSumDat['grn_date']))); ?></td>
                            <td style="text-align:left;"><?php echo htmlspecialchars($purchaseSumDat['supplier_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumDat['invoice_number']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumDat['invoice_date']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumDat['dc_number']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumDat['dc_date']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumDat['total_qty']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumDat['total_amount']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumDat['cgst_amount']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumDat['sgst_amount']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumDat['igst_amount']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumDat['addon']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumDat['deduction']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumDat['net_amount']); ?></td>
                        </tr>
                <?php } 
                }?>
                <?php if(isset($resultTotalPurchaseSummary)){
                        $totalPurchaseSumData = $resultTotalPurchaseSummary->fetch_assoc()
                        
                        
                 ?>
                <tr style="font-weight: bolder;font-size:15px">
                    <td><?php echo "Total" ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $totalPurchaseSumData['tqty']; ?></td>
                    <td><?php echo $totalPurchaseSumData['tamount'];?></td>
                    <td><?php echo $totalPurchaseSumData['tcgst'];?></td>
                    <td><?php echo $totalPurchaseSumData['tsgst'];?></td>
                    <td><?php echo $totalPurchaseSumData['tigst'];?></td>
                    <td><?php echo $totalPurchaseSumData['taddon'];?></td>
                    <td><?php echo $totalPurchaseSumData['tdeduction'];?></td>
                    <td><?php echo $totalPurchaseSumData['tnetamount'];?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>


</div>


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
        
       
        <!-- <div style="margin-left: 165px; font-size: 11px;" >
    <div style="width: 1250px; height: 220px; overflow-y: auto;overflow-x:auto" id="itemTable">
        <table class="table text-white" style="border-collapse: collapse; width: 100%; text-align: center;font-size:13px">
            <thead>
                <tr style="position: sticky; z-index: 1; top: 0; background-color: #FF3CAC;">
                    <th style="width: 40px;">S.No.</th>
                    <th style="width: 90px; text-align: left;">Product</th>
                    <th style="width: 130px;">Brand</th>
                    <th style="width: 150px;">Design</th>
                    <th style="width: 10px;">Color</th>
                    <th style="width: 10px;">Batch</th>
                    <th style="width: 10px;">Category</th>
                    <th style="width: 20px;">HSN</th>
                    <th style="width: 20px;">Tax</th>
                    <th style="width: 20px;">Size</th>
                    <th style="width: 20px;">MRP</th>
                    <th style="width: 20px;">Selling</th>
                    <th style="width: 20px;">Rate</th>
                    <th style="width: 20px;">Qty</th>
                    <th style="width: 20px;">Amount</th>
                    <th style="width: 20px;">Id</th>
                </tr>
            </thead>
            <tbody id="table_body" class="items">
                <?php 
                if(isset($_SESSION['resultSearchPurchaseSummaryItem']) && isset($grnNumberSearchButton)) {
                    $sno = 1;
                    foreach ($_SESSION['resultSearchPurchaseSummaryItem'] as $purchaseSumData) { ?>
                        <tr>
                            <td><?php echo $sno++; ?></td>
                            <td style="text-align: left;"><?php echo htmlspecialchars($purchaseSumData['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['brand_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['design_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['color_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['batch_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['hsn_code']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['tax_code']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['size_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['mrp']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['selling_price']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['rate']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['item_qty']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['item_amount']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['item_id']); ?></td>
                        </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
</div> -->

    <br>
    
    

</div>


</form>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    
    function itemDetails(grnNumber,supplierName){
        
        let grnNumber_supplierName = [grnNumber,supplierName];
        
        let grnData = new FormData();
        grnData.append('aj_grn_details',JSON.stringify(grnNumber_supplierName));
        let ajaxGRN = new XMLHttpRequest();
        ajaxGRN.open("post","ajaxGetItemDetailsOfGRN.php", true);
        ajaxGRN.send(grnData);
        
        ajaxGRN.onreadystatechange = function(){
            if(ajaxGRN.status === 200 && ajaxGRN.readyState === 4){
            
                document.getElementById('response_message').innerHTML = ajaxGRN.responseText;
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
    
    document.getElementById("grnNumber").addEventListener("keydown", function(event){
            let target  = event.target;
            let supplierId = document.getElementById("supplierId").value || '';
            let fromDate = document.getElementById('fromDate').value || '';
            let toDate = document.getElementById('toDate').value || '';
            
            if(event.key === "F2"){
                event.preventDefault();
                let grnNumber = new FormData();
                let data = [target.value,supplierId,fromDate,toDate]
                
                grnNumber.append("lb_grn_number",JSON.stringify(data));
                let aj_grn = new XMLHttpRequest();
                aj_grn.open("POST","ajaxPurchaseReport.php",true);
                aj_grn.send(grnNumber);
                aj_grn.onreadystatechange = function(){
                    if(aj_grn.status === 200 && aj_grn.readyState === 4){
                            document.getElementById("response_message").innerHTML = aj_grn.responseText;
                             
                
                    }
                }
                
            }
            
    })
    
    document.getElementById("invoiceNumber").addEventListener("keydown", function(event){
            let target  = event.target;
            let supplierId = document.getElementById('supplierId').value;
            let fromDate = document.getElementById('fromDate').value || '';
            let toDate = document.getElementById('toDate').value || '';
            
            if(event.key === "F2"){
                event.preventDefault();
                let grnNumber = new FormData();
                let data = [target.value, supplierId,fromDate,toDate]
                grnNumber.append("lb_invoice_number", JSON.stringify(data));
                let aj_grn = new XMLHttpRequest();
                aj_grn.open("POST","ajaxPurchaseReport.php",true);
                aj_grn.send(grnNumber);
                aj_grn.onreadystatechange = function(){
                    if(aj_grn.status === 200 && aj_grn.readyState === 4){
                            document.getElementById("response_message").innerHTML = aj_grn.responseText;
                             
                
                    }
                }
                
            }
            
    })
    
    document.getElementById("dcNumber").addEventListener("keydown", function(event){
            let target  = event.target;
            let supplierId = document.getElementById('supplierId').value;
            let fromDate = document.getElementById('fromDate').value || '';
            let toDate = document.getElementById('toDate').value || '';
            if(event.key === "F2"){
                event.preventDefault();
                let grnNumber = new FormData();
                let data = [target.value,supplierId,fromDate,toDate]
                grnNumber.append("lb_dc_number", JSON.stringify(data));
                let aj_grn = new XMLHttpRequest();
                aj_grn.open("POST","ajaxPurchaseReport.php",true);
                aj_grn.send(grnNumber);
                aj_grn.onreadystatechange = function(){
                    if(aj_grn.status === 200 && aj_grn.readyState === 4){
                            document.getElementById("response_message").innerHTML = aj_grn.responseText;
                             
                
                    }
                }
                
            }
            
    })
    

document.getElementById("supplierName").addEventListener("keydown", function(event){
        let target = event.target;
        
    if(event.key === "F2"){
        event.preventDefault();
        
        
        let supplierName = new FormData();
        supplierName.append("lb_supplier_name",target.value);
        let aj_supplier =  new XMLHttpRequest();
        aj_supplier.open("POST","ajaxPurchaseReport.php",true);
        aj_supplier.send(supplierName);
        
        aj_supplier.onreadystatechange = function(){
            if(aj_supplier.status === 200 && aj_supplier.readyState === 4){
            document.getElementById("response_message").innerHTML = aj_supplier.responseText;
            document.getElementById("response_message").style.display = "block";

                
            }
        }
        
    
    }

})

    
    
    document.getElementById('supplierName').addEventListener('keydown',function(e){
       
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
        
        let grn  = document.getElementById('grnNumber');
        let invoice  = document.getElementById('invoiceNumber');
        let dc  = document.getElementById('dcNumber');
        if(e.key === "Enter"){
            e.preventDefault();
            // Focus on the first enabled field
        if (!grn.disabled) {
            grn.focus();
        } else if (!invoice.disabled) {
            invoice.focus();
        } else if (!dc.disabled) {
            dc.focus();
        }
        }
    })
    document.getElementById('grnNumber').addEventListener('keydown',function(e){
        
        if(e.key === "Enter"){
            e.preventDefault();
            document.getElementById('searchButton').focus();
        }
    })
    
    document.getElementById('invoiceNumber').addEventListener('keydown',function(e){
        
        if(e.key === "Enter"){
            e.preventDefault();
            document.getElementById('searchButton').focus();
        }
    })
    
    document.getElementById('dcNumber').addEventListener('keydown',function(e){
        
        if(e.key === "Enter"){
            e.preventDefault();
            document.getElementById('searchButton').focus();
        }
    })
    
    window.onload = function(){
        
        // document.getElementById("supplierName").value = "";
        document.getElementById("supplierName").focus();
        
        
        
        
        
        document.getElementById('invoiceNumber').disabled = true;
        document.getElementById('dcNumber').disabled =true;
        
        
        
        let supplierName = document.getElementById("supplierName").value;
        
        
        
        
        
        
        
        
        localStorage.setItem("total_rows",1);
        let myDate = new Date();
        
        let fromDate = myDate.getFullYear() + "-" + 
                         (myDate.getMonth() + 1).toString().padStart(2, "0") + "-" + "01";
                          
        let currentDate = myDate.getFullYear() + "-" + 
                         (myDate.getMonth() + 1).toString().padStart(2, "0") + "-" + 
                          myDate.getDate().toString().padStart(2, "0");
        // document.getElementById("grnDate").value = currentDate;
        document.getElementById("fromDate").value =fromDate;
        document.getElementById("toDate").value =currentDate;
        
        
        
        
    }
    let rowIndex =localStorage.getItem("row_index");
    
    
    




document.getElementById('grnNumber').addEventListener('keypress', function (event) {
        
        const charCode = event.which || event.keyCode; // Get the character code
        const charStr = String.fromCharCode(charCode); // Convert to a string

        // Allow digits (0-9) and a single decimal point
        if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
            event.preventDefault(); // Prevent input if not a number or extra decimal
        }
    });

    document.getElementById('grnNumber').addEventListener('input', function () {
        // Prevent any invalid characters that might slip through (e.g., copy-paste)
        this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
});



setTimeout(() => {
   var alertBox = document.getElementById("liveToast");
    if(alertBox){
        alertBox.style.display='none';
    }
}, 2000);


document.getElementById('radio1').addEventListener('click', function(e){
    
    document.getElementById('grnNumber').disabled = false;
    document.getElementById('grnNumber').focus();
    
    document.getElementById('invoiceNumber').value ="";
    document.getElementById('invoiceNumber').disabled = true;
    
    document.getElementById('dcNumber').disabled = true;
    document.getElementById('dcNumber').value ="";
    
})

document.getElementById('radio2').addEventListener('click', function(e){
    
    document.getElementById('invoiceNumber').disabled = false;
    document.getElementById('invoiceNumber').focus();
    
    document.getElementById('grnNumber').value ="";
    document.getElementById('grnNumber').disabled = true;
    
    document.getElementById('dcNumber').disabled = true;
    document.getElementById('dcNumber').value = "";
})

document.getElementById('radio3').addEventListener('click', function(e){
    
    document.getElementById('dcNumber').disabled = false;
    document.getElementById('dcNumber').focus();
    
    document.getElementById('grnNumber').value ="";
    document.getElementById('grnNumber').disabled = true;
    
    document.getElementById('invoiceNumber').disabled = true;
    document.getElementById('invoiceNumber').value ="";
    
})

</script>

</body>
</html>

<?php
    
if(isset($_POST['deleteButton'])){
    

    $supplierName =  $_POST['supplierName'];
    $supplierId = $_POST['supplierId'];
    $grnAmount = $_POST['grnAmount'];
    $netAmount = $_POST['netAmount'];
    
    if($grnAmount != '' && $grnAmount != 0){
    
    if($grnAmount == $netAmount){
            $grnNumber = $_POST['grnNumber'];
            $grnDate = $_POST['grnDate'];
            $dcNumber = $_POST['dcNumber'];
            $fromDate = $_POST['fromDate'];
            $invoiceNumber = $_POST['invoiceNumber'];
            $toDate = $_POST['toDate'];
            
            
            $updateStockBal = "
            UPDATE stock_balance sb
            JOIN purchase_item pi ON sb.item_id = pi.item_id AND sb.branch_id = pi.branch_id
            SET sb.item_qty = sb.item_qty - pi.item_qty
            WHERE pi.grn_number = ? AND pi.branch_id = ?";
        
            $stmt = $con->prepare($updateStockBal);
            $stmt->bind_param("si", $grnNumber, $userBranchId);
            $stmt->execute();
            $stmt->close();

            
            // $searchGRN = "select*from purchase_item where grn_number = '$grnNumber' and branch_id = '$userBranchId'";
            // $resultSearchGRN = $con->query($searchGRN);
            
            
            // while($grnData = $resultSearchGRN->fetch_assoc()){
            //     $searchStockBal = "update stock_balance set item_qty = item_qty-'$grnData[item_qty]' where item_id = '$grnData[item_id]' and branch_id = '$userBranchId'";
            //     $resultSearchStockBal = $con->query($searchStockBal);
                
            // }
            
            
            $query = "delete from  purchase_summary where grn_number = '$grnNumber' and branch_id = '$userBranchId' ";
                  
                  
        
        $resultQuery = $con->query($query);
        // if($resultQuery){
        //     echo "purchase summary deleted";
        // }else{
        //     echo "oops! something went wrong";
        // }
        
        
        $queryDeletePurchaseItem = "delete from purchase_item where grn_number = '$grnNumber' and branch_id = '$userBranchId'";
        $resultDeletePurchaseItem = $con->query($queryDeletePurchaseItem);
        
        $queryDeleteStockTransaction = "delete from stock_transaction where grn_number = '$grnNumber' and branch_id = '$userBranchId'";
        $resultDeleteStockTransaction = $con->query($queryDeleteStockTransaction);
        $a=0;
            if($resultQuery && $resultDeletePurchaseItem && $resultDeleteStockTransaction){
                
                $_SESSION['notification'] = "Purchase Deleted Successfully";            
                header("Location:".BASE_URL."/pages/purchaseDelete.php");
                
            }else{
                echo "something went wrong";
            }
    
    
    // }else{
    //     $_SESSION['notification'] = "GRN Amount And Net Amount Does Not Match";
    //     header("Location:".BASE_URL."/pages/purchaseDelete.php");
    //     if($_SESSION['notification']){
    //         echo '<script>
    //   document.addEventListener("DOMContentLoaded", function() {
    //       let toastElement = new bootstrap.Toast(document.getElementById("liveToast"));
    //       toastElement.show();
    //   });
    // </script>';
    //     }
        
    
            

        }
   }  
}

    

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
