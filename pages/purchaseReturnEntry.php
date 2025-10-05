<?php

ob_start();

?>
<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

use function PHPSTORM_META\type;

include_once("../config/config.php");
include_once(DIR_URL . "/includes/header.php");
include_once(DIR_URL . "/db/dbConnection.php");
include_once(DIR_URL . "/includes/navbar.php");

include_once(DIR_URL . "/includes/sidebar.php");
// include_once(DIR_URL."includes/itemMaster.php");



$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$financial_year = $_SESSION['financial_year'];
$companyState = $_SESSION['company_state'];


// $currentDate = date("Y-m-d H:i:s");
// echo $currentDate;

$querySearchsupplierId = "select*from suppliers where supplier_name = 'Cash'
                              && branch_id = '$userBranchId'";
$resultSearchsupplierId = $con->query($querySearchsupplierId)->fetch_assoc();






// if(isset($_SESSION['item_id'])){
//     $itemId = $_SESSION['item_id'];
//     echo "item id = ".$itemId;
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
    background-color: red !important;
    /* Orange-Red for Sales Return */
    color: white !important;
}
</style>
<?php
$querySearchSnoMaster = "select*from sno_master where
                         financial_year = '$financial_year'
                         && branch_id='$userBranchId' ";
$resultSearchSnoMaster  = $con->query($querySearchSnoMaster)->fetch_assoc();
$purchase_return_no = $resultSearchSnoMaster['purchase_return_no'];
$purchase_return_no = $purchase_return_no + 1;

if (isset($purchase_return_no)) {
} else {
    $purchase_return_no = "";
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
#duplicatesupplierMobile {
    width: 120px;
    height: 30px;
    margin-top: -80px;
    margin-left: 819px;
    display: none;

}

#purchaseReturnEntry {

    margin-left: 0px;
    margin-top: -120px;
    width: 345px;
    font-size: 14px;
    font-weight: bold;
    text-transform: capitalize;
    padding: 4px 14.5px;
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
    background-color: blanchedalmond;
    margin-top: -120px;
    /* margin-left:300px; */
    width: 400px;
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

