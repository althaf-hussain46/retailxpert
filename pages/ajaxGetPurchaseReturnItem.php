<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");

$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$userBranchState = $_SESSION['branch_state'];
$field2 =  "";

if(isset($_POST['get_item_f4'])){
    $searchItem = $_POST['get_item_f4'];
    $querySearchPurchaseReturnItem  = "select i.*,sb.*
                              from items as i
                              join stock_balance as sb on i.id = sb.item_id
                              where (
                              i.product_name like '%$searchItem%'
                              or i.brand_name like '%$searchItem%'
                              or i.design_name like '%$searchItem%'
                              or i.batch_name like '%$searchItem%'
                              or i.color_name like '%$searchItem%'
                              or i.size_name like '%$searchItem%'
                              or i.id like '%$searchItem%'
                              or i.mrp like '%$searchItem%'
                              or i.tax_code like '%$searchItem%'
                              ) and sb.item_qty >=1
                              and i.branch_id = '$userBranchId' order by i.product_name
                            ";
    $resultSearchPurchaseReturnItem = $con->query($querySearchPurchaseReturnItem);
    


}elseif(isset($_POST['pr_get_item_f4'])){
  $searchItem = $_POST['pr_get_item_f4'];
  $querySearchPurchaseReturnItem  = "select i.*,sb.*
                            from items as i
                            join stock_balance as sb on i.id = sb.item_id
                            where (
                            i.product_name like '%$searchItem%'
                            or i.brand_name like '%$searchItem%'
                            or i.design_name like '%$searchItem%'
                            or i.batch_name like '%$searchItem%'
                            or i.color_name like '%$searchItem%'
                            or i.size_name like '%$searchItem%'
                            or i.id like '%$searchItem%'
                            or i.mrp like '%$searchItem%'
                            or i.tax_code like '%$searchItem%'
                            ) and sb.item_qty >=1
                            and i.branch_id = '$userBranchId' order by i.product_name
                          ";
  $resultSearchPurchaseReturnItem = $con->query($querySearchPurchaseReturnItem);
  


}
?>

<?php if($resultSearchPurchaseReturnItem){?>
<style>
#itemInformationTable{
color:white;
background-color: #FF3CAC;
background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}
</style>
  <form style="width:880px;position:absolute;top:510px;left:274px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
  <div style="max-height: 200px; overflow-y: auto; width: 880px;">
    <table id="itemInformationTable" class="table" style="font-size:11px;width: 100%; table-layout: fixed; border-collapse: collapse;">
      <thead>
        <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
          <th><button class="btn-close" type="button"
          onclick="
            document.getElementById('itemInformationTable').style.display = 'none';
            
          "
          style="background-color:#FF3CAC;"></button></th>
                  <th style="width:0px;"></th>
                  <th style="width:60px;">Item ID</th>
                  <th style="width:620px">Item Details</th>
                  <th style="width:100px;text-align:right;">Selling Price</th>
                  <th style="width:50px;text-align:right;">Qty</th>
                  
              </tr>
            </thead>
            <tbody>
              <?php $i =1; while($itemData = $resultSearchPurchaseReturnItem->fetch_assoc()){?>
              <tr
                
                onclick="
                  
                  
                  let purchaseReturn = localStorage.getItem('purchase_return');
                  
                  if(purchaseReturn == '1'){
                  let i =localStorage.getItem('row_index');
                      let itemDescription  = '<?php echo $itemData['product_name'].'/'.$itemData['brand_name'].'/'.
                     $itemData['color_name'].'/'.$itemData['batch_name'].'/'.$itemData['tax_code'].'/'.
                     $itemData['size_name'].'/'.$itemData['mrp'];?>'
                     
                  document.getElementById('design_'+i).value ='<?php echo htmlspecialchars($itemData['design_name']); ?>';
                  document.getElementById('description_'+i).value = itemDescription;
                  document.getElementById('hsnCode_'+i).value ='<?php echo htmlspecialchars($itemData['hsn_code']); ?>';
                  document.getElementById('tax_'+i).value ='<?php echo htmlspecialchars($itemData['tax_code']); ?>';
                  document.getElementById('sellingPrice_'+i).value ='<?php echo htmlspecialchars($itemData['selling_price']); ?>';
                  document.getElementById('id_'+i).value ='<?php echo htmlspecialchars($itemData['id']); ?>';
                  document.getElementById('salesMan_'+i).focus();
                  document.getElementById('salesMan_'+i).value = 1;
                  document.getElementById('salesMan_'+i).select();
                  document.getElementById('itemInformationTable').style.display = 'none';   
              }else{
              let i =localStorage.getItem('row_index');
              
                  let itemDescription  = '<?php echo $itemData['product_name'].'/'.$itemData['brand_name'].'/'.
                     $itemData['color_name'].'/'.$itemData['batch_name'].'/'.$itemData['tax_code'].'/'.
                     $itemData['size_name'].'/'.$itemData['mrp'];?>'
                     
                  document.getElementById('design_'+i).value ='<?php echo htmlspecialchars($itemData['design_name']); ?>';
                  document.getElementById('description_'+i).value = itemDescription;
                  document.getElementById('hsnCode_'+i).value ='<?php echo htmlspecialchars($itemData['hsn_code']); ?>';
                  document.getElementById('tax_'+i).value ='<?php echo htmlspecialchars($itemData['tax_code']); ?>';
                  document.getElementById('sellingPrice_'+i).value ='<?php echo htmlspecialchars($itemData['selling_price']); ?>';
                  document.getElementById('id_'+i).value ='<?php echo htmlspecialchars($itemData['id']); ?>';
                  // document.getElementById('salesMan_'+i).focus();
                  document.getElementById('qty_'+i).focus();
                  // document.getElementById('salesMan_'+i).value = '1';
                  // document.getElementById('qty_'+i).select();
                  document.getElementById('salesMan_'+i).select();
                  document.getElementById('itemInformationTable').style.display = 'none';
                  
              }    
                                                              
                "
              
              >
                <td><?php echo " "; ?></td>
                <td><?php echo " "; ?></td>
                <td><?php echo $itemData['id']; ?></td>
                <td><?php echo $itemData['product_name']."/".$itemData['brand_name']."/".
                     $itemData['design_name']."/".$itemData['color_name']."/".
                     $itemData['batch_name']."/".$itemData['tax_code']."/".
                     $itemData['size_name']."/".$itemData['mrp']; ?></td>
                <td style="text-align:right;"><?php echo $itemData['selling_price']; ?></td>
                <td style="text-align:right;"><?php echo $itemData['item_qty']; ?></td>
              </tr>
              <?php }?>
            </tbody>
        </table>
    </form>
    
    
<?php };?>
