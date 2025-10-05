<?php
ob_start();
include_once("../config/config.php");
include_once("../db/dbConnection.php");
include_once(DIR_URL . "/includes/header.php");
include_once(DIR_URL . "/includes/navbar.php");
include_once(DIR_URL . "/includes/sidebar.php");

$userName = $_SESSION['user_name'];
$visitorId = $_SESSION['user_id'];
$visitorBranchId = $_SESSION['user_branch_id'];


$afterExplode = explode("@", $userName);



$visitorName = $afterExplode[0];

// if(isset($_POST['submitButton'])){

//     extract($_POST);

//     date_default_timezone_set("Asia/kolkata");
//     $currentDate = date("Y-m-d H:i:s A");

//     $querySearchVisitor = "select*from visitor_feedback where visitor_id = '$visitorId'";
//     $resultSearchVisitor = $con->query($querySearchVisitor);
//     if($resultSearchVisitor->num_rows==0){
//         $queryVisitorFeedback = "insert into visitor_feedback(visitor_name, feedback,feedback_date,visitor_id,branch_id)
//                             values('$visitorName', '$feedback','$currentDate', '$visitorId', '$visitorBranchId')";
//         $resultVisitorFeedback = $con->query($queryVisitorFeedback);

//         if($resultVisitorFeedback){
//             $_SESSION['success'] = "Your Feedback Is Submitted";
//             header("Location:".BASE_URL."/pages/visitorFeedbackPage.php");
//         }else{
//             $_SESSION['failure'] = "Oops Something Went Wrong";
//             header("Location:".BASE_URL."/pages/visitorFeedbackPage.php");
//         }
//     }else{
//         $queryUpdateVisitorFeedback = "update visitor_feedback
//                 set feedback = '$feedback' where visitor_id = '$visitorId' && branch_id = '$visitorBranchId'";
//         $resultUpdateVisitorFeedback = $con->query($queryUpdateVisitorFeedback);

//         if($resultUpdateVisitorFeedback){
//             $_SESSION['success'] = "Your Feedback Is Submitted";
//             header("Location:".BASE_URL."/pages/visitorFeedbackPage.php");
//         }else{
//             $_SESSION['failure'] = "Oops Something Went Wrong";
//             header("Location:".BASE_URL."/pages/visitorFeedbackPage.php");
//         }
//     }


// }

if (isset($_POST['submitButton'])) {

    mysqli_begin_transaction($con);

    try {
        extract($_POST);

        date_default_timezone_set("Asia/kolkata");
        $currentDate = date("Y-m-d H:i:s A");

        $querySearchVisitor = "SELECT * FROM visitor_feedback WHERE visitor_id = '$visitorId'";
        $resultSearchVisitor = $con->query($querySearchVisitor);

        if ($resultSearchVisitor->num_rows == 0) {
            $queryVisitorFeedback = "INSERT INTO visitor_feedback(visitor_name, feedback, feedback_date, visitor_id, branch_id)
                                     VALUES('$visitorName', '$feedback', '$currentDate', '$visitorId', '$visitorBranchId')";
            $resultVisitorFeedback = $con->query($queryVisitorFeedback);

            if ($resultVisitorFeedback) {
                mysqli_commit($con);
                $_SESSION['success'] = "Your Feedback Is Submitted";
                header("Location:" . BASE_URL . "/pages/visitorFeedbackPage.php");
                exit;
            } else {
                throw new Exception("Insert failed");
            }
        } else {
            $queryUpdateVisitorFeedback = "UPDATE visitor_feedback
                                           SET feedback = '$feedback'
                                           WHERE visitor_id = '$visitorId' AND branch_id = '$visitorBranchId'";
            $resultUpdateVisitorFeedback = $con->query($queryUpdateVisitorFeedback);

            if ($resultUpdateVisitorFeedback) {
                mysqli_commit($con);
                $_SESSION['success'] = "Your Feedback Is Submitted";
                header("Location:" . BASE_URL . "/pages/visitorFeedbackPage.php");
                exit;
            } else {
                throw new Exception("Update failed");
            }
        }
    } catch (Exception $e) {
        mysqli_rollback($con);
        $_SESSION['failure'] = "Oops Something Went Wrong";

        // echo '<script>
        //   document.addEventListener("DOMContentLoaded", function() {
        //       let toastLive = document.getElementById("liveToast");
        //       if (toastLive) {
        //           toastLive.querySelector(".toast-body").textContent = "Error: ' . addslashes($e->getMessage()) . '";
        //           let toast = new bootstrap.Toast(toastLive);
        //           toast.show();
        //       }
        //   });
        // </script>';
    }
}


