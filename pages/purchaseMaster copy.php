<?php
include_once("../config/config.php");
include_once(DIR_URL."includes/header.php");
include_once(DIR_URL."db/dbConnection.php");
include_once(DIR_URL."includes/navbar.php");
include_once(DIR_URL."includes/sidebar.php");
include_once(DIR_URL."includes/itemMaster.php");

$userId= $_SESSION['user_id'];
$userLocationId = $_SESSION['user_location_id'];
$financial_year = $_SESSION['financial_year'];


$querySearchSnoMaster = "select*from sno_master where financial_year = '$financial_year'";
$resultSearchSnoMaster  = $con->query($querySearchSnoMaster)->fetch_assoc();

$purchase_no = $resultSearchSnoMaster['purchase_no'];


// itemGrid('p','d','f','s','df','k','d','s','d','d','d','500',$userId,$con);

$purchase_no = $purchase_no+1;





$querySearchTax = "select*from taxes where location_id = '$userLocationId'";
$resultSearchTax = $con->query($querySearchTax);
?>


<style>
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


#supplierName{
    margin-top:-120px;
    /* margin-left:300px; */
    width: 400px;
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

#grn,#grnDate{
    margin-top:20px;
    margin-left: 15px;
    width: 140px;
    font-size: 13px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
    
    
}
#dcNumber,#dcDate,#invoiceNumber,#invoiceDate{
    margin-top:-2px;
    margin-left:10px;
    width: 150px;
    font-size: 13px;
    font-weight: bold;
    text-transform: capitalize;
    height: 30px;
}
/* #invoiceNumber,#invoiceDate{
    margin-top:10px;
    width: 150px;
    font-size: 15px;
    font-weight: bold;
    text-transform: capitalize;
    height: 40px;
} */
</style>



<!-- <div style="margin-left:300px">
<form action="" id="supplierForm" method="post">
<h3 style="text-align:left;font-family:Verdana, Geneva, Tahoma, sans-serif;"><span style="font-weight:bolder">Purchase </span><span style="font-size:medium;font-weight:bold;color:gray;">Entry</span></h3>
<hr>
<div class="form-floating">
<input type="text" name="grn" id="grn" class="form-control" placeholder="Grn" value=""  maxlength="30">
<label for="floatingInput">GRN</label>
</div>

</div> -->

<div class="" style="margin-left:1160px;border:1px solid black;width:340px;height:140px;margin-top:10px;">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab">GRN</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">DC & Invoice</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <div style="display:flex;gap:10px;">
                    <div class="form-floating">
                        <input type="text" name="grn" id="grn" readonly class="form-control" placeholder="Goods Receipt Number" value=""  maxlength="30">
                        <label for="GRN" style="margin-left:6px;margin-top:12px;">GRN</label>
                    </div>          
                    <div class="form-floating">
                        <input type="date" name="grnDate" readonly id="grnDate" class="form-control" placeholder="GRN Date " value=""  maxlength="30">
                        <label for="GRNDate" style="margin-left:15px;margin-top:15px;">GRN Date</label>
                    </div>          
                </div>
                
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <div style="display:flex;gap:10px">
                    <div class="form-floating">
                        <input type="text" name="dcNumber" id="dcNumber" class="form-control" placeholder="DC Number" value=""  maxlength="20">
                        <label for="DCNumber" style="margin-top:-10px">DC Number</label>
                    </div>          
                    <div class="form-floating">
                        <input type="date" name="dcDate" id="dcDate" class="form-control" placeholder="DC Date" value="" maxlength="20">
                        <label for="DCDate" style="margin-top:-10px">DC Date</label>
                    </div>          
                </div>
                <div style="margin-top:5px;">
                </div>
                <div style="display:flex;gap:10px;">
                    <div class="form-floating">
                        <input type="text" name="invoiceNumber" id="invoiceNumber" class="form-control" placeholder="Invoice Number" value=""  maxlength="30">
                        <label for="invoiceNumber" style="margin-top:-10px">Invoice Number</label>
                    </div>          
                    <div class="form-floating">
                        <input type="date" name="invoiceDate" id="invoiceDate" class="form-control" placeholder="Invoice Date" value="">
                        <label for="invoiceDate" style="margin-top:-10px;">Invoice Date</label>
                    </div>          
                </div>
            
            </div>
            
        </div>
</div>
<div style="margin-top:-20px;margin-left:5px">



<div style="display:flex;gap:12px">
        <label for="" style="margin-left:280px;margin-top:-118px;">Supplier Name</label>
        <input type="text" name="supplierName" id="supplierName" class="form-control" placeholder="Press F2 For Supplier Info">
</div>
<br>
<div style="display:flex;gap:23px;">
    <label for="" style="margin-left:280px;margin-top:-98px">GRN Amount</label>
    <input type="text" name="grnAmount" id="grnAmount" style="" class="form-control" maxlength="12">
</div>

</div>

