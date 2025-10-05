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
$companyName = $_SESSION['company_name'] ?? 'Company';
$branchName = $_SESSION['branch_name'] ?? 'Branch';

// Query to fetch products
$querySearch = "SELECT * FROM taxes WHERE tax_code LIKE '%$searching_name1%' && branch_id = '$_SESSION[user_branch_id]'";
$searchResult = $con->query($querySearch);

// Check if query was successful
if ($searchResult && $searchResult->num_rows > 0) {
    // Create a new Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set column widths
    $sheet->getColumnDimension('A')->setWidth(10);
    $sheet->getColumnDimension('B')->setWidth(15);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(20);
    $sheet->getColumnDimension('F')->setWidth(20);
    $sheet->getColumnDimension('G')->setWidth(10);

    // Merge cells for title and branch
    //$sheet->mergeCells('A1:G1');
    //$sheet->setCellValue('A1', $companyName);
    $sheet->mergeCells('A2:G2');
    $sheet->setCellValue('A2', $branchName);

    // Apply styles to merged cells
    $titleStyle = [
        'font' => ['bold' => true, 'size' => 16],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
    ];
    $sheet->getStyle('A1:A2')->applyFromArray($titleStyle);
    
    // Set header row with background color, bold text, and borders
    $sheet->setCellValue('A5', 'S.No.');
    $sheet->setCellValue('B5', 'Tax Code');
    $sheet->setCellValue('C5', 'Tax Description');
    $sheet->setCellValue('D5', 'Tax (%)');
    $sheet->setCellValue('E5', 'Created By');
    $sheet->setCellValue('F5', 'Created Date');
    $sheet->setCellValue('G5', 'ID');
    
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
    $sheet->getStyle('A5:G5')->applyFromArray($headerStyle);

    // Apply AutoFilter to the range A1:C1
    $sheet->setAutoFilter('A5:G5');

    // Fetch data and populate rows with alternating row colors and borders
    $row = 6; // Start from the second row
    $i=1;
    while ($data = $searchResult->fetch_assoc()) {
        
        $searchUserName = "select user_name from user_master1 where id='$data[user_id]'";
        $resultUserName = $con->query($searchUserName)->fetch_assoc();     
        
        $sheet->setCellValue('A' . $row, $i++);          // Adjust column names as per your database
        $sheet->setCellValue('B' . $row, $data['tax_code']);
        $sheet->setCellValue('C' . $row, $data['tax_description']);
        $sheet->setCellValue('D' . $row, $data['tax_percentage']);
        $sheet->setCellValue('E' . $row, $resultUserName['user_name']);
        $sheet->setCellValue('F' . $row, date('d-m-Y',strtotime($data['created_date'])));
        $sheet->setCellValue('G' . $row, $data['id']);
        
        // Apply alternating row color
        $rowStyle = ($row % 2 == 0) ? 
            ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']]] : // Light green for even rows
            ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]]; // White for odd rows
        
        // Apply the style to data rows
        $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray($rowStyle);

        // Apply borders to data cells
        $sheet->getStyle('A' . $row . ':G' . $row)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Black border
                ],
            ],
        ]);

        $row++;
    }

    // Set headers for preview (not download)
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: inline; filename='.'Taxes'.".xlsx");
    header('Cache-Control: max-age=0');

    // Write to PHP output (this will show the file in the browser)
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "No Records found.";
}

?>
<!-- header('Content-Disposition: attachment; filename="Products_' . time() . '.xlsx"');
 -->