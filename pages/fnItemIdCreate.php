<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");
$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];

if(isset($_POST['lb_trigger_item_creation'])){

        $items = json_decode($_POST['lb_trigger_item_creation'],true);
         
        if($items[0]!='' && $items[1]!='' && $items[2]!='' && $items[3]!='' && $items[4]!='' && $items[5]!=''
        && $items[6]!='' && $items[7]!='' && $items[8]!='' && $items[9]!='' && $items[10]!='' && $items[11]!=''){
            
            itemCreation($items[0],$items[1],$items[2],$items[3],$items[4],$items[5],$items[6],$items[7],
               $items[8],$items[9],$items[10],$items[11],$userId,$userBranchId,$con);    
        }
}



function itemCreation($productName, $brandName, $designName, $colorName,$batchName,$categoryName,
$hsnCode,$taxCode,$sizeName,$mrpPrice,$sellingPrice,$rate,$userId,$BranchId, $con){

    
    
    $description = $productName."/".$brandName."/".$designName."/".$colorName."/".$batchName."/".$mrpPrice."/".$sizeName;
    
    
    $querySearchItem = "select*from items where product_name = '$productName' && brand_name = '$brandName'
        && design_name = '$designName' && color_name = '$colorName' && batch_name = '$batchName'
        && category_name = '$categoryName' && hsn_code = '$hsnCode' && tax_code  = '$taxCode'
        && size_name = '$sizeName' && mrp = '$mrpPrice' && selling_price = '$sellingPrice' && rate = '$rate' && branch_id = '$BranchId' ";
    $resultSearchItem = $con->query($querySearchItem);
    
    if($resultSearchItem->num_rows==0){
    
        $queryInsertItem = "insert into items (product_name, brand_name, design_name,color_name,batch_name,
        category_name,hsn_code,tax_code,size_name,mrp,selling_price,rate,description,user_id,branch_id) values('$productName','$brandName',
        '$designName', '$colorName','$batchName', '$categoryName', '$hsnCode', '$taxCode','$sizeName',
        '$mrpPrice', '$sellingPrice', '$rate', '$description', '$userId', '$BranchId')";
        $resultInsertItem = $con->query($queryInsertItem);
        if($resultInsertItem){
        
            $querySearchItemId = "select*from items where product_name = '$productName' && brand_name = '$brandName'
            && design_name = '$designName' && color_name = '$colorName' && batch_name = '$batchName'
            && category_name = '$categoryName' && hsn_code = '$hsnCode' && tax_code  = '$taxCode'
            && size_name = '$sizeName' && mrp = '$mrpPrice' && selling_price = '$sellingPrice' && rate = '$rate' && branch_id = '$BranchId'";
            $resultSearchItemId = $con->query($querySearchItemId)->fetch_assoc();
            echo $resultSearchItemId['id'];
            // $_SESSION['item_id']  = $resultSearchItemId['id'];
            
            
        }
    }else{
        
        $querySearchItemId = "select*from items where product_name = '$productName' && brand_name = '$brandName'
        && design_name = '$designName' && color_name = '$colorName' && batch_name = '$batchName'
        && category_name = '$categoryName' && hsn_code = '$hsnCode' && tax_code  = '$taxCode'
        && size_name = '$sizeName' && mrp = '$mrpPrice' && selling_price = '$sellingPrice' && rate = '$rate' && branch_id = '$BranchId' ";
        $resultSearchItemId = $con->query($querySearchItemId)->fetch_assoc();
        echo $resultSearchItemId['id'];
        // $_SESSION['item_id']  = $resultSearchItemId['id'];
    
    }
    
    

}



?>


