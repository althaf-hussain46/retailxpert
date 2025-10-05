<?php
include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");

require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Query to fetch company details
// $queryCompany = "SELECT * FROM company";
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


$querySearchPurchaseItem  = "SELECT 
                                purchase_item.*, 
                                items.*
                                FROM purchase_item
                                INNER JOIN items ON purchase_item.item_id = items.id
                                WHERE purchase_item.branch_id = '$userBranchId' and date(purchase_item.grn_date) BETWEEN '$fromDate' AND '$toDate'";
    $resultSearchPurchaseItem = $con->query($querySearchPurchaseItem);
    // $querySearchPurchaseSum = "
    // SELECT ps.*, s.* 
    // FROM purchase_summary AS ps
    // JOIN suppliers AS s ON s.id = ps.supplier_id
    // WHERE ps.supplier_id LIKE '%$supplierId%'
    // AND ps.branch_id = '$userBranchId' AND (invoice_date  BETWEEN '$fromDate' AND '$toDate')";
    
    $querySearchPurchaseSum = "
    SELECT ps.*, s.* 
    FROM purchase_summary AS ps
    JOIN suppliers AS s ON s.id = ps.supplier_id
    WHERE ps.grn_number LIKE '%$grnNumber%' AND ps.supplier_id LIKE '%$supplierId%'
    AND ps.branch_id = '$userBranchId' and date(ps.grn_date) BETWEEN '$fromDate' and '$toDate'";
$resultSearchPurchaseSum = $con->query($querySearchPurchaseSum);

$totalcgst = 0;
$totalsgst = 0;
$totaligst = 0;
$totaladdon = 0;
$totaldeduction = 0;
$totalnetamount = 0;
while($resultPurchaseSummary = $resultSearchPurchaseSum->fetch_assoc()){
    $totalcgst         = $totalcgst+$resultPurchaseSummary['cgst_amount'];
    $totalsgst         = $totalsgst+$resultPurchaseSummary['sgst_amount'];
    $totaligst         = $totaligst+$resultPurchaseSummary['igst_amount'];
    $totaladdon        = $totaladdon+$resultPurchaseSummary['addon'];
    $totaldeduction    = $totaldeduction+$resultPurchaseSummary['deduction'];
    $totalnetamount    = $totalnetamount+$resultPurchaseSummary['net_amount'];    
    
}

    $querySearchSupplier = "select*from suppliers where id = '$supplierId' and branch_id = '$userBranchId'";
    $resultSearchSupplier = $con->query($querySearchSupplier)->fetch_assoc();





