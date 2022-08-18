<?php

error_reporting(0);

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$no = 1;
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

if ($gred != 13) {
    if ($row == 1) {
        $phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads-cv/template-laporan.xlsx');
    } else {
        $phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads-cv/laporan.xlsx');
    }
} else {
    if ($row == 1) {
        $phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads-cv/template-laporan-DS52.xlsx');
    } else {
        $phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads-cv/laporan-DS52.xlsx');
    }
}
if ($gred == 13) {
    $totalColumn = 'AQ';
}else{
    $totalColumn = 'CC';
}

$sheet = $phpExcel->getActiveSheet();
foreach (range('A', $totalColumn) as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    $sheet->getColumnDimension('A' . $columnID)->setAutoSize(true);
}
$i = 6 + $row;
$sheet->setCellValue('G6', 'Tahun 1');
$sheet->setCellValue('H6', 'Tahun 2');
$sheet->setCellValue('I6', 'Tahun 3');
foreach ($model as $model) {
    if ($no == $row) {
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
        } else if (!empty($model->markahlnptCV(2, 'Tahun'))) { 
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

        if ($gred == 13) {

            $sheet->setCellValue('N' . $i, $kjstatus);
            $sheet->setCellValue('O' . $i, $kjulasan);


            $sheet->setCellValue('P' . $i, ($model->confirmDt ? 'YA' : 'TIDAK'));

            if (!empty($model->markahlnptCV(3, 'Tahun'))) {
                $avglnpt = number_format(($model->markahlnptCV(1, 'Markah') * 0.2) + ($model->markahlnptCV(2, 'Markah') * 0.35) + ($model->markahlnptCV(3, 'Markah') * 0.45));
            } else {
                $avglnpt = number_format(($model->markahlnptCV(1, 'Markah') * 0.6) + ($model->markahlnptCV(2, 'Markah') * 0.4));
            }

            $lnpt = '';
            if ($avglnpt >= 80) {
                $lnpt = 'YA';
            }

            $sheet->setCellValue('Q' . $i, $lnpt);

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
            if ($phd) {
                $statusphd = 'YA';
                $yearphd = date('Y', strtotime($phd->ConfermentDt));
                $datephd = $phd->ConfermentDt;
            }

            $sheet->setCellValue('U' . $i, $statusphd);
            $skim = \app\models\hronline\GredJawatan::findOne(['id' => $gred]);
            $tempoh = '';
            if ($model->getServPeriod($skim->gred, 'Kriteria') >= 1) {
                $tempoh = 'YA';
            }
            $sheet->setCellValue('V' . $i, $tempoh);

            $leadresearch = count(array_filter($model->researchCompletedAfterPhd, function ($var) {
                        return ($var['Membership'] == 'Leader' && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
                    }));

            $memberresearch = count(array_filter($model->researchCompletedAfterPhd, function ($var) {
                        return ($var['Membership'] == 'Member' && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
                    }));

            $statusleadresearch = '';
            if ($leadresearch >= 1) {
                $statusleadresearch = 'YA';
            }

            $sheet->setCellValue('W' . $i, $statusleadresearch);

            $leadpublication = count(array_filter($model->publicationCompletedAfterPhd, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article' && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                    }));

            $statusresearchPhd = '';
            if ($leadpublication >= 1) {
                $statusresearchPhd = 'YA';
            }

            $sheet->setCellValue('X' . $i, $statusresearchPhd);
            $sheet->setCellValue('Y' . $i, $yearphd);
            $sheet->setCellValue('Z' . $i, $datephd);


            $sheet->setCellValue('AB' . $i, $leadresearch);
            $sheet->setCellValue('AC' . $i, array_sum(array_column(array_filter($model->researchCompletedAfterPhd, function ($var) {
                                        return (($var['Membership'] == 'Leader') && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
                                    }), 'Amount')));
            $sheet->setCellValue('AD' . $i, $memberresearch);
            $sheet->setCellValue('AE' . $i, array_sum(array_column(array_filter($model->researchCompletedAfterPhd, function ($var) {
                                        return (($var['Membership'] == 'Member') && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
                                    }), 'Amount')));
            $sheet->setCellValue('AF' . $i, array_sum(array_column(array_filter($model->researchCompletedAfterPhd, function ($var) {
                                        return (($var['Membership'] == 'Leader' || $var['Membership'] == 'Member') && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
                                    }), 'Amount')));


            $sheet->setCellValue('AG' . $i, (count(array_filter($model->publicationCompletedAfterPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            })) + count(array_filter($model->publicationCompletedAfterPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            }))));
            $sheet->setCellValue('AH' . $i, count(array_filter($model->publicationCompletedAfterPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            })));
            $sheet->setCellValue('AI' . $i, count(array_filter($model->publicationCompletedAfterPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                            })));
            $sheet->setCellValue('AJ' . $i, count(array_filter($model->publicationCompletedAfterPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                            })));
            $sheet->setCellValue('AK' . $i, count(array_filter($model->publicationCompletedAfterPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            })));
            $sheet->setCellValue('AL' . $i, count(array_filter($model->publicationCompletedAfterPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                            })));
            $sheet->setCellValue('AM' . $i, count(array_filter($model->publicationCompletedAfterPhd, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                            })));

            $sheet->setCellValue('AN' . $i, $model->scopus->h_index);
            $sheet->setCellValue('AO' . $i, $model->googleScholar->h_index);
            $sheet->setCellValue('AP' . $i, $model->scopus->Citations);
            $sheet->setCellValue('AQ' . $i, $model->googleScholar->Citations);
        }

        if ($gred != 13) {

            $sheet->setCellValue('N' . $i, $kjstatus);
            $sheet->setCellValue('O' . $i, $kjulasan);

            $researchleader = array_filter($model->research2, function ($var) {
                return ($var['Membership'] == 'Leader');
            });
            $researchmember = array_filter($model->research2, function ($var) {
                return ($var['Membership'] == 'Member');
            });

            $sheet->setCellValue('Q' . $i, count($researchleader));
            $sheet->setCellValue('R' . $i, array_sum(array_column($researchleader, 'Amount')));
            $sheet->setCellValue('S' . $i, count($researchmember));
            $sheet->setCellValue('T' . $i, array_sum(array_column($researchmember, 'Amount')));
            $sheet->setCellValue('U' . $i, '=(R' . $i . ')+(T' . $i . ')');
            $sheet->setCellValue('V' . $i, count(array_filter($researchleader, function ($var) {
                                return ($var['GrantLevel'] == '');
                            })));
            $sheet->setCellValue('W' . $i, count(array_filter($researchleader, function ($var) {
                                return ($var['GrantLevel'] == 'Antarabangsa');
                            })));
            $sheet->setCellValue('X' . $i, count(array_filter($researchleader, function ($var) {
                                return ($var['GrantLevel'] == 'Universiti');
                            })));
            $sheet->setCellValue('Y' . $i, count(array_filter($researchleader, function ($var) {
                                return ($var['GrantLevel'] == 'Luar (Tempatan)');
                            })));
            $sheet->setCellValue('Z' . $i, count(array_filter($researchmember, function ($var) {
                                return ($var['GrantLevel'] == '');
                            })));
            $sheet->setCellValue('AA' . $i, count(array_filter($researchmember, function ($var) {
                                return ($var['GrantLevel'] == 'Antarabangsa');
                            })));
            $sheet->setCellValue('AB' . $i, count(array_filter($researchmember, function ($var) {
                                return ($var['GrantLevel'] == 'Universiti');
                            })));
            $sheet->setCellValue('AC' . $i, count(array_filter($researchmember, function ($var) {
                                return ($var['GrantLevel'] == 'Luar (Tempatan)');
                            })));

            $sheet->setCellValue('AD' . $i, (count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            })) + count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            }))));
            $sheet->setCellValue('AE' . $i, count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            })));
            $sheet->setCellValue('AF' . $i, count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                            })));
            $sheet->setCellValue('AG' . $i, count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                            })));
            $sheet->setCellValue('AH' . $i, count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                            })));
            $sheet->setCellValue('AI' . $i, count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                            })));
            $sheet->setCellValue('AJ' . $i, count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                            })));

            $sheet->setCellValue('AK' . $i, $model->scopus->h_index);
            $sheet->setCellValue('AL' . $i, $model->googleScholar->h_index);
            $sheet->setCellValue('AM' . $i, count(array_filter($model->publication, function ($var) {
                                return ($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)');
                            })));
            $sheet->setCellValue('AN' . $i, $model->scopus->Citations);
            $sheet->setCellValue('AO' . $i, $model->googleScholar->Citations);

            $sheet->setCellValue('AP' . $i, count(array_filter($model->publication, function ($var) {
                                return ($var['Keterangan_PublicationTypeID'] == 'General Book');
                            })));
            $sheet->setCellValue('AQ' . $i, count(array_filter($model->publication, function ($var) {
                                return ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book');
                            })));
            $sheet->setCellValue('AR' . $i, count(array_filter($model->publication, function ($var) {
                                return ($var['Keterangan_PublicationTypeID'] == 'General Publication');
                            })));

