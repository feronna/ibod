<?php
use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;
use app\models\ptb\TblPbpu;
error_reporting(0);
$tmp = \app\models\harta\TblMesyuarat::find()->select(['tarikh_mesyuarat'])->orderBy(['id'=>SORT_DESC])->limit(1)->one();
?>
<?php
?>
<div class="col-md-12">
    <?php echo $this->render('/harta/_menu'); ?>
</div>

<div class="row">

            <div class="col-xs-12 col-md-12 col-lg-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-users"></i>PERAKUAN JFPIU</strong></h2>
                    
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form id="w0" class="form-horizontal form-label-left" action="" method="post">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Tarikh Perakuan
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="form-control" value="<?php  if ($model->tarikh_perakuan != null){
                   echo  $model->tarikhPerakuan;
                  }else{
                    echo 'Tiada Tindakan';
                 }
                ?>" disabled>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Nama Ketua JFPIU
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="form-control" value="<?= $model->ketua->CONm?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Perakuan<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <input class="form-control" value="<?= 
                $model->statusKj;
                ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ulasan Ketua JFPIU<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea class="form-control" rows="5" disabled><?= $model->ulasan_kj?></textarea>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                        </form>
                    </div>
                </div>
            </div>
      
</div>
<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-pencil"></i>Keputusan Mesyuarat</strong></h2>
                <div class="clearfix"></div>
          
                    </div>
                    <div class="x_content">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tarikh Mesyuarat
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                   <?= $form->field($model, 'tarikh_mesyuarat')->textInput(['maxlength' => true, 'rows' => 4, 'value' => date('d M Y', strtotime ($tmp['tarikh_mesyuarat'])), 'disabled' => 'disabled'])->label(false);
                        ?>
                    </div>         
                </div>
                        
               <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">No Rujukan Surat<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'ADEdrsdRefNo')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>
                
                
                 <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Status Pelulus <span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <?=
                        $form->field($model, 'status_pelulus')->label(false)->widget(Select2::classname(), [
                            'data' => [1 =>'PERMOHONAN DILULUSKAN', 0 => 'PERMOHONAN DITOLAK'],
                            'options' => ['placeholder' => 'Pilih Kelulusan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Catatan Pelulus<span class="required" style="color:red;">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($model, 'ulasan_pelulus')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    </div>
                </div>
             
            
                
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button class="btn btn-primary" type="reset">Reset</button>
                        <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
                <!--form-->
            </div>
        </div>
    </div>
</div>
