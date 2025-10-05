<?php ob_start(); ?>

<?php

include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");
include_once(DIR_URL . "/includes/header.php");
include_once(DIR_URL . "/includes/navbar.php");
include_once(DIR_URL . "/includes/sidebar.php");


?>

<style>
#updateSupBtn {
    visibility: hidden;
}

#backSupBtn {
    visibility: hidden;
}
</style>


<?php
if ($_SESSION['user_role'] != "Super Admin") {
    if ($_SESSION['sales_person_form_create'] == 0) {
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let submitBtn = document.getElementById('submitSalesPersonBtn');
    if (submitBtn) {
        submitBtn.setAttribute('disabled', true);
    }

});
</script>

<?php } ?>
<?php

    if ($_SESSION['sales_person_form_reprint'] == 0) {
    ?>
<script>
document.addEventListener('DOMContentLoaded', function() {

    let supSearchBtn = document.getElementById("salesPersonSearchBtn");
    if (supSearchBtn) {
        supSearchBtn.setAttribute('disabled', true)
    }

    let supSearch = document.getElementById("salesPersonSearch");
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

    if ($_SESSION['sales_person_form_update'] == 0) {
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

    if ($_SESSION['sales_person_form_delete'] == 0) {
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
}
?>


<?php









// if(isset($_POST['createSalesPerson'])){
$_SESSION['table_name'] = "sales_person";
$_SESSION['field_name'] = "sales_person_name";


// }

$name     = "";
$address1 = "";
$address2 = "";
$address3 = "";
$locality = "";
$city     = "";
$pincode  = "";
$state    = "";
$landline = "";
$mobile   = "";
$email    = "";
$pan      = "";

$states = [
    '01' => 'Jammu & Kashmir',
    '02' => 'Himachal Pradesh',
    '03' => 'Punjab',
    '04' => 'Chandigarh',
    '05' => 'Uttarakhand',
    '06' => 'Haryana',
    '07' => 'Delhi',
    '08' => 'Rajasthan',
    '09' => 'Uttar Pradesh',
    '10' => 'Bihar',
    '11' => 'Sikkim',
    '12' => 'Arunachal Pradesh',
    '13' => 'Nagaland',
    '14' => 'Manipur',
    '15' => 'Mizoram',
    '16' => 'Tripura',
    '17' => 'Meghalaya',
    '18' => 'Assam',
    '19' => 'West Bengal',
    '20' => 'Jharkhand',
    '21' => 'Odisha',
    '22' => 'Chhattisgarh',
    '23' => 'Madhya Pradesh',
    '24' => 'Gujarat',
    '25' => 'Daman & Diu',
    '26' => 'Dadra & Nagar Haveli & Daman & Diu',
    '27' => 'Maharashtra',
    '29' => 'Karnataka',
    '30' => 'Goa',
    '31' => 'Lakshdweep',
    '32' => 'Kerala',
    '33' => 'Tamil Nadu',
    '34' => 'Puducherry',
    '35' => 'Andaman & Nicobar Islands',
    '36' => 'Telangana',
    '37' => 'Andhra Pradesh',
    '38' => 'Ladakh',
    '97' => 'Other Territory'

];
sort($states);

$userid = $_SESSION['user_id'];
$branchId = $_SESSION['user_branch_id'];
$userRole = $_SESSION['user_role'];


if (isset($_POST['createSalesPerson'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract form data

        extract($_POST);
        echo $name;
        echo "<br>";
        echo $address1;
        echo "<br>";
        echo $address2;
        echo "<br>";
        echo $address3;
        echo "<br>";
        echo $locality;
        echo "<br>";
        echo $city;
        echo "<br>";
        echo $pinCode;
        echo "<br>";
        echo $state;
        echo "<br>";
        echo $landline;
        echo "<br>";
        echo $mobile;
        echo "<br>";
        echo $email;
        echo "<br>";
        echo $pan;

        // if (isset($name) && isset($address1) && isset($address2) && isset($address3)
        //    && isset($locality) && isset($city) && isset($pinCode) && isset($state) && isset($mobile)
        //    && isset($landline) && isset($email) && isset($pan) && $name !== '' && $address1 !== ''
        //    && $address2 !== '' && $address3 !== ''&& $locality !== ''&& $city !== ''
        //    && $pinCode !== ''  && $state !== '' && $mobile !== '' && $landline !== ''
        //    && $email !== '' && $pan !== '') {
        if (isset($name) && $name != '') {

            // Prepare the query to prevent SQL injection
            // Prepare the SQL statement


            $querySearchSalesPerson = "select*from sales_person where sales_person_name = '$name'
            and branch_id = '$branchId'";
            $resultSearchSalesPerson = $con->query($querySearchSalesPerson);

            if ($resultSearchSalesPerson->num_rows == 0) {

                $querycreateSalesPerson = "INSERT INTO sales_person (
                    sales_person_name, 
                    address1, 
                    address2, 
                    address3, 
                    locality, 
                    city, 
                    pincode, 
                    state, 
                    landline, 
                    mobile, 
                    email, 
                    pan,
                    user_id,
                    branch_id
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
                $stmt = $con->prepare($querycreateSalesPerson);
                $stmt->bind_param(
                    "ssssssssssssii",
                    $name,
                    $address1,
                    $address2,
                    $address3,
                    $locality,
                    $city,
                    $pinCode,
                    $state,
                    $landline,
                    $mobile,
                    $email,
                    $pan,
                    $userid,
                    $branchId
                );




                // Execute the query
                if ($stmt->execute()) {
                    $con->commit();
                    $_SESSION['success'] = "Sales Person Created Successfully";
                    header("Location:" . BASE_URL . "/pages/salesPersonMaster.php");
                    exit;
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Failed to create Sales Person. Please try again.";
                }
            } else {
                $con->rollback();
                $_SESSION['failure'] = "Sales Person Already Exist! Cannot Create A Duplicate";
            }
        } else {
            $_SESSION['failure'] = "At Least Sales Person Name Is Required To Create.";
        }
    } catch (mysqli_sql_exception $e) {
        // Check if it's a duplicate entry error
        $con->rollback();
        if ($e->getCode() == 1062) { // Error code for duplicate entry
            $_SESSION['failure'] = "Sales Person Name '$name' already exists. Please enter a different Sales Person name.";
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


if (isset($_GET['updationid'])) {
    try {
        // Enable MySQLi exceptions
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $con->begin_transaction();
        // Extract GET data
        extract($_GET);
        $querySearchsalesPerson = "select*from sales_person where id = '$updationid'";
        $resultSearchsalesPerson = $con->query($querySearchsalesPerson)->fetch_assoc();
        $name     = $resultSearchsalesPerson['sales_person_name'];
        $address1 = $resultSearchsalesPerson['address1'];
        $address2 = $resultSearchsalesPerson['address2'];
        $address3 = $resultSearchsalesPerson['address3'];
        $locality = $resultSearchsalesPerson['locality'];
        $city     = $resultSearchsalesPerson['city'];
        $pincode  = $resultSearchsalesPerson['pincode'];
        $state    = $resultSearchsalesPerson['state'];
        $landline = $resultSearchsalesPerson['landline'];
        $mobile   = $resultSearchsalesPerson['mobile'];
        $email    = $resultSearchsalesPerson['email'];
        $pan      = $resultSearchsalesPerson['pan'];

        if (isset($_POST['updateSalesPerson'])) {
            // Extract POST data
            extract($_POST);

            if (!empty($name)) {
                // Prepare the query to prevent SQL injection

                $querySearchSalesPerson = "select*from sales_person where sales_person_name = '$name'
            and branch_id = '$branchId' and id !='$updationid'";
                $resultSearchSalesPerson = $con->query($querySearchSalesPerson);

                if ($resultSearchSalesPerson->num_rows == 0) {
                    $qryupdateSalesPerson = "UPDATE sales_person SET sales_person_name = ?, address1 = ?,
                address2 = ?, address3 = ?, locality = ?, city = ?,
                pincode = ?, state = ?, landline = ?, mobile = ?,
                email = ?, pan = ?, user_id = ?, branch_id = ? WHERE id = ?";
                    $stmt = $con->prepare($qryupdateSalesPerson);
                    $stmt->bind_param(
                        "ssssssssssssiii",
                        $name,
                        $address1,
                        $address2,
                        $address3,
                        $locality,
                        $city,
                        $pinCode,
                        $state,
                        $landline,
                        $mobile,
                        $email,
                        $pan,
                        $userid,
                        $branchId,
                        $updationid
                    );

                    // Execute the query
                    if ($stmt->execute()) {
                        $con->commit();
                        $_SESSION['success'] = "Sales Person Updated Successfully";
                        header("Location:" . BASE_URL . "/pages/salesPersonMaster.php");
                        exit;
                    } else {
                        $con->rollback();
                        $_SESSION['failure'] = "Failed to update Sales Person. Please try again.";
                    }
                } else {
                    $con->rollback();
                    $_SESSION['failure'] = "Sales Person Already Exist! Cannot Create A Duplicate";
                }
            } else {
                $_SESSION['failure'] = "Sales Person Name cannot be empty.";
            }
        }
    } catch (mysqli_sql_exception $e) {
        // Check for specific SQL errors like duplicate entry
        $con->rollback();
        if ($e->getCode() == 1062) {
            $_SESSION['failure'] = "Sales Person Name '$name' already exists. Please enter a different Sales Person name.";
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
#submitSalesPersonBtn {
    visibility: hidden;
}

#closeSupBtn {
    visibility: hidden;
}


#updateSupBtn {
    visibility: visible;

}

#backSupBtn {
    visibility: visible;

}
</style>
<!-- <script>
let pro = document.getElementById("updateBrandBtn");
pro.style.visibility = "visible";
</script> -->
<?php }; ?>
<?php



// if (isset($_GET['deletionid'])) {
//     extract($_GET);
//     $queryDeleteSalesPerson = "delete from sales_person where id='$deletionid'";
//     $resultDeleteSalesPerson = $con->query($queryDeleteSalesPerson);
//     if ($resultDeleteSalesPerson) {
//         $_SESSION['success'] = "Sales Person Deleted Successfully";
//         header("Location:" . BASE_URL . "/pages/salesPersonMaster.php");
//         exit;
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

        // Get the ID
        $deletionid = $_GET['deletionid'];

        // Prepare DELETE statement
        $queryDeleteSalesPerson = "DELETE FROM sales_person WHERE id = ?";
        $stmtDelete = $con->prepare($queryDeleteSalesPerson);
        $stmtDelete->bind_param("i", $deletionid);

        // Execute DELETE
        if ($stmtDelete->execute()) {
            $con->commit(); //  Commit if successful
            $_SESSION['success'] = "Sales Person Deleted Successfully";
            header("Location:" . BASE_URL . "/pages/salesPersonMaster.php");
            exit;
        } else {
            $con->rollback(); //  Rollback if failed
            $_SESSION['failure'] = "Failed to delete Sales Person. Please try again.";
        }
    } catch (mysqli_sql_exception $e) {
        $con->rollback(); // Rollback on exception
        $_SESSION['failure'] = "Error during deletion: " . $e->getMessage();
    } finally {
        if (isset($stmtDelete)) $stmtDelete->close();
    }
}



if (isset($_POST['exportButton'])) {
    extract($_POST);
    if ($fileType == "pdfFile") {
        $_SESSION['report_title'] = "Sales Persons Report";
        $_SESSION['table_header'] = "Sales Person Name";
        $_SESSION['pan'] = "Pan";
        header("Location:" . BASE_URL . "/exportFile/pdfFileFormatSupCus.php");
        // pdfFormat($_SESSION['brand_name'],$con);



        // echo "hello = ".$objectbrand->getbrandsSearch();
        // header("Location:".BASE_URL."exportFile/pdfFileFormat.php");

    } elseif ($fileType == "excelFile") {
        $_SESSION['table_header'] = "Sales Person Name";
        header("Location:" . BASE_URL . "/exportFile/excelFileFormatSupCus.php");
    } else {
        echo "Please Select File Type";
    }
}


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

<form action="" class="salesPersonForm" id="salesPersonForm" method="post">
    <h3 style="text-align:left;font-family:Verdana, Geneva, Tahoma, sans-serif;"><span style="font-weight:bolder">Manage
        </span><span style="font-size:medium;font-weight:bold;color:gray;">Sales Person</span></h3>
    <hr>
    <div style="display:flex;">

        <div class="form-floating">
            <input type="text" name="name" autocomplete="off" id="name" class="form-control" placeholder="Name"
                value="<?php echo  $name; ?>" maxlength="50">
            <label for="floatingInput" style="color:#2B86C5">Name <span
                    style="color:red;font-size:20px;">*</span></label>
        </div>

        <!-- <input type="text" name="shortName" id="shortName" class="form-control" placeholder="Short Name"> -->
    </div>

    <div style="display:flex;gap:10px;">
        <div class="form-floating">
            <input type="text" name="address1" autocomplete="off" id="address1" class="form-control"
                placeholder="Address1" value="<?php echo  $address1; ?>" maxlength="30">
            <label for="floatingInput">Address1</label>
        </div>

        <div class="form-floating">
            <input type="text" name="locality" autocomplete="off" id="locality" class="form-control"
                placeholder="Locality" value="<?php echo  $locality; ?>" maxlength="30">
            <label for="floatingInput">Locality</label>
        </div>

        <div class="form-floating">
            <select name="state" id="state" class="form-control" maxlength="40">
                <option value=""></option>
                <?php foreach ($states as $state_names) {

                ?>
                <option value="<?php echo $state_names ?>" <?php echo ($state_names == $state) ? 'selected' : ""; ?>>
                    <?php echo $state_names; ?></option>

                <?php } ?>
            </select>

            <label for="floatingInput">State</label>
        </div>

        <div class="form-floating">
            <input type="text" name="email" autocomplete="off" id="email" class="form-control" placeholder="Email"
                value="<?php echo  $email; ?>" maxlength="50">
            <label for="floatingInput">Email</label>
        </div>






    </div>
    <div style="display:flex;gap:10px;">
        <div class="form-floating">
            <input type="text" name="address2" autocomplete="off" id="address2" class="form-control"
                placeholder="Address2" value="<?php echo  $address2; ?>" maxlength="30">
            <label for="floatingInput">Address2</label>
        </div>
        <div class="form-floating">
            <input type="text" name="city" autocomplete="off" id="city" class="form-control" placeholder="City"
                value="<?php echo  $city; ?>" maxlength="30">
            <label for="floatingInput">City</label>
        </div>


        <div class="form-floating">
            <input type="text" name="landline" autocomplete="off" id="landline" class="form-control"
                placeholder="landline" value="<?php echo  $landline; ?>" maxlength="25">
            <label for="floatingInput">landline</label>
        </div>

        <div class="form-floating">
            <input type="text" name="pan" autocomplete="off" id="pan" class="form-control" placeholder="pan NO"
                value="<?php echo  $pan; ?>" maxlength="10">
            <label for="floatingInput">PAN</label>
        </div>





    </div>

    <div style="display:flex;gap:10px;">

        <div class="form-floating">
            <input type="text" name="address3" autocomplete="off" id="address3" class="form-control"
                placeholder="Address3" value="<?php echo  $address3; ?>" maxlength="30">
            <label for="floatingInput">Address3</label>
        </div>

        <div class="form-floating">
            <input type="text" name="pinCode" autocomplete="off" id="pinCode" class="form-control" placeholder="pinCode"
                value="<?php echo  $pincode; ?>" maxlength="6">
            <label for="floatingInput">PinCode</label>
        </div>

        <div class="form-floating">
            <input type="text" name="mobile" autocomplete="off" id="mobile" class="form-control" placeholder="Mobile"
                value="<?php echo  $mobile; ?>" maxlength="21">
            <label for="floatingInput">Mobile</label>
        </div>








    </div>
    <!-- <div style="margin-top:-130px;margin-left:5px;">
        
        
        
        <input type="text" name="state" id="state" class="form-control" placeholder="State">
        </div> -->
    <hr>
    <div style="display:flex; gap:150px;margin-top:-10px;" id="beforeEditPress">
        <button type="submit" name="createSalesPerson" id="submitSalesPersonBtn" class="btn btn-primary"
            style="width:120px;">Submit</button>
        <a href="<?php echo BASE_URL; ?>/pages/homePage.php" id="closeSupBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Close</a>
    </div>

    <div style="display:flex;gap:150px;margin-top:-38px;" id="afterEditPress">
        <button type="submit" name="updateSalesPerson" id="updateSupBtn" class="btn btn-primary"
            style="width:120px;">Update</button>
        <a href="<?php echo BASE_URL; ?>/pages/salesPersonMaster.php" id="backSupBtn" class="btn btn-secondary"
            style="width:120px;margin-left:-120px">Back</a>
    </div>
    <hr style="margin-top:5px">
</form>

<!-- salesPerson Search And Export Button Start -->
<form action="" class="salesPersonSearchForm" style="margin-top:-20px;" method="post">
    <input type="text" class="form-control" name="salesPersonSearch" autocomplete="off" id="salesPersonSearch"
        placeholder="Search Sales Person">
    <button type="submit" class="btn btn-success" name="salesPersonSearchBtn" id="salesPersonSearchBtn">Search</button>
</form>


<form action="" id="exportForm" method="post" target="">
    <select name="fileType" id="fileType" class="form-control" style="width:160px;">
        <!-- <option value="">--Select File Type--</option> -->
        <option value="pdfFile">PDF</option>
        <option value="excelFile">Excel</option>
    </select>
    <button type="submit" id="exportBtn" name="exportButton" class="btn btn-primary">Export</button>
</form>

<!-- salesPerson Search And Export Button End -->
<!-- salesPerson Table Start-->
<div style="overflow-x:auto;overflow-y:auto;max-height:220px;height:500px;" id="salesPersonTable">
    <table class="table text-white" style="width:3000px;height:5px;font-size:11px;">
        <thead style="position:sticky;z-index:1;top:0;background-color:#FF3CAC">
            <tr>
                <th style="width:20px">S.No.</th>
                <th style="width:120px;">Actions</th>
                <th style="width:180px">Sales Person Name</th>
                <th style="width:180px">Address 1</th>
                <th style="width:180px">Address 2</th>
                <th style="width:200px">Address 3</th>
                <th style="width:150px">Locality</th>
                <th style="width:150px">City</th>
                <th style="width:100px">Pin Code</th>
                <th style="width:150px">State</th>
                <th style="width:200px">landline</th>
                <th style="width:200px">Mobile</th>
                <th style="width:200px">Email</th>
                <th style="width:140px">PAN</th>
                <th style="width:250px">Created Date</th>
                <th style="width:130px;">User Name</th>
                <th style="width:240px;">Branch Name</th>

            </tr>
        </thead>
        <tbody>
            <?php

            if (isset($_POST['salesPersonSearchBtn'])) {

                extract($_POST);

                $_SESSION['searching_name'] = $salesPersonSearch;

                $querySearchSalesPerson = "select*from sales_person where sales_person_name like '%$salesPersonSearch%' && branch_id='$branchId' order by sales_Person_name";


                $resultSearchSupp = $con->query($querySearchSalesPerson);
                $i = 1;
                while ($salesPersonData = $resultSearchSupp->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a style="font-size:5px;" id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/salesPersonMaster.php?updationid=<?php echo $salesPersonData['id']; ?>"
                        class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size:10px;"></i></a>

                    <a style="font-size:5px;" id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/salesPersonMaster.php?deletionid=<?php echo $salesPersonData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete <?php echo $salesPersonData['sales_person_name']; ?>?')"
                        class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash" style="font-size:10px;"></i></a>
                </td>
                <td><?php echo $salesPersonData['sales_person_name']; ?></td>
                <td><?php echo $salesPersonData['address1']; ?></td>
                <td><?php echo $salesPersonData['address2']; ?></td>
                <td><?php echo $salesPersonData['address3']; ?></td>
                <td><?php echo $salesPersonData['locality']; ?></td>
                <td><?php echo $salesPersonData['city']; ?></td>
                <td><?php echo $salesPersonData['pincode']; ?></td>
                <td><?php echo $salesPersonData['state']; ?></td>
                <td><?php echo $salesPersonData['landline']; ?></td>
                <td><?php echo $salesPersonData['mobile']; ?></td>
                <td><?php echo $salesPersonData['email']; ?></td>
                <td><?php echo $salesPersonData['pan']; ?></td>
                <td><?php echo date('d-m-Y h:i:s A', strtotime($salesPersonData['created_date'])); ?></td>



                <?php
                        $userIdFromSalesPerson = $salesPersonData['user_id'];
                        $branchIdFromSalesPerson = $salesPersonData['branch_id'];


                        $query  = "
                    select
                    u.user_name,
                    b.branch_name
                    from 
                    user_master1 u
                    inner join
                    branches b
                    on
                    u.branch_id = b.id
                    where u.id = '$userIdFromSalesPerson' AND b.id = '$branchIdFromSalesPerson'
                ";
                        $resultUserNameBranch = $con->query($query)->fetch_assoc();
                        ?>
                <td><?php echo $resultUserNameBranch['user_name']; ?></td>
                <td><?php echo $resultUserNameBranch['branch_name']; ?></td>

            </tr>
            <?php } ?>
            <?php
            } else {
                $querySearchSalesPerson = "select*from sales_person where branch_id='$branchId' order by sales_person_name";



                $resultSearchSupp = $con->query($querySearchSalesPerson);
                $i = 1;
                while ($salesPersonData = $resultSearchSupp->fetch_assoc()) {


                ?>


            <tr>
                <td><?php echo $i++; ?></td>
                <td>
                    <a style="font-size:5px;" id="editButton"
                        href="<?php echo BASE_URL; ?>/pages/salesPersonMaster.php?updationid=<?php echo $salesPersonData['id']; ?>"
                        class="btn btn-success editBtn"><i class="fa-solid fa-pen" style="font-size:10px;"></i></a>

                    <a style="font-size:5px;" id="deleteButton"
                        href="<?php echo BASE_URL; ?>/pages/salesPersonMaster.php?deletionid=<?php echo $salesPersonData['id']; ?>"
                        onclick="return confirm('Are you sure you want to delete <?php echo $salesPersonData['sales_person_name']; ?>?')"
                        class="btn btn-danger deleteBtn"><i class="fa-solid fa-trash" style="font-size:10px;"></i></a>
                </td>
                <td><?php echo $salesPersonData['sales_person_name']; ?></td>
                <td><?php echo $salesPersonData['address1']; ?></td>
                <td><?php echo $salesPersonData['address2']; ?></td>
                <td><?php echo $salesPersonData['address3']; ?></td>
                <td><?php echo $salesPersonData['locality']; ?></td>
                <td><?php echo $salesPersonData['city']; ?></td>
                <td><?php echo $salesPersonData['pincode']; ?></td>
                <td><?php echo $salesPersonData['state']; ?></td>
                <td><?php echo $salesPersonData['landline']; ?></td>
                <td><?php echo $salesPersonData['mobile']; ?></td>
                <td><?php echo $salesPersonData['email']; ?></td>
                <td><?php echo $salesPersonData['pan']; ?></td>
                <td><?php echo date('d-m-Y h:i:s A', strtotime($salesPersonData['created_date'])); ?></td>
                <?php
                        $userIdFromSalesPerson = $salesPersonData['user_id'];
                        $branchIdFromSalesPerson = $salesPersonData['branch_id'];


                        $query  = "
                    select
                    u.user_name,
                    b.branch_name
                    from 
                    user_master1 u
                    inner join
                    branches b
                    on
                    u.branch_id = b.id
                    where u.id = '$userIdFromSalesPerson' AND b.id = '$branchIdFromSalesPerson'
                ";
                        $resultUserNameBranch = $con->query($query)->fetch_assoc();

                        ?>
                <td><?php echo $resultUserNameBranch['user_name']; ?></td>
                <td><?php echo $resultUserNameBranch['branch_name']; ?></td>

            </tr>




            <?php }
            } ?>
        </tbody>
    </table>
</div>
<!-- salesPerson Table End-->


<style>
/* Style the select element to add a chevron */
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

#salesPersonForm {
    /* background-color: white; */

    position: absolute;
    top: 110px;
    width: 1150px;
    left: 300px;

    /* box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; */
}

.salesPersonSearchForm {
    display: flex;
    gap: 10px;
    position: absolute;
    top: 460px;
    left: 300px;
}

#exportForm {
    display: flex;
    gap: 10px;
    position: absolute;
    top: 440px;
    left: 1260px;

}

#salesPersonTable {

    position: absolute;
    top: 480px;
    left: 300px;
    width: 1200px;

    color: white;
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}

.form-floating {
    padding-top: 5px;
    color: #2B86C5;
    font-size: 13px;

}

#name {
    width: 560px;
    font-size: 20px;
    font-weight: bold;
    text-transform: capitalize;
    height: 50px;
    padding-top: 30px;
    /* margin-left:300px; */
}

