<style>
@font-face {
    font-family: 'FiresideDemo';
    src: url('../fonts/FIRESIDE-DEMO.woff') format('woff');

}

.sidebar {
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);






}

.offcanvas-body a {
    color: black !important
}

#login_form {
    box-shadow: rgba(4, 248, 114, 0.904) 0px 7px 29px 0px;

}


.offcanvas-backdrop {
    display: none !important;
}


.sidebar {

    position: fixed;
    top: 70px;
    width: 262px;
    height: 100%;
}

.companyName {
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-size: xx-large;


}

.sidebar-link .right-icon {
    transition: all 0.5s;
}

.sidebar-link[aria-expanded="true"] .right-icon {
    transform: rotate(180deg);
}


#master_items {
    margin-right: 20px;
    border-right: 1px solid white;
}

#masterMenu a {
    color: white !important;
    /* font-size:small; */
}

#transactionsMenu a {
    color: white !important;
    /* font-size:small; */
}

#userMenu a {
    color: white !important;
    /* font-size:small; */
}

#helpMenu a {
    color: white !important;
    /* font-size:small; */
}

#trans_menu a {

    color: white !important;
    text-decoration: none;
    font-size: medium;
    padding: 5px 5px;
    font-weight: bold;

}

#trans_menu a:hover {
    padding: 5px 5px;
    display: block;
    background-color: #575757;

}

.developed {
    color: white;
    position: absolute;
    bottom: 125px;
    font-family: 'FiresideDemo';
    font-size: x-large;
    /* left: 95px; */

}

.developerName {
    color: white;
    position: absolute;
    bottom: 90px;
    font-family: 'FiresideDemo';
    font-size: small;
    /* left: 95px; */

}

li a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 5px 5px;
    font-weight: bold;
}

li a:hover {
    background-color: #575757;
}


/* li a {
    display: block;
    color: white;
    text-decoration: none;
    padding: 10px 15px;
  }
li a:hover {
    background-color: #575757;
  } */
</style>

<?php
// List of form access session keys and their corresponding element IDs

$formAccess = [
    'company_form_access' => 'company_form',
    'branch_form_access' => 'branch_form',
    'supplier_form_access' => 'supplier_form',
    'customer_form_access' => 'customer_form',
    'sales_person_form_access' => 'sales_person_form',
    'product_form_access' => 'product_form',
    'brand_form_access' => 'brand_form',
    'design_form_access' => 'design_form',
    'color_form_access' => 'color_form',
    'batch_form_access' => 'batch_form',
    'category_form_access' => 'category_form',
    'hsn_form_access' => 'hsn_form',
    'tax_form_access' => 'tax_form',
    'size_form_access' => 'size_form',
    'mrp_form_access' => 'mrp_form',
    'item_form_access' => 'item_form',
    'purchase_form_access' => 'purchase_form',
    'purchase_return_form_access' => 'purchase_return_form',
    'sales_form_access' => 'sales_form',
    'reports_form_access' => 'reports_form',
    'user_info_form_access' => 'user_info_form',
    'user_management_form_access' => 'user_management_form',





];



// Initialize an array to store display styles
$displayStyles = [];

foreach ($formAccess as $sessionKey => $elementId) {
    $displayStyles[$elementId] = (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey] == 0) ? "none" : "block";
}
?>
<style>
<?php foreach ($displayStyles as $id=> $display) {
    echo "#$id{display:$display;}". PHP_EOL;
}

?>
</style>


<?php
$formsName = [
    "company_form",
    "branch_form",
    "supplier_form",
    "customer_form",
    "sales_person_form",
    "product_form",
    "brand_form",
    "design_form",
    "color_form",
    "batch_form",
    "category_form",
    "hsn_form",
    "tax_form",
    "size_form",
    "mrp_form",
    "item_form",
    "purchase_form",
    "purchase_return_form",
    "sales_form",
    "reports_form",
    "user_info_form",
    "user_management_form"
];
?>

<?php



// // Define the forms and their operations
// $forms = [
//   "purchase_form" => ["create", "reprint", "update", "delete"],
//   "purchase_return_form" => ["create", "reprint", "update", "delete"],
//   "sales_form" => ["create", "reprint", "update", "delete"]
// ];

// $field = ['purchaseEntry','purchaseEdit','purchaseDelete','purchaseReport',
//           'purchaseReturnEntry','purchaseReturnEdit','purchaseReturnDelete','purchaseReturnReport',
//           'salesEntry','salesEdit','salesDelete', 'salesReport'
//   ];
// // Initialize an array to store styles
// $hiddenElements = [];

