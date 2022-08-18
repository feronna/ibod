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
$sheet->mergeCells("A1:H1");
$sheet->mergeCells("A2:H2");
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
//$sheet->mergeCells("I3:I4");


$sheet->getStyle('A1:H1')->applyFromArray($firstheader);
$sheet->getStyle('A2:H2')->applyFromArray($firstheader);
$sheet->getStyle('A3:H3')->applyFromArray($secondheader);
$sheet->getStyle('A4:H4')->applyFromArray($secondheader);

$sheet->setCellValue('A1', 'LAPORAN TUNTUTAN PEMBELIAN ALAT KOMUNIKASI');;

$sheet->setCellValue('A3', 'BIL');
$sheet->setCellValue('B3', 'NAMA KAKITANGAN');
$sheet->setCellValue('C3', 'NO. IC / UMS-PER');
$sheet->setCellValue('D3', 'JAWATAN & GRED');
$sheet->setCellValue('E3', 'JFPIU');
$sheet->setCellValue('F3', 'KEMUDAHAN / TUNTUTAN');
$sheet->setCellValue('G3', 'TARIKH MOHON');
//$sheet->setCellValue('H3', 'TUJUAN');
$sheet->setCellValue('H3', 'JUMLAH');


$i=5;
$no=1;
//$total = 0;
//count($i);
foreach($model as $model){
    $sheet->setCellValue('A'.$i, $no);
    $sheet->setCellValue('B'.$i, $model->kakitangan->CONm);
    $sheet->setCellValue('C'.$i, $model->icno.' / '.$model->kakitangan->COOldID);
    $sheet->setCellValue('D'.$i, $model->kakitangan->jawatan->nama.' / '.$model->kakitangan->jawatan->gred);
    $sheet->setCellValue('E'.$i, $model->kakitangan->department->shortname);
    $sheet->setCellValue('F'.$i, $model->displayjenis->kemudahan);
    $sheet->setCellValue('G'.$i, $model->entrydate);
//    $sheet->setCellValue('H'.$i, $model->tujuan);
    $sheet->setCellValue('H'.$i, 'RM '.$model->jumlah_tuntutan);
   
//    $total = $total+$model['jumlah'];
   
    $sheet->getStyle('R'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':H'.$i)->applyFromArray($content);
    $sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $i++;
    $no++;
}

  $sheet->setCellValue('G'.$i , "Jumlah");
  if($bulan != 00){
      $sheet->setCellValue('H'.$i ,'RM '. $model->getTotal($tahun,$bulan));
  }else{
      $sheet->setCellValue('H'.$i ,'RM '. $model->getTotalYear($tahun,$bulan));
  }
  

foreach(range('A','T') as $columnID) {
    if($columnID != 'R'){
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
    $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('R')->setWidth(60);
$writer = new Xlsx($spreadsheet);
$writer->save("LAPORAN TUNTUTAN PEMBELIAN ALAT KOMUNIKASI.xlsx");
Yii::$app->response->redirect(['LAPORAN TUNTUTAN PEMBELIAN ALAT KOMUNIKASI.xlsx']);
?>
<a href="<?php echo Url::to('@web/'.'hello worldsssssss.xlsx', true); ?>" target="_blank" ><i class="fa fa-download"></i> Laporan Tuntutan Pembelian Alat Komunikasi</a><br>
