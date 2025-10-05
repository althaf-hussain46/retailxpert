<style>
#itemUpdateBtn {
    display: none;
}
</style>
<?php
ob_start();
include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");
include_once(DIR_URL . "/includes/header.php");
include_once(DIR_URL . "/includes/navbar.php");
include_once(DIR_URL . "/includes/sidebar.php");
?>

<?php
if ($_SESSION['user_role'] != "Super Admin") {
    if ($_SESSION['item_form_create'] == 0) {
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let submitBtn = document.getElementById('createItem');
    if (submitBtn) {
        submitBtn.setAttribute('disabled', true);
    }

});
</script>

<?php } ?>
<?php

    if ($_SESSION['item_form_reprint'] == 0) {
    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {

    let itemSearchBtn = document.getElementById("itemSearchBtn");
    if (itemSearchBtn) {
        itemSearchBtn.setAttribute('disabled', true)
    }

    let itemSearch = document.getElementById("itemSearch");
    if (itemSearch) {
        itemSearch.setAttribute('disabled', true)
    }
    let fileType = document.getElementById("fileType");
    if (fileType) {
        fileType.setAttribute('disabled', true)
    }

    let exportButton = document.getElementById("exportBtn");
    if (exportButton) {
        exportButton.setAttribute('disabled', true)
    }
})
</script>


<?php } ?>
<?php

    if ($_SESSION['item_form_update'] == 0) {
    ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".editBtn").forEach(btn => {
        btn.style.pointerEvents = "none"; // Disable clicking
        btn.style.backgroundColor = "grey";
        btn.style.border = "none";
        btn.style.cursor = "not-allowed"; // Change cursor
    });
});
</script>

<?php } ?>

<?php

    if ($_SESSION['item_form_delete'] == 0) {
    ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".deleteBtn").forEach(btn => {
        btn.style.pointerEvents = "none"; // Disable clicking
        btn.style.backgroundColor = "grey";
        btn.style.border = "none";
        // btn.style.opacity = "0.3"; // Make it look disabled
        btn.style.cursor = "not-allowed"; // Change cursor
    });
});
</script>

<?php }
} ?>

<?php
$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];

$product = "";
$brand = "";
$design = "";
$color = "";
$batch = "";
$category = "";
$hsnCode = "";
$taxCode = "";
$size = "";
$mrp = "";
$selling = "";
$rate = "";


if (isset($_POST['createItem'])) {
    try {
        extract($_POST);
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Check if all required fields are filled
        if (
            $product != '' && $brand != '' && $design != '' && $color != '' &&
            $batch != '' && $category != '' && $hsnCode != '' && $taxCode != '' &&
            $size != ''  && $rate != ''  && $selling != '' && $rate != ''
        ) {

            // Query to check if item already exists
            $querySearchingItems = "SELECT * FROM items WHERE 
            (product_name = '$product' AND brand_name = '$brand' AND design_name = '$design'
            AND color_name = '$color' AND batch_name = '$batch'AND size_name = '$size'
            AND category_name = '$category' AND hsn_code = '$hsnCode' AND tax_code = '$taxCode' 
            AND mrp = '$mrp' AND selling_price = '$selling' AND rate = '$rate') 
            AND branch_id = '$userBranchId'";

            $resultSearchingItem = $con->query($querySearchingItems);


            if ($resultSearchingItem->num_rows == 0) {


                $createdDate = date("Y-m-d");
                $description = $product . "/" . $brand . "/" . $design . "/" . $color . "/" . $batch . "/" . $mrp . "/" . $size;
                $queryInsertItem = "insert into items (product_name,brand_name,design_name,
                color_name,batch_name,category_name,hsn_code,tax_code,size_name,mrp,selling_price,rate,description,
                created_date,user_id,branch_id)
                values('$product','$brand','$design','$color','$batch','$category','$hsnCode','$taxCode',
                '$size','$mrp','$selling','$rate','$createdDate','$description','$userId','$userBranchId')
                ";

                $resultInsertItem = $con->query($queryInsertItem);

                if ($resultInsertItem) {
                    $con->commit();
                    $_SESSION['success'] = "Item created successfully";
                    header("Location: " . BASE_URL . "/pages/itemMaster.php");
                    exit;
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Oops! something went wrong";
                }
            } else {
                $product = "";
                $brand = "";
                $design = "";
                $color = "";
                $batch = "";
                $category = "";
                $hsnCode = "";
                $taxCode = "";
                $size = "";
                $mrp = "";
                $selling = "";
                $rate = "";
                $_SESSION['failure'] = "Item already exists";
            }
        } else {
            $_SESSION['failure'] = "All fields are required";
        }
    } catch (mysqli_sql_exception $e) {
        $con->rollback();
        $_SESSION['failure'] = "Error: " . $e->getMessage();
    }
}


// if (isset($_GET['updateId'])) {
//     extract($_GET);
//     $querySearchItems = "select*from items where id='$updateId' and branch_id = '$userBranchId' order by product_name";
//     $resultSearchItems = $con->query($querySearchItems)->fetch_assoc();

//     $product = $resultSearchItems['product_name'];
//     $brand = $resultSearchItems['brand_name'];
//     $design = $resultSearchItems['design_name'];
//     $color = $resultSearchItems['color_name'];
//     $batch = $resultSearchItems['batch_name'];
//     $category =  $resultSearchItems['category_name'];
//     $hsnCode = $resultSearchItems['hsn_code'];
//     $taxCode = $resultSearchItems['tax_code'];
//     $size = $resultSearchItems['size_name'];
//     $mrp = $resultSearchItems['mrp'];
//     $selling = $resultSearchItems['selling_price'];
//     $rate = $resultSearchItems['rate'];

