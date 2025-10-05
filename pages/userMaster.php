<style>
#updateUserBtn {
    visibility: hidden;
}

#backUserBtn {
    visibility: hidden;
}
</style>


<style>
.password-container {
    position: relative;
    display: inline-block;
}

.password-input {
    padding-right: 20px;
}

.eye-icon {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    width: 20px;
}
</style>
<?php
ob_start();
include_once("../config/config.php");
include_once(DIR_URL . "/includes/header.php");
include_once(DIR_URL . "/db/dbConnection.php");
include_once(DIR_URL . "/includes/navbar.php");
include_once(DIR_URL . "/includes/sidebar.php");

$hiddenRoleSelectionValue = "";

?>


<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
// echo $_SESSION['user_info_form_create'];
// echo "<br>";
// echo $_SESSION['user_info_form_reprint'];
// echo "<br>";
// echo $_SESSION['user_info_form_update'];
// echo "<br>";
// echo $_SESSION['user_info_form_delete'];
// echo "<br>";

if ($_SESSION['user_role'] != "Super Admin") {


    if ($_SESSION['user_info_form_create'] == 0) {
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let submitBtn = document.getElementById('createUserBtn');
    if (submitBtn) {
        submitBtn.setAttribute('disabled', true);
    }

});
</script>

<?php } ?>
<?php

    if ($_SESSION['user_info_form_reprint'] == 0) {
    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {

    let userSearchBtn = document.getElementById("userSearchBtn");
    if (userSearchBtn) {
        userSearchBtn.setAttribute('disabled', true)
    }

    let userSearch = document.getElementById("userSearch");
    if (userSearch) {
        userSearch.setAttribute('disabled', true)
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

    if ($_SESSION['user_info_form_update'] == 0) {
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

    if ($_SESSION['user_info_form_delete'] == 0) {
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

<?php } ?>
<?php
}
$branchId = $_SESSION['user_branch_id'];
if ($_SESSION['user_role'] == "Admin") {

    $qryFetchPro = "select*from user_master1 where user_role != 'Super Admin' and branch_id = '$branchId' order by user_name";
} elseif ($_SESSION['user_role'] == 'Manager') {
    $qryFetchPro = "select*from user_master1 where (user_role != 'Super Admin' and user_role != 'Admin') and branch_id = '$branchId' order by user_name";
} elseif ($_SESSION['user_role'] == "Super Admin") {

    $qryFetchPro = "select*from user_master1 order by user_name";
}



// $qryFetchPro = "select*from user_master1";


$formsName = [
    "company_form",
    "branch_form",
    "supplier_form",
    "customer_form",
    "sales_person_form",
    "product_form",
    "brand_form",
    "design_form",
    "color_form",
    "batch_form",
    "category_form",
    "hsn_form",
    "tax_form",
    "size_form",
    "mrp_form",
    "item_form",
    "purchase_form",
    "purchase_return_form",
    "sales_form",
    "reports_form",
    "user_info_form",
    "user_management_form"
];




$resFetchPro = $con->query($qryFetchPro);

$_SESSION['table_name'] = "user_master1";
$_SESSION['field_name'] = "user_name";


if (isset($_POST['exportButton'])) {
    extract($_POST);
    if ($fileType == "pdfFile") {
        $_SESSION['report_title'] = "Users Report";
        $_SESSION['header_title'] = "User Name";

        header("Location:" . BASE_URL . "/exportFile/pdfFileFormatUsers.php");
        // pdfFormat($_SESSION['user_name'],$con);



        // echo "hello = ".$objectuser->getusersSearch();
        // header("Location:".BASE_URL."exportFile/pdfFileFormat.php");

    } elseif ($fileType == "excelFile") {
        header("Location:" . BASE_URL . "/exportFile/excelFileFormatUsers.php");
    } else {
        echo "Please Select File Type";
    }
}


if (isset($_POST['createUser'])) {


    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();

        // Extract form data
        extract($_POST);

        if (isset($userName) && isset($userPass) && isset($userRole) && isset($userBranch) && $userName != '' && $userPass != '' && $userRole != '' && $userBranch != '') {
            // Prepare the query to prevent SQL injection

            $querySearchUserExist = "select*from user_master1 where user_name = '$userName' && user_role = '$userRole'";
            $resultSearchUserExist = $con->query($querySearchUserExist);
            if ($resultSearchUserExist->num_rows == 0) {

                $encrypted_password = password_hash($userPass, PASSWORD_DEFAULT);

                $queryCreateUser = "INSERT INTO user_master1 (user_name, user_pass, user_role, created_date, branch_id,login_status) VALUES (?, ?, ?, NOW(), ?, ?)";
                $stmt = $con->prepare($queryCreateUser);

                $login_status = 0;

                // $queryInsertUserCrudPermission = ""

                // Bind the parameters
                $stmt->bind_param("sssii", $userName, $encrypted_password, $userRole, $userBranch, $login_status);


                if ($stmt->execute()) {

                    $querySearchUserId = "select*from user_master1 where user_name = '$userName' &&
                    user_role = '$userRole' && branch_id = '$userBranch'";
                    $resultSearchUserId = $con->query($querySearchUserId)->fetch_assoc();


                    $queryInsertUserFormPermission = "INSERT INTO user_forms_permission (branch_id, user_id, company_form,
                    branch_form, supplier_form, customer_form, sales_person_form, product_form,
                    brand_form, design_form, color_form, batch_form, category_form, hsn_form,
                    tax_form, size_form, mrp_form, item_form, purchase_form, purchase_return_form,
                    sales_form, reports_form, user_info_form, user_management_form)
                    VALUES ('$resultSearchUserId[branch_id]', '$resultSearchUserId[id]', '0', '0', '0', '0', '0',
                    '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0',  '0', '0', '0', '0', '0', '0')";

                    // $queryInsertUserFormPermission = "INSERT INTO user_forms_permission (branch_id, user_id, company_form,
                    // branch_form, supplier_form, customer_form, sales_person_form, product_form,
                    // brand_form, design_form, color_form, batch_form, category_form, hsn_form,
                    // tax_form, size_form, mrp_form, item_form, purchase_form, purchase_return_form,
                    // sales_form, reports_form, user_info_form, user_management_form)
                    // VALUES ('$resultSearchUserId[branch_id]', '$resultSearchUserId[id]', '1', '1', '1', '1', '1',
                    // '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1',  '1', '1', '1', '1', '1', '1')";
                    $resultInsertUserFormPermission = $con->query($queryInsertUserFormPermission);
                    foreach ($formsName as $fNames) {

                        $queryInsertUserCrudPermission = "insert into user_crud_permission
                                                         (form_name, create_op,reprint_op,
                                                         update_op,delete_op,user_id,branch_id)
                                                         values('$fNames', '0','0','0','0',
                                                         '$resultSearchUserId[id]','$resultSearchUserId[branch_id]')";
                        $resultInsertUserCrudPermission = $con->query($queryInsertUserCrudPermission);
                    }

                    $con->commit();
                    $_SESSION['success'] = "User Created Successfully";
                    header("Location:" . BASE_URL . "/pages/userMaster.php");
                    exit();
                }
            } else {
                $con->rollback();
                $_SESSION['failure'] = "User Already Exist With Same Role";
            }



            // Execute the query



        } else {
            $con->rollback();
            $_SESSION['failure'] = "All fields are required.";
        }
    } catch (mysqli_sql_exception $e) {
        // Check if it's a duplicate entry error
        $con->rollback();
        if ($e->getCode() == 1062) { // Error code for duplicate entry
            $_SESSION['failure'] = "User name '$userName' already exists. Please use a different user name.";
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

if ($_SESSION['user_role'] != "Super Admin") {
    $querySearchBranch = "select*from branches where id = '$branchId'";
} else {
    $querySearchBranch = "select*from branches order by locality";
}

$resultSearchBranch = $con->query($querySearchBranch);

$id = "";
$userName  = "";
$userPassword = "";
$userRole = "";
$userBranchId = "";


if (isset($_GET['userName']) && isset($_GET['userPassword']) && isset($_GET['userRole'])) {

    extract($_GET);
} else {

    $userName  = "";
    $userPassword = "";
    $userRole = "";
}
?>
<?php

if (isset($_GET['deletionid'])) {
    try {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        extract($_GET);
        $con->begin_transaction();


        $queryDeleteUser = "delete from user_master1 where id='$deletionid'";
        $resultDeleteUser = $con->query($queryDeleteUser);

        $queryDeleteUserFormPermission = "delete from user_forms_permission where user_id='$deletionid'";
        $resultDeleteUserFormPermission = $con->query($queryDeleteUserFormPermission);

        $queryDeleteUserCrudPermission = "delete from user_crud_permission where user_id='$deletionid'";
        $resultDeleteUserCrudPermission = $con->query($queryDeleteUserCrudPermission);
        if ($resultDeleteUser) {
            $con->commit();
            $_SESSION['success'] = "User Deleted Successfully";
            header("Location:" . BASE_URL . "/pages/userMaster.php");
            exit;
        } else {
            $con->rollback();
            $_SESSION['failure'] = "Oops! Something Went Wrong";
        }
    } catch (mysqli_sql_exception $e) {
        $con->rollback();
        $_SESSION['failure'] = 'Error during deletion ' . $e->getMessage();
    }
}


// if(isset($_GET['updationid'])){

//     extract($_GET);

//     $querySearchUser1 = "select*from user_master1 where id='$updationid'";
//     $resultSearchUser1 = $con->query($querySearchUser1)->fetch_assoc();


//     $userName = $resultSearchUser1['user_name'];
//     $userPassword = $resultSearchUser1['user_pass'];
//     $userRole = $resultSearchUser1['user_role'];
//     $userBranchId = $resultSearchUser1['branch_id'];



//     if(isset($_POST['updateUser'])){
//         extract($_POST);
//         $queryUpdateUser = "update user_master1 set user_name = '$userName', user_pass = '$userPass', user_role = '$userRole', branch_id = '$userLocation' where id='$updationid'";
//         $resultUpdateUser = $con->query($queryUpdateUser);
//         if($resultUpdateUser){
//               $_SESSION['success'] = "User Updated Successfully";
//               header("Location:".BASE_URL."/pages/userMaster.php");
//               exit;
//         }else{
//               $_SESSION['failure'] = "Oops! Something Went Wrong";
//         }
//     }

if (isset($_GET['updationid'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract GET data
        extract($_GET);
        $querySearchUser1 = "select*from user_master1 where id='$updationid'";
        $resultSearchUser1 = $con->query($querySearchUser1)->fetch_assoc();


        $userName = $resultSearchUser1['user_name'];
        $userPassword = $resultSearchUser1['user_pass'];
        $userRole = $hiddenRoleSelectionValue = $resultSearchUser1['user_role'];
        $userBranchId = $resultSearchUser1['branch_id'];

        if (isset($_POST['updateUser'])) {
            // Extract POST data
            extract($_POST);

            if (isset($userName)) {

                if ($hiddenRoleSelectionValue == "Super Admin" || $hiddenRoleSelectionValue == "Admin" || $hiddenRoleSelectionValue  == "Manager") {
                    $queryUpdateUserExist = "select*from user_master1 where user_name = '$userName' && user_role = '$hiddenRoleSelectionValue' && id != $updationid";
                } else {

                    $queryUpdateUserExist = "select*from user_master1 where user_name = '$userName' && user_role = '$userRole' && id != $updationid";
                }


                $resultUpdateUseExist = $con->query($queryUpdateUserExist);
                if ($resultUpdateUseExist->num_rows == 0) {
                    // echo "user does not exist";
                    $qryUpdateUser = "UPDATE user_master1 SET user_name = ?, user_pass = ?, user_role = ?,
                                  branch_id = ? WHERE id = ?";
                    $stmt = $con->prepare($qryUpdateUser);
                    
                    $encryptedUserPassword = password_hash($userPass, PASSWORD_DEFAULT);

                    if ($_SESSION['user_role'] == "Super Admin" and $hiddenRoleSelectionValue == "Super Admin") {
                        $stmt->bind_param("sssii", $userName, $encryptedUserPassword, $hiddenRoleSelectionValue, $userBranch, $updationid);
                    } elseif ($_SESSION['user_role'] == "Admin" and $hiddenRoleSelectionValue == "Admin") {
                        $stmt->bind_param("sssii", $userName, $encryptedUserPassword, $hiddenRoleSelectionValue, $userBranch, $updationid);
                    } elseif ($_SESSION['user_role'] == "Manager" and $hiddenRoleSelectionValue == "Manager") {
                        $stmt->bind_param("sssii", $userName, $encryptedUserPassword, $hiddenRoleSelectionValue, $userBranch, $updationid);
                    } else {
                        $stmt->bind_param("sssii", $userName, $encryptedUserPassword, $userRole, $userBranch, $updationid);
                    }

                    // if($hiddenRoleSelectionValue == "Super Admin" || $hiddenRoleSelectionValue == "Admin"){
                    //     $stmt->bind_param("sssii", $userName,$userPass,$hiddenRoleSelectionValue,$userBranch, $updationid);
                    // }else{
                    //     $stmt->bind_param("sssii", $userName,$userPass,$userRole,$userBranch, $updationid);    
                    // }


                    // Execute the query
                    if ($stmt->execute()) {
                        $con->commit();
                        $_SESSION['success'] = "User Updated Successfully";

                        header("Location:" . BASE_URL . "/pages/userMaster.php");
                        exit;
                    } else {
                        $con->rollback();
                        $_SESSION['failure'] = "Failed to update user. Please try again.";
                    }
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "User Exist With Same Role And Location.";
                }
            } else {
                $con->rollback();
                $_SESSION['failure'] = "User Name cannot be empty.";
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Check for specific SQL errors like duplicate entry
        $con->rollback();
        if ($e->getCode() == 1062) {
            $_SESSION['failure'] = "user name '$userName' already exists. Please enter a different user name.";
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
#createUserBtn {
    visibility: hidden;
}

#closeUserBtn {
    visibility: hidden;
}


#updateUserBtn {
    visibility: visible;

}

#backUserBtn {
    visibility: visible;

}
</style>

<?php } ?>

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

<div id="userContent">
    <form action="" id="userForm" method="post">
        <h3 style="text-align:left;font-family:Verdana, Geneva, Tahoma, sans-serif;"><span
                style="font-weight:bolder">Manage </span><span
                style="font-size:medium;font-weight:bold;color:gray;">User Info</span></h3>
        <hr>
        <span style="display:flex;gap:20px">

            <input type="text" name="userName" autocomplete="off" id="userName" class="form-control"
                placeholder="User Name" value="<?php echo $userName; ?>" maxlength="30">



            <div class="password-container">
                <input type="password" name="userPass" id="userPass" class="form-control password-input"
                    placeholder="Password" value="<?php echo $userPassword; ?>" maxLength="30">
                <img src="https://cdn-icons-png.flaticon.com/512/159/159604.png" id="togglePassword" class="eye-icon"
                    width="20" alt="Show Password">
            </div>
        </span>

        <span style="display: flex;gap:20px;">
            <select name="userRole" id="userRole" class="form-control">
                <option value="">--Select Role--</option>
                <?php if ($_SESSION['user_role'] == "Super Admin") { ?>
                <option value="Admin" <?php echo ($userRole == "Admin") ? "selected" : "" ?>>Admin</option>
                <option value="Manager" <?php echo ($userRole == "Manager") ? "selected" : "" ?>>Manager</option>
                <option value="User" <?php echo ($userRole == "User") ? "selected" : "" ?>>User</option>

                <?php } ?>
                <?php
                if ($_SESSION['user_role'] == "Admin") {
                ?>
                <option value="Manager" <?php echo ($userRole == "Manager") ? "selected" : "" ?>>Manager</option>
                <option value="User" <?php echo ($userRole == "User") ? "selected" : "" ?>>User</option>
                <?php } ?>
                <?php
                if ($_SESSION['user_role'] == "Manager") {
                ?>
                <option value="User" <?php echo ($userRole == "User") ? "selected" : "" ?>>User</option>
                <?php } ?>
            </select>

            <select name="userBranch" id="userBranch" class="form-control">
                <!-- <option value="">--Select Branch--</option> -->
                <?php while ($branchData = $resultSearchBranch->fetch_assoc()) { ?>
                <option value="<?php echo $branchData['id']; ?>"
                    <?php echo ($userBranchId == $branchData['id']) ? "Selected" : "" ?>>
                    <?php echo $branchData['locality']; ?></option>
                <?php }; ?>
            </select>
            <input type="text" class="form-control" id="hiddenRoleSelection" name="hiddenRoleSelection"
                style="width:100px;;margin-top:10px;" value="<?php echo $hiddenRoleSelectionValue; ?>" hidden>
        </span>

        <hr>

        <div style="display:flex; gap:100px;margin-top:-10px;" id="beforeEditPress">
            <button type="submit" name="createUser" id="createUserBtn" class="btn btn-primary"
                style="width:120px;">Submit</button>
            <a href="<?php echo BASE_URL; ?>/pages/homePage.php" class="btn btn-secondary" id="closeUserBtn"
                style="width:120px;margin-left:-70px">Close</a>
        </div>

        <div style="display:flex;gap:150px;margin-top:-38px;" id="afterEditPress">
            <button type="submit" name="updateUser" id="updateUserBtn" class="btn btn-primary"
                style="width:120px;">Update</button>
            <a href="<?php echo BASE_URL; ?>/pages/userMaster.php" id="backUserBtn" class="btn btn-secondary"
                style="width:120px;margin-left:-120px">Back</a>
        </div>


        <hr>
    </form>

    <!-- User Details Table Start-->
    <form action="" class="userSearchForm" style="margin-top:-20px;" method="post">
        <input type="text" class="form-control" name="userSearch" id="userSearch" placeholder="Search user">
        <button type="submit" class="btn btn-success" name="userSearchBtn" id="userSearchBtn">Search</button>
    </form>

    <form action="" id="exportForm" method="post" target="">
        <select name="fileType" id="fileType" class="form-control" style="width:160px;">
            <!-- <option value="">--Select File Type--</option> -->
            <option value="pdfFile">PDF</option>
            <option value="excelFile">Excel</option>
        </select>
        <button type="submit" id="exportBtn" name="exportButton" class="btn btn-primary">Export</button>
    </form>




    <div style="max-height:400px;overflow-x:auto;overflow-y:auto;" class="userTable">


        <table class="table text-white" style="font-size:11px;">
            <thead style="position:sticky;z-index:1;top:0;background-color:#FF3CAC">
                <tr>
                    <th style="width:20px">S.No</th>
                    <th>Actions</th>
                    <th style="width:300px">User Name</th>
                    <th style="width:250px">User Role</th>
                    <th>Branch</th>
                    <th>Created Date</th>
                </tr>

            </thead>
            <tbody>
                <?php




                if (isset($_POST['userSearchBtn'])) {
                    extract($_POST);
                    $_SESSION['searching_name'] = $userSearch;
                    if ($_SESSION['user_role'] == "Admin") {
                        $querySearchUser = "select*from user_master1 where user_name  like '%$userSearch%' and user_role != 'Super Admin' and branch_id = '$branchId' order by user_name";
                    } elseif ($_SESSION['user_role'] == 'Super Admin') {
                        $querySearchUser = "select*from user_master1 where user_name  like '%$userSearch%' order by user_name";
                    }


                    $resultSearchUser = $con->query($querySearchUser);



                    if (isset($resultSearchUser)) {
                        $i = 1;
                        while ($userSearchData = $resultSearchUser->fetch_assoc()) {
                            $queryJoinUserBranch = "select branch_name from branches  where id='$userSearchData[branch_id]'";
                            $resultJoinUserBranch = $con->query($queryJoinUserBranch)->fetch_assoc();
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td>
                        <a id="editButton"
                            href="<?php echo BASE_URL; ?>/pages/userMaster.php?updationid=<?php echo $userSearchData['id']; ?>"
                            class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size: 10px;"></i></a>

                        <a id="deleteButton"
                            href="<?php echo BASE_URL; ?>/pages/userMaster.php?deletionid=<?php echo $userSearchData['id']; ?>"
                            onclick="return confirm('Are you sure you want to delete <?php echo $userSearchData['user_name']; ?>?')"
                            class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash"
                                style="font-size: 10px"></i></a>
                    </td>
                    <td><?php echo $userSearchData['user_name']; ?></td>
                    <td><?php echo $userSearchData['user_role']; ?></td>
                    <td><?php echo $resultJoinUserBranch['branch_name']; ?></td>
                    <td><?php echo date("d-m-Y h:i:s A", strtotime($userSearchData['created_date'])); ?></td>

                </tr>
                <!--  -->
                <?php }
                    }
                } else {


                    // echo " without clicking search button = ". $_SESSION['searching_name'];
                    $i = 1;
                    while ($userData = $resFetchPro->fetch_assoc()) {

                        $queryJoinUserBranch = "select branch_name from branches where id = '$userData[branch_id]'";
                        $resultJoinUserBranch = $con->query($queryJoinUserBranch)->fetch_assoc();

                        ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td>
                        <a id="editButton"
                            href="<?php echo BASE_URL; ?>/pages/userMaster.php?updationid=<?php echo $userData['id']; ?>"
                            class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size: 10px;"></i></a>

                        <a id="deleteButton"
                            href="<?php echo BASE_URL; ?>/pages/userMaster.php?deletionid=<?php echo $userData['id']; ?>"
                            onclick="return confirm('Are you sure you want to delete <?php echo $userData['user_name']; ?>?')"
                            class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash"
                                style="font-size: 10px;"></i></a>
                    </td>
                    <td><?php echo $userData['user_name']; ?></td>
                    <th><?php echo $userData['user_role'] ?></th>
                    <td><?php echo $resultJoinUserBranch['branch_name'] ?></td>
                    <td><?php echo date("d-m-Y h:i:s A", strtotime($userData['created_date'])); ?></td>

                </tr>

                <?php }
                }; ?>

            </tbody>
        </table>
    </div>
</div>
<!-- User Details Table End -->

<?php include_once(DIR_URL . "/includes/footer.php"); ?>
<?php ob_end_flush(); ?>
<style>
.userTable {

    position: absolute;
    top: 420px;
    left: 300px;
    width: 1150px;
    height: 275px;
    color: white;
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}



.userSearchForm {
    display: flex;
    gap: 10px;
    position: absolute;
    top: 390px;
    left: 300px;
}

#exportForm {
    display: flex;
    gap: 10px;
    position: absolute;
    top: 370px;
    left: 1205px;

}

#userDetailsTable tr {
    /* height:2px; */
    /* margin-top:100px;
margin-left:300px;
width:50%; */
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

#userForm {
    position: absolute;
    top: 125px;
    left: 300px;
    width: 500px;
}

#userName {
    width: 270px;


}

#userPass {
    width: 240px;
    /* margin-top:10px; */
}

#userRole {
    width: 270px;
    margin-top: 10px;
}

