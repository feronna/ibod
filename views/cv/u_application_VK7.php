<?php

use app\models\cv\RequirementUmum;
use \app\models\hronline\GredJawatan;
use yii\helpers\Html;
use kartik\popover\PopoverX;

error_reporting(0);
?>
<?php
$cluster = $model->departmentHakiki->cluster;
$penyelidikan = RequirementUmum::penyelidikan($jawatan->id, $cluster);
$penerbitan = RequirementUmum::penerbitan($jawatan->id, $cluster);
$pengajaran = RequirementUmum::pengajaran($jawatan->id, $cluster);
$penyeliaan = RequirementUmum::penyeliaan($jawatan->id, $cluster);
$persidangan = RequirementUmum::persidangan($jawatan->id, $cluster);
$perundingan = RequirementUmum::perundingan($jawatan->id, $cluster);
$service = RequirementUmum::service($jawatan->id, $cluster);
$tempoh = RequirementUmum::tempoh($jawatan->id);
$umum = RequirementUmum::umum($model->statLantikan);
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
    <u><h2><strong>KRITERIA : <?= $jawatan->fname; ?> / <?= $nameCluster; ?></strong></h2></u>  
    <div class="clearfix"></div> 
    <div class="x_content">    

        <div class="x_panel">

            <h2>KRITERIA UMUM</h2>  

            <div class="table-responsive">
                <center> 
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <table class="table table-sm table-bordered jambo_table table-striped" style="width:80%"> 
                            <?php if ($model->statLantikan == 1) { ?>
                                <tr>   
                                    <th style="width:40%">PENGESAHAN PERKHIDMATAN</th>  
                                    <td colspan="2">
                                        <?php
                                        $pengesahan_status = '';

                                        if ($model->confirmDt) {
                                            echo $model->confirmDt->tarikhMula;
                                            $pengesahan_status = "YA";
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td> 
                                </tr> 
                            <?php } ?>
                            <tr>   
                                <th rowspan="4">LNPT <br/>
                                    (Pemberat 3 Tahun = 20%, 35%, 45%)<br/>
                                    (Pemberat 2 Tahun = 40% , 60%)
                                </th>  
                                <td colspan="2"><?= '<b>' . $model->markahlnptCV(1, 'Tahun') . ' :</b> ' . $model->markahlnptCV(1, 'Markah'); ?></td> 
                            </tr>
                            <tr>   
                                <td colspan="2"><?= '<b>' . $model->markahlnptCV(2, 'Tahun') . ' :</b> ' . $model->markahlnptCV(2, 'Markah'); ?></td>  
                            </tr>
                            <tr>
                                <td colspan="2"><?= '<b>' . $model->markahlnptCV(3, 'Tahun') . ' :</b> ' . $model->markahlnptCV(3, 'Markah'); ?></td> 
                            </tr> 
                            <tr>
                                <td colspan="2">   
                                    <?php if (!empty($model->markahlnptCV(3, 'Tahun'))) { ?>
                                        Avg (3 Tahun) : 
                                        <?php
                                        $lnpt = number_format(($model->markahlnptCV(3, 'Markah') * 0.2) + ($model->markahlnptCV(2, 'Markah') * 0.35) + ($model->markahlnptCV(1, 'Markah') * 0.45));
                                        echo $lnpt;
                                    } else {
                                        ?> 
                                        Avg (2 Tahun) : 
                                        <?php
                                        $lnpt = number_format(($model->markahlnptCV(2, 'Markah') * 0.6) + ($model->markahlnptCV(1, 'Markah') * 0.4));
                                        echo $lnpt;
                                    }
                                    ?>
                                </td> 
                            </tr>
                            <?php if ($model->statLantikan == 1) { ?>
                                <tr>   
                                    <th>BERJAWATAN TETAP</th>  
                                    <td colspan="2"><?= $model->statusLantikan->ApmtStatusNm; ?></td> 
                                </tr>
                            <?php } ?>
                            <tr>   
                                <th>BEBAS TINDAKAN TATATERTIB</th>  
                                <td colspan="2"><?= $model->statusTatatertib(); ?></td> 
                            </tr>
                            <tr>   
                                <th>TEMPOH PERKHIDMATAN DALAM JAWATAN SEMASA</th>  
                                <?php if ($model->statLantikan == 1) { ?>
                                    <td colspan="2"><?= $model->getServPeriod($jawatan->id, 'Tempoh'); ?></td> 
                                <?php } else { ?>
                                    <td colspan="2"><?= $model->getServPeriodKontrak('Tempoh'); ?></td> 
                                <?php } ?>
                            </tr>  
                        </table>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <table class="table table-sm table-bordered jambo_table table-striped" style="width:80%"> 
                            <tr>   
                                <th colspan="3" class="text-center" style="background-color:#20c997; color:white;">KRITERIA</th>   
                            </tr>
                            <?php
                            $totalUmum = 0;
                            foreach ($umum as $p) {
                                ?>
                                <tr>     
                                    <th colspan="2"><?= $p->requirement; ?></th>  
                                    <?php
                                    if ($p->id == 1) {
                                        if ($pengesahan_status == $p->ans_char) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    } else if ($p->id == 2) {
                                        if ($lnpt >= $p->ans_no) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    } else if ($p->id == 3) {
                                        if ($model->statLantikan == $p->ans_no) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    } else if ($p->id == 4) {
                                        $j = 0;
                                        $s = $model->statusTatatertib();
                                        if ($s == 'Ya') { //bersih tatatertib
                                            $j = 1;
                                        }

                                        if ($j == $p->ans_no) {
                                            $s = 1;
                                            $totalUmum++;
                                        } else {
                                            $s = 0;
                                        }
                                    }

                                    if ($s == 1) {
                                        $color = "#20c997";
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
                                <?php
                            }
                            ?>
                            <?php
                            $totalTempoh = 0;
                            $p = $tempoh;
                            ?>
                            <tr>     
                                <?php
                                if ($model->statLantikan == 1) {
                                    $tempoh_kriteria = $model->getServPeriod($jawatan->id, 'Kriteria');
                                    ?>

                                    <th colspan="2"><?= $p->requirement; ?></th>  
                                    <?php
                                } else {
                                    $tempoh_kriteria = $model->getServPeriodKontrak('Kriteria');
                                    ?>
                                    <th colspan="2">Telah berkhidmat sekurang-kurangnya satu (3) tahun di UMS</th> 
                                    <?php
                                }
                                if ($tempoh_kriteria >= $p->ans_no) {
                                    $s = 1;
                                    $totalTempoh++;
                                } else {
                                    $s = 0;
                                }

                                if ($s == 1) {
                                    $color = "#20c997";
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
                            <?php
                            if ($model->statLantikan == 1) {
                                $toPassUmum = 4;
                            } else {
                                $toPassUmum = 2;
                            }


                            if ($totalUmum == $toPassUmum && $totalTempoh == 1) {
                                $umum = 1; //pass all kriteria umum
                            } else {
                                $umum = 0;
                            }
                            ?>
                        </table>
                    </div>
                </center>
            </div> 
        </div>  
        <div class="x_panel">
            <h2>KRITERIA KHUSUS</h2>
            <div class="table-responsive">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">

                        <tr>
                            <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PENYELIDIKAN (SELESAI DAN SEDANG BERJALAN) <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'research',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                        </tr>
                        <tr> 
                            <th class="text-center" colspan="3">KRITERIA</th> 
                            <th class="text-center">JUMLAH SEMASA</th> 
                        </tr> 
                        <?php
                        $researchleader = array_filter($model->research2, function ($var) {
                            return ($var['Membership'] == 'Leader' && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
                        });
                        $researchmember = array_filter($model->research2, function ($var) {
                            return ($var['Membership'] == 'Member' && ($var['ResearchStatus'] == 'Selesai' || $var['ResearchStatus'] == 'Sedang Berjalan'));
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
                            <td class="text-center"><?= number_format((array_sum(array_column($researchleader, 'Amount')) + array_sum(array_column($researchmember, 'Amount'))), 2) ?></td>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMPPI</th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA PENYELIDIKAN</th>
                        </tr>
                        <?php
                        $i = 1;
                        $totalPenyelidikan = 0;
                        foreach ($penyelidikan as $p) {
                            ?>
                            <tr>     
                                <th colspan="3"><?= $p->requirement; ?></th>  
                                <th><?php
                                    if ($p->info) {
                                        echo PopoverX::widget([
                                            'header' => '<span style="color:black;">Maklumat</span>',
                                            'type' => PopoverX::TYPE_SUCCESS,
                                            'placement' => PopoverX::ALIGN_BOTTOM,
                                            'content' => $p->info,
                                            'toggleButton' => ['label' => '<i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-success'],
                                        ]);
                                    }
                                    ?></th> 
                                <?php
                                if ($i == 1) {
                                    if (count($researchleader) >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenyelidikan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 2) {
                                    $nilai = array_sum(array_column($researchleader, 'Amount')) + array_sum(array_column($researchmember, 'Amount'));
                                    if ($nilai >= $p->ans_decimal) {
                                        $s = 1;
                                        $totalPenyelidikan++;
                                    } else {
                                        $s = 0;
                                    }
                                }

                                $i++;
                                if ($s == 1) {
                                    $color = "#20c997";
                                    $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                } else {
                                    $color = "white";
                                    $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                }
                                ?>
                                <td style="background-color:<?= $color; ?>" class="text-center">  
                                    <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                            <?php
                        }
                        if ($totalPenyelidikan >= 1) {
                            $pyldkn = 1;
                        } else {
                            $pyldkn = 0;
                        }
                        ?>

                    </table>
                </div>
            </div>
        </div>

        <div class="x_panel">   
            <div class="table-responsive"> 
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">

                        <tr>
                            <th colspan="5" class="text-center" style="background-color:#2A3F54; color:white;">PENERBITAN (YANG DISAHKAN) <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'publication',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th> 
                        </tr>  
                        <tr> 
                            <th class="text-center" colspan="4">KRITERIA</th> 
                            <th class="text-center">JUMLAH SEMASA</th> 
                        </tr> 
                        <tr>     
                            <th rowspan="9">JURNAL BERINDEKS</th>
                            <th colspan="3">BIL KESELURUHAN</th> 
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>      
                            <th>JURNAL</th> 
                            <th>High-Indexed (SCOPUS, WOS, ERA)</th> 
                            <th>Indexing (Mycite)</th> 
                            <td class="text-center"></td>
                        </tr>
                        <tr>      
                            <th>PENULIS UTAMA</th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                                        }))
                                ?></th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                                        }))
                                ?></th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>      
                            <th>CORRESPONDING AUTHOR</th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' ) && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                        }))
                                ?></th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                        }))
                                ?></th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                        }))
                                ?>
                            </td>
                        </tr> 
                        <tr>      
                            <th>COLLABORATIVE AUTHOR</th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' ) && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Collaborative Author'));
                                        }))
                                ?></th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Collaborative Author'));
                                        }))
                                ?></th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Collaborative Author'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>      
                            <th>EDITOR</th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' ) && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Editor'));
                                        }))
                                ?></th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Editor'));
                                        }))
                                ?></th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Editor'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>      
                            <th>TRANSLATOR</th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' ) && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Translator'));
                                        }))
                                ?></th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Translator'));
                                        }))
                                ?></th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Translator'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>      
                            <th>NO DATA</th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' ) && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'No Data'));
                                        }))
                                ?></th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'No Data'));
                                        }))
                                ?></th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'No Data'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>      
                            <th>JUMLAH</th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                                        }))
                                ?></th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                                        }))
                                ?></th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                                        }))
                                ?>
                            </td>
                        </tr>  
                        <tr>     
                            <th rowspan="3">JURNAL TIDAK BERINDEKS</th>
                            <th colspan="3">BIL KESELURUHAN</th> 
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="3">SEBAGAI PENULIS UTAMA</th>
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th colspan="3">SEBAGAI CORRESPONDING AUTHOR</th>
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                        }))
                                ?>
                            </td>
                        </tr> 
                        <tr>
                            <th colspan="5" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMPPI</th>
                        </tr>
                        <tr>
                            <th rowspan="2">SCOPUS</th>
                            <th colspan="3">SITASI </th> 
                            <td class="text-center"><?= $model->scopus->Citations; ?> </td>
                        </tr> 
                        <tr>
                            <th colspan="3">H-INDEKS </th>
                            <td class="text-center"> <?= $model->scopus->h_index; ?> </td>
                        </tr>  

                        <tr>
                            <th colspan="5" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data PPDM</th>
                        </tr> 
                    </table>

                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA PENERBITAN</th>
                        </tr>
                        <?php
                        $i = 1;
                        $totalPenerbitan = 0;
                        foreach ($penerbitan as $p) {
                            ?>
                            <tr>     
                                <th colspan="3"><?= $p->requirement; ?></th>  
                                <th><?php
                                    if ($p->info) {
                                        echo PopoverX::widget([
                                            'header' => '<span style="color:black;">Maklumat</span>',
                                            'type' => PopoverX::TYPE_SUCCESS,
                                            'placement' => PopoverX::ALIGN_BOTTOM,
                                            'content' => $p->info,
                                            'toggleButton' => ['label' => '<i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-success'],
                                        ]);
                                    }
                                    ?></th> 
                                <?php
                                if ($i == 1) {

                                    $j = count(array_filter($model->publication, function ($var) {
                                                return ($var['Keterangan_PublicationTypeID'] == 'Article');
                                            }));

                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenerbitan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 2) {

                                    $j = count(array_filter($model->publication, function ($var) {
                                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                                            }));

                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenerbitan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 3) {
                                    $j = count(array_filter($model->publication, function ($var) {
                                                return (($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                            }));
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenerbitan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 4) {
                                    $j = $model->scopus->h_index;
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenerbitan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 5) {
                                    $j = $model->scopus->Citations;

                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenerbitan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else {
                                    //temp for sitasi
                                    $s = 2;
                                }

                                $i++;
                                if ($s == 1) {
                                    $color = "#20c997";
                                    $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                } else if ($s == 0) {
                                    $color = "red";
                                    $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                } else {
                                    $color = "#1E90FF";
                                    $button = "HOLD";
                                }
                                ?>
                                <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                                    <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                            <?php
                        }
                        if ($totalPenerbitan == 5) {
                            $pnrbtn = 1;
                        } else {
                            $pnrbtn = 0;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="x_panel">   
            <div class="table-responsive">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="2" class="text-center" style="background-color:#2A3F54; color:white;">PENGAJARAN <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'teaching',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                        </tr> 
                        <tr> 
                            <th class="text-center">KRITERIA</th> 
                            <th class="text-center">JUMLAH JAM KREDIT</th>  
                        </tr>  
                        <tr> 
                            <th>PRA-SISWAZAH</th> 
                            <td class="text-center"><?php
                                $pra_kredit = array_filter($model->pengajaran, function ($var) {
                                    return ($var['KATEGORIPELAJAR'] == 'PRASISWAZAH (PLUMS)' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH PERUBATAN' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH PPG' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH UMUM');
                                });
                                echo array_sum(array_column($pra_kredit, 'JAMKREDIT'));
                                ?></td> 
                        </tr>
                        <tr>
                            <th>PASCA-SISWAZAH</th> 
                            <td class="text-center"><?php
                                $pas_kredit = array_filter($model->pengajaran, function ($var) {
                                    return ($var['KATEGORIPELAJAR'] == 'PASCASISWAZAH');
                                });
                                echo array_sum(array_column($pas_kredit, 'JAMKREDIT'));
                                ?></td> 
                        </tr> 
                        <tr>
                            <th>ASASI/ASASI SAINS</th> 
                            <td class="text-center"><?php
                                $asasi_kredit = array_filter($model->pengajaran, function ($var) {
                                    return ($var['KATEGORIPELAJAR'] == 'ASASI' || $var['KATEGORIPELAJAR'] == 'ASASI SAINS');
                                });
                                echo array_sum(array_column($asasi_kredit, 'JAMKREDIT'));
                                ?></td> 
                        </tr> 
                        <tr>
                            <th class="text-right">JUMLAH KESELURUHAN</th> 
                            <td class="text-center"><?php
                                echo (array_sum(array_column($pra_kredit, 'JAMKREDIT')) + array_sum(array_column($pas_kredit, 'JAMKREDIT')) + array_sum(array_column($asasi_kredit, 'JAMKREDIT')));
                                ?></td> 
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMP</th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="4" class="text-center" style="background-color:#20c997; color:white;">i. KRITERIA PENGAJARAN</th>
                        </tr>
                        <?php
                        $i = 1;
                        $totalPengajaran2 = 0;
                        foreach ($pengajaran as $p) {
                            if ($i >= 3) {
                                ?>
                                <tr>     
                                    <th colspan="3"><?= $p->requirement; ?></th>  
                                    <?php
                                    if ($i == 3) {
                                        $j = array_sum(array_column($pra_kredit, 'JAMKREDIT')) + array_sum(array_column($pas_kredit, 'JAMKREDIT')) + array_sum(array_column($asasi_kredit, 'JAMKREDIT'));
                                        if ($j > $p->ans_no) {
                                            $s = 1;
                                            $totalPengajaran2++;
                                        } else {
                                            $s = 0;
                                        }
                                    }


                                    if ($s == 1) {
                                        $color = "#20c997";
                                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                    } else if ($s == 0) {
                                        $color = "red";
                                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                    }
                                    ?>
                                    <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                    </td>
                                </tr>
                                <?php
                            }$i++;
                        }
                        ?>
                    </table>
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="4" class="text-center" style="background-color:#20c997; color:white;">ii. KRITERIA PENGAJARAN</th>
                        </tr>
                        <?php
                        $i = 1;
                        $totalPengajaran1 = 0;
                        foreach ($pengajaran as $p) {
                            if ($i <= 2) {
                                ?>
                                <tr>     
                                    <th colspan="3"><?= $p->requirement; ?></th>  

                                    <?php
                                    if ($i == 1) {
                                        $s = 2;
                                    } elseif ($i == 2) {
                                        $j = $model->findPenilaianPengajaran($model->ICNO);
                                        if ($j > $p->ans_decimal) {
                                            $s = 1;
                                            $totalPengajaran1++;
                                        } else {
                                            $s = 0;
                                        }
                                    }


                                    if ($s == 1) {
                                        $color = "#20c997";
                                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                    } else if ($s == 0) {
                                        $color = "white";
                                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                    } else {
                                        $color = "white";
                                        $button = "<i class='fa fa-minus'></i>";
                                    }
                                    ?>
                                    <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                    </td>
                                </tr>
                                <?php
                            }$i++;
                        }
                        ?>

                    </table> 
                    <table class="table table-sm table-bordered jambo_table table-striped"> 
                        <?php
                        $totalPengajaran = 0;
                        $totalPengajaran = $totalPengajaran1 + $totalPengajaran2;
                        $pgjrn = 0;
                        if ($totalPengajaran >= 2) {
                            $pgjrn = 1;
                            $Scolor = "#20c997";
                            $button = "<i class='fa fa-check-circle fa-lg'></i>";
                        } else {
                            $Scolor = "red";
                            $button = "<i class='fa fa-times-circle fa-lg'></i>";
                        }
                        ?>

                        <tr>     
                            <th style="background-color:#20c997; color:white;" colspan="3">STATUS KESELURUHAN <br/><br/></th>  
                            <td style="background-color:<?= $Scolor; ?>; width:5%;" class="text-center">  
                                <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                            </td>
                        </tr>
                    </table>



                </div>
            </div>
        </div>
        <div class="x_panel">   
            <div class="table-responsive">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr> 
                            <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PENYELIAAN PENYELIDIKAN UMS/LUAR <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'supervisory',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th> 
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
                            $model->PenyeliaanTamatPengajianUtama('PHD','RESEARCH');
                            ?></td>
                    </tr>
                    <tr>
                        <th>AKTIF</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanAktifUtama('PHD','RESEARCH');
                            ?></td>
                    </tr>  
                    <tr>
                        <th rowspan="2">PENYELIA BERSAMA & AJK PENYELIAAN</th>
                        <th>TAMAT PENGAJIAN</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanTamatPengajianBersama('PHD','RESEARCH');
                            ?></td>
                    </tr>
                    <tr>
                        <th>AKTIF</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanAktifBersama('PHD','RESEARCH');
                            ?></td>
                    </tr>
                    <tr>
                        <th rowspan="4">SARJANA</th>
                        <th rowspan="2">PENYELIA UTAMA, PENYELIA & PENGERUSI J/K PENYELIAAN</th>
                        <th>TAMAT PENGAJIAN</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanTamatPengajianUtama('MASTER','RESEARCH');
                            ?></td>
                    </tr>
                    <tr>
                        <th>AKTIF</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanAktifUtama('MASTER','RESEARCH');
                            ?></td>
                    </tr>  
                    <tr>
                        <th rowspan="2">PENYELIA BERSAMA & AJK PENYELIAAN</th>
                        <th>TAMAT PENGAJIAN</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanTamatPengajianBersama('MASTER','RESEARCH');
                            ?></td>
                    </tr>
                    <tr>
                        <th>AKTIF</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanAktifBersama('MASTER','RESEARCH');
                            ?></td>
                    </tr> 
                        <tr>
                            <th colspan="4" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMP</th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA PENYELIAAN</th>
                        </tr>
                        <?php
                        $i = 1;
                        $totalPenyeliaan = 0;
                        foreach ($penyeliaan as $p) {
                            ?>
                            <tr>     
                                <th colspan="3"><?= $p->requirement; ?></th>  
                                <th><?php
                                    if ($p->info) {
                                        echo PopoverX::widget([
                                            'header' => '<span style="color:black;">Maklumat</span>',
                                            'type' => PopoverX::TYPE_SUCCESS,
                                            'placement' => PopoverX::ALIGN_BOTTOM,
                                            'content' => $p->info,
                                            'toggleButton' => ['label' => '<i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-success'],
                                        ]);
                                    }
                                    ?></th>
                                <?php
                                if ($i == 1) {
                                    $j = $model->PenyeliaanTamatPengajianUtama('PHD','RESEARCH');
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenyeliaan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 2) {
                                    $j = $model->PenyeliaanTamatPengajianUtama('MASTER','RESEARCH');
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenyeliaan++;
                                    } else {
                                        $s = 0;
                                    }
                                }


                                $i++;
                                if ($s == 1) {
                                    $color = "#20c997";
                                    $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                } else {
                                    $color = "red";
                                    $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                }
                                ?>
                                <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                                    <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                            <?php
                        }
                        if ($totalPenyeliaan == 2) {
                            $pnylia = 1;
                        } else {
                            $pnylia = 0;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <div class="x_panel">   
            <div class="table-responsive">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr> 
                            <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">SANJUNGAN AKADEMIK & KEPIMPINAN AKADEMIK</th>  

                        </tr> 

                        <tr> 
                            <th class="text-center" colspan="2">KRITERIA</th> 
                            <th class="text-center">JUMLAH SEMASA</th> 
                        </tr>
                        <tr>  
                            <th colspan="2">EDITOR JURNAL BERINDEKS <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'publication',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article' && $var['KeteranganBI_WriterStatus'] == 'Editor');
                                        }));
                                ?></td>
                        </tr>
                        <tr>  
                            <th colspan="2">PENILAI JURNAL BERINDEKS <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'consultancy',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            <td class="text-center"><?=
                                count(array_filter($model->outreaching, function ($var) {
                                            return ($var['Keahlian'] == 'Indexed Journal Assessor' && $var['StatusPengesahan'] == 'V');
                                        }));
                                ?></td>
                        </tr>
                        <tr>  
                            <th colspan="2">PENILAI MANUSKRIP BUKU <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'consultancy',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            <td class="text-center"><?=
                                count(array_filter($model->outreaching, function ($var) {
                                            return ($var['Keahlian'] == 'Book Manuscript Reviewer' && $var['StatusPengesahan'] == 'V');
                                        }));
                                ?></td>
                        </tr>
                        <tr>  
                            <th colspan="2">PENILAI LUAR KENAIKAN PANGKAT <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'consultancy',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            <td class="text-center"><?=
                                count(array_filter($model->outreaching, function ($var) {
                                            return ($var['Keahlian'] == ' External Assessor for Promotion' && $var['StatusPengesahan'] == 'V');
                                        }));
                                ?></td>
                        </tr> 
                        <tr>
                            <th colspan="3" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMPPI</th>
                        </tr>
                        <tr> 
                            <th colspan="2">PEMERIKSA LUAR TESIS (PHD) <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'esteem',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>

                            <td class="text-center"><?=
                                count(array_filter($model->asPanel, function ($var) {
                                            return ($var['type'] == 13 && ($var['level'] == 'phd') && $var['examiner_type'] == 'external'); //Thesis Examiner (By Research)
                                        }));
                                ?></td>
                        </tr>  
                        <tr>
                            <th colspan="3" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data HROnline</th>
                        </tr>
                        <tr> 
                            <th colspan="3" class="text-center" style="background-color:#2A3F54; color:white;">PERSIDANGAN (YANG DISAHKAN) <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'conferences',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>  

                        </tr> 
                        <tr>
                            <th>PERINGKAT</th> 
                            <th>ANTARABANGSA</th> 
                            <th>KEBANGSAAN</th>  
                        </tr>


                        <?php foreach ($model->rolepersidangan as $r) { ?> 
                            <tr>

                                <th>
                                    <?= strtoupper($r['Peranan']) ?> 

                                </th> 
                                <td class="text-center">
                                    <?=
                                    count(array_filter($model->persidangan2, function ($var) use ($r) {
                                                return ($var['Peringkat'] == 'Antarabangsa' && $var['Peranan'] == $r['Peranan']);
                                            }))
                                    ?> 
                                </td>
                                <td class="text-center">

                                    <?=
                                    count(array_filter($model->persidangan2, function ($var) use ($r) {
                                                return ($var['Peringkat'] == 'Kebangsaan' && $var['Peranan'] == $r['Peranan']);
                                            }))
                                    ?> 
                                </td> 

                            </tr>
                        <?php } ?> 
                        <tr>
                            <th colspan="4" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMPPI</th>
                        </tr>
                    </table> 
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA SANJUNGAN AKADEMIK & KEPIMPINAN AKADEMIK</th>
                        </tr>
                        <?php
                        $i = 1;
                        $totalPersidangan = 0;
                        foreach ($persidangan as $p) {
                            ?>
                            <tr>     
                                <th colspan="3"><?= $p->requirement; ?></th>  
                                <th><?php
                                    if ($p->info) {
                                        echo PopoverX::widget([
                                            'header' => '<span style="color:black;">Maklumat</span>',
                                            'type' => PopoverX::TYPE_SUCCESS,
                                            'placement' => PopoverX::ALIGN_BOTTOM,
                                            'content' => $p->info,
                                            'toggleButton' => ['label' => '<i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-success'],
                                        ]);
                                    }
                                    ?></th>  
                                <?php
                                if ($i == 1) {
                                    $j = count(array_filter($model->persidangan2, function ($var) {
                                                return (($var['Peringkat'] == 'Antarabangsa' || $var['Peringkat'] == 'Kebangsaan') && ($var['Peranan'] == 'Pembentang'));
                                            }));
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPersidangan++;
                                    } else {
                                        $s = 0;
                                    }
                                } elseif ($i == 2) {
                                    $j = count(array_filter($model->persidangan2, function ($var) {
                                                return (($var['Peringkat'] == 'Antarabangsa' || $var['Peringkat'] == 'Kebangsaan') && ($var['Peranan'] == 'Keynote Speaker'));
                                            }));
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPersidangan++;
                                    } else {
                                        $s = 0;
                                    }
                                } elseif ($i == 3) {

                                    $j = count(array_filter($model->publication, function ($var) {
                                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article' && $var['KeteranganBI_WriterStatus'] == 'Editor');
                                            }));
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPersidangan++;
                                    } else {
                                        $s = 0;
                                    }
                                } elseif ($i == 4) {
                                    $j = count(array_filter($model->outreaching, function ($var) {
                                                return (($var['Keahlian'] == 'Indexed Journal Assessor' || $var['Keahlian'] == 'Book Manuscript Reviewer') && $var['StatusPengesahan'] == 'V');
                                            }));
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPersidangan++;
                                    } else {
                                        $s = 0;
                                    }
                                } elseif ($i == 5) {
                                    $j = count(array_filter($model->outreaching, function ($var) {
                                                return ($var['Keahlian'] == ' External Assessor for Promotion' && $var['StatusPengesahan'] == 'V');
                                            }));
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPersidangan++;
                                    } else {
                                        $s = 0;
                                    }
                                } elseif ($i == 6) {
                                    $j = count(array_filter($model->asPanel, function ($var) {
                                                return ($var['type'] == 13 && $var['level'] == 'phd' && $var['examiner_type'] == 'external'); //Thesis Examiner (By Research)
                                            }));

                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPersidangan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else {
                                    //temp for (no data)
                                    $s = 2;
                                }

                                $i++;

                                if ($s == 1) {
                                    $color = "#20c997";
                                    $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                } else if ($s == 0) {
                                    $color = "white";
                                    $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                } else {
                                    $color = "white";
                                    $button = "<i class='fa fa-minus'></i>";
                                }
                                ?>
                                <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                                    <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                            <?php
                        }
                        $persdgn = 0;
                        if ($totalPersidangan >= 1) {
                            $persdgn = 1;
                            $Scolor = "#20c997";
                            $button = "<i class='fa fa-check-circle fa-lg'></i>";
                        } else {
                            $Scolor = "red";
                            $button = "<i class='fa fa-times-circle fa-lg'></i>";
                        }
                        ?>
                        <tr>     
                            <th style="background-color:#20c997; color:white;" colspan="4">STATUS KESELURUHAN <br/><br/> * Memenuhi salah satu sub kriteria sanjungan akademik & kepimpinan akademik (i,ii,iii,iv,v,vi) yang dinyatakan diatas.</th>  
                            <td style="background-color:<?= $Scolor; ?>; width:5%;" class="text-center">   
                                <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                            </td>
                        </tr> 
                    </table>
                </div>

            </div>
        </div>
        <div class="x_panel">   
            <div class="table-responsive">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">KHIDMAT KEPADA UNIVERSITI <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'services',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank']); ?></th>
                        </tr>  
                        <tr>   
                            <th colspan="3">PENGERUSI </th>
                            <th class="text-center"><?=
                                count(array_filter($model->serviceUniversity, function ($var) {
                                            return ($var['role_key'] == 'Chairman');
                                        }));
                                ?></th>
                        </tr>  
                        <tr>   
                            <th colspan="3">AJK</th>
                            <th class="text-center"><?=
                                count(array_filter($model->serviceUniversity, function ($var) {
                                            return ($var['role_key'] == 'Member Committee');
                                        }));
                                ?></th>
                        </tr> 
                        <tr>
                            <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">KHIDMAT KEPADA MASYARAKAT <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'services',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                        </tr>  
                        <tr>  
                            <th></th>
                            <th>PERINGKAT ANTARABANGSA</th>
                            <th>PERINGKAT KEBANGSAAN</th>
                            <th>PERINGKAT NEGERI</th>

                        </tr>   
                        <tr>  
                            <th>PENGURUSI</th>
                            <th class="text-center"><?=
                                count(array_filter($model->serviceCommunity, function ($var) {
                                            return ($var['level'] == '1' && $var['role_key'] == 'Chairman');
                                        }))
                                ?></th>
                            <th class="text-center"><?=
                                count(array_filter($model->serviceCommunity, function ($var) {
                                            return ($var['level'] == '2' && $var['role_key'] == 'Chairman');
                                        }))
                                ?></th>
                            <th class="text-center"><?=
                                count(array_filter($model->serviceCommunity, function ($var) {
                                            return ($var['level'] == '3' && $var['role_key'] == 'Chairman');
                                        }))
                                ?></th>
                        </tr>
                        <tr>  
                            <th>AJK</th>
                            <th class="text-center"><?=
                                count(array_filter($model->serviceCommunity, function ($var) {
                                            return ($var['level'] == '1' && $var['role_key'] == 'Member Committee');
                                        }))
                                ?></th>
                            <th class="text-center"><?=
                                count(array_filter($model->serviceCommunity, function ($var) {
                                            return ($var['level'] == '2' && $var['role_key'] == 'Member Committee');
                                        }))
                                ?></th>
                            <th class="text-center"><?=
                                count(array_filter($model->serviceCommunity, function ($var) {
                                            return ($var['level'] == '3' && $var['role_key'] == 'Member Committee');
                                        }))
                                ?></th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data HROnline</th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="4" class="text-center" style="background-color:#20c997; color:white;">KRITERIA KHIDMAT KEPADA UNIVERSITI</th>
                        </tr>
                        <?php
                        $i = 1;
                        $totalService = 0;
                        foreach ($service as $p) {
                            if ($i <= 2) {
                                ?>
                                <tr>     
                                    <th colspan="3"><?= $p->requirement; ?></th>  
                                    <?php
                                    if ($i == 1) {
                                        $j = count(array_filter($model->serviceUniversity, function ($var) {
                                                    return ($var['role_key'] == 'Chairman');
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $totalService++;
                                        } else {
                                            $s = 0;
                                        }
                                    } elseif ($i == 2) {
                                        $j = count(array_filter($model->serviceUniversity, function ($var) {
                                                    return ($var['role_key'] == 'Member Committee');
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $totalService++;
                                        } else {
                                            $s = 0;
                                        }
                                    }

                                    if ($s == 1) {
                                        $color = "#20c997";
                                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                    } else if ($s == 0) {
                                        $color = "white";
                                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                    } else {
                                        $color = "#1E90FF";
                                        $button = "HOLD";
                                    }
                                    ?>
                                    <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                    </td>
                                </tr>
                                <?php
                            }$i++;
                        }
                        ?>
                    </table>
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="4" class="text-center" style="background-color:#20c997; color:white;">KRITERIA KHIDMAT KEPADA MASYARAKAT</th>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($service as $p) {
                            if ($i >= 3) {
                                ?>
                                <tr>     
                                    <th colspan="3"><?= $p->requirement; ?></th>  
                                    <?php
                                    if ($i == 3) {
                                        $j = count(array_filter($model->serviceCommunity, function ($var) {
                                                    return (($var['level'] == 1 || $var['level'] == 2 || $var['level'] == 3) && ($var['role_key'] == 'Chairman')); //National & internasional
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $totalService++;
                                        } else {
                                            $s = 0;
                                        }
                                    } elseif ($i == 4) {
                                        $j = count(array_filter($model->serviceCommunity, function ($var) {
                                                    return (($var['level'] == 1 || $var['level'] == 2 || $var['level'] == 3) && ($var['role_key'] == 'Member Committee')); //National & internasional
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $totalService++;
                                        } else {
                                            $s = 0;
                                        }
                                    }

                                    if ($s == 1) {
                                        $color = "#20c997";
                                        $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                    } else if ($s == 0) {
                                        $color = "white";
                                        $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                    } else {
                                        $color = "#1E90FF";
                                        $button = "HOLD";
                                    }
                                    ?>
                                    <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                                        <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                    </td>
                                </tr>
                                <?php
                            }$i++;
                        }
                        ?>
                    </table>
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <?php
                            $serviceS = 0;
                            if ($totalService >= 1) {
                                $serviceS = 1;
                                $Scolor = "#20c997";
                                $button = "<i class='fa fa-check-circle fa-lg'></i>";
                            } else {
                                $Scolor = "red";
                                $button = "<i class='fa fa-times-circle fa-lg'></i>";
                            }
                            ?>
                        </tr>
                        <tr>     
                            <th style="background-color:#20c997; color:white;" colspan="4">STATUS KESELURUHAN<br/><br/>*Memenuhi salah satu kriteria dalam peringkat Universiti atau Masyarakat.<br/></th>  
                            <td style="background-color:<?= $Scolor; ?>; width:5%;" class="text-center">  
                                <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
        <div class="x_panel">   
            <div class="table-responsive">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="2" class="text-center" style="background-color:#2A3F54; color:white;">PERUNDINGAN / PERUNDINGAN KLINIKAL / JARINGAN INDUSTRI <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'consultancy',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                        </tr> 
                        <tr> 
                            <th class="text-center">KRITERIA</th> 
                            <th class="text-center">JUMLAH SEMASA</th> 
                        </tr>
                        <tr>  
                            <th>PERUNDINGAN (YANG DISAHKAN) <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'consultancy',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?> </th>
                            <td class="text-center"><?=
                                count(array_filter($model->outreaching, function ($var) {
                                            return ($var['StatusPengesahan'] == 'V'); //verified
                                        }));
                                ?></td>
                        </tr>
                        <tr>
                            <th>PERUNDINGAN KLINIKAL (YANG DISAHKAN) <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'consultancy',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            <td class="text-center"><?=
                                count(array_filter($model->outreachingClinical, function ($var) {
                                            return ($var['ApproveStatus'] == 'V'); //verified
                                        }));
                                ?></td>
                        </tr>
                        <tr>
                            <th>INOVASI (SELESAI) <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'innovation',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            <td class="text-center"><?= count($model->inovasiSelesai); ?> </td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMPPI</th>
                        </tr>
                        <tr>
                            <th>TEKNOLOGI INOVASI <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'innovation_it',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            <td class="text-center"><?= count($model->getTeknologiInvasi()); ?></td>
                        </tr> 
                        <tr>
                            <th colspan="2" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data LNPT</th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA PERUNDINGAN / PERUNDINGAN KLINIKAL / JARINGAN INDUSTRI</th>
                        </tr>
                        <?php
                        $totalPerundingan = 0;
                        $i = 1;
                        foreach ($perundingan as $p) {
                            ?>
                            <tr>     
                                <th colspan="3"><?= $p->requirement; ?></th>  
                                <th><?php
                                    if ($p->info) {
                                        echo PopoverX::widget([
                                            'header' => '<span style="color:black;">Maklumat</span>',
                                            'type' => PopoverX::TYPE_SUCCESS,
                                            'placement' => PopoverX::ALIGN_BOTTOM,
                                            'content' => $p->info,
                                            'toggleButton' => ['label' => '<i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-success'],
                                        ]);
                                    }
                                    ?></th>
                                <?php
                                if ($i == 1) {
                                    $j = count(array_filter($model->outreaching, function ($var) {
                                                        return ($var['StatusPengesahan'] == 'V'); //verified
                                                    })) + count(array_filter($model->outreachingClinical, function ($var) {
                                                        return ($var['ApproveStatus'] == 'V'); //verified
                                                    }));
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPerundingan++;
                                    } else {
                                        $s = 0;
                                    }
                                } elseif ($i == 2) {
                                    $j = count($model->inovasiSelesai) + count($model->getTeknologiInvasi());
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPerundingan++;
                                    } else {
                                        $s = 0;
                                    }
                                } elseif ($i == 3) {
                                    $j = count(array_filter($model->outreaching, function ($var) {
                                                return ($var['StatusPengesahan'] == 'V' && $var['Keahlian'] == 'Speaker'); //verified
                                            }));
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPerundingan++;
                                    } else {
                                        $s = 0;
                                    }
                                }


                                if ($s == 1) {
                                    $color = "#20c997";
                                    $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                } else if ($s == 0) {
                                    $color = "red";
                                    $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                } else {
                                    $color = "#1E90FF";
                                    $button = "HOLD";
                                }
                                ?>
                                <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                                    <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </table>
                    <?php
                    if ($totalPerundingan == 3) {
                        $prndgn = 1;
                    } else {
                        $prndgn = 0;
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php
        if ($umum == 1 && $pyldkn == 1 && $pnrbtn == 1 && $pgjrn == 1 && $pnylia == 1 && $persdgn == 1 && $serviceS == 1 && $prndgn == 1) {
            $checking = 1;
        } else {
            $checking = 0;
        }
        ?>
        <?php if (Yii::$app->controller->action->id != 'self-check') { ?>
            <div class="x_panel"> 
                <h2>DECLARATION</h2>
                <p>
                    I hereby declare that have complied with the regulation of working hours as prescribed in Registrar Circular No. 1/2015: UMS-Rated Working Time Regulations (Amendment 2015) AND all the information in this application is true. In the event where I am proven to falsify any information, this application or the offer letter of promotion shall be terminated with immediate effect and I shall be rendered liable to disciplinary action, in accordance with Rule 3 (2) (f) Second Schedule, Statutory Bodies (Discipline & Surcharge) Act 2000 (Act 605).
                </p> 

                <p align="right">
                    <?= Html::a('<i class="fa fa-pencil-square-o"></i> Aduan', ['complain'], ['class' => 'btn btn-warning']); ?><?= Html::a('Submit', ['appsubmit', 'id' => $jawatan->id, 'status' => $checking], ['class' => 'btn btn-primary']); ?>
                </p>
            </div>
        <?php } ?>
    </div>  
</div> 
</div>   
