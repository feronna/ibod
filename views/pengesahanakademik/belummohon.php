<?php
use yii\helpers\Html;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblrscoconfirmstatus;
error_reporting(0);
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [114, 116, 122], 'vars' => [
    ['label' => ''],
    ['label' => app\models\pengesahan\Pengesahan::totalPending(Yii::$app->user->getId())]
]]); ?>


<div class="row"> 
    <div class="x_panel">
       
        <div class="x_title">
            <h2><strong><i class="fa fa-book"></i> Senarai Kakitangan Tetap yang Cukup Tempoh (Pentadbiran)</strong></h2>
           <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
<!--                <li><a class="close-link"><i class="fa fa-close"></i></a>-->
                </li>
            </ul>
            
            <div class="clearfix"></div>
            
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil.</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Jawatan</th>
                    <th class="text-center">JAFPIB</th>
                    <th class="text-center">Taraf Jawatan</th>
                    <th class="text-center">Tarikh Lantikan Tetap</th>
                </tr>
                </thead>
                <?php
                $bil = '1';
           $biodata = Tblprcobiodata::find()->where(['statLantikan' => "1", 'Status' => "1"])->all();
                    foreach ($biodata as $biodatas){
  $icno=$biodatas->ICNO;
         $model = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt'); 
        $confirm = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno, 'ConfirmStatusStDt' => $model])->one()->ConfirmStatusCd;

        $m = Tblprcobiodata::find()->where(['ICNO' => $icno])->min('startDateSandangan');     
        $date1=date_create($m);
        $date2=date_create(date('Y-m-d'));
        $tempohlantikantetap = date_diff($date1, $date2)->format('%y Tahun %m Bulan %d Hari');
                       if($confirm=="2"&& $biodatas->jawatan->job_category=="2" && $tempohlantikantetap>="1"){

                    ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                            <td class="text-center"><?php echo $biodatas->CONm; ?></td>
                            <td class="text-center"><?php echo $biodatas->jawatan->nama; ?></td>
                            <td class="text-center"><?php echo $biodatas->department->shortname; ?></td>
                            <td class="text-center"><?php echo $biodatas->statusLantikan->ApmtStatusNm; ?></td>
                            <td class="text-center"><?php echo $biodatas->startDateLantik; ?></td>
                        </tr>
                     <?php 
                    }
                    }
                     ?>
            </table>
            </div>
        </div>
    </div>
</div>