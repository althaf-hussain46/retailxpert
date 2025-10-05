<style>
#updateHsnCodeBtn {
    visibility: hidden;
}

#backhsnCodeBtn {
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
    if ($_SESSION['hsn_form_create'] == 0) {
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let submitBtn = document.getElementById('submithsnCodeBtn');
    if (submitBtn) {
        submitBtn.setAttribute('disabled', true);
    }

});
</script>

<?php } ?>
<?php

    if ($_SESSION['hsn_form_reprint'] == 0) {
    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {

    let hsnCodeSearchBtn = document.getElementById("hsnCodeSearchBtn");
    if (hsnCodeSearchBtn) {
        hsnCodeSearchBtn.setAttribute('disabled', true)
    }

    let hsnCodeSearch = document.getElementById("hsnCodeSearch");
    if (hsnCodeSearch) {
        hsnCodeSearch.setAttribute('disabled', true)
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

    if ($_SESSION['hsn_form_update'] == 0) {
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

    if ($_SESSION['hsn_form_delete'] == 0) {
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
$_SESSION['table_name'] = "hsn_codes";
$_SESSION['field_name'] = "hsn_code";


$userBranchId = $_SESSION['user_branch_id'];
$userId = $_SESSION['user_id'];

$hsnCode  = "";
$id = "";



if (isset($_POST['exportButton'])) {
    extract($_POST);
    if ($fileType == "pdfFile") {
        $_SESSION['report_title'] = "HSN Codes Report";
        $_SESSION['header_title'] = "HSN Code ";

        header("Location:" . BASE_URL . "/exportFile/pdfFileFormat.php");
    } elseif ($fileType == "excelFile") {
        $_SESSION['report_title'] = "HSN Codes Report";
        $_SESSION['header_title'] = "HSN Code ";
        header("Location:" . BASE_URL . "/exportFile/excelFileFormat.php");
    } else {
        echo "Please Select File Type";
    }
}


// if(isset($_GET['deletionId'])){
// extract($_GET);
// $queryDeleteHsnCode = "delete from hsn_codes where id='$deletionId'";
// $resultDeleteHsnCode = $con->query($queryDeleteHsnCode);
// if($resultDeleteHsnCode){
//     $_SESSION['success'] = "HSN Code Deleted Successfully";
//     header("Location:".BASE_URL."/pages/hsnCodeMaster.php");
//     exit;
// }else{
//     $_SESSION['failure'] = "Oops! Something Went Wrong";
// }

// }
if (isset($_GET['deletionId'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        // Start a transaction
        $con->begin_transaction();

        // Get the deletion ID from GET
        $deletionId = $_GET['deletionId'];

        // Prepare the DELETE statement
        $queryDeleteHsnCode = "DELETE FROM hsn_codes WHERE id = ?";
        $stmtDelete = $con->prepare($queryDeleteHsnCode);
        $stmtDelete->bind_param("i", $deletionId);

        // Execute the query
        if ($stmtDelete->execute()) {
            $con->commit(); //  Commit on success
            $_SESSION['success'] = "HSN Code Deleted Successfully";
            header("Location:" . BASE_URL . "/pages/hsnCodeMaster.php");
            exit;
        } else {
            $con->rollback(); //  Rollback on failure
            $_SESSION['failure'] = "Failed to delete HSN code. Please try again.";
        }
    } catch (mysqli_sql_exception $e) {
        $con->rollback(); // Rollback on error
        $_SESSION['failure'] = "Error during deletion: " . $e->getMessage();
    } finally {
        if (isset($stmtDelete)) $stmtDelete->close();
    }
}



if (isset($_GET['updationId']) && isset($_GET['hsnCode'])) {

    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract GET data
        extract($_GET);

        if (isset($_POST['updateHsnCode'])) {
            // Extract POST data
            extract($_POST);

            if (!empty($hsnCode)) {
                // Prepare the query to prevent SQL injection

                $querySearchHsn = "select*from hsn_codes where hsn_code = '$hsnCode'
                                    and branch_id = '$userBranchId' and id !='$updationId'";
                $resultSearchHsn = $con->query($querySearchHsn);

                if ($resultSearchHsn->num_rows == 0) {
                    $qryUpdateHsnCode = "UPDATE hsn_codes SET hsn_code = ?, user_id = ?, branch_id = ?  WHERE id = ?";
                    $stmt = $con->prepare($qryUpdateHsnCode);
                    $stmt->bind_param("siii", $hsnCode, $userId, $userBranchId, $updationId);

                    // Execute the query
                    if ($stmt->execute()) {
                        $con->commit();
                        $_SESSION['success'] = "HSN Code Updated Successfully";
                        header("Location:" . BASE_URL . "/pages/hsnCodeMaster.php");
                        exit;
                    } else {
                        $con->rollback();
                        $_SESSION['failure'] = "Failed to update HSN Code. Please try again.";
                    }
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "HSN Already Exist! Cannot Create A Duplicate";
                }
            } else {
                $_SESSION['failure'] = "HSN Code cannot be empty.";
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Check for specific SQL errors like duplicate entry
        $con->rollback();
        if ($e->getCode() == 1062) {
            $_SESSION['failure'] = "HSN Code '$hsnCode' already exists. Please enter a different HSN Code.";
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
#submithsnCodeBtn {
    visibility: hidden;
}

#closehsnCodeBtn {
    visibility: hidden;
}


#updateHsnCodeBtn {
    visibility: visible;

}

#backhsnCodeBtn {
    visibility: visible;

}
</style>
<!-- <script>
let pro = document.getElementById("updateHsnCodeBtn");
pro.style.visibility = "visible";
</script> -->
<?php } ?>

<?php

if (isset($_POST['submithsnCode'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract form data
        extract($_POST);

        if (!empty($hsnCode)) {
            // Prepare the query to prevent SQL injection
            $querySearchHsn = "select*from hsn_codes where hsn_code = '$hsnCode'
                                    and branch_id = '$userBranchId'";
            $resultSearchHsn = $con->query($querySearchHsn);

            if ($resultSearchHsn->num_rows == 0) {
                $qryCrtPro = "INSERT INTO hsn_codes (hsn_code, user_id, branch_id) VALUES(?,?,?)";
                $stmt = $con->prepare($qryCrtPro);
                $stmt->bind_param("sii", $hsnCode, $userId, $userBranchId);

                // Execute the query
                if ($stmt->execute()) {
                    $con->commit();
                    $_SESSION['success'] = "HSN Code Created Successfully";
                    header("Location:" . BASE_URL . "/pages/hsnCodeMaster.php");
                    exit;
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Failed to create HSN Code. Please try again.";
                }
            } else {
                $con->rollback();
                $_SESSION['failure'] = "HSN Already Exist! Cannot Create A Duplicate";
            }
        } else {
            $_SESSION['failure'] = "HSN Code  cannot be empty.";
        }
    } catch (mysqli_sql_exception $e) {
        // Check if it's a duplicate entry error
        $con->rollback();
        if ($e->getCode() == 1062) { // Error code for duplicate entry
            $_SESSION['failure'] = "HSN Code  '$hsnCode' already exists. Please enter a different HSN Code.";
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



// if(isset($_POST['submithsnCode'])){

//     extract($_POST);
//     $qryCrtPro = "insert into hsnCodes (hsnCode_name) values('$hsnCode')";
//     $resCrtPro  = $con->query($qryCrtPro);

//     if($resCrtPro){
//         $_SESSION['success'] = "hsnCode Created Successfully";
//     }else{
//         $_SESSION['failure'] = "Oops! Something Went Wrong";
//     }


// }




$qryFetchPro = "select*from hsn_codes where branch_id = '$userBranchId' order by hsn_code";
$resFetchHSN = $con->query($qryFetchPro);


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
<form action="" id="hsnCodeForm" method="post">
    <h3 style="text-align:left;font-family:Verdana, Geneva, Tahoma, sans-serif;"><span style="font-weight:bolder">Manage
        </span><span style="font-size:medium;font-weight:bold;color:gray;">HSN Code</span></h3>
    <hr>
    <div class="form-floating">
        <input type="text" name="hsnCode" autocomplete="off" id="hsnCode" class="form-control" placeholder="HSN Code"
            value="<?php echo $hsnCode; ?>" maxlength="8">
        <label for="form-floating">HSN Code</label>
    </div>



    <hr>
    <div style="display:flex; gap:150px;margin-top:-10px;" id="beforeEditPress">
        <button type="submit" name="submithsnCode" id="submithsnCodeBtn" class="btn btn-primary"
            style="width:120px;">Submit</button>
        <a href="<?php echo BASE_URL; ?>/pages/homePage.php" id="closehsnCodeBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Close</a>
    </div>

    <div style="display:flex;gap:150px;margin-top:-38px;" id="afterEditPress">
        <button type="submit" name="updateHsnCode" id="updateHsnCodeBtn" class="btn btn-primary"
            style="width:120px;">Update</button>
        <a href="<?php echo BASE_URL; ?>/pages/hsnCodeMaster.php" id="backhsnCodeBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Back</a>
    </div>

    <hr>
</form>




<form action="" class="hsnCodeSearchForm" style="margin-top:-20px;" method="post">
    <input type="text" class="form-control" name="hsnCodeSearch" autocomplete="off" id="hsnCodeSearch"
        placeholder="Search HSN Code">
    <button type="submit" class="btn btn-success" name="hsnCodeSearchBtn" id="hsnCodeSearchBtn">Search</button>
</form>

<form action="" id="exportForm" method="post" target="">
    <select name="fileType" id="fileType" class="form-control" style="width:160px;">
        <!-- <option value="">--Select File Type--</option> -->
        <option value="pdfFile">PDF</option>
        <option value="excelFile">Excel</option>
    </select>
    <button type="submit" id="exportBtn" name="exportButton" class="btn btn-primary">Export</button>
</form>

<div style="max-height:400px;overflow-x:auto;overflow-y:auto;" class="hsnCodeTable">


    <table class="table text-white" style="font-size:10px;">
        <thead style="position:sticky;z-index:1;top:0;background-color:#FF3CAC">
            <tr>
                <th style="width:40px">S.No.</th>
                <th style="width:150px">Actions</th>
                <th style="width:250px">HSN Codes</th>
                <th style="width:250px">Created By</th>
                <th>Created Date</th>
                <th>HSN Code Id</th>
            </tr>

        </thead>
        <tbody>
            <?php

            if (isset($_POST['hsnCodeSearchBtn'])) {
                extract($_POST);
                // echo $hsnCodeSearch;
                $_SESSION['hsnCode_name'] = $hsnCodeSearch;
                $_SESSION['searching_name']  = $hsnCodeSearch;
                // $objecthsnCode->sethsnCodesSearch($hsnCodeSearch);
                // echo "object = ".$objecthsnCode->gethsnCodesSearch();
                echo "<script>
        document.addEventListener('DOMContentLoaded', function(event) {
            event.preventDefault();
            document.getElementById('hsnCodeSearch').focus();
        });
      </script>";



                $querySearchhsnCode = "select*from hsn_codes where hsn_code like '%$hsnCodeSearch%' && branch_id = '$userBranchId' order by hsn_code";
                $resultSearchhsnCode = $con->query($querySearchhsnCode);



                if (isset($resultSearchhsnCode)) {
                    $i = 1;
                    while ($hsnCodeSearchData = $resultSearchhsnCode->fetch_assoc()) {
                        $searchUserName = "select user_name from user_master1 where id='$hsnCodeSearchData[user_id]'";
                        $resultUserName = $con->query($searchUserName)->fetch_assoc();




            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/hsnCodeMaster.php?updationId=<?php echo $hsnCodeSearchData['id']; ?>&hsnCode=<?php echo $hsnCodeSearchData['hsn_code']; ?>"
                        class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size:10px;"></i></a>

                    <a id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/hsnCodeMaster.php?deletionId=<?php echo $hsnCodeSearchData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete <?php echo $hsnCodeSearchData['hsn_code']; ?>?')"
                        class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash" style="font-size:10px;"></i></a>
                </td>
                <td><?php echo $hsnCodeSearchData['hsn_code']; ?></td>
                <td><?php echo $resultUserName['user_name']; ?></td>
                <td><?php echo date("d-m-Y h:i:s A", strtotime($hsnCodeSearchData['created_date'])); ?></td>
                <td><?php echo $hsnCodeSearchData['id'] ?></td>
            </tr>

            <?php }
                }
            } else {
                $i = 1;
                while ($hsnCodeSearchData = $resFetchHSN->fetch_assoc()) {
                    $searchUserName = "select user_name from user_master1 where id='$hsnCodeSearchData[user_id]'";
                    $resultUserName = $con->query($searchUserName)->fetch_assoc();
                    ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/hsnCodeMaster.php?updationId=<?php echo $hsnCodeSearchData['id']; ?>&hsnCode=<?php echo $hsnCodeSearchData['hsn_code']; ?>"
                        class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size:10px;"></i></a>

                    <a id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/hsnCodeMaster.php?deletionId=<?php echo $hsnCodeSearchData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete <?php echo $hsnCodeSearchData['hsn_code']; ?>?')"
                        class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash" style="font-size:10px;"></i></a>
                </td>
                <td><?php echo $hsnCodeSearchData['hsn_code']; ?></td>
                <td><?php echo $resultUserName['user_name']; ?></td>
                <td><?php echo date("d-m-Y h:i:s A", strtotime($hsnCodeSearchData['created_date'])); ?></td>
                <td><?php echo $hsnCodeSearchData['id'] ?></td>
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

#hsnCode {
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

#hsnCodeForm {
    position: absolute;
    top: 120px;
    left: 300px;
    width: 500px;
}

.hsnCodeSearchForm {
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

#hsnCode {
    width: 270px;
}

.hsnCodeTable {

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
document.getElementById("hsnCode").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("submithsnCodeBtn").focus();
    }
});
document.getElementById("hsnCode").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("updateHsnCodeBtn").focus();
    }
})
window.onload = function() {
    document.getElementById("hsnCode").focus();
    document.getElementById("hsnCode").select();

}


document.getElementById("hsnCodeSearch").addEventListener('keypress', function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("hsnCodeSearchBtn").focus();
    }
})

// document.getElementById("hsnCodeSearchBtn").addEventListener('keypress', function(event){

// if(event.key === "Enter"){
//     event.preventDefault();
//     document.getElementById("hsnCodeSearchBtn").focus();
// }
// })

// document.addEventListener("DOMContentLoaded", function () {
//     document.getElementById("editButton").addEventListener("click", function (event) {
//         event.preventDefault(); // Prevent the default anchor behavior
//         document.getElementById("hsnCode").focus(); // Focus the input field
//     });
// });

document.getElementById('hsnCode').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('hsnCode').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
});


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