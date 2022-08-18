<?php echo $this->render('menu'); ?>  
<?php echo $this->render('main', ['biodata' => $model]); ?> 
<div class="x_panel"> 
    <div class="col-md-10 col-sm-10 col-xs-10  col-md-offset-1 col-sm-offset-11 col--xs-offset-11"> 

        <h2 class="StepTitle">SUMMARY</h2>
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">

                <tr>
                    <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PENYELIDIKAN</th>
                </tr>
                <tr> 
                    <th class="text-center" colspan="3">KRITERIA</th> 
                    <th class="text-center">JUMLAH SEMASA</th> 
                </tr> 
                <?php
                $researchleader = array_filter($model->research2, function ($var) {
                    return ($var['Membership'] == 'Leader');
                });
                $researchmember = array_filter($model->research2, function ($var) {
                    return ($var['Membership'] == 'Member');
                });
                ?>
                <tr>    
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
                    <td class="text-center"><?= number_format(array_sum(array_column($model->research2, 'Amount')), 2) ?></td>
                </tr>
            </table>
            <table class="table table-sm table-bordered jambo_table table-striped">
                <tr>
                    <th colspan="3" class="text-center" style="background-color:#2A3F54; color:white;">KATEGORI GERAN (SEBAGAI PENYELIDIK UTAMA)</th>
                </tr>
                <tr> 
                    <th class="text-center" colspan="2">KRITERIA</th> 
                    <th class="text-center">JUMLAH SEMASA</th> 
                </tr> 
                <?php
                $g = $model->researchGrantLevel;
                foreach ($g as $g) {
                    ?>
                    <tr> 
                        <th rowspan="9" width="20%"><?= $g->GrantLevel ? strtoupper($g->GrantLevel) : 'NULL'; ?></th> 
                    </tr>
                    <?php
                    $a = $model->researchAgencyType;
                    foreach ($a as $a) {
                        ?>
                        <tr>
                            <td><?= strtoupper($a->AgencyType); ?></td>
                            <td class="text-center" width="20%">
                                <?= $model->s($g->GrantLevel, $a->AgencyType, $model->ICNO); ?>                               
                            </td>
                        </tr>

                        <?php
                    }
                }
                ?>  
            </table>

            <table class="table table-sm table-bordered jambo_table table-striped">

                <tr>
                    <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PENERBITAN (YANG DISAHKAN)</th> 
                </tr>  
                <tr> 
                    <th class="text-center" colspan="3">KRITERIA</th> 
                    <th class="text-center">JUMLAH SEMASA</th> 
                </tr> 
                <tr>    
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

            </table>

            <table class="table table-sm table-bordered jambo_table table-striped">
                <tr>
                    <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PENGAJARAN</th>
                </tr> 
                <tr> 
                    <th class="text-center" colspan="3">KRITERIA</th> 
                    <th class="text-center">JUMLAH SEMASA</th> 
                </tr> 

                <tr> 
                    <th>PRA-SISWAZAH</th>
                    <th colspan="2">JUMLAH KREDIT MENGAJAR</th>
                    <td class="text-center"><?= $model->jumlahKreditMengajar('PRASISWAZAH') ?></td>
                </tr>
                <tr>
                    <th>PASCA-SISWAZAH</th>
                    <th colspan="2">JUMLAH KREDIT MENGAJAR</th>
                    <td class="text-center"><?= $model->jumlahKreditMengajar('PASCASISWAZAH') ?></td>
                </tr>
            </table>

            <table class="table table-sm table-bordered jambo_table table-striped">
                <tr> 
                    <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PENYELIAAN (COMPLETE)</th> 
                </tr> 

                <tr> 
                    <th class="text-center" colspan="3">KRITERIA</th> 
                    <th class="text-center">JUMLAH SEMASA</th> 
                </tr> 
                <tr> 
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
            </table>

            <table class="table table-sm table-bordered jambo_table table-striped">
                <tr> 
                    <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PERSIDANGAN</th>  

                </tr> 

                <tr> 
                    <th class="text-center" colspan="3">KRITERIA</th> 
                    <th class="text-center">JUMLAH SEMASA</th> 
                </tr>
                <tr>    
                    <?php
                    $persidangani = array_filter($model->persidangan, function ($var) {
                        return ($var['ConfLevel'] == 'International');
                    });
                    $persidangann = array_filter($model->persidangan, function ($var) {
                        return ($var['ConfLevel'] == 'National');
                    });
                    ?>
                    <th rowspan="4" colspan ="2">ANTARABANGSA</th>
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
                    <th rowspan="4" colspan ="2">KEBANGSAAN</th>
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
                    <th colspan="2">EDITOR</th>
                    <th>JURNAL BERINDEKS</th>
                    <td class="text-center"><?=
                        count(array_filter(($model->journalNational + $model->journalInternational), function ($var) {
                                    return (($var['CitedJournal'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['CitedJournal'] == 'Indexed') && $var['AuthorType'] == 'Editor');
                                }))
                        ?></td>
                </tr>   
            </table>

            <table class="table table-sm table-bordered jambo_table table-striped">
                <tr>
                    <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PERUNDINGAN / JARINGAN INDUSTRI / KLINIKAL</th>
                </tr> 
                <tr> 
                    <th class="text-center" colspan="3">KRITERIA</th> 
                    <th class="text-center">JUMLAH SEMASA</th> 
                </tr>
                <tr> 
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
            </table> 
        </div>
    </div>
</div>