//     if (isset($_POST['updateItem'])) {

//         extract($_POST);


//         $description = $product . "/" . $brand . "/" . $design . "/" . $color . "/" . $batch . "/" . $mrp . "/" . $size;

//         $querySearchItemForUpdate = "SELECT * FROM items WHERE 
//             (product_name = '$product' AND brand_name = '$brand' AND design_name = '$design'
//             AND color_name = '$color' AND batch_name = '$batch'AND size_name = '$size'
//             AND category_name = '$category' AND hsn_code = '$hsnCode' AND tax_code = '$taxCode' 
//             AND mrp = '$mrp' AND selling_price = '$selling' AND rate = '$rate') 
//              AND id != '$updateId' AND branch_id = '$userBranchId'";

//         $resultSearchItemForUpdate = $con->query($querySearchItemForUpdate);
//         if ($resultSearchItemForUpdate->num_rows == 0) {
//             $queryUpdateItem = "update items set product_name = '$product',
//             brand_name = '$brand', design_name = '$design', color_name = '$color',
//             batch_name = '$batch', category_name = '$category', hsn_code = '$hsnCode',
//             tax_code = '$taxCode', size_name = '$size', mrp ='$mrp', selling_price ='$selling',
//             rate = '$rate' where id='$updateId' and branch_id  = '$userBranchId'";

//             $resultUpdateItem = $con->query($queryUpdateItem);

//             $_SESSION['success'] = "Item Updated Successfully";
//             header("Location:" . BASE_URL . "/pages/itemMaster.php");
//         } else {
//             $_SESSION['failure'] = "Already Item Created For This Attributes";
//         }
//     }
if (isset($_GET['updateId'])) {
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $updateId = $_GET['updateId'];

        // Get item to update
        $stmtGetItem = $con->prepare("SELECT * FROM items WHERE id = ? AND branch_id = ? ORDER BY product_name");
        $stmtGetItem->bind_param("ii", $updateId, $userBranchId);
        $stmtGetItem->execute();
        $resultSearchItems = $stmtGetItem->get_result()->fetch_assoc();

        if (!$resultSearchItems) {
            $_SESSION['failure'] = "Item not found";
            exit;
        }

        // Extract data
        $product = $resultSearchItems['product_name'];
        $brand = $resultSearchItems['brand_name'];
        $design = $resultSearchItems['design_name'];
        $color = $resultSearchItems['color_name'];
        $batch = $resultSearchItems['batch_name'];
        $category = $resultSearchItems['category_name'];
        $hsnCode = $resultSearchItems['hsn_code'];
        $taxCode = $resultSearchItems['tax_code'];
        $size = $resultSearchItems['size_name'];
        $mrp = $resultSearchItems['mrp'];
        $selling = $resultSearchItems['selling_price'];
        $rate = $resultSearchItems['rate'];

        if (isset($_POST['updateItem'])) {
            extract($_POST);
            $description = "$product/$brand/$design/$color/$batch/$mrp/$size";

            // Check for duplicate
            $stmtCheckDuplicate = $con->prepare("
                SELECT * FROM items WHERE
                product_name = ? AND brand_name = ? AND design_name = ? AND
                color_name = ? AND batch_name = ? AND size_name = ? AND
                category_name = ? AND hsn_code = ? AND tax_code = ? AND
                mrp = ? AND selling_price = ? AND rate = ?
                AND id != ? AND branch_id = ?
            ");
            $stmtCheckDuplicate->bind_param(
                "ssssssssddiii",
                $product,
                $brand,
                $design,
                $color,
                $batch,
                $size,
                $category,
                $hsnCode,
                $taxCode,
                $mrp,
                $selling,
                $rate,
                $updateId,
                $userBranchId
            );
            $stmtCheckDuplicate->execute();
            $resultDuplicate = $stmtCheckDuplicate->get_result();

            if ($resultDuplicate->num_rows == 0) {
                // Start transaction
                $con->begin_transaction();

                $stmtUpdateItem = $con->prepare("
                    UPDATE items SET
                    product_name = ?, brand_name = ?, design_name = ?, color_name = ?,
                    batch_name = ?, category_name = ?, hsn_code = ?, tax_code = ?,
                    size_name = ?, mrp = ?, selling_price = ?, rate = ?
                    WHERE id = ? AND branch_id = ?
                ");
                $stmtUpdateItem->bind_param(
                    "ssssssssddiii",
                    $product,
                    $brand,
                    $design,
                    $color,
                    $batch,
                    $category,
                    $hsnCode,
                    $taxCode,
                    $size,
                    $mrp,
                    $selling,
                    $rate,
                    $updateId,
                    $userBranchId
                );
                $stmtUpdateItem->execute();
                $con->commit();

                $_SESSION['success'] = "Item Updated Successfully";
                header("Location:" . BASE_URL . "/pages/itemMaster.php");
                exit;
            } else {
                $_SESSION['failure'] = "Already Item Created For These Attributes";
            }
        }
    } catch (mysqli_sql_exception $e) {
        $con->rollback();
        $_SESSION['failure'] = "Error: " . $e->getMessage();
    } finally {
        if (isset($stmtGetItem)) $stmtGetItem->close();
        if (isset($stmtCheckDuplicate)) $stmtCheckDuplicate->close();
        if (isset($stmtUpdateItem)) $stmtUpdateItem->close();
    }



?>

<style>
#itemUpdateBtn {
    display: block;
}

#itemCreateBtn {
    display: none;
}
</style>
<?php } ?>



