<?php ob_start(); ?>
<!-- when i press f2 in billNumber text field , PurchaseReturnSummaryTable popup using ajax showing sales summary of different grn numbers. when i select any particular row from PurchaseReturnSummaryTable all the data from sales_item pertaining to  that grn number should display  in itemGrid.this code i have written for one row but i want all rows to be append in the itemGrid automatically -->
<style>

</style>
<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

use function PHPSTORM_META\type;

include_once("../config/config.php");
include_once(DIR_URL . "/includes/header.php");
include_once(DIR_URL . "/db/dbConnection.php");
include_once(DIR_URL . "/includes/navbar.php");
include_once(DIR_URL . "/includes/sidebar.php");

// include_once(DIR_URL."includes/itemMaster.php");
$_SESSION['snos'] = 0;


unset($_SESSION['resultSearchPurchaseReturnItem']);
unset($_SESSION['resultSearchPRI']);
$d = 1;
$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$financial_year = $_SESSION['financial_year'];
$companyState = $_SESSION['company_state'];
$counterName = $_SESSION['counter_name'];
$supplierId = "";
// $querySearchsupplierId = "select*from customers where customer_name = 'CASH'
//                               && branch_id = '$userBranchId'";
// $resultSearchsupplierId = $con->query($querySearchsupplierId)->fetch_assoc();
// if(isset($_SESSION['sales_number'])){
// echo "sales_number = ".$_SESSION['sales_number'];
// }

if (isset($_POST['add'])) {
    // echo "grn number = ".$_POST['sales_number'];
    // $_SESSION['sales_number'] = $_POST['sales_number'];

}

// if(isset($_SESSION['item_id'])){
//     $itemId = $_SESSION['item_id'];
//     echo "item id = ".$itemId;
// }


?>

<script>


</script>






<?php
// $querySearchSnoMaster = "select*from sno_master where financial_year = '$financial_year'
//                          && branch_id='$userBranchId'";
// $resultSearchSnoMaster  = $con->query($querySearchSnoMaster)->fetch_assoc();
// $sales_no = $resultSearchSnoMaster['sales_no'];
// $sales_no = $sales_no+1;

// if(isset($sales_no)){

// }else{
//     $sales_no = "";
// }
$supplierName = "";
$counterName = "";
//sales variables start
$billNumber = "";


$totalQty = "";
$totalAmount = "";
$cgstAmount = "";
$sgstAmount = "";
$igstAmount = "";
$addOnAmount = "";
$deductionAmount = "";
$netAmount = "";
$netDiscountPercent = "";
$deductionAmount = "";
$addOnAmount = "";
$afterAddOn = "";
$salesReturnNetAmount = "";
//purchase  variables end


//purchase return variables start
$pr_billNumber = "";
$pr_date = "";
$pr_dcNumber = "";
$pr_dcDate = "";
$pr_invoiceNumber = "";
$pr_invoiceDate = "";
$pr_totalQty1 = "";
$pr_totalAmount1 = "";
$pr_cgstAmount = "";
$pr_sgstAmount = "";
$pr_igstAmount = "";
$pr_totalActualAmount = "";
$pr_addOnAmount1 = "";
$pr_deductionAmount1 = "";
$pr_netAmount1 = "";
$pr_netDiscountPercent = "";

// $pr_deductionAmount1 = "";
// $pr_addOnAmount1 = "";
$pr_afterAddOn = "";


// $pr_salesReturnNetAmount="";

//purchase return variables end


if (isset($_POST['billNumberSearchButton'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    extract($_POST);

    //sales return searching start
    $querySearchPRI = "SELECT   pri.*,i.*
                       from purchase_return_item as pri
                       join items as i on pri.pr_item_id = i.id
                       where pri.pr_grn_number = '$billNumber' AND pri.branch_id = '$userBranchId'";

    $_SESSION['resultSearchPRI'] = $resultSearchPRI = $con->query($querySearchPRI);


    $querySearchPurchaseReturnSummary = "SELECT*FROM purchase_return_summary where pr_grn_number = '$billNumber' AND branch_id = '$userBranchId'";
    $checkingSearchPurchaseReturnSummary = $con->query($querySearchPurchaseReturnSummary);

    if ($checkingSearchPurchaseReturnSummary->num_rows >= 1) {
        $resultSearchPurchaseReturnSummary = $checkingSearchPurchaseReturnSummary->fetch_assoc();
        $pr_totalQty1 = $resultSearchPurchaseReturnSummary['pr_total_qty'];
        $pr_totalAmount1 = $resultSearchPurchaseReturnSummary['pr_total_amount'];
        $_SESSION['pr_date'] = $pr_date = $resultSearchPurchaseReturnSummary['pr_grn_date'];


        $pr_cgstAmount = $resultSearchPurchaseReturnSummary['pr_cgst_amount'];
        $pr_sgstAmount = $resultSearchPurchaseReturnSummary['pr_sgst_amount'];
        $pr_igstAmount = $resultSearchPurchaseReturnSummary['pr_igst_amount'];
        $pr_afterAddOn = "";
        $pr_addOnAmount1 = $resultSearchPurchaseReturnSummary['pr_addon'];
        $pr_deductionAmount1 = $resultSearchPurchaseReturnSummary['pr_deduction'];
        $pr_netAmount1 = $resultSearchPurchaseReturnSummary['pr_net_amount'];

        while ($salesReturnItemData = $resultSearchPRI->fetch_assoc()) {
        }
    }




    // $afterAddOn = $resultSearchPurchaseReturnSummary['s_'];
    // $pr_salesReturnNetAmount = $resultSearchPurchaseReturnSummary['sales_return_amount'];

    //sales return searching end




    $querySearchPurchaseReturnItem  = "SELECT 
                                purchase_return_item.*, 
                                items.*
                                FROM purchase_return_item
                                INNER JOIN items ON purchase_return_item.pr_item_id = items.id
                                WHERE purchase_return_item.pr_grn_number = '$billNumber' 
                                AND purchase_return_item.branch_id = '$userBranchId'";
    $resultSearchSalesItem = $con->query($querySearchPurchaseReturnItem);

    $querySearchPurchaseReturnSummary = "SELECT*FROM purchase_return_summary where pr_grn_number = '$billNumber' AND branch_id = '$userBranchId'";
    $resultSearchPurchaseReturnSummary = $con->query($querySearchPurchaseReturnSummary)->fetch_assoc();

    $totalQty = $resultSearchPurchaseReturnSummary['pr_total_qty'];
    $totalAmount = $resultSearchPurchaseReturnSummary['pr_total_amount'];
    // $netDiscountPercent = $resultSearchPurchaseReturnSummary['s_amount'];
    $deductionAmount = $resultSearchPurchaseReturnSummary['pr_deduction'];

    $addOnAmount = $resultSearchPurchaseReturnSummary['pr_addon'];
    // $afterAddOn = $resultSearchPurchaseReturnSummary['s_'];

    $netAmount = $resultSearchPurchaseReturnSummary['pr_net_amount'];



    $_SESSION['resultSearchPurchaseReturnItem'] = $con->query($querySearchPurchaseReturnItem)->fetch_all(MYSQLI_ASSOC);

    while ($data = $resultSearchSalesItem->fetch_assoc()) {
        $_SESSION['counter_name'] = $data['counter_name'];
        $id1[] = $data['pr_item_id'];
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
        $qty1[] = $data['pr_item_qty'];

        // echo "<pre>";
        // print_r($qty1);
        // echo "</pre>";
        $amount[] = $data['pr_item_amount'];




        // echo $data['sales_number']." ".$data['s_item_id']." ".$data['product_name']." ".$data['batch_name']." ".$data['color_name'];

        // echo "<br>";

    }
}

if (isset($_POST['submit_button'])) {
    extract($_POST);



    // echo $supplierName;
    // echo "<br>";
    // echo  "Bill Number ".$billNumber;
    // echo "<br>";
    // echo  "Bill Amount".$billAmount;
    // echo "<br>";
    // echo  "DC Number".$dcNumber;
    // echo "<br>";
    // echo  "DC Date".$dcDate;
    // echo "<br>";
    // echo  "Invoice Number".$invoiceNumber;
    // echo "<br>";
    // echo  "Invoice Date".$invoiceDate; 
    // echo "<br>";
    // echo  "Total Qty".$totalQty;
    // echo "<br>";
    // echo  "Total Amount".$totalAmount;
    // echo "<br>";
    // echo  "CGST Amount".$cgstAmount;
    // echo "<br>";
    // echo  "SGST Amount".$sgstAmount;
    // echo "<br>";
    // echo  "IGST Amount".$igstAmount;
    // echo "<br>";
    // echo  "Add On Amount".$addOnAmount;
    // echo "<br>";
    // echo  "Deduction Amount".$deductionAmount;
    // echo "<br>";
    // echo  "Net Amount".$netAmount;
    // echo "<br>";
    // echo  "Net Discount Percent".$netDiscountPercent;
    // echo "<br>";
    // echo  "Sales Return Net Amount".$salesReturnNetAmount;
    $supplierName            =  $_POST['supplierName'];
    $supplierId              = $_POST['supplierId'];
    // $counterName             = $_POST['counterName'];




    $salesNumber = $_SESSION['sales_number'] = $_POST['billNumber'];
    // $salesDate = $_POST['salesDate'];

    date_default_timezone_set("Asia/Kolkata");
    $salesDate = date("Y-m-d h:i:s A");


    // echo "current data and time  = ".$salesDate;

    $netAmount = $_POST['netAmount'];
    // Sales Item  Grid Attributes Start
    $design                         = $_POST['design'];
    $sales_Number                   = $_POST['billNumber'];
    // $salesDate                     = $_POST['salesDate'];
    $sales_itemId                   = $_POST['id'];
    $sales_salesPersonNumber        = $_POST['salesMan'];
    $sales_itemTax                  = $_POST['tax'];
    $sales_itemQty                  = $_POST['qty'];
    $sales_itemDiscountPercent      = $_POST['discountPercent'];
    $sales_itemDiscountAmount       = $_POST['discountAmount'];
    $sales_itemAmount               = $_POST['amount'];
    $sales_itemActualAmount         = $_POST['actualAmount'];
    $sales_itemTaxableAmount        = $_POST['taxable'];
    $sales_itemTaxAmount            = $_POST['taxAmount'];
    $sales_serialNumber             = $_POST['serialNumber'];

    // Sales Item  Grid Attributes End


    // Sales Bill  Attribute Total
    $salesQty                = $_POST['totalQty'];
    $salesTotalAmount        = $_POST['totalAmount'];
    $salesTotalActualAmount  = $_POST['totalActualAmount'];
    $salesTotalTaxableAmount = $_POST['totalTaxable'];
    $salesTotalTaxAmount     = $_POST['totalTaxAmount'];
    $salescgstAmount         = isset($_POST['cgstAmount']) ? $_POST['cgstAmount'] : 0;
    $salessgstAmount         = isset($_POST['sgstAmount']) ? $_POST['sgstAmount'] : 0;
    $salesigstAmount         = isset($_POST['igstAmount']) ? $_POST['igstAmount'] : 0;
    $salesAddonAmount        = isset($_POST['addOnAmount']) ? $_POST['addOnAmount'] : 0;
    $salesDeductionAmount    = isset($_POST['deductionAmount']) ? $_POST['deductionAmount'] : 0;
    $salesReturnAmount       = isset($_POST['salesReturnNetAmount']) ? $_POST['salesReturnNetAmount'] : 0;
    $salesNetAmount          = isset($_POST['netAmount']) ? $_POST['netAmount'] : 0;
    // echo "<br>";
    // echo "sgst".$salescgstAmount     ;
    // echo "<br>";
    // echo "cgst".$salessgstAmount     ;
    // echo "<br>";
    // echo "igst".$salesigstAmount     ;
    // echo "<br>";
    // echo "addon".$salesAddonAmount    ;
    // echo "<br>";
    // echo "deduction".$salesDeductionAmount;
    // echo "<br>";
    // echo "return".$salesReturnAmount   ;
    // echo "<br>";
    // echo "net amount".$salesNetAmount      ;
    // echo "<br>";


    // $queryStockUpdate = "update stock_balance set item_qty = 'item_qty+1'"







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
.nav-tabs .nav-link.active#home-tab {
    background-color: #4CAF50 !important;
    /* Green for Sales */
    color: white !important;
}

.nav-tabs .nav-link.active#profile-tab {
    /*background-color: red !important;  Orange-Red for Sales Return */
    background-color: rgba(214, 46, 16, 0.78) !important;
    /* Orange-Red for Sales Return */
    color: white !important;
}




#PREdit {

    margin-left: 0px;
    margin-top: 0px;
    width: 345px;
    font-size: 14px;
    font-weight: bold;
    text-transform: capitalize;
    padding: 4px 24px;
    height: 30px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    letter-spacing: 5px;
    font-weight: bolder;
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    color: white;
    border-radius: 5px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    /* position:absolute;
    right:370px;top:120px;
    width: 405px;
    font-size: 12px;
    font-weight: bold;
    text-transform: capitalize;
    padding: 4px 68px;
    height: 30px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    letter-spacing:5px;
    font-weight:bolder;
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    color: white;
    border-radius: 5px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); */
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

#serialNumber_1 {

    background-color: #212529;
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
    row-gap: 2px;
    /* Adjust the value as needed */
}

