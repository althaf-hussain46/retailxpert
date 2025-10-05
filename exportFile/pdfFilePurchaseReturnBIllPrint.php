<?php
// Ensure no output before this script
ob_start(); // Start output buffering
include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");
    

$searching_name1 = $_SESSION['searching_name'] ?? ''; // Get field name from session or set as empty
// echo "export  = ".$searching_name1;

$report_title1 = "Debit Note";
$header_title1 = "";
$purchaseReturnNumber = $_SESSION['pr_number'];
$branchId = $_SESSION['user_branch_id'];

$querySearch = "SELECT  prs.*,s.*
                FROM purchase_return_summary as prs
                JOIN  suppliers as s on prs.supplier_id = s.id
                WHERE prs.pr_grn_number = '$purchaseReturnNumber' && prs.branch_id = '$branchId'";
$searchResult = $con->query($querySearch);

$purchase_return_summary = $searchResult->fetch_assoc();

$supplierAddress1 = $purchase_return_summary['address1']." , ".$purchase_return_summary['address2'];
$supplierAddress2 = $purchase_return_summary['address3']." , ".$purchase_return_summary['locality'];
$supplierMobile = $purchase_return_summary['mobile'];

// Include FPDF library

require_once("../fpdf/fpdf.php");

// Create instance of FPDF
$pdf = new FPDF();
$pdf->AliasNbPages(); // Enable total page number
$pdf->AddPage(); // Add a page

// Company Header Section
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 51, 102); // Dark blue
$pdf->Cell(190, -5, $_SESSION['branch_name'], 0, 1, 'C'); // Company title
$pdf->SetFont('Arial', '', 12);
$pdf->Ln(6); // Line break
$pdf->SetTextColor(50); // Gray text
$pdf->Cell(190, 5, $_SESSION['branch_address1']    .','.$_SESSION['branch_address2'], 0, 1, 'C');
$pdf->Cell(190, 5, $_SESSION['branch_address3']    .','.$_SESSION['branch_locality'], 0, 1, 'C');
$pdf->Cell(190, 5, $_SESSION['branch_city']        .','.$_SESSION['branch_pinCode'], 0, 1, 'C');
$pdf->Cell(190, 5,  $_SESSION['company_landline'].' | '.$_SESSION['branch_mobile'].' | GSTIN : '.$_SESSION['branch_gst_no'], 0, 1, 'C');
$pdf->Ln(0); // Line break

// Report Title Section
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0, 51, 102); // Dark blue
$pdf->Cell(190, 10, $report_title1, 0, 1, 'C');
$pdf->Ln(0);

//Bill Details
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(0,0,0); // Dark blue

// $pdf->Cell(100,5,'Customer Name  : '.$purchase_return_summary['customer_name'],0,0,'L');
$pdf->Cell(30,5,'Supplier Name  : ',0,0,'L');
$pdf->SetFont('','B');
$pdf->Cell(70,5,$purchase_return_summary['supplier_name'],0,0,'L');
$pdf->SetFont('','');


$pdf->Cell(56,5,str_repeat(' ',30).'PRN Number'.str_repeat(' ',5).' : ',0,0);
$pdf->SetFont('','B');
$pdf->Cell(10,5,$purchase_return_summary['pr_grn_number'],0,1);
$pdf->SetFont('','');

$pdf->Cell(100,5,'Address               : '.$supplierAddress1,0,0,'L');
$pdf->Cell(56,5,str_repeat(' ',30).'PRN Date'.str_repeat(' ',10).' : ',0,0);
$pdf->SetFont('','B');
$pdf->Cell(10,5,$purchase_return_summary['pr_grn_date'],0,1);
$pdf->SetFont('','');

$pdf->Cell(100,5,  str_repeat(' ',30).$supplierAddress2,0,0,'L');
$pdf->Cell(56,5,str_repeat(' ',30).'PRN Time'.str_repeat(' ',10).' : ',0,0);
$pdf->SetFont('','B');
$pdf->Cell(10,5,$purchase_return_summary['pr_grn_date'],0,1);
$pdf->SetFont('','');


$pdf->Cell(100,5,  str_repeat(' ',30).$purchase_return_summary['mobile'],0,0,'L');
$pdf->Cell(56,5,str_repeat(' ',30).'Counter Name'.str_repeat(' ',1).' : ',0,0);
$pdf->SetFont('','B');
$pdf->Cell(10,5,$purchase_return_summary['counter_name'],0,1);
$pdf->SetFont('','');


$pdf->Ln(0);

// Subtitle with Date
$pdf->SetFont('Arial', '', 7);
$pdf->SetTextColor(50); // Gray text
$pdf->Cell(190, 10, 'Generated on: ' . date('d-m-Y'), 0, 1, 'C');
$pdf->Ln(0); // Line break

