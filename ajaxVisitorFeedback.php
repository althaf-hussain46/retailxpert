<?php

include_once("./config/config.php");
include_once(DIR_URL."/db/dbConnection.php");

if(isset($_POST['lb_visitor_name'])){
        $visitorName = $_POST['lb_visitor_name'];
        $querySearchFeedback  = "select*from visitor_feedback
                                 where visitor_name  = '$visitorName'";
        $resultSearchFeedback  = $con->query($querySearchFeedback);
        $resultSearchFeedbackDate  = $con->query($querySearchFeedback);
        
}


?>

<body>
    <div style="position:absolute;bottom:10px;left:30px;">
    <?php 
        while($visitorData = $resultSearchFeedbackDate->fetch_assoc()){
            echo date("d-m-Y H:i:s",strtotime($visitorData['feedback_date']));
            }   
    ?>
    </div>
    
    <div style="height:80px;overflow-x:auto;overflow-y:auto;position:absolute;left:180px;
    top:50px;width:500px;">
        <label for="" style="text-align:justify">
           <?php 
           $i=1;
            while($visitorData = $resultSearchFeedback->fetch_assoc()){
            echo '"'.$visitorData['feedback'].'"';
            }   
           ?> 
      </label>
    </div>
    
    
</body>