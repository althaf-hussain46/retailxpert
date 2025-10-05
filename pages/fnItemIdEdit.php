<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");
$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];

if(isset($_POST['lb_trigger_item_updation'])){

        $items = json_decode($_POST['lb_trigger_item_updation'],true);
         
                
        itemUpdation($items[0],$items[1],$items[2],$items[3],$items[4],$items[5],$items[6],$items[7],
               $items[8],$items[9],$items[10],$items[11],$items[12],$userId,$userBranchId,$con,$items);
        
        
        
        
        
}


function itemUpdation($productName, $brandName, $designName,$colorName, $batchName,$categoryName,
$hsnCode,$taxCode,$sizeName,$mrpPrice,$sellingPrice,$rate,$itemId,$userId,$BranchId, $con,$items){
    
    
    if($items[0]!='' && $items[1]!='' && $items[2]!='' && $items[3]!='' && $items[4]!='' && $items[5]!=''
        && $items[6]!='' && $items[7]!='' && $items[8]!='' && $items[9]!='' && $items[10]!='' && $items[11]!=''){
            
            
            if($items[12] > 0){
                $queryCheckItemId = "select*from items where id= '$items[12]'";
                $resultCheckItemId = $con->query($queryCheckItemId);
                
                if($resultCheckItemId->num_rows == 0){
                
                
                }else{
                    $queryupdateItem = "update items set product_name = '$productName', brand_name = '$brandName',
                    design_name = '$designName', batch_name = '$batchName', color_name = '$colorName',
                    category_name = '$categoryName', hsn_code = '$hsnCode', tax_code = '$taxCode',
                    size_name = '$sizeName', mrp = '$mrpPrice', selling_price = '$sellingPrice',
                    rate = '$rate', user_id = '$userId' where id = '$itemId' and 
                    branch_id = '$BranchId'";
                    $resultUpdateItem = $con->query($queryupdateItem);
                    
                    if($resultUpdateItem){
                        
                        $querySearchItem = "select*from items where id = '$itemId' and branch_id = '$BranchId'";
                        $resultSearchItem = $con->query($querySearchItem)->fetch_assoc();
                        echo $resultSearchItem['id'];
                    }
                }
            
                
                
            }else{
                itemCreation($items[0],$items[1],$items[2],$items[3],$items[4],$items[5],$items[6],$items[7],
               $items[8],$items[9],$items[10],$items[11],$userId,$BranchId,$con);
            }    
            
        
        
        }
    
        
    
    
}


function itemCreation($productName, $brandName, $designName, $batchName,$colorName,$categoryName,
$hsnCode,$taxCode,$sizeName,$mrpPrice,$sellingPrice,$rate,$userId,$BranchId, $con){

    // echo $productName;
    // echo "<br>";
    // echo $brandName;
    // echo "<br>";
    // echo $designName;
    // echo "<br>";
    // echo $batchName;
    // echo "<br>";
    // echo $colorName;
    // echo "<br>";
    // echo $categoryName;
    // echo "<br>";
    // echo $hsnCode;
    // echo '<br>';
    // echo $taxCode;
    // echo "<br>";
    // echo $sizeName;
    // echo "<br>";
    // echo $mrpPrice;
    // echo "<br>";
    // echo $sellingPrice;
    // echo "<br>";
    // echo $userId;
    // echo "<br>";
    // echo $BranchId;
    
    $description = $productName."/".$brandName."/".$designName."/".$colorName."/".$batchName."/".$mrpPrice."/".$sizeName;
    
    
    $querySearchItem = "select*from items where product_name = '$productName' && brand_name = '$brandName'
        && design_name = '$designName' && batch_name = '$batchName' && color_name = '$colorName'
        && category_name = '$categoryName' && hsn_code = '$hsnCode' && tax_code  = '$taxCode'
        && size_name = '$sizeName' && mrp = '$mrpPrice' && selling_price = '$sellingPrice' && rate = '$rate' && branch_id = '$BranchId' ";
    $resultSearchItem = $con->query($querySearchItem);
    
    if($resultSearchItem->num_rows==0){
    
        $queryInsertItem = "insert into items (product_name, brand_name, design_name,batch_name,color_name,
        category_name,hsn_code,tax_code,size_name,mrp,selling_price,rate,description,user_id,branch_id) values('$productName','$brandName',
        '$designName','$batchName', '$colorName', '$categoryName', '$hsnCode', '$taxCode','$sizeName',
        '$mrpPrice', '$sellingPrice', '$rate', '$description', '$userId', '$BranchId')";
        $resultInsertItem = $con->query($queryInsertItem);
        if($resultInsertItem){
        
            $querySearchItemId = "select*from items where product_name = '$productName' && brand_name = '$brandName'
            && design_name = '$designName' && batch_name = '$batchName' && color_name = '$colorName'
            && category_name = '$categoryName' && hsn_code = '$hsnCode' && tax_code  = '$taxCode'
            && size_name = '$sizeName' && mrp = '$mrpPrice' && selling_price = '$sellingPrice' && rate = '$rate' && branch_id = '$BranchId'";
            $resultSearchItemId = $con->query($querySearchItemId)->fetch_assoc();
            echo $resultSearchItemId['id'];
            // $_SESSION['item_id']  = $resultSearchItemId['id'];
            
            
        }
    }else{
        
        $querySearchItemId = "select*from items where product_name = '$productName' && brand_name = '$brandName'
        && design_name = '$designName' && batch_name = '$batchName' && color_name = '$colorName'
        && category_name = '$categoryName' && hsn_code = '$hsnCode' && tax_code  = '$taxCode'
        && size_name = '$sizeName' && mrp = '$mrpPrice' && selling_price = '$sellingPrice' && rate = '$rate' && branch_id = '$BranchId' ";
        $resultSearchItemId = $con->query($querySearchItemId)->fetch_assoc();
        echo $resultSearchItemId['id'];
        // $_SESSION['item_id']  = $resultSearchItemId['id'];
    
    }
    
    

}



?>


