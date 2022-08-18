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

$phpExcel = PhpOffice\PhpSpreadsheet\IOFactory::load('uploads-cv/template-laporan.xlsx');

$sheet = $phpExcel->getActiveSheet();
foreach (range('A', 'DV') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
    $sheet->getColumnDimension('A' . $columnID)->setAutoSize(true);
}

$i = 7;
$no = 1;
foreach ($model as $model) {
    $sheet->setCellValue('A' . $i, $no);
    $sheet->setCellValue('B' . $i, $model->CONm);
    $sheet->setCellValue('C' . $i, $model->ICNO);
    $sheet->setCellValue('D' . $i, $model->COOldID);
    $sheet->setCellValue('E' . $i, $model->umur);
    $sheet->setCellValue('F' . $i, $model->jawatan->gred);
    $sheet->setCellValue('G' . $i, $model->departmentHakiki->shortname);
    $sheet->setCellValue('H' . $i, $model->programPengajaran? $model->programPengajaran->NamaProgram:'-');
    $sheet->setCellValue('I' . $i, $model->department->shortname);
    $sheet->setCellValue('J' . $i, $model->markahlnptCV(1, 'Markah'));
    $sheet->setCellValue('K' . $i, $model->markahlnptCV(2, 'Markah'));
    $sheet->setCellValue('L' . $i, $model->markahlnptCV(3, 'Markah'));

    if (!empty($model->markahlnptCV(3, 'Tahun'))) {
        $purataLNPT = number_format(($model->markahlnptCV(1, 'Markah') * 0.2) + ($model->markahlnptCV(2, 'Markah') * 0.35) + ($model->markahlnptCV(3, 'Markah') * 0.45));
    } else if (!empty($model->markahlnptCV(2, 'Tahun'))) {
        $purataLNPT = number_format(($model->markahlnptCV(1, 'Markah') * 0.6) + ($model->markahlnptCV(2, 'Markah') * 0.4));
    } else {
        $purataLNPT = number_format(($model->markahlnptCV(1, 'Markah') * 1));
    }

    $sheet->setCellValue('M' . $i, $purataLNPT);

    $sheet->setCellValue('N' . $i, $model->servPeriodPermanent);

    $sheet->setCellValue('O' . $i, $model->servPeriodCPositionBI);

    if ($model->statLantikan == 1) {//tetap
        $dateLantik = $model->SandanganCTetap ? $model->getTarikh($model->SandanganCTetap->start_date) : '-';
    } else {
        $dateLantik = $model->sandanganCKontrak ? $model->getTarikh($model->sandanganCKontrak->start_date) : '-';
    }

    $sheet->setCellValue('P' . $i, $dateLantik);

    $cvapplied = app\models\cv\TblPermohonan::findOne(['ICNO' => $model->ICNO, 'ads_id' => $gred]);
    $kjstatus = 'TIDAK';
    if ($cvapplied->kj_status == 1) {
        $kjstatus = 'YA';
    }

    $sheet->setCellValue('Q' . $i, $kjstatus);
    $sheet->setCellValue('R' . $i, $cvapplied->kj_ulasan); 

    $sheet->setCellValue('S' . $i, ($model->confirmDt ? $model->confirmDt->ConfirmStatusStDt : ''));

    $sheet->setCellValue('T' . $i, $purataLNPT);

    $sheet->setCellValue('U' . $i, $kjstatus);

    $statusLantikan = 'TIDAK';
    if ($model->statLantikan == 1) {
        $statusLantikan = 'YA';
    }

    $sheet->setCellValue('V' . $i, $statusLantikan);

    $tatatertib = '';
    if (($model->usercv ? $model->usercv->tatatertib_status : '') == 1) {
        $tatatertib = 'YA';
    }

    $sheet->setCellValue('W' . $i, $tatatertib);

    $researchleader = array_filter($model->research2, function ($var) {
        return ($var['Membership'] == 'Leader');
    });
    $researchmember = array_filter($model->research2, function ($var) {
        return ($var['Membership'] == 'Member');
    });

    $sheet->setCellValue('X' . $i, count($researchleader));
    $sheet->setCellValue('Y' . $i, array_sum(array_column($researchleader, 'Amount')));
    $sheet->setCellValue('Z' . $i, count($researchmember));
    $sheet->setCellValue('AA' . $i, array_sum(array_column($researchmember, 'Amount')));
    $sheet->setCellValue('AB' . $i, '=(Y' . $i . ')+(AA' . $i . ')');
    $sheet->setCellValue('AC' . $i, count(array_filter($researchleader, function ($var) {
                        return ($var['GrantLevel'] == '');
                    })));
    $sheet->setCellValue('AD' . $i, count(array_filter($researchleader, function ($var) {
                        return ($var['GrantLevel'] == 'Antarabangsa');
                    })));
    $sheet->setCellValue('AE' . $i, count(array_filter($researchleader, function ($var) {
                        return ($var['GrantLevel'] == 'Universiti');
                    })));
    $sheet->setCellValue('AF' . $i, count(array_filter($researchleader, function ($var) {
                        return ($var['GrantLevel'] == 'Luar (Tempatan)');
                    })));
    $sheet->setCellValue('AG' . $i, count(array_filter($researchmember, function ($var) {
                        return ($var['GrantLevel'] == '');
                    })));
    $sheet->setCellValue('AH' . $i, count(array_filter($researchmember, function ($var) {
                        return ($var['GrantLevel'] == 'Antarabangsa');
                    })));
    $sheet->setCellValue('AI' . $i, count(array_filter($researchmember, function ($var) {
                        return ($var['GrantLevel'] == 'Universiti');
                    })));
    $sheet->setCellValue('AJ' . $i, count(array_filter($researchmember, function ($var) {
                        return ($var['GrantLevel'] == 'Luar (Tempatan)');
                    })));

    $sheet->setCellValue('AK' . $i, (count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                    })) + count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                    }))));
    $sheet->setCellValue('AL' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                    })));
    $sheet->setCellValue('AM' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                    })));
    $sheet->setCellValue('AN' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Collaborative Author'));
                    })));
    $sheet->setCellValue('AO' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                    })));
    $sheet->setCellValue('AP' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                    })));
    $sheet->setCellValue('AQ' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Collaborative Author'));
                    })));

    $sheet->setCellValue('AR' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
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
    //university
    $sheet->setCellValue('CI' . $i, count(array_filter($model->serviceUniversity, function ($var) {
                        return ($var['role_key'] == 'Chairman');
                    })));
    $sheet->setCellValue('CJ' . $i, count(array_filter($model->serviceUniversity, function ($var) {
                        return ($var['role_key'] == 'Member Committee');
                    })));
    //community                
    $sheet->setCellValue('CK' . $i, count(array_filter($model->serviceCommunity, function ($var) {
                                        return ($var['level'] == '1' && $var['role_key'] == 'Chairman');
                                    })));
    $sheet->setCellValue('CL' . $i, count(array_filter($model->serviceCommunity, function ($var) {
                                        return ($var['level'] == '1' && $var['role_key'] == 'Member Committee');
                                    })));
    
    $sheet->setCellValue('CM' . $i, count(array_filter($model->serviceCommunity, function ($var) {
                                        return ($var['level'] == '2' && $var['role_key'] == 'Chairman');
                                    })));
    $sheet->setCellValue('CN' . $i, count(array_filter($model->serviceCommunity, function ($var) {
                                        return ($var['level'] == '2' && $var['role_key'] == 'Member Committee');
                                    })));
    
    $sheet->setCellValue('CO' . $i, count(array_filter($model->serviceCommunity, function ($var) {
                                        return ($var['level'] == '3' && $var['role_key'] == 'Chairman');
                                    })));
    $sheet->setCellValue('CP' . $i, count(array_filter($model->serviceCommunity, function ($var) {
                                        return ($var['level'] == '3' && $var['role_key'] == 'Member Committee');
                                    })));
                    
                    

    $persidangani = array_filter($model->persidangan2, function ($var) {
        return ($var['Peringkat'] == 'Antarabangsa');
    });
    $persidangann = array_filter($model->persidangan2, function ($var) {
        return ($var['Peringkat'] == 'Kebangsaan');
    });

    $sheet->setCellValue('CQ' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Pembentang');
                    })));
    $sheet->setCellValue('CR' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Pembentang');
                    })));
    $sheet->setCellValue('CS' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Ahli Panel');
                    })));
    $sheet->setCellValue('CT' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Ahli Panel');
                    })));
    $sheet->setCellValue('CU' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Pengerusi');
                    })));
    $sheet->setCellValue('CV' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Pengerusi');
                    })));
    $sheet->setCellValue('CW' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Peserta');
                    })));
    $sheet->setCellValue('CX' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Peserta');
                    })));
    $sheet->setCellValue('CY' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Pembentang Poster');
                    })));
    $sheet->setCellValue('CZ' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Pembentang Poster');
                    })));
    $sheet->setCellValue('DA' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Pembentang Jemputan');
                    })));
    $sheet->setCellValue('DB' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Pembentang Jemputan');
                    })));
    $sheet->setCellValue('DC' . $i, count(array_filter($persidangann, function ($var) {
                        return ($var['Peranan'] == 'Keynote Speaker');
                    })));
    $sheet->setCellValue('DD' . $i, count(array_filter($persidangani, function ($var) {
                        return ($var['Peranan'] == 'Keynote Speaker');
                    })));

    $sheet->setCellValue('DE' . $i, count(array_filter($model->publication, function ($var) {
                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article' && $var['KeteranganBI_WriterStatus'] == 'Editor');
                    }))); 
                    
    $sheet->setCellValue('DF' . $i, count(array_filter($model->outreaching, function ($var) {
                                        return (($var['Keahlian'] == 'Indexed Journal Assessor' || $var['Keahlian'] == 'Book Manuscript Reviewer') && $var['StatusPengesahan'] == 'V');
                                    })));  
    $sheet->setCellValue('DG' . $i, count(array_filter($model->outreaching, function ($var) {
                                        return ($var['Keahlian'] == ' External Assessor for Promotion' && $var['StatusPengesahan'] == 'V');
                                    })));
    $sheet->setCellValue('DH' . $i, count(array_filter($model->asPanel, function ($var) {
                                        return ($var['type'] == 13 && ($var['level'] == 'phd') && $var['examiner_type'] == 'external'); //Thesis Examiner (By Research)
                                    })));
                                    
    $sheet->setCellValue('DI' . $i, '');//Hakim / Penilai Sayembara / Pertandingan
    $sheet->setCellValue('DJ' . $i, '');//Penilai luar / pemeriksa luar untuk program akademik
    $sheet->setCellValue('DK' . $i, '');//Ahli Lembaga Penasihat agensi awam / swasta
                    
                    
                    
    $sheet->setCellValue('DL' . $i, count(array_filter($model->outreaching, function ($var) {
                        return ($var['StatusPengesahan'] == 'V');
                    })));
    $sheet->setCellValue('DM' . $i, count(array_filter($model->outreaching, function ($var) {
                        return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'International' && $var['Keahlian'] == 'Leader');
                    })));
    $sheet->setCellValue('DN' . $i, array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'International' && $var['Keahlian'] == 'Leader');
                            }), 'Jumlah')));
    $sheet->setCellValue('DO' . $i, count(array_filter($model->outreaching, function ($var) {
                        return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'National' && $var['Keahlian'] == 'Leader');
                    })));
    $sheet->setCellValue('DP' . $i, array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'National' && $var['Keahlian'] == 'Leader');
                            }), 'Jumlah')));
    $sheet->setCellValue('DQ' . $i, count(array_filter($model->outreaching, function ($var) {
                        return ($var['StatusPengesahan'] == 'V' && $var['Keahlian'] == 'Professional Service');
                    })));
    $sheet->setCellValue('DR' . $i, array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                return ($var['StatusPengesahan'] == 'V' && $var['Keahlian'] == 'Professional Service');
                            }), 'Jumlah')));
                            
    $sheet->setCellValue('DS' . $i, count($model->inovasiSelesai));                
    $sheet->setCellValue('DT' . $i, count($model->getTeknologiInvasi())); 
    $sheet->setCellValue('DU' . $i, count(array_filter($model->outreaching, function ($var) {
                                                return ($var['StatusPengesahan'] == 'V' && $var['Keahlian'] == 'Speaker'); //verified
                                            }))); 
                            
    $sheet->setCellValue('DV' . $i, count(array_filter($model->outreachingClinical, function ($var) {
                        return ($var['ApproveStatus'] == 'V');
                    }))); 
    $i++;
    $no++;
}

$writer = new Xlsx($phpExcel);
$writer->save('uploads-cv/laporan.xlsx');
Yii::$app->response->redirect(['uploads-cv/laporan.xlsx']);
