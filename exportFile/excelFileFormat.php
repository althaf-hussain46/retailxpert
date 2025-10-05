<?php
include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");

require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Retrieve values from session
$searching_name1 = $_SESSION['searching_name'] ?? ''; // Default to empty if not set
$table_name1 = $_SESSION['table_name'] ?? '';
$field_name1 = $_SESSION['field_name'] ?? '';
$report_title1 = $_SESSION['report_title'] ?? 'Report';
$header_title1 = $_SESSION['header_title'] ?? 'Header';
$branchId = $_SESSION['user_branch_id'] ?? '';
$companyName = $_SESSION['company_name'] ?? 'Company';
$branchName = $_SESSION['branch_name'] ?? 'Branch';

// Validate essential session variables
if (empty($table_name1) || empty($field_name1) || empty($branchId)) {
    die("Required session data is missing.");
}

// Query to fetch products
$querySearch = "SELECT * FROM $table_name1 WHERE $field_name1 LIKE ? AND $field_name1 != 'althaf' AND branch_id = ? order by $field_name1";
$stmt = $con->prepare($querySearch);
$likeParam = '%' . $searching_name1 . '%';
$stmt->bind_param('ss', $likeParam, $branchId);
$stmt->execute();
$searchResult = $stmt->get_result();

if ($searchResult && $searchResult->num_rows > 0) {
    // Create a new Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set column widths
    $sheet->getColumnDimension('A')->setWidth(15);
    $sheet->getColumnDimension('B')->setWidth(40);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(15);

    // Merge cells for title and branch
    //$sheet->mergeCells('A1:E1');
    //$sheet->setCellValue('A1', $companyName);
    $sheet->mergeCells('A2:E2');
    $sheet->setCellValue('A2', $branchName);

    // Apply styles to merged cells
    $titleStyle = [
        'font' => ['bold' => true, 'size' => 16],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
    ];
    $sheet->getStyle('A1:A2')->applyFromArray($titleStyle);

    // Set header row
    $sheet->setCellValue('A5', 'S.No.');
    $sheet->setCellValue('B5', $header_title1);
    $sheet->setCellValue('C5', 'Created By');
    $sheet->setCellValue('D5', 'Created Date');
    $sheet->setCellValue('E5', 'ID');

    // Apply header styles
    $headerStyle = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'borders' => [
            'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '000000']],
        ],
    ];
    $sheet->getStyle('A5:E5')->applyFromArray($headerStyle);

    // Apply AutoFilter to the range
    $sheet->setAutoFilter('A5:E5');

    // Populate rows
    $row = 6; // Start from row 6
    $i = 1;
    while ($data = $searchResult->fetch_assoc()) {
        $queryUserName = "SELECT user_name FROM user_master1 WHERE id = ?";
        $stmtUserName = $con->prepare($queryUserName);
        $stmtUserName->bind_param('i', $data['user_id']);
        $stmtUserName->execute();
        $resultUserName = $stmtUserName->get_result()->fetch_assoc();

        $sheet->setCellValue('A' . $row, $i++);
        $sheet->setCellValueExplicit('B' . $row, $data[$field_name1],\PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        $sheet->setCellValue('C' . $row, $resultUserName['user_name'] ?? 'Unknown');
        $sheet->setCellValue('D' . $row, date('d-m-Y', strtotime($data['created_date'])));
        $sheet->setCellValue('E' . $row, $data['id']);

        // Apply alternating row color
        $rowStyle = ($row % 2 == 0) ?
            ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']]] :
            ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']]];
        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($rowStyle);

        // Apply borders
        $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['rgb' => '000000']],
            ],
        ]);

        $row++;
    }

    // Output file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $table_name1 . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
} else {
    echo "No $table_name1 found.";
}
?>
