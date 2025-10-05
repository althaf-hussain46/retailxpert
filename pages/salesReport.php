<!-- when i press f2 in salesNumber text field , aalesSummaryTable popup using ajax showing purchase summary of different grn numbers. when i select any particular row from salesSummaryTable all the data from purchase_item pertaining to  that grn number should display  in itemGrid.this code i have written for one row but i want all rows to be append in the itemGrid automatically -->
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
    if($optionSelected == "salesRadio"){
        
        header("Location:".BASE_URL."/exportFile/excelFileFormatSalesSummary.php");
        
    
    }elseif($optionSelected == "salesReturnRadio"){
        header("Location:".BASE_URL."/exportFile/excelFileFormatSalesReturnSummary.php");
    }
    // elseif($optionSelected == "salesItemRadio"){
    //     header("Location:".BASE_URL."/exportFile/excelFileFormatSalesItem.php");
        
    // }
    

}

if(isset($_POST['exportButton'])){
    extract($_POST);
    if($option == "salesItemRadio"){
        header("Location:".BASE_URL."/exportFile/excelFileFormatSalesItem.php");
        
        
    }
    
}



if(isset($_POST['searchButton']))
{       $_SESSION['customerName'] = $_POST['customerName'];
        $optionSelected = $_SESSION['optionSelected'] = $_POST['option'];
        $fromDate = $_SESSION['fromDate'] = $_POST['fromDate'];
        $toDate = $_SESSION['toDate'] = $_POST['toDate'];
        $customerId = $_SESSION['customerId'] =$_POST['customerId'];
        $salesNumber = $_SESSION['salesNumber'] = isset($_POST['salesNumber']) ? $_POST['salesNumber'] : "";
        $salesReturnNumber = $_SESSION['salesReturnNumber'] = isset($_POST['salesReturnNumber']) ? $_POST['salesReturnNumber'] : "";
        
        
        
        
        if($optionSelected=="salesRadio"){
            $querySearchSalesAndSalesReturnSum = "SELECT 
            ss.sales_number, ss.sales_date, ss.counter_name, ss.s_qty, ss.s_taxable_amount,
            ss.s_tax_amount,ss.sales_return_amount, ss.s_net_amount, ss.customer_id, ss.user_id,
            c.customer_name,
            sr.sr_taxable_amount, sr.sr_tax_amount
            FROM sales_summary AS ss
            LEFT JOIN customers AS c ON c.id = ss.customer_id
            LEFT JOIN sales_return_summary AS sr ON sr.sr_number = ss.sales_number
            WHERE ss.sales_number LIKE '%$salesNumber%' AND ss.customer_id LIKE '%$customerId%'
            AND ss.branch_id = '$userBranchId' AND (date(sales_date)  BETWEEN '$fromDate' AND '$toDate') order by sales_number";

            // $querySearchSalesAndSalesReturnSum = "
            // SELECT ss.*, c.*, sr.* 
            // FROM sales_summary AS ss
            // JOIN customers AS c ON c.id = ss.customer_id
            // left join sales_return_summary as sr on sr.sr_number = ss.sales_number
            // WHERE ss.sales_number LIKE '%$salesNumber%' AND ss.customer_id LIKE '%$customerId%'
            // AND ss.branch_id = '$userBranchId' AND (date(sales_date)  BETWEEN '$fromDate' AND '$toDate') order by sales_number";    
            
            $queryTotalSalesAndSalesReturnSummary = "select sum(s_qty) as tqty , sum(s_amount) as tamount,
             sum(s_cgst_amount) as tcgst, sum(s_sgst_amount) as tsgst, sum(s_igst_amount) as tigst,
             sum(s_addon) as taddon, sum(s_deduction) as tdeduction, sum(s_net_amount) as tnetamount,
             sum(sales_return_amount) as tsramount, sum(s_taxable_amount) as ttaxableamount,
             sum(s_tax_amount) as ttaxamount, sum(sales_return_amount) as tsalesreturnamount
             from sales_summary WHERE sales_number LIKE '%$salesNumber%' AND customer_id LIKE '%$customerId%'
            AND branch_id = '$userBranchId' AND (date(sales_date)  BETWEEN '$fromDate' AND '$toDate')";
        
        }elseif($optionSelected=="salesReturnRadio"){
        
            $querySearchSalesAndSalesReturnSum = "
            SELECT srs.*, c.* 
            FROM sales_return_summary AS srs
            JOIN customers AS c ON c.id = srs.customer_id
            WHERE (srs.sr_number LIKE '%$salesReturnNumber%') AND srs.customer_id LIKE '%$customerId%'
            AND srs.branch_id = '$userBranchId' AND (date(sr_date)  BETWEEN '$fromDate' AND '$toDate') order by sr_number";
            
            $queryTotalSalesAndSalesReturnSummary = "select sum(sr_qty) as tqty , sum(sr_amount) as tamount,
             sum(sr_cgst_amount) as tcgst, sum(sr_sgst_amount) as tsgst, sum(sr_igst_amount) as tigst,
             sum(sr_addon) as taddon, sum(sr_deduction) as tdeduction, sum(sr_net_amount) as tnetamount,
            sum(sr_taxable_amount) as ttaxableamount, sum(sr_tax_amount) as ttaxamount 
             from sales_return_summary WHERE sr_number LIKE '%$salesReturnNumber%' AND customer_id LIKE '%$customerId%'
            AND branch_id = '$userBranchId' AND (date(sr_date)  BETWEEN '$fromDate' AND '$toDate')";
            
        }
        
        
        $resultSearchSalesSum = $con->query($querySearchSalesAndSalesReturnSum);
        $resultTotalSalesSummary = $con->query($queryTotalSalesAndSalesReturnSummary);
        
        
        
    
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
$customerName = "";

$salesNumber = "";
$salesDate = "";


$fromDate = "";
$salesReturnNumber = "";
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

if(isset($_POST['salesNumberSearchButton'])){

    extract($_POST);
    echo $customerId;
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
    
    $querySearchSalesItem  = "SELECT 
                                si.*, 
                                i.*
                                FROM sales_item as si
                                INNER JOIN items as i ON si.item_id = i.id
                                WHERE si.sales_number = '$salesNumber' 
                                AND si.branch_id = '$userBranchId'";
    $resultSearchSalesItem = $con->query($querySearchSalesItem);
    $_SESSION['resultSearchSalesSummaryItem'] = $resultSearchSalesItem->fetch_all(MYSQLI_ASSOC);
    
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

#customerName{
    margin-top:20px;
    margin-left:30px;
    width: 440px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    height: 40px;
    background-color:blanchedalmond;
}

#customerId{
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

#salesNumber{
    margin-top:20px;
    margin-left: 5px;
    width: 150px;
    font-size: 13px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
    background-color:blanchedalmond;
}

