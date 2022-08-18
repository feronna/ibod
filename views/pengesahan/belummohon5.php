<?php
use yii\helpers\Html;
use app\models\hronline\Tblprcobiodata;
use app\models\hronline\Tblrscoconfirmstatus;
error_reporting(0);
?>

<!--<= $this->render('/pengesahan/_topmenu') ?>-->

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel"> 
        <div class="x_title">
            <h2><strong>Senarai Kakitangan Pentadbiran Tetap yang Telah Melebihi Tempoh Percubaan Maksimum <br> (Melebihi Percubaan 3 Tahun)</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['halaman-belum-mohon-pentadbiran'], ['class' => 'btn btn-primary']) ?></p>   
<!--            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>-->
            <div class="clearfix"></div>   
        </div>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped table-sm jambo_table table-bordered">
                <thead>
                <tr class="headings">
                    <th class="text-center">Bil.</th>
                    <th class="text-center">ICNO</th>
                    <th class="text-center">Nama</th>
                    <th class="text-center">Jawatan</th>
                    <th class="text-center">JAFPIB</th>
<!--                    <th class="text-center">Taraf Jawatan</th>-->
                    <th class="text-center">Status Pengesahan</th>
                    <th class="text-center">Tarikh Pengesahan</th>
                    <th class="text-center">Tempoh Pengesahan</th>
                    <th class="text-center">Tarikh Lantikan Tetap Di UMS</th>
                    <th class="text-center">Tempoh Lantikan Tetap Di UMS</th>
<!--                    <th class="text-center">Tarikh Lantikan Sandangan Semasa</th>
                    <th class="text-center">Tempoh Lantikan Sandangan Semasa</th>-->
                    <th class="text-center">Status PTM</th>
                    <th class="text-center">Tindakan</th>   
<!--                    <th class="text-center">Tarikh PTM</th>-->
                </tr>
                </thead>
        <?php
            $bil = '1';
            
            $biodata = Tblprcobiodata::find()->where(['statLantikan' => "1", 'Status' => "1"])->orderBy(['startDateLantik' => SORT_ASC])->all();
           
            foreach ($biodata as $biodatas){
            $icno=$biodatas->ICNO;
        
            $model = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt'); 
            $confirmstatuspengesahan = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno, 'ConfirmStatusStDt' => $model])->one()->ConfirmStatusCd; //ambil latest status pengesahan
        
            //$m = Tblprcobiodata::find()->where(['ICNO' => $icno])->min('startDateSandangan'); 
            $m = Tblrscoconfirmstatus::find()->where(['ICNO' => $icno])->max('ConfirmStatusStDt');  //ambil latest tarikh status pengesahan   
            $date1=date_create($m);
            $date2=date_create(date('Y-m-d'));
            $tempohstatuspengesahan = date_diff($date1, $date2)->format('%y');
            
            if(($biodatas->jawatan->job_category == "2" && $biodatas->servPeriodPermanent >= "3" && $confirmstatuspengesahan != "1" && $confirmstatuspengesahan != "8" && $confirmstatuspengesahan != "")){

            //if(($biodatas->jawatan->job_category == "2" && $tempohstatuspengesahan >= "3" && $confirmstatuspengesahan != "1" && $confirmstatuspengesahan != "8" && $confirmstatuspengesahan != "") || ($biodatas->jawatan->job_category == "2" && $tempohstatuspengesahan >= "1" && $confirmstatuspengesahan == "5") || ($biodatas->jawatan->job_category == "2" && $tempohstatuspengesahan >= "1" && $confirmstatuspengesahan == "6")){
            //if($biodatas->jawatan->job_category == "2" && $confirmstatuspengesahan != "1" && $confirmstatuspengesahan != ""){
        ?>
                        <tr>
                            <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                            <td class="text-center"><?php echo $biodatas->ICNO; ?></td>
                            <td class="text-center"><?php echo $biodatas->CONm; ?></td>
                            <td class="text-center"><?php echo $biodatas->jawatan->fname; ?></td>
                            <td class="text-center"><?php echo $biodatas->department->shortname; ?></td>
<!--                            <td class="text-center"><php echo $biodatas->statusLantikan->ApmtStatusNm; ?></td>-->
                            <td class="text-center"><?php echo $biodatas->confirmpengesahan->statusPengesahan->ConfirmStatusNm; ?></td>
                            <td class="text-center"><?php echo $biodatas->tarikhpengesahan; ?></td>
                            <td class="text-center"><?php echo $biodatas->tempohstatuspengesahan; ?></td>
                            <td class="text-center"><?php echo $biodatas->lantikanPerkhidmatan->tarikhmulalantikan; ?></td>
                            <td class="text-center"><?php echo $biodatas->servPeriodPermanent; ?></td>
<!--                            <td class="text-center"><php echo $biodatas->tarikhmulalantik; ?></td>
                            <td class="text-center"><php echo $biodatas->servPeriodCPosition; ?></td>-->
                            <td class="text-center"><?php echo $biodatas->ptm->status; ?></td>
<!--                            <td class="text-center"><php echo $biodatas->ptm->tarikhptm; ?></td>-->
                            <td class="text-center"><?php echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ["lihat-rekod", 'ICNO' => $biodatas->ICNO], ['target' => '_blank']) ?>    
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
</div>