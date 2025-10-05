<?php ob_start(); ?>
<!-- when i press f2 in grnNumber text field , purchaseSummaryTable popup using ajax showing purchase summary of different grn numbers. when i select any particular row from purchaseSummaryTable all the data from purchase_item pertaining to  that grn number should display  in itemGrid.this code i have written for one row but i want all rows to be append in the itemGrid automatically -->
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
unset($_SESSION['resultSearchPurchaseItem']);
$d = 1;
$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$financial_year = $_SESSION['financial_year'];
$companyState = $_SESSION['company_state'];
$counterName = $_SESSION['counter_name'];

// if(isset($_SESSION['grn_number'])){
// echo "grn_number = ".$_SESSION['grn_number'];
// }

if (isset($_POST['add'])) {
    // echo "grn number = ".$_POST['grn_number'];
    // $_SESSION['grn_number'] = $_POST['grn_number'];

}

// if(isset($_SESSION['item_id'])){
//     $itemId = $_SESSION['item_id'];
//     echo "item id = ".$itemId;
// }


?>

<script>


</script>






<?php
$querySearchSnoMaster = "select*from sno_master where financial_year = '$financial_year'
                         && branch_id='$userBranchId'";
$resultSearchSnoMaster  = $con->query($querySearchSnoMaster)->fetch_assoc();
$purchase_no = $resultSearchSnoMaster['purchase_no'];
$purchase_no = $purchase_no + 1;

if (isset($purchase_no)) {
} else {
    $purchase_no = "";
}
$supplierName = "";

$grnNumber = "";
$grnDate = "";
$grnAmount = "";
$dcNumber = "";
$dcDate = "";
$invoiceNumber = "";
$invoiceDate = "";
$totalQty = "";
$totalAmount = "";
$cgstAmount = "";
$sgstAmount = "";
$igstAmount = "";
$addOnAmount = "";
$deductionAmount = "";
$netAmount = "";


