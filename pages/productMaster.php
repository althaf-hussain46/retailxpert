<style>
#updateProductBtn {
    visibility: hidden;
}

#backProductBtn {
    visibility: hidden;
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
    if ($_SESSION['product_form_create'] == 0) {
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let submitBtn = document.getElementById('submitProductBtn');
    if (submitBtn) {
        submitBtn.setAttribute('disabled', true);
    }

});
</script>

<?php } ?>
<?php

    if ($_SESSION['product_form_reprint'] == 0) {
    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {

    let supSearchBtn = document.getElementById("productSearchBtn");
    if (supSearchBtn) {
        supSearchBtn.setAttribute('disabled', true)
    }

    let supSearch = document.getElementById("productSearch");
    if (supSearch) {
        supSearch.setAttribute('disabled', true)
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

    if ($_SESSION['product_form_update'] == 0) {
    ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".editBtn").forEach(btn => {
        btn.style.pointerEvents = "none"; // Disable clicking
        btn.style.backgroundColor = 'grey';
        btn.style.border = 'none';
        btn.style.cursor = "not-allowed"; // Change cursor
    });
});
</script>

<?php } ?>

<?php

    if ($_SESSION['product_form_delete'] == 0) {
    ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".deleteBtn").forEach(btn => {
        btn.style.pointerEvents = "none"; // Disable clicking
        btn.style.backgroundColor = 'grey';
        btn.style.border = 'none';
        btn.style.cursor = "not-allowed"; // Change cursor
    });
});
</script>

<?php }
} ?>



<?php

// include_once(DIR_URL."/cls/classProduct.php");
// include_once(DIR_URL."/exportFile/pdfFileFormat.php");
// $objectProduct  = new  ClassProduct();
$product  = "";
$id = "";
$userId = $_SESSION['user_id'];
$userBranchId  = $_SESSION['user_branch_id'];

$_SESSION['table_name'] = "products";
$_SESSION['field_name'] = "product_name";


if (isset($_POST['exportButton'])) {
    extract($_POST);
    if ($fileType == "pdfFile") {
        $_SESSION['report_title'] = "Products Report";
        $_SESSION['header_title'] = "Product Name";

        header("Location:" . BASE_URL . "/exportFile/pdfFileFormat.php");
        // pdfFormat($_SESSION['product_name'],$con);



        // echo "hello = ".$objectProduct->getProductsSearch();
        // header("Location:".BASE_URL."exportFile/pdfFileFormat.php");

    } elseif ($fileType == "excelFile") {
        $_SESSION['item_id'] = "Product Id";
        $_SESSION['report_title'] = "Products Report";
        $_SESSION['header_title'] = "Product Name";
        header("Location:" . BASE_URL . "/exportFile/excelFileFormat.php");
    } else {
        echo "Please Select File Type";
    }
}


// if (isset($_GET['deletionid'])) {
//     extract($_GET);
//     $queryDeleteProduct = "delete from products where id='$deletionid' and branch_id = '$userBranchId'";
//     $resultDeleteProduct = $con->query($queryDeleteProduct);
//     if ($resultDeleteProduct) {
//         $_SESSION['success'] = "Product Deleted Successfully";
//     } else {
//         $_SESSION['failure'] = "Oops! Something Went Wrong";
//     }
// }