<?php
// if (isset($_GET['deleteId'])) {
//     extract($_GET);


//     $querySearchItemForDelete = "select*from stock_balance where item_id = '$deleteId'
//     and branch_id= '$userBranchId'";
//     $resultSearchItemForDelete  = $con->query($querySearchItemForDelete);
//     if ($resultSearchItemForDelete->num_rows == 0) {

//         $queryDeleteItem  = "delete from items where id='$deleteId'
//         and branch_id = '$userBranchId'";
//         $resultDeleteItem = $con->query($queryDeleteItem);

//         $_SESSION['success'] = "Item Deleted Successfully";
//     } else {
//         $_SESSION['failure'] = "Can't Delete This Item Due To Transaction Found For This Item";
//     }
// }

if (isset($_GET['deleteId'])) {
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $deleteId = $_GET['deleteId'];

        // Begin transaction
        $con->begin_transaction();

        // Check if item has stock_balance records
        $stmtCheckStock = $con->prepare("SELECT * FROM stock_balance WHERE item_id = ? AND branch_id = ?");
        $stmtCheckStock->bind_param("ii", $deleteId, $userBranchId);
        $stmtCheckStock->execute();
        $resultCheckStock = $stmtCheckStock->get_result();

        if ($resultCheckStock->num_rows === 0) {
            // No stock balance found, safe to delete
            $stmtDeleteItem = $con->prepare("DELETE FROM items WHERE id = ? AND branch_id = ?");
            $stmtDeleteItem->bind_param("ii", $deleteId, $userBranchId);
            $stmtDeleteItem->execute();

            $con->commit();
            $_SESSION['success'] = "Item Deleted Successfully";
        } else {
            $con->rollback();
            $_SESSION['failure'] = "Can't delete this item due to transaction found for this item.";
        }

    } catch (mysqli_sql_exception $e) {
        $con->rollback();
        $_SESSION['failure'] = "Error: " . $e->getMessage();
    } finally {
        if (isset($stmtCheckStock)) $stmtCheckStock->close();
        if (isset($stmtDeleteItem)) $stmtDeleteItem->close();
    }
}



if (isset($_POST['itemSearchBtn'])) {

    extract($_POST);
    $_SESSION['searchItem'] = $searchItem;

    $querySearchItem2 = "SELECT * FROM items WHERE 
            (product_name LIKE '%$searchItem%' OR brand_name LIKE '%$searchItem%' OR design_name LIKE '%$searchItem%'
            OR color_name LIKE '%$searchItem%' OR batch_name LIKE '%$searchItem%' OR size_name LIKE '%$searchItem%'
            OR category_name LIKE '%$searchItem%' OR hsn_code LIKE '%$searchItem%' OR tax_code LIKE '%$searchItem%' 
            OR mrp LIKE '%$searchItem%' OR selling_price LIKE '%$searchItem%' OR rate LIKE '%$searchItem%') 
            AND branch_id = '$userBranchId' order by product_name";
    $resultSearchItem2  = $con->query($querySearchItem2);
}


if (isset($_POST['exportButton'])) {
    extract($_POST);

    header("Location:" . BASE_URL . "/exportFile/excelFileFormatItems.php");
}

// if(isset($_POST['createItem'])){
//     try{
//     extract($_POST);

//     echo "product = ".$product;
//     echo "<br>";
//     echo "brand = ".$brand;
//     echo "<br>";
//     echo "design = ".$design;
//     echo "<br>";
//     echo "color = ".$color;
//     echo "<br>";
//     echo "batch = ".$batch;
//     echo "<br>";
//     echo "category = ".$category;
//     echo "<br>";
//     echo "hsn = ".$hsnCode;
//     echo "<br>";
//     echo "tax = ".$taxCode;
//     echo "<br>";
//     echo "size = ".$size;
//     echo "<br>";
//     echo "mrp = ".$mrp;
//     echo "<br>";
//     echo "selling = ".$selling;
//     echo "<br>";
//     echo "rate = ".$rate;
//     echo "<br>";




//         mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

//     if(isset($product) && $product !='' && isset($brand) && $brand != '' && $design != '' && $color != '' &&
//         $batch != '' && $category != '' && $hsnCode != '' && $taxCode !=''&&
//         $size != ''  && $rate != ''  && $selling != '' && $rate != '')
//     {
//         echo "all fields are filled";
//         $querySearchingItems = "select*from items where 
//         (product_name = '$product' and brand_name = '$brand' and design_name = '$design'
//         and color_name = '$color' and batch_name = '$batch' and category_name = '$category'
//         and hsn_code = '$hsnCode' and tax_code = '$taxCode' and size_name = '$size'
//         and mrp = '$mrp' and selling_price = '$selling' and $rate = '$rate') and branch_id = '$userBranchId'";
//         $resultSearchingItem = $con->query($querySearchingItems);



//         if($resultSearchingItem->num_rows==0){

//             $_SESSION['success']  = "item created successfully";    
//             header("Location:".BASE_URL."/pages/itemMaster.php");
//             exit;
//         }else{

//             $_SESSION['failure'] = 'Item Already Exist';
//             exit;
//         }

//     }else{
//         $_SESSION['failure']  = "all the fields are required ";

//     }
//     }catch(Exception $e){


//     }








// }





$querySearchTax = "select*from taxes where branch_id = '$userBranchId'";
$resultSearchTax  = $con->query($querySearchTax);

