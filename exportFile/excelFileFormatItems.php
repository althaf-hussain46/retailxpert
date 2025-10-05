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
$searchItem = $_SESSION['searchItem'];


$querySearchItems = "SELECT * FROM items WHERE 
            (product_name LIKE '%$searchItem%' OR brand_name LIKE '%$searchItem%' OR design_name LIKE '%$searchItem%'
            OR color_name LIKE '%$searchItem%' OR batch_name LIKE '%$searchItem%' OR size_name LIKE '%$searchItem%'
            OR category_name LIKE '%$searchItem%' OR hsn_code LIKE '%$searchItem%' OR tax_code LIKE '%$searchItem%' 
            OR mrp LIKE '%$searchItem%' OR selling_price LIKE '%$searchItem%' OR rate LIKE '%$searchItem%') 
            AND branch_id = '$userBranchId'";
    $resultSearchItems  = $con->query($querySearchItems);
    
    





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
    
    $sheet->setCellValue('A6', 'I T E M   D E T A I L S');
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
    
    
    
    
    
    // Style Company Details
    // $sheet->getStyle('A3:A7')->applyFromArray([
    //     'font' => ['bold' => true],
    //     'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    // ]);

    // Set Column Widths
    $columns = [
        'A' => 8,   // Sno   
        'B' => 15,   // Item Id
        'C' => 15,  // Product
        'D' => 15,  // Brand
        'E' => 18,  // Design
        'F' => 15,  // Color
        'G' => 15,  // Batch
        'H' => 15,  // Category
        'I' => 10,  // HSN Code
        'J' => 7,  // Tax
        'K' => 7,  // Size
        'L' => 7,  // MRP
        'M' => 7,  // Selling
        'N' => 7,  // Rate
        'O' => 20,  // Description
        'P' => 10,  // Created Date
        'Q' => 8,  // User Id
        
        
        
    ];
    foreach ($columns as $col => $width) {
        $sheet->getColumnDimension($col)->setWidth($width);
    }

    // Headers Row
    $headers = ['Sno','Item Id','Product', 'Brand', 'Design', 'Color', 'Batch',
    'Category', 'HSN Code', 'Tax', 'Size', 'MRP', 'Selling',
    'Rate', 'Description', 'Created Date', 'User Id'];
    $sheet->fromArray($headers, null, 'A12');

    // Style Header Row
    $headerStyle = [
        'font' => ['bold' => true, 'size'=>'8', 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A12:Q12')->applyFromArray($headerStyle);

    // Enable AutoFilter
    $sheet->setAutoFilter('A12:Q12');

    // Populate Purchase Data
    $row = 13;
    $sno = 1;
    while ($data = $resultSearchItems->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $sno++);
        // Apply left alignment
        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('B' . $row, $data['id']);        
        $sheet->setCellValue('C' . $row, $data['product_name']);
        $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->setCellValue('D' . $row, $data['brand_name']);
        $sheet->setCellValue('E' . $row, $data['design_name']);
        $sheet->setCellValue('F' . $row, $data['color_name']);
        $sheet->setCellValueExplicit('G' . $row, $data['batch_name'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('H' . $row, $data['category_name']);
        $sheet->setCellValue('I' . $row, $data['hsn_code']);
        $sheet->setCellValue('J' . $row, $data['tax_code']);
        $sheet->setCellValue('K' . $row, $data['size_name']);
        $sheet->setCellValue('L' . $row, $data['mrp']);
        $sheet->setCellValue('M' . $row, $data['selling_price']);
        $sheet->setCellValue('N' . $row, $data['rate']);
        $sheet->setCellValue('O' . $row, $data['description']);
        $sheet->setCellValue('P' . $row, $data['created_date']);
        $sheet->setCellValue('Q' . $row, $data['user_id']);
        
        
        
        

        // Alternating Row Colors
        $rowStyle = ($row % 2 == 0)
            ? ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']]] // Light green
            : ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]]; // White
        $sheet->getStyle('A' . $row . ':Q' . $row)->applyFromArray($rowStyle);

        // Add Borders
        $sheet->getStyle('A' . $row . ':Q' . $row)->applyFromArray([
            'font' => ['size'=>'8'],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ]);

        $row++;
    }
 






    // Output File
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="ItemDetails_' . date('Y-m-d') . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;

?>
