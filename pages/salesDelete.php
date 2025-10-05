
<style>

</style>
<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

use function PHPSTORM_META\type;

include_once("../config/config.php");
include_once(DIR_URL."/includes/header.php");
include_once(DIR_URL."/db/dbConnection.php");
include_once(DIR_URL."/includes/navbar.php");
ob_start();
include_once(DIR_URL."/includes/sidebar.php");
// include_once(DIR_URL."includes/itemMaster.php");



$userId= $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$financial_year = $_SESSION['financial_year'];
$companyState = $_SESSION['company_state'];



$customerName = "";
$customerMobile  = "";
$salesNumber = "";
$salesDate = "";
$counterName = "";
$totalQty = 0;
$totalTotal = 0;
$netDiscountPercent = 0;
$deductionAmount = 0;
$addOnAmount = 0;

$salesReturnNetAmount = 0;
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

$querySearchCustomerId = "select*from customers where customer_name = 'Cash'
                              && branch_id = '$userBranchId'";
$resultSearchCustomerId = $con->query($querySearchCustomerId)->fetch_assoc();
    
    


if(isset($_POST['grnNumberSearchButton'])){
    extract($_POST);
    
    
    
    $querySearchSalesItem = "select si.*,i.*
                            from sales_item as si
                            join items as i on i.id  = si.s_item_id
                            where si.sales_number = '$salesNumber' and si.branch_id = '$userBranchId'";
    $resultSearchSalesItem = $con->query($querySearchSalesItem);
    
    
    $querySearchSalesReturnItem = "select sri.*,i.*
                            from sales_return_item as sri
                            join items as i on i.id  = sri.sr_item_id
                            where sri.sr_number = '$salesNumber' and sri.branch_id = '$userBranchId'";
    $resultSearchSalesReturnItem = $con->query($querySearchSalesReturnItem);

    
    
    $querySearchSalesSummary = "select*from sales_summary where sales_number = '$salesNumber'
                                and branch_id = '$userBranchId'";
                                
    $resultSearchSalesSummary = $con->query($querySearchSalesSummary)->fetch_assoc();
    
    
    
        
        
    $s_qty                 = $resultSearchSalesSummary['s_qty'];
    $s_amount              = $resultSearchSalesSummary['s_amount'];
    $s_deduction           = $resultSearchSalesSummary['s_deduction'];
    $s_addon               = $resultSearchSalesSummary['s_addon'];
    $sales_return_amount = $resultSearchSalesSummary['sales_return_amount'];
    $s_net_amount          = $resultSearchSalesSummary['s_net_amount'];
    
    if($sales_return_amount>0){
        $querySearchSalesReturnSummary = "select*from sales_return_summary where sr_number = '$salesNumber'
        and branch_id = '$userBranchId'";
        
        $resultSearchSalesReturnSummary = $con->query($querySearchSalesReturnSummary)->fetch_assoc();
          $sr_qty                = $resultSearchSalesReturnSummary['sr_qty'];
          $sr_amount             = $resultSearchSalesReturnSummary['sr_amount'];
          $sr_deduction          = $resultSearchSalesReturnSummary['sr_deduction'];
          $sr_addon              = $resultSearchSalesReturnSummary['sr_addon'];
          $sr_net_amount         = $resultSearchSalesReturnSummary['sr_net_amount'];
    }
    
    
    
    $afterAddOn = $resultSearchSalesSummary['s_amount']-$resultSearchSalesSummary['s_deduction']+$resultSearchSalesSummary['s_addon'];
    // echo $afterAddOn;
        
}


