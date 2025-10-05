<style>

</style>

<?php
ob_start();
include_once("../config/config.php");
include_once(DIR_URL . "/includes/header.php");
include_once(DIR_URL . "/db/dbConnection.php");
include_once(DIR_URL . "/includes/navbar.php");
include_once(DIR_URL . "/includes/sidebar.php");
?>

<?php
if (isset($_SESSION['notification'])) {
} else {

    $_SESSION['notification'] = "";
}
?>
<?php if ($_SESSION['notification'] != '') { ?>
<div class="toast-container custom-toast">
    <div id="liveToast" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto text-white">Notification</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?php echo $_SESSION['notification'];
                unset($_SESSION['notification']);
                ?>
        </div>
    </div>
</div>
<?php } ?>

<?php


// $querySearchUserCrudPermission = "select*from user_crud_permission where 
//                                                    user_id = '$_SESSION[user_id]' 
//                                                    and branch_id = '$_SESSION[user_branch_id]'
//                                                    ";
//                 $resultSearchUserCrudPermission = $con->query($querySearchUserCrudPermission);


// $formNames = ['company_form', 'branch_form', 'supplier_form',
//                             'customer_form','sales_person_form','product_form',
//                             'brand_form','design_form','color_form','batch_form',
//                             'hsn_form','category_form','size_form','tax_form',
//                             'mrp_form','item_form','purchase_form','purchase_return_form',
//                             'sales_form','reports_form','user_info_form','user_management_form'
//                 ];

//                 while ($UserCrudPermissionData = $resultSearchUserCrudPermission->fetch_assoc()) {
//                 $formName = $UserCrudPermissionData['form_name'];

//                 // Check if form is in the list
//                     if (in_array($formName, $formNames)) {
//                         $_SESSION[$formName . '_create']  = $UserCrudPermissionData['create_op'];
//                         $_SESSION[$formName . '_reprint'] = $UserCrudPermissionData['reprint_op'];
//                         $_SESSION[$formName . '_update']  = $UserCrudPermissionData['update_op'];
//                         $_SESSION[$formName . '_delete']  = $UserCrudPermissionData['delete_op'];


//                         if($_SESSION[$formName.'_create'] == 0){

//                     
//                         }
//                     }
//                 }



$querySearchUserCrudPermission = "SELECT * FROM user_crud_permission WHERE 
                                   user_id = '{$_SESSION['user_id']}' 
                                   AND branch_id = '{$_SESSION['user_branch_id']}'";
$resultSearchUserCrudPermission = $con->query($querySearchUserCrudPermission);

$formNames = [
    'company_form',
    'branch_form',
    'supplier_form',
    'customer_form',
    'sales_person_form',
    'product_form',
    'brand_form',
    'design_form',
    'color_form',
    'batch_form',
    'hsn_form',
    'category_form',
    'size_form',
    'tax_form',
    'mrp_form',
    'item_form',
    'purchase_form',
    'purchase_return_form',
    'sales_form',
    'reports_form',
    'user_info_form',
    'user_management_form'
];

$hiddenForms = []; // Store forms that should be hidden





while ($UserCrudPermissionData = $resultSearchUserCrudPermission->fetch_assoc()) {
    $formName = $UserCrudPermissionData['form_name'];

    // Check if form is in the list
    if (in_array($formName, $formNames)) {
        $_SESSION[$formName . '_create']  = $UserCrudPermissionData['create_op'] ?? 0;
        $_SESSION[$formName . '_reprint'] = $UserCrudPermissionData['reprint_op'] ?? 0;
        $_SESSION[$formName . '_update']  = $UserCrudPermissionData['update_op'] ?? 0;
        $_SESSION[$formName . '_delete']  = $UserCrudPermissionData['delete_op'] ?? 0;

        // If create permission is 0, store the form name for hiding
        if ($_SESSION[$formName . '_create'] == 0) {
            $hiddenForms[] = $formName . '_create';
        }

        if ($_SESSION[$formName . '_reprint'] == 0) {
            $hiddenForms[] = $formName . '_reprint';
        }

        if ($_SESSION[$formName . '_update'] == 0) {
            $hiddenForms[] = $formName . '_update';
        }

        if ($_SESSION[$formName . '_delete'] == 0) {
            $hiddenForms[] = $formName . '_delete';
        }
    }
}

?>



<?php

foreach ($hiddenForms as $form) {
    echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var checkbox = document.getElementById("' . $form . '");
                            if (checkbox) {
                                checkbox.disabled = true;
                            } else {
                                
                            }
                        });
                      </script>';
}

?>






<style>
<?php // foreach ($hiddenForms as $form) {
//     echo "#$form { display: none; }" . PHP_EOL;
//   }



?>
</style>


<?php








// $_SESSION['company_form_create']=0;
// $_SESSION['company_form_reprint']=0;
// $_SESSION['company_form_update']=0;
// $_SESSION['company_form_delete']=0;


// $_SESSION['branch_form_create']=0;
// $_SESSION['branch_form_reprint']=0;
// $_SESSION['branch_form_update']=0;
// $_SESSION['branch_form_delete']=0;

// $_SESSION['supplier_form_create']=0;
// $_SESSION['supplier_form_reprint']=0;
// $_SESSION['supplier_form_update']=0;
// $_SESSION['supplier_form_delete']=0;

// $_SESSION['customer_form_create']=0;
// $_SESSION['customer_form_reprint']=0;
// $_SESSION['customer_form_update']=0;
// $_SESSION['customer_form_delete']=0;

// $_SESSION['sales_person_form_create']=0;
// $_SESSION['sales_person_form_reprint']=0;
// $_SESSION['sales_person_form_update']=0;
// $_SESSION['sales_person_form_delete']=0;

// $_SESSION['product_form_create']=0;
// $_SESSION['product_form_reprint']=0;
// $_SESSION['product_form_update']=0;
// $_SESSION['product_form_delete']=0;

// $_SESSION['brand_form_create']=0;
// $_SESSION['brand_form_reprint']=0;
// $_SESSION['brand_form_update']=0;
// $_SESSION['brand_form_delete']=0;

// $_SESSION['design_form_create']=0;
// $_SESSION['design_form_reprint']=0;
// $_SESSION['design_form_update']=0;
// $_SESSION['design_form_delete']=0;

// $_SESSION['color_form_create']=0;
// $_SESSION['color_form_reprint']=0;
// $_SESSION['color_form_update']=0;
// $_SESSION['color_form_delete']=0;

// $_SESSION['batch_form_create']=0;
// $_SESSION['batch_form_reprint']=0;
// $_SESSION['batch_form_update']=0;
// $_SESSION['batch_form_delete']=0;

// $_SESSION['hsn_form_create']=0;
// $_SESSION['hsn_form_reprint']=0;
// $_SESSION['hsn_form_update']=0;
// $_SESSION['hsn_form_delete']=0;

// $_SESSION['category_form_create']=0;
// $_SESSION['category_form_reprint']=0;
// $_SESSION['category_form_update']=0;
// $_SESSION['category_form_delete']=0;

// $_SESSION['size_form_create']=0;
// $_SESSION['size_form_reprint']=0;
// $_SESSION['size_form_update']=0;
// $_SESSION['size_form_delete']=0;

// $_SESSION['tax_form_create'] = 0;
// $_SESSION['tax_form_reprint'] = 0;
// $_SESSION['tax_form_update'] = 0;
// $_SESSION['tax_form_delete'] = 0;

// $_SESSION['mrp_form_create'] = 0;
// $_SESSION['mrp_form_reprint'] = 0;
// $_SESSION['mrp_form_update'] = 0;
// $_SESSION['mrp_form_delete'] = 0;

// $_SESSION['item_form_create'] = 0;
// $_SESSION['item_form_reprint'] = 0;
// $_SESSION['item_form_update'] = 0;
// $_SESSION['item_form_delete'] = 0;

// $_SESSION['purchase_form_create'] = 0;
// $_SESSION['purchase_form_reprint'] = 0;
// $_SESSION['purchase_form_update'] = 0;
// $_SESSION['purchase_form_delete'] = 0;


// $_SESSION['purchase_return_form_create'] = 0;
// $_SESSION['purchase_return_form_reprint'] = 0;
// $_SESSION['purchase_return_form_update'] = 0;
// $_SESSION['purchase_return_form_delete'] = 0;


// $_SESSION['sales_form_create']   = 0;
// $_SESSION['sales_form_reprint']   = 0;
// $_SESSION['sales_form_update']   = 0;
// $_SESSION['sales_form_delete']   = 0;

// $_SESSION['user_info_form_create'] = 0;
// $_SESSION['user_info_form_reprint'] = 0;
// $_SESSION['user_info_form_update'] = 0;
// $_SESSION['user_info_form_delete'] = 0;


// $_SESSION['user_management_form_create']= 0;
// $_SESSION['user_management_form_reprint']= 0;
// $_SESSION['user_management_form_update']= 0;
// $_SESSION['user_management_form_delete']= 0;




