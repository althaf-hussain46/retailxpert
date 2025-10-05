<style>

</style>
<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

use function PHPSTORM_META\type;

include_once("../config/config.php");
include_once(DIR_URL . "/includes/header.php");
include_once(DIR_URL . "/db/dbConnection.php");
include_once(DIR_URL . "/includes/navbar.php");
ob_start();
include_once(DIR_URL . "/includes/sidebar.php");
// include_once(DIR_URL."includes/itemMaster.php");



$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$financial_year = $_SESSION['financial_year'];
$companyState = $_SESSION['company_state'];



$supplierName = "";
$supplierMobile  = "";
$prNumber = "";
$prDate = "";
$counterName = "";
$totalQty = 0;
$totalTotal = 0;
$netDiscountPercent = 0;
$deductionAmount = 0;
$addOnAmount = 0;

$PurchaseReturnNetAmount = 0;
$netAmount = 0;
$sr_totalQty = 0;
$sr_totalAmount = 0;
$sr_netDeduction = 0;
$sr_netAddOn = 0;
$sr_netAmount = 0;



$s_qty                 = 0;
$s_amount              = 0;
$s_deduction           = 0;
$s_addon               = 0;
$afterAddOn = 0;
$sales_return_amount = 0;
$s_net_amount          = 0;
$sr_qty                = 0;
$sr_amount             = 0;
$sr_deduction          = 0;
$sr_addon              = 0;
$sr_net_amount         = 0;


// $currentDate = date("Y-m-d H:i:s");
// echo $currentDate;

$querySearchsupplierId = "select*from customers where customer_name = 'Cash'
                              && branch_id = '$userBranchId'";
$resultSearchsupplierId = $con->query($querySearchsupplierId)->fetch_assoc();




if (isset($_POST['grnNumberSearchButton'])) {
    extract($_POST);



    $querySearchPurchaseItem = "select pri.*,i.*
                            from purchase_return_item as pri
                            join items as i on i.id  = pri.pr_item_id
                            where pri.pr_grn_number = '$prNumber' and pri.branch_id = '$userBranchId'";
    $resultSearchPurchaseItem = $con->query($querySearchPurchaseItem);


    $querySearchPurchaseReturnItem = "select pri.*,i.*
                            from purchase_return_item as pri
                            join items as i on i.id  = pri.pr_item_id
                            where pri.pr_grn_number = '$prNumber' and pri.branch_id = '$userBranchId'";
    $resultSearchPurchaseReturnItem = $con->query($querySearchPurchaseReturnItem);



    $querySearchPurchaseSummary = "select*from purchase_return_summary where pr_grn_number = '$prNumber'
                                and branch_id = '$userBranchId'";

    $resultSearchPurchaseSummary = $con->query($querySearchPurchaseSummary)->fetch_assoc();





    $s_qty                 = $resultSearchPurchaseSummary['pr_total_qty'];
    $s_amount              = $resultSearchPurchaseSummary['pr_total_amount'];
    $s_deduction           = $resultSearchPurchaseSummary['pr_deduction'];
    $s_addon               = $resultSearchPurchaseSummary['pr_addon'];
    $s_net_amount          = $resultSearchPurchaseSummary['pr_net_amount'];





    $afterAddOn = $resultSearchPurchaseSummary['pr_total_amount'] - $resultSearchPurchaseSummary['pr_deduction'] + $resultSearchPurchaseSummary['pr_addon'];
    // echo $afterAddOn;

}


