<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
ob_start();
include_once('../config/config.php');
include_once(DIR_URL."/includes/header.php");
include_once(DIR_URL."/db/dbConnection.php");

$querySearchBranch = "select*from branches";
$resultSearchBranch = $con->query($querySearchBranch);

$querySearchFinancial = "select*from financial order by financial_year DESC";
$resultSearchFinancial = $con->query($querySearchFinancial);

?>

<div style="display:flex;justify-content:center;align-items:center;height:712px;">


<form action="" id="branchFinancialForm" method="post">
        <br>
        <h5 style="text-align:center;font-family:Verdana, Geneva, Tahoma, sans-serif"><?php echo $_SESSION['branch_name'];?></h5>
        <label for=""   class="companyAddress1"><?php echo $_SESSION['branch_address1'] ?></label>
        <label for=""   class="companyAddress2"><?php echo $_SESSION['branch_address2'] ?></label>
        <label for=""   class="companyAddress3"><?php echo $_SESSION['branch_address3'] ?></label>
        <label for=""   class="companyLocality"><?php echo $_SESSION['branch_locality'] ?></label>
        <span style="display:flex;gap:3px;justify-content:center;">
        <label for=""   class="companyCity"><?php echo $_SESSION['branch_city'] ?></label>-
        <label for=""   class="companyPincode"><?php echo $_SESSION['branch_pinCode'] ?></label>
        </span>
        <label for=""   class="companyState"><?php echo $_SESSION['branch_state'] ?></label>
        <span style="display:flex;gap:640px;">
        <label for=""   class="companyLandline" style="margin-left:20px">Landline : <?php echo $_SESSION['branch_landline'] ?></label>
        <label for=""   class="companyMobile">Mobile : <?php echo $_SESSION['branch_mobile'] ?></label>
        </span>
        <span style="display:flex;gap:500px;">
        <label for=""   class="companyGstNo" style="margin-left:20px;">GST NO : <?php echo $_SESSION['branch_gst_no'] ?></label>
        <label for=""   class="companyEmail" style="margin-left:35px;">Email : <?php echo $_SESSION['branch_email'] ?></label>
        </span>
        
        
        
        
        
        
        
        <hr>

        
        <h6 style="text-align:center;font-family:Verdana, Geneva, Tahoma, sans-serif">Select Financial Year</h6>
        
        <select name="financialYearSelection" id="financialYearSelection" class="form-control custom-select">
        
            <?php while($financialData = $resultSearchFinancial->fetch_assoc()){ ?>
            <option value="<?php echo $financialData['financial_year']; ?>"><?php echo $financialData['financial_year'];?></option>
            
            
            <?php };?>
            
        </select>
        
        
        
        
        
        <button type="submit" id="financialYearBtn" class="btn financialYearBtn" name="financialYearBtn">Submit</button>
        
</form>

</div>


<?php include_once(DIR_URL."/includes/footer.php");?>

<?php

if(isset($_POST['financialYearBtn'])){
    extract($_POST);
    // $_SESSION['branch_name'] = $branchSelection;
    
    
    
    $querySearchFinancial2 = "select*from financial where financial_year = '$financialYearSelection'";
    $resultSearchFinancial2 = $con->query($querySearchFinancial2);
    while($financialTableData = $resultSearchFinancial2->fetch_assoc()){
        $_SESSION['from_date'] = $financialTableData['from_date'];
        $_SESSION['to_date'] = $financialTableData['to_date'];
        $_SESSION['financial_year'] = $financialTableData['financial_year'];
    }
    header("Location:homePage.php");
}
?>

<?php ob_end_flush(); ?>
<style>
body{
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}
.financialYearBtn{
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    width: 270px;
    border:none;
    text-align:center;
    margin-left:360px;
    margin-top:150px;
    color:white;
    /* padding-left:35px; */
}
#branchFinancialForm{
    height: 580px;
    width: 1000px;
    background-color: white;
    border-radius: 25px;
    
}
#branchSelection{
    width: 270px;
    text-align:center;
    margin-left:360px;
    padding-left:10px;
}
#financialYearSelection{
    width: 270px;
    text-align:center;
    margin-left:360px;
    padding-left:10px;
    

}

.companyAddress1{
    display: flex;
    justify-content: center;
}
.companyAddress2{
    display: flex;
    justify-content: center;
}
.companyAddress3{
    display: flex;
    justify-content: center;
}
.companyLocality{
    display: flex;
    justify-content: center;
}
.companyCity{
    /* display: flex;
    justify-content: center; */
}
.companyPincode{
    /* display: flex;
    justify-content: center; */
}
.companyState{
    display: flex;
    justify-content: center;
}
.companyLandline{

}
.companyMobile{

}
.companyEmail{

}
.companyGstNO{

}

.custom-select {
  -webkit-appearance: none; /* Removes default arrow in Chrome/Safari */
  -moz-appearance: none;    /* Removes default arrow in Firefox */
  appearance: none;         /* Removes default arrow in modern browsers */
  background-color: #fff;   /* Set background color */
  border: 1px solid #ccc;   /* Border style */
  padding: 8px 4px 8px 12px; /* Padding with space for the chevron */
  background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" width="10" height="6" viewBox="0 0 10 6"%3E%3Cpath fill="%23000" d="M5 6L0 0h10z"/%3E%3C/svg%3E'); /* Alternate downward chevron */
  background-repeat: no-repeat; /* Prevent repetition */
  background-position: right 10px center; /* Position the chevron */
  background-size: 10px 6px; /* Chevron dimensions */
  border-radius: 4px; /* Rounded corners */
  font-size: 16px; /* Font size */
}

.custom-select:focus {
  outline: none; /* Remove outline on focus */
  border-color: #007bff; /* Highlight border color on focus */
  box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25); /* Focus shadow */
}






</style>


<script>
window.onload = function(){
document.getElementById("financialYearBtn").focus();
}
</script>
<!-- <h6 style="text-align:center;font-family:Verdana, Geneva, Tahoma, sans-serif">Select branch</h6>
        
        <select name="branchSelection" id="branchSelection" class="form-control custom-select">
            <?php while($branchData = $resultSearchBranch->fetch_assoc()){ ?>
            <option  value="<?php echo $branchData['branch_name']; ?>"><?php echo $branchData['branch_name'];?></option>
            <?php };?>
        </select> -->
