<?php

use yii\helpers\Html;

error_reporting(0);
?>   
<style>
    .btn.btn-app{
        height: auto;
        padding: 5px 5px;
    }
    .btn.btn-app>.badge{
        position: relative;
    }

    .bad{
        display: inline-block;
        min-width: 10px;
        padding: 3px 7px;
        font-size: 16px;
        font-weight: bold;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        background-color: #777777;
        border-radius: 10px;
    }

    h2{
        font-size: 16px;
    }

    #inside{
        background-color: white;
    }

</style>
<?= $this->render('menu'); ?>
<?php echo $this->render('main_head', ['biodata' => $model]); ?> 
<div class="x_panel">

    <div class="x_title" style="border-radius: 10px;">
        <h2><strong>PENYELIDIKAN (SELESAI DAN SEDANG BERJALAN) <i class="fa fa-hand-o-down"></i></strong></h2>
        <p align="right"> 
            <?= Html::a('Kembali', ['search'], ['class' => 'btn btn-primary btn-sm']); ?>
        </p>
        <div class="clearfix"></div>
    </div>
    <?php
    $researchleader = array_filter($model->research2, function ($var) {
        return ($var['Membership'] == 'Leader' && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
    });
    $researchmember = array_filter($model->research2, function ($var) {
        return ($var['Membership'] == 'Member' && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
    });
    ?>
    <div class="x_content"> 
        <div class="btn btn-app" style="color: green;">
            <i class="fa fa-search"></i> PENYELIDIK UTAMA<br><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue">
                    <?= count($researchleader) ?></span><br>
                Bil. Geran
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue">
                    <?= number_format(array_sum(array_column($researchleader, 'Amount')), 2) ?></span>
                <br>Nilai (RM)
            </div>
        </div>

        <div class="btn btn-app" style="color: green;">
            <i class="fa fa-search"></i> PENYELIDIK BERSAMA<br><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?= count($researchmember) ?></span>
                <br> Bil. Geran
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?= number_format(array_sum(array_column($researchmember, 'Amount')), 2) ?></span>
                <br> Nilai (RM)
            </div>
        </div>

        <div class="btn btn-app" style="color: green;">
            <i class="fa fa-search"></i> JUMLAH KESELURUHAN<br><br>
            <div class="btn btn-app" id="inside" style="color: black;"> 
                <span class="bad bg-blue"><?= number_format(array_sum(array_column($model->research2, 'Amount')), 2) ?></span>
                <br> JUMLAH GERAN (RM)
            </div>
        </div>

        <div class="btn btn-app" style="color: green;">
            <i class="fa fa-search"></i> KATEGORI GERAN (SEBAGAI PENYELIDIK UTAMA)<br><br>
            <?php
            $g = $model->researchGrantLevel;
            foreach ($g as $g) {
                ?>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        count(array_filter($researchleader, function ($var) use ($g) {
                                    return ($var['GrantLevel'] == $g->GrantLevel);
                                }))
                        ?></span>
                    <br> <?= $g->GrantLevel != '' ? $g->GrantLevel : 'NULL' ?>
                </div><?php } ?>
        </div>
        <div class="btn btn-app" style="color: green;">
            <i class="fa fa-search"></i> KATEGORI GERAN (SEBAGAI PENYELIDIK BERSAMA)<br><br>
            <?php
            $g = $model->researchGrantLevel;
            foreach ($g as $g) {
                ?>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        count(array_filter($researchmember, function ($var) use ($g) {
                                    return ($var['GrantLevel'] == $g->GrantLevel);
                                }))
                        ?></span>
                    <br> <?= $g->GrantLevel != '' ? $g->GrantLevel : 'NULL' ?>
                </div><?php } ?>
        </div><hr>
    </div> 
</div>  

<div class="x_panel">

    <div class="x_title" style="border-radius: 10px;">
        <h2><strong>PENERBITAN (YANG DISAHKAN)<i class="fa fa-hand-o-down"></i></strong></h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content"> 

        <div class="btn btn-app" style="color: darkred;">
            <i class="fa fa-file-powerpoint-o"></i> Jurnal Berindeks<br><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                            }))
                    ?></span>
                <br> Penulis Utama
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                            }))
                    ?></span>
                <br> Penulis Bersama
            </div>
        </div>

        <div class="btn btn-app" style="color: darkred;">
            <i class="fa fa-file-powerpoint-o"></i> Jurnal Tidak Berindeks<br><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                            }))
                    ?></span>
                <br> Penulis Utama
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                            }))
                    ?></span>
                <br> Penulis Bersama
            </div>
        </div>


        <div class="btn btn-app" style="color: darkred;">
            <i class="fa fa-file-powerpoint-o"></i> Bab Dalam Buku Berindeks<br><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                            }))
                    ?></span>
                <br> Penulis Utama
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                            }))
                    ?></span>
                <br> Penulis Bersama
            </div>
        </div>

        <div class="btn btn-app" style="color: darkred;">
            <i class="fa fa-file-powerpoint-o"></i> Bab Dalam Buku Tidak Berindeks<br><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                            }))
                    ?></span>
                <br> Penulis Utama
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->publication, function ($var) {
                                return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                            }))
                    ?></span>
                <br> Penulis Bersama
            </div>
        </div>


        <hr>
    </div> 
