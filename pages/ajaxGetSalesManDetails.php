<?php 
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");

$userId = $_SESSION['user_id'];
$userBranchId = $_SESSION['user_branch_id'];
$userBranchState = $_SESSION['branch_state'];


if(isset($_POST['get_sales_man_details_f2'])){

    $salesPersonName = $_POST['get_sales_man_details_f2'];
    
    // echo $salesPersonName;
    if($_SESSION['user_role'] == "Super Admin"){
      $querySearchSalesPersonInfo = "select*from sales_person where sales_person_name like '%$salesPersonName%' order by sales_person_name";
    }else{
      $querySearchSalesPersonInfo = "select*from sales_person where sales_person_name like '%$salesPersonName%' and
                          branch_id = '$userBranchId' order by sales_person_name";
    }
    
    
    $resultSearchSalesPersonInfo = $con->query($querySearchSalesPersonInfo);
    
}
if(isset($_POST['sr_get_sales_man_details_f2'])){

    $salesPersonName = $_POST['sr_get_sales_man_details_f2'];
    
    // echo $salesPersonName;
    if($_SESSION['user_role'] == "Super Admin"){
      $querySearchSalesPersonInfo = "select*from sales_person where sales_person_name like '%$salesPersonName%'";
    }else{
      $querySearchSalesPersonInfo = "select*from sales_person where sales_person_name like '%$salesPersonName%' and
                          branch_id = '$userBranchId'";
    }
    
    
    $sr_resultSearchSalesPersonInfo = $con->query($querySearchSalesPersonInfo);
    
}
?>
<style>
#salesPersonInformationTable{
color:white;
background-color: #FF3CAC;
background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}

</style>

<?php if(isset($resultSearchSalesPersonInfo) or isset($sr_resultSearchSalesPersonInfo)){ ?>
    <form style="width:270px;position:absolute;top:300px;left:900px;z-index:1000;background-color: #FF3CAC;background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);">
  <div style="max-height: 210px; overflow-y: auto; ">
    <table id="salesPersonInformationTable" class="table" style="font-size:11px;width: 270px; table-layout: fixed; border-collapse: collapse;">
      <thead>
        <tr style="position: sticky; top: 0; z-index: 1;font-size: 12px;background-color:#FF3CAC">
          <th style="width: 30px;"><button class="btn-close" type="button"
          onclick="
            document.getElementById('salesPersonInformationTable').style.display = 'none';
          "
          style="background-color:#FF3CAC;"></button></th>
                    <th>S.P Name</th>
                    <th>S.P Code</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(isset($resultSearchSalesPersonInfo)){
                while($salesPersonData = $resultSearchSalesPersonInfo->fetch_assoc()){?>
                <tr onclick=" 
                let i =localStorage.getItem('row_index');
                
                document.getElementById('salesMan_'+i).value = '<?php echo htmlspecialchars($salesPersonData['id']);?>'
                document.getElementById('qty_'+i).focus();
                document.getElementById('salesPersonInformationTable').style.display='none';
                // document.getElementById('searchUser').click();
                 ">
                
                
                
                    <td></td>
                    <td><?php echo $salesPersonData['sales_person_name']; ?></td>
                    <td><?php echo $salesPersonData['id']; ?></td>
                </tr>
            <?php }
            }else{?>
            
            <?php   while($sr_salesPersonData = $sr_resultSearchSalesPersonInfo->fetch_assoc()){?>
                <tr onclick=" 
                let i2 =localStorage.getItem('sr_row_index');
                
                document.getElementById('sr_salesMan_'+i2).value = '<?php echo htmlspecialchars($sr_salesPersonData['id']);?>'
                document.getElementById('sr_qty_'+i2).focus();
                document.getElementById('salesPersonInformationTable').style.display='none';
                // document.getElementById('searchUser').click();
                 ">
                
                
                
                    <td></td>
                    <td><?php echo $sr_salesPersonData['sales_person_name']; ?></td>
                    <td><?php echo $sr_salesPersonData['id']; ?></td>
                </tr>
            <?php }
            }?>
            </tbody>
        </table>

</div>
</form>

<?php }?>