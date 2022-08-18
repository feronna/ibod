<?php
 
use app\models\cv\RequirementUmum;
use \app\models\hronline\GredJawatan;
use yii\helpers\Html;
use yii\helpers\Url;
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
                            <tr>   
                                <th>TEMPOH PERKHIDMATAN</th>  
                                <td colspan="2"><?= $model->getServPeriod($jawatan->id, 'Tempoh'); ?></td> 
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
                                <th colspan="2"><?= $p->requirement; ?></th>  
                                <?php
                                if ($model->getServPeriod($jawatan->id, 'Kriteria') >= $p->ans_no) {
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
                        </table>
                    </center>
                </div>
            </div> 
        </div>   
        <?php
        if ($totalUmum == 4 && $totalTempoh == 1) {
            $umum = 1; //pass all kriteria umum
        } else {
            $umum = 0;
        }
        ?>

        <div class="x_panel">
            <div class="x_title">
                <h2>KRITERIA KHUSUS</h2>  
                <div class="clearfix"></div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr>
                        <th colspan="3" class="text-center" style="background-color:#2A3F54; color:white;">KHIDMAT KEPADA UNIVERSITI DAN MASYARAKAT <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'services',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>
                    </tr> 
                    <tr> 
                        <th class="text-center">KRITERIA</th> 
                        <th class="text-center">JUMLAH SEMASA</th> 
                    </tr>  

                    <tr>  
                        <th>UNIVERSITI</th> 
                        <th class="text-center"><?= count(array_filter($model->serviceUniversity)); ?></th>
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
                            $j = count(array_filter($model->serviceUniversity));
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
                    ?>
                </table>
            </div>
        </div> 
        <?php
        if ($totalService == 1) {
            $serviceS = 1;
        } else {
            $serviceS = 1;
        }
        ?>

        <div class="x_panel">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <table class="table table-sm table-bordered jambo_table table-striped">
                    <tr> 
                        <th colspan="4" class="text-center" style="background-color:#2A3F54; color:white;">PERSIDANGAN (YANG DISAHKAN) <?= Html::a('<i class="fa fa-search"></i>', ['view-cv', 'id' => sha1($model->ICNO), 'title' => 'conferences',], ['class' => 'btn btn-default btn-sm', 'target' => '_blank',]); ?></th>  

                    </tr>  
                    <tr> 
                        <th class="text-center" colspan="3">KRITERIA</th> 
                        <th class="text-center">JUMLAH SEMASA</th> 
                    </tr> 
                    <tr>
                        <th rowspan="9" colspan="2">UNIVERSITI</th> 
                    </tr>

                    <?php foreach ($model->rolepersidangan as $r) { ?>
                        <tr>
                            <th><?= strtoupper($r['Peranan']) ?></th>
                            <td class="text-center">
                                <?=
                                count(array_filter($model->persidangan2, function ($var) use ($r) {
                                            return ($var['Peringkat'] == 'Universiti' && $var['Peranan'] == $r['Peranan']);
                                        }))
                                ?> 
                            </td>

                        </tr> 
                    <?php } ?>  
                    <tr>
                        <th rowspan="9" colspan ="2">KEBANGSAAN</th>  
                    </tr>

                    <?php foreach ($model->rolepersidangan as $r) { ?> 
                        <tr>
                            <th><?= strtoupper($r['Peranan']) ?></th>
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
                        <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA PERSIDANGAN</th>
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
                                            return ($var['Peringkat'] == 'Kebangsaan' || $var['Peringkat'] == 'Universiti');
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
        <?php
        if ($totalPersidangan == 1) {
            $persdgn = 1;
        } else {
            $persdgn = 0;
        }
        ?> 

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
                        <th rowspan="3">JURNAL BERINDEKS/ TIDAK BERINDEKS</th> 
                        <th>JURNAL</th> 
                        <td class="text-center"><?=
                            count(array_filter($model->publication, function ($var) {
                                        return (($var['Keterangan_PublicationTypeID'] == 'Article'));
                                    }));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>BAB DALAM BUKU</th>
                        <td class="text-center"><?=
                            count(array_filter($model->publication, function ($var) {
                                        return (($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book'));
                                    }));
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>MAJALAH POPULAR/SURAT KHABAR</th>
                        <td class="text-center"><?=
                            count(array_filter($model->publication, function ($var) {
                                        return (($var['Keterangan_PublicationTypeID'] == 'Article in Mass Media/Magazine'));
                                    }));
                            ?>
                        </td>
                    </tr>  
                    <tr>
                        <th colspan="4" class="text-center"><button class="btn btn-default btn-md"><i class="fa fa-map-marker" aria-hidden="true"></i></button> Sumber data SMPPI</th>
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
                                            return (($var['Keterangan_PublicationTypeID'] == 'Article') || ($var['Keterangan_PublicationTypeID'] == 'Chapter(s) in Book') || ($var['Keterangan_PublicationTypeID'] == 'Article in Mass Media/Magazine'));
                                        }));
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
        <?php
        if ($totalPenerbitan == 1) {
            $pnrbtn = 1;
        } else {
            $pnrbtn = 0;
        }
        ?>

        <?php
        if ($umum == 1 && $serviceS == 1 && $persdgn == 1 && $pnrbtn == 1) {
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
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Aduan', ['complain'], ['class' => 'btn btn-warning']); ?> <?= Html::a('Submit', ['appsubmit', 'id' => $jawatan->id, 'status' => $checking], ['class' => 'btn btn-primary']); ?>
            </p>
        </div> 
    </div>  
</div> 
</div>   
