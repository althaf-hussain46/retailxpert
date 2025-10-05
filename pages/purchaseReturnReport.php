<!-- when i press f2 in prNumber text field , aalesSummaryTable popup using ajax showing purchase summary of different grn numbers. when i select any particular row from purchaseReturnSummaryTable all the data from purchase_item pertaining to  that grn number should display  in itemGrid.this code i have written for one row but i want all rows to be append in the itemGrid automatically -->
<style>
#exportForm{
display: flex;
gap:2px;
position: absolute;
top:185px;
left:1085px;

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



if(isset($_POST['exportButton']) && isset($_SESSION['optionSelected'])){
    // extract($_POST);
    $optionSelected  = $_SESSION['optionSelected'];
    if($optionSelected == "purchaseReturnRadio"){
        header("Location:".BASE_URL."/exportFile/excelFileFormatPurchaseReturnItem.php");
    }
    // elseif($optionSelected == "purchaseReturnItemRadio"){
    //     header("Location:".BASE_URL."/exportFile/excelFileFormatSalesItem.php");
        
    // }
    

}





if(isset($_POST['searchButton']))
{       $_SESSION['supplierName'] = $_POST['supplierName'];
        $optionSelected = $_SESSION['optionSelected'] = $_POST['option'];
        $fromDate = $_SESSION['fromDate'] = $_POST['fromDate'];
        $toDate = $_SESSION['toDate'] = $_POST['toDate'];
        $supplierId = $_SESSION['supplierId'] =$_POST['supplierId'];
        $prNumber = $_SESSION['prNumber'] = isset($_POST['prNumber']) ? $_POST['prNumber'] : "";
        $purchaseReturnNumber = $_SESSION['purchaseReturnNumber'] = isset($_POST['purchaseReturnNumber']) ? $_POST['purchaseReturnNumber'] : "";
        
        
        
        
        if($optionSelected=="purchaseReturnRadio"){
        
            $querySearchSalesAndSalesReturnSum = "
            SELECT prs.*, s.* 
            FROM purchase_return_summary AS prs
            JOIN suppliers AS s ON s.id = prs.supplier_id
            WHERE (prs.pr_grn_number LIKE '%$purchaseReturnNumber%') AND prs.supplier_id LIKE '%$supplierId%'
            AND prs.branch_id = '$userBranchId' AND (date(pr_grn_date)  BETWEEN '$fromDate' AND '$toDate') order by pr_grn_number";
            
            $queryTotalSalesAndSalesReturnSummary = "select sum(pr_total_qty) as tqty , sum(pr_total_amount) as tamount,
             sum(pr_cgst_amount) as tcgst, sum(pr_sgst_amount) as tsgst, sum(pr_igst_amount) as tigst,
             sum(pr_addon) as taddon, sum(pr_deduction) as tdeduction, sum(pr_net_amount) as tnetamount
             from purchase_return_summary WHERE pr_grn_number LIKE '%$purchaseReturnNumber%' AND supplier_id LIKE '%$supplierId%'
            AND branch_id = '$userBranchId' AND (date(pr_grn_date)  BETWEEN '$fromDate' AND '$toDate')";
            
        }
        
        
        $resultSearchPurchaseReturnSum = $con->query($querySearchSalesAndSalesReturnSum);
        $resultTotalPurchaseReturnSummary = $con->query($queryTotalSalesAndSalesReturnSummary);
        
        
        
    
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

$prNumber = "";
$salesDate = "";


$fromDate = "";
$purchaseReturnNumber = "";
$toDate = ""; 
$totalQty = "";
$totalAmount = "";
$cgstAmount = "";
$sgstAmount = "";
$igstAmount = "";
$addOnAmount = "";
$deductionAmount = "";
$netAmount = "";
// $resultSearchSalesItem= ""; 

if(isset($_POST['prNumberSearchButton'])){

    extract($_POST);
    echo $supplierId;
    // echo "<br>";
    // echo "grn Number = ".$prNumber;
    // echo "<br>";
    // echo $prNumber;
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
    // echo $purchaseReturnNumber;
    // echo "<br>";
    // echo $toDate;
    
    $querySearchSalesItem  = "SELECT 
                                si.*, 
                                i.*
                                FROM sales_item as si
                                INNER JOIN items as i ON si.item_id = i.id
                                WHERE si.sales_number = '$prNumber' 
                                AND si.branch_id = '$userBranchId'";
    $resultSearchSalesItem = $con->query($querySearchSalesItem);
    $_SESSION['resultSearchPurchaseReturnSummaryItem'] = $resultSearchSalesItem->fetch_all(MYSQLI_ASSOC);
    
    while($data = $resultSearchSalesItem->fetch_assoc()){
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
        
        
        echo $data['sales_number']." ".$data['item_id']." ".$data['product_name']." ".$data['batch_name']." ".$data['color_name'];
        
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
    font-weight: bold;
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



#purchaseReturnNumber{
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


<div id="response_message_customer_form">

</div>



<form action="" id="frm" method="post">
<div class="" style="margin-left:480px;border:1px solid black;width:800px;height:160px;margin-top:5px;">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab">Purchase Return Report</button>
            </li>
            
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <div style="margin-top:-20px;margin-left:-12px">
                    <div style="display:flex;gap:12px">
                            <div class="form-floating">
                            <input type="text"  name="supplierName" autocomplete="off" id="supplierName"  class="form-control"  value="">
                            <label for="supplierName" style="padding-left:40px;padding-top:30px;font-weight:bolder;">Supplier Info</label>
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
                        
                        

                                
                                
                                <!-- hidden search button is used to trigger click event through code to fetch grn number-->
                                <!-- <button type="submit" name="prNumberSearchButton" id="grnSearchButton" style="width:22px;height:25px;position:absolute;right:20px;top:130px;">S</button> -->
                                <div style="display:flex;gap:10px;margin-top:22px;margin-left:-20px">
                                <input type="radio" name="option" id="radio1" value="purchaseReturnRadio" style="margin-left:30px">
                                    <div class="form-floating">
                                        <input type="text" name="purchaseReturnNumber" id="purchaseReturnNumber"  class="form-control" placeholder="Invoice Number" value="" autocomplete="off"  maxlength="11">
                                        <label for="purchaseReturnNumber" style="margin-top:-10px">PR Number </label>
                                    </div>          
                                    
                                    <button type="submit" name="searchButton" id="searchButton" class="btn btn-primary" style="width: 150px;margin-left:5px;">Search</button>
                                </div>
                                
                                
                        </div>
                        
                    
                
            
            </div>
            </div>
            
</div>
</form>

<form action="" id="exportForm" method="post" target="">
    <div style="margin-top:5px;margin-left:-65px;">
        <label>PR Item</label>
        <input type="radio" name="option" id="radio3" value="purchaseReturnItemRadio"  style="margin-top:5px;">    
    </div>
<!-- <select name="billType" id="billType" class="form-control" style="width:155px;">-->
<!--<option value="">--Select File Type--</option>-->
<!--<option value="salesItem">Sales Item</option>-->
<!--<option value="salesReturnSummary">Sales Return Summary</option>-->
</select> 
<button type="submit" name="exportButton" class="btn btn-primary" style="width: 150px;padding-left:9px;margin-left:10px;">Export</button>

</form>







<?php if(isset($optionSelected) && $optionSelected == "purchaseReturnRadio"){?>

<form action="">
<!-- <label for=""  id="purchaseReport">PURCHASE REPORT</label> -->

<div id="purchaseReturnSummaryTable" style="margin-top:-10px">
    
<div style="margin-left: 265px; font-size: 11px;">
    <div style="width: 1240px; height: 260px; overflow-y: auto;overflow-x:auto" id="itemTable">
        <table class="table text-white" style="border-collapse: collapse; width: 1240px;font-size:12px">
            <thead>
                <tr style="position: sticky; z-index: 1; top: 0; background-color: #FF3CAC;">
                    <th style=>S.No.</th>
                    <th style="width:20px;"                 >PR Number</th>
                    <th style="width:50px;"                 >PR Date</th>
                    <th style="width:5px;text-align:center;">Counter</th>
                    <th style="width:20px"                  >Supplier Name</th>
                    <th style="text-align:right"            >Qty</th>
                    <th style="text-align:right"            >Purchase Return Amount</th>
                    <th style="text-align:right"            >User Id</th>
                </tr>
            </thead>
            <tbody id="table_body" class="items">
                <?php 
                if(isset($resultSearchPurchaseReturnSum)) {
                    $sno = 1;
                    while ($purchaseReturnSumDat = $resultSearchPurchaseReturnSum->fetch_assoc()) { ?>
                        <tr onclick="itemDetails('<?php echo $purchaseReturnSumDat['pr_grn_number']; ?>', '<?php echo $purchaseReturnSumDat['supplier_id'] ?>')">
                            <td style="width:10px;"><?php echo $sno++; ?></td>
                            <td style="width:20px"><?php echo htmlspecialchars($purchaseReturnSumDat['pr_grn_number']); ?></td>
                            <td style="width:80px"><?php echo htmlspecialchars($purchaseReturnSumDat['pr_grn_date']); ?></td>
                            <td style="width:20px;text-align:center"><?php echo htmlspecialchars($purchaseReturnSumDat['counter_name']); ?></td>
                            <td style="width:50px;text-align: left;"><?php echo htmlspecialchars($purchaseReturnSumDat['supplier_name']); ?></td>
                            <td style="width:20px;text-align:right"><?php echo htmlspecialchars($purchaseReturnSumDat['pr_total_qty']); ?></td>
                            <td style="width:80px;text-align:right"><?php echo htmlspecialchars($purchaseReturnSumDat['pr_net_amount']); ?></td>
                            <td style="width:50px;text-align:right"><?php echo htmlspecialchars($purchaseReturnSumDat['user_id']); ?></td>
                            
                            
                            
                            
                        </tr>
                <?php } 
                }?>
                <?php if(isset($resultTotalPurchaseReturnSummary)){
                        $totalPurchaseReturnSumData = $resultTotalPurchaseReturnSummary->fetch_assoc()
                        
                        
                 ?>
                <tr style="font-weight: bolder;font-size:15px">
                    <td><?php echo "Total" ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;"><?php echo $totalPurchaseReturnSumData['tqty']; ?></td>
                    <td style="text-align: right;"><?php echo $totalPurchaseReturnSumData['tnetamount'];?></td>
                    <td></td>
                    
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
        
       
        
</div>


</form>

<?php }else{?>

    <div id="purchaseReturnSummaryTable" style="margin-top:-10px">
    
    <div style="margin-left: 265px; font-size: 11px;">
    <div style="width: 1240px; height: 260px; overflow-y: auto;overflow-x:auto" id="itemTable">
        <table class="table text-white" style="border-collapse: collapse; width: 1240px;font-size:12px">
                <thead>
                    <tr style="position: sticky; z-index: 1; top: 0; background-color: #FF3CAC;">
                        <th >S.No.</th>
                        <th style="">PR Number</th>
                        <th style="">Pr Date</th>
                        <th style="text-align:center;">Counter</th>
                        <th style="">Supplier Name</th>
                        <th style="text-align:right">Qty</th>
                        <th style="text-align:right">Purchase Return Amount</th>
                        <th style="text-align:right">User Id</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
        </table>            
       </div>
       </div>
    </div>



<?php }?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    
    function itemDetails(prNumber,supplierName){
        
        let prNumber_supplierName = [prNumber,supplierName];
        
        let salesData = new FormData();
        salesData.append('aj_purchase_return_details',JSON.stringify(prNumber_supplierName));
        let ajaxSales = new XMLHttpRequest();
        ajaxSales.open("post","ajaxGetItemDetailsOfPurchaseReturn.php", true);
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
    
    
    
    document.getElementById("purchaseReturnNumber").addEventListener("keydown", function(event){
            let target  = event.target;
            let supplierId = document.getElementById('supplierId').value;
            let fromDate = document.getElementById('fromDate').value || '';
            let toDate = document.getElementById('toDate').value || '';
            
            if(event.key === "F2"){
                event.preventDefault();
                let prNumber = new FormData();
                let data = [target.value, supplierId,fromDate,toDate]
                prNumber.append("lb_purchase_return_number", JSON.stringify(data));
                let aj_grn = new XMLHttpRequest();
                aj_grn.open("POST","ajaxPurchaseReturnReport.php",true);
                aj_grn.send(prNumber);
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
        let aj_customer =  new XMLHttpRequest();
        aj_customer.open("POST","ajaxPurchaseReturnReport.php",true);
        aj_customer.send(supplierName);
        
        aj_customer.onreadystatechange = function(){
            if(aj_customer.status === 200 && aj_customer.readyState === 4){
            document.getElementById("response_message").innerHTML = aj_customer.responseText;
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
        
        let grn  = document.getElementById('prNumber');
        let invoice  = document.getElementById('purchaseReturnNumber');
        
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
    
    
    
    document.getElementById('purchaseReturnNumber').addEventListener('keydown',function(e){
        
        if(e.key === "Enter"){
            e.preventDefault();
            document.getElementById('searchButton').focus();
        }
    })
    
    
    window.onload = function(){
        
        // document.getElementById("supplierName").value = "";
        document.getElementById("supplierName").focus();
        
        document.getElementById('radio1').setAttribute('checked','true');
        
        
        
        
        
        // document.getElementById('purchaseReturnNumber').disabled = true;
        
        
        
        
        let supplierName = document.getElementById("supplierName").value;
        
        
        
        
        
        
        
        
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
    
    
    







document.getElementById('purchaseReturnNumber').addEventListener('keypress', function (event) {
        
        const charCode = event.which || event.keyCode; // Get the character code
        const charStr = String.fromCharCode(charCode); // Convert to a string

        // Allow digits (0-9) and a single decimal point
        if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
            event.preventDefault(); // Prevent input if not a number or extra decimal
        }
    });

    document.getElementById('purchaseReturnNumber').addEventListener('input', function () {
        // Prevent any invalid characters that might slip through (e.g., copy-paste)
        this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
});


setTimeout(() => {
   var alertBox = document.getElementById("liveToast");
    if(alertBox){
        alertBox.style.display='none';
    }
}, 2000);




// document.getElementById('radio2').addEventListener('click', function(e){
    
//     document.getElementById('purchaseReturnNumber').disabled = false;
//     document.getElementById('purchaseReturnNumber').focus();
    
    
    
    
// })



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
