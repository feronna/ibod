<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\elnpt\penerbitan\TblLnptPublicationV2;
use app\models\smp_ppi\LNPTConference;
use app\models\smp\Penyeliaan;

?>
<script>
    $('#submit').click(function() {
        if(document.getElementById("tblkpi-catatan").value!==''){
        $('#mod').modal('hide');}else{
        document.getElementById("tblkpi-catatan").style.borderColor = "#a94442";
        return false;
        }
   }); 
   $('#delete').click(function() {
        $('#mod').modal('hide');
   }); 
    </script>

<?php 
Pjax::begin(['enablePushState' => false, 'id' => 'newmodel'.uniqid(),'clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['id' => 'form','class' => 'hantar form-horizontal form-label-left','data-pjax' => true]]); ?>
<div class="row"> 
    <div class="x_panel">
        <div class="x_title" style="font-size:14px;"><strong>
                        <?= $refkpi->kriteria_bm.' / <em>'.$refkpi->kriteria_bi.'</em> ' ?>
                                </strong><div class="clearfix"></div>
                </div>        
<?php if($refkpi->id <='3'){
?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Bilangan / <i>Number</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?= $form->field($model, 'catatan')->textInput(['type' => 'number', 'autocomplete' => 'off'])->label(false); ?>
                
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah / <i>Amount</i> (RM)
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?= $form->field($model, 'catatan_2')->textInput(['type' => 'number', 'step'=>'.01', 'autocomplete' => 'off'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Ketua/Member / <i>Leader/Member</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <?=
                    $form->field($model, 'catatan_3')->label(false)->widget(Select2::classname(), [
                        'data' => ['Leader' => 'Leader', 'Member' => 'Member'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
            </div>
        </div>
        <?php }
        elseif($refkpi->id == '4'){?>
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Bilangan / <i>Amount</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?= $form->field($model, 'catatan')->textInput(['type' => 'number', 'autocomplete' => 'off'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis / <i>Type</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
               <?=
                    $form->field($model, 'catatan_2')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TblLnptPublicationV2::find()->select(['Keterangan_PublicationTypeID'])->where(['!=','Keterangan_PublicationTypeID', 'Tiada Data'])->distinct()->all(), 'Keterangan_PublicationTypeID', 'Keterangan_PublicationTypeID'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'tags' => true,
                        ],
                    ]);?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Peranan / <i>Role</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
               <?=
                    $form->field($model, 'catatan_3')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(TblLnptPublicationV2::find()->select(['KeteranganBI_WriterStatus'])->where(['!=','KeteranganBI_WriterStatus', 'No Data'])->distinct()->all(), 'KeteranganBI_WriterStatus', 'KeteranganBI_WriterStatus'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
            </div>
        </div>
        <?php }
        
        elseif($refkpi->id == '5'){?>
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Bilangan / <i>Amount</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?= $form->field($model, 'catatan')->textInput(['type' => 'number', 'autocomplete' => 'off'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Peranan / <i>Role</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
               <?=
                    $form->field($model, 'catatan_2')->label(false)->widget(Select2::classname(), [
                        'data' => ['Presenter' => 'Presenter' , 'Chairman' => 'Chairman', 'Member of Panel' => 'Member of Panel', 'Poster Presenter' => 'Poster Presenter', 'Invitation Presenter' => 'Invited Speaker', 'Plenary' => 'Plenary', 'Keynote Speaker' => 'Keynote Speaker'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahap / <i>Level</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
               <?=
                    $form->field($model, 'catatan_3')->label(false)->widget(Select2::classname(), [
                        'data' => ['National' => 'National', 'International' => 'International','State' => 'State','University' => 'University'],
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
            </div>
        </div>
        <?php }
        elseif($refkpi->id <='6'){
?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Bilangan Kursus / <i>Number of Courses</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?= $form->field($model, 'catatan')->textInput(['type' => 'number', 'autocomplete' => 'off'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Bilangan Jam Per Sem / <i>Number of Hours Per Sem</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?= $form->field($model, 'catatan_2')->textInput(['type' => 'number', 'autocomplete' => 'off'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Bilangan Pelajar / <i>Number of Students</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <?= $form->field($model, 'catatan_3')->textInput(['type' => 'number', 'autocomplete' => 'off'])->label(false); ?>
            </div>
        </div>
        <?php }
        
        elseif($refkpi->id <='7'){
?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Bilangan Pelajar / <i>Number of Students</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?= $form->field($model, 'catatan')->textInput(['type' => 'number', 'autocomplete' => 'off'])->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahap / <i>Level</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                 <?=
                    $form->field($model, 'catatan_2')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Penyeliaan::find()->select(['LevelPengajian'])->distinct()->all(), 'LevelPengajian', 'LevelPengajian'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Peranan / <i>Role</i>
            </label>
            <div class="col-md-3 col-sm-6 col-xs-6">
                <?=
                    $form->field($model, 'catatan_3')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Penyeliaan::find()->select(['TahapPenyeliaanBI'])->distinct()->all(), 'TahapPenyeliaanBI', 'TahapPenyeliaanBI'),
                        'options' => ['placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
            </div>
        </div>
        <?php }
        
        else{?>
           <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"></i>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-6">
                 <?= $form->field($model, 'catatan')->textarea(['rows' => '4','autocomplete' => 'off'])->label(false); ?>
            </div>
        </div>
            <?php }?>
        
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <?= Html::submitButton('Save', ['id' => 'submit','class' => 'btn btn-primary']) ?>
            <?php
            if(\app\models\kontrak\TblKpi::find()->where(['kontrak_id' => $model->kontrak_id, 'kriteriakpi_id' => $model->kriteriakpi_id])->andWhere(['!=','perkara','comment'])->count() > 1){
            
            echo Html::a('Delete', ['deletekpi', 'id' => $model->id, 'kontrak' => $kontrak->id], [
                                            'class' => 'btn btn-danger','id' => 'delete',
            ]);  }?>
            </div>
        </div>
</div>
</div>
<?php ActiveForm::end();
Pjax::end();?>
    