?>


<style>
.nav-tabs .nav-link.active#home-tab {
    background-color: dodgerblue !important;
    /* Green for Sales */
    color: white !important;
}

.nav-tabs .nav-link.active#profile-tab {
    background-color: dodgerblue !important;
    /* Green for Sales */
    color: white !important;
}

.custom-toast {
    position: absolute;
    bottom: 60px;
    left: 1160px;
    width: 90%;
    height: 40px;
    padding-top: 6px;
    font-weight: bolder;
}

#liveToast {
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    color: white;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}

.toast-header {
    background: none;
    border-bottom: none;
}

.btn-close-white {
    filter: invert(1);
}
</style>
<?php

$branchId = $_SESSION['user_branch_id'];
$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
$userRole = $_SESSION['user_role'];

$cbCompanyForm              = 0;
$cbCompanyC                 = 0;
$cbCompanyR                 = 0;
$cbCompanyU                 = 0;
$cbCompanyD                 = 0;

$cbBranchForm              = 0;
$cbBranchC                 = 0;
$cbBranchR                 = 0;
$cbBranchU                 = 0;
$cbBranchD                 = 0;

$cbSupplierForm              = 0;
$cbSupplierC                 = 0;
$cbSupplierR                 = 0;
$cbSupplierU                 = 0;
$cbSupplierD                 = 0;



$cbCustomerForm   = 0;
$cbCustomerC   = 0;
$cbCustomerR   = 0;
$cbCustomerU   = 0;
$cbCustomerD   = 0;

$cbSalesPersonForm              = 0;
$cbSalesPersonC                 = 0;
$cbSalesPersonR                 = 0;
$cbSalesPersonU                 = 0;
$cbSalesPersonD                 = 0;

$cbProductForm                  = 0;
$cbProductC                 = 0;
$cbProductR                 = 0;
$cbProductU                 = 0;
$cbProductD                 = 0;


$cbBrandForm                    = 0;
$cbBrandC                 = 0;
$cbBrandR                 = 0;
$cbBrandU                 = 0;
$cbBrandD                 = 0;


$cbDesignForm                   = 0;
$cbDesignC                 = 0;
$cbDesignR                 = 0;
$cbDesignU                 = 0;
$cbDesignD                 = 0;


$cbColorForm                    = 0;
$cbColorC                 = 0;
$cbColorR                 = 0;
$cbColorU                 = 0;
$cbColorD                 = 0;


$cbBatchForm                    = 0;
$cbBatchC                 = 0;
$cbBatchR                 = 0;
$cbBatchU                 = 0;
$cbBatchD                 = 0;


$cbHsnForm                      = 0;
$cbHsnC                 = 0;
$cbHsnR                 = 0;
$cbHsnU                 = 0;
$cbHsnD                 = 0;


$cbCategoryForm                 = 0;
$cbCategoryC                 = 0;
$cbCategoryR                 = 0;
$cbCategoryU                 = 0;
$cbCategoryD                 = 0;


$cbTaxForm                      = 0;
$cbTaxC                 = 0;
$cbTaxR                 = 0;
$cbTaxU                 = 0;
$cbTaxD                 = 0;


$cbSizeForm                     = 0;
$cbSizeC                 = 0;
$cbSizeR                 = 0;
$cbSizeU                 = 0;
$cbSizeD                 = 0;


$cbMrpForm                      = 0;
$cbMrpC                 = 0;
$cbMrpR                 = 0;
$cbMrpU                 = 0;
$cbMrpD                 = 0;


$cbItemForm                     = 0;
$cbItemC                 = 0;
$cbItemR                 = 0;
$cbItemU                 = 0;
$cbItemD                 = 0;


$cbPurchaseForm                 = 0;
$cbPurchaseC                 = 0;
$cbPurchaseR                 = 0;
$cbPurchaseU                 = 0;
$cbPurchaseD                 = 0;


$cbPurchaseReturnForm           = 0;
$cbPurchaseReturnC                 = 0;
$cbPurchaseReturnR                 = 0;
$cbPurchaseReturnU                 = 0;
$cbPurchaseReturnD                 = 0;


$cbSalesForm               = 0;
$cbSalesC                 = 0;
$cbSalesR                 = 0;
$cbSalesU                 = 0;
$cbSalesD                 = 0;

$cbReportForm                   = 0;

$cbUserForm                     = 0;
$cbUserC                        = 0;
$cbUserR                 = 0;
$cbUserU                 = 0;
$cbUserD                 = 0;

$cbUserManagementForm              = 0;
$cbUserManagementC                 = 0;
$cbUserManagementR                 = 0;
$cbUserManagementU                 = 0;
$cbUserManagementD                 = 0;




//check box variables 

$cbVariables = [
    '$cbCompanyForm',
    '$cbBranchForm',
    '$cbSupplierForm',
    '$cbCustomerForm',
    '$cbSalesPersonForm',
    '$cbProductForm',
    '$cbBrandForm',
    '$cbDesignForm',
    '$cbColorForm',
    '$cbBatchForm',
    '$cbCategoryForm',
    '$cbHsnForm',
    '$cbTaxForm',
    '$cbSizeForm',
    '$cbMrpForm',
    '$cbItemForm',
    '$cbPurchaseForm',
    '$cbPurchaseReturnForm',
    '$cbSalesForm',
    '$cbReportForm',
    '$cbUserForm',
    '$cbUserManagementForm'
];




$formNames = [
    'company_form',
    'branch_form',
    'supplier_form',
    'customer_form',
    'sales_person_form',
    'product_form',
    'brand_form',
    'design_form',
    'color_form',
    'batch_form',
    'hsn_form',
    'category_form',
    'tax_form',
    'size_form',
    'mrp_form',
    'item_form',
    'purchase_form',
    'purchase_return_form',
    'sales_form',
    'reports_form',
    'user_info_form',
    'user_management_form'
];


$formNames2 = [
    'company_form',
    'branch_form',
    'supplier_form',
    'customer_form',
    'sales_person_form',
    'product_form',
    'brand_form',
    'design_form',
    'color_form',
    'batch_form',
    'category_form',
    'hsn_form',
    'tax_form',
    'size_form',
    'mrp_form',
    'item_form',
    'purchase_form',
    'purchase_return_form',
    'sales_form',
    'reports_form',
    'user_info_form',
    'user_management_form'
];



$querySearchUserFormPermission  = "select*from user_forms_permission where user_id = '$_SESSION[user_id]'
    and branch_id = '$_SESSION[user_branch_id]'";
$resultSearchUserFormPermission1 = $con->query($querySearchUserFormPermission)->fetch_assoc();

foreach ($formNames as $formName) {



    if ($resultSearchUserFormPermission1[$formName] == 0) {
        if ($formName) { // Ensure comparison is correct
            echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var checkbox = document.getElementById("' . $formName . '_form");
                            if (checkbox) {
                                checkbox.disabled = true;
                            } else {
                                
                            }
                        });
                      </script>';
        }
    }
}






$querySearchUserFormPermission  = "select*from user_forms_permission where user_id = '$_SESSION[user_id]'
    and branch_id = '$branchId'";
$resultSearchUserFormPermission = $con->query($querySearchUserFormPermission)->fetch_assoc();
$i = 0;
foreach ($formNames as $formName) {


    if ($resultSearchUserFormPermission[$formName] == 1) {
        $cbVariables[$i] = 1;
    } else {



        $cbVariables[$i] = 0;
    }
    $i++;
}