</div>  

<div class="x_panel">

    <div class="x_title" style="border-radius: 10px;">
        <h2><strong>PENGAJARAN <i class="fa fa-hand-o-down"></i></strong></h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <div class="btn btn-app" style="color: orange;">
            <i class="fa fa-users"></i> PRASISWAZAH<br><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->pengajaran, function ($var) {
                                return ($var['KATEGORIPELAJAR'] == 'PRASISWAZAH (PLUMS)' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH PERUBATAN' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH PPG' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH UMUM');
                            }));
                    ?></span>
                <br> Jumlah Mengajar
            </div>
        </div>
        <div class="btn btn-app" style="color: orange;">
            <i class="fa fa-users"></i> PASCASISWAZAH<br><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->pengajaran, function ($var) {
                                return ($var['KATEGORIPELAJAR'] == 'PASCASISWAZAH');
                            }));
                    ?></span>
                <br> Jumlah Mengajar
            </div>
        </div><hr>
    </div> 
</div> 

<div class="x_panel">

    <div class="x_title" style="border-radius: 10px;">
        <h2><strong>PENYELIAAN (TAMAT PENGAJIAN)<i class="fa fa-hand-o-down"></i></strong></h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content"> 
        <div class="btn btn-app" style="color: black;">
            <i class="fa fa-universal-access"></i> PHD<br><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'PHD' && ($var['NamaBM'] == 'PENYELIA'));
                            }))
                    ?></span>
                <br></i> Penyelia
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'PHD' && ($var['NamaBM'] == 'PENYELIA UTAMA '));
                            }))
                    ?></span>
                <br></i> Penyelia Utama 
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'PHD' && $var['NamaBM'] == 'PENYELIA BERSAMA');
                            }))
                    ?></span>
                <br> Penyelia Bersama
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'PHD' && $var['NamaBM'] == 'PENGERUSI J/K PENYELIAAN');
                            }))
                    ?></span>
                <br> PENGERUSI J/K PENYELIAAN
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'PHD' && $var['NamaBM'] == 'AHLI J/K PENYELIAAN');
                            }))
                    ?></span>
                <br> AHLI J/K PENYELIAAN
            </div>
        </div>

        <div class="btn btn-app" style="color: black;">
            <i class="fa fa-universal-access"></i> MASTER<br><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'MASTER' && ($var['NamaBM'] == 'PENYELIA'));
                            }))
                    ?></span>
                <br> Penyelia
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'MASTER' && ($var['NamaBM'] == 'PENYELIA UTAMA '));
                            }))
                    ?></span>
                <br> Penyelia Utama 
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'MASTER' && $var['NamaBM'] == 'PENYELIA BERSAMA');
                            }))
                    ?></span>
                <br> Penyelia Bersama
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'MASTER' && $var['NamaBM'] == 'PENGERUSI J/K PENYELIAAN');
                            }))
                    ?></span>
                <br> PENGERUSI J/K PENYELIAAN
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'MASTER' && $var['NamaBM'] == 'AHLI J/K PENYELIAAN');
                            }))
                    ?></span>
                <br> AHLI J/K PENYELIAAN
            </div>
        </div>
        <div class="btn btn-app" style="color: black;">
            <i class="fa fa-universal-access"></i> M.Phil.<br><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'M.Phil.' && ($var['NamaBM'] == 'PENYELIA'));
                            }))
                    ?></span>
                <br></i> Penyelia
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'M.Phil.' && ($var['NamaBM'] == 'PENYELIA UTAMA '));
                            }))
                    ?></span>
                <br></i> Penyelia Utama 
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'M.Phil.' && $var['NamaBM'] == 'PENYELIA BERSAMA');
                            }))
                    ?></span>
                <br> Penyelia Bersama
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'M.Phil.' && $var['NamaBM'] == 'PENGERUSI J/K PENYELIAAN');
                            }))
                    ?></span>
                <br> PENGERUSI J/K PENYELIAAN
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                <span class="bad bg-blue"><?=
                    count(array_filter($model->penyeliaan2, function ($var) {
                                return (($var['StatusBI'] == 'STUDY COMPLETED' || $var['StatusBI'] == 'EXPECTED TO GRADUATE') && $var['ModLevelName'] == 'M.Phil.' && $var['NamaBM'] == 'AHLI J/K PENYELIAAN');
                            }))
                    ?></span>
                <br> AHLI J/K PENYELIAAN
            </div>
        </div>
        <hr>
    </div> 