#shortName {
    width: 500px;
    margin-left: 20px;
}

#address1 {
    width: 275px;
    height: 40px;
    padding-top: 24px;
    /* margin-left:300px; */
}

#address2 {
    width: 275px;
    height: 40px;
    padding-top: 24px;
    /* margin-top: 5px; */
}

#address3 {
    width: 275px;
    height: 40px;
    padding-top: 24px;
    /* margin-top: 5px; */
}

#locality {
    width: 275px;
    height: 40px;
    padding-top: 24px;


}

#city {
    width: 275px;
    height: 40px;
    padding-top: 24px;
    /* margin-left:280px;
    margin-top: 5px; */
}

#pinCode {
    width: 275px;
    height: 40px;
    padding-top: 24px;
    /* margin-left:280px; 
    margin-top: 5px; */
}

#state {
    width: 275px;
    height: 40px;
    padding-top: 10px;

    /* margin-left:20px;  */
}

#landline {
    width: 275px;
    height: 40px;
    padding-top: 24px;
    /* margin-left:570px; 
    margin-top: 5px; */
}

#mobile {
    width: 275px;
    height: 40px;
    padding-top: 24px;
    /* margin-left:570px;
    margin-top: 5px; */
}

#email {
    width: 275px;
    height: 40px;
    padding-top: 24px;
    /* margin-left:570px; 
    margin-top: 5px; */
}

