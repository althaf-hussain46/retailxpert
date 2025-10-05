<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");

$userBranchId = $_SESSION['user_branch_id'];



if(isset($_POST['lb_bill_number'])){
  $billNumber = $_POST['lb_bill_number'];
  $querySearchPurchaseReturnSummary = "select prs.*, s.*
                              from purchase_return_summary as prs
                              join suppliers as s on prs.supplier_id = s.id
                              where prs.pr_grn_number like '%$billNumber%' and s.branch_id = '$userBranchId'
                              order by prs.pr_grn_number desc";
  $resultSearchPurchaseReturnSummary = $con->query($querySearchPurchaseReturnSummary);
}

?>

<?php if($resultSearchPurchaseReturnSummary){ ?>
<style>
#PurchaseReturnSummaryTable{
    color: white;
}


</style>

    <form method="post" action="purchaseEdit.php" style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
  <div style="max-height: 300px; overflow-y: auto; width: 750px;">
    <table id="PurchaseReturnSummaryTable" class="table" style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px;">
      <thead>
        <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
          <th><button class="btn-close" type="button"
          onclick="
            document.getElementById('PurchaseReturnSummaryTable').style.display = 'none';
          "
          style="background-color:#FF3CAC;"></button></th>
          
            <th style="width: 35px;" > </th>
            <th style="width: 40px;" >S.No.</th>
            <th style="width: 110px;" >PR Number</th>
            <th style="width: 110px;">PR Date</th>
            <th style="width: 250px;">Supplier Name</th>
            <th style="width: 120px;text-align:right;">PR Amount</th>
            <th style="width: 80px;text-align:right;">Total Qty</th>
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
        <?php $i=1; while($PurchaseReturnSummaryData = $resultSearchPurchaseReturnSummary->fetch_assoc()){
                
                
        ?>    
        <tr onclick="
            
            let supplierState = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['state']); ?>';
            let companyState = '<?php echo $_SESSION['company_state']; ?>';            
            
            document.getElementById('supplierId').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['supplier_id']); ?>'
            document.getElementById('supplierName').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['supplier_name']); ?>'
            document.getElementById('billNumber').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['pr_grn_number']); ?>'
            document.getElementById('billDate').value = '<?php echo htmlspecialchars(date('Y-m-d',strtotime($PurchaseReturnSummaryData['pr_grn_date']))); ?>'
            document.getElementById('totalQty').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['pr_total_qty']); ?>'
            document.getElementById('totalAmount').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['pr_total_amount']); ?>'
            document.getElementById('cgstAmount').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['pr_cgst_amount']); ?>'
            document.getElementById('sgstAmount').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['pr_sgst_amount']); ?>'
            document.getElementById('igstAmount').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['pr_igst_amount']); ?>'
            document.getElementById('addOnAmount').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['pr_addon']); ?>'
            document.getElementById('deductionAmount').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['pr_deduction']); ?>'                        
            document.getElementById('netAmount').value = '<?php echo htmlspecialchars($PurchaseReturnSummaryData['pr_net_amount']); ?>'
            
            
            document.getElementById('PurchaseReturnSummaryTable').style.display = 'none';
            document.getElementById('billNumberSearchButton').click();
            
            
    
    
        ">
            <td><?php echo "";?></td>
            <td><?php echo "";?></td>
            <td><?php echo $i++;?></td>
            <td><?php echo $PurchaseReturnSummaryData['pr_grn_number']; ?></td>
            <td><?php echo date("d-m-Y",strtotime($PurchaseReturnSummaryData['pr_grn_date'])); ?></td>
            <td><?php echo $PurchaseReturnSummaryData['supplier_name']; ?></td>
            <td style="text-align:right"><?php echo $PurchaseReturnSummaryData['pr_total_amount']; ?></td>
            <td style="text-align:right"><?php echo $PurchaseReturnSummaryData['pr_total_qty']; ?></td>
            <td style="text-align:right"><?php echo $PurchaseReturnSummaryData['pr_cgst_amount']; ?></td>
            <td style="text-align:right"><?php echo $PurchaseReturnSummaryData['pr_sgst_amount']; ?></td>
            <td style="text-align:right"><?php echo $PurchaseReturnSummaryData['pr_igst_amount']; ?></td>
            <td style="text-align:right"><?php echo $PurchaseReturnSummaryData['pr_addon']; ?></td>
            <td style="text-align:right"><?php echo $PurchaseReturnSummaryData['pr_deduction']; ?></td>
            <td style="text-align:right"><?php echo $PurchaseReturnSummaryData['pr_net_amount']; ?></td>
            <td style="text-align:right;"><?php echo $PurchaseReturnSummaryData['user_id']; ?></td>
            
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