</div> 

<div class="x_panel">

    <div class="x_title" style="border-radius: 10px;">
        <h2><strong>PERSIDANGAN (YANG DISAHKAN) <i class="fa fa-hand-o-down"></i></strong></h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content"> 
        <div class="btn btn-app" style="color: blueviolet;">
             <br>
            <?php
            $persidangani = array_filter($model->persidangan2, function ($var) {
                return ($var['Peringkat'] == 'Kebangsaan');
            });
            $persidangann = array_filter($model->persidangan2, function ($var) {
                return ($var['Peringkat'] == 'Antarabangsa');
            });
            $persidanganUni = array_filter($model->persidangan2, function ($var) {
                return ($var['Peringkat'] == 'Universiti');
            });
            $persidanganNeg = array_filter($model->persidangan2, function ($var) {
                return ($var['Peringkat'] == 'Negeri');
            });
            $persidanganNd = array_filter($model->persidangan2, function ($var) {
                return ($var['Peringkat'] == 'Tiada Data');
            });
            ?>

            <div class="btn btn-app" id="inside" style="color: black;">
                Antarabangsa<br>
                <?php foreach ($model->rolepersidangan as $r) { ?>
                    <div class="btn btn-app" id="inside" style="color: black;">
                        <span class="bad bg-blue">
                            <?=
                            count(array_filter($persidangani, function ($var) use ($r) {
                                        return ($var['Peranan'] == $r['Peranan']);
                                    }))
                            ?></span>
                        <br> <?= $r['Peranan'] ?>
                    </div>

                <?php } ?>
            </div><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                Kebangsaan<br>
                <?php foreach ($model->rolepersidangan as $r) { ?>
                    <div class="btn btn-app" id="inside" style="color: black;">
                        <span class="bad bg-blue">
                            <?=
                            count(array_filter($persidangann, function ($var) use ($r) {
                                        return ($var['Peranan'] == $r['Peranan']);
                                    }))
                            ?></span>
                        <br> <?= $r['Peranan'] ?>
                    </div>

                <?php } ?>
            </div><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                Universiti<br>
                <?php foreach ($model->rolepersidangan as $r) { ?>
                    <div class="btn btn-app" id="inside" style="color: black;">
                        <span class="bad bg-blue">
                            <?=
                            count(array_filter($persidanganUni, function ($var) use ($r) {
                                        return ($var['Peranan'] == $r['Peranan']);
                                    }))
                            ?></span>
                        <br> <?= $r['Peranan'] ?>
                    </div>

                <?php } ?>
            </div><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                Negeri<br>
                <?php foreach ($model->rolepersidangan as $r) { ?>
                    <div class="btn btn-app" id="inside" style="color: black;">
                        <span class="bad bg-blue">
                            <?=
                            count(array_filter($persidangannNeg, function ($var) use ($r) {
                                        return ($var['Peranan'] == $r['Peranan']);
                                    }))
                            ?></span>
                        <br> <?= $r['Peranan'] ?>
                    </div>

                <?php } ?>
            </div><br>
            <div class="btn btn-app" id="inside" style="color: black;">
                Tiada Data<br>
                <?php foreach ($model->rolepersidangan as $r) { ?>
                    <div class="btn btn-app" id="inside" style="color: black;">
                        <span class="bad bg-blue">
                            <?=
                            count(array_filter($persidangannNd, function ($var) use ($r) {
                                        return ($var['Peranan'] == $r['Peranan']);
                                    }))
                            ?></span>
                        <br> <?= $r['Peranan'] ?>
                    </div>

                <?php } ?>
            </div>
        </div>

        <!--        <div class="btn btn-app" style="color: blueviolet;">
                    <i class="fa fa-newspaper-o"></i> EDITOR<br><br>
                    <div class="btn btn-app" id="inside" style="color: black;">
                        <span class="bad bg-blue">
        <?php
        //count(array_filter(($model->journalNational + $model->journalInternational), function ($var) {
//                                return (($var['CitedJournal'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['CitedJournal'] == 'Indexed') && $var['AuthorType'] == 'Editor');
//                            }))
        ?></span>
                        <br> Jumlah Jurnal Berindeks
                    </div>
                </div>-->
        <hr>
    </div> <hr>
</div>



