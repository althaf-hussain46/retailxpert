<?php
include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");

require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Query to fetch company details
// $queryCompany = "SELECT * FROM company WHERE id = '1'";
// $companyResult = $con->query($queryCompany);
// $_SESSION = $companyResult->fetch_assoc();

$userBranchId = $_SESSION['user_branch_id'];
$customerId = $_SESSION['customerId'];
$fromDate = $_SESSION['fromDate'];
$toDate = $_SESSION['toDate'];
$salesNumber = $_SESSION['salesNumber'];
$salesReturnNumber = $_SESSION['salesReturnNumber'];
$optionSelected = $_SESSION['optionSelected'];

if($optionSelected=="salesRadio"){
    // $querySearchSalesAndSalesReturnSum = "
    // SELECT ss.*, c.* 
    // FROM sales_summary AS ss
    // JOIN customers AS c ON c.id = ss.customer_id
    // WHERE ss.sales_number LIKE '%$salesNumber%' AND ss.customer_id LIKE '%$customerId%'
    // AND ss.branch_id = '$userBranchId' AND (date(sales_date)  BETWEEN '$fromDate' AND '$toDate') order by sales_number";    
    
    $querySearchSalesAndSalesReturnSum = "SELECT 
            ss.sales_number, ss.sales_date, ss.counter_name, ss.s_qty, ss.s_taxable_amount,
            ss.s_tax_amount,ss.sales_return_amount, ss.s_net_amount, ss.customer_id, ss.user_id,
            c.customer_name,
            sr.sr_taxable_amount, sr.sr_tax_amount
            FROM sales_summary AS ss
            LEFT JOIN customers AS c ON c.id = ss.customer_id
            LEFT JOIN sales_return_summary AS sr ON sr.sr_number = ss.sales_number
            WHERE ss.sales_number LIKE '%$salesNumber%' AND ss.customer_id LIKE '%$customerId%'
            AND ss.branch_id = '$userBranchId' AND (date(sales_date)  BETWEEN '$fromDate' AND '$toDate') order by sales_number";
    
    $queryTotalSalesAndSalesReturnSummary = "select sum(s_qty) as tqty , sum(s_amount) as tamount,
     sum(s_cgst_amount) as tcgst, sum(s_sgst_amount) as tsgst, sum(s_igst_amount) as tigst,
     sum(s_addon) as taddon, sum(s_deduction) as tdeduction, sum(s_net_amount) as tnetamount,
     sum(sales_return_amount) as tsramount, sum(s_taxable_amount) as ttaxableamount,
     sum(s_tax_amount) as ttaxamount 
     from sales_summary WHERE sales_number LIKE '%$salesNumber%' AND customer_id LIKE '%$customerId%'
    AND branch_id = '$userBranchId' AND (date(sales_date)  BETWEEN '$fromDate' AND '$toDate')";

}elseif($optionSelected=="salesReturnRadio"){

    // $querySearchSalesAndSalesReturnSum = "
    // SELECT srs.*, c.* 
    // FROM sales_return_summary AS srs
    // JOIN customers AS c ON c.id = srs.customer_id
    // WHERE (srs.sr_number LIKE '%$salesReturnNumber%') AND srs.customer_id LIKE '%$customerId%'
    // AND srs.branch_id = '$userBranchId' AND (sr_date  BETWEEN '$fromDate' AND '$toDate') order by sr_number";
    
    // $queryTotalSalesAndSalesReturnSummary = "select sum(sr_qty) as tqty , sum(sr_amount) as tamount,
    //  sum(sr_cgst_amount) as tcgst, sum(sr_sgst_amount) as tsgst, sum(sr_igst_amount) as tigst,
    //  sum(sr_addon) as taddon, sum(sr_deduction) as tdeduction, sum(sr_net_amount) as tnetamount,
    // sum(sr_taxable_amount) as ttaxableamount, sum(sr_tax_amount) as ttaxamount 
    //  from sales_return_summary WHERE sr_number LIKE '%$salesReturnNumber%' AND customer_id LIKE '%$customerId%'
    // AND branch_id = '$userBranchId' AND (sr_date  BETWEEN '$fromDate' AND '$toDate')";
    
}





$resultSearchSalesSum = $con->query($querySearchSalesAndSalesReturnSum);

$resultTotalSalesSummary = $con->query($queryTotalSalesAndSalesReturnSummary)->fetch_assoc();


// Query to fetch purchase report data
// $queryPurchases = "SELECT p.*,s.* FROM purchase_summary p 
//     JOIN suppliers s ON p.supplier_id = s.id 
//     ORDER BY p.grn_date DESC";
// $resultSearchSalesSum = $con->query($queryPurchases);

