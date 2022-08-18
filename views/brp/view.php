<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\web\View;
error_reporting(0);

/* @var $this yii\web\View */
/* @var $model app\models\hronline\Tblprcobiodata */

$this->title = 'Rekod BRP';


$statusLabel = [
        1 => '<span class="label label-warning">Selesai Disahkan</span>',
        0 => '<span class="label label-danger">Belum Disahkan</span>',
        null  => '<span class="label label-danger">Belum Disahkan</span>',
];
$statusLabel2 = [
        1 => '<span class="label label-info">Selesai Disemak</span>',
        0 => '<span class="label label-danger">Belum Disemak</span>',
        null  => '<span class="label label-danger">Belum Disemak</span>',
];


?>

 <div class="x_panel"> 
        <div class="x_title">
            <h2>Rekod BRP</h2> <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <div class="table-responsive">
                <table class="table table-sm table-bordered jambo_table table-striped"> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Nama Pegawai</th>
                        <td><?= $model->kakitangan->CONm?></td> 
                    </tr>
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">No. KP / Paspot</th>
                        <td><?php
                            if ($model->kakitangan->NatCd == "MYS") {
                                echo strtoupper($model->kakitangan->ICNO);
                            } else {
                                echo $model->kakitangan->latestPaspot;
                            }
                            ?></td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jawatan</th>
                        <td><?=strtoupper($model->kakitangan->jawatan->nama); ?> (<?= $model->kakitangan->jawatan->gred; ?>)</td> 
                    </tr> 
                    <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jabatan</th>
                        <td><?= strtoupper($model->kakitangan->department->fullname); ?></td> 
                    </tr> 
                     <tr>
                        <th class="col-md-3 col-sm-3 col-xs-12">Jenis Lantikan</th>
                        <td><?= strtoupper($model->kakitangan->statusLantikan->ApmtStatusNm)?></td> 
                    </tr> 
                    
                </table>
            </div> 

        </div>
    </div>




    <div class="x_panel">

        
        <div class="x_content">
         <?= Html::a('Carian Kakitangan', ['brp/index'], ['class' => 'btn btn-primary']) ?>
         <?= Html::a('Tambah Rekod BRP', ['brp/tambah-rekod', 'ICNO' => $model->ICNO], ['class' => 'btn btn-success']) ?>
         <?= Html::a('Tambah Rekod LPG', ['brp/view-rekod-lpg', 'COOldID' => implode(',',\yii\helpers\ArrayHelper::getColumn($model2, 'COOldID'))], ['class' => 'btn btn-success']) ?>
         <?= Html::a('Checklist BRP', ['brp/checklist-brp', 'ICNO' => $model->ICNO], ['class' => 'btn btn-success']) ?>   
         <?= Html::a('Lihat BRP', ['buku-rekod', 'ICNO' => $model->ICNO, 't_lpg_id' => $t_lpg_id], ['class' => 'btn btn-success']);?>   
         <?= Html::a('Cetak BRP', ['cetak-brp', 'ICNO' => $model->ICNO], ['class' => 'btn btn-success']);?>  
         <?= Html::a('Jenis BRP', ['jenis-brp'], ['class' => 'btn btn-success']);?> 

        </div>
    </div>





        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Rekod Belum Disahkan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered jambo_table"  style="font-size: 11px">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Pilih</th>
                                <th class="text-center">Bil</th>
                                <th class="text-center">No Siri</th>
                                <th class="text-center">Nama Jawatan</th>
                                <th class="text-center">Butir-butir perubahan atau lain-lain hal mengenai pegawai</th>
                                <th class="text-center">Tarikh Mulai Daripda/Kuatkuasa</th>
                                <th class="text-center">Tarikh Surat</th>
                                 <th class="text-center">Berpencen/Tidak Berpencen</th>
                                <th class="text-center">Gaji Sebulan</th>
                                <th class="text-center">Status Semakan</th>
                                <th class="text-center">Status Pengesahan</th>
                                <th class="text-center">Kemaskini</th>
                                <th class="text-center">Padam</th>
                                <th class="text-center">Tindakan Pengesahan</th>
                                
                            </tr>
                        </thead>
                        <?php if ($sah) { ?>
                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'login-form',
                                        'options' => ['class' => 'form-horizontal'],
                                    ])
                            ?>
                            <?php foreach ($sah as $senarai) { ?>
                                <tr>
                                    <td class="text-center"  style="text-align:center"><?= $form->field($senarai, 'brp_id[]')->checkbox(['value'=>$senarai->brp_id, 'label' => '', 'class' => 'checkId']); ?></td>
                                    <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                    <td><?= $senarai->brp_id ?></td>
                                    <td><?= $senarai->jawatan->nama; ?> (<?= $senarai->jawatan->gred; ?>)</td>
                                    <td style="width:500px; height:20px"><?= $senarai->remark ?></td>
                                    <td><?= $senarai->tarikhMulai?></td>
                                    <td><?= $senarai->tarikhSurat ?></td>
                                    <td><?php if($senarai->isPencen == 1){
                                         echo 'Berpencen';
                                            }else{
                                           echo 'Tidak Berpencen';
                                      } ?></td>
                                    <td><?= $senarai->gajiSebulan2 ?></td>
                                    <td><?= $statusLabel2[$senarai->status]?></td>
                                    <td><?= $statusLabel[$senarai->sah]?></td>
                                    <td align= 'center' ><?= Html::a('<i class="fa fa-pencil">', ["brp/kemaskini-pengesahan", 'brp_id' => $senarai->brp_id])?></td>  
                                    <td align= 'center' ><?= Html::a('<i class="fa fa-trash">', ["brp/padam-pengesahan", 'brp_id' => $senarai->brp_id] )?></td> 
                                    <td align= 'center' ><?=Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['brp/pengesahan', 'brp_id' => $senarai->brp_id]),'style'=>'background-color: transparent; 
                                 border: none;', 'class' => 'fa fa-edit mapBtn']) .' '?></td>
                                </tr>
                            <?php } ?>

                            <button type="button" class="checkall btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Tanda Semua</button>
                            <?= Html::submitButton('<i class="fa fa-paper-plane"></i>&nbsp;Rekod Disahkan', ['class' => 'btn btn-primary']) ?>
                            <?php ActiveForm::end() ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="9" class="align-center text-center"><i>Belum ada Rekod lagi</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>



    
 


<?php
$script = <<< JS
        
       $(document).ready(function () {
        
        var clicked = false;
        $(".checkall").on("click", function() {
          $(".checkId").prop("checked", !clicked);
          clicked = !clicked;
        });

    });

JS;
$this->registerJs($script, View::POS_END);
?>














