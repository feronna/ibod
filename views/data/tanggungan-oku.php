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
$sheet->mergeCells("A1:M1");
$sheet->mergeCells("A2:M2");
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
$sheet->mergeCells("L3:L4");
$sheet->mergeCells("M3:M4");


$sheet->getStyle('A1:M1')->applyFromArray($firstheader);
$sheet->getStyle('A2:M2')->applyFromArray($firstheader);
$sheet->getStyle('A3:M3')->applyFromArray($secondheader);
$sheet->getStyle('A4:M4')->applyFromArray($secondheader);

$sheet->setCellValue('A1', 'SENARAI TANGGUNGAN BERSTATUS OKU');
$sheet->setCellValue('A2', $model->kakitangan->CONm);

$sheet->setCellValue('A3', 'BIL');
$sheet->setCellValue('B3', 'NAMA KAKITANGAN');
$sheet->setCellValue('C3', 'UMSPER');
$sheet->setCellValue('D3', 'NAMA TANGGUNGAN');
$sheet->setCellValue('E3', 'NO.KP / MYKID');
$sheet->setCellValue('F3', 'HUBUNGAN');
$sheet->setCellValue('G3', 'NO. KAD KEBAJIKAN');
$sheet->setCellValue('H3', 'JENIS KECACATAN');
$sheet->setCellValue('I3', 'GRED JAWATAN');
$sheet->setCellValue('J3', 'KATEGORI');
$sheet->setCellValue('K3', 'STATUS LANTIKAN');
$sheet->setCellValue('L3', 'STATUS KHIDMAT');
$sheet->setCellValue('M3', 'JAFPIB');



$i=5;
$no=1;
//$total = 0;
//count($i);
foreach($model as $models){
    $sheet->setCellValue('A'.$i, $no);
    $sheet->setCellValue('B'.$i, $models->keluarga->biodata->CONm);
    $sheet->setCellValue('C'.$i, $models->keluarga->biodata->COOldID);
    $sheet->setCellValue('D'.$i, $models->keluarga->FmyNm);
    $sheet->setCellValue('E'.$i, $models->keluarga->FamilyId);
    $sheet->setCellValue('F'.$i, $models->keluarga->Hubkeluarga);
    $sheet->setCellValue('G'.$i, $models->SocialWelfareNo);
    $sheet->setCellValue('H'.$i, $models->jenisKecacatan->DisabilityType);
    $sheet->setCellValue('I'.$i, $models->keluarga->biodata->displayJawatan);
    $sheet->setCellValue('J'.$i, $models->keluarga->biodata->jawatan->LongCat);
    $sheet->setCellValue('K'.$i, $models->keluarga->biodata->displayStatusLantikan);
    $sheet->setCellValue('L'.$i,$models->keluarga->biodata->displayServiceStatus);
    $sheet->setCellValue('M'.$i, $models->keluarga->biodata->displayDepartment);
   
//    $total = $total+$model['jumlah'];
   
    $sheet->getStyle('R'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':M'.$i)->applyFromArray($content);
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
foreach(range('A','M') as $columnID) {
   if($columnID != 'R'){
   $sheet->getColumnDimension($columnID)->setAutoSize(true);
   }
   $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('R')->setWidth(60);
$writer = new Xlsx($spreadsheet);
$writer->save("SENARAI TANGGUNGAN BERSTATUS OKU.xlsx");
Yii::$app->response->redirect(['SENARAI TANGGUNGAN BERSTATUS OKU.xlsx']);
?>
<a href="<?php echo Url::to('@web/'.'hello worldsssssss.xlsx', true); ?>" target="_blank" ><i class="fa fa-download"></i> Senarai Ahli Pemegang Amanah</a><br>