$querySearchItems = "select*from items where branch_id = '$userBranchId'";
$resultSearchItems = $con->query($querySearchItems);

?>
<div id="response_message">

</div>

<?php if (isset($_SESSION['success'])) { ?>
<div class="alert alert-success" id="success-alert">
    <?php echo $_SESSION['success']; ?>!
    <?php unset($_SESSION['success']); ?>
</div>
<?php } ?>

<?php if (isset($_SESSION['failure'])) { ?>
<div class="alert alert-danger" id="failure-alert">
    <?php echo $_SESSION['failure']; ?>!
    <?php unset($_SESSION['failure']); ?>
</div>

<?php } ?>

<form action="" id="itemForm" method="post">
    <h3 style="text-align:left;font-family:Verdana, Geneva, Tahoma, sans-serif;"><span style="font-weight:bolder">Manage
        </span><span style="font-size:medium;font-weight:bold;color:gray;">Item</span></h3>
    <hr>
    <span style="display:flex; gap:20px;">
        <div class="form-floating">
            <input type="text" name="product" id="product" autocomplete="off" class="form-control" placeholder="Product"
                value="<?php echo $product; ?>">
            <label for="form-floating" style="margin-top:-14px">Product <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>
        <div class="form-floating">
            <input type="text" name="brand" id="brand" class="form-control" autocomplete="off" placeholder="Brand"
                value="<?php echo $brand; ?>">
            <label for="form-floating" style="margin-top:-14px">Brand <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>
        <div class="form-floating">
            <input type="text" name="design" id="design" class="form-control" autocomplete="off" placeholder="Design"
                value="<?php echo $design; ?>">
            <label for="form-floating" style="margin-top:-14px">Design <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>

        <div class="form-floating">
            <input type="text" name="color" id="color" class="form-control" autocomplete="off" placeholder="Color"
                value="<?php echo $color; ?>">
            <label for="form-floating" style="margin-top:-14px">Color <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>

    </span>

    <span style="display:flex;gap:20px;">
        <div class="form-floating">
            <input type="text" name="batch" id="batch" class="form-control" autocomplete="off" placeholder="Batch"
                value="<?php echo $batch; ?>">
            <label for="form-floating" style="margin-top:-4px">Batch <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>

        <div class="form-floating">
            <input type="text" name="category" id="category" class="form-control" autocomplete="off"
                placeholder="Category" value="<?php echo $category; ?>">
            <label for="form-floating" style="margin-top:-4px">Category <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>
        <div class="form-floating">
            <input type="text" name="hsnCode" id="hsnCode" class="form-control" autocomplete="off"
                placeholder="HSN Code" value="<?php echo $hsnCode; ?>">
            <label for="form-floating" style="margin-top:-4px">HSN Code <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>
        <div class="form-floating">
            <select name="taxCode" id="taxCode" class="form-control" style="padding-top:10px">
                <?php while ($taxData = $resultSearchTax->fetch_assoc()) { ?>
                <option style="padding-bottom: 10px;" value="<?php echo $taxData['tax_code']; ?>"
                    <?php echo ($taxData['tax_code'] == $taxCode) ? 'selected' : ""; ?>>
                    <?php echo $taxData['tax_code'] ?></option>

                <?php } ?>
            </select>
            <label for="form-floating" style="margin-top:10px;margin-left:200px;font-size:16px;">Tax <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>
    </span>




    <span style="display:flex;gap:20px;">
        <div class="form-floating">
            <input type="text" name="size" id="size" class="form-control" autocomplete="off"
                value="<?php echo $size; ?>" placeholder="Size">
            <label for="form-floating" style="margin-top:-4px">Size <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>
        <div class="form-floating">
            <input type="text" name="mrp" id="mrp" class="form-control" autocomplete="off" value="<?php echo $mrp; ?>"
                placeholder="MRP">
            <label for="form-floating" style="margin-top:-4px">Mrp <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>
        <div class="form-floating">
            <input type="text" name="selling" id="selling" class="form-control" autocomplete="off"
                value="<?php echo $selling; ?>" placeholder="Selling">
            <label for="form-floating" style="margin-top:-4px">Selling <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>
        <div class="form-floating">
            <input type="text" name="rate" id="rate" class="form-control" autocomplete="off"
                value="<?php echo $rate; ?>" placeholder="Rate">
            <label for="form-floating" style="margin-top:-4px">Rate <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>
    </span>



    <!-- <input type="text" name="itemName" id="itemName" class="form-control" placeholder="Item Name"> -->


    <hr>
    <div id="itemCreateBtn">
        <button type="submit" name="createItem" id="createItem" class="btn btn-primary"
            style="width:120px;">Submit</button>
        <a href="<?php echo BASE_URL; ?>/pages/homePage.php" class="btn btn-secondary" style="width:120px;">Back</a>
    </div>


    <div id="itemUpdateBtn">
        <button type="submit" name="updateItem" id="updateItem" class="btn btn-primary"
            style="width:120px;">Update</button>
        <a href="<?php echo BASE_URL; ?>/pages/itemMaster.php" class="btn btn-secondary" style="width:120px;">Cancel</a>
    </div>

    <hr>
</form>

<form action="" class="itemSearchForm" style="margin-top:-20px;" method="post">
    <input type="text" class="form-control" name="searchItem" autocomplete="off" id="itemSearch"
        placeholder="Search Item">
    <button type="submit" class="btn btn-success" name="itemSearchBtn" id="itemSearchBtn">Search</button>
</form>

