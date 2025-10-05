
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3-->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
ob_start();
include_once("./config/config.php");
include_once(DIR_URL."/includes/header.php");
include_once(DIR_URL."/db/dbConnection.php");
// include_once(DIR_URL."/includes/header.php");
// include_once(DIR_URL."/db/dbConnection.php");
// include_once(__DIR__."/includes/header.php");
// include_once(__DIR__."/db/dbConnection.php");

?>
<?php if(!isset($_SESSION['is_logged_in'])){ ?>

<?php

?>

    
<div style="display:flex;justify-content:right;align-items:center;height:710px;">
<span style="font-size:52px;font-family:FiresideDemo;margin-top:-140px;margin-left:-60px;
            width:200px;font-weight:bolder">retail</span>
<label for="" class="fireside-text"><span style="margin-top:20px;">X</span><span style="font-size:52px;font-weight:bolder">pert</span></label>

<!-- <span style="font-size:52px;font-family:fireSideDemo;margin-top:70px;margin-left:80px;
            width:265px;font-weight:bolder">Retail</span>
<span style="margin-left:-40px;margin-top:20px;font-family:fireSideDemo;font-size:150px;width:200px;">X</span>
<span style="font-weight:bolder;font-size:52px;margin-top:-65px;font-family:fireSideDemo;margin-left:-85px;width:360px">pert</span> -->
<label for="" class=""></label>
<br>
<div class="developerName">
<label for="" style="font-size:larger">althaf <span style="margin-left: 8px;"> </span> hUssain   <span style="margin-left:10px;">j</span></label>
<br>
<label for="" style="font-size:15px;font-weight:bolder;margin-left:65px">mca final year</label>
<br>
<label for="" class="batch" style="font-size:15px;margin-left:97px">(2023 - 2025)</label>
</div>



<?php if(isset($_SESSION['failure'])){?>
    <div class="alert alert-danger" id="failure-alert" >
    <?php echo $_SESSION['failure'];?>!
    <?php unset($_SESSION['failure']);?>
    </div>
    <?php }?>
<form action="" method="post" style="" id="login_form">
    <br>
    
    <h4 style="font-family:FiresideDemo">login</h4>
    <br>
    <input type="text" autocomplete="off" name="userName" id="userName" class="form-control" placeholder="User Name">
    <br>
    <input type="password" autocomplete="off" name="userPass" id="userPass" class="form-control" placeholder="Password">
    <br>
        
   
        
   
    <button type="submit" id="loginBtn" name="loginButton" class="btn loginButton">Login</button>
</form>
</div>




<?php 

    if(isset($_POST['loginButton'])){
        extract($_POST);
     
    $querySearchPassword = "select*from user_master1 where user_name = '$userName'";
        $resultSearchPassword = $con->query($querySearchPassword);
        if ($resultSearchPassword->num_rows > 0) {

            while ($userData = $resultSearchPassword->fetch_assoc()) {
                // echo "<pre>";
                // print_r($data);
                // echo "</pre>";

                if (password_verify($userPass, $userData['user_pass'])) {
                    if (
                        $userData['user_name'] == $userName
                        && $userData['user_role'] != 'Super Admin' && $userData['login_status'] == 0
                    ) {



                        $_SESSION['user_id'] = $userData['id'];
                        $_SESSION['user_name'] = $userData['user_name'];
                        $_SESSION['user_password'] = $userData['user_pass'];
                        $_SESSION['user_role'] = $userData['user_role'];
                        $_SESSION['user_created_date'] = $userData['created_date'];
                        $_SESSION['user_branch_id'] = $userData['branch_id'];




                        $querySearchBranch = "select*from branches where id = '$userData[branch_id]'";
                        $resultSearchBranch = $con->query($querySearchBranch)->fetch_assoc();

                        $_SESSION['branch_name']       = $resultSearchBranch['branch_name'];
                        $_SESSION['branch_address1']   = $resultSearchBranch['address1'];
                        $_SESSION['branch_address2']   = $resultSearchBranch['address2'];
                        $_SESSION['branch_address3']   = $resultSearchBranch['address3'];
                        $_SESSION['branch_locality']   = $resultSearchBranch['locality'];
                        $_SESSION['branch_city']       = $resultSearchBranch['city'];
                        $_SESSION['branch_pinCode']    = $resultSearchBranch['pincode'];
                        $_SESSION['branch_state']      = $resultSearchBranch['state'];
                        $_SESSION['branch_landline']   = $resultSearchBranch['landline'];
                        $_SESSION['branch_mobile']     = $resultSearchBranch['mobile'];
                        $_SESSION['branch_email']      = $resultSearchBranch['email'];
                        $_SESSION['branch_gst_no']     = $resultSearchBranch['gst_no'];


                        $querySearchUserFormsPermission = "select*from user_forms_permission where 
                                                       user_id = '$userData[id]' 
                                                       and branch_id = '$userData[branch_id]'";
                        $resultSearchUserFormsPermission = $con->query($querySearchUserFormsPermission)->fetch_assoc();


                        $_SESSION['company_form_access']  = $resultSearchUserFormsPermission['company_form'];
                        $_SESSION['branch_form_access']   = $resultSearchUserFormsPermission['branch_form'];
                        $_SESSION['supplier_form_access'] = $resultSearchUserFormsPermission['supplier_form'];
                        $_SESSION['customer_form_access'] = $resultSearchUserFormsPermission['customer_form'];
                        $_SESSION['sales_person_form_access']       = $resultSearchUserFormsPermission['sales_person_form'];
                        $_SESSION['product_form_access']            = $resultSearchUserFormsPermission['product_form'];
                        $_SESSION['brand_form_access']                  = $resultSearchUserFormsPermission['brand_form'];
                        $_SESSION['design_form_access']             = $resultSearchUserFormsPermission['design_form'];
                        $_SESSION['color_form_access']              = $resultSearchUserFormsPermission['color_form'];
                        $_SESSION['batch_form_access']              = $resultSearchUserFormsPermission['batch_form'];
                        $_SESSION['hsn_form_access']                = $resultSearchUserFormsPermission['hsn_form'];
                        $_SESSION['category_form_access']           = $resultSearchUserFormsPermission['category_form'];
                        $_SESSION['tax_form_access']                 = $resultSearchUserFormsPermission['tax_form'];
                        $_SESSION['size_form_access']               = $resultSearchUserFormsPermission['size_form'];
                        $_SESSION['mrp_form_access']                = $resultSearchUserFormsPermission['mrp_form'];
                        $_SESSION['item_form_access']               = $resultSearchUserFormsPermission['item_form'];
                        $_SESSION['purchase_form_access']            = $resultSearchUserFormsPermission['purchase_form'];
                        $_SESSION['purchase_return_form_access'] = $resultSearchUserFormsPermission['purchase_return_form'];
                        $_SESSION['sales_form_access']           = $resultSearchUserFormsPermission['sales_form'];
                        $_SESSION['reports_form_access']         = $resultSearchUserFormsPermission['reports_form'];
                        $_SESSION['user_info_form_access']          = $resultSearchUserFormsPermission['user_info_form'];
                        $_SESSION['user_management_form_access'] = $resultSearchUserFormsPermission['user_management_form'];



                        $querySearchUserCrudPermission = "select*from user_crud_permission where 
                                                       user_id = '$userData[id]' 
                                                       and branch_id = '$userData[branch_id]'";
                        $resultSearchUserCrudPermission = $con->query($querySearchUserCrudPermission);

                        $_SESSION['formNameArrayCreateOp'] = [];
                        $_SESSION['formNameArrayReprintOp']  = [];
                        $_SESSION['formNameArrayUpdateOp'] = [];
                        $_SESSION['formNameArrayDeleteOp'] = [];
                        // List of forms to track permissions for
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

                        while ($UserCrudPermissionData = $resultSearchUserCrudPermission->fetch_assoc()) {
                            $formName = $UserCrudPermissionData['form_name'];

                            // Check if form is in the list
                            if (in_array($formName, $formNames)) {
                                $_SESSION[$formName . '_create']  = $UserCrudPermissionData['create_op'];
                                $_SESSION[$formName . '_reprint'] = $UserCrudPermissionData['reprint_op'];
                                $_SESSION[$formName . '_update']  = $UserCrudPermissionData['update_op'];
                                $_SESSION[$formName . '_delete']  = $UserCrudPermissionData['delete_op'];
                            }
                        }



                        echo "<br>";
                        echo $_SESSION['company_form_create'];
                        echo "<br>";
                        echo $_SESSION['company_form_reprint'];
                        echo "<br>";
                        echo $_SESSION['company_form_update'];
                        echo "<br>";
                        echo $_SESSION['company_form_delete'];
                        echo "<br>";





                        // $_SESSION['company_form']           = $resultSearchUserCrudPermission['company_name'];
                        // $_SESSION['branch_form']            = $resultSearchUserCrudPermission['branch_form'];
                        // $_SESSION['supplier_form']          = $resultSearchUserCrudPermission['supplier_form'];
                        // $_SESSION['customer_form']              = $resultSearchUserCrudPermission['customer_form'];
                        // $_SESSION['sales_person_form']          = $resultSearchUserCrudPermission['sales_person_form'];
                        // $_SESSION['product_form']            = $resultSearchUserCrudPermission['product_form'];
                        // $_SESSION['brand_form']                  = $resultSearchUserCrudPermission['brand_form'];
                        // $_SESSION['design_form']             = $resultSearchUserCrudPermission['design_form'];
                        // $_SESSION['color_form']              = $resultSearchUserCrudPermission['color_form'];
                        // $_SESSION['batch_form']              = $resultSearchUserCrudPermission['batch_form'];
                        // $_SESSION['hsn_form']                = $resultSearchUserCrudPermission['hsn_form'];
                        // $_SESSION['category_form']           = $resultSearchUserCrudPermission['category_form'];
                        // $_SESSION['tax_form']                 = $resultSearchUserCrudPermission['tax_form'];
                        // $_SESSION['size_form']               = $resultSearchUserCrudPermission['size_form'];
                        // $_SESSION['mrp_form']                = $resultSearchUserCrudPermission['mrp_form'];
                        // $_SESSION['item_form']               = $resultSearchUserCrudPermission['item_form'];
                        // $_SESSION['purchase_form']            = $resultSearchUserCrudPermission['purchase_form'];
                        // $_SESSION['purchase_return_form'] = $resultSearchUserCrudPermission['purchase_return_form'];
                        // $_SESSION['sales_form_']           = $resultSearchUserCrudPermission['sales_form'];
                        // $_SESSION['reports_form']         = $resultSearchUserCrudPermission['reports_form'];
                        // $_SESSION['user_info_form']          = $resultSearchUserCrudPermission['user_info_form'];
                        // $_SESSION['user_management_form'] = $resultSearchUserCrudPermission['user_management_form'];








                        $querySearchCompany = "select*from company where id = 1";
                        $resultSearchCompany = $con->query($querySearchCompany);

                        $_SESSION['is_logged_in'] = true;

                        while ($companyData = $resultSearchCompany->fetch_assoc()) {
                            $_SESSION['company_id']         = $companyData['id'];
                            $_SESSION['company_name']       = $companyData['company_name'];
                            $_SESSION['company_short_name'] = $companyData['company_short_name'];
                            $_SESSION['company_address1']   = $companyData['address1'];
                            $_SESSION['company_address2']   = $companyData['address2'];
                            $_SESSION['company_address3']   = $companyData['address3'];
                            $_SESSION['company_locality']   = $companyData['locality'];
                            $_SESSION['company_city']       = $companyData['city'];
                            $_SESSION['company_pincode']    = $companyData['pincode'];
                            $_SESSION['company_state']      = $companyData['state'];
                            $_SESSION['company_landline']   = $companyData['landline'];
                            $_SESSION['company_mobile']     = $companyData['mobile'];
                            $_SESSION['company_email']      = $companyData['email'];
                            $_SESSION['company_gst_no']     = $companyData['gst_no'];
                        }

                        $queryGetCounter = "select*from counters";
                        $resultGetCounter = $locationConnection->query($queryGetCounter)->fetch_assoc();
                        $_SESSION['counter_name'] = $resultGetCounter['counter_name'];


                        // $updateQueryLoginStatus = "update user_master1 set login_status = 1 where user_name = '$_SESSION[user_name]' and user_pass = '$_SESSION[user_password]'
                        //                           and branch_id = '$_SESSION[user_branch_id]'";
                        // $resultQueryLoginStatus = $con->query($updateQueryLoginStatus);

                        header("Location:pages/financialYearSelection.php");
                    } elseif ($userData['user_role'] == 'Super Admin') {

                        $_SESSION['user_id'] = $userData['id'];
                        $_SESSION['user_name'] = $userData['user_name'];
                        $_SESSION['user_password'] = $userData['user_pass'];
                        $_SESSION['user_role'] = $userData['user_role'];
                        $_SESSION['user_created_date'] = $userData['created_date'];
                        $_SESSION['user_branch_id'] = $userData['branch_id'];




                        $querySearchBranch = "select*from branches where id = '$userData[branch_id]'";
                        $resultSearchBranch = $con->query($querySearchBranch)->fetch_assoc();

                        $_SESSION['branch_name']       = $resultSearchBranch['branch_name'];
                        $_SESSION['branch_address1']   = $resultSearchBranch['address1'];
                        $_SESSION['branch_address2']   = $resultSearchBranch['address2'];
                        $_SESSION['branch_address3']   = $resultSearchBranch['address3'];
                        $_SESSION['branch_locality']   = $resultSearchBranch['locality'];
                        $_SESSION['branch_city']       = $resultSearchBranch['city'];
                        $_SESSION['branch_pinCode']    = $resultSearchBranch['pincode'];
                        $_SESSION['branch_state']      = $resultSearchBranch['state'];
                        $_SESSION['branch_landline']   = $resultSearchBranch['landline'];
                        $_SESSION['branch_mobile']     = $resultSearchBranch['mobile'];
                        $_SESSION['branch_email']      = $resultSearchBranch['email'];
                        $_SESSION['branch_gst_no']     = $resultSearchBranch['gst_no'];


                        $querySearchUserFormsPermission = "select*from user_forms_permission where 
                                                       user_id = '$userData[id]' 
                                                       and branch_id = '$userData[branch_id]'";
                        $resultSearchUserFormsPermission = $con->query($querySearchUserFormsPermission)->fetch_assoc();


                        $_SESSION['company_form_access']  = $resultSearchUserFormsPermission['company_form'];
                        $_SESSION['branch_form_access']   = $resultSearchUserFormsPermission['branch_form'];
                        $_SESSION['supplier_form_access'] = $resultSearchUserFormsPermission['supplier_form'];
                        $_SESSION['customer_form_access'] = $resultSearchUserFormsPermission['customer_form'];
                        $_SESSION['sales_person_form_access']       = $resultSearchUserFormsPermission['sales_person_form'];
                        $_SESSION['product_form_access']            = $resultSearchUserFormsPermission['product_form'];
                        $_SESSION['brand_form_access']                  = $resultSearchUserFormsPermission['brand_form'];
                        $_SESSION['design_form_access']             = $resultSearchUserFormsPermission['design_form'];
                        $_SESSION['color_form_access']              = $resultSearchUserFormsPermission['color_form'];
                        $_SESSION['batch_form_access']              = $resultSearchUserFormsPermission['batch_form'];
                        $_SESSION['hsn_form_access']                = $resultSearchUserFormsPermission['hsn_form'];
                        $_SESSION['category_form_access']           = $resultSearchUserFormsPermission['category_form'];
                        $_SESSION['tax_form_access']                 = $resultSearchUserFormsPermission['tax_form'];
                        $_SESSION['size_form_access']               = $resultSearchUserFormsPermission['size_form'];
                        $_SESSION['mrp_form_access']                = $resultSearchUserFormsPermission['mrp_form'];
                        $_SESSION['item_form_access']               = $resultSearchUserFormsPermission['item_form'];
                        $_SESSION['purchase_form_access']            = $resultSearchUserFormsPermission['purchase_form'];
                        $_SESSION['purchase_return_form_access'] = $resultSearchUserFormsPermission['purchase_return_form'];
                        $_SESSION['sales_form_access']           = $resultSearchUserFormsPermission['sales_form'];
                        $_SESSION['reports_form_access']         = $resultSearchUserFormsPermission['reports_form'];
                        $_SESSION['user_info_form_access']          = $resultSearchUserFormsPermission['user_info_form'];
                        $_SESSION['user_management_form_access'] = $resultSearchUserFormsPermission['user_management_form'];



                        $querySearchUserCrudPermission = "select*from user_crud_permission where 
                                                       user_id = '$userData[id]' 
                                                       and branch_id = '$userData[branch_id]'";
                        $resultSearchUserCrudPermission = $con->query($querySearchUserCrudPermission)->fetch_assoc();

                        $_SESSION['create_op_access']  = $resultSearchUserCrudPermission['create_op'];
                        $_SESSION['reprint_op_access'] = $resultSearchUserCrudPermission['reprint_op'];
                        $_SESSION['update_op_access']  = $resultSearchUserCrudPermission['update_op'];
                        $_SESSION['delete_op_access']  = $resultSearchUserCrudPermission['delete_op'];



                        // $_SESSION['company_form']           = $resultSearchUserCrudPermission['company_form'];
                        // $_SESSION['branch_form']            = $resultSearchUserCrudPermission['branch_form'];
                        // $_SESSION['supplier_form']          = $resultSearchUserCrudPermission['supplier_form'];
                        // $_SESSION['customer_form']              = $resultSearchUserCrudPermission['customer_form'];
                        // $_SESSION['sales_person_form']          = $resultSearchUserCrudPermission['sales_person_form'];
                        // $_SESSION['product_form']            = $resultSearchUserCrudPermission['product_form'];
                        // $_SESSION['brand_form']                  = $resultSearchUserCrudPermission['brand_form'];
                        // $_SESSION['design_form']             = $resultSearchUserCrudPermission['design_form'];
                        // $_SESSION['color_form']              = $resultSearchUserCrudPermission['color_form'];
                        // $_SESSION['batch_form']              = $resultSearchUserCrudPermission['batch_form'];
                        // $_SESSION['hsn_form']                = $resultSearchUserCrudPermission['hsn_form'];
                        // $_SESSION['category_form']           = $resultSearchUserCrudPermission['category_form'];
                        // $_SESSION['tax_form']                 = $resultSearchUserCrudPermission['tax_form'];
                        // $_SESSION['size_form']               = $resultSearchUserCrudPermission['size_form'];
                        // $_SESSION['mrp_form']                = $resultSearchUserCrudPermission['mrp_form'];
                        // $_SESSION['item_form']               = $resultSearchUserCrudPermission['item_form'];
                        // $_SESSION['purchase_form']            = $resultSearchUserCrudPermission['purchase_form'];
                        // $_SESSION['purchase_return_form'] = $resultSearchUserCrudPermission['purchase_return_form'];
                        // $_SESSION['sales_form_']           = $resultSearchUserCrudPermission['sales_form'];
                        // $_SESSION['reports_form']         = $resultSearchUserCrudPermission['reports_form'];
                        // $_SESSION['user_info_form']          = $resultSearchUserCrudPermission['user_info_form'];
                        // $_SESSION['user_management_form'] = $resultSearchUserCrudPermission['user_management_form'];








                        $querySearchCompany = "select*from company where id = 1";
                        $resultSearchCompany = $con->query($querySearchCompany);

                        $_SESSION['is_logged_in'] = true;

                        while ($companyData = $resultSearchCompany->fetch_assoc()) {
                            $_SESSION['company_id']         = $companyData['id'];
                            $_SESSION['company_name']       = $companyData['company_name'];
                            $_SESSION['company_short_name'] = $companyData['company_short_name'];
                            $_SESSION['company_address1']   = $companyData['address1'];
                            $_SESSION['company_address2']   = $companyData['address2'];
                            $_SESSION['company_address3']   = $companyData['address3'];
                            $_SESSION['company_locality']   = $companyData['locality'];
                            $_SESSION['company_city']       = $companyData['city'];
                            $_SESSION['company_pincode']    = $companyData['pincode'];
                            $_SESSION['company_state']      = $companyData['state'];
                            $_SESSION['company_landline']   = $companyData['landline'];
                            $_SESSION['company_mobile']     = $companyData['mobile'];
                            $_SESSION['company_email']      = $companyData['email'];
                            $_SESSION['company_gst_no']     = $companyData['gst_no'];
                        }

                        $queryGetCounter = "select*from counters";
                        $resultGetCounter = $locationConnection->query($queryGetCounter)->fetch_assoc();
                        $_SESSION['counter_name'] = $resultGetCounter['counter_name'];

                        // $updateQueryLoginStatus = "update user_master1 set login_status = 1 where user_name = '$_SESSION[user_name]' and user_pass = '$_SESSION[user_password]'
                        //                           and branch_id = '$_SESSION[user_branch_id]'";
                        // $resultQueryLoginStatus = $con->query($updateQueryLoginStatus);

                        header("Location:pages/financialYearSelection.php");
                    } else {

                        $_SESSION['failure'] = "User Already Logged In";
                        header("Location:index.php");
                        // header("Location:pages/financialYearSelection.php");
                    }
                }
            }
        } else {

            $_SESSION['failure'] = "Invalid User Name Or Password!";

            header("Location:index.php");
        }
}



?>


<?php }else{
?>
<div style="border:1px solid black;display:flex;justify-content:center;align-items:center;height:712px;

    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
">
<div class="alert alert" style="font-family:Verdana, Geneva, Tahoma, sans-serif ;width:500px;height:100px;display:flex;justify-content:center;align-items:center;background-color:white;">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </svg>
    You Are Already Logged In 
    <!--<a href="<?php BASE_URL;?>pages/homePage.php"-->
    <a href="pages/homePage.php"
    class="text-primary" 
    style="margin-left:10px;"> Go To Home Page</a>
</div>

</div>

<?php
};?>

