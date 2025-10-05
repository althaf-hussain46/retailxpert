<style>
#updateColorBtn {
    visibility: hidden;
}

#backColorBtn {
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
    if ($_SESSION['color_form_create'] == 0) {
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let submitBtn = document.getElementById('submitColorBtn');
    if (submitBtn) {
        submitBtn.setAttribute('disabled', true);
    }

});
</script>

<?php } ?>
<?php

    if ($_SESSION['color_form_reprint'] == 0) {
    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {

    let colorSearchBtn = document.getElementById("colorSearchBtn");
    if (colorSearchBtn) {
        colorSearchBtn.setAttribute('disabled', true)
    }

    let colorSearch = document.getElementById("colorSearch");
    if (colorSearch) {
        colorSearch.setAttribute('disabled', true)
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

    if ($_SESSION['color_form_update'] == 0) {
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

    if ($_SESSION['color_form_delete'] == 0) {
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
// include_once(DIR_URL."/exportFile/pdfFileFormat.php");
$_SESSION['table_name'] = "colors";
$_SESSION['field_name'] = "color_name";


$userBranchId = $_SESSION['user_branch_id'];
$userId = $_SESSION['user_id'];



$color  = "";
$id = "";



if (isset($_POST['exportButton'])) {
    extract($_POST);
    if ($fileType == "pdfFile") {
        $_SESSION['report_title'] = "Colors Report";
        $_SESSION['header_title'] = "Color Name";

        header("Location:" . BASE_URL . "/exportFile/pdfFileFormat.php");
    } elseif ($fileType == "excelFile") {
        $_SESSION['report_title'] = "Colors Report";
        $_SESSION['header_title'] = "Color Name";
        header("Location:" . BASE_URL . "/exportFile/excelFileFormat.php");
    } else {
        echo "Please Select File Type";
    }
}


// if (isset($_GET['deletionId'])) {
//     extract($_GET);
//     $queryDeleteColor = "delete from colors where id='$deletionId'";
//     $resultDeleteColor = $con->query($queryDeleteColor);
//     if ($resultDeleteColor) {
//         $_SESSION['success'] = "Color Deleted Successfully";
//         header("Location:" . BASE_URL . "/pages/colorMaster.php");
//         exit;
//     } else {
//         $_SESSION['failure'] = "Oops! Something Went Wrong";
//     }
// }

if (isset($_GET['deletionId'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Start the transaction
        $con->begin_transaction();

        // Get the ID
        $deletionId = $_GET['deletionId'];

        // Prepare the DELETE statement
        $queryDeleteColor = "DELETE FROM colors WHERE id = ?";
        $stmtDelete = $con->prepare($queryDeleteColor);
        $stmtDelete->bind_param("i", $deletionId);

        // Execute the DELETE
        if ($stmtDelete->execute()) {
            $con->commit(); // Commit on success
            $_SESSION['success'] = "Color Deleted Successfully";
            header("Location:" . BASE_URL . "/pages/colorMaster.php");
            exit;
        } else {
            $con->rollback(); // Rollback on failure
            $_SESSION['failure'] = "Failed to delete color. Please try again.";
        }
    } catch (mysqli_sql_exception $e) {
        $con->rollback(); // Rollback on exception
        $_SESSION['failure'] = "Error during deletion: " . $e->getMessage();
    } finally {
        if (isset($stmtDelete)) $stmtDelete->close();
    }
}


if (isset($_GET['updationId']) && isset($_GET['color'])) {

    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract GET data
        extract($_GET);

        if (isset($_POST['updateColor'])) {
            // Extract POST data
            extract($_POST);

            if (!empty($colorName)) {
                // Prepare the query to prevent SQL injection
                $querySearchColor = "select*from colors where color_name = '$colorName'
                                    and branch_id = '$userBranchId' and id !='$updationId'";
                $resultSearchColor = $con->query($querySearchColor);

                if ($resultSearchColor->num_rows == 0) {
                    $qryUpdateColor = "UPDATE colors SET color_name = ?, user_id = ?, branch_id = ? WHERE id = ?";
                    $stmt = $con->prepare($qryUpdateColor);
                    $stmt->bind_param("siii", $colorName, $userId, $userBranchId, $updationId);

                    // Execute the query
                    if ($stmt->execute()) {
                        $con->commit();
                        $_SESSION['success'] = "Color Updated Successfully";
                        header("Location:" . BASE_URL . "/pages/colorMaster.php");
                        exit;
                    } else {
                        $con->rollback();
                        $_SESSION['failure'] = "Failed to update Color. Please try again.";
                    }
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Color Already Exist! Cannot Create A Duplicate";
                }
            } else {
                $_SESSION['failure'] = "Color Name cannot be empty.";
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Check for specific SQL errors like duplicate entry
        $con->rollback();
        if ($e->getCode() == 1062) {
            $_SESSION['failure'] = "Color name '$colorName' already exists. Please enter a different Color name.";
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
#submitColorBtn {
    visibility: hidden;
}

#closeColorBtn {
    visibility: hidden;
}


#updateColorBtn {
    visibility: visible;

}

#backColorBtn {
    visibility: visible;

}
</style>
<!-- <script>
let pro = document.getElementById("updateColorBtn");
pro.style.visibility = "visible";
</script> -->
<?php } ?>

<?php

if (isset($_POST['submitColor'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract form data
        extract($_POST);

        if (!empty($colorName)) {
            // Prepare the query to prevent SQL injection

            $querySearchColor = "select*from colors where color_name = '$colorName'
                                    and branch_id = '$userBranchId'";
            $resultSearchColor = $con->query($querySearchColor);

            if ($resultSearchColor->num_rows == 0) {
                $qryCrtPro = "INSERT INTO colors (color_name, user_id, branch_id) VALUES(?,?,?)";
                $stmt = $con->prepare($qryCrtPro);
                $stmt->bind_param("sii", $colorName, $userId, $userBranchId);

                // Execute the query
                if ($stmt->execute()) {
                    $con->commit();
                    $_SESSION['success'] = "Color Created Successfully";
                    header("Location:" . BASE_URL . "/pages/colorMaster.php");
                    exit;
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Failed to create color. Please try again.";
                }
            } else {
                $con->rollback();
                $_SESSION['failure'] = "Color Already Exist! Cannot Create A Duplicate";
            }
        } else {
            $_SESSION['failure'] = "Color Name cannot be empty.";
        }
    } catch (mysqli_sql_exception $e) {
        // Check if it's a duplicate entry error\
        $con->rollback();
        if ($e->getCode() == 1062) { // Error code for duplicate entry
            $_SESSION['failure'] = "Color Name '$colorName' already exists. Please enter a different color name.";
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



// if(isset($_POST['submitColor'])){

//     extract($_POST);
//     $qryCrtPro = "insert into colors (color_name) values('$colorName')";
//     $resCrtPro  = $con->query($qryCrtPro);

//     if($resCrtPro){
//         $_SESSION['success'] = "color Created Successfully";
//     }else{
//         $_SESSION['failure'] = "Oops! Something Went Wrong";
//     }


// }




$qryFetchPro = "select*from colors where branch_id = '$userBranchId'  order by color_name";
$resFetchColor = $con->query($qryFetchPro);


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
<form action="" id="colorForm" method="post">
    <h3 style="text-align:left;font-family:Verdana, Geneva, Tahoma, sans-serif;"><span style="font-weight:bolder">Manage
        </span><span style="font-size:medium;font-weight:bold;color:gray;">Color</span></h3>
    <hr>

    <div class="form-floating">
        <input type="text" name="colorName" autocomplete="off" id="colorName" class="form-control"
            placeholder="Color Name" value="<?php echo $color; ?>" maxlength="30">
        <label for="form-floating">Color Name</label>
    </div>


    <hr>
    <div style="display:flex; gap:150px;margin-top:-10px;" id="beforeEditPress">
        <button type="submit" name="submitColor" id="submitColorBtn" class="btn btn-primary"
            style="width:120px;">Submit</button>
        <a href="<?php echo BASE_URL; ?>/pages/homePage.php" id="closeColorBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Close</a>
    </div>

    <div style="display:flex;gap:150px;margin-top:-38px;" id="afterEditPress">
        <button type="submit" name="updateColor" id="updateColorBtn" class="btn btn-primary"
            style="width:120px;">Update</button>
        <a href="<?php echo BASE_URL; ?>/pages/colorMaster.php" id="backColorBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Back</a>
    </div>

    <hr>
</form>




<form action="" class="colorSearchForm" style="margin-top:-20px;" method="post">
    <input type="text" class="form-control" name="colorSearch" autocomplete="off" id="colorSearch"
        placeholder="Search color">
    <button type="submit" class="btn btn-success" name="colorSearchBtn" id="colorSearchBtn">Search</button>
</form>

<form action="" id="exportForm" method="post" target="">
    <select name="fileType" id="fileType" class="form-control" style="width:160px;">
        <!-- <option value="">--Select File Type--</option> -->
        <option value="pdfFile">PDF</option>
        <option value="excelFile">Excel</option>
    </select>
    <button type="submit" id="exportBtn" name="exportButton" class="btn btn-primary">Export</button>
</form>

<div style="max-height:400px;overflow-x:auto;overflow-y:auto;" class="colorTable">


    <table class="table text-white" style="font-size:10px;">
        <thead style="position:sticky;z-index:1;top:0;background-color:#FF3CAC">
            <tr>
                <th style="width:40px">S.No.</th>
                <th style="width:150px">Actions</th>
                <th style="width:250px">Colors</th>
                <th style="width:250px">Created By</th>
                <th>Created Date</th>
                <th>Color Id</th>

            </tr>

        </thead>
        <tbody>
            <?php

            if (isset($_POST['colorSearchBtn'])) {
                extract($_POST);
                // echo $colorSearch;
                $_SESSION['color_name'] = $colorSearch;
                $_SESSION['searching_name']  = $colorSearch;
                // $objectcolor->setcolorsSearch($colorSearch);
                // echo "object = ".$objectcolor->getcolorsSearch();
                echo "<script>
        document.addEventListener('DOMContentLoaded', function(event) {
            event.preventDefault();
            document.getElementById('colorSearch').focus();
        });
      </script>";



                $querySearchcolor = "select*from colors where color_name like '%$colorSearch%' && branch_id = '$userBranchId' order by color_name";
                $resultSearchcolor = $con->query($querySearchcolor);



                if (isset($resultSearchcolor)) {
                    $i = 1;
                    while ($colorSearchData = $resultSearchcolor->fetch_assoc()) {

                        $searchUserName = "select user_name from user_master1 where id='$colorSearchData[user_id]'";
                        $resultUserName = $con->query($searchUserName)->fetch_assoc();



            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/colorMaster.php?updationId=<?php echo $colorSearchData['id']; ?>&color=<?php echo $colorSearchData['color_name']; ?>"
                        class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size:10px;"></i></a>

                    <a id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/colorMaster.php?deletionId=<?php echo $colorSearchData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete <?php echo $colorSearchData['color_name']; ?>?')"
                        class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash" style="font-size:10px;"></i></a>
                </td>
                <td><?php echo $colorSearchData['color_name']; ?></td>
                <td><?php echo $resultUserName['user_name']; ?></td>
                <td><?php echo date("d-m-Y h:i:s A", strtotime($colorSearchData['created_date'])); ?></td>
                <td><?php echo $colorSearchData['id'] ?></td>
            </tr>

            <?php }
                }
            } else {
                $i = 1;
                while ($colorData = $resFetchColor->fetch_assoc()) {
                    $searchUserName = "select user_name from user_master1 where id='$colorData[user_id]'";
                    $resultUserName = $con->query($searchUserName)->fetch_assoc();
                    ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/colorMaster.php?updationId=<?php echo $colorData['id']; ?>&color=<?php echo $colorData['color_name']; ?>"
                        class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size:10px;"></i></a>

                    <a id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/colorMaster.php?deletionId=<?php echo $colorData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete <?php echo $colorData['color_name']; ?>?')"
                        class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash" style="font-size:10px;"></i></a>
                </td>
                <td><?php echo $colorData['color_name']; ?></td>
                <td><?php echo $resultUserName['user_name']; ?></td>
                <td><?php echo date("d-m-Y h:i:s A", strtotime($colorData['created_date'])); ?></td>
                <td><?php echo $colorData['id'] ?></td>
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

#colorName {
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

#colorForm {
    position: absolute;
    top: 120px;
    left: 300px;
    width: 500px;
}

.colorSearchForm {
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

#colorName {
    width: 270px;
}

.colorTable {

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
document.getElementById("colorName").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("submitColorBtn").focus();
    }
});
document.getElementById("colorName").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("updateColorBtn").focus();
    }
})
window.onload = function() {
    document.getElementById("colorName").focus();
    document.getElementById("colorName").select();

}


document.getElementById("colorSearch").addEventListener('keypress', function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("colorSearchBtn").focus();
    }
})

// document.getElementById("colorSearchBtn").addEventListener('keypress', function(event){

// if(event.key === "Enter"){
//     event.preventDefault();
//     document.getElementById("colorSearchBtn").focus();
// }
// })

// document.addEventListener("DOMContentLoaded", function () {
//     document.getElementById("editButton").addEventListener("click", function (event) {
//         event.preventDefault(); // Prevent the default anchor behavior
//         document.getElementById("colorName").focus(); // Focus the input field
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