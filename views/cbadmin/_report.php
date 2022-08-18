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
$sheet->mergeCells("A1:Z1");
$sheet->mergeCells("A2:O2");
$sheet->mergeCells("P2:R2");
$sheet->mergeCells("S2:Z2");
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
$sheet->mergeCells("N3:N4");
$sheet->mergeCells("O3:O4");

$sheet->getStyle('A1:O1')->applyFromArray($thirdheader);
$sheet->getStyle('A2:O2')->applyFromArray($firstheader);
$sheet->getStyle('A3:O3')->applyFromArray($secondheader);
$sheet->getStyle('A3:O3')->applyFromArray($secondheader);
$sheet->getStyle('A4:O4')->applyFromArray($secondheader);

$sheet->setCellValue('A1', 'AKADEMIK');;
$sheet->setCellValue('A2', 'MAKLUMAT PERKHIDMATAN KAKITANGAN');;
$sheet->setCellValue('A3', 'BIL');
$sheet->setCellValue('B3', 'NAMA');
$sheet->setCellValue('C3', 'UMUR');
$sheet->setCellValue('D3', 'NO. KP');
$sheet->setCellValue('E3', 'UMS(PER)');
$sheet->setCellValue('F3', 'GRED JAWATAN');
$sheet->setCellValue('G3', 'JFPIU');
$sheet->setCellValue('H3', 'EMEL');
$sheet->setCellValue('I3', 'PERINGKAT PENGAJIAN');
$sheet->setCellValue('J3', 'UNIVERSITI / PENEMPATAN');
$sheet->setCellValue('K3', 'NEGARA');
$sheet->setCellValue('L3', 'BIDANG');
$sheet->setCellValue('M3', 'TAJAAN');
$sheet->setCellValue('N3', 'MULA');
$sheet->setCellValue('O3', 'TAMAT');



$i=5;
$no=1;
foreach($model as $model){
    $sheet->setCellValue('A'.$i, $no);
    $sheet->setCellValue('B'.$i, $model->kakitangan->CONm);
    $sheet->setCellValue('C'.$i, $model->kakitangan->umur);
    $sheet->setCellValue('D'.$i, $model->kakitangan->ICNO);
    $sheet->setCellValue('E'.$i, $model->kakitangan->COOldID);
    $sheet->setCellValue('F'.$i, $model->kakitangan->jawatan->gred);
    $sheet->setCellValue('G'.$i, $model->kakitangan->department->fullname);
    $sheet->setCellValue('H'.$i, $model->kakitangan->department->fullname);
    $sheet->setCellValue('I'.$i, $model->study2->pendidikanTertinggi->HighestEduLevel);
    $sheet->setCellValue('J'.$i, $model->study2->InstNm);
    $sheet->setCellValue('K'.$i, $model->study2->negara->Country);
    $sheet->setCellValue('L'.$i, $model->study2->major->MajorMinor);
    $sheet->setCellValue('M'.$i, $model->sponsor->nama_tajaan);
    $sheet->setCellValue('N'.$i, $model->study2->tarikhmula);
    $sheet->setCellValue('O'.$i, $model->study2->tarikhtamat);

    
  
//    
    $sheet->getStyle('R'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':O'.$i)->applyFromArray($content);
    $sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $i++;
    $no++;
}
foreach(range('A','O') as $columnID) {
    if($columnID != 'R'){
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }
    $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
}

$sheet->getColumnDimension('R')->setWidth(80);
$writer = new Xlsx($spreadsheet);
$writer->save("SENARAI LAPORAN PERMOHONAN CUTI BELAJAR.xlsx");
Yii::$app->response->redirect(['SENARAI LAPORAN PERMOHONAN CUTI BELAJAR.xlsx']);
?>
<a href="<?php echo Url::to('@web/'.'hello worldsssssss.xlsx', true); ?>" target="_blank" ><i class="fa fa-download"></i> Surat Penerimaan Tawaran</a><br>
