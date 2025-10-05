<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");
include_once(DIR_URL . "/includes/header.php");
include_once(DIR_URL . "/includes/navbar.php");
include_once(DIR_URL . "/includes/sidebar.php");
?>
<style>
#about {

    margin-left: 280px;
    margin-top: 20px;
}

#content {

    margin-left: 280px;
    font-family: Verdana;

}
</style>

<body>

    <h1 id="about">About RetailXpert</h1>
    <div style="overflow-x:auto;max-height:550px;">


        <pre id=content>
        <span style="font-size:15px;font-weight:bolder;">
        RetailXpert is a web-based inventory management software developed with a desktop-like interface by me, ALTHAF HUSSAIN  J, 
        specifically for retail businesses. Created as part of a real-time MCA final year project (2025), it provides a streamlined platform
        to manage inventory, purchases, sales, and users with ease.    
        </span>
        </pre>
        <div id="content-table" style="max-height:500;overflow-x:auto;overflow-y:auto;
            margin-top:-50px;
            margin-left:320px;width:1110px;height:380px;">

            <div>
                <div style="position:sticky;z-index:1;top:0;background-color: #FF3CAC;">

                    <ul class=" nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item " role="presentation">
                            <button class="nav-link active" id="dec2024-march2025" data-bs-toggle="tab"
                                data-bs-target="#dec2024_march2025" type="button" role="tab"
                                aria-controls="dec2024_march2025" aria-selected="true">Dec 2024 - March
                                2025</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="may2025-june2025" data-bs-toggle="tab"
                                data-bs-target="#may2025_june2025" type="button" role="tab"
                                aria-controls="may2025_june2025" aria-selected="false">May 2025
                                -
                                June
                                2025</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="future-Enhancement" data-bs-toggle="tab"
                                data-bs-target="#futureEnhancement" type="button" role="tab"
                                aria-controls="futureEnhancement" aria-selected="false">Future
                                Enhancement</button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <br>
                    <div class="tab-pane fade show active text-white" id="dec2024_march2025" role="tabpanel"
                        aria-labelledby="dec2024_march2025">
                        <pre style="font-weight:500;font-size:medium;font-family:Verdana, Geneva, Tahoma, sans-serif">
    Core Modules

                
    1. Masters Module
    
        Handles all essential master data:
            •	Company & Branch Management – Stores business and branch details (accessible only by Super Admin/Developer)
            •	Supplier & Customer Management – Maintains vendor and customer records
            •	Salesperson Management – Stores sales employee details
            •	Attributes Master – Manages inventory-related fields like:
                Product, Brand, Design, Color, Batch, Category, HSN, Tax, Size, MRP, and Item.

                
    2. Transaction Module

        Manages all stock movement and customer transactions:
                •	Purchase (Add, Edit, Delete, Report) – Records items received from suppliers
                •	Purchase Return (To be developed) – Handles return of excess/defective stock
                •	Sales & Sales Return (Add, Report (Edit, Delete To be developed))– Records customer sales, generates invoices and
                    Processes returned items and adjusts stock
                •	Stock Management – Updates stock levels in real time
                    
                
    3. User Management Module
    
        Controls user access and permission settings:
            •	User Authentication – Provides secure login for staff
            •	Role-Based Access Control (RBAC) –
            •	Admin can grant access to Manager and User within their own access level
            •	Manager can grant access to User within their own access level
                            
                
    4. Reports Module

        Supports business analysis and decisions:
            •	Stock Reports – Real-time stock information
            •	Purchase & Sales Reports – Tracks incoming and outgoing transactions
            •	Customer & Supplier Reports – Monitors activity of vendors and buyers

     </pre>


                    </div>
                    <div class="tab-pane fade text-white" id="may2025_june2025" role="tabpanel"
                        aria-labelledby="may2025_june2025">
                        <pre style="font-weight:500;font-family:Verdana, Geneva, Tahoma, sans-serif;font-size:medium">
    Under the Transaction module, the pending modules were developed during this period.
            Purchase Return 
                •   Purchase Return (Add, Edit, Delete, Report)  
            Sales & Sales Return 
                •   Sales & Sales Return (Edit, Delete) 
    
    Challenges Faced During SMS Integration Using SMSHorizon API
            <!-- SMS Integration Challenge -->
                •   Used SMSHorizon for SMS integration in a project.
                •   Learned that sending custom SMS in India requires TRAI’s DLT registration.
                •   As a student without a GST number, could not register directly on the DLT platform.
                •   Attempted MSME/Udyam business registration by providing PAN, bank, and address details.
                •   Faced a hurdle: government-authorized proof was mandatory, which I couldn’t obtain.
                •   Gained valuable exposure to real-world regulatory compliance and its effect on software implementation.
           
                        </pre>

                    </div>
                    <div class="tab-pane fade text-white" id="futureEnhancement" role="tabpanel"
                        aria-labelledby="futureEnhancement">
                        <pre style="font-weight:500;font-size:medium;font-family:Verdana, Geneva, Tahoma, sans-serif">

    Future Enhancements

        •   Barcode Generating And Printing
        •   Attribute Wise Reports For - Purchase & Purchase Return, Sales & Sales Return, Stock
        •   GST Reports - GSTR1, GSTR3B And Other Related Reports
        •   Accounting Features (Payment, Receipts, Expenses, etc.).
        <!--•   During navigation, some glitches occur; however, these can be overcome by clicking Dashboard before going to the next menu.-->
                    
                        </pre>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-left:320px;margin-top:5px;">
            <label style="font-weight:bold;font-size:large">Contact</label>
            <br>
            For Any Queries <i class="fa-solid fa-phone" style="margin-left:10px;"></i> <b
                style="margin-left:5px;">9094095610</b>
            <i class="fa-solid fa-envelope" style="margin-left:30px;font-size:large"></i>
            <label for="" style="font-weight:bold;margin-left:5px;">althafhussain2k3@gmail.com</label>

        </div>

        <!--  Only Through Whatsapp Number -->
    </div>