if (isset($_GET['deletionid'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Start transaction
        $con->begin_transaction();

        // Get deletion ID and branch ID
        $deletionid = $_GET['deletionid'];

        // Prepare the DELETE query with WHERE id AND branch_id
        $queryDeleteProduct = "DELETE FROM products WHERE id = ? AND branch_id = ?";
        $stmtDelete = $con->prepare($queryDeleteProduct);
        $stmtDelete->bind_param("ii", $deletionid, $userBranchId);

        // Execute the delete
        if ($stmtDelete->execute()) {
            $con->commit(); // Commit on success
            $_SESSION['success'] = "Product Deleted Successfully";
        } else {
            $con->rollback(); //Rollback on failure
            $_SESSION['failure'] = "Failed to delete product. Please try again.";
        }
    } catch (mysqli_sql_exception $e) {
        $con->rollback(); // Rollback if any exception occurs
        $_SESSION['failure'] = "Error during deletion: " . $e->getMessage();
    } finally {
        if (isset($stmtDelete)) $stmtDelete->close();
    }
}




if (isset($_GET['updationid']) && isset($_GET['product'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract GET data
        extract($_GET);

        if (isset($_POST['updateProduct'])) {
            // Extract POST data
            extract($_POST);

            if (!empty($productName)) {
                // Prepare the query to prevent SQL injection
                $querySearchProduct = "select*from products where product_name = '$productName'
                                    and branch_id = '$userBranchId' and id != '$updationid'";
                $resultSearchProduct = $con->query($querySearchProduct);

                if ($resultSearchProduct->num_rows == 0) {
                    $qryUpdateProduct = "UPDATE products SET product_name = ?, user_id = ?, branch_id = ? WHERE id = ?";
                    $stmt = $con->prepare($qryUpdateProduct);
                    $stmt->bind_param("siii", $productName, $userId, $userBranchId, $updationid);

                    // Execute the query
                    if ($stmt->execute()) {
                        $con->commit();
                        $_SESSION['success'] = "Product Updated Successfully";
                        header("Location:" . BASE_URL . "/pages/productMaster.php");
                        exit;
                    } else {
                        $con->rollback();
                        $_SESSION['failure'] = "Failed to update product. Please try again.";
                    }
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Product Already Exist! Cannot Create A Duplicate";
                }
            } else {
                $_SESSION['failure'] = "Product Name cannot be empty.";
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Check for specific SQL errors like duplicate entry
        $con->rollback();
        if ($e->getCode() == 1062) {
            $_SESSION['failure'] = "Product name '$productName' already exists. Please enter a different product name.";
        } else {
            $_SESSION['failure'] = "Oops! Something Went Wrong: " . $e->getMessage();
        }
    } finally {
        // Close the prepared statement if it exists
        if (isset($stmt)) {
            $stmt->close();
        }
    }


?>
<style>
#submitProductBtn {
    visibility: hidden;
}

#closeProductBtn {
    visibility: hidden;
}


#updateProductBtn {
    visibility: visible;

}

#backProductBtn {
    visibility: visible;

}
</style>
<!-- <script>
let pro = document.getElementById("updateProductBtn");
pro.style.visibility = "visible";
</script> -->
<?php } ?>

<?php