if (isset($_POST['searchUser'])) {
    extract($_POST);

    $querySearchUserFormPermission  = "select*from user_forms_permission where user_id = '$userId'
                                        and branch_id = '$branchId'";
    $resultSearchUserFormPermission = $con->query($querySearchUserFormPermission)->fetch_assoc();
    $i = 0;
    foreach ($formNames as $formName) {


        if ($resultSearchUserFormPermission[$formName] == 1) {
            $cbVariables[$i] = 1;
            // echo $i."value = 1". $formName;
            // echo "<br>";

        } else {

            $cbVariables[$i] = 0;

?>


<?php
        }
        $i++;
    }



    // echo "<pre>";
    // print_r($cbVariables);
    // echo "</pre>";



    $querySearchUserCrudPermission = "select*from  user_crud_permission where user_id = '$userId'
                                      and branch_id = '$branchId'";

    $resultSearchUserCrudPermission = $con->query($querySearchUserCrudPermission);

    $s = 0;
    while ($UserCrudPermissionData = $resultSearchUserCrudPermission->fetch_assoc()) {





        if ($UserCrudPermissionData['form_name'] == $formNames2[$s] && $UserCrudPermissionData['create_op'] == 1) {

            $_SESSION[$formNames2[$s] . '_create']  = $UserCrudPermissionData['create_op'];
        } else {
            $_SESSION[$formNames2[$s] . '_create']  = 0;
        }

        if ($UserCrudPermissionData['form_name'] == $formNames2[$s]  && $UserCrudPermissionData['reprint_op'] == 1) {
            $_SESSION[$formNames2[$s] . '_reprint'] = $UserCrudPermissionData['reprint_op'];
        } else {
            $_SESSION[$formNames2[$s] . '_reprint'] = 0;
        }
        if ($UserCrudPermissionData['form_name'] == $formNames2[$s]  && $UserCrudPermissionData['update_op'] == 1) {

            $_SESSION[$formNames2[$s] . '_update']  = $UserCrudPermissionData['update_op'];
        } else {
            $_SESSION[$formNames2[$s] . '_update'] = 0;
        }
        if ($UserCrudPermissionData['form_name'] == $formNames2[$s]  && $UserCrudPermissionData['delete_op'] == 1) {

            $_SESSION[$formNames2[$s] . '_delete']  = $UserCrudPermissionData['delete_op'];
        } else {
            $_SESSION[$formNames2[$s] . '_delete'] = 0;
        }

        // echo $UserCrudPermissionData['form_name']." - ".$UserCrudPermissionData['create_op'];
        // echo $UserCrudPermissionData['form_name']." - ".$UserCrudPermissionData['reprint_op'];
        // echo $UserCrudPermissionData['form_name']." - ".$UserCrudPermissionData['update_op'];
        // echo $UserCrudPermissionData['form_name']." - ".$UserCrudPermissionData['delete_op'];



        $s++;
    }



    // echo $_SESSION['size_form_create'];
    // echo "<br>";
    // echo $_SESSION['size_form_reprint'];
    // echo "<br>";
    // echo $_SESSION['size_form_update'];
    // echo "<br>";
    // echo $_SESSION['size_form_delete'];
    // echo "<br>";


}





// if(isset($_POST['userPermissionSubmit'])){
//         extract($_POST);

//         $cbCompanyForm   = isset($cbCompanyForm )?$cbCompanyForm :0;
//         $cbCompanyC      = isset($cbCompanyC    )?$cbCompanyC    :0;   
//         $cbCompanyR      = isset($cbCompanyR    )?$cbCompanyR    :0;   
//         $cbCompanyU      = isset($cbCompanyU    )?$cbCompanyU    :0;   
//         $cbCompanyD      = isset($cbCompanyD    )?$cbCompanyD    :0;   

//         $cbBranchForm   = isset($cbBranchForm )?$cbBranchForm :0;
//         $cbBranchC      = isset($cbBranchC    )?$cbBranchC    :0;   
//         $cbBranchR      = isset($cbBranchR    )?$cbBranchR    :0;   
//         $cbBranchU      = isset($cbBranchU    )?$cbBranchU    :0;   
//         $cbBranchD      = isset($cbBranchD    )?$cbBranchD    :0;   



//          $cbSupplierForm   = isset($cbSupplierForm )?$cbSupplierForm :0;
//          $cbSupplierC      = isset($cbSupplierC    )?$cbSupplierC    :0;   
//          $cbSupplierR      = isset($cbSupplierR    )?$cbSupplierR    :0;   
//          $cbSupplierU      = isset($cbSupplierU    )?$cbSupplierU    :0;   
//          $cbSupplierD      = isset($cbSupplierD    )?$cbSupplierD    :0;   

//          $cbCustomerForm   = isset($cbCustomerForm )?$cbCustomerForm :0;
//          $cbCustomerC      = isset($cbCustomerC    )?$cbCustomerC    :0;   
//          $cbCustomerR      = isset($cbCustomerR    )?$cbCustomerR    :0;   
//          $cbCustomerU      = isset($cbCustomerU    )?$cbCustomerU    :0;   
//          $cbCustomerD      = isset($cbCustomerD    )?$cbCustomerD    :0;   

//          $cbSalesPersonForm   = isset($cbSalesPersonForm )?$cbSalesPersonForm :0;
//          $cbSalesPersonC      = isset($cbSalesPersonC    )?$cbSalesPersonC    :0;   
//          $cbSalesPersonR      = isset($cbSalesPersonR    )?$cbSalesPersonR    :0;   
//          $cbSalesPersonU      = isset($cbSalesPersonU    )?$cbSalesPersonU    :0;   
//          $cbSalesPersonD      = isset($cbSalesPersonD    )?$cbSalesPersonD    :0;   

//          $cbProductForm   = isset($cbProductForm )?$cbProductForm :0;
//          $cbProductC      = isset($cbProductC    )?$cbProductC    :0;   
//          $cbProductR      = isset($cbProductR    )?$cbProductR    :0;   
//          $cbProductU      = isset($cbProductU    )?$cbProductU    :0;   
//          $cbProductD      = isset($cbProductD    )?$cbProductD    :0;   


//          $cbBrandForm   = isset($cbBrandForm )?$cbBrandForm :0;
//          $cbBrandC      = isset($cbBrandC    )?$cbBrandC    :0;   
//          $cbBrandR      = isset($cbBrandR    )?$cbBrandR    :0;   
//          $cbBrandU      = isset($cbBrandU    )?$cbBrandU    :0;   
//          $cbBrandD      = isset($cbBrandD    )?$cbBrandD    :0;   


//          $cbDesignForm   = isset($cbDesignForm )?$cbDesignForm :0;
//          $cbDesignC      = isset($cbDesignC    )?$cbDesignC    :0;   
//          $cbDesignR      = isset($cbDesignR    )?$cbDesignR    :0;   
//          $cbDesignU      = isset($cbDesignU    )?$cbDesignU    :0;   
//          $cbDesignD      = isset($cbDesignD    )?$cbDesignD    :0;   


//          $cbColorForm   = isset($cbColorForm )?$cbColorForm :0;
//          $cbColorC      = isset($cbColorC    )?$cbColorC    :0;   
//          $cbColorR      = isset($cbColorR    )?$cbColorR    :0;   
//          $cbColorU      = isset($cbColorU    )?$cbColorU    :0;   
//          $cbColorD      = isset($cbColorD    )?$cbColorD    :0;   


//          $cbBatchForm   = isset($cbBatchForm )?$cbBatchForm :0;
//          $cbBatchC      = isset($cbBatchC    )?$cbBatchC    :0;   
//          $cbBatchR      = isset($cbBatchR    )?$cbBatchR    :0;   
//          $cbBatchU      = isset($cbBatchU    )?$cbBatchU    :0;   
//          $cbBatchD      = isset($cbBatchD    )?$cbBatchD    :0;   


//          $cbCategoryForm   = isset($cbCategoryForm )?$cbCategoryForm :0;
//          $cbCategoryC      = isset($cbCategoryC    )?$cbCategoryC    :0;   
//          $cbCategoryR      = isset($cbCategoryR    )?$cbCategoryR    :0;   
//          $cbCategoryU      = isset($cbCategoryU    )?$cbCategoryU    :0;   
//          $cbCategoryD      = isset($cbCategoryD    )?$cbCategoryD    :0;   


//          $cbHsnForm   = isset($cbHsnForm )?$cbHsnForm :0;
//          $cbHsnC      = isset($cbHsnC    )?$cbHsnC    :0;   
//          $cbHsnR      = isset($cbHsnR    )?$cbHsnR    :0;   
//          $cbHsnU      = isset($cbHsnU    )?$cbHsnU    :0;   
//          $cbHsnD      = isset($cbHsnD    )?$cbHsnD    :0;   


//          $cbTaxForm   = isset($cbTaxForm )?$cbTaxForm :0;
//          $cbTaxC      = isset($cbTaxC    )?$cbTaxC    :0;   
//          $cbTaxR      = isset($cbTaxR    )?$cbTaxR    :0;   
//          $cbTaxU      = isset($cbTaxU    )?$cbTaxU    :0;   
//          $cbTaxD      = isset($cbTaxD    )?$cbTaxD    :0;   


//          $cbSizeForm   = isset($cbSizeForm )?$cbSizeForm :0;
//          $cbSizeC      = isset($cbSizeC    )?$cbSizeC    :0;   
//          $cbSizeR      = isset($cbSizeR    )?$cbSizeR    :0;   
//          $cbSizeU      = isset($cbSizeU    )?$cbSizeU    :0;   
//          $cbSizeD      = isset($cbSizeD    )?$cbSizeD    :0;   


//          $cbMrpForm   = isset($cbMrpForm )?$cbMrpForm :0;
//          $cbMrpC      = isset($cbMrpC    )?$cbMrpC    :0;   
//          $cbMrpR      = isset($cbMrpR    )?$cbMrpR    :0;   
//          $cbMrpU      = isset($cbMrpU    )?$cbMrpU    :0;   
//          $cbMrpD      = isset($cbMrpD    )?$cbMrpD    :0;   