<?php ob_end_flush(); ?>

<script>

setTimeout(() => {
   var alertBox = document.getElementById("failure-alert");
    if(alertBox){
        alertBox.style.display='none';
    }
}, 3000);


window.onload = function(){
    document.getElementById("userName").focus();

}

document.getElementById("userName").addEventListener("keypress", function(event){

    if(event.key === "Enter"){
        event.preventDefault();
        document.getElementById("userPass").focus();
    }
})

document.getElementById("userPass").addEventListener("keypress", function(event){

if(event.key === "Enter"){
    event.preventDefault();
    document.getElementById("loginBtn").focus();
}
})
</script>

<style>


@font-face{
  font-family: 'FiresideDemo';
  src: url('fonts/FIRESIDE-DEMO.woff') format('woff');
  /*src: url('https://www.retailxpert.in/public_html/fonts/FIRESIDE-DEMO.woff2') format('woff2');*/
       /*url('https://www.retailxpert.in/public_html/fonts/FIRESIDE-DEMO.woff') format('woff'),*/
       /*url('https://www.retailxpert.in/public_html/fonts/FIRESIDE-DEMO.otf') format('opentype');*/
}

#greeting-alert{
    position:absolute;
    text-align: center;
    top:120px;
    border-radius: 5px;
    right:123px; 
    /* color:white; */
    padding-top:15px;
    height: 70px;
    width:30%;
    font-weight: bolder;
    /* /* border:1px solid  #FF3CAC; */
    /* background-color: #FF3CAC; */
    /* background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);  */
}