.table-dark tbody tr td {
    padding: 0px !important;
}

.form-floating {
    padding-top: 1px;
    color: #2B86C5;
    font-size: 13px;
}

#itemTable {
    color: white;
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}

#supplierName {
    /* margin-top:-120px; */
    /* margin-left:300px; */
    width: 400px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
    background-color: blanchedalmond;

}

#supplierId {
    margin-top: 10px;
    margin-left: -510px;

    display: none;
    width: 80px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
}



#billNumber,
#billDate {
    margin-top: 20px;
    margin-left: 15px;
    width: 140px;
    font-size: 11px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;

}

#dcNumber,
#dcDate,
#invoiceNumber,
#invoiceDate {
    margin-top: -2px;
    margin-left: 10px;
    width: 150px;
    font-size: 13px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
}
</style>
<!-- Bootstrap Toast -->

<?php
if (isset($_SESSION['notification'])) {
} else {

    $_SESSION['notification'] = "";
}
?>
<?php if (isset($_SESSION['notification']) && $_SESSION['notification'] != '') { ?>
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
<?php } ?>






<!-- JavaScript to trigger toast on form submission -->



<div id="response_message">

</div>


<div id="response_message_supplier_form">

</div>



<form action="" id="frm" method="post">
    <div style="margin-top:10px;">

        <div style="display:flex;gap:12px">
            <label for="" style="margin-left:280px">Supplier Name</label>
            <input type="text" name="supplierName" autocomplete="off" id="supplierName" class="form-control"
                placeholder="Press F2 For Supplier Info" value="<?php echo $supplierName; ?>">
            <input type="text" name="supplierId" id="supplierId" class="form-control"
                value="<?php echo $supplierId; ?>">
            <label for="" id="PREdit">PURCHASE RETURN EDIT</label>
        </div>

        <br>



        <div style="display:flex" hidden>
            <label for="" style="margin-left:200px;">User Id</label>
            <input type="text" name="userId" readonly id="userId" class="form-control" value="<?php echo $userId; ?>"
                style="width:250px;">
            <label for="">Branch Id</label>
            <input type="text" name="userBranchId" readonly id="userBranchId" class="form-control"
                value="<?php echo $userBranchId; ?>" style="width:250px;">
            <label for="">Supplier Id</label>

        </div>
    </div>
    <div class="" style="margin-left:1160px;border:1px solid black;width:340px;height:140px;margin-top:-50px;">

        <!-- Tab Navigation -->

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                    role="tab">PR Bill</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <div style="display:flex;gap:10px;">
                    <input type="text" name="billNumber" id="billNumber" class="form-control"
                        placeholder="Press F2 For PR BIll Info"
                        style="height: 40px;font-size:11px;font-weight:bolder;padding-left:3px;background-color:blanchedalmond;"
                        autocomplete="off" maxlength="11" value="<?php echo isset($billNumber) ? $billNumber : ''; ?>">
                    <!-- <input type="text" name="billNumber" id="billNumber"  class="form-control" placeholder="Press F2 For GRN Info" style="height: 40px;font-size:12px;font-weight:bolder;padding-left:3px" autocomplete="off"  maxlength="11"> -->
                    <button type="submit" name="billNumberSearchButton" id="billNumberSearchButton"
                        style="width:22px;height:25px;position:absolute;right:20px;top:130px;" hidden>S</button>
                    <div class="form-floating">
                        <input type="date" name="billDate" id="billDate" class="form-control" placeholder="Bill Date "
                            value="<?php echo $billDate; ?>" maxlength="30">
                        <label for="billDate" style="margin-left:15px;margin-top:15px;">Bill Date</label>
                    </div>
                </div>

            </div>


        </div>
    </div>





    <!--  Purchase Return Edit Content Here -->






    <div style="margin-left:265px;font-size:12px;margin-top:10px;">
        <div style="width:1235px;height:240px;overflow-y:auto;" id="itemTable">
            <table class="table text-white table-dark"
                style="font-size:11px;border-collapse:collapse;width:100%; text-align:center;">
                <thead>
                    <tr style="position:sticky;z-index:1;top:0;background-color:#FF3CAC;">
                        <th>S.No.</th>
                        <th>Design</th>
                        <th>Description</th>
                        <th>HSN</th>
                        <th>Tax</th>
                        <th>Selling</th>
                        <th>Salesman</th>
                        <th>Qty</th>
                        <th>Disc %</th>
                        <th>Disc.Amt</th>
                        <th>Amount</th>
                        <th hidden>Actual</th>
                        <th hidden>Taxable</th>
                        <th hidden>Tax Amt</th>
                        <th>Id</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="items" id="table_body">
                    <?php
                    if (isset($_SESSION['resultSearchPurchaseReturnItem'])) {
                        $sno = 1;
                        $i = 1;
                        $snos = 1;
                        foreach ($_SESSION['resultSearchPurchaseReturnItem'] as $purchaseReturnItemData) {


                            $itemDescription  = $purchaseReturnItemData['product_name'] . '/' . $purchaseReturnItemData['brand_name'] . '/' .
                                $purchaseReturnItemData['color_name'] . '/' . $purchaseReturnItemData['batch_name'] . '/' . $purchaseReturnItemData['tax_code'] . '/' .
                                $purchaseReturnItemData['size_name'] . '/' . $purchaseReturnItemData['mrp'];

                    ?>
                    <tr>
                        <td>
                            <input type="text" class="serial-field" name="serialNumber[]"
                                id="serialNumber_<?php echo $i; ?>"
                                style="width:45px; height:25px; text-align:center;background-color:#212529;color:white;"
                                maxlength="4" autocomplete="off" value="<?php echo $sno++; ?>" readonly />
                        </td>
                        <td>
                            <input type="text" class="design-field" name="design[]" id="design_<?php echo $i; ?>"
                                autocomplete="off" value="<?php echo $purchaseReturnItemData['design_name']; ?>"
                                style="width:175px; height:25px; text-align:left;background-image: linear-gradient(225deg, white 50%, blanchedalmond 50%);"
                                maxlength="30" placeholder="Press F4 For Item Info"/>
                        </td>
                        <td>
                            <input type="text" class="description-field" name="description[]"
                                id="description_<?php echo $i; ?>" autocomplete="off"
                                value="<?php echo $itemDescription; ?>"
                                style="width:430px; height:25px; text-align:left;" maxlength="150" readonly />
                        </td>
                        <td>
                            <input type="text" class="hsnCode-field" name="hsnCode[]" id="hsnCode_<?php echo $i; ?>"
                                autocomplete="off" value="<?php echo $purchaseReturnItemData['hsn_code']; ?>"
                                style="width:65px; height:25px; text-align:center;" maxlength="8" readonly />
                        </td>
                        <td>
                            <input type="text" class="tax-field" name="tax[]" id="tax_<?php echo $i; ?>"
                                autocomplete="off" value="<?php echo $purchaseReturnItemData['tax_code']; ?>"
                                style="width:35px; height:25px; text-align:center;" maxlength="8" readonly />
                        </td>
                        <td>
                            <input type="text" class="sellingPrice-field" name="sellingPrice[]"
                                id="sellingPrice_<?php echo $i; ?>" autocomplete="off"
                                value="<?php echo $purchaseReturnItemData['selling_price']; ?>"
                                style="width:70px; height:25px; text-align:right;" maxlength="12" readonly />
                        </td>
                        <td>
                            <input type="text" class="salesMan-field" name="salesMan[]" id="salesMan_<?php echo $i; ?>"
                                autocomplete="off" value=""
                                style="width:70px; height:25px; text-align:center;background-color:blanchedalmond;"
                                maxlength="12" />
                        </td>
                        <td>
                            <input type="text" class="qty-field" name="qty[]" id="qty_<?php echo $i; ?>"
                                autocomplete="off" value="<?php echo $purchaseReturnItemData['pr_item_qty']; ?>"
                                style="width:35px; height:25px; text-align:center;" maxlength="5" />
                        </td>
                        <td>
                            <input type="text" class="discountPercent-field" name="discountPercent[]"
                                id="discountPercent_<?php echo $i; ?>" autocomplete="off" value=""
                                style="width:45px; height:25px; text-align:center;" maxlength="4" />
                        </td>
                        <td>
                            <input type="text" class="discountAmount-field" name="discountAmount[]"
                                id="discountAmount_<?php echo $i; ?>" autocomplete="off" value=""
                                style="width:80px; height:25px; text-align:right;" maxlength="10" />
                        </td>
                        <td>
                            <input type="text" class="amount-field" name="amount[]" id="amount_<?php echo $i; ?>"
                                autocomplete="off" value="<?php echo $purchaseReturnItemData['pr_item_amount']; ?>"
                                style="width:85px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                maxlength="13" readonly />
                        </td>
                        <td hidden>
                            <input type="text" class="actualAmount-field" name="actualAmount[]"
                                id="actualAmount_<?php echo $i; ?>" autocomplete="off" value=""
                                style="width:80px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                maxlength="13" readonly />
                        </td>
                        <td hidden>
                            <input type="text" class="taxable-field" name="taxable[]" id="taxable_<?php echo $i; ?>"
                                autocomplete="off" value=""
                                style="width:50px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                maxlength="13" readonly />
                        </td>
                        <td hidden>
                            <input type="text" class="taxAmount-field" name="taxAmount[]"
                                id="taxAmount_<?php echo $i; ?>" autocomplete="off" value=""
                                style="width:10px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                maxlength="13" readonly />
                        </td>
                        <td>
                            <input type="text" class="id-field" name="id[]" id="id_<?php echo $i; ?>" readonly
                                autocomplete="off" value="<?php echo $purchaseReturnItemData['pr_item_id']; ?>"
                                style="width:50px; height:25px; text-align:center; background-color:#212529; color:white; border:1px solid white;" />
                        </td>

                        <?php
                                if ($snos > 1) {
                                ?>
                        <td>
                            <button type="button" id="remove" class="btn btn-danger" title="Remove"
                                style="font-size:8px;margin-left:1px;width:45px">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                        <?php
                                }
                                ?>
                    </tr>
                    <?php
                            $_SESSION['snos'] = $snos++;
                            $i++;
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <br>
    <!-- <button style="padding-top:0px;position:relative;left:1270px;top:143px;width:120px;
            font-weight:bolder;height:30px;font-size:large"
            type="submit" class="btn btn-primary"
            name="submit_button" id="submitButton">Submit</button> -->




    <div>
        <button style="padding-top:0px;position:relative;left:1378px;bottom:-115px;width:120px;
            font-weight:bolder;height:30px;font-size:large" type="submit" class="btn btn-primary" name="update_button"
            id="updateButton">Update</button>
    </div>
    <div>
        <a style="padding-top:0px;position:absolute;right:20px;bottom:102px;width:120px;
                font-weight:bolder;height:30px;font-size:large" class="btn btn-warning" name="cancel_button"
            id="cancelButton" href="<?php echo BASE_URL; ?>/pages/purchaseReturnEdit.php">Cancel</a>
    </div>
    <div style="margin-left:1180px;margin-top:-40px">
        <div style="display:flex;gap:8px">
            <label for="" style="margin-left:-12px">Total</label>
            <input type="text" name="totalQty" id="totalQty" value="<?php echo $totalQty; ?>" class="form-control"
                readonly style="text-align:right;font-size:13px;height:25px;width:50px;" maxlength="4">
            <input type="text" name="totalAmount" id="totalAmount" value="<?php echo $totalAmount; ?>"
                class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
            <input type="text" name="totalActualAmount" id="totalActualAmount" value="<?php echo $totalActualAmount; ?>"
                hidden class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
            <input type="text" name="totalTaxable" id="totalTaxable" value="<?php echo $totalTaxable; ?>" hidden
                readonly style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px"
                class="form-control" maxlength="12">
            <input type="text" name="totalTaxAmount" id="totalTaxAmount" value="<?php echo $totalTaxAmount; ?>" hidden
                readonly style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px"
                class="form-control" maxlength="12">
        </div>
        <div style="display:flex;margin-top:-25px;margin-left:180px" hidden>
            <label for="">CGST</label>
            <input type="text" name="cgstAmount" id="cgstAmount" value="<?php echo $pr_cgstAmount; ?>" readonly
                autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:10px" maxlength="12">
        </div>
        <div style="display:flex;margin-top:5px;margin-left:180px" hidden>
            <label for="">SGST</label>
            <input type="text" name="sgstAmount" id="sgstAmount" value="<?php echo $pr_sgstAmount; ?>" readonly
                autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:10px;" maxlength="12">
        </div>
        <div style="display:flex;margin-top:5px;margin-left:180px" hidden>
            <label for="">IGST</label>
            <input type="text" name="igstAmount" id="igstAmount" value="<?php echo $pr_igstAmount; ?>" readonly
                autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:15px" maxlength="12">
        </div>

        <div style="display:flex;margin-top:8px;margin-left:-11px;gap:2px">
            <label for="">Dis %</label>
            <input type="text" name="netDiscountPercent" id="netDiscountPercent"
                value="<?php echo $netDiscountPercent; ?>" class="form-control" autocomplete="off" maxlength="4"
                style="width:51px;height:25px">
            <!-- <label for="">Discount </label> -->
            <input type="text" name="deductionAmount" id="deductionAmount" value="<?php echo $deductionAmount; ?>"
                autocomplete="off" class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;"
                maxlength="12">
        </div>

        <div style="display:flex;margin-top:5px;">

            <label for="" style="margin-left: -11px;">Add On</label>
            <input type="text" name="addOnAmount" id="addOnAmount" value="<?php echo $addOnAmount; ?>"
                autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:40px" maxlength="12">
        </div>

        <div style="display:flex;margin-top:5px">
            <label for="" style="margin-left:-11px;">After Add On</label>
            <input type="text" name="afterAddOn" id="afterAddOn" value="<?php echo $afterAddOn; ?>" class="form-control"
                readonly style="text-align:right;font-size:12px;height:25px;width:90px;margin-left:1px" maxlength="12">
        </div>


        <div style="display:flex;margin-top:5px;">
            <label for="" style="margin-left: -11px;color:green;font-size:15px;font-weight:bolder;margin-top:2px">Net
                Amount</label>
            <input type="text" name="netAmount" id="netAmount" class="form-control" value="<?php echo $netAmount; ?>"
                readonly
                style="font-weight:bolder;color:green;text-align:right;font-size:15px;height:30px;width:90px;margin-left:8px"
                maxlength="12">

        </div>
    </div>


</form>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
window.onload = function() {

    localStorage.setItem("row_deleted", 0);
}




document.addEventListener("keydown", function(event) {
    if (event.key === "F5") {
        event.preventDefault();

        let confirmRefresh = confirm("Are you sure you want to refresh? Your unsaved data will be lost.");
        if (confirmRefresh) {
            location.reload();
        }
    }
})

document.getElementById("billNumber").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "F2") {
        event.preventDefault();
        let billNumber = new FormData();
        billNumber.append("lb_bill_number", target.value);
        let aj_grn = new XMLHttpRequest();
        aj_grn.open("POST", "ajaxPurchaseReturnBill.php", true);
        aj_grn.send(billNumber);
        aj_grn.onreadystatechange = function() {
            if (aj_grn.status === 200 && aj_grn.readyState === 4) {
                document.getElementById("response_message").innerHTML = aj_grn.responseText;


            }
        }

    } else if (event.key == "Enter") {
        let tab = new bootstrap.Tab(document.getElementById('profile-tab'))
        tab.show();

        setTimeout(() => {
            document.getElementById('invoiceNumber').focus();
            document.getElementById('invoiceNumber').select();
        }, 200)


    }

})


