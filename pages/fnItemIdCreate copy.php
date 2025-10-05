<?php
include_once("../config/config.php");
include_once(DIR_URL."db/dbConnection.php");
$userId = $_SESSION['user_id'];
$userLocationId = $_SESSION['user_location_id'];

if(isset($_POST['lb_trigger_item_creation'])){

        $items = json_decode($_POST['lb_trigger_item_creation'],true);
         
        
        
        
        if($items[0]!='' && $items[1]!='' && $items[2]!='' && $items[3]!='' && $items[4]!='' && $items[5]!=''
        && $items[6]!='' && $items[7]!='' && $items[8]!='' && $items[9]!='' && $items[10]!='' && $items[11]!=''){
            
            
            if($items[12] > 0){
                $queryCheckItemId = "select*from items where id= '$items[12]'";
                $resultCheckItemId = $con->query($queryCheckItemId);
                
                if($resultCheckItemId->num_rows == 0){
                
                
                }else{
                    itemUpdation($items[0],$items[1],$items[2],$items[3],$items[4],$items[5],$items[6],$items[7],
                $items[8],$items[9],$items[10],$items[11],$items[12],$userId,$userLocationId,$con); 
                }
            
                
                
            }else{
                itemCreation($items[0],$items[1],$items[2],$items[3],$items[4],$items[5],$items[6],$items[7],
               $items[8],$items[9],$items[10],$items[11],$userId,$userLocationId,$con);
            }    
            
        
        
        }
        
        
}


function itemUpdation($productName, $brandName, $designName, $batchName,$colorName,$categoryName,
$hsnCode,$taxCode,$sizeName,$mrpPrice,$sellingPrice,$rate,$itemId,$userId,$locationId, $con){
    
    
    $querySearchItemMatch = "select*from items  where product_name =  ";
    
    
    $queryupdateItem = "update items set product_name = '$productName', brand_name = '$brandName',
                        design_name = '$designName', batch_name = '$batchName', color_name = '$colorName',
                        category_name = '$categoryName', hsn_code = '$hsnCode', tax_code = '$taxCode',
                        size_name = '$sizeName', mrp = '$mrpPrice', selling_price = '$sellingPrice',
                        rate = '$rate', user_id = '$userId' where id = '$itemId' and 
                        location_id = '$locationId'";
    $resultUpdateItem = $con->query($queryupdateItem);
    
    if($resultUpdateItem){
        
        $querySearchItem = "select*from items where id = '$itemId' and location_id = '$locationId'";
        $resultSearchItem = $con->query($querySearchItem)->fetch_assoc();
        echo $resultSearchItem['id'];
    }
    
}


function itemCreation($productName, $brandName, $designName, $batchName,$colorName,$categoryName,
$hsnCode,$taxCode,$sizeName,$mrpPrice,$sellingPrice,$rate,$userId,$locationId, $con){

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
    // echo $locationId;
    
    $description = $productName."/".$brandName."/".$designName."/".$batchName."/".$colorName."/".$mrpPrice."/".$sizeName;
    
    
    $querySearchItem = "select*from items where product_name = '$productName' && brand_name = '$brandName'
        && design_name = '$designName' && batch_name = '$batchName' && color_name = '$colorName'
        && category_name = '$categoryName' && hsn_code = '$hsnCode' && tax_code  = '$taxCode'
        && size_name = '$sizeName' && mrp = '$mrpPrice' && selling_price = '$sellingPrice' && rate = '$rate' && location_id = '$locationId' ";
    $resultSearchItem = $con->query($querySearchItem);
    
    if($resultSearchItem->num_rows==0){
    
        $queryInsertItem = "insert into items (product_name, brand_name, design_name,batch_name,color_name,
        category_name,hsn_code,tax_code,size_name,mrp,selling_price,rate,description,user_id,location_id) values('$productName','$brandName',
        '$designName','$batchName', '$colorName', '$categoryName', '$hsnCode', '$taxCode','$sizeName',
        '$mrpPrice', '$sellingPrice', '$rate', '$description', '$userId', '$locationId')";
        $resultInsertItem = $con->query($queryInsertItem);
        if($resultInsertItem){
        
            $querySearchItemId = "select*from items where product_name = '$productName' && brand_name = '$brandName'
            && design_name = '$designName' && batch_name = '$batchName' && color_name = '$colorName'
            && category_name = '$categoryName' && hsn_code = '$hsnCode' && tax_code  = '$taxCode'
            && size_name = '$sizeName' && mrp = '$mrpPrice' && selling_price = '$sellingPrice' && rate = '$rate' && location_id = '$locationId'";
            $resultSearchItemId = $con->query($querySearchItemId)->fetch_assoc();
            echo $resultSearchItemId['id'];
            // $_SESSION['item_id']  = $resultSearchItemId['id'];
            
            
        }
    }else{
        
        $querySearchItemId = "select*from items where product_name = '$productName' && brand_name = '$brandName'
        && design_name = '$designName' && batch_name = '$batchName' && color_name = '$colorName'
        && category_name = '$categoryName' && hsn_code = '$hsnCode' && tax_code  = '$taxCode'
        && size_name = '$sizeName' && mrp = '$mrpPrice' && selling_price = '$sellingPrice' && rate = '$rate' && location_id = '$locationId' ";
        $resultSearchItemId = $con->query($querySearchItemId)->fetch_assoc();
        echo $resultSearchItemId['id'];
        // $_SESSION['item_id']  = $resultSearchItemId['id'];
    
    }
    
    

}



?>