<div class="container" style="margin-top:10px" id="itemGrid">

        <div id="response_message">
        
        </div>
        <div>
            <?php
                if(isset($_SESSION['product'])){
                    print_r($_SESSION['product']);
                }
            ?>
        </div>
        <div style="display:flex" hidden>
        <label for=""   style="margin-left:200px;">User Id</label>
        <input type="text" name="userId" readonly id="userId" class="form-control" value="<?php echo $userId;?>" style="width:250px;">
        <label for="">Location Id</label>
        <input type="text" name="userLocationId" readonly id="userLocationId" class="form-control" value="<?php echo $userLocationId;?>" style="width:250px;">
        </div>
        
        <form action="" id="frm" method="post" style="margin-left:170px;font-size:12px;">
        
        <div style=" width:1235px;height:270px;overflow-y:auto;"id="itemTable">
        
    <table class="table text-white table-dark"   style="border-collapse:collapse;width:100%;">
        <thead>
            <tr style="position:sticky;z-index:1;top:0;background-color:#FF3CAC">
                <th style="padding-left:2px">S.No.</th>
                <th style="padding-left:25px">Product</th>
                <th style="padding-left:30px">Brand</th>
                <th style="padding-left:25px">Design</th>
                <th style="padding-left:20px">Batch</th>
                <th style="padding-left:15px">Color</th>
                <th style="padding-left:5px">Category</th>
                <th style="padding-left:10px">HSN</th>
                <th style="padding-left:0px">Tax</th>
                <th style="padding-left:5px">Size</th>
                <th style="padding-left:20px">Mrp</th>
                <th style="padding-left:5px">Selling</th>
                <th style="padding-left:5px">Rate</th>
                <th style="padding-left:px">Qty</th>
                <th style="padding-left:2px">Amount</th>
                <th>Id</th>
                <th style="padding-left:2px">Action</th>
            </tr>
        </thead>
        <tbody class="items" id="table_body" >
            <tr>
                <td>
                    <input
                        type="text"
                        class="serial-field"
                        name="serialNumber[]"
                        id="serialNumber_1"
                        style="font-size:12px;height:25px;width:40px;margin-left:1px;"
                        maxlength="4"
                        autocomplete="off"
                        
                    />
                </td>
            
                <td>
                    <input
                        type="text"
                        class="product-field"
                        name="product[]"
                        id="product_1"
                        autocomplete="off"
                        style="font-size:12px;height:25px;width:120px;margin-left:-9px;font-weight:bold"
                        maxlength="30"
                    />
                </td>
                <td>
                    <input
                        type="text" 
                        class="brand-field"
                        name="brand[]"
                        id="brand_1"
                        autocomplete="off"
                        style="font-size:12px;height:25px;width:120px;margin-left:-9px;"
                        maxlength="30"
                    />
                </td>
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="design[]"
                        id="design_1"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:120px;margin-left:-9px;"
                        maxlength="30"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="batch[]"
                        id="batch_1"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:100px;margin-left:-9px;"
                        maxlength="30"
                    />
                </td>
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="color[]"
                        id="color_1"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:80px;margin-left:-9px;"
                        maxlength="30"
                    />
                </td>
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="category[]"
                        id="category_1"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:80px;margin-left:-8px;"
                        maxlength="30"
                    />
                </td>
                <td>
                    <input
                        type="text"
                        class="design-field"
                        name="hsnCode[]"
                        id="hsnCode_1"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:70px;margin-left:-6px;"
                        maxlength="8"
                    />
                </td>
                <td>
                
                    
                    <input
                        type="text" 
                        class="design-field"
                        name="tax[]"
                        id="tax_1"
                        style="font-size:13px;height:25px;width:50px;margin-left:-16px;"
                        maxlength="4"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="size[]"
                        id="size_1"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:50px;margin-left:-5px;"
                        maxlength="30"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="mrp[]"
                        id="mrp_1"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:80px;margin-left:-5px;"
                        maxlength="12"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="sellingPrice[]"
                        id="sellingPrice_1"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:80px;margin-left:-6px;"
                        maxlength="12"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="rate[]"
                        id="rate_1"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:80px;margin-left:-18px;"
                        maxlength="12"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="qty[]"
                        id="qty_1"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:65px;margin-left:-10px;"
                        maxlength="5"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="amount[]"
                        id="amount_1"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:90px;margin-left:-14px;"
                        maxlength="13"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="id[]"
                        id="id_1"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:50px;margin-left:-3px;"
                        
                    />
                </td>
                <!-- <td>
                    <button
                        type="button" id="addMore"
                        class="btn btn-primary" title="Add more row"
                        style="font-size:10px;margin-left:5px"
                        >
                        +
                    </button>
                </td> -->
            </tr>
        </tbody>
    </table>
    </div>
    <br>
    <button
        type="submit"
        class="btn btn-primary" name="submit_button">
        Submit
    </button>
</form>
</div>

<div style="margin-left:1228px;margin-top:-45px">

<label for="" style="margin-left:-2px">Total</label>
<input type="text" name="totalQty" id="totalQty" readonly style="font-size:13px;height:25px;width:50px;" maxlength="4">
<input type="text" name="totalAmount" id="totalAmount" readonly style="font-size:13px;height:25px;width:90px;margin-left:-5px" maxlength="12">