#purchaseReturnNumber,
#purchaseReturnDate {
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
    <div class="" style="margin-left:1160px;border:1px solid black;width:340px;height:140px;margin-top:10px;">



        <div style="display:flex;gap:10px;">
            <div class="form-floating">
                <input type="text" name="purchaseReturnNumber" id="purchaseReturnNumber" readonly class="form-control"
                    placeholder="PRN Number" value="<?php echo $purchase_return_no; ?>" autocomplete="off"
                    maxlength="30">
                <label for="purchaseReturnNumber"
                    style="margin-left:6px;margin-top:12px;font-size:large;font-weight:bold">PRN Number</label>
            </div>
            <div class="form-floating">
                <input type="date" name="purchaseReturnDate" readonly id="purchaseReturnDate" class="form-control"
                    placeholder="PRN Date " value="" maxlength="30">
                <label for="purchaseReturnDate"
                    style="margin-left:15px;margin-top:15px;font-size:large;font-weight:bold">PRN Date</label>
            </div>
        </div>

        <div style="display: flex;">
            <div class="form-floating">
                <input type="text" name="counterName" readonly id="counterName" class="form-control"
                    value="<?php echo $_SESSION['counter_name']; ?>" maxlength="4">
                <label for="counterName"
                    style="margin-left:15px;margin-top:5px;font-size:large;font-weight:bold">Counter</label>

            </div>

            <div style="display: flex;margin-left:25px;margin-top:18px;gap:4px">
                <label for="" style="font-size:25px;font-weight:bolder">Print</label>

                <input type="checkbox" name="printPurchaseReturn" id="printPurchaseReturn" value="printPR" checked
                    style="width:20px;height:20px;margin-top:8px;">
            </div>

        </div>


    </div>
    <div style="margin-top:-20px;margin-left:-12px">

        <div style="display:flex;gap:12px">
            <label for="" style="margin-left:280px;margin-top:-118px;">Supplier Name</label>
            <input type="text" name="supplierName" autocomplete="off" id="supplierName" class="form-control"
                placeholder="Press F2 For supplier Info"
                value="<?php echo $resultSearchsupplierId['supplier_name']; ?>">

            <input type="text" hidden name="supplierId" id="supplierId" class="form-control"
                value="<?php echo $resultSearchsupplierId['id']; ?>">
            <label for="" id="purchaseReturnEntry">PURCHASE RETURN ENTRY</label>
        </div>
        <div style="display:flex;gap:6px">

            <div style="display: flex;gap:4px;">
                <div class="form-floating" style="margin-top:-40px;margin-left:880px">
                    <input type="text" style="height: 40px;width:180px;background-color:blanchedalmond;"
                        name="reprintPurchaseReturnNumber" id="reprintPurchaseReturnNumber" class="form-control"
                        placeholder="Reprint Sales Number" autocomplete="off" maxlength="30">
                    <label for="reprintPurchaseReturnNumber"
                        style="margin-left:6px;margin-top:-5px;font-size:13px;font-weight:bold;">Select PRN</label>

                </div>
                <button type="submit" name="reprintButton" id="reprintButton" class="btn btn-success"
                    style="margin-top:-38px;height:39px">Reprint</button>
            </div>









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
        <!-- Your Sales Content Here -->






        <div style="margin-left:165px;font-size:12px;">
            <div style="width:1235px;height:270px;overflow-y:auto;" id="itemTable">
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
                        <tr>
                            <td>
                                <input type="text" class="serial-field" name="serialNumber[]" id="serialNumber_1"
                                    style="background-color:#212529;color:white;width:45px; height:25px; text-align:center;"
                                    maxlength="4" autocomplete="off" value="1" readonly />
                            </td>
                            <td>
                                <input type="text" class="design-field" name="design[]" id="design_1" autocomplete="off"
                                    style="width:175px; height:25px; text-align:left;background-image: linear-gradient(225deg, white 50%, blanchedalmond 50%);"
                                    maxlength="30" placeholder="Press F4 For Item Info"/>
                            </td>
                            <td>
                                <input type="text" class="description-field" name="description[]" id="description_1"
                                    autocomplete="off" style="width:430px; height:25px; text-align:left;"
                                    maxlength="150" readonly />
                            </td>
                            <td>
                                <input type="text" class="hsnCode-field" name="hsnCode[]" id="hsnCode_1"
                                    autocomplete="off" style="width:65px; height:25px; text-align:center;" maxlength="8"
                                    readonly />
                            </td>
                            <td>
                                <input type="text" class="tax-field" name="tax[]" id="tax_1" autocomplete="off"
                                    style="width:35px; height:25px; text-align:center;" maxlength="8" readonly />
                            </td>
                            <td>
                                <input type="text" class="sellingPrice-field" name="sellingPrice[]" id="sellingPrice_1"
                                    autocomplete="off" style="width:70px; height:25px; text-align:right;" maxlength="12"
                                    readonly />
                            </td>
                            <td>
                                <input type="text" class="salesMan-field" name="salesMan[]" id="salesMan_1"
                                    autocomplete="off" style="width:70px; height:25px; text-align:center;"
                                    maxlength="12" />
                            </td>
                            <td>
                                <input type="text" class="qty-field" name="qty[]" id="qty_1" autocomplete="off"
                                    style="width:35px; height:25px; text-align:center;" maxlength="5" />
                            </td>
                            <td>
                                <input type="text" class="discountPercent-field" name="discountPercent[]"
                                    id="discountPercent_1" autocomplete="off"
                                    style="width:45px; height:25px; text-align:center;" maxlength="4" />
                            </td>
                            <td>
                                <input type="text" class="discountAmount-field" name="discountAmount[]"
                                    id="discountAmount_1" autocomplete="off"
                                    style="width:80px; height:25px; text-align:right;" maxlength="10" />
                            </td>
                            <td>
                                <input type="text" class="amount-field" name="amount[]" id="amount_1" autocomplete="off"
                                    style="width:85px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                    maxlength="13" readonly />
                            </td>
                            <td hidden>
                                <input type="text" class="actualAmount-field" name="actualAmount[]" id="actualAmount_1"
                                    autocomplete="off"
                                    style="width:80px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                    maxlength="13" readonly />
                            </td>
                            <td hidden>
                                <input type="text" class="taxable-field" name="taxable[]" id="taxable_1"
                                    autocomplete="off"
                                    style="width:50px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                    maxlength="13" readonly />
                            </td>
                            <td hidden>
                                <input type="text" class="taxAmount-field" name="taxAmount[]" id="taxAmount_1"
                                    autocomplete="off"
                                    style="width:10px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                    maxlength="13" readonly />
                            </td>
                            <td>
                                <input type="text" class="id-field" name="id[]" id="id_1" readonly autocomplete="off"
                                    style="width:50px; height:25px; text-align:center; background-color:#212529; color:white; border:1px solid white;" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br>
        <button style="padding-top:0px;position:relative;left:1270px;top:106px;width:120px;
            font-weight:bolder;height:30px;font-size:large" type="submit" class="btn btn-primary" name="submit_button"
            id="submitButton">Submit</button>
    </div>
    <div style="margin-left:1180px;margin-top:-45px">
        <div style="display:flex;gap:8px">
            <label for="" style="margin-left:-12px">Total</label>
            <input type="text" name="totalQty" id="totalQty" class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:50px;" maxlength="4">
            <input type="text" name="totalAmount" id="totalAmount" class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
            <input type="text" name="totalActualAmount" id="totalActualAmount" hidden class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
            <input type="text" name="totalTaxable" id="totalTaxable" hidden readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px" class="form-control"
                maxlength="12">
            <input type="text" name="totalTaxAmount" id="totalTaxAmount" hidden readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px" class="form-control"
                maxlength="12">
        </div>
        <div style="display:flex;margin-top:-25px;margin-left:180px" hidden>
            <label for="">CGST</label>
            <input type="text" name="cgstAmount" id="cgstAmount" readonly autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:10px" maxlength="12">
        </div>
        <div style="display:flex;margin-top:5px;margin-left:180px" hidden>
            <label for="">SGST</label>
            <input type="text" name="sgstAmount" id="sgstAmount" readonly autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:10px" maxlength="12">
        </div>
        <div style="display:flex;margin-top:5px;margin-left:180px" hidden>
            <label for="">IGST</label>
            <input type="text" name="igstAmount" id="igstAmount" readonly autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:15px" maxlength="12">
        </div>

        <div style="display:flex;margin-top:5px;margin-left:-11px;gap:2px">
            <label for="">Dis %</label>
            <input type="text" name="netDiscountPercent" id="netDiscountPercent" class="form-control" autocomplete="off"
                maxlength="4" style="width:51px;height:25px">
            <!-- <label for="">Discount </label> -->
            <input type="text" name="deductionAmount" id="deductionAmount" autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;" maxlength="12">
        </div>

        <div style="display:flex;margin-top:5px;">

            <label for="" style="margin-left: -11px;">Add On</label>
            <input type="text" name="addOnAmount" id="addOnAmount" autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:40px" maxlength="12">
        </div>

        <div style="display:flex;margin-top:5px">
            <label for="" style="margin-left:-11px;">After Add On</label>
            <input type="text" name="afterAddOn" id="afterAddOn" class="form-control" readonly
                style="font-weight:bold;color:red;text-align:right;font-size:12px;height:25px;width:90px;margin-left:1px"
                maxlength="12">
        </div>
        <div style="display:flex;margin-top:5px" hidden>
            <label for="" style="margin-left:-11px;color:red;">Sales Return</label>
            <input type="text" name="salesReturnNetAmount" id="salesReturnNetAmount" class="form-control" readonly
                style="font-weight:bold;color:red;text-align:right;font-size:12px;height:25px;width:90px;margin-left:8px"
                maxlength="12">
        </div>

        <div style="display:flex;margin-top:5px;">
            <label for="" style="margin-left: -11px;color:green;font-size:15px;font-weight:bolder;margin-top:2px">Net
                Amount</label>
            <input type="text" name="netAmount" id="netAmount" class="form-control" readonly
                style="font-weight:bolder;color:green;text-align:right;font-size:15px;height:30px;width:90px;margin-left:8px"
                maxlength="12">

        </div>



