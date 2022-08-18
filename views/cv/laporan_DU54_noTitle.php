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


$phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads-cv/template-laporan-DU54x.xlsx');

$sheet = $phpExcel->getActiveSheet();
foreach (range('A', 'DO') as $columnID) {
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
    } else if (!empty($model->markahlnptCV(2, 'Tahun'))) {
        $purataLNPT = number_format(($model->markahlnptCV(1, 'Markah') * 0.6) + ($model->markahlnptCV(2, 'Markah') * 0.4));
    } else {
        $purataLNPT = number_format(($model->markahlnptCV(1, 'Markah') * 1));
    }

    $sheet->setCellValue('J' . $i, $purataLNPT);
    $kkm = \app\models\hronline\Tblpengalamankerja::find()->where(['ICNO' => $model->ICNO])
            ->andWhere(['like', 'OrgNm', 'Kementerian Kesihatan Malaysia'])
            ->andWhere(['CorpBodyTypeCd' => '01'])
            ->one();

    $diffkkm = date_diff(date_create($kkm->PrevEmpStartDt), date_create($kkm->PrevEmpEndDt));
    $tempohkkm = $diffkkm->format('%y Tahun %m Bulan');
    //KKM
    $sheet->setCellValue('K' . $i, $kkm->PrevEmpStartDt);
    $sheet->setCellValue('L' . $i, $tempohkkm);

    $expums = app\models\hronline\Tblrscosandangan::find()->where(['ICNO' => $model->ICNO])->orderBy(['start_date' => SORT_ASC])->one();
    $diffums = date_diff(date_create($expums->start_date), date_create(date('Y-m-d')));
    $tempohums = $diffums->format('%y Tahun %m Bulan');
    //UMS
    $sheet->setCellValue('M' . $i, $expums->start_date);
    $sheet->setCellValue('N' . $i, $tempohums);

    //KKM + UMS
    $tempohKkmUmsY = $diffkkm->format('%y') + $diffums->format('%y');
    $tempohKkmUmsM = $diffkkm->format('%m') + $diffums->format('%m');

    $sheet->setCellValue('O' . $i, $tempohKkmUmsY . ' Tahun ' . $tempohKkmUmsM);

    $lantikDU51 = app\models\hronline\Tblrscosandangan::find()->where(['ICNO' => $model->ICNO])->andWhere(['gredjawatan' => 22])->orderBy(['start_date' => SORT_ASC])->one();
    //TARIKH LANTIKAN GRED DU51
    $sheet->setCellValue('P' . $i, $lantikDU51->start_date);

    $yearDU51 = 0;
    if ($lantikDU51) {
        if ($lantikDU51->start_date) {

            $diffDU51 = date_diff(date_create($lantikDU51->start_date), date_create(date('Y-m-d')));
            $yearDU51 = $diffDU51->format('%y Tahun %m Bulan');
        }
    }

    //TEMPOH PERKHIDMATAN GRED DU51
    $sheet->setCellValue('Q' . $i, $yearDU51);


    $cvapplied = app\models\cv\TblPermohonan::findOne(['ICNO' => $model->ICNO, 'ads_id' => $gred]);
    $kjstatus = 'TIDAK';
    if ($cvapplied->kj_status == 1) {
        $kjstatus = 'YA';
    }
    $sheet->setCellValue('R' . $i, $kjstatus);
    $sheet->setCellValue('S' . $i, $cvapplied->kj_ulasan);

    $sheet->setCellValue('T' . $i, ($model->confirmDt ? $model->confirmDt->ConfirmStatusStDt : ''));


    $sheet->setCellValue('U' . $i, $purataLNPT);

    $sheet->setCellValue('V' . $i, $kjstatus);

    $statusLantikan = 'TIDAK';
    if ($model->statLantikan == 1) {
        $statusLantikan = 'YA';
    }

    $sheet->setCellValue('W' . $i, $statusLantikan);

    $tatatertib = '';
    if (($model->usercv ? $model->usercv->tatatertib_status : '') == 1) {
        $tatatertib = 'YA';
    }

    $sheet->setCellValue('X' . $i, $tatatertib);

    //PENERBITAN

    $researchleader = array_filter($model->research2, function ($var) {
        return ($var['Membership'] == 'Leader');
    });
    $researchmember = array_filter($model->research2, function ($var) {
        return ($var['Membership'] == 'Member');
    });

    $sheet->setCellValue('Y' . $i, count($researchleader));
    $sheet->setCellValue('Z' . $i, array_sum(array_column($researchleader, 'Amount')));
    $sheet->setCellValue('AA' . $i, count($researchmember));
    $sheet->setCellValue('AB' . $i, array_sum(array_column($researchmember, 'Amount')));
    $sheet->setCellValue('AC' . $i, '=(Z' . $i . ')+(AB' . $i . ')');
    $sheet->setCellValue('AD' . $i, count(array_filter($researchleader, function ($var) {
                        return ($var['GrantLevel'] == '');
                    })));
    $sheet->setCellValue('AE' . $i, count(array_filter($researchleader, function ($var) {
                        return ($var['GrantLevel'] == 'Antarabangsa');
                    })));
    $sheet->setCellValue('AF' . $i, count(array_filter($researchleader, function ($var) {
                        return ($var['GrantLevel'] == 'Universiti');
                    })));
    $sheet->setCellValue('AG' . $i, count(array_filter($researchleader, function ($var) {
                        return ($var['GrantLevel'] == 'Luar (Tempatan)');
                    })));
    $sheet->setCellValue('AH' . $i, count(array_filter($researchmember, function ($var) {
                        return ($var['GrantLevel'] == '');
                    })));
    $sheet->setCellValue('AI' . $i, count(array_filter($researchmember, function ($var) {
                        return ($var['GrantLevel'] == 'Antarabangsa');
                    })));
    $sheet->setCellValue('AJ' . $i, count(array_filter($researchmember, function ($var) {
                        return ($var['GrantLevel'] == 'Universiti');
                    })));
    $sheet->setCellValue('AK' . $i, count(array_filter($researchmember, function ($var) {
                        return ($var['GrantLevel'] == 'Luar (Tempatan)');
                    })));

    //PENERBITAN

    $sheet->setCellValue('AL' . $i, (count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                    })) + count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                    }))));
    $sheet->setCellValue('AM' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                    })));
    $sheet->setCellValue('AN' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                    })));
    $sheet->setCellValue('AO' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Collaborative Author'));
                    })));
    $sheet->setCellValue('AP' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                    })));
    $sheet->setCellValue('AQ' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                    })));
    $sheet->setCellValue('AR' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Collaborative Author'));
                    })));

    $sheet->setCellValue('AS' . $i, $model->scopus->h_index);
    $sheet->setCellValue('AT' . $i, $model->googleScholar->h_index);
    $sheet->setCellValue('AU' . $i, count(array_filter($model->publication, function ($var) {
                        return ($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)');
                    })));
    $sheet->setCellValue('AV' . $i, $model->scopus->Citations);
    $sheet->setCellValue('AW' . $i, $model->googleScholar->Citations);

    $sheet->setCellValue('AX' . $i, count(array_filter($model->publication, function ($var) {
                        return ($var['Keterangan_PublicationTypeID'] == 'General Book');
                    })));
    $sheet->setCellValue('AY' . $i, count(array_filter($model->publication, function ($var) {
                        return ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book');
                    })));
    $sheet->setCellValue('AZ' . $i, count(array_filter($model->publication, function ($var) {
                        return ($var['Keterangan_PublicationTypeID'] == 'General Publication');
                    })));