<form action="" id="exportForm" method="post" target="">
    <select name="fileType" id="fileType" class="form-control" style="width:160px;">
        <!-- <option value="">--Select File Type--</option> -->
        <!-- <option value="pdfFile">PDF</option> -->
        <option value="excelFile">Excel</option>
    </select>
    <button type="submit" id="exportBtn" name="exportButton" class="btn btn-primary">Export</button>
</form>

<div style="max-height:400px;overflow-x:auto;overflow-y:auto;" class="itemTable">
    <table class="table text-white" style="font-size:11px;width:1147px">
        <thead style="position:sticky;z-index:1;top:0;background-color:#FF3CAC;font-size:10px;">
            <tr>
                <th>S.No</th>
                <th>Action</th>
                <th>Item Id</th>
                <th>Product</th>
                <th>Brand</th>
                <th>Design</th>
                <th>Color</th>
                <th>Batch</th>
                <th>Category</th>
                <th>HSN Code</th>
                <th>Tax Code</th>
                <th>Size</th>
                <th>MRP</th>
                <th>Selling</th>
                <th>Rate</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($resultSearchItem2)) {

                $sno = 1;
                while ($itemData = $resultSearchItem2->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $sno++; ?></td>
                <td>
                    <a href="<?php echo BASE_URL; ?>/pages/itemMaster.php?updateId=<?php echo $itemData['id']; ?>"
                        id="editButton" class="btn btn-success editBtn" style="font-size: 5px;"><i
                            class="fa-solid fa-pen" style="font-size:10px"></i></a>
                    <a href="<?php echo BASE_URL; ?>/pages/itemMaster.php?deleteId=<?php echo $itemData['id']; ?>"
                        onclick="return confirm('Do you want to delete this Item <?php echo $itemData['id']; ?>?')"
                        id="deleteButton" class="btn btn-danger deleteBtn" style="font-size:5px"><i
                            class="fa-solid fa-trash" style="font-size:10px"></i></a>
                </td>
                <td><?php echo $itemData['id']; ?></td>
                <td><?php echo $itemData['product_name']; ?></td>
                <td><?php echo $itemData['brand_name']; ?></td>
                <td><?php echo $itemData['design_name']; ?></td>
                <td><?php echo $itemData['color_name']; ?></td>
                <td><?php echo $itemData['batch_name']; ?></td>
                <td><?php echo $itemData['category_name']; ?></td>
                <td><?php echo $itemData['hsn_code']; ?></td>
                <td><?php echo $itemData['tax_code']; ?></td>
                <td><?php echo $itemData['size_name']; ?></td>
                <td><?php echo $itemData['mrp']; ?></td>
                <td><?php echo $itemData['selling_price']; ?></td>
                <td><?php echo $itemData['rate']; ?></td>
            </tr>
            <?php }
            } else {
                ?>
            <?php
                $sno = 1;
                while ($itemData = $resultSearchItems->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $sno++; ?></td>
                <td>
                    <a href="<?php echo BASE_URL; ?>/pages/itemMaster.php?updateId=<?php echo $itemData['id']; ?>"
                        id="editButton" class="btn btn-success editBtn" style="font-size: 5px;"><i
                            class="fa-solid fa-pen" style="font-size:10px"></i></a>
                    <a href="<?php echo BASE_URL; ?>/pages/itemMaster.php?deleteId=<?php echo $itemData['id']; ?>"
                        onclick="return confirm('Do you want to delete this Item <?php echo $itemData['id']; ?>?')"
                        id="deleteButton" class="btn btn-danger deleteBtn" style="font-size:5px"><i
                            class="fa-solid fa-trash" style="font-size:10px"></i></a>
                </td>
                <td><?php echo $itemData['id']; ?></td>
                <td><?php echo $itemData['product_name']; ?></td>
                <td><?php echo $itemData['brand_name']; ?></td>
                <td><?php echo $itemData['design_name']; ?></td>
                <td style=""><?php echo $itemData['color_name']; ?></td>
                <td><?php echo $itemData['batch_name']; ?></td>
                <td><?php echo $itemData['category_name']; ?></td>
                <td><?php echo $itemData['hsn_code']; ?></td>
                <td><?php echo $itemData['tax_code']; ?></td>
                <td><?php echo $itemData['size_name']; ?></td>
                <td><?php echo $itemData['mrp']; ?></td>
                <td><?php echo $itemData['selling_price']; ?></td>
                <td><?php echo $itemData['rate']; ?></td>
            </tr>
            <?php }
            }
            ?>

        </tbody>
    </table>
</div>


<?php include_once(DIR_URL . "/includes/footer.php"); ?>

<script>
setTimeout(() => {
    let alert_box = document.getElementById("success-alert");
    if (alert_box) {
        alert_box.style.display = 'none';
    }
}, 2000);

setTimeout(() => {
    let alert_box = document.getElementById("failure-alert");
    if (alert_box) {
        alert_box.style.display = 'none';
    }
}, 4000);



addEventListener('keydown', function(event) {
    if (event.key === "F5") {
        event.preventDefault();
        let confirmation = confirm("Are you sure you want to refresh? Your unsaved data will be lost.");
        if (confirmation) {
            location.reload();
        }
    }

})



window.onload = function() {
    document.getElementById("product").focus();

}

document.getElementById("taxCode").addEventListener('change', function() {


})

function createProduct(target) {
    let productName = new FormData();
    productName.append('al_product', target.value);
    let aj_product = new XMLHttpRequest();
    aj_product.open("POST", "ajaxItemMaster.php", true);
    aj_product.send(productName);
    aj_product.onreadystatechange = function() {

        if (aj_product.status === 200 && aj_product.readyState == -4) {

            document.getElementById("response_message").innerHTML = aj_product.responseText;
        }
    }
}

