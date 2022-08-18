
<?php
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
error_reporting(0);
$no=1;
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

    if($row ==0){
    $phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads-kontrak/template-akademik.xlsx');
    }
    else{
        $phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads-kontrak/data-kontrakakademik.xlsx');
    }
    $sheet = $phpExcel->getActiveSheet();
    foreach(range('A','Z') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    if($columnID != 'P' && $columnID != 'S'){
    $sheet->getColumnDimension('A'.$columnID)->setAutoSize(true);
    }
}
$sheet->setCellValue('N5', date('Y')-3);
$sheet->setCellValue('O5', date('Y')-2);
$sheet->setCellValue('P5', date('Y')-1);
$sheet->setCellValue('AG3', 'Penyeliaan (Complete)');
$sheet->getColumnDimension('AP')->setWidth(80);
    $i=6+$row; 
//    foreach($model as $model){
//    if($no==$row){
    $sheet->setCellValue('A'.$i, $row+1);
    $sheet->setCellValue('B'.$i, $model->kakitangan->CONm);
    $sheet->setCellValue('C'.$i, $model->icno);
    $sheet->setCellValue('D'.$i, $model->kakitangan->COOldID);
    $sheet->setCellValue('E'.$i, $model->kakitangan->umur);
    $sheet->setCellValue('F'.$i, $model->kakitangan->displayPendidikan);
    $sheet->setCellValue('G'.$i, $model->tempoh);
    $sheet->setCellValue('H'.$i, date_format(date_create($model->kakitangan->startDateLantik), 'd/m/Y'));
    $sheet->setCellValue('I'.$i, date_format(date_create($model->kakitangan->endDateLantik), 'd/m/Y'));
    $sheet->setCellValue('J'.$i, $model->tempohkontraksemasa);
    $sheet->setCellValue('K'.$i, $model->kakitangan->jawatan->gred);
    $sheet->setCellValue('L'.$i, $model->kakitangan->jawatan->nama);
    $sheet->setCellValue('M'.$i, $model->kakitangan->department->fullname);
    $sheet->setCellValue('N'.$i, $model->markahlnpt(date('Y')-3));
    $sheet->setCellValue('O'.$i, $model->markahlnpt(date('Y')-2));
    $sheet->setCellValue('P'.$i, $model->markahlnpt(date('Y')-1));
    $sheet->setCellValue('Q'.$i, '=(N'.$i.'*0.2)+(O'.$i.'*0.35)+(P'.$i.'*0.45)');
    $sheet->setCellValue('R'.$i, $model->kelayakantempohakademik);
    $sheet->setCellValue('S'.$i, $model->jumlahKreditMengajar);
    $sheet->setCellValue('T'.$i, $model->jumlahPelajar);
    $sheet->setCellValue('U'.$i, $model->jumlahGeranPenyelidikUtama);
    $sheet->setCellValue('V'.$i, $model->jumlahRmPenyelidikUtama);
    $sheet->setCellValue('W'.$i, $model->jumlahGeranPenyelidikBersama);
    $sheet->setCellValue('X'.$i, $model->jumlahRmPenyelidikBersama);
    $sheet->setCellValue('Y'.$i, $model->jumlahJurnal);
    $sheet->setCellValue('Z'.$i, $model->jumlahBuku);
    $sheet->setCellValue('AA'.$i, $model->jumlahBabDalamBuku);
    $sheet->setCellValue('AB'.$i, $model->jumlahPenerbitanPenulisUtama);
    $sheet->setCellValue('AC'.$i, $model->hindex->scopus_hindex);
    $sheet->setCellValue('AD'.$i, $model->hindex->scopus_citation);
    $sheet->setCellValue('AE'.$i, $model->hindex->googlescholar_hindex);
    $sheet->setCellValue('AF'.$i, $model->hindex->googlescholar_citation);
    $sheet->setCellValue('AG'.$i, count(array_filter($model->penyeliaan, function ($var) {
                        return ($var['LevelPengajian'] == 'PHD' && $var['StatusPengajianBI'] == 'STUDY COMPLETED');
                        })));
    //ongoing
                      
    $sheet->setCellValue('AH'.$i, count(array_count_values(array_column((array_filter($model->penyeliaan, function ($var) use ($model){
                        return ($var['LevelPengajian'] == 'PHD' && in_array($var['StatusPengajianBI'], array('ACTIVE',
'ACTIVE (NOTICE SUBMIT THESIS)',
'ACTIVE (THESIS CORRECTION)',
'ACTIVE (WAITING FOR VIVA)',
'ACTIVE(EXTEND (I))',
'ACTIVE(EXTEND (II))',
'ACTIVE(EXTEND (III))',
'ACTIVE(EXTEND (IV))',
'ACTIVE(EXTEND (V))',
'ACTIVE(EXTEND (VI))',
'EXPECTED TO GRADUATE'
)) &&
  (substr($var['KodSesi_Sem'], -9) > $model->sesimulakontrak || (substr($var['KodSesi_Sem'], -9) == $model->sesimulakontrak && substr($var['KodSesi_Sem'], 0,1) >= $model->semmulakontrak))
);
                        })),'Nomatrik'))));
    $sheet->setCellValue('AI'.$i, count(array_filter($model->penyeliaan, function ($var) {
                        return ($var['LevelPengajian'] == 'MASTER' && $var['StatusPengajianBI'] == 'STUDY COMPLETED');
                        })));
    //ongoing
    $sheet->setCellValue('AJ'.$i, count(array_count_values(array_column((array_filter($model->penyeliaan, function ($var) use ($model){
                        return ($var['LevelPengajian'] == 'MASTER' && in_array($var['StatusPengajianBI'], array('ACTIVE',
'ACTIVE (NOTICE SUBMIT THESIS)',
'ACTIVE (THESIS CORRECTION)',
'ACTIVE (WAITING FOR VIVA)',
'ACTIVE(EXTEND (I))',
'ACTIVE(EXTEND (II))',
'ACTIVE(EXTEND (III))',
'ACTIVE(EXTEND (IV))',
'ACTIVE(EXTEND (V))',
'ACTIVE(EXTEND (VI))',
'EXPECTED TO GRADUATE'
)) &&
  (substr($var['KodSesi_Sem'], -9) > $model->sesimulakontrak || (substr($var['KodSesi_Sem'], -9) == $model->sesimulakontrak && substr($var['KodSesi_Sem'], 0,1) >= $model->semmulakontrak))
);
                        })),'Nomatrik'))));                   
    $sheet->setCellValue('AK'.$i, $model->jumlahPerundingan);
    $sheet->setCellValue('AL'.$i, $model->gajipokok);
    $sheet->setCellValue('AM'.$i, $model->jumlahelaun);
    $sheet->setCellValue('AN'.$i, $model->tempoh_l_pp);
    $sheet->setCellValue('AO'.$i, $model->cadangan_jawatan_ver);
    $sheet->setCellValue('AP'.$i, $model->ulasan_pp);
    $sheet->setCellValue('AQ'.$i, $model->tempoh_l_jfpiu);
    $sheet->setCellValue('AR'.$i, $model->cadangan_jawatan);
    $sheet->setCellValue('AS'.$i, $model->ulasan_jfpiu);
//    
    
    $sheet->getStyle('G2')->getAlignment()->setWrapText(true);
    $sheet->getStyle('AP'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('AS'.$i)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$i.':AS'.$i)->applyFromArray($content);
    $sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $sheet->getStyle('Q'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_00);
    $sheet->getStyle('V'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $sheet->getStyle('X'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $sheet->getStyle('AL'.$i.':AM'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    $i++;
//    }
//    $no++;
//    }
    $writer = new Xlsx($phpExcel);
    $writer->save('uploads-kontrak/data-kontrakakademik.xlsx');