</body>


<style>
/* .nav-tabs .nav-link.active {

    background-color: black;
    color: white;
} */


.nav-tabs .nav-link.active {

    background-color: #2B86C5;
    color: white;
}

#content-table {

    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
}
</style>

<script>
window.onload = function() {

    let home_style = document.getElementById("dec2024-march2025");
    // home_style.style.background = "none";
    home_style.style.color = "white";


    let profile_style = document.getElementById("may2025-june2025");
    // profile_style.style.background = "none";
    profile_style.style.color = "white";


    let contact_style = document.getElementById("future-Enhancement");
    // contact_style.style.background = "none";
    contact_style.style.color = "white";
}

// setColorTab();

// function setColorTab() {

//     document.getElementById("home-tab").addEventListener("focusin", function(event) {

//         event.preventDefault();
//         let home_style = document.getElementById("home-tab");
//         home_style.style.background = "black";


//     })

//     document.getElementById("home-tab").addEventListener("focusout", function(event) {

//         event.preventDefault();
//         let home_style = document.getElementById("home-tab");
//         home_style.style.background = "none";


//     })



//     document.getElementById("profile-tab").addEventListener("focusin", function(event) {

//         event.preventDefault();
//         let profile_style = document.getElementById("profile-tab");
//         profile_style.style.background = "black";


//     })

//     document.getElementById("profile-tab").addEventListener("focusout", function(event) {

//         event.preventDefault();
//         let profile_style = document.getElementById("profile-tab");
//         profile_style.style.background = "none";


//     })


//     document.getElementById("contact-tab").addEventListener("focusin", function(event) {

//         event.preventDefault();
//         let contact_style = document.getElementById("contact-tab");
//         contact_style.style.background = "black";


//     })

//     document.getElementById("contact-tab").addEventListener("focusout", function(event) {

//         event.preventDefault();
//         let contact_style = document.getElementById("contact-tab");
//         contact_style.style.background = "none";


//     })
// }
</script>

<?php
include_once(DIR_URL . "/includes/footer.php");
?>