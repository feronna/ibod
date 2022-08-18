<?php

use app\models\cv\RequirementUmum;
use app\models\cv\TblAccess;
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
    <?php if (empty(TblAccess::isExternalUner())) { ?>
        <p align="right"><?= Html::a('Resume', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'personal',], ['class' => 'btn btn-default', 'target' => '_blank',]); ?><?= Html::a('Kembali', ['search-candidate'], ['class' => 'btn btn-primary btn-sm']); ?></p>
    <?php } ?>
    <div class="clearfix"></div> 
    <div class="x_content">    

        <div class="x_panel">  
            <div class="hide">  
                <form>  
                    <input id="gred_apply" class="form-control" value=<?= $jawatan->id; ?> > 
                </form>
            </div>
            <div class="x_title">
                <h2>KRITERIA UMUM</h2>  
                <div class="clearfix"></div>
            </div> 

            <div class="table-responsive">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center> 
                        <table class="table table-sm table-bordered jambo_table table-striped" style="width:80%"> 
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
                            <tr>   
                                <th>BERJAWATAN TETAP</th>  
                                <td colspan="2"><?= $model->statusLantikan->ApmtStatusNm; ?></td> 
                            </tr>
                            <tr>   
                                <th>BEBAS TINDAKAN TATATERTIB</th>  
                                <td colspan="2"><?= $model->statusTatatertib(); ?></td> 
                            </tr>   
                        </table>
                    </center>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center>
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
                        </table>
                    </center>
                </div>
            </div> 
        </div>   

        <div class="table-responsive">
            <div class="x_panel">
                <div class="x_title">
                    <h2>KRITERIA KHUSUS</h2>  
                    <div class="clearfix"></div>
                </div>
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
                                    if (count($researchleader + $researchmember) >= $p->ans_no) {
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
                        ?>

                    </table>
                </div>
            </div>
            <div class="x_panel"> 
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">

                        <tr>
                            <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PENERBITAN (YANG DISAHKAN) <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'publication',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th> 
                        </tr>  
                        <tr> 
                            <th class="text-center" colspan="2">KRITERIA</th> 
                            <th class="text-center">JUMLAH SEMASA</th> 
                        </tr> 
                        <tr>     
                            <th rowspan="3">JURNAL BERINDEKS</th>
                            <th>BIL KESELURUHAN</th> 
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>SEBAGAI PENULIS UTAMA</th>
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>SEBAGAI CORRESPONDING AUTHOR</th>
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                        }))
                                ?>
                            </td>
                        </tr> 
                        <tr>     
                            <th rowspan="3">JURNAL TIDAK BERINDEKS</th>
                            <th>BIL KESELURUHAN</th> 
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>SEBAGAI PENULIS UTAMA</th>
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>SEBAGAI CORRESPONDING AUTHOR</th>
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                        }))
                                ?>
                            </td>
                        </tr> 
                        <tr>     
                            <th rowspan="3">BAB DALAM BUKU BERINDEKS</th>
                            <th>BIL KESELURUHAN</th> 
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>SEBAGAI PENULIS UTAMA</th>
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>SEBAGAI CORRESPONDING AUTHOR</th>
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                        }))
                                ?>
                            </td>
                        </tr> 
                        <tr>     
                            <th rowspan="3">BAB DALAM BUKU TIDAK BERINDEKS</th>
                            <th>BIL KESELURUHAN</th> 
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>SEBAGAI PENULIS UTAMA</th>
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'First Author'));
                                        }))
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>SEBAGAI CORRESPONDING AUTHOR</th>
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'Non-indexed' || is_null($var['IndexingDesc']) || $var['IndexingDesc'] == '-') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                        }))
                                ?>
                            </td>
                        </tr> 
                        <tr>
                            <th colspan="4" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMPPI</th>
                        </tr>
                        <tr>
                            <th colspan="2">JUMLAH SITASI
                                <?php
                                if ($cluster == 1) {
                                    echo '(SCOPUS)';
                                } else {
                                    echo '(GOOGLE SCHOLAR)';
                                }
                                ?>
                            </th> 
                            <td class="text-center"><?php
                                if ($cluster == 1) {
                                    echo $model->scopus->Citations;
                                } else {
                                    echo $model->googleScholar->Citations;
                                }
                                ?>
                            </td>
                        </tr> 
                        <tr>
                            <th colspan="2">H-INDEKS <?php
                                if ($cluster == 1) {
                                    echo '(SCOPUS)';
                                } else {
                                    echo '(GOOGLE SCHOLAR)';
                                }
                                ?></th>
                            <td class="text-center">
                                <?php
                                if ($cluster == 1) {
                                    echo $model->scopus->h_index;
                                } else {
                                    echo $model->googleScholar->h_index;
                                }
                                ?>
                            </td>
                        <tr>
                            <th colspan="4" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data PPDM</th>
                        </tr>
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
                                                return ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book' || $var['Keterangan_PublicationTypeID'] == 'Article');
                                            }));

                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenerbitan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 2) {
                                    $article = count(array_filter($model->publication, function ($var) {
                                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Article'));
                                            }));

                                    $book = count(array_filter($model->publication, function ($var) {
                                                return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book'));
                                            }));

                                    $j = $article + $book;

                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenerbitan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 3) {
                                    $j = count(array_filter($model->publication, function ($var) {
                                                return ($var['Keterangan_PublicationTypeID'] == 'Article');
                                            }));
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenerbitan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 4) {
                                    $article = count(array_filter($model->publication, function ($var) {
                                                return (($var['Keterangan_PublicationTypeID'] == 'Article') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                            }));

                                    $book = count(array_filter($model->publication, function ($var) {
                                                return (($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') && ($var['KeteranganBI_WriterStatus'] == 'First Author' || $var['KeteranganBI_WriterStatus'] == 'Corresponding Author'));
                                            }));
                                    $j = $article + $book;
                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenerbitan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 5) {
                                    if ($cluster == 1) {
                                        $j = $model->scopus->h_index;
                                    } else {
                                        $j = $model->googleScholar->h_index;
                                    }

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
                        ?>
                    </table>
                </div>
            </div>


            <div class="x_panel"> 
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">

                        <tr> 
                            <th colspan="3" class="text-center" style="background-color:#2A3F54; color:white;">PERSIDANGAN (YANG DISAHKAN) <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'conferences',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>  

                        </tr> 
                        <tr>
                            <th>PERINGKAT</th> 
                            <th>ANTARABANGSA</th> 
                            <th>NEGERI</th>  
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
                                                return ($var['Peringkat'] == 'Negeri' && $var['Peranan'] == $r['Peranan']);
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
                    <table class="table table-sm table-bordered jambo_table table-striped" style="width:100%">
                        <tr>
                            <th colspan="3" class="text-center" style="background-color:#20c997; color:white;">i. MENGHADIRI PERSIDANGAN ANTARABANGSA atau,</th>
                        </tr>
                        <?php
                        $i = 1;
                        $totalPersidangan = 0;
                        foreach ($persidangan as $p) {
                            if ($i <= 2) {
                                ?>
                                <tr>     
                                    <th><?= $p->requirement; ?></th>  
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
                                                    return ($var['Peranan'] == 'Pembentang Poster' && $var['Peringkat'] == 'Antarabangsa');
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $i_persidangan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } elseif ($i == 2) {
                                        $j = count(array_filter($model->persidangan2, function ($var) {
                                                    return ($var['Peranan'] == 'Peserta' && $var['Peringkat'] == 'Antarabangsa');
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $i_persidangan++;
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
                            } $i++;
                        }
                        ?> 
                    </table>
                    <table class="table table-sm table-bordered jambo_table table-striped" style="width:100%">
                        <tr>
                            <th colspan="3" class="text-center" style="background-color:#20c997; color:white;">ii. MENGHADIRI PERSIDANGAN TEMPATAN</th>
                        </tr>
                        <?php
                        $i = 1;
                        $totalPersidangan = 0;
                        foreach ($persidangan as $p) {
                            if (($i >= 3) && ($i < 7)) {
                                ?>
                                <tr>     
                                    <th><?= $p->requirement; ?></th>  
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
                                    if ($i == 3) {
                                        $j = count(array_filter($model->persidangan2, function ($var) {
                                                    return ($var['Peranan'] == 'Pembentang' && $var['Peringkat'] == 'Negeri');
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $totalPersidangan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } elseif ($i == 4) {
                                        $j = count(array_filter($model->persidangan2, function ($var) {
                                                    return ($var['Peranan'] == 'Pembentang Poster' && $var['Peringkat'] == 'Negeri');
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $ii_persidangan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } elseif ($i == 5) {
                                        $j = count(array_filter($model->persidangan2, function ($var) {
                                                    return (($var['Peranan'] == 'Pengerusi' || $var['Peranan'] == 'Ketua Sesi') && $var['Peringkat'] == 'Negeri');
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $ii_persidangan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } elseif ($i == 6) {
                                        $j = count(array_filter($model->persidangan2, function ($var) {
                                                    return ($var['Peranan'] == 'Peserta' && $var['Peringkat'] == 'Negeri');
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $ii_persidangan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } else {
                                        //temp for (no data)
                                        $s = 2;
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
                            }$i++;
                        }
                        ?> 
                    </table>
                    <table class="table table-sm table-bordered jambo_table table-striped" style="width:100%">
                        <tr>
                            <th class="width:90%;" style="background-color:#20c997; color:white;">STATUS KESELURUHAN* <br/>  Memenuhi salah satu sub kriteria persidangan (i,ii) yang dinyatakan diatas.</th>

                            <?php
                            $s = 0;

                            if (($i_persidangan == 2) || ($ii_persidangan == 4)) {
                                $s = 1;
                            }

                            if ($s == 1) {
                                $colorAll = "#20c997";
                                $buttonAll = "<i class='fa fa-check-circle fa-lg'></i>";
                            } else if ($s == 0) {
                                $colorAll = "red";
                                $buttonAll = "<i class='fa fa-times-circle fa-lg'></i>";
                            }
                            ?>
                            <td style="background-color:<?= $colorAll; ?>; width:5%;" class="text-center">  
                                <?= Html::a($buttonAll, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="x_panel">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="2" class="text-center" style="background-color:#2A3F54; color:white;">PENGAJARAN <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'teaching',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                        </tr> 
                        <tr> 
                            <th class="text-center">KRITERIA</th> 
                            <th class="text-center">JUMLAH</th>

                        </tr>  
                        <tr> 
                            <th>PRA-SISWAZAH</th> 
                            <td class="text-center"><?php
                                $pra = array_filter($model->pengajaran, function ($var) {
                                    return ($var['KATEGORIPELAJAR'] == 'PRASISWAZAH (PLUMS)' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH PERUBATAN' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH PPG' || $var['KATEGORIPELAJAR'] == 'PRASISWAZAH UMUM');
                                });
                                echo count($pra);
                                ?></td> 
                        </tr>
                        <tr>
                            <th>PASCA-SISWAZAH</th> 
                            <td class="text-center"><?php
                                $pasca = array_filter($model->pengajaran, function ($var) {
                                    return ($var['KATEGORIPELAJAR'] == 'PASCASISWAZAH');
                                });
                                echo count($pasca);
                                ?></td> 
                        </tr>   
                        <tr>
                            <th colspan="2" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMP</th>
                        </tr>
                        <tr>
                            <th>JAM MENGAJAR <?php
                                if (Yii::$app->user->getId() == $model->ICNO) {
                                    echo Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['elnpt/borang'], ['class' => 'btn btn-default', 'target' => '_blank']);
                                } else {
                                    echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['elnpt/carian-borang', 'PYD' => $model->ICNO], ['class' => 'btn btn-default', 'target' => '_blank']);
                                }
                                ?>
                            </th>
                            <th class="text-center"><?= $model->jamPengajaran; ?></th>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data LNPT</th>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center" style="background-color:#2A3F54; color:white;">BLENDED LEARNING <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'teaching',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                        </tr> 
                        <tr> 
                            <th>JUMLAH (STATUS LULUS)</th>   
                            <?php
                            $totalBL = 0;
                            if ($model->getBlendedLearningSmartv3byStatus('Pass') != 'no_ad_ums') {
                                $totalBL = count($model->getBlendedLearningSmartv3byStatus('Pass'));
                            }
                            ?>
                            <td class="text-center"><?= $totalBL; ?></td>
                        </tr>
                        <tr>
                            <th colspan="2" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data E-Learning</th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="4" class="text-center" style="background-color:#20c997; color:white;">KRITERIA PENGAJARAN</th>
                        </tr>
                        <?php
                        $i = 1;
                        $totalPengajaran = 0;
                        $totalPengajaran1 = 0;
                        $totalPengajaran2 = 0;
                        foreach ($pengajaran as $p) {
                            ?>
                            <tr>     
                                <th colspan="3"><?= $p->requirement; ?></th>  
                                <?php
                                if ($i == 1) {
                                    if (count($pra) >= $p->ans_no) {
                                        $s = 1;
                                        $totalPengajaran1++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 2) {
                                    if (count($pasca) >= $p->ans_no) {
                                        $s = 1;
                                        $totalPengajaran1++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 3) { //100 jam mengajar
                                    $j = $model->jamPengajaran;
                                    if ($j > $p->ans_no) {
                                        $s = 1;
                                        $totalPengajaran2++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 4) {
                                    $j = $model->findPenilaianPengajaran($model->ICNO);
                                    if ($j > $p->ans_decimal) {
                                        $s = 1;
                                        $totalPengajaran2++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 5) { //blanded learning & mooc
                                    $j = $totalBL;

                                    if ($j >= $p->ans_no) {
                                        $s = 1;
                                        $totalPengajaran2++;
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

                        <?php } ?>
                    </table>
                </div>
            </div>


            <div class="x_panel">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr> 
                            <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PENYELIAAN <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'supervisory',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th> 
                        </tr> 

                        <tr> 
                            <th class="text-center" colspan="2">KRITERIA</th> 
                            <th class="text-center">JUMLAH SEMASA</th> 
                        </tr>  
                        <tr>
                            <th rowspan="4">PENYELIA BERSAMA & AJK PENYELIAAN</th>
                            <th>PHD</th>  
                            <td class="text-center"><?php
                                $penyeliaanPHD = $model->PenyeliaanTamatPengajianBersama('PHD','RESEARCH');
                                echo $penyeliaanPHD;
                                ?></td>
                        </tr>  
                        <tr>
                            <th>DrPH</th>  
                            <td class="text-center"><?php
                                $penyeliaanDrPHD = $model->PenyeliaanTamatPengajianBersama('PHD','MIXED MODE');
                                echo $penyeliaanDrPHD;
                                ?></td>
                        </tr>
                        <tr>
                            <th>SARJANA PENYELIDIKAN</th>  
                            <td class="text-center"><?php
                                $penyeliaanMas = $model->PenyeliaanTamatPengajianBersama('MASTER','RESEARCH');
                                echo $penyeliaanMas;
                                ?></td>
                        </tr>
                        <tr>
                            <th>SARJANA KESIHATAN AWAM (MPH)</th>  
                            <td class="text-center"><?=
                                '-';
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
                                    $j = $penyeliaanPHD;
                                    $k = $penyeliaanDrPHD;
                                    if ($j >= $p->ans_no || $k >= $p->ans_no) {
                                        $s = 1;
                                        $totalPenyeliaan++;
                                    } else {
                                        $s = 0;
                                    }
                                } else if ($i == 2) {
                                    $master = $penyeliaanMas;
                                    // temp check sarjana penyelidikan saja  
                                    // belum kira MPH
                                    $j = 'TIDAK';
                                    if ($master >= 1) {
                                        $j = 'YA';
                                    }

                                    if ($j >= $p->ans_char) {
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
                                    $color = "white";
                                    $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                }
                                ?>
                                <td style="background-color:<?= $color; ?>; width:5%;" class="text-center">  
                                    <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                            <?php
                        }

                        if ($totalPenyeliaan >= 1) {
                            $color1 = "#20c997";
                            $button1 = "<i class='fa fa-check-circle fa-lg'></i>";
                        } else {
                            $color1 = "red";
                            $button1 = "<i class='fa fa-times-circle fa-lg'></i>";
                        }
                        ?>
                        <tr>     
                            <th style="background-color:#20c997; color:white;" colspan="4">STATUS KESELURUHAN <br/><br/> * Memenuhi salah satu sub penyeliaan (i,ii) yang dinyatakan diatas.</th>  
                            <td style="background-color:<?= $color1; ?>; width:5%;" class="text-center">  
                                <?= Html::a($button1, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="x_panel">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr> 
                            <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">SANJUNGAN AKADEMIK & KEPIMPINAN AKADEMIK</th>  

                        </tr> 

                        <tr> 
                            <th class="text-center" colspan="3">KRITERIA</th> 
                            <th class="text-center">JUMLAH SEMASA</th> 
                        </tr>
                        <tr>  
                            <th colspan="3">EDITOR JURNAL BERINDEKS <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'publication',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            <td class="text-center"><?=
                                count(array_filter($model->publication, function ($var) {
                                            return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article' && $var['KeteranganBI_WriterStatus'] == 'Editor');
                                        }));
                                ?></td>
                        </tr>
                        <tr>  
                            <th colspan="3">PENILAI JURNAL BERINDEKS <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'consultancy',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            <td class="text-center"><?=
                                count(array_filter($model->outreaching, function ($var) {
                                            return ($var['Keahlian'] == 'Indexed Journal Assessor');
                                        }));
                                ?></td>
                        </tr>
                        <tr>  
                            <th colspan="3">PENILAI MANUSKRIP BUKU <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'consultancy',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            <td class="text-center"><?=
                                count(array_filter($model->outreaching, function ($var) {
                                            return ($var['Keahlian'] == 'Book Manuscript Reviewer');
                                        }));
                                ?></td>
                        </tr>
                        <tr>  
                            <th colspan="3">PENILAI LUAR KENAIKAN PANGKAT <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'consultancy',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            <td class="text-center"><?=
                                count(array_filter($model->outreaching, function ($var) {
                                            return ($var['Keahlian'] == ' External Assessor for Promotion');
                                        }));
                                ?></td>
                        </tr> 
                        <tr>
                            <th colspan="4" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMPPI</th>
                        </tr> 
                        <tr> 
                            <th>PEMERIKSA TESIS PASCASISWAZAH <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'esteem',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            <th colspan="2">MASTER (RESEARCH/MPH)</th>
                            <td class="text-center"><?=
                                count(array_filter($model->asPanel, function ($var) {
                                            return ($var['type'] == 13 && ($var['level'] == 'Master (Research/MPH)')); //Thesis Examiner (By Research)
                                        }));
                                ?></td>
                        </tr> 
                        <tr>
                            <th colspan="4" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data HROnline</th>
                        </tr>
                        <tr> 
                            <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PERSIDANGAN (YANG DISAHKAN) <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'conferences',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>  

                        </tr> 
                        <tr>
                            <th>PERINGKAT</th> 
                            <th colspan="3">ANTARABANGSA</th>  
                        </tr>


                        <?php foreach ($model->rolepersidangan as $r) { ?> 
                            <tr>

                                <th>
                                    <?= strtoupper($r['Peranan']) ?> 

                                </th> 
                                <td colspan="3" class="text-center">
                                    <?=
                                    count(array_filter($model->persidangan2, function ($var) use ($r) {
                                                return ($var['Peringkat'] == 'Antarabangsa' && $var['Peranan'] == $r['Peranan']);
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
                        $totalSanjungan = 0;
                        foreach ($persidangan as $p) {
                            if ($i >= 7) {
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
                                    if ($i == 7) {
                                        $j = count(array_filter($model->publication, function ($var) {
                                                    return (($var['IndexingDesc'] == 'High-Indexed (SCOPUS, WOS, ERA)' || $var['IndexingDesc'] == 'Indexing (Mycite)') && $var['Keterangan_PublicationTypeID'] == 'Article' && $var['KeteranganBI_WriterStatus'] == 'Editor');
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $totalSanjungan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } elseif ($i == 8) {
                                        $j = count(array_filter($model->outreaching, function ($var) {
                                                    return ($var['Keahlian'] == 'Indexed Journal Assessor');
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $totalSanjungan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } elseif ($i == 9) {
                                        $j = count(array_filter($model->outreaching, function ($var) {
                                                    return ($var['Keahlian'] == 'Book Manuscript Reviewer');
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $totalSanjungan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } elseif ($i == 10) {
                                        $j = count(array_filter($model->outreaching, function ($var) {
                                                    return ($var['Keahlian'] == ' External Assessor for Promotion');
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $totalSanjungan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } elseif ($i == 11) {
                                        $j = count(array_filter($model->persidangan2, function ($var) {
                                                    return ($var['Peringkat'] == 'Antarabangsa' && ($var['Peranan'] == 'Keynote Speaker' || $var['Peranan'] == 'Ahli Panel'));
                                                }));
                                        if ($j >= $p->ans_no) {
                                            $s = 1;
                                            $totalSanjungan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } elseif ($i == 12) {
                                        $k = count(array_filter($model->asPanel, function ($var) {
                                                    return ($var['type'] == 13 && ($var['level'] == 'Master (Research/MPH)')); //Thesis Examiner (By Research)
                                                }));

                                        if ($k >= $p->ans_no) {
                                            $s = 1;
                                            $totalSanjungan++;
                                        } else {
                                            $s = 0;
                                        }
                                    } else {
                                        //temp for (no data)
                                        $s = 2;
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

                        if ($totalSanjungan >= 1) {
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

            <div class="x_panel">   
                <div class="table-responsive">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        
                            <table class="table table-sm table-bordered jambo_table table-striped">
                                <tr>
                                    <th colspan="3" class="text-center" style="background-color:#2A3F54; color:white;">LANTIKAN PENTADBIRAN </th>
                                </tr> 
                                <tr> 
                                    <th class="text-center" colspan="2">KRITERIA</th> 
                                    <th class="text-center">JUMLAH SEMASA</th> 
                                </tr> 


                                <tr>  
                                    <th>DEKAN / PENGARAH</th>
                                    <th rowspan="4" class="text-center"><br/><br/>REKOD LANTIKAN PENTADBIRAN<br/>
                                        <?php
                                        if (Yii::$app->user->getId() == $model->ICNO) {
                                            echo Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['services-university'], ['class' => 'btn btn-default', 'target' => '_blank']);
                                        } else {
                                            echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'personal',], ['class' => 'btn btn-default', 'target' => '_blank']);
                                        }
                                        ?>
                                    </th>
                                    <th class="text-center"> 
                                        <!--Dekan = 3
                                       Pengarah (Akademik) = 5
                                       Pengarah (Pentadbiran) = 10 -->
                                        <?=
                                        count(array_filter($model->adminPosition, function ($var) {
                                                    return ($var['adminpos_id'] == '3' || $var['adminpos_id'] == '5' || $var['adminpos_id'] == '10');
                                                }))
                                        ?>
                                    </th>
                                </tr>
                                <tr>  
                                    <th>TIMBALAN DEKAN / TIMBALAN PENGARAH / KETUA JABATAN</th>
                                    <th class="text-center"> 
                                        <!--Timbalan Dekan (Akademik) = 4
                                            Timbalan Pengarah (Akademik) = 6
                                            Timbalan Pengarah (Pentadbiran) = 11
                                            Timbalan Pengarah (Pengurusan & Operasi) = 21
                                            Timbalan Pengarah (Kewangan) = 22
                                            Timbalan Pengarah (Klinikal)= 23
                                            Ketua (Akademik) = 7
                                            Ketua (Pentadbiran) = 12 -->
                                        <?=
                                        count(array_filter($model->adminPosition, function ($var) {
                                                    return ($var['adminpos_id'] == '4' || $var['adminpos_id'] == '6' || $var['adminpos_id'] == '11' || $var['adminpos_id'] == '21' || $var['adminpos_id'] == '22' || $var['adminpos_id'] == '23' || $var['adminpos_id'] == '7' || $var['adminpos_id'] == '12');
                                                }))
                                        ?>
                                    </th>
                                    </th>
                                </tr>
                                <tr>  
                                    <th>KETUA PROGRAM</th>
                                    <th class="text-center"> 
                                        <?=
                                        count(array_filter($model->adminPosition, function ($var) {
                                                    return ($var['adminpos_id'] == '18');
                                                }))
                                        ?>
                                    </th>
                                </tr>
                                <tr>  
                                    <th>PENYELARAS</th>
                                    <th class="text-center"> 
                                        <?=
                                        count(array_filter($model->adminPosition, function ($var) {
                                                    return ($var['adminpos_id'] == '8');
                                                }))
                                        ?>
                                    </th>
                                </tr>
                                <tr>  
                                    <th>KETUA UNIT</th>
                                    <th rowspan="2" class="text-center"><br/><br/>REKOD KHIDMAT UNIVERSITI<br/>
                                        <?php
                                        if (Yii::$app->user->getId() == $model->ICNO) {
                                            echo Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'services',], ['class' => 'btn btn-default', 'target' => '_blank']);
                                        } else {
                                            echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'services',], ['class' => 'btn btn-default', 'target' => '_blank']);
                                        }
                                        ?>
                                    </th>
                                    <th class="text-center"> 
                                        <?=
                                        count(array_filter($model->serviceUniversity, function ($var) {
                                                    return ($var['level'] == '10');
                                                }))
                                        ?>
                                    </th>
                                </tr>
                                <tr>  
                                    <th>TIMBALAN PENYELARAS</th>
                                    <th class="text-center"> 
                                        <?=
                                        count(array_filter($model->serviceUniversity, function ($var) {
                                                    return ($var['level'] == '11');
                                                }))
                                        ?>
                                    </th>
                                </tr> 
                            <tr>
                                <th colspan="3" class="text-center" style="background-color:#2A3F54; color:white;">KHIDMAT KEPADA UNIVERSITI <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'services',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            </tr> 
                            <tr> 
                                <th colspan="2" class="text-center">KRITERIA</th> 
                                <th class="text-center">JUMLAH SEMASA</th> 
                            </tr> 
                            <tr>  
                                <th colspan="2">JAWATANKUASA PERINGKAT UNIVERSITI</th>
                                <th class="text-center"><?=
                                    count(array_filter($model->serviceUniversity, function ($var) {
                                                return ($var['level'] == '5');
                                            }))
                                    ?></th>
                            </tr>
                            <tr>  
                                <th colspan="2">JAWATANKUASA PERINGKAT JFPIU</th>
                                <th class="text-center"><?=
                                    count(array_filter($model->serviceUniversity, function ($var) {
                                                return ($var['level'] == '6');
                                            }))
                                    ?></th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-center" style="background-color:#2A3F54; color:white;">KHIDMAT KEPADA MASYARAKAT <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'services',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                            </tr> 
                            <tr> 
                                <th colspan="2" class="text-center">KRITERIA</th> 
                                <th class="text-center">JUMLAH SEMASA</th> 
                            </tr> 
                            <tr>  
                                <th colspan="2">PERINGKAT ANTARABANGSA</th>
                                <th class="text-center"><?=
                                    count(array_filter($model->serviceCommunity, function ($var) {
                                                return ($var['level'] == '1');
                                            }))
                                    ?></th>
                            </tr>   
                            <tr>  
                                <th colspan="2">PERINGKAT KEBANGSAAN</th>
                                <th class="text-center"><?=
                                    count(array_filter($model->serviceCommunity, function ($var) {
                                                return ($var['level'] == '2');
                                            }))
                                    ?></th>
                            </tr>
                            <tr>  
                                <th colspan="2">PERINGKAT NEGERI</th>
                                <th class="text-center"><?=
                                    count(array_filter($model->serviceCommunity, function ($var) {
                                                return ($var['level'] == '3');
                                            }))
                                    ?></th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data HROnline</th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <tr>
                                <th colspan="2" class="text-center" style="background-color:#20c997; color:white;">KRITERIA KHIDMAT KEPADA UNIVERSITI (PENTADBIRAN)</th>
                            </tr>
                            <?php
                            $i = 1;
                            $totalService = 0;
                            foreach ($service as $p) {
                                if ($i <= 4) {
                                    ?>
                                    <tr>     
                                        <th><?= $p->requirement; ?></th>      
                                        <?php
                                        if ($i == 1) {
                                            $j = count(array_filter($model->adminPosition, function ($var) {
                                                                return ($var['adminpos_id'] == '3' || $var['adminpos_id'] == '5' || $var['adminpos_id'] == '10');
                                                            })) + count(array_filter($model->serviceUniversity, function ($var) {
                                                                return ($var['level'] == '10');
                                                            }));
                                            if ($j >= $p->ans_no) {
                                                $s = 1;
                                                $totalService++;
                                            } else {
                                                $s = 0;
                                            }
                                        } else if ($i == 2) {
                                            $j = count(array_filter($model->adminPosition, function ($var) {
                                                        return ($var['adminpos_id'] == '4' || $var['adminpos_id'] == '6' || $var['adminpos_id'] == '11' || $var['adminpos_id'] == '21' || $var['adminpos_id'] == '22' || $var['adminpos_id'] == '23' || $var['adminpos_id'] == '7' || $var['adminpos_id'] == '12');
                                                    }));

                                            if ($j >= $p->ans_no) {
                                                $s = 1;
                                                $totalService++;
                                            } else {
                                                $s = 0;
                                            }
                                        } else if ($i == 3) {
                                            $j = count(array_filter($model->adminPosition, function ($var) {
                                                        return ($var['adminpos_id'] == '18');
                                                    }));
                                            if ($j >= $p->ans_no) {
                                                $s = 1;
                                                $totalService++;
                                            } else {
                                                $s = 0;
                                            }
                                        } else if ($i == 4) {
                                            $j = count(array_filter($model->adminPosition, function ($var) {
                                                                return ($var['adminpos_id'] == '8');
                                                            })) + count(array_filter($model->serviceUniversity, function ($var) {
                                                                return ($var['level'] == '11');
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
                                }$i++;
                            }
                            if ($totalService >= 1) {
                                $Scolor = "#20c997";
                                $button = "<i class='fa fa-check-circle fa-lg'></i>";
                            } else {
                                $Scolor = "red";
                                $button = "<i class='fa fa-times-circle fa-lg'></i>";
                            }
                            ?>
                            <tr>     
                                <th style="background-color:#20c997; color:white;">STATUS KESELURUHAN <br/><br/> * Memenuhi salah satu sub kriteria khidmat kepada universiti (i,ii,iii,iv) yang dinyatakan diatas.</th>  
                                <td style="background-color:<?= $Scolor; ?>; width:5%;" class="text-center">  
                                    <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <tr>
                                <th colspan="4" class="text-center" style="background-color:#20c997; color:white;">KRITERIA KHIDMAT KEPADA UNIVERSITI (KEAHLIAN JAWATANKUASA)</th>
                            </tr>
                            <?php
                            $n = 1;
                            $totalService1 = 0;
                            foreach ($service as $p) {
                                if ($n > 4 && $n <= 6) {
                                    ?>
                                    <tr>     
                                        <th colspan="3"><?= $p->requirement; ?></th>      
                                        <?php
                                        if ($n == 5) {
                                            $j = count(array_filter($model->serviceUniversity, function ($var) {
                                                        return ($var['level'] == '5');
                                                    }));
                                            if ($j >= $p->ans_no) {
                                                $s = 1;
                                                $totalService1++;
                                            } else {
                                                $s = 0;
                                            }
                                        } else if ($n == 6) {
                                            $j = count(array_filter($model->serviceUniversity, function ($var) {
                                                        return ($var['level'] == '6');
                                                    }));
                                            if ($j >= $p->ans_no) {
                                                $s = 1;
                                                $totalService1++;
                                            } else {
                                                $s = 0;
                                            }
                                        }


                                        if ($s == 1) {
                                            $color = "#20c997";
                                            $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                        } else {
                                            $color = "red";
                                            $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                        }
                                        ?>
                                        <td style="background-color:<?= $color; ?>;width: 25px;" class="text-center">  
                                            <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                        </td>
                                    </tr>
                                    <?php
                                }$n++;
                            }
                            ?>
                        </table>
                        <table class="table table-sm table-bordered jambo_table table-striped">
                            <tr>
                                <th colspan="2" class="text-center" style="background-color:#20c997; color:white;">KRITERIA KHIDMAT KEPADA MASYARAKAT</th>
                            </tr>
                            <?php
                            $k = 1;
                            $totalService2 = 0;
                            foreach ($service as $p) {
                                if ($k > 6 && $k <= 9) {
                                    ?>
                                    <tr>     
                                        <th><?= $p->requirement; ?></th>      
                                        <?php
                                        if ($k == 7) {
                                            $j = count(array_filter($model->serviceCommunity, function ($var) {
                                                        return ($var['level'] == '1');
                                                    }));
                                            if ($j >= $p->ans_no) {
                                                $s = 1;
                                                $totalService2++;
                                            } else {
                                                $s = 0;
                                            }
                                        } else if ($k == 8) {
                                            $j = count(array_filter($model->serviceCommunity, function ($var) {
                                                        return ($var['level'] == '2');
                                                    }));
                                            if ($j >= $p->ans_no) {
                                                $s = 1;
                                                $totalService2++;
                                            } else {
                                                $s = 0;
                                            }
                                        } else if ($k == 9) {
                                            $j = count(array_filter($model->serviceCommunity, function ($var) {
                                                        return ($var['level'] == '3');
                                                    }));
                                            if ($j >= $p->ans_no) {
                                                $s = 1;
                                                $totalService2++;
                                            } else {
                                                $s = 0;
                                            }
                                        }


                                        if ($s == 1) {
                                            $color = "#20c997";
                                            $button = "<i class='fa fa-check-circle fa-lg'></i>";
                                        } else {
                                            $color = "white";
                                            $button = "<i class='fa fa-times-circle fa-lg'></i>";
                                        }
                                        ?>
                                        <td style="background-color:<?= $color; ?>;width: 25px;" class="text-center">  
                                            <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                        </td>
                                    </tr>
                                    <?php
                                }$k++;
                            }
                            if ($totalService2 >= 1) {
                                $Scolor = "#20c997";
                                $button = "<i class='fa fa-check-circle fa-lg'></i>";
                            } else {
                                $Scolor = "red";
                                $button = "<i class='fa fa-times-circle fa-lg'></i>";
                            }
                            ?>
                            <tr>     
                                <th style="background-color:#20c997; color:white;">STATUS KESELURUHAN <br/><br/> * Memenuhi salah satu sub kriteria khidmat kepada masyarakat (i,ii,iii) yang dinyatakan diatas.</th>  
                                <td style="background-color:<?= $Scolor; ?>; width:5%;" class="text-center">  
                                    <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="x_panel">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="3" class="text-center" style="background-color:#2A3F54; color:white;">PERUNDINGAN / PERUNDINGAN KLINIKAL / JARINGAN INDUSTRI </th>
                        </tr> 
                        <tr> 
                            <th class="text-center">KRITERIA</th>  
                            <th class="text-center" colspan="2">STATUS</th> 
                        </tr>
                        <?php
                        if ($model->nsr) {
                            $nsr = 'YA';
                        } else {
                            $nsr = 'TIADA MAKLUMAT';
                        }
                        ?>
                        <tr>       
                            <th>NATIONAL SPECIALIST REGISTER (NSR)  </th>
                            <th class="text-center"><?= $nsr; ?></th> 
                            <th class="text-center"> <?php
                                if (Yii::$app->user->getId() == $model->ICNO) {
                                    echo Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['badan-profesional/view'], ['class' => 'btn btn-default', 'target' => '_blank']);
                                } else {
                                    echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['badan-profesional/adminview', 'icno' => $model->ICNO], ['class' => 'btn btn-default', 'target' => '_blank']);
                                }
                                ?></th> 
                        </tr>
                        <?php
                        if ($model->findAnugerah('9999025')) {// anugerah Credentialing and Priveledging
                            $cp = 'YA';
                        } else {
                            $cp = 'TIADA MAKLUMAT';
                        }
                        ?>
                        <tr>         
                            <th>PENGIKTIRAFAN CREDENTIALING AND PRIVELEDGING DARIPADA INSTITUSI PERUBATAN DALAM ATAU LUAR NEGARA </th>   
                            <th class="text-center"><?= $cp; ?> </th>
                            <th class="text-center"><?php
                                if (Yii::$app->user->getId() == $model->ICNO) {
                                    echo Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['anugerah/view'], ['class' => 'btn btn-default', 'target' => '_blank']);
                                } else {
                                    echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['anugerah/adminview', 'icno' => $model->ICNO], ['class' => 'btn btn-default', 'target' => '_blank']);
                                }
                                ?></th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data HROnline</th>
                        </tr>
                        <tr> 
                            <th class="text-center">KRITERIA</th> 
                            <th class="text-center" colspan="2">JUMLAH SEMASA</th> 
                        </tr>
                        <tr>  
                            <th>BILANGAN PERUNDINGAN KLINIKAL (YANG DISAHKAN)</th>
                            <td class="text-center"><?php
                                $totalP = count(array_filter($model->outreaching, function ($var) {
                                                    return ($var['StatusPengesahan'] == 'V'); //verified
                                                })) + count(array_filter($model->outreachingClinical, function ($var) {
                                                    return ($var['ApproveStatus'] == 'V'); //verified
                                                }));

                                echo $totalP;
                                ?></td>
                            <th class="text-center"><?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'consultancy',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?> </th>
                        </tr> 
                        <tr>
                            <th colspan="3" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMPPI</th>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">  
                    <table class="table table-sm table-bordered jambo_table table-striped">
                        <tr>
                            <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA PERUNDINGAN / PERUNDINGAN KLINIKAL / JARINGAN INDUSTRI</th>
                        </tr>
                        <?php
                        $i = 1;
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
                                if ($i == 1) {
                                    if ($nsr == $p->ans_char) {
                                        $s = 1;
                                        $totalPerundingan++;
                                    } else {
                                        $s = 0;
                                        $prndgn1 = 0;
                                    }
//                                    $s = 3;
                                } elseif ($i == 2) {

                                    if ($cp == $p->ans_char) {
                                        $s = 1;
                                        $totalPerundingan++;
                                    } else {
                                        $s = 0;
                                        $prndgn1 = 0;
                                    }
                                } elseif ($i == 3) {
                                    if ($totalP >= 1) {
                                        $s = 1;
                                        $totalPerundingan++;
                                    } else {
                                        $s = 0;
                                        $prndgn1 = 0;
                                    }
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
                        }$i++;
                        ?>
                    </table>
                </div>
            </div>
        </div> 
    </div>  
</div> 
</div>   