function createBrand(target) {
    let brandName = new FormData();
    brandName.append('al_brand', target.value);
    let aj_brand = new XMLHttpRequest();
    aj_brand.open("POST", "ajaxItemMaster.php", true);
    aj_brand.send(brandName);
    aj_brand.onreadystatechange = function() {

        if (aj_brand.status === 200 && aj_brand.readyState == -4) {

            document.getElementById("response_message").innerHTML = aj_brand.responseText;
        }
    }
}

function createDesign(target) {
    let designName = new FormData();
    designName.append('al_design', target.value);
    let aj_design = new XMLHttpRequest();
    aj_design.open("POST", "ajaxItemMaster.php", true);
    aj_design.send(designName);
    aj_design.onreadystatechange = function() {

        if (aj_design.status === 200 && aj_design.readyState == -4) {

            document.getElementById("response_message").innerHTML = aj_design.responseText;
        }
    }
}

function createColor(target) {
    let colorName = new FormData();
    colorName.append('al_color', target.value);
    let aj_color = new XMLHttpRequest();
    aj_color.open("POST", "ajaxItemMaster.php", true);
    aj_color.send(colorName);
    aj_color.onreadystatechange = function() {

        if (aj_color.status === 200 && aj_color.readyState == -4) {

            document.getElementById("response_message").innerHTML = aj_color.responseText;
        }
    }
}

function createBatch(target) {
    let batchName = new FormData();
    batchName.append('al_batch', target.value);
    let aj_batch = new XMLHttpRequest();
    aj_batch.open("POST", "ajaxItemMaster.php", true);
    aj_batch.send(batchName);
    aj_batch.onreadystatechange = function() {

        if (aj_batch.status === 200 && aj_batch.readyState == -4) {

            document.getElementById("response_message").innerHTML = aj_batch.responseText;
        }
    }
}

function createCategory(target) {
    let categoryName = new FormData();
    categoryName.append('al_category', target.value);
    let aj_category = new XMLHttpRequest();
    aj_category.open("POST", "ajaxItemMaster.php", true);
    aj_category.send(categoryName);
    aj_category.onreadystatechange = function() {

        if (aj_category.status === 200 && aj_category.readyState == -4) {

            document.getElementById("response_message").innerHTML = aj_category.responseText;
        }
    }
}

function createHSN(target) {
    event.preventDefault();
    let hsnCodeName = new FormData();
    hsnCodeName.append('al_hsnCode', target.value);
    let aj_hsnCode = new XMLHttpRequest();
    aj_hsnCode.open("POST", "ajaxItemMaster.php", true);
    aj_hsnCode.send(hsnCodeName);
    aj_hsnCode.onreadystatechange = function() {

        if (aj_hsnCode.status === 200 && aj_hsnCode.readyState == -4) {

            document.getElementById("response_message").innerHTML = aj_hsnCode.responseText;
        }
    }
}

function createSize(target) {
    let sizeName = new FormData();
    sizeName.append('al_size', target.value);
    let aj_size = new XMLHttpRequest();
    aj_size.open("POST", "ajaxItemMaster.php", true);
    aj_size.send(sizeName);
    aj_size.onreadystatechange = function() {

        if (aj_size.status === 200 && aj_size.readyState == -4) {

            document.getElementById("response_message").innerHTML = aj_size.responseText;
        }
    }
}

function createMrp(target) {
    let mrpName = new FormData();
    mrpName.append('al_mrp', target.value);
    let aj_mrp = new XMLHttpRequest();
    aj_mrp.open("POST", "ajaxItemMaster.php", true);
    aj_mrp.send(mrpName);
    aj_mrp.onreadystatechange = function() {

        if (aj_mrp.status === 200 && aj_mrp.readyState == -4) {

            document.getElementById("response_message").innerHTML = aj_mrp.responseText;
        }
    }
}


document.getElementById("product").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {
        event.preventDefault();

        createProduct(target);

        document.getElementById("brand").focus();
        document.getElementById("brand").select();

    } else if (event.key === "F2") {

        let productData = new FormData();
        let productQuery =
            `select*from products where product_name like '%${target.value}%' order by product_name`;

        productData.append('lb_qry_product', productQuery)
        let aj_product = new XMLHttpRequest();
        aj_product.open("POST", "ajaxItemMaster.php", true);
        aj_product.send(productData);
        aj_product.onreadystatechange = function() {

            if (aj_product.status === 200 && aj_product.readyState === 4) {

                document.getElementById("response_message").innerHTML = aj_product.responseText;

            }
        }

    }
})

document.getElementById("brand").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {
        event.preventDefault();
        createBrand(target);
        document.getElementById("design").focus();
        document.getElementById("design").select();

    } else if (event.key === "F2") {

        let brandData = new FormData();
        let brandQuery = `select*from brands where brand_name like '%${target.value}%' order by brand_name`;

        brandData.append('lb_qry_brand', brandQuery)
        let aj_brand = new XMLHttpRequest();
        aj_brand.open("POST", "ajaxItemMaster.php", true);
        aj_brand.send(brandData);
        aj_brand.onreadystatechange = function() {

            if (aj_brand.status === 200 && aj_brand.readyState === 4) {

                document.getElementById("response_message").innerHTML = aj_brand.responseText;

            }
        }

    }
})

