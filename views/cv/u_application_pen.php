<?php

use app\assets\StepperAsset;
use app\models\cv\RequirementMain;
use app\models\cv\RequirementUmum;
use \app\models\hronline\GredJawatan;
use yii\helpers\Html;
use kartik\popover\PopoverX;

StepperAsset::register($this);
$request = Yii::$app->request;
$gred = $request->get('gred');
$jawatan = GredJawatan::findOne(['id' => $gred]);
error_reporting(0)
?>
<?php echo $this->render('menu'); ?>   
<?php echo $this->render('main_head', ['biodata' => $model]); ?> 
<div class="x_panel"> 
    <u><h2><strong>KRITERIA - <?= $jawatan->fname; ?></strong></h2></u>  
    <div class="clearfix"></div> 
    <div class="x_content">   
        <div id="wizard_verticle" class="form_wizard wizard_verticle">
            <ul class="list-unstyled wizard_steps"> 
                <li>
                    <a href="#step-22">
                        <span class="step_no">1</span>
                    </a>
                </li>
                <li>
                    <a href="#step-33">
                        <span class="step_no">2</span>
                    </a>
                </li> 
            </ul> 
            <div id="step-22">
                <div class="x_panel">

                    <?php
                    $umum = RequirementMain::umum();
                    $tempoh = RequirementUmum::tempoh(99);
                    ?> 

                    <div class="hide">  
                        <form>
                            <input id="gred_apply" class="form-control" value=<?= $jawatan->id; ?> > 
                        </form>
                    </div> 
                    <div class="table-responsive">
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
                                    <td colspan="2"><?= '<b>' . $model->markahlnptCVpen(1, 'Tahun') . ' :</b> ' . $model->markahlnptCVpen(1, 'Markah'); ?></td> 
                                </tr>
                                <tr>   
                                    <td colspan="2"><?= '<b>' . $model->markahlnptCVpen(2, 'Tahun') . ' :</b> ' . $model->markahlnptCVpen(2, 'Markah'); ?></td>  
                                </tr>
                                <tr>
                                    <td colspan="2"><?= '<b>' . $model->markahlnptCVpen(3, 'Tahun') . ' :</b> ' . $model->markahlnptCVpen(3, 'Markah'); ?></td> 
                                </tr> 
                                <tr>
                                    <td colspan="2">   
                                        <?php if (!empty($model->markahlnptCVpen(3, 'Tahun'))) { ?>
                                            Avg (3 Tahun) : 
                                            <?php
                                            $lnpt = number_format(($model->markahlnptCVpen(3, 'Markah') * 0.2) + ($model->markahlnptCVpen(2, 'Markah') * 0.35) + ($model->markahlnptCVpen(1, 'Markah') * 0.45), 2, '.', '');
                                            echo $lnpt;
                                        } else {
                                            ?> 
                                            Avg (2 Tahun) : 
                                            <?php
                                            $lnpt = number_format(($model->markahlnptCVpen(2, 'Markah') * 0.6) + ($model->markahlnptCVpen(1, 'Markah') * 0.4), 2, '.', '');
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
                                    <td colspan="2"><?= $model->usercv->statusTatatertib(); ?></td> 
                                </tr> 
                                <tr>   
                                    <th>SEKURANG-KURANGNYA 3 TAHUN DI JAWATAN SEMASA</th>  
                                    <td colspan="2">
                                        <?= $model->getServPeriod(99, 'Tempoh'); ?> 
                                    </td> 
                                </tr> 
                                <tr>   
                                    <th>TARIKH PERISYTIHARAN HARTA</th>  
                                    <td colspan="2"><?php
                                        if ($model->usercv->sahHarta) {
                                            echo $model->usercv->sahHarta->ADDeclDt;
                                        } else {
                                            echo '<span class="label label-danger">Tiada Maklumat</span> ' . Html::a('<i class="fa fa-edit" aria-hidden="true"></i>', ['harta/permohonan'], ['class' => 'btn btn-default btn-md', 'target' => '_blank']);
                                        }
                                        ?></td> 
                                </tr>
                            </table>
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
                                            $s = $model->usercv ? $model->usercv->statusTatatertib() : '-';
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

                                $i = 1;
                                $totalTempoh = 0;
                                foreach ($tempoh as $p) {
                                    ?>

                                    <tr>     
                                        <th colspan="2"><?= $p->requirement; ?></th>  
                                        <?php
                                        if ($i == 1) {
                                            if ($model->usercv->sahHarta) {
                                                $s = 1;
                                                $totalTempoh++;
                                            } else {
                                                $s = 0;
                                            }
                                        } elseif ($i == 2) {
                                            if ($model->getServPeriod(99, 'Kriteria') >= $p->ans_no) {
                                                $s = 1;
                                                $totalTempoh++;
                                            } else {
                                                $s = 0;
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
                                        <td colspan="2" style="background-color:<?= $color; ?>" class="text-center">  
                                            <?= Html::a($button, [''], ['class' => 'btn btn-default btn-md', 'disabled' => true]); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </center>
                    </div> 
                </div>
            </div>
            <?php
            if ($totalUmum++ == 4 && $totalTempoh == 2) {
                $checking = 1;
            } else {
                $checking = 0;
            }
            ?>

            <div class="hide">  
                <form>  
                    <input id="checking" class="form-control" value=<?= $checking; ?>> 
                </form>
            </div>

            <div id="step-33">
                <div class="x_panel">
                    <h2 class="StepTitle"><b>PENGAKUAN</b></h2>  
                    <p>
                        Dengan ini saya menyatakan bahawa telah mematuhi peraturan jam kerja seperti yang ditetapkan dalam Pekeliling Pendaftar Bil. 1/2015: Peraturan Waktu Kerja Bertingkat UMS (Pindaan 2015) DAN semua maklumat dalam permohonan ini adalah benar. Sekiranya saya terbukti memalsukan sebarang maklumat, permohonan ini atau surat tawaran promosi akan diberhentikan serta-merta dan saya akan dikenakan tindakan tatatertib, sesuai dengan Peraturan 3 (2) (f) Jadual Kedua, Akta Badan Berkanun (Tatatertib & Surcaj) 2000 (Akta 605).
                    </p> 
                    <br/><br/>
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">Pilih Pegawai Peraku: <span class="required" style="color:red;">*</span> 
                        </label>
                        <div class="col-md-5 col-sm-5 col-xs-12"> 
                            <form> 
                                <b>Sila pilih pegawai peraku anda...</b>
                                <br/><br/>
                                <select id="peraku" class="form-control">
                                    <?php
                                    $peg = \app\models\hronline\Tblprcobiodata::find()->where(['!=', 'Status', 6])->andWhere(['!=', 'ICNO', Yii::$app->user->getId()])->orderBy(['CONm' => SORT_ASC])->all();
                                    foreach ($peg as $j) {
                                        ?>
                                        <option value=<?= $j->ICNO; ?>><?= $j->CONm; ?></option>  
                                    <?php } ?>
                                </select>  
                                <br/>
                                <b>Pegawai peraku merujuk kepada Ketua Jabatan semasa atau jabatan terdahulu yang menyelia pemohon bagi tempoh minimum enam (6) bulan. </b>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div> 

        <br/> 

    </div> 
</div>   
