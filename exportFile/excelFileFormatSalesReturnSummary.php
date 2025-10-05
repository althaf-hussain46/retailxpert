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

if($optionSelected=="salesReturnRadio"){

    $querySearchSalesAndSalesReturnSum = "
    SELECT srs.*, c.* 
    FROM sales_return_summary AS srs
    JOIN customers AS c ON c.id = srs.customer_id
    WHERE (srs.sr_number LIKE '%$salesReturnNumber%') AND srs.customer_id LIKE '%$customerId%'
    AND srs.branch_id = '$userBranchId' AND (date(sr_date)  BETWEEN '$fromDate' AND '$toDate') order by sr_number";
    
    $queryTotalSalesAndSalesReturnSummary = "select sum(sr_qty) as tqty , sum(sr_amount) as tamount,
     sum(sr_cgst_amount) as tcgst, sum(sr_sgst_amount) as tsgst, sum(sr_igst_amount) as tigst,
     sum(sr_addon) as taddon, sum(sr_deduction) as tdeduction, sum(sr_net_amount) as tnetamount,
    sum(sr_taxable_amount) as ttaxableamount, sum(sr_tax_amount) as ttaxamount 
     from sales_return_summary WHERE sr_number LIKE '%$salesReturnNumber%' AND customer_id LIKE '%$customerId%'
    AND branch_id = '$userBranchId' AND (date(sr_date)  BETWEEN '$fromDate' AND '$toDate')";
    
}





$resultSearchSalesReturnSum = $con->query($querySearchSalesAndSalesReturnSum);

$resultTotalSalesSummary = $con->query($queryTotalSalesAndSalesReturnSummary)->fetch_assoc();




if ($resultSearchSalesReturnSum->num_rows > 0) {
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
    
    $sheet->setCellValue('A6', 'S A L E S   R E T U R N   S U M M A R Y');
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
        'B' => 11,  // Bill Return Number
        'C' => 9,  // Bill Return Date
        'D' => 8,  // Counter 
        'E' => 20,  // Customer Name
        'F' => 7,  //  Qty
        'G' => 15,  // Bill Return Amount
        'H' => 8,  // User ID
        
        
    ];
    foreach ($columns as $col => $width) {
        $sheet->getColumnDimension($col)->setWidth($width);
    }

    // Headers Row
    $headers = ['Sno','Bill Return Number', 'Bill Return Date', 'Counter', 'Customer Name', 'Qty',
     'Bill Return Amount', 'User ID'];
    
    $sheet->fromArray($headers, null, 'A9');

    // Style Header Row
    $headerStyle = [
        'font' => ['bold' => true, 'size' => '8', 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A9:H9')->applyFromArray($headerStyle);

    // Enable AutoFilter
    $sheet->setAutoFilter('A9:H9');

    // Populate Purchase Data
    $row = 10;
    $sno = 1;
    while ($data = $resultSearchSalesReturnSum->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $sno++);
        // Apply left alignment
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('B' . $row, $data['sr_number']);
        $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('C' . $row, date('d-m-Y', strtotime($data['sr_date'])));
        $sheet->setCellValue('D' . $row, $data['counter_name']);
        $sheet->setCellValue('E' . $row, $data['customer_name']);
        $sheet->setCellValue('F' . $row, $data['sr_qty']);
        $sheet->setCellValue('G' . $row, $data['sr_net_amount']);
        $sheet->setCellValue('H' . $row, $data['user_id']);
        

        // Alternating Row Colors
        $rowStyle = ($row % 2 == 0)
            ? ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']]] // Light green
            : ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]]; // White
        $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray($rowStyle);

        // Add Borders
        $sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
            'font' => ['size'=>'8'],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ]);

        $row++;
    }
    // Merge columns A to H for "TOTAL"
$sheet->mergeCells('A' . $row . ':B' . $row);
$sheet->setCellValue('A' . $row, 'T O T A L');

// Apply styling: Bold text, increased font size, center alignment
$sheet->getStyle('A' . $row.':H'.$row)->applyFromArray([
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
$sheet->setCellValue('G' . $row, $resultTotalSalesSummary['tnetamount']);


// Apply border styling for the total row
$sheet->getStyle('A' . $row . ':H' . $row)->applyFromArray([
    'borders' => [
        'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    ],
]);

    // Output File
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="SalesReturnSummary_' . date('Y-m-d') . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "No Sales Return data found.";
}
?>
