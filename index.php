
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3-->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php

include_once("./config/config.php");
include_once(DIR_URL."/includes/header.php");
include_once(DIR_URL."/db/dbConnection.php");
ob_start();
// include_once(DIR_URL."/includes/header.php");
// include_once(DIR_URL."/db/dbConnection.php");
// include_once(__DIR__."/includes/header.php");
// include_once(__DIR__."/db/dbConnection.php");
// unset($_SESSION['greeting']);
// unset($_SESSION['success']);
// unset($_SESSION['failure']);

// header("Location:".BASE_URL."/");

$queryTotalVisitor = "select count(*) as total_visitor from visitor_master";
$resultTotalVisitor = $con->query($queryTotalVisitor)->fetch_assoc();
    
$queryVisitorFeedback  = "select distinct(visitor_name), feedback, feedback_date from visitor_feedback";
$resultVisitorFeedback = $con->query($queryVisitorFeedback);

?>
<?php
// if(!isset($_POST['newVisitorButton'])){
        // unset($_SESSION['greeting']);
        // unset($_SESSION['success']);
        // unset($_SESSION['failure']);
//     }
?>


<!--<?php if(isset($_SESSION['greeting'])){?>-->

<!--    <div class="alert alert-success alert-dismissible fade show" role="alert" id="greeting-alert">-->
<!--    <?php echo $_SESSION['greeting'];?>-->
<!--    <?php unset($_SESSION['greeting']);?>-->
<!--    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
<!--    </div>-->
<!--    <?php }?>-->

<!--<?php if(isset($_SESSION['success'])){?>-->

<!--    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" style="display:none">-->
<!--    <?php echo $_SESSION['success'];?>-->
<!--    <?php unset($_SESSION['success']);?>-->
<!--    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>-->
<!--    </div>-->
<!--    <?php }?>-->

<?php if(isset($_SESSION['failure'])){?>
    <div class="alert alert-danger" id="failure-alert" >
    <?php echo $_SESSION['failure'];?>!
    <?php unset($_SESSION['failure']);?>
    </div>
    <?php }?>
    
    
    <div style="position:absolute;bottom:12px;left:5px;font-size:13px;">
    <div class="card" style="width: 535px;height:150px;">
  <div class="card-header"  style="font-weight:bold;display:flex;gap:270px;">
  Project Overview
  <a href="https://drive.google.com/file/d/1mAIXT4P57S3A7-4Uc-ysghSSBiWxQLuN/view?usp=sharing"
        style="font-size:13px;" target="_blank">Software Demo Link</a>
  </div>
  
  <div class="card-body">
    <h5 class="card-title">Retail Inventory Solution</h5>
    <p class="card-text" style="text-align:justify">"This is my final year MCA (2023–2025) project,  developed by me, Althaf Hussain J. It is a web-based inventory management system designed to provide a desktop-like experience, helping retail shops efficiently track and manage their product stock."</p>
  </div>