if (isset($_POST['deleteButton'])) {
    extract($_POST);
    
    $con->begin_transaction(); // Start transaction
    
    try {
        // Update Stock Balance
        $queryUpdateSalesStock = "UPDATE stock_balance sb
                                  INNER JOIN sales_item si ON si.s_item_id = sb.item_id
                                  SET sb.item_qty = sb.item_qty + si.s_item_qty
                                  WHERE si.sales_number = ? AND si.branch_id = ?";
        $stmt = $con->prepare($queryUpdateSalesStock);
        $stmt->bind_param("si", $salesNumber, $userBranchId);
        $stmt->execute();

        // Delete from stock_transaction
        $queryDeleteSalesStockTransaction = "DELETE FROM stock_transaction WHERE grn_number = ? AND branch_id = ?
                                            AND counter_name = ?";
        $stmt = $con->prepare($queryDeleteSalesStockTransaction);
        $stmt->bind_param("sis", $salesNumber, $userBranchId,$counterName);
        $stmt->execute();

        // Delete from sales_item
        $queryDeleteSalesItem = "DELETE FROM sales_item WHERE sales_number = ? AND branch_id = ?
                                 AND counter_name = ?";
        $stmt = $con->prepare($queryDeleteSalesItem);
        $stmt->bind_param("sis", $salesNumber, $userBranchId,$counterName);
        $stmt->execute();

        // Delete from sales_summary
        $queryDeleteSalesSummary = "DELETE FROM sales_summary WHERE sales_number = ? AND branch_id = ?
                                    AND counter_name = ?";
        $stmt = $con->prepare($queryDeleteSalesSummary);
        $stmt->bind_param("sis", $salesNumber, $userBranchId,$counterName);
        $stmt->execute();

        // Delete from sales_return_item
        $queryDeleteSalesReturnItem = "DELETE FROM sales_return_item WHERE sr_number = ? AND branch_id = ?
                                       AND counter_name = ?";
        $stmt = $con->prepare($queryDeleteSalesReturnItem);
        $stmt->bind_param("sis", $salesNumber, $userBranchId,$counterName);
        $stmt->execute();

        // Delete from sales_return_summary
        $queryDeleteSalesReturnSummary = "DELETE FROM sales_return_summary WHERE sr_number = ? AND branch_id = ?
                                          AND counter_name = ?";
        $stmt = $con->prepare($queryDeleteSalesReturnSummary);
        $stmt->bind_param("sis", $salesNumber, $userBranchId,$counterName);
        $stmt->execute();

        // Commit transaction
        $con->commit();

        $_SESSION['notification'] = "Sales Bill Deleted Successfully";
        // header("Location:".BASE_URL."/pages/salesDelete.php");
      

    } catch (Exception $e) {
        $con->rollback(); // Rollback changes on error
        $_SESSION['notification'] = "Error: " . $e->getMessage();
        header("Location:".BASE_URL."/pages/salesDelete.php");
        
    }

    $customerName = "";
    $customerMobile = "";
    $salesNumber = "";
    $salesDate = "";
    $counterName = "";
    

    // header("Location:".BASE_URL."/pages/salesDelete.php");
}


// if(isset($_POST['deleteButton'])){
//     extract($_POST);
                
//         $queryUpdateSalesStock = "update stock_balance sb
//                                   inner join sales_item  si on si.s_item_id  = sb.item_id
//                                   set sb.item_qty = sb.item_qty + si.s_item_qty
//                                   where si.sales_number = '$salesNumber' and si.branch_id = '$userBranchId'
//         ";
//         $resultUpdateSalesStock = $con->query($queryUpdateSalesStock);
        
        
//         $queryDeleteSalesStockTransaction = "delete from stock_transaction where 
//                                             grn_number = '$salesNumber' and branch_id = '$userBranchId'
//                                             ";
//         $resultDeleteSalesStockTransaction = $con->query($queryDeleteSalesStockTransaction);       
        
        
//         $queryDeleteSalesItem = "delete from sales_item where sales_number = '$salesNumber'
//                                 and branch_id = '$userBranchId'";
//         $resultDeleteSalesItem = $con->query($queryDeleteSalesItem);
        
//         $queryDeleteSalesSummary = "delete from sales_summary  where sales_number = '$salesNumber'
//                                     and branch_id = '$userBranchId'    
//                                     ";
//         $resultDeleteSalesSummary = $con->query($queryDeleteSalesSummary);
        
        
        
//         $queryDeleteSalesReturnItem = "delete from sales_return_item where sr_number = '$salesNumber'
//                                 and branch_id = '$userBranchId'";
//         $resultDeleteSalesReturnItem = $con->query($queryDeleteSalesReturnItem);
        
//         $queryDeleteSalesReturnSummary = "delete from sales_return_summary  where sr_number = '$salesNumber'
//                                     and branch_id = '$userBranchId'    
//                                     ";
//         $resultDeleteSalesReturnSummary = $con->query($queryDeleteSalesReturnSummary);
        
        
//         $_SESSION['notification'] = "Sales Bill Deleted Successfully";
//         $customerName = "";
//         $customerMobile = "";
//         $salesNumber = "";
//         $salesDate = "";
//         $counterName = "";
//         // header("Location:".BASE_URL."/pages/salesDelete.php");
// }





?>

<script>

    
</script>





<style>
.nav-tabs .nav-link.active#home-tab {
    background-color: #4CAF50 !important; /* Green for Sales */
    color: white !important;
}

.nav-tabs .nav-link.active#profile-tab {
    background-color:rgba(214, 46, 16, 0.78) !important; /* Orange-Red for Sales Return */
    color: white !important;
}


</style>
<?php 
$querySearchSnoMaster = "select*from sales_sno_master where counter_name = '$_SESSION[counter_name]'
                         && financial_year = '$financial_year'
                         && branch_id='$userBranchId' ";
$resultSearchSnoMaster  = $con->query($querySearchSnoMaster)->fetch_assoc();
$sales_no = $resultSearchSnoMaster['sales_no'];
$sales_no = $sales_no+1;

