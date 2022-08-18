<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;

error_reporting(0);

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$content = [
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        ],
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
];

 
$phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads-cv/template-laporan-DS52.xlsx');

$sheet = $phpExcel->getActiveSheet();
foreach (range('A', 'AQ') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    $sheet->getColumnDimension('A' . $columnID)->setAutoSize(true);
}

$i = 7;
$no = 1;
foreach ($model as $model) {
    $sheet->setCellValue('A' . $i, $no);
    $sheet->setCellValue('B' . $i, $model->CONm);
    $sheet->setCellValue('C' . $i, $model->umur);
    $sheet->setCellValue('D' . $i, $model->jawatan->gred);
    $sheet->setCellValue('E' . $i, $model->departmentHakiki->shortname);
    $sheet->setCellValue('F' . $i, $model->department->shortname);
    $sheet->setCellValue('G' . $i, $model->markahlnptCV(1, 'Markah'));
    $sheet->setCellValue('H' . $i, $model->markahlnptCV(2, 'Markah'));
    $sheet->setCellValue('I' . $i, $model->markahlnptCV(3, 'Markah'));
    
    if (!empty($model->markahlnptCV(3, 'Tahun'))) {
            $purataLNPT = number_format(($model->markahlnptCV(1, 'Markah') * 0.2) + ($model->markahlnptCV(2, 'Markah') * 0.35) + ($model->markahlnptCV(3, 'Markah') * 0.45));
        } else if (!empty($model->markahlnptCV(2, 'Tahun')) ) { 
            $purataLNPT = number_format(($model->markahlnptCV(1, 'Markah') * 0.6) + ($model->markahlnptCV(2, 'Markah') * 0.4));
        } else {
            $purataLNPT = number_format(($model->markahlnptCV(1, 'Markah') * 1));
        } 

        $sheet->setCellValue('J' . $i, $purataLNPT);


        $sheet->setCellValue('K' . $i, $model->servPeriodPermanent);


        $sheet->setCellValue('L' . $i, $model->servPeriodCPositionBI);

        if ($model->statLantikan == 1) {//tetap
            $dateLantik = $model->SandanganCTetap ? $model->getTarikh($model->SandanganCTetap->start_date) : '-';
        } else {
            $dateLantik = $model->sandanganCKontrak ? $model->getTarikh($model->sandanganCKontrak->start_date) : '-';
        }

        $sheet->setCellValue('M' . $i, $dateLantik);

        $cvapplied = app\models\cv\TblPermohonan::findOne(['ICNO' => $model->ICNO, 'ads_id' => $gred]);
        $kjstatus = '';
        $kjulasan = '';
        if ($cvapplied) {
            if ($cvapplied->kj_status == 1) {
                $kjstatus = 'YA';
                $kjulasan = $cvapplied->kj_ulasan;
            }
        }
        
        $sheet->setCellValue('N' . $i, $kjstatus);
            $sheet->setCellValue('O' . $i, $kjulasan);


            $sheet->setCellValue('P' . $i, ($model->confirmDt ? $model->confirmDt->ConfirmStatusStDt : '')); 
            
            $sheet->setCellValue('Q' . $i, $purataLNPT);

            $sheet->setCellValue('R' . $i, $kjstatus);

            $statusLantikan = 'TIDAK';
            if ($model->statLantikan == 1) {
                $statusLantikan = 'YA';
            }

            $sheet->setCellValue('S' . $i, $statusLantikan);

            $tatatertib = '';
            if (($model->usercv ? $model->usercv->tatatertib_status : '') == 1) {
                $tatatertib = 'YA';
            }

            $sheet->setCellValue('T' . $i, $tatatertib);

            $phd = \app\models\hronline\Tblpendidikan::find()
                            ->where(['ICNO' => $model->ICNO])
                            ->andWhere(['HighestEduLevelCd' => 1])
                            ->orderBy(['ConfermentDt' => SORT_ASC])->one();

            $statusphd = '';
            $yearphd = '';
            $datephd = '';
            $startphd = '';
            if ($phd) {
                $statusphd = 'YA';
                $yearphd = date('Y', strtotime($phd->ConfermentDt));
                $datephd = $phd->ConfermentDt;
                $startphd = $phd->StartEduDt;
            }

            $sheet->setCellValue('U' . $i, $statusphd);
             

            $leadresearch = count(array_filter($model->researchMulaLantikan, function ($var) {
                            return ($var['Membership'] == 'Leader' && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
                        }));

            $memberresearch = count(array_filter($model->researchMulaLantikan, function ($var) {
                            return ($var['Membership'] == 'Member' && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
                        }));

            $statusleadresearch = '';
            if ($leadresearch >= 1) {
                $statusleadresearch = 'YA';
            }

            $sheet->setCellValue('V' . $i, $statusleadresearch);

            $leadpublication = count(array_filter($model->publicationStartPhd, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article' && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                    }));

            $statusresearchPhd = '';
            if ($leadpublication >= 1) {
                $statusresearchPhd = 'YA';
            }

            $sheet->setCellValue('W' . $i, $statusresearchPhd);
            $sheet->setCellValue('X' . $i, $yearphd);
            $sheet->setCellValue('Y' . $i, $startphd);
            $sheet->setCellValue('Z' . $i, $datephd);
            $sheet->setCellValue('AA' . $i, $model->dateStartLantikanPertama());


            $sheet->setCellValue('AB' . $i, $leadresearch);
            $sheet->setCellValue('AC' . $i, array_sum(array_column(array_filter($model->researchMulaLantikan, function ($var) {
                                        return (($var['Membership'] == 'Leader') && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
                                    }), 'Amount')));
            $sheet->setCellValue('AD' . $i, $memberresearch);
            $sheet->setCellValue('AE' . $i, array_sum(array_column(array_filter($model->researchMulaLantikan, function ($var) {
                                        return (($var['Membership'] == 'Member') && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
                                    }), 'Amount')));
            $sheet->setCellValue('AF' . $i, array_sum(array_column(array_filter($model->researchMulaLantikan, function ($var) {
                                        return (($var['Membership'] == 'Leader' || $var['Membership'] == 'Member') && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
                                    }), 'Amount')));


            $sheet->setCellValue('AG' . $i, (count(array_filter($model->publicationStartPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            })) + count(array_filter($model->publicationStartPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            }))));
            $sheet->setCellValue('AH' . $i, count(array_filter($model->publicationStartPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            })));
            $sheet->setCellValue('AI' . $i, count(array_filter($model->publicationStartPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'||$var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                            })));
            $sheet->setCellValue('AJ' . $i, count(array_filter($model->publicationStartPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Collaborative Author'));
                            })));
            $sheet->setCellValue('AK' . $i, count(array_filter($model->publicationStartPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            })));
            $sheet->setCellValue('AL' . $i, count(array_filter($model->publicationStartPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'||$var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                            })));
            $sheet->setCellValue('AM' . $i, count(array_filter($model->publicationStartPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Collaborative Author'));
                            })));

            $sheet->setCellValue('AN' . $i, $model->scopus->h_index);
            $sheet->setCellValue('AO' . $i, $model->googleScholar->h_index);
            $sheet->setCellValue('AP' . $i, $model->scopus->Citations);
            $sheet->setCellValue('AQ' . $i, $model->googleScholar->Citations);

    $i++;
    $no++;
}

$writer = new Xlsx($phpExcel);
$writer->save('uploads-cv/laporan-DS52.xlsx');
Yii::$app->response->redirect(['uploads-cv/laporan-DS52.xlsx']);
