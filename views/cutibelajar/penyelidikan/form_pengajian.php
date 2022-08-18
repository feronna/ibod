<?php

use yii\helpers\Url;    
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use dosamigos\datepicker\DatePicker;
use app\models\hronline\Institut;
use app\models\cbelajar\PendidikanTertinggi;
use app\models\cbelajar\Modpengajian;
use app\models\hronline\Penaja;
use app\models\hronline\Negara;
use app\models\hronline\MajorMinor; 
use app\models\cbelajar\TblTajaan;
$title = $this->title = 'Maklumat Pengajian';
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>
<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN PENGAJIAN LANJUTAN PROGRAM SANGKUTAN PENTADBIRAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>
</div>
<?php echo $this->render('_menusm', ['title' => $title, 'id'=> $iklan->id]) ?>

<div class="col-md-12 col-sm-12 col-xs-12 "> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-graduation-cap"></i> Maklumat Pengajian Yang Dipohon</strong></h2>
            <p align="right">
              
            
                <?php
                if (!$eduhighest){
                
                //if ($model->status !=0 ) {
                echo Html::a('Tambah Pengajian', ['tambah-pengajian', 'id' => $iklan->id],
                ['class' => 'btn btn-success btn-sm']);?>
                
                </p>
            
       
                <?php }
 else {
    echo Html::a('Tambah Pengajian', ['tambah-pengajian', 'id' => $iklan->id],
                ['class' => 'btn btn-success btn-sm disabled']);
 }
?>
                <div class="clearfix"></div>
       </div>  
        <div class="x_content">
       
            <div class="table-responsive">
            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                <tr class="headings">
                    <th class="text-center">BIL</th>
                    <th class="text-center">NAMA UNIVERSITI</th>
                    <th class="text-center">NEGARA</th>
                    <th class="text-center">PERINGKAT PENGAJIAN</th>
                    <th class="text-center">BIDANG</th>
                    <th class="text-center">MOD PENGAJIAN</th>
                    <th class="text-center">TARIKH PENGAJIAN</th>
                    <th class="text-center">TINDAKAN</th>    
                </tr>
                </thead>
               <?php
                    if ($eduhighest) {
                        $counter = 0;
                        foreach ($eduhighest as $eduhighest) {
                            $counter = $counter + 1;
                            ?>

                            <tr>
                                <td class="text-center"><?= $counter; ?></td> 
                                <td class="text-center"><?= strtoupper($eduhighest->InstNm)?></td>
                                <td class="text-center"><?= strtoupper($eduhighest->negara->Country)?></td>
                                <td class="text-center"><?= strtoupper($eduhighest->tahapPendidikan)?></td>
                                <td class="text-center">
                                        <?php if($eduhighest->MajorCd == 9999 )
                                        {
                                                echo strtoupper($eduhighest->MajorMinor);
                                        }
                                        else
                                        {
                                             echo strtoupper($eduhighest->major->MajorMinor); 
                                        }?></td>
                                <td class="text-center"><?= strtoupper($eduhighest->mod->studyMode) ?></td>
                                <td class="text-center"><small>
                                             <?php if($eduhighest->tarikh_mula && $eduhighest->tarikh_tamat)
                                            {  ?><?= strtoupper($eduhighest->tarikhmula) ?> HINGGA 
                                            <?= strtoupper($eduhighest->tarikhtamat); ?>
                                            (<?= $eduhighest->tempohtajaan; ?>)<br><?php }
                                            else{
                                                echo '<p style="color:red">Tarikh Pengajian Tidak Diisi Lengkap'.
                                                    '</p>';
                                                     
                                            }
?> 
                                    </small></td>
                                <td class="text-center">
                                  <?= Html::a('<i class="fa fa-info-circle" aria-hidden="true"></i>', ['cbelajar/lihatpengajiansm', 'id' => $eduhighest->id], ['class' => 'btn btn-default']) ?> |

                                  <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', ['cbelajar/updatesm', 'id' => $eduhighest->id], ['class' => 'btn btn-default']) ?> |

                                  <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['cbelajar/deletesm?id='.$eduhighest->id.'&i='.$eduhighest->iklan_id], ['class' => 'btn btn-default',
                                        'data' => [
                                        'confirm' => 'Anda ingin membuang rekod ini?',
                                        'method' => 'post',
                                        ],
                                    ])
                                  ?>
                                    
                                  </td>  
                            </tr>
                            

                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="11" class="text-center">Tiada Rekod</td>                     
                        </tr>
<?php }
?>
                </table>
                <p align ="right">
                 <?= Html::a('Seterusnya', ['maklumat-biasiswa', 'id' => $iklan->id], ['class' => 'btn btn-info btn-sm']);?>
                 <?= Html::a('Kembali', ['cbelajar/maklumat-akademik', 'id'=>$iklan->id], ['class' => 'btn btn-primary btn-sm']) ?>
         </p> 

            </div>
         
             
   </div>
   </div>
    

    
    
</div>
</div>