// // Loop through each form and check session values
// foreach ($forms as $form => $operations) {
//   foreach ($operations as $op) {
//       $elementId = str_replace("_form", "", $form) . ucfirst($op); // Generates IDs like 'purchaseCreate'
//       if (isset($_SESSION[$form . "_" . $op]) && $_SESSION[$form . "_" . $op] == 0) {
//           foreach($field as $idField){
//             $hiddenElements[] = "#$idField";
//           }

//       }
//   }
// }

// // Only output CSS if there are elements to hide
// if (!empty($hiddenElements)) {
//   echo "<style>" . implode(",", $hiddenElements) . " { display: none; } </style>";
// }





// Define the forms and their operations
// $forms = [
//     "purchase_form" => ["create", "reprint", "update", "delete"],
//     "purchase_return_form" => ["create", "reprint", "update", "delete"],
//     "sales_form" => ["create", "reprint", "update", "delete"]
// ];

// Define element IDs for each form and operation
$fieldMapping = [


    "purchase_form_create" => "purchaseEntry",
    "purchase_form_reprint" => "purchaseReport",
    "purchase_form_update" => "purchaseEdit",
    "purchase_form_delete" => "purchaseDelete",

    "purchase_return_form_create" => "purchaseReturnEntry",
    "purchase_return_form_reprint" => "purchaseReturnReport",
    "purchase_return_form_update" => "purchaseReturnEdit",
    "purchase_return_form_delete" => "purchaseReturnDelete",

    "sales_form_create" => "salesEntry",
    "sales_form_reprint" => "salesReport",
    "sales_form_update" => "salesEdit",
    "sales_form_delete" => "salesDelete"
];

// Initialize an array to store styles
$hiddenElements = [];

// Loop through each permission and check session values
foreach ($fieldMapping as $sessionKey => $elementId) {
    if (isset($_SESSION[$sessionKey]) && $_SESSION[$sessionKey] == 0) {
        $hiddenElements[] = "#$elementId";
    }
}

// Only output CSS if there are elements to hide
if (!empty($hiddenElements)) {
    echo "<style>" . implode(", ", $hiddenElements) . " { display: none; } </style>";
}




?>




<!-- #21BCBA -->
<!-- #D69265 -->
<!-- #00B2C6 -->