if(isset($sales_no)){
    
}else{
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


#duplicateCustomerMobile{
    width:120px;
    height:30px;
    margin-top:-80px;
    margin-left:819px;
    display: none;
    
}

#salesDelete{

    margin-left:5px;margin-top:-120px;
    width: 340px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    padding: 4px 79px;
    height: 30px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    letter-spacing:5px;
    font-weight:bolder;
    background-color: red;
    /* background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%); */
    color: white;
    border-radius: 5px;
    /*box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);*/
    background-color:#DC3545;
    /*background-color:rgba(224, 46, 26, 100) !important; Orange-Red for Sales Return */
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

    background-color:white;
    color: black;
}

#totalQty{
    background-color:gainsboro;
}
#totalAmount{
    background-color:gainsboro;
}
#netAmount{
    background-color:gainsboro;
}
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
    margin-top:-120px;
    /* margin-left:300px; */
    width: 400px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
}

#customerId{
    margin-top:-120px;
    /* margin-left:300px; */
    /* display: none; */
    width: 80px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
}

#grnAmount{
    margin-top:-100px;
    /* margin-left:1000px; */
    width: 150px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
}

#salesNumber,#salesDate{
    margin-top:20px;
    margin-left: 15px;
    width: 140px;
    font-size: 13px;
    font-weight: bold;
    text-transform: capitalize;
    height: 48px;
}

#counterName{
    margin-top:10px;
    margin-left: 15px;
    
    width: 140px;
    font-size: 13px;
    font-weight:800;
    text-transform: capitalize;
    height: 48px;

}


</style>
<!-- Bootstrap Toast -->

<?php 
    if(isset($_SESSION['notification'])){
        
    }else{
    
        $_SESSION['notification'] = "";
    }
