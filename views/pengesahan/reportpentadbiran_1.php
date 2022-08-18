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
$sheet->mergeCells("A1:S1");
$sheet->mergeCells("A2:O2");
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
$sheet->mergeCells("M3:O3");
$sheet->mergeCells("M4:M4");
$sheet->mergeCells("N4:N4");
$sheet->mergeCells("O4:O4");
$sheet->mergeCells("P3:P4");
$sheet->mergeCells("Q3:Q4");
$sheet->mergeCells("R3:R4");
$sheet->mergeCells("S3:S4");

$sheet->getStyle('A1:S1')->applyFromArray($thirdheader);
$sheet->getStyle('A2:S2')->applyFromArray($firstheader);
$sheet->getStyle('A3:S3')->applyFromArray($secondheader);
$sheet->getStyle('A4:S4')->applyFromArray($secondheader);

$sheet->setCellValue('A1', 'PELAKSANA 1');;
$sheet->setCellValue('A2', 'MAKLUMAT PERKHIDMATAN');;
$sheet->setCellValue('P2', 'PERAKUAN KETUA JABATAN');
$sheet->setCellValue('S2', 'KEPUTUSAN MESYUARAT');
$sheet->setCellValue('A3', 'BIL');
$sheet->setCellValue('B3', 'NAMA');
$sheet->setCellValue('C3', 'UMS(PER)');
$sheet->setCellValue('D3', 'JAWATAN');
$sheet->setCellValue('E3', 'GRED');
$sheet->setCellValue('F3', 'JAFPIB');
$sheet->setCellValue('G3', 'TARIKH LANTIKAN TETAP');
$sheet->setCellValue('H3', 'TEMPOH PERKHIDMATAN');
$sheet->setCellValue('I3', 'BM(SPM)');
$sheet->setCellValue('J3', 'LATARBELAKANG PENDIDIKAN');
$sheet->setCellValue('K3', 'INDUKSI/PTM');
$sheet->setCellValue('L3', 'STATUS TATATERTIB');
$sheet->setCellValue('M3', 'MARKAH PRESTASI(%)');
$sheet->setCellValue('M4', date('Y')-3);
$sheet->setCellValue('N4', date('Y')-2);
$sheet->setCellValue('O4', date('Y')-1);
$sheet->setCellValue('P3', 'STATUS');
$sheet->setCellValue('Q3', 'ULASAN');
$sheet->setCellValue('R3', 'CADANGAN TEMPOH MEMOHON BALIK');
$sheet->setCellValue('S3', 'CATATAN');

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
    $sheet->setCellValue('I'.$i, $model->gredbm->grade->grade);
    $sheet->setCellValue('J'.$i, $model->kakitangan->displayPendidikan);
    $sheet->setCellValue('K'.$i, $model->tarikhLulusPtm);
    $sheet->setCellValue('L'.$i, $model->status_tatatertib);
    $sheet->setCellValue('M'.$i, $model->markahkeseluruhan3->markah_PP);
    $sheet->setCellValue('N'.$i, $model->markahkeseluruhan2->markah_PP);
    $sheet->setCellValue('O'.$i, $model->markahkeseluruhan1->markah_PP);
    $sheet->setCellValue('P'.$i, $model->status_jfpiu);
    $sheet->setCellValue('Q'.$i, $model->ulasan_jfpiu);
    $sheet->setCellValue('R'.$i, $model->tempoh_l_jfpiu);
    $sheet->setCellValue('S'.$i, $model->catatan);

//    
    $sheet->getStyle('R'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':S'.$i)->applyFromArray($content);
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

$sheet->getColumnDimension('R')->setWidth(40);
$writer = new Xlsx($spreadsheet);
$writer->save("RINGKASAN PDP (PENTADBIRAN).xlsx");
Yii::$app->response->redirect(['RINGKASAN PDP (PENTADBIRAN).xlsx']);
?>
<a href="<?php echo Url::to('@web/'.'hello worldsssssss.xlsx', true); ?>" target="_blank" ><i class="fa fa-download"></i> Surat Penerimaan Tawaran</a><br>
