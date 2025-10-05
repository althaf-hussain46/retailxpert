<style>
#updateTaxBtn {
    visibility: hidden;
}

#backTaxBtn {
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



$tax  = "";
$desc = "";
$per = "";
$branch = "";
$id = "";
// unset($_SESSION['searching_name']);

$_SESSION['table_name'] = "taxes";
$_SESSION['field_name'] = "tax_code";

$userBranchId = $_SESSION['user_branch_id'];
$userId = $_SESSION['user_id'];

$querySearchBranches = "select*from branches";
$resultSearchBranches = $con->query($querySearchBranches);

if (isset($_POST['exportButton'])) {
    extract($_POST);
    if ($fileType == "pdfFile") {
        $_SESSION['report_title'] = "Taxes Report";
        $_SESSION['header_title'] = "Tax Name";

        header("Location:" . BASE_URL . "/exportFile/pdfFileFormatTaxes.php");
    } elseif ($fileType == "excelFile") {
        $_SESSION['report_title'] = "Taxes Report";
        $_SESSION['header_title'] = "Tax Name";
        header("Location:" . BASE_URL . "/exportFile/excelFileFormatTaxes.php");
    } else {
        echo "Please Select File Type";
    }
}


// if(isset($_GET['deletionId'])){
// extract($_GET);
// $queryDeleteTax = "delete from taxes where id='$deletionId'";
// $resultDeleteTax = $con->query($queryDeleteTax);
// if($resultDeleteTax){
//     $_SESSION['success'] = "Tax Deleted Successfully";
//     header("Location:".BASE_URL."/pages/taxesMaster.php");
//     exit;
// }else{
//     $_SESSION['failure'] = "Oops! Something Went Wrong";
// }

// }

if (isset($_GET['deletionId'])) {
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $deletionId = $_GET['deletionId'];

        // Start transaction
        $con->begin_transaction();

        // Prepare and execute the delete query
        $stmtDeleteTax = $con->prepare("DELETE FROM taxes WHERE id = ?");
        $stmtDeleteTax->bind_param("i", $deletionId);
        $stmtDeleteTax->execute();

        // Commit transaction
        $con->commit();
        $_SESSION['success'] = "Tax Deleted Successfully";
        header("Location: " . BASE_URL . "/pages/taxesMaster.php");
        exit;
    } catch (mysqli_sql_exception $e) {
        // Rollback on error
        $con->rollback();
        $_SESSION['failure'] = "Oops! Something Went Wrong: " . $e->getMessage();
    } finally {
        if (isset($stmtDeleteTax)) $stmtDeleteTax->close();
    }
}