if (isset($_POST['deleteButton'])) {
    extract($_POST);

    $con->begin_transaction(); // Start transaction

    try {
        // Update Stock Balance
        $queryUpdatePurchaseReturnStock = "UPDATE stock_balance sb
                                  INNER JOIN purchase_return_item pri ON pri.pr_item_id = sb.item_id
                                  SET sb.item_qty = sb.item_qty + pri.pr_item_qty
                                  WHERE pri.pr_grn_number = ? AND pri.branch_id = ?";
        $stmt = $con->prepare($queryUpdatePurchaseReturnStock);
        $stmt->bind_param("si", $prNumber, $userBranchId);
        $stmt->execute();

        // Delete from stock_transaction
        $queryDeletePurchaseReturnStockTransaction = "DELETE FROM stock_transaction WHERE grn_number = ? AND branch_id = ?
                                            AND counter_name = ?";
        $stmt = $con->prepare($queryDeletePurchaseReturnStockTransaction);
        $stmt->bind_param("sis", $prNumber, $userBranchId, $counterName);
        $stmt->execute();

        // Delete from sales_item
        $queryDeletePurchaseItem = "DELETE FROM purchase_return_item WHERE pr_grn_number = ? AND branch_id = ?
                                 AND counter_name = ?";
        $stmt = $con->prepare($queryDeletePurchaseItem);
        $stmt->bind_param("sis", $prNumber, $userBranchId, $counterName);
        $stmt->execute();

        // Delete from sales_summary
        // $queryDeletePurchaseSummary = "DELETE FROM sales_summary WHERE sales_number = ? AND branch_id = ?
        //                             AND counter_name = ?";
        // $stmt = $con->prepare($queryDeletePurchaseSummary);
        // $stmt->bind_param("sis", $prNumber, $userBranchId,$counterName);
        // $stmt->execute();

        // Delete from purchase_return_item
        $queryDeletePurchaseReturnItem = "DELETE FROM purchase_return_item WHERE pr_grn_number = ? AND branch_id = ?
                                       AND counter_name = ?";
        $stmt = $con->prepare($queryDeletePurchaseReturnItem);
        $stmt->bind_param("sis", $prNumber, $userBranchId, $counterName);
        $stmt->execute();

        // Delete from sales_return_summary
        $queryDeletePurchaseReturnSummary = "DELETE FROM purchase_return_summary WHERE pr_grn_number = ? AND branch_id = ?
                                          AND counter_name = ?";
        $stmt = $con->prepare($queryDeletePurchaseReturnSummary);
        $stmt->bind_param("sis", $prNumber, $userBranchId, $counterName);
        $stmt->execute();

        // Commit transaction
        $con->commit();

        $_SESSION['notification'] = "Purchase Return Bill Deleted Successfully";
        // header("Location:".BASE_URL."/pages/purchaseReturnDelete.php");


    } catch (Exception $e) {
        $con->rollback(); // Rollback changes on error
        $_SESSION['notification'] = "Error: " . $e->getMessage();
        header("Location:" . BASE_URL . "/pages/purchaseReturnDelete.php");
    }

    $supplierName = "";
    $supplierMobile = "";
    $prNumber = "";
    $prDate = "";
    $counterName = "";


    // header("Location:".BASE_URL."/pages/purchaseReturnDelete.php");
}


// if(isset($_POST['deleteButton'])){
//     extract($_POST);

//         $queryUpdatePurchaseReturnStock = "update stock_balance sb
//                                   inner join sales_item  si on si.s_item_id  = sb.item_id
//                                   set sb.item_qty = sb.item_qty + si.s_item_qty
//                                   where si.sales_number = '$prNumber' and si.branch_id = '$userBranchId'
//         ";
//         $resultUpdatePurchaseReturnStock = $con->query($queryUpdatePurchaseReturnStock);


//         $queryDeletePurchaseReturnStockTransaction = "delete from stock_transaction where 
//                                             grn_number = '$prNumber' and branch_id = '$userBranchId'
//                                             ";
//         $resultDeletePurchaseReturnStockTransaction = $con->query($queryDeletePurchaseReturnStockTransaction);       


//         $queryDeletePurchaseItem = "delete from sales_item where sales_number = '$prNumber'
//                                 and branch_id = '$userBranchId'";
//         $resultDeletePurchaseItem = $con->query($queryDeletePurchaseItem);

//         $queryDeletePurchaseSummary = "delete from sales_summary  where sales_number = '$prNumber'
//                                     and branch_id = '$userBranchId'    
//                                     ";
//         $resultDeletePurchaseSummary = $con->query($queryDeletePurchaseSummary);



//         $queryDeletePurchaseReturnItem = "delete from sales_return_item where sr_number = '$prNumber'
//                                 and branch_id = '$userBranchId'";
//         $resultDeletePurchaseReturnItem = $con->query($queryDeletePurchaseReturnItem);

//         $queryDeletePurchaseReturnSummary = "delete from sales_return_summary  where sr_number = '$prNumber'
//                                     and branch_id = '$userBranchId'    
//                                     ";
//         $resultDeletePurchaseReturnSummary = $con->query($queryDeletePurchaseReturnSummary);


//         $_SESSION['notification'] = "Sales Bill Deleted Successfully";
//         $supplierName = "";
//         $supplierMobile = "";
//         $prNumber = "";
//         $prDate = "";
//         $counterName = "";
//         // header("Location:".BASE_URL."/pages/purchaseReturnDelete.php");
// }





?>

<script>



</script>





<style>
.nav-tabs .nav-link.active#home-tab {
    background-color: #4CAF50 !important;
    /* Green for Sales */
    color: white !important;
}