<div class="x_panel">

    <div class="x_title" style="border-radius: 10px;">
        <h2><strong>PERUNDINGAN / JARINGAN INDUSTRI / KLINIKAL (YANG DISAHKAN) <i class="fa fa-hand-o-down"></i></strong></h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content"> 
        <div class="btn btn-app" style="color: red;">
            <i class="fa fa-hand-rock-o"></i> Perundingan (Antarabangsa)<br>
            <div class="btn btn-app" id="inside" style="color: black;">
                Ketua<br>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        count(array_filter($model->outreaching, function ($var) {
                                    return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'International' && $var['Keahlian'] == 'Leader');
                                }))
                        ?></span>
                    <br> Bilangan
                </div>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                            return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'International' && $var['Keahlian'] == 'Leader');
                                        }), 'TotalCost'))
                        ?></span>
                    <br> Nilai (RM)
                </div>
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                Member<br>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        count(array_filter($model->outreaching, function ($var) {
                                    return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'International' && $var['Keahlian'] == 'Member');
                                }))
                        ?></span>
                    <br> Bilangan
                </div>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                            return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'International' && $var['Keahlian'] == 'Member');
                                        }), 'TotalCost'))
                        ?></span>
                    <br> Nilai (RM)
                </div>
            </div>
        </div>
        <div class="btn btn-app" style="color: red;">
            <i class="fa fa-hand-rock-o"></i> Perundingan (Kebangsaan)<br>
            <div class="btn btn-app" id="inside" style="color: black;">
                Ketua<br>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        count(array_filter($model->outreaching, function ($var) {
                                    return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'National' && $var['Keahlian'] == 'Leader');
                                }))
                        ?></span>
                    <br> Bilangan
                </div>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                            return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'National' && $var['Keahlian'] == 'Leader');
                                        }), 'TotalCost'))
                        ?></span>
                    <br> Nilai (RM)
                </div>
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                Member<br>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        count(array_filter($model->outreaching, function ($var) {
                                    return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'National' && $var['Keahlian'] == 'Member');
                                }))
                        ?></span>
                    <br> Bilangan
                </div>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                            return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'National' && $var['Keahlian'] == 'Member');
                                        }), 'TotalCost'))
                        ?></span>
                    <br> Nilai (RM)
                </div>
            </div>
        </div>
        <div class="btn btn-app" style="color: red;">
            <i class="fa fa-hand-rock-o"></i> Perundingan (Universiti)<br>
            <div class="btn btn-app" id="inside" style="color: black;">
                Ketua<br>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        count(array_filter($model->outreaching, function ($var) {
                                    return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'University' && $var['Keahlian'] == 'Leader');
                                }))
                        ?></span>
                    <br> Bilangan
                </div>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                            return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'University' && $var['Keahlian'] == 'Leader');
                                        }), 'TotalCost'))
                        ?></span>
                    <br> Nilai (RM)
                </div>
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                Member<br>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        count(array_filter($model->outreaching, function ($var) {
                                    return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'University' && $var['Keahlian'] == 'Member');
                                }))
                        ?></span>
                    <br> Bilangan
                </div>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                            return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'University' && $var['Keahlian'] == 'Member');
                                        }), 'TotalCost'))
                        ?></span>
                    <br> Nilai (RM)
                </div>
            </div>
        </div>

        <div class="btn btn-app" style="color: red;">
            <i class="fa fa-hand-rock-o"></i> Perundingan (Tiada Data)<br>
            <div class="btn btn-app" id="inside" style="color: black;">
                Ketua<br>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        count(array_filter($model->outreaching, function ($var) {
                                    return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'No Data' && $var['Keahlian'] == 'Leader');
                                }))
                        ?></span>
                    <br> Bilangan
                </div>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                            return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'No Data' && $var['Keahlian'] == 'Leader');
                                        }), 'TotalCost'))
                        ?></span>
                    <br> Nilai (RM)
                </div>
            </div>
            <div class="btn btn-app" id="inside" style="color: black;">
                Member<br>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        count(array_filter($model->outreaching, function ($var) {
                                    return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'No Data' && $var['Keahlian'] == 'Member');
                                }))
                        ?></span>
                    <br> Bilangan
                </div>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        array_sum(array_column(array_filter($model->outreaching, function ($var) {
                                            return ($var['StatusPengesahan'] == 'V' && $var['Peringkat'] == 'No Data' && $var['Keahlian'] == 'Member');
                                        }), 'TotalCost'))
                        ?></span>
                    <br> Nilai (RM)
                </div>
            </div>
        </div>
        <br>
        <div class="btn btn-app" style="color: red;">
            <i class="fa fa-hand-rock-o"></i> Perundingan Klinikal<br> 
                <br>
                <div class="btn btn-app" id="inside" style="color: black;">
                    <span class="bad bg-blue"><?=
                        count(array_filter($model->outreachingClinical, function ($var) {
                                    return ($var['ApproveStatus'] == 'V');
                                }))
                        ?></span>
                    <br> Bilangan
                </div>  
        </div>
        <hr>
    </div> 
</div>