#salesReturnNumber{
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
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab">Sales Report</button>
            </li>
            
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <div style="margin-top:-20px;margin-left:-12px">
                    <div style="display:flex;gap:12px">
                            <div class="form-floating">
                            <input type="text"  name="customerName" autocomplete="off" id="customerName"  class="form-control"  value="">
                            <label for="customerName" style="padding-left:40px;padding-top:30px;font-weight:bolder;">Customer Info</label>
                            </div>
                            
                            <input type="text" name="customerId" id="customerId" class="form-control">
                            
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
                        <input type="radio" name="option" id="radio1" value="salesRadio" checked style="margin-top:22px">
                        

                                <div class="form-floating" style="font-size: 12px;">
                                    <input type="text" name="salesNumber" id="salesNumber"  class="form-control" placeholder="Press F2 For GRN Info" style="height: 40px;font-size:12px;font-weight:bolder;padding-left:3px" autocomplete="off"  maxlength="11" value="">
                                    <label for="salesNumber" style="margin-top:14px;">Bill  Number </label>
                                </div>
                                
                                <!-- hidden search button is used to trigger click event through code to fetch grn number-->
                                <!-- <button type="submit" name="salesNumberSearchButton" id="grnSearchButton" style="width:22px;height:25px;position:absolute;right:20px;top:130px;">S</button> -->
                                <div style="display:flex;gap:10px;margin-top:22px;margin-left:-20px">
                                <input type="radio" name="option" id="radio2" value="salesReturnRadio" style="margin-left:30px">
                                    <div class="form-floating">
                                        <input type="text" name="salesReturnNumber" id="salesReturnNumber"  class="form-control" placeholder="Invoice Number" value="" autocomplete="off"  maxlength="11">
                                        <label for="salesReturnNumber" style="margin-top:-10px">Bill Return Number </label>
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
        <label>Sales Item</label>
        <input type="radio" name="option" id="radio3" value="salesItemRadio"  style="margin-top:5px;">    
    </div>