document.getElementById("design").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {
        event.preventDefault();

        createDesign(target);

        document.getElementById("color").focus();
        document.getElementById("color").select();

    } else if (event.key === "F2") {

        let designData = new FormData();
        let designQuery = `select*from designs where design_name like '%${target.value}%' order by design_name`;

        designData.append('lb_qry_design', designQuery)
        let aj_design = new XMLHttpRequest();
        aj_design.open("POST", "ajaxItemMaster.php", true);
        aj_design.send(designData);
        aj_design.onreadystatechange = function() {

            if (aj_design.status === 200 && aj_design.readyState === 4) {

                document.getElementById("response_message").innerHTML = aj_design.responseText;

            }
        }

    }
})
document.getElementById("color").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {
        event.preventDefault();

        createColor(target);
        document.getElementById("batch").focus();
        document.getElementById("batch").select();

    } else if (event.key === "F2") {

        let colorData = new FormData();
        let colorQuery = `select*from colors where color_name like '%${target.value}%' order by color_name`;

        colorData.append('lb_qry_color', colorQuery)
        let aj_color = new XMLHttpRequest();
        aj_color.open("POST", "ajaxItemMaster.php", true);
        aj_color.send(colorData);
        aj_color.onreadystatechange = function() {

            if (aj_color.status === 200 && aj_color.readyState === 4) {

                document.getElementById("response_message").innerHTML = aj_color.responseText;

            }
        }

    }
})
document.getElementById("batch").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {
        event.preventDefault();

        document.getElementById("category").focus();
        document.getElementById("category").select();

    } else if (event.key === "F2") {

        let batchData = new FormData();
        let batchQuery = `select*from batches where batch_name like '%${target.value}%' order by batch_name`;

        batchData.append('lb_qry_batch', batchQuery)
        let aj_batch = new XMLHttpRequest();
        aj_batch.open("POST", "ajaxItemMaster.php", true);
        aj_batch.send(batchData);
        aj_batch.onreadystatechange = function() {

            if (aj_batch.status === 200 && aj_batch.readyState === 4) {

                document.getElementById("response_message").innerHTML = aj_batch.responseText;

            }
        }

    }
})
document.getElementById("category").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {
        event.preventDefault();
        createCategory(target);
        document.getElementById("hsnCode").focus();
        document.getElementById("hsnCode").select();

    } else if (event.key === "F2") {

        let categoryData = new FormData();
        let categoryQuery =
            `select*from categories where category_name like '%${target.value}%' order by category_name`;

        categoryData.append('lb_qry_category', categoryQuery)
        let aj_category = new XMLHttpRequest();
        aj_category.open("POST", "ajaxItemMaster.php", true);
        aj_category.send(categoryData);
        aj_category.onreadystatechange = function() {

            if (aj_category.status === 200 && aj_category.readyState === 4) {

                document.getElementById("response_message").innerHTML = aj_category.responseText;

            }
        }

    }
})
document.getElementById("hsnCode").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {

        createHSN(target);
        document.getElementById("taxCode").focus();


    } else if (event.key === "F2") {

        let hsnData = new FormData();
        let hsnQuery = `select*from hsn_codes where hsn_code like '%${target.value}%' order by hsn_code`;

        hsnData.append('lb_qry_hsnCode', hsnQuery)
        let aj_hsn = new XMLHttpRequest();
        aj_hsn.open("POST", "ajaxItemMaster.php", true);
        aj_hsn.send(hsnData);
        aj_hsn.onreadystatechange = function() {

            if (aj_hsn.status === 200 && aj_hsn.readyState === 4) {

                document.getElementById("response_message").innerHTML = aj_hsn.responseText;

            }
        }

    }
})
document.getElementById("taxCode").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {
        // let taxCodeName = new FormData();
        //         taxCodeName.append('al_tax',target.value);
        //         let aj_taxCode = new XMLHttpRequest();
        //         aj_taxCode.open("POST","ajaxItemMaster.php",true);
        //         aj_taxCode.send(taxCodeName);
        //         aj_product.onreadystatechange = function(){

        //             if(tax.status === 200 && tax.readyState ==- 4){

        //                 document.getElementById("response_message").innerHTML = aj_tax.responseText;
        //             }
        //         }
        event.preventDefault();
        document.getElementById("size").focus();
        document.getElementById("size").select();

    } else if (event.key === "F2") {

        let taxData = new FormData();
        let taxQuery = `select*from taxes where tax_code like '%${target.value}%' order by tax_code`;

        taxData.append('lb_qry_tax', brandQuery)
        let aj_tax = new XMLHttpRequest();
        aj_tax.open("POST", "ajaxItemMaster.php", true);
        aj_tax.send(taxData);
        aj_tax.onreadystatechange = function() {

            if (aj_tax.status === 200 && aj_tax.readyState === 4) {

                document.getElementById("response_message").innerHTML = aj_tax.responseText;

            }
        }

    }
})
document.getElementById("size").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {
        event.preventDefault();
        createSize(target);
        document.getElementById("mrp").focus();
        document.getElementById("mrp").select();

    } else if (event.key === "F2") {

        let sizeData = new FormData();
        let sizeQuery = `select*from sizes where size_name like '%${target.value}%' order by size_name`;

        sizeData.append('lb_qry_size', sizeQuery)
        let aj_size = new XMLHttpRequest();
        aj_size.open("POST", "ajaxItemMaster.php", true);
        aj_size.send(sizeData);
        aj_size.onreadystatechange = function() {

            if (aj_size.status === 200 && aj_size.readyState === 4) {

                document.getElementById("response_message").innerHTML = aj_size.responseText;

            }
        }

    }
})
document.getElementById("mrp").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {
        event.preventDefault();
        createMrp(target);
        document.getElementById("selling").focus();
        document.getElementById("selling").select();

    } else if (event.key === "F2") {

        let mrpData = new FormData();
        let mrpQuery = `select*from mrps where mrp like '%${target.value}%' order by mrp`;

        mrpData.append('lb_qry_mrp', mrpQuery)
        let aj_mrp = new XMLHttpRequest();
        aj_mrp.open("POST", "ajaxItemMaster.php", true);
        aj_mrp.send(mrpData);
        aj_mrp.onreadystatechange = function() {

            if (aj_mrp.status === 200 && aj_mrp.readyState === 4) {

                document.getElementById("response_message").innerHTML = aj_mrp.responseText;

            }
        }

    }
})



