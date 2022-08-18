<?php
use yii\helpers\Url;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

error_reporting(0);
$firstheader = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
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
$sheet->mergeCells("A1:J1");
$sheet->mergeCells("A2:J2");
$sheet->mergeCells("P2:R2");
$sheet->mergeCells("S2:S2");
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


$sheet->getStyle('A1:J1')->applyFromArray($firstheader);
$sheet->getStyle('A2:J2')->applyFromArray($firstheader);
$sheet->getStyle('A3:J3')->applyFromArray($secondheader);
$sheet->getStyle('A4:J4')->applyFromArray($secondheader);

$sheet->setCellValue('A1', 'SENARAI KAKITANGAN UMS BERSTATUS OKU');
$sheet->setCellValue('A2', $model->kakitangan->CONm);

$sheet->setCellValue('A3', 'BIL');
$sheet->setCellValue('B3', 'NAMA KAKITANGAN');
$sheet->setCellValue('C3', 'UMSPER');
$sheet->setCellValue('D3', 'NO. KAD KEBAJIKAN');
$sheet->setCellValue('E3', 'JENIS KECACATAN');
$sheet->setCellValue('F3', 'GRED JAWATAN');
$sheet->setCellValue('G3', 'KATEGORI');
$sheet->setCellValue('H3', 'STATUS LANTIKAN');
$sheet->setCellValue('I3', 'STATUS KHIDMAT');
$sheet->setCellValue('J3', 'JAFPIB');



$i=5;
$no=1;
//$total = 0;
//count($i);
foreach($model as $models){
    $sheet->setCellValue('A'.$i, $no);
    $sheet->setCellValue('B'.$i, $models->biodata->CONm);
    $sheet->setCellValue('C'.$i, $models->biodata->COOldID);
    $sheet->setCellValue('D'.$i, $models->SocialWelfareNo);
    $sheet->setCellValue('E'.$i, $models->jenisKecacatan->DisabilityType);
    $sheet->setCellValue('F'.$i, $models->biodata->displayJawatan);
    $sheet->setCellValue('G'.$i, $models->biodata->jawatan->LongCat);
    $sheet->setCellValue('H'.$i, $models->biodata->displayStatusLantikan);
    $sheet->setCellValue('I'.$i,$models->biodata->displayServiceStatus);
    $sheet->setCellValue('J'.$i, $models->biodata->displayDepartment);
   
//    $total = $total+$model['jumlah'];
   
    $sheet->getStyle('R'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':J'.$i)->applyFromArray($content);
    $sheet->getStyle('C'.$i.':H'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $sheet->getColumnDimension('A'.$i)->setAutoSize(true);

    $i++;
    $no++;
}

//  $sheet->setCellValue('F'.$i , "Jumlah");
//  if($bulan != 00){
//      $sheet->setCellValue('G'.$i ,'RM '. $model->getTotal($tahun,$bulan));
//  }else{
//      $sheet->setCellValue('G'.$i ,'RM '. $model->getTotalYear($tahun,$bulan));
//  }
//  
//
foreach(range('A','J') as $columnID) {
   if($columnID != 'R'){
   $sheet->getColumnDimension($columnID)->setAutoSize(true);
   }
   $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('R')->setWidth(60);
$writer = new Xlsx($spreadsheet);
$writer->save("SENARAI KAKITANGAN UMS BERSTATUS OKU.xlsx");
Yii::$app->response->redirect(['SENARAI KAKITANGAN UMS BERSTATUS OKU.xlsx']);
?>
<a href="<?php echo Url::to('@web/'.'hello worldsssssss.xlsx', true); ?>" target="_blank" ><i class="fa fa-download"></i> Senarai Ahli Pemegang Amanah</a><br>