if (isset($_POST['submitProduct'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract form data
        extract($_POST);

        if (!empty($productName)) {
            // Prepare the query to prevent SQL injection

            $querySearchProduct = "select*from products where product_name = '$productName' and 
                                    branch_id = '$userBranchId'";
            $resultSearchProduct = $con->query($querySearchProduct);

            if ($resultSearchProduct->num_rows == 0) {
                $qryCrtPro = "INSERT INTO products (product_name, user_id, branch_id) VALUES(?,?,?)";
                $stmt = $con->prepare($qryCrtPro);
                $stmt->bind_param("sii", $productName, $userId, $userBranchId);

                // Execute the query
                if ($stmt->execute()) {
                    $con->commit();
                    $_SESSION['success'] = "Product Created Successfully";
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Failed to create product. Please try again.";
                }
            } else {
                $con->rollback();
                $_SESSION['failure'] = "Product already exists! Cannot create a duplicate.";
            }
        } else {
            $_SESSION['failure'] = "Product Name cannot be empty.";
        }
    } catch (mysqli_sql_exception $e) {
        // Check if it's a duplicate entry error
        $con->rollback();
        if ($e->getCode() == 1062) { // Error code for duplicate entry
            $_SESSION['failure'] = "Product name '$productName' already exists. Please enter a different product name.";
        } else {
            // Handle other SQL errors
            $_SESSION['failure'] = "Oops! Something Went Wrong: " . $e->getMessage();
        }
    } finally {
        // Close the prepared statement if it exists
        if (isset($stmt)) {
            $stmt->close();
        }
    }
}



// if(isset($_POST['submitProduct'])){

//     extract($_POST);
//     $qryCrtPro = "insert into products (product_name) values('$productName')";
//     $resCrtPro  = $con->query($qryCrtPro);

//     if($resCrtPro){
//         $_SESSION['success'] = "Product Created Successfully";
//     }else{
//         $_SESSION['failure'] = "Oops! Something Went Wrong";
//     }


// }




$qryFetchPro = "select*from products where branch_id = '$userBranchId' order by product_name";
$resFetchPro = $con->query($qryFetchPro);


?>

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


<form action="" id="productForm" method="post">
    <h3 style="text-align:left;font-family:Verdana, Geneva, Tahoma, sans-serif;"><span style="font-weight:bolder">Manage
        </span><span style="font-size:medium;font-weight:bold;color:gray;">Product</span></h3>
    <hr>
    <div class="form-floating">
        <input type="text" name="productName" autocomplete="off" id="productName" class="form-control"
            placeholder="Product Name" value="<?php echo $product; ?>" maxlength="30">
        <label for="floatingInput">Product Name</label>
    </div>


    <hr>
    <div style="display:flex; gap:150px;margin-top:-10px;" id="beforeEditPress">
        <button type="submit" name="submitProduct" id="submitProductBtn" class="btn btn-primary"
            style="width:120px;">Submit</button>
        <a href="<?php echo BASE_URL; ?>/pages/homePage.php" id="closeProductBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Close</a>
    </div>

    <div style="display:flex;gap:150px;margin-top:-38px;" id="afterEditPress">
        <button type="submit" name="updateProduct" id="updateProductBtn" class="btn btn-primary"
            style="width:120px;">Update</button>
        <a href="<?php echo BASE_URL; ?>/pages/productMaster.php" id="backProductBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Back</a>
    </div>

    <hr>
</form>




<form action="" class="productSearchForm" style="margin-top:-20px;" method="post">
    <input type="text" class="form-control" name="productSearch" autocomplete="off" id="productSearch"
        placeholder="Search Product">
    <button type="submit" class="btn btn-success" name="productSearchBtn" id="productSearchBtn">Search</button>
</form>

<form action="" id="exportForm" method="post" target="">
    <select name="fileType" id="fileType" class="form-control" style="width:160px;">
        <!-- <option value="">--Select File Type--</option> -->
        <option value="pdfFile">PDF</option>
        <option value="excelFile">Excel</option>
    </select>
    <button type="submit" id="exportBtn" name="exportButton" class="btn btn-primary">Export</button>
</form>

<div style="max-height:400px;overflow-x:auto;overflow-y:auto;" class="productTable">


    <table class="table text-white" style="font-size:10px;">
        <thead style="position:sticky;z-index:1;top:0;background-color:#FF3CAC">
            <tr>
                <th style="width:20px">S.No.</th>
                <th style="width:150px">Actions</th>
                <th style="width:350px">Products</th>
                <th style="width:250px">Created By</th>
                <th>Created Date</th>
                <th>Product Id</th>

            </tr>

        </thead>
        <tbody>
            <?php




            if (isset($_POST['productSearchBtn'])) {
                extract($_POST);
                // echo $productSearch;

                $_SESSION['searching_name'] = $productSearch;
                // echo $_SESSION['searching_name'];


                // $objectProduct->setProductsSearch($productSearch);
                // echo "object = ".$objectProduct->getProductsSearch();
                echo "<script>
        document.addEventListener('DOMContentLoaded', function(event) {
            event.preventDefault();
            document.getElementById('productSearch').focus();
        });
      </script>";



                $querySearchProduct = "select*from products where product_name like '%$productSearch%' && branch_id = '$userBranchId'";
                $resultSearchProduct = $con->query($querySearchProduct);



                if (isset($resultSearchProduct)) {
                    $i = 1;
                    while ($productSearchData = $resultSearchProduct->fetch_assoc()) {


                        $querySearchUserName = "select user_name from user_master1 where id='$productSearchData[user_id]'";
                        $resultSearchUserName = $con->query($querySearchUserName)->fetch_assoc();


            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/productMaster.php?updationid=<?php echo $productSearchData['id']; ?>&product=<?php echo $productSearchData['product_name']; ?>"
                        class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size:10px"></i></a>

                    <a id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/productMaster.php?deletionid=<?php echo $productSearchData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this record (ID <?php echo $productSearchData['id']; ?>)?')"
                        class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash" style="font-size:10px"></i></a>
                </td>
                <td><?php echo $productSearchData['product_name']; ?></td>
                <td><?php echo $resultSearchUserName['user_name'] ?></td>
                <td><?php echo date("d-m-Y h:i:s A", strtotime($productSearchData['created_date'])); ?></td>
                <td><?php echo $productSearchData['id']; ?></td>
            </tr>

            <?php }
                }
            } else {


                // echo " without clicking search button = ". $_SESSION['searching_name'];
                $i = 1;
                while ($proData = $resFetchPro->fetch_assoc()) {

                    $querySearchUserName = "select user_name from user_master1 where id='$proData[user_id]'";
                    $resultSearchUserName = $con->query($querySearchUserName)->fetch_assoc();


                    ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/productMaster.php?updationid=<?php echo $proData['id']; ?>&product=<?php echo $proData['product_name']; ?>"
                        class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size:10px"></i></a>

                    <a id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/productMaster.php?deletionid=<?php echo $proData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete this record (ID <?php echo $proData['id']; ?>)?')"
                        class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash" style="font-size:10px;"></i></a>
                </td>
                <td><?php echo $proData['product_name']; ?></td>
                <td><?php echo date("d-m-Y h:i:s A", strtotime($resultSearchUserName['user_name'])); ?></td>
                <td><?php echo $proData['created_date']; ?></td>
                <td><?php echo $proData['id']; ?></td>
            </tr>

            <?php }
            }; ?>

        </tbody>
    </table>
</div>
<?php include_once(DIR_URL . "/includes/footer.php"); ?>



<style>
#fileType {
    appearance: none;
    /* Remove default arrow */
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

/* For better appearance in older browsers */
select::-ms-expand {
    display: none;
}

/* Optional: Add hover effect */
#fileType:hover {
    border-color: #007bff;
}