//        $sheet->setCellValue('AS' . $i,  );KARYA ASLI
            $sheet->setCellValue('AT' . $i, $model->jumlahKreditMengajar('PRASISWAZAH'));
            $sheet->setCellValue('AU' . $i, $model->jumlahKreditMengajar('PASCASISWAZAH'));
            $sheet->setCellValue('AW' . $i, $model->totalPenyeliaan('PHD', 'PENYELIA'));
            $sheet->setCellValue('AX' . $i, $model->totalPenyeliaan('PHD', 'PENYELIA UTAMA '));
            $sheet->setCellValue('AY' . $i, $model->totalPenyeliaan('PHD', 'PENYELIA BERSAMA'));
            $sheet->setCellValue('AZ' . $i, $model->totalPenyeliaan('PHD', 'PENGERUSI J/K PENYELIAAN'));
            $sheet->setCellValue('BA' . $i, $model->totalPenyeliaan('PHD', 'AHLI J/K PENYELIAAN'));
            $sheet->setCellValue('BB' . $i, $model->totalPenyeliaan('MASTER', 'PENYELIA'));
            $sheet->setCellValue('BC' . $i, $model->totalPenyeliaan('MASTER', 'PENYELIA UTAMA '));
            $sheet->setCellValue('BD' . $i, $model->totalPenyeliaan('MASTER', 'PENYELIA BERSAMA'));
            $sheet->setCellValue('BE' . $i, $model->totalPenyeliaan('MASTER', 'PENGERUSI J/K PENYELIAAN'));
            $sheet->setCellValue('BF' . $i, $model->totalPenyeliaan('MASTER', 'AHLI J/K PENYELIAAN'));
            $persidangani = array_filter($model->persidangan2, function ($var) {
                return ($var['Peringkat'] == 'Antarabangsa');
            });
            $persidangann = array_filter($model->persidangan2, function ($var) {
                return ($var['Peringkat'] == 'Kebangsaan');
            });

            $sheet->setCellValue('BG' . $i, count(array_filter($persidangann, function ($var) {
                                return ($var['Peranan'] == 'Pembentang');
                            })));
            $sheet->setCellValue('BH' . $i, count(array_filter($persidangani, function ($var) {
                                return ($var['Peranan'] == 'Pembentang');
                            })));
            $sheet->setCellValue('BI' . $i, count(array_filter($persidangann, function ($var) {
                                return ($var['Peranan'] == 'Ahli Panel');
                            })));
            $sheet->setCellValue('BJ' . $i, count(array_filter($persidangani, function ($var) {
                                return ($var['Peranan'] == 'Ahli Panel');
                            })));
            $sheet->setCellValue('BK' . $i, count(array_filter($persidangann, function ($var) {
                                return ($var['Peranan'] == 'Pengerusi');
                            })));
            $sheet->setCellValue('BL' . $i, count(array_filter($persidangani, function ($var) {
                                return ($var['Peranan'] == 'Pengerusi');
                            })));
            $sheet->setCellValue('BM' . $i, count(array_filter($persidangann, function ($var) {
                                return ($var['Peranan'] == 'Peserta');
                            })));
            $sheet->setCellValue('BN' . $i, count(array_filter($persidangani, function ($var) {
                                return ($var['Peranan'] == 'Peserta');
                            })));
            $sheet->setCellValue('BO' . $i, count(array_filter($persidangann, function ($var) {
                                return ($var['Peranan'] == 'Pembentang Poster');
                            })));
            $sheet->setCellValue('BP' . $i, count(array_filter($persidangani, function ($var) {
                                return ($var['Peranan'] == 'Pembentang Poster');
                            })));
            $sheet->setCellValue('BQ' . $i, count(array_filter($persidangann, function ($var) {
                                return ($var['Peranan'] == 'Pembentang Jemputan');
                            })));
            $sheet->setCellValue('BR' . $i, count(array_filter($persidangani, function ($var) {
                                return ($var['Peranan'] == 'Pembentang Jemputan');
                            })));
            $sheet->setCellValue('BS' . $i, count(array_filter($persidangann, function ($var) {
                                return ($var['Peranan'] == 'Keynote Speaker');
                            })));
            $sheet->setCellValue('BT' . $i, count(array_filter($persidangani, function ($var) {
                                return ($var['Peranan'] == 'Keynote Speaker');
                            })));

            $sheet->setCellValue('BU' . $i, count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article' && $var['KeteranganBI_WriterStatus'] == 'Editor');
                            })));

            $sheet->setCellValue('BV' . $i, count(array_filter($model->outreaching, function ($var) {
                                return ($var['StatusPengesahan'] == 'V');
                            })));
            $sheet->setCellValue('BW' . $i, count(array_filter($model->outreaching, function ($var) {
                                return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'International' && $var['Keahlian'] == 'Leader');
                            })));
            $sheet->setCellValue('BX' . $i, array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                        return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'International' && $var['Keahlian'] == 'Leader');
                                    }), 'Jumlah')));
            $sheet->setCellValue('BY' . $i, count(array_filter($model->outreaching, function ($var) {
                                return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'National' && $var['Keahlian'] == 'Leader');
                            })));
            $sheet->setCellValue('BZ' . $i, array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                        return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'National' && $var['Keahlian'] == 'Leader');
                                    }), 'Jumlah')));
            $sheet->setCellValue('CA' . $i, count(array_filter($model->outreaching, function ($var) {
                                return ($var['StatusPengesahan'] == 'V' && $var['Keahlian'] == 'Professional Service');
                            })));
            $sheet->setCellValue('CB' . $i, array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                        return ($var['StatusPengesahan'] == 'V' && $var['Keahlian'] == 'Professional Service');
                                    }), 'Jumlah')));
            $sheet->setCellValue('CC' . $i, count(array_filter($model->outreachingClinical, function ($var) {
                                return ($var['ApproveStatus'] == 'V');
                            })));
        }

        $sheet->getStyle('A' . $i . ':'.$totalColumn . $i)->applyFromArray($content);
//    $sheet->getStyle('D'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
//    $sheet->getStyle('F'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
//    $sheet->getStyle('G'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
//    $sheet->getStyle('AC'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
//$sheet->getStyle('A'.$i.':AD'.$i)->applyFromArray($content);
        //$sheet->getStyle('C'.$i)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
        $i++;
        break;
    }
    $no++;
}

$writer = new Xlsx($phpExcel);
if ($gred != 13) {
    $writer->save('uploads-cv/laporan.xlsx');
    Yii::$app->response->redirect(['uploads-cv/laporan.xlsx']);
} else {
    $writer->save('uploads-cv/laporan-DS52.xlsx');
    Yii::$app->response->redirect(['uploads-cv/laporan.xlsx']);
}
