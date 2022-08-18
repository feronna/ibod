<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\kontrak\TblKpi;
use app\models\kontrak\Kontrak;
use kartik\popover\PopoverX;
use kartik\select2\Select2;


$bil=1;?>
<script>$(function(){
    
    $('.mapB').click(function (){
       $('#mod').modal('show')
               .find('#content')
               .load($(this).attr('value'));
    });
    
    
    
});</script>


<script>
    $(document).ready(function(){
        $("#mod").on('hidden.bs.modal', function(){
        $('#content').empty();
  });
    });
</script>

<?php $form = ActiveForm::begin(['options' => ['id' => 'form', 'name' => 'isikpi','class' => 'form-horizontal form-label-left']]); 
if($kontrak->status == '2' && Yii::$app->user->getId() === $kontrak->app_by){
    
}

error_reporting(0);
?>
<style>
    .popover-content {
    color: red;
    white-space:pre-line;
}
.table{
                margin-bottom: 0px;
                empty-cells: hide;
            }
            .table-responsive > .table > tbody > tr > td{
            white-space:normal;
            }
            .table-responsive{
                margin-bottom: 0px;
                white-space:normal;
            }
.form-control{
    background-color: transparent;
    height: auto;
}
.table > tbody > tr > td{
vertical-align:middle;
}
</style>

<script>
                                    $(document).ready(function(){
                                      $('[data-toggle="popover"]').popover();   
                                    });
                                    
                                    $('body').on('click', function (e) {
                                        $('[data-toggle="popover"]').each(function () {
                                            //the 'is' for buttons that trigger popups
                                            //the 'has' for icons within a button that triggers a popup
                                            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                                                $(this).popover('hide');
                                            }
                                        });
                                    });
                                    </script>
