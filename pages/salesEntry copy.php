
<style>

</style>
<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

use function PHPSTORM_META\type;

include_once("../config/config.php");
include_once(DIR_URL."includes/header.php");
include_once(DIR_URL."db/dbConnection.php");
include_once(DIR_URL."includes/navbar.php");
ob_start();
include_once(DIR_URL."includes/sidebar.php");
// include_once(DIR_URL."includes/itemMaster.php");



$userId= $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$financial_year = $_SESSION['financial_year'];
$companyState = $_SESSION['company_state'];


// if(isset($_SESSION['item_id'])){
//     $itemId = $_SESSION['item_id'];
//     echo "item id = ".$itemId;
// }


?>

<script>

    
</script>






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

#salesEntry{

    margin-left:5px;margin-top:-120px;
    width: 340px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    padding: 4px 58px;
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
    display: none;
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
                        <input type="text" name="salesNumber" id="salesNumber" readonly class="form-control" placeholder="Sales Number" value="<?php echo $sales_no; ?>" autocomplete="off"  maxlength="30">
                        <label for="salesNumber" style="margin-left:6px;margin-top:12px;font-size:large;font-weight:bold">Sales Number</label>
                    </div>          
                    <div class="form-floating">
                        <input type="date" name="salesDate" readonly id="salesDate" class="form-control" placeholder="Sales Date " value=""  maxlength="30">
                        <label for="salesDate" style="margin-left:15px;margin-top:15px;font-size:large;font-weight:bold">Sales Date</label>
                    </div>          
                </div>
                <div class="form-floating">
                        <input type="text" name="counterName" readonly id="counterName" class="form-control"  value="<?php echo $_SESSION['counter_name']; ?>"  maxlength="4">
                        <label for="counterName" style="margin-left:15px;margin-top:5px;font-size:large;font-weight:bold">Counter</label>
                </div>          
              
</div>
<div style="margin-top:-20px;margin-left:-12px">

<div style="display:flex;gap:12px">
        <label for="" style="margin-left:280px;margin-top:-118px;">Customer Name</label>
        <input type="text" name="customerName" autocomplete="off" id="customerName"  class="form-control" placeholder="Press F2 For Customer Info">
        
        <input type="text" name="customerId" id="customerId" class="form-control">
        <label for=""  id="salesEntry">SALES ENTRY</label>
</div>
        <div style="display:flex;gap:6px">
        <label for="" style="margin-left:280px;margin-top:-78px;">Customer Mobile</label>
        <input type="text" style="width:280px;height:30px;margin-top:-80px;" name="customerMobile" placeholder="Press F2 For Mobile Info" autocomplete="off" id="customerMobile" maxlength="10" class="form-control">
        </div>
        
        <div style="display:flex;gap:6px">
        <input type="text"  name="duplicateCustomerMobile"  autocomplete="off" id="duplicateCustomerMobile" maxlength="10" class="form-control">
        </div>
        
<br>


</div>


<!-- Tab Navigation -->
<ul class="nav nav-tabs" id="myTab" role="tablist" style="width: 300px;margin-left:265px;margin-top:-50px">
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
        <!-- Sales Content -->
        <div class="container" style="margin-top:10px" id="itemGrid">
            <!-- Your Sales Content Here -->
            <div>
                <?php
                    // if(isset($_SESSION['product'])){
                    //     print_r($_SESSION['product']);
                    // }
                ?>
            </div>
            <div style="display:flex" hidden>
                <label for="" style="margin-left:200px;">User Id</label>
                <input type="text" name="userId" readonly id="userId" class="form-control" value="<?php echo $userId;?>" style="width:250px;">
                <label for="">Branch Id</label>
                <input type="text" name="userBranchId" readonly id="userBranchId" class="form-control" value="<?php echo $userBranchId;?>" style="width:250px;">
            </div>

            <div style="margin-left:165px;font-size:12px;">
                <div style="width:1235px;height:270px;overflow-y:auto;" id="itemTable">
                    <table class="table text-white table-dark" style="font-size:11px;border-collapse:collapse;width:100%;">
                        <thead>
                            <tr style="position:sticky;z-index:1;top:0;background-color:#FF3CAC">
                                <th style="padding-left:5px">S.No.</th>
                                <th style="padding-left:4px">Design</th>
                                <th style="padding-left:0px;width:20px">Description</th>
                                <th style="padding-left:-15px">HSN</th>
                                <th style="padding-left:0px">Tax</th>
                                <th style="padding-left:5px">Selling</th>
                                <th style="padding-left:5px">Salesman</th>
                                <th style="padding-left:0px">Qty</th>
                                <th style="padding-left:0px;width:50px;">Disc %</th>
                                <th style="padding-left:0px;">Disc.Amt</th>
                                <th style="padding-left:0px">Amount</th>
                                <th style="padding-left:0px">Actual</th>
                                <th style="padding-left:0px">Taxable</th>
                                <th style="padding-left:0px">Tax Amt</th>
                                <th >Id</th>
                                <th style="padding-left:2px">Action</th>
                            </tr>
                        </thead>
                        <tbody class="items" id="table_body">
                            <tr>
                                <td>
                                    <input type="text" class="serial-field" name="serialNumber[]" id="serialNumber_1" style="font-size:12px;height:25px;width:60px;margin-left:1px;" maxlength="4" autocomplete="off" value="1" readonly />
                                </td>
                                <td>
                                    <input type="text" class="design-field form" name="design[]" id="design_1" autocomplete="off" style="font-size:12px;height:25px;width:160px;margin-left:-29px;" maxlength="30" />
                                </td>
                                <td>
                                    <input type="text" class="description-field" name="description[]" id="description_1" autocomplete="off" style="font-size:12px;height:25px;width:400px;margin-left:-9px;" maxlength="150" readonly />
                                </td>
                                
                                <td>
                                    <input type="text" class="hsnCode-field" name="hsnCode[]" id="hsnCode_1" autocomplete="off" style="font-size:13px;height:25px;width:65px;margin-left:0px;" maxlength="8" readonly/>
                                </td>
                                <td>
                                    <input type="text" class="tax-field" name="tax[]" id="tax_1" autocomplete="off" style="font-size:13px;height:25px;width:35px;margin-left:-4px;" maxlength="8" readonly/>
                                </td>
                                <td>
                                    <input type="text" class="sellingPrice-field" name="sellingPrice[]" id="sellingPrice_1" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:70px;margin-left:-5px;" maxlength="12" readonly/>
                                </td>
                                <td>
                                    <input type="text" class="salesMan-field" name="salesMan[]" id="salesMan_1" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:-4px;" maxlength="12" />
                                </td>
                                <td>
                                    <input type="text" class="qty-field" name="qty[]" id="qty_1" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:33px;margin-left:-9px;" maxlength="5" />
                                </td>
                                <td>
                                    <input type="text" class="discountPercent-field" name="discountPercent[]" id="discountPercent_1" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:35px;margin-left:-6px;" maxlength="4" />
                                </td>
                                <td>
                                    <input type="text" class="discountAmount-field" name="discountAmount[]" id="discountAmount_1" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:80px;margin-left:-2px;" maxlength="10" />
                                </td>
                                <td>
                                    <input type="text" class="amount-field" name="amount[]" id="amount_1" autocomplete="off" style="text-align:right;height:25px;font-weight:bold;width:80px;margin-left:-2px;background-color:#212529;color:white;border:1px solid white;" maxlength="13" readonly />
                                </td>
                                <td>
                                    <input type="text" class="actualAmount-field" name="actualAmount[]" id="actualAmount_1" autocomplete="off" style="text-align:right;height:25px;font-weight:bold;width:80px;margin-left:-2px;background-color:#212529;color:white;border:1px solid white;" maxlength="13" readonly />
                                </td>
                                <td>
                                    <input type="text" class="taxable-field" name="taxable[]" id="taxable_1" autocomplete="off" style="text-align:right;height:25px;font-weight:bold;width:50px;margin-left:-1px;background-color:#212529;color:white;border:1px solid white;" maxlength="13" readonly />
                                </td>
                                <td>
                                    <input type="text" class="taxAmount-field" name="taxAmount[]" id="taxAmount_1" autocomplete="off" style="text-align:right;height:25px;font-weight:bold;width:80px;margin-left:-4px;background-color:#212529;color:white;border:1px solid white;" maxlength="13" readonly />
                                </td>
                                <td>
                                    <input type="text" class="id-field" name="id[]" id="id_1" readonly autocomplete="off" style="font-size:13px;height:25px;width:65px;margin-left:-4px;background-color:#212529;color:white;border:1px solid white;text-align:right;" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <button style="margin-left:180px;width:120px;" type="submit" class="btn btn-primary" name="submit_button" id="submitButton">Submit</button>
        </div>
