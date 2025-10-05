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
// $customerId = $_SESSION['customerId'];
$fromDate = $_SESSION['fromDate'];
$toDate = $_SESSION['toDate'];
// $salesNumber = $_SESSION['salesNumber'];
// $salesReturnNumber = $_SESSION['salesReturnNumber'];
// $optionSelected = $_SESSION['optionSelected'];

$productName = $_SESSION['productName'];
$brandName   = $_SESSION['brandName'];   
$designName  = $_SESSION['designName'];  
$colorName   = $_SESSION['colorName'];   
$batchName   = $_SESSION['batchName'];   
$sizeName    = $_SESSION['sizeName'];    




$querySearchSalesItem = "SELECT i.*, sb.*
                         FROM items AS i
                         JOIN stock_balance AS sb ON sb.item_id = i.id
                         WHERE ((
                             i.product_name = '$productName'
                             OR i.brand_name = '$brandName'
                             OR i.design_name = '$designName'
                             OR i.color_name = '$colorName'
                             OR i.batch_name = '$batchName'
                             OR i.size_name = '$sizeName') 
                        OR
                             ( i.product_name like '%$productName%'
                                AND i.brand_name like '%$brandName%'
                                AND i.design_name like '%$designName%'
                                AND i.color_name like '%$colorName%'
                                AND i.batch_name like '%$batchName%'
                                AND i.size_name like '%$sizeName%')
                        ) 
                         AND (i.branch_id = '$userBranchId' AND sb.item_qty != 0)";
                         
$searchResultSalesItem = $con->query($querySearchSalesItem);








// Query to fetch purchase report data
// $queryPurchases = "SELECT p.*,s.* FROM purchase_summary p 
//     JOIN suppliers s ON p.supplier_id = s.id 
//     ORDER BY p.grn_date DESC";
// $searchResultSalesItem = $con->query($queryPurchases);

if ($searchResultSalesItem->num_rows > 0) {
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
    
    $sheet->setCellValue('A6', 'S T O C K    R E P O R T');
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
        'B' => 15,  // Product
        'C' => 15,  // Brand
        'D' => 15,  // Design 
        'E' => 15,  // Color
        'F' => 15,  // Batch
        'G' => 15,  // Category
        'H' => 15,  // HSN code
        'I' => 9,  // Tax Code 
        'J' => 9,  // Size
        'K' => 9,  // MRP
        'L' => 9,  // Selling
        'M' => 9,  // Rate
        'N' => 9,  // Item QTY
        'O' => 12,  // Value
        'P' => 9,  // Item Id
        
        
        
    ];
    foreach ($columns as $col => $width) {
        $sheet->getColumnDimension($col)->setWidth($width);
    }

    // Headers Row
    $headers = ['Sno','Product', 'Brand', 'Design', 'Color', 'Batch',
    'Category', 'HSN Code', 'Tax Code', 'Size', 'MRP', 'Selling','Rate',
    'Item Qty', 'Value', 'Item Id'];
    
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
    $itemTotalQty = 0;
    $itemTotalValue = 0;
    while ($data = $searchResultSalesItem->fetch_assoc()) {
        $itemTotalQty  = $itemTotalQty  + $data['item_qty']; 
        $itemTotalValue = $itemTotalValue + ($data['item_qty']*$data['rate']);
         
        $sheet->setCellValue('A' . $row, $sno++);
        // Apply left alignment
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('B' . $row, $data['product_name']);
        $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('C' . $row, $data['brand_name']);
        $sheet->setCellValue('D' . $row, $data['design_name']);
        $sheet->setCellValue('E' . $row, $data['color_name']);
        $sheet->setCellValue('F' . $row, $data['batch_name']);
        $sheet->setCellValue('G' . $row, $data['category_name']);
        $sheet->setCellValue('H' . $row, $data['hsn_code']);
        $sheet->setCellValue('I' . $row, $data['tax_code']);
        $sheet->setCellValue('J' . $row, $data['size_name']);
        $sheet->setCellValue('K' . $row, number_format($data['mrp'],2));
        $sheet->setCellValue('L' . $row, number_format($data['selling_price'],2));
        $sheet->setCellValue('M' . $row, number_format($data['rate'],2));
        $sheet->setCellValue('N' . $row, $data['item_qty']);
        $sheet->setCellValue('O' . $row, ($data['item_qty'] * $data['rate']) );
        $sheet->setCellValue('P' . $row, $data['item_id']);
        
        

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
$sheet->mergeCells('A' . $row . ':L' . $row);
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

$sheet->setCellValue('N' . $row, $itemTotalQty);
$sheet->setCellValue('O' . $row, $itemTotalValue);

// Set total values (do NOT merge these columns)
// $sheet->setCellValue('F' . $row, $resultTotalSalesSummary['tqty']);
// $sheet->setCellValue('G' . $row, $resultTotalSalesSummary['tnetamount']);
// $sheet->setCellValue('H' . $row, $resultTotalSalesSummary['tsramount']);
// $sheet->setCellValue('I' . $row, $resultTotalSalesSummary['ttaxableamount']);
// $sheet->setCellValue('J' . $row, $resultTotalSalesSummary['ttaxamount']);
// $sheet->setCellValue('K' . $row, $resultTotalSalesSummary['tcgst']);
// $sheet->setCellValue('L' . $row, $resultTotalSalesSummary['tsgst']);
// $sheet->setCellValue('M' . $row, $resultTotalSalesSummary['tigst']);
// $sheet->setCellValue('N' . $row, $resultTotalSalesSummary['taddon']);
// $sheet->setCellValue('O' . $row, $resultTotalSalesSummary['tdeduction']);


// Apply border styling for the total row
$sheet->getStyle('A' . $row . ':P' . $row)->applyFromArray([
    'borders' => [
        'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    ],
]);

    // Output File
    ob_end_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="StockReport_' . date('Y-m-d') . '.xlsx"');
    header('Cache-Control: max-age=0');
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "No Stock data found.";
}
?>
