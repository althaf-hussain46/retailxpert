<style>

</style>
<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

use function PHPSTORM_META\type;

ob_start();
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

$counterName = $_SESSION['counter_name'];
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
#purchaseEntry {

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
    width: 400px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
    background-color: blanchedalmond;
}

#supplierId {
    margin-top: -120px;
    /* margin-left:300px; */
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
    font-size: 13px;
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
                    <div class="form-floating">
                        <input type="text" name="grnNumber" id="grnNumber" readonly class="form-control"
                            placeholder="Goods Receipt Number" value="<?php echo $purchase_no; ?>" autocomplete="off"
                            maxlength="30">
                        <label for="grnNumber" style="margin-left:6px;margin-top:12px;">GRN</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" name="grnDate" readonly id="grnDate" class="form-control"
                            placeholder="GRN Date " value="" maxlength="30">
                        <label for="GRNDate" style="margin-left:15px;margin-top:15px;">GRN Date</label>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <div style="display:flex;gap:10px">
                    <div class="form-floating">
                        <input type="text" name="dcNumber" id="dcNumber" class="form-control" placeholder="DC Number"
                            value="" autocomplete="off" maxlength="20">
                        <label for="DCNumber" style="margin-top:-10px">DC Number</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" name="dcDate" id="dcDate" class="form-control" placeholder="DC Date" value=""
                            autocomplete="off" maxlength="20">
                        <label for="DCDate" style="margin-top:-10px">DC Date</label>
                    </div>
                </div>
                <div style="margin-top:5px;">
                </div>
                <div style="display:flex;gap:10px;">
                    <div class="form-floating">
                        <input type="text" name="invoiceNumber" id="invoiceNumber" class="form-control"
                            placeholder="Invoice Number" value="" autocomplete="off" maxlength="30">
                        <label for="invoiceNumber" style="margin-top:-10px">Invoice Number</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" name="invoiceDate" id="invoiceDate" class="form-control"
                            placeholder="Invoice Date" value="" autocomplete="off">
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
                placeholder="Press F2 For Supplier Info">
            <input type="text" name="supplierId" id="supplierId" class="form-control">
            <label for="" id="purchaseEntry">PURCHASE ENTRY</label>
        </div>
        <br>
        <div style="display:flex;gap:23px;">
            <label for="" style="margin-left:280px;margin-top:-98px">GRN Amount</label>
            <input type="text" name="grnAmount" id="grnAmount" style="" class="form-control" autocomplete="off"
                maxlength="12">
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
                        <tr>
                            <td>
                                <input type="text" class="serial-field" name="serialNumber[]" id="serialNumber_1"
                                    style="font-size:12px;height:25px;width:40px;margin-left:1px;" maxlength="4"
                                    autocomplete="off" value="1" readonly />
                            </td>

                            <td>
                                <!--background-image: linear-gradient(225deg, #FF3CAC 50%, #784BA0 50%, #2B86C5 50%);opacity:0.60-->
                                <input type="text" class="product-field form" name="product[]" id="product_1"
                                    autocomplete="off" style="font-size:12px;height:25px;width:100px;margin-left:-9px;background-color: #FF3CAC;
                        background-image: linear-gradient(225deg, white 50%, blanchedalmond 50%);" maxlength="30" placeholder="Press F4 For Item Info" />
                            </td>
                            <td>
                                <input type="text" class="brand-field" name="brand[]" id="brand_1" autocomplete="off"
                                    style="font-size:12px;height:25px;width:120px;margin-left:-2px;background-color:blanchedalmond;"
                                    maxlength="30" />
                            </td>
                            <td>
                                <input type="text" class="design-field" name="design[]" id="design_1" autocomplete="off"
                                    style="font-size:13px;height:25px;width:140px;margin-left:0px;background-color:blanchedalmond;"
                                    maxlength="30" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="color[]" id="color_1" autocomplete="off"
                                    style="font-size:13px;height:25px;width:80px;margin-left:0px;background-color:blanchedalmond;"
                                    maxlength="30" />
                            </td>
                            <td>
                                <input type="text" class="design-field" name="batch[]" id="batch_1" autocomplete="off"
                                    style="font-size:13px;height:25px;width:120px;margin-left:0px;background-color:blanchedalmond;"
                                    maxlength="30" />
                            </td>
                            <td>
                                <input type="text" class="design-field" name="category[]" id="category_1"
                                    autocomplete="off"
                                    style="font-size:13px;height:25px;width:80px;margin-left:-2px;background-color:blanchedalmond;"
                                    maxlength="30" />
                            </td>
                            <td>
                                <input type="text" class="design-field" name="hsnCode[]" id="hsnCode_1"
                                    autocomplete="off"
                                    style="font-size:13px;height:25px;width:65px;margin-left:-6px;background-color:blanchedalmond;"
                                    maxlength="8" />
                            </td>
                            <td>


                                <input type="text" class="design-field" name="tax[]" id="tax_1"
                                    style="font-size:13px;height:25px;width:40px;margin-left:0px;background-color:blanchedalmond;"
                                    maxlength="4" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="size[]" id="size_1" autocomplete="off"
                                    style="font-size:13px;height:25px;width:50px;margin-left:0px;background-color:blanchedalmond;"
                                    maxlength="30" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="mrp[]" id="mrp_1" autocomplete="off"
                                    style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:0px;background-color:blanchedalmond;"
                                    maxlength="12" />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="sellingPrice[]" id="sellingPrice_1"
                                    autocomplete="off"
                                    style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:0px;"
                                    maxlength="12" />
                            </td>

                            <td>
                                <input type="text" class="rate-field" name="rate[]" id="rate_1" autocomplete="off"
                                    style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:-4px;"
                                    maxlength="12" />
                            </td>

                            <td>
                                <input type="text" class="qty-field" name="qty[]" id="qty_1" autocomplete="off"
                                    style="text-align:right;font-size:13px;height:25px;width:30px;margin-left:0px;"
                                    maxlength="5" oninput="calculateAmount()" />
                            </td>

                            <td>
                                <input type="text" class="amount-field" name="amount[]" id="amount_1" autocomplete="off"
                                    style="text-align:right;
                        height:25px;font-weight:bold;width:80px;
                        margin-left:-6px;background-color:#212529;
                        color:white;border:1px solid white;" maxlength="13" readonly />
                            </td>

                            <td>
                                <input type="text" class="design-field" name="id[]" id="id_1" readonly
                                    autocomplete="off"
                                    style="font-size:13px;height:25px;width:65px;margin-left:-4px;background-color:#212529;color:white;border:1px solid white;text-align:right;" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <button style="margin-left:180px;width:120px;" type="submit" class="btn btn-primary" name="submit_button"
            id="submitButton">
            Submit
        </button>

    </div>

    <div style="margin-left:1228px;margin-top:-45px">
        <div style="display:flex;gap:5px">
            <label for="" style="margin-left:-2px">Total</label>
            <input type="text" name="totalQty" id="totalQty" class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:50px;" maxlength="4">
            <input type="text" name="totalAmount" id="totalAmount" class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
        </div>
        <div style="display:flex;margin-top:2px;">
            <label for="">CGST</label>
            <input type="text" name="cgstAmount" id="cgstAmount" autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:48px" maxlength="12">
        </div>
        <div style="display:flex;margin-top:2px;">
            <label for="">SGST</label>
            <input type="text" name="sgstAmount" id="sgstAmount" autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:49px" maxlength="12">
        </div>
        <div style="display:flex;margin-top:2px;">
            <label for="">IGST</label>
            <input type="text" name="igstAmount" id="igstAmount" autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:54px" maxlength="12">
        </div>

        <div style="display:flex;margin-top:2px;">
            <label for="">Add On</label>
            <input type="text" name="addOnAmount" id="addOnAmount" autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:32px" maxlength="12">
        </div>

        <div style="display:flex;margin-top:3px;">
            <label for="">Deduction</label>
            <input type="text" name="deductionAmount" id="deductionAmount" autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:13px" maxlength="12">
        </div>

        <div style="display:flex;margin-top:2px;">
            <label for="">Net</label>
            <input type="text" name="netAmount" id="netAmount" class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:61px" maxlength="12">
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
window.onload = function() {
    localStorage.setItem("row_index", 1);
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
    // alert(rowIndex)
    for (let i = 1; i <= totalRow; i++) {

        eachRowQty = document.getElementById("qty_" + i).value || 0;
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

            validateAmounts();
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
            validateAmounts();
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
                    }
                }

            } else {
                // Move to the product field in the next row
                const nextRow = currentRow.nextElementSibling;
                if (nextRow) {
                    const productField = nextRow.querySelector('input[name="product[]"]');
                    if (productField) {
                        productField.focus();
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

// function add_row(){
//     let totalRows =localStorage.getItem("total_rows");
//     totalRows = parseInt(totalRows)+1
//     localStorage.setItem("total_rows", totalRows);
//     let i =parseInt(localStorage.getItem("row_index"))+1;
//     const currentRows = document.querySelectorAll('#table_body tr');
// const newRowIndex = currentRows.length + 1;

// // Add the new row using vanilla JS instead of jQuery
// const newRow = document.createElement('tr');
// newRow.innerHTML = `
//         <tr>
//             <td>
//                 <input
//                     type="text"
//                     class="serial-field"
//                     name="serialNumber[]"
//                     id="serialNumber_${i}"
//                     style="font-size:12px;height:25px;width:40px;margin-left:1px;"
//                     maxlength="4"
//                     autocomplete="off"

//                 />
//             </td>

//             <td>
//                 <input
//                     type="text"
//                     class="product-field"
//                     name="product[]"
//                     id="product_${i}"
//                     autocomplete="off"
//                     style="font-size:12px;height:25px;width:120px;margin-left:-9px;font-weight:bold"
//                     maxlength="30"
//                 />
//             </td>
//             <td>
//                 <input
//                     type="text" 
//                     class="brand-field"
//                     name="brand[]"
//                     id="brand_${i}"
//                     autocomplete="off"
//                     style="font-size:12px;height:25px;width:120px;margin-left:-9px;"
//                     maxlength="30"
//                 />
//             </td>
//             <td>
//                 <input
//                     type="text" 
//                     class="design-field"
//                     name="design[]"
//                     id="design_${i}"
//                     autocomplete="off"
//                     style="font-size:13px;height:25px;width:120px;margin-left:-9px;"
//                     maxlength="30"
//                 />
//             </td>

//             <td>
//                 <input
//                     type="text" 
//                     class="design-field"
//                     name="batch[]"
//                     id="batch_${i}"
//                     autocomplete="off"
//                     style="font-size:13px;height:25px;width:100px;margin-left:-9px;"
//                     maxlength="30"
//                 />
//             </td>
//             <td>
//                 <input
//                     type="text" 
//                     class="design-field"
//                     name="color[]"
//                     id="color_${i}"
//                     autocomplete="off"
//                     style="font-size:13px;height:25px;width:80px;margin-left:-9px;"
//                     maxlength="30"
//                 />
//             </td>
//             <td>
//                 <input
//                     type="text" 
//                     class="design-field"
//                     name="category[]"
//                     id="category_${i}"
//                     autocomplete="off"
//                     style="font-size:13px;height:25px;width:80px;margin-left:-8px;"
//                     maxlength="30"
//                 />
//             </td>
//             <td>
//                 <input
//                     type="text"
//                     class="design-field"
//                     name="hsnCode[]"
//                     id="hsnCode_${i}"
//                     autocomplete="off"
//                     style="font-size:13px;height:25px;width:70px;margin-left:-6px;"
//                     maxlength="8"
//                 />
//             </td>
//             <td>


//                 <input
//                     type="text" 
//                     class="design-field"
//                     name="tax[]"
//                     id="tax_${i}"
//                     style="font-size:13px;height:25px;width:50px;margin-left:-16px;"
//                     maxlength="4"
//                 />
//             </td>

//             <td>
//                 <input
//                     type="text" 
//                     class="design-field"
//                     name="size[]"
//                     id="size_${i}"
//                     autocomplete="off"
//                     style="font-size:13px;height:25px;width:50px;margin-left:-5px;"
//                     maxlength="30"
//                 />
//             </td>

//             <td>
//                 <input
//                     type="text" 
//                     class="design-field"
//                     name="mrp[]"
//                     id="mrp_${i}"
//                     autocomplete="off"
//                     style="text-align:right;font-size:13px;height:25px;width:80px;margin-left:-5px;"
//                     maxlength="12"
//                 />
//             </td>

//             <td>
//                 <input
//                     type="text" 
//                     class="design-field"
//                     name="sellingPrice[]"
//                     id="sellingPrice_${i}"
//                     autocomplete="off"
//                     style="text-align:right;font-size:13px;height:25px;width:80px;margin-left:-1px;"
//                     maxlength="12"
//                 />
//             </td>

//             <td>
//                 <input
//                     type="text" 
//                     class="design-field"
//                     name="rate[]"
//                     id="rate_${i}"
//                     autocomplete="off"
//                     style="text-align:right;font-size:13px;height:25px;width:80px;margin-left:0px;"
//                     maxlength="12"
//                 />
//             </td>

//             <td>
//                 <input
//                     type="text" 
//                     class="design-field"
//                     name="qty[]"
//                     id="qty_${i}"
//                     autocomplete="off"
//                     style="text-align:right;font-size:13px;height:25px;width:50px;margin-left:0px;"
//                     maxlength="5"
//                 />
//             </td>

//             <td>
//                 <input
//                     type="text" 
//                     class="design-field"
//                     name="amount[]"
//                     id="amount_${i}"
//                     autocomplete="off"
//                     style="text-align:right;font-size:15px;height:25px;font-weight:bold;width:100px;margin-left:-2px;"
//                     maxlength="13"
//                     disabled
//                 />
//             </td>

//             <td>
//                 <input
//                     type="text" 
//                     class="design-field"
//                     name="id[]"
//                     id="id_${i}"
//                     autocomplete="off"
//                     style="font-size:13px;height:25px;width:60px;margin-left:-3px;"

//                 />
//             </td>
//             <td>
//                 <button
//                     type="button" id="remove"
//                     class="btn btn-danger" title="Remove"
//                        style="font-size:8px;margin-left:1px;width:40px"
//                     >
//                     <i class="fa fa-trash"></i>
//                 </button>
//             </td>
//         </tr>
//     `;

//     document.querySelector('#table_body').appendChild(newRow);

// // Log the index of the new row
// console.log("New row added at index:", newRowIndex);
// localStorage.setItem("row_index", newRowIndex);

// // Focus on the new row's product field
// newRow.querySelector('input[name="product[]"]').focus();
//     }

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
            <input type="text" class="serial-field" name="serialNumber[]" id="serialNumber_${i}"  value="${i}"  style="font-size:12px;height:25px;width:40px;margin-left:1px;background-color:#212529;color:white;" maxlength="4" autocomplete="off" readonly/>
        </td>
        <td>
            <input type="text" class="product-field" name="product[]" id="product_${i}" autocomplete="off" 
            style="font-size:12px;height:25px;width:100px;margin-left:-9px;background-color: #FF3CAC;
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
            <input type="text" class="design-field" name="batch[]" id="batch_${i}" autocomplete="off"
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
    if (lastRow) {
        newRow.querySelectorAll("input").forEach((input) => {
            let fieldName = input.name;
            let lastValue = lastRow.querySelector(`[name="${fieldName}"]`).value;
            input.value = lastValue; // Copy the value from the last row
        });
    }

    document.querySelector('#table_body').appendChild(newRow);
    // ✅ Set the value for serialNumber explicitly after appending the row

    newRow.querySelector(`#serialNumber_${i}`).value = i;

    // Log the new row index
    console.log("New row added at index:", newRowIndex);
    localStorage.setItem("row_index", newRowIndex);

    // Focus on the new row's product field
    newRow.querySelector('input[name="product[]"]').focus();
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

    localStorage.setItem('supplier_state', '');

    document.getElementById("totalQty").value = 0;
    document.getElementById("totalAmount").value = 0;
    document.getElementById("cgstAmount").value = 0;
    document.getElementById("sgstAmount").value = 0;
    document.getElementById("igstAmount").value = 0;
    document.getElementById("addOnAmount").value = 0;
    document.getElementById("deductionAmount").value = 0;
    document.getElementById("netAmount").value = 0;
    document.getElementById("cgstAmount").style.background = 'gainsboro';
    document.getElementById("sgstAmount").style.background = 'gainsboro';
    document.getElementById("igstAmount").style.background = 'gainsboro';
    // document.getElementById("cgstAmount").setAttribute('readonly','true');
    // document.getElementById("sgstAmount").setAttribute('readonly','true');
    // document.getElementById("igstAmount").setAttribute('readonly','true');
    document.getElementById('submitButton').disabled = true;

    document.getElementById("cgstAmount").disabled = true;
    document.getElementById("sgstAmount").disabled = true;
    document.getElementById("igstAmount").disabled = true;


    localStorage.setItem("total_rows", 1);
    let mydate = new Date();
    let currentDate = mydate.getFullYear() + "-" +
        (mydate.getMonth() + 1).toString().padStart(2, "0") + "-" +
        mydate.getDate().toString().padStart(2, "0");
    document.getElementById("grnDate").value = currentDate;
    document.getElementById("dcDate").value = currentDate;
    document.getElementById("invoiceDate").value = currentDate;

    // document.getElementById("grnNumber").value = '<?php echo htmlspecialchars($purchase_no); ?>';

    document.getElementById("supplierName").focus();
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





document.getElementById("supplierName").addEventListener("keydown", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("grnAmount").focus();
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

// if(isset($_POST['submit_button'])){


//     $supplierName =  $_POST['supplierName'];
//     $supplierId = $_POST['supplierId'];
//     $grnAmount = $_POST['grnAmount'];
//     $netAmount = $_POST['netAmount'];

//     if($grnAmount != '' && $grnAmount != 0){

//     if($grnAmount == $netAmount){



//             $grnNumber = $_POST['grnNumber'];
//             date_default_timezone_set("Asia/Kolkata");
//             $currentTime = date('h:i:s A');
//             $grnDate = $_POST['grnDate']." ".$currentTime;
//             $dcNumber = $_POST['dcNumber'];
//             $dcDate = $_POST['dcDate'];
//             $invoiceNumber = $_POST['invoiceNumber'];
//             $invoiceDate = $_POST['invoiceDate'];


//             $querySearchGRNNumber = "select*from sno_master where purchase_no = '$grnNumber' && 
//                                      financial_year = '$financial_year' && branch_id = '$userBranchId'";
//             $resultSearchGRNNumber  = $con->query($querySearchGRNNumber);

//             if($resultSearchGRNNumber->num_rows==0){
//                 $currentGRNNumber = $_POST['grnNumber'];
//             }else{
//                 $grn = $resultSearchGRNNumber->fetch_assoc();
//                 $currentGRNNumber = $grn['purchase_no']+1;
//             }

//             echo "current GRN number = ".$currentGRNNumber;
//             echo "<br>";
//             $querySearchSnoMaster = "update sno_master set purchase_no = '$currentGRNNumber'
//                                      where financial_year = '$financial_year' && branch_id = '$userBranchId'";
//             $resultSearchSnoMaster = $con->query($querySearchSnoMaster);        

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

//             $query = "insert into purchase_summary (grn_number,grn_date,counter_name,supplier_id,grn_amount,
//                   dc_number,dc_date,invoice_number,invoice_date,total_qty,total_amount,
//                   cgst_amount,sgst_amount,igst_amount,addon,deduction,net_amount,user_id,branch_id)
//                   values('$currentGRNNumber','$grnDate','$counterName','$supplierId','$grnAmount','$dcNumber','$dcDate',
//                   '$invoiceNumber','$invoiceDate','$totalQty','$totalAmount','$cgst','$sgst',
//                   '$igst','$addOn','$deduction','$netAmount','$userId','$userBranchId')";


//         $resultQuery = $con->query($query);
//         if($resultQuery){
//             echo "purchase summary created";
//         }else{
//             echo "oops! something went wrong";
//         }


//         $a=0;

//         foreach($product as $pro){

//             $landCost = round($rate[$a]+(($rate[$a]*$percent)/100),2);
//             $margin = round((($sellingPrice[$a]-$landCost)/$sellingPrice[$a])*100,2);

//             $queryPurchaseItem = "insert into purchase_item (grn_number, grn_date,counter_name,
//             item_id,item_qty,item_amount,land_cost,margin,s_no,branch_id)
//             values('$currentGRNNumber','$grnDate','$counterName','$itemId[$a]','$itemQty[$a]','$itemAmount[$a]',
//                    '$landCost','$margin','$serialNumber[$a]', '$userBranchId')";

//             $resultQuery = $con->query($queryPurchaseItem);        


//             $queryStockTransaction = "insert into stock_transaction (grn_number, grn_date,counter_name,
//             item_id,item_qty,land_cost,entry_type,branch_id)
//             values('$currentGRNNumber','$grnDate','$counterName','$itemId[$a]','$itemQty[$a]',
//                    '$landCost','P','$userBranchId')";
//             $resultStockTransaction = $con->query($queryStockTransaction);


//                 $querySearchStockBalance = "select*from stock_balance where item_id = '$itemId[$a]'
//                                             and branch_id = '$userBranchId'";
//                 $resultSearchStockBalance = $con->query($querySearchStockBalance);

//                 if($resultSearchStockBalance->num_rows==0){
//                     echo "item id from stock balance table = ";
//                     echo "<br>";

//                     $queryStockBalance = "insert into stock_balance(item_id,item_qty,branch_id) values('$itemId[$a]','$itemQty[$a]','$userBranchId')";                
//                     $resultStockBalance = $con->query($queryStockBalance);                    


//                 }else{
//                     echo "<br>";
//                     echo "item is there";
//                     echo "<br>";


//                         $queryStockBalance = "update stock_balance set item_qty = item_qty+'$itemQty[$a]'
//                         where item_id = '$itemId[$a]' and branch_id = '$userBranchId'";
//                         $resultStockBalance = $con->query($queryStockBalance);


//                     };

//                     $a++;            

//         }
//                 // $resultStockBalance = $con->query($queryStockBalance);


//             if($resultQuery){

//                 $_SESSION['notification'] = "Purchase Saved Successfully";            
//                 header("Location:".BASE_URL."/pages/purchaseEntry.php");

//             }else{
//                 echo "something went wrong";
//             }


//     }else{
//         $_SESSION['notification'] = "GRN Amount And Net Amount Does Not Match";
//         header("Location:".BASE_URL."/pages/purchaseEntry.php");
//         echo '<script>
//       document.addEventListener("DOMContentLoaded", function() {
//           let toastElement = new bootstrap.Toast(document.getElementById("liveToast"));
//           toastElement.show();
//       });
//     </script>';



//         }
//    }  
// }

if (isset($_POST['submit_button'])) {
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();

        $supplierName = $_POST['supplierName'];
        $supplierId = $_POST['supplierId'];
        $grnAmount = $_POST['grnAmount'];
        $netAmount = $_POST['netAmount'];

        if ($grnAmount != '' && $grnAmount != 0) {
            if ($grnAmount == $netAmount) {

                $grnNumber = $_POST['grnNumber'];
                date_default_timezone_set("Asia/Kolkata");
                $currentTime = date('h:i:s A');
                $grnDate = $_POST['grnDate'] . " " . $currentTime;
                $dcNumber = $_POST['dcNumber'];
                $dcDate = $_POST['dcDate'];
                $invoiceNumber = $_POST['invoiceNumber'];
                $invoiceDate = $_POST['invoiceDate'];

                $querySearchGRNNumber = "SELECT * FROM sno_master WHERE purchase_no = ? AND financial_year = ? AND branch_id = ?";
                $stmt = $con->prepare($querySearchGRNNumber);
                $stmt->bind_param("sss", $grnNumber, $financial_year, $userBranchId);
                $stmt->execute();
                $resultSearchGRNNumber = $stmt->get_result();

                if ($resultSearchGRNNumber->num_rows == 0) {
                    $currentGRNNumber = $grnNumber;
                } else {
                    $grn = $resultSearchGRNNumber->fetch_assoc();
                    $currentGRNNumber = $grn['purchase_no'] + 1;
                }

                $querySearchSnoMaster = "UPDATE sno_master SET purchase_no = ? WHERE financial_year = ? AND branch_id = ?";
                $stmt = $con->prepare($querySearchSnoMaster);
                $stmt->bind_param("sss", $currentGRNNumber, $financial_year, $userBranchId);
                $stmt->execute();

                $serialNumber = $_POST['serialNumber'];
                $product = $_POST['product'];
                $brand = $_POST['brand'];
                $design = $_POST['design'];
                $batch = $_POST['batch'];
                $color = $_POST['color'];
                $hsnCode = $_POST['hsnCode'];
                $category = $_POST['category'];
                $tax = $_POST['tax'];
                $size = $_POST['size'];
                $mrp = $_POST['mrp'];
                $sellingPrice = $_POST['sellingPrice'];
                $rate = $_POST['rate'];
                $itemQty = $_POST['qty'];
                $itemAmount = $_POST['amount'];
                $itemId = $_POST['id'];

                $totalQty = $_POST['totalQty'];
                $totalAmount = $_POST['totalAmount'];
                $cgst = $_POST['cgstAmount'] ?? 0;
                $sgst = $_POST['sgstAmount'] ?? 0;
                $igst = $_POST['igstAmount'] ?? 0;
                $addOn = $_POST['addOnAmount'];
                $deduction = $_POST['deductionAmount'];

                $percent = ($netAmount - $totalAmount) != 0 ? round((($netAmount - $totalAmount) / $totalAmount) * 100, 2) : 0;

                $query = "INSERT INTO purchase_summary (grn_number, grn_date, counter_name, supplier_id, grn_amount, dc_number, dc_date, invoice_number, invoice_date, total_qty, total_amount, cgst_amount, sgst_amount, igst_amount, addon, deduction, net_amount, user_id, branch_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($query);
                $stmt->bind_param("sssssssssssssssssss", $currentGRNNumber, $grnDate, $counterName, $supplierId, $grnAmount, $dcNumber, $dcDate, $invoiceNumber, $invoiceDate, $totalQty, $totalAmount, $cgst, $sgst, $igst, $addOn, $deduction, $netAmount, $userId, $userBranchId);
                $stmt->execute();

                $a = 0;
                foreach ($product as $pro) {
                    $landCost = round($rate[$a] + (($rate[$a] * $percent) / 100), 2);
                    $margin = round((($sellingPrice[$a] - $landCost) / $sellingPrice[$a]) * 100, 2);

                    $queryPurchaseItem = "INSERT INTO purchase_item (grn_number, grn_date, counter_name, item_id, item_qty, item_amount, land_cost, margin, s_no, branch_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $con->prepare($queryPurchaseItem);
                    $stmt->bind_param("ssssssssss", $currentGRNNumber, $grnDate, $counterName, $itemId[$a], $itemQty[$a], $itemAmount[$a], $landCost, $margin, $serialNumber[$a], $userBranchId);
                    $stmt->execute();

                    $queryStockTransaction = "INSERT INTO stock_transaction (grn_number, grn_date, counter_name, item_id, item_qty, land_cost, entry_type, branch_id) VALUES (?, ?, ?, ?, ?, ?, 'P', ?)";
                    $stmt = $con->prepare($queryStockTransaction);
                    $stmt->bind_param("sssssss", $currentGRNNumber, $grnDate, $counterName, $itemId[$a], $itemQty[$a], $landCost, $userBranchId);
                    $stmt->execute();

                    $querySearchStockBalance = "SELECT * FROM stock_balance WHERE item_id = ? AND branch_id = ?";
                    $stmt = $con->prepare($querySearchStockBalance);
                    $stmt->bind_param("ss", $itemId[$a], $userBranchId);
                    $stmt->execute();
                    $resultSearchStockBalance = $stmt->get_result();

                    if ($resultSearchStockBalance->num_rows == 0) {
                        $queryStockBalance = "INSERT INTO stock_balance(item_id, item_qty, branch_id) VALUES (?, ?, ?)";
                        $stmt = $con->prepare($queryStockBalance);
                        $stmt->bind_param("sss", $itemId[$a], $itemQty[$a], $userBranchId);
                        $stmt->execute();
                    } else {
                        $queryStockBalance = "UPDATE stock_balance SET item_qty = item_qty + ? WHERE item_id = ? AND branch_id = ?";
                        $stmt = $con->prepare($queryStockBalance);
                        $stmt->bind_param("sss", $itemQty[$a], $itemId[$a], $userBranchId);
                        $stmt->execute();
                    }
                    $a++;
                }

                $con->commit();
                $_SESSION['notification'] = "Purchase Saved Successfully";
                header("Location:" . BASE_URL . "/pages/purchaseEntry.php");
                exit;
            } else {
                $_SESSION['notification'] = "GRN Amount And Net Amount Does Not Match";
                header("Location:" . BASE_URL . "/pages/purchaseEntry.php");
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        let toastElement = new bootstrap.Toast(document.getElementById("liveToast"));
                        toastElement.show();
                    });
                </script>';
            }
        }
    } catch (mysqli_sql_exception $e) {
        $con->rollback();
        $_SESSION['notification'] = "Oops! Something Went Wrong: " . $e->getMessage();
    }
}






// try {
//     if ($totalAmount != 0) {
//         $percent = round((($netAmount - $totalAmount) / $totalAmount) * 100, 2);
//     } else {
//         $percent = 0; // Or handle it differently
//     }
// } catch (Exception $e) {
//     // Log error or handle it gracefully
// }









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
// print_r($category);
// echo "<br>";
// print_r($hsnCode);
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
// print_r($qty);
// echo "<br>";
// echo "amount ";
// print_r($amount);
// echo "<br>";
// print_r($totalQty);
// echo "<br>";
// print_r($totalAmount);
// echo "<br>";
// print_r($cgst);
// echo "<br>";
// print_r($sgst);
// echo "<br>";
// print_r($igst);
// echo "<br>";
// print_r($addOn);
// echo "<br>";
// print_r($deduction);
// echo "<br>";
// print_r($netAmount);
// echo "</pre>";


// echo $supplierName;
// echo "<pre>";
// print_r($product);


?>


<?php ob_end_flush(); ?>
<?php include_once(DIR_URL . "/includes/footer.php"); ?>