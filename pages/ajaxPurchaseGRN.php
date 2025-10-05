<?php
include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");

$userBranchId = $_SESSION['user_branch_id'];


if (isset($_POST['lb_grn_number'])) {
  $grnNumber = $_POST['lb_grn_number'];

  $querySearchPurchaseSummary = "
    SELECT ps.*, 
           s.supplier_name, 
           s.state,
           s.branch_id 
    FROM purchase_summary ps
    LEFT JOIN suppliers s ON ps.supplier_id = s.id
    WHERE ps.grn_number LIKE '%$grnNumber%' and ps.branch_id = '$userBranchId'
    ORDER BY ps.grn_number DESC
    ";

  $resultSearchPurchaseSummary = $con->query($querySearchPurchaseSummary);
}
if (isset($_POST['lb_bill_number'])) {
  $billNumber = $_POST['lb_bill_number'];
  $querySearchSalesSummary = "select ss.*, cs.customer_name, cs.state, cs.branch_id
                              from sales_summary as ss
                              join customers as cs on ss.customer_id = cs.id
                              where ss.sales_number like '%$billNumber%' and ss.branch_id = '$userBranchId'
                              order by ss.sales_number desc";
  $resultSearchSalesSummary = $con->query($querySearchSalesSummary);
}

?>
<?php if ($resultSearchPurchaseSummary) { ?>
<style>
#purchaseSummaryTable {
    color: white;
}
</style>