document.getElementById("supplierName").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "F2") {
        event.preventDefault();
        let supplierName = new FormData();
        supplierName.append("lb_supplier_name", target.value);
        let aj_supplier = new XMLHttpRequest();
        aj_supplier.open("POST", "itemStoring.php", true);
        aj_supplier.send(supplierName);

        aj_supplier.onreadystatechange = function() {
            if (aj_supplier.status === 200 && aj_supplier.readyState === 4) {
                document.getElementById("response_message").innerHTML = aj_supplier.responseText;
                document.getElementById("response_message").style.display = "block";


            }
        }


    }

})



function calculateTotalAmount() {
    let totalRow = localStorage.getItem('total_rows');

    let eachRowQty = 0;
    let totalQty = 0;
    let totalAmount = 0;
    let eachRowAmount = 0;

    for (let i = 1; i <= totalRow; i++) {
        // console.log('total row',totalRow)
        // console.log(i);
        eachRowQty = document.getElementById("qty_" + i).value || 0;
        console.log("each row qty = " + eachRowQty);
        // console.log('row qty = ',eachRowQty)
        eachRowAmount = document.getElementById("amount_" + i).value || 0;
        totalQty = parseInt(totalQty) + parseInt(eachRowQty);

        totalAmount = parseFloat(totalAmount) + parseFloat(eachRowAmount);
    }
    document.getElementById("totalQty").value = totalQty;
    document.getElementById("totalAmount").value = parseFloat(totalAmount).toFixed(2);
}


// function calculateNetAmount(){