?>
<?php if($_SESSION['notification'] != ''){?>
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
<div class="" style="margin-left:1160px;border:1px solid black;width:340px;height:140px;margin-top:10px;">
        

        
                <div style="display:flex;gap:10px;">
                    <div class="form-floating">
                        <input type="text" name="salesNumber" id="salesNumber"   class="form-control" placeholder="Bill Number" value="<?php echo $salesNumber; ?>" autocomplete="off"  maxlength="30" style="background-color:blanchedalmond;">
                        <label for="salesNumber" style="margin-left:6px;margin-top:12px;font-size:large;font-weight:bold;">Bill Number</label>
                    </div>          
                    <div class="form-floating">
                        <input type="date" name="salesDate" readonly id="salesDate" class="form-control" placeholder="Bill Date " value="<?php echo $salesDate;?>"  maxlength="30" >
                        <label for="salesDate" style="margin-left:15px;margin-top:15px;font-size:large;font-weight:bold">Bill Date</label>
                    </div>          
                </div>
                
                <div style="display: flex;">
                  <div class="form-floating">
                        <input type="text" name="counterName" readonly id="counterName" class="form-control"  value="<?php echo $counterName;?>"  maxlength="4">
                        <label for="counterName" style="margin-left:15px;margin-top:5px;font-size:large;font-weight:bold">Counter</label>
                        <button type="submit" name="grnNumberSearchButton" id="grnSearchButton" style="width:22px;height:25px;position:absolute;left:220px;top:20px" hidden>S</button>
                  </div>          
                  
            </div>
                
              
</div>
<div style="margin-top:-20px;margin-left:-12px">

<div style="display:flex;gap:12px">
        <label for="" style="margin-left:280px;margin-top:-118px;">Customer Name</label>
        <input type="text" name="customerName" readonly autocomplete="off" id="customerName"  class="form-control" value="<?php echo $customerName; ?>">
        
        <input type="text" hidden name="customerId" id="customerId" class="form-control" value="<?php echo $resultSearchCustomerId['id']; ?>">
        <label for=""  id="salesDelete">SALES DELETE</label>
</div>
        <div style="display:flex;gap:6px">
        <label for="" style="margin-left:280px;margin-top:-78px;">Customer Mobile</label>
        <input type="text" readonly style="width:280px;height:30px;margin-top:-80px;" name="customerMobile" value="<?php echo $customerMobile;?>"  autocomplete="off" id="customerMobile" maxlength="10" class="form-control">
                
                
                
                
                
                        
                
                
                
        
        </div>
        
        <div style="diay:flex;gap:6px">
        <input type="text"  name="duplicateCustomerMobile"  autocomplete="off" id="duplicateCustomerMobile" maxlength="10" class="form-control">
        </div>
        
        
<br>


</div>

<div style="display:flex" hidden>
                <label for="" style="margin-left:200px;">User Id</label>
                <input type="text" name="userId" readonly id="userId" class="form-control" value="<?php echo $userId;?>" style="width:250px;">
                <label for="">Branch Id</label>
                <input type="text" name="userBranchId" readonly id="userBranchId" class="form-control" value="<?php echo $userBranchId;?>" style="width:250px;">
</div>
            
<!-- Tab Navigation -->
<ul class="nav nav-tabs" id="myTab" role="tablist" style="width: 300px;margin-left:275px;margin-top:-50px">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#sales" type="button" role="tab">Sales</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#salesReturn" type="button" role="tab">Sales Return</button>
    </li>
</ul>

<!-- Tab Content -->
<div class="tab-content mt-2" id="myTabContent">
    <div class="tab-pane fade show active" id="sales" role="tabpanel">
        <!-- Sales Tab Content Start-->
        <div class="container" style="margin-top:10px" id="itemGrid">
            <!-- Your Sales Content Here -->
        
            <div style="margin-left: 165px; font-size: 11px;">
    <div style="width: 1250px; height: 220px; overflow-y: auto;overflow-x:auto" id="itemTable">
        <table class="table text-white" style="border-collapse: collapse; width: 1240; text-align: center;font-size:11px">
            <thead>
                <tr style="position: sticky; z-index: 1; top: 0; background-color: #FF3CAC;">
                    <th style="width: 21px;">S.No.</th>
                    <th style="width: 100px;">Design</th>
                    <th style="width: 100px;">Description</th>
                    <th style="width: 50px;">HSN</th>
                    <th style="width: 10px;">Tax</th>
                    <th style="width: 50px;">Selling</th>
                    <th style="width: 80px;">Sales Man</th>
                    <th style="width: 10px;">Qty</th>
                    <th style="width: 80px;">Disc %</th>
                    <th style="width: 120px;">Discount Amount</th>
                    <th style="width: 110px;">Amount</th>
                    <th style="width: 20px;">Id</th>
                </tr>
            </thead>
            <tbody id="table_body" class="items">
                <?php 
                if(isset($resultSearchSalesItem) && isset($grnNumberSearchButton)) {
                    $sno = 1;
                    foreach ($resultSearchSalesItem as $salesData) {
                    
                        $description = $salesData['product_name']."/".$salesData['brand_name']."/".
                     $salesData['color_name']."/".$salesData['batch_name']."/".$salesData['tax_code']."/".
                     $salesData['size_name']."/".$salesData['mrp'];
                    ?>
                        <tr>
                            <td><?php echo $salesData['s_s_no']; ?></td>
                            <td style=""><?php echo htmlspecialchars($salesData['design_name']); ?></td>
                            <td><?php echo htmlspecialchars($description); ?></td>
                            <td><?php echo htmlspecialchars($salesData['hsn_code']); ?></td>
                            <td><?php echo htmlspecialchars($salesData['tax_code']); ?></td>
                            <td><?php echo htmlspecialchars($salesData['selling_price']); ?></td>
                            <td><?php echo htmlspecialchars($salesData['s_salesperson_code']); ?></td>
                            <td><?php echo htmlspecialchars($salesData['s_item_qty']); ?></td>
                            <td><?php echo htmlspecialchars($salesData['s_discount_percentage']); ?></td>
                            <td><?php echo htmlspecialchars($salesData['s_discount_amount']); ?></td>
                            <td><?php echo htmlspecialchars($salesData['s_item_amount']); ?></td>
                            <td><?php echo htmlspecialchars($salesData['s_item_id']); ?></td>
                        </tr>
                <?php } } ?>
            </tbody>
        </table>
    </div>
</div>      

    
            
            
      
<div style="display: flex;margin-top:20px">
    <button
        style="margin-left:180px;width:120px;"
        type="submit"
        class="btn btn-danger" name="deleteButton" id="deleteButton"   onclick="return confirm('Are You Sure Do You Want To Delete This Sales Bill')">
        Delete
    </button>
    
    <button
        type="submit"
        style="margin-left:10px;width:120px;"
        class="btn btn-warning" name="cancelButton" id="cancelButton">
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
<input type="text" value="<?php echo $s_qty; ?>" name="totalQty" id="totalQty" class="form-control" readonly style="text-align:right;font-size:13px;height:25px;width:50px;" maxlength="4">
<input type="text" value="<?php echo $s_amount; ?>" name="totalAmount" id="totalAmount" class="form-control" readonly style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
<input type="text" name="totalActualAmount" id="totalActualAmount" hidden class="form-control" readonly style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
<input type="text" name="totalTaxable" id="totalTaxable" hidden readonly 
style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px" class="form-control" maxlength="12"
>
<input type="text" name="totalTaxAmount" id="totalTaxAmount" hidden readonly 
style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px" class="form-control" maxlength="12"
>
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
<input type="text" name="netDiscountPercent" value="<?php echo $netDiscountPercent; ?>" readonly id="netDiscountPercent" class="form-control" 
autocomplete="off"    
maxlength="4"
style="width:51px;height:25px">
<!-- <label for="">Discount </label> -->
<input type="text" value="<?php echo $s_deduction;?>" name="deductionAmount" readonly id="deductionAmount" autocomplete="off" class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;"  maxlength="12">
</div>

<div style="display:flex;margin-top:5px;">

<label for="" style="margin-left: -11px;">Add On</label>
<input type="text" value="<?php  echo $s_addon; ?>" name="addOnAmount" id="addOnAmount" readonly autocomplete="off" class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:40px" maxlength="12">
</div>

<div style="display:flex;margin-top:5px">
<label for="" style="margin-left:-11px;">After Add On</label>
<input type="text" value="<?phP echo $afterAddOn;?>" name="afterAddOn" id="afterAddOn" class="form-control"  readonly style="font-weight:bold;text-align:right;font-size:12px;height:25px;width:90px;margin-left:1px" maxlength="12">
</div>
<div style="display:flex;margin-top:5px">
<label for="" style="margin-left:-11px;color:red;">Sales Return</label>
<input type="text" value="<?php echo $sales_return_amount; ?>" name="salesReturnNetAmount" id="salesReturnNetAmount" class="form-control"  readonly style="font-weight:bold;color:red;text-align:right;font-size:12px;height:25px;width:90px;margin-left:8px" maxlength="12">
</div>

<div style="display:flex;margin-top:5px;">
<label for="" style="margin-left: -11px;color:green;font-size:15px;font-weight:bolder;margin-top:2px">Net Amount</label>
<input type="text" value="<?php echo $s_net_amount;?>"  name="netAmount" id="netAmount" class="form-control"  readonly style="font-weight:bolder;color:green;text-align:right;font-size:15px;height:30px;width:90px;margin-left:8px" maxlength="12">

</div>
</div>
</div>
    <!-- Sales Tab Content End-->
    
    <!-- Sales Return Tab Content Start-->
    <div class="tab-pane fade" id="salesReturn" role="tabpanel" >
        
        <!-- Add your Sales Return content here -->
        <div class="container" style="margin-top:10px" id="itemGrid">
        <div style="margin-left: 165px; font-size: 11px;">
    <div style="width: 1250px; height: 220px; overflow-y: auto;overflow-x:auto" id="itemTable">
        <table class="table text-white" style="border-collapse: collapse; width: 1240; text-align: center;font-size:11px">
            <thead>
                <tr style="position: sticky; z-index: 1; top: 0; background-color: #FF3CAC;">
                    <th style="width: 21px;">S.No.</th>
                    <th style="width: 100px;">Design</th>
                    <th style="width: 100px;">Description</th>
                    <th style="width: 50px;">HSN</th>
                    <th style="width: 10px;">Tax</th>
                    <th style="width: 50px;">Selling</th>
                    <th style="width: 80px;">Sales Man</th>
                    <th style="width: 10px;">Qty</th>
                    <th style="width: 80px;">Disc %</th>
                    <th style="width: 120px;">Discount Amount</th>
                    <th style="width: 110px;">Amount</th>
                    <th style="width: 20px;">Id</th>
                </tr>
            </thead>
            <tbody id="table_body" class="items">
                <?php 
                if(isset($resultSearchSalesReturnItem) && isset($grnNumberSearchButton)) {
                    $sno = 1;
                    foreach ($resultSearchSalesReturnItem as $salesReturnData) {
                    
                        $description = $salesReturnData['product_name']."/".$salesReturnData['brand_name']."/".
                     $salesReturnData['color_name']."/".$salesReturnData['batch_name']."/".$salesReturnData['tax_code']."/".
                     $salesReturnData['size_name']."/".$salesReturnData['mrp'];
                     
                     $sr_totalQty = $salesReturnData['sr_item_qty'];
                     $sr_totalAmount = $salesReturnData['sr_item_amount'];
                     $sr_netDiscountAmount = $salesReturnData['sr_discount_amount'];
                    //  $sr_AddonAmount = $salesReturnData['sr_'];
                     
                    ?>
                        <tr>
                            <td><?php echo $salesReturnData['sr_s_no']; ?></td>
                            <td style=""><?php echo htmlspecialchars($salesReturnData['design_name']); ?></td>
                            <td><?php echo htmlspecialchars($description); ?></td>
                            <td><?php echo htmlspecialchars($salesReturnData['hsn_code']); ?></td>
                            <td><?php echo htmlspecialchars($salesReturnData['tax_code']); ?></td>
                            <td><?php echo htmlspecialchars($salesReturnData['selling_price']); ?></td>
                            <td><?php echo htmlspecialchars($salesReturnData['sr_salesperson_code']); ?></td>
                            <td><?php echo htmlspecialchars($salesReturnData['sr_item_qty']); ?></td>
                            <td><?php echo htmlspecialchars($salesReturnData['sr_discount_percentage']); ?></td>
                            <td><?php echo htmlspecialchars($salesReturnData['sr_discount_amount']); ?></td>
                            <td><?php echo htmlspecialchars($salesReturnData['sr_item_amount']); ?></td>
                            <td><?php echo htmlspecialchars($salesReturnData['sr_item_id']); ?></td>
                        </tr>
                <?php } } ?>
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
        <div style="margin-left:1180px;margin-top:-40px">
            <div style="display:flex;gap:8px">
            <label for="" style="margin-left:-12px">Total</label>
            <input type="text" value="<?php echo $sr_qty;?>" name="sr_totalQty" id="sr_totalQty" class="form-control" readonly style="text-align:right;font-size:13px;height:25px;width:50px;" maxlength="4">
            <input type="text" value="<?php echo $sr_amount;?>" name="sr_totalAmount" id="sr_totalAmount" class="form-control" readonly style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
            <input type="text"  name="sr_totalActualAmount" id="sr_totalActualAmount" hidden class="form-control" readonly style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
            <input type="text"  name="sr_totalTaxable" id="sr_totalTaxable" hidden readonly 
            style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px" class="form-control" maxlength="12"
            >
            <input type="text" name="sr_totalTaxAmount" id="sr_totalTaxAmount" hidden readonly 
            style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px" class="form-control" maxlength="12"
            >
            </div>
            
            <div style="display:flex;margin-top:5px;margin-left:-11px;gap:2px">
            <label for="">Dis %</label>
            <input type="text"  name="sr_netDiscountPercent" id="sr_netDiscountPercent" class="form-control" 
            autocomplete="off"
            maxlength="4"
            style="width:51px;height:25px">
            <!-- <label for="">Discount </label> -->
            <input type="text" value="<?php echo $sr_deduction; ?>" name="sr_deductionAmount" id="sr_deductionAmount" autocomplete="off" class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;"  maxlength="12">
            </div>
            
            <div style="display:flex;margin-top:5px;">
            
            <label for="" style="margin-left: -11px;">Add On</label>
            <input type="text" value="<?php echo $sr_addon; ?>" name="sr_addOnAmount" id="sr_addOnAmount" autocomplete="off" class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:40px" maxlength="12">
            </div>
            
            
            <div style="display:flex;margin-top:5px;">
            <label for="" style="margin-left: -11px;color:red;font-size:15px;font-weight:bolder;margin-top:2px">Net Amount</label>
            <input type="text" value="<?php echo $sr_net_amount; ?>" name="sr_netAmount" id="sr_netAmount" class="form-control"  readonly style="font-weight:bolder;color:red;text-align:right;font-size:15px;height:30px;width:90px;margin-left:8px" maxlength="12">
            
            </div>
    </div>    
        
    </div>
    <!-- Sales Return Tab Content End-->
</div>



</form>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    
    
    
    
    
    

    document.addEventListener("keydown",function(event){
        if(event.key === "F5"){
            event.preventDefault();
            
            let confirmRefresh = confirm("Are you sure you want to refresh? Your unsaved data will be lost.");
            if(confirmRefresh){
                location.reload();
            }
        }
    })
    
    
    // Fetching Sales Summary Data For Bill Print Starts
    
    document.getElementById("salesNumber").addEventListener("keydown", function(event){
            let target  = event.target;
            if(event.key === "F2"){
                event.preventDefault();
                let salesNumber = new FormData();
                salesNumber.append("lb_sales_number", target.value);
                let aj_salesNumber = new XMLHttpRequest();
                aj_salesNumber.open("POST","ajaxSalesBillDelete.php",true);
                aj_salesNumber.send(salesNumber);
                aj_salesNumber.onreadystatechange = function(){
                    if(aj_salesNumber.status === 200 && aj_salesNumber.readyState === 4){
                            document.getElementById("response_message").innerHTML = aj_salesNumber.responseText;
                            document.getElementById("deleteButton").focus();
                
                    }
                }
                
            }
            
    })
    
    

    
    
    
    
    
    
    
    
    
    
    
    window.onload = function(){
        
        
        
        
        let sales_number = document.getElementById("salesNumber").value;
        if(sales_number!=''){
            document.getElementById("salesNumber").setAttribute('readonly',true);
        }
    
        
        
        
        
        
        
        localStorage.setItem('customer_state', '1');
        localStorage.setItem('sales_return','0');
        let customerState  = localStorage.getItem("customer_state");
        
        
        
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
        
        
        localStorage.setItem("total_rows",1);
        localStorage.setItem("sr_row_index",1);
        localStorage.setItem("sr_total_rows",1);
        let mydate = new Date();
        let currentDate = mydate.getFullYear() + "-" + 
                         (mydate.getMonth() + 1).toString().padStart(2, "0") + "-" + 
                          mydate.getDate().toString().padStart(2, "0");
        // document.getElementById("salesDate").value = currentDate;
        
        
        // document.getElementById("SalesNumber").value = '<?php echo htmlspecialchars($sales_no);?>';
        
        
    }
    
    let salesNumber = document.getElementById("salesNumber").value;
    if(salesNumber==""){
        document.getElementById("deleteButton").disabled = true;
        document.getElementById("cancelButton").style.display = "none";
    }else{
        
        document.getElementById("deleteButton").disabled = false;
        document.getElementById("deleteButton").focus();
        document.getElementById("cancelButton").style.display = "block";
    }
    
    let rowIndex =localStorage.getItem("row_index");
    









setTimeout(() => {
   var alertBox = document.getElementById("liveToast");
    if(alertBox){
        alertBox.style.display='none';
    }
}, 2000);

</script>

</body>
</html>

<?php
    
    
    
    
    
if(isset($_POST['submit_button'])){
    
    $customerName            =  $_POST['customerName'];
    $customerId              = $_POST['customerId'];
    $counterName             = $_POST['counterName'];
    
    
    
    $salesNumber = $_SESSION['sales_number'] = $_POST['salesNumber'];
    // $salesDate = $_POST['salesDate'];
    
    date_default_timezone_set("Asia/Kolkata");
    $salesDate = date("Y-m-d h:i:s A");
    
    
    echo "current data and time  = ".$salesDate;
    
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
    $salesAddonAmount        = isset($_POST['addOnAmount'])? $_POST['addOnAmount'] : 0;
    $salesDeductionAmount    = isset($_POST['deductionAmount']) ? $_POST['deductionAmount'] : 0;
    $salesReturnAmount       = isset($_POST['salesReturnNetAmount']) ? $_POST['salesReturnNetAmount'] : 0;
    $salesNetAmount          = isset($_POST['netAmount']) ? $_POST['netAmount'] : 0;
    
    echo $salescgstAmount     ;
    echo "<br>";
    echo $salessgstAmount     ;
    echo "<br>";
    echo $salesigstAmount     ;
    echo "<br>";
    echo $salesAddonAmount    ;
    echo "<br>";
    echo $salesDeductionAmount;
    echo "<br>";
    echo $salesReturnAmount   ;
    echo "<br>";
    echo $salesNetAmount      ;
    echo "<br>";
    
    
    
    
     
    
    if($netAmount>=0 && $design[0] != ''){
            echo "iam in";
            
            $salesNumber = $_POST['salesNumber'];
            // $salesDate = $_POST['salesDate'];
            $querySearchSalesNumber = "select*from sales_sno_master where counter_name = '$counterName' && 
                                     financial_year = '$financial_year' && branch_id = '$userBranchId'";
            $resultSearchSalesNumber  = $con->query($querySearchSalesNumber);
            
            if($resultSearchSalesNumber->num_rows==0){
                $currentSalesNumber = $_POST['salesNumber'];
            }else{
                $sales = $resultSearchSalesNumber->fetch_assoc();
                $currentSalesNumber = $sales['sales_no']+1;
            }
            echo "customer name  =".$customerName;
            echo "<br>";
            echo "customer id =  ".$customerId;
            echo "<br>";
            echo "current GRN number = ".$currentSalesNumber;
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
            


            
            $percent = round((($salesDeductionAmount -$salesAddonAmount     )/$salesTotalAmount)*100,4);
        
        
        
        $a=0;
        $itemActualAmount = 0;
        $itemTaxPercentage = 0;
        $itemTaxableAmount = 0;
        $itemTaxAmount = 0;
        $billActualAmount =0;
        $billTaxableAmount=0;
        $billTaxAmount    =0;
        $billIgstAmount = 0;
        $billCgstAmount = 0;
        $billSgstAmount = 0;
        
        foreach($design as $des){
            
            $itemActualAmount = round($sales_itemAmount[$a]-(($sales_itemAmount[$a]*$percent)/100),2);
            $itemTaxPercentage =  str_replace("G","",$sales_itemTax[$a]);            
            $itemTaxableAmount = round((($itemActualAmount/($itemTaxPercentage+100))*100),2);
            $itemTaxAmount = round(($itemTaxableAmount*$itemTaxPercentage)/100,2);
            
            
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
            
            $queryStockTransaction = "insert into stock_transaction (grn_number, grn_date,item_id,
                                  item_qty,land_cost,entry_type,branch_id)
            values('$sales_Number','$salesDate','$sales_itemId[$a]','$sales_itemQty[$a]',
                   '$landCost','S','$userBranchId')";
                   
            $resultStockTransaction = $con->query($queryStockTransaction);
                        
                        $queryStockBalance = "update stock_balance set item_qty = item_qty-$sales_itemQty[$a]
                        where item_id = '$sales_itemId[$a]' and branch_id = '$userBranchId'";
                        
                        $resultStockBalance = $con->query($queryStockBalance);
                        
                        $billActualAmount =$billActualAmount+$itemActualAmount;  
                        $billTaxableAmount=$billTaxableAmount+$itemTaxableAmount; 
                        $billTaxAmount    =$billTaxAmount+$itemTaxAmount;     
                    $a++;            
        }
        
        if($salesigstAmount>0){
            
          $billIgstAmount = $billTaxAmount;     
          $billCgstAmount =0;
          $billSgstAmount =0;
        }else{
            $billIgstAmount =0;
            $billCgstAmount = $billTaxAmount/2;     
            $billSgstAmount = $billTaxAmount/2;     
            
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
            
           
            if($resultQuery){
                
                $_SESSION['notification'] = "Sales Saved Successfully";            
                header("Location:".BASE_URL."/pages/salesDelete.php");
                $_SESSION['printSales'] = $_POST['printSales'];
                
                
            }else{
                echo "something went wrong";
            }
    
    
    }
        
        
        // sales return starts
        
        $sr_netAmount = isset($_POST['sr_netAmount']) ? $_POST['sr_netAmount'] : 0;
    
    
    
    if($sr_netAmount > 0){
    
        
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
            $sr_AddonAmount        = isset($_POST['sr_addOnAmount'])? $_POST['sr_addOnAmount'] : 0;
            $sr_DeductionAmount    = isset($_POST['sr_deductionAmount']) ? $_POST['sr_deductionAmount']:0;
            $sr_NetAmount          = isset($_POST['sr_netAmount'])?$_POST['sr_netAmount']:0;
            
            
            // if(($sr_netAmount - $sr_totalAmount) != 0 ){
            //     $sr_percent = round((($sr_netAmount-$sr_totalAmount)/$sr_totalAmount)*100,2);
            // }else{
            //     $sr_percent = 0;
            // }
            
            $percent = round((($sr_DeductionAmount -$sr_AddonAmount     )/$sr_TotalAmount)*100,4);
            
        
            
                  
        
        
        
        $a=0;
        $sr_itemActualAmount = 0;
        $sr_itemTaxPercentage = 0;
        $sr_itemTaxableAmount = 0;
        $sr_itemTaxAmount = 0;
        $sr_billActualAmount =0;
        $sr_billTaxableAmount=0;
        $sr_billTaxAmount    =0;
        $sr_billIgstAmount = 0;
        $sr_billCgstAmount = 0;
        $sr_billSgstAmount = 0;
    
        foreach($sr_design as $des){
            
            $sr_itemActualAmount = round($sr_itemAmount[$a]-(($sr_itemAmount[$a]*$percent)/100),2);
            $sr_itemTaxPercentage =  str_replace("G","",$sr_itemTax[$a]);            
            $sr_itemTaxableAmount = round((($sr_itemActualAmount/($sr_itemTaxPercentage+100))*100),2);
            $sr_itemTaxAmount = round(($sr_itemTaxableAmount*$sr_itemTaxPercentage)/100,2);

            
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
            
            $queryStockTransaction = "insert into stock_transaction (grn_number, grn_date,item_id,
                                  item_qty,land_cost,entry_type,branch_id)
            values('$sr_Number','$sr_Date','$sr_itemId[$a]','$sr_itemQty[$a]',
                   '$landCost','SR','$userBranchId')";
                   
            $resultStockTransaction = $con->query($queryStockTransaction);
                   
                   
                        
                        $queryStockBalance = "update stock_balance set item_qty = item_qty+$sr_itemQty[$a]
                        where item_id = '$sr_itemId[$a]' and branch_id = '$userBranchId'";
                        
                        $resultStockBalance = $con->query($queryStockBalance);
                        
                                                   
                        $sr_billActualAmount =$sr_billActualAmount+$sr_itemActualAmount;  
                        $sr_billTaxableAmount=$sr_billTaxableAmount+$sr_itemTaxableAmount; 
                        $sr_billTaxAmount    =$sr_billTaxAmount+$sr_itemTaxAmount;     

                
                
                    
                    $a++;            
                    
        }
                
        if($salesigstAmount>0){
            
            $sr_billIgstAmount = $sr_billTaxAmount;     
            $sr_billCgstAmount =0;
            $sr_billSgstAmount =0;
          }else{
              $sr_billIgstAmount =0;
              $sr_billCgstAmount = $sr_billTaxAmount/2;     
              $sr_billSgstAmount = $sr_billTaxAmount/2;     
              
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
            //     header("Location:".BASE_URL."/pages/salesDelete.php");
                
            // }else{
            //     echo "something went wrong";
            // }
    
    
    
    }
        
    
    

   
}



    function printSalesBill($salesNumber){
    
        $_SESSION['sales_number'] = $salesNumber;
            
        
        // header("Location:".BASE_URL."exportFile/pdfFileSalesBillPrint.php");
        // exit();
    }
    

    

?>


<?php ob_end_flush(); ?>
<?php include_once(DIR_URL."/includes/footer.php");?>