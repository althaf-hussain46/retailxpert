<?php 

include_once("config/config.php");
include_once(DIR_URL."/db/dbConnection.php");

$updateQueryLoginStatus = "update user_master1 set login_status = 0 where user_name = '$_SESSION[user_name]' and user_pass = '$_SESSION[user_password]'
                          and branch_id = '$_SESSION[user_branch_id]'";
$resultQueryLoginStatus = $con->query($updateQueryLoginStatus);
// session_start();


//visitor details start
unset($_SESSION['user_name']);    
unset($_SESSION['user_id']);
unset($_SESSION['user_password']);
unset($_SESSION['user_branch_id']);
//visitor details end


unset($_SESSION['product_name']); 
unset($_SESSION['is_logged_in']);
unset($_SESSION['company_id']);        
unset($_SESSION['company_name']);      
unset($_SESSION['company_short_name']);
unset($_SESSION['company_address1']);  
unset($_SESSION['company_address2']);  
unset($_SESSION['company_address3']);  
unset($_SESSION['company_locality']);  
unset($_SESSION['company_city']);      
unset($_SESSION['company_pincode']);   
unset($_SESSION['company_state']);     
unset($_SESSION['company_landline']);  
unset($_SESSION['company_mobile']);    
unset($_SESSION['company_email']);     
unset($_SESSION['company_gst_no']); 
unset($_SESSION['user_location']);
unset($_SESSION['from_date']);
unset($_SESSION['to_date']);
unset($_SESSION['financial_year']);
unset($_SESSION['supplier_state']);
unset($_SESSION['notification']);
unset($_SESSION['grn_number']);
unset($_SESSION['resultSearchPurchaseSummaryItem']);
unset($_SESSION['resultSearchPurchaseItem']);
unset($_SESSION['sno']);
unset($_SESSION['snos']);
unset($_SESSION['sr_no']);
unset($_SESSION['resultSearchSRI']);
unset($_SESSION['printPurchaseReturn']);
unset($_SESSION['pr_number']);
unset($_SESSION['counter_name']);
// purchase report attributes 
unset($_SESSION['supplierName']);
unset($_SESSION['supplierId']);
unset($_SESSION['fromDate']);
unset($_SESSION['toDate']);
unset($_SESSION['grnNumber']);
unset($_SESSION['invoiceNumber']);
unset($_SESSION['dcNumber']);
unset($_SESSION['optionSelected']);


//purchase return attributes

unset($_SESSION['pr_date']);

unset($_SESSION['table_name']);
unset($_SESSION['field_name']);
unset($_SESSION['searching_name']);
unset($_SESSION['report_title']);
unset($_SESSION['header_title']);

//branch details

unset($_SESSION['branch_name']);
unset($_SESSION['branch_address1']);
unset($_SESSION['branch_address2']);
unset($_SESSION['branch_address3']);
unset($_SESSION['branch_locality']);
unset($_SESSION['branch_city']);    
unset($_SESSION['branch_pinCode']); 
unset($_SESSION['branch_state']);   
unset($_SESSION['branch_landline']);
unset($_SESSION['branch_mobile']);  
unset($_SESSION['branch_email']);   
unset($_SESSION['branch_gst_no']);  

//counter
unset($_SESSION['counter_name']);


//sales bill print
unset($_SESSION['printSales']);


//stock report

unset($_SESSION['productName']);
unset($_SESSION['brandName']);  
unset($_SESSION['designName']); 
unset($_SESSION['colorName']);  
unset($_SESSION['batchName']);  
unset($_SESSION['sizeName']);   



// item master

unset($_SESSION['success']);
unset($_SESSION['failure']);
unset($_SESSION['greeting']);

// user forms permission

unset($_SESSION['company_form_access']); 
unset($_SESSION['branch_form_access']);  
unset($_SESSION['supplier_form_access']);
unset($_SESSION['customer_form_access']);
unset($_SESSION['sales_person_form_access']); 
unset($_SESSION['product_form_access']); 
unset($_SESSION['brand_form_access']); 
unset($_SESSION['design_form_access']); 
unset($_SESSION['color_form_access']); 
unset($_SESSION['batch_form_access']); 
unset($_SESSION['hsn_form_access']); 
unset($_SESSION['category_form_access']); 
unset($_SESSION['tax_form_access']); 
unset($_SESSION['size_form_access']); 
unset($_SESSION['mrp_form_access']); 
unset($_SESSION['item_form_access']); 
unset($_SESSION['purchase_form_access']); 
unset($_SESSION['purchase_return_form_access']); 
unset($_SESSION['sales_form_access']); 
unset($_SESSION['reports_form_access']); 
unset($_SESSION['user_info_form_access']); 
unset($_SESSION['user_management_form_access']); 

// user CRUD permission

unset($_SESSION['create_op_access']);
unset($_SESSION['reprint_op_access']);
unset($_SESSION['update_op_access']);
unset($_SESSION['delete_op_access']);