</form>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
window.onload = function() {
    localStorage.setItem("row_index", 1);
    localStorage.setItem("row_deleted", 0);


    localStorage.setItem("sr_row_deleted", 0);
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


// Fetching Purchase Return Summary Data For Bill Print Starts

document.getElementById("reprintPurchaseReturnNumber").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "F2") {
        event.preventDefault();
        let salesNumber = new FormData();
        salesNumber.append("lb_pr_number", target.value);
        let aj_salesNumber = new XMLHttpRequest();
        aj_salesNumber.open("POST", "ajaxPurchaseReturnBillReprint.php", true);
        aj_salesNumber.send(salesNumber);
        aj_salesNumber.onreadystatechange = function() {
            if (aj_salesNumber.status === 200 && aj_salesNumber.readyState === 4) {
                document.getElementById("response_message").innerHTML = aj_salesNumber.responseText;
                document.getElementById("reprintButton").focus();

            }
        }

    }

})



// Ends








// document.getElementById('submitButton').addEventListener('click',function(event){
//     event.preventDefault();
//     document.getElementById("sr_submitButton").click();
// })


document.getElementById("supplierName").addEventListener("focusout", function(event) {
    let target = event.target;
    event.preventDefault();

    if (target.value != "") {
        let supplierName = new FormData();
        supplierName.append("al_supplier_name", target.value);
        let aj_supplier = new XMLHttpRequest();
        aj_supplier.open("POST", "itemStoring.php", true);
        aj_supplier.send(supplierName);

        aj_supplier.onreadystatechange = function() {
            if (aj_supplier.status === 200 && aj_supplier.readyState === 4) {
                // document.getElementById("response_message").innerHTML = aj_supplier.responseText;
                // document.getElementById("response_message").style.display = "block";
                document.getElementById('supplierId').value = aj_supplier.responseText;

            }
        }
    }


})




document.getElementById("table_body").addEventListener('focusin', function(event) {

    let target = event.target;
    let currentRow = target.closest('tr');
    if (target.name == "salesMan[]") {

        calculateAmount(target);
        // calculateAc();
        calculateTaxAmount(target);
        calculateTotalAmount();
        calculateNetAmount();

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





document.getElementById("supplierName").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "F2") {
        event.preventDefault();
        let supplierName = new FormData();
        supplierName.append("lb_supplier_name", target.value);
        let aj_supplier = new XMLHttpRequest();
        // aj_supplier.open("POST","ajaxGetsupplierDetails.php",true);
        aj_supplier.open("POST", "itemStoring.php", true);
        aj_supplier.send(supplierName);

        aj_supplier.onreadystatechange = function() {
            if (aj_supplier.status === 200 && aj_supplier.readyState === 4) {
                document.getElementById("response_message").innerHTML = aj_supplier.responseText;
                document.getElementById("response_message").style.display = "block";



            }
        }


    } else if (event.key === "Enter") {

        event.preventDefault();
        if (target.value != "") {
            let supplierName = new FormData();
            supplierName.append("al_supplier_name", target.value);
            let aj_supplier = new XMLHttpRequest();
            aj_supplier.open("POST", "itemStoring.php", true);
            aj_supplier.send(supplierName);

            aj_supplier.onreadystatechange = function() {
                if (aj_supplier.status === 200 && aj_supplier.readyState === 4) {
                    document.getElementById('supplierId').value = aj_supplier.responseText;

                    // document.getElementById("response_message").innerHTML = aj_supplier.responseText;
                    // document.getElementById("response_message").style.display = "block";

                }
            }
        }
    }

})



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
    let supplierState = localStorage.getItem('supplier_state');
    if (supplierState == '1') {
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

    let salesReturnNetAmount = document.getElementById('salesReturnNetAmount').value || 0;
    let deduction = document.getElementById("deductionAmount").value || 0;
    let afterDiscount = 0;
    let netAmount = parseFloat(totalAmount) + parseFloat(addOn) - parseFloat(deduction);


    calculateGST()


    afterDiscount = parseFloat(totalAmount) - parseFloat(deduction);

    afterAddOn.value = parseFloat(afterDiscount) + parseFloat(addOn);

    document.getElementById("netAmount").value = (parseFloat(netAmount) - parseFloat(salesReturnNetAmount)).toFixed(2);


    if (netAmount >= salesReturnNetAmount) {
        document.getElementById("submitButton").disabled = false;

    } else {
        document.getElementById("submitButton").disabled = true;
    }


}