// Query to fetch purchase report data
// $queryPurchases = "SELECT p.*,s.* FROM purchase_summary p 
//     JOIN suppliers s ON p.supplier_id = s.id 
//     ORDER BY p.grn_date DESC";
// $purchasesResult = $con->query($queryPurchases);


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
    $sheet->setCellValue('A3', $_SESSION['branch_locality']." | ".$_SESSION['branch_city']. " | " . $_SESSION['branch_pinCode'] . " | " . $_SESSION['branch_state']);
    $sheet->mergeCells('A3:P3');
    $sheet->getStyle('A3:P3')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);
    
    $sheet->setCellValue('A4',  "Landline : ".$_SESSION['branch_landline']. " | Mobile : " . $_SESSION['branch_mobile']." | GST No: " . $_SESSION['branch_gst_no']);
    $sheet->mergeCells('A4:P4');
    $sheet->getStyle('A4:P4')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);
    
    $sheet->setCellValue('A6', 'P U R C H A S E     I T E M');
    $sheet->mergeCells('A6:P6');
    $sheet->getStyle('A6')->applyFromArray([
        'font' => ['bold' => true, 'size' => 16],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);
    
    
    $sheet->setCellValue('A7', "Generated On ".date("d-m-Y"));
    $sheet->mergeCells('A7:P7');
    $sheet->getStyle('A7')->applyFromArray([
        'font' => ['bold' => true, 'size' => 10],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ]);
    
    
    
    
    // $sheet->setCellValue('A8', $resultSearchPurchaseSum['supplier_name']);
    // $sheet->mergeCells('A8:C8');
    // $sheet->getStyle('A8')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 16],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    // $sheet->setCellValue('A9', $resultSearchSupplier['address1'].", ".$resultSearchSupplier['address2'].
    // ", ".$resultSearchSupplier['address3'].", ".$resultSearchSupplier['locality'].", ".$resultSearchSupplier['city'].
    // ", ".$resultSearchSupplier['pincode'].", ".$resultSearchSupplier['state']);
    // $sheet->mergeCells('A9:F9');
    // $sheet->getStyle('A9')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 10],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    
    // $sheet->setCellValue('J8', "GRN");
    // $sheet->mergeCells("J8:K8");
    // $sheet->getStyle('J8:k8')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 12],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    // $sheet->setCellValue('L8', "Invoice");
    // $sheet->mergeCells("L8:N8");
    // $sheet->getStyle('L8:N8')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 12],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    // $sheet->setCellValue('O8', "DC");
    // $sheet->mergeCells("O8:P8");
    // $sheet->getStyle('O8:P8')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 12],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    // $sheet->setCellValue('I9', "No.");
    
    // $sheet->getStyle('I9')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 12],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    // $sheet->setCellValue('I10', "Date");
    
    // $sheet->getStyle('I10')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 12],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    
    // $sheet->setCellValue('J9', $resultSearchPurchaseSum['grn_number']);
    // $sheet->mergeCells("J9:K9");
    // $sheet->getStyle('J9:K9')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 10],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    // $sheet->setCellValue('L9', $resultSearchPurchaseSum['invoice_number']);
    // $sheet->mergeCells("L9:N9");
    // $sheet->getStyle('L9:N9')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 10],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    // $sheet->setCellValue('O9', $resultSearchPurchaseSum['dc_number']);
    // $sheet->mergeCells("O9:P9");
    // $sheet->getStyle('O9:P9')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 10],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    
    
    
    
    // $sheet->setCellValue('J10', date('d-m-Y',strtotime($resultSearchPurchaseSum['grn_date'])));
    // $sheet->mergeCells("J10:K10");
    // $sheet->getStyle('J10:K10')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 10],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    // $sheet->setCellValue('L10', date('d-m-Y',strtotime($resultSearchPurchaseSum['invoice_date'])));
    // $sheet->mergeCells("L10:N10");
    // $sheet->getStyle('L10:N10')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 10],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    // $sheet->setCellValue('O10', date('d-m-Y',strtotime($resultSearchPurchaseSum['dc_date'])));
    // $sheet->mergeCells("O10:P10");
    // $sheet->getStyle('O10:P10')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 10],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    
    // $sheet->setCellValue('A10', $resultSearchSupplier['landline']." | ".$resultSearchSupplier['mobile'].
    // " | ".$resultSearchSupplier['email']." | GSTIN : ".$resultSearchSupplier['gst_no']);
    // $sheet->mergeCells('A10:F10');
    // $sheet->getStyle('A10')->applyFromArray([
    //     'font' => ['bold' => true, 'size' => 10],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);
    
    // Style Company Details
    // $sheet->getStyle('A3:A7')->applyFromArray([
    //     'font' => ['bold' => true],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);

    // Set Column Widths
    $columns = [
        'A' => 8,  // Sno   
        'B' => 15, //GRN Number
        'C' => 15, //GRN Number
        'D' => 15,  // Product
        'E' => 15,  // Brand
        'F' => 18,  // Design
        'G' => 15,  // Color
        'H' => 15,  // Batch
        'I' => 15,  // Category
        'J' => 10,  // HSN Code
        'K' => 7,  // Tax
        'L' => 7,  // Size
        'M' => 7,  // MRP
        'N' => 7,  // Selling
        'O' => 7,  // Rate
        'P' => 7,  // Land Cost
        'Q' => 7,  // Margin
        'R' => 12,  // Qty
        'S' => 12   // Amount Amount
        
        
    ];
    foreach ($columns as $col => $width) {
        $sheet->getColumnDimension($col)->setWidth($width);
    }

    // Headers Row
    $headers = ['Sno', 'GRN Number', 'GRN Date', 'Product', 'Brand', 'Design', 'Color', 'Batch',
    'Category', 'HSN Code', 'Tax', 'Size', 'MRP', 'Selling',
    'Rate', 'Land Cost', 'Margin(%)', 'QTY', 'Amount'];
    $sheet->fromArray($headers, null, 'A12');

    // Style Header Row
    $headerStyle = [
        'font' => ['bold' => true, 'size'=>'8', 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A12:S12')->applyFromArray($headerStyle);

    // Enable AutoFilter
    $sheet->setAutoFilter('A12:S12');

    // Populate Purchase Data
    $row = 13;
    $sno = 1;
    $totalqty = 0;
    $totalamount = 0;
    while ($data = $resultSearchPurchaseItem->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $sno++);
        // Apply left alignment
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('B' . $row, $data['grn_number']);
        $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('C' . $row, $data['grn_date']);
        $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('D' . $row, $data['product_name']);
        $sheet->setCellValue('E' . $row, $data['brand_name']);
        $sheet->setCellValue('F' . $row, $data['design_name']);
        $sheet->setCellValue('G' . $row, $data['color_name']);
        $sheet->setCellValueExplicit('H' . $row, $data['batch_name'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('I' . $row, $data['category_name']);
        $sheet->setCellValue('J' . $row, $data['hsn_code']);
        $sheet->setCellValue('K' . $row, $data['tax_code']);
        $sheet->setCellValue('L' . $row, $data['size_name']);
        $sheet->setCellValue('M' . $row, $data['mrp']);
        $sheet->setCellValue('N' . $row, $data['selling_price']);
        $sheet->setCellValue('O' . $row, $data['rate']);
        $sheet->setCellValue('P' . $row, $data['land_cost']);
        $sheet->setCellValue('Q' . $row, $data['margin']);
        $sheet->setCellValue('R' . $row, $data['item_qty']);
        $sheet->setCellValue('S' . $row, $data['item_amount']);
        
        $totalqty = $totalqty+$data['item_qty'];
        $totalamount = $totalamount+$data['item_amount'];
        

        // Alternating Row Colors
        $rowStyle = ($row % 2 == 0)
            ? ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']]] // Light green
            : ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]]; // White
        $sheet->getStyle('A' . $row . ':S' . $row)->applyFromArray($rowStyle);

        // Add Borders
        $sheet->getStyle('A' . $row . ':S' . $row)->applyFromArray([
            'font' => ['size'=>'8'],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ]);

        $row++;
    }
    // Merge columns A to H for "TOTAL"

$sheet->setCellValue('Q' . $row, 'T O T A L');

// Apply styling: Bold text, increased font size, center alignment
$sheet->getStyle('Q' .$row)->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 12, // Increase font size
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFFF99'], // Light yellow background
    ],
]);