//                 let totalAmount = document.getElementById('totalAmount').value||0;
//                 let cgstAmount = document.getElementById('cgstAmount').value||0;
//                 let sgstAmount = document.getElementById("sgstAmount").value||0;
//                 let igstAmount = document.getElementById("igstAmount").value||0;
//                 let addOn = document.getElementById("addOnAmount").value||0;
//                 let deduction = document.getElementById("deductionAmount").value||0;
//                 let netAmount = parseFloat(totalAmount)+parseFloat(cgstAmount)+parseFloat(sgstAmount)+parseFloat(igstAmount)+parseFloat(addOn)-parseFloat(deduction);
//                 document.getElementById("netAmount").value = parseFloat(netAmount).toFixed(2);
//                 alert(netAmount);
// }
document.getElementById("cgstAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("sgstAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("igstAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("addOnAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("deductionAmount").addEventListener("focusout", calculateNetAmount);




let totalAmount = 0;

document.getElementById("table_body").addEventListener("focusout", function(event) {
    const target = event.target;

    if (target.name === "qty[]") {
        const currentRow = target.closest('tr');
        const selling = currentRow.querySelector('input[name="sellingPrice[]"]').value || 0;
        const qty = currentRow.querySelector('input[name="qty[]"]').value || 0;
        let amount = currentRow.querySelector('input[name="amount[]"]');
        amount.value = (selling * qty).toFixed(2);
        calculateTotalAmount();
        calculateNetAmount();
        // validateAmounts();
        // let cgstAmount = document.getElementById('cgstAmount').value||0;
        // let sgstAmount = document.getElementById("sgstAmount").value||0;
        // let igstAmount = document.getElementById("igstAmount").value||0;
        // let addOn = document.getElementById("addOnAmount").value||0;
        // let deduction = document.getElementById("deductionAmount").value||0;

        // let netAmount = parseInt(totalAmount)+parseInt(cgstAmount)+parseInt(sgstAmount)+parseInt(igstAmount)+parseInt(addOn)-parseInt(deduction);


        // document.getElementById("netAmount").value = netAmount;
    }


})




// document.getElementById('table_body').addEventListener('input',function(event){
//             let target = event.target;



//             if(target.name == "qty[]"){

//                 let currentRow = target.closest('tr');
//                 let selling  = currentRow.querySelector('input[name="sellingPrice[]"]').value;
//                 let qty = currentRow.querySelector('input[name="qty[]"]').value;
//                 let amount = selling*qty;

//                 currentRow.querySelector('input[name="amount[]"]').value = amount;
//         }




// })

// sales all calculation functions start

function calculateDiscountAmount(target) {
    const currentRow = target.closest('tr');
    const discountAmountField = currentRow.querySelector('input[name="discountAmount[]"]');
    const sellingPriceField = currentRow.querySelector('input[name="sellingPrice[]"]');
    const qtyField = currentRow.querySelector('input[name="qty[]"]');
    const discountPercentField = currentRow.querySelector('input[name="discountPercent[]"]');

    // discountAmountField.value = ((parseFloat(sellingPriceField)*parseInt(qtyField))*(parseFloat(discountPercentField))/100).toFixed(2);
    discountAmountField.value = (
        (parseFloat(sellingPriceField.value || 0) * parseInt(qtyField.value || 0, 10)) *
        (parseFloat(discountPercentField.value || 0) / 100)
    ).toFixed(0);


}

function calculateDiscountPercentage(target) {
    const currentRow = target.closest('tr');
    const selling = currentRow.querySelector('input[name="sellingPrice[]"]').value || 0;
    const qty = currentRow.querySelector('input[name="qty[]"]').value || 0;
    const discountAmount = currentRow.querySelector('input[name="discountAmount[]"]').value || 0;
    let discountPercentage = currentRow.querySelector('input[name="discountPercent[]"]');

    discountPercentage.value = ((parseFloat(discountAmount) / parseFloat(selling)) * 100).toFixed(2);


}

function calculateAmount(target) {
    const currentRow = target.closest('tr');
    const selling = currentRow.querySelector('input[name="sellingPrice[]"]').value || 0;
    const qty = currentRow.querySelector('input[name="qty[]"]').value || 0;
    const discountAmount = currentRow.querySelector('input[name="discountAmount[]"]').value || 0;
    const actualAmount = currentRow.querySelector('input[name="actualAmount[]"]');
    let amount = currentRow.querySelector('input[name="amount[]"]');
    amount.value = ((selling * qty) - discountAmount).toFixed(2);
    actualAmount.value = ((selling * qty)).toFixed(2);
}


function calculateAc() {
    let total_rows = parseInt(localStorage.getItem('total_rows'));

    let eachRowActualAmount = 0;
    let eachRowActualAmountAfterDiscount = 0;
    let eachRowTaxableAmount = 0;
    let eachRowTaxPercentage = 0;
    let eachRowTaxPercentage2 = 0;
    let eachRowTaxAmount = 0;
    let actualTotalAmount = document.getElementById("totalActualAmount").value || 0;
    let netAmount = document.getElementById("netAmount").value || 0;

    let totalTaxable = 0;
    let totalTaxAmount = 0;

    let differenceAmount = parseFloat(actualTotalAmount) - parseFloat(netAmount);
    let differencePercentage = (parseFloat(parseFloat(differenceAmount) / parseFloat(actualTotalAmount)) * 100).toFixed(
        2);

    console.log("difference per = ", differencePercentage)

    for (let i = 1; i <= total_rows; i++) {

        eachRowActualAmount = document.getElementById("actualAmount_" + i).value || 0;

        eachRowTaxPercentage = document.getElementById("tax_" + i).value || 0;
        console.log("actual Amount = ", eachRowActualAmount);
        console.log("tax amount = ", eachRowTaxPercentage);
        eachRowTaxPercentage2 = eachRowTaxPercentage.replace("G", "");

        console.log("each row tax =", eachRowTaxPercentage2)
        console.log("tax type =", typeof(eachRowTaxPercentage2))
        // eachRowActualAmountAfterDiscount = (parseFloat(eachRowActualAmount)-((parseFloat(eachRowActualAmount)*parseFloat(differencePercentage))/100)).toFixed(2)
        eachRowActualAmountAfterDiscount = (parseFloat(eachRowActualAmount) - parseFloat(((parseFloat(
            eachRowActualAmount) * parseFloat(differencePercentage)) / 100))).toFixed(2);

        console.log("actual after discount = ", eachRowActualAmountAfterDiscount)

        // eachRowTaxableAmount = ((parseFloat(eachRowActualAmountAfterDiscount)/parseFloat(eachRowTaxPercentage2+100))*100).toFixed(2)    
        eachRowTaxableAmount = ((parseFloat(eachRowActualAmountAfterDiscount) / parseFloat(parseFloat(
            eachRowTaxPercentage2) + 100)) * 100).toFixed(2);
        console.log("taxable amount  after discount = ", eachRowTaxableAmount)

        // eachRowTaxAmount = ((parseFloat(eachRowTaxableAmount)*parseFloat(eachRowTaxPercentage2))/100).toFixed(2)
        eachRowTaxAmount = ((parseFloat(eachRowTaxableAmount) * parseFloat(eachRowTaxPercentage2)) / 100).toFixed(2);


        console.log("")
        // console.log(eachRowActualAmountAfterDiscount);
        // console.log(eachRowTaxableAmount);


        document.getElementById("taxable_" + i).value = parseFloat(eachRowTaxableAmount) || 0;
        document.getElementById("taxAmount_" + i).value = parseFloat(eachRowTaxAmount) || 0;


        totalTaxable = parseFloat(totalTaxable) + parseFloat(document.getElementById("taxable_" + i).value || 0);
        totalTaxAmount = parseFloat(totalTaxAmount) + parseFloat(document.getElementById("taxAmount_" + i).value || 0);

    }

    document.getElementById("totalTaxable").value = parseFloat(totalTaxable).toFixed(2);
    document.getElementById("totalTaxAmount").value = parseFloat(totalTaxAmount).toFixed(2);


    console.log("actual", actualTotalAmount)
    console.log("net", netAmount)
    console.log("diff", differenceAmount)

}

function calculateTaxAmount(target) {
    const currentRow = target.closest('tr');
    // const selling = currentRow.querySelector('input[name="sellingPrice[]"]').value||0;
    // const qty = currentRow.querySelector('input[name="qty[]"]').value||0;
    // const discountAmount =currentRow.querySelector('input[name="discountAmount[]"]').value||0;
    let amount = currentRow.querySelector('input[name="amount[]"]').value;
    let tax = currentRow.querySelector('input[name="tax[]"]').value;
    let truncatedTax = tax.replace('G', "");

    let taxAmount = currentRow.querySelector('input[name="taxAmount[]"]');
    let taxable = currentRow.querySelector('input[name="taxable[]"]');

    taxable.value = (((parseFloat(amount) / (parseFloat(truncatedTax) + 100))) * 100).toFixed(2);
    taxAmount.value = (parseFloat(amount) - ((parseFloat(amount) / (parseFloat(truncatedTax) + 100))) * 100).toFixed(2);

}



function calculateTotalAmount() {
    let totalRow = parseInt(localStorage.getItem('total_rows'));
    console.log("total  rows = ", typeof(totalRow))
    let eachRowQty = 0;
    let totalQty = 0;

    let eachRowDiscountAmount = 0;

    let eachRowAmount = 0;
    let totalAmount = 0;


    let eachRowActualAmount = 0;
    let totalActualAmount = 0;

    let eachRowTaxable = 0;
    let totalTaxable = 0;

    let eachRowTaxAmount = 0;
    let totalTaxAmount = 0;








    // alert(rowIndex)
    for (let i = 1; i <= totalRow; i++) {

        eachRowQty = document.getElementById("qty_" + i).value || 0;


        eachRowAmount = document.getElementById("amount_" + i).value || 0;
        eachRowActualAmount = document.getElementById("actualAmount_" + i).value || 0;

        eachRowTaxable = document.getElementById("taxable_" + i).value || 0;
        console.log("each row tax ", eachRowTaxable)
        eachRowTaxAmount = document.getElementById("taxAmount_" + i).value || 0;



        totalQty = parseInt(totalQty) + parseInt(eachRowQty);
        totalAmount = parseFloat(totalAmount) + parseFloat(eachRowAmount);
        totalActualAmount = parseFloat(totalActualAmount) + parseFloat(eachRowActualAmount);
        totalTaxable = parseFloat(totalTaxable) + parseFloat(eachRowTaxable);
        totalTaxAmount = parseFloat(totalTaxAmount) + parseFloat(eachRowTaxAmount);
        console.log("total taxable amount from calculatetotalamount = ", totalTaxable)
        console.log("total tax amount from calculatetotalamount = ", totalTaxAmount)


    }


    for (let i = 1; i <= totalRow; i++) {

        eachRowDiscountAmount = parseFloat(document.getElementById("discountAmount_" + i).value || 0);


        // if(eachRowDiscountAmount>0){
        //     document.getElementById("netDiscountPercent").disabled = true;
        //     document.getElementById("deductionAmount").disabled = true;
        //     document.getElementById("netDiscountPercent").style.background='gainsboro';
        //     document.getElementById("deductionAmount").style.background='gainsboro';


        // }else{
        //     document.getElementById("netDiscountPercent").disabled = false;
        //     document.getElementById("deductionAmount").disabled = false;
        //     document.getElementById("netDiscountPercent").style.background='none';
        //     document.getElementById("deductionAmount").style.background='none';

        // }
    }


    document.getElementById("totalQty").value = totalQty;
    document.getElementById("totalAmount").value = parseFloat(totalAmount).toFixed(2);
    document.getElementById("totalActualAmount").value = parseFloat(totalActualAmount).toFixed(2);
    document.getElementById("totalTaxable").value = parseFloat(totalTaxable).toFixed(2);
    document.getElementById("totalTaxAmount").value = parseFloat(totalTaxAmount).toFixed(2);
}


function calculateGST() {
    let totalTaxAmount = document.getElementById("totalTaxAmount").value;
    let cgstAmount = document.getElementById('cgstAmount');
    let sgstAmount = document.getElementById("sgstAmount");
    let igstAmount = document.getElementById("igstAmount");
    let customerState = localStorage.getItem('customer_state');
    if (customerState == '1') {
        cgstAmount.value = sgstAmount.value = parseFloat((parseFloat(totalTaxAmount) / 2)).toFixed(2);
    } else {
        igstAmount.value = totalTaxAmount;
    }




}

function calculateNetDiscountPercent() {

    let netDiscountAmount = document.getElementById("deductionAmount").value || 0;
    let totalAmount = document.getElementById("totalAmount").value || 0;
    let netDiscountPercent = document.getElementById("netDiscountPercent");

    console.log("net discount amount = ", netDiscountAmount);
    console.log("total amount from calculatenetdiscountpercent = ", totalAmount)
    netDiscountPercent.value = (parseFloat((parseFloat(netDiscountAmount) / parseFloat(totalAmount)) * 100)).toFixed(2);



}


function calculateNetDiscount() {
    let netDiscountPercent = document.getElementById("netDiscountPercent").value || 0;
    let totalAmount = document.getElementById("totalAmount").value || 0;
    let netDiscountAmount = document.getElementById("deductionAmount");

    netDiscountAmount.value = ((parseFloat(totalAmount) * parseFloat(netDiscountPercent)) / 100).toFixed();
    calculateNetAmount()






}


function calculateNetAmount() {


    let totalAmount = document.getElementById('totalAmount').value || 0;
    let cgstAmount = document.getElementById('cgstAmount').value || 0;
    let sgstAmount = document.getElementById("sgstAmount").value || 0;
    let igstAmount = document.getElementById("igstAmount").value || 0;
    let addOn = document.getElementById("addOnAmount").value || 0;
    let afterAddOn = document.getElementById("afterAddOn");


    let deduction = document.getElementById("deductionAmount").value || 0;
    let afterDiscount = 0;
    let netAmount = parseFloat(totalAmount) + parseFloat(addOn) - parseFloat(deduction);


    calculateGST();


    afterDiscount = parseFloat(totalAmount) - parseFloat(deduction);

    afterAddOn.value = parseFloat(afterDiscount) + parseFloat(addOn);


    document.getElementById('netAmount').value = netAmount;

    if (netAmount > 0) {
        document.getElementById("updateButton").disabled = false;

    } else {
        document.getElementById("updateButton").disabled = true;
    }


}

document.getElementById("netDiscountPercent").addEventListener('input', function(event) {
        let target = event.target
        let netDiscountPercent = target.value

        let netDiscountPercent2 = document.getElementById("netDiscountPercent");
        let totalAmount = document.getElementById("totalAmount").value || 0;
        let netDiscountAmount = document.getElementById("deductionAmount");
        if (parseFloat(netDiscountPercent) < 100) {
            calculateNetDiscount()
        } else {
            netDiscountAmount.value = 0;
            netDiscountPercent2.value = 0;
            netDiscountPercent2.select();
        }
        calculateNetAmount();


    }

);
document.getElementById("addOnAmount").addEventListener('input', calculateNetAmount)

document.getElementById("deductionAmount").addEventListener('focus', function(event) {

    document.getElementById("deductionAmount").select();
})

document.getElementById("deductionAmount").addEventListener('input', function(event) {

    let target = event.target
    console.log("target = ", target.value)
    let netDiscountAmount = parseFloat(target.value) || 0;

    let netDiscountAmount2 = document.getElementById("deductionAmount");
    let totalAmount = parseFloat(document.getElementById("totalAmount").value) || 0;
    let netDiscountPercent = document.getElementById("netDiscountPercent");
    if (netDiscountAmount < totalAmount) {
        // calculateDiscountPercentage(target);
        // calculateAmount(target);

        // calculateAmount(target);
        // calculateAc()
        // calculateTaxAmount(target);

        // calculateTotalAmount();

        // calculateNetAmount();


        calculateTotalAmount();
        calculateNetDiscountPercent();
        calculateNetAmount();
        calculateAc();



    } else {
        netDiscountPercent.value = 0;
        netDiscountAmount2.value = 0;
        netDiscountAmount2.select();
        calculateNetDiscountPercent();
        calculateAc();
    }

    calculateNetAmount()

})






document.getElementById("cgstAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("sgstAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("igstAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("addOnAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("deductionAmount").addEventListener("focusout", calculateNetAmount);


document.getElementById("table_body").addEventListener('focusin', function(event) {

    let target = event.target;
    let currentRow = target.closest('tr');
    if (target.name == "salesMan[]") {

        calculateAmount(target);
        // calculateAc();
        calculateTaxAmount(target);
        calculateTotalAmount();
        calculateNetAmount();
        currentRow.querySelector('input[name="salesMan[]"]').value = 0;

    } else if (target.name == "qty[]") {
        if (target.value >= 1) {

        } else {
            currentRow.querySelector('input[name="qty[]"]').value = 1;
        }

        currentRow.querySelector('input[name="qty[]"]').select();
        calculateAmount(target);
        // calculateAc()
        calculateTaxAmount(target);
        calculateTotalAmount();
        calculateNetAmount();

    }
})

document.getElementById('table_body').addEventListener('input', function(event) {

    let target = event.target;
    let currentRow = target.closest('tr');
    if (target.name == "qty[]") {




        calculateAmount(target);
        // calculateAc()
        calculateTaxAmount(target);

        calculateTotalAmount();

        calculateNetAmount();


    } else if (target.name == "discountPercent[]") {

        let amount = currentRow.querySelector('input[name="amount[]"]').value;
        let discountAmount = currentRow.querySelector('input[name="discountAmount[]"]');
        let discountPercentage = currentRow.querySelector('input[name="discountPercent[]"]');

        if (parseFloat(target.value) < parseFloat(100)) {
            calculateDiscountAmount(target)
            calculateAmount(target);
            calculateTaxAmount(target);
            calculateTotalAmount();
            calculateNetAmount();
        } else {
            discountAmount.value = 0;
            discountPercentage.value = 0;
            discountPercentage.select();
        }

    } else if (target.name == 'discountAmount[]') {


        let amount = currentRow.querySelector('input[name="amount[]"]').value;
        let discountAmount = currentRow.querySelector('input[name="discountAmount[]"]');
        let discountPercentage = currentRow.querySelector('input[name="discountPercent[]"]');

        if (parseFloat(discountAmount.value) < parseFloat(amount)) {
            calculateDiscountPercentage(target);
            calculateAmount(target);
            // calculateAc();
            calculateTaxAmount(target);
            calculateTotalAmount();
            calculateNetAmount();


        } else {

            discountAmount.value = 0;
            discountAmount.select();
            discountPercentage.value = 0;
        }


    }
})



document.getElementById("table_body").addEventListener("focusout", function(event) {
    const target = event.target;

    // if(target.name === "rate[]"){
    //         const currentRow = target.closest('tr');
    //         const rate = currentRow.querySelector('input[name="rate[]"]').value||0;
    //         const qty = currentRow.querySelector('input[name="qty[]"]').value||0;
    //         let amount =  currentRow.querySelector('input[name="amount[]"]');
    //         amount.value = (rate*qty).toFixed(2);

    //         calculateTotalAmount();
    //         calculateNetAmount();
    //         validateAmounts();
    //         // let cgstAmount = document.getElementById('cgstAmount').value||0;
    //         // let sgstAmount = document.getElementById("sgstAmount").value||0;
    //         // let igstAmount = document.getElementById("igstAmount").value||0;
    //         // let addOn = document.getElementById("addOnAmount").value||0;
    //         // let deduction = document.getElementById("deductionAmount").value||0;

    //         // let netAmount = parseInt(totalAmount)+parseInt(cgstAmount)+parseInt(sgstAmount)+parseInt(igstAmount)+parseInt(addOn)-parseInt(deduction);


    //         // document.getElementById("netAmount").value = netAmount;

    // }
    if (target.name === "qty[]") {
        const currentRow = target.closest('tr');


        let taxAmount = currentRow.querySelector('input[name="taxAmount[]"]');


        // taxAmount.value = amount.value*2;
        calculateDiscountAmount(target)
        calculateAmount(target)
        calculateTotalAmount();
        calculateNetAmount();
        // validateAmounts();
        // let cgstAmount = document.getElementById('cgstAmount').value||0;
        // let sgstAmount = document.getElementById("sgstAmount").value||0;
        // let igstAmount = document.getElementById("igstAmount").value||0;
        // let addOn = document.getElementById("addOnAmount").value||0;
        // let deduction = document.getElementById("deductionAmount").value||0;

        // let netAmount = parseInt(totalAmount)+parseInt(cgstAmount)+parseInt(sgstAmount)+parseInt(igstAmount)+parseInt(addOn)-parseInt(deduction);


        // document.getElementById("netAmount").value = netAmount;
    } else if (target.name == "discountPercent[]") {

        calculateDiscountAmount(target);
        calculateAmount(target);
        calculateTotalAmount();
        calculateNetAmount();
    }


})

// sales all calculation functions end








document.getElementById("table_body").addEventListener("keydown", function(event) {
    const target = event.target;

    // Handle the Enter key event
    if (event.key === "Enter") {
        event.preventDefault(); // Prevent the default Enter key behavior

        // Navigate based on the input field's name
        if (target.name === "design[]") {





            const currentRow = target.closest("tr");
            const qtyField = currentRow.querySelector('input[name="qty[]"]');
            if (qtyField) {
                qtyField.focus();
                qtyField.select();
            }






        }
        // else if(target.name == "salesMan[]"){




        //                 const currentRow = target.closest("tr");
        //                 const qtyField = currentRow.querySelector('input[name="qty[]"]');    
        //                 const qtyField2 = currentRow.querySelector('input[name="qty[]"]').value;    

        //                 if (qtyField) {

        //                     if(qtyField2 == ""){
        //                         currentRow.querySelector('input[name="qty[]"]').value = 1;
        //                     }
        //                     qtyField.focus();
        //                     qtyField.select();
        //                 }





        // }
        else if (target.name == "qty[]") {




            const currentRow = target.closest("tr");
            const discountPercentField = currentRow.querySelector('input[name="discountPercent[]"]');
            const discountPercentField2 = currentRow.querySelector('input[name="discountPercent[]"]').value;
            if (discountPercentField) {
                if (discountPercentField2 == "") {
                    currentRow.querySelector('input[name="discountPercent[]"]').value = "0.00";
                }
                discountPercentField.focus();
                discountPercentField.select();
                // taxField.click();
            }




        } else if (target.name == "discountPercent[]") {

            const currentRow = target.closest("tr");

            const discountAmountField = currentRow.querySelector('input[name="discountAmount[]"]');
            const discountAmountField2 = currentRow.querySelector('input[name="discountAmount[]"]').value;
            if (discountAmountField) {

                if (discountAmountField2 == "") {
                    currentRow.querySelector('input[name="discountAmount[]"]').value = "0.00";
                }
                discountAmountField.focus();
                discountAmountField.select();
            }
        }
    }
});

function gettingRowItemDetails(target) {

    const currentRow = target.closest("tr");
    const product = currentRow.querySelector('input[name="product[]"]').value;
    const brand = currentRow.querySelector('input[name="brand[]"]').value;
    const design = currentRow.querySelector('input[name="design[]"]').value;
    const color = currentRow.querySelector('input[name="color[]"]').value;
    const batch = currentRow.querySelector('input[name="batch[]"]').value;
    const category = currentRow.querySelector('input[name="category[]"]').value;
    const hsnCode = currentRow.querySelector('input[name="hsnCode[]"]').value;
    const tax = currentRow.querySelector('input[name="tax[]"]').value;
    const size = currentRow.querySelector('input[name="size[]"]').value;
    const mrp = currentRow.querySelector('input[name="mrp[]"]').value;
    const sellingPrice = currentRow.querySelector('input[name="sellingPrice[]"]').value;
    const rate = currentRow.querySelector('input[name="rate[]"]').value;
    const id = currentRow.querySelector('input[name="id[]"]');

    // alert(product.value+" "+brand.value+" "+design.value+" "+batch.value+" "
    // +color.value+" "+category.value+" "+hsnCode.value+" "+tax.value+" "+size.value+" "
    // +mrp.value+" "+sellingPrice.value+" "+rate.value);

    let items = [product, brand, design, color, batch, category, hsnCode, tax, size, mrp, sellingPrice, rate, id.value];


}

// Function to update row indices after deletion
function updateRowIndices() {
    const rows = document.querySelectorAll('#table_body tr');
    rows.forEach((row, index) => {
        const rowNumber = index + 1;
        row.querySelectorAll('input').forEach(input => {
            const name = input.name.replace(/\d+/, rowNumber);
            const id = input.id.replace(/\d+/, rowNumber);
            input.name = name;
            input.id = id;
        });
    });
}


// Modified logRowIndex function
function logRowIndex(input) {
    const currentRow = input.closest('tr');
    if (currentRow) {
        const rowIndex = currentRow.rowIndex + 1; // This is 0-based index
        console.log("Row Index:", rowIndex - 1); // Show 1-based index to user
        localStorage.setItem("row_index", rowIndex - 1);
    }
}

// Event delegation for dynamically added rows
document.getElementById('table_body').addEventListener('focus', function(e) {
    if (e.target.matches('input[name*="[]"]')) {
        logRowIndex(e.target);
    }
}, true);

document.getElementById('table_body').addEventListener('click', function(e) {
    let target = e.target;
    if (target.name == target.name) {
        let fieldname = target.name;

        let row = target.closest('tr');
        row.querySelector(`input[name="${fieldname}"]`).select()
    }
    if (e.target.matches('input[name*="[]"]')) {
        logRowIndex(e.target);
    }
}, true);




// Modify the F2 key event listener
document.getElementById("table_body").addEventListener("keydown", function(event) {
    const target = event.target;
    if (target.tagName === "INPUT" && event.key === "F2") {

        if (target.name === "salesMan[]" && event.key === "F2") {
            event.preventDefault();
            let fieldName = target.name.replace("[]", "");
            let value = target.value;
            let currentBranchId = document.getElementById("userBranchId").value;
            localStorage.setItem("sales_return", "0")
            let get_salesman_code = new FormData();
            get_salesman_code.append("get_sales_man_details_f2", value);
            let aj = new XMLHttpRequest();
            aj.open("POST", "ajaxGetSalesManDetails.php", true);
            aj.send(get_salesman_code);
            aj.onreadystatechange = function() {

                if (aj.status === 200 && aj.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj.responseText;
                }
            }
        }

    } else if (target.name === "design[]" && event.key === "F4") {
        event.preventDefault();
        let fieldName = target.name.replace("[]", "");
        let value = target.value;
        let currentBranchId = document.getElementById("userBranchId").value;
        localStorage.setItem("sales_return", "0")
        let get_item = new FormData();
        get_item.append("get_item_f4", value);
        let aj = new XMLHttpRequest();
        aj.open("POST", "ajaxGetSalesItem.php", true);
        aj.send(get_item);
        aj.onreadystatechange = function() {

            if (aj.status === 200 && aj.readyState === 4) {
                document.getElementById("response_message").innerHTML = aj.responseText;

            }
        }


    }
});







$(document).on("keypress", ".discountAmount-field", function(e) {


    if (e.key === "Enter") {
        e.preventDefault();
        let currentRow = $(this).closest("tr");
        // Check if it's the last row
        let isLastRow = currentRow.is(":last-child");
        if (isLastRow) {
            // Add a new row
            // add_row();
            // Focus on the product field of the newly added row
            // currentRow.next("tr").find('input[name="design[]"]').focus();
        } else {
            // Move focus to the product field in the next row
            // currentRow.next("tr").find('input[name="design[]"]').focus();
        }
    }
});



function add_row() {
    let totalRows = localStorage.getItem("total_rows");
    totalRows = parseInt(totalRows) + 1;
    localStorage.setItem("total_rows", totalRows);

    let i = parseInt(localStorage.getItem("row_index")) + 1;
    // alert(i)
    const currentRows = document.querySelectorAll('#table_body tr');
    const lastRow = currentRows[currentRows.length - 1]; // Get the last row
    const newRowIndex = currentRows.length + 1;
    // ${batch[i]}


    // Create new row
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>
            <input type="text" class="serial-field" name="serialNumber[]" id="serialNumber_${i}"    style="width:45px; height:25px; text-align:center;background-color:#212529;color:white;" maxlength="4" autocomplete="off" readonly/>
        </td>
        <td>
                        <input type="text" class="design-field" name="design[]" id="design_${i}" autocomplete="off"
                           style="width:175px; height:25px; text-align:left;background-image: linear-gradient(225deg, white 50%, blanchedalmond 50%);" maxlength="30"
                           placeholder="Press F4 For Item Info"/>
                    </td>
                    <td>
                        <input type="text" class="description-field" name="description[]" id="description_${i}" autocomplete="off"
                                
                               style="width:430px; height:25px; text-align:left;" maxlength="150" readonly />
                    </td>
                    <td>
                        <input type="text" class="hsnCode-field" name="hsnCode[]" id="hsnCode_${i}" autocomplete="off"
                                
                               style="width:65px; height:25px; text-align:center;" maxlength="8" readonly />
                    </td>
                    <td>
                        <input type="text" class="tax-field" name="tax[]" id="tax_${i}" autocomplete="off"
                                
                               style="width:35px; height:25px; text-align:center;" maxlength="8" readonly />
                    </td>
                    <td>
                        <input type="text" class="sellingPrice-field" name="sellingPrice[]" id="sellingPrice_${i}" autocomplete="off"
                                
                               style="width:70px; height:25px; text-align:right;" maxlength="12" readonly />
                    </td>
                    <td>
                        <input type="text" class="salesMan-field" name="salesMan[]" id="salesMan_${i}" autocomplete="off"
                                
                               style="width:70px; height:25px; text-align:center;background-color:blanchedalmond;" maxlength="12" />
                    </td>
                    <td>
                        <input type="text" class="qty-field" name="qty[]" id="qty_${i}" autocomplete="off"
                                
                               style="width:35px; height:25px; text-align:center;" maxlength="5" />
                    </td>
                    <td>
                        <input type="text" class="discountPercent-field" name="discountPercent[]" id="discountPercent_${i}" autocomplete="off"
                        
                               style="width:45px; height:25px; text-align:center;" maxlength="4" />
                    </td>
                    <td>
                        <input type="text" class="discountAmount-field" name="discountAmount[]" id="discountAmount_${i}" autocomplete="off"
                        
                               style="width:80px; height:25px; text-align:right;" maxlength="10" />
                    </td>
                    <td>
                        <input type="text" class="amount-field" name="amount[]" id="amount_${i}" autocomplete="off"
                        
                               style="width:85px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;" maxlength="13" readonly />
                    </td>
                    <td hidden>
                        <input type="text" class="actualAmount-field" name="actualAmount[]" id="actualAmount_${i}" autocomplete="off"
                        
                               style="width:80px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;" maxlength="13" readonly />
                    </td>
                    <td hidden>
                        <input type="text" class="taxable-field" name="taxable[]" id="taxable_${i}" autocomplete="off"
                        
                               style="width:50px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;" maxlength="13" readonly />
                    </td>
                    <td hidden>
                        <input type="text" class="taxAmount-field" name="taxAmount[]" id="taxAmount_${i}" autocomplete="off"
                        
                               style="width:10px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;" maxlength="13" readonly />
                    </td>
                    <td>
                        <input type="text" class="id-field" name="id[]" id="id_${i}" readonly autocomplete="off"
                        
                               style="width:50px; height:25px; text-align:center; background-color:#212529; color:white; border:1px solid white;" />
                    </td>
        <td>
            <button type="button" id="remove" class="btn btn-danger" title="Remove" style="font-size:8px;margin-left:1px;width:45px">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    `;








    // if (lastRow) {
    //     newRow.querySelectorAll("input").forEach((input) => {
    //         let fieldName = input.name;

    //         if(fieldName === "id[]"){
    //             input.value = "";

    //         }else{
    //             let lastValue = lastRow.querySelector(`[name="${fieldName}"]`).value;
    //             input.value = lastValue;
    //         }

    //         // Copy the value from the last row
    //             // document.getElementById(`batch_${i}`).value = batchData[i] || ''; // Set value dynamically\
    //     });
    // }

    document.querySelector('#table_body').appendChild(newRow);
    // ✅ Set the value for serialNumber explicitly after appending the row

    newRow.querySelector(`#serialNumber_${i}`).value = i;

    // Log the new row index
    console.log("New row added at index:", newRowIndex);
    localStorage.setItem("row_index", newRowIndex);

    // Focus on the new row's product field
    // newRow.querySelector('input[name="design[]"]').focus();
}


// document.addEventListener("keydown", function (event) {
//     if (event.key === "Enter") {
//         event.preventDefault();

//         const activeElement = document.activeElement;
//         if (!activeElement || activeElement.name !== "discountAmount[]") return;

//         const currentRow = activeElement.closest("tr");
//         const allRows = Array.from(document.querySelectorAll("#table_body tr"));
//         const lastRow = allRows[allRows.length - 1];

//         if (currentRow === lastRow) {
//             // ✅ Add row only if it's the last row
//             add_row();
//         } else {
//             // ✅ Move to design field in the next row
//             const currentIndex = allRows.indexOf(currentRow);
//             const nextRow = allRows[currentIndex + 1];
//             const designField = nextRow.querySelector('input[name="design[]"]');
//             if (designField) designField.focus();
//         }
//     }
// });

// document.addEventListener("keydown", function (event) {
//     if (event.key === "Enter") {
//         event.preventDefault();

//         const activeElement = document.activeElement;

//         // Only respond when Enter is pressed inside discountAmount[] field
//         if (!activeElement || activeElement.name == "discountAmount[]") return;

//         const currentRow = activeElement.closest("tr");
//         const allRows = Array.from(document.querySelectorAll("#table_body tr"));
//         const lastRow = allRows[allRows.length - 1];

//         if (currentRow === lastRow) {
//             // ✅ Add new row if currently in last row
//             add_row();
//         } else {
//             // ✅ If not in last row, go to design field in next row
//             const currentIndex = allRows.indexOf(currentRow);
//             const nextRow = allRows[currentIndex + 1];
//             const designField = nextRow.querySelector('input[name="design[]"]');
//             if (designField) designField.focus();
//         }
//     }
// });


document.addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {
        event.preventDefault();

        const activeElement = document.activeElement;

        // ✅ Only respond when Enter is pressed inside discountAmount[] field
        if (!activeElement || activeElement.name !== "discountAmount[]") return;

        const currentRow = activeElement.closest("tr");
        const allRows = Array.from(document.querySelectorAll("#table_body tr"));
        const lastRow = allRows[allRows.length - 1];

        if (currentRow === lastRow) {
            // ✅ Add new row if currently in last row
            if (target.name == "discountAmount[]") {
                add_row();

                const updatedRows = document.querySelectorAll("#table_body tr");
                const newLastRow = updatedRows[updatedRows.length - 1];
                const designField = newLastRow.querySelector('input[name="design[]"]');
                if (designField) designField.focus();
            }
        } else {
            // ✅ If not in last row, go to design[] in next row

            const currentIndex = allRows.indexOf(currentRow);
            const nextRow = allRows[currentIndex + 1];
            const designField = nextRow.querySelector('input[name="design[]"]');


            if (target.name == "discountAmount[]") {
                if (designField) {

                    designField.focus();
                    designField.select();
                }

            }

        }
    }
});




document.addEventListener("focusin", function(event) {
    let activeElement = event.target; // Get the currently focused input field

    if (activeElement && activeElement.tagName === "INPUT") {
        let fieldName = activeElement.name; // Get the field name
        let currentRow = activeElement.closest("tr"); // Get the current row
        let previousRow = currentRow?.previousElementSibling; // Get the previous row

        if (previousRow) {
            // Get the value from the same field in the previous row
            let prevInput = previousRow.querySelector(`[name="${fieldName}"]`);
            let prevValue = prevInput ? prevInput.value : "";

            if (prevValue !== undefined) {
                if (activeElement.value == "") {
                    // activeElement.value = prevValue; // Set the previous value
                }
            }
        }
    }
});




$(document).on("click", "#remove", function(e) {
    e.preventDefault();
    const removedRow = $(this).closest('tr');
    const removedIndex = removedRow.index() + 1; // 1-based index
    console.log("Removed row at index:", removedIndex);

    removedRow.remove();

    // Update all subsequent row indices
    const remainingRows = document.querySelectorAll('#table_body tr');
    remainingRows.forEach((row, index) => {
        const rowNumber = index + 1;
        row.querySelector('.serial-field').value = index + 1; // Reset serial numbers
        row.querySelectorAll('input').forEach(input => {
            const name = input.name.replace(/\d+/, rowNumber);
            const id = input.id.replace(/\d+/, rowNumber);
            input.name = name;
            input.id = id;
        });

    });

    localStorage.setItem("row_deleted", 1);
    let totalRows = localStorage.getItem('total_rows');
    deleteRow = parseInt(totalRows) - 1;
    localStorage.setItem("total_rows", deleteRow);



});

// Modify the row deletion logic
$(document).on("click", "#remove", function(e) {
    e.preventDefault();
    const removedRow = $(this).closest('tr');
    const removedIndex = removedRow.index() + 1; // 1-based index
    console.log("Removed row at index:", removedIndex);

    removedRow.remove();
    updateRowIndices();

    localStorage.setItem("row_deleted", 1);

    calculateTotalAmount();
    calculateNetAmount();
});








document.addEventListener("focusin", function(event) {
    let activeElement = event.target; // Get the currently focused input field

    if (activeElement && activeElement.tagName === "INPUT") {
        let fieldName = activeElement.name; // Get the field name
        let currentRow = activeElement.closest("tr"); // Get the current row
        let previousRow = currentRow?.previousElementSibling; // Get the previous row

        if (previousRow) {
            // Get the value from the same field in the previous row
            let prevInput = previousRow.querySelector(`[name="${fieldName}"]`);
            let prevValue = prevInput ? prevInput.value : "";

            if (prevValue !== undefined) {
                if (activeElement.value == "") {
                    // activeElement.value = prevValue; // Set the previous value
                }
            }
        }
    }
});





// sales return add_row function end




window.onload = function() {

    localStorage.setItem('supplier_state', '');
    localStorage.setItem("row_index", 0);


    // document.getElementById('submitButton').disabled = true;    
    document.getElementById("billNumber").focus();

    document.getElementById('billDate').setAttribute('readonly', true);




    let supplierName = document.getElementById("supplierName").value;


    let billNumber = document.getElementById("billNumber").value;

    let totalQty = document.getElementById("totalQty").value;
    let totalAmount = document.getElementById("totalAmount").value;
    let cgstAmount = document.getElementById("cgstAmount").value;
    let sgstAmount = document.getElementById("sgstAmount").value;
    let igstAmount = document.getElementById("igstAmount").value;
    let addOnAmount = document.getElementById("addOnAmount").value;
    let deductionAmount = document.getElementById("deductionAmount").value;
    let netAmount = document.getElementById("netAmount").value;


    if (billNumber == "") {
        document.getElementById("updateButton").disabled = true;
    } else {
        document.getElementById("updateButton").disabled = false;
        document.getElementById("billNumber").style.background = 'gainsboro';
        document.getElementById("billNumber").setAttribute('readonly', 'true');
        document.getElementById("supplierName").focus();
        document.getElementById("supplierName").select();
    }

    if (netAmount == "") {
        document.getElementById('cancelButton').style.display = 'none';
    } else {
        document.getElementById('cancelButton').style.display = 'block';
    }

    // if(billNumber==""){

    //     document.getElementById('updateButton').disabled = true;

    // }

    if (supplierName == "") {
        document.getElementById("supplierName").style.background = 'gainsboro';
        document.getElementById("supplierName").setAttribute('readonly', 'true')
    } else {
        // document.getElementById("supplierName").style.background='none';
        document.getElementById("supplierName").removeAttribute('readonly');

    }






    // if(billAmount == ""){
    // document.getElementById("billAmount").style.background='gainsboro';
    // document.getElementById("billAmount").setAttribute('readonly','true');
    // }else{

    //     document.getElementById("billAmount").style.background='none';
    //     document.getElementById("billAmount").removeAttribute('readonly');

    // }



    if (totalQty) {
        // alert(totalQty)
        document.getElementById("totalQty").style.background = 'gainsboro';
        document.getElementById("totalQty").setAttribute('readonly', 'true');
    }

    if (totalAmount) {
        document.getElementById("totalAmount").style.background = 'gainsboro';
        document.getElementById("totalAmount").setAttribute('readonly', 'true');
    }

    if (cgstAmount == 0.00) {
        document.getElementById("cgstAmount").style.background = 'gainsboro';
        document.getElementById("cgstAmount").setAttribute('readonly', 'true');
    } else {

        document.getElementById("cgstAmount").style.background = 'none';
        document.getElementById("cgstAmount").removeAttribute('readonly');

    }
    if (sgstAmount == 0.00) {
        document.getElementById("sgstAmount").style.background = 'gainsboro';
        document.getElementById("sgstAmount").setAttribute('readonly', 'true');
    } else {

        document.getElementById("sgstAmount").style.background = 'none';
        document.getElementById("sgstAmount").removeAttribute('readonly');

    }

    if (igstAmount == 0.00) {
        document.getElementById("igstAmount").style.background = 'gainsboro';
        document.getElementById("igstAmount").setAttribute('readonly', 'true');
    } else {

        document.getElementById("igstAmount").style.background = 'none';
        document.getElementById("igstAmount").removeAttribute('readonly');

    }

    if (addOnAmount == "") {
        document.getElementById("addOnAmount").style.background = 'gainsboro';
        document.getElementById("addOnAmount").setAttribute('readonly', 'true');
    } else {

        document.getElementById("addOnAmount").style.background = 'none';
        document.getElementById("addOnAmount").removeAttribute('readonly');

    }
    if (deductionAmount == "") {
        document.getElementById("deductionAmount").style.background = 'gainsboro';
        document.getElementById("deductionAmount").setAttribute('readonly', 'true');
    } else {

        document.getElementById("deductionAmount").style.background = 'none';
        document.getElementById("deductionAmount").removeAttribute('readonly');

    }
    if (netAmount) {
        document.getElementById("netAmount").style.background = 'gainsboro';
        document.getElementById("netAmount").setAttribute('readonly', 'true');
    }

    // document.getElementById("supplierName").style.background='gainsboro';

    // document.getElementById("billAmount").style.background='gainsboro';

    // if(cgstAmount == 0){
    // document.getElementById("cgstAmount").style.background='gainsboro';
    // document.getElementById("cgstAmount").disabled = true;
    // document.getElementById("cgstAmount").value = 0;
    // }else{
    //     document.getElementById("cgstAmount").style.background='none';
    //     document.getElementById("cgstAmount").disabled = false;

    // }
    // document.getElementById("totalQty").value = 0;
    // document.getElementById("totalAmount").value = 0;
    // document.getElementById("sgstAmount").value = 0;
    // document.getElementById("igstAmount").value = 0;
    // document.getElementById("addOnAmount").value = 0;
    // document.getElementById("deductionAmount").value = 0;
    // document.getElementById("netAmount").value = 0;

    // document.getElementById("dcNumber").style.background='gainsboro';
    // document.getElementById("dcDate").style.background='gainsboro';
    // document.getElementById("invoiceNumber").style.background='gainsboro';
    // document.getElementById("invoiceDate").style.background='gainsboro';

    // document.getElementById("cgstAmount").style.background='gainsboro';
    // document.getElementById("sgstAmount").style.background='gainsboro';
    // document.getElementById("igstAmount").style.background='gainsboro';
    // document.getElementById("addOnAmount").style.background='gainsboro';
    // document.getElementById("deductionAmount").style.background='gainsboro';
    // document.getElementById("cgstAmount").setAttribute('readonly','true');
    // document.getElementById("sgstAmount").setAttribute('readonly','true');
    // document.getElementById("igstAmount").setAttribute('readonly','true');
    // document.getElementById('submitButton').disabled = true;
    // document.getElementById("supplierName").disabled = true;
    // document.getElementById("billAmount").disabled = true;
    // document.getElementById("dcNumber").disabled = true;
    // document.getElementById("dcDate").disabled = true;
    // document.getElementById("invoiceNumber").disabled = true;
    // document.getElementById("invoiceDate").disabled = true;

    // document.getElementById("cgstAmount").disabled = true;
    // document.getElementById("sgstAmount").disabled = true;
    // document.getElementById("igstAmount").disabled = true;
    // document.getElementById("addOnAmount").disabled = true;
    // document.getElementById("deductionAmount").disabled = true;

    let session_sno = '<?php echo $_SESSION['snos']; ?>';
    localStorage.setItem("total_rows", session_sno);


    let mydate = new Date();
    let currentDate = mydate.getFullYear() + "-" +
        (mydate.getMonth() + 1).toString().padStart(2, "0") + "-" +
        mydate.getDate().toString().padStart(2, "0");
    // document.getElementById("billDate").value = currentDate;
    // document.getElementById("dcDate").value =currentDate;
    // document.getElementById("invoiceDate").value =currentDate;




}
let rowIndex = localStorage.getItem("row_index");


setTimeout(() => {


}, 10);












// document.getElementById("table_body").addEventListener("keypress", function(event){

//         let target = event.target;


//                     if(target.name == "mrp[]"){
//                         const charCode = event.which || event.keyCode;
//                         const charStr = String.fromCharCode(charCode);

//                         if(!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))){

//                             event.preventDefault();
//                         }


//                         this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
//                     }
// });


document.getElementById("table_body").addEventListener("input", function(event) {
    let target = event.target;

    if (target.name === "qty[]") {
        // Allow only numbers and a single decimal point
        target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    } else if (target.name === "discountPercent[]") {
        // Allow only numbers and a single decimal point
        target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    } else if (target.name === "discountAmount[]") {
        // Allow only numbers and a single decimal point
        target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    }

});












document.getElementById('totalAmount').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('totalAmount').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});