</div>
</div>
    
    <div style="position:absolute;bottom:83px;left:550px;font-size:13px;">
             <div style="width:750px;height:78px;" id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                <div style="background-color:white;text-align:center;border-radius:2px;">
                    <label for="" style="font-size:15px;font-weight:bolder">Visitor Feedback</label>
                </div>
              <div class="carousel-inner">
                <?php
                    $i=1;
                    if($resultVisitorFeedback->num_rows>0){
                        
                    
                while($visitorData = $resultVisitorFeedback->fetch_assoc()){
                    if($i==1){
                ?>
                    
                <div class="carousel-item active" data-bs-interval="2000">
                    <div class="card" style="width:750px;height:126px;">
                        <div class="card-body" style="text-align:center;margin-top:-10px;">
                            <div style="display:flex;width:100%;height:115px;gap:10px;">
                                <div style="width:25%;border-right:1px solid black">
                                    <img src="./images/user_img.jpg" alt="" style="width: 40px;margin-top:10px;">
                                    <p class="card-title" style="font-size:15px;font-weight:bold"><?php echo $visitorData['visitor_name']." ";?></p>
                                    <p><span style="font-size:12px;"><?php echo date("d-m-Y H:i:s A",strtotime($visitorData['feedback_date'])); ?></span></p>
                                </div>
                                <div style="width:75%;">
                                    <p class="card-text" style="margin-top:20px;text-align:justify;font-size:16px;font-weight:bolder"><?php echo $visitorData['feedback'];?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $i=0;
                }else{?>
                <div class="carousel-item" data-bs-interval="2000">
                    <div class="card" style="width:750px;height:126px;">
                        <div class="card-body" style="text-align:center;margin-top:-10px;">
                            <div style="display:flex;width:100%;height:115px;gap:10px;">
                                <div style="width:25%;border-right:1px solid black">
                                    <img src="./images/user_img.jpg" alt="" style="width:40px;margin-top:10px;">
                                    <p class="card-title" style="font-size:15px;font-weight:bold"><?php echo $visitorData['visitor_name']." ";?></p>
                                    <p><span style="font-size:12px;"><?php echo date("d-m-Y H:i:s A",strtotime($visitorData['feedback_date'])); ?></span></p>
                                </div>
                                <div style="width:75%;">
                                    <p class="card-text" style="margin-top:20px;text-align:justify;font-size:16px;font-weight:bolder"><?php echo $visitorData['feedback'];?></p>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
                
                <?php }
                }
            }else{?>
            <div class="carousel-item active" data-bs-interval="2000">
                    <div class="card" style="width:750px;height:126px;">
                        <div class="card-body" style="text-align:center;margin-top:30px;">
                            <p class="card-text" style="font-size:16px;font-weight:bolder"><?php echo " Visitor Feedback Not Found";?></p>
                        </div>
                    </div>
                </div>
            <?php }?>  
              </div>
              <button style="background-color:black;width:20px;height:60px;margin-top:52px;margin-left:10px;border-radius:50px;" class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button style="background-color:black;width:20px;height:60px;margin-top:52px;margin-right:10px;border-radius:50px;" class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
        
    
    <!-- <div class="card" style="width:700px;height:140px;">
  <div class="card-header" style="font-weight:bold">Visitor Feedback</div>
  
  <div class="card-body">
    <h5 class="card-title">
    <select name="" id="feedback" class="form-control" style="width:150px;">
        <option value="">--Select Visitor--</option>
    <?php while($visitorData = $resultVisitorFeedback->fetch_assoc()){
     ?>
    <option style="text-align:center" value="<?php echo $visitorData['visitor_name']; ?>"><?php echo $visitorData['visitor_name']; ?></option>
    <?php }?>
    </select>
    
    </h5>
    <p class="card-text" style="text-align:justify" id="response_message"></p>
    
  </div>
</div> -->
</div>
    
    
<div style="display:flex;justify-content:right;align-items:center;height:710px;">
<span style="font-size:52px;font-family:FiresideDemo;margin-top:-140px;margin-left:-60px;
            width:200px;font-weight:bolder">retail</span>

<label for="" class="fireside-text"><span style="margin-top:20px;">X</span><span style="font-size:52px;font-weight:bolder">pert</span></label>

<!-- <span style="font-size:52px;font-family:fireSideDemo;margin-top:70px;margin-left:80px;
            width:265px;font-weight:bolder">Retail</span>
<span style="margin-left:-40px;margin-top:20px;font-family:fireSideDemo;font-size:150px;width:200px;">X</span>
<span style="font-weight:bolder;font-size:52px;margin-top:-65px;font-family:fireSideDemo;margin-left:-85px;width:360px">pert</span> -->

<br>
<div style="position:absolute;left:10px;top:10px;">
        
    
    <!-- <video controls>
        <source src="<?php echo BASE_URL; ?>/videos/softwareDemo.mp4" type="video/mp4">
    </video> -->
</div>
<div class="developerName">
<label for="" style="font-size:larger">althaf <span style="margin-left: 8px;"> </span> hUssain   <span style="margin-left:10px;">j</span></label>
<br>
<label for="" style="font-size:15px;font-weight:bolder;margin-left:25px">mca final year project</label>
<br>
<label for="" class="batch" style="font-size:15px;margin-left:97px">(2023 - 2025)</label>
</div>



<form action="" method="post" id="visitor_form">
    <br>
    
    <h5 style="font-family:Verdana, Geneva, Tahoma, sans-serif;font-weight:bold">Register Here To Get</h5>
    <h5 style="font-family:Verdana, Geneva, Tahoma, sans-serif;font-weight:bold">Username & Password</h5>
    
    <input type="text" autocomplete="off" name="visitorName" id="visitorName" class="form-control" placeholder="Visitor Name" maxlength="50">
    <br>
    <input type="text" autocomplete="off" name="visitorMobile" id="visitorMobile" class="form-control" placeholder="Visitor Mobile" maxlength="10">
    <br>
        
   
        
   <div style="display:flex;gap:5px;">
    <input type="submit" id="newVisitorBtn" name="newVisitorButton" class="btn newVisitorButton" value="Register">
    <input type="submit" id="existingUserBtn" name="existingUserButton" class="btn existingUserButton" value="Existing User">
   </div>
   <br>
   <label>Total Visitors : <b><?php echo $resultTotalVisitor['total_visitor']; ?></b></label>
   
</form>
</div>

<?php

function generatePassword($length = 6) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#&*_';
    $password = '';
    $maxIndex = strlen($chars) - 1;

    for ($i = 0; $i < $length; $i++) {
        $index = random_int(0, $maxIndex);
        $password .= $chars[$index];
    }

    return $password;
}