.nav-tabs .nav-link.active#profile-tab {
    background-color: rgba(214, 46, 16, 0.78) !important;
    /* Orange-Red for Sales Return */
    color: white !important;
}
</style>
<?php
$querySearchSnoMaster = "select*from sales_sno_master where counter_name = '$_SESSION[counter_name]'
                         && financial_year = '$financial_year'
                         && branch_id='$userBranchId' ";
$resultSearchSnoMaster  = $con->query($querySearchSnoMaster)->fetch_assoc();
$sales_no = $resultSearchSnoMaster['sales_no'];
$sales_no = $sales_no + 1;

if (isset($sales_no)) {
} else {
    $sales_no = "";
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
#duplicateSupplierMobile {
    width: 120px;
    height: 30px;
    margin-top: -80px;
    margin-left: 819px;
    display: none;

}

/* #purchaseReturnDelete{

    margin-left:5px;margin-top:-120px;
    width: 340px;
    font-size: 10px;
    font-weight: bold;
    text-transform: capitalize;
    padding: 4px 79px;
    height: 30px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    
    font-weight:bolder;
    background-color: red;
    /* background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%); */
/* color: white; */
/* border-radius: 5px; */
/*box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);*/
/* background-color:#DC3545; */
/* background-color:rgba(224, 46, 26, 100) !important; Orange-Red for Sales Return */
/* } */



#purchaseReturnDelete {

    margin-left: 0px;
    margin-top: -120px;
    width: 404px;
    font-size: 14px;
    font-weight: bold;
    text-transform: capitalize;
    padding: 4px 38px;
    height: 30px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    letter-spacing: 5px;
    font-weight: bolder;
    background-color: #DC3545;
    /* background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%); */
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

#serialNumber_1 {

    background-color: white;
    color: black;
}

#totalQty {
    background-color: gainsboro;
}

#totalAmount {
    background-color: gainsboro;
}

#netAmount {
    background-color: gainsboro;
}

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
    margin-top: -120px;
    /* margin-left:300px; */
    width: 350px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
}

#supplierId {
    margin-top: -120px;
    /* margin-left:300px; */
    /* display: none; */
    width: 80px;
    font-size: 10px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
}

#grnAmount {
    margin-top: -100px;
    /* margin-left:1000px; */
    width: 150px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
}

#prNumber,
#prDate {
    margin-top: 20px;
    margin-left: 15px;
    width: 140px;
    font-size: 13px;
    font-weight: bold;
    text-transform: capitalize;
    height: 48px;
}

#counterName {
    margin-top: 10px;
    margin-left: 15px;

    width: 140px;
    font-size: 13px;
    font-weight: 800;
    text-transform: capitalize;
    height: 48px;

}
</style>
<!-- Bootstrap Toast -->

