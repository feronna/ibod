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


$sheet->getStyle('A1:H1')->applyFromArray($firstheader);
$sheet->getStyle('A2:H2')->applyFromArray($firstheader);
$sheet->getStyle('A3:H3')->applyFromArray($secondheader);
$sheet->getStyle('A4:H4')->applyFromArray($secondheader);

$sheet->setCellValue('A1', 'REKOD LAWATAN KAKITANGAN KE KLINIK PANEL UMS TAHUN 2021');
$sheet->setCellValue('A2', $model->kakitangan->CONm);

$sheet->setCellValue('A3', 'BIL');
$sheet->setCellValue('B3', 'TARIKH RAWATAN');
$sheet->setCellValue('C3', 'NAMA PESAKIT');
$sheet->setCellValue('D3', 'NO. KP PESAKIT');
$sheet->setCellValue('E3', 'HUBUNGAN');
$sheet->setCellValue('F3', 'RAWATAN');
$sheet->setCellValue('G3', 'NAMA KLINIK');
$sheet->setCellValue('H3', 'JUMLAH TUNTUTAN');


$i=5;
$no=1;
//$total = 0;
//count($i);
foreach($model as $models){
    $sheet->setCellValue('A'.$i, $no);
    $sheet->setCellValue('B'.$i, $models->rawatan_date);
    $sheet->setCellValue('C'.$i, $models->pesakit_name);
    $sheet->setCellValue('D'.$i, $models->pesakit_icno);
    $sheet->setCellValue('E'.$i, $models->ahlikeluarga->hubunganKeluarga->RelNm);
    $sheet->setCellValue('F'.$i, $models->rawatan);
    $sheet->setCellValue('G'.$i, $models->klinik->nama);
   $sheet->setCellValue('H'.$i, 'RM '.$models->jum_tuntutan);
   
//    $total = $total+$model['jumlah'];
   
    $sheet->getStyle('R'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':H'.$i)->applyFromArray($content);
    $sheet->getStyle('D'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
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
//foreach(range('A','T') as $columnID) {
//    if($columnID != 'R'){
//    $sheet->getColumnDimension($columnID)->setAutoSize(true);
//    }
//    $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
//}

$sheet->getColumnDimension('R')->setWidth(60);
$writer = new Xlsx($spreadsheet);
$writer->save("REKOD RAWATAN KLINIK PANEL KAKITANGAN.xlsx");
Yii::$app->response->redirect(['REKOD RAWATAN KLINIK PANEL KAKITANGAN.xlsx']);
?>
<a href="<?php echo Url::to('@web/'.'hello worldsssssss.xlsx', true); ?>" target="_blank" ><i class="fa fa-download"></i> Senarai Ahli Pemegang Amanah</a><br>
