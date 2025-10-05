<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");
$userLocationId = $_SESSION['user_location_id'];
// if (isset($_POST['grn_number'])) {
//     $grnNumber = $_POST['grn_number'];
//     $query = "SELECT 
//                                 purchase_item.*, 
//                                 items.*
//                                 FROM purchase_item
//                                 INNER JOIN items ON purchase_item.item_id = items.id
//                                 WHERE purchase_item.grn_number = '$grnNumber' 
//                                 AND purchase_item.location_id = '$userLocationId'";
//     $result = $con->query($query);

//     $items = [];
//     while ($row = $result->fetch_assoc()) {
//         $items[] = $row;
//     }

//     echo json_encode($items); // Return the data as JSON
// }
if (isset($_POST['grn_number'])) {
    $grnNumber = $_POST['grn_number'];
    $query = "SELECT 
                purchase_item.*, 
                items.*
              FROM purchase_item
              INNER JOIN items ON purchase_item.item_id = items.id
              WHERE purchase_item.grn_number = '$grnNumber'
              AND purchase_item.location_id = '$userLocationId'";
    $result = $con->query($query);

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    echo json_encode($items); // Return the data as JSON
}
?>