//          $cbItemForm   = isset($cbItemForm )?$cbItemForm :0;
//          $cbItemC      = isset($cbItemC    )?$cbItemC    :0;   
//          $cbItemR      = isset($cbItemR    )?$cbItemR    :0;   
//          $cbItemU      = isset($cbItemU    )?$cbItemU    :0;   
//          $cbItemD      = isset($cbItemD    )?$cbItemD    :0;   


//          $cbPurchaseForm   = isset($cbPurchaseForm )?$cbPurchaseForm :0;
//          $cbPurchaseC      = isset($cbPurchaseC    )?$cbPurchaseC    :0;   
//          $cbPurchaseR      = isset($cbPurchaseR    )?$cbPurchaseR    :0;   
//          $cbPurchaseU      = isset($cbPurchaseU    )?$cbPurchaseU    :0;   
//          $cbPurchaseD      = isset($cbPurchaseD    )?$cbPurchaseD    :0;   


//          $cbPurchaseReturnForm   = isset($cbPurchaseReturnForm )?$cbPurchaseReturnForm :0;
//          $cbPurchaseReturnC      = isset($cbPurchaseReturnC    )?$cbPurchaseReturnC    :0;   
//          $cbPurchaseReturnR      = isset($cbPurchaseReturnR    )?$cbPurchaseReturnR    :0;   
//          $cbPurchaseReturnU      = isset($cbPurchaseReturnU    )?$cbPurchaseReturnU    :0;   
//          $cbPurchaseReturnD      = isset($cbPurchaseReturnD    )?$cbPurchaseReturnD    :0;   


//          $cbSalesForm   = isset($cbSalesForm )?$cbSalesForm :0;
//          $cbSalesC      = isset($cbSalesC    )?$cbSalesC    :0;   
//          $cbSalesR      = isset($cbSalesR    )?$cbSalesR    :0;   
//          $cbSalesU      = isset($cbSalesU    )?$cbSalesU    :0;   
//          $cbSalesD      = isset($cbSalesD    )?$cbSalesD    :0;   


//          $cbUserForm   = isset($cbUserForm )?$cbUserForm :0;
//          $cbUserC      = isset($cbUserC    )?$cbUserC    :0;   
//          $cbUserR      = isset($cbUserR    )?$cbUserR    :0;   
//          $cbUserU      = isset($cbUserU    )?$cbUserU    :0;   
//          $cbUserD      = isset($cbUserD    )?$cbUserD    :0;   


//          $cbUserManagementForm   = isset($cbUserManagementForm )?$cbUserManagementForm :0;
//          $cbUserManagementC      = isset($cbUserManagementC    )?$cbUserManagementC    :0;   
//          $cbUserManagementR      = isset($cbUserManagementR    )?$cbUserManagementR    :0;   
//          $cbUserManagementU      = isset($cbUserManagementU    )?$cbUserManagementU    :0;   
//          $cbUserManagementD      = isset($cbUserManagementD    )?$cbUserManagementD    :0;   


//        $queryUpdateUserFormPermission = "update user_forms_permission set company_form = '$cbCompanyForm',
//                                         branch_form = '$cbBranchForm', supplier_form = '$cbSupplierForm',
//                                         customer_form = '$cbCustomerForm', sales_person_form = '$cbSalesPersonForm',
//                                          product_form = '$cbProductForm', brand_form = '$cbBrandForm',
//                                           design_form = '$cbDesignForm', color_form = '$cbColorForm',
//                                            batch_form = '$cbBatchForm', category_form = '$cbCategoryForm',
//                                             hsn_form = '$cbHsnForm', tax_form = '$cbTaxForm',
//                                             size_form = '$cbSizeForm', mrp_form = '$cbMrpForm',
//                                             item_form = '$cbItemForm', purchase_form = '$cbPurchaseForm',
//                                              purchase_return_form = '$cbPurchaseReturnForm', sales_form = '$cbSalesForm',
//                                              reports_form = '$cbReportForm', user_info_form = '$cbUserForm'
//                                              , user_management_form = '$cbUserManagementForm'
//                                              where user_id = '$userId' and branch_id = '$branchId'";


//         $resultUpdateUserFormPermission = $con->query($queryUpdateUserFormPermission);


//         // $crudArray = [
//         //     'company_form'=>['$cbCompanyC','$cbCompanyR','$cbCompanyU','$cbCompanyD'],
//         //     'branch_form'=>['$cbBranchC','$cbBranchR','$cbBranchU','$cbBranchD'],
//         //     'supplier_form'=>['$cbSupplierC','$cbSupplierR','$cbSupplierU','$cbSupplierD'],
//         // ];

//         $crudArray = [
//             'company_form' => [$cbCompanyC, $cbCompanyR, $cbCompanyU, $cbCompanyD],
//             'branch_form' => [$cbBranchC, $cbBranchR, $cbBranchU, $cbBranchD],
//             'supplier_form' => [$cbSupplierC, $cbSupplierR, $cbSupplierU, $cbSupplierD],
//             'customer_form' => [$cbCustomerC, $cbCustomerR, $cbCustomerU, $cbCustomerD],
//             'sales_person_form' => [$cbSalesPersonC, $cbSalesPersonR, $cbSalesPersonU, $cbSalesPersonD],
//             'product_form' => [$cbProductC, $cbProductR, $cbProductU, $cbProductD],
//             'brand_form' => [$cbBrandC, $cbBrandR, $cbBrandU, $cbBrandD],
//             'design_form' => [$cbDesignC, $cbDesignR, $cbDesignU, $cbDesignD],
//             'color_form' => [$cbColorC, $cbColorR, $cbColorU, $cbColorD],
//             'batch_form' => [$cbBatchC, $cbBatchR, $cbBatchU, $cbBatchD],
//             'category_form' => [$cbCategoryC, $cbCategoryR, $cbCategoryU, $cbCategoryD],
//             'hsn_form' => [$cbHsnC, $cbHsnR, $cbHsnU, $cbHsnD],
//             'size_form' => [$cbSizeC, $cbSizeR, $cbSizeU, $cbSizeD],
//             'tax_form' => [$cbTaxC, $cbTaxR, $cbTaxU, $cbTaxD],
//             'mrp_form' => [$cbMrpC, $cbMrpR, $cbMrpU, $cbMrpD],
//             'item_form' => [$cbItemC, $cbItemR, $cbItemU, $cbItemD],
//             'purchase_form' => [$cbPurchaseC, $cbPurchaseR, $cbPurchaseU, $cbPurchaseD],
//             'purchase_return_form' => [$cbPurchaseReturnC, $cbPurchaseReturnR, $cbPurchaseReturnU, $cbPurchaseReturnD],
//             'sales_form' => [$cbSalesC, $cbSalesR, $cbSalesU, $cbSalesD],
//             'user_info_form' => [$cbUserC, $cbUserR, $cbUserU, $cbUserD],
//             'user_management_form' => [$cbUserManagementC, $cbUserManagementR, $cbUserManagementU, $cbUserManagementD],

//         ];

//         foreach($crudArray as $key => $item){



//             $queryUpdateUserCrudPermission = "update user_crud_permission set create_op = '$item[0]', 
//                                             reprint_op = '$item[1]', update_op = '$item[2]', delete_op = '$item[3]'
//                                             where form_name = '$key' and user_id = '$userId' and branch_id = '$branchId'"; 



//             $resultUpdateUserCrudPermission = $con->query($queryUpdateUserCrudPermission);
//      }



//     //    echo  "<br>";
//     //    echo "supplier Form = ".$cbSupplierForm;
//     //    echo "<br>";
//     //    echo "category form = ".$cbCategoryForm;
//     $userId = "";
//     $userName = "";
//     $userRole = "";

//     $_SESSION['notification'] = 'User Permission Is Updated Successfully';
//     header("Location:".BASE_URL."/pages/userAccessManagement.php");

// }   


