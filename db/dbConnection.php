<?php


session_start();

// Main server connection
$mainHostName = "localhost";
$mainUserName = "u518829414_althaf";
$mainUserPass = "AlthafHussain1";
$mainDataBase = "u518829414_sample";

$con = mysqli_connect($mainHostName, $mainUserName, $mainUserPass, $mainDataBase);

// Check connections
if (!$con) {
    die("Main Database Connection Failed: " . mysqli_connect_error());
}

// Location - Counter connection
$locationHostName = "localhost";
$locationUserName = "u518829414_hussain";
$locationUserPass = "AlthafHussain1";
$locationDataBase = "u518829414_location";

$locationConnection = mysqli_connect($locationHostName, $locationUserName, $locationUserPass, $locationDataBase);

// Check connection
if (!$locationConnection) {
    die("Location Database Connection Failed: " . mysqli_connect_error());
}




// session_start();
// //connection for main server


// $mainHostName = "localhost:3307";
// $mainUserName = "root";
// $mainUserPass = "";
// $mainDataBase = "g_soft";

// try {
//     $con = mysqli_connect($mainHostName,$mainUserName,
//     $mainUserPass,$mainDataBase);

//     // Check connection
//     if ($con->connect_error) {
//         throw new Exception("Connection failed: " . $con->connect_error);
//     }

//     return $con; // Connection successful
// } catch (Exception $e) {
//     // Log or display the error
//     echo "Error: " . $e->getMessage();
// }


// // connection for location - counter

// $locationHostName = "localhost:3307";
// $locationUserName = "root";
// $locationUserPass = "";
// $locationDataBase = "location";


// try {
//     $locationConnection = mysqli_connect($locationHostName,$locationUserName,
//     $locationUserPass,$locationDataBase);

//     // Check connection
//     if ($locationConnection->connect_error) {
//         throw new Exception("Connection failed: " . $locationConnection->connect_error);
//     }

//     return $locationConnection; // Connection successful
// } catch (Exception $e) {
//     // Log or display the error
//     echo "Error: " . $e->getMessage();
// }


?>