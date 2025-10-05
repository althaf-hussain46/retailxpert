<style>
#updateBrandBtn {
    visibility: hidden;
}

#backbrandBtn {
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
    if ($_SESSION['brand_form_create'] == 0) {
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let submitBtn = document.getElementById('submitbrandBtn');
    if (submitBtn) {
        submitBtn.setAttribute('disabled', true);
    }

});
</script>

<?php } ?>
<?php

    if ($_SESSION['brand_form_reprint'] == 0) {
    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {

    let brandSearchBtn = document.getElementById("brandSearchBtn");
    if (brandSearchBtn) {
        brandSearchBtn.setAttribute('disabled', true)
    }

    let brandSearch = document.getElementById("brandSearch");
    if (brandSearch) {
        brandSearch.setAttribute('disabled', true)
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

    if ($_SESSION['brand_form_update'] == 0) {
    ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".editBtn").forEach(btn => {
        btn.style.pointerEvents = "none"; // Disable clicking
        // btn.style.opacity = "0.6"; // Make it look disabled
        btn.style.backgroundColor = 'grey';
        btn.style.border = 'none';
        btn.style.cursor = "not-allowed"; // Change cursor
    });
});
</script>

<?php } ?>

<?php

    if ($_SESSION['brand_form_delete'] == 0) {
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


// include_once(DIR_URL."/exportFile/pdfFileFormat.php");

$brand  = "";
$id = "";
// unset($_SESSION['searching_name']);
$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];

$_SESSION['table_name'] = "brands";
$_SESSION['field_name'] = "brand_name";


if (isset($_POST['exportButton'])) {
    extract($_POST);
    if ($fileType == "pdfFile") {
        $_SESSION['report_title'] = "Brands Report";
        $_SESSION['header_title'] = "Brand Name";
        header("Location:" . BASE_URL . "/exportFile/pdfFileFormat.php");
    } elseif ($fileType == "excelFile") {
        $_SESSION['report_title'] = "Brands Report";
        $_SESSION['header_title'] = "Brand Name";
        header("Location:" . BASE_URL . "/exportFile/excelFileFormat.php");
    } else {
        echo "Please Select File Type";
    }
}


// if (isset($_GET['deletionid'])) {
//     extract($_GET);
//     $queryDeletebrand = "delete from brands where id='$deletionid'";
//     $resultDeletebrand = $con->query($queryDeletebrand);
//     if ($resultDeletebrand) {
//         $_SESSION['success'] = "Brand Deleted Successfully";
//         header("Location:" . BASE_URL . "/pages/brandMaster.php");
//         exit;
//     } else {
//         $_SESSION['failure'] = "Oops! Something Went Wrong";
//     }
// }