.form-floating {
    padding-top: 0px;
    color: #2B86C5;
    font-size: 13px;

}

#productName {
    width: 280px;
    font-size: 20px;
    font-weight: bold;
    /* text-transform: capitalize; */
    height: 50px;

}

#success-alert {
    position: absolute;
    top: 70px;
    left: 260px;
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
    left: 260px;
    color: white;
    padding-top: 6px;
    height: 40px;
    width: 90%;
    font-weight: bolder;
    /* border:1px solid  #FF3CAC; */
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);

}

#productForm {
    position: absolute;
    top: 120px;
    left: 300px;
    width: 500px;
}

.productSearchForm {
    display: flex;
    gap: 10px;
    position: absolute;
    top: 350px;
    left: 300px;
}

#exportForm {
    display: flex;
    gap: 10px;
    position: absolute;
    top: 330px;
    left: 1205px;

}


.productTable {

    position: absolute;
    top: 380px;
    left: 300px;
    width: 1150px;
    height: 275px;
    color: white;
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}
</style>

<script>
document.getElementById("productName").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("submitProductBtn").focus();
    }
});
document.getElementById("productName").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("updateProductBtn").focus();
    }
})
window.onload = function() {
    document.getElementById("productName").focus();
    document.getElementById("productName").select();

}


document.getElementById("productSearch").addEventListener('keypress', function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("productSearchBtn").focus();
    }
})

// document.getElementById("productSearchBtn").addEventListener('keypress', function(event){

// if(event.key === "Enter"){
//     event.preventDefault();
//     document.getElementById("productSearchBtn").focus();
// }
// })

// document.addEventListener("DOMContentLoaded", function () {
//     document.getElementById("editButton").addEventListener("click", function (event) {
//         event.preventDefault(); // Prevent the default anchor behavior
//         document.getElementById("productName").focus(); // Focus the input field
//     });
// });





setTimeout(() => {
    var alertBox = document.getElementById("success-alert");
    if (alertBox) {
        alertBox.style.display = 'none';
    }
}, 2000);

setTimeout(() => {
    var alertBox = document.getElementById("failure-alert");
    if (alertBox) {
        alertBox.style.display = 'none';
    }
}, 2000);
</script>
<?php ob_end_flush();
exit;
?>