if (isset($_GET['updationId'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract GET data
        extract($_GET);
        $queryTaxSearch = "select*from taxes where id = '$updationId'";
        $resultTaxSearch = $con->query($queryTaxSearch)->fetch_assoc();
        $tax  = $resultTaxSearch['tax_code'];
        $desc  = $resultTaxSearch['tax_description'];
        $per = $resultTaxSearch['tax_percentage'];
        $branch = $resultTaxSearch['branch_id'];

        if (isset($_POST['updateTax'])) {
            // Extract POST data
            extract($_POST);

            if (!empty($taxCode)) {
                // Prepare the query to prevent SQL injection
                $queryCheckTaxUpdate = "select*from taxes where tax_code = '$taxCode' and tax_description = '$taxDesc' and tax_percentage = '$taxPer' and branch_id = '$branchName' and id !='$updationId'";
                $resultCheckTaxUpdate = $con->query($queryCheckTaxUpdate);

                if ($resultCheckTaxUpdate->num_rows == 0) {
                    $qryupdateTax = "UPDATE taxes SET tax_code = ?, tax_description = ?, tax_percentage = ?, user_id = ?, 
                branch_id = ? WHERE id = ?";
                    $stmt = $con->prepare($qryupdateTax);
                    $stmt->bind_param("ssdiii", $taxCode, $taxDesc, $taxPer, $userId, $userBranchId, $updationId);

                    // Execute the query
                    if ($stmt->execute()) {
                        $con->commit();
                        $_SESSION['success'] = "Tax Updated Successfully";
                        header("Location:" . BASE_URL . "/pages/taxesMaster.php");
                        exit;
                    } else {
                        $con->rollback();
                        $_SESSION['failure'] = "Failed to update tax. Please try again.";
                    }
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Already Exist. Connot Update";
                }
            } else {
                $_SESSION['failure'] = "Tax Name cannot be empty.";
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Check for specific SQL errors like duplicate entry
        $con->rollback();
        if ($e->getCode() == 1062) {
            $_SESSION['failure'] = "Tax Name '$taxCode' already exists. Please enter a different tax name.";
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
#submitTaxBtn {
    visibility: hidden;
}

#closetaxBtn {
    visibility: hidden;
}


#updateTaxBtn {
    visibility: visible;

}

#backTaxBtn {
    visibility: visible;

}
</style>
<!-- <script>
let pro = document.getElementById("updateTaxBtn");
pro.style.visibility = "visible";
</script> -->
<?php } ?>

<?php

if (isset($_POST['submitTax'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract form data
        extract($_POST);


        if (isset($taxCode) && isset($taxDesc) && isset($taxPer) && $taxCode !== '' && $taxDesc !== '' && $taxPer !== '') {
            echo $taxCode;
            echo $taxDesc;
            echo $taxPer;
            $queryCheckTax = "select*from taxes where tax_code = '$taxCode' and tax_description = '$taxDesc' and tax_percentage = '$taxPer' and branch_id = '$branchName'";
            $resultCheckTax = $con->query($queryCheckTax);

            if ($resultCheckTax->num_rows == 0) {
                $qryCrtPro = "INSERT INTO taxes (tax_code, tax_description, tax_percentage, user_id , branch_id) VALUES (?, ?, ?, ?, ?)";
                $stmt = $con->prepare($qryCrtPro);
                // $stmt->bind_param("ssdii", $taxCode, $taxDesc, $taxPer,$userId,$userBranchId);
                $stmt->bind_param("ssdii", $taxCode, $taxDesc, $taxPer, $userId, $branchName);



                // Execute the query
                if ($stmt->execute()) {
                    $con->commit();
                    $_SESSION['success'] = "Tax Created Successfully";
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Failed to create tax. Please try again.";
                }
            } else {
                $con->rollback();
                $_SESSION['failure'] = "Already Exist. Duplicate Entry Not Valid";
            }
            // Prepare the query to prevent SQL injection

        } else {
            $_SESSION['failure'] = "All fields are required.";
        }
    } catch (mysqli_sql_exception $e) {
        // Check if it's a duplicate entry error
        $con->rollback();
        if ($e->getCode() == 1062) { // Error code for duplicate entry
            $_SESSION['failure'] = "Tax Code '$taxCode' already exists. Please enter a different tax name.";
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



// if(isset($_POST['submitTax'])){

//     extract($_POST);
//     $qryCrtPro = "insert into taxes (tax_code) values('$taxCode')";
//     $resCrtPro  = $con->query($qryCrtPro);

//     if($resCrtPro){
//         $_SESSION['success'] = "tax Created Successfully";
//     }else{
//         $_SESSION['failure'] = "Oops! Something Went Wrong";
//     }


// }




$qryFetchTax = "select*from taxes order by  tax_code ";
// $resFetchTax = $con->query($qryFetchTax);
// $qryFetchTax = "select t.*,b.*
//                 from taxes as t
//                 join branches as b on b.id = t.branch_id
//                 order by t.tax_code";
$resFetchTax = $con->query($qryFetchTax);


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
<form action="" id="taxForm" method="post">
    <h3 style="text-align:left;font-family:Verdana, Geneva, Tahoma, sans-serif;"><span style="font-weight:bolder">Manage
        </span><span style="font-size:medium;font-weight:bold;color:gray;">Tax</span></h3>
    <hr>
    <!-- <span style="display:flex;gap:10px"> -->
    <div class="form-floating">
        <input type="text" name="taxCode" id="taxCode" class="form-control" placeholder="Tax Code" autocomplete="off"
            value="<?php echo $tax; ?>" maxlength="4">
        <label for="form-floating">Tax Code <span style="color:red;">*</span></label>
    </div>
    <div class="form-floating">
        <input type="text" name="taxDesc" id="taxDesc" class="form-control" placeholder="Tax Description"
            autocomplete="off" value="<?php echo $desc; ?>" maxlength="11">
        <label for="form-floating">Tax Description <span style="color:red;">*</span></label>
    </div>
    <div style="display:flex;gap:5px;">
        <div class="form-floating">
            <input type="text" name="taxPer" id="taxPer" class="form-control" placeholder="Tax %"
                value="<?php echo $per; ?>" autocomplete="off" maxlength="5">
            <label for="form-floating">Tax % <span style="color:red;">*</span></label>
        </div>
        <div class="form-floating">
            <select id="branchName" name="branchName" class="form-control">
                <?php
                while ($branchData = $resultSearchBranches->fetch_assoc()) {
                ?>
                <option value="<?php echo $branchData['id']; ?>"
                    <?php echo ($branchData['id'] == $branch) ? "selected" : ""; ?>>
                    <?php echo $branchData['locality']; ?>
                </option>
                <?php }; ?>
            </select>
            <!--<label for='form-floating' style="margin-left:150px;">Select Branch</label>-->
        </div>

    </div>



    <!-- </span> -->


    <hr>
    <div style="display:flex; gap:150px;margin-top:-10px;" id="beforeEditPress">
        <button type="submit" name="submitTax" id="submitTaxBtn" class="btn btn-primary"
            style="width:120px;">Submit</button>
        <a href="<?php echo BASE_URL; ?>/pages/homePage.php" id="closetaxBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Close</a>
    </div>

    <div style="display:flex;gap:150px;margin-top:-38px;" id="afterEditPress">
        <button type="submit" name="updateTax" id="updateTaxBtn" class="btn btn-primary"
            style="width:120px;">Update</button>
        <a href="<?php echo BASE_URL; ?>/pages/taxesMaster.php" id="backTaxBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Back</a>
    </div>

    <hr>
</form>




<form action="" class="taxSearchForm" style="margin-top:-20px;" method="post">
    <input type="text" class="form-control" name="taxSearch" id="taxSearch" placeholder="Search Tax">
    <button type="submit" class="btn btn-success" name="taxSearchBtn" id="taxSearchBtn">Search</button>
</form>

<form action="" id="exportForm" method="post" target="">
    <select name="fileType" id="fileType" class="form-control" style="width:160px;">
        <!-- <option value="">--Select File Type--</option> -->
        <option value="pdfFile">PDF</option>
        <option value="excelFile">Excel</option>
    </select>
    <button type="submit" name="exportButton" class="btn btn-primary">Export</button>
</form>

<div style="max-height:200px;overflow-x:auto;overflow-y:auto;" class="taxTable">


    <table class="table text-white" style="font-size:10px;">
        <thead style="position:sticky;z-index:1;top:0;background-color:#FF3CAC">
            <tr>
                <th style="width:40px">S.No.</th>
                <th style="width:150px">Actions</th>
                <th style="width:120px">Taxes</th>
                <th>Description</th>
                <th>Tax (%)</th>
                <th style="width:250px">Created By</th>
                <th>Created Date</th>
                <th>User Id</th>
                <th>Branch</th>
            </tr>
            </tr>

        </thead>
        <tbody>
            <?php

            if (isset($_POST['taxSearchBtn'])) {
                extract($_POST);
                // echo $taxSearch;

                $_SESSION['searching_name'] = $taxSearch;




                // $objecttax->settaxsSearch($taxSearch);
                // echo "object = ".$objecttax->gettaxsSearch();
                echo "<script>
        document.addEventListener('DOMContentLoaded', function(event) {
            event.preventDefault();
            document.getElementById('taxSearch').focus();
        });
      </script>";



                $querySearchTax = "select*from taxes where tax_code like '%$taxSearch%' order by tax_code";
                // $querySearchTax = "select t.*,b.*
                //                   from taxes as t
                //                   join branches as b on b.id = t.branch_id
                //                   where t.tax_code like '%$taxSearch%' order by t.tax_code";
                $resultSearchTax = $con->query($querySearchTax);



                if (isset($resultSearchTax)) {
                    $i = 1;
                    while ($taxSearchData = $resultSearchTax->fetch_assoc()) {
                        $branchSearch = "select*from branches where id='$taxSearchData[branch_id]'";
                        $resultBranchSearch = $con->query($branchSearch)->fetch_assoc();

                        $searchUserName = "select user_name from user_master1 where id='$taxSearchData[user_id]'";
                        $resultUserName = $con->query($searchUserName)->fetch_assoc();




            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/taxesMaster.php?updationId=<?php echo $taxSearchData['id']; ?>"
                        class="btn btn-success"><i class="fa-solid fa-pen" style="font-size:10px;"></i></a>

                    <a id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/taxesMaster.php?deletionId=<?php echo $taxSearchData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete <?php echo $taxSearchData['tax_code']; ?>?')"
                        class="btn btn-danger"><i class="fa-solid fa-trash" style="font-size:10px;"></i></a>
                </td>
                <td><?php echo $taxSearchData['tax_code']; ?></td>
                <td><?php echo $taxSearchData['tax_description']; ?></td>
                <td><?php echo $taxSearchData['tax_percentage']; ?></td>
                <td><?php echo $resultUserName['user_name']; ?></td>
                <td><?php echo date("d-m-Y h:i:s A", strtotime($taxSearchData['created_date'])); ?></td>
                <td><?php echo $taxSearchData['user_id'] ?></td>
                <td><?php echo $resultBranchSearch['locality'] ?></td>

            </tr>

            <?php }
                }
            } else {

                $i = 1;
                while ($taxSearchData = $resFetchTax->fetch_assoc()) {
                    $branchSearch = "select*from branches where id='$taxSearchData[branch_id]'";
                    $resultBranchSearch = $con->query($branchSearch)->fetch_assoc();

                    $searchUserName = "select user_name from user_master1 where id='$taxSearchData[user_id]'";
                    $resultUserName = $con->query($searchUserName)->fetch_assoc();
                    ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/taxesMaster.php?updationId=<?php echo $taxSearchData['id']; ?>"
                        class="btn btn-success"><i class="fa-solid fa-pen" style="font-size:10px;"></i></a>

                    <a id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/taxesMaster.php?deletionId=<?php echo $taxSearchData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete <?php echo $taxSearchData['tax_code']; ?>?')"
                        class="btn btn-danger"><i class="fa-solid fa-trash" style="font-size:10px;"></i></a>
                </td>
                <td><?php echo $taxSearchData['tax_code']; ?></td>
                <td><?php echo $taxSearchData['tax_description']; ?></td>
                <td><?php echo $taxSearchData['tax_percentage']; ?></td>
                <td><?php echo $resultUserName['user_name']; ?></td>
                <td><?php echo date("d-m-Y h:i:s A", strtotime($taxSearchData['created_date'])); ?></td>
                <td><?php echo $taxSearchData['user_id'] ?></td>
                <td><?php echo $resultBranchSearch['locality'] ?></td>
            </tr>

            <?php }
            }; ?>

        </tbody>
    </table>
</div>
<?php include_once(DIR_URL . "/includes/footer.php"); ?>



<style>
.form-floating {
    padding-top: 4px;
    color: #2B86C5;
    font-size: 13px;

}

#taxCode {
    width: 280px;
    font-size: 20px;
    font-weight: bold;
    /* text-transform: capitalize; */
    height: 50px;

}

#taxDesc {
    width: 280px;
    font-size: 20px;
    font-weight: bold;
    /* text-transform: capitalize; */
    height: 50px;

}

#taxPer {
    width: 280px;
    font-size: 20px;
    font-weight: bold;
    /* text-transform: capitalize; */
    height: 50px;

}

#branchName {
    margin-top: 4px;
    width: 226px;
    font-size: 15px;
    font-weight: bold;
    /* text-transform: capitalize; */
    height: 36px;
    padding-top: 5px;
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

#taxForm {
    position: absolute;
    top: 120px;
    left: 300px;
    width: 500px;
}

.taxSearchForm {
    display: flex;
    gap: 10px;
    position: absolute;
    top: 430px;
    left: 300px;
}

#exportForm {
    display: flex;
    gap: 10px;
    position: absolute;
    top: 410px;
    left: 1205px;

}

