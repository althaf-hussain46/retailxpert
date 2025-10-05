<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");






$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$field2 =  "";



?>

<?php 

  if(isset($_POST['lb_customer_name'])){
  
    $customerName = $_POST['lb_customer_name'];
    
    $querySearchCustInfo = "select*from customers where customer_name like '%$customerName%'
                            && branch_id = '$userBranchId' order by customer_name";
    $resultSearchCustInfo = $con->query($querySearchCustInfo);
    
      // while($custData = $resultSearchCustInfo->fetch_assoc()){
        
          
      // }
    
    
  }


  if(isset($_POST['lb_sales_number'])){
    $salesDetails =   json_decode($_POST['lb_sales_number']);
    
    
    $caption = "sales";
    $jsVariable = "salesNumber";
    $fieldName = 'sales_number';
    $querySearchSalesSummary = "select * from sales_summary where sales_number like '%$salesDetails[0]%'
                                   and customer_id like '%$salesDetails[1]%'  and branch_id='$userBranchId'
                                   and  (date(sales_date) between '$salesDetails[2]' and '$salesDetails[3]' )
                                   order by sales_number DESC";
    $resultSearchSalesAndSalesReturnSummary = $con->query($querySearchSalesSummary);
    
}elseif(isset($_POST['lb_sales_return_number'])){
    $salesReturnDetails = json_decode($_POST['lb_sales_return_number']);
    
    $caption = "Sales Return Number";
    $jsVariable = "salesReturnNumber";
    $fieldName = 'sr_number';
    $querySearchSalesReturnSummary = "select  * from sales_return_summary where sr_number like '%$salesReturnDetails[0]%'
                                   and customer_id like '%$salesReturnDetails[1]%' and branch_id='$userBranchId'
                                   and (date(sr_date) between '$salesReturnDetails[2]' and '$salesReturnDetails[3]' )
                                   order by sr_number DESC";
    $resultSearchSalesAndSalesReturnSummary = $con->query($querySearchSalesReturnSummary);
    
}







if(isset($resultSearchCustInfo)){
  
  
  
  
?>
<style>


#customerInformationTable{
color:white;
background-color: #FF3CAC;
background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}

.customerInputField{
  color: white;
  background:none;
  border:none;

}

.customerNameField{
  color: white;
  background:none;
  border:none;
  outline: none;
}

.customerInputField:focus{

  background-color:#FF3CAC;
  outline:none;
}


</style>
<!-- customer Information Start -->



<form style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
  <div style="max-height: 300px; overflow-y: auto; width: 700px;">
    <table id="customerInformationTable" class="table" style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px;">
      <thead>
        <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
          <th><button class="btn-close" type="button"
          onclick="
            document.getElementById('customerInformationTable').style.display = 'none';
          "
          style="background-color:#FF3CAC;"></button></th>
          <th style="width: 25px;"  > </th>
          <th style="width: 60px;"  >Id</th>
          <th style="width: 150px;" >Customer Name</th>
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
      <?php $i = 1; while ($custData = $resultSearchCustInfo->fetch_assoc()) { ?>
           <tr style="font-size: 12px;"
            
             onclick="
             
             
                     
 
           
             
            
             document.getElementById('customerName').value = '<?php echo htmlspecialchars($custData['customer_name']); ?>'
             document.getElementById('customerId').value = '<?php echo htmlspecialchars($custData['id']); ?>'
             document.getElementById('customerInformationTable').style.display='none';
            //  document.getElementById('salesNumberSearchButton').click();
             
             "
           >
             <td> <?php echo " "; ?>  </td>
             <td> <?php echo " "; ?>  </td>
             <td><input type="text" class="customerInputField" value="<?php echo $custData['id']; ?>" readonly></td>
             <td><input type="text" class="customerInputField customerNameField" id="customerNameField_<?php echo $i;?>" value="<?php echo $custData['customer_name']; ?>"></td>
             <td><input type="text" class="customerInputField" value="<?php echo $custData['address1']; ?>" readonly></td>
             <td><input type="text" class="customerInputField" value="<?php echo $custData['address2']; ?>" readonly></td>
             <td><input type="text" class="customerInputField" value="<?php echo $custData['address3']; ?>" readonly></td>
             <td><input type="text" class="customerInputField" value="<?php echo $custData['locality']; ?>" readonly></td>
             <td><input type="text" class="customerInputField" value="<?php echo $custData['city']; ?>" readonly></td>
             <td><input type="text" class="customerInputField" value="<?php echo $custData['pincode']; ?>" readonly></td>
             <td><input type="text" class="customerInputField" value="<?php echo $custData['state']; ?>" readonly></td>
             <td><input type="text" class="customerInputField" value="<?php echo $custData['landline']; ?>" readonly></td>
             <td><input type="text" class="customerInputField" value="<?php echo $custData['mobile']; ?>" readonly></td>
             <td><input type="text" class="customerInputField" value="<?php echo $custData['email']; ?>" readonly></td>
             <td><input type="text" class="customerInputField" value="<?php echo $custData['gst_no']; ?>" readonly></td>
           </tr>

         <?php $i++; }
          
         ?>    
      </tbody>
    </table>
  </div>
          </form>

            
            

          
    
    <!-- Customer Information End -->


    
<?php }elseif($resultSearchSalesAndSalesReturnSummary){?>
    
    

    <style>
#salesSummaryTable{
    color: white;
}
</style>

<?php if($fieldName == "sales_number"){?>

    <style>
      #sales_salesReturn{
        
      }
    </style>
<?php }elseif($fieldName == "sr_number"){?>
  <style>
      #sales_salesReturn{
        margin-left: 200px;
      }
    </style>
<?php }?>


    <form method="post" id="sales_salesReturn"  style="position:absolute;top:260px;left:435px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
  <div style="max-height: 250px; overflow-y: auto; width: 155px;">
    <table id="salesSummaryTable" class="table" style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px;">
      <thead>
        <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
          <th style="width:20px;"><button class="btn-close" type="button"
          onclick="document.getElementById('salesSummaryTable').style.display = 'none';"
          style="background-color:#FF3CAC;"></button>
        </th>
        <th style="width: 100px;" ><?php echo $caption; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; while($salesAndSalesReturnSummaryData = $resultSearchSalesAndSalesReturnSummary->fetch_assoc()){
                
                
        ?>    
        <tr onclick="
            document.getElementById('customerId').value = '<?php echo htmlspecialchars($salesAndSalesReturnSummaryData['customer_id']); ?>'
            document.getElementById('<?php echo $jsVariable; ?>').value = '<?php echo htmlspecialchars($salesAndSalesReturnSummaryData[$fieldName]); ?>'
            document.getElementById('salesSummaryTable').style.display = 'none';
            // document.getElementById('salesSearchButton').click();
        ">
        
            <td><?php echo ""; ?></td>
            <td><?php echo $salesAndSalesReturnSummaryData[$fieldName]; ?></td>
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
//         document.querySelectorAll('.customerNameField').forEach(function (input) {
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