$formsName = ["company_form",
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

if(isset($_POST['newVisitorButton'])){
        extract($_POST);
        if($visitorName !="" and strlen($visitorMobile)==10){
            $queryCheckVisitor = "select*from visitor_master where mobile = '$visitorMobile'";
            $resultCheckVisitor = $con->query($queryCheckVisitor);
            if($resultCheckVisitor->num_rows>=1){
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="failure-alert">
                      <label style="margin-left:40px;">Mobile Number Already Exist</label>
                    </div>';    
            }else{
            
            date_default_timezone_set("Asia/kolkata");
            $currentDate = date("Y-m-d H:i:s A");
            
        
            $queryCreateNewVisitor = "insert into visitor_master (name,mobile,created_date) values('$visitorName','$visitorMobile','$currentDate')";
            $resultCreateNewVisitor = $con->query($queryCreateNewVisitor);
            
            $_SESSION['user_name']     = $userName = $visitorName."@Admin";
            $_SESSION['user_password'] = $userPassword = generatePassword();
            
            $encryptedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
            
            $querySearchUserExist = "select*from user_master1 where user_name = '$userName' && user_role = 'Admin'";
            $resultSearchUserExist = $con->query($querySearchUserExist);
            
            if($resultSearchUserExist->num_rows==0){
                    
                    
                    
                $queryCreateUser = "INSERT INTO user_master1 (user_name, user_pass, user_role, created_date, branch_id,login_status) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($queryCreateUser);
                
                
                // $queryInsertUserCrudPermission = ""
                
                // Bind the parameters
                $role = "Admin";
                $branch = 16;
                $login_status = 0;
                 $stmt->bind_param("ssssii", $userName, $encryptedPassword, $role,$currentDate, $branch,$login_status);                                               
                 
                 
                 if ($stmt->execute()) {
                        
                    $querySearchUserId = "select*from user_master1 where user_name = '$userName' &&
                    user_role = 'Admin' && branch_id = '16'";
                    $resultSearchUserId = $con->query($querySearchUserId)->fetch_assoc();
                    
                    
                    $queryInsertUserFormPermission = "INSERT INTO user_forms_permission (branch_id, user_id, company_form,
                    branch_form, supplier_form, customer_form, sales_person_form, product_form,
                    brand_form, design_form, color_form, batch_form, category_form, hsn_form,
                    tax_form, size_form, mrp_form, item_form, purchase_form, purchase_return_form,
                    sales_form, reports_form, user_info_form, user_management_form)
                    VALUES ('$resultSearchUserId[branch_id]', '$resultSearchUserId[id]', '0', '0', '1', '1', '1',
                    '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1',  '1', '1', '1', '1', '1', '1')";
                    
                    $resultInsertUserFormPermission = $con->query($queryInsertUserFormPermission);
                    foreach($formsName as $fNames){
                     
                            $queryInsertUserCrudPermission = "insert into user_crud_permission
                                                         (form_name, create_op,reprint_op,
                                                         update_op,delete_op,user_id,branch_id)
                                                         values('$fNames', '1','1','1','1',
                                                         '$resultSearchUserId[id]','$resultSearchUserId[branch_id]')";
                            $resultInsertUserCrudPermission = $con->query($queryInsertUserCrudPermission);
                     }
                 
                 
                    // $_SESSION['success'] = "User Created Successfully";
                    // header("Location:".BASE_URL."/index.php");
                    // exit();
                     
                }
                
                
                
            }
            
            
            if($resultCreateNewVisitor){
                
                $querySearchUserExist = "select*from user_master1 where user_name = '$_SESSION[user_name]' && user_role = 'Admin'";
                $resultSearchUserExist = $con->query($querySearchUserExist)->fetch_assoc();
                
                // $_SESSION['greeting'] = "Thank You For Your Registration - Kindly Note Your User Name And Password";        
                // $_SESSION['success'] = "User Name = 'admin@abc' and Password = '123'";        
                // header("Location:".BASE_URL."/index.php");
                
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="greeting-alert">
                      Thank You For Your Registration - Kindly Note Your User Name And Password
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    $userName = $resultSearchUserExist['user_name'];
                    $userPass = $resultSearchUserExist['user_pass'];
                    
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert" style="display:none">';
                echo 'User Name : '."$userName";
                echo ' Password : '."$userPassword";
                echo  '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                
                
            }
        }
            
        }else{
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert" id="failure-alert">
                      <label style="margin-left:40px;">Please Enter Valid Details</label>
                    </div>';
        }
        
    }elseif(isset($_POST['existingUserButton'])){
            // error_reporting(E_ALL);
            // ini_set("display_errors",1);
        header("Location:".BASE_URL."/login.php");
    }
?>    


