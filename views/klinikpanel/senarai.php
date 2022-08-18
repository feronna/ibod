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
$sheet->mergeCells("A1:K1");
$sheet->mergeCells("A2:K2");
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
$sheet->mergeCells("K3:K4");


$sheet->getStyle('A1:K1')->applyFromArray($firstheader);
$sheet->getStyle('A2:K2')->applyFromArray($firstheader);
$sheet->getStyle('A3:K3')->applyFromArray($secondheader);
$sheet->getStyle('A4:K4')->applyFromArray($secondheader);

$sheet->setCellValue('A1', 'SENARAI PERMOHONAN PENAMBAHAN PERUNTUKAN MYHEALTH TAHUN 2022');
// $sheet->setCellValue('A2', $model->kakitangan->CONm);

$sheet->setCellValue('A3', 'BIL');
$sheet->setCellValue('B3', 'NAMA KAKITANGAN');
$sheet->setCellValue('C3', 'NO. KP');
$sheet->setCellValue('D3', 'TANGGUNGAN');
$sheet->setCellValue('E3', 'STATUS PERKAHWINAN');
$sheet->setCellValue('F3', 'PERUNTUKAN TAHUN SEMASA');
$sheet->setCellValue('G3', 'BAKI PERUNTUKAN');
$sheet->setCellValue('H3', 'REKOD PENAMBAHAN PERUNTUKAN');
$sheet->setCellValue('I3', 'PENAMBAHAN KALI');
$sheet->setCellValue('J3', 'JUSTIFIKASI PERMOHONAN');
$sheet->setCellValue('K3', 'STATUS');


$i=5;
$no=1;
//$total = 0;
//count($i);
foreach($model as $models){
    $sheet->setCellValue('A'.$i, $no);
    $sheet->setCellValue('B'.$i, $models->kakitangan->kakitangan->CONm);
    $sheet->setCellValue('C'.$i, $models->icno);
    $sheet->setCellValue('D'.$i, $models->dependent);
    $sheet->setCellValue('E'.$i, $models->kakitangan->kakitangan->tarafPerkahwinan->MrtlStatus);
    $sheet->setCellValue('F'.$i, 'RM'.$models->kakitangan->max_tuntutan);
    $sheet->setCellValue('G'.$i, 'RM'.$models->kakitangan->current_balance);
    $sheet->setCellValue('H'.$i, 'RM'.$models->kakitangan->topup_max);
    $sheet->setCellValue('I'.$i,$models->permohonanR);
    $sheet->setCellValue('J'.$i, $models->entry_remarks);
    $sheet->setCellValue('K'.$i, $models->statusE);
   
//    $total = $total+$model['jumlah'];
   
    $sheet->getStyle('R'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':K'.$i)->applyFromArray($content);
    $sheet->getStyle('C'.$i.':H'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    // $sheet->getColumnDimension('A'.$i)->setAutoSize(true);

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
foreach(range('A','K') as $columnID) {
   if($columnID != 'R'){
   $sheet->getColumnDimension($columnID)->setAutoSize(true);
   }
   $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('R')->setWidth(60);
$writer = new Xlsx($spreadsheet);
$writer->save("SENARAI PERMOHONAN PENAMBAHAN PERUNTUKAN MYHEALTH TAHUN 2022.xlsx");
Yii::$app->response->redirect(['SENARAI PERMOHONAN PENAMBAHAN PERUNTUKAN MYHEALTH TAHUN 2022.xlsx']);
?>
<a href="<?php echo Url::to('@web/'.'hello worldsssssss.xlsx', true); ?>" target="_blank" ><i class="fa fa-download"></i> Senarai Ahli Pemegang Amanah</a><br>