<div class="row" id="myModal"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><strong> Penetapan Petunjuk Prestasi Utama Kontrak Akan Datang /<br> Key Performance Indicators For Next Contract</strong></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table style="font-size:12px;" class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th style="width:4%" class="text-center" rowspan="2">Bil / <i>No.</i></th>
                                    <th style="width:4%;" class="text-center" rowspan="2">Jenis KPI / <i>Type of KPI</i></th>
                                    <th class="text-center" colspan="4">Di Fakulti / Pusat / Institut<br>
                                        <i>At Faculty / Center / Institute</i></th>
                                    <?php if($kontrak->tarikh_m != NULL){?>
                                    <th style="width:18%" rowspan="2" class="text-center">Comment (Head of Program)</th>
                                    <th style="width:18%" rowspan="2" class="text-center">Comment (Head of Department)</th>
                                    <?php }?>
                                </tr>
                                <tr class="headings">
                                    <th style="width:25%" class="text-center">Bilangan / <i>Number</i></th>
                                    <th style="width:26%" class="text-center">Jumlah / <i>Amount</i> (RM)</th>
                                    <th style="width:23%" class="text-center">Ketua / Ahli / <br><i>Leader / Member</i></th>
                                    <th style="width:6%" class="text-center"></i></th>
                                    <?php 
                                    
                                    $mod = TblKpi::find()->where(['kontrak_id' => $kontrak->id])->one();?>
                                </tr>
                            </thead>
                            <?php
                            if ($kriteriakpi) { $no=0;?>
                                <?php foreach ($kriteriakpi as $kpi) { $no++; 
                                $model = TblKpi::kpi_user($kontrak->id, $kpi->id);
                                $count = count($model);
                                ?>
                            <?php if($kpi->id<=3){?>
                                <tr>
                                    <td rowspan="<?= $count + 1?>" class="text-center"><?= $no; ?></td>
                                    <td rowspan="<?= $count + 1?>" style="position: relative;" class="text-center"><?= '<strong>'.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em></strong>' ?>
                                        <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>
                                    
                                
                                    <?php 
                                    if($count == 0){?>
                                        <td colspan="4" class="text-right"><button style="color:red;background-color:transparent; border: none " value = "/staff/web/kontrakakademik/tambahkpi?id=<?= $kontrak->id?>&kpi=<?= $kpi->id?>" id="op" type="button" class="glyphicon glyphicon-plus mapB"></button></td>
                                    <?php }
                                    $first=1; foreach($model as $m){
                                        if($first === 1){?>
                                        <td class="text-center" style="color:black"><?= $m->catatan?></td>
                                        <td class="text-center" style="color:black"><?= number_format($m->catatan_2,2)?></td>
                                        <td class="text-center" style="color:black"><?= $m->catatan_3?></td>
                                        <td class="text-center" style="color:black"><button style="background-color:transparent;border: none;" value = "updatekpi?id=<?= $m->id?>&&kontrak=<?= $kontrak->id?>" type="button" class="fa fa-edit mapB"></button></td>
                                        <?php if($kontrak->tarikh_m != NULL){?>
                                        <td rowspan="<?= $count + 1?>">
                                        <?= TblKpi::find()->where(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id'=>$kpi->id, 'perkara' => 'comment_kp'])->one()->catatan?>
                                        </td>
                                        <td rowspan="<?= $count + 1?>">
                                        <?= TblKpi::find()->where(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id'=>$kpi->id, 'perkara' => 'comment'])->one()->catatan?>
                                        </td>
                                </tr><?php }
                                        }else{
                                        ?>
                                    <tr class="text-center" style="color:black;">
                                        <td><?= $m->catatan?></td>
                                        <td><?= number_format($m->catatan_2,2)?></td>
                                        <td><?= $m->catatan_3?></td>
                                        <td><button style="background-color:transparent;border: none;" value = "updatekpi?id=<?= $m->id?>&&kontrak=<?= $kontrak->id?>" type="button" class="fa fa-edit mapB"></button></td>
                                    </tr>
                                        <?php } $first++; }
                                        if($count != 0){?>
                                    <tr class="text-right">
                                        <td colspan="4" class=""><button style="background-color:transparent; border: none " value = "/staff/web/kontrakakademik/tambahkpi?id=<?= $kontrak->id?>&kpi=<?= $kpi->id?>" id="op" type="button" class="glyphicon glyphicon-plus mapB"></button></td>
                                    </tr>
                                        <?php } } 
                                    
                                    elseif($kpi->id==4){?>
                                    <tr>
                                        <td rowspan="<?= $count + 2?>" class="text-center"><?= $no; ?></td>
                                    <td rowspan="<?= $count + 2?>" style="position: relative;" class="text-center"><?= '<strong>'.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em></strong>' ?>
                                        <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>
                                    <td style="padding:0px; background-color: rgba(52, 73, 94, 0.94);" class="text-center">
                                        <div style="font-weight: bold;color:#ECF0F1; padding: 8px;">Bilangan / <i>Number</i></div>
                                        
                                    </td>
                                    <td style="padding:0px; background-color: rgba(52, 73, 94, 0.94);" class="text-center">
                                        <div style="font-weight: bold;color:#ECF0F1; padding: 8px;">Jenis / <i>Type</i></div>
                                        
                                    </td>
                                    <td style="padding:0px; background-color: rgba(52, 73, 94, 0.94);" class="text-center">
                                        <div style="font-weight: bold;color:#ECF0F1; padding: 8px;">Peranan / <i>Role</i></div>
                                        
                                    </td>
                                    <td></td>
                                    
                                    <?php if($kontrak->tarikh_m != NULL){?>
                                    <td rowspan="<?= $count + 2?>">
                                    <?= TblKpi::find()->where(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id'=>$kpi->id, 'perkara' => 'comment_kp'])->one()->catatan?>
                                    </td>
                                        <td rowspan="<?= $count + 2?>">
                                    <?= TblKpi::find()->where(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id'=>$kpi->id, 'perkara' => 'comment'])->one()->catatan?>
                                    </td><?php }?>
                                    </tr>
                                    <?php foreach($model as $m){?>
                                    <tr class="text-center" style="color:black">
                                        <td><?= $m->catatan?></td>
                                        <td><?= $m->catatan_2?></td>
                                        <td><?= $m->catatan_3?></td>
                                        <td><button style="background-color:transparent;border: none;" value = "updatekpi?id=<?= $m->id?>&&kontrak=<?= $kontrak->id?>" type="button" class="fa fa-edit mapB"></button></td>
                                    </tr>
                                    <?php } ?>
                                    <tr class="text-right">
                                        <?php if($count < 1){?>
                                        <td colspan="4" class=""><button style="color:red;background-color:transparent; border: none " value = "/staff/web/kontrakakademik/tambahkpi?id=<?= $kontrak->id?>&kpi=<?= $kpi->id?>" id="op" type="button" class="glyphicon glyphicon-plus mapB"></button></td>
                                        <?php }else{?>
                                          <td colspan="4" class=""><button style="background-color:transparent; border: none " value = "/staff/web/kontrakakademik/tambahkpi?id=<?= $kontrak->id?>&kpi=<?= $kpi->id?>" id="op" type="button" class="glyphicon glyphicon-plus mapB"></button></td>  
                                        <?php }
?>
                                    </tr>
                                    <?php } 
                                    
                                    elseif($kpi->id==5){?>
                                    <tr>
                                        <td rowspan="<?= $count+2?>" class="text-center"><?= $no; ?></td>
                                    <td rowspan="<?= $count+2?>" style="position: relative;" class="text-center"><?= '<strong>'.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em></strong>' ?>
                                        <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>
                                    <td style="padding:0px; background-color: rgba(52, 73, 94, 0.94);" class="text-center">
                                        <div style="font-weight: bold;color:#ECF0F1; padding: 8px;">Bilangan / <i>Number</i></div>
                                        
                                    </td>
                                    <td style="padding:0px; background-color: rgba(52, 73, 94, 0.94);" class="text-center">
                                        <div style="font-weight: bold;color:#ECF0F1; padding: 8px;">Peranan / <i>Role</i></div>
                                        
                                    </td>
                                    <td style="padding:0px; background-color: rgba(52, 73, 94, 0.94);" class="text-center">
                                        <div style="font-weight: bold;color:#ECF0F1; padding: 8px;">Tahap / <i>Level</i></div>
                                    </td>
                                    <td></td>
                                    <?php if($kontrak->tarikh_m != NULL){?>
                                    <td rowspan="<?= $count + 2?>">
                                    <?= TblKpi::find()->where(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id'=>$kpi->id, 'perkara' => 'comment_kp'])->one()->catatan?>
                                    </td>
                                        <td rowspan="<?= $count + 2?>">
                                    <?= TblKpi::find()->where(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id'=>$kpi->id, 'perkara' => 'comment'])->one()->catatan?>
                                    </td><?php }?>
                                    </tr>
                                    <?php foreach($model as $m){?>
                                    <tr class="text-center" style="color:black">
                                        <td><?= $m->catatan?></td>
                                        <td><?= $m->catatan_2?></td>
                                        <td><?= $m->catatan_3?></td>
                                        <td><button style="background-color:transparent;border: none;" value = "updatekpi?id=<?= $m->id?>&&kontrak=<?= $kontrak->id?>" type="button" class="fa fa-edit mapB"></button></td>
                                    </tr>
                                    <?php } ?>
                                    <tr class="text-right">
                                        <?php if($count < 1){?>
                                        <td colspan="4" class=""><button style="color:red;background-color:transparent; border: none " value = "/staff/web/kontrakakademik/tambahkpi?id=<?= $kontrak->id?>&kpi=<?= $kpi->id?>" id="op" type="button" class="glyphicon glyphicon-plus mapB"></button></td>
                                        <?php }else{?>
                                          <td colspan="4" class=""><button style="background-color:transparent; border: none " value = "/staff/web/kontrakakademik/tambahkpi?id=<?= $kontrak->id?>&kpi=<?= $kpi->id?>" id="op" type="button" class="glyphicon glyphicon-plus mapB"></button></td>  
                                        <?php }
?>
                                    </tr>
                                    <?php } 
                                    
                                    elseif($kpi->id==6){?>
                                    <tr>
                                        <td rowspan="<?= $count+2?>" class="text-center"><?= $no; ?></td>
                                    <td rowspan="<?= $count+2?>" style="position: relative;" class="text-center"><?= '<strong>'.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em></strong>' ?>
                                        <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>
                                    <td style="padding:0px; background-color: rgba(52, 73, 94, 0.94);" class="text-center">
                                        <div style="font-weight: bold;color:#ECF0F1; padding: 8px;">Bilangan Kursus / <i>Number of Courses</i></div>
                                        
                                    </td>
                                    <td style="padding:0px; background-color: rgba(52, 73, 94, 0.94);" class="text-center">
                                        <div style="font-weight: bold;color:#ECF0F1; padding: 8px;">Bilangan Jam Per Sem / <i>Number of Hours Per Sem</i></div>
                                        
                                    </td>
                                    <td style="padding:0px; background-color: rgba(52, 73, 94, 0.94);" class="text-center">
                                        <div style="font-weight: bold;color:#ECF0F1; padding: 8px;">Bilangan Pelajar / <i>Number of Students</i></div>
                                        
                                    </td>
                                    <td></td>
                                    <?php if($kontrak->tarikh_m != NULL){?>
                                    <td rowspan="<?= $count + 2?>">
                                    <?= TblKpi::find()->where(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id'=>$kpi->id, 'perkara' => 'comment_kp'])->one()->catatan?>
                                    </td>
                                        <td rowspan="<?= $count + 2?>">
                                    <?= TblKpi::find()->where(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id'=>$kpi->id, 'perkara' => 'comment'])->one()->catatan?>
                                    </td><?php }?>
                                    </tr>
                                    <?php foreach($model as $m){?>
                                    <tr class="text-center" style="color:black">
                                        <td><?= $m->catatan?></td>
                                        <td><?= $m->catatan_2?></td>
                                        <td><?= $m->catatan_3?></td>
                                        <td><button style="background-color:transparent;border: none;" value = "updatekpi?id=<?= $m->id?>&&kontrak=<?= $kontrak->id?>" type="button" class="fa fa-edit mapB"></button></td>
                                    </tr>
                                    <?php } ?>
                                    <tr class="text-right">
                                        <?php if($count < 1){?>
                                        <td colspan="4" class=""><button style="color:red;background-color:transparent; border: none " value = "/staff/web/kontrakakademik/tambahkpi?id=<?= $kontrak->id?>&kpi=<?= $kpi->id?>" id="op" type="button" class="glyphicon glyphicon-plus mapB"></button></td>
                                        <?php }else{?>
                                          <td colspan="4" class=""><button style="background-color:transparent; border: none " value = "/staff/web/kontrakakademik/tambahkpi?id=<?= $kontrak->id?>&kpi=<?= $kpi->id?>" id="op" type="button" class="glyphicon glyphicon-plus mapB"></button></td>  
                                        <?php }
?>
                                    </tr>
                                    <?php } 
                                    elseif($kpi->id==7){?>
                                    <tr>
                                        <td rowspan="<?= $count+2?>" class="text-center"><?= $no; ?></td>
                                    <td rowspan="<?= $count+2?>" style="position: relative;" class="text-center"><?= '<strong>'.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em></strong>' ?>
                                        <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>
                                    <td style="padding:0px; background-color: rgba(52, 73, 94, 0.94);" class="text-center">
                                        <div style="font-weight: bold;color:#ECF0F1; padding: 8px;">Bilangan Pelajar / <i>Number of Students</i></div>
                                        
                                    </td>
                                    <td style="padding:0px; background-color: rgba(52, 73, 94, 0.94);" class="text-center">
                                        <div style="font-weight: bold;color:#ECF0F1; padding: 8px;">Tahap / <i>Level</i></div>
                                        
                                    </td>
                                    <td style="padding:0px; background-color: rgba(52, 73, 94, 0.94);" class="text-center">
                                        <div style="font-weight: bold;color:#ECF0F1; padding: 8px;">Peranan / <i>Role</i></div>
                                        
                                    </td>
                                    <td></td>
                                    <?php if($kontrak->tarikh_m != NULL){?>
                                    <td rowspan="<?= $count + 2?>">
                                    <?= TblKpi::find()->where(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id'=>$kpi->id, 'perkara' => 'comment_kp'])->one()->catatan?>
                                    </td>
                                        <td rowspan="<?= $count + 2?>">
                                    <?= TblKpi::find()->where(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id'=>$kpi->id, 'perkara' => 'comment'])->one()->catatan?>
                                    </td><?php }?>
                                    </tr>
                                    <?php foreach($model as $m){?>
                                    <tr class="text-center" style="color:black">
                                        <td><?= $m->catatan?></td>
                                        <td><?= $m->catatan_2?></td>
                                        <td><?= $m->catatan_3?></td>
                                        <td><button style="background-color:transparent;border: none;" value = "updatekpi?id=<?= $m->id?>&&kontrak=<?= $kontrak->id?>" type="button" class="fa fa-edit mapB"></button></td>
                                    </tr>
                                    <?php } ?>
                                    <tr class="text-right">
                                        <?php if($count < 1){?>
                                        <td colspan="4" class=""><button style="color:red;background-color:transparent; border: none " value = "/staff/web/kontrakakademik/tambahkpi?id=<?= $kontrak->id?>&kpi=<?= $kpi->id?>" id="op" type="button" class="glyphicon glyphicon-plus mapB"></button></td>
                                        <?php }else{?>
                                          <td colspan="4" class=""><button style="background-color:transparent; border: none " value = "/staff/web/kontrakakademik/tambahkpi?id=<?= $kontrak->id?>&kpi=<?= $kpi->id?>" id="op" type="button" class="glyphicon glyphicon-plus mapB"></button></td>  
                                        <?php }
?>
                                    </tr>
                                    <?php } 
                                    else{?>
                                    <tr>
                                    <td class="text-center"><?= $no; ?></td>
                                    <td style="position: relative;" class="text-center"><?= '<strong>'.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em></strong>' ?>
                                        <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>
                                    <?php 
                                        if($count < 1){?>
                                    <td colspan="4" class="text-right">
                                        <button style="color:red;background-color:transparent; border: none " value = "/staff/web/kontrakakademik/tambahkpi?id=<?= $kontrak->id?>&kpi=<?= $kpi->id?>" id="op" type="button" class="glyphicon glyphicon-plus mapB"></button></td>
                                        <?php }?>
                                        <?php foreach($model as $m){?>
                                        <td colspan="3" style="color: black;padding: 10px;white-space:pre-line;"><?= $m->catatan?></td>
                                        <td><button style="color: black; background-color:transparent;border: none;" value = "updatekpi?id=<?= $m->id?>&&kontrak=<?= $kontrak->id?>" type="button" class="fa fa-edit mapB"></button>
                                        </td>
                                        <?php } ?>
                                    <?php if($kontrak->tarikh_m != NULL){?>
                                    <td>
                                    <?= TblKpi::find()->where(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id'=>$kpi->id, 'perkara' => 'comment_kp'])->one()->catatan?>
                                    </td>
                                    <td>
                                    <?= TblKpi::find()->where(['kontrak_id'=> $kontrak->id, 'kriteriakpi_id'=>$kpi->id, 'perkara' => 'comment'])->one()->catatan?>
                                    </td>    
                                    <?php }?>
                                    </tr>
                                    <?php }  ?>
                                    <?php   }?>

                                <?php 
                                } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<div class="col-md-12 col-sm-12 col-xs-12" align="center"> 
<?= Html::a('CLOSE', ['mohonlanjut'], ['class'=>'btn btn-primary']) ?>
</div>
<?php ActiveForm::end();?>