$sheet->getStyle('R' .$row.':S'.$row)->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 12, // Increase font size
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'FFFF99'], // Light yellow background
    ],
]);


for($i=1;$i<=6;$i++){
    if($i==6){
        $sheet->getStyle('S'.$row+$i)->applyFromArray([
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
    }else{
    
    
    $sheet->getStyle('S'.$row+$i)->applyFromArray([
        'font' => [
            'bold' => true,
            'size' => 10, // Increase font size
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FFFF99'], // Light yellow background
        ],
    ]);
    }
}

for($i=1;$i<=6;$i++){
 
    $sheet->getStyle('R' . $row+$i . ':S' . $row+$i)->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
    ]);
    
    $sheet->getStyle('R'.$row+$i)->applyFromArray([
        'font' => [
            'bold' => true,
            
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'FFFF99'], // Light yellow background
        ],
    ]);
 
}



// Set total values (do NOT merge these columns)
$sheet->setCellValue('R' . $row, $totalqty);
$sheet->setCellValue('S' . $row,$totalamount);
$sheet->setCellValue('R' . $row+1, "CGST");
$sheet->setCellValue('S' . $row+1,$totalcgst);
$sheet->setCellValue('R' . $row+2, "SGST");
$sheet->setCellValue('S' . $row+2,$totalsgst);
$sheet->setCellValue('R' . $row+3, "IGST");
$sheet->setCellValue('S' . $row+3,$totaligst);
$sheet->setCellValue('R' . $row+4, "AddOn");
$sheet->setCellValue('S' . $row+4,$totaladdon);
$sheet->setCellValue('R' . $row+5, "Deduction");
$sheet->setCellValue('S' . $row+5,$totaldeduction);
$sheet->setCellValue('R' . $row+6, "Net Amount");
$sheet->setCellValue('S' . $row+6,$totalnetamount);

// Apply border styling for the total row
$sheet->getStyle('R' . $row . ':S' . $row)->applyFromArray([
    'borders' => [
        'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
    ],
]);
    // Output File
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="PurchaseItem_' . date('Y-m-d') . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

?>
