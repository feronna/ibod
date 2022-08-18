<?php
//use yii\helpers\Html;
//use kartik\form\ActiveForm;
//use kartik\select2\Select2;
//use yii\helpers\ArrayHelper;
//use dosamigos\datepicker\DatePicker;
//use dosamigos\tinymce\TinyMce;
?> 
<?php echo $this->render('menu'); ?> 
<div class="x_panel"> 
    <div class="x_title">
        <h2>SYARAT KHUSUS</h2> 
        <div class="clearfix"></div>
    </div> 
    <div class="x_content">  
        <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">

                <tr> 
                    <th class="text-center" colspan="5">PENYELIDIKAN</th> 
                </tr> 

                <tr>
                    <th style="width: 60%;" class="text-center" colspan="3">PENYELIDIK UTAMA</th> 
                    <th style="width: 20%;">
                        BIL. GERAN : <span class="required" style="color:red;"><?php
                            $researchleader = array_filter($model->research, function ($var) {
                                return ($var['Membership'] == 'Leader');
                            });

                            echo count($researchleader);
                            ?>
                        </span>
                    </th>  
                    <th style="width: 20%;">NILAI (RM) : <span class="required" style="color:red;"><?= number_format(array_sum(array_column($researchleader, 'Amount'))); ?></span></th>
                </tr> 
                <tr>
                    <th class="text-center" colspan="3"> PENYELIDIK BERSAMA</th> 
                    <th style="width: 20%;">BIL. GERAN : <span class="required" style="color:red;"><?php
                            $researchmember = array_filter($model->research, function ($var) {
                                return ($var['Membership'] == 'Member');
                            });

                            echo count($researchmember);
                            ?>
                        </span>
                    </th>  
                    <th style="width: 20%;">NILAI (RM) : <span class="required" style="color:red;"><?= number_format(array_sum(array_column($researchmember, 'Amount'))); ?></span></th>
                </tr> 
                <tr>
                    <th class="text-center" colspan="4">JUMLAH GERAN (RM)</th>  
                    <th style="width: 20%;">NILAI (RM) : <span class="required" style="color:red;"><?= number_format((array_sum(array_column($researchleader, 'Amount')) + (array_sum(array_column($researchmember, 'Amount'))))); ?></span></th>
                </tr>
                <tr>
                    <th class="text-center" colspan="5">KATEGORI GERAN (SEBAGAI PENYELIDIK UTAMA)</th>   
                </tr>
                <tr>
                    <th class="text-center">UMS</th> 
                    <th class="text-center">KPM</th>
                    <th class="text-center">ANTARABANGSA</th>
                    <th class="text-center">SWASTA</th>
                    <th class="text-center">KERAJAAN</th>
                </tr>
                <tr>
                    <th class="text-center" style="width: 20%;"><span class="required" style="color:red;">
                            <?php
                            $ums = count(array_filter($researchleader, function ($var) {
                                        return ($var['AgencyName'] == 'UNIVERSITI MALAYSIA SABAH');
                                    }));

                            echo $ums;
                            ?></span>
                    </th> 
                    <th class="text-center" style="width: 20%;"><span class="required" style="color:red;">
                            <?php
                            $kpm = count(array_filter($researchleader, function ($var) {
                                        return ($var['AgencyName'] == 'KEMENTERIAN PENGAJIAN TINGGI ' || $var['AgencyName'] == 'KEMENTERIAN PENDIDIKAN MALAYSIA');
                                    }));

                            echo $kpm;
                            ?></span>
                    </th>
                    <th class="text-center" style="width: 20%;"><span class="required" style="color:red;">
                            <?php
                            $ant = count(array_filter($researchleader, function ($var) {
                                        return ($var['AgencyStatusID'] == '5' || $var['AgencyStatusID'] == '6' || ($var['AgencyStatusID'] == '3' && $var['GrantTypeDecs'] == 'GERAN ANTARABANGSA'));
                                    }));

                            echo $ant;
                            ?></span>
                    </th>
                    <th class="text-center" style="width: 20%;"><span class="required" style="color:red;">
                            <?php
                            $swasta = count(array_filter($researchleader, function ($var) {
                                        return ($var['AgencyStatusID'] == '2' || $var['AgencyStatusID'] == '4' || ($var['AgencyStatusID'] == '3' && $var['GrantTypeDecs'] == 'GERAN GERAN NGO/SWASTA'));
                                    }));

                            echo $swasta;
                            ?></span>
                    </th>
                    <th class="text-center" style="width: 20%;"><span class="required" style="color:red;">
                            <?php
                            $kerajaan = count(array_filter($researchleader, function ($var) {
                                        return ($var['AgencyStatusID'] == '1' && $var['AgencyName'] != 'UNIVERSITI MALAYSIA SABAH' && $var['AgencyName'] != 'KEMENTERIAN PENGAJIAN TINGGI ' && $var['AgencyName'] != 'KEMENTERIAN PENDIDIKAN MALAYSIA');
                                    }));

                            echo $kerajaan;
                            ?></span> 
                    </th>
                </tr>


            </table>


            <table class="table table-sm table-bordered jambo_table table-striped">

                <tr> 
                    <th class="text-center" colspan="4">PENYELIDIKAN</th> 
                </tr>

                <tr> 
                    <th class="text-center" style="width: 25%;">/</th> 
                    <th class="text-center" style="width: 25%;">BIL. JURNAL</th> 
                    <th class="text-center" style="width: 25%;">JUMLAH JURNAL SEBAGAI PENULIS UTAMA</th> 
                    <th class="text-center" style="width: 25%;">JUMLAH JURNAL SEBAGAI PENULIS BERSAMA</th> 
                </tr>

                <tr> 
                    <th class="text-center">JURNAL BERINDEKS</th> 
                    <th class="text-center"><span class="required" style="color:red;">
                            <?php
                            $jurnalindex = array_filter(($model->journalNational + $model->journalInternational), function ($var) {
                                return ($var['CitedJournal'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['CitedJournal'] == 'Indexed');
                            });

                            echo count($jurnalindex);
                            ?>
                        </span></th> 
                    <th class="text-center"><span class="required" style="color:red;">
                            <?php
                            $jurnalindex1 = count(array_filter($jurnalindex, function ($var) {
                                        return ($var['WriterStatusID'] == '1');
                                    }));

                            echo $jurnalindex1;
                            ?>
                        </span></th> 
                    <th class="text-center"><span class="required" style="color:red;">
                            <?php
                            $jurnalindex2 = count(array_filter($jurnalindex, function ($var) {
                                        return ($var['WriterStatusID'] == '4' || $var['WriterStatusID'] == '5');
                                    }));

                            echo $jurnalindex2;
                            ?>
                        </span></th>  
                </tr>

                <tr> 
                    <th class="text-center">JURNAL TIDAK BERINDEKS</th> 
                    <th class="text-center"><span class="required" style="color:red;">
                            <?php
                            $jurnaltidakindex = array_filter(($model->journalNational + $model->journalInternational), function ($var) {
                                return ($var['CitedJournal'] != 'High-Indexed (SCOPUS, WOS, ERA)' && $var['CitedJournal'] != 'Indexed');
                            });

                            echo count($jurnaltidakindex);
                            ?>
                        </span></th> 
                    <th class="text-center"><span class="required" style="color:red;">
                            <?php
                            $jurnaltidakindex1 = count(array_filter($jurnaltidakindex, function ($var) {
                                        return ($var['WriterStatusID'] == '1');
                                    }));

                            echo $jurnaltidakindex1;
                            ?>
                        </span></th> 
                    <th class="text-center"><span class="required" style="color:red;"> 
                            <?php
                            $jurnaltidakindex2 = count(array_filter($jurnaltidakindex, function ($var) {
                                        return ($var['WriterStatusID'] == '4' || $var['WriterStatusID'] == '5');
                                    }));

                            echo $jurnaltidakindex2;
                            ?>
                        </span></th>  
                </tr>

                <tr> 
                    <th class="text-center">/</th> 
                    <th class="text-center">SCOPUS</th> 
                    <th class="text-center">GOOGLE SCHOLAR</th> 
                    <th class="text-center">WOS</th> 
                </tr>

                <tr> 
                    <th class="text-center">JUMLAH H-INDEKS</th> 
                    <th class="text-center"><span class="required" style="color:red;"></span></th> 
                    <th class="text-center"><span class="required" style="color:red;"></span></th> 
                    <th class="text-center"><span class="required" style="color:red;"></span></th>  
                </tr>

                <tr> 
                    <th class="text-center">JUMLAH SITASI</th> 
                    <th class="text-center"><span class="required" style="color:red;"></span></th> 
                    <th class="text-center"><span class="required" style="color:red;"></span></th> 
                    <th class="text-center"><span class="required" style="color:red;"></span></th>  
                </tr>

                <tr> 
                    <th class="text-center" colspan="4">/</th>  
                </tr>

                <tr> 
                    <th class="text-center">BILANGAN BUKU</th> 
                    <th class="text-center">BILANGAN BAB DALAM BUKU</th> 
                    <th class="text-center">PENERBITAN UMUM</th> 
                    <th class="text-center">BUKU KARYA ASLI (DITERBITKAN OLEH PENERBIT YANG DIIKTIRAF)</th> 
                </tr>

                <tr> 
                    <th class="text-center"><span class="required" style="color:red;"> </span></th> 
                    <th class="text-center"><span class="required" style="color:red;"></span></th> 
                    <th class="text-center"><span class="required" style="color:red;"></span></th> 
                    <th class="text-center"><span class="required" style="color:red;"></span></th>  
                </tr>

            </table>

            <table class="table table-sm table-bordered jambo_table table-striped">

                <tr> 
                    <th class="text-center" colspan="4">PENGAJARAN</th> 
                </tr> 
                <tr> 
                    <th class="text-center" style="width: 25%;">PRA-SISWAZAH</th> 
                    <th class="text-center" style="width: 25%;">JUMLAH KREDIT : <span class="required" style="color:red;"><?= $model->jumlahKreditMengajar('PRASISWAZAH')? $model->jumlahKreditMengajar('PRASISWAZAH'):'-';?></span></th>   
                    <th class="text-center" style="width: 25%;">PENILAIAN PENGAJARAN</th> 
                    <th class="text-center" style="width: 25%;">JUMLAH KREDIT : <span class="required" style="color:red;"><?= $model->jumlahKreditMengajar('PASCASISWAZAH')? $model->jumlahKreditMengajar('PASCASISWAZAH'):'-';?></span></th>   
                </tr>
                
            </table>
            
            <table class="table table-sm table-bordered jambo_table table-striped">

                <tr> 
                    <th class="text-center" colspan="5">PENYELIAAN</th> 
                </tr>
                <tr> 
                    <th colspan="5">PHD</th> 
                </tr> 
                <tr> 
                    <th class="text-center">PENYELIA</th> 
                    <th class="text-center">PENYELIA UTAMA</th> 
                    <th class="text-center">PENYELIA BERSAMA</th> 
                    <th class="text-center">PENGERUSI AJK PENYELIAAN</th> 
                    <th class="text-center">AJK PENYELIAAN</th>
                </tr>

                <tr> 
                    <th class="text-center"><span class="required" style="color:red;"> 
                        <?= count(array_filter($model->completePenyeliaan, function ($var) {
                        return ($var['LevelPengajian'] == 'PHD' && $var['TahapPenyeliaanBM'] == 'PENYELIA');
                        }));
                        ?>
                        </span></th> 
                        <th class="text-center"><span class="required" style="color:red;">
                            <?= count(array_filter($model->completePenyeliaan, function ($var) {
                        return ($var['LevelPengajian'] == 'PHD' && $var['TahapPenyeliaanBM'] == 'PENYELIA UTAMA');
                        }));
                        ?>
                            </span></th> 
                            <th class="text-center"><span class="required" style="color:red;">
                                <?= count(array_filter($model->completePenyeliaan, function ($var) {
                        return ($var['LevelPengajian'] == 'PHD' && $var['TahapPenyeliaanBM'] == 'PENYELIA BERSAMA');
                        }));
                        ?>
                                </span></th> 
                                <th class="text-center"><span class="required" style="color:red;">
                                    <?= count(array_filter($model->completePenyeliaan, function ($var) {
                        return ($var['LevelPengajian'] == 'PHD' && $var['TahapPenyeliaanBM'] == 'PENGERUSI J/K PENYELIAAN');
                        }));
                        ?>
                                    </span></th>
                                    </th> 
                                <th class="text-center"><span class="required" style="color:red;">
                                    <?= count(array_filter($model->completePenyeliaan, function ($var) {
                        return ($var['LevelPengajian'] == 'PHD' && $var['TahapPenyeliaanBM'] == 'AHLI J/K PENYELIAAN');
                        }));
                        ?>
                                    </span></th>
                </tr>
                
                <tr> 
                    <th colspan="5">MASTER</th> 
                </tr> 
                <tr> 
                    <th class="text-center">PENYELIA</th> 
                    <th class="text-center">PENYELIA UTAMA</th> 
                    <th class="text-center">PENYELIA BERSAMA</th> 
                    <th class="text-center">PENGERUSI AJK PENYELIAAN</th> 
                    <th class="text-center">AJK PENYELIAAN</th>
                </tr>

                <tr> 
                    <th class="text-center"><span class="required" style="color:red;"> 
                        <?= count(array_filter($model->completePenyeliaan, function ($var) {
                        return ($var['LevelPengajian'] == 'MASTER' && $var['TahapPenyeliaanBM'] == 'PENYELIA');
                        }));
                        ?>
                        </span></th> 
                        <th class="text-center"><span class="required" style="color:red;">
                            <?= count(array_filter($model->completePenyeliaan, function ($var) {
                        return ($var['LevelPengajian'] == 'MASTER' && $var['TahapPenyeliaanBM'] == 'PENYELIA UTAMA');
                        }));
                        ?>
                            </span></th> 
                            <th class="text-center"><span class="required" style="color:red;">
                                <?= count(array_filter($model->completePenyeliaan, function ($var) {
                        return ($var['LevelPengajian'] == 'MASTER' && $var['TahapPenyeliaanBM'] == 'PENYELIA BERSAMA');
                        }));
                        ?>
                                </span></th> 
                                <th class="text-center"><span class="required" style="color:red;">
                                    <?= count(array_filter($model->completePenyeliaan, function ($var) {
                        return ($var['LevelPengajian'] == 'MASTER' && $var['TahapPenyeliaanBM'] == 'PENGERUSI J/K PENYELIAAN');
                        }));
                        ?>
                                    </span></th>
                                    </th> 
                                <th class="text-center"><span class="required" style="color:red;">
                                    <?= count(array_filter($model->completePenyeliaan, function ($var) {
                        return ($var['LevelPengajian'] == 'MASTER' && $var['TahapPenyeliaanBM'] == 'AHLI J/K PENYELIAAN');
                        }));
                        ?>
                                    </span></th>
                </tr>
                
            </table>
            
            <table class="table table-sm table-bordered jambo_table table-striped">

                <tr> 
                    <th class="text-center" colspan="3">KHIDMAT MASYARAKAT / UNIVERSITI</th> 
                </tr>
                <tr> 
                    <th class="text-center" style="width: 40%;">/</th> 
                    <th class="text-center" style="width: 30%;">PENGERUSI</th> 
                    <th class="text-center" style="width: 30%;">PENYELIA BERSAMA</th> 
                </tr> 
                <tr> 
                    <th class="text-center">MASYARAKAT</th> 
                    <th class="text-center"><span class="required" style="color:red;">
                        <?=count(array_filter($model->usercv->serviceUniversity, function ($var) {
                        return ($var['role'] == 'Pengerusi' || $var['role'] == 'Chairman');
                        }));
                        ?>
                        </span></th> 
                        <th class="text-center"><span class="required" style="color:red;">
                            <?=count(array_filter($model->usercv->serviceUniversity, function ($var) {
                        return ($var['role'] != 'Pengerusi' && $var['role'] != 'Chairman');
                        }));
                        ?>
                            </span></th>  
                </tr>
                <tr> 
                    <th class="text-center">UNIVERSITI</th> 
                    <th class="text-center"><span class="required" style="color:red;">
                        <?=count(array_filter($model->usercv->serviceCommunity, function ($var) {
                        return ($var['role'] == 'Pengerusi' || $var['role'] == 'Chairman');
                        }));
                        ?>
                        </span></th> 
                        <th class="text-center"><span class="required" style="color:red;">
                            <?=count(array_filter($model->usercv->serviceCommunity, function ($var) {
                        return ($var['role'] != 'Pengerusi' && $var['role'] != 'Chairman');
                        }));
                        ?>
                            </span></th>  
                </tr>
            </table>
            
            <table class="table table-sm table-bordered jambo_table table-striped">

                <tr> 
                    <th class="text-center" colspan="3">PERUNDINGAN / JARINGAN INDUSTRI / KLINIKAL</th> 
                </tr>
                <tr> 
                    <th class="text-center" style="width: 60%;">PERUNDINGAN (ANTARABANGSA)</th> 
                    <th class="text-center" style="width: 20%;">BILANGAN (KETUA) :<span class="required" style="color:red;">
                        <?=count(array_filter($model->consultancy, function ($var) {
                        return ($var['ConsultationType'] == 'Consultation' && $var['KeteranganBI_ConsultationLevelID'] == 'International' && $var['Keterangan_MembershipID'] == 'Leader');
                        }));
                        ?>
                        </span></th> 
                    <th class="text-center" style="width: 20%;">NILAI (RM) :<span class="required" style="color:red;"></span></th> 
                </tr> 
                <tr> 
                    <th class="text-center" style="width: 60%;">PERUNDINGAN (KEBANGSAAN)</th> 
                    <th class="text-center" style="width: 20%;">BILANGAN (KETUA) :<span class="required" style="color:red;">
                        <?=count(array_filter($model->consultancy, function ($var) {
                        return ($var['ConsultationType'] == 'Consultation' && $var['KeteranganBI_ConsultationLevelID'] == 'National' && $var['Keterangan_MembershipID'] == 'Leader');
                        }));
                        ?>
                        </span></th> 
                    <th class="text-center" style="width: 20%;">NILAI (RM) :<span class="required" style="color:red;"></span></th> 
                </tr> 
                <tr> 
                    <th class="text-center" style="width: 60%;">KHIDMAT PROFESIONAL</th> 
                    <th class="text-center" style="width: 20%;">BILANGAN (KETUA) :<span class="required" style="color:red;">
                        <?=count(array_filter($model->consultancy, function ($var) {
                        return ($var['ConsultationType'] == 'Professional Service' && $var['Keterangan_MembershipID'] == 'Leader');
                        }));
                        ?>
                        </span></th> 
                    <th class="text-center" style="width: 20%;">NILAI (RM) :<span class="required" style="color:red;"></span></th> 
                </tr> 
                
            </table>
        </div> 
    </div>
</div>   
