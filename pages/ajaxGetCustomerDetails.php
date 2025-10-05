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
<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");


$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];


if(isset($_POST['lb_customer_name'])){
  
    $customerName = $_POST['lb_customer_name'];
    
    $querySearchCustInfo = "select*from customers where customer_name like '%$customerName%' && branch_id = '$userBranchId' order by customer_name";
    $resultSearchCustInfo = $con->query($querySearchCustInfo);
    
      // while($cusData = $resultSearchSuppInfo->fetch_assoc()){
        
          
      // }
    
    
  }elseif(isset($_POST['lb_customer_mobile'])){
  
    $customerMobile = $_POST['lb_customer_mobile'];
    
    $querySearchCustInfo = "select*from customers where mobile like '%$customerMobile%' && branch_id = '$userBranchId' order by customer_name";
    $resultSearchCustMobileInfo = $con->query($querySearchCustInfo);
  }
  
?>
<?php
    if(isset($resultSearchCustInfo)){
  
  
  
  
  ?>
  
  <!-- customer Information Start -->
  
  
  
  <form style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
    <div style="max-height: 230px; overflow-y: auto; width: 720px;">
      <table id="customerInformationTable" class="table" style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px">
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
            <th style="width: 180px;" >GST No.</th>
          </tr>
        </thead>
        <tbody>
        <?php $i = 1; while ($cusData = $resultSearchCustInfo->fetch_assoc()) { ?>
             <tr style="font-size: 12px;"
              
               onclick="
               
               
                       let customerState = '<?php echo htmlspecialchars($cusData['state']); ?>';
                      // localStorage.setItem('customer_state',customerState);
             
          // Send customer name to PHP using AJAX
          // fetch('customerSession.php', {
          //     method: 'POST',
          //     headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          //     body: 'customerState=' + encodeURIComponent(customerState)
          // }).then(response => response.text())
          // .then(data => console.log(data)); // Debugging output
  
                let companyState = '<?php echo $_SESSION['company_state']; ?>';
                // let customerState1 = localStorage.getItem('customer_state');
  
  
   var cgstAmount = document.getElementById('cgstAmount');
   var sgstAmount = document.getElementById('sgstAmount');
   var igstAmount = document.getElementById('igstAmount');
   if (cgstAmount && sgstAmount && igstAmount) {
       if (customerState === companyState) {
          //  cgstAmount.setAttribute('readonly','false');
          //  sgstAmount.setAttribute('readonly','false');
          
          //  igstAmount.setAttribute('readonly','true');
          localStorage.setItem('customer_state','1');
           cgstAmount.disabled = false;
           sgstAmount.disabled = false;
           igstAmount.disabled = true;
           igstAmount.value = 0;
           cgstAmount.style.background = 'none';
           sgstAmount.style.background = 'none';
           igstAmount.style.background = 'gainsboro';
       } else {
       localStorage.setItem('customer_state','0');
           cgstAmount.disabled = true;
           sgstAmount.disabled = true;
           igstAmount.disabled = false;
            // cgstAmount.setAttribute('readonly','true');
            // sgstAmount.setAttribute('readonly','true');
            // igstAmount.removeAttribute('readonly','true');
            
           cgstAmount.value = 0;
           sgstAmount.value = 0;
           cgstAmount.style.background = 'gainsboro';
           sgstAmount.style.background = 'gainsboro';
           igstAmount.style.background = 'none';
       }
   } else {
       console.error('Error: One or more elements not found in the DOM.');
   }
   
             
               
              
               document.getElementById('customerName').value = '<?php echo htmlspecialchars($cusData['customer_name']); ?>'
               document.getElementById('customerId').value = '<?php echo htmlspecialchars($cusData['id']); ?>'
               document.getElementById('customerMobile').value = '<?php echo htmlspecialchars($cusData['mobile']) ?>'
               document.getElementById('duplicateCustomerMobile').value = '<?php echo htmlspecialchars($cusData['mobile']) ?>'
               document.getElementById('customerInformationTable').style.display='none';
              //  document.getElementById('customerMobile').focus();
               
               
               "
             >
               <td> <?php echo " "; ?>  </td>
               <td> <?php echo " "; ?>  </td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['id']; ?>" readonly></td>
               <td><input type="text" class="customerInputField customerNameField" id="customerNameField_<?php echo $i;?>" value="<?php echo $cusData['customer_name']; ?>"></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['address1']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['address2']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['address3']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['locality']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['city']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['pincode']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['state']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['landline']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['mobile']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['email']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['gst_no']; ?>" readonly></td>
             </tr>
  
           <?php $i++; }
    
           ?>    
        </tbody>
      </table>
    </div>
            </form>
  <?php  }elseif($resultSearchCustMobileInfo){?>
  
  
  
  
              
              <form style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
    <div style="max-height: 300px; overflow-y: auto; width: 720px;">
      <table id="customerInformationTable" class="table" style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:10px;">
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
            <th style="width: 180px;" >GST No.</th>
          </tr>
        </thead>
        <tbody>
        <?php $i = 1; while ($cusData = $resultSearchCustMobileInfo->fetch_assoc()) { ?>
             <tr style="font-size: 12px;"
              
               onclick="
               
               
                       let customerState = '<?php echo htmlspecialchars($cusData['state']); ?>';
                      // localStorage.setItem('customer_state',customerState);
             
          // Send customer name to PHP using AJAX
          // fetch('customerSession.php', {
          //     method: 'POST',
          //     headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          //     body: 'customerState=' + encodeURIComponent(customerState)
          // }).then(response => response.text())
          // .then(data => console.log(data)); // Debugging output
  
                let companyState = '<?php echo $_SESSION['company_state']; ?>';
                // let customerState1 = localStorage.getItem('customer_state');
  
  
   var cgstAmount = document.getElementById('cgstAmount');
   var sgstAmount = document.getElementById('sgstAmount');
   var igstAmount = document.getElementById('igstAmount');
   if (cgstAmount && sgstAmount && igstAmount) {
       if (customerState === companyState) {
          //  cgstAmount.setAttribute('readonly','false');
          //  sgstAmount.setAttribute('readonly','false');
            localStorage.setItem('customer_state','1');
            
          //  igstAmount.setAttribute('readonly','true');
           cgstAmount.disabled = false;
           sgstAmount.disabled = false;
           igstAmount.disabled = true;
           igstAmount.value = 0;
           cgstAmount.style.background = 'none';
           sgstAmount.style.background = 'none';
           igstAmount.style.background = 'gainsboro';
       } else {
           cgstAmount.disabled = true;
           sgstAmount.disabled = true;
           igstAmount.disabled = false;
            // cgstAmount.setAttribute('readonly','true');
            // sgstAmount.setAttribute('readonly','true');
            // igstAmount.removeAttribute('readonly','true');
            
           cgstAmount.value = 0;
           sgstAmount.value = 0;
           cgstAmount.style.background = 'gainsboro';
           sgstAmount.style.background = 'gainsboro';
           igstAmount.style.background = 'none';
       }
   } else {
       console.error('Error: One or more elements not found in the DOM.');
   }
   
             
               
              
               document.getElementById('customerName').value = '<?php echo htmlspecialchars($cusData['customer_name']); ?>'
               document.getElementById('customerId').value = '<?php echo htmlspecialchars($cusData['id']); ?>'
               document.getElementById('customerMobile').value = '<?php echo htmlspecialchars($cusData['mobile']) ?>'
               document.getElementById('duplicateCustomerMobile').value = '<?php echo htmlspecialchars($cusData['mobile']) ?>'
               document.getElementById('customerInformationTable').style.display='none';
               document.getElementById('customerMobile').focus();
               
               
               "
             >
               <td> <?php echo " "; ?>  </td>
               <td> <?php echo " "; ?>  </td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['id']; ?>" readonly></td>
               <td><input type="text" class="customerInputField customerNameField" id="customerNameField_<?php echo $i;?>" value="<?php echo $cusData['customer_name']; ?>"></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['address1']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['address2']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['address3']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['locality']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['city']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['pincode']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['state']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['landline']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['mobile']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['email']; ?>" readonly></td>
               <td><input type="text" class="customerInputField" value="<?php echo $cusData['gst_no']; ?>" readonly></td>
             </tr>
  
           <?php $i++; }
    
           ?>    
        </tbody>
      </table>
    </div>
            </form>
  <?php  }
            
      
    //   <!-- Customer Information End -->
  
  
