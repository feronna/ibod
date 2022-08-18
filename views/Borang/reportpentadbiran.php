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
$sheet->mergeCells("A1:G1");
$sheet->mergeCells("A2:G2");
$sheet->mergeCells("P2:R2");
$sheet->mergeCells("S2:S2");
$sheet->mergeCells("A3:A4");
$sheet->mergeCells("B3:B4");
$sheet->mergeCells("C3:C4");
$sheet->mergeCells("D3:D4");
$sheet->mergeCells("E3:E4");
$sheet->mergeCells("F3:F4");
$sheet->mergeCells("G3:G4");


$sheet->getStyle('A1:G1')->applyFromArray($firstheader);
$sheet->getStyle('A2:G2')->applyFromArray($firstheader);
$sheet->getStyle('A3:G3')->applyFromArray($secondheader);
$sheet->getStyle('A4:G4')->applyFromArray($secondheader);

$sheet->setCellValue('A1', 'LAPORAN PEMAKAIAN ELAUN PAKAIAN PANAS');;

$sheet->setCellValue('A3', 'BIL');
$sheet->setCellValue('B3', 'NAMA');
$sheet->setCellValue('C3', 'ICNO / UMS-PER');
$sheet->setCellValue('D3', 'JAWATAN');
$sheet->setCellValue('E3', 'DESTINASI');
$sheet->setCellValue('F3', 'TARIKH');
$sheet->setCellValue('G3', 'JUMLAH');


$i=5;
$no=1;
//$total = 0;
//count($i);
foreach($model as $model){
    $sheet->setCellValue('A'.$i, $no);
    $sheet->setCellValue('B'.$i, $model->kakitangan->CONm);
    $sheet->setCellValue('C'.$i, $model->icno.' / '.$model->kakitangan->COOldID);
    $sheet->setCellValue('D'.$i, $model->kakitangan->jawatan->nama);
    $sheet->setCellValue('E'.$i, $model->nama_tempat.' '.$model->negara);
    $sheet->setCellValue('F'.$i, $model->entrydate);
    $sheet->setCellValue('G'.$i, 'RM '.$model->jumlah);
   
//    $total = $total+$model['jumlah'];
   
    $sheet->getStyle('R'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':G'.$i)->applyFromArray($content);
    $sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $i++;
    $no++;
}

  $sheet->setCellValue('F'.$i , "Jumlah");
  if($bulan != 00){
      $sheet->setCellValue('G'.$i ,'RM '. $model->getTotal($tahun,$bulan));
  }else{
      $sheet->setCellValue('G'.$i ,'RM '. $model->getTotalYear($tahun,$bulan));
  }
  

foreach(range('A','T') as $columnID) {
    if($columnID != 'R'){
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
    $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('R')->setWidth(60);
$writer = new Xlsx($spreadsheet);
$writer->save("LAPORAN PEMAKAIAN ELAUN PAKAIAN PANAS.xlsx");
Yii::$app->response->redirect(['LAPORAN PEMAKAIAN ELAUN PAKAIAN PANAS.xlsx']);
?>
<a href="<?php echo Url::to('@web/'.'hello worldsssssss.xlsx', true); ?>" target="_blank" ><i class="fa fa-download"></i> Laporan Elaun Pakaian Panas</a><br>