document.getElementById('cgstAmount').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('cgstAmount').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});
document.getElementById('sgstAmount').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('sgstAmount').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});


document.getElementById('igstAmount').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('igstAmount').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});


document.getElementById('addOnAmount').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('addOnAmount').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});
document.getElementById('deductionAmount').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('deductionAmount').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});



document.getElementById('netAmount').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('netAmount').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});





document.getElementById('netDiscountPercent').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('netDiscountPercent').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});





document.getElementById('totalQty').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('totalQty').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
});

document.getElementById('billNumber').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('billNumber').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
});




document.getElementById("supplierName").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById('design_1').focus();
        document.getElementById('design_1').select();
        // document.getElementById("billAmount").focus();
        // document.getElementById("billAmount").select();
    }

})






document.getElementById("cgstAmount").addEventListener("focus", function() {

    document.getElementById("cgstAmount").select();

})

document.getElementById("cgstAmount").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {

        event.preventDefault();
        document.getElementById("sgstAmount").focus();
        document.getElementById("sgstAmount").select();
    }
})



document.getElementById("sgstAmount").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        if (document.getElementById("igstAmount").disabled) {
            document.getElementById("addOnAmount").focus();
            document.getElementById("addOnAmount").select();
        } else {
            document.getElementById("igstAmount").focus();
            document.getElementById("igstAmount").select();
        }

    }
})