document.getElementById("cgstAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("sgstAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("igstAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("addOnAmount").addEventListener("focusout", calculateNetAmount);
document.getElementById("deductionAmount").addEventListener("focusout", calculateNetAmount);




let totalAmount = 0;

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
        validateAmounts();
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





document.getElementById("table_body").addEventListener("keydown", function(event) {
    const target = event.target;

    // Handle the Enter key event
    if (event.key === "Enter") {
        event.preventDefault(); // Prevent the default Enter key behavior

        // Navigate based on the input field's name


        if (target.name == "design[]") {


            const currentRow = target.closest("tr");
            const salesManField = currentRow.querySelector('input[name="salesMan[]"]');
            if (salesManField) {
                salesManField.focus();
                salesManField.select();
            }



        } else if (target.name == "salesMan[]") {

            const currentRow = target.closest("tr");
            const qtyField = currentRow.querySelector('input[name="qty[]"]');
            if (qtyField) {
                qtyField.focus();
                qtyField.select();
            }


        } else if (target.name == "qty[]") {

            // validateAmounts();

            const currentRow = target.closest('tr');
            const discountPercentField = currentRow.querySelector('input[name="discountPercent[]"]');




            if (discountPercentField) {
                discountPercentField.focus();
                discountPercentField.select();

            }


        } else if (target.name == "discountPercent[]") {

            // validateAmounts();
            if (parseFloat(target.value) < parseFloat(100)) {
                calculateDiscountAmount(target)
            }

            const currentRow = target.closest('tr');
            const discountAmountField = currentRow.querySelector('input[name="discountAmount[]"]');
            // const sellingPriceField = currentRow.querySelector('input[name="sellingPrice[]"]').value;
            // const qtyField = currentRow.querySelector('input[name="qty[]"]').value;
            // const discountPercentField = currentRow.querySelector('input[name="discountPercent[]"]').value;

            // discountAmountField.value = ((sellingPriceField*qtyField)*discountPercentField/100)



            if (discountAmountField) {
                discountAmountField.focus();
                discountAmountField.select();

            }


        } else if (target.name === "discountAmount[]") {
            // Check if it's the last row

            const currentRow = target.closest("tr");
            const isLastRow = currentRow.isSameNode(document.querySelector("#table_body tr:last-child"));
            // validateAmounts();
            if (isLastRow) {
                // Add a new row if it's the last one
                add_row();

                // Focus on the product field of the newly added row
                const nextRow = currentRow.nextElementSibling;
                if (nextRow) {
                    const designField = nextRow.querySelector('input[name="design[]"]');
                    if (designField) {
                        // validateAmounts();
                        designField.focus();
                        designField.select();
                    }
                }

            } else {
                // Move to the product field in the next row
                const nextRow = currentRow.nextElementSibling;
                if (nextRow) {
                    const designField = nextRow.querySelector('input[name="design[]"]');
                    if (designField) {
                        designField.focus();
                        designField.select();
                    }
                }
            }
        }
    }
});

function gettingRowItemDetails(target) {

    const currentRow = target.closest("tr");
    const design = currentRow.querySelector('input[name="design[]"]').value;

    const hsnCode = currentRow.querySelector('input[name="hsnCode[]"]').value;
    const tax = currentRow.querySelector('input[name="tax[]"]').value;
    const sellingPrice = currentRow.querySelector('input[name="sellingPrice[]"]').value;
    const salesMan = currentRow.querySelector('input[name="salesMan[]"]').value;
    const Qty = currentRow.querySelector('input[name="qty[]"]').value;
    const discountPercent = currentRow.querySelector('input[name="discountPercent[]"]').value;
    const discountAmount = currentRow.querySelector('input[name="discountAmount[]"]').value;
    const Amount = currentRow.querySelector('input[name="amount[]"]').value;
    const taxAmount = currentRow.querySelector('input[name="taxAmount[]"]').value;

    const id = currentRow.querySelector('input[name="id[]"]');
    // alert(product.value+" "+brand.value+" "+design.value+" "+batch.value+" "
    // +color.value+" "+category.value+" "+hsnCode.value+" "+tax.value+" "+size.value+" "
    // +mrp.value+" "+sellingPrice.value+" "+rate.value);

    let items = [product, brand, design, color, batch, category, hsnCode, tax, size, mrp, sellingPrice, rate];

    let triggerItemCreation = new FormData();
    triggerItemCreation.append("lb_trigger_item_creation", JSON.stringify(items));
    let ajTriggerItemCreation = new XMLHttpRequest();
    ajTriggerItemCreation.open("POST", "fnItemIdCreate.php", true);
    ajTriggerItemCreation.send(triggerItemCreation);


    ajTriggerItemCreation.onreadystatechange = function() {
        if (ajTriggerItemCreation.status === 200 && ajTriggerItemCreation.readyState === 4) {
            id.value = ajTriggerItemCreation.responseText;
            // document.getElementById('response_message').innerHTML = ajTriggerItemCreation.responseText;
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
        const rowIndex = currentRow.rowIndex; // This is 0-based index
        console.log("Row Index:", rowIndex); // Show 1-based index to user
        localStorage.setItem("row_index", rowIndex);
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
    let row = target.closest('tr');
    if (target.name == target.name) {
        let fieldname = target.name;
        row.querySelector(`input[name="${fieldname}"]`).select();

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

        if (fieldName == "design") {
            query =
                `select * from ${fieldName}s where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}'`;


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
        }
    } else if (target.name === "design[]" && event.key === "F4") {
        event.preventDefault();
        let fieldName = target.name.replace("[]", "");
        let value = target.value;
        let currentBranchId = document.getElementById("userBranchId").value;
        localStorage.setItem("purchase_return", "1")
        let get_item = new FormData();
        get_item.append("pr_get_item_f4", value);
        let aj = new XMLHttpRequest();
        aj.open("POST", "ajaxGetPurchaseReturnItem.php", true);
        aj.send(get_item);
        aj.onreadystatechange = function() {

            if (aj.status === 200 && aj.readyState === 4) {
                document.getElementById("response_message").innerHTML = aj.responseText;
            }
        }


    }
});




// $(document).on("keypress", ".design-field", function(e) {


//     if(e.key === "Enter"){
//         alert()
//         e.preventDefault();
//         let currentRow = $(this).closest("tr");
//         // Check if it's the last row
//         let isLastRow = currentRow.is(":last-child");
//         if (isLastRow) {
//             // Add a new row
//             add_row();
//             // Focus on the product field of the newly added row
//             currentRow.next("tr").find('input[name="design[]"]').focus();
//         } else {
//             // Move focus to the product field in the next row
//             currentRow.next("tr").find('input[name="design[]"]').focus();
//         }
//     }
// });


function add_row() {
    let totalRows = localStorage.getItem("total_rows");
    totalRows = parseInt(totalRows) + 1;
    localStorage.setItem("total_rows", totalRows);

    let i = parseInt(localStorage.getItem("row_index")) + 1;
    const currentRows = document.querySelectorAll('#table_body tr');
    const lastRow = currentRows[currentRows.length - 1]; // Get the last row
    const newRowIndex = currentRows.length + 1;

    // Create new row
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
         <td>
                    <input type="text" class="serial-field" name="serialNumber[]" id="serialNumber_${i}" 
                               style="background-color:#212529;color:white;width:45px; height:25px; text-align:center;" maxlength="4" autocomplete="off" value="1" readonly />
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
                               style="width:70px; height:25px; text-align:center;" maxlength="12" />
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

    // Copy values from the last row
    if (lastRow) {
        newRow.querySelectorAll("input").forEach((input) => {
            let fieldName = input.name;

            let lastValue = lastRow.querySelector(`[name="${fieldName}"]`).value || "";
            // input.value = lastValue; // Copy the value from the last row

        });
    }

    document.querySelector('#table_body').appendChild(newRow);
    // ✅ Set the value for serialNumber explicitly after appending the row

    newRow.querySelector(`#serialNumber_${i}`).value = i;

    // Log the new row index
    console.log("New row added at index:", newRowIndex);
    localStorage.setItem("row_index", newRowIndex);

    // Focus on the new row's product field
    newRow.querySelector('input[name="design[]"]').focus();

}


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

    localStorage.setItem('supplier_state', '1');

    let supplierState = localStorage.getItem("supplier_state");

    document.getElementById("supplierName").value = "";


    document.getElementById("totalQty").value = 0;
    document.getElementById("totalAmount").value = 0;
    document.getElementById("cgstAmount").value = 0;
    document.getElementById("sgstAmount").value = 0;
    document.getElementById("igstAmount").value = 0;
    document.getElementById("addOnAmount").value = 0;
    document.getElementById("deductionAmount").value = 0;
    document.getElementById("netAmount").value = 0;
    document.getElementById("netDiscountPercent").value = 0;
    document.getElementById("cgstAmount").style.background = 'gainsboro';
    document.getElementById("sgstAmount").style.background = 'gainsboro';
    document.getElementById("igstAmount").style.background = 'gainsboro';







    document.getElementById('submitButton').disabled = true;

    // if(supplierState === "1"){

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
    document.getElementById("purchaseReturnDate").value = currentDate;


    // document.getElementById("purchaseReturnNumber").value = '<?php echo htmlspecialchars($purchase_return_no); ?>';

    document.getElementById("supplierName").focus();
}
let rowIndex = localStorage.getItem("row_index");


setTimeout(() => {


}, 10);

function validateAmounts() {

    let netAmount = parseFloat(document.getElementById("netAmount").value) || 0;

    if (netAmount >= 0) {

        document.getElementById("submitButton").disabled = false;
    } else {
        document.getElementById("submitButton").disabled = true;
    }

}


if (netAmount >= 0) {

    document.getElementById("submitButton").disabled = false;
} else {
    document.getElementById("submitButton").disabled = true;
}
document.getElementById("cgstAmount").addEventListener("focusout", validateAmounts);
document.getElementById("sgstAmount").addEventListener("focusout", validateAmounts);
document.getElementById("igstAmount").addEventListener("focusout", validateAmounts);
document.getElementById("addOnAmount").addEventListener("focusout", validateAmounts);
document.getElementById("deductionAmount").addEventListener("focusout", validateAmounts);








document.getElementById("table_body").addEventListener("input", function(event) {
    let target = event.target;

    if (target.name === "discountPercent[]") {
        // Allow only numbers and a single decimal point
        target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    } else if (target.name === "sellingPrice[]") {
        // Allow only numbers and a single decimal point
        target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');

    } else if (target.name === "discountAmount[]") {
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







document.getElementById("supplierName").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();

    }

})




document.getElementById("netDiscountPercent").addEventListener("focus", function(event) {

    document.getElementById('netDiscountPercent').select();

})

document.getElementById("addOnAmount").addEventListener("focus", function(event) {

    document.getElementById('addOnAmount').select();

})


document.getElementById("netDiscountPercent").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("deductionAmount").focus();
        document.getElementById("deductionAmount").select();
    }


})