if ($resultSearchSalesSum->num_rows > 0) {
    // Create a new Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set Report Title
    //$sheet->setCellValue('A1', $_SESSION['company_name']." ( ".$_SESSION['branch_name']." ) ");
    $sheet->setCellValue('A1', $_SESSION['branch_name']);
    $sheet->mergeCells('A1:P1');
    $sheet->getStyle('A1')->applyFromArray([
        'font' => ['bold' => true, 'size' => 20],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);

    // Report Date
    $sheet->setCellValue('A2', $_SESSION['branch_address1'] . ", " . $_SESSION['branch_address2'] . ", " . $_SESSION['branch_address3']);
    $sheet->mergeCells('A2:P2');
    $sheet->getStyle('A2')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);

    // Company Details
    $sheet->setCellValue('A3', $_SESSION['branch_locality'] . " | " . $_SESSION['branch_city'] . " | " . $_SESSION['branch_pinCode']." | ".$_SESSION['branch_state']);
    $sheet->mergeCells('A3:P3');
    $sheet->getStyle('A3:P3')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);
    
    $sheet->setCellValue('A4',  "Landline : ".$_SESSION['branch_landline'] ." | Mobile : " . $_SESSION['branch_mobile']." | GST No: " . $_SESSION['branch_gst_no']);
    $sheet->mergeCells('A4:P4');
    $sheet->getStyle('A4:P4')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);
    
    $sheet->setCellValue('A6', 'S A L E S     S U M M A R Y');
    $sheet->mergeCells('A6:P6');
    $sheet->getStyle('A6')->applyFromArray([
        'font' => ['bold' => true, 'size' => 16],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);
    
    $sheet->setCellValue('A7', "From  ".date("d-m-Y",strtotime($fromDate))
    ." To ".date("d-m-Y",strtotime($toDate)));
    $sheet->mergeCells('A7:D7');
    $sheet->getStyle('A7')->applyFromArray([
        'font' => ['bold' => true, 'size' => 10],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    ]);
    
    
    $sheet->setCellValue('M7', "Generated On ".date("d-m-Y"));
    $sheet->mergeCells('M7:P7');
    $sheet->getStyle('M7')->applyFromArray([
        'font' => ['bold' => true, 'size' => 10],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT],
    ]);
    
    // Set Column Widths
    $columns = [
        'A' => 6,  // Sno   
        'B' => 11,  // Bill Number
        'C' => 9,  // Bill Date
        'D' => 8,  // Counter 
        'E' => 20,  // Customer Name
        'F' => 7,  // Qty
        'G' => 15, //Taxable Amount
        'H' => 13,  //Tax Amount
        'I' => 13, // Total Amount
        'J' => 15, // Taxable Amount
        'K' => 13, // Tax Amount
        'L' => 15, // Bill Return Amount
        'M' => 15, // Bill Amount
        'N' => 8,// User ID
        
        
    ];
    foreach ($columns as $col => $width) {
        $sheet->getColumnDimension($col)->setWidth($width);
    }

    // Headers Row
    $headers = ['Sno','Bill Number', 'Bill Date', 'Counter', 'Customer Name', 'Qty',
                'Sales - Taxable Amt','Tax Amt', 'Total Sales Amt', 'S.Return - Taxable Amt',
                'Tax Amount', 'Total S.Return Amt', 'Net Bill Amount', 'User ID'];
    
    $sheet->fromArray($headers, null, 'A9');

    // Style Header Row
    $headerStyle = [
        'font' => ['bold' => true, 'size' => '8', 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A9:N9')->applyFromArray($headerStyle);

    // Enable AutoFilter
    $sheet->setAutoFilter('A9:N9');

    // Populate Purchase Data
    $row = 10;
    $sno = 1;
    $salesTotalTaxAmount = 0;
    $salesReturnTotalAmount = 0;
    
    while ($data = $resultSearchSalesSum->fetch_assoc()) {
        $salesTotalTaxAmount = $salesTotalTaxAmount+$data['s_taxable_amount']+$data['s_tax_amount'];
        $salesReturnTotalAmount = $salesReturnTotalAmount+$data['sales_return_amount'];
        $sheet->setCellValue('A' . $row, $sno++);
        // Apply left alignment
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('B' . $row, $data['sales_number']);
        $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('C' . $row, date('d-m-Y', strtotime($data['sales_date'])));
        $sheet->setCellValue('D' . $row, $data['counter_name']);
        $sheet->setCellValue('E' . $row, $data['customer_name']);
        $sheet->setCellValue('F' . $row, $data['s_qty']);
        $sheet->setCellValue('G' . $row, $data['s_taxable_amount']);
        $sheet->setCellValue('H' . $row, $data['s_tax_amount']);
        $sheet->setCellValue('I' . $row, $data['s_taxable_amount']+$data['s_tax_amount']);
        $sheet->setCellValue('J' . $row, $data['sr_taxable_amount']);
        $sheet->setCellValue('K' . $row, $data['sr_tax_amount']);
        $sheet->setCellValue('L' . $row, $data['sales_return_amount']);
        $sheet->setCellValue('M' . $row, $data['s_net_amount']);
        $sheet->setCellValue('N' . $row, $data['user_id']);
        

        // Alternating Row Colors
        $rowStyle = ($row % 2 == 0)
            ? ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']]] // Light green
            : ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]]; // White
        $sheet->getStyle('A' . $row . ':N' . $row)->applyFromArray($rowStyle);

        // Add Borders
        $sheet->getStyle('A' . $row . ':N' . $row)->applyFromArray([
            'font' => ['size'=>'8'],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ]);

        $row++;
    }
    // Merge columns A to H for "TOTAL"
$sheet->mergeCells('A' . $row . ':B' . $row);
$sheet->setCellValue('A' . $row, 'T O T A L');

// Apply styling: Bold text, increased font size, center alignment
$sheet->getStyle('A' . $row.':N'.$row)->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 14, // Increase font size
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFFF99'], // Light yellow background
    ],
]);

// Set total values (do NOT merge these columns) 
$sheet->setCellValue('F' . $row, $resultTotalSalesSummary['tqty']);
$sheet->setCellValue('I' . $row, $salesTotalTaxAmount);
$sheet->setCellValue('L' . $row, $salesReturnTotalAmount);
$sheet->setCellValue('M' . $row, $resultTotalSalesSummary['tnetamount']);

// Apply border styling for the total row
$sheet->getStyle('A' . $row . ':N' . $row)->applyFromArray([
    'borders' => [
        'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    ],
]);

    // Output File
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="SalesSummary_' . date('Y-m-d') . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "No Sales data found.";
}
?>