<div style="display:flex;margin-top:2px;">
<label for="">CGST</label>
<input type="text" name="cgstAmount" id="cgstAmount" style="font-size:13px;height:25px;width:90px;margin-left:48px" maxlength="12">
</div>
<div style="display:flex;margin-top:2px;">
<label for="">SGST</label>
<input type="text" name="sgstAmount" id="sgstAmount" style="font-size:13px;height:25px;width:90px;margin-left:49px" maxlength="12">
</div>
<div style="display:flex;margin-top:2px;">
<label for="">IGST</label>
<input type="text" name="igstAmount" id="igstAmount" style="font-size:13px;height:25px;width:90px;margin-left:54px" maxlength="12">
</div>

<div style="display:flex;margin-top:2px;">
<label for="">Add On</label>
<input type="text" name="addOnAmount" id="addOnAmount" style="font-size:13px;height:25px;width:90px;margin-left:31px" maxlength="12">
</div>

<div style="display:flex;margin-top:3px;">
<label for="">Deduction</label>
<input type="text" name="deductionAmount" id="deductionAmount" style="font-size:13px;height:25px;width:90px;margin-left:13px" maxlength="12">
</div>

<div style="display:flex;margin-top:2px;">
<label for="">Net</label>
<input type="text" name="netAmount" id="netAmount" readonly style="font-size:13px;height:25px;width:90px;margin-left:60px" maxlength="12">
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    
    window.onload = function(){
        localStorage.setItem("row_index",1);
        localStorage.setItem("row_deleted",0);
    }
    // document.getElementById("product").addEventListener("keypress", function(event){
    
    //     if(event.key === "F2"){
    //         event.preventDefault();
    //         alert("hello");
    //     }
    // })
    // $(document).on("keypress", "#product", function(e){
    //         if(e.key === "F2"){
    //             alert("hi");
    //         }
    // })
    
    
    //text field navigation
    
//     $(document).on("keydown", "input", function (e) {
//     if (e.key === "Enter") {
//         e.preventDefault(); // Prevent the default form submission behavior

//         // Find all input fields in the form
//         let inputs = $("input");

//         // Get the current input index
//         let currentIndex = inputs.index(this);

//         // Focus on the next input field, if it exists
//         if (currentIndex + 1 < inputs.length) {
//             inputs.eq(currentIndex + 1).focus();
//         }
//     }
// });