#taxCode {
    width: 270px;
    margin-top: 5px;
    height: 20px;

}

#taxDesc {
    width: 270px;
    margin-top: 5px;
    height: 20px;
}

#taxPer {
    width: 270px;
    margin-top: 5px;
    height: 20px;
}

.taxTable {

    position: absolute;
    top: 450px;
    left: 300px;
    width: 1150px;
    height: 275px;
    color: white;
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}
</style>

<script>
document.getElementById('taxPer').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9.]$/) || (charStr === '.' && this.value.includes('.'))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('taxPer').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
});



document.getElementById("taxCode").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("taxDesc").focus();
        document.getElementById("taxDesc").select();
    }
});


document.getElementById("taxDesc").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("taxPer").focus();
        document.getElementById("taxPer").select();
    }
});

document.getElementById("taxPer").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById('branchName').focus()

    }
});

document.getElementById("branchName").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("submitTaxBtn").focus();

    }
});

document.getElementById("taxPer").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById('branchName').focus()
        // document.getElementById("updateTaxBtn").focus();
    }
})

document.getElementById("branchName").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();

        document.getElementById("updateTaxBtn").focus();
    }
})

window.onload = function() {
    document.getElementById("taxCode").focus();
    document.getElementById("taxCode").select();

}


document.getElementById("taxSearch").addEventListener('keypress', function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("taxSearchBtn").focus();
    }
})

// document.getElementById("taxSearchBtn").addEventListener('keypress', function(event){

// if(event.key === "Enter"){
//     event.preventDefault();
//     document.getElementById("taxSearchBtn").focus();
// }
// })

// document.addEventListener("DOMContentLoaded", function () {
//     document.getElementById("editButton").addEventListener("click", function (event) {
//         event.preventDefault(); // Prevent the default anchor behavior
//         document.getElementById("taxCode").focus(); // Focus the input field
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