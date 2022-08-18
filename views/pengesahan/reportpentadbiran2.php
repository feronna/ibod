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
        $phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads/pengesahan/template-pengesahan-pentadbiran.xlsx');
//    }
    $sheet = $phpExcel->getActiveSheet();
    foreach(range('A','R') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('R')->setWidth(80);
$i=5;
$no=1;
foreach($model as $model){
    $sheet->setCellValue('A'.$i, $no);
    $sheet->setCellValue('B'.$i, $model->kakitangan->CONm);
    $sheet->setCellValue('C'.$i, $model->kakitangan->COOldID);
    $sheet->setCellValue('D'.$i, $model->kakitangan->jawatan->nama);
    $sheet->setCellValue('E'.$i, $model->kakitangan->jawatan->gred);
    $sheet->setCellValue('F'.$i, $model->kakitangan->department->fullname);
    $sheet->setCellValue('G'.$i, $model->startDateLantik);
    $sheet->setCellValue('H'.$i, $model->kakitangan->servPeriodPermanent);
    $sheet->setCellValue('I'.$i, $model->gredpmrbm->grade->grade);
    $sheet->setCellValue('J'.$i, $model->gredspmbm->grade->grade);
    $sheet->setCellValue('K'.$i, $model->kakitangan->displayPendidikan);
    $sheet->setCellValue('L'.$i, $model->tarikhLulusPtm);
    $sheet->setCellValue('M'.$i, $model->status_tatatertib);
    $sheet->setCellValue('N'.$i, $model->puratalnptpentadbiran);
//    $sheet->setCellValue('M'.$i, $model->markahkeseluruhan3->markah_PP);
//    $sheet->setCellValue('N'.$i, $model->markahkeseluruhan2->markah_PP);
//    $sheet->setCellValue('O'.$i, $model->markahkeseluruhan1->markah_PP);
    $sheet->setCellValue('O'.$i, $model->status_jfpiu);
    $sheet->setCellValue('P'.$i, $model->ulasan_jfpiu);
    $sheet->setCellValue('Q'.$i, $model->tempoh_l_jfpiu);
    $sheet->setCellValue('R'.$i, $model->catatan);

//    
    $sheet->getStyle('R'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':R'.$i)->applyFromArray($content);
    $sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $i++;
    $no++;
}
foreach(range('A','R') as $columnID) {
    if($columnID != 'R'){
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
    $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('R')->setWidth(40);
$writer = new Xlsx($phpExcel);
$writer->save("RINGKASAN PDP (PENTADBIRAN).xlsx");
Yii::$app->response->redirect(['RINGKASAN PDP (PENTADBIRAN).xlsx']);
?>
<a href="<?php echo Url::to('@web/'.'hello worldsssssss.xlsx', true); ?>" target="_blank" ><i class="fa fa-download"></i> Surat Penerimaan Tawaran</a><br>