<div style="margin-left:1000px;margin-top:-45px">
<div style="display:flex;gap:5px">
<label for="" style="margin-left:-2px">Total</label>
<input type="text" name="totalQty" id="totalQty" class="form-control" readonly style="text-align:right;font-size:13px;height:25px;width:50px;" maxlength="4">
<input type="text" name="totalAmount" id="totalAmount" class="form-control" readonly style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
<input type="text" name="totalActualAmount" id="totalActualAmount" class="form-control" readonly style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">
<input type="text" name="totalTaxable" id="totalTaxable" readonly 
style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px" class="form-control" maxlength="12"
>
<input type="text" name="totalTaxAmount" id="totalTaxAmount" readonly 
style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:-2px" class="form-control" maxlength="12"
>
</div>
<div style="display:flex;margin-top:2px;">
<label for="">CGST</label>
<input type="text" name="cgstAmount" id="cgstAmount" autocomplete="off" class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:48px" maxlength="12">
</div>
<div style="display:flex;margin-top:2px;">
<label for="">SGST</label>
<input type="text" name="sgstAmount" id="sgstAmount" autocomplete="off" class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:49px" maxlength="12">
</div>
<div style="display:flex;margin-top:2px;">
<label for="">IGST</label>
<input type="text" name="igstAmount" id="igstAmount" autocomplete="off" class="form-control"  style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:54px" maxlength="12">
</div>

<div style="display:flex;margin-top:2px;">
<label for="">Dis %</label>
<input type="text" name="netDiscountPercent" id="netDiscountPercent" class="form-control" 
autocomplete="off"
maxlength="4"
style="width:50px;height:25px">
<label for="">Add On</label>
<input type="text" name="addOnAmount" id="addOnAmount" autocomplete="off" class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:32px" maxlength="12">
</div>

<div style="display:flex;margin-top:3px;">
<label for="">Discount </label>
<input type="text" name="deductionAmount" id="deductionAmount" autocomplete="off" class="form-control" style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:13px"  maxlength="12">
</div>

<div style="display:flex;margin-top:2px;">
<label for="">Net</label>
<input type="text" name="netAmount" id="netAmount" class="form-control"  readonly style="text-align:right;font-size:13px;height:25px;width:90px;margin-left:61px" maxlength="12">
</div>
</div>
    </div>
    
    <!-- Sales Return Tab Content -->
    <div class="tab-pane fade" id="salesReturn" role="tabpanel" style="margin-left:300px">
        <label for="">Sales Return</label>
        <!-- Add your Sales Return content here -->
    </div>
</div>