if (isset($_POST['grnNumberSearchButton'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    extract($_POST);
    // echo "<br>";
    // echo "grn Number = ";
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
    // echo $dcDate;
    // echo "<br>";
    // echo $invoiceNumber;
    // echo "<br>";
    // echo $invoiceDate;

    $querySearchPurchaseItem  = "SELECT 
                                purchase_item.*, 
                                items.*
                                FROM purchase_item
                                INNER JOIN items ON purchase_item.item_id = items.id
                                WHERE purchase_item.grn_number = '$grnNumber' 
                                AND purchase_item.branch_id = '$userBranchId'";
    $resultSearchPurchaseItem = $con->query($querySearchPurchaseItem);

    $_SESSION['resultSearchPurchaseItem'] = $con->query($querySearchPurchaseItem)->fetch_all(MYSQLI_ASSOC);

    while ($data = $resultSearchPurchaseItem->fetch_assoc()) {
        $id1[] = $data['item_id'];
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


        // echo $data['grn_number']." ".$data['item_id']." ".$data['product_name']." ".$data['batch_name']." ".$data['color_name'];

        // echo "<br>";

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
#purchaseEdit {

    margin-left: 5px;
    margin-top: -120px;
    width: 340px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    padding: 4px 58px;
    height: 30px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    letter-spacing: 5px;
    font-weight: bolder;
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
    margin-top: -120px;
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

#grnAmount {
    margin-top: -100px;
    /* margin-left:1000px; */
    width: 150px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
}

#grnNumber,
#grnDate {
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
    <div class="" style="margin-left:1160px;border:1px solid black;width:340px;height:140px;margin-top:10px;">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                    role="tab">GRN</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                    role="tab">DC & Invoice</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <div style="display:flex;gap:10px;">
                    <input type="text" name="grnNumber" id="grnNumber" class="form-control"
                        placeholder="Press F2 For GRN Info"
                        style="height: 40px;font-size:12px;font-weight:bolder;padding-left:3px;background-color:blanchedalmond;"
                        autocomplete="off" maxlength="11" value="<?php echo isset($grnNumber) ? $grnNumber : ''; ?>">
                    <!-- <input type="text" name="grnNumber" id="grnNumber"  class="form-control" placeholder="Press F2 For GRN Info" style="height: 40px;font-size:12px;font-weight:bolder;padding-left:3px" autocomplete="off"  maxlength="11"> -->
                    <button type="submit" name="grnNumberSearchButton" id="grnSearchButton"
                        style="width:22px;height:25px;position:absolute;right:20px;top:130px;" hidden>S</button>
                    <div class="form-floating">
                        <input type="date" name="grnDate" id="grnDate" class="form-control" placeholder="GRN Date "
                            value="<?php echo $grnDate; ?>" maxlength="30">
                        <label for="GRNDate" style="margin-left:15px;margin-top:15px;">GRN Date</label>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <div style="display:flex;gap:10px">
                    <div class="form-floating">
                        <input type="text" name="dcNumber" id="dcNumber" class="form-control" placeholder="DC Number"
                            value="<?php echo $dcNumber; ?>" autocomplete="off" maxlength="20">
                        <label for="DCNumber" style="margin-top:-10px">DC Number</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" name="dcDate" id="dcDate" class="form-control" placeholder="DC Date"
                            value="<?php echo $dcDate; ?>" autocomplete="off" maxlength="20">
                        <label for="DCDate" style="margin-top:-10px">DC Date</label>
                    </div>
                </div>
                <div style="margin-top:5px;">
                </div>
                <div style="display:flex;gap:10px;">
                    <div class="form-floating">
                        <input type="text" name="invoiceNumber" id="invoiceNumber" class="form-control"
                            placeholder="Invoice Number" value="<?php echo $invoiceNumber; ?>" autocomplete="off"
                            maxlength="30">
                        <label for="invoiceNumber" style="margin-top:-10px">Invoice Number</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" name="invoiceDate" id="invoiceDate" class="form-control"
                            placeholder="Invoice Date" value="<?php echo $invoiceDate; ?>" autocomplete="off">
                        <label for="invoiceDate" style="margin-top:-10px;">Invoice Date</label>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div style="margin-top:-20px;margin-left:-12px">

        <div style="display:flex;gap:12px">
            <label for="" style="margin-left:280px;margin-top:-118px;">Supplier Name</label>
            <input type="text" name="supplierName" autocomplete="off" id="supplierName" class="form-control"
                placeholder="Press F2 For Supplier Info" value="<?php echo $supplierName; ?>">
            <input type="text" name="supplierId" id="supplierId" class="form-control" value="<?php echo $supplierId ?>">
            <label for="" id="purchaseEdit">PURCHASE EDIT</label>
        </div>
        <br>
        <div style="display:flex;gap:23px;">
            <label for="" style="margin-left:280px;margin-top:-98px">GRN Amount</label>
            <input type="text" name="grnAmount" id="grnAmount" class="form-control" autocomplete="off" maxlength="12"
                value="<?php echo $grnAmount; ?>">
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
            <label for="" style="margin-left:200px;">User Id</label>
            <input type="text" name="userId" readonly id="userId" class="form-control" value="<?php echo $userId; ?>"
                style="width:250px;">
            <label for="">Branch Id</label>
            <input type="text" name="userBranchId" readonly id="userBranchId" class="form-control"
                value="<?php echo $userBranchId; ?>" style="width:250px;">
            <label for="">Supplier Id</label>

        </div>


        <div style="margin-left:165px;font-size:12px;">
            <div style=" width:1235px;height:270px;overflow-y:auto;" id="itemTable">

                <table class="table text-white table-dark" style="border-collapse:collapse;width:100%;">
                    <thead>
                        <tr style="position:sticky;z-index:1;top:0;background-color:#FF3CAC">
                            <th style="padding-left:2px">S.No.</th>
                            <th style="padding-left:25px">Product</th>
                            <th style="padding-left:30px">Brand</th>
                            <th style="padding-left:25px">Design</th>
                            <th style="padding-left:15px">Color</th>
                            <th style="padding-left:20px">Batch</th>
                            <th style="padding-left:5px">Category</th>
                            <th style="padding-left:10px">HSN</th>
                            <th style="padding-left:0px">Tax</th>
                            <th style="padding-left:5px">Size</th>
                            <th style="padding-left:20px">Mrp</th>
                            <th style="padding-left:5px">Selling</th>
                            <th style="padding-left:5px">Rate</th>
                            <th style="padding-left:1px">Qty</th>
                            <th style="padding-left:2px">Amount</th>
                            <th>Id</th>
                            <th style="padding-left:2px">Action</th>
                        </tr>
                    </thead>
                    <tbody class="items" id="table_body">

                        <?php
                        if (isset($_SESSION['resultSearchPurchaseItem'])) {
                            $sno = 1;
                            $snos = 1;
                            foreach ($_SESSION['resultSearchPurchaseItem'] as $purchaseItemData) {

                                $_SESSION['snos'] = $snos++;


                        ?>

                        <tr>
                            <td>
                                <input type="text" class="serial-field" name="serialNumber[]" id="serialNumber_1"
                                    style="font-size:12px;height:25px;width:40px;margin-left:1px;background-color:#212529;color:white"
                                    maxlength="4" autocomplete="off" value="<?php echo $sno++; ?>" readonly />
                            </td>

                            <td>
                                <input type="text" class="product-field form" name="product[]"
                                    value="<?php echo $purchaseItemData['product_name']; ?>" id="product_1"
                                    autocomplete="off" style="font-size:12px;height:25px;width:100px;margin-left:-9px;    background-color: #FF3CAC;
                        background-image: linear-gradient(225deg, white 50%, blanchedalmond 50%);" maxlength="30" 
                        placeholder="Press F4 For Item Info"/>
                            </td>

                            <td>
                                <input type="text" class="brand-field" name="brand[]"
                                    value="<?php echo $purchaseItemData['brand_name']; ?>" id="brand_1"
                                    autocomplete="off"
                                    style="font-size:12px;height:25px;width:120px;margin-left:-2px;background-color:blanchedalmond;"
                                    maxlength="30" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="design[]"
                                    value="<?php echo $purchaseItemData['design_name']; ?>" id="design_1"
                                    autocomplete="off"
                                    style="font-size:13px;height:25px;width:140px;margin-left:0px;background-color:blanchedalmond;"
                                    maxlength="30" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="color[]"
                                    value="<?php echo $purchaseItemData['color_name']; ?>" id="color_1"
                                    autocomplete="off"
                                    style="font-size:13px;height:25px;width:80px;margin-left:0px;background-color:blanchedalmond;"
                                    maxlength="30" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="batch[]"
                                    value="<?php echo $purchaseItemData['batch_name']; ?>" id="batch_1"
                                    autocomplete="off"
                                    style="font-size:13px;height:25px;width:120px;margin-left:0px;background-color:blanchedalmond;"
                                    maxlength="30" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="category[]"
                                    value="<?php echo $purchaseItemData['category_name']; ?>" id="category_1"
                                    autocomplete="off"
                                    style="font-size:13px;height:25px;width:80px;margin-left:-2px;background-color:blanchedalmond;"
                                    maxlength="30" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="hsnCode[]"
                                    value="<?php echo $purchaseItemData['hsn_code']; ?>" id="hsnCode_1"
                                    autocomplete="off"
                                    style="font-size:13px;height:25px;width:65px;margin-left:-6px;background-color:blanchedalmond;"
                                    maxlength="8" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="tax[]"
                                    value="<?php echo $purchaseItemData['tax_code']; ?>" id="tax_1"
                                    style="font-size:13px;height:25px;width:40px;margin-left:0px;background-color:blanchedalmond;"
                                    maxlength="4" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="size[]"
                                    value="<?php echo $purchaseItemData['size_name']; ?>" id="size_1" autocomplete="off"
                                    style="font-size:13px;height:25px;width:50px;margin-left:0px;background-color:blanchedalmond;"
                                    maxlength="30" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="mrp[]"
                                    value="<?php echo $purchaseItemData['mrp']; ?>" id="mrp_1" autocomplete="off"
                                    style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:0px;background-color:blanchedalmond;"
                                    maxlength="12" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="sellingPrice[]"
                                    value="<?php echo $purchaseItemData['selling_price']; ?>" id="sellingPrice_1"
                                    autocomplete="off"
                                    style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:0px;"
                                    maxlength="12" />
                            </td>

                            <td>
                                <input type="text" class="rate-field" name="rate[]"
                                    value="<?php echo $purchaseItemData['rate']; ?>" id="rate_1" autocomplete="off"
                                    style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:-4px;"
                                    maxlength="12" />
                            </td>

                            <td>
                                <input type="text" class="qty-field" name="qty[]"
                                    value="<?php echo $purchaseItemData['item_qty']; ?>" id="qty_1" autocomplete="off"
                                    style="text-align:right;font-size:13px;height:25px;width:30px;margin-left:0px;"
                                    maxlength="5" oninput="calculateAmount()" />
                            </td>

                            <td>
                                <input type="text" class="amount-field" name="amount[]"
                                    value="<?php echo round($purchaseItemData['item_amount'], 2); ?>" id="amount_1"
                                    autocomplete="off" style="text-align:right;
                        height:25px;font-weight:bold;width:80px;
                        margin-left:-6px;background-color:#212529;
                        color:white;border:1px solid white;" maxlength="13" readonly />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="id[]"
                                    value="<?php echo $purchaseItemData['item_id']; ?>" id="id_1" readonly
                                    autocomplete="off"
                                    style="font-size:13px;height:25px;width:65px;margin-left:-4px;background-color:#212529;color:white;border:1px solid white;text-align:right;" />
                            </td>
                            <?php if ($sno > 2) { ?>
                            <td>
                                <button type="button" id="remove" class="btn btn-danger" title="Remove"
                                    style="font-size:8px;margin-left:1px;width:45px">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>


                            <?php } ?>
                        </tr>

                        <?php }
                        } ?>
                        <tr>
                            <td>
                                <button type="button" hidden id="remove" class="btn btn-danger" title="Remove"
                                    style="font-size:8px;margin-left:1px;width:45px">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <button style="margin-left:180px;width:120px;" type="submit" class="btn btn-primary" name="update_button"
            id="submitButton">
            Update
        </button>

    </div>

    <div style="margin-left:1228px;margin-top:-45px">
        <div style="display:flex;gap:5px">
            <label for="" style="margin-left:-2px">Total</label>
            <input type="text" name="totalQty" id="totalQty" class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:50px;" maxlength="4"
                value="<?php echo $totalQty; ?>">
            <input type="text" name="totalAmount" id="totalAmount" class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12"
                value="<?php echo $totalAmount; ?>">
        </div>
        <div style="display:flex;margin-top:2px;">
            <label for="">CGST</label>
            <input type="text" name="cgstAmount" id="cgstAmount" autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:48px" maxlength="12"
                value="<?php echo $cgstAmount; ?>">
        </div>
        <div style="display:flex;margin-top:2px;">
            <label for="">SGST</label>
            <input type="text" name="sgstAmount" id="sgstAmount" autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:49px" maxlength="12"
                value="<?php echo $sgstAmount; ?>">
        </div>
        <div style="display:flex;margin-top:2px;">
            <label for="">IGST</label>
            <input type="text" name="igstAmount" id="igstAmount" autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:54px" maxlength="12"
                value="<?php echo $igstAmount; ?>">
        </div>

        <div style="display:flex;margin-top:2px;">
            <label for="">Add On</label>
            <input type="text" name="addOnAmount" id="addOnAmount" autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:32px" maxlength="12"
                value="<?php echo $addOnAmount; ?>">
        </div>

        <div style="display:flex;margin-top:3px;">
            <label for="">Deduction</label>
            <input type="text" name="deductionAmount" id="deductionAmount" autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:13px" maxlength="12"
                value="<?php echo $deductionAmount; ?>">
        </div>

        <div style="display:flex;margin-top:2px;">
            <label for="">Net</label>
            <input type="text" name="netAmount" id="netAmount" class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:61px" maxlength="12"
                value="<?php echo $netAmount; ?>">
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

document.getElementById("grnNumber").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "F2") {
        event.preventDefault();
        let grnNumber = new FormData();
        grnNumber.append("lb_grn_number", target.value);
        let aj_grn = new XMLHttpRequest();
        aj_grn.open("POST", "ajaxPurchaseGRN.php", true);
        aj_grn.send(grnNumber);
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

//     function fetchPurchaseItems(grnNumber) {
//     let ajax = new XMLHttpRequest();
//     ajax.open("POST", "fetchPurchaseItems.php", true);
//     ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//     ajax.send("grn_number=" + grnNumber);
//     ajax.onreadystatechange = function () {
//         if (ajax.status === 200 && ajax.readyState === 4) {
//             let items = JSON.parse(ajax.responseText); // Parse the JSON response
//             populateItemGrid(items); // Populate the itemGrid with the fetched items
//         }
//     };
// }
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

                // Set focus on the first row of the pop-up table
                // setTimeout(() => {
                //     document.getElementById("supplierNameField_1").focus();
                //     document.getElementById("supplierNameField_1").select();
                // }, 10);

            }
        }


    }
    // }else if(event.altKey && event.key.toLowerCase() === "c"){
    //     event.preventDefault();
    //     let supplier_form = new FormData();
    //     supplier_form.append("supplier_form","supplier_create");
    //     let aj_supplier = new XMLHttpRequest();
    //     aj_supplier.open("POST","ajaxSupplierForm.php",true);
    //     aj_supplier.send(supplier_form);
    //     aj_supplier.onreadystatechange = function(){
    //         if(aj_supplier.status === 200 && aj_supplier.readyState === 4){
    //                 document.getElementById("response_message_supplier_form").innerHTML = aj_supplier.responseText;
    //         }
    //     }
    // }
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
        // console.log('row qty = ',eachRowQty)
        eachRowAmount = document.getElementById("amount_" + i).value || 0;
        totalQty = parseInt(totalQty) + parseInt(eachRowQty);

        totalAmount = parseFloat(totalAmount) + parseFloat(eachRowAmount);
    }
    document.getElementById("totalQty").value = totalQty;
    document.getElementById("totalAmount").value = parseFloat(totalAmount).toFixed(2);
}


