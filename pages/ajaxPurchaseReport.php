<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");
// include_once(DIR_URL."cls/clsSupplier.php");


// // Initialize class (or retrieve from session)
// $clsSupplier = new ClassSupplier();

// $clsSupplier = new ClassSupplier();


$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];

$field2 =  "";



?>

<?php 

  if(isset($_POST['lb_supplier_name'])){
  
    $supplierName = $_POST['lb_supplier_name'];
    
    $querySearchSuppInfo = "select*from suppliers where supplier_name like '%$supplierName%'
                            && branch_id = '$userBranchId' order by supplier_name";
    $resultSearchSuppInfo = $con->query($querySearchSuppInfo);
    
      // while($suppData = $resultSearchSuppInfo->fetch_assoc()){
        
          
      // }
    
    
  }


  if(isset($_POST['lb_grn_number'])){
    $grnDetails =   json_decode($_POST['lb_grn_number']);
    
    
    $caption = "GRN";
    $jsVariable = "grnNumber";
    $fieldName = 'grn_number';
    $querySearchPurchaseSummary = "select * from purchase_summary where grn_number like '%$grnDetails[0]%'
                                   && supplier_id like '%$grnDetails[1]%'  && branch_id='$userBranchId'
                                   &&  (date(grn_date) between '$grnDetails[2]' and '$grnDetails[3]')
                                   order by grn_number DESC";
    $resultSearchPurchaseSummary = $con->query($querySearchPurchaseSummary);
    
}elseif(isset($_POST['lb_invoice_number'])){
    $invoiceDetails = json_decode($_POST['lb_invoice_number']);
    
    $caption = "Invoice Number";
    $jsVariable = "invoiceNumber";
    $fieldName = 'invoice_number';
    $querySearchPurchaseSummary = "select  * from purchase_summary where invoice_number like '%$invoiceDetails[0]%'
                                   and supplier_id like '%$invoiceDetails[1]%' and branch_id='$userBranchId'
                                   and (date(invoice_date) between '$invoiceDetails[2]' and '$invoiceDetails[3]' )
                                   order by invoice_number";
    $resultSearchPurchaseSummary = $con->query($querySearchPurchaseSummary);
    
}elseif(isset($_POST['lb_dc_number'])){
    $dcDetails = json_decode($_POST['lb_dc_number']);
    $caption = "DC Number";
    $jsVariable = "dcNumber";
    $fieldName = 'dc_number';
    $querySearchPurchaseSummary = "select  * from purchase_summary where dc_number like '%$dcDetails[0]%'
                                  and supplier_id like '%$dcDetails[1]%' and branch_id='$userBranchId'
                                  and (date(dc_date) between '$dcDetails[2]' and '$dcDetails[3]' )
                                  order by dc_number";
    
    
    $resultSearchPurchaseSummary = $con->query($querySearchPurchaseSummary);
    
}







if(isset($resultSearchSuppInfo)){
  
  
  
  
?>
<style>


#supplierInformationTable{
color:white;
background-color: #FF3CAC;
background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}

.supplierInputField{
  color: white;
  background:none;
  border:none;

}

.supplierNameField{
  color: white;
  background:none;
  border:none;
  outline: none;
}

.supplierInputField:focus{

  background-color:#FF3CAC;
  outline:none;
}


</style>
<!-- Supplier Information Start -->