document.getElementById("igstAmount").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("addOnAmount").focus();
        document.getElementById("addOnAmount").select();
    }
})

document.getElementById("igstAmount").addEventListener("focus", function() {

    document.getElementById("igstAmount").select();
})

document.getElementById("addOnAmount").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("deductionAmount").focus();
        document.getElementById("deductionAmount").select();
    }
})


document.getElementById("deductionAmount").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("updateButton").focus();

    }


})

setTimeout(() => {
    var alertBox = document.getElementById("liveToast");
    if (alertBox) {
        alertBox.style.display = 'none';
    }
}, 2000);
</script>

</body>

</html>

<?php

// if(isset($_POST['update_button'])){
//     // error_reporting(E_ALL);
//     //             ini_set('display_errors',1);

// $s_netAmount          = isset($_POST['netAmount']) ? $_POST['netAmount'] : 0;                
// $serialNumber = $_POST['serialNumber'];
// $addOnAmount = $_POST['addOnAmount'];
// $deductionAmount = $_POST['deductionAmount'];
// $s_design   = $_POST['design'];

// // $netAmount = $_POST['netAmount'];



//     $supplierName =  $_POST['supplierName'];
//     $supplierId = $_POST['supplierId'];
//     // echo $supplierId;


//     $netAmount = $_POST['netAmount'];