<body>


    <div id="myOffcanvas" class="offcanvas  show text-dark sidebar" data-bs-backdrop="false"
        style="background-color:#00f2fe;" aria-labelledby="offcanvasDarkLabel">
        <div class="offcanvas-header">
        </div>
        <div class="offcanvas-body" style="margin-top:-30px;">
            <a href="<?php echo BASE_URL; ?>/pages/homePage.php" class="text-dark text-decoration-none"
                style="font-weight:bold;padding-left:15px;"><i class="fa-solid fa-house"></i> Dashboard</a>
            <hr>
            <!-- Master Menu Start -->
            <a class="nav-link sidebar-link" style="font-weight:bold;" data-bs-toggle="collapse" href="#masterMenu"
                role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-pen-nib"></i> <span>Masters</span>
                <span class="right-icon float-end">
                    <i class="fas fa-chevron-down"></i>
                </span>
            </a>

            <div class="collapse" id="masterMenu">

                <ul class="navbar-nav" style="height:160px">
                    <div style="display:flex;width:100%;height:160px;">
                        <div style="width:50%" id="master_items">
                            <li id="company_form"><a href="<?php echo BASE_URL; ?>/pages/companyMaster.php">Company</a>
                            </li>
                            <li id="branch_form"><a href="<?php echo BASE_URL; ?>/pages/branchMaster.php">Branch</a>
                            </li>
                            <li id="supplier_form"><a
                                    href="<?php echo BASE_URL; ?>/pages/supplierMaster.php">Supplier</a>
                            </li>
                            <li id="customer_form"><a
                                    href="<?php echo BASE_URL; ?>/pages/customerMaster.php">Customer</a>
                            </li>
                            <li id="sales_person_form"><a
                                    href="<?php echo BASE_URL; ?>/pages/salesPersonMaster.php">Sales
                                    Person</a></li>
                        </div>
                        <div style="width:50%;overflow-x:auto;overflow-y:auto;max-height:160px">
                            <li id="product_form"><a href="<?php echo BASE_URL; ?>/pages/productMaster.php">Product</a>
                            </li>
                            <li id="brand_form"><a href="<?php echo BASE_URL; ?>/pages/brandMaster.php">Brand</a></li>
                            <li id="design_form"><a href="<?php echo BASE_URL; ?>/pages/designMaster.php">Design</a>
                            </li>
                            <li id="color_form"><a href="<?php echo BASE_URL; ?>/pages/colorMaster.php">Color</a></li>
                            <li id="batch_form"><a href="<?php echo BASE_URL; ?>/pages/batchMaster.php">Batch</a></li>
                            <li id="category_form"><a
                                    href="<?php echo BASE_URL; ?>/pages/categoryMaster.php">Category</a>
                            </li>
                            <li id="hsn_form"><a href="<?php echo BASE_URL; ?>/pages/hsnCodeMaster.php">HSN Code</a>
                            </li>
                            <li id="tax_form"><a href="<?php echo BASE_URL; ?>/pages/taxesMaster.php">Manage Taxes</a>
                            </li>
                            <li id="size_form"><a href="<?php echo BASE_URL; ?>/pages/sizeMaster.php">Size</a></li>
                            <li id="mrp_form"><a href="<?php echo BASE_URL; ?>/pages/mrpMaster.php">Mrp</a></li>
                            <li id="item_form"><a href="<?php echo BASE_URL; ?>/pages/itemMaster.php">Item</a></li>
                        </div>
                    </div>
                </ul>
            </div>
            <!-- Master Menu End -->
            <hr>
            <!-- Transactions Menu Start -->
            <a class="nav-link sidebar-link" style="font-weight:bold;" data-bs-toggle="collapse"
                href="#transactionsMenu" role="button" aria-expanded="false" aria-controls="transactionsMenu">
                <i class="fa-solid fa-receipt"></i>
                Transactions
                <span class="right-icon float-end">
                    <i class="fas fa-chevron-down"></i>
                </span>
            </a>

            <div class="collapse" id="transactionsMenu">
                <ul class="navbar-nav" style="padding-left:15px;" id="trans_menu">

                    <!-- Purchase -->
                    <li>
                        <a data-bs-toggle="collapse" href="#purchaseMenu" role="button" aria-expanded="false"
                            aria-controls="purchaseMenu">
                            Purchase
                        </a>
                        <div class="collapse" id="purchaseMenu" data-bs-parent="#transactionsMenu">
                            <ul class="navbar-nav" style="margin-left:20px;">
                                <li><a href="<?php echo BASE_URL; ?>/pages/purchaseEntry.php"><i
                                            class="fa-solid fa-plus"></i>
                                        Add</a></li>
                                <li><a href="<?php echo BASE_URL; ?>/pages/purchaseEdit.php"><i
                                            class="fa-solid fa-pen-to-square"></i> Edit</a></li>
                                <li><a href="<?php echo BASE_URL; ?>/pages/purchaseDelete.php"><i
                                            class="fa-solid fa-trash"></i>
                                        Delete</a></li>
                                <li><a href="<?php echo BASE_URL; ?>/pages/purchaseReport.php"><i
                                            class="fa-solid fa-receipt"></i>
                                        Report</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Purchase Return -->
                    <li>
                        <a data-bs-toggle="collapse" href="#purchaseReturnMenu" role="button" aria-expanded="false"
                            aria-controls="purchaseReturnMenu">
                            Purchase Return
                        </a>
                        <div class="collapse" id="purchaseReturnMenu" data-bs-parent="#transactionsMenu">
                            <ul class="navbar-nav" style="margin-left:20px;">
                                <li><a href="<?php echo BASE_URL; ?>/pages/purchaseReturnEntry.php"><i
                                            class="fa-solid fa-plus"></i>
                                        Add</a></li>
                                <li><a href="<?php echo BASE_URL; ?>/pages/purchaseReturnEdit.php"><i
                                            class="fa-solid fa-pen-to-square"></i> Edit</a></li>
                                <li><a href="<?php echo BASE_URL; ?>/pages/purchaseReturnDelete.php"><i
                                            class="fa-solid fa-trash"></i> Delete</a></li>
                                <li><a href="<?php echo BASE_URL; ?>/pages/purchaseReturnReport.php"><i
                                            class="fa-solid fa-receipt"></i> Report</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Sales -->
                    <li>
                        <a data-bs-toggle="collapse" href="#salesMenu" role="button" aria-expanded="false"
                            aria-controls="salesMenu">
                            Sales
                        </a>
                        <div class="collapse" id="salesMenu" data-bs-parent="#transactionsMenu">
                            <ul class="navbar-nav" style="margin-left:20px;">
                                <li><a href="<?php echo BASE_URL; ?>/pages/salesEntry.php"><i
                                            class="fa-solid fa-plus"></i> Add</a>
                                </li>
                                <li><a href="<?php echo BASE_URL; ?>/pages/salesEdit.php"><i
                                            class="fa-solid fa-pen-to-square"></i>
                                        Edit</a></li>
                                <li><a href="<?php echo BASE_URL; ?>/pages/salesDelete.php"><i
                                            class="fa-solid fa-trash"></i>
                                        Delete</a></li>
                                <li><a href="<?php echo BASE_URL; ?>/pages/salesReport.php"><i
                                            class="fa-solid fa-receipt"></i>
                                        Report</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Reports -->
                    <li><a href="<?php echo BASE_URL; ?>/pages/stockReports.php">Reports</a></li>
                </ul>
            </div>
            <!-- Transactions Menu End -->
            <hr>

            <!-- User Menu Start -->
            <a class="nav-link sidebar-link" style="font-weight:bold;" data-bs-toggle="collapse" href="#userMenu"
                role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-users"></i>
                Manage User
                <span class="right-icon float-end">
                    <i class="fas fa-chevron-down float-end"></i>
                </span>
            </a>
            <div class="collapse" id="userMenu">
                <ul class="navbar-nav" style="margin-left:20px;">
                    <li id="user_info_form"><a href="<?php echo BASE_URL; ?>/pages/userMaster.php">User Info</a></li>
                    <li id="user_management_form"><a href="<?php echo BASE_URL; ?>/pages/userAccessManagement.php">User
                            Access Mgmt.</a></li>
                </ul>
            </div>

            <hr>
            <!-- User Menu End -->

            <!-- Help Menu Start -->
            <a class="nav-link sidebar-link" style="font-weight:bold;" data-bs-toggle="collapse" href="#helpMenu"
                role="button" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-circle-info"></i>
                Help
                <span class="right-icon float-end">
                    <i class="fas fa-chevron-down float-end"></i>
                </span>
            </a>
            <div class="collapse" id="helpMenu">
                <ul class="navbar-nav" style="margin-left:20px;">
                    <li id="about_form"><a href="<?php echo BASE_URL; ?>/pages/aboutPage.php">About</a></li>
                    <li id="short_manual_form"><a href="<?php echo BASE_URL; ?>/pages/shortManualPage.php">Short
                            Manual</a>
                    </li>

                </ul>
            </div>
            <hr>
            <a class="nav-link sidebar-link" style="font-weight:bold;"
                href="<?php echo BASE_URL; ?>/pages/visitorFeedbackPage.php" role="button" aria-expanded="false"
                aria-controls="collapseExample">
                <i class="fa-solid fa-comment"></i>
                Visitor Feedback
            </a>
            <hr>
            <!-- Help Menu End -->


            <!-- Developed By Gsoft Logo Start-->
            <label for="" class="developed"><span style="font-size:x-small">Developed By</span></label>
            <br>
            <label for="">
                <pre class="developerName">Althaf   Hussain   J</pre>
            </label>

            <!-- Developed By Gsoft Logo End-->


        </div>
    </div>