<?php include_once(DIR_URL."/includes/footer.php"); ?>



<?php ob_end_flush(); ?>

<script>

document.getElementById("visitorName").addEventListener("keydown",function(event){
    if(event.key === "Enter"){
        event.preventDefault();
        document.getElementById("visitorMobile").focus();
    }
})

document.getElementById("visitorMobile").addEventListener("keydown",function(event){
    if(event.key === "Enter"){
        event.preventDefault();
        document.getElementById("newVisitorBtn").focus();
    }
})



setTimeout(() => {
  var alertBox = document.getElementById("greeting-alert");
    if(alertBox){
        alertBox.style.display='none';
    }
}, 2000);

setInterval(()=>{
    var alertBox = document.getElementById("success-alert");
    if(alertBox){
        alertBox.style.display = "block";
    }
},2000)

// Check if form was submitted previously
if (sessionStorage.getItem('formSubmitted')) {
    // Prevent auto-resubmission on refresh
    history.replaceState(null, '', location.href);
}

// On form submit, store a flag
document.getElementById("visitor_form").addEventListener("submit", function () {
    sessionStorage.setItem('formSubmitted', 'true');
});



// setTimeout(() => {
//   var alertBox = document.getElementById("success-alert");
//     if(alertBox){
//         alertBox.style.display='none';
//     }
// }, 3000);


// setInterval(()=>{
//     var alertBox = document.getElementById("success-alert");
//     if(alertBox){
//         alertBox.style.display = "none";
//     }
// },2000)

// setTimeout(() => {
//   var alertBox = document.getElementById("failure-alert");
//     if(alertBox){
//         alertBox.style.display='none';
//     }
// }, 3000);



window.onload = function(){
    document.getElementById("visitorName").focus();

}








document.getElementById("visitorName").addEventListener("keypress", function(event){

    if(event.key === "Enter"){
        event.preventDefault();
        document.getElementById("visitorMobile").focus();
    }
})

document.getElementById('visitorMobile').addEventListener('keypress', function (event) {
            const charCode = event.which || event.keyCode; // Get the character code
            const charStr = String.fromCharCode(charCode); // Convert to a string

            // Allow digits (0-9) and a single decimal point
            if (!charStr.match(/^[0-9 '']$/) || (charStr === '' && this.value.includes(''))) {
                event.preventDefault(); // Prevent input if not a number or extra decimal
            }
        });

        document.getElementById('visitorMobile').addEventListener('input', function () {
            // Prevent any invalid characters that might slip through (e.g., copy-paste)
            this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
});



document.getElementById("visitorMobile").addEventListener("keypress", function(event){

if(event.key === "Enter"){
    event.preventDefault();
    document.getElementById("newVisitorBtn").focus();
}
})

setTimeout(() =>{
    let alertbox = document.getElementById("failure-alert");
    if(alertbox){
        alertbox.style.display = "none";
    }
    
},3000)

// document.getElementById("visitorName").addEventListener("keydown",function(event){
//         if(event.key === "F5"){
//             event.preventDefault();
            
//         }
// })
// document.getElementById("visitorMobile").addEventListener("keydown",function(event){
//         if(event.key === "F5"){
//             event.preventDefault();
            
//         }
// })

</script>

<style>

@font-face{
  font-family: 'FiresideDemo';
  src: url('fonts/FIRESIDE-DEMO.woff') format('woff');
  /*src: url('https://www.retailxpert.in/public_html/fonts/FIRESIDE-DEMO.woff2') format('woff2');*/
       /*url('https://www.retailxpert.in/public_html/fonts/FIRESIDE-DEMO.woff') format('woff'),*/
       /*url('https://www.retailxpert.in/public_html/fonts/FIRESIDE-DEMO.otf') format('opentype');*/
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
#success-alert{
    position:absolute;
    text-align: center;
    top:130px;
    border-radius: 5px;
    right:123px; 
    /* color:white; */
    padding-top:15px;
    height: 60px;
    width:30%;
    font-weight: bolder;
    /* /* border:1px solid  #FF3CAC; */
    /* background-color: #FF3CAC; */
    /* background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);  */
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

.newVisitorButton{
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    width:130px;
    color: white;
    margin-left:100px;
    border: none;
    font-weight:bold;

}
.existingUserButton{
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    width:135px;
    color: white;
    /*margin-left:10px;*/
    border: none;
    font-weight:bold;

}
#visitor_form{
    box-shadow: rgba(57, 57, 58, 0.9) 0px 7px 29px 0px;
    background-color: white;
    height:320px;
    margin-right:120px;
    width:460px;
    border-radius:20px;
    text-align:center;
    
}
#visitorName{
    width:270px;
    margin-left:100px;
    
}
#visitorMobile{
    width:270px;
    margin-left:100px;
}

</style>