function calculateNetAmount() {

    let totalAmount = document.getElementById('totalAmount').value || 0;
    let cgstAmount = document.getElementById('cgstAmount').value || 0;
    let sgstAmount = document.getElementById("sgstAmount").value || 0;
    let igstAmount = document.getElementById("igstAmount").value || 0;
    let addOn = document.getElementById("addOnAmount").value || 0;
    let deduction = document.getElementById("deductionAmount").value || 0;
    let netAmount = parseFloat(totalAmount) + parseFloat(cgstAmount) + parseFloat(sgstAmount) + parseFloat(igstAmount) +
        parseFloat(addOn) - parseFloat(deduction);
    document.getElementById("netAmount").value = parseFloat(netAmount).toFixed(2);
}
document.getElementById("cgstAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("sgstAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("igstAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("addOnAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("deductionAmount").addEventListener("focusout", calculateNetAmount);




let totalAmount = 0;

document.getElementById("table_body").addEventListener("focusout", function(event) {
    const target = event.target;

    if (target.name === "rate[]") {
        const currentRow = target.closest('tr');
        const rate = currentRow.querySelector('input[name="rate[]"]').value || 0;
        const qty = currentRow.querySelector('input[name="qty[]"]').value || 0;
        let amount = currentRow.querySelector('input[name="amount[]"]');
        amount.value = (rate * qty).toFixed(2);

        calculateTotalAmount();
        calculateNetAmount();
        validateAmounts();
        // let cgstAmount = document.getElementById('cgstAmount').value||0;
        // let sgstAmount = document.getElementById("sgstAmount").value||0;
        // let igstAmount = document.getElementById("igstAmount").value||0;
        // let addOn = document.getElementById("addOnAmount").value||0;
        // let deduction = document.getElementById("deductionAmount").value||0;

        // let netAmount = parseInt(totalAmount)+parseInt(cgstAmount)+parseInt(sgstAmount)+parseInt(igstAmount)+parseInt(addOn)-parseInt(deduction);


        // document.getElementById("netAmount").value = netAmount;

    } else if (target.name === "qty[]") {
        const currentRow = target.closest('tr');
        const rate = currentRow.querySelector('input[name="rate[]"]').value || 0;
        const qty = currentRow.querySelector('input[name="qty[]"]').value || 0;
        let amount = currentRow.querySelector('input[name="amount[]"]');
        amount.value = (rate * qty).toFixed(2);
        calculateTotalAmount();
        calculateNetAmount();
        validateAmounts();
        // let cgstAmount = document.getElementById('cgstAmount').value||0;
        // let sgstAmount = document.getElementById("sgstAmount").value||0;
        // let igstAmount = document.getElementById("igstAmount").value||0;
        // let addOn = document.getElementById("addOnAmount").value||0;
        // let deduction = document.getElementById("deductionAmount").value||0;

        // let netAmount = parseInt(totalAmount)+parseInt(cgstAmount)+parseInt(sgstAmount)+parseInt(igstAmount)+parseInt(addOn)-parseInt(deduction);


        // document.getElementById("netAmount").value = netAmount;
    }


})


// document.getElementById("table_body").addEventListener("focusout", function(event){
//         let target = event.target;
//     if(target.name === "product[]"){
//         event.preventDefault();
//         let product_name = new FormData();
//         product_name.append("al_product", target.value);
//         let aj = new XMLHttpRequest();
//         aj.open("POST", "itemStoring.php", true);
//         aj.send(product_name);
//         aj.onreadystatechange = function(){
//             if(aj.status === 200 && aj.readyState === 4){

//                     document.getElementById("response_message").innerHTML = aj.responseText;
//                     gettingRowItemDetails(target);
//             }

//         }

//     }else if(target.name === "brand[]"){
//         event.preventDefault();
//         let brand_name = new FormData();
//         brand_name.append("al_brand", target.value);
//         let aj = new XMLHttpRequest();
//         aj.open("POST", "itemStoring.php", true);
//         aj.send(brand_name);
//         aj.onreadystatechange = function(){
//             if(aj.status === 200 && aj.readyState === 4){

//                     document.getElementById("response_message").innerHTML = aj.responseText;
//                     gettingRowItemDetails(target);
//             }

//         }

//     }else if(target.name === "design[]"){
//         event.preventDefault();
//         let design_name = new FormData();
//         design_name.append("al_design", target.value);
//         let aj = new XMLHttpRequest();
//         aj.open("POST", "itemStoring.php", true);
//         aj.send(design_name);
//         aj.onreadystatechange = function(){
//             if(aj.status === 200 && aj.readyState === 4){

//                     document.getElementById("response_message").innerHTML = aj.responseText;
//                     gettingRowItemDetails(target);
//             }

//         }

//     }else if(target.name === "color[]"){
//         event.preventDefault();
//         let color_name = new FormData();
//         color_name.append("al_color", target.value);
//         let aj = new XMLHttpRequest();
//         aj.open("POST", "itemStoring.php", true);
//         aj.send(color_name);
//         aj.onreadystatechange = function(){
//             if(aj.status === 200 && aj.readyState === 4){

//                     document.getElementById("response_message").innerHTML = aj.responseText;
//                     gettingRowItemDetails(target);
//             }

//         }

//     }else if(target.name === "batch[]"){
//         event.preventDefault();
//         let batch_name = new FormData();
//         batch_name.append("al_batch", target.value);
//         let aj = new XMLHttpRequest();
//         aj.open("POST", "itemStoring.php", true);
//         aj.send(batch_name);
//         aj.onreadystatechange = function(){
//             if(aj.status === 200 && aj.readyState === 4){

//                     document.getElementById("response_message").innerHTML = aj.responseText;
//                     gettingRowItemDetails(target);
//             }

//         }

//     }else if(target.name === "category[]"){
//         event.preventDefault();
//         let category_name = new FormData();
//         category_name.append("al_category", target.value);
//         let aj = new XMLHttpRequest();
//         aj.open("POST", "itemStoring.php", true);
//         aj.send(category_name);
//         aj.onreadystatechange = function(){
//             if(aj.status === 200 && aj.readyState === 4){

//                     document.getElementById("response_message").innerHTML = aj.responseText;
//                     gettingRowItemDetails(target);
//             }

//         }

//     }else if(target.name === "hsnCode[]"){
//         event.preventDefault();
//         let hsn_code = new FormData();
//         hsn_code.append("al_hsnCode", target.value);
//         let aj = new XMLHttpRequest();
//         aj.open("POST", "itemStoring.php", true);
//         aj.send(hsn_code);
//         aj.onreadystatechange = function(){
//             if(aj.status === 200 && aj.readyState === 4){

//                     document.getElementById("response_message").innerHTML = aj.responseText;
//                     gettingRowItemDetails(target);
//             }

//         }

//     }else if(target.name === "tax[]"){
//         event.preventDefault();
//         let tax_code = new FormData();
//         tax_code.append("al_tax", target.value);
//         let aj = new XMLHttpRequest();
//         aj.open("POST", "itemStoring.php", true);
//         aj.send(tax_code);
//         aj.onreadystatechange = function(){
//             if(aj.status === 200 && aj.readyState === 4){

//                     document.getElementById("response_message").innerHTML = aj.responseText;
//                     gettingRowItemDetails(target);
//             }

//         }

//     }else if(target.name === "size[]"){
//         event.preventDefault();
//         let size_name = new FormData();
//         size_name.append("al_size", target.value);
//         let aj = new XMLHttpRequest();
//         aj.open("POST", "itemStoring.php", true);
//         aj.send(size_name);
//         aj.onreadystatechange = function(){
//             if(aj.status === 200 && aj.readyState === 4){

//                     document.getElementById("response_message").innerHTML = aj.responseText;
//                     gettingRowItemDetails(target);
//             }

//         }

//     }else if(target.name === "mrp[]"){
//         event.preventDefault();
//         let mrp = new FormData();
//         mrp.append("al_mrp", target.value);
//         let aj = new XMLHttpRequest();
//         aj.open("POST", "itemStoring.php", true);
//         aj.send(mrp);
//         aj.onreadystatechange = function(){
//             if(aj.status === 200 && aj.readyState === 4){

//                     document.getElementById("response_message").innerHTML = aj.responseText;
//                     gettingRowItemDetails(target);
//             }

//         }

//     }
// })






document.getElementById("table_body").addEventListener("keydown", function(event) {
    const target = event.target;

    // Handle the Enter key event
    if (event.key === "Enter") {
        event.preventDefault(); // Prevent the default Enter key behavior

        // Navigate based on the input field's name
        if (target.name === "product[]") {


            let product_data = new FormData();
            product_data.append("al_product", target.value)
            let aj = new XMLHttpRequest();
            aj.open("POST", "itemStoring.php", true);
            aj.send(product_data);
            aj.onreadystatechange = function() {
                if (aj.status === 200 && aj.readyState === 4) {
                    document.getElementById('response_message').innerHTML = aj.responseText;

                    gettingRowItemDetails(target);
                    const currentRow = target.closest("tr");
                    const brandField = currentRow.querySelector('input[name="brand[]"]');
                    if (brandField) {
                        brandField.focus();
                        brandField.select();
                    }
                }

            }


        } else if (target.name === "brand[]") {


            let brand_data = new FormData();
            brand_data.append("al_brand", target.value)
            let aj_brand = new XMLHttpRequest();
            aj_brand.open("POST", "itemStoring.php", true);
            aj_brand.send(brand_data);
            aj_brand.onreadystatechange = function() {
                if (aj_brand.status === 200 && aj_brand.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj_brand.responseText;
                    gettingRowItemDetails(target);
                    const currentRow = target.closest("tr");
                    const designField = currentRow.querySelector('input[name="design[]"]');
                    if (designField) {
                        designField.focus();
                        designField.select();
                    }
                }
            }


        } else if (target.name == "design[]") {



            let design_data = new FormData();
            design_data.append("al_design", target.value)
            let aj_design = new XMLHttpRequest();
            aj_design.open("POST", "itemStoring.php", true);
            aj_design.send(design_data);
            aj_design.onreadystatechange = function() {
                if (aj_design.status === 200 && aj_design.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj_design.responseText;
                    gettingRowItemDetails(target);
                    const currentRow = target.closest("tr");
                    const colorField = currentRow.querySelector('input[name="color[]"]');
                    if (colorField) {
                        colorField.focus();
                        colorField.select();
                    }
                }
            }




        } else if (target.name == "color[]") {



            let color_data = new FormData();
            color_data.append("al_color", target.value)
            let aj_color = new XMLHttpRequest();
            aj_color.open("POST", "itemStoring.php", true);
            aj_color.send(color_data);
            aj_color.onreadystatechange = function() {
                if (aj_color.status === 200 && aj_color.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj_color.responseText;
                    gettingRowItemDetails(target);
                    const currentRow = target.closest("tr");
                    const batchField = currentRow.querySelector('input[name="batch[]"]');
                    if (batchField) {
                        batchField.focus();
                        batchField.select();
                    }
                }
            }




        } else if (target.name == "batch[]") {



            let batch_data = new FormData();
            batch_data.append("al_batch", target.value)
            let aj_batch = new XMLHttpRequest();
            aj_batch.open("POST", "itemStoring.php", true);
            aj_batch.send(batch_data);
            aj_batch.onreadystatechange = function() {
                if (aj_batch.status === 200 && aj_batch.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj_batch.responseText;
                    gettingRowItemDetails(target);
                    const currentRow = target.closest("tr");
                    const categoryField = currentRow.querySelector('input[name="category[]"]');
                    if (categoryField) {
                        categoryField.focus();
                        categoryField.select();
                    }
                }
            }




        } else if (target.name == "category[]") {



            let category_data = new FormData();
            category_data.append("al_category", target.value)
            let aj_category = new XMLHttpRequest();
            aj_category.open("POST", "itemStoring.php", true);
            aj_category.send(category_data);
            aj_category.onreadystatechange = function() {
                if (aj_category.status === 200 && aj_category.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj_category.responseText;
                    gettingRowItemDetails(target);
                    const currentRow = target.closest("tr");
                    const hsnCodeField = currentRow.querySelector('input[name="hsnCode[]"]');
                    if (hsnCodeField) {
                        hsnCodeField.focus();
                        hsnCodeField.select();
                    }
                }
            }




        } else if (target.name == "hsnCode[]") {



            let hsnCode_data = new FormData();
            hsnCode_data.append("al_hsnCode", target.value)
            let aj_hsnCode = new XMLHttpRequest();
            aj_hsnCode.open("POST", "itemStoring.php", true);
            aj_hsnCode.send(hsnCode_data);
            aj_hsnCode.onreadystatechange = function() {
                if (aj_hsnCode.status === 200 && aj_hsnCode.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj_hsnCode.responseText;
                    gettingRowItemDetails(target);
                    const currentRow = target.closest("tr");
                    const taxField = currentRow.querySelector('input[name="tax[]"]');
                    if (taxField) {
                        taxField.focus();
                        taxField.select();
                        // taxField.click();
                    }
                }
            }




        } else if (target.name == "tax[]") {



            let tax_data = new FormData();
            tax_data.append("al_tax", target.value)
            let aj_tax = new XMLHttpRequest();
            aj_tax.open("POST", "itemStoring.php", true);
            aj_tax.send(tax_data);
            aj_tax.onreadystatechange = function() {
                if (aj_tax.status === 200 && aj_tax.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj_tax.responseText;
                    gettingRowItemDetails(target);
                    const currentRow = target.closest("tr");
                    const sizeField = currentRow.querySelector('input[name="size[]"]');
                    if (sizeField) {
                        sizeField.focus();
                        sizeField.select();
                    }
                }
            }




        } else if (target.name == "size[]") {



            let size_data = new FormData();
            size_data.append("al_size", target.value)
            let aj_size = new XMLHttpRequest();
            aj_size.open("POST", "itemStoring.php", true);
            aj_size.send(size_data);
            aj_size.onreadystatechange = function() {
                if (aj_size.status === 200 && aj_size.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj_size.responseText;
                    gettingRowItemDetails(target);
                    const currentRow = target.closest("tr");
                    const mrpField = currentRow.querySelector('input[name="mrp[]"]');
                    if (mrpField) {
                        mrpField.focus();
                        mrpField.select();
                    }
                }
            }




        } else if (target.name == "mrp[]") {



            let mrp_data = new FormData();
            mrp_data.append("al_mrp", target.value)
            let aj_mrp = new XMLHttpRequest();
            aj_mrp.open("POST", "itemStoring.php", true);
            aj_mrp.send(mrp_data);
            aj_mrp.onreadystatechange = function() {
                if (aj_mrp.status === 200 && aj_mrp.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj_mrp.responseText;
                    gettingRowItemDetails(target);
                    const currentRow = target.closest("tr");
                    const sellingPriceField = currentRow.querySelector('input[name="sellingPrice[]"]');
                    if (sellingPriceField) {
                        sellingPriceField.focus();
                        sellingPriceField.select();
                    }
                }
            }




        } else if (target.name == "sellingPrice[]") {

            gettingRowItemDetails(target);
            const currentRow = target.closest("tr");
            const rateField = currentRow.querySelector('input[name="rate[]"]');




            if (rateField) {
                rateField.focus();
                rateField.select();
            }


        } else if (target.name == "rate[]") {


            gettingRowItemDetails(target);
            const currentRow = target.closest('tr');
            const qtyField = currentRow.querySelector('input[name="qty[]"]');




            if (qtyField) {
                qtyField.focus();
                qtyField.select();

            }


        } else if (target.name === "qty[]") {
            // Check if it's the last row
            const currentRow = target.closest("tr");
            const isLastRow = currentRow.isSameNode(document.querySelector("#table_body tr:last-child"));

            if (isLastRow) {
                // Add a new row if it's the last one
                add_row();


                // Focus on the product field of the newly added row
                const nextRow = currentRow.nextElementSibling;
                if (nextRow) {
                    const productField = nextRow.querySelector('input[name="product[]"]');
                    if (productField) {
                        validateAmounts();
                        productField.focus();
                        productField.select();
                        // let incrementBatchValue = '<?php echo htmlspecialchars($d); ?>'

                        // alert(incrementBatchValue)
                    }
                }

            } else {
                // Move to the product field in the next row
                const nextRow = currentRow.nextElementSibling;
                if (nextRow) {
                    const productField = nextRow.querySelector('input[name="product[]"]');
                    if (productField) {
                        productField.focus();
                        productField.select();
                    }
                }
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

    let triggerItemCreation = new FormData();
    triggerItemCreation.append("lb_trigger_item_updation", JSON.stringify(items));
    let ajTriggerItemCreation = new XMLHttpRequest();
    ajTriggerItemCreation.open("POST", "fnItemIdEdit.php", true);
    ajTriggerItemCreation.send(triggerItemCreation);


    ajTriggerItemCreation.onreadystatechange = function() {
        if (ajTriggerItemCreation.status === 200 && ajTriggerItemCreation.readyState === 4) {
            // id.value = ajTriggerItemCreation.responseText;
            id.value = ajTriggerItemCreation.responseText;
        }
    }

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
        event.preventDefault();
        const fieldName = target.name.replace("[]", "");
        const value = target.value;
        const currentBranchId = document.getElementById("userBranchId").value;
        let query = "";

        if (fieldName === "batch") {
            query =
                `select * from ${fieldName}es where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}' order by batch_name`;
        } else if (fieldName === "category") {
            query =
                `select * from categories where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}' order by category_name`;
        } else if (fieldName === "hsnCode") {
            query =
                `select * from hsn_codes where hsn_code like '${value}%' && branch_id = '${currentBranchId}' order by hsn_code`;
        } else if (fieldName === "tax") {
            query =
                `select * from taxes where tax_code like '${value}%' && branch_id = '${currentBranchId}' order by tax_code`;
        } else if (fieldName === "mrp") {
            query =
                `select * from mrps where mrp like '${value}%' && branch_id = '${currentBranchId}' order by mrp`;
        } else {
            query =
                `select * from ${fieldName}s where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}' order by ${fieldName}_name`;
        }

        const data = new FormData();
        data.append(`lb_qry_${fieldName}`, query);
        const row_index_f2 = localStorage.getItem("row_index");
        data.append("lb_f2_row_index", row_index_f2);

        const ajaxRequest = new XMLHttpRequest();
        ajaxRequest.open("POST", "itemStoring.php", true);
        ajaxRequest.send(data);
        ajaxRequest.onreadystatechange = function() {
            if (ajaxRequest.status === 200 && ajaxRequest.readyState === 4) {
                document.getElementById("response_message").innerHTML = ajaxRequest.responseText;
            }
        };
    } else if (target.name === "product[]" && event.key === "F4") {
        event.preventDefault();
        let fieldName = target.name.replace("[]", "");
        let value = target.value;
        let currentBranchId = document.getElementById("userBranchId").value;

        let get_item = new FormData();
        get_item.append("get_item_f4", value);
        let aj = new XMLHttpRequest();
        aj.open("POST", "itemStoring.php", true);
        aj.send(get_item);
        aj.onreadystatechange = function() {

            if (aj.status === 200 && aj.readyState === 4) {
                document.getElementById("response_message").innerHTML = aj.responseText;
            }
        }


    }
});




$(document).on("keypress", ".design-field", function(e) {


    if (e.key === "Enter") {
        e.preventDefault();
        let currentRow = $(this).closest("tr");
        // Check if it's the last row
        let isLastRow = currentRow.is(":last-child");
        if (isLastRow) {
            // Add a new row
            add_row();
            // Focus on the product field of the newly added row
            currentRow.next("tr").find('input[name="product[]"]').focus();
        } else {
            // Move focus to the product field in the next row
            currentRow.next("tr").find('input[name="product[]"]').focus();
        }
    }
});


//     function populateItemGrid(items) {
//     let tableBody = document.getElementById("table_body");
//     tableBody.innerHTML = ""; // Clear existing rows

//     items.forEach((item, index) => {
//         let row = document.createElement("tr");
//         row.innerHTML = `
//             <td>
//                 <input type="text" class="serial-field" name="serialNumber[]" value="${index + 1}" readonly />
//             </td>
//             <td>
//                 <input type="text" class="product-field" name="product[]" value="${item.product_name}" />
//             </td>
//             <td>
//                 <input type="text" class="brand-field" name="brand[]" value="${item.brand_name}" />
//             </td>
//             <td>
//                 <input type="text" class="design-field" name="design[]" value="${item.design_name}" />
//             </td>
//             <td>
//                 <input type="text" class="batch-field" name="batch[]" value="${item.batch_name}" />
//             </td>
//             <td>
//                 <input type="text" class="color-field" name="color[]" value="${item.color_name}" />
//             </td>
//             <td>
//                 <input type="text" class="category-field" name="category[]" value="${item.category_name}" />
//             </td>
//             <td>
//                 <input type="text" class="hsnCode-field" name="hsnCode[]" value="${item.hsn_code}" />
//             </td>
//             <td>
//                 <input type="text" class="tax-field" name="tax[]" value="${item.tax_code}" />
//             </td>
//             <td>
//                 <input type="text" class="size-field" name="size[]" value="${item.size_name}" />
//             </td>
//             <td>
//                 <input type="text" class="mrp-field" name="mrp[]" value="${item.mrp}" />
//             </td>
//             <td>
//                 <input type="text" class="sellingPrice-field" name="sellingPrice[]" value="${item.selling_price}" />
//             </td>
//             <td>
//                 <input type="text" class="rate-field" name="rate[]" value="${item.rate}" />
//             </td>
//             <td>
//                 <input type="text" class="qty-field" name="qty[]" value="${item.item_amount}" />
//             </td>
//             <td>
//                 <input type="text" class="amount-field" name="amount[]" value="${item.item_amount}" readonly />
//             </td>
//             <td>
//                 <input type="text" class="id-field" name="id[]" value="${item.item_id}" readonly />
//             </td>
//         `;
//         tableBody.appendChild(row);
//     });

//     // Update the total rows count in localStorage
//     localStorage.setItem("total_rows", items.length);
// }


// Function to add a new row
/// Counter to track the row index
// let rowCounter = 1;

// // Function to add a new row
// function add_row() {
//     // Create new row
//     const newRow = document.createElement('tr');
//     newRow.innerHTML = `
//         <td>
//             <input type="text" class="serial-field" name="serialNumber[]" id="serialNumber_${rowCounter}" style="font-size:12px;height:25px;width:40px;margin-left:1px;background-color:#212529;color:white;" maxlength="4" autocomplete="off" readonly/>
//         </td>
//         <td>
//             <input type="text" class="product-field" name="product[]" id="product_${rowCounter}" autocomplete="off" style="font-size:12px;height:25px;width:100px;margin-left:-9px;" maxlength="30" />
//         </td>
//         <td>
//             <input type="text" class="brand-field" name="brand[]" id="brand_${rowCounter}" autocomplete="off" style="font-size:12px;height:25px;width:120px;margin-left:-2px;" maxlength="30" />
//         </td>
//         <td>
//             <input type="text" class="design-field" name="design[]" id="design_${rowCounter}" autocomplete="off" style="font-size:13px;height:25px;width:140px;margin-left:0px;" maxlength="30" />
//         </td>
//         <td>
//             <input type="text" class="design-field" name="batch[]" id="batch_${rowCounter}" value="" autocomplete="off" style="font-size:13px;height:25px;width:120px;margin-left:0px;" maxlength="30" />
//         </td>
//         <td>
//             <input type="text" class="design-field" name="color[]" id="color_${rowCounter}" autocomplete="off" style="font-size:13px;height:25px;width:80px;margin-left:0px;" maxlength="30" />
//         </td>
//         <td>
//             <input type="text" class="design-field" name="category[]" id="category_${rowCounter}" autocomplete="off" style="font-size:13px;height:25px;width:80px;margin-left:-2px;" maxlength="30" />
//         </td>
//         <td>
//             <input type="text" class="design-field" name="hsnCode[]" id="hsnCode_${rowCounter}" autocomplete="off" style="font-size:13px;height:25px;width:65px;margin-left:-6px;" maxlength="8" />
//         </td>
//         <td>
//             <input type="text" class="design-field" name="tax[]" id="tax_${rowCounter}" style="font-size:13px;height:25px;width:40px;margin-left:0px;" maxlength="4" />
//         </td>
//         <td>
//             <input type="text" class="design-field" name="size[]" id="size_${rowCounter}" autocomplete="off" style="font-size:13px;height:25px;width:50px;margin-left:0px;" maxlength="30" />
//         </td>
//         <td>
//             <input type="text" class="design-field" name="mrp[]" id="mrp_${rowCounter}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:0px;" maxlength="12" />
//         </td>
//         <td>
//             <input type="text" class="design-field" name="sellingPrice[]" id="sellingPrice_${rowCounter}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:0px;" maxlength="12" />
//         </td>
//         <td>
//             <input type="text" class="design-field" name="rate[]" id="rate_${rowCounter}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:-4px;" maxlength="12" />
//         </td>
//         <td>
//             <input type="text" class="qty-field" name="qty[]" id="qty_${rowCounter}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:30px;margin-left:0px;" maxlength="5" />
//         </td>
//         <td>
//             <input type="text" class="design-field" name="amount[]" id="amount_${rowCounter}" autocomplete="off" style="text-align:right;height:25px;font-weight:bold;width:80px; margin-left:-6px;background-color:#212529;color:white;border:1px solid white;" maxlength="13" readonly />
//         </td>
//         <td>
//             <input type="text" class="design-field" name="id[]" id="id_${rowCounter}"  autocomplete="off" style="font-size:13px;height:25px;width:65px;margin-left:-4px;background-color:#212529;color:white;border:1px solid white;text-align:right;" />
//         </td>
//         <td>
//             <button type="button" id="remove" class="btn btn-danger" title="Remove" style="font-size:8px;margin-left:1px;width:45px">
//                 <i class="fa fa-trash"></i>
//             </button>
//         </td>
//     `;

//     // Append the new row to the table body
//     document.querySelector('#table_body').appendChild(newRow);

//     // Set the serial number for the new row
//     newRow.querySelector(`#serialNumber_${rowCounter}`).value = rowCounter;

//     // Increment the row counter
//     rowCounter++;

//     // Debugging: Log the current row counter
//     console.log("New row added. Current row counter:", rowCounter);

//     // Add event listener to the qty field of the new row
//     const qtyField = newRow.querySelector('.qty-field');
//     qtyField.addEventListener('focus', handleQtyFocus, { once: true }); // Ensure the listener is added only once
// }

// // Function to handle qty field focus
// function handleQtyFocus(event) {
//     event.stopPropagation(); // Prevent the event from bubbling up
//     console.log("Qty field focused. Row index:", rowCounter - 1); // Log the current row index
// }

// // Event listener for removing a row
// document.getElementById('table_body').addEventListener('click', function (e) {
//     if (e.target && e.target.id === 'remove') {
//         const removedRow = e.target.closest('tr');
//         removedRow.remove();

//         // Re-index the remaining rows
//         reindexRows();

//         // Debugging: Log the current row counter
//         console.log("Row removed. Re-indexing rows. Current row counter:", rowCounter);
//     }
// });

// // Function to re-index rows after deletion
// function reindexRows() {
//     const rows = document.querySelectorAll('#table_body tr');
//     rows.forEach((row, index) => {
//         const rowNumber = index + 1;
//         row.querySelector('.serial-field').value = rowNumber; // Update serial number
//         row.querySelectorAll('input').forEach(input => {
//             const name = input.name.replace(/\d+/, rowNumber);
//             const id = input.id.replace(/\d+/, rowNumber);
//             input.name = name;
//             input.id = id;
//         });
//     });

//     // Update the row counter to match the number of rows
//     rowCounter = rows.length + 1;
// }


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
            <input type="text" class="serial-field" name="serialNumber[]" id="serialNumber_${i}"    style="font-size:12px;height:25px;width:40px;margin-left:1px;background-color:#212529;color:white;" maxlength="4" autocomplete="off" readonly/>
        </td>
        <td>
            <input type="text" class="product-field" name="product[]" id="product_${i}" autocomplete="off" style="font-size:12px;height:25px;width:100px;margin-left:-9px;
             background-image: linear-gradient(225deg, white 50%, blanchedalmond 50%);" maxlength="30"
             placeholder="Press F4 For Item Info"/>
        </td>
        <td>
            <input type="text" class="brand-field" name="brand[]" id="brand_${i}" autocomplete="off" 
            style="font-size:12px;height:25px;width:120px;margin-left:-2px;background-color:blanchedalmond;" maxlength="30" />
        </td>
        <td>
            <input type="text" class="design-field" name="design[]" id="design_${i}" autocomplete="off"
            style="font-size:13px;height:25px;width:140px;margin-left:0px;background-color:blanchedalmond;" maxlength="30" />
        </td>
        <td>
            <input type="text" class="design-field" name="color[]" id="color_${i}" autocomplete="off" 
            style="font-size:13px;height:25px;width:80px;margin-left:0px;background-color:blanchedalmond;" maxlength="30" />
        </td>
        <td>
            <input type="text" class="design-field" name="batch[]" id="batch_${i}" value="" autocomplete="off" 
            style="font-size:13px;height:25px;width:120px;margin-left:0px;background-color:blanchedalmond;" maxlength="30" />
        </td>
        
        <td>
            <input type="text" class="design-field" name="category[]" id="category_${i}" autocomplete="off" 
            style="font-size:13px;height:25px;width:80px;margin-left:-2px;background-color:blanchedalmond;" maxlength="30" />
        </td>
        <td>
            <input type="text" class="design-field" name="hsnCode[]" id="hsnCode_${i}" autocomplete="off" 
            style="font-size:13px;height:25px;width:65px;margin-left:-6px;background-color:blanchedalmond;" maxlength="8" />
        </td>
        <td>
            <input type="text" class="design-field" name="tax[]" id="tax_${i}" 
            style="font-size:13px;height:25px;width:40px;margin-left:0px;background-color:blanchedalmond;" maxlength="4" />
        </td>
        <td>
            <input type="text" class="design-field" name="size[]" id="size_${i}" autocomplete="off" 
            style="font-size:13px;height:25px;width:50px;margin-left:0px;background-color:blanchedalmond;" maxlength="30" />
        </td>
        <td>
            <input type="text" class="design-field" name="mrp[]" id="mrp_${i}" autocomplete="off" 
            style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:0px;background-color:blanchedalmond;" maxlength="12" />
        </td>
        <td>
            <input type="text" class="design-field" name="sellingPrice[]" id="sellingPrice_${i}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:0px;" maxlength="12" />
        </td>
        <td>
            <input type="text" class="design-field" name="rate[]" id="rate_${i}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:-4px;" maxlength="12" />
        </td>
        <td>
            <input type="text" class="design-field" name="qty[]" id="qty_${i}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:30px;margin-left:0px;" maxlength="5" />
        </td>
        <td>
            <input type="text" class="design-field" name="amount[]" id="amount_${i}" autocomplete="off" style="text-align:right;height:25px;font-weight:bold;width:80px; margin-left:-6px;background-color:#212529;color:white;border:1px solid white;" maxlength="13" readonly />
        </td>
        <td>
            <input type="text" class="design-field" name="id[]" id="id_${i}"  autocomplete="off" style="font-size:13px;height:25px;width:65px;margin-left:-4px;background-color:#212529;color:white;border:1px solid white;text-align:right;" />
        </td>
        <td>
            <button type="button" id="remove" class="btn btn-danger" title="Remove" style="font-size:8px;margin-left:1px;width:45px">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    `;

    // Copy values from the last row
    //     document.addEventListener("keydown", function (event) {
    //     if (event.key === "Enter") {
    //         event.preventDefault(); // Prevent default Enter behavior

    //         let activeElement = document.activeElement; // Get the currently focused input field

    //         if (activeElement) {
    //             let fieldName = activeElement.name; // Get the field name
    //             let currentRow = activeElement.closest("tr"); // Get the current row
    //             let previousRow = currentRow?.previousElementSibling; // Get the previous row

    //             if (fieldName === "qty[]") {
    //                 // If Enter is pressed in qty field, generate a new row
    //                 add_row();
    //             } else if (previousRow) {
    //                 // Get the value from the same field in the previous row
    //                 let prevInput = previousRow.querySelector(`[name="${fieldName}"]`);
    //                 let prevValue = prevInput ? prevInput.value : "";

    //                 if (prevValue !== undefined) {
    //                     activeElement.value = prevValue; // Set the previous value
    //                 }

    //                 // Move focus to the next input field in the same row (one by one)
    //                 let inputs = Array.from(currentRow.querySelectorAll("input"));
    //                 let index = inputs.indexOf(activeElement);
    //                 if (index !== -1 && index < inputs.length - 1) {
    //                     inputs[index + 1].focus(); // Move focus to next field in the same row
    //                 }
    //             }
    //         }
    //     }
    // });



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
                        activeElement.value = prevValue; // Set the previous value
                    }
                }
            }
        }
    });

    document.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent default Enter behavior

            let activeElement = document.activeElement; // Get the currently focused input field

            if (activeElement) {
                let fieldName = activeElement.name; // Get the field name
                let currentRow = activeElement.closest("tr"); // Get the current row

                if (fieldName === "qty[]") {
                    // If Enter is pressed in qty field, generate a new row
                    // add_row();
                } else {
                    // Move focus to the next input field in the same row
                    let inputs = Array.from(currentRow.querySelectorAll("input"));
                    let index = inputs.indexOf(activeElement);
                    if (index !== -1 && index < inputs.length - 1) {
                        inputs[index].focus(); // Move focus to next field in the same row
                    }
                }
            }
        }
    });




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
    newRow.querySelector('input[name="product[]"]').focus();
}

//     function row_deletion(){

//         $(document).on("click", ".row_delete", function (e) {
//     e.preventDefault(); // Prevent default action
//     e.stopPropagation(); // Stop event bubbling

//     const removedRow = $(this).closest('tr');
//     const removedIndex = removedRow.index() + 1;
//     console.log("Removing row at index:", removedIndex);

//     removedRow.fadeOut(300, function () { // Animate removal for better UX
//         $(this).remove();

//         // Update remaining row indices
//         $('#table_body tr').each(function (index) {
//             $(this).find('.serial-field').val(index + 1);
//         });

//         // Update LocalStorage
//         let totalRows = parseInt(localStorage.getItem("total_rows") || 0);
//         localStorage.setItem("total_rows", Math.max(0, totalRows - 1));
//     });
// });


//     }


$(document).on("click", "#remove", function(e) {

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






window.onload = function() {

    localStorage.setItem('supplier_state', '');
    localStorage.setItem("row_index", 0);
    // document.getElementById('submitButton').disabled = true;    

    document.getElementById('grnDate').setAttribute('readonly', true);

    let supplierName = document.getElementById("supplierName").value;
    let grnAmount = document.getElementById("grnAmount").value;

    let totalQty = document.getElementById("totalQty").value;
    let totalAmount = document.getElementById("totalAmount").value;
    let cgstAmount = document.getElementById("cgstAmount").value;
    let sgstAmount = document.getElementById("sgstAmount").value;
    let igstAmount = document.getElementById("igstAmount").value;
    let addOnAmount = document.getElementById("addOnAmount").value;
    let deductionAmount = document.getElementById("deductionAmount").value;
    let netAmount = document.getElementById("netAmount").value;


    if (grnAmount == 0) {
        document.getElementById("submitButton").disabled = true;
    } else {
        document.getElementById("submitButton").disabled = false;
        setTimeout(function() {
            $('#table_body tr').last().find('#remove').trigger('click');
        }, 200)



    }

    if (grnAmount != netAmount) {

        document.getElementById('submitButton').disabled = false;
    }

    if (supplierName == "") {
        document.getElementById("supplierName").style.background = 'gainsboro';
        document.getElementById("supplierName").setAttribute('readonly', 'true')
    } else {
        // document.getElementById("supplierName").style.background='none';
        document.getElementById("supplierName").removeAttribute('readonly');

    }



    if (grnAmount == "") {
        document.getElementById("grnAmount").style.background = 'gainsboro';
        document.getElementById("grnAmount").setAttribute('readonly', 'true');
    } else {

        document.getElementById("grnAmount").style.background = 'none';
        document.getElementById("grnAmount").removeAttribute('readonly');

    }



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

    // document.getElementById("grnAmount").style.background='gainsboro';

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
    // document.getElementById("grnAmount").disabled = true;
    // document.getElementById("dcNumber").disabled = true;
    // document.getElementById("dcDate").disabled = true;
    // document.getElementById("invoiceNumber").disabled = true;
    // document.getElementById("invoiceDate").disabled = true;

    // document.getElementById("cgstAmount").disabled = true;
    // document.getElementById("sgstAmount").disabled = true;
    // document.getElementById("igstAmount").disabled = true;
    // document.getElementById("addOnAmount").disabled = true;
    // document.getElementById("deductionAmount").disabled = true;

    let session_sno = '<?php echo $_SESSION['snos'] + 1; ?>';
    localStorage.setItem("total_rows", session_sno);
    let mydate = new Date();
    let currentDate = mydate.getFullYear() + "-" +
        (mydate.getMonth() + 1).toString().padStart(2, "0") + "-" +
        mydate.getDate().toString().padStart(2, "0");
    // document.getElementById("grnDate").value = currentDate;
    // document.getElementById("dcDate").value =currentDate;
    // document.getElementById("invoiceDate").value =currentDate;



    document.getElementById("grnNumber").focus();
}
let rowIndex = localStorage.getItem("row_index");


setTimeout(() => {


}, 10);




function validateAmounts() {
    let grnAmount = parseFloat(document.getElementById("grnAmount").value) || 0;
    let netAmount = parseFloat(document.getElementById("netAmount").value) || 0;


    if (grnAmount == netAmount) {
        document.getElementById("submitButton").disabled = false;
    } else {
        document.getElementById("submitButton").disabled = true;
    }

}

document.getElementById("grnAmount").addEventListener("input", validateAmounts);
document.getElementById("cgstAmount").addEventListener("focusout", validateAmounts);
document.getElementById("sgstAmount").addEventListener("focusout", validateAmounts);
document.getElementById("igstAmount").addEventListener("focusout", validateAmounts);
document.getElementById("addOnAmount").addEventListener("focusout", validateAmounts);
document.getElementById("deductionAmount").addEventListener("focusout", validateAmounts);



document.getElementById('grnAmount').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('grnAmount').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});



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

    if (target.name === "mrp[]") {
        // Allow only numbers and a single decimal point
        target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    } else if (target.name === "sellingPrice[]") {
        // Allow only numbers and a single decimal point
        target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');

    } else if (target.name === "rate[]") {
        // Allow only numbers and a single decimal point
        target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    } else if (target.name === "qty[]") {
        // Allow only numbers and a single decimal point
        target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    }

});


// document.getElementById("table_body").addEventListener("focusout", function(event){
//         let target = event.target;
//     if(target.name == 'product[]'){

//         let row = target.closest('tr');
//         row.querySelector('input[name="brand[]"]').select()
//     }else if(target.name == 'brand[]'){

//     let row = target.closest('tr');
//     row.querySelector('input[name="design[]"]').select()
//     }else if(target.name == 'design[]'){

//         let row = target.closest('tr');
//         row.querySelector('input[name="batch[]"]').select()
//     }else if(target.name == 'batch[]'){

//         let row = target.closest('tr');
//         row.querySelector('input[name="color[]"]').select()
//     }else if(target.name == 'color[]'){

//         let row = target.closest('tr');
//         row.querySelector('input[name="category[]"]').select()
//     }else if(target.name == 'category[]'){

//         let row = target.closest('tr');
//         row.querySelector('input[name="hsnCode[]"]').select()
//     }else if(target.name == 'hsnCode[]'){

//         let row = target.closest('tr');
//         row.querySelector('input[name="tax[]"]').select()
//     }else if(target.name == 'tax[]'){

//         let row = target.closest('tr');
//         row.querySelector('input[name="size[]"]').select()
//     }else if(target.name == 'size[]'){

//         let row = target.closest('tr');
//         row.querySelector('input[name="mrp[]"]').select()
//     }else if(target.name == 'mrp[]'){

//         let row = target.closest('tr');
//         row.querySelector('input[name="sellingPrice[]"]').select()
//     }else if(target.name == 'sellingPrice[]'){

//         let row = target.closest('tr');
//         row.querySelector('input[name="rate[]"]').select()
//     }else if(target.name == 'rate[]'){

//         let row = target.closest('tr');
//         row.querySelector('input[name="qty[]"]').select()
//     }

// })

// document.getElementById('mrp_'+rowIndex).addEventListener('keypress', function (event) {
//             const charCode = event.which || event.keyCode; // Get the character code
//             const charStr = String.fromCharCode(charCode); // Convert to a string

//             // Allow digits (0-9) and a single decimal point
//             if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
//                 event.preventDefault(); // Prevent input if not a number or extra decimal
//             }
//         });

//         document.getElementById('mrp_'+rowIndex).addEventListener('input', function () {
//             // Prevent any invalid characters that might slip through (e.g., copy-paste)
//             this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
// });









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

document.getElementById('grnNumber').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('grnNumber').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
});




document.getElementById("supplierName").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("grnAmount").focus();
        document.getElementById("grnAmount").select();
    }

})

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("grnAmount").addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();

            // Activate the "DC & Invoice" tab
            let tab = new bootstrap.Tab(document.getElementById("profile-tab"));
            tab.show();

            // Wait a little for the tab transition, then focus on the input field
            setTimeout(() => {
                document.getElementById("invoiceNumber").focus();
                document.getElementById("invoiceNumber").select();
            }, 200);
        }
    });
});


document.getElementById("dcNumber").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("dcDate").focus();


    }
})

document.getElementById("dcDate").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {

        event.preventDefault();
        document.getElementById("invoiceNumber").focus();
        document.getElementById("invoiceNumber").select();
    }
})


document.getElementById("invoiceNumber").addEventListener("keydown", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("invoiceDate").focus();

    }
})

document.getElementById("invoiceDate").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {

        event.preventDefault();

        document.getElementById("product_1").focus();
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
        document.getElementById("submitButton").focus();

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
//     error_reporting(E_ALL);
//                 ini_set('display_errors',1);

//     $serialNumber = $_POST['serialNumber'];
// $product = $_POST['product'];
// $brand = $_POST['brand'];
// $design = $_POST['design'];
// $batch = $_POST['batch'];
// $color = $_POST['color'];
// $hsnCode = $_POST['hsnCode'];
// $category = $_POST['category'];
// $tax = $_POST['tax'];
// $size = $_POST['size'];
// $mrp = $_POST['mrp'];
// $sellingPrice = $_POST['sellingPrice'];
// $rate = $_POST['rate'];
// $itemQty  = $_POST['qty'];
// $itemAmount = $_POST['amount'];
// $itemId = $_POST['id'];
// $totalQty = $_POST['totalQty'];
// $totalAmount = $_POST['totalAmount'];
// $cgstAmount = $_POST['cgstAmount'];
// $sgstAmount = $_POST['sgstAmount'];
// $igstAmount = $_POST['igstAmount'];
// $addOnAmount = $_POST['addOnAmount'];
// $deductionAmount = $_POST['deductionAmount'];
// $netAmount = $_POST['netAmount'];

// echo "<pre>";
// print_r($product);
// echo "<br>";
// print_r($brand);
// echo "<br>";
// print_r($design);
// echo "<br>";
// print_r($batch);
// echo "<br>";
// print_r($color);
// echo "<br>";
// print_r($hsnCode);
// echo "<br>";
// print_r($category);
// echo "<br>";
// print_r($tax);
// echo "<br>";
// print_r($size);
// echo "<br>";
// print_r($mrp);
// echo "<br>";
// print_r($sellingPrice);
// echo "<br>";
// print_r($rate);
// echo "<br>";
// print_r($itemQty);
// echo "<br>";
// print_r($itemAmount);
// echo "<br>";
// print_r($itemId);
// echo "<br>";
// echo $totalQty;
// echo "<br>";
// echo $totalAmount;
// echo "<br>";
// echo $cgstAmount;
// echo "<br>";
// echo $sgstAmount;
// echo "<br>";
// echo $igstAmount;
// echo "<br>";
// echo $addOnAmount;
// echo "<br>";
// echo $deductionAmount;
// echo "<br>";
// echo $netAmount;
// echo "<br>";
// echo "</pre>";

//     $supplierName =  $_POST['supplierName'];
//     $supplierId = $_POST['supplierId'];

//     $grnAmount = $_POST['grnAmount'];
//     $netAmount = $_POST['netAmount'];

//     if($grnAmount != '' && $grnAmount != 0){

//     if($grnAmount == $netAmount){
//             $grnNumber = $_POST['grnNumber'];
//             $grnDate = $_POST['grnDate'];
//             $dcNumber = $_POST['dcNumber'];
//             $dcDate = $_POST['dcDate'];
//             $invoiceNumber = $_POST['invoiceNumber'];
//             $invoiceDate = $_POST['invoiceDate'];
//             $serialNumber = $_POST['serialNumber'];
//             $product = $_POST['product'];
//             $brand = $_POST['brand'];
//             $design = $_POST['design'];
//             $batch = $_POST['batch'];
//             $color = $_POST['color'];
//             $hsnCode = $_POST['hsnCode'];
//             $category = $_POST['category'];
//             $tax = $_POST['tax'];
//             $size = $_POST['size'];
//             $mrp = $_POST['mrp'];
//             $sellingPrice = $_POST['sellingPrice'];
//             $rate = $_POST['rate'];
//             $itemQty  = $_POST['qty'];
//             $itemAmount = $_POST['amount'];
//             $itemId = $_POST['id'];

//             $totalQty = $_POST['totalQty'];
//             $totalAmount =$_POST['totalAmount'];
//             $cgst = isset($_POST['cgstAmount']) ? $_POST['cgstAmount'] : 0;
//             $sgst = isset($_POST['sgstAmount']) ? $_POST['sgstAmount'] : 0;
//             $igst = isset($_POST['igstAmount']) ? $_POST['igstAmount'] : 0;
//             $addOn = $_POST['addOnAmount'];
//             $deduction = $_POST['deductionAmount'];

//             if(($netAmount - $totalAmount) != 0 ){
//                 $percent = round((($netAmount-$totalAmount)/$totalAmount)*100,2);
//             }else{
//                 $percent = 0;
//             }

//             $query = "
//                   update purchase_summary
//                   set
//                   grn_number = '$grnNumber', grn_date ='$grnDate',counter_name='$counterName',
//                   supplier_id =  '$supplierId',grn_amount = '$grnAmount', dc_number = '$dcNumber', dc_date = '$dcDate',
//                   invoice_number = '$invoiceNumber', invoice_date = '$invoiceDate',
//                   total_qty = '$totalQty',total_amount = '$totalAmount',cgst_amount = '$cgst',
//                   sgst_amount = '$sgst', igst_amount = '$igst',addon = '$addOn',
//                   deduction = '$deduction',net_amount = '$netAmount',user_id = '$userId'
//                   where grn_number = '$grnNumber' and branch_id = '$userBranchId'";


//         $resultQueryPurchaseSummary = $con->query($query);
//         // if($resultQuery){
//         //     echo "purchase summary updated";
//         // }else{
//         //     echo "oops! something went wrong";
//         // }


//         $updateStockBal = "
//             UPDATE stock_balance sb
//             JOIN purchase_item pi ON sb.item_id = pi.item_id AND sb.branch_id = pi.branch_id
//             SET sb.item_qty = sb.item_qty - pi.item_qty
//             WHERE pi.grn_number = ? AND pi.branch_id = ?";

//             $stmt = $con->prepare($updateStockBal);
//             $stmt->bind_param("si", $grnNumber, $userBranchId);
//             $stmt->execute();
//             $stmt->close();


//         $queryDeleteOldPurchaseItem = "delete from purchase_item where grn_number = '$grnNumber' and branch_id = '$userBranchId'
//                                        and counter_name = '$counterName'";
//         $resultDeleteOldPurchaseItem = $con->query($queryDeleteOldPurchaseItem);

//         $queryDeleteOldStockTransaction = "delete from stock_transaction where grn_number = '$grnNumber' and branch_id = '$userBranchId'
//                                            and counter_name = '$counterName'";
//         $resultDeleteOldStockTransaction = $con->query($queryDeleteOldStockTransaction);


//         $a=0;

//         foreach($product as $pro){

//             $landCost = round($rate[$a]+(($rate[$a]*$percent)/100),2);
//             $margin = round((($sellingPrice[$a]-$landCost)/$sellingPrice[$a])*100,2);

//             $queryPurchaseItem = "insert into purchase_item (grn_number, grn_date,counter_name,
//             item_id,item_qty,item_amount,land_cost,margin,s_no,branch_id)
//             values('$grnNumber','$grnDate','$counterName','$itemId[$a]','$itemQty[$a]','$itemAmount[$a]',
//                    '$landCost','$margin','$serialNumber[$a]','$userBranchId')";

//             $resultQuery = $con->query($queryPurchaseItem);        


//             $queryStockTransaction = "insert into stock_transaction (grn_number, grn_date,counter_name,
//             item_id,item_qty,land_cost,entry_type,branch_id)
//             values('$grnNumber','$grnDate','$counterName','$itemId[$a]','$itemQty[$a]',
//                    '$landCost','P','$userBranchId')";
//             $resultStockTransaction = $con->query($queryStockTransaction);


//                 $querySearchStockBalance = "select*from stock_balance where item_id = '$itemId[$a]' and branch_id = '$userBranchId'";
//                 $resultSearchStockBalance = $con->query($querySearchStockBalance);

//                 if($resultSearchStockBalance->num_rows==0){
//                     echo "item id from stock balance table = ";
//                     echo "<br>";
//                     $queryStockBalance = "insert into stock_balance(item_id,item_qty,branch_id) values('$itemId[$a]','$itemQty[$a]','$userBranchId')";                
//                     $resultStockBalance = $con->query($queryStockBalance);                    
//                 }else{
//                     // echo "<br>";
//                     // echo "item is there";
//                     // echo "<br>";
//                         $queryStockBalance = "update stock_balance set item_qty = item_qty+'$itemQty[$a]'
//                         where item_id = '$itemId[$a]' and branch_id = '$userBranchId'";
//                         $resultStockBalance = $con->query($queryStockBalance);


//                     };

//                     $a++;            

//         }
//                 // $resultStockBalance = $con->query($queryStockBalance);


//             if($resultQueryPurchaseSummary){
//                 error_reporting(E_ALL);
//                 ini_set('display_errors',1);
//                 $_SESSION['notification'] = "Purchase Updated Successfully";            
//                 header("Location:".BASE_URL."/pages/purchaseEdit.php");
//                 exit();

//             }else{
//                 echo "something went wrong";
//             }


//     }else{
//         $_SESSION['notification'] = "GRN Amount And Net Amount Does Not Match";
//         header("Location:".BASE_URL."/pages/purchaseEdit.php");
//         echo '<script>
//       document.addEventListener("DOMContentLoaded", function() {
//           let toastElement = new bootstrap.Toast(document.getElementById("liveToast"));
//           toastElement.show();
//       });
//     </script>';



//         }
//    }  
// }

if (isset($_POST['update_button'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Extract common fields
    extract($_POST);

    // Check GRN amount match
    if ($grnAmount != '' && $grnAmount != 0 && $grnAmount == $netAmount) {
        try {
            $con->begin_transaction(); // Start transaction

            // Update purchase_summary
            $query = "
                UPDATE purchase_summary
                SET grn_number = ?, grn_date = ?, counter_name = ?, supplier_id = ?, grn_amount = ?, 
                    dc_number = ?, dc_date = ?, invoice_number = ?, invoice_date = ?, total_qty = ?, 
                    total_amount = ?, cgst_amount = ?, sgst_amount = ?, igst_amount = ?, addon = ?, 
                    deduction = ?, net_amount = ?, user_id = ?
                WHERE grn_number = ? AND branch_id = ?";

            $stmt = $con->prepare($query);
            $stmt->bind_param(
                "ssssssssdddddddddssi",
                $grnNumber,
                $grnDate,
                $counterName,
                $supplierId,
                $grnAmount,
                $dcNumber,
                $dcDate,
                $invoiceNumber,
                $invoiceDate,
                $totalQty,
                $totalAmount,
                $cgstAmount,
                $sgstAmount,
                $igstAmount,
                $addOnAmount,
                $deductionAmount,
                $netAmount,
                $userId,
                $grnNumber,
                $userBranchId
            );
            $stmt->execute();
            $stmt->close();

            // Reverse old stock balance
            $updateStockBal = "
                UPDATE stock_balance sb
                JOIN purchase_item pi ON sb.item_id = pi.item_id AND sb.branch_id = pi.branch_id
                SET sb.item_qty = sb.item_qty - pi.item_qty
                WHERE pi.grn_number = ? AND pi.branch_id = ?";
            $stmt = $con->prepare($updateStockBal);
            $stmt->bind_param("si", $grnNumber, $userBranchId);
            $stmt->execute();
            $stmt->close();

            // Delete old purchase_item and stock_transaction
            $deleteItem = $con->prepare("DELETE FROM purchase_item WHERE grn_number = ? AND branch_id = ? AND counter_name = ?");
            $deleteItem->bind_param("sis", $grnNumber, $userBranchId, $counterName);
            $deleteItem->execute();
            $deleteItem->close();

            $deleteStock = $con->prepare("DELETE FROM stock_transaction WHERE grn_number = ? AND branch_id = ? AND counter_name = ?");
            $deleteStock->bind_param("sis", $grnNumber, $userBranchId, $counterName);
            $deleteStock->execute();
            $deleteStock->close();

            // Reinsert updated items
            $a = 0;
            $percent = ($netAmount - $totalAmount) != 0 ? round((($netAmount - $totalAmount) / $totalAmount) * 100, 2) : 0;

            foreach ($product as $pro) {
                $landCost = round($rate[$a] + (($rate[$a] * $percent) / 100), 2);
                $margin = round((($sellingPrice[$a] - $landCost) / $sellingPrice[$a]) * 100, 2);

                $queryInsertItem = "
                    INSERT INTO purchase_item (grn_number, grn_date, counter_name, item_id, item_qty, item_amount, land_cost, margin, s_no, branch_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($queryInsertItem);
                $stmt->bind_param(
                    "ssssiiddii",
                    $grnNumber,
                    $grnDate,
                    $counterName,
                    $itemId[$a],
                    $itemQty[$a],
                    $itemAmount[$a],
                    $landCost,
                    $margin,
                    $serialNumber[$a],
                    $userBranchId
                );
                $stmt->execute();
                $stmt->close();

                $queryInsertStock = "
                    INSERT INTO stock_transaction (grn_number, grn_date, counter_name, item_id, item_qty, land_cost, entry_type, branch_id)
                    VALUES (?, ?, ?, ?, ?, ?, 'P', ?)";
                $stmt = $con->prepare($queryInsertStock);
                $stmt->bind_param(
                    "sssiddi",
                    $grnNumber,
                    $grnDate,
                    $counterName,
                    $itemId[$a],
                    $itemQty[$a],
                    $landCost,
                    $userBranchId
                );
                $stmt->execute();
                $stmt->close();

                // Check if item exists in stock_balance
                $queryCheck = "SELECT item_qty FROM stock_balance WHERE item_id = ? AND branch_id = ?";
                $stmt = $con->prepare($queryCheck);
                $stmt->bind_param("ii", $itemId[$a], $userBranchId);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows == 0) {
                    $stmt->close();
                    $queryInsertStockBalance = "INSERT INTO stock_balance (item_id, item_qty, branch_id) VALUES (?, ?, ?)";
                    $stmt = $con->prepare($queryInsertStockBalance);
                    $stmt->bind_param("iii", $itemId[$a], $itemQty[$a], $userBranchId);
                } else {
                    $stmt->close();
                    $queryUpdateStockBalance = "UPDATE stock_balance SET item_qty = item_qty + ? WHERE item_id = ? AND branch_id = ?";
                    $stmt = $con->prepare($queryUpdateStockBalance);
                    $stmt->bind_param("iii", $itemQty[$a], $itemId[$a], $userBranchId);
                }

                $stmt->execute();
                $stmt->close();

                $a++;
            }

            // All successful, commit
            $con->commit();
            $_SESSION['notification'] = "Purchase Updated Successfully";
            header("Location:" . BASE_URL . "/pages/purchaseEdit.php");
            exit();
        } catch (Exception $e) {
            $con->rollback(); // Revert everything on error
            $_SESSION['notification'] = "Error occurred: " . $e->getMessage();
            header("Location:" . BASE_URL . "/pages/purchaseEdit.php");
            exit();
        }
    } else {
        $_SESSION['notification'] = "GRN Amount And Net Amount Does Not Match";
        echo '<script>
      document.addEventListener("DOMContentLoaded", function() {
          let toastElement = new bootstrap.Toast(document.getElementById("liveToast"));
          toastElement.show();
      });
    </script>';

        header("Location:" . BASE_URL . "/pages/purchaseEdit.php");
        exit();
    }
}



?>



<?php include_once(DIR_URL . "/includes/footer.php"); ?>
<?php ob_end_flush(); ?>