<?php
use app\models\cv\RequirementMain;
use \app\models\hronline\GredJawatan;
use yii\helpers\Html;
?>
<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $model]); ?> 
<div class="x_panel">
    <h2>SYARAT UMUM</h2>  
    <?php
    $gred_apply = 7; // temp
    $gred = GredJawatan::findOne(['id' => $gred_apply]);
    $main_id = RequirementMain::findOne(['gred' => $gred]);
    $penyelidikan = RequirementMain::penyelidikan($main_id);
    $penerbitan = RequirementMain::penerbitan($main_id);
    $pengajaran = RequirementMain::pengajaran($main_id);
    $penyeliaan = RequirementMain::penyeliaan($main_id);
    $sanjungan = RequirementMain::sanjungan($main_id);
    $perundingan = RequirementMain::perundingan($main_id);
    $umum = RequirementMain::umum($main_id);
    ?>



    <div class="table-responsive">
        <center> 
            <table class="table table-sm table-bordered jambo_table table-striped" style="width:60%"> 
                <tr>   
                    <th style="width:40%">PENGESAHAN PERKHIDMATAN</th>  
                    <td colspan="2">
                        <?php
                        if ($model->confirmDt) {
                            echo $model->confirmDt->tarikhMula;
                        } else {
                            echo '-';
                        }
                        ?>
                    </td> 
                </tr> 
                <tr>   
                    <th rowspan="4">LNPT <br/>
                        (Pemberat 3 Tahun = 20%, 35%, 45%)<br/>
                        (Pemberat 2 Tahun = 40% , 60%)
                    </th>  
                    <td colspan="2"><?= '<b>' . (date('Y') - 1) . ' :</b> ' . $model->markahlnpt(date('Y') - 1); ?></td> 
                </tr>
                <tr>   
                    <td colspan="2"><?= '<b>' . (date('Y') - 2) . ' :</b> ' . $model->markahlnpt(date('Y') - 2); ?></td>  
                </tr>
                <tr>
                    <td colspan="2"><?= '<b>' . (date('Y') - 3) . ' :</b> ' . $model->markahlnpt(date('Y') - 3); ?></td> 
                </tr> 
                <tr>
                    <td>Avg (3 Tahun) : <?= number_format(($model->markahlnpt(date('Y') - 1) + $model->markahlnpt(date('Y') - 2) + $model->markahlnpt(date('Y') - 3)) / 3, 2); ?></td> 
                    <td>Avg (2 Tahun) : <?= number_format(($model->markahlnpt(date('Y') - 1) + $model->markahlnpt(date('Y') - 2)) / 2, 2); ?></td> 
                </tr>
                <tr>   
                    <th>BERJAWATAN TETAP</th>  
                    <td colspan="2"><?= $model->statusLantikan->ApmtStatusNm; ?></td> 
                </tr>
                <tr>   
                    <th>BEBAS TINDAKAN TATATERTIB</th>  
                    <td colspan="2"><?= $model->usercv->statusTatatertib(); ?></td> 
                </tr>
                <tr>   
                    <th>SEKURANG-KURANGNYA 3 TAHUN DI JAWATAN SEMASA</th>  
                    <td colspan="2"><?= $model->servPeriodCPosition; ?></td> 
                </tr> 
                <tr>   
                    <th>TARIKH PERISYTIHARAN HARTA</th>  
                    <td colspan="2"><?= $model->usercv->statusHarta(); ?></td> 
                </tr>

                <tr>   
                    <th colspan="3" class="text-center">KRITIRIA</th>   
                </tr>
                <?php foreach ($umum as $p) { ?>
                    <tr>     
                        <th colspan="2"><?= $p->requirement; ?></th>  
                        <td colspan="1">check</td>
                    </tr>
                <?php } ?>
            </table>
        </center>
    </div> 
    <h2>SYARAT KHUSUS</h2>
    <div class="table-responsive">
        <table class="table table-sm table-bordered jambo_table table-striped">

            <tr> 
                <th class="text-center" colspan="4">KRITERIA</th> 
                <th class="text-center">JUMLAH SEMASA</th> 
            </tr> 
            <?php
            $researchleader = array_filter($model->research, function ($var) {
                return ($var['Membership'] == 'Leader');
            });
            $researchmember = array_filter($model->research, function ($var) {
                return ($var['Membership'] == 'Member');
            });
            ?>
            <tr>   
                <th rowspan="10">PENYELIDIKAN</th>  
                <th rowspan="2">PENYELIDIK UTAMA</th>
                <th colspan="2">BIL GERAN</th>
                <td class="text-center"><?= count($researchleader) ?></td>
            </tr>
            <tr>
                <th colspan="2">NILAI (RM)</th>
                <td class="text-center"><?= number_format(array_sum(array_column($researchleader, 'Amount')), 2) ?></td>
            </tr>
            <tr>   
                <th rowspan="2">PENYELIDIK BERSAMA</th>
                <th colspan="2">BIL GERAN</th>
                <td class="text-center"><?= count($researchmember) ?></td>
            </tr>
            <tr>
                <th colspan="2">NILAI (RM)</th>
                <td class="text-center"><?= number_format(array_sum(array_column($researchmember, 'Amount')), 2) ?></td>
            </tr>
            <tr>
                <th colspan="3">JUMLAH GERAN (RM)</th>
                <td class="text-center"><?= number_format(array_sum(array_column($model->research, 'Amount')), 2) ?></td>
            </tr>
            <tr>
                <th rowspan="5">KATEGORI GERAN (SEBAGAI PENYELIDIK UTAMA)</th>
                <th colspan="2">UMS</th>
                <td class="text-center"><?=
                    count(array_filter($researchleader, function ($var) {
                                return ($var['AgencyName'] == 'UNIVERSITI MALAYSIA SABAH');
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="2">KPM</th>
                <td class="text-center"><?=
                    count(array_filter($researchleader, function ($var) {
                                return ($var['AgencyName'] == 'KEMENTERIAN PENGAJIAN TINGGI ' || $var['AgencyName'] == 'KEMENTERIAN PENDIDIKAN MALAYSIA');
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="2">ANTARABANGSA</th>
                <td class="text-center"><?=
                    count(array_filter($researchleader, function ($var) {
                                return ($var['AgencyStatusID'] == '5' || $var['AgencyStatusID'] == '6' || ($var['AgencyStatusID'] == '3' && $var['GrantTypeDecs'] == 'GERAN ANTARABANGSA'));
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="2">SWASTA</th>
                <td class="text-center"><?=
                    count(array_filter($researchleader, function ($var) {
                                return ($var['AgencyStatusID'] == '2' || $var['AgencyStatusID'] == '4' || ($var['AgencyStatusID'] == '3' && $var['GrantTypeDecs'] == 'GERAN GERAN NGO/SWASTA'));
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="2">KERAJAAN</th>
                <td class="text-center"><?=
                    count(array_filter($researchleader, function ($var) {
                                return ($var['AgencyStatusID'] == '1' && $var['AgencyName'] != 'UNIVERSITI MALAYSIA SABAH' && $var['AgencyName'] != 'KEMENTERIAN PENGAJIAN TINGGI ' && $var['AgencyName'] != 'KEMENTERIAN PENDIDIKAN MALAYSIA');
                            }))
                    ?>
                </td>
            </tr> 
            <?php foreach ($penyelidikan as $p) { ?>
                <tr>     
                    <th colspan="3"><?= $p->requirement; ?></th>  
                    <?php
                    if ($p->id == 1) {
                        if (count($researchleader) >= $p->ans_no) {
                            $s = 1;
                        } else {
                            $s = 0;
                        }
                    } else if ($p->id == 2) {
                        $nilai = array_sum(array_column($researchleader, 'Amount')) + array_sum(array_column($researchmember, 'Amount'));
                        if ($nilai >= $p->ans_decimal) {
                            $s = 1;
                        } else {
                            $s = 0;
                        }
                    }

                    if ($s == 1) {
                        $color = "#00FF00";
                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                    } else {
                        $color = "red";
                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                    }
                    ?>
                    <td colspan="2" style="background-color:<?= $color; ?>" class="text-center">  
                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>   
                <th rowspan="10">PENERBITAN (YANG DISAHKAN)</th>  
                <?php
                $jurnaltidakindex = array_filter(($model->journalNational + $model->journalInternational), function ($var) {
                    return ($var['CitedJournal'] != 'High-Indexed (SCOPUS, WOS, ERA)' && $var['CitedJournal'] != 'Indexed');
                });
                $jurnalindex = array_filter(($model->journalNational + $model->journalInternational), function ($var) {
                    return ($var['CitedJournal'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['CitedJournal'] == 'Indexed');
                });
                ?>
                <th rowspan="3">JURNAL BERINDEKS</th>
                <th colspan="2">BIL JURNAL</th>
                <td class="text-center"><?= count($jurnalindex) ?></td>
            </tr>
            <tr>
                <th colspan="2">JUMLAH JURNAL SEBAGAI PENULIS UTAMA</th>
                <td class="text-center"><?=
                    count(array_filter($jurnalindex, function ($var) {
                                return ($var['WriterStatusID'] == '1');
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="2">JUMLAH JURNAL SEBAGAI PENULIS BERSAMA</th>
                <td class="text-center"><?=
                    count(array_filter($jurnalindex, function ($var) {
                                return ($var['WriterStatusID'] == '4' || $var['WriterStatusID'] == '5');
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th rowspan="3">JURNAL TIDAK BERINDEKS</th>
                <th colspan="2">BIL JURNAL</th>
                <td class="text-center"><?= count($jurnaltidakindex) ?></td>
            </tr>
            <tr>
                <th colspan="2">JUMLAH JURNAL SEBAGAI PENULIS UTAMA</th>
                <td class="text-center"><?=
                    count(array_filter($jurnaltidakindex, function ($var) {
                                return ($var['WriterStatusID'] == '1');
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="2">JUMLAH JURNAL SEBAGAI PENULIS BERSAMA</th>
                <td class="text-center"><?=
                    count(array_filter($jurnaltidakindex, function ($var) {
                                return ($var['WriterStatusID'] == '4' || $var['WriterStatusID'] == '5');
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="3">BILANGAN BUKU</th>
                <td class="text-center"><?= count($model->book) ?>
                </td>
            </tr>
            <tr>
                <th colspan="3">BILANGAN BAB DALAM BUKU</th>
                <td class="text-center"><?= count($model->bookChapter) ?>
                </td>
            </tr>
            <tr>
                <th colspan="3">PENERBITAN UMUM</th>
                <td class="text-center"><?=
                    count(array_filter($model->publication, function ($var) {
                                return $var['Keterangan_PublicationTypeID'] == 'General Publication';
                            }))
                    ?>
                </td>
            </tr>
            <tr>
                <th colspan="3">BUKU KARYA ASLI (DITERBITKAN OLEH PENERBIT YANG DIIKTIRAF</th>
                <td class="text-center"><?=
                    count(array_filter($model->publication, function ($var) {
                                return $var['Keterangan_PublicationTypeID'] == 'Original Work';
                            }))
                    ?>
                </td>
            </tr>
            <?php foreach ($penerbitan as $p) { ?>
                <tr>     
                    <th colspan="3"><?= $p->requirement; ?></th>  
                    <?php
                    if ($p->id == 1) {
                        $j = count($jurnalindex) + count($jurnaltidakindex) + count($model->bookChapter);
                        if ($j >= $p->ans_no) {
                            $s = 1;
                        } else {
                            $s = 0;
                        }
                    } else if ($p->id == 2) {
                        if (count($jurnalindex) >= $p->ans_no) {
                            $s = 1;
                        } else {
                            $s = 0;
                        }
                    } else if ($p->id == 3) {
                        $j = count($jurnalindex) + count($jurnaltidakindex);
                        if ($j >= $p->ans_no) {
                            $s = 1;
                        } else {
                            $s = 0;
                        }
                    } else if ($p->id == 4) {
                        $j = count(array_filter($jurnaltidakindex, function ($var) {
                                    return ($var['WriterStatusID'] == '1');
                                }));
                        if ($j >= $p->ans_no) {
                            $s = 1;
                        } else {
                            $s = 0;
                        }
                    } else if ($p->id == 5) {
                        $j = count(array_filter($model->publication, function ($var) {
                                    return $var['Keterangan_PublicationTypeID'] == 'Original Work';
                                }));
                        if ($j >= $p->ans_no) {
                            $s = 1;
                        } else {
                            $s = 0;
                        }
                    } else {
                        //temp for sitasi
                        $s = 2;
                    }

                    if ($s == 1) {
                        $color = "#00FF00";
                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                    } else if ($s == 0) {
                        $color = "red";
                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                    } else {
                        $color = "#1E90FF";
                        $button = "HOLD";
                    }
                    ?>
                    <td colspan="2" style="background-color:<?= $color; ?>" class="text-center">  
                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th rowspan="2">PENGAJARAN</th>
                <th>PRA-SISWAZAH</th>
                <th colspan="2">JUMLAH KREDIT MENGAJAR</th>
                <td class="text-center"><?= $model->jumlahKreditMengajar('PRASISWAZAH') ?></td>
            </tr>
            <tr>
                <th>PASCA-SISWAZAH</th>
                <th colspan="2">JUMLAH KREDIT MENGAJAR</th>
                <td class="text-center"><?= $model->jumlahKreditMengajar('PASCASISWAZAH') ?></td>
            </tr>
            <?php foreach ($pengajaran as $p) { ?>
                <tr>     
                    <th colspan="3"><?= $p->requirement; ?></th>  
                    <?php
                    if ($p->id == 1) {
                        if ($model->jumlahKreditMengajar('PRASISWAZAH') >= $p->ans_no) {
                            $s = 1;
                        } else {
                            $s = 0;
                        }
                    } else if ($p->id == 2) {
                        if ($model->jumlahKreditMengajar('PASCASISWAZAH') >= $p->ans_no) {
                            $s = 1;
                        } else {
                            $s = 0;
                        }
                    }

                    if ($s == 1) {
                        $color = "#00FF00";
                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                    } else {
                        $color = "red";
                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                    }
                    ?>
                    <td colspan="2" style="background-color:<?= $color; ?>" class="text-center">  
                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th rowspan="10">PENYELIAAN (COMPLETE)</th>
                <th rowspan="5">PHD</th>
                <th colspan="2">PENYELIA</th>
                <td class="text-center"><?=
                    count(array_filter($model->penyeliaan, function ($var) {
                                return ($var['StatusPengajianBI'] == 'STUDY COMPLETED' && $var['LevelPengajian'] == 'PHD' && ($var['TahapPenyeliaanBM'] == 'PENYELIA'));
                            }))
                    ?></td>
            </tr>
            <tr>
                <th colspan="2">PENYELIA UTAMA</th>
                <td class="text-center"><?=
                    count(array_filter($model->penyeliaan, function ($var) {
                                return ($var['StatusPengajianBI'] == 'STUDY COMPLETED' && $var['LevelPengajian'] == 'PHD' && ($var['TahapPenyeliaanBM'] == 'PENYELIA UTAMA'));
                            }))
                    ?></td>
            </tr>
            <tr>
                <th colspan="2">PENYELIA BERSAMA</th>
                <td class="text-center"><?=
                    count(array_filter($model->penyeliaan, function ($var) {
                                return ($var['StatusPengajianBI'] == 'STUDY COMPLETED' && $var['LevelPengajian'] == 'PHD' && ($var['TahapPenyeliaanBM'] == 'PENYELIA BERSAMA'));
                            }))
                    ?></td>
            </tr>
            <tr>
                <th colspan="2">PENGERUSI JK PENYELIAAN</th>
                <td class="text-center"><?=
                    count(array_filter($model->penyeliaan, function ($var) {
                                return ($var['StatusPengajianBI'] == 'STUDY COMPLETED' && $var['LevelPengajian'] == 'PHD' && ($var['TahapPenyeliaanBM'] == 'PENGERUSI J/K PENYELIAAN'));
                            }))
                    ?></td>
            </tr>
            <tr>
                <th colspan="2">AJK PENYELIAAN</th>
                <td class="text-center"><?=
                    count(array_filter($model->penyeliaan, function ($var) {
                                return ($var['StatusPengajianBI'] == 'STUDY COMPLETED' && $var['LevelPengajian'] == 'PHD' && ($var['TahapPenyeliaanBM'] == 'AHLI J/K PENYELIAAN'));
                            }))
                    ?></td>
            </tr>
            <tr>
                <th rowspan="5">MASTER</th>
                <th colspan="2">PENYELIA</th>
                <td class="text-center"><?=
                    count(array_filter($model->penyeliaan, function ($var) {
                                return ($var['StatusPengajianBI'] == 'STUDY COMPLETED' && $var['LevelPengajian'] == 'MASTER' && ($var['TahapPenyeliaanBM'] == 'PENYELIA'));
                            }))
                    ?></td>
            </tr>
            <tr>
                <th colspan="2">PENYELIA UTAMA</th>
                <td class="text-center"><?=
                    count(array_filter($model->penyeliaan, function ($var) {
                                return ($var['StatusPengajianBI'] == 'STUDY COMPLETED' && $var['LevelPengajian'] == 'MASTER' && ($var['TahapPenyeliaanBM'] == 'PENYELIA UTAMA'));
                            }))
                    ?></td>
            </tr>
            <tr>
                <th colspan="2">PENYELIA BERSAMA</th>
                <td class="text-center"><?=
                    count(array_filter($model->penyeliaan, function ($var) {
                                return ($var['StatusPengajianBI'] == 'STUDY COMPLETED' && $var['LevelPengajian'] == 'MASTER' && ($var['TahapPenyeliaanBM'] == 'PENYELIA BERSAMA'));
                            }))
                    ?></td>
            </tr>
            <tr>
                <th colspan="2">PENGERUSI JK PENYELIAAN</th>
                <td class="text-center"><?=
                    count(array_filter($model->penyeliaan, function ($var) {
                                return ($var['StatusPengajianBI'] == 'STUDY COMPLETED' && $var['LevelPengajian'] == 'MASTER' && ($var['TahapPenyeliaanBM'] == 'PENGERUSI J/K PENYELIAAN'));
                            }))
                    ?></td>
            </tr>
            <tr>
                <th colspan="2">AJK PENYELIAAN</th>
                <td class="text-center"><?=
                    count(array_filter($model->penyeliaan, function ($var) {
                                return ($var['StatusPengajianBI'] == 'STUDY COMPLETED' && $var['LevelPengajian'] == 'MASTER' && ($var['TahapPenyeliaanBM'] == 'AHLI J/K PENYELIAAN'));
                            }))
                    ?></td>
            </tr>
            <?php foreach ($penyeliaan as $p) { ?>
                <tr>     
                    <th colspan="3"><?= $p->requirement; ?></th>  
                    <?php
                    if ($p->id == 1) {
                        $j = count(array_filter($model->penyeliaan, function ($var) {
                                    return ($var['StatusPengajianBI'] == 'STUDY COMPLETED' && $var['LevelPengajian'] == 'PHD' && ($var['TahapPenyeliaanBM'] == 'PENYELIA UTAMA'));
                                }));
                        if ($j >= $p->ans_no) {
                            $s = 1;
                        } else {
                            $s = 0;
                        }
                    } else if ($p->id == 2) {
                        $j = count(array_filter($model->penyeliaan, function ($var) {
                                    return ($var['StatusPengajianBI'] == 'STUDY COMPLETED' && $var['LevelPengajian'] == 'MASTER' && ($var['TahapPenyeliaanBM'] == 'PENYELIA UTAMA'));
                                }));
                        if ($j >= $p->ans_no) {
                            $s = 1;
                        } else {
                            $s = 0;
                        }
                    }

                    if ($s == 1) {
                        $color = "#00FF00";
                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                    } else {
                        $color = "red";
                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                    }
                    ?>
                    <td colspan="2" style="background-color:<?= $color; ?>" class="text-center">  
                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>   
                <th rowspan="9">SANJUNGAN & KEPIMPINAN AKADEMIK</th>  
                <th rowspan="8">PERSIDANGAN</th>
                <?php
                $persidangani = array_filter($model->persidangan, function ($var) {
                    return ($var['ConfLevel'] == 'International');
                });
                $persidangann = array_filter($model->persidangan, function ($var) {
                    return ($var['ConfLevel'] == 'National');
                });
                ?>
                <th rowspan="4">ANTARABANGSA</th>
                <th>UCAPTAMA / PLENARI</th>
                <td class="text-center"><?=
                    count(array_filter($persidangani, function ($var) {
                                return ($var['Role'] == 'Ahli Panel' || $var['Role'] == 'Keynote Speaker');
                            }))
                    ?></td>
            </tr>
            <tr>
                <th>PEMBENTANG LISAN</th>
                <td class="text-center"><?=
                    count(array_filter($persidangani, function ($var) {
                                return ($var['Role'] == 'Pembentang' || $var['Role'] == 'Pembentang Jemputan');
                            }))
                    ?></td>
            </tr>
            <tr>
                <th>PEMBENTANG POSTER</th>
                <td class="text-center"><?=
                    count(array_filter($persidangani, function ($var) {
                                return ($var['Role'] == 'Pembentang Poster');
                            }))
                    ?></td>
            </tr>
            <tr>
                <th>PESERTA</th>
                <td class="text-center"><?=
                    count(array_filter($persidangani, function ($var) {
                                return ($var['Role'] == 'Peserta');
                            }))
                    ?></td>
            </tr>
            <tr>
                <th rowspan="4">KEBANGSAAN</th>
                <th>UCAPTAMA / PLENARI</th>
                <td class="text-center"><?=
                    count(array_filter($persidangann, function ($var) {
                                return ($var['Role'] == 'Ahli Panel' || $var['Role'] == 'Keynote Speaker');
                            }))
                    ?></td>
            </tr>
            <tr>
                <th>PEMBENTANG LISAN</th>
                <td class="text-center"><?=
                    count(array_filter($persidangann, function ($var) {
                                return ($var['Role'] == 'Pembentang' || $var['Role'] == 'Pembentang Jemputan');
                            }))
                    ?></td>
            </tr>
            <tr>
                <th>PEMBENTANG POSTER</th>
                <td class="text-center"><?=
                    count(array_filter($persidangann, function ($var) {
                                return ($var['Role'] == 'Pembentang Poster');
                            }))
                    ?></td>
            </tr>
            <tr>
                <th>PESERTA</th>
                <td class="text-center"><?=
                    count(array_filter($persidangann, function ($var) {
                                return ($var['Role'] == 'Peserta');
                            }))
                    ?></td>
            </tr>
            <tr>
                <th>EDITOR</th>
                <th colspan="2">JURNAL BERINDEKS</th>
                <td class="text-center"><?=
                    count(array_filter(($model->journalNational + $model->journalInternational), function ($var) {
                                return (($var['CitedJournal'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['CitedJournal'] == 'Indexed') && $var['AuthorType'] == 'Editor');
                            }))
                    ?></td>
            </tr>  
            <?php foreach ($sanjungan as $p) { ?>
                <tr>     
                    <th colspan="3"><?= $p->requirement; ?></th>  
                    <?php
                    if ($p->id == 1) {
                        $j = count(array_filter(($model->journalNational + $model->journalInternational), function ($var) {
                                    return (($var['CitedJournal'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['CitedJournal'] == 'Indexed') && $var['AuthorType'] == 'Editor');
                                }));
                        if ($j >= $p->ans_no) {
                            $s = 1;
                        } else {
                            $s = 0;
                        }
                    } else {
                        //temp for (no data)
                        $s = 2;
                    }

                    if ($s == 1) {
                        $color = "#00FF00";
                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                    } else if ($s == 0) {
                        $color = "red";
                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                    } else {
                        $color = "#1E90FF";
                        $button = "HOLD";
                    }
                    ?>
                    <td colspan="2" style="background-color:<?= $color; ?>" class="text-center">  
                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th rowspan="6"> PERUNDINGAN / JARINGAN INDUSTRI / KLINIKAL</th>
                <th rowspan="2">PERUNDINGAN (ANTARABANGSA)</th>
                <th colspan="2"> BILANGAN (KETUA)</th>
                <td class="text-center"><?=
                    count(array_filter($model->consultancy, function ($var) {
                                return ($var['ConsultationType'] == 'Consultation' && $var['KeteranganBI_ConsultationLevelID'] == 'International' && $var['Keterangan_MembershipID'] == 'Leader');
                            }))
                    ?></td>
            </tr>
            <tr>
                <th colspan="2"> NILAI (RM)</th>
                <td class="text-center"><?=
                    array_sum(array_column(array_filter($model->consultancy, function ($var) {
                                        return ($var['ConsultationType'] == 'Consultation' && $var['KeteranganBI_ConsultationLevelID'] == 'International' && $var['Keterangan_MembershipID'] == 'Leader');
                                    }), 'TotalCost'))
                    ?></td>
            </tr> 
            <tr>
                <th rowspan="2">PERUNDINGAN (KEBANGSAAN)</th>
                <th colspan="2"> BILANGAN (KETUA)</th>
                <td class="text-center"><?=
                    count(array_filter($model->consultancy, function ($var) {
                                return ($var['ConsultationType'] == 'Consultation' && $var['KeteranganBI_ConsultationLevelID'] == 'National' && $var['Keterangan_MembershipID'] == 'Leader');
                            }))
                    ?></td>
            </tr>
            <tr>
                <th colspan="2"> NILAI (RM)</th>
                <td class="text-center"><?=
                    array_sum(array_column(array_filter($model->consultancy, function ($var) {
                                        return ($var['ConsultationType'] == 'Consultation' && $var['KeteranganBI_ConsultationLevelID'] == 'National' && $var['Keterangan_MembershipID'] == 'Leader');
                                    }), 'TotalCost'))
                    ?></td>
            </tr> 
            <tr>
                <th rowspan="2">KHIDMAT PROFESIONAL</th>
                <th colspan="2"> BILANGAN (KETUA)</th>
                <td class="text-center"><?=
                    count(array_filter($model->consultancy, function ($var) {
                                return ($var['ConsultationType'] == 'Professional Service' && $var['Keterangan_MembershipID'] == 'Leader');
                            }))
                    ?></td>
            </tr>
            <tr>
                <th colspan="2"> NILAI (RM)</th>
                <td class="text-center"><?=
                    array_sum(array_column(array_filter($model->consultancy, function ($var) {
                                        return ($var['ConsultationType'] == 'Professional Service' && $var['Keterangan_MembershipID'] == 'Leader');
                                    }), 'TotalCost'))
                    ?></td>
            </tr> 
            <?php foreach ($perundingan as $p) { ?>
                <tr>     
                    <th colspan="3"><?= $p->requirement; ?></th>  
                    <?php
                    //temp (no data)
                    $s = 2;

                    if ($s == 1) {
                        $color = "#00FF00";
                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                    } else if ($s == 0) {
                        $color = "red";
                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                    } else {
                        $color = "#1E90FF";
                        $button = "HOLD";
                    }
                    ?>
                    <td colspan="2" style="background-color:<?= $color; ?>" class="text-center">  
                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>