document.getElementById("deductionAmount").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("addOnAmount").focus();
        document.getElementById("addOnAmount").select();
    }
})



document.getElementById("addOnAmount").addEventListener("keydown", function(event) {

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

if (isset($_POST['reprintButton'])) {

    $prNumber  =  $_POST['reprintPurchaseReturnNumber'];
    printPurchaseReturnBill($prNumber);
}



// if(isset($_POST['submit_button'])){

//     $supplierName            =  $_POST['supplierName'];
//     $supplierId              = $_POST['supplierId'];
//     $counterName             = $_POST['counterName'];




//     // $purchaseReturnDate = $_POST['purchaseReturnDate'];

//     date_default_timezone_set("Asia/Kolkata");
//     $purchaseReturnDate = date("Y-m-d H:i:s A");


//     // echo "current data and time  = ".$purchaseReturnDate;

//     $netAmount = $_POST['netAmount'];
//     // Sales Item  Grid Attributes Start
//     $design                         = $_POST['design'];
//     $pr_Number                   = $_POST['purchaseReturnNumber'];
//     // echo "prr_number = ".$pr_Number;
//     // echo "<br>";
//     // $purchaseReturnDate                     = $_POST['purchaseReturnDate'];
//     $pr_ItemId                   = $_POST['id'];
//     $sales_salesPersonNumber        = $_POST['salesMan'];            
//     $pr_ItemTax                  = $_POST['tax'];
//     $pr_ItemQty                  = $_POST['qty'];
//     $sales_itemDiscountPercent      = $_POST['discountPercent'];
//     $sales_itemDiscountAmount       = $_POST['discountAmount'];
//     $pr_itemAmount               = $_POST['amount'];
//     $sales_itemActualAmount         = $_POST['actualAmount'];
//     $sales_itemTaxableAmount        = $_POST['taxable'];
//     $sales_itemTaxAmount            = $_POST['taxAmount'];
//     $pr_serialNumber             = $_POST['serialNumber'];

//     // Sales Item  Grid Attributes End


//     // Sales Bill  Attribute Total
//     $prQty                = $_POST['totalQty'];
//     $prTotalAmount        = $_POST['totalAmount'];
//     $salesTotalActualAmount  = $_POST['totalActualAmount'];
//     $salesTotalTaxableAmount = $_POST['totalTaxable'];
//     $salesTotalTaxAmount     = $_POST['totalTaxAmount'];
//     $prcgstAmount         = isset($_POST['cgstAmount']) ? $_POST['cgstAmount'] : 0;
//     $prsgstAmount         = isset($_POST['sgstAmount']) ? $_POST['sgstAmount'] : 0;
//     $prigstAmount         = isset($_POST['igstAmount']) ? $_POST['igstAmount'] : 0;
//     $prAddonAmount        = isset($_POST['addOnAmount'])? $_POST['addOnAmount'] : 0;
//     $prDeductionAmount    = isset($_POST['deductionAmount']) ? $_POST['deductionAmount'] : 0;
//     $salesReturnAmount       = isset($_POST['salesReturnNetAmount']) ? $_POST['salesReturnNetAmount'] : 0;
//     $prNetAmount          = isset($_POST['netAmount']) ? $_POST['netAmount'] : 0;

//     // echo $prcgstAmount     ;
//     // echo "<br>";
//     // echo $prsgstAmount     ;
//     // echo "<br>";
//     // echo $prigstAmount     ;
//     // echo "<br>";
//     // echo $prAddonAmount    ;
//     // echo "<br>";
//     // echo $prDeductionAmount;
//     // echo "<br>";
//     // echo $salesReturnAmount   ;
//     // echo "<br>";
//     // echo $prNetAmount      ;
//     // echo "<br>";






//     if($netAmount>=0 && $design[0] != ''){
//             // echo "iam in";

//             // $purchaseReturnNumber = $_POST['purchaseReturnNumber'];
//             // $purchaseReturnDate = $_POST['purchaseReturnDate'];
//             $querySearchPurchaseReturnNumber = "select*from sno_master where
//                                      financial_year = '$financial_year' && branch_id = '$userBranchId'";
//             $resultSearchPurchaseReturnNumber  = $con->query($querySearchPurchaseReturnNumber);

//             if($resultSearchPurchaseReturnNumber->num_rows==0){
//                 $currentPurchaseReturnNumber = $_POST['purchaseReturnNumber'];
//             }else{
//                 $sales = $resultSearchPurchaseReturnNumber->fetch_assoc();
//                 $currentPurchaseReturnNumber = $sales['purchase_return_no']+1;
//             }
//             // echo "supplier name  =".$supplierName;
//             // echo "<br>";
//             // echo "supplier id =  ".$supplierId;
//             // echo "<br>";
//             // echo "current GRN number = ".$currentPurchaseReturnNumber;
//             // echo "<br>";
//             $querySearchSnoMaster = "update sno_master set purchase_return_no = '$currentPurchaseReturnNumber'
//                                      where financial_year = '$financial_year' && branch_id = '$userBranchId'";
//             $resultSearchSnoMaster = $con->query($querySearchSnoMaster);        




//             // if(($netAmount - $totalAmount) != 0 ){
//             //     $percent = round((($netAmount-$totalAmount)/$totalAmount)*100,2);
//             // }else{
//             //     $percent = 0;
//             // }




//             $percent = round((($prDeductionAmount -$prAddonAmount     )/$prTotalAmount)*100,4);



//         $a=0;
//         $itemActualAmount = 0;
//         $itemTaxPercentage = 0;
//         $itemTaxableAmount = 0;
//         $itemTaxAmount = 0;
//         $billActualAmount =0;
//         $billTaxableAmount=0;
//         $billTaxAmount    =0;
//         $billIgstAmount = 0;
//         $billCgstAmount = 0;
//         $billSgstAmount = 0;

//         foreach($design as $des){

//             $itemActualAmount = round($pr_itemAmount[$a]-(($pr_itemAmount[$a]*$percent)/100),2);
//             $itemTaxPercentage =  str_replace("G","",$pr_ItemTax[$a]);            
//             $itemTaxableAmount = round((($itemActualAmount/($itemTaxPercentage+100))*100),2);
//             $itemTaxAmount = round(($itemTaxableAmount*$itemTaxPercentage)/100,2);

//             $querySearchLandCostAndMargin = "select*from purchase_item where item_id = '$pr_ItemId[$a]'
//             && branch_id = '$userBranchId'";
//             $resultSearchLandCostAndMargin = $con->query($querySearchLandCostAndMargin)->fetch_assoc();

//             $landCost = $resultSearchLandCostAndMargin['land_cost'];
//             $margin  = $resultSearchLandCostAndMargin['margin'];


//             $queryPurchaseReturnItem = "insert into purchase_return_item (pr_grn_number, pr_grn_date,
//                                 counter_name,pr_item_id,pr_item_qty,pr_item_amount,pr_land_cost,pr_margin,pr_s_no,branch_id)
//             values('$pr_Number','$purchaseReturnDate','$counterName','$pr_ItemId[$a]'
//             ,'$pr_ItemQty[$a]','$pr_itemAmount[$a]','$landCost','$margin','$pr_serialNumber[$a]',
//             '$userBranchId')";

//             $resultQuery = $con->query($queryPurchaseReturnItem);        



//             $queryStockTransaction = "insert into stock_transaction (grn_number, grn_date,
//             counter_name,item_id,item_qty,land_cost,entry_type,branch_id)
//             values('$pr_Number','$purchaseReturnDate','$counterName','$pr_ItemId[$a]','$pr_ItemQty[$a]',
//                    '$landCost','PR','$userBranchId')";

//             $resultStockTransaction = $con->query($queryStockTransaction);

//                         $queryStockBalance = "update stock_balance set item_qty = item_qty-$pr_ItemQty[$a]
//                         where item_id = '$pr_ItemId[$a]' and branch_id = '$userBranchId'";

//                         $resultStockBalance = $con->query($queryStockBalance);

//                         $billActualAmount =$billActualAmount+$itemActualAmount;  
//                         $billTaxableAmount=$billTaxableAmount+$itemTaxableAmount; 
//                         $billTaxAmount    =$billTaxAmount+$itemTaxAmount;     
//                     $a++;            
//         }

//         if($prigstAmount>0){

//           $billIgstAmount = $billTaxAmount;     
//           $billCgstAmount =0;
//           $billSgstAmount =0;
//         }else{
//             $billIgstAmount =0;
//             $billCgstAmount = $billTaxAmount/2;     
//             $billSgstAmount = $billTaxAmount/2;     

//         }

//         $queryInsertPurchaseReturnSummary = "insert into purchase_return_summary (pr_grn_number,pr_grn_date,counter_name,supplier_id,
//                   pr_total_qty,pr_total_amount,pr_cgst_amount,pr_sgst_amount,pr_igst_amount,pr_addon,pr_deduction,
//                   pr_net_amount,user_id,branch_id)
//                   values('$currentPurchaseReturnNumber','$purchaseReturnDate','$counterName','$supplierId',
//                   '$prQty','$prTotalAmount','$billCgstAmount','$billSgstAmount',
//                   '$billIgstAmount','$prAddonAmount','$prDeductionAmount',
//                   '$prNetAmount','$userId','$userBranchId')";



//         $resultInsertPurchaseReturnSummary = $con->query($queryInsertPurchaseReturnSummary);

//                 // $resultStockBalance = $con->query($queryStockBalance);


//                 if($resultQuery){

//                     $_SESSION['notification'] = "Purchase Return Saved Successfully";            
//                     header("Location:".BASE_URL."/pages/purchaseReturnEntry.php");
//                     $_SESSION['printPurchaseReturn'] = $_POST['printPurchaseReturn'];



//             }else{
//                 echo "something went wrong";
//             }


//     }

//     if(isset($_SESSION['printPurchaseReturn'])){

//         $prNumber  =  $_POST['purchaseReturnNumber'];
//         printPurchaseReturnBill($prNumber);
//     }        





// }


if (isset($_POST['submit_button'])) {
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();

        $supplierName = $_POST['supplierName'];
        $supplierId = $_POST['supplierId'];
        $counterName = $_POST['counterName'];

        date_default_timezone_set("Asia/Kolkata");
        $purchaseReturnDate = date("Y-m-d H:i:s A");

        $netAmount = $_POST['netAmount'];
        $design = $_POST['design'];
        $pr_Number = $_POST['purchaseReturnNumber'];
        $pr_ItemId = $_POST['id'];
        $sales_salesPersonNumber = $_POST['salesMan'];
        $pr_ItemTax = $_POST['tax'];
        $pr_ItemQty = $_POST['qty'];
        $sales_itemDiscountPercent = $_POST['discountPercent'];
        $sales_itemDiscountAmount = $_POST['discountAmount'];
        $pr_itemAmount = $_POST['amount'];
        $sales_itemActualAmount = $_POST['actualAmount'];
        $sales_itemTaxableAmount = $_POST['taxable'];
        $sales_itemTaxAmount = $_POST['taxAmount'];
        $pr_serialNumber = $_POST['serialNumber'];

        $prQty = $_POST['totalQty'];
        $prTotalAmount = $_POST['totalAmount'];
        $salesTotalActualAmount = $_POST['totalActualAmount'];
        $salesTotalTaxableAmount = $_POST['totalTaxable'];
        $salesTotalTaxAmount = $_POST['totalTaxAmount'];
        $prcgstAmount = isset($_POST['cgstAmount']) ? $_POST['cgstAmount'] : 0;
        $prsgstAmount = isset($_POST['sgstAmount']) ? $_POST['sgstAmount'] : 0;
        $prigstAmount = isset($_POST['igstAmount']) ? $_POST['igstAmount'] : 0;
        $prAddonAmount = isset($_POST['addOnAmount']) ? $_POST['addOnAmount'] : 0;
        $prDeductionAmount = isset($_POST['deductionAmount']) ? $_POST['deductionAmount'] : 0;
        $salesReturnAmount = isset($_POST['salesReturnNetAmount']) ? $_POST['salesReturnNetAmount'] : 0;
        $prNetAmount = isset($_POST['netAmount']) ? $_POST['netAmount'] : 0;

        if ($netAmount >= 0 && $design[0] != '') {
            $querySearchPurchaseReturnNumber = "SELECT * FROM sno_master WHERE financial_year = '$financial_year' AND branch_id = '$userBranchId'";
            $resultSearchPurchaseReturnNumber = $con->query($querySearchPurchaseReturnNumber);

            if ($resultSearchPurchaseReturnNumber->num_rows == 0) {
                $currentPurchaseReturnNumber = $_POST['purchaseReturnNumber'];
            } else {
                $sales = $resultSearchPurchaseReturnNumber->fetch_assoc();
                $currentPurchaseReturnNumber = $sales['purchase_return_no'] + 1;
            }

            $querySearchSnoMaster = "UPDATE sno_master SET purchase_return_no = '$currentPurchaseReturnNumber' WHERE financial_year = '$financial_year' AND branch_id = '$userBranchId'";
            $con->query($querySearchSnoMaster);

            $percent = round((($prDeductionAmount - $prAddonAmount) / $prTotalAmount) * 100, 4);

            $a = 0;
            $billActualAmount = $billTaxableAmount = $billTaxAmount = 0;

            foreach ($design as $des) {
                $itemActualAmount = round($pr_itemAmount[$a] - (($pr_itemAmount[$a] * $percent) / 100), 2);
                $itemTaxPercentage = str_replace("G", "", $pr_ItemTax[$a]);
                $itemTaxableAmount = round((($itemActualAmount / ($itemTaxPercentage + 100)) * 100), 2);
                $itemTaxAmount = round(($itemTaxableAmount * $itemTaxPercentage) / 100, 2);

                $querySearchLandCostAndMargin = "SELECT * FROM purchase_item WHERE item_id = '{$pr_ItemId[$a]}' AND branch_id = '$userBranchId'";
                $resultSearchLandCostAndMargin = $con->query($querySearchLandCostAndMargin)->fetch_assoc();
                $landCost = $resultSearchLandCostAndMargin['land_cost'];
                $margin = $resultSearchLandCostAndMargin['margin'];

                $queryPurchaseReturnItem = "INSERT INTO purchase_return_item (pr_grn_number, pr_grn_date, counter_name, pr_item_id, pr_item_qty, pr_item_amount, pr_land_cost, pr_margin, pr_s_no, branch_id)
                VALUES ('$pr_Number','$purchaseReturnDate','$counterName','{$pr_ItemId[$a]}','{$pr_ItemQty[$a]}','{$pr_itemAmount[$a]}','$landCost','$margin','{$pr_serialNumber[$a]}','$userBranchId')";
                $con->query($queryPurchaseReturnItem);

                $queryStockTransaction = "INSERT INTO stock_transaction (grn_number, grn_date, counter_name, item_id, item_qty, land_cost, entry_type, branch_id)
                VALUES ('$pr_Number','$purchaseReturnDate','$counterName','{$pr_ItemId[$a]}','{$pr_ItemQty[$a]}','$landCost','PR','$userBranchId')";
                $con->query($queryStockTransaction);

                $queryStockBalance = "UPDATE stock_balance SET item_qty = item_qty - {$pr_ItemQty[$a]} WHERE item_id = '{$pr_ItemId[$a]}' AND branch_id = '$userBranchId'";
                $con->query($queryStockBalance);

                $billActualAmount += $itemActualAmount;
                $billTaxableAmount += $itemTaxableAmount;
                $billTaxAmount += $itemTaxAmount;

                $a++;
            }

            if ($prigstAmount > 0) {
                $billIgstAmount = $billTaxAmount;
                $billCgstAmount = 0;
                $billSgstAmount = 0;
            } else {
                $billIgstAmount = 0;
                $billCgstAmount = $billTaxAmount / 2;
                $billSgstAmount = $billTaxAmount / 2;
            }

            $queryInsertPurchaseReturnSummary = "INSERT INTO purchase_return_summary (pr_grn_number, pr_grn_date, counter_name, supplier_id,
              pr_total_qty, pr_total_amount, pr_cgst_amount, pr_sgst_amount, pr_igst_amount, pr_addon, pr_deduction,
              pr_net_amount, user_id, branch_id)
              VALUES ('$currentPurchaseReturnNumber','$purchaseReturnDate','$counterName','$supplierId',
              '$prQty','$prTotalAmount','$billCgstAmount','$billSgstAmount',
              '$billIgstAmount','$prAddonAmount','$prDeductionAmount',
              '$prNetAmount','$userId','$userBranchId')";
            $con->query($queryInsertPurchaseReturnSummary);

            $con->commit();

            $_SESSION['notification'] = "Purchase Return Saved Successfully";
            $_SESSION['printPurchaseReturn'] = $_POST['printPurchaseReturn'];
            header("Location:" . BASE_URL . "/pages/purchaseReturnEntry.php");
            exit;
        }

        if (isset($_SESSION['printPurchaseReturn'])) {
            $prNumber = $_POST['purchaseReturnNumber'];
            printPurchaseReturnBill($prNumber);
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

function printPurchaseReturnBill($prNumber)
{

    $_SESSION['pr_number'] = $prNumber;
    header("Location:" . BASE_URL . "/exportFile/pdfFilePurchaseReturnBIllPrint.php");
    exit();
}

?>


<?php include_once(DIR_URL . "/includes/footer.php"); ?>
<?php ob_end_flush(); ?>