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
$supplierId = $_SESSION['supplierId'];
$fromDate = $_SESSION['fromDate'];
$toDate = $_SESSION['toDate'];
$grnNumber = $_SESSION['grnNumber'];
$invoiceNumber = $_SESSION['invoiceNumber'];
$dcNumber = $_SESSION['dcNumber'];
$optionSelected = $_SESSION['optionSelected'];

if($optionSelected=="grnRadio"){
    $querySearchPurchaseSum = "
    SELECT ps.*, s.* 
    FROM purchase_summary AS ps
    JOIN suppliers AS s ON s.id = ps.supplier_id
    WHERE ps.grn_number LIKE '%$grnNumber%' AND ps.supplier_id LIKE '%$supplierId%'
    AND ps.branch_id = '$userBranchId' AND (grn_date  BETWEEN '$fromDate' AND '$toDate') order by grn_number";    
    
    $queryTotalPurchaseSummary = "select sum(total_qty) as tqty , sum(total_amount) as tamount,
     sum(cgst_amount) as tcgst, sum(sgst_amount) as tsgst, sum(igst_amount) as tigst,
     sum(addon) as taddon, sum(deduction) as tdeduction, sum(net_amount) as tnetamount 
     from purchase_summary WHERE grn_number LIKE '%$grnNumber%' AND supplier_id LIKE '%$supplierId%'
    AND branch_id = '$userBranchId' AND (grn_date  BETWEEN '$fromDate' AND '$toDate')";

}elseif($optionSelected=="invoiceRadio"){

    $querySearchPurchaseSum = "
    SELECT ps.*, s.* 
    FROM purchase_summary AS ps
    JOIN suppliers AS s ON s.id = ps.supplier_id
    WHERE (ps.invoice_number LIKE '%$invoiceNumber%') AND ps.supplier_id LIKE '%$supplierId%'
    AND ps.branch_id = '$userBranchId' AND (invoice_date  BETWEEN '$fromDate' AND '$toDate') order by grn_number";
    
    $queryTotalPurchaseSummary = "select sum(total_qty) as tqty , sum(total_amount) as tamount,
     sum(cgst_amount) as tcgst, sum(sgst_amount) as tsgst, sum(igst_amount) as tigst,
     sum(addon) as taddon, sum(deduction) as tdeduction, sum(net_amount) as tnetamount 
     from purchase_summary WHERE invoice_number LIKE '%$invoiceNumber%' AND supplier_id LIKE '%$supplierId%'
    AND branch_id = '$userBranchId' AND (invoice_date  BETWEEN '$fromDate' AND '$toDate')";
    
}elseif($optionSelected=="dcRadio"){
    $querySearchPurchaseSum = "
    SELECT ps.*, s.* 
    FROM purchase_summary AS ps
    JOIN suppliers AS s ON s.id = ps.supplier_id
    WHERE (ps.dc_number LIKE '%$dcNumber%') AND ps.supplier_id LIKE '%$supplierId%'
    AND ps.branch_id = '$userBranchId' AND (dc_date  BETWEEN '$fromDate' AND '$toDate') order by grn_number";
    
    $queryTotalPurchaseSummary = "select sum(total_qty) as tqty , sum(total_amount) as tamount,
     sum(cgst_amount) as tcgst, sum(sgst_amount) as tsgst, sum(igst_amount) as tigst,
     sum(addon) as taddon, sum(deduction) as tdeduction, sum(net_amount) as tnetamount 
     from purchase_summary WHERE dc_number LIKE '%$dcNumber%' AND supplier_id LIKE '%$supplierId%'
    AND branch_id = '$userBranchId' AND (dc_date  BETWEEN '$fromDate' AND '$toDate')";
}


$purchasesResult = $con->query($querySearchPurchaseSum);

$resultTotalPurchaseSummary = $con->query($queryTotalPurchaseSummary)->fetch_assoc();


// Query to fetch purchase report data
// $queryPurchases = "SELECT p.*,s.* FROM purchase_summary p 
//     JOIN suppliers s ON p.supplier_id = s.id 
//     ORDER BY p.grn_date DESC";
// $purchasesResult = $con->query($queryPurchases);

