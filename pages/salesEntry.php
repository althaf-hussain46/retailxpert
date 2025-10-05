<style>

</style>
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

$querySearchCustomerId = "select*from customers where customer_name = 'Cash'
                              && branch_id = '$userBranchId'";
$resultSearchCustomerId = $con->query($querySearchCustomerId)->fetch_assoc();






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
        /*background-color: red !important;  Orange-Red for Sales Return */
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
    #duplicateCustomerMobile {
        width: 120px;
        height: 30px;
        margin-top: -80px;
        margin-left: 819px;
        display: none;


    }

    #salesEntry {

        margin-left: 5px;
        margin-top: -120px;
        width: 340px;
        font-size: 15px;
        font-weight: bold;
        text-transform: capitalize;
        padding: 4px 85px;
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

    #customerName {
        margin-top: -120px;
        /* margin-left:300px; */
        width: 400px;
        font-size: 15px;
        font-weight: bold;
        text-transform: capitalize;
        height: 30px;
        background-color: blanchedalmond;
    }

    #customerId {
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

    #salesNumber,
    #salesDate {
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


<div id="response_message_customer_form">

</div>



<form action="" id="frm" method="post">
    <div class="" style="margin-left:1160px;border:1px solid black;width:340px;height:140px;margin-top:10px;">



        <div style="display:flex;gap:10px;">
            <div class="form-floating">
                <input type="text" name="salesNumber" id="salesNumber" readonly class="form-control"
                    placeholder="Bill Number" value="<?php echo $sales_no; ?>" autocomplete="off" maxlength="30">
                <label for="salesNumber" style="margin-left:6px;margin-top:12px;font-size:large;font-weight:bold">Bill
                    Number</label>
            </div>
            <div class="form-floating">
                <input type="date" name="salesDate" readonly id="salesDate" class="form-control"
                    placeholder="Bill Date " value="" maxlength="30">
                <label for="salesDate" style="margin-left:15px;margin-top:15px;font-size:large;font-weight:bold">Bill
                    Date</label>
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

                <input type="checkbox" name="printSales" id="printSales" value="printBill" checked
                    style="width:20px;height:20px;margin-top:8px;">
            </div>

        </div>


    </div>
    <div style="margin-top:-20px;margin-left:-12px">

        <div style="display:flex;gap:12px">
            <label for="" style="margin-left:280px;margin-top:-118px;">Customer Name</label>
            <input type="text" name="customerName" autocomplete="off" id="customerName" class="form-control"
                placeholder="Press F2 For Customer Info"
                value="<?php echo $resultSearchCustomerId['customer_name']; ?>">

            <input type="text" hidden name="customerId" id="customerId" class="form-control"
                value="<?php echo $resultSearchCustomerId['id']; ?>">
            <label for="" id="salesEntry">SALES ENTRY</label>
        </div>
        <div style="display:flex;gap:6px">
            <label for="" style="margin-left:280px;margin-top:-78px;">Customer Mobile</label>
            <input type="text" style="width:280px;height:30px;margin-top:-80px;background-color:blanchedalmond;"
                name="customerMobile" placeholder="Press F2 For Mobile Info" autocomplete="off" id="customerMobile"
                maxlength="10" class="form-control" value="<?php echo $resultSearchCustomerId['mobile']; ?>">





            <div style="display: flex;gap:4px;">
                <div class="form-floating" style="margin-top:-40px;margin-left:180px">
                    <input type="text" style="height: 40px;width:180px;background-color:blanchedalmond;"
                        name="rePrintSalesNumber" id="reprintSalesNumber" class="form-control"
                        placeholder="Reprint Sales Number" autocomplete="off" maxlength="30">
                    <label for="reprintSalesNumber"
                        style="margin-left:6px;margin-top:-5px;font-size:13px;font-weight:bold;">Select Bill
                        Number</label>

                </div>
                <button type="submit" name="reprintButton" id="reprintButton" class="btn btn-success"
                    style="margin-top:-38px;height:39px">Reprint</button>
            </div>




        </div>

        <div style="display:flex;gap:6px">
            <input type="text" name="duplicateCustomerMobile" autocomplete="off" id="duplicateCustomerMobile"
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

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist" style="width: 300px;margin-left:275px;margin-top:-50px">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#sales" type="button"
                role="tab">Sales</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#salesReturn" type="button"
                role="tab">Sales Return</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="sales" role="tabpanel">
            <!-- Sales Tab Content Start-->
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
                                        <input type="text" class="serial-field" name="serialNumber[]"
                                            id="serialNumber_1" style="width:45px; height:25px; text-align:center;"
                                            maxlength="4" autocomplete="off" value="1" readonly />
                                    </td>
                                    <td>
                                        <input type="text" class="design-field" name="design[]" id="design_1"
                                            autocomplete="off"
                                            style="width:175px; height:25px; text-align:left;background-image: linear-gradient(225deg, white 50%, blanchedalmond 50%);"
                                            maxlength="30" placeholder="Press F4 For Item Info" />
                                    </td>
                                    <td>
                                        <input type="text" class="description-field" name="description[]"
                                            id="description_1" autocomplete="off"
                                            style="width:430px; height:25px; text-align:left;" maxlength="150"
                                            readonly />
                                    </td>
                                    <td>
                                        <input type="text" class="hsnCode-field" name="hsnCode[]" id="hsnCode_1"
                                            autocomplete="off" style="width:65px; height:25px; text-align:center;"
                                            maxlength="8" readonly />
                                    </td>
                                    <td>
                                        <input type="text" class="tax-field" name="tax[]" id="tax_1" autocomplete="off"
                                            style="width:35px; height:25px; text-align:center;" maxlength="8"
                                            readonly />
                                    </td>
                                    <td>
                                        <input type="text" class="sellingPrice-field" name="sellingPrice[]"
                                            id="sellingPrice_1" autocomplete="off"
                                            style="width:70px; height:25px; text-align:right;" maxlength="12"
                                            readonly />
                                    </td>
                                    <td>
                                        <input type="text" class="salesMan-field" name="salesMan[]" id="salesMan_1"
                                            autocomplete="off"
                                            style="width:70px; height:25px; text-align:center;background-color:blanchedalmond;"
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
                                        <input type="text" class="amount-field" name="amount[]" id="amount_1"
                                            autocomplete="off"
                                            style="width:85px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                            maxlength="13" readonly />
                                    </td>
                                    <td hidden>
                                        <input type="text" class="actualAmount-field" name="actualAmount[]"
                                            id="actualAmount_1" autocomplete="off"
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
                                        <input type="text" class="id-field" name="id[]" id="id_1" readonly
                                            autocomplete="off"
                                            style="width:50px; height:25px; text-align:center; background-color:#212529; color:white; border:1px solid white;" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <br>
                <button style="padding-top:0px;position:relative;left:1270px;top:143px;width:120px;
            font-weight:bolder;height:30px;font-size:large" type="submit" class="btn btn-primary" name="submit_button"
                    id="submitButton">Submit</button>
            </div>
            <div style="margin-left:1180px;margin-top:-40px">
                <div style="display:flex;gap:8px">
                    <label for="" style="margin-left:-12px">Total</label>
                    <input type="text" name="totalQty" id="totalQty" class="form-control" readonly
                        style="text-align:right;font-size:13px;height:25px;width:50px;" maxlength="4">
                    <input type="text" name="totalAmount" id="totalAmount" class="form-control" readonly
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
                    <input type="text" name="totalActualAmount" id="totalActualAmount" hidden class="form-control"
                        readonly style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px"
                        maxlength="12">
                    <input type="text" name="totalTaxable" id="totalTaxable" hidden readonly
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px"
                        class="form-control" maxlength="12">
                    <input type="text" name="totalTaxAmount" id="totalTaxAmount" hidden readonly
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px"
                        class="form-control" maxlength="12">
                </div>
                <div style="display:flex;margin-top:-25px;margin-left:180px" hidden>
                    <label for="">CGST</label>
                    <input type="text" name="cgstAmount" id="cgstAmount" readonly autocomplete="off"
                        class="form-control"
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:10px" maxlength="12">
                </div>
                <div style="display:flex;margin-top:5px;margin-left:180px" hidden>
                    <label for="">SGST</label>
                    <input type="text" name="sgstAmount" id="sgstAmount" readonly autocomplete="off"
                        class="form-control"
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:10px;" maxlength="12">
                </div>
                <div style="display:flex;margin-top:5px;margin-left:180px" hidden>
                    <label for="">IGST</label>
                    <input type="text" name="igstAmount" id="igstAmount" readonly autocomplete="off"
                        class="form-control"
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:15px" maxlength="12">
                </div>

                <div style="display:flex;margin-top:8px;margin-left:-11px;gap:2px">
                    <label for="">Dis %</label>
                    <input type="text" name="netDiscountPercent" id="netDiscountPercent" class="form-control"
                        autocomplete="off" maxlength="4" style="width:51px;height:25px">
                    <!-- <label for="">Discount </label> -->
                    <input type="text" name="deductionAmount" id="deductionAmount" autocomplete="off"
                        class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;"
                        maxlength="12">
                </div>

                <div style="display:flex;margin-top:5px;">

                    <label for="" style="margin-left: -11px;">Add On</label>
                    <input type="text" name="addOnAmount" id="addOnAmount" autocomplete="off" class="form-control"
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:40px" maxlength="12">
                </div>

                <div style="display:flex;margin-top:5px">
                    <label for="" style="margin-left:-11px;">After Add On</label>
                    <input type="text" name="afterAddOn" id="afterAddOn" class="form-control" readonly
                        style="text-align:right;font-size:12px;height:25px;width:90px;margin-left:1px" maxlength="12">
                </div>
                <div style="display:flex;margin-top:5px">
                    <label for="" style="margin-left:-11px;color:red;">Sales Return</label>
                    <input type="text" name="salesReturnNetAmount" id="salesReturnNetAmount" class="form-control"
                        readonly
                        style="font-weight:bold;color:red;text-align:right;font-size:12px;height:25px;width:90px;margin-left:8px"
                        maxlength="12">
                </div>

                <div style="display:flex;margin-top:5px;">
                    <label for=""
                        style="margin-left: -11px;color:green;font-size:15px;font-weight:bolder;margin-top:2px">Net
                        Amount</label>
                    <input type="text" name="netAmount" id="netAmount" class="form-control" readonly
                        style="font-weight:bolder;color:green;text-align:right;font-size:15px;height:30px;width:90px;margin-left:8px"
                        maxlength="12">

                </div>
            </div>
        </div>
        <!-- Sales Tab Content End-->

        <!-- Sales Return Tab Content Start-->
        <div class="tab-pane fade" id="salesReturn" role="tabpanel">

            <!-- Add your Sales Return content here -->
            <div class="container" style="margin-top:10px" id="itemGrid">



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
                            <tbody class="sr_items" id="sr_table_body">
                                <tr>
                                    <td>
                                        <input type="text" class="sr_serial-field" name="sr_serialNumber[]"
                                            id="sr_serialNumber_1" style="width:45px; height:25px; text-align:center;"
                                            maxlength="4" autocomplete="off" value="1" readonly />
                                    </td>
                                    <td>
                                        <input type="text" class="sr_design-field" name="sr_design[]" id="sr_design_1"
                                            autocomplete="off"
                                            style="width:175px; height:25px; text-align:left;background-image: linear-gradient(225deg, white 50%, blanchedalmond 50%);"
                                            maxlength="30" placeholder="Press F4 For Item Info"/>
                                    </td>
                                    <td>
                                        <input type="text" class="sr_description-field" name="sr_description[]"
                                            id="sr_description_1" autocomplete="off"
                                            style="width:430px; height:25px; text-align:left;" maxlength="150"
                                            readonly />
                                    </td>
                                    <td>
                                        <input type="text" class="sr_hsnCode-field" name="sr_hsnCode[]"
                                            id="sr_hsnCode_1" autocomplete="off"
                                            style="width:65px; height:25px; text-align:center;" maxlength="8"
                                            readonly />
                                    </td>
                                    <td>
                                        <input type="text" class="sr_tax-field" name="sr_tax[]" id="sr_tax_1"
                                            autocomplete="off" style="width:35px; height:25px; text-align:center;"
                                            maxlength="8" readonly />
                                    </td>
                                    <td>
                                        <input type="text" class="sr_sellingPrice-field" name="sr_sellingPrice[]"
                                            id="sr_sellingPrice_1" autocomplete="off"
                                            style="width:70px; height:25px; text-align:right;" maxlength="12"
                                            readonly />
                                    </td>
                                    <td>
                                        <input type="text" class="sr_salesMan-field" name="sr_salesMan[]"
                                            id="sr_salesMan_1" autocomplete="off"
                                            style="width:70px; height:25px; text-align:center;background-color:blanchedalmond;"
                                            maxlength="12" />
                                    </td>
                                    <td>
                                        <input type="text" class="sr_qty-field" name="sr_qty[]" id="sr_qty_1"
                                            autocomplete="off" style="width:35px; height:25px; text-align:center;"
                                            maxlength="5" />
                                    </td>
                                    <td>
                                        <input type="text" class="sr_discountPercent-field" name="sr_discountPercent[]"
                                            id="sr_discountPercent_1" autocomplete="off"
                                            style="width:45px; height:25px; text-align:center;" maxlength="4" />
                                    </td>
                                    <td>
                                        <input type="text" class="sr_discountAmount-field" name="sr_discountAmount[]"
                                            id="sr_discountAmount_1" autocomplete="off"
                                            style="width:80px; height:25px; text-align:right;" maxlength="10" />
                                    </td>
                                    <td>
                                        <input type="text" class="sr_amount-field" name="sr_amount[]" id="sr_amount_1"
                                            autocomplete="off"
                                            style="width:85px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                            maxlength="13" readonly />
                                    </td>
                                    <td hidden>
                                        <input type="text" class="sr_actualAmount-field" name="sr_actualAmount[]"
                                            id="sr_actualAmount_1" autocomplete="off"
                                            style="width:80px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                            maxlength="13" readonly />
                                    </td>
                                    <td hidden>
                                        <input type="text" class="sr_taxable-field" name="sr_taxable[]"
                                            id="sr_taxable_1" autocomplete="off"
                                            style="width:50px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                            maxlength="13" readonly />
                                    </td>
                                    <td hidden>
                                        <input type="text" class="sr_taxAmount-field" name="sr_taxAmount[]"
                                            id="sr_taxAmount_1" autocomplete="off"
                                            style="width:10px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;"
                                            maxlength="13" readonly />
                                    </td>
                                    <td>
                                        <input type="text" class="sr_id-field" name="sr_id[]" id="sr_id_1" readonly
                                            autocomplete="off"
                                            style="width:50px; height:25px; text-align:center; background-color:#212529; color:white; border:1px solid white;" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                <div style="padding-top:0px;position:relative;left:1270px;top:77px;width:120px;
            font-weight:bolder;height:30px;font-size:large">

                </div>
                <!-- <button style="padding-top:0px;position:relative;left:1270px;top:77px;width:120px;
            font-weight:bolder;height:30px;font-size:large"
            type="submit" class="btn btn-primary"
            name="sr_submit_button" id="sr_submitButton">Submit</button> -->
            </div>
            <div style="margin-left:1180px;margin-top:-45px">
                <div style="display:flex;gap:8px">
                    <label for="" style="margin-left:-12px">Total</label>
                    <input type="text" name="sr_totalQty" id="sr_totalQty" class="form-control" readonly
                        style="text-align:right;font-size:13px;height:25px;width:50px;" maxlength="4">
                    <input type="text" name="sr_totalAmount" id="sr_totalAmount" class="form-control" readonly
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
                    <input type="text" name="sr_totalActualAmount" id="sr_totalActualAmount" hidden class="form-control"
                        readonly style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px"
                        maxlength="12">
                    <input type="text" name="sr_totalTaxable" id="sr_totalTaxable" hidden readonly
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px"
                        class="form-control" maxlength="12">
                    <input type="text" name="sr_totalTaxAmount" id="sr_totalTaxAmount" hidden readonly
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px"
                        class="form-control" maxlength="12">
                </div>
                <div style="display:flex;margin-top:-25px;margin-left:180px" hidden>
                    <label for="">CGST</label>
                    <input type="text" name="sr_cgstAmount" readonly id="sr_cgstAmount" autocomplete="off"
                        class="form-control"
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:10px" maxlength="12">
                </div>
                <div style="display:flex;margin-top:5px;margin-left:180px" hidden>
                    <label for="">SGST</label>
                    <input type="text" name="sr_sgstAmount" readonly id="sr_sgstAmount" autocomplete="off"
                        class="form-control"
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:10px" maxlength="12">
                </div>
                <div style="display:flex;margin-top:5px;margin-left:180px" hidden>
                    <label for="">IGST</label>
                    <input type="text" name="sr_igstAmount" readonly id="sr_igstAmount" autocomplete="off"
                        class="form-control"
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:15px" maxlength="12">
                </div>

                <div style="display:flex;margin-top:5px;margin-left:-11px;gap:2px">
                    <label for="">Dis %</label>
                    <input type="text" name="sr_netDiscountPercent" id="sr_netDiscountPercent" class="form-control"
                        autocomplete="off" maxlength="4" style="width:51px;height:25px">
                    <!-- <label for="">Discount </label> -->
                    <input type="text" name="sr_deductionAmount" id="sr_deductionAmount" autocomplete="off"
                        class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;"
                        maxlength="12">
                </div>

                <div style="display:flex;margin-top:5px;">

                    <label for="" style="margin-left: -11px;">Add On</label>
                    <input type="text" name="sr_addOnAmount" id="sr_addOnAmount" autocomplete="off" class="form-control"
                        style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:40px" maxlength="12">
                </div>


                <div style="display:flex;margin-top:5px;">
                    <label for=""
                        style="margin-left: -11px;color:red;font-size:15px;font-weight:bolder;margin-top:2px">Net
                        Amount</label>
                    <input type="text" name="sr_netAmount" id="sr_netAmount" class="form-control" readonly
                        style="font-weight:bolder;color:red;text-align:right;font-size:15px;height:30px;width:90px;margin-left:8px"
                        maxlength="12">

                </div>
            </div>

        </div>
        <!-- Sales Return Tab Content End-->
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


    // Fetching Sales Summary Data For Bill Print Starts

    document.getElementById("reprintSalesNumber").addEventListener("keydown", function(event) {
        let target = event.target;
        if (event.key === "F2") {
            event.preventDefault();
            let salesNumber = new FormData();
            salesNumber.append("lb_sales_number", target.value);
            let aj_salesNumber = new XMLHttpRequest();
            aj_salesNumber.open("POST", "ajaxSalesBillReprint.php", true);
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


    document.getElementById("customerName").addEventListener("focusout", function(event) {
        let target = event.target;
        event.preventDefault();

        if (target.value != "") {
            let customerName = new FormData();
            customerName.append("al_customer_name", target.value);
            let aj_customer = new XMLHttpRequest();
            aj_customer.open("POST", "itemStoring.php", true);
            aj_customer.send(customerName);

            aj_customer.onreadystatechange = function() {
                if (aj_customer.status === 200 && aj_customer.readyState === 4) {
                    // document.getElementById("response_message").innerHTML = aj_customer.responseText;
                    // document.getElementById("response_message").style.display = "block";
                    document.getElementById('customerId').value = aj_customer.responseText;
                    document.getElementById("customerMobile").focus();
                }
            }
        }


    })

    document.getElementById("customerMobile").addEventListener("focusout", function(event) {
        let target = event.target;
        event.preventDefault();
        if (target.value != "") {
            let duplicateCustomerMobile = document.getElementById('duplicateCustomerMobile').value;

            if (duplicateCustomerMobile == '') {
                let customerId = document.getElementById('customerId').value;
                let customerData = [customerId, target.value];

                let customerDetails = new FormData();
                customerDetails.append("al_customer_details", JSON.stringify(customerData));
                let aj_customer = new XMLHttpRequest();
                aj_customer.open("POST", "itemStoring.php", true);
                aj_customer.send(customerDetails);

                aj_customer.onreadystatechange = function() {
                    if (aj_customer.status === 200 && aj_customer.readyState === 4) {
                        document.getElementById('customerId').value = aj_customer.responseText;

                    }
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





    document.getElementById("customerName").addEventListener("keydown", function(event) {
        let target = event.target;
        if (event.key === "F2") {
            event.preventDefault();
            let customerName = new FormData();
            customerName.append("lb_customer_name", target.value);
            let aj_customer = new XMLHttpRequest();
            aj_customer.open("POST", "ajaxGetCustomerDetails.php", true);
            aj_customer.send(customerName);

            aj_customer.onreadystatechange = function() {
                if (aj_customer.status === 200 && aj_customer.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj_customer.responseText;
                    document.getElementById("response_message").style.display = "block";



                }
            }


        } else if (event.key === "Enter") {

            event.preventDefault();
            if (target.value != "") {
                let customerName = new FormData();
                customerName.append("al_customer_name", target.value);
                let aj_customer = new XMLHttpRequest();
                aj_customer.open("POST", "itemStoring.php", true);
                aj_customer.send(customerName);

                aj_customer.onreadystatechange = function() {
                    if (aj_customer.status === 200 && aj_customer.readyState === 4) {
                        document.getElementById('customerId').value = aj_customer.responseText;

                        // document.getElementById("response_message").innerHTML = aj_customer.responseText;
                        // document.getElementById("response_message").style.display = "block";
                        document.getElementById("customerMobile").focus();
                    }
                }
            }
        }

    })

    document.getElementById("customerMobile").addEventListener("keydown", function(event) {
        let target = event.target;
        if (event.key === "F2") {
            event.preventDefault();
            let customerName = new FormData();
            customerName.append("lb_customer_mobile", target.value);
            let aj_customer = new XMLHttpRequest();
            aj_customer.open("POST", "ajaxGetCustomerDetails.php", true);
            aj_customer.send(customerName);

            aj_customer.onreadystatechange = function() {
                if (aj_customer.status === 200 && aj_customer.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj_customer.responseText;
                    document.getElementById("response_message").style.display = "block";



                }
            }


        } else if (event.key === "Enter") {

            event.preventDefault();
            if (target.value != "") {
                let duplicateCustomerNumber = document.getElementById('duplicateCustomerMobile').value;

                if (duplicateCustomerNumber == "") {
                    let customerId = document.getElementById('customerId').value;
                    let customerData = [customerId, target.value];

                    let customerDetails = new FormData();
                    customerDetails.append("al_customer_details", JSON.stringify(customerData));
                    let aj_customer = new XMLHttpRequest();
                    aj_customer.open("POST", "itemStoring.php", true);
                    aj_customer.send(customerDetails);

                    aj_customer.onreadystatechange = function() {
                        if (aj_customer.status === 200 && aj_customer.readyState === 4) {
                            document.getElementById('customerId').value = aj_customer.responseText;
                            // document.getElementById("response_message").innerHTML = aj_customer.responseText;
                            // document.getElementById("response_message").style.display = "block";
                            document.getElementById("product_1").focus();
                        }
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
                    `select * from designs where design_name like '${value}%' && branch_id = '${currentBranchId}' order by design_name`;
            }
            // else if(fieldName == "salesMan"){

            //     query = `select * from sales_person where sales_person_name like '${value}%' && branch_id = '${currentBranchId}' order by sales_person_name`;
            // }


            // if (fieldName === "batch") {
            //     query = `select * from ${fieldName}es where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}' order by batch_name`;
            // } else if (fieldName === "category") {
            //     query = `select * from categories where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}' order by category_name`;
            // } else if (fieldName === "hsnCode") {
            //     query = `select * from hsn_codes where hsn_code like '${value}%' && branch_id = '${currentBranchId}' order by hsn_code`;
            // } else if (fieldName === "tax") {
            //     query = `select * from taxes where tax_code like '${value}%' && branch_id = '${currentBranchId}' order by tax_code`;
            // } else if (fieldName === "mrp") {
            //     query = `select * from mrps where mrp like '${value}%' && branch_id = '${currentBranchId}' order by mrp`;
            // } else {
            //     query = `select * from ${fieldName}s where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}' order by ${fieldName}_name`;
            // }

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
                               style="width:45px; height:25px; text-align:center;" maxlength="4" autocomplete="off" value="1" readonly />
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
                               style="width:65px; height:25px; text-align:center; maxlength="8" readonly />
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


    // sales return javascript start 

    // sales return add_row function start

    function sr_add_row() {
        let sr_totalRows = localStorage.getItem("sr_total_rows");
        sr_totalRows = parseInt(sr_totalRows) + 1;
        localStorage.setItem("sr_total_rows", sr_totalRows);

        let i = parseInt(localStorage.getItem("sr_row_index")) + 1;
        const currentRows = document.querySelectorAll('#sr_table_body tr');
        const sr_lastRow = currentRows[currentRows.length - 1]; // Get the last row
        const sr_newRowIndex = currentRows.length + 1;

        // Create new row
        const sr_newRow = document.createElement('tr');
        sr_newRow.innerHTML = `
            <td>
            <input type="text" class="sr_serial-field" name="sr_serialNumber[]" id="sr_serialNumber_${i}" 
                       style="width:45px; height:25px; text-align:center;" maxlength="4" autocomplete="off" value="1" readonly />
            </td>
            <td>
                <input type="text" class="sr_design-field" name="sr_design[]" id="sr_design_${i}" autocomplete="off"
                       style="width:175px; height:25px; text-align:left;background-image: linear-gradient(225deg, white 50%, blanchedalmond 50%);" maxlength="30"
                       placeholder="Press F4 For Item Info"/>
            </td>
            <td>
                <input type="text" class="sr_description-field" name="sr_description[]" id="sr_description_${i}" autocomplete="off"
                       style="width:430px; height:25px; text-align:left;" maxlength="150" readonly />
            </td>
            <td>
                <input type="text" class="sr_hsnCode-field" name="sr_hsnCode[]" id="sr_hsnCode_${i}" autocomplete="off"
                       style="width:65px; height:25px; text-align:center;" maxlength="8" readonly />
            </td>
            <td>
                <input type="text" class="sr_tax-field" name="sr_tax[]" id="sr_tax_${i}" autocomplete="off"
                       style="width:35px; height:25px; text-align:center;" maxlength="8" readonly />
            </td>
            <td>
                <input type="text" class="sr_sellingPrice-field" name="sr_sellingPrice[]" id="sr_sellingPrice_${i}" autocomplete="off"
                       style="width:70px; height:25px; text-align:right;" maxlength="12" readonly />
            </td>
            <td>
                <input type="text" class="sr_salesMan-field" name="sr_salesMan[]" id="sr_salesMan_${i}" autocomplete="off"
                       style="width:70px; height:25px; text-align:center;background-color:blanchedalmond;" maxlength="12" />
            </td>
            <td>
                <input type="text" class="sr_qty-field" name="sr_qty[]" id="sr_qty_${i}" autocomplete="off"
                       style="width:35px; height:25px; text-align:center;" maxlength="5" />
            </td>
            <td>
                <input type="text" class="sr_discountPercent-field" name="sr_discountPercent[]" id="sr_discountPercent_${i}" autocomplete="off"
                       style="width:45px; height:25px; text-align:center;" maxlength="4" />
            </td>
            <td>
                <input type="text" class="sr_discountAmount-field" name="sr_discountAmount[]" id="sr_discountAmount_${i}" autocomplete="off"
                       style="width:80px; height:25px; text-align:right;" maxlength="10" />
            </td>
            <td>
                <input type="text" class="sr_amount-field" name="sr_amount[]" id="sr_amount_${i}" autocomplete="off"
                       style="width:85px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;" maxlength="13" readonly />
            </td>
            <td hidden>
                <input type="text" class="sr_actualAmount-field" name="sr_actualAmount[]" id="sr_actualAmount_${i}" autocomplete="off"
                       style="width:80px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;" maxlength="13" readonly />
            </td>
            <td hidden>
                <input type="text" class="sr_taxable-field" name="sr_taxable[]" id="sr_taxable_${i}" autocomplete="off"
                       style="width:50px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;" maxlength="13" readonly />
            </td>
            <td hidden>
                <input type="text" class="sr_taxAmount-field" name="sr_taxAmount[]" id="sr_taxAmount_${i}" autocomplete="off"
                       style="width:10px; height:25px; text-align:right; background-color:#212529; color:white; border:1px solid white;" maxlength="13" readonly />
            </td>
            <td>
                <input type="text" class="sr_id-field" name="sr_id[]" id="sr_id_${i}" readonly autocomplete="off"
                       style="width:50px; height:25px; text-align:center; background-color:#212529; color:white; border:1px solid white;" />
            </td>
        <td>
            <button type="button" id="sr_remove" class="btn btn-danger" title="Remove" style="font-size:8px;margin-left:1px;width:45px">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    `;

        // Copy values from the last row
        if (sr_lastRow) {
            sr_newRow.querySelectorAll("input").forEach((input) => {
                let fieldName = input.name;

                let lastValue = sr_lastRow.querySelector(`[name="${fieldName}"]`).value || "";
                // input.value = lastValue; // Copy the value from the last row

            });
        }

        document.querySelector('#sr_table_body').appendChild(sr_newRow);
        // ✅ Set the value for serialNumber explicitly after appending the row

        sr_newRow.querySelector(`#sr_serialNumber_${i}`).value = i;

        // Log the new row index
        console.log("New row added at index:", sr_newRowIndex);
        localStorage.setItem("sr_row_index", sr_newRowIndex);

        // Focus on the new row's product field
        sr_newRow.querySelector('input[name="sr_design[]"]').focus();
    }


    $(document).on("click", "#sr_remove", function(e) {
        const sr_removedRow = $(this).closest('tr');
        const sr_removedIndex = sr_removedRow.index() + 1; // 1-based index
        console.log("Removed row at index:", sr_removedIndex);

        sr_removedRow.remove();

        // Update all subsequent row indices
        const sr_remainingRows = document.querySelectorAll('#sr_table_body tr');
        sr_remainingRows.forEach((sr_row, sr_index) => {
            const sr_rowNumber = sr_index + 1;
            sr_row.querySelector('.sr_serial-field').value = sr_index + 1; // Reset serial numbers
            sr_row.querySelectorAll('input').forEach(input => {
                const name = input.name.replace(/\d+/, sr_rowNumber);
                const id = input.id.replace(/\d+/, sr_rowNumber);
                input.name = name;
                input.id = id;
            });

        });

        localStorage.setItem("sr_row_deleted", 1);
        let sr_totalRows = localStorage.getItem('sr_total_rows');
        sr_deleteRow = parseInt(sr_totalRows) - 1;
        localStorage.setItem("sr_total_rows", sr_deleteRow);



    });

    // Modify the row deletion logic
    $(document).on("click", "#sr_remove", function(e) {
        e.preventDefault();
        const sr_removedRow = $(this).closest('tr');
        const sr_removedIndex = sr_removedRow.index() + 1; // 1-based index
        console.log("Removed row at index:", sr_removedIndex);

        sr_removedRow.remove();
        sr_updateRowIndices();

        localStorage.setItem("sr_row_deleted", 1);

        sr_calculateTotalAmount();
        sr_calculateNetAmount();
    });

    // Function to update row indices after deletion
    function sr_updateRowIndices() {
        const sr_rows = document.querySelectorAll('#sr_table_body tr');
        sr_rows.forEach((sr_row, index) => {
            const sr_rowNumber = index + 1;
            sr_row.querySelectorAll('input').forEach(input => {
                const name = input.name.replace(/\d+/, sr_rowNumber);
                const id = input.id.replace(/\d+/, sr_rowNumber);
                input.name = name;
                input.id = id;
            });
        });
    }


    // Modified logRowIndex function
    function sr_logRowIndex(input) {
        const sr_currentRow = input.closest('tr');
        if (sr_currentRow) {
            const sr_rowIndex = sr_currentRow.rowIndex; // This is 0-based index
            console.log("sr_Row Index:", sr_rowIndex); // Show 1-based index to user
            localStorage.setItem("sr_row_index", sr_rowIndex);
        }
    }


    // sales return add_row function end




    document.getElementById("sr_table_body").addEventListener('focusin', function(event) {

        let target = event.target;
        let sr_currentRow = target.closest('tr');
        if (target.name == "sr_salesMan[]") {

            sr_calculateAmount(target);
            // calculateAc();
            sr_calculateTaxAmount(target);
            sr_calculateTotalAmount();
            sr_calculateNetAmount();

        } else if (target.name == "sr_qty[]") {
            if (target.value >= 1) {

            } else {
                sr_currentRow.querySelector('input[name="sr_qty[]"]').value = 1;
            }

            sr_currentRow.querySelector('input[name="sr_qty[]"]').select();
            sr_calculateAmount(target);
            // calculateAc()
            sr_calculateTaxAmount(target);
            sr_calculateTotalAmount();
            sr_calculateNetAmount();

        }
    })




    document.getElementById('sr_table_body').addEventListener('input', function(event) {

        let target = event.target;
        let currentRow = target.closest('tr');
        if (target.name == "sr_qty[]") {

            sr_calculateAmount(target);
            // calculateAc()
            sr_calculateTaxAmount(target);
            sr_calculateTotalAmount();
            sr_calculateNetAmount();


        } else if (target.name == "sr_discountPercent[]") {

            let sr_amount = currentRow.querySelector('input[name="sr_amount[]"]').value;
            let sr_discountAmount = currentRow.querySelector('input[name="sr_discountAmount[]"]');
            let sr_discountPercentage = currentRow.querySelector('input[name="sr_discountPercent[]"]');

            if (parseFloat(target.value) < parseFloat(100)) {
                sr_calculateDiscountAmount(target)
                sr_calculateAmount(target);
                sr_calculateTaxAmount(target);
                sr_calculateTotalAmount();
                sr_calculateNetAmount();
            } else {
                sr_discountAmount.value = 0;
                sr_discountPercentage.value = 0;
                sr_discountPercentage.select();
            }

        } else if (target.name == 'sr_discountAmount[]') {


            let sr_amount = currentRow.querySelector('input[name="sr_amount[]"]').value;
            let sr_discountAmount = currentRow.querySelector('input[name="sr_discountAmount[]"]');
            let sr_discountPercentage = currentRow.querySelector('input[name="sr_discountPercent[]"]');

            if (parseFloat(sr_discountAmount.value) < parseFloat(sr_amount)) {
                sr_calculateDiscountPercentage(target);
                sr_calculateAmount(target);
                // calculateAc();
                sr_calculateTaxAmount(target);
                sr_calculateTotalAmount();
                sr_calculateNetAmount();


            } else {

                sr_discountAmount.value = 0;
                sr_discountAmount.select();
                sr_discountPercentage.value = 0;
            }


        }
    })








    document.getElementById("sr_table_body").addEventListener("focusout", function(event) {
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
        if (target.name === "sr_qty[]") {
            const currentRow = target.closest('tr');


            let sr_taxAmount = currentRow.querySelector('input[name="sr_taxAmount[]"]');


            // taxAmount.value = amount.value*2;
            sr_calculateDiscountAmount(target)
            sr_calculateAmount(target)
            sr_calculateTotalAmount();
            sr_calculateNetAmount();
            // validateAmounts();
            // let cgstAmount = document.getElementById('cgstAmount').value||0;
            // let sgstAmount = document.getElementById("sgstAmount").value||0;
            // let igstAmount = document.getElementById("igstAmount").value||0;
            // let addOn = document.getElementById("addOnAmount").value||0;
            // let deduction = document.getElementById("deductionAmount").value||0;

            // let netAmount = parseInt(totalAmount)+parseInt(cgstAmount)+parseInt(sgstAmount)+parseInt(igstAmount)+parseInt(addOn)-parseInt(deduction);


            // document.getElementById("netAmount").value = netAmount;
        } else if (target.name == "sr_discountPercent[]") {

            sr_calculateDiscountAmount(target);
            sr_calculateAmount(target);
            sr_calculateTotalAmount();
            sr_calculateNetAmount();
        }


    })





    document.getElementById("sr_table_body").addEventListener("keydown", function(event) {
        const target = event.target;

        // Handle the Enter key event
        if (event.key === "Enter") {
            event.preventDefault(); // Prevent the default Enter key behavior

            // Navigate based on the input field's name


            if (target.name == "sr_design[]") {


                const currentRow = target.closest("tr");
                const sr_salesManField = currentRow.querySelector('input[name="sr_salesMan[]"]');
                if (sr_salesManField) {
                    sr_salesManField.focus();
                    sr_salesManField.select();
                }



            } else if (target.name == "sr_salesMan[]") {

                const currentRow = target.closest("tr");
                const sr_qtyField = currentRow.querySelector('input[name="sr_qty[]"]');
                if (sr_qtyField) {
                    sr_qtyField.focus();
                    sr_qtyField.select();
                }


            } else if (target.name == "sr_qty[]") {

                // validateAmounts();

                const currentRow = target.closest('tr');
                const sr_discountPercentField = currentRow.querySelector('input[name="sr_discountPercent[]"]');




                if (sr_discountPercentField) {
                    sr_discountPercentField.focus();
                    sr_discountPercentField.select();

                }


            } else if (target.name == "sr_discountPercent[]") {

                // validateAmounts();
                if (parseFloat(target.value) < parseFloat(100)) {
                    sr_calculateDiscountAmount(target)
                }

                const currentRow = target.closest('tr');
                const sr_discountAmountField = currentRow.querySelector('input[name="sr_discountAmount[]"]');
                // const sellingPriceField = currentRow.querySelector('input[name="sellingPrice[]"]').value;
                // const qtyField = currentRow.querySelector('input[name="qty[]"]').value;
                // const discountPercentField = currentRow.querySelector('input[name="discountPercent[]"]').value;

                // discountAmountField.value = ((sellingPriceField*qtyField)*discountPercentField/100)



                if (sr_discountAmountField) {
                    sr_discountAmountField.focus();
                    sr_discountAmountField.select();

                }


            } else if (target.name === "sr_discountAmount[]") {
                // Check if it's the last row

                const currentRow = target.closest("tr");
                const isLastRow = currentRow.isSameNode(document.querySelector("#sr_table_body tr:last-child"));
                // validateAmounts();
                if (isLastRow) {
                    // Add a new row if it's the last one
                    sr_add_row();

                    // Focus on the product field of the newly added row
                    const sr_nextRow = currentRow.nextElementSibling;
                    if (sr_nextRow) {
                        const sr_designField = sr_nextRow.querySelector('input[name="sr_design[]"]');
                        if (sr_designField) {
                            // validateAmounts();
                            sr_designField.focus();
                            sr_designField.select();
                        }
                    }

                } else {
                    // Move to the product field in the next row
                    const sr_nextRow = currentRow.nextElementSibling;
                    if (sr_nextRow) {
                        const sr_designField = sr_nextRow.querySelector('input[name="sr_design[]"]');
                        if (sr_designField) {
                            sr_designField.focus();
                        }
                    }
                }
            }
        }
    });

    // Event delegation for dynamically added rows
    document.getElementById('sr_table_body').addEventListener('focus', function(e) {
        if (e.target.matches('input[name*="[]"]')) {
            sr_logRowIndex(e.target);
        }
    }, true);

    document.getElementById('sr_table_body').addEventListener('click', function(e) {
        let target = e.target;
        let row = target.closest('tr');
        if (target.name == target.name) {
            let fieldname = target.name;
            row.querySelector(`input[name="${fieldname}"]`).select();

        }
        if (e.target.matches('input[name*="[]"]')) {
            sr_logRowIndex(e.target);
        }
    }, true);


    // Modify the F2 key event listener
    document.getElementById("sr_table_body").addEventListener("keydown", function(event) {
        const target = event.target;
        if (target.tagName === "INPUT" && event.key === "F2") {
            event.preventDefault();
            const fieldName = target.name.replace("[]", "");
            const removedsr = fieldName.replace("sr_", "");
            const value = target.value;
            const currentBranchId = document.getElementById("userBranchId").value;
            let query = "";

            if (removedsr == "design") {
                query =
                    `select * from designs where design_name like '${value}%' && branch_id = '${currentBranchId}' order by design_name`;
            }
            // else if(removedsr == "salesMan"){

            //     query = `select * from sales_person where sales_person_name like '${value}%' && branch_id = '${currentBranchId}' order by sales_person_name`;
            // }

            // if (removedsr === "batch") {
            //     query = `select * from batches where ${removedsr}_name like '${value}%' && branch_id = '${currentBranchId}' order by batch_name`;
            // } else if (removedsr === "category") {
            //     query = `select * from categories where ${removedsr}_name like '${value}%' && branch_id = '${currentBranchId}' order by category_name`;
            // } else if (removedsr === "hsnCode") {
            //     query = `select * from hsn_codes where hsn_code like '${value}%' && branch_id = '${currentBranchId}' order by hsn_code`;
            // } else if (removedsr === "tax") {
            //     query = `select * from taxes where tax_code like '${value}%' && branch_id = '${currentBranchId}' order by tax_code`;
            // } else if (removedsr === "mrp") {
            //     query = `select * from mrps where mrp like '${value}%' && branch_id = '${currentBranchId}' order by mrp`;
            // } else {
            //     query = `select*from ${removedsr}s where ${removedsr}_name like '${value}%' && branch_id = '${currentBranchId}' order by ${removedsr}_name`;
            // }

            const data = new FormData();
            data.append(`lb_qry_${removedsr}`, query);
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
        } else if (target.name === "sr_design[]" && event.key === "F4") {
            event.preventDefault();
            let fieldName = target.name.replace("[]", "");
            let value = target.value;
            let currentBranchId = document.getElementById("userBranchId").value;

            localStorage.setItem("sales_return", "1")
            let get_item = new FormData();
            get_item.append("sr_get_item_f4", value);
            let aj = new XMLHttpRequest();
            aj.open("POST", "ajaxGetSalesItem.php", true);
            aj.send(get_item);
            aj.onreadystatechange = function() {

                if (aj.status === 200 && aj.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj.responseText;
                }
            }


        }
        if (target.name === "sr_salesMan[]" && event.key === "F2") {

            event.preventDefault();
            let fieldName = target.name.replace("[]", "");
            let value = target.value;
            let currentBranchId = document.getElementById("userBranchId").value;
            localStorage.setItem("sales_return", "0")
            let sr_get_salesman_code = new FormData();
            sr_get_salesman_code.append("sr_get_sales_man_details_f2", value);
            let aj = new XMLHttpRequest();
            aj.open("POST", "ajaxGetSalesManDetails.php", true);
            aj.send(sr_get_salesman_code);
            aj.onreadystatechange = function() {

                if (aj.status === 200 && aj.readyState === 4) {
                    document.getElementById("response_message").innerHTML = aj.responseText;
                }
            }


        }

    });



    // sales return  all calculation functions start
    function sr_calculateDiscountAmount(target) {
        const sr_currentRow = target.closest('tr');
        const sr_discountAmountField = sr_currentRow.querySelector('input[name="sr_discountAmount[]"]');
        const sr_sellingPriceField = sr_currentRow.querySelector('input[name="sr_sellingPrice[]"]');
        const sr_qtyField = sr_currentRow.querySelector('input[name="sr_qty[]"]');
        const sr_discountPercentField = sr_currentRow.querySelector('input[name="sr_discountPercent[]"]');

        // discountAmountField.value = ((parseFloat(sellingPriceField)*parseInt(qtyField))*(parseFloat(discountPercentField))/100).toFixed(2);
        sr_discountAmountField.value = (
            (parseFloat(sr_sellingPriceField.value || 0) * parseInt(sr_qtyField.value || 0, 10)) *
            (parseFloat(sr_discountPercentField.value || 0) / 100)
        ).toFixed(0);


    }

    function sr_calculateDiscountPercentage(target) {
        const sr_currentRow = target.closest('tr');
        const sr_selling = sr_currentRow.querySelector('input[name="sr_sellingPrice[]"]').value || 0;
        const sr_qty = sr_currentRow.querySelector('input[name="sr_qty[]"]').value || 0;
        const sr_discountAmount = sr_currentRow.querySelector('input[name="sr_discountAmount[]"]').value || 0;
        let sr_discountPercentage = sr_currentRow.querySelector('input[name="sr_discountPercent[]"]');

        sr_discountPercentage.value = ((parseFloat(sr_discountAmount) / parseFloat(sr_selling)) * 100).toFixed(2);


    }

    function sr_calculateAmount(target) {
        const sr_currentRow = target.closest('tr');
        const sr_selling = sr_currentRow.querySelector('input[name="sr_sellingPrice[]"]').value || 0;
        const sr_qty = sr_currentRow.querySelector('input[name="sr_qty[]"]').value || 0;
        const sr_discountAmount = sr_currentRow.querySelector('input[name="sr_discountAmount[]"]').value || 0;
        const sr_actualAmount = sr_currentRow.querySelector('input[name="sr_actualAmount[]"]');
        let sr_amount = sr_currentRow.querySelector('input[name="sr_amount[]"]');
        sr_amount.value = ((sr_selling * sr_qty) - sr_discountAmount).toFixed(2);
        sr_actualAmount.value = ((sr_selling * sr_qty)).toFixed(2);
    }


    function sr_calculateAc() {
        let sr_total_rows = parseInt(localStorage.getItem('sr_total_rows'));

        let sr_eachRowActualAmount = 0;
        let sr_eachRowActualAmountAfterDiscount = 0;
        let sr_eachRowTaxableAmount = 0;
        let sr_eachRowTaxPercentage = 0;
        let sr_eachRowTaxPercentage2 = 0;
        let sr_eachRowTaxAmount = 0;
        let sr_actualTotalAmount = document.getElementById("sr_totalActualAmount").value || 0;
        let sr_netAmount = document.getElementById("sr_netAmount").value || 0;

        let sr_totalTaxable = 0;
        let sr_totalTaxAmount = 0;

        let sr_differenceAmount = parseFloat(sr_actualTotalAmount) - parseFloat(sr_netAmount);
        let sr_differencePercentage = (parseFloat(parseFloat(sr_differenceAmount) / parseFloat(sr_actualTotalAmount)) * 100)
            .toFixed(2);

        console.log("difference per = ", sr_differencePercentage)

        for (let i = 1; i <= sr_total_rows; i++) {

            sr_eachRowActualAmount = document.getElementById("sr_actualAmount_" + i).value || 0;

            sr_eachRowTaxPercentage = document.getElementById("sr_tax_" + i).value || 0;
            console.log("sr_actual Amount = ", sr_eachRowActualAmount);
            console.log("sr_tax amount = ", sr_eachRowTaxPercentage);
            sr_eachRowTaxPercentage2 = sr_eachRowTaxPercentage.replace("G", "");

            console.log("sr_each row tax =", sr_eachRowTaxPercentage2)
            console.log("sr_tax type =", typeof(sr_eachRowTaxPercentage2))
            // eachRowActualAmountAfterDiscount = (parseFloat(eachRowActualAmount)-((parseFloat(eachRowActualAmount)*parseFloat(differencePercentage))/100)).toFixed(2)
            sr_eachRowActualAmountAfterDiscount = (parseFloat(sr_eachRowActualAmount) - parseFloat(((parseFloat(
                sr_eachRowActualAmount) * parseFloat(sr_differencePercentage)) / 100))).toFixed(2);

            console.log("sr_actual after discount = ", sr_eachRowActualAmountAfterDiscount)

            // eachRowTaxableAmount = ((parseFloat(eachRowActualAmountAfterDiscount)/parseFloat(eachRowTaxPercentage2+100))*100).toFixed(2)    
            sr_eachRowTaxableAmount = ((parseFloat(sr_eachRowActualAmountAfterDiscount) / parseFloat(parseFloat(
                sr_eachRowTaxPercentage2) + 100)) * 100).toFixed(2);
            console.log("sr_taxable amount  after discount = ", sr_eachRowTaxableAmount)

            // eachRowTaxAmount = ((parseFloat(eachRowTaxableAmount)*parseFloat(eachRowTaxPercentage2))/100).toFixed(2)
            sr_eachRowTaxAmount = ((parseFloat(sr_eachRowTaxableAmount) * parseFloat(sr_eachRowTaxPercentage2)) / 100)
                .toFixed(2);


            console.log("")
            // console.log(eachRowActualAmountAfterDiscount);
            // console.log(eachRowTaxableAmount);


            document.getElementById("sr_taxable_" + i).value = parseFloat(sr_eachRowTaxableAmount) || 0;
            document.getElementById("sr_taxAmount_" + i).value = parseFloat(sr_eachRowTaxAmount) || 0;


            sr_totalTaxable = parseFloat(sr_totalTaxable) + parseFloat(document.getElementById("sr_taxable_" + i).value ||
                0);
            sr_totalTaxAmount = parseFloat(sr_totalTaxAmount) + parseFloat(document.getElementById("sr_taxAmount_" + i)
                .value || 0);

        }

        document.getElementById("sr_totalTaxable").value = parseFloat(sr_totalTaxable).toFixed(2);
        document.getElementById("sr_totalTaxAmount").value = parseFloat(sr_totalTaxAmount).toFixed(2);


        console.log("sr_actual", sr_actualTotalAmount)
        console.log("sr_net", sr_netAmount)
        console.log("sr_diff", sr_differenceAmount)

    }

    function sr_calculateTaxAmount(target) {
        const sr_currentRow = target.closest('tr');
        // const selling = currentRow.querySelector('input[name="sellingPrice[]"]').value||0;
        // const qty = currentRow.querySelector('input[name="qty[]"]').value||0;
        // const discountAmount =currentRow.querySelector('input[name="discountAmount[]"]').value||0;
        let sr_amount = sr_currentRow.querySelector('input[name="sr_amount[]"]').value;
        let sr_tax = sr_currentRow.querySelector('input[name="sr_tax[]"]').value;
        let sr_truncatedTax = sr_tax.replace('G', "");

        let sr_taxAmount = sr_currentRow.querySelector('input[name="sr_taxAmount[]"]');
        let sr_taxable = sr_currentRow.querySelector('input[name="sr_taxable[]"]');

        sr_taxable.value = (((parseFloat(sr_amount) / (parseFloat(sr_truncatedTax) + 100))) * 100).toFixed(2);
        sr_taxAmount.value = (parseFloat(sr_amount) - ((parseFloat(sr_amount) / (parseFloat(sr_truncatedTax) + 100))) * 100)
            .toFixed(2);

    }



    function sr_calculateTotalAmount() {
        let sr_totalRow = parseInt(localStorage.getItem('sr_total_rows'));
        console.log("sr_total  rows = ", typeof(sr_totalRow))
        let sr_eachRowQty = 0;
        let sr_totalQty = 0;

        let sr_eachRowDiscountAmount = 0;

        let sr_eachRowAmount = 0;
        let sr_totalAmount = 0;


        let sr_eachRowActualAmount = 0;
        let sr_totalActualAmount = 0;

        let sr_eachRowTaxable = 0;
        let sr_totalTaxable = 0;

        let sr_eachRowTaxAmount = 0;
        let sr_totalTaxAmount = 0;



        for (let i = 1; i <= sr_totalRow; i++) {

            sr_eachRowQty = document.getElementById("sr_qty_" + i).value || 0;


            sr_eachRowAmount = document.getElementById("sr_amount_" + i).value || 0;
            sr_eachRowActualAmount = document.getElementById("sr_actualAmount_" + i).value || 0;

            sr_eachRowTaxable = document.getElementById("sr_taxable_" + i).value || 0;
            console.log("sr_each row tax ", sr_eachRowTaxable)
            sr_eachRowTaxAmount = document.getElementById("sr_taxAmount_" + i).value || 0;



            sr_totalQty = parseInt(sr_totalQty) + parseInt(sr_eachRowQty);
            sr_totalAmount = parseFloat(sr_totalAmount) + parseFloat(sr_eachRowAmount);
            sr_totalActualAmount = parseFloat(sr_totalActualAmount) + parseFloat(sr_eachRowActualAmount);
            sr_totalTaxable = parseFloat(sr_totalTaxable) + parseFloat(sr_eachRowTaxable);
            sr_totalTaxAmount = parseFloat(sr_totalTaxAmount) + parseFloat(sr_eachRowTaxAmount);
            console.log("total taxable amount from sr_calculatetotalamount = ", sr_totalTaxable)
            console.log("total tax amount from sr_calculatetotalamount = ", sr_totalTaxAmount)


        }


        for (let i = 1; i <= sr_totalRow; i++) {

            sr_eachRowDiscountAmount = parseFloat(document.getElementById("sr_discountAmount_" + i).value || 0);


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


        document.getElementById("sr_totalQty").value = sr_totalQty;
        document.getElementById("sr_totalAmount").value = parseFloat(sr_totalAmount).toFixed(2);
        document.getElementById("sr_totalActualAmount").value = parseFloat(sr_totalActualAmount).toFixed(2);
        document.getElementById("sr_totalTaxable").value = parseFloat(sr_totalTaxable).toFixed(2);
        document.getElementById("sr_totalTaxAmount").value = parseFloat(sr_totalTaxAmount).toFixed(2);
    }


    function sr_calculateGST() {
        let sr_totalTaxAmount = document.getElementById("sr_totalTaxAmount").value;
        let sr_cgstAmount = document.getElementById('sr_cgstAmount');
        let sr_sgstAmount = document.getElementById("sr_sgstAmount");
        let sr_igstAmount = document.getElementById("sr_igstAmount");
        let customerState = localStorage.getItem('customer_state');
        if (customerState == '1') {
            sr_cgstAmount.value = sr_sgstAmount.value = parseFloat((parseFloat(sr_totalTaxAmount) / 2)).toFixed(2);
        } else {
            sr_igstAmount.value = sr_totalTaxAmount;
        }




    }

    function sr_calculateNetDiscountPercent() {

        let sr_netDiscountAmount = document.getElementById("sr_deductionAmount").value || 0;
        let sr_totalAmount = document.getElementById("sr_totalActualAmount").value || 0;
        let sr_netDiscountPercent = document.getElementById("sr_netDiscountPercent");

        console.log("sr_net discount amount = ", sr_netDiscountAmount);
        console.log("sr_total amount from sr_calculatenetdiscountpercent = ", sr_totalAmount)
        sr_netDiscountPercent.value = (parseFloat((parseFloat(sr_netDiscountAmount) / parseFloat(sr_totalAmount)) * 100))
            .toFixed(2);
        sr_calculateNetAmount();


    }


    function sr_calculateNetDiscount() {
        let sr_netDiscountPercent = document.getElementById("sr_netDiscountPercent").value || 0;
        let sr_totalAmount = document.getElementById("sr_totalAmount").value || 0;
        let sr_netDiscountAmount = document.getElementById("sr_deductionAmount");

        sr_netDiscountAmount.value = ((parseFloat(sr_totalAmount) * parseFloat(sr_netDiscountPercent)) / 100).toFixed();
        sr_calculateNetAmount()






    }


    function sr_calculateNetAmount() {

        let sr_totalAmount = document.getElementById('sr_totalAmount').value || 0;
        let sr_cgstAmount = document.getElementById('sr_cgstAmount').value || 0;
        let sr_sgstAmount = document.getElementById("sr_sgstAmount").value || 0;
        let sr_igstAmount = document.getElementById("sr_igstAmount").value || 0;
        let sr_addOn = document.getElementById("sr_addOnAmount").value || 0;
        let sr_deduction = document.getElementById("sr_deductionAmount").value || 0;
        let sr_netAmount = parseFloat(sr_totalAmount) + parseFloat(sr_addOn) - parseFloat(sr_deduction);
        sr_calculateGST()
        document.getElementById("sr_netAmount").value = parseFloat(sr_netAmount).toFixed(2);
        document.getElementById("salesReturnNetAmount").value = parseFloat(sr_netAmount).toFixed(2);
        calculateNetAmount();

    }


    document.getElementById("sr_netDiscountPercent").addEventListener("focusout", sr_calculateNetDiscount);
    document.getElementById("sr_netDiscountPercent").addEventListener("input", sr_calculateNetDiscount);

    document.getElementById("sr_deductionAmount").addEventListener("focusout", sr_calculateNetDiscountPercent);
    document.getElementById("sr_deductionAmount").addEventListener("input", sr_calculateNetDiscountPercent);

    document.getElementById("sr_addOnAmount").addEventListener("focusout", sr_calculateNetAmount);
    document.getElementById("sr_addOnAmount").addEventListener("input", sr_calculateNetAmount);

    // sales return all calculation function end 



    // sales return javascript end 











    window.onload = function() {

        localStorage.setItem('customer_state', '1');
        localStorage.setItem('sales_return', '0');
        let customerState = localStorage.getItem("customer_state");

        document.getElementById("customerName").value = "Cash";
        document.getElementById("customerMobile").value = "0";

        document.getElementById("totalQty").value = 0;
        document.getElementById("totalAmount").value = 0;
        document.getElementById("cgstAmount").value = 0;
        document.getElementById("sgstAmount").value = 0;
        document.getElementById("igstAmount").value = 0;
        document.getElementById("addOnAmount").value = 0;
        document.getElementById("deductionAmount").value = 0;
        document.getElementById("netAmount").value = 0;
        document.getElementById("salesReturnNetAmount").value = 0;
        document.getElementById("netDiscountPercent").value = 0;
        document.getElementById("cgstAmount").style.background = 'gainsboro';
        document.getElementById("sgstAmount").style.background = 'gainsboro';
        document.getElementById("igstAmount").style.background = 'gainsboro';


        //sales return text fields start

        document.getElementById("sr_totalQty").value = 0;
        document.getElementById("sr_totalAmount").value = 0;
        document.getElementById("sr_cgstAmount").value = 0;
        document.getElementById("sr_sgstAmount").value = 0;
        document.getElementById("sr_igstAmount").value = 0;
        document.getElementById("sr_addOnAmount").value = 0;
        document.getElementById("sr_deductionAmount").value = 0;
        document.getElementById("sr_netAmount").value = 0;
        document.getElementById("sr_netDiscountPercent").value = 0;
        document.getElementById("sr_cgstAmount").style.background = 'gainsboro';
        document.getElementById("sr_sgstAmount").style.background = 'gainsboro';
        document.getElementById("sr_igstAmount").style.background = 'gainsboro';

        //sales return text fields end




        // document.getElementById("cgstAmount").setAttribute('readonly','true');
        // document.getElementById("sgstAmount").setAttribute('readonly','true');
        // document.getElementById("igstAmount").setAttribute('readonly','true');
        document.getElementById('submitButton').disabled = true;

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
        document.getElementById("salesDate").value = currentDate;


        // document.getElementById("SalesNumber").value = '<?php echo htmlspecialchars($sales_no); ?>';

        document.getElementById("design_1").focus();
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


    document.getElementById('customerMobile').addEventListener('keypress', function(event) {
        const charCode = event.which || event.keyCode; // Get the character code
        const charStr = String.fromCharCode(charCode); // Convert to a string

        // Allow digits (0-9) and a single decimal point
        if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
            event.preventDefault(); // Prevent input if not a number or extra decimal
        }
    });

    document.getElementById('customerMobile').addEventListener('input', function() {
        // Prevent any invalid characters that might slip through (e.g., copy-paste)
        this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
    });




    document.getElementById("customerName").addEventListener("keydown", function(event) {

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

    // sales return 




    document.getElementById("sr_netDiscountPercent").addEventListener("focus", function(event) {

        document.getElementById('sr_netDiscountPercent').select();

    })

    document.getElementById("sr_addOnAmount").addEventListener("focus", function(event) {

        document.getElementById('sr_addOnAmount').select();

    })


    document.getElementById("sr_netDiscountPercent").addEventListener("keydown", function(event) {

        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("sr_deductionAmount").focus();
            document.getElementById("sr_deductionAmount").select();
        }


    })

    document.getElementById("sr_deductionAmount").addEventListener("keydown", function(event) {

        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("sr_addOnAmount").focus();
            document.getElementById("sr_addOnAmount").select();
        }
    })



    document.getElementById("customerMobile").addEventListener("keydown", function(event) {

        if (event.key === "Enter") {
            event.preventDefault();

            document.getElementById("design_1").focus();
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

    $salesNumber  =  $_POST['rePrintSalesNumber'];
    printSalesBill($salesNumber);
}


if (isset($_POST['submit_button'])) {
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        $customerName            =  $_POST['customerName'];
        $customerId              = $_POST['customerId'];
        $counterName             = $_POST['counterName'];



        $salesNumber = $_SESSION['sales_number'] = $_POST['salesNumber'];
        // $salesDate = $_POST['salesDate'];

        date_default_timezone_set("Asia/Kolkata");
        $salesDate = date("Y-m-d h:i:s A");


        // echo "current data and time  = " . $salesDate;

        $netAmount = $_POST['netAmount'];
        // Sales Item  Grid Attributes Start
        $design                         = $_POST['design'];
        $sales_Number                   = $_POST['salesNumber'];
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
        echo $salesReturnAmount;
        echo "<br>";
        echo $salesNetAmount;
        echo "<br>";






        if ($netAmount >= 0 && $design[0] != '') {
            echo "iam in";

            $salesNumber = $_POST['salesNumber'];
            // $salesDate = $_POST['salesDate'];
            $querySearchSalesNumber = "select*from sales_sno_master where counter_name = '$counterName' && 
                                     financial_year = '$financial_year' && branch_id = '$userBranchId'";
            $resultSearchSalesNumber  = $con->query($querySearchSalesNumber);

            if ($resultSearchSalesNumber->num_rows == 0) {
                $currentSalesNumber = $_POST['salesNumber'];
            } else {
                $sales = $resultSearchSalesNumber->fetch_assoc();
                $currentSalesNumber = $sales['sales_no'] + 1;
            }
            echo "customer name  =" . $customerName;
            echo "<br>";
            echo "customer id =  " . $customerId;
            echo "<br>";
            echo "current GRN number = " . $currentSalesNumber;
            echo "<br>";
            $querySearchSnoMaster = "update sales_sno_master set sales_no = '$currentSalesNumber'
                                     where financial_year = '$financial_year' && branch_id = '$userBranchId'
                                     && counter_name = '$counterName'";
            $resultSearchSnoMaster = $con->query($querySearchSnoMaster);




            // if(($netAmount - $totalAmount) != 0 ){
            //     $percent = round((($netAmount-$totalAmount)/$totalAmount)*100,2);
            // }else{
            //     $percent = 0;
            // }




            $percent = round((($salesDeductionAmount - $salesAddonAmount) / $salesTotalAmount) * 100, 4);



            $a = 0;
            $itemActualAmount = 0;
            $itemTaxPercentage = 0;
            $itemTaxableAmount = 0;
            $itemTaxAmount = 0;
            $billActualAmount = 0;
            $billTaxableAmount = 0;
            $billTaxAmount    = 0;
            $billIgstAmount = 0;
            $billCgstAmount = 0;
            $billSgstAmount = 0;

            foreach ($design as $des) {

                if ($sales_itemId[$a] != '') {



                    $itemActualAmount = round((float)$sales_itemAmount[$a] - (((float)$sales_itemAmount[$a] * (float)$percent) / 100), 2);
                    $itemTaxPercentage =  str_replace("G", "", $sales_itemTax[$a]);
                    $itemTaxableAmount = round((((float)$itemActualAmount / ((float)$itemTaxPercentage + 100)) * 100), 2);
                    $itemTaxAmount = round(((float)$itemTaxableAmount * (float)$itemTaxPercentage) / 100, 2);


                    $querySalesItem = "insert into sales_item (sales_number, sales_date,
                                counter_name,s_item_id,s_salesperson_code,
                                s_item_qty,s_discount_percentage,s_discount_amount,
                                s_item_amount,s_actual_amount,s_taxable_amount,
                                s_tax_amount,s_s_no,branch_id)
            values('$sales_Number','$salesDate','$counterName','$sales_itemId[$a]',
            '$sales_salesPersonNumber[$a]','$sales_itemQty[$a]','$sales_itemDiscountPercent[$a]',
            '$sales_itemDiscountAmount[$a]','$sales_itemAmount[$a]','$itemActualAmount',   
            '$itemTaxableAmount','$itemTaxAmount','$sales_serialNumber[$a]',
            '$userBranchId')";

                    $resultQuery = $con->query($querySalesItem);

                    $querySearchLandCost = "select*from purchase_item where item_id = '$sales_itemId[$a]'
            && branch_id = '$userBranchId'";
                    $resultSearchLandCost = $con->query($querySearchLandCost)->fetch_assoc();

                    $landCost = $resultSearchLandCost['land_cost'];

                    $queryStockTransaction = "insert into stock_transaction (grn_number, grn_date,
            counter_name,item_id,item_qty,land_cost,entry_type,branch_id)
            values('$sales_Number','$salesDate','$counterName','$sales_itemId[$a]','$sales_itemQty[$a]',
                   '$landCost','S','$userBranchId')";

                    $resultStockTransaction = $con->query($queryStockTransaction);

                    $queryStockBalance = "update stock_balance set item_qty = item_qty-$sales_itemQty[$a]
                        where item_id = '$sales_itemId[$a]' and branch_id = '$userBranchId'";

                    $resultStockBalance = $con->query($queryStockBalance);

                    $billActualAmount = $billActualAmount + $itemActualAmount;
                    $billTaxableAmount = $billTaxableAmount + $itemTaxableAmount;
                    $billTaxAmount    = $billTaxAmount + $itemTaxAmount;

                    $a++;
                }
            }

            if ($salesigstAmount > 0) {

                $billIgstAmount = $billTaxAmount;
                $billCgstAmount = 0;
                $billSgstAmount = 0;
            } else {
                $billIgstAmount = 0;
                $billCgstAmount = $billTaxAmount / 2;
                $billSgstAmount = $billTaxAmount / 2;
            }

            $queryInsertSalesSummary = "insert into sales_summary (sales_number,sales_date,counter_name,customer_id,
                  s_qty,s_amount,s_actual_amount,s_taxable_amount,s_tax_amount,
                  s_cgst_amount,s_sgst_amount,s_igst_amount,s_addon,s_deduction,sales_return_amount,
                  s_net_amount,user_id,branch_id)
                  values('$currentSalesNumber','$salesDate','$counterName','$customerId',
                  '$salesQty','$salesTotalAmount','$billActualAmount','$billTaxableAmount',
                  '$billTaxAmount','$billCgstAmount','$billSgstAmount',
                  '$billIgstAmount','$salesAddonAmount','$salesDeductionAmount','$salesReturnAmount',
                  '$salesNetAmount','$userId','$userBranchId')";



            $resultInsertSalesSummary = $con->query($queryInsertSalesSummary);

            // $resultStockBalance = $con->query($queryStockBalance);


            if ($resultQuery) {

                $_SESSION['notification'] = "Sales Saved Successfully";
                header("Location:" . BASE_URL . "/pages/salesEntry.php");
                $_SESSION['printSales'] = $_POST['printSales'];
            } else {
                echo "something went wrong";
            }
        }


        // sales return starts

        $sr_netAmount = isset($_POST['sr_netAmount']) ? $_POST['sr_netAmount'] : 0;



        if ($sr_netAmount > 0) {


            $customerName =  $_POST['customerName'];
            $sr_design = $_POST['sr_design'];
            echo "Sales Return ";
            echo "<br>";
            echo "<pre>";
            print_r($sr_design);
            echo "</pre>";
            $querySearchCustomerId = "select*from customers where customer_name = '$customerName'
                                  && branch_id = '$userBranchId'";
            $resultSearchCustomerId = $con->query($querySearchCustomerId)->fetch_assoc();
            $customerId = $resultSearchCustomerId['id'];

            $sr_Number = $_POST['salesNumber'];
            $sr_Date = $_POST['salesDate'];
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

                if ($sr_itemId[$a] != '') {




                    $sr_itemActualAmount = round((float)$sr_itemAmount[$a] - (((float)$sr_itemAmount[$a] * (float)$percent) / 100), 2);
                    $sr_itemTaxPercentage =  str_replace("G", "", $sr_itemTax[$a]);
                    $sr_itemTaxableAmount = round((((float)$sr_itemActualAmount / ((float)$sr_itemTaxPercentage + 100)) * 100), 2);
                    $sr_itemTaxAmount = round(((float)$sr_itemTaxableAmount * (float)$sr_itemTaxPercentage) / 100, 2);


                    $querySalesReturnItem = "insert into sales_return_item (sr_number, sr_date,
                                counter_name,sr_item_id,sr_salesperson_code,
                                sr_item_qty,sr_discount_percentage,sr_discount_amount,
                                sr_item_amount,sr_actual_amount,sr_taxable_amount,
                                sr_tax_amount,sr_s_no,branch_id)
                                
            values('$sr_Number','$sr_Date','$counterName','$sr_itemId[$a]',
            '$sr_salesPersonNumber[$a]','$sr_itemQty[$a]','$sr_itemDiscountPercent[$a]',
            '$sr_itemDiscountAmount[$a]','$sr_itemAmount[$a]','$sr_itemActualAmount',   
            '$sr_itemTaxableAmount','$sr_itemTaxAmount','$sr_serialNumber[$a]',
            '$userBranchId')";


                    $resultQuery = $con->query($querySalesReturnItem);


                    $querySearchLandCost = "select*from purchase_item where item_id = '$sr_itemId[$a]'
            && branch_id = '$userBranchId'";
                    $resultSearchLandCost = $con->query($querySearchLandCost)->fetch_assoc();

                    $landCost = $resultSearchLandCost['land_cost'];

                    $queryStockTransaction = "insert into stock_transaction (grn_number, grn_date,
            counter_name,item_id,item_qty,land_cost,entry_type,branch_id)
            values('$sr_Number','$sr_Date','$counterName','$sr_itemId[$a]','$sr_itemQty[$a]',
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




            $queryInsertSalesReturnSummary = "insert into sales_return_summary (sr_number,sr_date,counter_name,customer_id,
        sr_qty,sr_amount,sr_actual_amount,sr_taxable_amount,sr_tax_amount,
        sr_cgst_amount,sr_sgst_amount,sr_igst_amount,sr_addon,sr_deduction,
        sr_net_amount,user_id,branch_id)
        values('$sr_Number','$sr_Date','$counterName','$customerId',
        '$sr_TotalQty','$sr_TotalAmount','$sr_billActualAmount',
        '$sr_billTaxableAmount','$sr_billTaxAmount','$sr_billCgstAmount',
        '$sr_billSgstAmount','$sr_billIgstAmount','$sr_AddonAmount',
        '$sr_DeductionAmount','$sr_NetAmount','$userId','$userBranchId')";

            $resultInsertSalesReturnSummary = $con->query($queryInsertSalesReturnSummary);

            // $sr_resultQuery = $con->query($sr_query);


            // if($resultInsertSalesReturnSummary){

            //     $_SESSION['notification'] = "Sales Return Saved Successfully";            
            //     header("Location:".BASE_URL."/pages/salesEntry.php");

            // }else{
            //     echo "something went wrong";
            // }



        }

        $con->commit();
        header("Location:" . BASE_URL . "/pages/salesEntry.php");
        // exit;
        if (isset($_SESSION['printSales'])) {
            echo $_SESSION['printSales'];
            printSalesBill($salesNumber);
        }
    } catch (Exception $e) {
        $con->rollback();
        $_SESSION['notification'] = "Transaction Failed";

        echo '<script>
document.addEventListener("DOMContentLoaded", function() {
    let toastElement = new bootstrap.Toast(document.getElementById("liveToast"));
    toastElement.show();
});
</script>';
    }
}



function printSalesBill($salesNumber)
{

    $_SESSION['sales_number'] = $salesNumber;

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    header("Location:" . BASE_URL . "/exportFile/pdfFileSalesBillPrint.php");
    exit();
}




?>



<?php include_once(DIR_URL . "/includes/footer.php"); ?>
<?php ob_end_flush(); ?>