#userBranch {
    width: 270px;
    margin-top: 10px;
}
</style>

<script>
const passwordInput = document.getElementById("userPass");
const togglePassword = document.getElementById("togglePassword");

togglePassword.addEventListener("click", function() {
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        togglePassword.src = "https://cdn-icons-png.flaticon.com/512/159/159605.png"; // Eye-off icon
    } else {
        passwordInput.type = "password";
        togglePassword.src = "https://cdn-icons-png.flaticon.com/512/159/159604.png"; // Eye icon
    }
});

// Initialize DataTable
$(document).ready(function() {
    $('#userDetailsTable').DataTable({
        "pageLength": 5, // Default number of records per page
        "lengthMenu": [5, 10, 25, 50, 100], // Options for records per page


    });
});

window.onload = function() {
    document.getElementById("userName").focus();
    document.getElementById("userName").select();
}



document.getElementById("userName").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("userPass").focus();
        document.getElementById("userPass").select();
    }
})
document.getElementById("userPass").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("userRole").focus();
        document.getElementById("userRole").select();
    }
})
document.getElementById("userRole").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("userBranch").focus();
        document.getElementById("userBranch").select();
    }
})
document.getElementById("userBranch").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("createUserBtn").focus();

    }
})


document.getElementById("userBranch").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("updateUserBtn").focus();
    }
})

document.getElementById("userSearch").addEventListener("keypress", function(event) {

    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("userSearchBtn").focus();
    }

})

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