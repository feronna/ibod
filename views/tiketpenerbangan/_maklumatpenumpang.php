<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2; 
?> 

<div class="col-md-12 col-sm-12 col-xs-12">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
   

    <div class="x_panel"> 
        <div class="x_title">
            <h2>Butiran Penumpang</h2> 
            <div class="clearfix"></div>
        </div>
        
            <?php if($model->NatCd == "MYS"){ ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Penumpang:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($penumpang, 'jp_icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($queryKeluarga, 'FamilyId', 'FmyNm'),
                        'options' => ['placeholder' => 'Pilih Nama Pemohon'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?> 
                    <span class="required" style="color:red;">*</span> Sila langkau nama pemohon jika permohonan dibuat untuk diri sendiri.
                </div>
            </div>
            <?php } ?>
            <div class="form-group text-center">
                <?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-primary']) ?>
                <?= Html::submitButton('Tambah', ['class' => 'btn btn-primary']) ?>
            </div>

        </div>
    </div>   

    <?php ActiveForm::end(); ?> 

</div> 
</div>  