?>

<style>
    #visitorName {
        width: 360px;
        font-size: 20px;
        font-weight: bold;
        /* text-transform: capitalize; */
        height: 50px;
        padding-top: 20px;
        /* margin-left:300px; */
    }

    #feedback {
        width: 360px;
        font-size: 20px;
        font-weight: bold;
        /* text-transform: capitalize; */
        height: 150px;
        padding-top: 20px;
        /* margin-left:300px; */
    }

    #visitorFeedbackForm {
        /* background-color: white; */

        position: absolute;
        top: 110px;
        width: 1150px;
        left: 300px;

        /* box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px; */
    }
</style>

<?php
if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
} else {
    $_SESSION['success'] = "";
}
?>
<?php if ($_SESSION['success']) { ?>
    <div class="alert alert-success" id="success-alert">
        <?php echo $_SESSION['success']; ?>
    </div>
<?php } ?>

<body>

    <form action="" class="visitorFeedbackForm" id="visitorFeedbackForm" method="post">
        <h3 style="text-align:left;font-family:Verdana, Geneva, Tahoma, sans-serif;"><span
                style="font-weight:bolder">Manage </span><span
                style="font-size:12px;font-weight:bold;color:gray;">Visitor Feedback</span></h3>
        <hr>
        <div style="display:flex;">

            <div class="form-floating" hidden>
                <input type="text" name="visitorName" autocomplete="off" id="visitorName" class="form-control" readonly
                    placeholder="Name" value="<?php echo  $visitorName; ?>" maxlength="50">
                <label for="floatingInput" style="color:#2B86C5;margin-top:-10px;">Visitor Name <span
                        style="color:red;font-size:20px;">*</span></label>
            </div>
            <!-- <input type="text" name="shortName" id="shortName" class="form-control" placeholder="Short Name"> -->
        </div>
        <br>
        <div class="form-floating">
            <textarea name="feedback" id="feedback" required rows="20" cols="40" placeholder="" class="form-control"
                maxlength="100"></textarea>
            <label for="" style="color:#2B86C5;">Put Your Feedback</label>
        </div>
        <br>
        <hr style="width:520px;">
        <div style="display:flex;gap:10px;">
            <button class="btn btn-success" style="width:120px;" name="submitButton" id="submitButton">Submit</button>
            <a href="<?php echo BASE_URL; ?>/pages/visitorFeedbackPage.php" style="width:120px;"
                class="btn btn-warning">Cancel</a>
        </div>
        <hr style="width:520px;">
    </form>

</body>

<script>
    window.onload = function() {
        document.getElementById("feedback").focus();
    }

    document.getElementById("feedback").addEventListener("keydown", function(event) {
        let target = event.target

        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("submitButton").focus();
        }

    })

    setTimeout(() => {
        let successMessage = document.getElementById('success-alert');
        if (successMessage) {
            successMessage.style.display = "none";
        }
    }, 2000)
</script>


<?php ob_end_flush(); ?>

<?php
include_once(DIR_URL . "/includes/footer.php");
?>

<style>
    #success-alert {
        position: absolute;
        top: 70px;
        left: 260px;
        color: white;
        padding-top: 6px;
        height: 40px;
        width: 90%;
        font-weight: bolder;
        /* border:1px solid  #FF3CAC; */
        background-color: #FF3CAC;
        background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);

    }
</style>