<form style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
  <div style="max-height: 300px; overflow-y: auto; width: 750px;">
    <table id="supplierInformationTable" class="table" style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px;">
      <thead>
        <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
          <th><button class="btn-close" type="button"
          onclick="
            document.getElementById('supplierInformationTable').style.display = 'none';
          "
          style="background-color:#FF3CAC;"></button></th>
          <th style="width: 25px;"  > </th>
          <th style="width: 60px;"  >Id</th>
          <th style="width: 150px;" >Supplier Name</th>
          <th style="width: 120px;" >Address1</th>
          <th style="width: 120px;" >Address2</th>
          <th style="width: 180px;" >Address3</th>
          <th style="width: 100px;" >Locality</th>
          <th style="width: 100px;" >City</th>
          <th style="width: 80px;"  >PinCode</th>
          <th style="width: 100px;" >State</th>
          <th style="width: 100px;" >Landline</th>
          <th style="width: 100px;" >Mobile</th>
          <th style="width: 150px;" >Email</th>
          <th style="width: 130px;" >GST No.</th>
        </tr>
      </thead>
      <tbody>
      <?php $i = 1; while ($suppData = $resultSearchSuppInfo->fetch_assoc()) { ?>
           <tr style="font-size: 12px;"
            
             onclick="
             
             
                     
 
           
             
            
             document.getElementById('supplierName').value = '<?php echo htmlspecialchars($suppData['supplier_name']); ?>'
             document.getElementById('supplierId').value = '<?php echo htmlspecialchars($suppData['id']); ?>'
             document.getElementById('supplierInformationTable').style.display='none';
            //  document.getElementById('grnNumberSearchButton').click();
             
             "
           >
             <td> <?php echo " "; ?>  </td>
             <td> <?php echo " "; ?>  </td>
             <td><input type="text" class="supplierInputField" value="<?php echo $suppData['id']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField supplierNameField" id="supplierNameField_<?php echo $i;?>" value="<?php echo $suppData['supplier_name']; ?>"></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $suppData['address1']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $suppData['address2']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $suppData['address3']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $suppData['locality']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $suppData['city']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $suppData['pincode']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $suppData['state']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $suppData['landline']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $suppData['mobile']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $suppData['email']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $suppData['gst_no']; ?>" readonly></td>
           </tr>

         <?php $i++; }
          
         ?>    
      </tbody>
    </table>
  </div>
          </form>

            
            

          
    
    <!-- Supplier Information End -->


    
<?php }elseif($resultSearchPurchaseSummary){?>
    
    

    <style>
#purchaseSummaryTable{
    color: white;
}
</style>

<?php if($fieldName == "grn_number"){?>

    <style>
      #GRN_INV_DC{
        
      }
    </style>
<?php }elseif($fieldName == "invoice_number"){?>
  <style>
      #GRN_INV_DC{
        margin-left: 200px;
      }
    </style>
<?php }elseif($fieldName == "dc_number"){?>
  <style>
      #GRN_INV_DC{
        margin-left: 400px;
      }
    </style>
<?php }?>


    <form method="post" id="GRN_INV_DC"  style="position:absolute;top:260px;left:435px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
  <div style="max-height: 250px; overflow-y: auto; width: 155px;">
    <table id="purchaseSummaryTable" class="table" style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px;">
      <thead>
        <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
          <th style="width:20px;"><button class="btn-close" type="button"
          onclick="document.getElementById('purchaseSummaryTable').style.display = 'none';"
          style="background-color:#FF3CAC;"></button>
        </th>
        <th style="width: 100px;" ><?php echo $caption; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; while($purchaseSummaryData = $resultSearchPurchaseSummary->fetch_assoc()){
                
                
        ?>    
        <tr onclick="
            document.getElementById('supplierId').value = '<?php echo htmlspecialchars($purchaseSummaryData['supplier_id']); ?>'
            document.getElementById('<?php echo $jsVariable; ?>').value = '<?php echo htmlspecialchars($purchaseSummaryData[$fieldName]); ?>'
            document.getElementById('purchaseSummaryTable').style.display = 'none';
            // document.getElementById('grnSearchButton').click();
        ">
        
            <td><?php echo ""; ?></td>
            <td><?php echo $purchaseSummaryData[$fieldName]; ?></td>
        </tr>
        <?php }?>
    </tbody>
</table>



<?php }?>



<script>

<?php



?>






// document.addEventListener("DOMContentLoaded", function () {
//     setTimeout(() => {  // Ensure elements are loaded
//         document.querySelectorAll('.supplierNameField').forEach(function (input) {
//             input.addEventListener('keydown', function (event) {
//                 if (event.key === "Enter") {
//                     event.preventDefault();
//                     alert("hello"); // Alert should now work
//                 }
//             });
//         });
//     }, 500); // Delay to ensure elements are available
// });


  


</script>
</body>


</html>