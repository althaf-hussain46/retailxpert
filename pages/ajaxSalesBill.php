<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");

$userBranchId = $_SESSION['user_branch_id'];



if(isset($_POST['lb_bill_number'])){
  $billNumber = $_POST['lb_bill_number'];
  $querySearchSalesSummary = "select ss.*, cs.*
                              from sales_summary as ss
                              join customers as cs on ss.customer_id = cs.id
                              where ss.sales_number like '%$billNumber%' and ss.branch_id = '$userBranchId'
                              order by ss.sales_number desc";
  $resultSearchSalesSummary = $con->query($querySearchSalesSummary);
}

?>

<?php if($resultSearchSalesSummary){ ?>
<style>
#SalesSummaryTable{
    color: white;
}
</style>

    <form method="post" action="purchaseEdit.php" style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
  <div style="max-height: 300px; overflow-y: auto; width: 750px;">
    <table id="salesSummaryTable" class="table" style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px;">
      <thead>
        <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
          <th><button class="btn-close" type="button"
          onclick="
            document.getElementById('salesSummaryTable').style.display = 'none';
          "
          style="background-color:#FF3CAC;"></button></th>
          
            <th style="width: 35px;" > </th>
            <th style="width: 40px;" >S.No.</th>
            <th style="width: 110px;" >Sales Number</th>
            <th style="width: 110px;">Sales Date</th>
            <th style="width: 250px;">Customer Name</th>
            <th style="width: 120px;text-align:right;">Sales Amount</th>
            <th style="width: 80px;text-align:right;">Total Qty</th>
            <th style="width: 100px;text-align:right;">Actual Amount</th>
            <th style="width: 100px;text-align:right;">CGST Amount</th>
            <th style="width: 100px;text-align:right;">SGST Amount</th>
            <th style="width: 100px;text-align:right;">IGST Amount</th>
            <th style="width: 120px;text-align:right;">Add On Amount</th>
            <th style="width: 130px;text-align:right;">Deduction Amount</th>
            <th style="width: 120px;text-align:right;">Net Amount</th>
            <th style="width: 80px;text-align:right;">User ID</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; while($salesSummaryData = $resultSearchSalesSummary->fetch_assoc()){
                
                
        ?>    
        <tr onclick="
            
            let supplierState = '<?php echo htmlspecialchars($salesSummaryData['state']); ?>';
            let companyState = '<?php echo $_SESSION['company_state']; ?>';            
            
            document.getElementById('customerId').value = '<?php echo htmlspecialchars($salesSummaryData['customer_id']); ?>'
            document.getElementById('customerName').value = '<?php echo htmlspecialchars($salesSummaryData['customer_name']); ?>'
            document.getElementById('customerMobile').value = '<?php echo htmlspecialchars($salesSummaryData['mobile']); ?>'
            document.getElementById('billNumber').value = '<?php echo htmlspecialchars($salesSummaryData['sales_number']); ?>'
            document.getElementById('billDate').value = '<?php echo htmlspecialchars(date('Y-m-d',strtotime($salesSummaryData['sales_date']))); ?>'
            document.getElementById('totalQty').value = '<?php echo htmlspecialchars($salesSummaryData['s_qty']); ?>'
            document.getElementById('totalAmount').value = '<?php echo htmlspecialchars($salesSummaryData['s_amount']); ?>'
            document.getElementById('cgstAmount').value = '<?php echo htmlspecialchars($salesSummaryData['s_cgst_amount']); ?>'
            document.getElementById('sgstAmount').value = '<?php echo htmlspecialchars($salesSummaryData['s_sgst_amount']); ?>'
            document.getElementById('igstAmount').value = '<?php echo htmlspecialchars($salesSummaryData['s_igst_amount']); ?>'
            document.getElementById('addOnAmount').value = '<?php echo htmlspecialchars($salesSummaryData['s_addon']); ?>'
            document.getElementById('deductionAmount').value = '<?php echo htmlspecialchars($salesSummaryData['s_deduction']); ?>'                        
            document.getElementById('netAmount').value = '<?php echo htmlspecialchars($salesSummaryData['s_net_amount']); ?>'
            
            
            document.getElementById('salesSummaryTable').style.display = 'none';
            document.getElementById('billNumberSearchButton').click();
            
            
    
    
        ">
            <td><?php echo "";?></td>
            <td><?php echo "";?></td>
            <td><?php echo $i++;?></td>
            <td><?php echo $salesSummaryData['sales_number']; ?></td>
            <td><?php echo date("d-m-Y",strtotime($salesSummaryData['sales_date'])); ?></td>
            <td><?php echo $salesSummaryData['customer_name']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_amount']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_qty']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_actual_amount']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_cgst_amount']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_sgst_amount']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_igst_amount']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_addon']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_deduction']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_net_amount']; ?></td>
            <td style="text-align:right;"><?php echo $salesSummaryData['user_id']; ?></td>
        </tr>
        <?php }?>
    </tbody>
</table>



<?php }?>


<?php 
// if(isset($_POST['add']))
// {
//     $_SESSION['grn_number'] = $_POST['grn_number'];
    
// }

?>