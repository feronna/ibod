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
                    <center>
                        <table class="table table-bordered table-sm jambo_table table-striped" style="width:80%"> 
                            <tr> 
                                <th class="text-center" style="background-color:#2A3F54; color:white;">KRITERIA</th>   
                            </tr>
                            <tr>          
                                <th>Telah diwartakan sebagai pakar klinikal untuk tempoh sekurang-kurangnya 5 tahun.</th> 
                            </tr> 
                            <tr>         
                                <th>Berdaftar dengan NSR (National Specialist Registery)</th>   
                            </tr>
                        </table> 
                    </center>
                </div> 
                <div class="col-md-6 col-sm-6 col-xs-6"> 
                    <table class="table table-bordered table-sm jambo_table table-striped" style="width:80%"> 
                        <tr> 
                            <th class="text-center" style="background-color:#20c997; color:white;">DOKUMEN SOKONGAN</th>   
                        </tr>
                        <tr>          
                            <th>Dokumen pembuktian perlu dikemukakan kepada pihak BSM: <br/> <br/> 
                                Razmi Bin Awang Osman<br/> 
                                Penolong Pendaftar Kanan<br/> 
                                Tel: 088320000 (samb. 102279)<br/>  
                                Emel:razmi_85@ums.edu.my
                            </th> 
                        </tr>  
                    </table> 
                </div>
            </div> 
        </div> 
        
        <?php
            if ($totalUmum == 4) {
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
                    <?= Html::a('<i class="fa fa-pencil-square-o"></i> Aduan', ['complain'], ['class' => 'btn btn-warning']); ?><?= Html::a('Submit', ['appsubmit', 'id' => $jawatan->id, 'status' => $checking, 'stpakar' => $pakar], ['class' => 'btn btn-primary']); ?>
                </p>
            </div>

    </div> 
</div>   
