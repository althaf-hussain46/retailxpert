<?php 
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");

$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$userBranchState = $_SESSION['branch_state'];


if(isset($_POST['get_user_info'])){

    $userName = $_POST['get_user_info'];
    
    if($_SESSION['user_role'] == "Super Admin"){
      $querySearchUserInfo = "select*from user_master1 where user_name like '%$userName%'";
    }elseif($_SESSION['user_role'] == "Admin"){
      $querySearchUserInfo = "select*from user_master1 where user_name like '%$userName%' and
                          branch_id = '$userBranchId' and user_role in ('Admin','Manager','User')";
    }elseif($_SESSION['user_role'] == "Manager"){
      $querySearchUserInfo = "select*from user_master1 where user_name like '%$userName%' and
                          branch_id = '$userBranchId' and user_role in ('User')";
    }
    
    
    $resultSearchUserInfo = $con->query($querySearchUserInfo);
    
}
?>
<style>
#userInformationTable{
color:white;
background-color: #FF3CAC;
background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}

</style>

<?php if(isset($resultSearchUserInfo)){ ?>
    <form style="width:270px;position:absolute;top:270px;left:300px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
  <div style="max-height: 210px; overflow-y: auto; width: 270px;">
    <table id="userInformationTable" class="table" style="font-size:11px;width: 100%; table-layout: fixed; border-collapse: collapse;">
      <thead>
        <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
          <th style="width: 30px;"><button class="btn-close" type="button"
          onclick="
            document.getElementById('userInformationTable').style.display = 'none';
          "
          style="background-color:#FF3CAC;"></button></th>
                    <th>User Name</th>
                    <th>User Role</th>
                </tr>
            </thead>
            <tbody>
            <?php   while($userData = $resultSearchUserInfo->fetch_assoc()){?>
                <tr onclick=" 
                document.getElementById('userName').value = '<?php echo htmlspecialchars($userData['user_name']);?>'
                document.getElementById('userRole').value = '<?php echo htmlspecialchars($userData['user_role']);?>'
                document.getElementById('userId').value = '<?php echo htmlspecialchars($userData['id']);?>'
                document.getElementById('branchId').value = '<?php echo htmlspecialchars($userData['branch_id']);?>'
                document.getElementById('userInformationTable').style.display='none';
                document.getElementById('searchUser').click();
                 ">
                
                
                
                    <td></td>
                    <td><?php echo $userData['user_name']; ?></td>
                    <td><?php echo $userData['user_role']; ?></td>
                </tr>
            <?php }?>
            </tbody>
        </table>

</div>
</form>

<?php }?>