.fireside-text {
    font-family: 'FiresideDemo';
    margin-right: 200px;
    margin-top:-60px;
    font-size: 150px;
}
.developerName{
    font-family: 'FiresideDemo', sans-serif;
    position: absolute;
    font-weight: bolder;
    top:450px;
    right:830px;
    font-size: 20px;
}
#failure-alert{
    position:absolute;
    text-align: center;
     top:150px;
     border-radius: 5px;
    right:123px; 
    /* color:white; */
    padding-top:6px;
    height: 40px;
    width:30%;
    font-weight: bolder;
    /* /* border:1px solid  #FF3CAC; */
    /* background-color: #FF3CAC; */
    /* background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);  */

}
/* #financialYearSelection{
    width: 270px;
    text-align:center;
    margin-left:360px;
    padding-left:10px;
    

} */

body{


    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    
}

.loginButton{
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    width:270px;
    color: white;
    margin-left:10px;
    border: none;
    font-weight:bold;

}
#login_form{
    box-shadow: rgba(57, 57, 58, 0.9) 0px 7px 29px 0px;
    background-color: white;
    height:320px;
    margin-right:120px;
    width:460px;
    border-radius:20px;
    text-align:center;
    
}
#userName{
    width:270px;
    margin-left:100px;
    
}
#userPass{
    width:270px;
    margin-left:100px;
}

</style>
