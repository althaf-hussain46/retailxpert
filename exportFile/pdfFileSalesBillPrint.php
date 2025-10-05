<?php
// Ensure no output before this script
ob_start(); // Start output buffering
include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");


$searching_name1 = $_SESSION['searching_name'] ?? ''; // Get field name from session or set as empty
// echo "export  = ".$searching_name1;

$report_title1 = "Bill";
$header_title1 = "";
$salesNumber = $_SESSION['sales_number'];
$branchId = $_SESSION['user_branch_id'];

$querySearch = "SELECT  ss.*,c.*
                FROM sales_summary as ss
                JOIN  customers as c on ss.customer_id = c.id
                WHERE ss.sales_number = '$salesNumber' && ss.branch_id = '$branchId'";
$searchResult = $con->query($querySearch);

$sales_summary = $searchResult->fetch_assoc();

$customerAddress1 = $sales_summary['address1'] . " , " . $sales_summary['address2'];
$customerAddress2 = $sales_summary['address3'] . " , " . $sales_summary['locality'];
$customerMobile = $sales_summary['mobile'];

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
$pdf->Cell(190, 5, $_SESSION['branch_address1']    . ',' . $_SESSION['branch_address2'], 0, 1, 'C');
$pdf->Cell(190, 5, $_SESSION['branch_address3']    . ',' . $_SESSION['branch_locality'], 0, 1, 'C');
$pdf->Cell(190, 5, $_SESSION['branch_city']        . ',' . $_SESSION['branch_pinCode'], 0, 1, 'C');
$pdf->Cell(190, 5,  $_SESSION['branch_landline'] . ' | ' . $_SESSION['branch_mobile'] . ' | GSTIN : ' . $_SESSION['branch_gst_no'], 0, 1, 'C');
$pdf->Ln(0); // Line break

// Report Title Section
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(0, 51, 102); // Dark blue
$pdf->Cell(190, 10, $report_title1, 0, 1, 'C');
$pdf->Ln(0);

//Bill Details
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(0, 0, 0); // Dark blue

// $pdf->Cell(100,5,'Customer Name  : '.$sales_summary['customer_name'],0,0,'L');
$pdf->Cell(30, 5, 'Customer Name  : ', 0, 0, 'L');
$pdf->SetFont('', 'B');
$pdf->Cell(70, 5, $sales_summary['customer_name'], 0, 0, 'L');
$pdf->SetFont('', '');


$pdf->Cell(56, 5, str_repeat(' ', 30) . 'Bill Number' . str_repeat(' ', 5) . ' : ', 0, 0);
$pdf->SetFont('', 'B');
$pdf->Cell(10, 5, $sales_summary['sales_number'], 0, 1);
$pdf->SetFont('', '');

$pdf->Cell(100, 5, 'Address               : ' . $customerAddress1, 0, 0, 'L');
$pdf->Cell(56, 5, str_repeat(' ', 30) . 'Bill Date' . str_repeat(' ', 10) . ' : ', 0, 0);
$pdf->SetFont('', 'B');
$pdf->Cell(10, 5, date("d-m-Y",strtotime($sales_summary['sales_date'])), 0, 1);
$pdf->SetFont('', '');

$pdf->Cell(100, 5,  str_repeat(' ', 30) . $customerAddress2, 0, 0, 'L');
$pdf->Cell(56, 5, str_repeat(' ', 30) . 'Bill Time' . str_repeat(' ', 10) . ' : ', 0, 0);
$pdf->SetFont('', 'B');
$pdf->Cell(10, 5, date("h:i:s A",strtotime($sales_summary['sales_date'])), 0, 1);
$pdf->SetFont('', '');


$pdf->Cell(100, 5,  str_repeat(' ', 30) . $sales_summary['mobile'], 0, 0, 'L');
$pdf->Cell(56, 5, str_repeat(' ', 30) . 'Counter Name' . str_repeat(' ', 1) . ' : ', 0, 0);
$pdf->SetFont('', 'B');
$pdf->Cell(10, 5, $sales_summary['counter_name'], 0, 1);
$pdf->SetFont('', '');


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
$pdf->Cell(10, 10, 'Disc(%)', 1, 0, 'C', true);
$pdf->Cell(12, 10, 'Disc Amt', 1, 0, 'C', true);
$pdf->Cell(20, 10, 'Amount', 1, 1, 'C', true);
// Reset text color for rows
$pdf->SetFont('Arial', '', 6);
$pdf->SetTextColor(0);

