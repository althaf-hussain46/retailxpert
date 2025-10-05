<?php
include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");

require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Retrieve product name from session
$searching_name1 = $_SESSION['searching_name'] ?? ''; // Get field name from session or set as empty
// $table_name1 = $_SESSION['table_name'];
// $field_name1 = $_SESSION['field_name'];
// $report_title1 = $_SESSION['report_title'];
// $header_title1 = $_SESSION['header_title'];

// Query to fetch products
if($_SESSION['user_role'] == "Super Admin"){
$querySearch = "SELECT * FROM user_master1 WHERE user_name LIKE '%$searching_name1%'";
}else{
    $querySearch = "SELECT * FROM user_master1 WHERE user_name LIKE '%$searching_name1%' && user_role != 'Super Admin'";
}


$searchResult = $con->query($querySearch);

// Check if query was successful
if ($searchResult && $searchResult->num_rows > 0) {
    // Create a new Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    $sheet->getColumnDimension('A')->setWidth(10);
    $sheet->getColumnDimension('B')->setWidth(15);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->getColumnDimension('D')->setWidth(15);
    

    // Merge cells for title and branch
    //$sheet->mergeCells('A1:D1');
    //$sheet->setCellValue('A1', $_SESSION['company_name']);
    $sheet->mergeCells('A2:D2');
    $sheet->setCellValue('A2', $_SESSION['branch_name']);

    // Apply styles to merged cells
    $titleStyle = [
        'font' => ['bold' => true, 'size' => 16],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
    ];    
    $sheet->getStyle('A1:A2')->applyFromArray($titleStyle);    
    

    if($_SESSION['user_role'] == "Super Admin"){
        // Set column widths
    $sheet->getColumnDimension('A')->setWidth(15);
    $sheet->getColumnDimension('B')->setWidth(40);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->getColumnDimension('D')->setWidth(20);
    $sheet->getColumnDimension('E')->setWidth(20);

    // Set header row with background color, bold text, and borders
    $sheet->setCellValue('A5', 'ID');
    $sheet->setCellValue('B5', 'User Name');
    $sheet->setCellValue('C5', 'User Password');
    $sheet->setCellValue('D5', 'User Role');
    $sheet->setCellValue('E5', 'Created Date');
    
    
    
    
    
    
    // Header Style: background color, bold text, borders, and alignment
    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'],
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => '4CAF50'], // Green background for header
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'], // Black border
            ],
        ],
    ];
    $sheet->getStyle('A5:E5')->applyFromArray($headerStyle);

    // Apply AutoFilter to the range A1:C1
    $sheet->setAutoFilter('A5:E5');

    // Fetch data and populate rows with alternating row colors and borders
    $row = 6; // Start from the second row
    while ($data = $searchResult->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id']);          // Adjust column names as per your database
        $sheet->setCellValue('B' . $row, $data['user_name']);
        $sheet->setCellValue('C' . $row, $data['user_pass']);
        $sheet->setCellValue('D' . $row, $data['user_role']);
        $sheet->setCellValue('E' . $row, $data['created_date']);
        
        // Apply alternating row color
        $rowStyle = ($row % 2 == 0) ? 
            ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']]] : // Light green for even rows
            ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]]; // White for odd rows
        
        // Apply the style to data rows
        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($rowStyle);

        // Apply borders to data cells
        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Black border
                ],
            ],
        ]);

        $row++;
    }
    }else{
               // Set column widths
    $sheet->getColumnDimension('A')->setWidth(15);
    $sheet->getColumnDimension('B')->setWidth(40);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->getColumnDimension('D')->setWidth(20);
    

    // Set header row with background color, bold text, and borders
    $sheet->setCellValue('A5', 'ID');
    $sheet->setCellValue('B5', 'User Name');
    $sheet->setCellValue('C5', 'User Role');
    $sheet->setCellValue('D5', 'Created Date');
    
    
    
    
    
    
    // Header Style: background color, bold text, borders, and alignment
    $headerStyle = [
        'font' => [
            'bold' => true,
            'color' => ['rgb' => 'FFFFFF'],
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => '4CAF50'], // Green background for header
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => '000000'], // Black border
            ],
        ],
    ];
    $sheet->getStyle('A5:D5')->applyFromArray($headerStyle);

    // Apply AutoFilter to the range A1:C1
    $sheet->setAutoFilter('A5:D5');

    // Fetch data and populate rows with alternating row colors and borders
    $row = 6; // Start from the second row
    while ($data = $searchResult->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id']);          // Adjust column names as per your database
        $sheet->setCellValue('B' . $row, $data['user_name']);
        $sheet->setCellValue('C' . $row, $data['user_role']);
        $sheet->setCellValue('D' . $row, $data['created_date']);
        
        // Apply alternating row color
        $rowStyle = ($row % 2 == 0) ? 
            ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']]] : // Light green for even rows
            ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]]; // White for odd rows
        
        // Apply the style to data rows
        $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($rowStyle);

        // Apply borders to data cells
        $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Black border
                ],
            ],
        ]);

        $row++;
    }
   }
    
    
    // Set headers for preview (not download)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: inline; filename='.'Users'.".xlsx");
    header('Cache-Control: max-age=0');

    // Write to PHP output (this will show the file in the browser)
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "No User found.";
}

?>