if ($purchasesResult->num_rows > 0) {
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
    
    $sheet->setCellValue('A6', 'P U R C H A S E     S U M M A R Y');
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
    // Style Company Details
    // $sheet->getStyle('A3:A7')->applyFromArray([
    //     'font' => ['bold' => true],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);

    // Set Column Widths
    $columns = [
        'A' => 6,  // Sno   
        'B' => 11,  // GRN
        'C' => 9,  // GRN Date
        'D' => 25,  // Supplier Name
        'E' => 17,  // Invoice Number
        'F' => 11,  // Invoice Date
        'G' => 10,  // DC Number
        'H' => 9,  // DC Date
        'I' => 6,  // QTY
        'J' => 12,  // Taxable Amount
        'K' => 12,  // CGST Amount
        'L' => 12,  // SGST Amount
        'M' => 12,  // IGST Amount
        'N' => 12,  // Add On Amount
        'O' => 12,  // Deduction Amount
        'P' => 12,  // Net Amount
        
        
    ];
    foreach ($columns as $col => $width) {
        $sheet->getColumnDimension($col)->setWidth($width);
    }

    // Headers Row
    $headers = ['Sno','GRN', 'GRN Date', 'Supplier Name', 'Invoice Number', 'Invoice Date',
    'DC Number', 'DC Date', 'Qty', 'Taxable Amount', 'CGST Amount', 'SGST Amount',
    'IGST Amount', 'Add On Amount', 'Deduction Amount', 'Net Amount'];
    $sheet->fromArray($headers, null, 'A9');

    // Style Header Row
    $headerStyle = [
        'font' => ['bold' => true, 'size' => '8', 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A9:P9')->applyFromArray($headerStyle);

    // Enable AutoFilter
    $sheet->setAutoFilter('A9:P9');

    // Populate Purchase Data
    $row = 10;
    $sno = 1;
    while ($data = $purchasesResult->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $sno++);
        // Apply left alignment
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('B' . $row, $data['grn_number']);
        $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('C' . $row, date('d-m-Y', strtotime($data['grn_date'])));
        $sheet->setCellValue('D' . $row, $data['supplier_name']);
        $sheet->setCellValue('E' . $row, $data['invoice_number']);
        $sheet->setCellValue('F' . $row, date("d-m-Y",strtotime($data['invoice_date'])));
        $sheet->setCellValue('G' . $row, $data['dc_number']);
        $sheet->setCellValue('H' . $row, date("d-m-Y",strtotime($data['dc_date'])));
        $sheet->setCellValue('I' . $row, $data['total_qty']);
        $sheet->setCellValue('J' . $row, round($data['total_amount'],2));
        $sheet->setCellValue('K' . $row, $data['cgst_amount']);
        $sheet->setCellValue('L' . $row, $data['sgst_amount']);
        $sheet->setCellValue('M' . $row, $data['igst_amount']);
        $sheet->setCellValue('N' . $row, $data['addon']);
        $sheet->setCellValue('O' . $row, $data['deduction']);
        $sheet->setCellValue('P' . $row, $data['net_amount']);
        

        // Alternating Row Colors
        $rowStyle = ($row % 2 == 0)
            ? ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']]] // Light green
            : ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]]; // White
        $sheet->getStyle('A' . $row . ':P' . $row)->applyFromArray($rowStyle);

        // Add Borders
        $sheet->getStyle('A' . $row . ':P' . $row)->applyFromArray([
            'font' => ['size'=>'8'],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ]);

        $row++;
    }
    // Merge columns A to H for "TOTAL"
$sheet->mergeCells('A' . $row . ':H' . $row);
$sheet->setCellValue('A' . $row, 'T O T A L');

// Apply styling: Bold text, increased font size, center alignment
$sheet->getStyle('A' . $row.':P'.$row)->applyFromArray([
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
$sheet->setCellValue('I' . $row, $resultTotalPurchaseSummary['tqty']);
$sheet->setCellValue('J' . $row, $resultTotalPurchaseSummary['tamount']);
$sheet->setCellValue('K' . $row, $resultTotalPurchaseSummary['tcgst']);
$sheet->setCellValue('L' . $row, $resultTotalPurchaseSummary['tsgst']);
$sheet->setCellValue('M' . $row, $resultTotalPurchaseSummary['tigst']);
$sheet->setCellValue('N' . $row, $resultTotalPurchaseSummary['taddon']);
$sheet->setCellValue('O' . $row, $resultTotalPurchaseSummary['tdeduction']);
$sheet->setCellValue('P' . $row, $resultTotalPurchaseSummary['tnetamount']);

// Apply border styling for the total row
$sheet->getStyle('A' . $row . ':P' . $row)->applyFromArray([
    'borders' => [
        'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    ],
]);

    // Output File
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="PurchaseSummary_' . date('Y-m-d') . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "No Purchase data found.";
}
?>
