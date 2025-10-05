<?php
session_start();

if (isset($_POST['supplierState'])) {
    $_SESSION['supplier_state'] = $_POST['supplierState']; // Store the selected supplier name in session
    // echo "Supplier state updated to: " . $_SESSION['supplier_state'];
} else {
    echo "No supplier name received!";
}
?>
