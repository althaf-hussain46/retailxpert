<!-- style="background-color:#00B2C6;border:1px solid black;" -->
<nav class="navbar  text-white"  data-bs-theme="dark">
  <div class="container-fluid">
    <span>
    <!--<label for="" class="companyShortName"><?php echo $_SESSION['company_short_name']; ?></label>-->
    <br>
    (F.Y <?php echo $_SESSION['financial_year'];?>)
    </span>
    
    
    
    
    <div style="display:flex;gap:50px">
    
    <span>
    <label for="" class="companyName"><?php echo $_SESSION['branch_name'];?></label>
    </span>
    <span class="location">
    <i class="fa-solid fa-location-dot" style="margin-right:5px"></i><label for=""><?php echo $_SESSION['branch_locality'];?></label>
    </span>
    <!-- <span style="margin-top:10px;">
    <img src="<?php echo BASE_URL;?>/images/user_img.jpg" alt="user image" style="width:40px" >      
    <label for="">Hello, <?php echo $_SESSION['user_name']; ?></label>
    <label for="" style="position:absolute;top:40px;right:195px;"><?php echo $_SESSION['user_role'];?></label>
    </span> -->
    <span style="margin-top:10px;">
  <img 
    src="<?php echo BASE_URL;?>/images/user_img.jpg" 
    alt="user image" 
    style="width:40px; cursor: pointer;" 
    data-bs-toggle="popover" 
    data-bs-trigger="hover focus" 
    data-bs-placement="bottom"
    data-bs-content="<?php echo $_SESSION['user_role']; ?>"
  
  >      
  <label for="">Hello, <?php echo $_SESSION['user_name']; ?></label>
  <br>
  
</span>
<span style="position:absolute;right:145px;top:45px;font-size:12px;">
(<?php echo $_SESSION['user_role']; ?>)
</span>
<!-- <label for="" style="margin-left:50px"></label> -->



    <span style="margin-top:10px">
      <!--<a href="<?php echo BASE_URL;?>/logout.php" class="btn btn-danger">Logout</a>-->
      <a href="<?php echo BASE_URL;?>/logout.php" class="btn btn-danger">Logout</a>
    </span>
    </div>
    
  </div>
</nav>


<style>
.navbar{
  background-color: #FF3CAC;
background-image: linear-gradient(135deg, #FF3CAC 0%, #784BA0 42%, #2B86C5 81%);
height: 70px;
width: 1518px;
}
.companyShortName{
  font-family:Verdana, Geneva, Tahoma, sans-serif;
  font-size: x-large;
}
.companyName{

  margin-right:200px;
}
.location{
  margin-right:20px;
  margin-top:30px;
}
</style>


<script>
  document.addEventListener('DOMContentLoaded', function () {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.forEach(function (popoverTriggerEl) {
      new bootstrap.Popover(popoverTriggerEl);
    });
  });
</script>
