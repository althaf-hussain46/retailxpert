<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");

$userBranchId = $_SESSION['user_branch_id'];


if(isset($_POST['aj_purchase_return_details'])){
    $purchaseReturnDetails = json_decode($_POST['aj_purchase_return_details']);
    $_SESSION['prNumber'] = $purchaseReturnDetails[0];
    $_SESSION['supplierId'] = $purchaseReturnDetails[1];
    $querySearchPurchaseReturnItem  = "SELECT 
                                pri.*, 
                                i.*
                                FROM purchase_return_item as pri
                                INNER JOIN items as i ON i.id = pri.pr_item_id
                                WHERE pri.pr_grn_number = '$purchaseReturnDetails[0]' 
                                AND pri.branch_id = '$userBranchId'";
    $resultSearchPurchaseReturnItem = $con->query($querySearchPurchaseReturnItem);
    
}


?>

<?php if(isset($resultSearchPurchaseReturnItem) && $resultSearchPurchaseReturnItem!=""){?>
<div style="margin-left: 265px; font-size: 11px;position:absolute;top:510px" >
    <div style="width: 1240px; height: 180px; overflow-y: auto;overflow-x:auto" id="itemTable">
        <table class="table text-white" style="border-collapse: collapse; width: 100%; text-align:left;font-size:11px">
            <thead>
                <tr style="position: sticky; z-index: 1; top: 0; background-color: #FF3CAC;">
                    <th style="width: 40px;">S.No.</th>
                    <th style="width: 120px; text-align: left;">Product</th>
                    <th style="width: 130px;">Brand</th>
                    <th style="width: 150px;">Design</th>
                    <th style="width: 120px;">Color</th>
                    <th style="width: 10px;">Batch</th>
                    <th style="width: 10px;">Category</th>
                    <th style="width: 20px;">HSN</th>
                    <th style="width: 20px;">Tax</th>
                    <th style="width: 20px;">Size</th>
                    <th style="width: 20px;">MRP</th>
                    <th style="width: 20px;">Selling</th>
                    <th style="width: 20px;">Rate</th>
                    <th style="width: 20px;">Qty</th>
                    <th style="width: 20px;">Amount</th>
                    <th style="width: 20px;">Id</th>
                </tr>
            </thead>
            <tbody id="table_body" class="items">
                <?php 
                
                    $sno = 1;
                    while($purchaseSumData = $resultSearchPurchaseReturnItem->fetch_assoc()) { 
                        
                    ?>
                        
                        <tr>
                            <td><?php echo $sno++; ?></td>
                            <td style="text-align: left;"><?php echo htmlspecialchars($purchaseSumData['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['brand_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['design_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['color_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['batch_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['hsn_code']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['tax_code']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['size_name']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['mrp']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['selling_price']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['rate']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['pr_item_qty']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['pr_item_amount']); ?></td>
                            <td><?php echo htmlspecialchars($purchaseSumData['pr_item_id']); ?></td>
                        </tr>
                <?php 
                     
                    }?>
            </tbody>
        </table>
    </div>
</div>

<?php }

?>

