<?php

use app\assets\StepperAsset;
use app\models\cv\TblAccess;
use yii\helpers\Html;
use kartik\popover\PopoverX;

StepperAsset::register($this);

error_reporting(0);
?>
<?php
$cluster = $model->departmentHakiki->cluster;
$nameCluster = '';
if ($cluster == 1) {
    $nameCluster = 'Sains Dan Teknologi';
} elseif ($cluster == 2) {
    $nameCluster = 'Sains Sosial Dan Kemanusiaan';
}
?>
<?php echo $this->render('menu'); ?>   
<?php echo $this->render('main_head', ['biodata' => $model]); ?> 
<div class="x_panel">  
    <center> <p style="font-size:18px;font-weight: bold;"><i class="fa fa-bar-chart"></i> LAPORAN "Data Mentah"</p> </center><br/>

    <div class="clearfix"></div> 
    <div class="x_content">     


        <div class="x_panel"> 
            <div class="x_title">
                <h2><b>PENYELIDIKAN <button type="button" class="btn btn-default"><b>JUMLAH KESELURUHAN : <?= count($model->research2); ?></b></button></b></h2>  
                <p align="right"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> <strong>SUMBER DATA SMPPI</strong></p>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">

                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr> 
                        <th colspan="<?= count($model->researchGrantLevel); ?>" class="text-center" style="background-color:#2A3F54; color:white;">GRANT LEVEL</th>  

                    </tr>   
                    <tr>
                        <?php foreach ($model->researchGrantLevel as $r) { ?> 
                            <th>

                                <?php
                                if (is_null($r['GrantLevel'])) {
                                    echo 'NULL';
                                } else {
                                    echo strtoupper($r['GrantLevel']);
                                }
                                ?> 

                            </th> 
                        <?php } ?>
                    </tr>
                    <tr>    
                        <?php foreach ($model->researchGrantLevel as $r) { ?> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->research2, function ($var) use ($r) {
                                            return ($var['GrantLevel'] == $r['GrantLevel']);
                                        }))
                                ?> 
                            </td>
                        <?php } ?>  
                    </tr>
                </table>
                <br/>
                    <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr> 
                        <th colspan="<?= count($model->researchMembership); ?>" class="text-center" style="background-color:#2A3F54; color:white;">MEMBERSHIP</th>  

                    </tr>   
                    <tr>
                        <?php foreach ($model->researchMembership as $r) { ?> 
                            <th>
                                <?= strtoupper($r['Membership']) ?> 

                            </th> 
                        <?php } ?>
                    </tr>    
                    <tr>    
                        <?php foreach ($model->researchMembership as $r) { ?> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->research2, function ($var) use ($r) {
                                            return ($var['Membership'] == $r['Membership']);
                                        }))
                                ?> 
                            </td>
                        <?php } ?>  
                    </tr> 
                    <tr> 
                        <th colspan="<?= count($model->researchMembership); ?>" class="text-center">TOTAL (RM)</th>  

                    </tr>
                    <tr>    
                        <?php foreach ($model->researchMembership as $r) { ?> 
                            <td class="text-center">
                                <?php
                                $mem = array_filter($model->research2, function ($var) use ($r) {
                                    return ($var['Membership'] == $r['Membership']);
                                });

                                echo number_format(array_sum(array_column($mem, 'Amount')), 2)
                                ?> 
                            </td>
                        <?php } ?>  
                    </tr>
                    <tr>
                        <th colspan="<?= (count($model->researchMembership) - 1); ?>" class="text-center"> Overall (Total)</th>
                        <td class="text-center"><?= number_format(array_sum(array_column($model->research2, 'Amount')), 2) ?></td>
                    </tr> 
                </table> 
                <br/>

            </div>
            <div class="col-md-6 col-sm-6 col-xs-6"> 
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr style="background-color:#2A3F54; color:white;"> 
                        <th class="text-center">STATUS</th>
                        <th class="text-center">LEADER</th>
                        <th class="text-center">MEMBER</th>

                    </tr>   

                    <?php foreach ($model->researchStatus as $r) { ?> 
                        <tr>
                            <th> 
                                <?= strtoupper($r['ResearchStatus']); ?>  
                            </th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->research2, function ($var) use ($r) {
                                            return ($var['ResearchStatus'] == $r['ResearchStatus'] && $var['Membership'] == 'Leader');
                                        }))
                                ?> 
                            </td>
                            
                            <td class="text-center">
                                <?=
                                count(array_filter($model->research2, function ($var) use ($r) {
                                            return ($var['ResearchStatus'] == $r['ResearchStatus'] && $var['Membership'] == 'Member');
                                        }))
                                ?> 
                            </td>
                        </tr>
                    <?php } ?>

                </table> 
            </div>
        </div>
        <div class="x_panel"> 
            <div class="x_title">
                <h2><b>PENERBITAN <button type="button" class="btn btn-default"><b>JUMLAH KESELURUHAN : <?= count($model->publication2); ?></b></button></b></h2>  
                <p align="right"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> <strong>SUMBER DATA SMPPI</strong></p>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr style="background-color:#2A3F54; color:white;"> 
                        <th class="text-center">TYPE</th>  
                        <th class="text-center">TOTAL</th>  
                        <th class="text-center">PUBLISHED</th>   
                    </tr>   

                    <?php foreach ($model->publicationType as $r) { ?> 
                        <tr>
                            <th> 
                                <?= strtoupper($r['Keterangan_PublicationTypeID']); ?>  
                            </th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->publication2, function ($var) use ($r) {
                                            return ($var['Keterangan_PublicationTypeID'] == $r['Keterangan_PublicationTypeID']);
                                        }))
                                ?> 
                            </td>
                            <td class="text-center">
                                <?=
                                count(array_filter($model->publication2, function ($var) use ($r) {
                                            return ($var['Keterangan_PublicationTypeID'] == $r['Keterangan_PublicationTypeID'] && $var['Keterangan_PublicationStatus'] == 'Published');
                                        }))
                                ?> 
                            </td>
                        </tr>
                    <?php } ?>
                </table>

            </div>
            <div class="col-md-6 col-sm-6 col-xs-6"> 
                <table class="table table-sm table-bordered jambo_table table-striped">

                    <tr>
                        <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PENERBITAN</th> 
                    </tr>  
                    <tr> 
                        <th class="text-center" colspan="2">KRITERIA</th> 
                        <th class="text-center">JUMLAH SEMASA</th> 
                    </tr> 
                    <tr>     
                        <th rowspan="3">JURNAL BERINDEKS</th>
                        <th>BIL KESELURUHAN</th> 
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                                    }))
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>SEBAGAI PENULIS UTAMA</th>
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                                    }))
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>SEBAGAI CORRESPONDING AUTHOR</th>
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                    }))
                            ?>
                        </td>
                    </tr> 
                    <tr>     
                        <th rowspan="3">JURNAL TIDAK BERINDEKS</th>
                        <th>BIL KESELURUHAN</th> 
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                                    }))
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>SEBAGAI PENULIS UTAMA</th>
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                                    }))
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>SEBAGAI CORRESPONDING AUTHOR</th>
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                    }))
                            ?>
                        </td>
                    </tr> 
                    <tr>     
                        <th rowspan="3">BAB DALAM BUKU BERINDEKS</th>
                        <th>BIL KESELURUHAN</th> 
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book'));
                                    }))
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>SEBAGAI PENULIS UTAMA</th>
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                                    }))
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>SEBAGAI CORRESPONDING AUTHOR</th>
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                    }))
                            ?>
                        </td>
                    </tr> 
                    <tr>     
                        <th rowspan="3">BAB DALAM BUKU TIDAK BERINDEKS</th>
                        <th>BIL KESELURUHAN</th> 
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book'));
                                    }))
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>SEBAGAI PENULIS UTAMA</th>
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                                    }))
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>SEBAGAI CORRESPONDING AUTHOR</th>
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                    }))
                            ?>
                        </td>
                    </tr>  
                </table>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2><b>PERSIDANGAN <button type="button" class="btn btn-default"><b>JUMLAH KESELURUHAN : <?= count($model->persidangan3); ?></b></button></b></h2>  
                <p align="right"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> <strong>SUMBER DATA SMPPI</strong></p>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table table-sm table-bordered jambo_table table-striped">  
                    <tr>  
                        <th></th>
                        <th colspan="5" class="text-center" style="background-color:#2A3F54; color:white;">PERINGKAT</th> 
                    </tr> 
                    <tr> 
                        <th class="text-center" style="background-color:#2A3F54; color:white;">PERANAN</th>  
                        <th>ANTARABANGSA</th> 
                        <th>KEBANGSAAN</th> 
                        <th>NEGERI</th> 
                        <th>UNIVERSITI</th> 
                        <th>TIADA DATA</th> 
                    </tr>


                    <?php foreach ($model->persidanganRole as $r) { ?> 
                        <tr>

                            <th>
                                <?= strtoupper($r['Peranan']) ?> 

                            </th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->persidangan3, function ($var) use ($r) {
                                            return ($var['Peringkat'] == 'Antarabangsa' && $var['Peranan'] == $r['Peranan']);
                                        }))
                                ?> 
                            </td>
                            <td class="text-center">

                                <?=
                                count(array_filter($model->persidangan3, function ($var) use ($r) {
                                            return ($var['Peringkat'] == 'Kebangsaan' && $var['Peranan'] == $r['Peranan']);
                                        }))
                                ?> 
                            </td>
                            <td class="text-center">
                                <?=
                                count(array_filter($model->persidangan3, function ($var) use ($r) {
                                            return ($var['Peringkat'] == 'Negeri' && $var['Peranan'] == $r['Peranan']);
                                        }))
                                ?> 
                            </td>
                            <td class="text-center">
                                <?=
                                count(array_filter($model->persidangan3, function ($var) use ($r) {
                                            return ($var['Peringkat'] == 'Universiti' && $var['Peranan'] == $r['Peranan']);
                                        }))
                                ?> 
                            </td>
                            <td class="text-center">
                                <?=
                                count(array_filter($model->persidangan3, function ($var) use ($r) {
                                            return ($var['Peringkat'] == 'Tiada Data' && $var['Peranan'] == $r['Peranan']);
                                        }))
                                ?> 
                            </td>

                        </tr>
                    <?php } ?> 
                </table>
            </div> 
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2><b>PERUNDINGAN <button type="button" class="btn btn-default"><b>JUMLAH KESELURUHAN : <?= count($model->outreaching); ?></b></button></b></h2>  
                <p align="right"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> <strong>SUMBER DATA SMPPI</strong></p>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6"> 
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr style="background-color:#2A3F54; color:white;">
                        <th class="text-center">EXPERTISE</th>
                        <th class="text-center">TOTAL</th> 
                    </tr>  
                    <?php foreach ($model->outreachingKeahlian as $r) { ?> 
                        <tr>
                            <th> 
                                <?= strtoupper($r['Keahlian']); ?>  
                            </th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->outreaching, function ($var) use ($r) {
                                            return ($var['Keahlian'] == $r['Keahlian']);
                                        }))
                                ?> 
                            </td> 
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr style="background-color:#2A3F54; color:white;">
                        <th class="text-center">LEVEL</th>
                        <th class="text-center">TOTAL</th> 
                    </tr>  
                    <?php foreach ($model->outreachingLevel as $r) { ?> 
                        <tr>
                            <th> 
                                <?= strtoupper($r['Peringkat']); ?>  
                            </th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->outreaching, function ($var) use ($r) {
                                            return ($var['Peringkat'] == $r['Peringkat']);
                                        }))
                                ?> 
                            </td> 
                        </tr>
                    <?php } ?>
                </table>
                <br/>
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr style="background-color:#2A3F54; color:white;">
                        <th class="text-center">STATUS</th>
                        <th class="text-center">TOTAL</th> 
                    </tr>  
                    <?php foreach ($model->outreachingStatus as $r) { ?> 
                        <tr>
                            <th> 
                                <?= strtoupper($r['Status']); ?>  
                            </th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->outreaching, function ($var) use ($r) {
                                            return ($var['Status'] == $r['Status']);
                                        }))
                                ?> 
                            </td> 
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div> 
        <div class="x_panel">
            <div class="x_title">
                <h2><b>PERUNDINGAN KINIKAL <button type="button" class="btn btn-default"><b>JUMLAH KESELURUHAN : <?= count($model->outreachingClinical); ?></b></button></b></h2>  
                <p align="right"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> <strong>SUMBER DATA SMPPI</strong></p>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6"> 
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr style="background-color:#2A3F54; color:white;">
                        <th class="text-center">ROLE</th>
                        <th class="text-center">TOTAL</th> 
                    </tr>  
                    <?php foreach ($model->outreachingJenisRawatan as $r) { ?> 
                        <tr>
                            <th> 
                                <?= strtoupper($r['JenisRawatan']); ?>  
                            </th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->outreachingClinical, function ($var) use ($r) {
                                            return ($var['JenisRawatan'] == $r['JenisRawatan']);
                                        }))
                                ?> 
                            </td> 
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">

            </div>
        </div> 
        <div class="x_panel">
            <div class="x_title">
                <h2><b>SITASI & H-INDEKS</b></h2>  
                <p align="right"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> <strong>SUMBER DATA PPDM</strong></p>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th colspan="2" class="text-center" style="background-color:#2A3F54; color:white;">GOOGLE SCHOLAR</th> 
                    </tr> 
                    <tr>
                        <th>SITASI  </th> 
                        <td class="text-center"><?= $model->googleScholar->Citations; ?> </td>
                    </tr> 
                    <tr>
                        <th>H-INDEKS </th>
                        <td class="text-center"> <?= $model->googleScholar->h_index; ?></td>
                    </tr> 
                </table>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr>
                        <th colspan="2" class="text-center" style="background-color:#2A3F54; color:white;">SCOPUS</th> 
                    </tr>
                    <tr>
                        <th>SITASI  </th> 
                        <td class="text-center"><?= $model->scopus->Citations; ?></td>
                    </tr> 
                    <tr>
                        <th>H-INDEKS</th>
                        <td class="text-center"><?= $model->scopus->h_index; ?></td>
                    </tr> 
                </table>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2><b>PENGAJARAN <button type="button" class="btn btn-default"><b>JUMLAH KESELURUHAN : <?= count($model->pengajaran); ?></b></button></b></h2>  
                <p align="right"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> <strong>SUMBER DATA SMP</strong></p>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr style="background-color:#2A3F54; color:white;">
                        <th class="text-center">KATEGORI</th>
                        <th class="text-center">JUMLAH</th> 
                    </tr>  
                    <?php foreach ($model->pengajaranKategoriPelajar as $r) { ?> 
                        <tr>
                            <th> 
                                <?php
                                if (is_null($r['KATEGORIPELAJAR'])) {
                                    echo 'NULL';
                                } else {
                                    echo strtoupper($r['KATEGORIPELAJAR']);
                                }
                                ?>  
                            </th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->pengajaran, function ($var) use ($r) {
                                            return ($var['KATEGORIPELAJAR'] == $r['KATEGORIPELAJAR']);
                                        }))
                                ?> 
                            </td> 
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr>
                        <th colspan="2" class="text-center" style="background-color:#2A3F54; color:white;">PENGAJARAN </th>
                    </tr> 
                    <tr> 
                        <th class="text-center">KRITERIA</th> 
                        <th class="text-center">JUMLAH</th> 
                    </tr>  
                    <tr> 
                        <th>PRA-SISWAZAH</th> 
                        <td class="text-center"><?=
                            count(array_filter($model->pengajaran, function ($var) {
                                        return ($var['KATEGORIPELAJAR'] == 'PRASISWAZAH (PLUMS)' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH PERUBATAN' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH PPG' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH UMUM');
                                    }));
                            ?></td>
                    </tr>
                    <tr>
                        <th>PASCA-SISWAZAH</th> 
                        <td class="text-center"><?=
                            count(array_filter($model->pengajaran, function ($var) {
                                        return ($var['KATEGORIPELAJAR'] == 'PASCASISWAZAH');
                                    }));
                            ?></td>
                    </tr>  
                </table>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2><b>PENYELIAAN <button type="button" class="btn btn-default"><b>JUMLAH KESELURUHAN : <?= count($model->penyeliaan2); ?></b></button></b></h2>  
                <p align="right"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> <strong>SUMBER DATA SMP</strong></p>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr style="background-color:#2A3F54; color:white;">
                        <th class="text-center">STATUS</th> 
                        <?php foreach ($model->penyeliaanModLevelName as $r) { ?> 
                            <th class="text-center"><?= strtoupper($r['ModLevelName']); ?> </th> 
                        <?php } ?>
                    </tr>  
                    <?php foreach ($model->penyeliaanStatusBM as $r) { ?> 
                        <tr>
                            <th> 
                                <?= strtoupper($r['StatusBM']); ?>  
                            </th> 
                            <?php foreach ($model->penyeliaanModLevelName as $i) { ?> 
                                <td class="text-center">
                                    <?=
                                    count(array_filter($model->penyeliaan2, function ($var) use ($r, $i) {
                                                return ($var['StatusBM'] == $r['StatusBM'] && $var['ModLevelName'] == $i['ModLevelName']);
                                            }))
                                    ?> 
                                </td> 
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr> 
                        <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PENYELIAAN </th> 
                    </tr> 

                    <tr> 
                        <th class="text-center" colspan="3">KRITERIA</th> 
                        <th class="text-center">JUMLAH SEMASA</th> 
                    </tr> 
                    <tr>
                        <th rowspan="4">PHD</th>
                        <th rowspan="2">PENYELIA UTAMA, PENYELIA & PENGERUSI J/K PENYELIAAN</th>
                        <th>TAMAT PENGAJIAN</th>
                        <td class="text-center"><?=
                            $model->totalTamatPengajianUtama('PHD');
                            ?></td>
                    </tr>
                    <tr>
                        <th>AKTIF</th>
                        <td class="text-center"><?=
                            $model->totalAktifUtama('PHD');
                            ?></td>
                    </tr>  
                    <tr>
                        <th rowspan="2">PENYELIA BERSAMA & AJK PENYELIAAN</th>
                        <th>TAMAT PENGAJIAN</th>
                        <td class="text-center"><?=
                            $model->totalTamatPengajianBersama('PHD');
                            ?></td>
                    </tr>
                    <tr>
                        <th>AKTIF</th>
                        <td class="text-center"><?=
                            $model->totalAktifBersama('PHD');
                            ?></td>
                    </tr>
                    <tr>
                        <th rowspan="4">SARJANA</th>
                        <th rowspan="2">PENYELIA UTAMA, PENYELIA & PENGERUSI J/K PENYELIAAN</th>
                        <th>TAMAT PENGAJIAN</th>
                        <td class="text-center"><?=
                            $model->totalTamatPengajianUtama('MASTER');
                            ?></td>
                    </tr>
                    <tr>
                        <th>AKTIF</th>
                        <td class="text-center"><?=
                            $model->totalAktifUtama('MASTER');
                            ?></td>
                    </tr>  
                    <tr>
                        <th rowspan="2">PENYELIA BERSAMA & AJK PENYELIAAN</th>
                        <th>TAMAT PENGAJIAN</th>
                        <td class="text-center"><?=
                            $model->totalTamatPengajianBersama('MASTER');
                            ?></td>
                    </tr>
                    <tr>
                        <th>AKTIF</th>
                        <td class="text-center"><?=
                            $model->totalAktifBersama('MASTER');
                            ?></td>
                    </tr>  
                </table>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2><b>SANJUNGAN AKADEMIK & KEPIMPINAN AKADEMIK</b></h2>  
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr style="background-color:#2A3F54; color:white;"> 
                        <th class="text-center" colspan="3">KRITERIA</th> 
                        <th class="text-center">JUMLAH</th> 
                        <th colspan="2" class="text-center">SUMBER</th> 
                    </tr>
                    <tr>  
                        <th colspan="3">EDITOR JURNAL BERINDEKS </th>
                        <td class="text-center"><?=
                            count(array_filter($model->publication2, function ($var) {
                                        return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article' && $var['KeteranganBI_WriterStatus'] == 'Editor');
                                    }));
                            ?></td> 
                        <th class="text-center"> 
                            <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'publication',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?> Bahagian Penerbitan
                        </th>
                        <th rowspan="4"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> SUMBER DATA SMPPI
                        </th>

                    </tr>
                    <tr>  
                        <th colspan="3">PENILAI JURNAL BERINDEKS </th>
                        <td class="text-center"><?=
                            count(array_filter($model->outreaching, function ($var) {
                                        return ($var['Keahlian'] == 'Indexed Journal Assessor' && $var['StatusPengesahan'] == 'V');
                                    }));
                            ?></td>
                        <th rowspan="3" class="text-center"> 
                            <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'consultancy',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?> Bahagian Perundingan
                        </th>
                    </tr>
                    <tr>  
                        <th colspan="3">PENILAI MANUSKRIP BUKU </th>
                        <td class="text-center"><?=
                            count(array_filter($model->outreaching, function ($var) {
                                        return ($var['Keahlian'] == 'Book Manuscript Reviewer' && $var['StatusPengesahan'] == 'V');
                                    }));
                            ?></td>
                    </tr>
                    <tr>  
                        <th colspan="3">PENILAI LUAR KENAIKAN PANGKAT </th>
                        <td class="text-center"><?=
                            count(array_filter($model->outreaching, function ($var) {
                                        return ($var['Keahlian'] == ' External Assessor for Promotion' && $var['StatusPengesahan'] == 'V');
                                    }));
                            ?></td>
                    </tr>  
                    <tr> 
                        <th rowspan="2">PEMERIKSA LUAR TESIS PASCASISWAZAH</th>
                        <th colspan="2">PHD</th>
                        <td class="text-center"><?=
                            count(array_filter($model->asPanel, function ($var) {
                                        return ($var['type'] == 13 && ($var['level'] == 'phd') && $var['examiner_type'] == 'external'); //Thesis Examiner (By Research)
                                    }));
                            ?></td>
                        <th rowspan="2" class="text-center"><?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'esteem',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?> Penilai Thesis</th>

                    </tr>
                    <tr>  
                        <th colspan="2">MASTER</th>
                        <td class="text-center"><?=
                            count(array_filter($model->asPanel, function ($var) {
                                        return ($var['type'] == 13 && ($var['level'] == 'master') && $var['examiner_type'] == 'external'); //Thesis Examiner (By Research)
                                    }));
                            ?></td>
                        <th rowspan="2" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> SUMBER DATA HROnline</th>

                    </tr>  
                </table> 
            </div> 
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2><b>KHIDMAT KEPADA UNIVERSITI DAN MASYARAKAT</b></h2>
                <p align="right"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> <strong>SUMBER DATA HROnline</strong></p>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p align="right"><button type="button" class="btn btn-default"><b>JUMLAH KESELURUHAN : <?= count($model->serviceUniversity); ?></b></button></p>
                
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr style="background-color:#2A3F54; color:white;">
                        <th class="text-center">KHIDMAT UNIVERSITI</th>
                        <th class="text-center">JUMLAH</th> 
                    </tr>  
                    <?php foreach ($model->serviceUniversityLevel as $r) { ?> 
                        <tr>
                            <th> 
                                <?= strtoupper($r['output']); ?>  
                            </th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->serviceUniversity, function ($var) use ($r) {
                                            return ($var['level'] == $r['id']);
                                        }))
                                ?> 
                            </td> 
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p align="right"><button type="button" class="btn btn-default"><b>JUMLAH KESELURUHAN : <?= count($model->serviceCommunity); ?></b></button></p>
                
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr style="background-color:#2A3F54; color:white;"> 
                        <th class="text-center">KHIDMAT MASYARAKAT</th> 
                        <th class="text-center">JUMLAH</th> 
                    </tr> 
                    <tr>   
                        <th>ANTARABANGSA</th>
                        <th> <?=
                            count(array_filter($model->serviceCommunity, function ($var) {
                                        return ($var['level'] == '1'); //INTERNATIONAL
                                    }))
                            ?> </th>
                    </tr>
                    <tr>  
                        <th>KEBANGSAAN</th>
                        <th> <?=
                            count(array_filter($model->serviceCommunity, function ($var) {
                                        return ($var['level'] == '2'); //National
                                    }))
                            ?></th>
                    </tr>
                    <tr>  
                        <th>NEGERI</th>
                        <th> <?=
                            count(array_filter($model->serviceCommunity, function ($var) {
                                        return ($var['level'] == '3'); //STATE
                                    }))
                            ?></th>
                    </tr>  
                </table>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2><b>LANTIKAN PENTADBIRAN</b></h2>
                <p align="right"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> <strong>SUMBER DATA HROnline</strong></p>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <table class="table table-sm table-bordered jambo_table table-striped">  

                                    <?php
                                    if ($model->adminPosition) {
                                        $bil1 = 1;
                                        ?>
                                        <tr style="background-color:#2A3F54; color:white;"> 
                                            <th class="text-center">JAWATAN</th> 
                                            <th class="text-center">STATUS</th> 
                                            <th class="text-center">JABATAN</th>
                                            <th class="text-center">KAMPUS</th>
                                            <th class="text-center">TARIKH DILANTIK</th>
                                            <th class="text-center">TARIKH SANDANGAN</th> 
                                            <th class="text-center">TEMPOH</th> 
                                        </tr>
                                        <?php
                                        $y = 0;
                                        $m = 0;
                                        $d = 0;
                                        foreach ($model->adminPosition as $l) {
                                            ?>

                                            <tr>
                                                <td class="text-center"><?= $l->adminpos ? $l->adminpos->position_name : ''; ?></td> 
                                                <td class="text-center"><?= $l->jobStatus0 ? $l->jobStatus0->jobstatus_desc : ''; ?></td>
                                                <!--<td class="text-center"><?php// $l->description ? $l->description : ''; ?></td>-->
                                                <td class="text-center"><?= $l->dept ? $l->dept->fullname : ''; ?></td>
                                                <td class="text-center"><?= $l->campus ? $l->campus->campus_name : ''; ?> </td>
                                                <td class="text-center" style="width: 10%;"><?= $l->appoinment_date ? $l->appoinment_date : ''; ?></td>
                                                <td class="text-center" style="width: 10%;"><?= $l->start_date ? $l->start_date : ''; ?> - <?= $l->end_date ? $l->end_date : ''; ?></td> 
                                                <td class="text-center" style="width: 10%;"><?= $l->tempohBM ? $l->tempohBM : ''; ?></td>

                                                <?php
                                                $curdays = 29;
                                                if ($l->getTempohType('%d') > 29) {
                                                    $curdays = $l->getTempohType('%d');
                                                }
                                                $y = $y + $l->getTempohType('%y');
                                                $m = $m + $l->getTempohType('%m');
                                                $d = $d + $l->getTempohType('%d');
                                                ?> 
                                            </tr>

                                            <?php
                                        }
                                        $dtoadd = intdiv($d, $curdays);  
                                        $dbal = fmod($d, $curdays);

                                        $mtoadd = intdiv(($m + $dtoadd), 12);
                                        $mbal = fmod(($m + $dtoadd), 12);

                                        $totaly = $y + $mtoadd;
                                        ?>
                                        <tr>
                                            <th class="text-right" colspan="4"></th>
                                            <th class="text-right" colspan="2" style="background-color:#2A3F54; color:white;">TEMPOH KESELURUHAN : </th>
                                            <th class="text-center"><?= $totaly . ' Tahun ' . $mbal . ' Bulan ' . $dbal . ' Hari ' ?></th>
                                            <?php
                                        }
                                        ?>
                                </table>
            </div>
        </div>
    </div>  
</div> 
</div>   
