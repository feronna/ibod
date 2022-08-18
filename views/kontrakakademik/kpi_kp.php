<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\kontrak\TblKpi;

$bil=1;?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    var modal = "<?= $modal?>";
    $('#yes').click(function() {
        $('#'+modal).modal('hide');
        swal({
  title: "Success!",
  text: "KPI Approved!",
  icon: "success"
});
   }); 
//   $('#no').click(function() {
//        $('#mod').modal('hide');
//   }); 
    </script>
            

<script>
    $(document).ready(function(){
        $("#mod").on('hidden.bs.modal', function(){
        $('#content').empty();
  });
    });
</script>

<?php 
Pjax::begin(['enablePushState' => false, 'id' => 'newmodel'.uniqid(),'clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['id' => 'form', 'name' => 'isikpi','class' => 'form-horizontal form-label-left', 'data-pjax' => true]]); 
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
            }
            .table-responsive{
                margin-bottom: 0px;
                white-space:normal;
            }
.form-control{
    background-color: transparent;
    height: auto;
}
.table-responsive > .table > tbody > tr > td{
            white-space:normal;
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
    <div class="x_panel" style="border:none">
        <div class="x_title">
            <h2><strong> Penetapan Petunjuk Prestasi Utama Kontrak Akan Datang /<br>Key Performance Indicators For Next Contract</strong></h2>
            <a onclick="window.open('laporankpi?id=<?= $id?>');"><div style="float: right; font-size:18px;"><i class="text-success fa fa-file-pdf-o"></i></div></a>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="table-responsive">
                <table style="font-size:12px;" class="table table-striped table-sm jambo_table table-bordered">
                    <thead>
                        <tr class="headings">
                            <th style="width:4%" class="text-center" rowspan="2">Bil / <i>No.</i></th>
                            <th style="width:4%;" class="text-center" rowspan="2">Jenis KPI / <i>Type of KPI</i></th>
                            <th class="text-center" colspan="3">Di Fakulti / Pusat / Institut<br>
                                <i>At Faculty / Center / Institute</i></th>
                            <th style="width:18%" rowspan="2" class="text-center">Comment <?= $kontrak->firstapp?></th>
                        </tr>
                        <tr class="headings">
                            <th style="width:25%" class="text-center">Bilangan / <i>Number</i></th>
                            <th style="width:26%" class="text-center">Jumlah / <i>Amount</i> (RM)</th>
                            <th style="width:23%" class="text-center">Ketua / Ahli / <br><i>Leader / Member</i></th>
                            
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
                            <td rowspan="<?= $count?>" class="text-center"><?= $no; ?></td>
                            <td rowspan="<?= $count?>" style="position: relative;" class="text-center"><?= '<strong>'.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em></strong>' ?>
                                <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>


                            <?php $first=1; foreach($model as $m){
                                if($first === 1){?>
                                <td class="text-center" style="color:black"><?= $m->catatan?></td>
                                <td class="text-center" style="color:black"><?= number_format($m->catatan_2,2)?></td>
                                <td class="text-center" style="color:black"><?= $m->catatan_3?></td>
                                <td rowspan="<?= $count?>">
                                    <?php if($kontrak->status == '1'  && Yii::$app->user->getId() === $kontrak->ver_by){?>
                                    <textarea style="resize: none;" rows="4" name="catatan_4<?=$kpi->id?>"><?= TblKpi::comment_kp($kontrak->id, $kpi->id)?></textarea>
                                    <?php }else{
                                        echo TblKpi::comment_kp($kontrak->id, $kpi->id);
                                    }?>
                            </td>
                        </tr>
                    <?php }
                    else{
                                ?>
                            <tr class="text-center" style="color:black;">
                                <td><?= $m->catatan?></td>
                                <td><?= number_format($m->catatan_2,2)?></td>
                                <td><?= $m->catatan_3?></td>
                            </tr>
                                <?php } $first++; }}

                            elseif($kpi->id==4){?>
                            <tr>
                                <td rowspan="<?=$count +1?>" class="text-center"><?= $no; ?></td>
                            <td rowspan="<?=$count +1?>" style="position: relative;" class="text-center"><?= '<strong>'.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em></strong>' ?>
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
                            <td rowspan="<?=$count +1?>">
                                <?php if($kontrak->status == '1'  && Yii::$app->user->getId() === $kontrak->ver_by){?>
                            <textarea style="resize: none;" rows="4" name="catatan_4<?=$kpi->id?>"><?= TblKpi::comment_kp($kontrak->id, $kpi->id)?></textarea>
                                <?php }else{
                                    echo TblKpi::comment_kp($kontrak->id, $kpi->id);
                                }?>
                            </td>
                            </tr>
                            <?php foreach($model as $m){?>
                            <tr class="text-center" style="color:black">
                                <td><?= $m->catatan?></td>
                                <td><?= $m->catatan_2?></td>
                                <td><?= $m->catatan_3?></td>
                            </tr>
                            <?php } } 

                            elseif($kpi->id==5){?>
                            <tr>
                                <td rowspan="<?=$count +1?>" class="text-center"><?= $no; ?></td>
                            <td rowspan="<?=$count +1?>" style="position: relative;" class="text-center"><?= '<strong>'.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em></strong>' ?>
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
                            <td rowspan="<?=$count +1?>">
                            <?php if($kontrak->status == '1'  && Yii::$app->user->getId() === $kontrak->ver_by){?>
                            <textarea style="resize: none;" rows="4" name="catatan_4<?=$kpi->id?>"><?= TblKpi::comment_kp($kontrak->id, $kpi->id)?></textarea>
                                <?php }else{
                                    echo TblKpi::comment_kp($kontrak->id, $kpi->id);
                                }?>
                            </td>
                            </tr>
                            <?php foreach($model as $m){?>
                            <tr class="text-center" style="color:black">
                                <td><?= $m->catatan?></td>
                                <td><?= $m->catatan_2?></td>
                                <td><?= $m->catatan_3?></td>
                            </tr>
                            <?php } } 

                            elseif($kpi->id==6){?>
                            <tr>
                                <td rowspan="<?=$count +1?>" class="text-center"><?= $no; ?></td>
                            <td rowspan="<?=$count +1?>" style="position: relative;" class="text-center"><?= '<strong>'.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em></strong>' ?>
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
                            <td rowspan="<?=$count +1?>">
                            <?php if($kontrak->status == '1'  && Yii::$app->user->getId() === $kontrak->ver_by){?>
                            <textarea style="resize: none;" rows="4" name="catatan_4<?=$kpi->id?>"><?= TblKpi::comment_kp($kontrak->id, $kpi->id)?></textarea>
                                <?php }else{
                                    echo TblKpi::comment_kp($kontrak->id, $kpi->id);
                                }?>
                            </td>
                            </tr>
                            <?php foreach($model as $m){?>
                            <tr class="text-center" style="color:black">
                                <td><?= $m->catatan?></td>
                                <td><?= $m->catatan_2?></td>
                                <td><?= $m->catatan_3?></td>
                            </tr>
                            <?php } } 
                            elseif($kpi->id==7){?>
                            <tr>
                                <td rowspan="<?=$count +1?>" class="text-center"><?= $no; ?></td>
                            <td rowspan="<?=$count +1?>" style="position: relative;" class="text-center"><?= '<strong>'.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em></strong>' ?>
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
                            <td rowspan="<?=$count +1?>">
                            <?php if($kontrak->status == '1'  && Yii::$app->user->getId() === $kontrak->ver_by){?>
                            <textarea style="resize: none;" rows="4" name="catatan_4<?=$kpi->id?>"><?= TblKpi::comment_kp($kontrak->id, $kpi->id)?></textarea>
                                <?php }else{
                                    echo TblKpi::comment_kp($kontrak->id, $kpi->id);
                                }?>
                            </td>
                            </tr>
                            <?php foreach($model as $m){?>
                            <tr class="text-center" style="color:black">
                                <td><?= $m->catatan?></td>
                                <td><?= $m->catatan_2?></td>
                                <td><?= $m->catatan_3?></td>
                            </tr>
                            <?php }  } 
                            else{?>
                            <tr>
                                <td class="text-center"><?= $no; ?></td>
                            <td style="position: relative;" class="text-center"><?= '<strong>'.$kpi->kriteria_bm.' / <em>'.$kpi->kriteria_bi.'</em></strong>' ?>
                                <a style="color:red; position: absolute;bottom: 0;left: 0;" href="#" data-toggle="popover" data-content="<?=$kpi->info?>"><i class="fa fa-info-circle"></i></a></td>

                                <?php foreach($model as $m){?>
                                <td colspan="3" style="color: black;padding: 10px;white-space:pre-line;"><?= $m->catatan?></td>
                                <?php } ?>
                            <td>
                            <?php if($kontrak->status == '1'  && Yii::$app->user->getId() === $kontrak->ver_by){?>
                            <textarea style="resize: none;" rows="4" name="catatan_4<?=$kpi->id?>"><?= TblKpi::comment_kp($kontrak->id, $kpi->id)?></textarea>
                                <?php }else{
                                    echo TblKpi::comment_kp($kontrak->id, $kpi->id);
                                }?>
                            </td></tr>
                            <?php }  ?>
                            <?php   }?>

                        <?php 
                        } ?>
                </table>
            </div>
        </div>
         <?php if($kontrak->status == '1'  && Yii::$app->user->getId() === $kontrak->ver_by){?>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('<i class="fa fa-check"></i>&nbsp;Approve' ,['class' => 'btn btn-primary', 'id' => 'yes','name' => 'yes','value' => 'yes']) ?>
                <?= Html::submitButton('<i class="fa fa-close"></i>&nbsp;Not Approve' ,['class' => 'btn btn-danger','id'=> 'no', 'name' => 'no','value' => 'no', 'data'=>['confirm'=>'This application will be returned to the applicant. Proceed?']]) ?>
                <a style="color: green; font-weight: bold"><?php echo $message;?></a>
            </div>
        </div>
        <?php }?>
    </div>
</div>
<?php ActiveForm::end();Pjax::end();?>