unset($_SESSION['company_form']);
unset($_SESSION['branch_form']);
unset($_SESSION['supplier_form']);
unset($_SESSION['customer_form']);
unset($_SESSION['sales_person_form']);
unset($_SESSION['product_form']);
unset($_SESSION['brand_form']);
unset($_SESSION['design_form']);
unset($_SESSION['color_form']);
unset($_SESSION['batch_form']);
unset($_SESSION['hsn_form']);
unset($_SESSION['category_form']);
unset($_SESSION['tax_form']);
unset($_SESSION['size_form']);
unset($_SESSION['mrp_form']);
unset($_SESSION['item_form']);
unset($_SESSION['purchase_form']);
unset($_SESSION['purchase_return_form']);
unset($_SESSION['sales_form_']);
unset($_SESSION['reports_form']);
unset($_SESSION['user_info_form']);
unset($_SESSION['user_management_form']);


unset($_SESSION['company_form_create']);
unset($_SESSION['company_form_reprint']);
unset($_SESSION['company_form_update']);
unset($_SESSION['company_form_delete']);


unset($_SESSION['branch_form_create']);
unset($_SESSION['branch_form_reprint']);
unset($_SESSION['branch_form_update']);
unset($_SESSION['branch_form_delete']);

unset($_SESSION['supplier_form_create']);
unset($_SESSION['supplier_form_reprint']);
unset($_SESSION['supplier_form_update']);
unset($_SESSION['supplier_form_delete']);

unset($_SESSION['customer_form_create']);
unset($_SESSION['customer_form_reprint']);
unset($_SESSION['customer_form_update']);
unset($_SESSION['customer_form_delete']);

unset($_SESSION['sales_person_form_create']);
unset($_SESSION['sales_person_form_reprint']);
unset($_SESSION['sales_person_form_update']);
unset($_SESSION['sales_person_form_delete']);

unset($_SESSION['product_form_create']);
unset($_SESSION['product_form_reprint']);
unset($_SESSION['product_form_update']);
unset($_SESSION['product_form_delete']);

unset($_SESSION['brand_form_create']);
unset($_SESSION['brand_form_reprint']);
unset($_SESSION['brand_form_update']);
unset($_SESSION['brand_form_delete']);

unset($_SESSION['design_form_create']);
unset($_SESSION['design_form_reprint']);
unset($_SESSION['design_form_update']);
unset($_SESSION['design_form_delete']);

unset($_SESSION['color_form_create']);
unset($_SESSION['color_form_reprint']);
unset($_SESSION['color_form_update']);
unset($_SESSION['color_form_delete']);

unset($_SESSION['batch_form_create']);
unset($_SESSION['batch_form_reprint']);
unset($_SESSION['batch_form_update']);
unset($_SESSION['batch_form_delete']);

unset($_SESSION['hsn_form_create']);
unset($_SESSION['hsn_form_reprint']);
unset($_SESSION['hsn_form_update']);
unset($_SESSION['hsn_form_delete']);

unset($_SESSION['category_form_create']);
unset($_SESSION['category_form_reprint']);
unset($_SESSION['category_form_update']);
unset($_SESSION['category_form_delete']);

unset($_SESSION['size_form_create']);
unset($_SESSION['size_form_reprint']);
unset($_SESSION['size_form_update']);
unset($_SESSION['size_form_delete']);

unset($_SESSION['tax_form_create']);
unset($_SESSION['tax_form_reprint']);
unset($_SESSION['tax_form_update']);
unset($_SESSION['tax_form_delete']);

unset($_SESSION['mrp_form_create']);
unset($_SESSION['mrp_form_reprint']);
unset($_SESSION['mrp_form_update']);
unset($_SESSION['mrp_form_delete']);

unset($_SESSION['item_form_create']);
unset($_SESSION['item_form_reprint']);
unset($_SESSION['item_form_update']);
unset($_SESSION['item_form_delete']);

unset($_SESSION['purchase_form_create']);
unset($_SESSION['purchase_form_reprint']);
unset($_SESSION['purchase_form_update']);
unset($_SESSION['purchase_form_delete']);


unset($_SESSION['purchase_return_form_create']);
unset($_SESSION['purchase_return_form_reprint']);
unset($_SESSION['purchase_return_form_update']);
unset($_SESSION['purchase_return_form_delete']);


unset($_SESSION['sales_form_create']);
unset($_SESSION['sales_form_reprint']);
unset($_SESSION['sales_form_update']);
unset($_SESSION['sales_form_delete']);

unset($_SESSION['user_info_form_create']);
unset($_SESSION['user_info_form_reprint']);
unset($_SESSION['user_info_form_update']);
unset($_SESSION['user_info_form_delete']);


unset($_SESSION['user_management_form_create']);
unset($_SESSION['user_management_form_reprint']);
unset($_SESSION['user_management_form_update']);
unset($_SESSION['user_management_form_delete']);





header("Location: index.php");

?>