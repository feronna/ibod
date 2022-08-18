<?php

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

error_reporting(0);

$firstheader = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => [
            'argb' => 'EB5D00',
        ],
    ],
];
$secondheader = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => [
            'argb' => 'FFC502',
        ],
    ],
];
$content = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        ],
    ],
];


$i = 1;
$phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads/hronline/paspot/template_passport_report.xlsx');
$sheet = $phpExcel->getActiveSheet();
foreach ($model as $model) {

    $row = $i + 1;
    $sheet->setCellValue('A' . $row, $i);
    $sheet->setCellValue('B' . $row, $model->ICNO);
    $sheet->getStyle('B' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $sheet->getStyle('A' . $row . ':F' . $row)->applyFromArray($content);
    $sheet->setCellValue('C' . $row, $model->biodata->CONm);
    switch ($model->isSabahan) {
        case '1':
            $status = 'Sabah';
            break;        
        default:
        $status = 'Non-Sabah';
            break;
    }
    $sheet->setCellValue('D' . $row, $status);
    switch ($model->ps_noty_status) {
        case '1':
            $status = 'ON';
            break;        
        default:
        $status = 'OFF';
            break;
    }
    $sheet->setCellValue('E' . $row, $status);
    switch ($model->pasport_status) {
        case '1':
            $status = 'Updated';
            break;
        case '2':
            $status = 'Expired';
            break;
        
        default:
        $status = 'Not Exist';
            break;
    }
    $sheet->setCellValue('F' . $row, $status);

    $i++;
}

$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);

$writer = new Xlsx($phpExcel);
$writer->save('uploads/hronline/paspot/passport_report.xlsx');


?>
<html>

<script language='javascript' type='text/javascript'>
    window.location.href = '/staff/web/uploads/hronline/paspot/passport_report.xlsx';
    alert("Success");
    window.close();
</script>

</html>