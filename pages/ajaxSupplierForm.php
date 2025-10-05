<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");

if($_POST['supplier_form']){

    $supplier = $_POST['supplier_form'];
}
?>


<?php if($supplier){?>
<form action="">

    <input type="text" class="form-control" placeholder="Supplier Name" style="width:270px">
    
</form>


<?php }?>