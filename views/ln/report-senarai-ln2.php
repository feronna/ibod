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
// if($no1 ==1){
//    $phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads/rekodlantikan/rekod-lantikan.xls');
//    }
//    else{
//    {
        $phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads/rekodlantikan/template-rekod-senarai-ln2.xls');
//    }
    $sheet = $phpExcel->getActiveSheet();
    foreach(range('A','Z') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('M')->setWidth(80);
$i=6;
$no=1;
foreach($model as $model){
    $sheet->setCellValue('A'.$i, $no);
    $sheet->setCellValue('B'.$i, $model->lulusdate);
    $sheet->setCellValue('C'.$i, $model->datefrom);
    $sheet->setCellValue('D'.$i, $model->dateto);
    $sheet->setCellValue('E'.$i, $model->verdatee);
    $sheet->setCellValue('F'.$i, $model->kakitangan->adminpos->dept->shortname);
    $sheet->setCellValue('G'.$i, $model->kakitangan->CONm);
    $sheet->setCellValue('H'.$i, $model->nama_lawatan);
    $sheet->setCellValue('I'.$i, $model->nama_tempat);
    $sheet->setCellValue('J'.$i, $model->kod_peruntukan_cn);
    $sheet->setCellValue('K'.$i, $model->jumlah3);
    $sheet->setCellValue('M'.$i, $model->status);


//    
    $sheet->getStyle('M'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':M'.$i)->applyFromArray($content);
    $sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $i++;
    $no++;
}
foreach(range('A','M') as $columnID) {
    if($columnID != 'M'){
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
    $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('M')->setWidth(80);
$writer = new Xlsx($phpExcel);
$writer->save("Senarai Rekod Laporan Bertugas Rasmi Di Luar Negara.xlsx");
Yii::$app->response->redirect(['Senarai Rekod Laporan Bertugas Rasmi Di Luar Negara.xlsx']);
?>