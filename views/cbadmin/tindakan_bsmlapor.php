<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
error_reporting(0);
?>
<?php

Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'data-pjax' => true ]]); ?>
<h5> <strong><center>KEPUTUSAN  UNIT PENGAJIAN LANJUTAN (UPL) - LAPOR DIRI</center></strong> </h5>
<div> 
    <div class="x_panel"> 
     
            
            <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_mesyuarat">Mesyuarat: <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        Mesyuarat Pengajian Lanjutan Bil. Ke
                        <?= $form->field($model, 'iklan_id')->widget(Select2::classname(), 
                        ['data' => ArrayHelper::map(\app\models\cbelajar\TblUrusMesyuarat::find()->orderBy(['id' => SORT_ASC,])->all(), 'id', 'nama_mesyuarat'),
                        'options' => [
                            'placeholder' => 'Pilih Mesyuarat'],
                    ])->label(false); ?>
                    </div>
                </div>  
 <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Permohonan:<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status_mesyuarat')->label(false)->widget(Select2::classname(), [
                        'data' => ['Diluluskan' => 'LAPORAN DITERIMA', 'Tidak Diluluskan' => 'TIDAK DITERIMA'],
                        'options' => ['placeholder' => 'Pilih Status Mesyuarat', 'class' => 'form-control col-md-7 col-xs-12',
                       
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        
                       
                    ]);
                    ?>
                </div>
        </div>

        <div class="form-group">
           
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Pengajian:<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($model, 'status_study')->label(false)->widget(Select2::classname(), [
                        'data' => ['Selesai' => 'TELAH SELESAI', 'Selesai GOT' => 'SELESAI GOT', 'BELUM SELESAI' => 'BELUM SELESAI & TELAH LAPOR DIRI'],
                        'options' => ['placeholder' => 'Pilih Status Kakitangan', 'class' => 'form-control col-md-7 col-xs-12',
                       
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                        
                       
                    ]);
                    ?>
                </div>
        </div>
        
         <div class="form-group">
                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan:<span class="required"></span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'catatan')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
         <!-- <div class="ln_solid"></div> -->
            <?php 
            if($model->status_bsm != "Diluluskan")
            {?>
                <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Simpan' ,['class' => 'btn btn-primary','name' => 'simpan']) ?>
                    <a style="color: green; font-weight: bold"><?php echo $message;?></a>
                    
                </div>
            </div>
        <?php }
        ?>
        </div>
    </div>

            <?php ActiveForm::end(); 
            Pjax::end();?>