//     if($s_netAmount>=0){
//         if($s_netAmount>=0 && $s_design[0] != ''){
//             $billNumber = $_POST['billNumber'];
//             $billDate = $_POST['billDate'];



//             $s_design   = $_POST['design'];
//             $s_itemTax = $_POST['tax'];
//             $s_itemId = $_POST['id'];
//             $s_ManCode = $_POST['salesMan'];
//             $s_itemQty  = $_POST['qty'];
//             $s_itemDiscountPercent = $_POST['discountPercent'];
//             $s_itemDiscountAmount = $_POST['discountAmount'];
//             $s_itemAmount = $_POST['amount'];
//             $s_actualAmount = $_POST['actualAmount'];
//             $s_taxable = $_POST['taxable'];
//             $s_taxAmount = $_POST['taxAmount'];
//             $s_serialNumber = $_POST['serialNumber'];

//             $s_totalQty = $_POST['totalQty'];
//             $s_totalAmount =$_POST['totalAmount'];
//             $s_totalActualAmount  = $_POST['totalActualAmount'];
//             $s_totalTaxableAmount = $_POST['totalTaxable'];
//             $s_totalTaxAmount     = $_POST['totalTaxAmount'];    
//             $s_cgst = isset($_POST['cgstAmount']) ? $_POST['cgstAmount'] : 0;
//             $s_sgst = isset($_POST['sgstAmount']) ? $_POST['sgstAmount'] : 0;
//             $s_igst = isset($_POST['igstAmount']) ? $_POST['igstAmount'] : 0;
//             $s_addOn = $_POST['addOnAmount'];
//             $s_deduction = $_POST['deductionAmount'];
//             $s_returnAmount       = isset($_POST['salesReturnNetAmount']) ? $_POST['salesReturnNetAmount'] : 0;
//             $s_netAmount          = isset($_POST['netAmount']) ? $_POST['netAmount'] : 0;

//             if(($netAmount - $s_totalAmount) != 0 ){
//                 $percent = round((($netAmount-$s_totalAmount)/$s_totalAmount)*100,2);
//             }else{
//                 $percent = 0;
//             }


//             $a=0;
//             $s_itemActualAmount = 0;
//             $s_itemTaxPercentage = 0;
//             $s_itemTaxableAmount = 0;
//             $s_itemTaxAmount = 0;
//             $s_ActualAmount =0;
//             $s_TaxableAmount=0;
//             $s_TaxAmount    =0;
//             $s_IgstAmount = 0;
//             $s_CgstAmount = 0;
//             $s_SgstAmount = 0;


//             // sales stock update

//             $updateStockBal = "
//             UPDATE stock_balance sb
//             JOIN purchase_return_item pri ON sb.item_id = pri.pr_item_id AND sb.branch_id = pri.branch_id
//             SET sb.item_qty = sb.item_qty + pri.pr_item_qty
//             WHERE pri.pr_grn_number = ? AND pri.branch_id = ?";

//             $stmt = $con->prepare($updateStockBal);
//             $stmt->bind_param("si", $billNumber, $userBranchId);
//             $stmt->execute();
//             $stmt->close();
//             //end
//             //update sales summary
//             $queryUpdatePurchaseReturnSummary = "
//                   update purchase_return_summary
//                   set
//                   pr_grn_number = '$billNumber', pr_grn_date ='$_SESSION[pr_date]',
//                   supplier_id =  '$supplierId',pr_total_qty = '$s_totalQty',pr_total_amount = '$s_totalAmount',pr_cgst_amount = '$s_cgst',
//                   pr_sgst_amount = '$s_sgst', pr_igst_amount = '$s_igst',pr_addon = '$s_addOn',
//                   pr_deduction = '$s_deduction',pr_net_amount = '$s_netAmount',user_id = '$userId'
//                   where pr_grn_number = '$billNumber' and branch_id = '$userBranchId'";


//         $resultQueryPurchaseReturnSummary = $con->query($queryUpdatePurchaseReturnSummary);
//         //end
//         //delete sales item    
//         $queryDeleteOldSalesItem = "delete from purchase_return_item where pr_grn_number = '$billNumber' and branch_id = '$userBranchId'
//         and counter_name = '$_SESSION[counter_name]'";
//         $resultDeleteOldSalesItem = $con->query($queryDeleteOldSalesItem);
//         //end

//         //delete stock transaction
//         $queryDeleteOldStockTransaction = "delete from stock_transaction where grn_number = '$billNumber' and entry_type = 'PR' and branch_id = '$userBranchId'
//                                            and counter_name = '$_SESSION[counter_name]'";
//         $resultDeleteOldStockTransaction = $con->query($queryDeleteOldStockTransaction);
//         //end


//             foreach($s_design as $des){

//             if($s_itemId[$a]!=''){