</body>
<!-- <style>
    /* Basic styling for menu */
    nav {
      background-color: #333;
      padding: 10px;
    }
    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }
    li {
      position: relative; /* Needed for itemMenu positioning */
      /* display: inline-block; */
    }
    

    /* itemMenu styles */
    .itemMenu {
      display: none; /* Hide itemMenu by default */
      position: absolute;
      left: 180px; /* Position itemMenu to the right of the main item */
      top: 0;
      background-color: #444;
      min-width: 150px;
    }
    .itemMenu li a {
      padding: 10px;
    }

    /* Toggle itemMenu visibility */
    .itemMenu.show {
      display: block;
    }
  </style>
  
  <script>
    function toggleitemMenu() {
      const itemMenu = document.querySelector('.itemMenu');
      itemMenu.classList.toggle('show'); // Toggle the 'show' class
    }
  </script> -->

<script>
// document.addEventListener("DOMContentLoaded", () => {
//     // Manually initialize the offcanvas with custom options
//     const offcanvasElement = document.getElementById('myOffcanvas');
//     const bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement, {
//         backdrop: false,
//         keyboard: false,
//     });
// });


document.addEventListener("DOMContentLoaded", function() {
    let activeMenu = "<?php echo isset($activeMenu) ? $activeMenu : ''; ?>";
    if (activeMenu) {
        let activeLink = document.getElementById(activeMenu);
        if (activeLink) {
            activeLink.classList.add("active");

            // Expand parent collapsible if inside one
            let parentCollapse = activeLink.closest(".collapse");
            if (parentCollapse) {
                parentCollapse.classList.add("show");
                let parentToggle = document.querySelector(
                    `[href="#${parentCollapse.id}"], [data-bs-target="#${parentCollapse.id}"]`);
                if (parentToggle) {
                    parentToggle.classList.add("active");
                    parentToggle.setAttribute("aria-expanded", "true");
                }
            }
        }
    }
});
</script>