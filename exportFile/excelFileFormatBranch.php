<?php
include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");

require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Retrieve the search query from session
$searching_name1 = $_SESSION['searching_name'] ?? '';
$table_name1 = $_SESSION['table_name'];
$field_name1 = $_SESSION['field_name'];
$table_header1 = $_SESSION['table_header'];
$branchId = $_SESSION['user_branch_id'];
// Query to fetch suppliers
$querySearch = "SELECT * FROM branches WHERE branch_name LIKE '%$searching_name1%' && id like '%$branchId%'";
$searchResult = $con->query($querySearch);

if ($searchResult && $searchResult->num_rows > 0) {
    // Create a new Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->getColumnDimension('A')->setWidth(10);
    $sheet->getColumnDimension('B')->setWidth(15);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(20);
    $sheet->getColumnDimension('F')->setWidth(20);
    $sheet->getColumnDimension('G')->setWidth(10);

    // Merge cells for title and branch
    //$sheet->mergeCells('A1:G1');
    //$sheet->setCellValue('A1', $_SESSION['company_name']);
    $sheet->mergeCells('A2:G2');
    $sheet->setCellValue('A2', $_SESSION['branch_name']);

    // Apply styles to merged cells
    $titleStyle = [
        'font' => ['bold' => true, 'size' => 16],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
    ];    
    $sheet->getStyle('A1:A2')->applyFromArray($titleStyle);    
    
    // Set column widths
    $columns = [
        'A' => 10,  // ID
        'B' => 40,  // Branch Name
        'C' => 30,  // Address 1
        'D' => 30,  // Address 2
        'E' => 30,  // Address 3
        'F' => 20,  // Locality
        'G' => 20,  // City
        'H' => 15,  // Pincode
        'I' => 15,  // State
        'J' => 20,  // Landline
        'K' => 20,  // Mobile
        'L' => 40,  // Email
        'M' => 20,  // GST No
        'N' => 25,  // Created Date
    ];
    foreach ($columns as $col => $width) {
        $sheet->getColumnDimension($col)->setWidth($width);
    }

    // Header row
    $headers = [
        'ID', 'Branch Name', 'Address 1', 'Address 2', 'Address 3', 'Locality', 'City', 
        'Pincode', 'State', 'Landline', 'Mobile', 'Email', 'GST No.', 'Created Date'
    ];
    $sheet->fromArray($headers, null, 'A10');

    // Style header row
    $headerStyle = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A10:N10')->applyFromArray($headerStyle);

    // Enable AutoFilter
    $sheet->setAutoFilter('A10:N10');

    // Populate data rows
    $row = 11; // Start from the second row
    while ($data = $searchResult->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id']);
        $sheet->setCellValue('B' . $row, $data['branch_name']);
        $sheet->setCellValue('C' . $row, $data['address1']);
        $sheet->setCellValue('D' . $row, $data['address2']);
        $sheet->setCellValue('E' . $row, $data['address3']);
        $sheet->setCellValue('F' . $row, $data['locality']);
        $sheet->setCellValue('G' . $row, $data['city']);
        $sheet->setCellValue('H' . $row, $data['pincode']);
        $sheet->setCellValue('I' . $row, $data['state']);
        $sheet->setCellValue('J' . $row, $data['landline']);
        $sheet->setCellValue('K' . $row, $data['mobile']);
        $sheet->setCellValue('L' . $row, $data['email']);
        $sheet->setCellValue('M' . $row, $data['gst_no']);
        $sheet->setCellValue('N' . $row, date('d-m-Y',strtotime($data['created_date'])));

        // Apply alternating row colors
        $rowStyle = ($row % 2 == 0)
            ? ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']]] // Light green
            : ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]]; // White

        $sheet->getStyle('A' . $row . ':N' . $row)->applyFromArray($rowStyle);

        // Add borders
        $sheet->getStyle('A' . $row . ':N' . $row)->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ]);

        $row++;
    }

    // Output file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="branches_"'. date('Y-m-d') . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "No suppliers found matching the search criteria.";
}
?>