<!-- <select name="billType" id="billType" class="form-control" style="width:155px;">-->
<!--<option value="">--Select File Type--</option>-->
<!--<option value="salesItem">Sales Item</option>-->
<!--<option value="salesReturnSummary">Sales Return Summary</option>-->
</select> 
<button type="submit" name="exportButton" class="btn btn-primary" style="width: 150px;padding-left:9px;margin-left:10px;">Export</button>

</form>






<?php if(isset($optionSelected) && $optionSelected == "salesRadio"){?>

<form action="">
<!-- <label for=""  id="purchaseReport">PURCHASE REPORT</label> -->

<div id="salesSummaryTable" style="margin-top:-10px">
    
<div style="margin-left: 265px; font-size: 11px;">
    <div style="width: 1240px; height: 260px; overflow-y: auto;overflow-x:auto" id="itemTable">
        <table class="table text-white" style="border-collapse: collapse; width: 1400px;font-size:10px">
            <thead>
                <tr style="position: sticky; z-index: 1; top: 0; background-color: #FF3CAC;">
                    <th style="width:10px">S.No.</th>
                    <th style="width:20px" >Bill Number</th>
                    <th style="width:50px">Bill Date</th>
                    <th style="width:5px;text-align:center;">Counter</th>
                    <th style="width:20px">Customer Name</th>
                    <th style="text-align:right">Qty</th>
                    <th style="text-align:right">Sales Txbl Amt</th>
                    <th style="text-align:right">Sales GST Amt</th>
                    <th style="text-align:right">Sales Total Amt</th>
                    <th style="text-align:right">S.R Txbl Amt</th>
                    <th style="text-align:right">S.R GST Amt</th>
                    <th style="text-align:right">S.R Total Amt</th>
                    <th style="text-align:right">Bill Txbl Amt</th>
                    <th style="text-align:right">Bill GST Amt</th>
                    <th style="text-align:right">Bill Amount</th>
                    <th style="text-align:right">User Id</th>
                </tr>
            </thead>
            <tbody id="table_body" class="items">
                <?php 
                if(isset($resultSearchSalesSum)) {
                    $sno = 1;
                    $salesTotalAmount = 0;
                    $salesReturnTotalAmount = 0;
                    while ($salesSumDat = $resultSearchSalesSum->fetch_assoc()) {
                        $salesTotalAmount = $salesTotalAmount+$salesSumDat['s_taxable_amount']+$salesSumDat['s_tax_amount'];
                        $salesReturnTotalAmount = $salesReturnTotalAmount+$salesSumDat['sales_return_amount'];
                    ?>
                        <tr onclick="itemDetails('<?php echo $salesSumDat['sales_number']; ?>', '<?php echo $salesSumDat['customer_id'] ?>')">
                            <td><?php echo $sno++; ?></td>
                            
                            <td style="width:20px"><?php echo htmlspecialchars($salesSumDat['sales_number']); ?></td>
                            <td style="width:150px"><?php echo htmlspecialchars(date("d-m-Y h:i:s A",strtotime($salesSumDat['sales_date']))); ?></td>
                            <td style="width:20px;text-align:center"><?php echo htmlspecialchars($salesSumDat['counter_name']); ?></td>
                            <td style="width:140px"><?php echo htmlspecialchars($salesSumDat['customer_name']); ?></td>
                            <td style="width:20px;text-align: right;"><?php echo htmlspecialchars($salesSumDat['s_qty']); ?></td>
                            <td style="width:110px;text-align: right;"><?php echo htmlspecialchars($salesSumDat['s_taxable_amount']); ?></td>
                            <td style="width:100px;text-align: right;"><?php echo htmlspecialchars($salesSumDat['s_tax_amount']); ?></td>
                            <td style="width:110px;text-align: right;"><?php echo htmlspecialchars(round($salesSumDat['s_taxable_amount']+$salesSumDat['s_tax_amount'])); ?></td>
                            <td style="width:110px;text-align: right;"><?php echo htmlspecialchars($salesSumDat['sr_taxable_amount']); ?></td>
                            <td style="width:90px;text-align: right;"><?php echo htmlspecialchars($salesSumDat['sr_tax_amount']); ?></td>
                            <td style="width:130px;text-align: right;"><?php echo htmlspecialchars($salesSumDat['sales_return_amount']); ?></td>
                            <td style="width:110px;text-align: right;"><?php echo htmlspecialchars($salesSumDat['s_taxable_amount']); ?></td>
                            <td style="width:90px;text-align: right;"><?php echo htmlspecialchars($salesSumDat['s_tax_amount']); ?></td>
                            <td style="width:90px;text-align: right;"><?php echo htmlspecialchars($salesSumDat['s_net_amount']); ?></td>
                            <td style="width:90px;text-align: right;"><?php echo htmlspecialchars($salesSumDat['user_id']); ?></td>
                        </tr>
                <?php } 
                }?>
                <?php if(isset($resultTotalSalesSummary)){
                        $totalSalesSumData = $resultTotalSalesSummary->fetch_assoc()
                        
                        
                 ?>
                <tr style="font-weight: bolder;font-size:15px">
                    <td><?php echo "Total" ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;"><?php echo $totalSalesSumData['tqty']; ?></td>
                    <td style="text-align: right;"><?php echo $totalSalesSumData['ttaxableamount']; ?></td>
                    <td style="text-align: right;"><?php echo $totalSalesSumData['ttaxamount']; ?></td>
                    <td style="text-align: right;"><?php echo round($salesTotalAmount); ?></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;"><?php echo $salesReturnTotalAmount; ?></td>
                    <td style="text-align: right;"><?php echo $totalSalesSumData['tnetamount'];?></td>
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
        
       


</form>

<?php }elseif(isset($optionSelected) && $optionSelected == "salesReturnRadio"){?>

<form action="">
<!-- <label for=""  id="purchaseReport">PURCHASE REPORT</label> -->

<div id="salesSummaryTable" style="margin-top:-10px">
    
<div style="margin-left: 265px; font-size: 11px;">
    <div style="width: 1240px; height: 260px; overflow-y: auto;overflow-x:auto" id="itemTable">
        <table class="table text-white" style="border-collapse: collapse; width: 1240px;font-size:12px">
            <thead>
                <tr style="position: sticky; z-index: 1; top: 0; background-color: #FF3CAC;">
                    <th style=>S.No.</th>
                    <th style="width:20px;">Bill Return No.</th>
                    <th style="width:50px;">Bill Return Date</th>
                    <th style="width:5px;text-align:center;">Counter</th>
                    <th style="width:20px">Customer Name</th>
                    <th style="text-align:right">Qty</th>
                    <th style="text-align:right">Taxable Amount</th>
                    <th style="text-align:right">Tax Amount</th>
                    <th style="text-align:right">Bill Return Amt</th>
                    <th style="text-align:right">User Id</th>
                </tr>
            </thead>
            <tbody id="table_body" class="items">
                <?php 
                if(isset($resultSearchSalesSum)) {
                    $sno = 1;
                    while ($salesSumDat = $resultSearchSalesSum->fetch_assoc()) { ?>
                        <tr onclick="itemDetails('<?php echo $salesSumDat['sr_number']; ?>', '<?php echo $salesSumDat['customer_id'] ?>')">
                            <td style="width: 20px;"><?php echo $sno++; ?></td>
                            <td style="width:20px"><?php echo htmlspecialchars($salesSumDat['sr_number']); ?></td>
                            <td style="width:100px"><?php echo htmlspecialchars($salesSumDat['sr_date']); ?></td>
                            <td style="width:20px;text-align:center"><?php echo htmlspecialchars($salesSumDat['counter_name']); ?></td>
                            <td style="width:140px;text-align: left;"><?php echo htmlspecialchars($salesSumDat['customer_name']); ?></td>
                            <td style="width:20px;text-align:right"><?php echo htmlspecialchars($salesSumDat['sr_qty']); ?></td>
                            <td style="width:90px;text-align:right"><?php echo htmlspecialchars($salesSumDat['sr_taxable_amount']); ?></td>
                            <td style="width:90px;text-align:right"><?php echo htmlspecialchars($salesSumDat['sr_tax_amount']); ?></td>
                            <td style="width:90px;text-align:right"><?php echo htmlspecialchars($salesSumDat['sr_net_amount']); ?></td>
                            <td style="width:90px;text-align:right"><?php echo htmlspecialchars($salesSumDat['user_id']); ?></td>
                            
                            
                            
                            
                        </tr>
                <?php } 
                }?>
                <?php if(isset($resultTotalSalesSummary)){
                        $totalSalesSumData = $resultTotalSalesSummary->fetch_assoc()
                        
                        
                 ?>
                <tr style="font-weight: bolder;font-size:15px">
                    <td><?php echo "Total" ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                    <td style="text-align: right;"><?php echo $totalSalesSumData['tqty']; ?></td>
                    <td style="text-align: right;"><?php echo $totalSalesSumData['ttaxableamount']; ?></td>
                    <td style="text-align: right;"><?php echo $totalSalesSumData['ttaxamount']; ?></td>
                    <td style="text-align: right;"><?php echo $totalSalesSumData['tnetamount'];?></td>
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

    <div id="salesSummaryTable" style="margin-top:-10px">
    
    <div style="margin-left: 265px; font-size: 11px;">
    <div style="width: 1240px; height: 260px; overflow-y: auto;overflow-x:auto" id="itemTable">
        <table class="table text-white" style="border-collapse: collapse; width: 1240px;font-size:12px">
                <thead>
                    <tr style="position: sticky; z-index: 1; top: 0; background-color: #FF3CAC;">
                        <th style=>S.No.</th>
                        <th style= >Bill Number</th>
                        <th style=>Bill Date</th>
                        <th style=>Counter</th>
                        <th style=>Customer Name</th>
                        <th style="text-align:right">Qty</th>
                        <th style="text-align:right">Bill Amount</th>
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
    
    function itemDetails(salesNumber,customerName){
        
        let salesNumber_customerName = [salesNumber,customerName];
        
        let salesData = new FormData();
        salesData.append('aj_sales_sr_details',JSON.stringify(salesNumber_customerName));
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
    
    document.getElementById("salesNumber").addEventListener("keydown", function(event){
            let target  = event.target;
            let customerId = document.getElementById("customerId").value || '';
            let fromDate = document.getElementById('fromDate').value || '';
            let toDate = document.getElementById('toDate').value || '';
            
            if(event.key === "F2"){
                event.preventDefault();
                let salesNumber = new FormData();
                let data = [target.value,customerId,fromDate,toDate]
                
                salesNumber.append("lb_sales_number",JSON.stringify(data));
                let aj_grn = new XMLHttpRequest();
                aj_grn.open("POST","ajaxSalesReport.php",true);
                aj_grn.send(salesNumber);
                aj_grn.onreadystatechange = function(){
                    if(aj_grn.status === 200 && aj_grn.readyState === 4){
                            document.getElementById("response_message").innerHTML = aj_grn.responseText;
                             
                
                    }
                }
                
            }
            
    })
    
    document.getElementById("salesReturnNumber").addEventListener("keydown", function(event){
            let target  = event.target;
            let customerId = document.getElementById('customerId').value;
            let fromDate = document.getElementById('fromDate').value || '';
            let toDate = document.getElementById('toDate').value || '';
            
            if(event.key === "F2"){
                event.preventDefault();
                let salesNumber = new FormData();
                let data = [target.value, customerId,fromDate,toDate]
                salesNumber.append("lb_sales_return_number", JSON.stringify(data));
                let aj_grn = new XMLHttpRequest();
                aj_grn.open("POST","ajaxSalesReport.php",true);
                aj_grn.send(salesNumber);
                aj_grn.onreadystatechange = function(){
                    if(aj_grn.status === 200 && aj_grn.readyState === 4){
                            document.getElementById("response_message").innerHTML = aj_grn.responseText;
                             
                
                    }
                }
                
            }
            
    })
    
    
    

document.getElementById("customerName").addEventListener("keydown", function(event){
        let target = event.target;
        
    if(event.key === "F2"){
        event.preventDefault();
        
        
        let customerName = new FormData();
        customerName.append("lb_customer_name",target.value);
        let aj_customer =  new XMLHttpRequest();
        aj_customer.open("POST","ajaxSalesReport.php",true);
        aj_customer.send(customerName);
        
        aj_customer.onreadystatechange = function(){
            if(aj_customer.status === 200 && aj_customer.readyState === 4){
            document.getElementById("response_message").innerHTML = aj_customer.responseText;
            document.getElementById("response_message").style.display = "block";

                
            }
        }
        
    
    }

})

    
    
    document.getElementById('customerName').addEventListener('keydown',function(e){
       
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
    document.getElementById('salesNumber').addEventListener('keydown',function(e){
        
        if(e.key === "Enter"){
            e.preventDefault();
            document.getElementById('searchButton').focus();
        }
    })
    
    document.getElementById('salesReturnNumber').addEventListener('keydown',function(e){
        
        if(e.key === "Enter"){
            e.preventDefault();
            document.getElementById('searchButton').focus();
        }
    })
    
    
    window.onload = function(){
        
        // document.getElementById("customerName").value = "";
        document.getElementById("customerName").focus();
        
        
        
        
        
        document.getElementById('salesReturnNumber').disabled = true;
        
        
        
        
        let customerName = document.getElementById("customerName").value;
        
        
        
        
        
        
        
        
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
    
    
    




document.getElementById('salesNumber').addEventListener('keypress', function (event) {
        
        const charCode = event.which || event.keyCode; // Get the character code
        const charStr = String.fromCharCode(charCode); // Convert to a string

        // Allow digits (0-9) and a single decimal point
        if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
            event.preventDefault(); // Prevent input if not a number or extra decimal
        }
    });

    document.getElementById('salesNumber').addEventListener('input', function () {
        // Prevent any invalid characters that might slip through (e.g., copy-paste)
        this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
});


document.getElementById('salesReturnNumber').addEventListener('keypress', function (event) {
        
        const charCode = event.which || event.keyCode; // Get the character code
        const charStr = String.fromCharCode(charCode); // Convert to a string

        // Allow digits (0-9) and a single decimal point
        if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
            event.preventDefault(); // Prevent input if not a number or extra decimal
        }
    });

    document.getElementById('salesReturnNumber').addEventListener('input', function () {
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
    
    document.getElementById('salesNumber').disabled = false;
    document.getElementById('salesNumber').focus();
    
    document.getElementById('salesReturnNumber').value ="";
    document.getElementById('salesReturnNumber').disabled = true;
    
    
    
})

document.getElementById('radio2').addEventListener('click', function(e){
    
    document.getElementById('salesReturnNumber').disabled = false;
    document.getElementById('salesReturnNumber').focus();
    
    document.getElementById('salesNumber').value ="";
    document.getElementById('salesNumber').disabled = true;
    
    
})



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