if (isset($_GET['deletionid'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Start the transaction
        $con->begin_transaction();

        // Get the deletion ID
        $deletionid = $_GET['deletionid'];

        // Prepare the DELETE query
        $queryDeleteBrand = "DELETE FROM brands WHERE id = ?";
        $stmtDelete = $con->prepare($queryDeleteBrand);
        $stmtDelete->bind_param("i", $deletionid);

        // Execute the DELETE
        if ($stmtDelete->execute()) {
            $con->commit(); //  Commit if successful
            $_SESSION['success'] = "Brand Deleted Successfully";
            header("Location:" . BASE_URL . "/pages/brandMaster.php");
            exit;
        } else {
            $con->rollback(); //  Rollback if failed
            $_SESSION['failure'] = "Failed to delete brand. Please try again.";
        }
    } catch (mysqli_sql_exception $e) {
        $con->rollback(); // Rollback on any error
        $_SESSION['failure'] = "Error during deletion: " . $e->getMessage();
    } finally {
        if (isset($stmtDelete)) $stmtDelete->close();
    }
}



if (isset($_GET['updationid']) && isset($_GET['brand'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract GET data
        extract($_GET);

        if (isset($_POST['updateBrand'])) {
            // Extract POST data
            extract($_POST);

            if (!empty($brandName)) {
                // Prepare the query to prevent SQL injection
                $querySearchBrand = "select*from brands where brand_name = '$brandName'
                                    and branch_id = '$userBranchId' and id !='$updationid'";
                $resultSearchBrand = $con->query($querySearchBrand);

                if ($resultSearchBrand->num_rows == 0) {
                    $qryupdateBrand = "UPDATE brands SET brand_name = ?, user_id = ?, branch_id = ? WHERE id = ?";
                    $stmt = $con->prepare($qryupdateBrand);
                    $stmt->bind_param("siii", $brandName, $userId, $userBranchId, $updationid);

                    // Execute the query
                    if ($stmt->execute()) {
                        $con->commit();
                        $_SESSION['success'] = "Brand Updated Successfully";
                        header("Location:" . BASE_URL . "/pages/brandMaster.php");
                        exit;
                    } else {
                        $con->rollback();
                        $_SESSION['failure'] = "Failed to update brand. Please try again.";
                    }
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Brand Already Exist! Cannot Create A Duplicate";
                }
            } else {
                $_SESSION['failure'] = "Brand Name cannot be empty.";
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Check for specific SQL errors like duplicate entry
        $con->rollback();
        if ($e->getCode() == 1062) {
            $_SESSION['failure'] = "Brand Name '$brandName' already exists. Please enter a different brand name.";
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
#submitbrandBtn {
    visibility: hidden;
}

#closebrandBtn {
    visibility: hidden;
}


#updateBrandBtn {
    visibility: visible;

}

#backbrandBtn {
    visibility: visible;

}
</style>
<!-- <script>
let pro = document.getElementById("updateBrandBtn");
pro.style.visibility = "visible";
</script> -->
<?php } ?>

<?php

if (isset($_POST['submitbrand'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract form data
        extract($_POST);

        if (!empty($brandName)) {
            // Prepare the query to prevent SQL injection
            $querySearchBrand = "select*from brands where brand_name = '$brandName'
                                    and branch_id = '$userBranchId'";
            $resultSearchBrand = $con->query($querySearchBrand);

            if ($resultSearchBrand->num_rows == 0) {
                $qryCrtPro = "INSERT INTO brands (brand_name, user_id, branch_id) VALUES(?,?,?)";
                $stmt = $con->prepare($qryCrtPro);
                $stmt->bind_param("sii", $brandName, $userId, $userBranchId);

                // Execute the query
                if ($stmt->execute()) {
                    $con->commit();
                    $_SESSION['success'] = "Brand Created Successfully";
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Failed to create brand. Please try again.";
                }
            } else {
                $con->rollback();
                $_SESSION['failure'] = "Brand Already Exist! Cannot Create A Duplicate";
            }
        } else {
            $_SESSION['failure'] = "Brand Name cannot be empty.";
        }
    } catch (mysqli_sql_exception $e) {
        // Check if it's a duplicate entry error
        $con->rollback();
        if ($e->getCode() == 1062) { // Error code for duplicate entry
            $_SESSION['failure'] = "Brand Name '$brandName' already exists. Please enter a different brand name.";
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



// if(isset($_POST['submitbrand'])){

//     extract($_POST);
//     $qryCrtPro = "insert into brands (brand_name) values('$brandName')";
//     $resCrtPro  = $con->query($qryCrtPro);

//     if($resCrtPro){
//         $_SESSION['success'] = "brand Created Successfully";
//     }else{
//         $_SESSION['failure'] = "Oops! Something Went Wrong";
//     }


// }




$qryFetchPro = "select*from brands where branch_id = '$userBranchId' order by brand_name";
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
<form action="" id="brandForm" method="post">
    <h3 style="text-align:left;font-family:Verdana, Geneva, Tahoma, sans-serif;"><span style="font-weight:bolder">Manage
        </span><span style="font-size:medium;font-weight:bold;color:gray;">Brand</span></h3>
    <hr>
    <div class="form-floating">
        <input type="text" name="brandName" autocomplete="off" id="brandName" class="form-control"
            placeholder="Brand Name" value="<?php echo $brand; ?>" maxlength="30">
        <label for="form-floating">Brand Name</label>
    </div>



    <hr>
    <div style="display:flex; gap:150px;margin-top:-10px;" id="beforeEditPress">
        <button type="submit" name="submitbrand" id="submitbrandBtn" class="btn btn-primary"
            style="width:120px;">Submit</button>
        <a href="<?php echo BASE_URL; ?>/pages/homePage.php" id="closebrandBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Close</a>
    </div>

    <div style="display:flex;gap:150px;margin-top:-38px;" id="afterEditPress">
        <button type="submit" name="updateBrand" id="updateBrandBtn" class="btn btn-primary"
            style="width:120px;">Update</button>
        <a href="<?php echo BASE_URL; ?>/pages/brandMaster.php" id="backbrandBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Back</a>
    </div>

    <hr>
</form>




<form action="" class="brandSearchForm" style="margin-top:-20px;" method="post">
    <input type="text" class="form-control" name="brandSearch" autocomplete="off" id="brandSearch"
        placeholder="Search Brand">
    <button type="submit" class="btn btn-success" name="brandSearchBtn" id="brandSearchBtn">Search</button>
</form>

<form action="" id="exportForm" method="post" target="">
    <select name="fileType" id="fileType" class="form-control" style="width:160px;">
        <!-- <option value="">--Select File Type--</option> -->
        <option value="pdfFile">PDF</option>
        <option value="excelFile">Excel</option>
    </select>
    <button type="submit" id="exportBtn" name="exportButton" class="btn btn-primary">Export</button>
</form>

<div style="max-height:400px;overflow-x:auto;overflow-y:auto;" class="brandTable">


    <table class="table text-white" style="font-size:10px;">
        <thead style="position:sticky;z-index:1;top:0;background-color:#FF3CAC">
            <tr>
                <th style="width:40px">S.No.</th>
                <th style="width:150px">Actions</th>
                <th style="width:250px">Brands</th>
                <th style="width:250px">Created By</th>
                <th>Created Date</th>
                <th>Brand Id</th>

            </tr>

        </thead>
        <tbody>
            <?php

            if (isset($_POST['brandSearchBtn'])) {
                extract($_POST);
                // echo $brandSearch;

                $_SESSION['searching_name'] = $brandSearch;




                // $objectbrand->setbrandsSearch($brandSearch);
                // echo "object = ".$objectbrand->getbrandsSearch();
                echo "<script>
        document.addEventListener('DOMContentLoaded', function(event) {
            event.preventDefault();
            document.getElementById('brandSearch').focus();
        });
      </script>";



                $querySearchBrand = "select*from brands where brand_name like '%$brandSearch%' && branch_id = '$userBranchId' order by brand_name";
                $resultSearchBrand = $con->query($querySearchBrand);



                if (isset($resultSearchBrand)) {
                    $i = 1;
                    while ($brandSearchData = $resultSearchBrand->fetch_assoc()) {

                        $searchUserName = "select user_name from user_master1 where id='$brandSearchData[user_id]'";
                        $resultUserName = $con->query($searchUserName)->fetch_assoc();




            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/brandMaster.php?updationid=<?php echo $brandSearchData['id']; ?>&brand=<?php echo $brandSearchData['brand_name']; ?>"
                        class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size:10px"></i></a>

                    <a id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/brandMaster.php?deletionid=<?php echo $brandSearchData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete<?php echo $brandSearchData['brand_name']; ?>?')"
                        class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash" style="font-size:10px"></i></a>
                </td>
                <td><?php echo $brandSearchData['brand_name']; ?></td>
                <td><?php echo $resultUserName['user_name']; ?></td>
                <td><?php echo date("d-m-Y h:i:s A", strtotime($brandSearchData['created_date'])); ?></td>
                <td><?php echo $brandSearchData['id'] ?></td>
            </tr>

            <?php }
                }
            } else {

                $i = 1;
                while ($brandData = $resFetchPro->fetch_assoc()) {
                    $searchUserName = "select user_name from user_master1 where id='$brandData[user_id]'";
                    $resultUserName = $con->query($searchUserName)->fetch_assoc();
                    ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/brandMaster.php?updationid=<?php echo $brandData['id']; ?>&brand=<?php echo $brandData['brand_name']; ?>"
                        class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size:10px"></i></a>
                    <a id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/brandMaster.php?deletionid=<?php echo $brandData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete <?php echo $brandData['brand_name']; ?>?')"
                        class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash" style="font-size:10px"></i></a>
                </td>
                <td><?php echo $brandData['brand_name']; ?></td>
                <td><?php echo $resultUserName['user_name']; ?></td>
                <td><?php echo date("d-m-Y h:i:s A", strtotime($brandData['created_date'])); ?></td>
                <td><?php echo $brandData['id']; ?></td>
            </tr>

            <?php }
            }; ?>

        </tbody>
    </table>
</div>
<?php include_once(DIR_URL . "/includes/footer.php"); ?>



<style>
.form-floating {
    padding-top: 0px;
    color: #2B86C5;
    font-size: 13px;

}

#brandName {
    width: 280px;
    font-size: 20px;
    font-weight: bold;
    /* text-transform: capitalize; */
    height: 50px;

}

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

#brandForm {
    position: absolute;
    top: 120px;
    left: 300px;
    width: 500px;
}

.brandSearchForm {
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

#brandName {
    width: 270px;
}

.brandTable {

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
document.getElementById("brandName").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("submitbrandBtn").focus();
    }
});
document.getElementById("brandName").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("updateBrandBtn").focus();
    }
})
window.onload = function() {
    document.getElementById("brandName").focus();
    document.getElementById("brandName").select();

}


document.getElementById("brandSearch").addEventListener('keypress', function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("brandSearchBtn").focus();
    }
})

// document.getElementById("brandSearchBtn").addEventListener('keypress', function(event){

// if(event.key === "Enter"){
//     event.preventDefault();
//     document.getElementById("brandSearchBtn").focus();
// }
// })

// document.addEventListener("DOMContentLoaded", function () {
//     document.getElementById("editButton").addEventListener("click", function (event) {
//         event.preventDefault(); // Prevent the default anchor behavior
//         document.getElementById("brandName").focus(); // Focus the input field
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