<?php
if (isset($_SESSION['notification'])) {
} else {

    $_SESSION['notification'] = "";
}
?>
<?php if ($_SESSION['notification'] != '') { ?>
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
    <div class="" style="margin-left:1173px;border:1px solid black;width:340px;height:140px;margin-top:10px;">



        <div style="display:flex;gap:10px;">
            <div class="form-floating">
                <input type="text" name="prNumber" id="prNumber" class="form-control" placeholder="Bill Number"
                    value="<?php echo $prNumber; ?>" autocomplete="off" maxlength="30"
                    style="background-color:blanchedalmond;">
                <label for="prNumber" style="margin-left:6px;margin-top:12px;font-size:large;font-weight:bold;">PR
                    Number</label>
            </div>
            <div class="form-floating">
                <input type="date" name="prDate" readonly id="prDate" class="form-control" placeholder="Bill Date "
                    value="<?php echo $prDate; ?>" maxlength="30">
                <label for="prDate" style="margin-left:15px;margin-top:15px;font-size:large;font-weight:bold">PR
                    Date</label>
            </div>
        </div>

        <div style="display: flex;">
            <div class="form-floating">
                <input type="text" name="counterName" readonly id="counterName" class="form-control"
                    value="<?php echo $counterName; ?>" maxlength="4">
                <label for="counterName"
                    style="margin-left:15px;margin-top:5px;font-size:large;font-weight:bold">Counter</label>
                <button type="submit" name="grnNumberSearchButton" id="grnSearchButton"
                    style="width:22px;height:25px;position:absolute;left:220px;top:20px" hidden>S</button>
            </div>

        </div>


    </div>
    <div style="margin-top:-20px;margin-left:-12px">

        <div style="display:flex;gap:12px">
            <label for="" style="margin-left:280px;margin-top:-118px;">Supplier Name</label>
            <input type="text" name="supplierName" readonly autocomplete="off" id="supplierName" class="form-control"
                value="<?php echo $supplierName; ?>">

            <input type="text" hidden name="supplierId" id="supplierId" class="form-control"
                value="<?php echo $resultSearchSupplierId['id']; ?>">
            <label for="" id="purchaseReturnDelete">PURCHASE RETURN DELETE</label>
        </div>
        <div style="display:flex;gap:6px">
            <label for="" style="margin-left:280px;margin-top:-78px;">Supplier Mobile</label>
            <input type="text" readonly style="width:280px;height:30px;margin-top:-80px;" name="supplierMobile"
                value="<?php echo $supplierMobile; ?>" autocomplete="off" id="supplierMobile" maxlength="10"
                class="form-control">










        </div>

        <div style="display:flex;gap:6px">
            <input type="text" name="duplicateSupplierMobile" autocomplete="off" id="duplicateSupplierMobile"
                maxlength="10" class="form-control">
        </div>


        <br>


    </div>

    <div style="display:flex" hidden>
        <label for="" style="margin-left:200px;">User Id</label>
        <input type="text" name="userId" readonly id="userId" class="form-control" value="<?php echo $userId; ?>"
            style="width:250px;">
        <label for="">Branch Id</label>
        <input type="text" name="userBranchId" readonly id="userBranchId" class="form-control"
            value="<?php echo $userBranchId; ?>" style="width:250px;">
    </div>






    <div class="container" style="margin-top:10px" id="itemGrid">


        <div style="margin-left: 160px; font-size: 11px;">
            <div style="width: 1250px; height: 300px; overflow-y: auto;overflow-x:auto" id="itemTable">
                <table class="table text-white"
                    style="border-collapse: collapse; width: 1250; text-align: center;font-size:11px">
                    <thead>
                        <tr style="position: sticky; z-index: 1; top: 0; background-color: #FF3CAC;">
                            <th style="width: 21px;">S.No.</th>
                            <th style="width: 100px;">Design</th>
                            <th style="width: 300px;">Description</th>
                            <th style="width: 50px;">HSN</th>
                            <th style="width: 10px;">Tax</th>
                            <th style="width: 50px;">Selling</th>
                            <th style="width: 10px;">Qty</th>
                            <th style="width: 80px;">Land Cost</th>
                            <th style="width: 80px;">Margin</th>
                            <th style="width: 110px;">Amount</th>
                            <th style="width: 20px;">Id</th>
                        </tr>
                    </thead>
                    <tbody id="table_body" class="items">
                        <?php
                        if (isset($resultSearchPurchaseItem) && isset($grnNumberSearchButton)) {
                            $sno = 1;
                            foreach ($resultSearchPurchaseItem as $PurchaseReturnData) {

                                $description = $PurchaseReturnData['product_name'] . "/" . $PurchaseReturnData['brand_name'] . "/" .
                                    $PurchaseReturnData['color_name'] . "/" . $PurchaseReturnData['batch_name'] . "/" . $PurchaseReturnData['tax_code'] . "/" .
                                    $PurchaseReturnData['size_name'] . "/" . $PurchaseReturnData['mrp'];
                        ?>
                        <tr>
                            <td><?php echo $PurchaseReturnData['pr_s_no']; ?></td>
                            <td style=""><?php echo htmlspecialchars($PurchaseReturnData['design_name']); ?></td>
                            <td><?php echo htmlspecialchars($description); ?></td>
                            <td><?php echo htmlspecialchars($PurchaseReturnData['hsn_code']); ?></td>
                            <td><?php echo htmlspecialchars($PurchaseReturnData['tax_code']); ?></td>
                            <td><?php echo htmlspecialchars($PurchaseReturnData['selling_price']); ?></td>
                            <td><?php echo htmlspecialchars($PurchaseReturnData['pr_item_qty']); ?></td>
                            <td><?php echo htmlspecialchars($PurchaseReturnData['pr_land_cost']); ?></td>
                            <td><?php echo htmlspecialchars($PurchaseReturnData['pr_margin']); ?></td>
                            <td><?php echo htmlspecialchars($PurchaseReturnData['pr_item_amount']); ?></td>
                            <td><?php echo htmlspecialchars($PurchaseReturnData['pr_item_id']); ?></td>
                        </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>





        <div style="display: flex;margin-top:20px">
            <button style="margin-left:180px;width:120px;" type="submit" class="btn btn-danger" name="deleteButton"
                id="deleteButton"
                onclick="return confirm('Are You Sure Do You Want To Delete This Purchase Return Bill')">
                Delete
            </button>

            <button type="submit" style="margin-left:10px;width:120px;" class="btn btn-warning" name="cancelButton"
                id="cancelButton">
                Cancel
            </button>


        </div>
        <!-- <br>
            <button style="padding-top:0px;position:relative;left:1270px;top:106px;width:120px;
            font-weight:bolder;height:30px;font-size:large"
            type="submit" class="btn btn-primary"
            name="submit_button" id="submitButton">Submit</button> -->
    </div>

    <div style="margin-left:1180px;margin-top:-45px">
        <div style="display:flex;gap:8px">
            <label for="" style="margin-left:-12px">Total</label>
            <input type="text" value="<?php echo $s_qty; ?>" name="totalQty" id="totalQty" class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:50px;" maxlength="4">
            <input type="text" value="<?php echo $s_amount; ?>" name="totalAmount" id="totalAmount" class="form-control"
                readonly style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
            <input type="text" name="totalActualAmount" id="totalActualAmount" hidden class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
            <input type="text" name="totalTaxable" id="totalTaxable" hidden readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px" class="form-control"
                maxlength="12">
            <input type="text" name="totalTaxAmount" id="totalTaxAmount" hidden readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px" class="form-control"
                maxlength="12">
        </div>


        <!-- <div style="display:flex;margin-top:-25px;margin-left:180px">
<label for="">CGST</label>
<input type="text" name="cgstAmount" id="cgstAmount" readonly autocomplete="off" class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:10px" maxlength="12">
</div>
<div style="display:flex;margin-top:5px;margin-left:180px">
<label for="">SGST</label>
<input type="text" name="sgstAmount" id="sgstAmount" readonly autocomplete="off" class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:10px" maxlength="12">
</div>
<div style="display:flex;margin-top:5px;margin-left:180px">
<label for="">IGST</label>
<input type="text" name="igstAmount" id="igstAmount" readonly autocomplete="off" class="form-control"  style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:15px" maxlength="12">
</div> -->

        <div style="display:flex;margin-top:5px;margin-left:-11px;gap:2px">
            <label for="">Dis %</label>
            <input type="text" name="netDiscountPercent" value="<?php echo $netDiscountPercent; ?>" readonly
                id="netDiscountPercent" class="form-control" autocomplete="off" maxlength="4"
                style="width:51px;height:25px">
            <!-- <label for="">Discount </label> -->
            <input type="text" value="<?php echo $s_deduction; ?>" name="deductionAmount" readonly id="deductionAmount"
                autocomplete="off" class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;"
                maxlength="12">
        </div>

        <div style="display:flex;margin-top:5px;">

            <label for="" style="margin-left: -11px;">Add On</label>
            <input type="text" value="<?php echo $s_addon; ?>" name="addOnAmount" id="addOnAmount" readonly
                autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:40px" maxlength="12">
        </div>

        <div style="display:flex;margin-top:5px">
            <label for="" style="margin-left:-11px;">After Add On</label>
            <input type="text" value="<?phP echo $afterAddOn; ?>" name="afterAddOn" id="afterAddOn" class="form-control"
                readonly style="font-weight:bold;text-align:right;font-size:12px;height:25px;width:90px;margin-left:1px"
                maxlength="12">
        </div>


        <div style="display:flex;margin-top:5px;">
            <label for="" style="margin-left: -11px;color:green;font-size:15px;font-weight:bolder;margin-top:2px">Net
                Amount</label>
            <input type="text" value="<?php echo $s_net_amount; ?>" name="netAmount" id="netAmount" class="form-control"
                readonly
                style="font-weight:bolder;color:green;text-align:right;font-size:15px;height:30px;width:90px;margin-left:8px"
                maxlength="12">

        </div>
    </div>







</form>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
document.addEventListener("keydown", function(event) {
    if (event.key === "F5") {
        event.preventDefault();

        let confirmRefresh = confirm("Are you sure you want to refresh? Your unsaved data will be lost.");
        if (confirmRefresh) {
            location.reload();
        }
    }
})


// Fetching Sales Summary Data For Bill Print Starts

document.getElementById("prNumber").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "F2") {
        event.preventDefault();
        let prNumber = new FormData();
        prNumber.append("lb_pr_number", target.value);
        let aj_prNumber = new XMLHttpRequest();
        aj_prNumber.open("POST", "ajaxPurchaseReturnBillDelete.php", true);
        aj_prNumber.send(prNumber);
        aj_prNumber.onreadystatechange = function() {
            if (aj_prNumber.status === 200 && aj_prNumber.readyState === 4) {
                document.getElementById("response_message").innerHTML = aj_prNumber.responseText;


            }
        }

    }

})