if (isset($_POST['userPermissionSubmit'])) {
    mysqli_begin_transaction($con);
    try {
        extract($_POST);

        // Form permissions
        $cbCompanyForm   = isset($cbCompanyForm) ? $cbCompanyForm : 0;
        $cbCompanyC      = isset($cbCompanyC) ? $cbCompanyC    : 0;
        $cbCompanyR      = isset($cbCompanyR) ? $cbCompanyR    : 0;
        $cbCompanyU      = isset($cbCompanyU) ? $cbCompanyU    : 0;
        $cbCompanyD      = isset($cbCompanyD) ? $cbCompanyD    : 0;

        $cbBranchForm   = isset($cbBranchForm) ? $cbBranchForm : 0;
        $cbBranchC      = isset($cbBranchC) ? $cbBranchC    : 0;
        $cbBranchR      = isset($cbBranchR) ? $cbBranchR    : 0;
        $cbBranchU      = isset($cbBranchU) ? $cbBranchU    : 0;
        $cbBranchD      = isset($cbBranchD) ? $cbBranchD    : 0;

        $cbSupplierForm   = isset($cbSupplierForm) ? $cbSupplierForm : 0;
        $cbSupplierC      = isset($cbSupplierC) ? $cbSupplierC    : 0;
        $cbSupplierR      = isset($cbSupplierR) ? $cbSupplierR    : 0;
        $cbSupplierU      = isset($cbSupplierU) ? $cbSupplierU    : 0;
        $cbSupplierD      = isset($cbSupplierD) ? $cbSupplierD    : 0;

        $cbCustomerForm   = isset($cbCustomerForm) ? $cbCustomerForm : 0;
        $cbCustomerC      = isset($cbCustomerC) ? $cbCustomerC    : 0;
        $cbCustomerR      = isset($cbCustomerR) ? $cbCustomerR    : 0;
        $cbCustomerU      = isset($cbCustomerU) ? $cbCustomerU    : 0;
        $cbCustomerD      = isset($cbCustomerD) ? $cbCustomerD    : 0;

        $cbSalesPersonForm   = isset($cbSalesPersonForm) ? $cbSalesPersonForm : 0;
        $cbSalesPersonC      = isset($cbSalesPersonC) ? $cbSalesPersonC    : 0;
        $cbSalesPersonR      = isset($cbSalesPersonR) ? $cbSalesPersonR    : 0;
        $cbSalesPersonU      = isset($cbSalesPersonU) ? $cbSalesPersonU    : 0;
        $cbSalesPersonD      = isset($cbSalesPersonD) ? $cbSalesPersonD    : 0;

        $cbProductForm   = isset($cbProductForm) ? $cbProductForm : 0;
        $cbProductC      = isset($cbProductC) ? $cbProductC    : 0;
        $cbProductR      = isset($cbProductR) ? $cbProductR    : 0;
        $cbProductU      = isset($cbProductU) ? $cbProductU    : 0;
        $cbProductD      = isset($cbProductD) ? $cbProductD    : 0;

        $cbBrandForm = isset($cbBrandForm) ? $cbBrandForm : 0;
        $cbBrandC = isset($cbBrandC) ? $cbBrandC : 0;
        $cbBrandR = isset($cbBrandR) ? $cbBrandR : 0;
        $cbBrandU = isset($cbBrandU) ? $cbBrandU : 0;
        $cbBrandD = isset($cbBrandD) ? $cbBrandD : 0;

        $cbDesignForm = isset($cbDesignForm) ? $cbDesignForm : 0;
        $cbDesignC = isset($cbDesignC) ? $cbDesignC : 0;
        $cbDesignR = isset($cbDesignR) ? $cbDesignR : 0;
        $cbDesignU = isset($cbDesignU) ? $cbDesignU : 0;
        $cbDesignD = isset($cbDesignD) ? $cbDesignD : 0;

        $cbColorForm = isset($cbColorForm) ? $cbColorForm : 0;
        $cbColorC = isset($cbColorC) ? $cbColorC : 0;
        $cbColorR = isset($cbColorR) ? $cbColorR : 0;
        $cbColorU = isset($cbColorU) ? $cbColorU : 0;
        $cbColorD = isset($cbColorD) ? $cbColorD : 0;

        $cbBatchForm = isset($cbBatchForm) ? $cbBatchForm : 0;
        $cbBatchC = isset($cbBatchC) ? $cbBatchC : 0;
        $cbBatchR = isset($cbBatchR) ? $cbBatchR : 0;
        $cbBatchU = isset($cbBatchU) ? $cbBatchU : 0;
        $cbBatchD = isset($cbBatchD) ? $cbBatchD : 0;

        $cbCategoryForm = isset($cbCategoryForm) ? $cbCategoryForm : 0;
        $cbCategoryC = isset($cbCategoryC) ? $cbCategoryC : 0;
        $cbCategoryR = isset($cbCategoryR) ? $cbCategoryR : 0;
        $cbCategoryU = isset($cbCategoryU) ? $cbCategoryU : 0;
        $cbCategoryD = isset($cbCategoryD) ? $cbCategoryD : 0;

        $cbHsnForm = isset($cbHsnForm) ? $cbHsnForm : 0;
        $cbHsnC = isset($cbHsnC) ? $cbHsnC : 0;
        $cbHsnR = isset($cbHsnR) ? $cbHsnR : 0;
        $cbHsnU = isset($cbHsnU) ? $cbHsnU : 0;
        $cbHsnD = isset($cbHsnD) ? $cbHsnD : 0;

        $cbTaxForm = isset($cbTaxForm) ? $cbTaxForm : 0;
        $cbTaxC = isset($cbTaxC) ? $cbTaxC : 0;
        $cbTaxR = isset($cbTaxR) ? $cbTaxR : 0;
        $cbTaxU = isset($cbTaxU) ? $cbTaxU : 0;
        $cbTaxD = isset($cbTaxD) ? $cbTaxD : 0;

        $cbSizeForm = isset($cbSizeForm) ? $cbSizeForm : 0;
        $cbSizeC = isset($cbSizeC) ? $cbSizeC : 0;
        $cbSizeR = isset($cbSizeR) ? $cbSizeR : 0;
        $cbSizeU = isset($cbSizeU) ? $cbSizeU : 0;
        $cbSizeD = isset($cbSizeD) ? $cbSizeD : 0;

        $cbMrpForm = isset($cbMrpForm) ? $cbMrpForm : 0;
        $cbMrpC = isset($cbMrpC) ? $cbMrpC : 0;
        $cbMrpR = isset($cbMrpR) ? $cbMrpR : 0;
        $cbMrpU = isset($cbMrpU) ? $cbMrpU : 0;
        $cbMrpD = isset($cbMrpD) ? $cbMrpD : 0;

        $cbItemForm = isset($cbItemForm) ? $cbItemForm : 0;
        $cbItemC = isset($cbItemC) ? $cbItemC : 0;
        $cbItemR = isset($cbItemR) ? $cbItemR : 0;
        $cbItemU = isset($cbItemU) ? $cbItemU : 0;
        $cbItemD = isset($cbItemD) ? $cbItemD : 0;

        $cbPurchaseForm = isset($cbPurchaseForm) ? $cbPurchaseForm : 0;
        $cbPurchaseC = isset($cbPurchaseC) ? $cbPurchaseC : 0;
        $cbPurchaseR = isset($cbPurchaseR) ? $cbPurchaseR : 0;
        $cbPurchaseU = isset($cbPurchaseU) ? $cbPurchaseU : 0;
        $cbPurchaseD = isset($cbPurchaseD) ? $cbPurchaseD : 0;

        $cbPurchaseReturnForm = isset($cbPurchaseReturnForm) ? $cbPurchaseReturnForm : 0;
        $cbPurchaseReturnC = isset($cbPurchaseReturnC) ? $cbPurchaseReturnC : 0;
        $cbPurchaseReturnR = isset($cbPurchaseReturnR) ? $cbPurchaseReturnR : 0;
        $cbPurchaseReturnU = isset($cbPurchaseReturnU) ? $cbPurchaseReturnU : 0;
        $cbPurchaseReturnD = isset($cbPurchaseReturnD) ? $cbPurchaseReturnD : 0;

        $cbSalesForm = isset($cbSalesForm) ? $cbSalesForm : 0;
        $cbSalesC = isset($cbSalesC) ? $cbSalesC : 0;
        $cbSalesR = isset($cbSalesR) ? $cbSalesR : 0;
        $cbSalesU = isset($cbSalesU) ? $cbSalesU : 0;
        $cbSalesD = isset($cbSalesD) ? $cbSalesD : 0;

        $cbUserForm = isset($cbUserForm) ? $cbUserForm : 0;
        $cbUserC = isset($cbUserC) ? $cbUserC : 0;
        $cbUserR = isset($cbUserR) ? $cbUserR : 0;
        $cbUserU = isset($cbUserU) ? $cbUserU : 0;
        $cbUserD = isset($cbUserD) ? $cbUserD : 0;

        $cbUserManagementForm = isset($cbUserManagementForm) ? $cbUserManagementForm : 0;
        $cbUserManagementC = isset($cbUserManagementC) ? $cbUserManagementC : 0;
        $cbUserManagementR = isset($cbUserManagementR) ? $cbUserManagementR : 0;
        $cbUserManagementU = isset($cbUserManagementU) ? $cbUserManagementU : 0;
        $cbUserManagementD = isset($cbUserManagementD) ? $cbUserManagementD : 0;

        $queryUpdateUserFormPermission = "UPDATE user_forms_permission SET 
            company_form = '$cbCompanyForm',
            branch_form = '$cbBranchForm',
            supplier_form = '$cbSupplierForm',
            customer_form = '$cbCustomerForm',
            sales_person_form = '$cbSalesPersonForm',
            product_form = '$cbProductForm',
            brand_form = '$cbBrandForm',
            design_form = '$cbDesignForm',
            color_form = '$cbColorForm',
            batch_form = '$cbBatchForm',
            category_form = '$cbCategoryForm',
            hsn_form = '$cbHsnForm',
            tax_form = '$cbTaxForm',
            size_form = '$cbSizeForm',
            mrp_form = '$cbMrpForm',
            item_form = '$cbItemForm',
            purchase_form = '$cbPurchaseForm',
            purchase_return_form = '$cbPurchaseReturnForm',
            sales_form = '$cbSalesForm',
            reports_form = '$cbReportForm',
            user_info_form = '$cbUserForm',
            user_management_form = '$cbUserManagementForm'
        WHERE user_id = '$userId' AND branch_id = '$branchId'";
        $con->query($queryUpdateUserFormPermission);

        $crudArray = [
            'company_form' => [$cbCompanyC, $cbCompanyR, $cbCompanyU, $cbCompanyD],
            'branch_form' => [$cbBranchC, $cbBranchR, $cbBranchU, $cbBranchD],
            'supplier_form' => [$cbSupplierC, $cbSupplierR, $cbSupplierU, $cbSupplierD],
            'customer_form' => [$cbCustomerC, $cbCustomerR, $cbCustomerU, $cbCustomerD],
            'sales_person_form' => [$cbSalesPersonC, $cbSalesPersonR, $cbSalesPersonU, $cbSalesPersonD],
            'product_form' => [$cbProductC, $cbProductR, $cbProductU, $cbProductD],
            'brand_form' => [$cbBrandC, $cbBrandR, $cbBrandU, $cbBrandD],
            'design_form' => [$cbDesignC, $cbDesignR, $cbDesignU, $cbDesignD],
            'color_form' => [$cbColorC, $cbColorR, $cbColorU, $cbColorD],
            'batch_form' => [$cbBatchC, $cbBatchR, $cbBatchU, $cbBatchD],
            'category_form' => [$cbCategoryC, $cbCategoryR, $cbCategoryU, $cbCategoryD],
            'hsn_form' => [$cbHsnC, $cbHsnR, $cbHsnU, $cbHsnD],
            'size_form' => [$cbSizeC, $cbSizeR, $cbSizeU, $cbSizeD],
            'tax_form' => [$cbTaxC, $cbTaxR, $cbTaxU, $cbTaxD],
            'mrp_form' => [$cbMrpC, $cbMrpR, $cbMrpU, $cbMrpD],
            'item_form' => [$cbItemC, $cbItemR, $cbItemU, $cbItemD],
            'purchase_form' => [$cbPurchaseC, $cbPurchaseR, $cbPurchaseU, $cbPurchaseD],
            'purchase_return_form' => [$cbPurchaseReturnC, $cbPurchaseReturnR, $cbPurchaseReturnU, $cbPurchaseReturnD],
            'sales_form' => [$cbSalesC, $cbSalesR, $cbSalesU, $cbSalesD],
            'user_info_form' => [$cbUserC, $cbUserR, $cbUserU, $cbUserD],
            'user_management_form' => [$cbUserManagementC, $cbUserManagementR, $cbUserManagementU, $cbUserManagementD],
        ];

        foreach ($crudArray as $key => $item) {
            $queryUpdateUserCrudPermission = "UPDATE user_crud_permission SET 
                create_op = '$item[0]', 
                reprint_op = '$item[1]', 
                update_op = '$item[2]', 
                delete_op = '$item[3]'
            WHERE form_name = '$key' AND user_id = '$userId' AND branch_id = '$branchId'";
            $con->query($queryUpdateUserCrudPermission);
        }

        mysqli_commit($con);
        $_SESSION['notification'] = 'User Permission Is Updated Successfully';
        header("Location:" . BASE_URL . "/pages/userAccessManagement.php");
        exit;
    } catch (Exception $e) {
        mysqli_rollback($con);
        echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                let toastLive = document.getElementById("liveToast");
                if (toastLive) {
                    toastLive.querySelector(".toast-body").textContent = "Error: ' . addslashes('Oops! something went wrong') . '";
                    let toast = new bootstrap.Toast(toastLive);
                    toast.show();
                }
            });
        </script>';
    }
}
?>




