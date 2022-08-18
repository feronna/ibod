<?php

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use app\models\cuti\TblRecords;
use app\models\kontrak\Kontrak;

error_reporting(0);
$no = 1;
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

//open excel
if ($no1 == 1) {
    $phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads-kontrak/template-pentadbiran.xlsx');
} else {
    $phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads-kontrak/data-kontrakpentadbiran.xlsx');
}


$sheet = $phpExcel->getSheetByName('main');
$kehadiran = $phpExcel->getSheetByName('kehadiran');
$lnpt = $phpExcel->getSheetByName('lnpt');

if ($no1 == 1) {

    foreach (range('A', 'Z') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
        $kehadiran->getColumnDimension($columnID)->setAutoSize(true);
        $lnpt->getColumnDimension($columnID)->setAutoSize(true);
        $sheet->getColumnDimension('A' . $columnID)->setAutoSize(true);
    }
    $sheet->setCellValue('B1', 'PERMOHONAN PELANTIKAN SEMULA KONTRAK KAKITANGAN PENTADBIRAN SESI ' . $sesi->sesi . ' ' . $tahun);

    //header tahun lnpt
    $sheet->setCellValue('K5', $tahun - 3);
    $sheet->setCellValue('L5', $tahun - 2);
    $sheet->setCellValue('M5', $tahun - 1);

    //header kehadiran
    $kehadiran->setCellValue('E4', date('Y') - 2);
    $kehadiran->setCellValue('H4', date('Y') - 1);
    $kehadiran->setCellValue('K4', date('Y'));

    $kehadiran->setCellValue('O4', date('Y') - 2);
    $kehadiran->setCellValue('R4', date('Y') - 1);
    $kehadiran->setCellValue('U4', date('Y'));

    //header cuti
    $sheet->setCellValue('P4', date('Y') - 2);
    $sheet->setCellValue('R4', date('Y') - 1);
    $sheet->setCellValue('T4', date('Y'));

    //header prestasi stars
    $sheet->setCellValue('AD5', 'PRESTASI STARS');
    $sheet->setCellValue('AE5', 'KATEGORI LNPT');



    //header lnpt
    $c = 'E';
    for ($i = $tahunlnpt; $i < date('Y'); $i++) {
        $lnpt->setCellValue($c . '5', $i);
        $c++;
    }
    $lnpt->mergeCells('E3:' . $c . '4');
    $lnpt->getStyle('E5:' . $c . '5')->applyFromArray($secondheader);

    $sheet->mergeCells('AC3:AC5');
    $sheet->setCellValue('AC3', 'ulasan ketua jabatan');
    $lnpt->getStyle('AC3:AC5')->applyFromArray($firstheader);
}

$i = 5 + $no1;

