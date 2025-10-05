<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");






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
    
      // while($SuppData = $resultSearchSuppInfo->fetch_assoc()){
        
          
      // }
    
    
  }


  if(isset($_POST['lb_purchase_return_number'])){
    $purchaseReturnDetails =   json_decode($_POST['lb_purchase_return_number']);
    
    
    $caption = "Purchase Return Number";
    $jsVariable = "purchaseReturnNumber";
    $fieldName = 'pr_grn_number';
    $querySearchPurchaseReturn = "select * from purchase_return_summary where   pr_grn_number like '%$purchaseReturnDetails[0]%'
                                   and supplier_id like '%$purchaseReturnDetails[1]%'  and branch_id='$userBranchId'
                                   and  (date(pr_grn_date) between '$purchaseReturnDetails[2]' and '$purchaseReturnDetails[3]' )
                                   order by pr_grn_number DESC";
    $resultSearchPurchaseReturnSummary = $con->query($querySearchPurchaseReturn);
    
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
<!-- supplier Information Start -->



<form style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
  <div style="max-height: 300px; overflow-y: auto; width: 700px;">
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
          <th style="width: 180px;" >Address1</th>
          <th style="width: 180px;" >Address2</th>
          <th style="width: 180px;" >Address3</th>
          <th style="width: 100px;" >Locality</th>
          <th style="width: 100px;" >City</th>
          <th style="width: 80px;"  >PinCode</th>
          <th style="width: 100px;" >State</th>
          <th style="width: 100px;" >Landline</th>
          <th style="width: 100px;" >Mobile</th>
          <th style="width: 150px;" >Email</th>
          <th style="width: 180px;" >GST No.</th>
        </tr>
      </thead>
      <tbody>
      <?php $i = 1; while ($SuppData = $resultSearchSuppInfo->fetch_assoc()) { ?>
           <tr style="font-size: 12px;"
            
             onclick="
             
             
                     
 
           
             
            
             document.getElementById('supplierName').value = '<?php echo htmlspecialchars($SuppData['supplier_name']); ?>'
             document.getElementById('supplierId').value = '<?php echo htmlspecialchars($SuppData['id']); ?>'
             document.getElementById('supplierInformationTable').style.display='none';
            //  document.getElementById('salesNumberSearchButton').click();
             
             "
           >
             <td> <?php echo " "; ?>  </td>
             <td> <?php echo " "; ?>  </td>
             <td><input type="text" class="supplierInputField" value="<?php echo $SuppData['id']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField supplierNameField" id="supplierNameField_<?php echo $i;?>" value="<?php echo $SuppData['supplier_name']; ?>"></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $SuppData['address1']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $SuppData['address2']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $SuppData['address3']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $SuppData['locality']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $SuppData['city']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $SuppData['pincode']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $SuppData['state']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $SuppData['landline']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $SuppData['mobile']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $SuppData['email']; ?>" readonly></td>
             <td><input type="text" class="supplierInputField" value="<?php echo $SuppData['gst_no']; ?>" readonly></td>
           </tr>

         <?php $i++; }
          
         ?>    
      </tbody>
    </table>
  </div>
          </form>

            
            

          
    
    <!-- supplier Information End -->


    
<?php }elseif($resultSearchPurchaseReturnSummary){?>
    
    

    <style>
#purchaseReturnTable{
    color: white;
}
</style>


<?php if($fieldName == "pr_grn_number"){?>
  <style>
      #purchaseReturn{
        margin-left: 80px;
        
      }
    </style>
<?php }?>


    <form method="post" id="purchaseReturn"  style="position:absolute;top:225px;left:435px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
  <div style="max-height: 250px; overflow-y: auto; width: 205px;">
    <table id="purchaseReturnTable" class="table" style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px;">
      <thead>
        <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
          <th style="width:20px;"><button class="btn-close" type="button"
          onclick="document.getElementById('purchaseReturnTable').style.display = 'none';"
          style="background-color:#FF3CAC;"></button>
        </th>
        <th style="width: 130px;" ><?php echo $caption; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; while($PurchaseReturnSummaryData = $resultSearchPurchaseReturnSummary->fetch_assoc()){
                
                
        ?>    
        <tr onclick="
            document.getElementById('supplierId').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['supplier_id']); ?>'
            document.getElementById('<?php echo $jsVariable; ?>').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData[$fieldName]); ?>'
            document.getElementById('purchaseReturnTable').style.display = 'none';
            // document.getElementById('salesSearchButton').click();
        ">
        
            <td><?php echo ""; ?></td>
            <td style=""><?php echo $PurchaseReturnSummaryData[$fieldName]; ?></td>
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