window.onload = function() {




    let pr_number = document.getElementById("prNumber").value;
    if (pr_number != '') {
        document.getElementById("prNumber").setAttribute('readonly', true);
        document.getElementById("prNumber").style.background = "#E9ECEF";
    } else {


    }








    localStorage.setItem('customer_state', '1');
    localStorage.setItem('sales_return', '0');
    let customerState = localStorage.getItem("customer_state");



    // document.getElementById("totalQty").value = 0;
    // document.getElementById("totalAmount").value = 0;
    // document.getElementById("addOnAmount").value = 0;
    // document.getElementById("deductionAmount").value = 0;
    // document.getElementById("netAmount").value = 0;
    // document.getElementById("netDiscountPercent").value = 0;


    //sales return text fields start

    // document.getElementById("sr_totalQty").value = 0;
    // document.getElementById("sr_totalAmount").value = 0;
    // document.getElementById("sr_addOnAmount").value = 0;
    // document.getElementById("sr_deductionAmount").value = 0;
    // document.getElementById("sr_netAmount").value = 0;
    // document.getElementById("sr_netDiscountPercent").value = 0;


    //sales return text fields end




    // document.getElementById("cgstAmount").setAttribute('readonly','true');
    // document.getElementById("sgstAmount").setAttribute('readonly','true');
    // document.getElementById("igstAmount").setAttribute('readonly','true');


    // if(customerState === "1"){

    //     document.getElementById("cgstAmount").disabled = false;
    //     document.getElementById("sgstAmount").disabled = false;
    //     document.getElementById("igstAmount").disabled = true;    
    //     cgstAmount.style.background = 'none';
    //     sgstAmount.style.background = 'none';
    //     igstAmount.style.background = 'gainsboro';
    // }else{
    //     document.getElementById("cgstAmount").disabled = true;
    //     document.getElementById("sgstAmount").disabled = true;
    //     document.getElementById("igstAmount").disabled = false;
    //     cgstAmount.style.background = 'gainsboro';
    //     sgstAmount.style.background = 'gainsboro';
    //     igstAmount.style.background = 'none';
    // }

    // document.getElementById("cgstAmount").disabled = true;
    // document.getElementById("sgstAmount").disabled = true;
    // document.getElementById("igstAmount").disabled = true;


    localStorage.setItem("total_rows", 1);
    localStorage.setItem("sr_row_index", 1);
    localStorage.setItem("sr_total_rows", 1);
    let mydate = new Date();
    let currentDate = mydate.getFullYear() + "-" +
        (mydate.getMonth() + 1).toString().padStart(2, "0") + "-" +
        mydate.getDate().toString().padStart(2, "0");
    // document.getElementById("prDate").value = currentDate;


    // document.getElementById("prNumber").value = '<?php echo htmlspecialchars($sales_no); ?>';



}
let rowIndex = localStorage.getItem("row_index");