</form>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    
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
    
    
    
    document.getElementById("customerName").addEventListener("focusout", function(event){    
        let target = event.target;
        event.preventDefault();
        
        if(target.value != ""){
            let customerName = new FormData();
        customerName.append("al_customer_name",target.value);
        let aj_customer =  new XMLHttpRequest();
        aj_customer.open("POST","itemStoring.php",true);
        aj_customer.send(customerName);
        
        aj_customer.onreadystatechange = function(){
            if(aj_customer.status === 200 && aj_customer.readyState === 4){
            // document.getElementById("response_message").innerHTML = aj_customer.responseText;
            // document.getElementById("response_message").style.display = "block";
            document.getElementById('customerId').value = aj_customer.responseText;
            document.getElementById("customerMobile").focus();
            }
        }
        }
        
            
    })
    
    document.getElementById("customerMobile").addEventListener("focusout", function(event){    
    let target = event.target;
    event.preventDefault();
    if(target.value != ""){
        let duplicateCustomerMobile = document.getElementById('duplicateCustomerMobile').value;
        
        if(duplicateCustomerMobile == ''){
            let customerId = document.getElementById('customerId').value;
        let customerData = [customerId,target.value];
        
        let customerDetails = new FormData();
        customerDetails.append("al_customer_details",JSON.stringify(customerData));
        let aj_customer =  new XMLHttpRequest();
        aj_customer.open("POST","itemStoring.php",true);
        aj_customer.send(customerDetails);
        
        aj_customer.onreadystatechange = function(){
                if(aj_customer.status === 200 && aj_customer.readyState === 4){
                    document.getElementById('customerId').value = aj_customer.responseText;
        
                }
           }   
        
        }
    
     
    }
})
    
    
    document.getElementById("table_body").addEventListener('focusin',function(event){
    
        let target = event.target;
        
        if(target.name == "salesMan[]"){
        
            calculateAmount(target);
            calculateAc();
            // calculateTaxAmount(target);
            calculateTotalAmount();
            calculateNetAmount();
        
        }else if(target.name == "qty[]"){
            calculateAmount(target);
            calculateAc()
            // calculateTaxAmount(target);
            calculateTotalAmount();
            calculateNetAmount();
        
        }
    })
    
    document.getElementById('table_body').addEventListener('input',function(event){
    
        let target = event.target;
        let currentRow = target.closest('tr');
        if(target.name == "qty[]"){
            
            calculateAmount(target);
            calculateAc()
            calculateTaxAmount(target);
            
            calculateTotalAmount();
            
            calculateNetAmount();
            
        
        }else if(target.name == "discountPercent[]"){
        
            let amount = currentRow.querySelector('input[name="amount[]"]').value;
            let discountAmount = currentRow.querySelector('input[name="discountAmount[]"]');
            let discountPercentage = currentRow.querySelector('input[name="discountPercent[]"]');
        
            if(parseFloat(target.value) < parseFloat(100)){
                calculateDiscountAmount(target)
                calculateAmount(target);
                calculateTaxAmount(target);
                calculateTotalAmount();
                calculateNetAmount();
            }else{
                discountAmount.value = 0;
                discountPercentage.value = 0;
                discountPercentage.select();
            }
            
        }else if(target.name == 'discountAmount[]'){
            
            
            let amount = currentRow.querySelector('input[name="amount[]"]').value;
            let discountAmount = currentRow.querySelector('input[name="discountAmount[]"]');
            let discountPercentage = currentRow.querySelector('input[name="discountPercent[]"]');
            
            if(parseFloat(discountAmount.value) < parseFloat(amount)){
                calculateDiscountPercentage(target);
                calculateAmount(target);
                calculateAc();
                calculateTaxAmount(target);
                calculateTotalAmount();
                calculateNetAmount();
                
                
            }else{
                
                discountAmount.value = 0;
                discountAmount.select();
                discountPercentage.value = 0;
            }
        
            
        }
    })
    
    
    
    document.getElementById("netDiscountPercent").addEventListener('input',function(event){
        let target = event.target
        let netDiscountPercent  = target.value
        
    let netDiscountPercent2 = document.getElementById("netDiscountPercent");
    let totalAmount = document.getElementById("totalAmount").value || 0;
    let netDiscountAmount = document.getElementById("deductionAmount");    
    if(parseFloat(netDiscountPercent)  < 100){
        calculateNetDiscount()
    }else{
        netDiscountAmount.value = 0;
        netDiscountPercent2.value = 0;
        netDiscountPercent2.select();
    }
        calculateNetAmount();    
    
        
    }
    
    );
    document.getElementById("addOnAmount").addEventListener('input',calculateNetAmount)
    
    document.getElementById("deductionAmount").addEventListener('focus',function(event){
    
            document.getElementById("deductionAmount").select();
    })
    
    document.getElementById("deductionAmount").addEventListener('input',function(event){
        
        let target = event.target
        console.log("target = ",target.value)
        let netDiscountAmount = parseFloat(target.value)||0;
        
        let netDiscountAmount2 =  document.getElementById("deductionAmount");
        let totalAmount = parseFloat(document.getElementById("totalAmount").value)||0;
        let netDiscountPercent = document.getElementById("netDiscountPercent");
        if(netDiscountAmount < totalAmount){
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

                
        
        }else{
            netDiscountPercent.value = 0;
            netDiscountAmount2.value  =  0;
            netDiscountAmount2.select();
            calculateNetDiscountPercent();
            calculateAc();
        }
        
        calculateNetAmount()
        
    })
    
    
document.getElementById("customerName").addEventListener("keydown", function(event){
        let target = event.target;
    if(event.key === "F2"){
        event.preventDefault();
        let customerName = new FormData();
        customerName.append("lb_customer_name",target.value);
        let aj_customer =  new XMLHttpRequest();
        aj_customer.open("POST","ajaxGetCustomerDetails.php",true);
        aj_customer.send(customerName);
        
        aj_customer.onreadystatechange = function(){
            if(aj_customer.status === 200 && aj_customer.readyState === 4){
            document.getElementById("response_message").innerHTML = aj_customer.responseText;
            document.getElementById("response_message").style.display = "block";

            
                
            }
        }
        
    
    }else if(event.key === "Enter"){
    
        event.preventDefault();
        if(target.value != ""){
            let customerName = new FormData();
            customerName.append("al_customer_name",target.value);
            let aj_customer =  new XMLHttpRequest();
            aj_customer.open("POST","itemStoring.php",true);
            aj_customer.send(customerName);
            
            aj_customer.onreadystatechange = function(){
            if(aj_customer.status === 200 && aj_customer.readyState === 4){
                document.getElementById('customerId').value = aj_customer.responseText;
                
            // document.getElementById("response_message").innerHTML = aj_customer.responseText;
            // document.getElementById("response_message").style.display = "block";
            document.getElementById("customerMobile").focus();
            }
        }
        }
    }
    
})

