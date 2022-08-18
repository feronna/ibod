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
        $phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads/rekodlantikan/template-rekod-senarai-semua-ln1.xls');
//    }
    $sheet = $phpExcel->getActiveSheet();
    foreach(range('A','Z') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('N')->setWidth(80);
$i=6;
$no=1;
foreach($model as $model){
    $sheet->setCellValue('A'.$i, $no);
    $sheet->setCellValue('B'.$i, $model->lulusdate);
    $sheet->setCellValue('C'.$i, $model->entrydate);
    $sheet->setCellValue('D'.$i, $model->datefrom);
    $sheet->setCellValue('E'.$i, $model->dateto);
    $sheet->setCellValue('F'.$i, $model->verdatee);
    $sheet->setCellValue('G'.$i, $model->kakitangan->adminpos->dept->shortname);
    $sheet->setCellValue('H'.$i, $model->kakitangan->CONm);
    $sheet->setCellValue('I'.$i, $model->nama_lawatan);
    $sheet->setCellValue('J'.$i, $model->nama_tempat);
    $sheet->setCellValue('K'.$i, $model->kod_peruntukan_cn);
    $sheet->setCellValue('L'.$i, $model->jumlah3);
    $sheet->setCellValue('N'.$i, $model->status);


//    
    $sheet->getStyle('N'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':N'.$i)->applyFromArray($content);
    $sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $i++;
    $no++;
}
foreach(range('A','N') as $columnID) {
    if($columnID != 'N'){
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
    $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('N')->setWidth(80);
$writer = new Xlsx($phpExcel);
$writer->save("Senarai Rekod Permohonan Bertugas Rasmi Di Luar Negara.xlsx");
Yii::$app->response->redirect(['Senarai Rekod Permohonan Bertugas Rasmi Di Luar Negara.xlsx']);
?>