setTimeout(() => {
    var alertBox = document.getElementById("liveToast");
    if (alertBox) {
        alertBox.style.display = 'none';
    }
}, 2000);



let prNumber = document.getElementById('prNumber').value;
if (prNumber == "") {
    document.getElementById('deleteButton').disabled = true;
    document.getElementById('cancelButton').style.display = "none";
} else {
    document.getElementById('cancelButton').style.display = "block";
    document.getElementById('deleteButton').disabled = false;
}

//     if(prNumber2==""){
//     
// }else{
//     
// }
</script>

</body>

</html>

<?php





if (isset($_POST['submit_button'])) {

    $supplierName            =  $_POST['supplierName'];
    $supplierId              = $_POST['supplierId'];
    $counterName             = $_POST['counterName'];



    $prNumber = $_SESSION['sales_number'] = $_POST['prNumber'];
    // $prDate = $_POST['prDate'];

    date_default_timezone_set("Asia/Kolkata");
    $prDate = date("Y-m-d h:i:s A");


    echo "current data and time  = " . $prDate;

    $netAmount = $_POST['netAmount'];
    // Sales Item  Grid Attributes Start
    $design                         = $_POST['design'];
    $sales_Number                   = $_POST['prNumber'];
    // $prDate                     = $_POST['prDate'];
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
    $PurchaseReturnAmount       = isset($_POST['PurchaseReturnNetAmount']) ? $_POST['PurchaseReturnNetAmount'] : 0;
    $salesNetAmount          = isset($_POST['netAmount']) ? $_POST['netAmount'] : 0;

    echo $salescgstAmount;
    echo "<br>";
    echo $salessgstAmount;
    echo "<br>";
    echo $salesigstAmount;
    echo "<br>";
    echo $salesAddonAmount;
    echo "<br>";
    echo $salesDeductionAmount;
    echo "<br>";
    echo $PurchaseReturnAmount;
    echo "<br>";
    echo $salesNetAmount;
    echo "<br>";








    if ($resultQuery) {

        $_SESSION['notification'] = " Saved Successfully";
        header("Location:" . BASE_URL . "/pages/purchaseReturnDelete.php");
        $_SESSION['printSales'] = $_POST['printSales'];
    } else {
        echo "something went wrong";
    }





    // purchase return starts





    if ($sr_netAmount > 0) {


        $supplierName =  $_POST['supplierName'];
        $sr_design = $_POST['sr_design'];
        echo "Sales Return ";
        echo "<br>";
        echo "<pre>";
        print_r($sr_design);
        echo "</pre>";
        $querySearchsupplierId = "select*from customers where customer_name = '$supplierName'
                                  && branch_id = '$userBranchId'";
        $resultSearchsupplierId = $con->query($querySearchsupplierId)->fetch_assoc();
        $supplierId = $resultSearchsupplierId['id'];

        $sr_Number = $_POST['prNumber'];
        $sr_Date = $_POST['prDate'];
        $counterName = $_POST['counterName'];

        // Sales Return Item  Grid Attributes Start

        $sr_itemId = $_POST['sr_id'];
        $sr_salesPersonNumber = $_POST['sr_salesMan'];
        $sr_itemTax = $_POST['sr_tax'];
        $sr_itemQty  = $_POST['sr_qty'];
        $sr_itemDiscountPercent = $_POST['sr_discountPercent'];
        $sr_itemDiscountAmount = $_POST['sr_discountAmount'];
        $sr_itemAmount = $_POST['sr_amount'];
        $sr_itemActualAmount = $_POST['sr_actualAmount'];
        $sr_itemTaxableAmount = $_POST['sr_taxable'];
        $sr_itemTaxAmount = $_POST['sr_taxAmount'];
        $sr_serialNumber = $_POST['sr_serialNumber'];

        // Sales Return Item  Grid Attributes End

        $sr_TotalQty           = $_POST['sr_totalQty'];
        $sr_TotalAmount        = $_POST['sr_totalAmount'];
        $sr_TotalActualAmount  = $_POST['sr_totalActualAmount'];
        $sr_TotalTaxableAmount = $_POST['sr_totalTaxable'];
        $sr_TotalTaxAmount     = $_POST['sr_totalTaxAmount'];
        $sr_cgstAmount         = isset($_POST['sr_cgstAmount']) ? $_POST['sr_cgstAmount'] : 0;
        $sr_sgstAmount         = isset($_POST['sr_sgstAmount']) ? $_POST['sr_sgstAmount'] : 0;
        $sr_igstAmount         = isset($_POST['sr_igstAmount']) ? $_POST['sr_igstAmount'] : 0;
        $sr_AddonAmount        = isset($_POST['sr_addOnAmount']) ? $_POST['sr_addOnAmount'] : 0;
        $sr_DeductionAmount    = isset($_POST['sr_deductionAmount']) ? $_POST['sr_deductionAmount'] : 0;
        $sr_NetAmount          = isset($_POST['sr_netAmount']) ? $_POST['sr_netAmount'] : 0;


        // if(($sr_netAmount - $sr_totalAmount) != 0 ){
        //     $sr_percent = round((($sr_netAmount-$sr_totalAmount)/$sr_totalAmount)*100,2);
        // }else{
        //     $sr_percent = 0;
        // }

        $percent = round((($sr_DeductionAmount - $sr_AddonAmount) / $sr_TotalAmount) * 100, 4);







        $a = 0;
        $sr_itemActualAmount = 0;
        $sr_itemTaxPercentage = 0;
        $sr_itemTaxableAmount = 0;
        $sr_itemTaxAmount = 0;
        $sr_billActualAmount = 0;
        $sr_billTaxableAmount = 0;
        $sr_billTaxAmount    = 0;
        $sr_billIgstAmount = 0;
        $sr_billCgstAmount = 0;
        $sr_billSgstAmount = 0;

        foreach ($sr_design as $des) {

            $sr_itemActualAmount = round($sr_itemAmount[$a] - (($sr_itemAmount[$a] * $percent) / 100), 2);
            $sr_itemTaxPercentage =  str_replace("G", "", $sr_itemTax[$a]);
            $sr_itemTaxableAmount = round((($sr_itemActualAmount / ($sr_itemTaxPercentage + 100)) * 100), 2);
            $sr_itemTaxAmount = round(($sr_itemTaxableAmount * $sr_itemTaxPercentage) / 100, 2);


            $queryPurchaseReturnItem = "insert into sales_return_item (sr_number, sr_date,
                                counter_name,sr_item_id,sr_salesperson_code,
                                sr_item_qty,sr_discount_percentage,sr_discount_amount,
                                sr_item_amount,sr_actual_amount,sr_taxable_amount,
                                sr_tax_amount,sr_s_no,branch_id)
                                
            values('$sr_Number','$sr_Date','$counterName','$sr_itemId[$a]',
            '$sr_salesPersonNumber[$a]','$sr_itemQty[$a]','$sr_itemDiscountPercent[$a]',
            '$sr_itemDiscountAmount[$a]','$sr_itemAmount[$a]','$sr_itemActualAmount',   
            '$sr_itemTaxableAmount','$sr_itemTaxAmount','$sr_serialNumber[$a]',
            '$userBranchId')";


            $resultQuery = $con->query($queryPurchaseReturnItem);


            $querySearchLandCost = "select*from purchase_item where item_id = '$sr_itemId[$a]'
            && branch_id = '$userBranchId'";
            $resultSearchLandCost = $con->query($querySearchLandCost)->fetch_assoc();

            $landCost = $resultSearchLandCost['land_cost'];

            $queryStockTransaction = "insert into stock_transaction (grn_number, grn_date,item_id,
                                  item_qty,land_cost,entry_type,branch_id)
            values('$sr_Number','$sr_Date','$sr_itemId[$a]','$sr_itemQty[$a]',
                   '$landCost','SR','$userBranchId')";

            $resultStockTransaction = $con->query($queryStockTransaction);



            $queryStockBalance = "update stock_balance set item_qty = item_qty+$sr_itemQty[$a]
                        where item_id = '$sr_itemId[$a]' and branch_id = '$userBranchId'";

            $resultStockBalance = $con->query($queryStockBalance);


            $sr_billActualAmount = $sr_billActualAmount + $sr_itemActualAmount;
            $sr_billTaxableAmount = $sr_billTaxableAmount + $sr_itemTaxableAmount;
            $sr_billTaxAmount    = $sr_billTaxAmount + $sr_itemTaxAmount;




            $a++;
        }

        if ($salesigstAmount > 0) {

            $sr_billIgstAmount = $sr_billTaxAmount;
            $sr_billCgstAmount = 0;
            $sr_billSgstAmount = 0;
        } else {
            $sr_billIgstAmount = 0;
            $sr_billCgstAmount = $sr_billTaxAmount / 2;
            $sr_billSgstAmount = $sr_billTaxAmount / 2;
        }




        $queryInsertPurchaseReturnSummary = "insert into sales_return_summary (sr_number,sr_date,counter_name,customer_id,
        sr_qty,sr_amount,sr_actual_amount,sr_taxable_amount,sr_tax_amount,
        sr_cgst_amount,sr_sgst_amount,sr_igst_amount,sr_addon,sr_deduction,
        sr_net_amount,user_id,branch_id)
        values('$sr_Number','$sr_Date','$counterName','$supplierId',
        '$sr_TotalQty','$sr_TotalAmount','$sr_billActualAmount',
        '$sr_billTaxableAmount','$sr_billTaxAmount','$sr_billCgstAmount',
        '$sr_billSgstAmount','$sr_billIgstAmount','$sr_AddonAmount',
        '$sr_DeductionAmount','$sr_NetAmount','$userId','$userBranchId')";

        $resultInsertPurchaseReturnSummary = $con->query($queryInsertPurchaseReturnSummary);

        // $sr_resultQuery = $con->query($sr_query);


        // if($resultInsertPurchaseReturnSummary){

        //     $_SESSION['notification'] = "Sales Return Saved Successfully";            
        //     header("Location:".BASE_URL."/pages/purchaseReturnDelete.php");

        // }else{
        //     echo "something went wrong";
        // }



    }
}



function printSalesBill($prNumber)
{

    $_SESSION['sales_number'] = $prNumber;


    // header("Location:".BASE_URL."exportFile/pdfFileSalesBillPrint.php");
    // exit();
}




?>


<?php ob_end_flush(); ?>
<?php include_once(DIR_URL . "/includes/footer.php"); ?>