// fetching  sales item starts

$queryItemSearch = "SELECT si.*,i.*
                    FROM sales_item as si
                    JOIN items as i on si.s_item_id = i.id
                    WHERE si.sales_number = '$salesNumber' && si.branch_id = '$branchId'";

$resultItemSearch = $con->query($queryItemSearch);
$discountAmount = 0;
if ($resultItemSearch && $resultItemSearch->num_rows > 0) {
    $i = 1;
    while ($data = $resultItemSearch->fetch_assoc()) {
        // Add data rows
        $userName = "select user_name from user_master1 where id='$data[user_id]'";
        $resultUserName  = $con->query($userName)->fetch_assoc();

        $description = $data['product_name'] . "/" . $data['brand_name'] . "/" . $data['color_name'] . "/" .
            $data['batch_name'] . "/" . $data['mrp'] . "/" . $data['size_name'];
        $pdf->SetX(6);
        $pdf->Cell(7,  10, $i++, 1, 0, 'C');
        $pdf->Cell(30, 10, $data['design_name'], 1, 0, 'L');
        $pdf->Cell(74, 10, $description, 1, 0, 'L');
        $pdf->Cell(12, 10, $data['hsn_code'], 1, 0, 'C');
        $pdf->Cell(7, 10, $data['tax_code'], 1, 0, 'C');
        $pdf->Cell(13, 10, $data['selling_price'], 1, 0, 'R');
        $pdf->Cell(6, 10, $data['s_salesperson_code'], 1, 0, 'R');
        $pdf->Cell(8,  10, $data['s_item_qty'], 1, 0, 'C');
        $pdf->Cell(10,  10, $data['s_discount_percentage'], 1, 0, 'C');
        $pdf->Cell(12,  10, $data['s_discount_amount'], 1, 0, 'C');
        $pdf->Cell(20, 10, number_format((float)($data['s_item_amount']), 2, '.', ''), 1, 1, 'R');
        $discountAmount = $discountAmount + $data['s_discount_amount'];
    }

    // $discountAmount = $discountAmount+$sales_summary['s_deduction'];

    // fetching sales item ends

    // sales summary attributes displaying start
    $pdf->SetX(136);
    $pdf->SetFont('', 'B', 10);
    $pdf->Cell(37, 6, 'Total', 1, 0, 'C');
    $pdf->Cell(9, 6, $sales_summary['s_qty'], 1, 0, 'C');
    $pdf->Cell(23, 6, number_format((float)($sales_summary['s_amount']), 2), 1, 1, 'R');

    $afterDiscountAmount = $sales_summary['s_amount'] - $sales_summary['s_deduction'];
    $pdf->SetX(136);
    $pdf->Cell(37, 6, 'Discount (-)', 1, 0, 'C');
    $pdf->Cell(32, 6, number_format((float)($sales_summary['s_deduction']), 2), 1, 1, 'R');
    $pdf->SetX(136);
    $pdf->Cell(37, 6, 'After Discount', 1, 0, 'C');
    $pdf->Cell(32, 6, number_format((float)($afterDiscountAmount), 2), 1, 1, 'R');

    $pdf->SetX(136);
    $pdf->Cell(37, 6, 'Other Add On (+)', 1, 0, 'C');
    $pdf->Cell(32, 6, number_format((float)($sales_summary['s_addon']), 2), 1, 1, 'R');

    if ($sales_summary['sales_return_amount'] > 0) {
        $pdf->SetX(136);
        $pdf->Cell(37, 6, 'After Add On', 1, 0, 'C');
        $pdf->Cell(32, 6, number_format((float)($afterDiscountAmount + $sales_summary['s_addon']), 2), 1, 1, 'R');
        $pdf->SetX(136);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(37, 6, 'Sales Return (-)', 1, 0, 'C');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(32, 6, number_format((float)($sales_summary['sales_return_amount']), 2), 1, 1, 'R');
    }


    $pdf->SetX(136);
    $pdf->SetFont('', 'B', 12);
    $pdf->SetTextColor(0, 150, 10);
    $pdf->Cell(37, 6, 'Net Bill Amount', 1, 0, 'C');
    $pdf->Cell(32, 6, number_format((float)($sales_summary['s_net_amount']), 2), 1, 1, 'R');
    $pdf->SetFont('', '', 12);
    $pdf->SetTextColor(0, 0, 0);


    // Sales Return Print Details Starts


    $querySearchSalesReturnSummary = "select*from sales_return_summary where sr_number = '$salesNumber'
                                  and branch_id = '$branchId'";

    $resultSalesReturnSummary = $con->query($querySearchSalesReturnSummary)->fetch_assoc();



    if ($sales_summary['sales_return_amount'] > 0) {

        // Return Item Details
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0); // Dark blue
        $pdf->Cell(190, 10, 'Returned Item Details', 0, 1, 'L');
        $pdf->Ln(0);

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
        $pdf->Cell(10, 10, 'Disc(%)', 1, 0, 'C', true);
        $pdf->Cell(12, 10, 'Disc Amt', 1, 0, 'C', true);
        $pdf->Cell(20, 10, 'Amount', 1, 1, 'C', true);
        // Reset text color for rows
        $pdf->SetFont('Arial', '', 6);
        $pdf->SetTextColor(0);



        // fetching  sales return item starts

        $queryItemSearch = "SELECT sri.*,i.*
                    FROM sales_return_item as sri
                    JOIN items as i on sri.sr_item_id = i.id
                    WHERE sri.sr_number = '$salesNumber' && sri.branch_id = '$branchId'";

        $resultItemSearch = $con->query($queryItemSearch);
        $discountAmount = 0;
        if ($resultItemSearch && $resultItemSearch->num_rows > 0) {
            $i = 1;
            while ($data = $resultItemSearch->fetch_assoc()) {
                // Add data rows
                $userName = "select user_name from user_master1 where id='$data[user_id]'";
                $resultUserName  = $con->query($userName)->fetch_assoc();

                $description = $data['product_name'] . "/" . $data['brand_name'] . "/" . $data['color_name'] . "/" .
                    $data['batch_name'] . "/" . $data['mrp'] . "/" . $data['size_name'];
                $pdf->SetX(6);
                $pdf->Cell(7,  10, $i++, 1, 0, 'C');
                $pdf->Cell(30, 10, $data['design_name'], 1, 0, 'L');
                $pdf->Cell(74, 10, $description, 1, 0, 'L');
                $pdf->Cell(12, 10, $data['hsn_code'], 1, 0, 'C');
                $pdf->Cell(7, 10, $data['tax_code'], 1, 0, 'C');
                $pdf->Cell(13, 10, $data['selling_price'], 1, 0, 'R');
                $pdf->Cell(6, 10, $data['sr_salesperson_code'], 1, 0, 'R');
                $pdf->Cell(8,  10, $data['sr_item_qty'], 1, 0, 'C');
                $pdf->Cell(10,  10, $data['sr_discount_percentage'], 1, 0, 'C');
                $pdf->Cell(12,  10, $data['sr_discount_amount'], 1, 0, 'C');
                $pdf->Cell(20, 10, number_format((float)($data['sr_item_amount']), 2, '.', ''), 1, 1, 'R');
                $discountAmount = $discountAmount + $data['sr_discount_amount'];
            }





            // fetching sales return item ends

            // sales return summary attributes displaying start
            $pdf->SetX(136);
            $pdf->SetFont('', 'B', 10);
            $pdf->Cell(37, 6, 'Total', 1, 0, 'C');
            $pdf->Cell(8, 6, $resultSalesReturnSummary['sr_qty'], 1, 0, 'C');
            $pdf->Cell(24, 6, number_format((float)($resultSalesReturnSummary['sr_amount']), 2), 1, 1, 'R');

            $afterDiscountAmount = $resultSalesReturnSummary['sr_amount'] - $resultSalesReturnSummary['sr_deduction'];
            $pdf->SetX(136);
            $pdf->Cell(37, 6, 'Discount (-)', 1, 0, 'C');
            $pdf->Cell(32, 6, number_format((float)($resultSalesReturnSummary['sr_deduction']), 2), 1, 1, 'R');
            $pdf->SetX(136);
            $pdf->Cell(37, 6, 'After Discount', 1, 0, 'C');
            $pdf->Cell(32, 6, number_format((float)($afterDiscountAmount), 2), 1, 1, 'R');
            $pdf->SetX(136);
            $pdf->Cell(37, 6, 'Other Add On (+)', 1, 0, 'C');
            $pdf->Cell(32, 6, number_format((float)($resultSalesReturnSummary['sr_addon']), 2), 1, 1, 'R');
            $pdf->SetX(136);
            $pdf->SetFont('', 'B', 12);
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Cell(37, 6, 'Net Sales Return', 1, 0, 'C');
            $pdf->Cell(32, 6, number_format((float)($resultSalesReturnSummary['sr_net_amount']), 2), 1, 1, 'R');
            $pdf->SetFont('', '', 12);
            $pdf->SetTextColor(0, 0, 0);
        }
    }
    // sales return summary attributes displaying end
    $netTaxable    = 0;
    $netIgstAmount = 0;
    $netCgstAmount = 0;
    $netSgstAmount = 0;

    // Tax Summary Starts
    if ($sales_summary['sales_return_amount'] > 0) {

        $netTaxable    =    $sales_summary['s_taxable_amount'] - $resultSalesReturnSummary['sr_taxable_amount'];
        $netIgstAmount = $sales_summary['s_igst_amount']    - $resultSalesReturnSummary['sr_igst_amount'];
        $netCgstAmount = $sales_summary['s_cgst_amount']    - $resultSalesReturnSummary['sr_cgst_amount'];
        $netSgstAmount = $sales_summary['s_sgst_amount']    - $resultSalesReturnSummary['sr_sgst_amount'];
    } else {
        $netTaxable =    $sales_summary['s_taxable_amount'];
        $netIgstAmount = $sales_summary['s_igst_amount'];
        $netCgstAmount = $sales_summary['s_cgst_amount'];
        $netSgstAmount = $sales_summary['s_sgst_amount'];
    }



    $pdf->SetFont('Arial', '', 14);

    $pdf->Cell(10, 5, 'Tax Summary');
    $pdf->Ln(6);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(30, 8, 'Taxable', 1, '', 'C');
    $pdf->cell(30, 8, 'IGST', '1', '', 'C');
    $pdf->Cell(30, 8, 'CGST', '1', '', 'C');
    $pdf->Cell(30, 8, 'SGST', '1', '1', 'C');
    $pdf->Cell(30, 8, $netTaxable, '1', '', 'C');
    $pdf->Cell(30, 8, $netIgstAmount, '1', '', 'C');
    $pdf->Cell(30, 8, $netCgstAmount, '1', '', 'C');
    $pdf->Cell(30, 8, $netSgstAmount, '1', '', 'C');

    // Tax Summary Ends



    // Sales Return Print Details Ends
    $pdf->SetFont('Arial', 'I', 10);

    $pdf->SetTextColor(128); // Gray text
    $pdf->SetY(240);
    $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo() . '/{nb}', 0, 1, 'R');
    $pdf->Cell(0, 0, 'Item Once Sold Cannot Be Taken Back', 0, 1, 'C');
    $pdf->Cell(0, 8, 'Thank You !', 0, 1, 'C');
    $pdf->Cell(0, 0, 'Visit Again - Have A Nice Day', 0, 1, 'C');

    // $pdf->Cell(0, 10, 'Generated by '.$_SESSION['user_name'].' - '.$_SESSION['branch_name'], 0, 0, 'C');    
} else {
    // If no data is found
    $pdf->Cell(190, 10, 'No ' . 'record' . ' found matching the search criteria.', 1, 1, 'C');
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