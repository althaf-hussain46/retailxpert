<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");

$userBranchId = $_SESSION['user_branch_id'];


if(isset($_POST['lb_sales_number'])){
    $salesNumber = $_POST['lb_sales_number'];
    
    $querySearchSalesSummary = "
    SELECT ss.*, c.*
    FROM sales_summary ss
    JOIN customers c ON ss.customer_id = c.id
    WHERE ss.sales_number LIKE '%$salesNumber%' and ss.branch_id = '$userBranchId'
    ORDER BY ss.sales_number DESC
    ";

    $resultSearchSalesSummary = $con->query($querySearchSalesSummary);
    
}

?>
<?php if($resultSearchSalesSummary){ ?>
<style>
#salesSummaryTable{
    color: white;
}
</style>

    <form method="post"  style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
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
            <th style="width: 110px;" >Bill Number</th>
            <th style="width: 110px;">Bill Date</th>
            <th style="width: 80px;">Counter</th>
            <th style="width: 120px;">Customer Name</th>
            <th style="width: 20px;text-align:right;">Qty</th>
            <th style="width: 100px;text-align:right;">Bill Amount</th>
            <th style="width: 110px;text-align:right;">Bill Return Amt</th>
            <th style="width: 100px;text-align:right;">Amount</th>
            <th style="width: 120px;text-align:right;">Taxable Amt</th>
            <th style="width: 120px;text-align:right;" >Tax Amount</th>
            <th style="width: 100px;text-align:right;">CGST Amount</th>
            <th style="width: 100px;text-align:right;">SGST Amount</th>
            <th style="width: 100px;text-align:right;">IGST Amount</th>
            <th style="width: 120px;text-align:right;">Add On Amt</th>
            <th style="width: 130px;text-align:right;">Discount Amt</th>
            <th style="width: 80px;text-align:right;">User ID</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; while($salesSummaryData = $resultSearchSalesSummary->fetch_assoc()){
                
                
        ?>    
        <tr onclick="
            
            
            
            
            document.getElementById('salesNumber').value = '<?php echo htmlspecialchars($salesSummaryData['sales_number']); ?>'
            document.getElementById('customerName').value = '<?php echo htmlspecialchars($salesSummaryData['customer_name']) ?>';
            document.getElementById('customerMobile').value = '<?php echo htmlspecialchars($salesSummaryData['mobile']) ?>';
            document.getElementById('salesNumber').value = '<?php echo htmlspecialchars($salesSummaryData['sales_number'])?>';
            document.getElementById('salesDate').value = '<?php echo htmlspecialchars(date('Y-m-d',strtotime($salesSummaryData['sales_date'])))?>';
            document.getElementById('counterName').value = '<?php echo htmlspecialchars($salesSummaryData['counter_name'])?>';
            
            document.getElementById('totalQty').value = '<?php echo htmlspecialchars($salesSummaryData['s_qty']);?>'
            document.getElementById('totalAmount').value = '<?php echo htmlspecialchars($salesSummaryData['s_amount']);?>'
            document.getElementById('deductionAmount').value = '<?php echo htmlspecialchars($salesSummaryData['s_deduction']);?>'
            document.getElementById('addOnAmount').value = '<?php echo htmlspecialchars($salesSummaryData['s_addon']);?>'
            
            let afterDiscount = 0;
            let totalAmount = document.getElementById('totalAmount').value||0;
            let deduction = document.getElementById('deductionAmount').value||0;
            let addOn = document.getElementById('addOnAmount').value||0;
            let afterAddOn = document.getElementById('afterAddOn');
            afterDiscount = parseFloat(totalAmount)-parseFloat(deduction);
            afterAddOn.value = parseFloat(afterDiscount)+parseFloat(addOn);
            
            
            
            
            
            
            document.getElementById('salesReturnNetAmount').value = '<?php echo htmlspecialchars($salesSummaryData['sales_return_amount']);?>'
            document.getElementById('netAmount').value = '<?php echo htmlspecialchars($salesSummaryData['s_net_amount']);?>'

            
            
            document.getElementById('salesSummaryTable').style.display = 'none';
            
            document.getElementById('salesNumber').setAttribute('readonly',true);
            document.getElementById('grnSearchButton').click();
    
    //   document.getElementById('grnSearchButton').click();
    
    
    
    
    


    
        ">
            <td><?php echo "";?></td>
            <td><?php echo "";?></td>
            <td><?php echo $i++;?></td>
            <td><?php echo $salesSummaryData['sales_number']; ?></td>
            <td><?php echo date("d-m-Y",strtotime($salesSummaryData['sales_date'])); ?></td>
            <td><?php echo $salesSummaryData['counter_name']; ?></td>
            <td><?php echo $salesSummaryData['customer_name']; ?></td>
            <td><?php echo $salesSummaryData['s_qty']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_net_amount']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['sales_return_amount'];?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_amount']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_taxable_amount']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_tax_amount']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_cgst_amount']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_sgst_amount']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_igst_amount']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_addon']; ?></td>
            <td style="text-align:right"><?php echo $salesSummaryData['s_deduction']; ?></td>
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