<?php 
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");
include_once(DIR_URL."/includes/header.php");
include_once(DIR_URL."/includes/navbar.php");
include_once(DIR_URL."/includes/sidebar.php");



?>
<style>
    #shortManual{
        margin-left:280px;
        font-family:Verdana;
        margin-top:20px;
        
    }
    #content{
        
        margin-left:250px;
        font-size:20px;
        max-height:500px;
        overflow-x:auto;
    }
</style>
<body>
    <h1 id="shortManual">Short Manual</h1>
    <div id="content">
        <br>
            <h5 style="margin-left:60px;font-weight:bold">Purchase Entry – Key Features</h5>
            <br>
            <pre style="margin-left:-50px;">
                1. Users  can  directly  type  all  attributes (e.g., Product, Brand, Design, etc.) in the Purchase Entry form.
                   These attributes will be automatically created — there's no need to add them separately in a different form.
                   
                2. Press F2 to view a list of previously created attributes and select them using the mouse.
                
                3. Press F4 to view a full list of previously created items and select them using the mouse.
            </pre>
    
            <div style="display:flex;heigt:100px;justify-content:center">
                <img style="text-align:center" src="<?php echo BASE_URL;?>/images/purchaseEntryForm.jpg">    
            </div>
    <br>
    <br>
    <h5 style="margin-left:60px;font-weight:bold">Sales Entry – Key Features</h5>
            <br>
            <pre style="margin-left:-50px;">
                1. Type something and press F4 to list previously created items and select them using the mouse.
                
                2. Press F4 to view a full list of previously created items and select them using the mouse.
            </pre>
    
            <div style="display:flex;height:300px;justify-content:center;width:700px;margin-left:278px;">
                <img style="text-align:center;width:680px;" src="<?php echo BASE_URL;?>/images/salesEntryForm.jpg">    
            </div>
    <br>
    <br>
    <!--<h5 style="margin-left:60px;font-weight:bold">Important Note :</h5>-->
        <pre>
          <!--If menus are not displaying properly, click on “Dashboard” and then try accessing the menus-->
          <!--again. (This issue will be fixed in a future update.)        -->
        </pre>
        
        <div style="display:flex;height:500px;justify-content:center">
        <!--    <video>-->
        <!--        <source>-->
        <!--    </video>-->
        <!--<video src="<?php echo BASE_URL; ?>videos/softwareDemo.mp4"  controls></video>     
        -->
        
        <a href="https://drive.google.com/file/d/1mAIXT4P57S3A7-4Uc-ysghSSBiWxQLuN/view?usp=sharing"
        style="font-size:25px;" target="_blank">Software Demo Link</a>
            <!-- <video controls>
                <source src="<?php echo BASE_URL; ?>/videos/softwareDemo.webm" type="video/webm">
                Your browser does not support the video tag.
            </video> -->

        </div>
    
        
        
    </div>
    

    
</body>


<?php
include_once(DIR_URL."/includes/footer.php");
?>