document.getElementById("customerMobile").addEventListener("keydown", function(event){
        let target = event.target;
    if(event.key === "F2"){
        event.preventDefault();
        let customerName = new FormData();
        customerName.append("lb_customer_mobile",target.value);
        let aj_customer =  new XMLHttpRequest();
        aj_customer.open("POST","ajaxGetCustomerDetails.php",true);
        aj_customer.send(customerName);
        
        aj_customer.onreadystatechange = function(){
            if(aj_customer.status === 200 && aj_customer.readyState === 4){
            document.getElementById("response_message").innerHTML = aj_customer.responseText;
            document.getElementById("response_message").style.display = "block";

     
                
            }
        }
        
    
    }else if(event.key === "Enter"){
    
    event.preventDefault();
    if(target.value != ""){
        let duplicateCustomerNumber = document.getElementById('duplicateCustomerMobile').value;
        
        if(duplicateCustomerNumber == ""){
            let customerId = document.getElementById('customerId').value;
            let customerData = [customerId,target.value];
            
            let customerDetails = new FormData();
            customerDetails.append("al_customer_details",JSON.stringify(customerData));
            let aj_customer =  new XMLHttpRequest();
            aj_customer.open("POST","itemStoring.php",true);
            aj_customer.send(customerDetails);
            
            aj_customer.onreadystatechange = function(){
            if(aj_customer.status === 200 && aj_customer.readyState === 4){
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

function calculateDiscountAmount(target){
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

function calculateDiscountPercentage(target){
    const currentRow = target.closest('tr');
    const selling = currentRow.querySelector('input[name="sellingPrice[]"]').value||0;
    const qty = currentRow.querySelector('input[name="qty[]"]').value||0;
    const discountAmount =currentRow.querySelector('input[name="discountAmount[]"]').value||0;
    let discountPercentage = currentRow.querySelector('input[name="discountPercent[]"]');
    
    discountPercentage.value = ((parseFloat(discountAmount)/parseFloat(selling))*100).toFixed(2);
    
    
}

function calculateAmount(target){
    const currentRow = target.closest('tr');
    const selling = currentRow.querySelector('input[name="sellingPrice[]"]').value||0;
    const qty = currentRow.querySelector('input[name="qty[]"]').value||0;
    const discountAmount =currentRow.querySelector('input[name="discountAmount[]"]').value||0;
    const actualAmount = currentRow.querySelector('input[name="actualAmount[]"]');
    let amount =  currentRow.querySelector('input[name="amount[]"]');
    amount.value = ((selling*qty)-discountAmount).toFixed(2);
    actualAmount.value = ((selling*qty)).toFixed(2);
}


function calculateAc(){
    let total_rows = parseInt(localStorage.getItem('total_rows'));
    
    let eachRowActualAmount = 0;
    let eachRowActualAmountAfterDiscount = 0;
    let eachRowTaxableAmount = 0;
    let eachRowTaxPercentage = 0;
    let eachRowTaxPercentage2 = 0;
    let eachRowTaxAmount = 0;
    let actualTotalAmount = document.getElementById("totalActualAmount").value||0;
    let netAmount = document.getElementById("netAmount").value||0;
    
    let totalTaxable = 0;
    let totalTaxAmount = 0;
    
    let differenceAmount = parseFloat(actualTotalAmount)-parseFloat(netAmount);
    let differencePercentage = (parseFloat(parseFloat(differenceAmount)/parseFloat(actualTotalAmount))*100).toFixed(2);
    
    console.log("difference per = ",differencePercentage)
    
    for(let i=1;i<=total_rows;i++){
        
        eachRowActualAmount =  document.getElementById("actualAmount_"+i).value||0;
        
        eachRowTaxPercentage =  document.getElementById("tax_"+i).value||0;
        console.log("actual Amount = ",eachRowActualAmount);
        console.log("tax amount = ",eachRowTaxPercentage);
        eachRowTaxPercentage2  =  eachRowTaxPercentage.replace("G","");
        
        console.log("each row tax =",eachRowTaxPercentage2)
        console.log("tax type =", typeof(eachRowTaxPercentage2))
        // eachRowActualAmountAfterDiscount = (parseFloat(eachRowActualAmount)-((parseFloat(eachRowActualAmount)*parseFloat(differencePercentage))/100)).toFixed(2)
        eachRowActualAmountAfterDiscount = (parseFloat(eachRowActualAmount) - parseFloat(((parseFloat(eachRowActualAmount) * parseFloat(differencePercentage)) / 100))).toFixed(2);
            
        console.log("actual after discount = ",eachRowActualAmountAfterDiscount)
        
        // eachRowTaxableAmount = ((parseFloat(eachRowActualAmountAfterDiscount)/parseFloat(eachRowTaxPercentage2+100))*100).toFixed(2)    
        eachRowTaxableAmount = ((parseFloat(eachRowActualAmountAfterDiscount) / parseFloat(parseFloat(eachRowTaxPercentage2) + 100)) * 100).toFixed(2);
        console.log("taxable amount  after discount = ",eachRowTaxableAmount)
        
        // eachRowTaxAmount = ((parseFloat(eachRowTaxableAmount)*parseFloat(eachRowTaxPercentage2))/100).toFixed(2)
        eachRowTaxAmount = ((parseFloat(eachRowTaxableAmount) * parseFloat(eachRowTaxPercentage2)) / 100).toFixed(2);

        
        console.log("")
        // console.log(eachRowActualAmountAfterDiscount);
        // console.log(eachRowTaxableAmount);
        
        
        document.getElementById("taxable_"+i).value = parseFloat(eachRowTaxableAmount)||0;
        document.getElementById("taxAmount_"+i).value = parseFloat(eachRowTaxAmount)||0;
        
        
        totalTaxable = parseFloat(totalTaxable)+parseFloat(document.getElementById("taxable_"+i).value||0);
        totalTaxAmount = parseFloat(totalTaxAmount)+parseFloat(document.getElementById("taxAmount_"+i).value||0);
        
    }
    
    document.getElementById("totalTaxable").value = parseFloat(totalTaxable).toFixed(2);
    document.getElementById("totalTaxAmount").value = parseFloat(totalTaxAmount).toFixed(2);
    
    
    console.log("actual",actualTotalAmount)
    console.log("net",netAmount)
    console.log("diff",differenceAmount)

}

function calculateTaxAmount(target){
    const currentRow = target.closest('tr');
    // const selling = currentRow.querySelector('input[name="sellingPrice[]"]').value||0;
    // const qty = currentRow.querySelector('input[name="qty[]"]').value||0;
    // const discountAmount =currentRow.querySelector('input[name="discountAmount[]"]').value||0;
    let amount =  currentRow.querySelector('input[name="amount[]"]').value;
    let tax = currentRow.querySelector('input[name="tax[]"]').value;
    let truncatedTax = tax.replace('G',"");
    
    let taxAmount = currentRow.querySelector('input[name="taxAmount[]"]');
    let taxable = currentRow.querySelector('input[name="taxable[]"]');
    
    taxable.value = (((parseFloat(amount) / (parseFloat(truncatedTax) + 100))) * 100).toFixed(2);
    taxAmount.value = (parseFloat(amount) - ((parseFloat(amount) / (parseFloat(truncatedTax) + 100))) * 100).toFixed(2);

}



function calculateTotalAmount(){
    let totalRow = parseInt(localStorage.getItem('total_rows'));
    console.log("total  rows = ",typeof(totalRow))
                let eachRowQty = 0;
                let totalQty = 0;
                
                let eachRowAmount = 0;
                let totalAmount = 0;
                
                let eachRowActualAmount = 0;
                let totalActualAmount = 0;
                
                let eachRowTaxable = 0;
                let totalTaxable = 0;
                
                let eachRowTaxAmount = 0;
                let totalTaxAmount = 0;
                
                
            
                
                
                
                
                
                // alert(rowIndex)
                        for(let i=1;i<=totalRow;i++){
                        
                            eachRowQty = document.getElementById("qty_"+i).value || 0;
                            eachRowAmount = document.getElementById("amount_"+i).value || 0;
                            eachRowActualAmount = document.getElementById("actualAmount_"+i).value || 0;
                            
                            eachRowTaxable = document.getElementById("taxable_"+i).value || 0;
                            console.log("each row tax ",eachRowTaxable)
                            eachRowTaxAmount = document.getElementById("taxAmount_"+i).value || 0;
                            
                            
                            
                            totalQty = parseInt(totalQty)+parseInt(eachRowQty);
                            totalAmount = parseFloat(totalAmount)+parseFloat(eachRowAmount);
                            totalActualAmount = parseFloat(totalActualAmount)+parseFloat(eachRowActualAmount);
                            totalTaxable = parseFloat(totalTaxable)+parseFloat(eachRowTaxable);
                            totalTaxAmount = parseFloat(totalTaxAmount)+parseFloat(eachRowTaxAmount);
                            console.log("total taxable amount from calculatetotalamount = ",totalTaxable)    
                            console.log("total tax amount from calculatetotalamount = ",totalTaxAmount)
                            
                        }
                        
                document.getElementById("totalQty").value = totalQty;
                document.getElementById("totalAmount").value = parseFloat(totalAmount).toFixed(2);
                document.getElementById("totalActualAmount").value = parseFloat(totalActualAmount).toFixed(2);
                document.getElementById("totalTaxable").value = parseFloat(totalTaxable).toFixed(2);
                document.getElementById("totalTaxAmount").value = parseFloat(totalTaxAmount).toFixed(2);
}


function calculateGST(){
    let totalTaxAmount = document.getElementById("totalTaxAmount").value;
    let cgstAmount = document.getElementById('cgstAmount');
    let sgstAmount = document.getElementById("sgstAmount");
    let igstAmount = document.getElementById("igstAmount");
    let customerState = localStorage.getItem('customer_state');
    if(customerState == '1'){
        cgstAmount.value = sgstAmount.value = parseFloat((parseFloat(totalTaxAmount)/2)).toFixed(2);
    }else{
        igstAmount.value = totalTaxAmount;
    }
    
    
    
    
}

function calculateNetDiscountPercent(){

        let netDiscountAmount = document.getElementById("deductionAmount").value||0;
        let totalAmount = document.getElementById("totalActualAmount").value||0;
        let netDiscountPercent = document.getElementById("netDiscountPercent");
        
        console.log("net discount amount = ",netDiscountAmount);
        console.log("total amount from calculatenetdiscountpercent = ",totalAmount)
            netDiscountPercent.value  = (parseFloat((parseFloat(netDiscountAmount)/parseFloat(totalAmount))*100)).toFixed(2);
        
        
        
}


function calculateNetDiscount(){
    let netDiscountPercent = document.getElementById("netDiscountPercent").value || 0;
    let totalAmount = document.getElementById("totalAmount").value || 0;
    let netDiscountAmount = document.getElementById("deductionAmount");
    
        netDiscountAmount.value =  ((parseFloat(totalAmount)*parseFloat(netDiscountPercent))/100).toFixed();
        calculateNetAmount()
    
    
    
    
    
    
}


function calculateNetAmount(){
    
                let totalAmount = document.getElementById('totalAmount').value||0;
                let cgstAmount = document.getElementById('cgstAmount').value||0;
                let sgstAmount = document.getElementById("sgstAmount").value||0;
                let igstAmount = document.getElementById("igstAmount").value||0;
                let addOn = document.getElementById("addOnAmount").value||0;
                let deduction = document.getElementById("deductionAmount").value||0;
                
                let netAmount = parseFloat(totalAmount)+parseFloat(addOn)-parseFloat(deduction);
                calculateGST()
                document.getElementById("netAmount").value = parseFloat(netAmount).toFixed(2);
                
}


document.getElementById("cgstAmount").addEventListener("focusout",calculateNetAmount);
document.getElementById("sgstAmount").addEventListener("focusout",calculateNetAmount);
document.getElementById("igstAmount").addEventListener("focusout",calculateNetAmount);
document.getElementById("addOnAmount").addEventListener("focusout",calculateNetAmount);
document.getElementById("deductionAmount").addEventListener("focusout",calculateNetAmount);




let totalAmount = 0;

document.getElementById("table_body").addEventListener("focusout", function(event){
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
         if(target.name === "qty[]"){
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
            }else if(target.name == "discountPercent[]"){
            
                calculateDiscountAmount(target);
                calculateAmount(target);
                calculateTotalAmount();
                calculateNetAmount();
            }
        
        
})





document.getElementById("table_body").addEventListener("keydown", function (event) {
    const target = event.target;

    // Handle the Enter key event
    if (event.key === "Enter") {
        event.preventDefault(); // Prevent the default Enter key behavior

        // Navigate based on the input field's name
        
            
        if(target.name == "design[]"){
               
             
                        const currentRow = target.closest("tr");
                        const salesManField = currentRow.querySelector('input[name="salesMan[]"]');
                        if (salesManField) {
                            salesManField.focus();
                            salesManField.select();
                        }
                
            
        
            }else if(target.name == "salesMan[]"){ 
                    
                const currentRow = target.closest("tr");
                        const qtyField = currentRow.querySelector('input[name="qty[]"]');
                        if (qtyField) {
                            qtyField.focus();
                            qtyField.select();
                        }
                        
                        
            }else if(target.name == "qty[]"){
        
        // validateAmounts();
        
        const currentRow = target.closest('tr');
        const discountPercentField = currentRow.querySelector('input[name="discountPercent[]"]');
        
                
            
     
        if (discountPercentField) {
            discountPercentField.focus();
            discountPercentField.select();
            
        }
    
    
    }else if(target.name == "discountPercent[]"){
        
        // validateAmounts();
        if(parseFloat(target.value) < parseFloat(100)){
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
    
    
    }
    else if (target.name === "discountAmount[]") {
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

function gettingRowItemDetails(target){

    const currentRow = target.closest("tr");
        const design =currentRow.querySelector('input[name="design[]"]').value;
        
        const hsnCode = currentRow.querySelector('input[name="hsnCode[]"]').value;
        const tax = currentRow.querySelector('input[name="tax[]"]').value;
        const sellingPrice  =currentRow.querySelector('input[name="sellingPrice[]"]').value;
        const salesMan      =currentRow.querySelector('input[name="salesMan[]"]').value;
        const Qty  =currentRow.querySelector('input[name="qty[]"]').value;
        const discountPercent  =currentRow.querySelector('input[name="discountPercent[]"]').value;
        const discountAmount  =currentRow.querySelector('input[name="discountAmount[]"]').value;
        const Amount  =currentRow.querySelector('input[name="amount[]"]').value;
        const taxAmount  =currentRow.querySelector('input[name="taxAmount[]"]').value;
        
        const id = currentRow.querySelector('input[name="id[]"]');
        // alert(product.value+" "+brand.value+" "+design.value+" "+batch.value+" "
        // +color.value+" "+category.value+" "+hsnCode.value+" "+tax.value+" "+size.value+" "
        // +mrp.value+" "+sellingPrice.value+" "+rate.value);
        
        let items = [product,brand,design,color,batch,category,hsnCode,tax,size,mrp,sellingPrice,rate];
        
        let triggerItemCreation = new FormData();
        triggerItemCreation.append("lb_trigger_item_creation",JSON.stringify(items));
        let ajTriggerItemCreation = new XMLHttpRequest();
        ajTriggerItemCreation.open("POST", "fnItemIdCreate.php", true);
        ajTriggerItemCreation.send(triggerItemCreation);
        
        
        ajTriggerItemCreation.onreadystatechange = function(){
            if(ajTriggerItemCreation.status === 200 && ajTriggerItemCreation.readyState === 4){
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
        let row  = target.closest('tr');
        if(target.name == target.name){
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
            query = `select * from ${fieldName}es where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}'`;
        } else if (fieldName === "category") {
            query = `select * from categories where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}'`;
        } else if (fieldName === "hsnCode") {
            query = `select * from hsn_codes where hsn_code like '${value}%' && branch_id = '${currentBranchId}'`;
        } else if (fieldName === "tax") {
            query = `select * from taxes where tax_code like '${value}%' && branch_id = '${currentBranchId}'`;
        } else if (fieldName === "mrp") {
            query = `select * from mrps where mrp like '${value}%' && branch_id = '${currentBranchId}'`;
        } else {
            query = `select * from ${fieldName}s where ${fieldName}_name like '${value}%' && branch_id = '${currentBranchId}'`;
        }

        const data = new FormData();
        data.append(`lb_qry_${fieldName}`, query);
        const row_index_f2 = localStorage.getItem("row_index");
        data.append("lb_f2_row_index", row_index_f2);

        const ajaxRequest = new XMLHttpRequest();
        ajaxRequest.open("POST", "itemStoring.php", true);
        ajaxRequest.send(data);
        ajaxRequest.onreadystatechange = function () {
            if (ajaxRequest.status === 200 && ajaxRequest.readyState === 4) {
                document.getElementById("response_message").innerHTML = ajaxRequest.responseText;
            }
        };
    }else if(target.name === "design[]" && event.key === "F4"){
            event.preventDefault();
            let fieldName = target.name.replace("[]","");
            let value = target.value;
            let currentBranchId = document.getElementById("userBranchId").value;
            
            let get_item = new FormData();
            get_item.append("get_item_f4", value);
            let aj = new XMLHttpRequest();
            aj.open("POST", "ajaxGetSalesItem.php", true);
            aj.send(get_item);
            aj.onreadystatechange = function(){
            
                if(aj.status === 200  && aj.readyState === 4){
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
             <input type="text" class="serial-field" name="serialNumber[]" id="serialNumber_${i}" style="font-size:12px;height:25px;width:60px;margin-left:1px;" maxlength="4" autocomplete="off" value="1" readonly />
         </td>
         <td>
             <input type="text" class="design-field form" name="design[]" id="design_${i}" autocomplete="off" style="font-size:12px;height:25px;width:160px;margin-left:-29px;" maxlength="30" />
         </td>
         <td>
             <input type="text" class="description-field" name="description[]" id="description_${i}" autocomplete="off" style="font-size:12px;height:25px;width:400px;margin-left:-9px;" maxlength="150" readonly/>
         </td>
         
         <td>
             <input type="text" class="hsnCode-field" name="hsnCode[]" id="hsnCode_${i}" autocomplete="off" style="font-size:13px;height:25px;width:65px;margin-left:0px;" maxlength="8" readonly/>
         </td>
         <td>
             <input type="text" class="tax-field" name="tax[]" id="tax_${i}" autocomplete="off" style="font-size:13px;height:25px;width:35px;margin-left:-4px;" maxlength="8" readonly/>
         </td>
         <td>
             <input type="text" class="sellingPrice-field" name="sellingPrice[]" id="sellingPrice_${i}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:70px;margin-left:-5px;" maxlength="12" readonly/>
         </td>
         <td>
             <input type="text" class="salesMan-field" name="salesMan[]" id="salesMan_${i}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:60px;margin-left:-4px;" maxlength="12" />
         </td>
         
         <td>
             <input type="text" class="qty-field" name="qty[]" id="qty_${i}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:33px;margin-left:-9px;" maxlength="5"  />
         </td>
         
         <td>
             <input type="text" class="discountPercent-field" name="discountPercent[]" id="discountPercent_${i}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:35px;margin-left:-6px;" maxlength="12" />
         </td>
         <td>
             <input type="text" class="discountAmount-field" name="discountAmount[]" id="discountAmount_${i}" autocomplete="off" style="text-align:right;font-size:13px;height:25px;width:80px;margin-left:-2px;" maxlength="12" />
         </td>
         <td>
             <input type="text" class="amount-field" name="amount[]" id="amount_${i}" autocomplete="off" style="text-align:right;height:25px;font-weight:bold;width:80px;margin-left:-2px;background-color:#212529;color:white;border:1px solid white;" maxlength="13" readonly />
         </td>
         <td>
             <input type="text" class="actualAmount-field" name="actualAmount[]" id="actualAmount_${i}" autocomplete="off" style="text-align:right;height:25px;font-weight:bold;width:80px;margin-left:-2px;background-color:#212529;color:white;border:1px solid white;" maxlength="13" readonly />
         </td>
         <td>
            <input type="text" class="taxable-field" name="taxable[]" id="taxable_${i}" autocomplete="off" style="text-align:right;height:25px;font-weight:bold;width:50px;margin-left:-1px;background-color:#212529;color:white;border:1px solid white;" maxlength="13" readonly />
        </td>
         
         
         <td>
             <input type="text" class="taxAmount-field" name="taxAmount[]" id="taxAmount_${i}" autocomplete="off" style="text-align:right;height:25px;font-weight:bold;width:80px;margin-left:-1px;background-color:#212529;color:white;border:1px solid white;" maxlength="13" readonly />
         </td>
         <td>
             <input type="text" class="design-field" name="id[]" id="id_${i}" readonly autocomplete="off" style="font-size:13px;height:25px;width:65px;margin-left:-4px;background-color:#212529;color:white;border:1px solid white;text-align:right;" />
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
    deleteRow = parseInt(totalRows)-1;
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
    
    
    
    
    
    
    window.onload = function(){
        
        localStorage.setItem('customer_state', '1');
        
        let customerState  = localStorage.getItem("customer_state");
        
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
        document.getElementById("netDiscountPercent").value = 0;
        document.getElementById("cgstAmount").style.background='gainsboro';
        document.getElementById("sgstAmount").style.background='gainsboro';
        document.getElementById("igstAmount").style.background='gainsboro';
        
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
        
        document.getElementById("cgstAmount").disabled = true;
        document.getElementById("sgstAmount").disabled = true;
        document.getElementById("igstAmount").disabled = true;
        
        
        localStorage.setItem("total_rows",1);
        let mydate = new Date();
        let currentDate = mydate.getFullYear() + "-" + 
                         (mydate.getMonth() + 1).toString().padStart(2, "0") + "-" + 
                          mydate.getDate().toString().padStart(2, "0");
        document.getElementById("salesDate").value = currentDate;
        
        
        // document.getElementById("SalesNumber").value = '<?php echo htmlspecialchars($sales_no);?>';
        
        document.getElementById("design_1").focus();
    }
    let rowIndex =localStorage.getItem("row_index");
    
    
    setTimeout(() => {
        
    
    }, 10);
    
    function validateAmounts() {
    
    let netAmount = parseFloat(document.getElementById("netAmount").value) || 0;
    
    if(netAmount >= 0){
        
        document.getElementById("submitButton").disabled = false;
    }else{
        document.getElementById("submitButton").disabled = true;
    }
    
}


if(netAmount >= 0){
        
        document.getElementById("submitButton").disabled = false;
    }else{
        document.getElementById("submitButton").disabled = true;
}
document.getElementById("cgstAmount").addEventListener("focusout", validateAmounts);
document.getElementById("sgstAmount").addEventListener("focusout", validateAmounts);
document.getElementById("igstAmount").addEventListener("focusout", validateAmounts);
document.getElementById("addOnAmount").addEventListener("focusout", validateAmounts);
document.getElementById("deductionAmount").addEventListener("focusout", validateAmounts);


    

    
    
    
    
    document.getElementById("table_body").addEventListener("input", function (event) {
    let target = event.target;

    if (target.name === "discountPercent[]") {
        // Allow only numbers and a single decimal point
        target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    }else if(target.name === "sellingPrice[]"){
            // Allow only numbers and a single decimal point
            target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    
    }else if(target.name === "discountAmount[]"){
            // Allow only numbers and a single decimal point
            target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    
    }else if(target.name === "rate[]"){
            // Allow only numbers and a single decimal point
            target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    }else if(target.name === "qty[]"){
            // Allow only numbers and a single decimal point
            target.value = target.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    }
    
});






    
    
    
    
document.getElementById('totalAmount').addEventListener('keypress', function (event) {
            const charCode = event.which || event.keyCode; // Get the character code
            const charStr = String.fromCharCode(charCode); // Convert to a string

            // Allow digits (0-9) and a single decimal point
            if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
                event.preventDefault(); // Prevent input if not a number or extra decimal
            }
        });

        document.getElementById('totalAmount').addEventListener('input', function () {
            // Prevent any invalid characters that might slip through (e.g., copy-paste)
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});
    
document.getElementById('cgstAmount').addEventListener('keypress', function (event) {
            const charCode = event.which || event.keyCode; // Get the character code
            const charStr = String.fromCharCode(charCode); // Convert to a string

            // Allow digits (0-9) and a single decimal point
            if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
                event.preventDefault(); // Prevent input if not a number or extra decimal
            }
        });

        document.getElementById('cgstAmount').addEventListener('input', function () {
            // Prevent any invalid characters that might slip through (e.g., copy-paste)
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});
document.getElementById('sgstAmount').addEventListener('keypress', function (event) {
            const charCode = event.which || event.keyCode; // Get the character code
            const charStr = String.fromCharCode(charCode); // Convert to a string

            // Allow digits (0-9) and a single decimal point
            if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
                event.preventDefault(); // Prevent input if not a number or extra decimal
            }
        });

        document.getElementById('sgstAmount').addEventListener('input', function () {
            // Prevent any invalid characters that might slip through (e.g., copy-paste)
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});


document.getElementById('igstAmount').addEventListener('keypress', function (event) {
            const charCode = event.which || event.keyCode; // Get the character code
            const charStr = String.fromCharCode(charCode); // Convert to a string

            // Allow digits (0-9) and a single decimal point
            if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
                event.preventDefault(); // Prevent input if not a number or extra decimal
            }
        });

        document.getElementById('igstAmount').addEventListener('input', function () {
            // Prevent any invalid characters that might slip through (e.g., copy-paste)
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});


document.getElementById('addOnAmount').addEventListener('keypress', function (event) {
            const charCode = event.which || event.keyCode; // Get the character code
            const charStr = String.fromCharCode(charCode); // Convert to a string

            // Allow digits (0-9) and a single decimal point
            if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
                event.preventDefault(); // Prevent input if not a number or extra decimal
            }
        });

        document.getElementById('addOnAmount').addEventListener('input', function () {
            // Prevent any invalid characters that might slip through (e.g., copy-paste)
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});



document.getElementById('netDiscountPercent').addEventListener('keypress', function (event) {
            const charCode = event.which || event.keyCode; // Get the character code
            const charStr = String.fromCharCode(charCode); // Convert to a string

            // Allow digits (0-9) and a single decimal point
            if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
                event.preventDefault(); // Prevent input if not a number or extra decimal
            }
        });

        document.getElementById('netDiscountPercent').addEventListener('input', function () {
            // Prevent any invalid characters that might slip through (e.g., copy-paste)
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});





document.getElementById('deductionAmount').addEventListener('keypress', function (event) {
            const charCode = event.which || event.keyCode; // Get the character code
            const charStr = String.fromCharCode(charCode); // Convert to a string

            // Allow digits (0-9) and a single decimal point
            if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
                event.preventDefault(); // Prevent input if not a number or extra decimal
            }
        });

        document.getElementById('deductionAmount').addEventListener('input', function () {
            // Prevent any invalid characters that might slip through (e.g., copy-paste)
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});




document.getElementById('netAmount').addEventListener('keypress', function (event) {
            const charCode = event.which || event.keyCode; // Get the character code
            const charStr = String.fromCharCode(charCode); // Convert to a string

            // Allow digits (0-9) and a single decimal point
            if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
                event.preventDefault(); // Prevent input if not a number or extra decimal
            }
        });

        document.getElementById('netAmount').addEventListener('input', function () {
            // Prevent any invalid characters that might slip through (e.g., copy-paste)
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});
document.getElementById('totalQty').addEventListener('keypress', function (event) {
            const charCode = event.which || event.keyCode; // Get the character code
            const charStr = String.fromCharCode(charCode); // Convert to a string

            // Allow digits (0-9) and a single decimal point
            if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
                event.preventDefault(); // Prevent input if not a number or extra decimal
            }
        });

        document.getElementById('totalQty').addEventListener('input', function () {
            // Prevent any invalid characters that might slip through (e.g., copy-paste)
            this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
});


document.getElementById('customerMobile').addEventListener('keypress', function (event) {
            const charCode = event.which || event.keyCode; // Get the character code
            const charStr = String.fromCharCode(charCode); // Convert to a string

            // Allow digits (0-9) and a single decimal point
            if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
                event.preventDefault(); // Prevent input if not a number or extra decimal
            }
        });

        document.getElementById('customerMobile').addEventListener('input', function () {
            // Prevent any invalid characters that might slip through (e.g., copy-paste)
            this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
});




document.getElementById("customerName").addEventListener("keydown", function(event){
        
        if(event.key === "Enter"){
            event.preventDefault();
            
        }

})







document.getElementById("cgstAmount").addEventListener("focus",function(){
    
    document.getElementById("cgstAmount").select();

})

document.getElementById("cgstAmount").addEventListener("keydown",function(event){

    if(event.key === "Enter"){
    
        event.preventDefault();
        document.getElementById("sgstAmount").focus();
        document.getElementById("sgstAmount").select();
    }
})



document.getElementById("sgstAmount").addEventListener("keydown",function(event){

    if(event.key === "Enter"){
        event.preventDefault();
        if(document.getElementById("igstAmount").disabled){
            document.getElementById("addOnAmount").focus();
            document.getElementById("addOnAmount").select();
        }else{
            document.getElementById("igstAmount").focus();
            document.getElementById("igstAmount").select();
        }
        
    }
})





document.getElementById("igstAmount").addEventListener("keydown",function(event){

if(event.key === "Enter"){
    event.preventDefault();
    document.getElementById("addOnAmount").focus();
    document.getElementById("addOnAmount").select();
}
})

document.getElementById("igstAmount").addEventListener("focus", function(){

        document.getElementById("igstAmount").select();
})

document.getElementById("addOnAmount").addEventListener("keydown",function(event){

if(event.key === "Enter"){
    event.preventDefault();
    document.getElementById("deductionAmount").focus();
    document.getElementById("deductionAmount").select();
}
})


document.getElementById("deductionAmount").addEventListener("keydown", function(event){
        if(event.key === "Enter"){
            event.preventDefault();
            document.getElementById("submitButton").focus();
            
        }
            

})

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
    

    $customerName =  $_POST['customerName'];
    $customerId = $_POST['customerId'];
    $grnAmount = $_POST['grnAmount'];
    $netAmount = $_POST['netAmount'];
    
    if($grnAmount != '' && $grnAmount != 0){
    
    if($grnAmount == $netAmount){
            $salesNumber = $_POST['salesNumber'];
            $salesDate = $_POST['salesDate'];
            $querySearchSalesNumber = "select*from sales_sno_master where counter_name = '$_SESSION[counter_name]' && 
                                     financial_year = '$financial_year' && branch_id = '$userBranchId'";
            $resultSearchSalesNumber  = $con->query($querySearchSalesNumber);
            
            if($resultSearchSalesNumber->num_rows==0){
                $currentSalesNumber = $_POST['salesNumber'];
            }else{
                $sales = $resultSearchSalesNumber->fetch_assoc();
                $currentSalesNumber = $sales['sales_no']+1;
            }
            
            echo "current GRN number = ".$currentSalesNumber;
            echo "<br>";
            $querySearchSnoMaster = "update sales_sno_master set sales_no = '$currentSalesNumber'
                                     where financial_year = '$financial_year' && branch_id = '$userBranchId'";
            $resultSearchSnoMaster = $con->query($querySearchSnoMaster);        
            
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
            $itemQty  = $_POST['qty'];
            $itemAmount = $_POST['amount'];
            $itemId = $_POST['id'];
            
            $totalQty = $_POST['totalQty'];
            $totalAmount =$_POST['totalAmount'];
            $cgst = isset($_POST['cgstAmount']) ? $_POST['cgstAmount'] : 0;
            $sgst = isset($_POST['sgstAmount']) ? $_POST['sgstAmount'] : 0;
            $igst = isset($_POST['igstAmount']) ? $_POST['igstAmount'] : 0;
            $addOn = $_POST['addOnAmount'];
            $deduction = $_POST['deductionAmount'];
        
            if(($netAmount - $totalAmount) != 0 ){
                $percent = round((($netAmount-$totalAmount)/$totalAmount)*100,2);
            }else{
                $percent = 0;
            }
        
            $query = "insert into sales_summary (grn_number,grn_date,supplier_id,grn_amount,
                  dc_number,dc_date,invoice_number,invoice_date,total_qty,total_amount,
                  cgst_amount,sgst_amount,igst_amount,addon,deduction,net_amount,user_id,branch_id)
                  values('$currentSalesNumber','$grnDate','$customerId','$grnAmount','$dcNumber','$dcDate',
                  '$invoiceNumber','$invoiceDate','$totalQty','$totalAmount','$cgst','$sgst',
                  '$igst','$addOn','$deduction','$netAmount','$userId','$userBranchId')";
                  
        
        $resultQuery = $con->query($query);
        if($resultQuery){
            echo "sales summary created";
        }else{
            echo "oops! something went wrong";
        }
        
        
        $a=0;
        
        foreach($product as $pro){
            
            $landCost = round($rate[$a]+(($rate[$a]*$percent)/100),2);
            $margin = round((($sellingPrice[$a]-$landCost)/$sellingPrice[$a])*100,2);
            
            $querySalesItem = "insert into sales_item (grn_number, grn_date,item_id,
                                  item_qty,item_amount,land_cost,margin,s_no,branch_id)
            values('$currentSalesNumber','$grnDate','$itemId[$a]','$itemQty[$a]','$itemAmount[$a]',
                   '$landCost','$margin','$serialNumber[$a]', '$userBranchId')";
                   
            $resultQuery = $con->query($querySalesItem);        
            
            
            $queryStockTransaction = "insert into stock_transaction (grn_number, grn_date,item_id,
                                  item_qty,land_cost,entry_type,branch_id)
            values('$currentSalesNumber','$grnDate','$itemId[$a]','$itemQty[$a]',
                   '$landCost','P','$userBranchId')";
            $resultStockTransaction = $con->query($queryStockTransaction);
                   
                   
                $querySearchStockBalance = "select*from stock_balance where item_id = '$itemId[$a]'
                                            and branch_id = '$userBranchId'";
                $resultSearchStockBalance = $con->query($querySearchStockBalance);
                
                if($resultSearchStockBalance->num_rows==0){
                    echo "item id from stock balance table = ";
                    echo "<br>";
                    
                    $queryStockBalance = "insert into stock_balance(item_id,item_qty,branch_id) values('$itemId[$a]','$itemQty[$a]','$userBranchId')";                
                    $resultStockBalance = $con->query($queryStockBalance);                    
                    
                    
                }else{
                    echo "<br>";
                    echo "item is there";
                    echo "<br>";
                    
                    
                        $queryStockBalance = "update stock_balance set item_qty = item_qty+'$itemQty[$a]'
                        where item_id = '$itemId[$a]' and branch_id = '$userBranchId'";
                        $resultStockBalance = $con->query($queryStockBalance);
                        
                                           
                    };
                    
                    $a++;            
                    
        }
                // $resultStockBalance = $con->query($queryStockBalance);
            
           
            if($resultQuery){
                
                $_SESSION['notification'] = "Sales Saved Successfully";            
                header("Location:".BASE_URL."/pages/salesEntry.php");
                
            }else{
                echo "something went wrong";
            }
    
    
    }else{
        $_SESSION['notification'] = "GRN Amount And Net Amount Does Not Match";
        header("Location:".BASE_URL."pages/salesEntry.php");
        echo '<script>
      document.addEventListener("DOMContentLoaded", function() {
          let toastElement = new bootstrap.Toast(document.getElementById("liveToast"));
          toastElement.show();
      });
    </script>';
    
            

        }
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
    
    
    // echo $customerName;
    // echo "<pre>";
    // print_r($product);
    

?>


<?php ob_end_flush(); ?>
<?php include_once(DIR_URL."includes/footer.php");?>