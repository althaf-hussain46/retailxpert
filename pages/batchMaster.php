<style>
#updateBatchBtn {
    visibility: hidden;
}

#backBatchBtn {
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
    if ($_SESSION['batch_form_create'] == 0) {
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let submitBtn = document.getElementById('submitBatchBtn');
    if (submitBtn) {
        submitBtn.setAttribute('disabled', true);
    }

});
</script>

<?php } ?>
<?php

    if ($_SESSION['batch_form_reprint'] == 0) {
    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {

    let batchSearchBtn = document.getElementById("batchSearchBtn");
    if (batchSearchBtn) {
        batchSearchBtn.setAttribute('disabled', true)
    }

    let batchSearch = document.getElementById("batchSearch");
    if (batchSearch) {
        batchSearch.setAttribute('disabled', true)
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

    if ($_SESSION['batch_form_update'] == 0) {
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

    if ($_SESSION['batch_form_delete'] == 0) {
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
$_SESSION['table_name'] = "batches";
$_SESSION['field_name'] = "batch_name";

$userBranchId = $_SESSION['user_branch_id'];
$userId = $_SESSION['user_id'];

$batch  = "";
$id = "";



if (isset($_POST['exportButton'])) {
    extract($_POST);
    if ($fileType == "pdfFile") {
        $_SESSION['report_title'] = "Batches Report";
        $_SESSION['header_title'] = "Batch Name";

        header("Location:" . BASE_URL . "/exportFile/pdfFileFormat.php");
        // pdfFormat($_SESSION['batch_name'],$con);



        // echo "hello = ".$objectbatch->getbatchsSearch();
        // header("Location:".BASE_URL."exportFile/pdfFileFormat.php");

    } elseif ($fileType == "excelFile") {
        $_SESSION['report_title'] = "Batches Report";
        $_SESSION['header_title'] = "Batch Name";
        header("Location:" . BASE_URL . "/exportFile/excelFileFormat.php");
    } else {
        echo "Please Select File Type";
    }
}


// if (isset($_GET['deletionid'])) {
//     extract($_GET);
//     $queryDeletebatch = "delete from batches where id='$deletionid'";
//     $resultDeletebatch = $con->query($queryDeletebatch);
//     if ($resultDeletebatch) {
//         $_SESSION['success'] = "Batch Deleted Successfully";
//         header("Location:" . BASE_URL . "/pages/batchMaster.php");
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

        // Get the ID from the request
        $deletionid = $_GET['deletionid'];

        // Prepare the DELETE statement
        $queryDeleteBatch = "DELETE FROM batches WHERE id = ?";
        $stmtDelete = $con->prepare($queryDeleteBatch);
        $stmtDelete->bind_param("i", $deletionid);

        // Execute the DELETE query
        if ($stmtDelete->execute()) {
            $con->commit(); //  Commit if successful
            $_SESSION['success'] = "Batch Deleted Successfully";
            header("Location:" . BASE_URL . "/pages/batchMaster.php");
            exit;
        } else {
            $con->rollback(); //  Rollback on failure
            $_SESSION['failure'] = "Failed to delete batch. Please try again.";
        }
    } catch (mysqli_sql_exception $e) {
        $con->rollback(); // Rollback on any DB error
        $_SESSION['failure'] = "Error during deletion: " . $e->getMessage();
    } finally {
        if (isset($stmtDelete)) $stmtDelete->close();
    }
}




if (isset($_GET['updationid']) && isset($_GET['batch'])) {

    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract GET data
        extract($_GET);

        if (isset($_POST['updateBatch'])) {
            // Extract POST data
            extract($_POST);

            if (!empty($batchName)) {


                // Prepare the query to prevent SQL injection

                $querySearchBatch = "select*from batches where batch_name = '$batchName'
                                    and branch_id = '$userBranchId' and id !='$updationid'";
                $resultSearchBatch = $con->query($querySearchBatch);

                if ($resultSearchBatch->num_rows == 0) {

                    $qryupdateBatch = "UPDATE batches SET batch_name = ?, user_id = ?, branch_id = ? WHERE id = ?";
                    $stmt = $con->prepare($qryupdateBatch);
                    $stmt->bind_param("siii", $batchName, $userId, $userBranchId, $updationid);

                    // Execute the query
                    if ($stmt->execute()) {
                        $con->commit();
                        $_SESSION['success'] = "Batch Updated Successfully";
                        header("Location:" . BASE_URL . "/pages/batchMaster.php");
                        exit;
                    } else {
                        $con->rollback();
                        $_SESSION['failure'] = "Failed to update Batch. Please try again.";
                    }
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Batch Already Exist! Cannot Create A Duplicate";
                }
            } else {
                $_SESSION['failure'] = "Batch Name cannot be empty.";
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Check for specific SQL errors like duplicate entry
        $con->rollback();
        if ($e->getCode() == 1062) {
            $_SESSION['failure'] = "Batch name '$batchName' already exists. Please enter a different Batch name.";
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
#submitBatchBtn {
    visibility: hidden;
}

#closeBatchBtn {
    visibility: hidden;
}


#updateBatchBtn {
    visibility: visible;

}

#backBatchBtn {
    visibility: visible;

}
</style>
<!-- <script>
let pro = document.getElementById("updateBatchBtn");
pro.style.visibility = "visible";
</script> -->
<?php } ?>

<?php

if (isset($_POST['submitBatch'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract form data
        extract($_POST);

        if (!empty($batchName)) {
            // Prepare the query to prevent SQL injection
            $querySearchBatch = "select*from batches where batch_name = '$batchName'
                                    and branch_id = '$userBranchId'";
            $resultSearchBatch = $con->query($querySearchBatch);

            if ($resultSearchBatch->num_rows == 0) {
                $qryCrtPro = "INSERT INTO batches (batch_name,user_id,branch_id) VALUES(?,?,?)";
                $stmt = $con->prepare($qryCrtPro);
                $stmt->bind_param("sii", $batchName, $userId, $userBranchId);

                // Execute the query
                if ($stmt->execute()) {
                    $con->commit();
                    $_SESSION['success'] = "Batch Created Successfully";
                    header("Location:" . BASE_URL . "/pages/batchMaster.php");
                    exit;
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Failed to create batch. Please try again.";
                }
            } else {
                $con->rollback();
                $_SESSION['failure'] = "Batch Already Exist! Cannot Create A Duplicate";
            }
        } else {
            $_SESSION['failure'] = "Batch Name cannot be empty.";
        }
    } catch (mysqli_sql_exception $e) {
        // Check if it's a duplicate entry error
        $con->rollback();
        if ($e->getCode() == 1062) { // Error code for duplicate entry
            $_SESSION['failure'] = "Batch name '$batchName' already exists. Please enter a different batch name.";
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



// if(isset($_POST['submitBatch'])){

//     extract($_POST);
//     $qryCrtPro = "insert into batchs (batch_name) values('$batchName')";
//     $resCrtPro  = $con->query($qryCrtPro);

//     if($resCrtPro){
//         $_SESSION['success'] = "batch Created Successfully";
//     }else{
//         $_SESSION['failure'] = "Oops! Something Went Wrong";
//     }


// }




$qryFetchPro = "select*from batches where branch_id = '$userBranchId' order by batch_name";
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
<form action="" id="batchForm" method="post">
    <h3 style="text-align:left;font-family:Verdana, Geneva, Tahoma, sans-serif;"><span style="font-weight:bolder">Manage
        </span><span style="font-size:medium;font-weight:bold;color:gray;">Batch</span></h3>
    <hr>
    <div class="form-floating">
        <input type="text" name="batchName" autocomplete="off" id="batchName" class="form-control"
            placeholder="Batch Name / Serial No." value="<?php echo $batch; ?>" maxlength="30">
        <label for="form-floating">Batch Name / Serial No.</label>
    </div>


    <hr>
    <div style="display:flex; gap:150px;margin-top:-10px;" id="beforeEditPress">
        <button type="submit" name="submitBatch" id="submitBatchBtn" class="btn btn-primary"
            style="width:120px;">Submit</button>
        <a href="<?php echo BASE_URL; ?>/pages/homePage.php" id="closeBatchBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Close</a>
    </div>

    <div style="display:flex;gap:150px;margin-top:-38px;" id="afterEditPress">
        <button type="submit" name="updateBatch" id="updateBatchBtn" class="btn btn-primary"
            style="width:120px;">Update</button>
        <a href="<?php echo BASE_URL; ?>/pages/batchMaster.php" id="backBatchBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Back</a>
    </div>

    <hr>
</form>




<form action="" class="batchSearchForm" style="margin-top:-20px;" method="post">
    <input type="text" class="form-control" name="batchSearch" autocomplete="off" id="batchSearch"
        placeholder="Search Batch">
    <button type="submit" class="btn btn-success" name="batchSearchBtn" id="batchSearchBtn">Search</button>
</form>

<form action="" id="exportForm" method="post" target="">
    <select name="fileType" id="fileType" class="form-control" style="width:160px;">
        <!-- <option value="">--Select File Type--</option> -->
        <option value="pdfFile">PDF</option>
        <option value="excelFile">Excel</option>
    </select>
    <button type="submit" id="exportBtn" name="exportButton" class="btn btn-primary">Export</button>
</form>

<div style="max-height:400px;overflow-x:auto;overflow-y:auto;" class="batchTable">


    <table class="table text-white" style="font-size:10px;">
        <thead style="position:sticky;z-index:1;top:0;background-color:#FF3CAC">
            <tr>
                <th style="width:40px">S.No.</th>
                <th style="width:150px">Actions</th>
                <th style="width:250px">Batch / Serial No.</th>
                <th style="width:250px">Created By</th>
                <th>Created Date</th>
                <th>Batch Id</th>
            </tr>

        </thead>
        <tbody>
            <?php

            if (isset($_POST['batchSearchBtn'])) {
                extract($_POST);
                // echo $batchSearch;
                $_SESSION['batch_name'] = $batchSearch;
                $_SESSION['searching_name']  = $batchSearch;
                // $objectbatch->setbatchsSearch($batchSearch);
                // echo "object = ".$objectbatch->getbatchsSearch();
                echo "<script>
        document.addEventListener('DOMContentLoaded', function(event) {
            event.preventDefault();
            document.getElementById('batchSearch').focus();
        });
      </script>";



                $querySearchbatch = "select*from batches where batch_name like '%$batchSearch%' && branch_id = '$userBranchId' order by batch_name";
                $resultSearchbatch = $con->query($querySearchbatch);



                if (isset($resultSearchbatch)) {
                    $i = 1;
                    while ($batchSearchData = $resultSearchbatch->fetch_assoc()) {

                        $searchUserName = "select user_name from user_master1 where id='$batchSearchData[user_id]'";
                        $resultUserName = $con->query($searchUserName)->fetch_assoc();



            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/batchMaster.php?updationid=<?php echo $batchSearchData['id']; ?>&batch=<?php echo $batchSearchData['batch_name']; ?>"
                        class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size:10px;"></i></a>

                    <a id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/batchMaster.php?deletionid=<?php echo $batchSearchData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete <?php echo $batchSearchData['batch_name']; ?>?')"
                        class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash" style="font-size:10px;"></i></a>
                </td>
                <td><?php echo $batchSearchData['batch_name']; ?></td>
                <td><?php echo $resultUserName['user_name']; ?></td>
                <td><?php echo date("d-m-Y h:i:s A", strtotime($batchSearchData['created_date'])); ?></td>
                <td><?php echo $batchSearchData['id'] ?></td>
            </tr>

            <?php }
                }
            } else {
                $i = 1;
                while ($batchSearchData = $resFetchPro->fetch_assoc()) {

                    $searchUserName = "select user_name from user_master1 where id='$batchSearchData[user_id]'";
                    $resultUserName = $con->query($searchUserName)->fetch_assoc();
                    ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/batchMaster.php?updationid=<?php echo $batchSearchData['id']; ?>&batch=<?php echo $batchSearchData['batch_name']; ?>"
                        class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size:10px;"></i></a>

                    <a id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/batchMaster.php?deletionid=<?php echo $batchSearchData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete <?php echo $batchSearchData['batch_name']; ?>?')"
                        class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash" style="font-size:10px;"></i></a>
                </td>
                <td><?php echo $batchSearchData['batch_name']; ?></td>
                <td><?php echo $resultUserName['user_name']; ?></td>
                <td><?php echo date("d-m-Y h:i:s A", strtotime($batchSearchData['created_date'])); ?></td>
                <td><?php echo $batchSearchData['id'] ?></td>
            </tr>
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

#batchName {
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

#batchForm {
    position: absolute;
    top: 120px;
    left: 300px;
    width: 500px;
}

.batchSearchForm {
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

#batchName {
    width: 270px;
}

.batchTable {

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
document.getElementById("batchName").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("submitBatchBtn").focus();
    }
});
document.getElementById("batchName").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("updateBatchBtn").focus();
    }
})
window.onload = function() {
    document.getElementById("batchName").focus();
    document.getElementById("batchName").select();

}


document.getElementById("batchSearch").addEventListener('keypress', function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("batchSearchBtn").focus();
    }
})

// document.getElementById("batchSearchBtn").addEventListener('keypress', function(event){

// if(event.key === "Enter"){
//     event.preventDefault();
//     document.getElementById("batchSearchBtn").focus();
// }
// })

// document.addEventListener("DOMContentLoaded", function () {
//     document.getElementById("editButton").addEventListener("click", function (event) {
//         event.preventDefault(); // Prevent the default anchor behavior
//         document.getElementById("batchName").focus(); // Focus the input field
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