<div id="response_message">


</div>


<form action="" method="post" style="">
    <div style="margin-left:300px;margin-top:50px">
        <h4 style="word-spacing:px;letter-spacing:12px;text-transform:uppercase;">User Permission</h4>
        <hr style="width:500px">
        <br>
        <div class="form-floating" style="display:flex;gap:12px">

            <input type="text" name="userName" style="width: 260px;font-weight:bold;
background-color:blanchedalmond;" id="userName" autocomplete="off" value="<?php echo $userName; ?>"
                class="form-control" placeholder="">
            <label for="form-floating" style="color:#2B86C5;">Press F2 For User Info</label>

            <div class="form-floating" style="">
                <input type="text" style="width:200px;font-weight:bold;" name="userRole" readonly id="userRole"
                    autocomplete="off" value="<?php echo $userRole; ?>" class="form-control" placeholder="">
                <label for="form-floating" style="color:#2B86C5;">User Role</label>
            </div>

            <div style="display:flex" hidden>
                <input type="text" name="userId" id="userId" value="<?php echo $userId; ?>" class="form-control"
                    style="width:50px;height:30px">
                <input type="text" name="branchId" id="branchId" value="<?php echo $branchId; ?>" class="form-control"
                    style="width:50px;height:30px">
                <button type="submit" name="searchUser" id="searchUser">S</button>
            </div>

        </div>
        <br>
        <hr style="width:500px">
    </div>
    <!-- Tab Navigation -->

    <!-- <div class="nav nav-tabs" id="nav-tab" role="tablist" style="width:900px">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Masters</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Items</button>
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Transactions</button>
  </div> -->


    <ul class="nav nav-tabs" id="myTab" role="tablist" style="width: 900px;margin-left:300px;margin-top:20px">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#masters" type="button"
                role="tab">Masters</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#attributes1" type="button"
                role="tab">Attributes1</button>
        </li>
        <li class="nav-item" role="">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#attributes2" type="button"
                role="tab">Attributes2</button>
        </li>
        <li class="nav-item" role="">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#transactions" type="button"
                role="tab">Transactions</button>
        </li>
        <li class="nav-item" role="">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#users" type="button"
                role="tab">Users</button>
        </li>
        <li class="nav-item" role="" style="display:flex;margin-left:260px;">
            <label for="" class="nav-link" style="color:black">Check All </label>
            <input type="checkbox" name="checkAll" id="checkAll" value="1">
        </li>
    </ul>


    <!-- Tab Content -->
    <div class="tab-content mt-2" id="myTabContent">
        <div class="tab-pane fade show active" id="masters" role="tabpanel">
            <!-- Masters Tab Content Start-->
            <div class="container" style="margin-top:10px;margin-left:290px;" id="">

                <table class="table table-hover" style="width: 900px;background-color:aliceblue">
                    <thead class="table table-dark">
                        <tr style="">

                            <th style="width:130px"></th>
                            <th style="text-align: left;">Form</th>
                            <th style="text-align: center;">Add</th>
                            <th style="text-align: center;">Report</th>
                            <th style="text-align: center;">Update</th>
                            <th style="text-align: center;">Delete</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr>
                            <td>Company</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBoxCompany" value="1"
                                    name="cbCompanyForm" <?php echo ($cbVariables[0] == 1) ? 'checked' : ''; ?>
                                    id="company_form_form"></td>
                            <td style="text-align:center"><input type="checkbox" class="checkBoxCompany" value="1"
                                    name="cbCompanyC"
                                    <?php echo ($_SESSION['company_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="company_form_create"></td>
                            <td style="text-align:center"><input type="checkbox" class="checkBoxCompany" value="1"
                                    name="cbCompanyR"
                                    <?php echo ($_SESSION['company_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="company_form_reprint"></td>
                            <td style="text-align:center"><input type="checkbox" class="checkBoxCompany" value="1"
                                    name="cbCompanyU"
                                    <?php echo ($_SESSION['company_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="company_form_update"></td>
                            <td style="text-align:center"><input type="checkbox" class="checkBoxCompany" value="1"
                                    name="cbCompanyD"
                                    <?php echo ($_SESSION['company_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="company_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Branch</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBoxBranch" value="1"
                                    name="cbBranchForm" <?php echo ($cbVariables[1] == 1) ? 'checked' : ''; ?>
                                    id="branch_form_form"></td>
                            <td style="text-align:center"><input type="checkbox" class="checkBoxBranch" value="1"
                                    name="cbBranchC"
                                    <?php echo ($_SESSION['branch_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="branch_form_create"></td>
                            <td style="text-align:center"><input type="checkbox" class="checkBoxBranch" value="1"
                                    name="cbBranchR"
                                    <?php echo ($_SESSION['branch_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="branch_form_reprint"></td>
                            <td style="text-align:center"><input type="checkbox" class="checkBoxBranch" value="1"
                                    name="cbBranchU"
                                    <?php echo ($_SESSION['branch_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="branch_form_update"></td>
                            <td style="text-align:center"><input type="checkbox" class="checkBoxBranch" value="1"
                                    name="cbBranchD"
                                    <?php echo ($_SESSION['branch_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="branch_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Supplier</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSupplierForm" <?php echo ($cbVariables[2] == 1) ? 'checked' : ''; ?>
                                    id="supplier_form_form"></td>
                            <td style="text-align:center"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSupplierC"
                                    <?php echo ($_SESSION['supplier_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="supplier_form_create"></td>
                            <td style="text-align:center"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSupplierR"
                                    <?php echo ($_SESSION['supplier_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="supplier_form_reprint"></td>
                            <td style="text-align:center"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSupplierU"
                                    <?php echo ($_SESSION['supplier_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="supplier_form_update"></td>
                            <td style="text-align:center"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSupplierD"
                                    <?php echo ($_SESSION['supplier_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="supplier_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Customer</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbCustomerForm" <?php echo ($cbVariables[3] == 1) ? 'checked' : ''; ?>
                                    id="customer_form_form"></td>
                            <!-- <td><input type="checkbox" value="1" name="cbCustomerC"  <?php echo (!empty($_SESSION['customer_form_create']) && ($_SESSION['customer_form_create'] == 1)) ? 'checked' : ''; ?> id=""></td> -->
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbCustomerC"
                                    <?php echo ($_SESSION['customer_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="customer_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbCustomerR"
                                    <?php echo ($_SESSION['customer_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="customer_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbCustomerU"
                                    <?php echo ($_SESSION['customer_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="customer_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbCustomerD"
                                    <?php echo ($_SESSION['customer_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="customer_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Sales Person</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSalesPersonForm" <?php echo ($cbVariables[4] == 1) ? 'checked' : ''; ?>
                                    id="sales_person_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSalesPersonC"
                                    <?php echo ($_SESSION['sales_person_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="sales_person_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSalesPersonR"
                                    <?php echo ($_SESSION['sales_person_form_reprint'] == 1) ? 'checked' : '';  ?>
                                    id="sales_person_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSalesPersonU"
                                    <?php echo ($_SESSION['sales_person_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="sales_person_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSalesPersonD"
                                    <?php echo ($_SESSION['sales_person_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="sales_person_form_delete"></td>
                        </tr>

                    </tbody>
                </table>


            </div>
        </div>
        <!-- Masters Tab Content End-->

        <!-- Items1  Tab Content Start-->
        <div class="tab-pane fade" id="attributes1" role="tabpanel">


            <div class="container" style="margin-top:10px;margin-left:290px;" id="">

                <table class="table table-hover" style="width: 900px;background-color:aliceblue">
                    <thead class="table table-dark">
                        <tr>

                            <th style="width: 130px;"></th>
                            <th style="text-align: left;">Form</th>
                            <th style="text-align: center;">Add</th>
                            <th style="text-align: center;">Report</th>
                            <th style="text-align: center;">Update</th>
                            <th style="text-align: center;">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Product</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbProductForm" <?php echo ($cbVariables[5] == 1) ? 'checked' : ''; ?>
                                    id="product_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbProductC"
                                    <?php echo ($_SESSION['product_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="product_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbProductR"
                                    <?php echo ($_SESSION['product_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="product_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbProductU"
                                    <?php echo ($_SESSION['product_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="product_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbProductD"
                                    <?php echo ($_SESSION['product_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="product_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Brand</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbBrandForm" <?php echo ($cbVariables[6] == 1) ? 'checked' : ''; ?>
                                    id="brand_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbBrandC"
                                    <?php echo ($_SESSION['brand_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="brand_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbBrandR"
                                    <?php echo ($_SESSION['brand_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="brand_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbBrandU"
                                    <?php echo ($_SESSION['brand_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="brand_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbBrandD"
                                    <?php echo ($_SESSION['brand_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="brand_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Design</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbDesignForm" <?php echo ($cbVariables[7] == 1) ? 'checked' : ''; ?>
                                    id="design_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbDesignC"
                                    <?php echo ($_SESSION['design_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="design_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbDesignR"
                                    <?php echo ($_SESSION['design_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="design_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbDesignU"
                                    <?php echo ($_SESSION['design_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="design_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbDesignD"
                                    <?php echo ($_SESSION['design_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="design_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Color</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbColorForm" <?php echo ($cbVariables[8] == 1) ? 'checked' : ''; ?>
                                    id="color_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbColorC"
                                    <?php echo ($_SESSION['color_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="color_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbColorR"
                                    <?php echo ($_SESSION['color_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="color_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbColorU"
                                    <?php echo ($_SESSION['color_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="color_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbColorD"
                                    <?php echo ($_SESSION['color_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="color_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Batch</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbBatchForm" <?php echo ($cbVariables[9] == 1) ? 'checked' : ''; ?>
                                    id="batch_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbBatchC"
                                    <?php echo ($_SESSION['batch_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="batch_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbBatchR"
                                    <?php echo ($_SESSION['batch_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="batch_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbBatchU"
                                    <?php echo ($_SESSION['batch_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="batch_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbBatchD"
                                    <?php echo ($_SESSION['batch_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="batch_form_delete"></td>
                        </tr>
                    </tbody>
                </table>



            </div>
        </div>
        <!-- Attributes1 Tab Content End-->

        <!-- Attributes2 Tab Content Start-->
        <div class="tab-pane fade" id="attributes2" role="tabpanel">
            <div class="container" style="margin-top:10px;margin-left:290px;" id="">
                <table class="table table-hover" style="width: 900px;background-color:aliceblue">
                    <thead class="table table-dark">
                        <tr>

                            <th style="width: 130px;"></th>
                            <th style="text-align: left;">Form</th>
                            <th style="text-align: center;">Add</th>
                            <th style="text-align: center;">Report</th>
                            <th style="text-align: center;">Update</th>
                            <th style="text-align: center;">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Category</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbCategoryForm" <?php echo ($cbVariables[10] == 1) ? 'checked' : ''; ?>
                                    id="category_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbCategoryC"
                                    <?php echo ($_SESSION['category_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="category_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbCategoryR"
                                    <?php echo ($_SESSION['category_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="category_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbCategoryU"
                                    <?php echo ($_SESSION['category_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="category_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbCategoryD"
                                    <?php echo ($_SESSION['category_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="category_form_delete"></td>
                        </tr>
                        <tr>
                            <td>HSN</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbHsnForm" <?php echo ($cbVariables[11] == 1) ? 'checked' : ''; ?>
                                    id="hsn_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbHsnC" <?php echo ($_SESSION['hsn_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="hsn_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbHsnR" <?php echo ($_SESSION['hsn_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="hsn_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbHsnU" <?php echo ($_SESSION['hsn_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="hsn_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbHsnD" <?php echo ($_SESSION['hsn_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="hsn_form_delete"></td>
                        </tr>
                        <!-- <tr>
                    <td>Tax</td>
                    <td style="text-align: center;"><input type="checkbox" value="1" name="cbTaxForm" <?php echo ($cbVariables[12] == 1) ? 'checked' : ''; ?> id=""></td>
                    <td style="text-align: center;"><input type="checkbox" value="1" name="cbTaxC"  <?php echo ($_SESSION['tax_form_create'] == 1) ? 'checked' : ''; ?> id="tax_form_create"></td>
                    <td style="text-align: center;"><input type="checkbox" value="1" name="cbTaxR"  <?php echo ($_SESSION['tax_form_reprint'] == 1) ? 'checked' : ''; ?> id="tax_form_reprint"></td>
                    <td style="text-align: center;"><input type="checkbox" value="1" name="cbTaxU"  <?php echo ($_SESSION['tax_form_update'] == 1) ? 'checked' : ''; ?> id="tax_form_update"></td>
                    <td style="text-align: center;"><input type="checkbox" value="1" name="cbTaxD"  <?php echo ($_SESSION['tax_form_delete'] == 1) ? 'checked' : ''; ?> id="tax_form_delete"></td>
                </tr> -->
                        <tr>
                            <td>Size</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSizeForm" <?php echo ($cbVariables[13] == 1) ? 'checked' : ''; ?>
                                    id="size_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSizeC" <?php echo ($_SESSION['size_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="size_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSizeR" <?php echo ($_SESSION['size_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="size_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSizeU" <?php echo ($_SESSION['size_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="size_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSizeD" <?php echo ($_SESSION['size_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="size_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Mrp</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbMrpForm" <?php echo ($cbVariables[14] == 1) ? 'checked' : ''; ?>
                                    id="mrp_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbMrpC" <?php echo ($_SESSION['mrp_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="mrp_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbMrpR" <?php echo ($_SESSION['mrp_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="mrp_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbMrpU" <?php echo ($_SESSION['mrp_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="mrp_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbMrpD" <?php echo ($_SESSION['mrp_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="mrp_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Item</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbItemForm" <?php echo ($cbVariables[15] == 1) ? 'checked' : ''; ?>
                                    id="item_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbItemC" <?php echo ($_SESSION['item_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="item_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbItemR" <?php echo ($_SESSION['item_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="item_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbItemU" <?php echo ($_SESSION['item_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="item_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbItemD" <?php echo ($_SESSION['item_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="item_form_delete"></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <!-- Attributes2 Tab Content End-->

        <!-- Transaction Tab Content Start-->
        <div class="tab-pane fade" id="transactions" role="tabpanel">
            <!-- Transaction Tab Content Start-->
            <div class="container" style="margin-top:10px;margin-left:290px;" id="">
                <table class="table table-hover" style="width: 900px;background-color:aliceblue">
                    <thead class="table table-dark">
                        <tr>
                            <th style="width: 180px;"></th>
                            <th style="text-align: left;">Form</th>
                            <th style="text-align: center;">Add</th>
                            <th style="text-align: center;">Report</th>
                            <th style="text-align: center;">Update</th>
                            <th style="text-align: center;">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Purchase</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbPurchaseForm" <?php echo ($cbVariables[16] == 1) ? 'checked' : ''; ?>
                                    id="purchase_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbPurchaseC"
                                    <?php echo ($_SESSION['purchase_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="purchase_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbPurchaseR"
                                    <?php echo ($_SESSION['purchase_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="purchase_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbPurchaseU"
                                    <?php echo ($_SESSION['purchase_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="purchase_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbPurchaseD"
                                    <?php echo ($_SESSION['purchase_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="purchase_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Purchase Return</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbPurchaseReturnForm" <?php echo ($cbVariables[17] == 1) ? 'checked' : ''; ?>
                                    id="purchase_return_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbPurchaseReturnC"
                                    <?php echo ($_SESSION['purchase_return_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="purchase_return_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbPurchaseReturnR"
                                    <?php echo ($_SESSION['purchase_return_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="purchase_return_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbPurchaseReturnU"
                                    <?php echo ($_SESSION['purchase_return_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="purchase_return_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbPurchaseReturnD"
                                    <?php echo ($_SESSION['purchase_return_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="purchase_return_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Sales / Sales Return</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSalesForm" <?php echo ($cbVariables[18] == 1) ? 'checked' : ''; ?>
                                    id="sales_form_form"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSalesC"
                                    <?php echo ($_SESSION['sales_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="sales_form_create"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSalesR"
                                    <?php echo ($_SESSION['sales_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="sales_form_reprint"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSalesU"
                                    <?php echo ($_SESSION['sales_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="sales_form_update"></td>
                            <td style="text-align: center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbSalesD"
                                    <?php echo ($_SESSION['sales_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="sales_form_delete"></td>
                        </tr>
                        <tr>
                            <td>Reports</td>
                            <td style="padding-left:20px;"><input type="checkbox" value="1" name="cbReportForm"
                                    class="checkBox" <?php echo ($cbVariables[19] == 1) ? 'checked' : ''; ?>
                                    id="reports_form_form"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <!-- Transaction Tab Content End-->

        <!-- User Tab Content Start-->

        <div class="tab-pane fade" id="users" role="tabpanel">
            <!-- User Tab Content Start-->
            <div class="container" style="margin-top:10px;margin-left:290px;" id="">
                <table class="table table-hover" style="width: 900px;background-color:aliceblue">
                    <thead class="table table-dark">
                        <tr>

                            <th style="width: 250px;"></th>
                            <th style="text-align:left;">Form</th>
                            <th style="text-align:center;">Add</th>
                            <th style="text-align:center;">Report</th>
                            <th style="text-align:center;">Update</th>
                            <th style="text-align:center;">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>User Info</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbUserForm" <?php echo ($cbVariables[20] == 1) ? 'checked' : ''; ?>
                                    id="user_info_form_form"></td>
                            <td style="text-align:center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbUserC"
                                    <?php echo ($_SESSION['user_info_form_create'] == 1) ? 'checked' : ''; ?>
                                    id="user_info_form_create"></td>
                            <td style="text-align:center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbUserR"
                                    <?php echo ($_SESSION['user_info_form_reprint'] == 1) ? 'checked' : ''; ?>
                                    id="user_info_form_reprint"></td>
                            <td style="text-align:center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbUserU"
                                    <?php echo ($_SESSION['user_info_form_update'] == 1) ? 'checked' : ''; ?>
                                    id="user_info_form_update"></td>
                            <td style="text-align:center;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbUserD"
                                    <?php echo ($_SESSION['user_info_form_delete'] == 1) ? 'checked' : ''; ?>
                                    id="user_info_form_delete"></td>
                        </tr>
                        <tr>
                            <td>User Access Management</td>
                            <td style="padding-left:20px;"><input type="checkbox" class="checkBox" value="1"
                                    name="cbUserManagementForm" <?php echo ($cbVariables[21] == 1) ? 'checked' : ''; ?>
                                    id="user_management_form_form"></td>
                            <!-- <td style="text-align:center;"><input type="checkbox" value="1" name="cbUserManagementC"   <?php echo ($_SESSION['user_management_form_create'] == 1) ? 'checked' : ''; ?> id="user_management_form_create"></td>
                    <td style="text-align:center;"><input type="checkbox" value="1" name="cbUserManagementR"   <?php echo ($_SESSION['user_management_form_reprint'] == 1) ? 'checked' : ''; ?> id="user_management_form_reprint"></td>
                    <td style="text-align:center;"><input type="checkbox" value="1" name="cbUserManagementU"   <?php echo ($_SESSION['user_management_form_update'] == 1) ? 'checked' : ''; ?> id="user_management_form_update"></td>
                    <td style="text-align:center;"><input type="checkbox" value="1" name="cbUserManagementD"   <?php echo ($_SESSION['user_management_form_delete'] == 1) ? 'checked' : ''; ?> id="user_management_form_delete"></td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- User Tab Content End-->
        </div>

    </div>
    <button type="submit" name="userPermissionSubmit" id="userPermissionSubmit" class="btn btn-primary"
        style="width:120px;margin-left:300px">Submit</button>

</form>
<!-- <div style="margin-left:280px;margin-top:120px;border:1px solid black;width:800px;height:500px">
<form action="" style="margin-left:20px">
    <h3 style="text-align: center;font-family:Verdana, Geneva, Tahoma, sans-serif;text-transform:uppercase;
    "
    >U s e r  P e r m i s s i o n</h3>  
    <hr>
    <div class="form-floating">
    <input type="text" class="form-control" style="width:270px" >
    <label for="form-floating">Press F2 For User Info </label>
    </div>
    

</form>
</div> -->

<script>
window.onload = function() {


    document.getElementById('userName').focus();




    document.getElementById('userPermissionSubmit').disabled = true;

    let role = document.getElementById('userRole').value;

    if (role == '') {
        document.getElementById('userPermissionSubmit').disabled = true;
    } else {
        document.getElementById('userPermissionSubmit').disabled = false;
    }

    if (role == 'Super Admin') {
        document.getElementById('checkAll').disabled = true;

        let boxes = document.querySelectorAll('.checkBox');
        boxes.forEach(box => {
            box.disabled = true;
        })

        let checkBoxCompany = document.querySelectorAll('.checkBoxCompany');
        checkBoxCompany.forEach(box => {
            box.disabled = true;
        })

        let checkBoxBranch = document.querySelectorAll('.checkBoxBranch');
        checkBoxBranch.forEach(box => {
            box.disabled = true;
        })
    }

}

document.getElementById("checkAll").addEventListener("change", function() {
    let checkboxes = document.querySelectorAll(".checkBox");
    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
});





// document.getElementById("checkAll").addEventListener("click",function(event){

//         if(event){

//             let checkBoxValue = document.getElementById("checkAll").value;
//             if(checkBoxValue == 1){
//                 alert(checkBoxValue);
//                 document.getElementById("company_form_create").setAttribute('checked',true);
//             }

//         }
// })



setTimeout(() => {
    var alertBox = document.getElementById("liveToast");
    if (alertBox) {
        alertBox.style.display = 'none';
    }
}, 2000);

document.getElementById("userName").addEventListener("keydown", function(event) {
    let target = event.target
    if (event.key === "Enter") {
        event.preventDefault();
        // document.getElementById('userPermissionSubmit').focus();

    } else if (event.key === "F2") {
        event.preventDefault();
        let userData = new FormData();
        userData.append("get_user_info", target.value);
        let aj_userData = new XMLHttpRequest();
        aj_userData.open("POST", 'ajaxGetUserDetails.php', true);
        aj_userData.send(userData);
        aj_userData.onreadystatechange = function() {
            if (aj_userData.status === 200 && aj_userData.readyState === 4) {
                document.getElementById("response_message").innerHTML = aj_userData.responseText;
            }
        }
    }
})
</script>


<?php include_once(DIR_URL . "/includes/footer.php"); ?>
<?php ob_end_flush(); ?>