//            $sheet->setCellValue('BA' . $i, 'Buku karya asli yang diterbitkan oleh penerbit yang diiktiraf');
    $sheet->setCellValue('BB' . $i, $model->jumlahKreditMengajar('PRASISWAZAH'));
    $sheet->setCellValue('BC' . $i, $model->jumlahKreditMengajar('PASCASISWAZAH'));
//    $sheet->setCellValue('BD' . $i, 'PENILAIAN PENGAJARAN/SKOR');
    //PENYELIAAN

    $sheet->setCellValue('BE' . $i, $model->totalPenyeliaanPenyelidikan('PHD', 'SUPERVISOR'));
    $sheet->setCellValue('BF' . $i, $model->totalPenyeliaanPenyelidikan('PHD', 'MAIN SUPERVISOR'));
    $sheet->setCellValue('BG' . $i, $model->totalPenyeliaanPenyelidikan('PHD', 'CO-SUPERVISOR'));
    $sheet->setCellValue('BH' . $i, $model->totalPenyeliaanPenyelidikan('PHD', 'CHAIRPERSON'));
    $sheet->setCellValue('BI' . $i, $model->totalPenyeliaanPenyelidikan('PHD', 'COMMITTEE MEMBER'));
    $sheet->setCellValue('BJ' . $i, $model->totalPenyeliaanPenyelidikan('MASTER', 'SUPERVISOR'));
    $sheet->setCellValue('BK' . $i, $model->totalPenyeliaanPenyelidikan('MASTER', 'MAIN SUPERVISOR'));
    $sheet->setCellValue('BL' . $i, $model->totalPenyeliaanPenyelidikan('MASTER', 'CO-SUPERVISOR'));
    $sheet->setCellValue('BM' . $i, $model->totalPenyeliaanPenyelidikan('MASTER', 'CHAIRPERSON'));
    $sheet->setCellValue('BN' . $i, $model->totalPenyeliaanPenyelidikan('MASTER', 'COMMITTEE MEMBER'));

    $sheet->setCellValue('BO' . $i, $model->totalPenyeliaanModCampuran('PHD', 'SUPERVISOR'));
    $sheet->setCellValue('BP' . $i, $model->totalPenyeliaanModCampuran('PHD', 'MAIN SUPERVISOR'));
    $sheet->setCellValue('BQ' . $i, $model->totalPenyeliaanModCampuran('PHD', 'CO-SUPERVISOR'));
    $sheet->setCellValue('BR' . $i, $model->totalPenyeliaanModCampuran('PHD', 'CHAIRPERSON'));
    $sheet->setCellValue('BS' . $i, $model->totalPenyeliaanModCampuran('PHD', 'COMMITTEE MEMBER'));
    $sheet->setCellValue('BT' . $i, $model->totalPenyeliaanModCampuran('MASTER', 'SUPERVISOR'));
    $sheet->setCellValue('BU' . $i, $model->totalPenyeliaanModCampuran('MASTER', 'MAIN SUPERVISOR'));
    $sheet->setCellValue('BV' . $i, $model->totalPenyeliaanModCampuran('MASTER', 'CO-SUPERVISOR'));
    $sheet->setCellValue('BW' . $i, $model->totalPenyeliaanModCampuran('MASTER', 'CHAIRPERSON'));
    $sheet->setCellValue('BX' . $i, $model->totalPenyeliaanModCampuran('MASTER', 'COMMITTEE MEMBER'));

    $sheet->setCellValue('BY' . $i, $model->totalPenyeliaanLuar('PHD', 'SUPERVISOR'));
    $sheet->setCellValue('BZ' . $i, $model->totalPenyeliaanLuar('PHD', 'MAIN SUPERVISOR'));
    $sheet->setCellValue('CA' . $i, $model->totalPenyeliaanLuar('PHD', 'CO-SUPERVISOR'));
    $sheet->setCellValue('CB' . $i, $model->totalPenyeliaanLuar('PHD', 'CHAIRPERSON'));
    $sheet->setCellValue('CC' . $i, $model->totalPenyeliaanLuar('PHD', 'COMMITTEE MEMBER'));
    $sheet->setCellValue('CD' . $i, $model->totalPenyeliaanLuar('MASTER', 'SUPERVISOR'));
    $sheet->setCellValue('CE' . $i, $model->totalPenyeliaanLuar('MASTER', 'MAIN SUPERVISOR'));
    $sheet->setCellValue('CF' . $i, $model->totalPenyeliaanLuar('MASTER', 'CO-SUPERVISOR'));
    $sheet->setCellValue('CG' . $i, $model->totalPenyeliaanLuar('MASTER', 'CHAIRPERSON'));
    $sheet->setCellValue('CH' . $i, $model->totalPenyeliaanLuar('MASTER', 'COMMITTEE MEMBER'));

    //PERSIDANGAN

    $persidangani = array_filter($model->persidangan2, function ($var) {
        return ($var['Peringkat'] == 'Antarabangsa');
    });
    $persidangann = array_filter($model->persidangan2, function ($var) {
        return ($var['Peringkat'] == 'Kebangsaan');
    });

    $sheet->setCellValue('CI' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Pembentang');
                    })));
    $sheet->setCellValue('CJ' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Pembentang');
                    })));
    $sheet->setCellValue('CK' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Ahli Panel');
                    })));
    $sheet->setCellValue('CL' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Ahli Panel');
                    })));
    $sheet->setCellValue('CM' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Pengerusi');
                    })));
    $sheet->setCellValue('CN' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Pengerusi');
                    })));
    $sheet->setCellValue('CO' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Peserta');
                    })));
    $sheet->setCellValue('CP' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Peserta');
                    })));
    $sheet->setCellValue('CQ' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Pembentang Poster');
                    })));
    $sheet->setCellValue('CR' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Pembentang Poster');
                    })));
    $sheet->setCellValue('CS' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Pembentang Jemputan');
                    })));
    $sheet->setCellValue('CT' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Pembentang Jemputan');
                    })));
    $sheet->setCellValue('CU' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Keynote Speaker');
                    })));
    $sheet->setCellValue('CV' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Keynote Speaker');
                    })));

    //PATERN
    $sheet->setCellValue('CW' . $i, '');
    $sheet->setCellValue('CX' . $i, '');
    //PENGKOMERSILAN
    $sheet->setCellValue('CY' . $i, '');
    $sheet->setCellValue('CZ' . $i, '');
    //EDITOR

    $sheet->setCellValue('DA' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article' && $var['KeteranganBI_WriterStatus'] == 'Editor');
                    })));

    //PENILAI
    $sheet->setCellValue('DB' . $i, count(array_filter($model->outreaching, function ($var) {
                        return ($var['Keahlian'] == 'Indexed Journal Assessor' && $var['StatusPengesahan'] == 'V');
                    })));
    $sheet->setCellValue('DC' . $i, count(array_filter($model->outreaching, function ($var) {
                        return ($var['Keahlian'] == 'Book Manuscript Reviewer' && $var['StatusPengesahan'] == 'V');
                    })));
    $sheet->setCellValue('DD' . $i, count(array_filter($model->outreaching, function ($var) {
                        return ($var['Keahlian'] == ' External Assessor for Promotion' && $var['StatusPengesahan'] == 'V');
                    })));
    $sheet->setCellValue('DE' . $i, count(array_filter($model->asPanel, function ($var) {
                        return ($var['type'] == 13 && ($var['level'] == 'phd') && $var['examiner_type'] == 'external'); //Thesis Examiner (By Research)
                    })));

    //KHIDMAT
    $sheet->setCellValue('DF' . $i, count(array_filter($model->serviceCommunity)));
    $sheet->setCellValue('DG' . $i, count(array_filter($model->serviceUniversity)));


    //PERUNDINGAN

    $sheet->setCellValue('DH' . $i, count(array_filter($model->outreaching, function ($var) {
                        return ($var['StatusPengesahan'] == 'V');
                    })));
    $sheet->setCellValue('DI' . $i, count(array_filter($model->outreaching, function ($var) {
                        return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'International' && $var['Keahlian'] == 'Leader');
                    })));
    $sheet->setCellValue('DJ' . $i, array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'International' && $var['Keahlian'] == 'Leader');
                            }), 'Jumlah')));
    $sheet->setCellValue('DK' . $i, count(array_filter($model->outreaching, function ($var) {
                        return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'National' && $var['Keahlian'] == 'Leader');
                    })));
    $sheet->setCellValue('DL' . $i, array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'National' && $var['Keahlian'] == 'Leader');
                            }), 'Jumlah')));
    $sheet->setCellValue('DM' . $i, count(array_filter($model->outreaching, function ($var) {
                        return ($var['StatusPengesahan'] == 'V' && $var['Keahlian'] == 'Professional Service');
                    })));
    $sheet->setCellValue('DN' . $i, array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                return ($var['StatusPengesahan'] == 'V' && $var['Keahlian'] == 'Professional Service');
                            }), 'Jumlah')));
    $sheet->setCellValue('DO' . $i, count(array_filter($model->outreachingClinical, function ($var) {
                        return ($var['ApproveStatus'] == 'V');
                    })));

    $i++;
    $no++;
}

$writer = new Xlsx($phpExcel);
$writer->save('uploads-cv/laporan-DU54x.xlsx');
Yii::$app->response->redirect(['uploads-cv/laporan-DU54x.xlsx']);
