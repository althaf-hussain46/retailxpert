<?php
include_once("../config/config.php");
include_once(DIR_URL . "/db/dbConnection.php");

require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Get filter session values
$userBranchId = $_SESSION['user_branch_id'];
$customerId = $_SESSION['customerId'];
$fromDate = $_SESSION['fromDate'];
$toDate = $_SESSION['toDate'];
$salesNumber = $_SESSION['salesNumber'];

// Fetch sales item data
$querySearchSalesItem = "SELECT sales_item.*, items.* 
                         FROM sales_item
                         INNER JOIN items ON sales_item.s_item_id = items.id
                         WHERE sales_item.branch_id = '$userBranchId' 
                         AND DATE(sales_item.sales_date) BETWEEN '$fromDate' AND '$toDate'";
$resultSearchSalesItem = $con->query($querySearchSalesItem);

// Fetch sales summary
$querySearchSalesSum = "SELECT ss.*, c.* 
                        FROM sales_summary AS ss
                        JOIN customers AS c ON c.id = ss.customer_id
                        WHERE ss.sales_number LIKE '%$salesNumber%' 
                        AND ss.customer_id LIKE '%$customerId%'
                        AND ss.branch_id = '$userBranchId' 
                        AND DATE(ss.sales_date) BETWEEN '$fromDate' AND '$toDate'";
$resultSearchSalesSum = $con->query($querySearchSalesSum);

// Totals
$s_total_cgst = $s_total_sgst = $s_total_igst = $s_total_addon = $s_total_decution = $s_total_netamount = 0;
while($summary = $resultSearchSalesSum->fetch_assoc()) {
    $s_total_cgst     += $summary['s_cgst_amount'];
    $s_total_sgst     += $summary['s_sgst_amount'];
    $s_total_igst     += $summary['s_igst_amount'];
    $s_total_addon    += $summary['s_addon'];
    $s_total_decution += $summary['s_deduction'];
    $s_total_netamount+= $summary['s_net_amount'];
}

// Customer info (optional)
$customerData = $con->query("SELECT * FROM customers WHERE id = '$customerId' AND branch_id = '$userBranchId'")->fetch_assoc();

// Create Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header
$sheet->setCellValue('A1', $_SESSION['branch_name']);
$sheet->mergeCells('A1:S1');
$sheet->getStyle('A1')->applyFromArray([
    'font' => ['bold' => true, 'size' => 20],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);

$sheet->setCellValue('A2', $_SESSION['branch_address1'] . ", " . $_SESSION['branch_address2'] . ", " . $_SESSION['branch_address3']);
$sheet->mergeCells('A2:S2');
$sheet->getStyle('A2')->applyFromArray([
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);

$sheet->setCellValue('A3', $_SESSION['branch_locality']." | ".$_SESSION['branch_city']." | ".$_SESSION['branch_pinCode']." | ".$_SESSION['branch_state']);
$sheet->mergeCells('A3:S3');
$sheet->getStyle('A3')->applyFromArray([
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);

$sheet->setCellValue('A4', "Landline: ".$_SESSION['branch_landline']." | Mobile: ".$_SESSION['branch_mobile']." | GST No: ".$_SESSION['branch_gst_no']);
$sheet->mergeCells('A4:S4');
$sheet->getStyle('A4')->applyFromArray([
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);

$sheet->setCellValue('A6', 'SALES ITEM');
$sheet->mergeCells('A6:S6');
$sheet->getStyle('A6')->applyFromArray([
    'font' => ['bold' => true, 'size' => 16],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);

$sheet->setCellValue('A7', 'Generated On ' . date("d-m-Y"));
$sheet->mergeCells('A7:S7');
$sheet->getStyle('A7')->applyFromArray([
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
]);

// Column Widths
$columns = [
    'A' => 8,  'B' => 15, 'C' => 15, 'D' => 15, 'E' => 15, 'F' => 18, 'G' => 15,
    'H' => 15, 'I' => 15, 'J' => 10, 'K' => 7,  'L' => 7,  'M' => 7,  'N' => 7,
    'O' => 7,  'P' => 7,  'Q' => 7,  'R' => 12, 'S' => 12,
];
foreach ($columns as $col => $width) {
    $sheet->getColumnDimension($col)->setWidth($width);
}

// Header Row
$headers = ['Sno', 'Sales Number', 'Sales Date', 'Product', 'Brand', 'Design', 'Color', 'Batch',
    'Category', 'HSN Code', 'Tax', 'Size', 'MRP', 'Selling', 'Rate', 'Taxable Amount', 'Tax Amount', 'QTY', 'Amount'];
$sheet->fromArray($headers, null, 'A12');
$sheet->getStyle('A12:S12')->applyFromArray([
    'font' => ['bold' => true, 'size' => 8, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
]);
$sheet->setAutoFilter('A12:S12');

// Populate Sales Data
$row = 13;
$sno = 1;
while ($data = $resultSearchSalesItem->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $sno++);
    $sheet->setCellValue('B' . $row, $data['sales_number']);
    $sheet->setCellValue('C' . $row, $data['sales_date']);
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
    $sheet->setCellValue('P' . $row, $data['s_taxable_amount']);
    $sheet->setCellValue('Q' . $row, $data['s_tax_amount']);
    $sheet->setCellValue('R' . $row, $data['s_item_qty']);
    $sheet->setCellValue('S' . $row, $data['s_item_amount']);
    $row++;
}

// Output to browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="SalesItem_' . date("Ymd_His") . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