document.getElementById("product").addEventListener("focusout", function(event) {
    event.preventDefault();
    let target = event.target;
    createProduct(target);

})

document.getElementById("brand").addEventListener("focusout", function(event) {
    event.preventDefault();
    let target = event.target;
    createBrand(target);

})

document.getElementById("design").addEventListener("focusout", function(event) {
    event.preventDefault();
    let target = event.target;
    createDesign(target);

})

document.getElementById("color").addEventListener("focusout", function(event) {
    event.preventDefault();
    let target = event.target;
    createColor(target);

})

document.getElementById("batch").addEventListener("focusout", function(event) {
    event.preventDefault();
    let target = event.target;
    createBatch(target);

})

document.getElementById("category").addEventListener("focusout", function(event) {
    event.preventDefault();
    let target = event.target;
    createCategory(target);

})

document.getElementById("hsnCode").addEventListener("focusout", function(event) {
    event.preventDefault();
    let target = event.target;
    createHSN(target);

})



document.getElementById("size").addEventListener("focusout", function(event) {
    event.preventDefault();
    let target = event.target;
    createSize(target);

})

document.getElementById("mrp").addEventListener("focusout", function(event) {
    event.preventDefault();
    let target = event.target;
    createMrp(target);

})

document.getElementById("selling").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {
        event.preventDefault();

        document.getElementById("rate").focus();
        document.getElementById("rate").select();

    }
})
document.getElementById("rate").addEventListener("keydown", function(event) {
    let target = event.target;
    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("createItem").focus();


    }
})
</script>

<style>
/* #fileType {
            appearance: none; Remove default arrow
            -moz-appearance: none;
            -webkit-appearance: none;
            background: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"%3E%3Cpolyline points="6 9 12 15 18 9"%3E%3C/polyline%3E%3C/svg%3E') no-repeat right 10px center;
            background-color: #fff;
            background-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px 40px 5px 10px;
            font-size: 14px;
            cursor: pointer;
        }

        For better appearance in older browsers
        select::-ms-expand {
            display: none;
        }

        Optional: Add hover effect
        #fileType:hover {
            border-color:#007bff ;
} */

#success-alert {
    position: absolute;
    top: 70px;
    left: 460px;
    color: white;
    padding-top: 6px;
    height: 40px;
    width: 90%;
    font-weight: bolder;
    /* border:1px solid  #FF3CAC; */
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);

}

#failure-alert {
    position: absolute;
    top: 70px;
    left: 500px;
    color: white;
    padding-top: 6px;
    height: 40px;
    width: 38%;
    font-weight: bolder;
    /* border:1px solid  #FF3CAC; */
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);

}

.itemSearchForm {
    display: flex;
    gap: 10px;
    position: absolute;
    top: 400px;
    left: 300px;
}

#exportForm {
    display: flex;
    gap: 10px;
    position: absolute;
    top: 381px;
    left: 1205px;

}

.itemTable {

    position: absolute;
    top: 430px;
    left: 300px;
    width: 1162px;
    height: 245px;
    color: white;
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}

.form-floating {

    color: #2B86C5;
    font-size: 13px;

}

#itemForm {
    position: absolute;
    top: 80px;
    left: 300px;
    width: 500px;
}

#createItem {}

#product {
    width: 270px;
    height: 40px;
    background-color: blanchedalmond;
}

#brand {
    width: 270px;
    height: 40px;
    /* margin-top:10px; */
    background-color: blanchedalmond;
}

#design {
    width: 270px;
    height: 40px;
    /* margin-top:10px; */
    background-color: blanchedalmond;
}

#batch {
    width: 270px;
    height: 40px;
    margin-top: 10px;
    background-color: blanchedalmond;

}

#color {
    width: 270px;
    height: 40px;
    background-color: blanchedalmond;
}

#category {
    width: 270px;
    height: 40px;
    margin-top: 10px;
    background-color: blanchedalmond;
}

#hsnCode {
    width: 270px;
    height: 40px;
    margin-top: 10px;
    background-color: blanchedalmond;
}

#taxCode {
    width: 270px;
    height: 40px;
    margin-top: 10px;

    /* padding-bottom:36px; */
}

#taxDesc {
    width: 270px;
    height: 40px;
    margin-top: 10px;


}

#size {
    width: 270px;
    height: 40px;
    margin-top: 10px;
    background-color: blanchedalmond;
}

#mrp {
    width: 270px;
    height: 40px;
    margin-top: 10px;
    background-color: blanchedalmond;
}

#selling {
    width: 270px;
    height: 40px;
    margin-top: 10px;
}

#rate {
    width: 270px;
    height: 40px;
    margin-top: 10px;
}
</style>

<?php



?>

<?php ob_end_flush(); ?>