//             $s_itemActualAmount = round((float)$s_itemAmount[$a]-(((float)$s_itemAmount[$a]*(float)$percent)/100),2);
//             $s_itemTaxPercentage =  str_replace("G","",$s_itemTax[$a]);            
//             $s_itemTaxableAmount = round((((float)$s_itemActualAmount/((float)$s_itemTaxPercentage+100))*100),2);
//             $s_itemTaxAmount = round(((float)$s_itemTaxableAmount*(float)$s_itemTaxPercentage)/100,2);


//             $querySearchLandCost = "select*from purchase_item where item_id = '$s_itemId[$a]'
//             && branch_id = '$userBranchId'";
//             $resultSearchLandCost = $con->query($querySearchLandCost)->fetch_assoc();

//             $landCost = $resultSearchLandCost['land_cost'];
//             $margin = $resultSearchLandCost['margin'];

//             $querySalesItem = "insert into purchase_return_item (pr_grn_number, pr_grn_date,
//                                 counter_name,pr_item_id,pr_item_qty,pr_item_amount,pr_land_cost,pr_margin,
//                                 pr_s_no,branch_id)
//             values('$billNumber','$_SESSION[pr_date]','$_SESSION[counter_name]','$s_itemId[$a]',
//             '$s_itemQty[$a]','$s_itemAmount[$a]','$landCost','$margin','$s_serialNumber[$a]',
//             '$userBranchId')";

//             $resultQuery = $con->query($querySalesItem);        





//             //insert stock transaction
//             $queryStockTransaction = "insert into stock_transaction (grn_number, grn_date,
//             counter_name,item_id,item_qty,land_cost,entry_type,branch_id)
//             values('$billNumber','$_SESSION[pr_date]','$_SESSION[counter_name]','$s_itemId[$a]','$s_itemQty[$a]',
//                    '$landCost','PR','$userBranchId')";

//             $resultStockTransaction = $con->query($queryStockTransaction);
//             //end


//                         $queryStockBalance = "update stock_balance set item_qty = item_qty-$s_itemQty[$a]
//                         where item_id = '$s_itemId[$a]' and branch_id = '$userBranchId'";

//                         $resultStockBalance = $con->query($queryStockBalance);
//                 $a++;

//             }
//         }


//     }
















//         // foreach($product as $pro){

//         //     $landCost = round($rate[$a]+(($rate[$a]*$percent)/100),2);
//         //     $margin = round((($sellingPrice[$a]-$landCost)/$sellingPrice[$a])*100,2);

//         //     $querySalesItem = "insert into sales_item (sales_number, sales_date,counter_name,
//         //     item_id,item_qty,item_amount,land_cost,margin,s_s_no,branch_id)
//         //     values('$billNumber','$billDate','$_SESSION[counter_name]','$itemId[$a]','$itemQty[$a]','$itemAmount[$a]',
//         //            '$landCost','$margin','$serialNumber[$a]','$userBranchId')";

//         //     $resultQuery = $con->query($querySalesItem);        


//         //     $queryStockTransaction = "insert into stock_transaction (sales_number, grn_date,counter_name,
//         //     item_id,item_qty,land_cost,entry_type,branch_id)
//         //     values('$billNumber','$billDate','$_SESSION[counter_name]','$itemId[$a]','$itemQty[$a]',
//         //            '$landCost','P','$userBranchId')";
//         //     $resultStockTransaction = $con->query($queryStockTransaction);


//         //         $querySearchStockBalance = "select*from stock_balance where item_id = '$itemId[$a]' and branch_id = '$userBranchId'";
//         //         $resultSearchStockBalance = $con->query($querySearchStockBalance);

//         //         if($resultSearchStockBalance->num_rows==0){
//         //             echo "item id from stock balance table = ";
//         //             echo "<br>";
//         //             $queryStockBalance = "insert into stock_balance(item_id,item_qty,branch_id) values('$itemId[$a]','$itemQty[$a]','$userBranchId')";                
//         //             $resultStockBalance = $con->query($queryStockBalance);                    
//         //         }else{
//         //             // echo "<br>";
//         //             // echo "item is there";
//         //             // echo "<br>";
//         //                 $queryStockBalance = "update stock_balance set item_qty = item_qty+'$itemQty[$a]'
//         //                 where item_id = '$itemId[$a]' and branch_id = '$userBranchId'";
//         //                 $resultStockBalance = $con->query($queryStockBalance);


//         //             };

//         //             $a++;            

//         // }
//                 // $resultStockBalance = $con->query($queryStockBalance);


//             if($resultQueryPurchaseReturnSummary && $stmt){

//                 $_SESSION['notification'] = "Purchase Return Updated Successfully";            
//                 header("Location:".BASE_URL."/pages/purchaseReturnEdit.php");
//                 exit();

//             }else{
//                 echo "something went wrong";
//             }


//     }else{
//         $_SESSION['notification'] = "Bill Amount And Net Amount Does Not Match";
//         header("Location:".BASE_URL."/pages/salesEdit.php");
//         echo '<script>
//       document.addEventListener("DOMContentLoaded", function() {
//           let toastElement = new bootstrap.Toast(document.getElementById("liveToast"));
//           toastElement.show();
//       });
//     </script>';



//         }
//    }  



if (isset($_POST['update_button'])) {
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();

        $s_netAmount = isset($_POST['netAmount']) ? $_POST['netAmount'] : 0;
        $serialNumber = $_POST['serialNumber'];
        $addOnAmount = $_POST['addOnAmount'];
        $deductionAmount = $_POST['deductionAmount'];
        $s_design = $_POST['design'];

        $supplierName = $_POST['supplierName'];
        $supplierId = $_POST['supplierId'];
        $netAmount = $_POST['netAmount'];

        if ($s_netAmount >= 0 && $s_design[0] != '') {
            $billNumber = $_POST['billNumber'];
            $billDate = $_POST['billDate'];

            $s_itemTax = $_POST['tax'];
            $s_itemId = $_POST['id'];
            $s_ManCode = $_POST['salesMan'];
            $s_itemQty = $_POST['qty'];
            $s_itemDiscountPercent = $_POST['discountPercent'];
            $s_itemDiscountAmount = $_POST['discountAmount'];
            $s_itemAmount = $_POST['amount'];
            $s_actualAmount = $_POST['actualAmount'];
            $s_taxable = $_POST['taxable'];
            $s_taxAmount = $_POST['taxAmount'];
            $s_serialNumber = $_POST['serialNumber'];

            $s_totalQty = $_POST['totalQty'];
            $s_totalAmount = $_POST['totalAmount'];
            $s_totalActualAmount = $_POST['totalActualAmount'];
            $s_totalTaxableAmount = $_POST['totalTaxable'];
            $s_totalTaxAmount = $_POST['totalTaxAmount'];
            $s_cgst = isset($_POST['cgstAmount']) ? $_POST['cgstAmount'] : 0;
            $s_sgst = isset($_POST['sgstAmount']) ? $_POST['sgstAmount'] : 0;
            $s_igst = isset($_POST['igstAmount']) ? $_POST['igstAmount'] : 0;
            $s_addOn = $_POST['addOnAmount'];
            $s_deduction = $_POST['deductionAmount'];
            $s_returnAmount = isset($_POST['salesReturnNetAmount']) ? $_POST['salesReturnNetAmount'] : 0;
            $s_netAmount = isset($_POST['netAmount']) ? $_POST['netAmount'] : 0;

            $percent = ($netAmount - $s_totalAmount) != 0 ? round((($netAmount - $s_totalAmount) / $s_totalAmount) * 100, 2) : 0;

            // Reverse previous stock effect
            $updateStockBal = "
                UPDATE stock_balance sb
                JOIN purchase_return_item pri ON sb.item_id = pri.pr_item_id AND sb.branch_id = pri.branch_id
                SET sb.item_qty = sb.item_qty + pri.pr_item_qty
                WHERE pri.pr_grn_number = ? AND pri.branch_id = ?";
            $stmt = $con->prepare($updateStockBal);
            $stmt->bind_param("si", $billNumber, $userBranchId);
            $stmt->execute();
            $stmt->close();

            // Update summary
            $queryUpdatePurchaseReturnSummary = "
                UPDATE purchase_return_summary SET
                pr_grn_number = '$billNumber',
                pr_grn_date = '$_SESSION[pr_date]',
                supplier_id = '$supplierId',
                pr_total_qty = '$s_totalQty',
                pr_total_amount = '$s_totalAmount',
                pr_cgst_amount = '$s_cgst',
                pr_sgst_amount = '$s_sgst',
                pr_igst_amount = '$s_igst',
                pr_addon = '$s_addOn',
                pr_deduction = '$s_deduction',
                pr_net_amount = '$s_netAmount',
                user_id = '$userId'
                WHERE pr_grn_number = '$billNumber' AND branch_id = '$userBranchId'";
            $con->query($queryUpdatePurchaseReturnSummary);

            // Remove previous items and transactions
            $con->query("DELETE FROM purchase_return_item WHERE pr_grn_number = '$billNumber' AND branch_id = '$userBranchId' AND counter_name = '$_SESSION[counter_name]'");
            $con->query("DELETE FROM stock_transaction WHERE grn_number = '$billNumber' AND entry_type = 'PR' AND branch_id = '$userBranchId' AND counter_name = '$_SESSION[counter_name]'");

            // Re-insert updated rows
            $a = 0;
            foreach ($s_design as $des) {
                if ($s_itemId[$a] != '') {
                    $s_itemActualAmount = round((float)$s_itemAmount[$a] - (((float)$s_itemAmount[$a] * (float)$percent) / 100), 2);
                    $s_itemTaxPercentage = str_replace("G", "", $s_itemTax[$a]);
                    $s_itemTaxableAmount = round((((float)$s_itemActualAmount / ((float)$s_itemTaxPercentage + 100)) * 100), 2);
                    $s_itemTaxAmount = round(((float)$s_itemTaxableAmount * (float)$s_itemTaxPercentage) / 100, 2);

                    $resultSearchLandCost = $con->query("SELECT * FROM purchase_item WHERE item_id = '$s_itemId[$a]' AND branch_id = '$userBranchId'")->fetch_assoc();
                    $landCost = $resultSearchLandCost['land_cost'];
                    $margin = $resultSearchLandCost['margin'];

                    $con->query("INSERT INTO purchase_return_item (
                        pr_grn_number, pr_grn_date, counter_name, pr_item_id, pr_item_qty, pr_item_amount, pr_land_cost, pr_margin, pr_s_no, branch_id
                    ) VALUES (
                        '$billNumber', '$_SESSION[pr_date]', '$_SESSION[counter_name]', '$s_itemId[$a]', '$s_itemQty[$a]', '$s_itemAmount[$a]',
                        '$landCost', '$margin', '$s_serialNumber[$a]', '$userBranchId'
                    )");

                    $con->query("INSERT INTO stock_transaction (
                        grn_number, grn_date, counter_name, item_id, item_qty, land_cost, entry_type, branch_id
                    ) VALUES (
                        '$billNumber', '$_SESSION[pr_date]', '$_SESSION[counter_name]', '$s_itemId[$a]', '$s_itemQty[$a]', '$landCost', 'PR', '$userBranchId'
                    )");

                    $con->query("UPDATE stock_balance SET item_qty = item_qty - $s_itemQty[$a] WHERE item_id = '$s_itemId[$a]' AND branch_id = '$userBranchId'");
                }
                $a++;
            }

            $con->commit();

            $_SESSION['notification'] = "Purchase Return Updated Successfully";
            header("Location:" . BASE_URL . "/pages/purchaseReturnEdit.php");
            exit();
        } else {
            $_SESSION['notification'] = "Bill Amount And Net Amount Does Not Match";
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    let toastElement = new bootstrap.Toast(document.getElementById("liveToast"));
                    toastElement.show();
                });
            </script>';
        }
    } catch (Exception $e) {
        $con->rollback();
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                let toastElement = new bootstrap.Toast(document.getElementById("liveToast"));
                toastElement.show();
            });
        </script>';
    }
}



?>



<?php include_once(DIR_URL . "/includes/footer.php"); ?>
<?php ob_end_flush(); ?>