#pan {
    width: 275px;
    height: 40px;
    padding-top: 24px;

    /* margin-top:10px; */
}
</style>

<?php
include_once(DIR_URL . '/includes/footer.php');
?>


<script>
window.onload = function() {

    document.getElementById("name").focus();
    document.getElementById("name").select();
}

document.getElementById("name").addEventListener("keypress", function(e) {

    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("address1").focus();
        document.getElementById("address1").select();
    }
})
document.getElementById("address1").addEventListener("keypress", function(e) {

    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("address2").focus();
        document.getElementById("address2").select();
    }
})
document.getElementById("address2").addEventListener("keypress", function(e) {

    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("address3").focus();
        document.getElementById("address3").select();
    }
})
document.getElementById("address3").addEventListener("keypress", function(e) {

    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("locality").focus();
        document.getElementById("locality").select();
    }
})
document.getElementById("locality").addEventListener("keypress", function(e) {

    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("city").focus();
        document.getElementById("city").select();
    }
})
document.getElementById("city").addEventListener("keypress", function(e) {

    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("pinCode").focus();
        document.getElementById("pinCode").select();
    }
})
document.getElementById("pinCode").addEventListener("keypress", function(e) {

    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("state").focus();
        document.getElementById("state").select();
    }
})
document.getElementById("state").addEventListener("keypress", function(e) {

    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("landline").focus();
        document.getElementById("landline").select();
    }
})
document.getElementById("landline").addEventListener("keypress", function(e) {

    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("mobile").focus();
        document.getElementById("mobile").select();
    }
})
document.getElementById("mobile").addEventListener("keypress", function(e) {

    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("email").focus();
        document.getElementById("email").select();
    }
})
document.getElementById("email").addEventListener("keypress", function(e) {

    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("pan").focus();
        document.getElementById("pan").select();
    }
})

