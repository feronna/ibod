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
                                        if (!empty($model->markahlnptCV(2, 'Tahun')) && !empty($model->markahlnptCV(1, 'Tahun'))) {
                                        $lnpt = number_format(($model->markahlnptCV(2, 'Markah') * 0.6) + ($model->markahlnptCV(1, 'Markah') * 0.4));
                                        echo $lnpt;
                                        } else {
                                            echo '';
                                        }
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
            <?php if($pakar==1) {?>
            <div class="x_panel">
                <div class="x_title">
                    <h2>KRITERIA KHUSUS</h2>  
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center>
                        <table class="table table-bordered table-sm jambo_table table-striped" style="width:80%"> 
                            <tr> 
                                <th class="text-center" style="background-color:#2A3F54; color:white;">KRITERIA PAKAR</th>  
                                <th class="text-center" style="background-color:#2A3F54; color:white;" colspan="2">STATUS</th> 
                            </tr>
                            <?php
                            if (!empty($model->getPendidikanbyTahap(45)) || !empty($model->getPendidikanbyTahap(46))) {
                                $smedic = 'YA';
                            } else {
                                $smedic = 'TIADA MAKLUMAT';
                            }
                            ?>
                            <tr>      

                                <th>i. Sarjana Perubatan Kepakaran (4 tahun pengajian) atau,<br/> ii. Kelayakan Kepakaran Perubatan (Parallel Pathway)</th>  
                                <th><?= $smedic; ?></th>
                                <th>

                                    <?php
                                    if (Yii::$app->user->getId() == $model->ICNO) {
                                        echo Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['pendidikan/view'], ['class' => 'btn btn-default', 'target' => '_blank']);
                                    } else {
                                        echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['pendidikan/adminview', 'icno' => $model->ICNO], ['class' => 'btn btn-default', 'target' => '_blank']);
                                    }
                                    ?>

                                </th>  
                            </tr> 
                            <tr>  
                                <th class="text-center" style="background-color:#2A3F54; color:white;" colspan="3">PERKHIDMATAN</th> 
                            </tr>
                            <tr>      
                                <th>KKM &nbsp;&nbsp;
                                <?= PopoverX::widget([
                                            'header' => '<span style="color:black;">Maklumat</span>',
                                            'type' => PopoverX::TYPE_DEFAULT,
                                            'placement' => PopoverX::ALIGN_BOTTOM,
                                            'content' => '<strong>Nama Majikan:</strong> Kementerian Kesihatan Malaysia <br/> '
                                    . '<strong>Jenis Majikan:</strong> Sektor Awam',
                                            'toggleButton' => ['label' => '<i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-default'],
                                        ]);
                                    ?>
                                </th>   
                                <th><?= $model->getPengalamanKKMTahun(); ?></th> 
                                <th>
                                    <?php
                                    if (Yii::$app->user->getId() == $model->ICNO) {
                                        echo Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['pengalamankerja/view'], ['class' => 'btn btn-default', 'target' => '_blank']);
                                    } else {
                                        echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['pengalamankerja/adminview', 'icno' => $model->ICNO], ['class' => 'btn btn-default', 'target' => '_blank']);
                                    }
                                    ?>
                                </th>
                            </tr>
                            <tr>      
                                <th>UMS</th>   
                                <th colspan="2"><?= $model->getPengalamanUMSTahun(); ?></th>   
                            </tr>  
                        </table> 
                    </center>
                </div> 
                <?php
                if ($smedic == 'YA') {//sarjana kepakaran
                    $color1 = "#20c997";
                    $button1 = "<i class='fa fa-check-circle fa-lg'></i>";
                } else {
                    $color1 = "red";
                    $button1 = "<i class='fa fa-times-circle fa-lg'></i>";
                } 


                if (($model->getPengalamanKKMTahun() + $model->getPengalamanUMSTahun()) >= 9) {
                    $color = "#20c997";
                    $button = "<i class='fa fa-check-circle fa-lg'></i>";
                } else {
                    $color = "red";
                    $button = "<i class='fa fa-times-circle fa-lg'></i>";
                }
                ?> 

                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center>
                        <table class="table table-sm jambo_table table-striped" style="width:80%"> 
                            <tr>
                                <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA</th>
                            </tr>
                            <tr>       
                                <th>Mempunyai sarjana Kepakaran.</th>   
                                <td style="background-color:<?= $color1; ?>" class="text-center">  
                                    <?= Html::a($button1, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td> 
                            </tr>
                            <tr>       
                                <th>9 Tahun perkhidmatan di KKM dan UMS atau pengalaman berkaitan</th>   
                                <td style="background-color:<?= $color; ?>" class="text-center">  
                                    <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                        </table> 
                    </center>
                </div> 

            </div> 
            
            
            <?php } elseif($pakar == 2) {?>
            <div class="x_panel">  
                <div class="x_title">
                    <h2>KRITERIA KHUSUS</h2>  
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center>
                        <table class="table table-bordered table-sm jambo_table table-striped" style="width:80%"> 
                            <tr> 
                                <th class="text-center" style="background-color:#2A3F54; color:white;">KRITERIA BUKAN PAKAR</th>  
                                <th class="text-center" style="background-color:#2A3F54; color:white;" colspan="2">STATUS</th> 
                            </tr>
                            <?php
                            if ($model->getPendidikanbyTahap(44)) {
                                $smedic = 'YA';
                            } else {
                                $smedic = 'TIADA MAKLUMAT';
                            }
                            ?>
                            <tr>      

                                <th>Sarjana Sains Perubatan (1-2 Tahun)</th>  
                                <th><?= $smedic; ?></th>
                                <th>

                                    <?php
                                    if (Yii::$app->user->getId() == $model->ICNO) {
                                        echo Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['pendidikan/view'], ['class' => 'btn btn-default', 'target' => '_blank']);
                                    } else {
                                        echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['pendidikan/adminview', 'icno' => $model->ICNO], ['class' => 'btn btn-default', 'target' => '_blank']);
                                    }
                                    ?>

                                </th>  
                            </tr> 
                            <tr>  
                                <th class="text-center" style="background-color:#2A3F54; color:white;" colspan="3">PERKHIDMATAN</th> 
                            </tr>
                            <tr>      
                                <th>KKM &nbsp;&nbsp;
                                <?= PopoverX::widget([
                                            'header' => '<span style="color:black;">Maklumat</span>',
                                            'type' => PopoverX::TYPE_DEFAULT,
                                            'placement' => PopoverX::ALIGN_BOTTOM,
                                            'content' => '<strong>Nama Majikan:</strong> Kementerian Kesihatan Malaysia <br/> '
                                    . '<strong>Jenis Majikan:</strong> Sektor Awam',
                                            'toggleButton' => ['label' => '<i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-default'],
                                        ]);
                                    ?>
                                </th>   
                                <th><?= $model->getPengalamanKKMTahun(); ?></th> 
                                <th>
                                    <?php
                                    if (Yii::$app->user->getId() == $model->ICNO) {
                                        echo Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['pengalamankerja/view'], ['class' => 'btn btn-default', 'target' => '_blank']);
                                    } else {
                                        echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['pengalamankerja/adminview', 'icno' => $model->ICNO], ['class' => 'btn btn-default', 'target' => '_blank']);
                                    }
                                    ?>
                                </th>
                            </tr>
                            <tr>      
                                <th>UMS</th>   
                                <th colspan="2"><?= $model->getPengalamanUMSTahun(); ?></th>   
                            </tr>  
                        </table> 
                    </center>
                </div> 
                <?php
                if ($smedic == 'YA') {//sarjana perubatan
                    $color1 = "#20c997";
                    $button1 = "<i class='fa fa-check-circle fa-lg'></i>";
                } else {
                    $color1 = "red";
                    $button1 = "<i class='fa fa-times-circle fa-lg'></i>";
                }


                if (($model->getPengalamanKKMTahun() + $model->getPengalamanUMSTahun()) >= 12) {
                    $color = "#20c997";
                    $button = "<i class='fa fa-check-circle fa-lg'></i>";
                } else {
                    $color = "red";
                    $button = "<i class='fa fa-times-circle fa-lg'></i>";
                }
                ?> 

                <div class="col-md-6 col-sm-6 col-xs-6">
                    <center>
                        <table class="table table-sm jambo_table table-striped" style="width:80%"> 
                            <tr>
                                <th colspan="5" class="text-center" style="background-color:#20c997; color:white;">KRITERIA</th>
                            </tr>
                            <tr>       
                                <th>Mempunyai Master dalam bidang sains perubatan (Medical Science).</th>   
                                <td style="background-color:<?= $color1; ?>" class="text-center">  
                                    <?= Html::a($button1, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td> 
                            </tr>
                            <tr>       
                                <th>12 Tahun perkhidmatan di KKM dan UMS atau pengalaman berkaitan</th>   
                                <td style="background-color:<?= $color; ?>" class="text-center">  
                                    <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                </td>
                            </tr>
                        </table> 
                    </center>
                </div>
            </div>
            <?php }?>
        </div> 

    </div> 
</div>   
