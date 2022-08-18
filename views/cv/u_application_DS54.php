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
                                <th>TEMPOH PERKHIDMATAN</th>  
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

                                        //calon cuti belajar 
                                        if ($model->findCutiBelajar($model->ICNO) != 1) {

                                            if ($lnpt >= $p->ans_no) {
                                                $s = 1;
                                                $totalUmum++;
                                            } else {
                                                $s = 0;
                                            }
                                        } else {
                                            $s = 0; //skip
                                            $totalUmum++;
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
                                        if ($p->id == 2) {
                                            $color = "white";
                                        } else {
                                            $color = "red";
                                        }
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
                            if($model->statLantikan == 1){
                                $toPassUmum = 4;
                            }else{
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
            <h2 class="StepTitle">KRITERIA KHUSUS</h2>
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
                                    $color = "red";
                                    $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                }
                                ?>
                                <td style="background-color:<?= $color; ?>" class="text-center">  
                            <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                            <?php
                        }
                        if ($totalPenyelidikan == 2) {
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
                            <th rowspan="5">JURNAL BERINDEKS</th>
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
                            <th>JUMLAH</th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                        }))
                                ?></th> 
                            <th><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                        }))
                                ?></th> 
                            <td class="text-center">
                                <?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
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
                            <th rowspan="2">GOOGLE SCHOLAR</th>
                            <th colspan="3">SITASI  </th> 
                            <td class="text-center"><?= $model->googleScholar->Citations; ?> </td>
                        </tr> 
                        <tr>
                            <th colspan="3">H-INDEKS </th>
                            <td class="text-center"> <?= $model->googleScholar->h_index; ?> </td>
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
                                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article');
                                            }));
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenerbitan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 2) {
                                    $j = 0;
                                    if ($cluster == 1) {
                                        $j = count(array_filter($model->publication, function ($var) {
                                                    return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                                }));
                                    } else {
                                        $k1 = count(array_filter($model->publication, function ($var) {
                                                    return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                                }));

                                        $k2 = count(array_filter($model->publication, function ($var) {
                                                    return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                                }));

                                        if ($k1 >= 3 && $k2 >= 1) {
                                            $j = 3; 
                                        }
                                    }

                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenerbitan++;
                                    } else {
                                        $s = 0;
                                    }
                               } else if ($i == 3) {
                                    if ($cluster == 1) {
                                        $j = $model->scopus->Citations;

                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $totalPenerbitan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } else {
                                        $j = 'TIDAK';
                                        if (($model->scopus->Citations >= 10) || ($model->googleScholar->Citations >= 20)) {
                                            $j = 'YA';
                                        }

                                        if ($j == $p->ans_char) {
                                            $s = 1;
                                            $totalPenerbitan++;
                                        } else {
                                            $s = 0;
                                        }
                                    }
                                } else if ($i == 4) {
                                    if ($cluster == 1) {
                                        $j = $model->scopus->h_index;

                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $totalPenerbitan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } else {
                                        $j = 'TIDAK';
                                        if (($model->scopus->h_index >= 1) || ($model->googleScholar->h_index >= 3)) {
                                            $j = 'YA';
                                        }
                                        if ($j >= $p->ans_char) {
                                            $s = 1;
                                            $totalPenerbitan++;
                                        } else {
                                            $s = 0;
                                        }
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

                        if ($totalPenerbitan == 4) {
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

                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr> 
                            <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PENYELIAAN MOD CAMPURAN <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'supervisory',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th> 
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
                            $model->PenyeliaanTamatPengajianUtama('PHD','MIXED MODE');
                            ?></td>
                    </tr>
                    <tr>
                        <th>AKTIF</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanAktifUtama('PHD','MIXED MODE');
                            ?></td>
                    </tr>  
                    <tr>
                        <th rowspan="2">PENYELIA BERSAMA & AJK PENYELIAAN</th>
                        <th>TAMAT PENGAJIAN</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanTamatPengajianBersama('PHD','MIXED MODE');
                            ?></td>
                    </tr>
                    <tr>
                        <th>AKTIF</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanAktifBersama('PHD','MIXED MODE');
                            ?></td>
                    </tr>
                    <tr>
                        <th rowspan="4">SARJANA</th>
                        <th rowspan="2">PENYELIA UTAMA, PENYELIA & PENGERUSI J/K PENYELIAAN</th>
                        <th>TAMAT PENGAJIAN</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanTamatPengajianUtama('MASTER','MIXED MODE');
                            ?></td>
                    </tr>
                    <tr>
                        <th>AKTIF</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanAktifUtama('MASTER','MIXED MODE');
                            ?></td>
                    </tr>  
                    <tr>
                        <th rowspan="2">PENYELIA BERSAMA & AJK PENYELIAAN</th>
                        <th>TAMAT PENGAJIAN</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanTamatPengajianBersama('MASTER','MIXED MODE');
                            ?></td>
                    </tr>
                    <tr>
                        <th>AKTIF</th>
                        <td class="text-center"><?=
                            $model->PenyeliaanAktifBersama('MASTER','MIXED MODE');
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
                                $a = $model->PenyeliaanTamatPengajian('MASTER','RESEARCH');
                                $b = $model->PenyeliaanTamatPengajianUtama('MASTER','RESEARCH');
                                 
                                $d = $model->PenyeliaanTamatPengajianUtama('PHD','RESEARCH');
                                $l = $model->PenyeliaanTamatPengajianBersama('PHD','RESEARCH');
                                
                                $e = $model->PenyeliaanTamatPengajian('MASTER','MIXED MODE');
                                $f = $model->PenyeliaanTamatPengajianUtama('PHD','MIXED MODE');
                                 
                                $g = intdiv($e,3); // 3 mod campuran = 1 penyelidkan
                                $h = intdiv($f,3);

                                $j = 'TIDAK';
                                
                                if ((($a+($d*2)+$l+$g) >= 3) && (($b+($d*2)+$h) >= 2)) { 
                                    $j = 'YA';
                                } 

                                if ($j == $p->ans_char) {
                                    $s = 1;
                                    $totalPenyeliaan++;
                                } else {
                                    $s = 0;
                                }

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
                        if ($totalPenyeliaan == 1) {
                            $pnylia = 1;
                        } else {
                            $pnylia = 0;
                        }
                        ?>
                    </table>
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="5" class="text-center" style="background-color:#0cc0e8; color:white;">NOTA PENSETARAAN</th>
                        </tr>
                        <tr>
                            <th colspan="5"> <br/>
                                i. 1 PhD (Penyelia Utama) = 2 Sarjana Penyelidikan (Penyelia Utama) - <i>Pensetaraan sehala</i>; atau <br/><br/>
                                ii. 1 PhD (Penyelia Bersama) = 1 Sarjana Penyelidikan (Penyelia Bersama) - <i>Pensetaraan sehala</i>; atau <br/><br/>
                                iii. 1 Sarjana Penyelidikan (Penyelia Utama) = 3 Sarjana Mod Campuran (Penyelia Utama)</th>  
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
                            <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PERSIDANGAN <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'conferences',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>  

                        </tr> 

                        <tr> 
                            <th class="text-center" colspan="3">KRITERIA</th> 
                            <th class="text-center">JUMLAH SEMASA</th> 
                        </tr>

                        <tr>
                            <th colspan="2">PERINGKAT</th> 
                            <th>ANTARABANGSA</th> 
                            <th>KEBANGSAAN</th>  
                        </tr>


<?php foreach ($model->rolepersidangan as $r) { ?> 
                            <tr>

                                <th colspan="2">
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
                                $Antarabangsa = count(array_filter($model->persidangan2, function ($var) {
                                            return ($var['Peringkat'] == 'Antarabangsa' && ($var['Peranan'] == 'Keynote Speaker' || $var['Peranan'] == 'Ahli Panel' || $var['Peranan'] == 'Pembentang Jemputan'));
                                        }));
                                $Kebangsaan = count(array_filter($model->persidangan2, function ($var) {
                                            return (($var['Peringkat'] == 'Kebangsaan' || $var['Peringkat'] == 'National') && ($var['Peranan'] == 'Keynote Speaker' || $var['Peranan'] == 'Ahli Panel' || $var['Peranan'] == 'Pembentang Jemputan'));
                                        }));
                                $j = $Antarabangsa + $Kebangsaan;
                                if ($j >= $p->ans_no) {
                                    $s = 1;
                                    $totalPersidangan++;
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
                                <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                            <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                            <?php
                        }
                        if ($totalPersidangan == 1) {
                            $persdgn = 1;
                        } else {
                            $persdgn = 0;
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
                            <th colspan="3" class="text-center" style="background-color:#2A3F54; color:white;">KHIDMAT KEPADA UNIVERSITI DAN MASYARAKAT <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'services',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                        </tr> 
                        <tr> 
                            <th class="text-center" colspan="2">KRITERIA</th> 
                            <th class="text-center" rowspan="2">JUMLAH SEMASA</th> 
                        </tr>
                        <tr>  
                            <th>JENIS</th>
                            <th>TAHAP</th>
                        </tr> 
                        <tr>  
                            <th rowspan="3">MASYARAKAT</th>
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

                        <tr>  
                            <th>UNIVERSITI</th>
                            <th>-</th>
                            <th><?= count(array_filter($model->serviceUniversity)); ?></th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data HROnline</th>
                        </tr>

                    </table>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="4" class="text-center" style="background-color:#20c997; color:white;">KRITERIA KHIDMAT KEPADA UNIVERSITI DAN MASYARAKAT</th>
                        </tr>
                        <?php
                        $totalService = 0;
                        foreach ($service as $p) {
                            ?>
                            <tr>     
                                <th colspan="3"><?= $p->requirement; ?></th>  
                                <?php
                                $j = count(array_filter($model->serviceCommunity, function ($var) {
                                            return ($var['level'] == 1 || $var['level'] == 2); //National
                                        }));
                                if ($j >= $p->ans_no) {
                                    $s = 1;
                                    $totalService++;
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
                                <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                            <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                            <?php
                        }
                        if ($totalService == 1) {
                            $serviceS = 1;
                        } else {
                            $serviceS = 0;
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
                            <th colspan="2" class="text-center" style="background-color:#2A3F54; color:white;">PERUNDINGAN / PERUNDINGAN KLINIKAL / JARINGAN INDUSTRI <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'consultancy',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                        </tr> 
                        <tr> 
                            <th class="text-center">KRITERIA</th> 
                            <th class="text-center">JUMLAH SEMASA</th> 
                        </tr>
                        <tr>  
                            <th>BILANGAN PERUNDINGAN (YANG DISAHKAN)</th>
                            <td class="text-center"><?=
                                count(array_filter($model->outreaching, function ($var) {
                                            return ($var['StatusPengesahan'] == 'V'); //verified
                                        })) + count(array_filter($model->outreachingClinical, function ($var) {
                                            return ($var['ApproveStatus'] == 'V'); //verified
                                        }));
                                ?></td>
                        </tr> 
                        <tr>
                            <th colspan="4" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMPPI</th>
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
                        if ($totalPerundingan == 1) {
                            $prndgn = 1;
                        } else {
                            $prndgn = 0;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div> 

        <?php
        if ($umum == 1 && $pyldkn == 1 && $pnrbtn == 1 && $pnylia == 1 && $persdgn == 1 && $serviceS == 1 && $prndgn == 1) {
            $checking = 1;
        } else {
            $checking = 0;
        }
        ?> 
        <div class="x_panel">
            <h2>DECLARATION</h2>
            <p>
                I hereby declare that have complied with the regulation of working hours as prescribed in Registrar Circular No. 1/2015: UMS-Rated Working Time Regulations (Amendment 2015) AND all the information in this application is true. In the event where I am proven to falsify any information, this application or the offer letter of promotion shall be terminated with immediate effect and I shall be rendered liable to disciplinary action, in accordance with Rule 3 (2) (f) Second Schedule, Statutory Bodies (Discipline & Surcharge) Act 2000 (Act 605).
            </p> 

            <p align="right">
<?= Html::a('<i class="fa fa-pencil-square-o"></i> Aduan', ['complain'], ['class' => 'btn btn-warning']); ?><?= Html::a('Submit', ['appsubmit', 'id' => $jawatan->id, 'status' => $checking], ['class' => 'btn btn-primary']); ?>
            </p>
        </div>  

    </div> 
</div>   