<form method="post" action="purchaseEdit.php"
    style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
    <div style="max-height: 300px; overflow-y: auto; width: 750px;">
        <table id="purchaseSummaryTable" class="table"
            style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px;">
            <thead>
                <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
                    <th><button class="btn-close" type="button" onclick="
            document.getElementById('purchaseSummaryTable').style.display = 'none';
          " style="background-color:#FF3CAC;"></button></th>

                    <th style="width: 35px;"> </th>
                    <th style="width: 40px;">S.No.</th>
                    <th style="width: 110px;">GRN Number</th>
                    <th style="width: 110px;">GRN Date</th>
                    <th style="width: 250px;">Supplier Name</th>
                    <th style="width: 120px;text-align:right;">GRN Amount</th>
                    <th style="width: 150px;">DC Number</th>
                    <th style="width: 100px;">DC Date</th>
                    <th style="width: 180px;">Invoice Number</th>
                    <th style="width: 120px;">Invoice Date</th>
                    <th style="width: 80px;text-align:right;">Total Qty</th>
                    <th style="width: 100px;text-align:right;">Total Amount</th>
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
                <?php $i = 1;
          while ($purchaseSummaryData = $resultSearchPurchaseSummary->fetch_assoc()) {


          ?>
                <tr onclick="
            
            let supplierState = '<?php echo htmlspecialchars($purchaseSummaryData['state']); ?>';
            let companyState = '<?php echo $_SESSION['company_state']; ?>';            
            
            document.getElementById('supplierId').value = '<?php echo htmlspecialchars($purchaseSummaryData['supplier_id']); ?>'
            document.getElementById('supplierName').value = '<?php echo htmlspecialchars($purchaseSummaryData['supplier_name']); ?>'
            
            document.getElementById('grnAmount').value = '<?php echo htmlspecialchars($purchaseSummaryData['grn_amount']); ?>'
            document.getElementById('grnNumber').value = '<?php echo htmlspecialchars($purchaseSummaryData['grn_number']); ?>'
            
            document.getElementById('grnDate').value = '<?php echo htmlspecialchars(date('Y-m-d', strtotime($purchaseSummaryData['grn_date']))); ?>'
            
            document.getElementById('dcNumber').value = '<?php echo htmlspecialchars($purchaseSummaryData['dc_number']); ?>'
            document.getElementById('dcDate').value = '<?php echo htmlspecialchars($purchaseSummaryData['dc_date']); ?>'
            document.getElementById('invoiceNumber').value = '<?php echo htmlspecialchars($purchaseSummaryData['invoice_number']); ?>'
            document.getElementById('invoiceDate').value = '<?php echo htmlspecialchars($purchaseSummaryData['invoice_date']); ?>'
            document.getElementById('totalQty').value = '<?php echo htmlspecialchars($purchaseSummaryData['total_qty']); ?>'
            document.getElementById('totalAmount').value = '<?php echo htmlspecialchars($purchaseSummaryData['total_amount']); ?>'
            document.getElementById('cgstAmount').value = '<?php echo htmlspecialchars($purchaseSummaryData['cgst_amount']); ?>'
            document.getElementById('sgstAmount').value = '<?php echo htmlspecialchars($purchaseSummaryData['sgst_amount']); ?>'
            document.getElementById('igstAmount').value = '<?php echo htmlspecialchars($purchaseSummaryData['igst_amount']); ?>'
            document.getElementById('addOnAmount').value = '<?php echo htmlspecialchars($purchaseSummaryData['addon']); ?>'
            document.getElementById('deductionAmount').value = '<?php echo htmlspecialchars($purchaseSummaryData['deduction']); ?>'                        
            document.getElementById('netAmount').value = '<?php echo htmlspecialchars($purchaseSummaryData['net_amount']); ?>'
            
            
            document.getElementById('purchaseSummaryTable').style.display = 'none';
            document.getElementById('grnSearchButton').click();
    
    
        ">
                    <td><?php echo ""; ?></td>
                    <td><?php echo ""; ?></td>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $purchaseSummaryData['grn_number']; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($purchaseSummaryData['grn_date'])); ?></td>
                    <td><?php echo $purchaseSummaryData['supplier_name']; ?></td>
                    <td style="text-align:right"><?php echo $purchaseSummaryData['grn_amount']; ?></td>
                    <td><?php echo $purchaseSummaryData['dc_number']; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($purchaseSummaryData['dc_date'])); ?></td>
                    <td><?php echo $purchaseSummaryData['invoice_number']; ?></td>
                    <td><?php echo date("d-m-Y", strtotime($purchaseSummaryData['invoice_date'])); ?></td>
                    <td style="text-align:right"><?php echo $purchaseSummaryData['total_qty']; ?></td>
                    <td style="text-align:right"><?php echo $purchaseSummaryData['total_amount']; ?></td>
                    <td style="text-align:right"><?php echo $purchaseSummaryData['cgst_amount']; ?></td>
                    <td style="text-align:right"><?php echo $purchaseSummaryData['sgst_amount']; ?></td>
                    <td style="text-align:right"><?php echo $purchaseSummaryData['igst_amount']; ?></td>
                    <td style="text-align:right"><?php echo $purchaseSummaryData['addon']; ?></td>
                    <td style="text-align:right"><?php echo $purchaseSummaryData['deduction']; ?></td>
                    <td style="text-align:right"><?php echo $purchaseSummaryData['net_amount']; ?></td>
                    <td style="text-align:right;"><?php echo $purchaseSummaryData['user_id']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>



        <?php } ?>

        <?php if (isset($resultSearchSalesSummary)) { ?>
        <style>
        #purchaseSummaryTable {
            color: white;
        }
        </style>

        <form method="post" action="purchaseEdit.php"
            style="position:absolute;top:170px;left:400px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
            <div style="max-height: 300px; overflow-y: auto; width: 750px;">
                <table id="purchaseSummaryTable" class="table"
                    style="width: 100%; table-layout: fixed; border-collapse: collapse;font-size:11px;">
                    <thead>
                        <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
                            <th><button class="btn-close" type="button" onclick="
            document.getElementById('purchaseSummaryTable').style.display = 'none';
          " style="background-color:#FF3CAC;"></button></th>

                            <th style="width: 35px;"> </th>
                            <th style="width: 40px;">S.No.</th>
                            <th style="width: 110px;">GRN Number</th>
                            <th style="width: 110px;">GRN Date</th>
                            <th style="width: 250px;">Supplier Name</th>
                            <th style="width: 120px;text-align:right;">GRN Amount</th>
                            <th style="width: 150px;">DC Number</th>
                            <th style="width: 100px;">DC Date</th>
                            <th style="width: 180px;">Invoice Number</th>
                            <th style="width: 120px;">Invoice Date</th>
                            <th style="width: 80px;text-align:right;">Total Qty</th>
                            <th style="width: 100px;text-align:right;">Total Amount</th>
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
                        <?php $i = 1;
              while ($salesSummaryData = $resultSearchSalesSummary->fetch_assoc()) {


              ?>
                        <tr onclick="
            
            let supplierState = '<?php echo htmlspecialchars($salesSummaryData['state']); ?>';
            let companyState = '<?php echo $_SESSION['company_state']; ?>';            
            
            document.getElementById('supplierId').value = '<?php echo htmlspecialchars($salesSummaryData['customer_id']); ?>'
            document.getElementById('supplierName').value = '<?php echo htmlspecialchars($salesSummaryData['customer_name']); ?>'
            
            document.getElementById('grnAmount').value = '<?php echo htmlspecialchars($salesSummaryData['grn_amount']); ?>'
            document.getElementById('grnNumber').value = '<?php echo htmlspecialchars($salesSummaryData['grn_number']); ?>'
            
            document.getElementById('grnDate').value = '<?php echo htmlspecialchars(date('Y-m-d', strtotime($salesSummaryData['grn_date']))); ?>'
            
            document.getElementById('dcNumber').value = '<?php echo htmlspecialchars($salesSummaryData['dc_number']); ?>'
            document.getElementById('dcDate').value = '<?php echo htmlspecialchars($salesSummaryData['dc_date']); ?>'
            document.getElementById('invoiceNumber').value = '<?php echo htmlspecialchars($salesSummaryData['invoice_number']); ?>'
            document.getElementById('invoiceDate').value = '<?php echo htmlspecialchars($salesSummaryData['invoice_date']); ?>'
            document.getElementById('totalQty').value = '<?php echo htmlspecialchars($salesSummaryData['total_qty']); ?>'
            document.getElementById('totalAmount').value = '<?php echo htmlspecialchars($salesSummaryData['total_amount']); ?>'
            document.getElementById('cgstAmount').value = '<?php echo htmlspecialchars($salesSummaryData['cgst_amount']); ?>'
            document.getElementById('sgstAmount').value = '<?php echo htmlspecialchars($salesSummaryData['sgst_amount']); ?>'
            document.getElementById('igstAmount').value = '<?php echo htmlspecialchars($salesSummaryData['igst_amount']); ?>'
            document.getElementById('addOnAmount').value = '<?php echo htmlspecialchars($salesSummaryData['addon']); ?>'
            document.getElementById('deductionAmount').value = '<?php echo htmlspecialchars($salesSummaryData['deduction']); ?>'                        
            document.getElementById('netAmount').value = '<?php echo htmlspecialchars($salesSummaryData['net_amount']); ?>'
            
            
            document.getElementById('purchaseSummaryTable').style.display = 'none';
            document.getElementById('grnSearchButton').click();
    
    
        ">
                            <td><?php echo ""; ?></td>
                            <td><?php echo ""; ?></td>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo $salesSummaryData['grn_number']; ?></td>
                            <td><?php echo date("d-m-Y", strtotime($salesSummaryData['grn_date'])); ?></td>
                            <td><?php echo $salesSummaryData['supplier_name']; ?></td>
                            <td style="text-align:right"><?php echo $salesSummaryData['grn_amount']; ?></td>
                            <td><?php echo $salesSummaryData['dc_number']; ?></td>
                            <td><?php echo date("d-m-Y", strtotime($salesSummaryData['dc_date'])); ?></td>
                            <td><?php echo $salesSummaryData['invoice_number']; ?></td>
                            <td><?php echo date("d-m-Y", strtotime($salesSummaryData['invoice_date'])); ?></td>
                            <td style="text-align:right"><?php echo $salesSummaryData['total_qty']; ?></td>
                            <td style="text-align:right"><?php echo $salesSummaryData['total_amount']; ?></td>
                            <td style="text-align:right"><?php echo $salesSummaryData['cgst_amount']; ?></td>
                            <td style="text-align:right"><?php echo $salesSummaryData['sgst_amount']; ?></td>
                            <td style="text-align:right"><?php echo $salesSummaryData['igst_amount']; ?></td>
                            <td style="text-align:right"><?php echo $salesSummaryData['addon']; ?></td>
                            <td style="text-align:right"><?php echo $salesSummaryData['deduction']; ?></td>
                            <td style="text-align:right"><?php echo $salesSummaryData['net_amount']; ?></td>
                            <td style="text-align:right;"><?php echo $salesSummaryData['user_id']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>



                <?php } ?>


                <?php
        // if(isset($_POST['add']))
        // {
        //     $_SESSION['grn_number'] = $_POST['grn_number'];

        // }

        ?>