document.getElementById("supplierName").addEventListener("keydown", function(event){
        let target = event.target;
    if(event.key === "F2"){
        event.preventDefault();
        let supplierName = new FormData();
        supplierName.append("lb_supplier_name",target.value);
        let aj_supplier =  new XMLHttpRequest();
        aj_supplier.open("POST","itemStoring.php",true);
        aj_supplier.send(supplierName);
        
        aj_supplier.onreadystatechange = function(){
            if(aj_supplier.status === 200 && aj_supplier.readyState === 4){
            document.getElementById("response_message").innerHTML = aj_supplier.responseText;
            }
        }
        
    
    }
})
document.getElementById("table_body").addEventListener("keydown", function (event) {
    const target = event.target;

    // Handle the Enter key event
    if (event.key === "Enter") {
        event.preventDefault(); // Prevent the default Enter key behavior

        // Navigate based on the input field's name
        if (target.name === "product[]") {
            const currentRow = target.closest("tr");
            const brandField = currentRow.querySelector('input[name="brand[]"]');
            
                let product_data = new FormData();
                product_data.append("al_product",target.value)
                let aj = new XMLHttpRequest();
                aj.open("POST", "itemStoring.php", true);
                aj.send(product_data);
                aj.onreadystatechange = function(){
                    if(aj.status === 200 && aj.readyState === 4){
                        document.getElementById('response_message').innerHTML = aj.responseText;
                    }
                
                }
                
            if (brandField) {
                brandField.focus();
            }
        } else if (target.name === "brand[]") {
            const currentRow = target.closest("tr");
            const designField = currentRow.querySelector('input[name="design[]"]');
                    
                let brand_data = new FormData();
                brand_data.append("al_brand", target.value)
                let aj_brand  = new XMLHttpRequest();
                aj_brand.open("POST","itemStoring.php", true);
                aj_brand.send(brand_data);
                aj_brand.onreadystatechange = function(){
                    if(aj_brand.status === 200 && aj_brand.readyState === 4){
                        document.getElementById("response_message").innerHTML =aj_brand.responseText;
                    }
                }
            if (designField) {
                designField.focus();
            }
        }else if(target.name == "design[]"){
        
            const currentRow = target.closest("tr");
            const batchField = currentRow.querySelector('input[name="batch[]"]');
                    
                let design_data = new FormData();
                design_data.append("al_design", target.value)
                let aj_design  = new XMLHttpRequest();
                aj_design.open("POST","itemStoring.php", true);
                aj_design.send(design_data);
                aj_design.onreadystatechange = function(){
                    if(aj_design.status === 200 && aj_design.readyState === 4){
                        document.getElementById("response_message").innerHTML =aj_design.responseText;
                    }
                }
            if (batchField) {
                batchField.focus();
            }
        
        
        }else if(target.name == "batch[]"){
        
        const currentRow = target.closest("tr");
        const colorField = currentRow.querySelector('input[name="color[]"]');
                
            let batch_data = new FormData();
            batch_data.append("al_batch", target.value)
            let aj_batch  = new XMLHttpRequest();
            aj_batch.open("POST","itemStoring.php", true);
            aj_batch.send(batch_data);
            aj_batch.onreadystatechange = function(){
                if(aj_batch.status === 200 && aj_batch.readyState === 4){
                    document.getElementById("response_message").innerHTML =aj_batch.responseText;
                }
            }
        if (colorField) {
            colorField.focus();
        }
    
    
    }else if(target.name == "color[]"){
        
        const currentRow = target.closest("tr");
        const categoryField = currentRow.querySelector('input[name="category[]"]');
                
            let color_data = new FormData();
            color_data.append("al_color", target.value)
            let aj_color  = new XMLHttpRequest();
            aj_color.open("POST","itemStoring.php", true);
            aj_color.send(color_data);
            aj_color.onreadystatechange = function(){
                if(aj_color.status === 200 && aj_color.readyState === 4){
                    document.getElementById("response_message").innerHTML =aj_color.responseText;
                }
            }
        if (categoryField) {
            categoryField.focus();
        }
    
    
    }else if(target.name == "category[]"){
        
        const currentRow = target.closest("tr");
        const hsnCodeField = currentRow.querySelector('input[name="hsnCode[]"]');
                
            let category_data = new FormData();
            category_data.append("al_category", target.value)
            let aj_category  = new XMLHttpRequest();
            aj_category.open("POST","itemStoring.php", true);
            aj_category.send(category_data);
            aj_category.onreadystatechange = function(){
                if(aj_category.status === 200 && aj_category.readyState === 4){
                    document.getElementById("response_message").innerHTML =aj_category.responseText;
                }
            }
        if (hsnCodeField) {
            hsnCodeField.focus();
        }
    
    
    }else if(target.name == "hsnCode[]"){
        
        const currentRow = target.closest("tr");
        const taxField = currentRow.querySelector('input[name="tax[]"]');
                
            let hsnCode_data = new FormData();
            hsnCode_data.append("al_hsnCode", target.value)
            let aj_hsnCode  = new XMLHttpRequest();
            aj_hsnCode.open("POST","itemStoring.php", true);
            aj_hsnCode.send(hsnCode_data);
            aj_hsnCode.onreadystatechange = function(){
                if(aj_hsnCode.status === 200 && aj_hsnCode.readyState === 4){
                    document.getElementById("response_message").innerHTML =aj_hsnCode.responseText;
                }
            }
        if (taxField) {
            taxField.focus();
            taxField.click();
        }
    
    
    }else if(target.name == "tax[]"){
        
        const currentRow = target.closest("tr");
        const sizeField = currentRow.querySelector('input[name="size[]"]');
                
            let tax_data = new FormData();
            tax_data.append("al_tax", target.value)
            let aj_tax  = new XMLHttpRequest();
            aj_tax.open("POST","itemStoring.php", true);
            aj_tax.send(tax_data);
            aj_tax.onreadystatechange = function(){
                if(aj_tax.status === 200 && aj_tax.readyState === 4){
                    document.getElementById("response_message").innerHTML =aj_tax.responseText;
                }
            }
        if (sizeField) {
            sizeField.focus();
            
        }
    
    
    }else if(target.name == "size[]"){
        
        const currentRow = target.closest("tr");
        const mrpField = currentRow.querySelector('input[name="mrp[]"]');
                
            let size_data = new FormData();
            size_data.append("al_size", target.value)
            let aj_size  = new XMLHttpRequest();
            aj_size.open("POST","itemStoring.php", true);
            aj_size.send(size_data);
            aj_size.onreadystatechange = function(){
                if(aj_size.status === 200 && aj_size.readyState === 4){
                    document.getElementById("response_message").innerHTML =aj_size.responseText;
                }
            }
        if (mrpField) {
            mrpField.focus();
        }
    
    
    }else if(target.name == "mrp[]"){
        
        const currentRow = target.closest("tr");
        const sellingPriceField = currentRow.querySelector('input[name="sellingPrice[]"]');
                
            let mrp_data = new FormData();
            mrp_data.append("al_mrp", target.value)
            let aj_mrp  = new XMLHttpRequest();
            aj_mrp.open("POST","itemStoring.php", true);
            aj_mrp.send(mrp_data);
            aj_mrp.onreadystatechange = function(){
                if(aj_mrp.status === 200 && aj_mrp.readyState === 4){
                    document.getElementById("response_message").innerHTML =aj_mrp.responseText;
                }
            }
        if (sellingPriceField) {
            sellingPriceField.focus();
        }
    
    
    }else if(target.name == "sellingPrice[]"){
        
        const currentRow = target.closest("tr");
        const rateField = currentRow.querySelector('input[name="rate[]"]');
                
            let sellingPrice_data = new FormData();
            sellingPrice_data.append("al_sellingPrice", target.value)
            let aj_sellingPrice  = new XMLHttpRequest();
            aj_sellingPrice.open("POST","itemStoring.php", true);
            aj_sellingPrice.send(sellingPrice_data);
            aj_sellingPrice.onreadystatechange = function(){
                if(aj_sellingPrice.status === 200 && aj_sellingPrice.readyState === 4){
                    document.getElementById("response_message").innerHTML =aj_sellingPrice.responseText;
                }
            }
        if (rateField) {
            rateField.focus();
        }
    
    
    }else if(target.name == "rate[]"){
        
        const currentRow = target.closest("tr");
        const qtyField = currentRow.querySelector('input[name="qty[]"]');
                
            
     
        if (qtyField) {
            qtyField.focus();
        }
    
    
    }
    else if (target.name === "qty[]") {
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
                        productField.focus();
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


    document.getElementById("table_body").addEventListener("keydown", function(event){
    
        const target = event.target;
        
        
        if(event.key === "Enter"){
            let cellIndex = localStorage.getItem("row_index");
            if(target.name == "rate[]"){
                let product  = document.getElementById("product_"+cellIndex).value;
                alert(product);
                //    let targetRow = target.closest('tr');
                //    if(targetRow){
                //     const row_index =targetRow.rowIndex;
                //     alert("rowindex",row_index);
                //    }
            }
        }
        
        
        
        
        if(target.tagName  === "INPUT"){
            let fieldName=target.name;
            const value = target.value;
            let currentLocationId = document.getElementById("userLocationId").value;
            if(event.key === "F2"){
                
                event.preventDefault();
                fieldName = fieldName.replace("[]","");
                
                
                let data = new FormData();
                let query = "";
                if(fieldName == "batch"){
                     query = `select * from ${fieldName}es where ${fieldName}_name like '${value}%' && location_id = '${currentLocationId}' `;
                }else if(fieldName == "category"){
                     query = `select * from categories where ${fieldName}_name like '${value}%' && location_id = '${currentLocationId}' `;
                }else if(fieldName == "hsnCode"){
                     query = `select * from hsn_codes where hsn_code like '${value}%' && location_id = '${currentLocationId}' `;
                }else if(fieldName == "tax"){
                     query = `select * from taxes where tax_code like '${value}%' && location_id = '${currentLocationId}' `;
                }else if(fieldName == "mrp"){
                     query = `select * from mrps where mrp like '${value}%' && location_id = '${currentLocationId}' `;
                }
                else{
                    query = `select * from ${fieldName}s where ${fieldName}_name like '${value}%' && location_id = '${currentLocationId}' `;
                }
                
                data.append(`lb_qry_${fieldName}`, query);
                let row_index_f2 =localStorage.getItem("row_index");
                data.append("lb_f2_row_index", row_index_f2);
                const ajaxRequest = new XMLHttpRequest();
                ajaxRequest.open("POST", "itemStoring.php", true);
                ajaxRequest.send(data);
                ajaxRequest.onreadystatechange = function () {
                if (ajaxRequest.status === 200 && ajaxRequest.readyState === 4) {
                    document.getElementById("response_message").innerHTML = ajaxRequest.responseText;
                }
            };
            }
        }
    
    })
    
//     document.addEventListener("DOMContentLoaded", function () {
//     attachEventListeners(); // Attach listeners on page load

//     document.getElementById("table_body").addEventListener("keydown", function (event) {
//         if (event.key === "Enter" && event.target.name === "rate[]") {
            
//         }
//     });
// });

// function attachEventListeners() {
//     document.querySelectorAll(
//         'input[name="product[]"], input[name="brand[]"], input[name="design[]"], input[name="batch[]"], input[name="color[]"],' +
//         'input[name="category[]"], input[name="hsnCode[]"], input[name="tax[]"], input[name="size[]"],' +
//         'input[name="mrp[]"], input[name="sellingPrice[]"], input[name="rate[]"], input[name="qty[]"]'
//     ).forEach(input => {
//         input.addEventListener("focus", function () {
//             handleEvent(input);
//         });

//         input.addEventListener("click", function () {
//             handleEvent(input);
//         });
//     });
// }

// function handleEvent(input) {
//     const currentRow = input.closest('tr');
//     if (currentRow) {
//         let rowIndex = currentRow.rowIndex;
//         localStorage.setItem("row_index", rowIndex);
//         console.log("rowindex = " + rowIndex);
//     }
// }


// // deep seek

// let activeInput = null; // Keep track of the active input field

// // Add event listener to the table body for keydown events
// document.getElementById("table_body").addEventListener("keydown", function (event) {
//     const target = event.target;

//     // Check if the target is an input field and handle the "Enter" key
//     if (target.tagName === "INPUT" && event.key === "Enter") {
//         handleEnterKey(target);
//     }
// });



// // Add event listeners to all relevant input fields
// document.querySelectorAll(
//     'input[name="product[]"], input[name="brand[]"], input[name="design[]"], input[name="batch[]"], input[name="color[]"],' +
//     'input[name="category[]"], input[name="hsnCode[]"], input[name="tax[]"], input[name="size[]"],' +
//     'input[name="mrp[]"], input[name="sellingPrice[]"], input[name="rate[]"], input[name="qty[]"]'
// ).forEach(input => {
//     input.addEventListener("click", () => handleEvent(input));
//     input.addEventListener("focus", () => handleEvent(input));
// });

// // Function to handle input field events (click and focus)
// function handleEvent(input) {
//     // Get the current row of the focused input field
//     const currentRow = input.closest('tr');

//     // Get the row index
//     const rowIndex = currentRow.rowIndex;

//     // Store the row index in localStorage
//     localStorage.setItem("row_index", rowIndex);

//     // Display the row index in the console
//     console.log("rowindex = " + rowIndex);

//     // Update the active input field
//     activeInput = input;
// }

// // Function to handle the "Enter" key press
// function handleEnterKey(target) {
//     const currentRow = target.closest('tr');
//     const rowIndex = currentRow.rowIndex;

//     // If the target input is "rate[]", move to the next row
//     if (target.name === "rate[]") {
//         const nextRowIndex = rowIndex + 1;
//         localStorage.setItem("row_index", nextRowIndex);
//         console.log("Moved to row index: " + nextRowIndex);
//     }
// }



// // Function to log the row index
// function logRowIndex(input) {
//     const currentRow = input.closest('tr');
//     if (currentRow) {
//         const rowIndex = currentRow.rowIndex; // Get the row index
//         console.log("Row Index:", rowIndex); // Log the row index
//         localStorage.setItem("row_index", rowIndex); // Store the row index in localStorage
//     }
// }

// // Add event listeners to all input fields in the table
// document.querySelectorAll(
//     'input[name="product[]"], input[name="brand[]"], input[name="design[]"], input[name="batch[]"], input[name="color[]"],' +
//     'input[name="category[]"], input[name="hsnCode[]"], input[name="tax[]"], input[name="size[]"],' +
//     'input[name="mrp[]"], input[name="sellingPrice[]"], input[name="rate[]"], input[name="qty[]"]'
// ).forEach(input => {
//     input.addEventListener("click", () => logRowIndex(input));
//     input.addEventListener("focus", () => logRowIndex(input));
// });

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



    
//     let activeInput = null; // Keep track of the active input field
// document.getElementById("table_body").addEventListener("keydown", function (event) {
//     const target = event.target;
//     // Add event listener to all 'product' input fields
// document.querySelectorAll(
// 'input[name="product[]"], input[name="brand[]"] , input[name="design[]"], input[name="batch[]"], input[name="color[]"],'+
// 'input[name="category[]"], input[name="hsnCode[]"], input[name="tax[]"], input[name="size[]"],'+
// 'input[name="mrp[]"], input[name="sellingPrice[]"], input[name="rate[]"], input[name="qty[]"]'
// ).forEach(input => {
//     input.addEventListener("click", function() {
//     handleEvent(input);
// });

// input.addEventListener("focus", function() {
//     handleEvent(input);
// });

// function handleEvent(input) {
//     // Get the current row of the focused input field
//     const currentRow = input.closest('tr');
    
//     // Get the row index
//     let rowIndex = currentRow.rowIndex;
    
//     localStorage.setItem("row_index", rowIndex);

//     // Display the row index
//     console.log("rowindex = " + rowIndex);
    
//     input.addEventListener("keydown", function(event){
//         let target = event.target;
//         if(event.key === "Enter"){
        
//             if(target.name == "rate[]"){
//                    let row_index = rowIndex+1; 
//                     localStorage.setItem("row_index", row_index);
//             }
//         //     const currentRow = input.closest('tr');

//         // // Get the row index
//         // const rowIndex = currentRow.rowIndex;

//         // Display the row index
//         // console.log(rowIndex);
//         }
//     })
// }

// })
// });

    // $(document).on("keypress", ".product-field", function(e){
    //     if(e.key === "F2"){
    //         alert("hi");
    //         e.preventDefault();
    //         let data = "hi"
    //         let form_data = new FormData();
    //         form_data.append("lb", data);
            
    //         let aj = new XMLHttpRequest();
    //         aj.open("post", "f2events.php", true);
    //         aj.send(form_data);
            
    //         aj.onreadystatechange = function(){
    //             if(aj.status == 200 && aj.readyState == 4){
    //                 document.getElementById("response_message").innerHTML =aj.responseText;
    //             }
    //         }
    //     }
    // })
    
    $(document).on("keypress", ".design-field", function(e) {
    
        
        if(e.key === "Enter"){
            e.preventDefault();
            
            // Get the current row
            // input.addEventListener("focus", function(){
            //     alert("focused");
            // })
            let currentRow = $(this).closest("tr");
            
            // let  i = currentRow.rowIndex;
            
            
            // localStorage.setItem("row_index", i);
            // console.log("row index set to :", i);

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
    
    
    function add_row(){
        let i =parseInt(localStorage.getItem("row_index"))+1;
        const currentRows = document.querySelectorAll('#table_body tr');
    const newRowIndex = currentRows.length + 1;
    
    // Add the new row using vanilla JS instead of jQuery
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
            <tr>
                <td>
                    <input
                        type="text"
                        class="serial-field"
                        name="serialNumber[]"
                        id="serialNumber_${i}"
                        style="font-size:12px;height:25px;width:40px;margin-left:1px;"
                        maxlength="4"
                        autocomplete="off"
                        
                    />
                </td>
            
                <td>
                    <input
                        type="text"
                        class="product-field"
                        name="product[]"
                        id="product_${i}"
                        autocomplete="off"
                        style="font-size:12px;height:25px;width:120px;margin-left:-9px;font-weight:bold"
                        maxlength="30"
                    />
                </td>
                <td>
                    <input
                        type="text" 
                        class="brand-field"
                        name="brand[]"
                        id="brand_${i}"
                        autocomplete="off"
                        style="font-size:12px;height:25px;width:120px;margin-left:-9px;"
                        maxlength="30"
                    />
                </td>
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="design[]"
                        id="design_${i}"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:120px;margin-left:-9px;"
                        maxlength="30"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="batch[]"
                        id="batch_${i}"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:100px;margin-left:-9px;"
                        maxlength="30"
                    />
                </td>
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="color[]"
                        id="color_${i}"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:80px;margin-left:-9px;"
                        maxlength="30"
                    />
                </td>
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="category[]"
                        id="category_${i}"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:80px;margin-left:-8px;"
                        maxlength="30"
                    />
                </td>
                <td>
                    <input
                        type="text"
                        class="design-field"
                        name="hsnCode[]"
                        id="hsnCode_${i}"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:70px;margin-left:-6px;"
                        maxlength="8"
                    />
                </td>
                <td>
                
                    
                    <input
                        type="text" 
                        class="design-field"
                        name="tax[]"
                        id="tax_${i}"
                        style="font-size:13px;height:25px;width:50px;margin-left:-16px;"
                        maxlength="4"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="size[]"
                        id="size_${i}"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:50px;margin-left:-5px;"
                        maxlength="30"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="mrp[]"
                        id="mrp_${i}"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:80px;margin-left:-5px;"
                        maxlength="12"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="sellingPrice[]"
                        id="sellingPrice_${i}"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:80px;margin-left:-6px;"
                        maxlength="12"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="rate[]"
                        id="rate_${i}"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:80px;margin-left:-18px;"
                        maxlength="12"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="qty[]"
                        id="qty_${i}"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:65px;margin-left:-10px;"
                        maxlength="5"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="amount[]"
                        id="amount_${i}"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:90px;margin-left:-14px;"
                        maxlength="13"
                    />
                </td>
                
                <td>
                    <input
                        type="text" 
                        class="design-field"
                        name="id[]"
                        id="id_${i}"
                        autocomplete="off"
                        style="font-size:13px;height:25px;width:50px;margin-left:-3px;"
                        
                    />
                </td>
                <td>
                    <button
                        type="button" id="remove"
                        class="btn btn-danger" title="Remove"
                           style="font-size:10px;margin-left:5px"
                        >
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        
        document.querySelector('#table_body').appendChild(newRow);
    
    // Log the index of the new row
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
        row.querySelectorAll('input').forEach(input => {
            const name = input.name.replace(/\d+/, rowNumber);
            const id = input.id.replace(/\d+/, rowNumber);
            input.name = name;
            input.id = id;
        });
    });
    
    localStorage.setItem("row_deleted", 1);
}); 
    
    $(document).on("click", "#remove", function(e) {
        e.preventDefault();
        $(this).closest("tr").remove();
        localStorage.setItem("row_deleted", 1);
    });
    
    
    
    window.onload = function(){
        document.getElementById("supplierName").focus();
        let mydate = new Date();
        let currentDate = mydate.getFullYear() + "-" + 
                         (mydate.getMonth() + 1).toString().padStart(2, "0") + "-" + 
                          mydate.getDate().toString().padStart(2, "0");
        document.getElementById("grnDate").value = currentDate;
        document.getElementById("dcDate").value =currentDate;
        document.getElementById("invoiceDate").value =currentDate;
        
        document.getElementById("grn").value = '<?php echo htmlspecialchars($purchase_no);?>';
    }
    
document.getElementById('grnAmount').addEventListener('keypress', function (event) {
            const charCode = event.which || event.keyCode; // Get the character code
            const charStr = String.fromCharCode(charCode); // Convert to a string

            // Allow digits (0-9) and a single decimal point
            if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
                event.preventDefault(); // Prevent input if not a number or extra decimal
            }
        });

        document.getElementById('grnAmount').addEventListener('input', function () {
            // Prevent any invalid characters that might slip through (e.g., copy-paste)
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
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

    
    
// document.getElementById("grnAmount").addEventListener("keydown", function(event){
//      if(event.key === "Enter"){
//         event.preventDefault();
//         document.getElementById("invoiceNumber").focus()
//      }
// })


document.getElementById("supplierName").addEventListener("keydown", function(event){
        
        if(event.key === "Enter"){
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


document.getElementById("dcNumber").addEventListener("keydown", function(event){

    if(event.key  === "Enter"){
        event.preventDefault();
        document.getElementById("dcDate").focus();
        
    }
})



document.getElementById("dcDate").addEventListener("keydown", function(event){

    if(event.key === "Enter"){
    
        event.preventDefault();
        document.getElementById("invoiceNumber").focus();
    }
})


document.getElementById("invoiceNumber").addEventListener("keydown", function(event){
    if(event.key === "Enter"){
        event.preventDefault();
        document.getElementById("invoiceDate").focus();
        
    }
})

document.getElementById("invoiceDate").addEventListener("keydown", function(event){

    if(event.key === "Enter"){
    
        event.preventDefault();
        
        document.getElementById("product_1").focus();
    }
})

document.getElementById("cgstAmount").addEventListener("keydown",function(event){

    if(event.key === "Enter"){
    
        event.preventDefault();
        document.getElementById("sgstAmount").focus();
    }
})

document.getElementById("sgstAmount").addEventListener("keydown",function(event){

    if(event.key === "Enter"){
        event.preventDefault();
        document.getElementById("igstAmount").focus();
    }
})

document.getElementById("igstAmount").addEventListener("keydown",function(event){

if(event.key === "Enter"){
    event.preventDefault();
    document.getElementById("addOnAmount").focus();
}
})

document.getElementById("addOnAmount").addEventListener("keydown",function(event){

if(event.key === "Enter"){
    event.preventDefault();
    document.getElementById("deductionAmount").focus();
}
})

    // i want to focus in invoiceNumber text field when i press enter key in grnAmount text field
</script>

        
        
       <!-- <form action="" id="frm" method="post">
       
        <div class="items">
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label for="" class="form-label fw-bold ">Item Name</label>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="" class="form-label fw-bold ">Rate</label>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="" class="form-label fw-bold ">Stock</label>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-3">
                    <input
                        type="text" required
                        class="form-control"
                        name="product[]"
                    />
                </div>
                <div class="mb-3 col-md-3">
                    <input
                        type="number" min="1"
                        class="form-control"
                        name="brand[]" required
                    />
                </div>
                <div class="mb-3 col-md-3">
                    <input
                        type="number" min="1"
                        class="form-control"
                        name="design[]" required
                    />
                </div>
                <div class="mb-3 col-md-3">
                    <button
                        type="button" id ="addMore"
                        class="btn btn-primary" title="add more row">
                        +
                    </button>
                </div>
            </div>
        </div>
        <button
            type="submit"
            class="btn btn-primary" name="submit_button">
            Submit
        </button>
        
       </form> 
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).on("click","#addMore", function(e){
            e.preventDefault();
            $(".items").append(`<div class="row addlRow">
                <div class="mb-3 col-md-3">
                    <input
                        type="text" required
                        class="form-control"
                        name="product[]"
                    />
                </div>
                <div class="mb-3 col-md-3">
                    <input
                        type="number" min="1"
                        class="form-control"
                        name="brand[]" required
                    />
                </div>
                <div class="mb-3 col-md-3">
                    <input
                        type="number" min="1"
                        class="form-control"
                        name="design[]" required
                    />
                </div>
                <div class="mb-3 col-md-3">
                    <button
                        type="button" id ="remove"
                        class="btn btn-danger" title="remove">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>`);
        });
    </script>

    <script>
        $(document).on("click","#remove",function(e){
            e.preventDefault();
            $(this).parent().parent().remove();
        });
    </script> -->

    <!-- <script>
       $(document).on("submit","#frm", function(e){
        e.preventDefault();
        $.ajax({
            type:"post",
            url:"create_items.php",
            data:$(this).serialize(),
            success:function(response){
                if (response=="success"){
                    var str = '<div class="alert alert-success">Rows inserted successfully</div>';
                    $(".addlRow").remove();
                    $("#frm")[0].reset();
                }
                else{
                    var str = '<div class="alert alert-danger">'+response+'</div>';
                }
                $("#msg").html(str);
            }

        });
       });
    </script> -->
</body>
</html>

<?php
    
if(isset($_POST['submit_button'])){
    $product = $_POST['product'];
    $brand = $_POST['brand'];
    $design = $_POST['design'];
    
    // echo '<pre>';
    // print_r($product);
    // echo "<br>";
    
    // echo '<pre>';
    // print_r($brand);
    // echo "<br>";
    
    // echo '<pre>';
    // print_r($design);
    // echo "<br>";
    // exit;
}
?>




<?php include_once(DIR_URL."includes/footer.php");?>