foreach ($model as $model) {
    if ($no >= $no1 && $no <= ($no1 + 4)) {
        $sheet->setCellValue('A' . $i, $no);
        $kehadiran->setCellValue('A' . $i, $no);
        $lnpt->setCellValue('A' . $i, $no);

        //maklumat kakitangan
        $sheet->setCellValue('B' . $i, $model->kakitangan->CONm);
        $sheet->setCellValue('C' . $i, $model->icno);
        $sheet->setCellValue('D' . $i, $model->kakitangan->COOldID);
        $kehadiran->setCellValue('B' . $i, $model->kakitangan->CONm);
        $kehadiran->setCellValue('C' . $i, $model->icno);
        $kehadiran->setCellValue('D' . $i, $model->kakitangan->COOldID);
        $lnpt->setCellValue('B' . $i, $model->kakitangan->CONm);
        $lnpt->setCellValue('C' . $i, $model->icno);
        $lnpt->setCellValue('D' . $i, $model->kakitangan->COOldID);

        //maklumat perkhidmatan
        $sheet->setCellValue('E' . $i, $model->tempoh);
        $sheet->setCellValue('F' . $i, $model->kakitangan->startDateLantik);
        $sheet->setCellValue('G' . $i, $model->kakitangan->endDateLantik);
        $sheet->setCellValue('H' . $i, $model->kakitangan->jawatan->gred);
        $sheet->setCellValue('I' . $i, $model->kakitangan->jawatan->nama);
        $sheet->setCellValue('J' . $i, $model->kakitangan->department->fullname);

        //lnpt
        $c = 'E';
        for ($t = $tahunlnpt; $t < date('Y'); $t++) {
            $lnpt->setCellValue($c . $i, $model->markahlnpt($t));
            $c++;
        }
        $sheet->setCellValue('K' . $i, $model->markahlnpt($tahun - 3));
        $sheet->setCellValue('L' . $i, $model->markahlnpt($tahun - 2));
        $sheet->setCellValue('M' . $i, $model->markahlnpt($tahun - 1));

        //perakuan
        $sheet->setCellValue('N' . $i, $model->kelayakantempohpentadbiran);
        $sheet->setCellValue('O' . $i, $model->tempoh_l_jfpiu);

        //kehadiran
        $kehadiran->setCellValue('E' . $i, $model->kehadiran(date('Y') - 2, 1, 'approve'));
        $kehadiran->setCellValue('F' . $i, $model->kehadiran(date('Y') - 2, 3, 'approve'));
        $kehadiran->setCellValue('G' . $i, $model->kehadiran(date('Y') - 2, 4, 'approve'));

        $kehadiran->setCellValue('H' . $i, $model->kehadiran(date('Y') - 1, 1, 'approve'));
        $kehadiran->setCellValue('I' . $i, $model->kehadiran(date('Y') - 1, 3, 'approve'));
        $kehadiran->setCellValue('J' . $i, $model->kehadiran(date('Y') - 1, 4, 'approve'));

        $kehadiran->setCellValue('K' . $i, $model->kehadiran(date('Y'), 1, 'approve'));
        $kehadiran->setCellValue('L' . $i, $model->kehadiran(date('Y'), 3, 'approve'));
        $kehadiran->setCellValue('M' . $i, $model->kehadiran(date('Y'), 4, 'approve'));

        $kehadiran->setCellValue('N' . $i, '=(E' . $i . ')+(F' . $i . ')+(G' . $i . ')+(H' . $i . ')+(I' . $i . ')+(J' . $i . ')+(K' . $i . ')+(L' . $i . ')+(M' . $i . ')');

        $kehadiran->setCellValue('O' . $i, $model->kehadiran(date('Y') - 2, 1, 'not'));
        $kehadiran->setCellValue('P' . $i, $model->kehadiran(date('Y') - 2, 3, 'not'));
        $kehadiran->setCellValue('Q' . $i, $model->kehadiran(date('Y') - 2, 4, 'not'));

        $kehadiran->setCellValue('R' . $i, $model->kehadiran(date('Y') - 1, 1, 'not'));
        $kehadiran->setCellValue('S' . $i, $model->kehadiran(date('Y') - 1, 3, 'not'));
        $kehadiran->setCellValue('T' . $i, $model->kehadiran(date('Y') - 1, 4, 'not'));

        $kehadiran->setCellValue('U' . $i, $model->kehadiran(date('Y'), 1, 'not'));
        $kehadiran->setCellValue('V' . $i, $model->kehadiran(date('Y'), 3, 'not'));
        $kehadiran->setCellValue('W' . $i, $model->kehadiran(date('Y'), 4, 'not'));

        $kehadiran->setCellValue('X' . $i, '=(P' . $i . ')+(Q' . $i . ')+(R' . $i . ')+(S' . $i . ')+(T' . $i . ')+(U' . $i . ')+(V' . $i . ')+(W' . $i . ')+(O' . $i . ')');

        //value cuti
        $sheet->setCellValue('P' . $i, TblRecords::usedcutibyyear($model->icno, 1, date('Y') - 2));
        $sheet->setCellValue('Q' . $i, TblRecords::usedcutibyyear($model->icno, 20, date('Y') - 2));
        $sheet->setCellValue('R' . $i, TblRecords::usedcutibyyear($model->icno, 1, date('Y') - 1));
        $sheet->setCellValue('S' . $i, TblRecords::usedcutibyyear($model->icno, 20, date('Y') - 1));
        $sheet->setCellValue('T' . $i, TblRecords::usedcutibyyear($model->icno, 1, date('Y')));
        $sheet->setCellValue('U' . $i, TblRecords::usedcutibyyear($model->icno, 20, date('Y')));
        $sheet->setCellValue('V' . $i, '=(P' . $i . ')+(Q' . $i . ')+(R' . $i . ')+(S' . $i . ')+(T' . $i . ')+(U' . $i . ')');
        //gaji
        $sheet->setCellValue('W' . $i, $model->gajipokok);
        $sheet->setCellValue('X' . $i, $model->biw);
        $sheet->setCellValue('Y' . $i, $model->itka);
        $sheet->setCellValue('Z' . $i, $model->itp);
        $sheet->setCellValue('AA' . $i, $model->bipk);

        //Bos Mail minta tmbh ni dlm excel - miji
        $sheet->setCellValue('AD' . $i, $model->kategoriStars);
        $sheet->setCellValue('AE' . $i, $model->kategoriLnpt);

        //    $lppid = \app\models\lppums\TblMain::find()->where(['PYD' => $model->icno, 'tahun' => '2020'])->one()->lpp_id;
        //    if(app\models\lppums\TblSkt::find()->where(['lpp_id' => $lppid])->andWhere(['skt_status' => null])->exists()){
        //        $sheet->setCellValue('AB'.$i, 'Yes');
        //    }else{
        //        $sheet->setCellValue('AB'.$i, 'No');
        //    }

        $sheet->setCellValue('AC' . $i, $model->ulasan_jfpiu);
        $sheet->getStyle('A' . $i . ':AC' . $i)->applyFromArray($content);
        $kehadiran->getStyle('A' . $i . ':X' . $i)->applyFromArray($content);
        $lnpt->getStyle('A' . $i . ':' . $c . $i)->applyFromArray($content);
        $sheet->getStyle('AC' . $i)->getAlignment()->setWrapText(true);
        $sheet->getStyle('C' . $i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
        $kehadiran->getStyle('C' . $i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
        $lnpt->getStyle('C' . $i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
        $i++;
    }
    $no++;
}
$writer = new Xlsx($phpExcel);
$writer->save('uploads-kontrak/data-kontrakpentadbiran.xlsx');