document.getElementById("pan").addEventListener("keypress", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("submitSalesPersonBtn").focus();

    }

})




document.getElementById("pan").addEventListener("keypress", function(e) {
    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("updateSupBtn").focus();

    }

})



document.getElementById('pinCode').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9]$/) || (charStr === '' && this.value.includes(''))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('pinCode').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
});


document.getElementById('landline').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9 '  ']$/) || (charStr === '  ' && this.value.includes('  '))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('landline').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9 '  ']/g, '').replace(/(\..*?)\..*/g, '$1');
});




document.getElementById('mobile').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[0-9 ' ']$/) || (charStr === ' ' && this.value.includes(' '))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('mobile').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^0-9 ' ']/g, '').replace(/(\..*?)\..*/g, '$1');
});



document.getElementById('pan').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow digits (0-9) and a single decimal point
    if (!charStr.match(/^[A-Z0-9]$/) || (charStr === '' && this.value.includes(''))) {
        event.preventDefault(); // Prevent input if not a number or extra decimal
    }
});

document.getElementById('pan').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^A-Z0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
});



document.getElementById('city').addEventListener('keypress', function(event) {
    const charCode = event.which || event.keyCode; // Get the character code
    const charStr = String.fromCharCode(charCode); // Convert to a string

    // Allow alphabetic characters (a-z, A-Z) and space only
    if (!charStr.match(/^[a-zA-Z\s]$/)) {
        event.preventDefault(); // Prevent input if not an alphabetic character or space
    }
});

document.getElementById('city').addEventListener('input', function() {
    // Prevent any invalid characters that might slip through (e.g., copy-paste)
    this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
});




document.getElementById("salesPersonSearch").addEventListener("keypress", function(e) {

    if (e.key === "Enter") {
        e.preventDefault();
        document.getElementById("salesPersonSearchBtn").focus();
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

<?php ob_end_flush(); ?>
<!--












 -->