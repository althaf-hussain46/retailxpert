<!-- when i press f2 in grnNumber text field , purchaseSummaryTable popup using ajax showing purchase summary of different grn numbers. when i select any particular row from purchaseSummaryTable all the data from purchase_item pertaining to  that grn number should display  in itemGrid.this code i have written for one row but i want all rows to be append in the itemGrid automatically -->
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


$d = 1;
$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$financial_year = $_SESSION['financial_year'];
$companyState = $_SESSION['company_state'];
$counterName = $_SESSION['counter_name'];

// if(isset($_SESSION['grn_number'])){
//     echo "grn_number = ".$_SESSION['grn_number'];
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
// $resultSearchPurchaseItem= ""; 

if (isset($_POST['grnNumberSearchButton'])) {

    extract($_POST);
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
    $_SESSION['resultSearchPurchaseSummaryItem'] = $resultSearchPurchaseItem->fetch_all(MYSQLI_ASSOC);

    while ($data = $resultSearchPurchaseItem->fetch_assoc()) {
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


        echo $data['grn_number'] . " " . $data['item_id'] . " " . $data['product_name'] . " " . $data['batch_name'] . " " . $data['color_name'];

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
#purchaseDelete {

    margin-left: 5px;
    margin-top: -120px;
    width: 340px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    padding: 4px 53px;
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
                    <!-- hidden search button is used to trigger click event through code to fetch grn number-->
                    <button type="submit" name="grnNumberSearchButton" id="grnSearchButton"
                        style="width:22px;height:25px;position:absolute;right:20px;top:130px;" hidden>S</button>
                    <div class="form-floating">
                        <input type="date" name="grnDate" id="grnDate" class="form-control" placeholder="GRN Date "
                            value="<?php echo $grnDate; ?>" readonly maxlength="30">
                        <label for="GRNDate" style="margin-left:15px;margin-top:15px;">GRN Date</label>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <div style="display:flex;gap:10px">
                    <div class="form-floating">
                        <input type="text" name="dcNumber" readonly id="dcNumber" class="form-control"
                            placeholder="DC Number" value="<?php echo $dcNumber; ?>" autocomplete="off" maxlength="20">
                        <label for="DCNumber" style="margin-top:-10px">DC Number</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" name="dcDate" id="dcDate" readonly class="form-control" placeholder="DC Date"
                            value="<?php echo $dcDate; ?>" autocomplete="off" maxlength="20">
                        <label for="DCDate" style="margin-top:-10px">DC Date</label>
                    </div>
                </div>
                <div style="margin-top:5px;">
                </div>
                <div style="display:flex;gap:10px;">
                    <div class="form-floating">
                        <input type="text" name="invoiceNumber" id="invoiceNumber" readonly class="form-control"
                            placeholder="Invoice Number" value="<?php echo $invoiceNumber; ?>" autocomplete="off"
                            maxlength="30">
                        <label for="invoiceNumber" style="margin-top:-10px">Invoice Number</label>
                    </div>
                    <div class="form-floating">
                        <input type="date" name="invoiceDate" id="invoiceDate" readonly class="form-control"
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
            <input type="text" readonly name="supplierName" autocomplete="off" id="supplierName" class="form-control"
                placeholder="Press F2 For Supplier Info" value="<?php echo $supplierName; ?>">
            <input type="text" name="supplierId" id="supplierId" class="form-control">
            <label for="" id="purchaseDelete">PURCHASE DELETE</label>
        </div>
        <br>
        <div style="display:flex;gap:23px;">
            <label for="" style="margin-left:280px;margin-top:-98px">GRN Amount</label>
            <input type="text" name="grnAmount" id="grnAmount" readonly class="form-control" autocomplete="off"
                maxlength="12" value="<?php echo $grnAmount; ?>">
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


        <div style="margin-left: 165px; font-size: 11px;">
            <div style="width: 1250px; height: 220px; overflow-y: auto;overflow-x:auto" id="itemTable">
                <table class="table text-white"
                    style="border-collapse: collapse; width: 100%; text-align: center;font-size:13px">
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
                        if (isset($_SESSION['resultSearchPurchaseSummaryItem']) && isset($grnNumberSearchButton)) {
                            $sno = 1;
                            foreach ($_SESSION['resultSearchPurchaseSummaryItem'] as $purchaseSumData) { ?>
                        <tr>
                            <td><?php echo $sno++; ?></td>
                            <td style="text-align: left;">
                                <?php echo htmlspecialchars($purchaseSumData['product_name']); ?></td>
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
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <br>
        <div style="display: flex;">
            <button style="margin-left:180px;width:120px;" type="submit" class="btn btn-danger" name="deleteButton"
                id="deleteButton" onclick="return confirm('Are You Sure Do You Want To Delete This Purchase')">
                Delete
            </button>

            <button type="submit" style="margin-left:10px;width:120px;" class="btn btn-warning" name="cancelButton"
                id="cancelButton">
                Cancel
            </button>


        </div>


    </div>

    <div style="margin-left:1290px;margin-top:-45px">
        <div style="display:flex;gap:5px">
            <label for="" style="margin-left:-2px">Total</label>
            <input type="text" name="totalQty" id="totalQty" required class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:50px;" maxlength="4"
                value="<?php echo $totalQty; ?>">
            <input type="text" name="totalAmount" id="totalAmount" class="form-control" readonly
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12"
                value="<?php echo $totalAmount; ?>">
        </div>
        <div style="display:flex;margin-top:2px;">
            <label for="">CGST</label>
            <input type="text" name="cgstAmount" id="cgstAmount" readonly autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:48px" maxlength="12"
                value="<?php echo $cgstAmount; ?>">
        </div>
        <div style="display:flex;margin-top:2px;">
            <label for="">SGST</label>
            <input type="text" name="sgstAmount" id="sgstAmount" readonly autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:49px" maxlength="12"
                value="<?php echo $sgstAmount; ?>">
        </div>
        <div style="display:flex;margin-top:2px;">
            <label for="">IGST</label>
            <input type="text" name="igstAmount" id="igstAmount" readonly autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:54px" maxlength="12"
                value="<?php echo $igstAmount; ?>">
        </div>

        <div style="display:flex;margin-top:2px;">
            <label for="">Add On</label>
            <input type="text" name="addOnAmount" id="addOnAmount" readonly autocomplete="off" class="form-control"
                style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:32px" maxlength="12"
                value="<?php echo $addOnAmount; ?>">
        </div>

        <div style="display:flex;margin-top:3px;">
            <label for="">Deduction</label>
            <input type="text" name="deductionAmount" id="deductionAmount" readonly autocomplete="off"
                class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:13px"
                maxlength="12" value="<?php echo $deductionAmount; ?>">
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
        amount.value = rate * qty;

        calculateTotalAmount();
        calculateNetAmount();
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
        amount.value = rate * qty;
        calculateTotalAmount();
        calculateNetAmount();
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
    const batch = currentRow.querySelector('input[name="batch[]"]').value;
    const color = currentRow.querySelector('input[name="color[]"]').value;
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

    let items = [product, brand, design, batch, color, category, hsnCode, tax, size, mrp, sellingPrice, rate];

    let triggerItemCreation = new FormData();
    triggerItemCreation.append("lb_trigger_item_creation", JSON.stringify(items));
    let ajTriggerItemCreation = new XMLHttpRequest();
    ajTriggerItemCreation.open("POST", "fnItemIdCreate.php", true);
    ajTriggerItemCreation.send(triggerItemCreation);


    ajTriggerItemCreation.onreadystatechange = function() {
        if (ajTriggerItemCreation.status === 200 && ajTriggerItemCreation.readyState === 4) {
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
                `select * from ${fieldName}es where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}'`;
        } else if (fieldName === "category") {
            query =
                `select * from categories where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}'`;
        } else if (fieldName === "hsnCode") {
            query =
                `select * from hsn_codes where hsn_code like '${value}%' && branch_id = '${currentBranchId}'`;
        } else if (fieldName === "tax") {
            query = `select * from taxes where tax_code like '${value}%' && branch_id = '${currentBranchId}'`;
        } else if (fieldName === "mrp") {
            query = `select * from mrps where mrp like '${value}%' && branch_id = '${currentBranchId}'`;
        } else {
            query =
                `select * from ${fieldName}s where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}'`;
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





function add_row() {
    let totalRows = localStorage.getItem("total_rows");
    totalRows = parseInt(totalRows) + 1;
    localStorage.setItem("total_rows", totalRows);

    let i = parseInt(localStorage.getItem("row_index")) + 1;
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
            <input type="text" class="product-field" name="product[]" id="product_${i}" autocomplete="off" style="font-size:12px;height:25px;width:100px;margin-left:-9px;" maxlength="30" />
        </td>
        <td>
            <input type="text" class="brand-field" name="brand[]" id="brand_${i}" autocomplete="off" style="font-size:12px;height:25px;width:120px;margin-left:-2px;" maxlength="30" />
        </td>
        <td>
            <input type="text" class="design-field" name="design[]" id="design_${i}" autocomplete="off" style="font-size:13px;height:25px;width:140px;margin-left:0px;" maxlength="30" />
        </td>
        <td>
            <input type="text" class="design-field" name="batch[]" id="batch_${i}" value="" autocomplete="off" style="font-size:13px;height:25px;width:120px;margin-left:0px;" maxlength="30" />
        </td>
        <td>
            <input type="text" class="design-field" name="color[]" id="color_${i}" autocomplete="off" style="font-size:13px;height:25px;width:80px;margin-left:0px;" maxlength="30" />
        </td>
        <td>
            <input type="text" class="design-field" name="category[]" id="category_${i}" autocomplete="off" style="font-size:13px;height:25px;width:80px;margin-left:-2px;" maxlength="30" />
        </td>
        <td>
            <input type="text" class="design-field" name="hsnCode[]" id="hsnCode_${i}" autocomplete="off" style="font-size:13px;height:25px;width:65px;margin-left:-6px;" maxlength="8" />
        </td>
        <td>
            <input type="text" class="design-field" name="tax[]" id="tax_${i}" style="font-size:13px;height:25px;width:40px;margin-left:0px;" maxlength="4" />
        </td>
        <td>
            <input type="text" class="design-field" name="size[]" id="size_${i}" autocomplete="off" style="font-size:13px;height:25px;width:50px;margin-left:0px;" maxlength="30" />
        </td>
        <td>
            <input type="text" class="design-field" name="mrp[]" id="mrp_${i}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:0px;" maxlength="12" />
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
            // let fieldName = input.name;
            // let lastValue = lastRow.querySelector(`[name="${fieldName}"]`).value;
            // input.value = lastValue; // Copy the value from the last row
            // document.getElementById(`batch_${i}`).value = batchData[i] || ''; // Set value dynamically\
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
    // document.getElementById('grnNumber').value =  


    document.getElementById('deleteButton').disabled = true;



    localStorage.setItem("total_rows", 1);
    let mydate = new Date();
    let currentDate = mydate.getFullYear() + "-" +
        (mydate.getMonth() + 1).toString().padStart(2, "0") + "-" +
        mydate.getDate().toString().padStart(2, "0");
    // document.getElementById("grnDate").value = currentDate;
    // document.getElementById("dcDate").value =currentDate;
    // document.getElementById("invoiceDate").value =currentDate;



    document.getElementById("grnNumber").focus();
}

let grnNumber = document.getElementById("grnNumber").value;
if (grnNumber == "") {
    document.getElementById("cancelButton").style.display = "none";

} else {
    document.getElementById("cancelButton").style.display = "block";
}
let rowIndex = localStorage.getItem("row_index");


setTimeout(() => {


}, 10);

function validateAmounts() {
    let grnAmount = parseFloat(document.getElementById("grnAmount").value) || 0;
    let netAmount = parseFloat(document.getElementById("netAmount").value) || 0;

    if (grnAmount == netAmount) {

        document.getElementById("deleteButton").disabled = false;
    } else {
        document.getElementById("deleteButton").disabled = true;
    }

}

document.getElementById("grnAmount").addEventListener("input", validateAmounts);
document.getElementById("cgstAmount").addEventListener("focusout", validateAmounts);
document.getElementById("sgstAmount").addEventListener("focusout", validateAmounts);
document.getElementById("igstAmount").addEventListener("focusout", validateAmounts);
document.getElementById("addOnAmount").addEventListener("focusout", validateAmounts);
document.getElementById("deductionAmount").addEventListener("focusout", validateAmounts);





window.onload = function() {

    let netAmount = document.getElementById('netAmount').value;
    if (netAmount != "") {
        document.getElementById("deleteButton").disabled = false;
        document.getElementById("deleteButton").focus();
        document.getElementById("grnNumber").setAttribute('readonly', true);
        document.getElementById("grnNumber").style.fontSize = '14px';
    } else {
        document.getElementById("deleteButton").disabled = true;
        document.getElementById('grnNumber').focus();
    }



}
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

// if(isset($_POST['deleteButton'])){


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


//             $updateStockBal = "
//             UPDATE stock_balance sb
//             JOIN purchase_item pi ON sb.item_id = pi.item_id AND sb.branch_id = pi.branch_id
//             SET sb.item_qty = sb.item_qty - pi.item_qty
//             WHERE pi.grn_number = ? AND pi.branch_id = ?";

//             $stmt = $con->prepare($updateStockBal);
//             $stmt->bind_param("si", $grnNumber, $userBranchId);
//             $stmt->execute();
//             $stmt->close();


//             // $searchGRN = "select*from purchase_item where grn_number = '$grnNumber' and branch_id = '$userBranchId'";
//             // $resultSearchGRN = $con->query($searchGRN);


//             // while($grnData = $resultSearchGRN->fetch_assoc()){
//             //     $searchStockBal = "update stock_balance set item_qty = item_qty-'$grnData[item_qty]' where item_id = '$grnData[item_id]' and branch_id = '$userBranchId'";
//             //     $resultSearchStockBal = $con->query($searchStockBal);

//             // }


//             $query = "delete from  purchase_summary where grn_number = '$grnNumber' and branch_id = '$userBranchId'
//                       and counter_name = '$counterName'";



//         $resultQuery = $con->query($query);
//         // if($resultQuery){
//         //     echo "purchase summary deleted";
//         // }else{
//         //     echo "oops! something went wrong";
//         // }


//         $queryDeletePurchaseItem = "delete from purchase_item where grn_number = '$grnNumber' and branch_id = '$userBranchId'
//                                     and counter_name = '$counterName'";
//         $resultDeletePurchaseItem = $con->query($queryDeletePurchaseItem);

//         $queryDeleteStockTransaction = "delete from stock_transaction where grn_number = '$grnNumber' and branch_id = '$userBranchId'
//                                         and counter_name = '$counterName'";
//         $resultDeleteStockTransaction = $con->query($queryDeleteStockTransaction);
//         $a=0;
//             if($resultQuery && $resultDeletePurchaseItem && $resultDeleteStockTransaction){

//                 $_SESSION['notification'] = "Purchase Deleted Successfully";            
//                 header("Location:".BASE_URL."/pages/purchaseDelete.php");

//             }else{
//                 echo "something went wrong";
//             }


//     // }else{
//     //     $_SESSION['notification'] = "GRN Amount And Net Amount Does Not Match";
//     //     header("Location:".BASE_URL."/pages/purchaseDelete.php");
//     //     if($_SESSION['notification']){
//     //         echo '<script>
//     //   document.addEventListener("DOMContentLoaded", function() {
//     //       let toastElement = new bootstrap.Toast(document.getElementById("liveToast"));
//     //       toastElement.show();
//     //   });
//     // </script>';
//     //     }




//         }
//    }  
// }



if (isset($_POST['deleteButton'])) {
    try {
        // Enable exceptions for MySQLi
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Start transaction
        $con->begin_transaction();

        $supplierName = $_POST['supplierName'];
        $supplierId = $_POST['supplierId'];
        $grnAmount = $_POST['grnAmount'];
        $netAmount = $_POST['netAmount'];

        if ($grnAmount != '' && $grnAmount != 0) {
            if ($grnAmount == $netAmount) {
                $grnNumber = $_POST['grnNumber'];
                $grnDate = $_POST['grnDate'];
                $dcNumber = $_POST['dcNumber'];
                $dcDate = $_POST['dcDate'];
                $invoiceNumber = $_POST['invoiceNumber'];
                $invoiceDate = $_POST['invoiceDate'];

                // Update stock_balance
                $updateStockBal = "
                    UPDATE stock_balance sb
                    JOIN purchase_item pi 
                    ON sb.item_id = pi.item_id AND sb.branch_id = pi.branch_id
                    SET sb.item_qty = sb.item_qty - pi.item_qty
                    WHERE pi.grn_number = ? AND pi.branch_id = ?
                ";

                $stmt = $con->prepare($updateStockBal);
                $stmt->bind_param("si", $grnNumber, $userBranchId);
                $stmt->execute();
                $stmt->close();

                // Delete from purchase_summary
                $queryDeleteSummary = "
                    DELETE FROM purchase_summary 
                    WHERE grn_number = ? AND branch_id = ? AND counter_name = ?
                ";
                $stmt1 = $con->prepare($queryDeleteSummary);
                $stmt1->bind_param("sis", $grnNumber, $userBranchId, $counterName);
                $stmt1->execute();
                $stmt1->close();

                // Delete from purchase_item
                $queryDeleteItems = "
                    DELETE FROM purchase_item 
                    WHERE grn_number = ? AND branch_id = ? AND counter_name = ?
                ";
                $stmt2 = $con->prepare($queryDeleteItems);
                $stmt2->bind_param("sis", $grnNumber, $userBranchId, $counterName);
                $stmt2->execute();
                $stmt2->close();

                // Delete from stock_transaction
                $queryDeleteStockTxn = "
                    DELETE FROM stock_transaction 
                    WHERE grn_number = ? AND branch_id = ? AND counter_name = ?
                ";
                $stmt3 = $con->prepare($queryDeleteStockTxn);
                $stmt3->bind_param("sis", $grnNumber, $userBranchId, $counterName);
                $stmt3->execute();
                $stmt3->close();

                // Commit transaction
                $con->commit();

                $_SESSION['notification'] = "Purchase Deleted Successfully";
                header("Location:" . BASE_URL . "/pages/purchaseDelete.php");
                exit();
            } else {
                $_SESSION['notification'] = "GRN Amount And Net Amount Does Not Match";
                header("Location:" . BASE_URL . "/pages/purchaseDelete.php");
                exit;
            }
        }
    } catch (Exception $e) {
        // Rollback on error
        $con->rollback();
        $_SESSION['notification'] = "Something went wrong. Transaction Failed!";
        error_log("Delete Purchase Error: " . $e->getMessage());

        // Optional: redirect or display error
        header("Location:" . BASE_URL . "/pages/purchaseDelete.php");
        exit;
    }
}



?>


<?php ob_end_flush(); ?>
<?php include_once(DIR_URL . "/includes/footer.php"); ?>