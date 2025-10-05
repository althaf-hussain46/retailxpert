<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");

$userBranchId = $_SESSION['user_branch_id'];


if(isset($_POST['lb_pr_number'])){
    $prNumber = $_POST['lb_pr_number'];
    
    $querySearchPurchaseReturnSummary = "
    SELECT prs.*, s.*
    FROM purchase_return_summary prs
    JOIN suppliers s ON prs.supplier_id = s.id
    WHERE prs.pr_grn_number LIKE '%$prNumber%' and prs.branch_id = '$userBranchId'
    ORDER BY prs.pr_grn_number DESC
    ";

    $resultSearchPurchaseReturnSummary = $con->query($querySearchPurchaseReturnSummary);
    
}

?>
<?php if($resultSearchPurchaseReturnSummary){ ?>
<style>
#purchaseReturnSummaryTable{
    color: white;
}
</style>

    <form method="post"  style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
  <div style="max-height: 300px; overflow-y: auto; width: 750px;">
    <table id="purchaseReturnSummaryTable" class="table" style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px;">
      <thead>
        <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
          <th><button class="btn-close" type="button"
          onclick="
            document.getElementById('purchaseReturnSummaryTable').style.display = 'none';
          "
          style="background-color:#FF3CAC;"></button></th>
          
            <th style="width: 35px;" > </th>
            <th style="width: 40px;" >S.No.</th>
            <th style="width: 110px;" >PRN Number</th>
            <th style="width: 110px;">PRN Date</th>
            <th style="width: 80px;">Counter</th>
            <th style="width: 120px;">Supplier Name</th>
            <th style="width: 20px;text-align:right;">Qty</th>
            <th style="width: 100px;text-align:right;">Net Amount</th>
            <th style="width: 100px;text-align:right;">Total Amount</th>
            <th style="width: 100px;text-align:right;">CGST Amount</th>
            <th style="width: 100px;text-align:right;">SGST Amount</th>
            <th style="width: 100px;text-align:right;">IGST Amount</th>
            <th style="width: 120px;text-align:right;">Add On Amt</th>
            <th style="width: 130px;text-align:right;">Deduction Amt</th>
            <th style="width: 130px;text-align:right;">Net Amount</th>
            <th style="width: 80px;text-align:right;">User ID</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; while($purchaseReturnSummaryData = $resultSearchPurchaseReturnSummary->fetch_assoc()){
                
                
        ?>    
        <tr onclick="
            
            
            
            
            document.getElementById('reprintPurchaseReturnNumber').value = '<?php echo htmlspecialchars($purchaseReturnSummaryData['pr_grn_number']); ?>'
            
            
            document.getElementById('purchaseReturnSummaryTable').style.display = 'none';
            document.getElementById('reprintButton').focus();
            

            
    
    //   document.getElementById('grnSearchButton').click();
    
    
    
    
    


    
        ">
            <td><?php echo "";?></td>
            <td><?php echo "";?></td>
            <td><?php echo $i++;?></td>
            <td><?php echo $purchaseReturnSummaryData['pr_grn_number']; ?></td>
            <td><?php echo date("d-m-Y",strtotime($purchaseReturnSummaryData['pr_grn_date'])); ?></td>
            <td><?php echo $purchaseReturnSummaryData['counter_name']; ?></td>
            <td><?php echo $purchaseReturnSummaryData['supplier_name']; ?></td>
            <td><?php echo $purchaseReturnSummaryData['pr_total_qty']; ?></td>
            <td style="text-align:right"><?php echo $purchaseReturnSummaryData['pr_net_amount']; ?></td>
            <td style="text-align:right"><?php echo $purchaseReturnSummaryData['pr_total_amount']; ?></td>
            <td style="text-align:right"><?php echo $purchaseReturnSummaryData['pr_cgst_amount']; ?></td>
            <td style="text-align:right"><?php echo $purchaseReturnSummaryData['pr_sgst_amount']; ?></td>
            <td style="text-align:right"><?php echo $purchaseReturnSummaryData['pr_igst_amount']; ?></td>
            <td style="text-align:right"><?php echo $purchaseReturnSummaryData['pr_addon']; ?></td>
            <td style="text-align:right"><?php echo $purchaseReturnSummaryData['pr_deduction']; ?></td>
            <td style="text-align:right;"><?php echo $purchaseReturnSummaryData['user_id']; ?></td>
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