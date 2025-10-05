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

// Query to fetch suppliers
$querySearch = "SELECT * FROM company WHERE company_name LIKE '%$searching_name1%'";
$searchResult = $con->query($querySearch);

if ($searchResult && $searchResult->num_rows > 0) {
    // Create a new Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set column widths
    $columns = [
        'A' => 10,  // ID
        'B' => 40,  // Company Name
        'C' => 30,   // Company Short Name 
        'D' => 30,  // Address 1
        'E' => 30,  // Address 2
        'F' => 30,  // Address 3
        'G' => 20,  // Locality
        'H' => 20,  // City
        'I' => 15,  // Pincode
        'J' => 15,  // State
        'K' => 20,  // Landline
        'L' => 20,  // Mobile
        'M' => 40,  // Email
        'N' => 20,  // GST No
        'O' => 25,  // Created Date
    ];
    foreach ($columns as $col => $width) {
        $sheet->getColumnDimension($col)->setWidth($width);
    }

    // Header row
    $headers = [
        'ID', 'Company Name', 'Company Short Name', 'Address 1', 'Address 2', 'Address 3', 'Locality', 'City', 
        'Pincode', 'State', 'Landline', 'Mobile', 'Email', 'GST No.', 'Created Date'
    ];
    $sheet->fromArray($headers, null, 'A1');

    // Style header row
    $headerStyle = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
    ];
    $sheet->getStyle('A1:O1')->applyFromArray($headerStyle);

    // Enable AutoFilter
    $sheet->setAutoFilter('A1:O1');

    // Populate data rows
    $row = 2; // Start from the second row
    while ($data = $searchResult->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id']);
        $sheet->setCellValue('B' . $row, $data['company_name']);
        $sheet->setCellValue('C' . $row, $data['company_short_name']);
        $sheet->setCellValue('D' . $row, $data['address1']);
        $sheet->setCellValue('E' . $row, $data['address2']);
        $sheet->setCellValue('F' . $row, $data['address3']);
        $sheet->setCellValue('G' . $row, $data['locality']);
        $sheet->setCellValue('H' . $row, $data['city']);
        $sheet->setCellValue('I' . $row, $data['pincode']);
        $sheet->setCellValue('J' . $row, $data['state']);
        $sheet->setCellValue('K' . $row, $data['landline']);
        $sheet->setCellValue('L' . $row, $data['mobile']);
        $sheet->setCellValue('M' . $row, $data['email']);
        $sheet->setCellValue('N' . $row, $data['gst_no']);
        $sheet->setCellValue('O' . $row, date('d-m-Y',strtotime($data['created_date'])));

        // Apply alternating row colors
        $rowStyle = ($row % 2 == 0)
            ? ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']]] // Light green
            : ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]]; // White

        $sheet->getStyle('A' . $row . ':O' . $row)->applyFromArray($rowStyle);

        // Add borders
        $sheet->getStyle('A' . $row . ':O' . $row)->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
        ]);

        $row++;
    }

    // Output file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="companies_"'. date('Y-m-d') . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "No Company found matching the search criteria.";
}
?>