// Table Header
$pdf->SetFont('Arial', 'B', 6);
$pdf->SetFillColor(200, 220, 255); // Light blue
$pdf->SetTextColor(0); // Black
$pdf->SetX(6);
$pdf->Cell(7, 10, 'S.No.', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Design', 1, 0, 'C', true);
$pdf->Cell(74, 10, 'Description', 1, 0, 'C', true);
$pdf->Cell(12, 10, 'HSN', 1, 0, 'C', true);
$pdf->Cell(7, 10, 'Tax', 1, 0, 'C', true);
$pdf->Cell(13, 10, 'Selling', 1, 0, 'C', true);
$pdf->Cell(6, 10, 'SPC', 1, 0, 'C', true);
$pdf->Cell(8, 10, 'Qty', 1, 0, 'C', true);
$pdf->Cell(10, 10, 'Land Cost', 1, 0, 'C', true);
$pdf->Cell(12, 10, 'Margin', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Amount', 1, 1, 'C', true);
// Reset text color for rows
$pdf->SetFont('Arial', '', 6);
$pdf->SetTextColor(0);

// fetching  sales item starts

$queryItemSearch = "SELECT pri.*,i.*
                    FROM purchase_return_item as pri
                    JOIN items as i on pri.pr_item_id = i.id
                    WHERE pri.pr_grn_number = '$purchaseReturnNumber' && pri.branch_id = '$branchId'";
                    
$resultItemSearch = $con->query($queryItemSearch);
$discountAmount = 0;
if ($resultItemSearch && $resultItemSearch->num_rows > 0) {
    $i=1;
    while ($data = $resultItemSearch->fetch_assoc()) {
        // Add data rows
        $userName = "select user_name from user_master1 where id='$data[user_id]'";
        $resultUserName  = $con->query($userName)->fetch_assoc();
        
        $description = $data['product_name']."/".$data['brand_name']."/".$data['color_name']."/".
        $data['batch_name']."/".$data['mrp']."/".$data['size_name'];
        $pdf->SetX(6);
        $pdf->Cell(7,  10, $i++, 1, 0, 'C');
        $pdf->Cell(30, 10, $data['design_name'], 1, 0, 'L');
        $pdf->Cell(74, 10, $description, 1, 0, 'L');
        $pdf->Cell(12, 10, $data['hsn_code'], 1, 0, 'C');
        $pdf->Cell(7, 10, $data['tax_code'], 1, 0, 'C');
        $pdf->Cell(13, 10, $data['selling_price'], 1, 0, 'R');
        $pdf->Cell(6, 10, "", 1, 0, 'R');
        $pdf->Cell(8,  10, $data['pr_item_qty'], 1, 0, 'C');
        $pdf->Cell(10,  10, $data['pr_land_cost'], 1, 0, 'C');
        $pdf->Cell(12,  10, $data['pr_margin'], 1, 0, 'C');
        $pdf->Cell(20, 10, number_format((float)($data['pr_item_amount']), 2, '.', ''), 1, 1, 'R');
        // $discountAmount = $discountAmount + $data['s_discount_amount'];
        }
        
        // $discountAmount = $discountAmount+$purchase_return_summary['s_deduction'];
        
    // fetching sales item ends
    
    // sales summary attributes displaying start
    $pdf->SetX(136);
    $pdf->SetFont('','B',10);
    $pdf->Cell(37,6,'Total',1,0,'C');
    $pdf->Cell(9,6,$purchase_return_summary['pr_total_qty'],1,0,'C');
    $pdf->Cell(23,6,number_format((float)($purchase_return_summary['pr_total_amount']),2),1,1,'R');
    
    $afterDiscountAmount = $purchase_return_summary['pr_total_amount'] - $purchase_return_summary['pr_deduction'];
    $pdf->SetX(136);
    $pdf->Cell(37,6,'Discount (-)',1,0,'C');
    $pdf->Cell(32,6,number_format((float)($purchase_return_summary['pr_deduction']),2),1,1,'R');
    $pdf->SetX(136);
    $pdf->Cell(37,6,'After Discount',1,0,'C');
    $pdf->Cell(32,6,number_format((float)($afterDiscountAmount),2),1,1,'R');
    
    $pdf->SetX(136);
    $pdf->Cell(37,6,'Other Add On (+)',1,0,'C');
    $pdf->Cell(32,6,number_format((float)($purchase_return_summary['pr_addon']),2),1,1,'R');
    
    // if($purchase_return_summary['sales_return_amount']>0){
    //     $pdf->SetX(136);
    //     $pdf->Cell(37,6,'After Add On',1,0,'C');
    //     $pdf->Cell(32,6,number_format((float)($afterDiscountAmount+$purchase_return_summary['s_addon']),2),1,1,'R');
    //     $pdf->SetX(136);
    //     $pdf->SetTextColor(255,0,0);
    //     $pdf->Cell(37,6,'Sales Return (-)',1,0,'C');
    //     $pdf->SetTextColor(0,0,0);
    //     $pdf->Cell(32,6,number_format((float)($purchase_return_summary['sales_return_amount']),2),1,1,'R');
        
    // }
    
    
    $pdf->SetX(136);
    $pdf->SetFont('','B',12);
    $pdf->SetTextColor(0,150,10);
    $pdf->Cell(37,6,'Net Bill Amount',1,0,'C');
    $pdf->Cell(32,6,number_format((float)($purchase_return_summary['pr_net_amount']),2),1,1,'R');
    $pdf->SetFont('','',12);
    $pdf->SetTextColor(0,0,0);
    
    
    
        $pdf->SetFont('Arial', 'I', 10);
        
        $pdf->SetTextColor(128); // Gray text
        $pdf->SetY(240);
        $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo() . '/{nb}', 0, 1, 'R');
        $pdf->Cell(0, 0, 'Debit Notice', 0, 1, 'C');
        
        
        // $pdf->Cell(0, 10, 'Generated by '.$_SESSION['user_name'].' - '.$_SESSION['branch_name'], 0, 0, 'C');    
} else {
    // If no data is found
    $pdf->Cell(190, 10, 'No ' .'record'. ' found matching the search criteria.', 1, 1, 'C');
}





// Output the PDF
$pdf->Output();
ob_end_flush(); // End output buffering
exit;




// Set Footer font


// // Footer Section
// $pdf->SetY(10); // Position footer 3 cm from bottom
// $pdf->SetFont('Arial', 'I', 10);
// $pdf->SetTextColor(128); // Gray
// $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo() . '/{nb}', 0, 1, 'C');
// $pdf->Cell(0, 10, 'Generated by '.$_SESSION['user_name'].' - '.$_SESSION['location_name'], 0, 0, 'C');