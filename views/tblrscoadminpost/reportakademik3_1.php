<?php
use yii\helpers\Url;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use yii\widgets\Pjax;

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
            'argb' => '1c94b5',
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
            'argb' => '5cc8e6',
        ],
    ],
];
$thirdheader = [
    'font' => [
        'bold' => true,
    ],
//    'alignment' => [
//        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
//    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
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
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->mergeCells("A1:I1");
$sheet->mergeCells("A2:I2");
$sheet->mergeCells("A3:A4");
$sheet->mergeCells("B3:B4");
$sheet->mergeCells("C3:C4");
$sheet->mergeCells("D3:D4");
$sheet->mergeCells("E3:E4");
$sheet->mergeCells("F3:F4");
$sheet->mergeCells("G3:G4");
$sheet->mergeCells("H3:H4");
$sheet->mergeCells("I3:I4");
$sheet->mergeCells("J3:J4");

$sheet->getStyle('A3:J3')->applyFromArray($secondheader);
$sheet->getStyle('A4:J4')->applyFromArray($secondheader);

$sheet->setCellValue('A3', 'BIL');
$sheet->setCellValue('B3', 'ICNO');
$sheet->setCellValue('C3', 'NAMA STAF');
$sheet->setCellValue('D3', 'JAWATAN PENTADBIRAN');
$sheet->setCellValue('E3', 'CATATAN');
$sheet->setCellValue('F3', 'JFPIB');
$sheet->setCellValue('G3', 'KAMPUS');
$sheet->setCellValue('H3', 'TARIKH KUATKUASA');
$sheet->setCellValue('I3', 'TARIKH TAMAT');
$sheet->setCellValue('J3', 'STATUS');

$i=5;
$no=1;
foreach($model as $model){
    $sheet->setCellValue('A'.$i, $no);
    $sheet->setCellValue('B'.$i, $model->ICNO);
    $sheet->setCellValue('C'.$i, $model->kakitangan->CONm);
    $sheet->setCellValue('D'.$i, $model->adminpos->position_name);
    $sheet->setCellValue('E'.$i, $model->description);
    $sheet->setCellValue('F'.$i, $model->dept->fullname);
    $sheet->setCellValue('G'.$i, $model->campus->campus_name);
    $sheet->setCellValue('H'.$i, $model->tarikhmula);
    $sheet->setCellValue('I'.$i, $model->tarikhtamat);
    $sheet->setCellValue('J'.$i, $model->displayflag->flagstatuss);

//    
    $sheet->getStyle('R'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':J'.$i)->applyFromArray($content);
    $sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $i++;
    $no++;
}
foreach(range('A','T') as $columnID) {
    if($columnID != 'R'){
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
    $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('J')->setWidth(40);
$writer = new Xlsx($spreadsheet);
$writer->save("Senarai Rekod Lantikan Keseluruhan (Akademik).xlsx");
Yii::$app->response->redirect(['Senarai Rekod Lantikan Keseluruhan (Akademik).xlsx']);
?>
<a href="<?php echo Url::to('@web/'.'hello worldsssssss.xlsx', true); ?>" target="_blank" ><i class="fa fa-download"></i> Surat Penerimaan Tawaran</a><br>
