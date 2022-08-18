<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use dosamigos\tinymce\TinyMce;  
?> 
<?php echo $this->render('menu'); ?> 
<div class="x_panel"> 
    <div class="x_title">
        <h2>APPLICATION INFORMATION</h2> 
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">   
         <?php if ($model->getGroupJawatan() == 1) { ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Why did you apply this position/ Why did you apply this position?: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">  
                    <?=
                    $form->field($model, 'why_applied')->widget(TinyMce::className(), [
                        'options' => ['rows' => 10],
                        'language' => 'en',
                        'clientOptions' => [
                            'plugins' => [],
                            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
                        ]
                    ])->label(false);
                    ?>
                </div>  
            </div>
        <?php } else { ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sila nyatakan faktor-faktor yang boleh melayakan anda menjawat jawatan ini/ Please state the factors that can qualify you for this position: <span class="required" style="color:red;">*</span>
                </label> <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">  
                    <?=
                    $form->field($model, 'qualification')->widget(TinyMce::className(), [
                        'options' => ['rows' => 10],
                        'language' => 'en',
                        'clientOptions' => [
                            'plugins' => [],
                            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
                        ]
                    ])->label(false);
                    ?>
                </div>  
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sila nyatakan pencapaian anda sepanjang tempoh berada dalam jawatan semasa/ Please state your achievements during your tenure in the current position: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">  
                    <?=
                    $form->field($model, 'accomplishment')->widget(TinyMce::className(), [
                        'options' => ['rows' => 10],
                        'language' => 'en',
                        'clientOptions' => [
                            'plugins' => [],
                            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
                        ]
                    ])->label(false);
                    ?>
                </div>  
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Jika anda menjawat jawatan ini, apakah yang akan anda sumbangkan untuk kepentingan universiti/ If you held this position, what would you contribute to the benefit of the university: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">  
                    <?=
                    $form->field($model, 'contribute')->widget(TinyMce::className(), [
                        'options' => ['rows' => 10],
                        'language' => 'en',
                        'clientOptions' => [
                            'plugins' => [],
                            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
                        ]
                    ])->label(false);
                    ?>
                </div>  
            </div>
<!--        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Behavioural Event Self-Assessment (BESA)?: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?php// $form->field($model, 'besa_status')->radioList(array(1 => 'Yes', 2 => 'No'))->label(false); ?>
            </div>
        </div>-->
        <?php } ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sudah istihar harta?/ Already declared a property?: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12"> 
                <?php
                if($model->sahHarta){
                    echo $model->sahHarta->ADDeclDt;
                }else{
                    echo '<span class="label label-danger">No information</span> Please declare your property before proceed to application. '.Html::a('Click Here', ['harta/permohonan'], ['class' => 'btn btn-link btn-md', 'target' => '_blank']);
                }
                
                //$form->field($model, 'harta_status')->radioList(array(1 => 'Taken', 2 => 'Not yet'))->label(false); 
                 
                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jika Sudah, bila?/ If Taken, when?:
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <?=
                DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'harta_date',
                    'template' => '{input}{addon}',
                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'placeholder' => 'Start Date'],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'readonly'=>true
                    ]
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Adakah anda pernah diambil tindakan tatatertib?/ Have you ever taken disciplinary action?: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?= $form->field($model, 'tatatertib_status')->radioList(array(1 => 'Never', 2 => 'Yes'))->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jika Ya, nyatakan jenis hukuman/ If Yes, state type of action:  
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?= $form->field($model, 'tatatertib_state')->textInput(['style'=>'width:500px','readonly'=>true])->label(false); ?> 
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sudahkah anda mengambil Kursus Induksi Umum dan Khusus?/ Did you take the General and Special Induction Course?: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?= $form->field($model, 'induksi_status')->radioList(array(1 => 'Taken', 2 => 'Not yet'))->label(false); ?>
            </div> 
            </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jika Sudah, bila?/ If Taken, when?:  
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?=
                DatePicker::widget([
                    'model' => $model,
                    'attribute' => 'induksi_date',
                    'template' => '{input}{addon}',
                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'placeholder' => 'Start Date'],
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd',
                        'readonly'=>true
                    ]
                ]);
                ?> 
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Keputusan/Result: 
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?= $form->field($model, 'induksi_result')->radioList(array(1 => 'Fail', 2 => 'Pass'))->label(false); ?>
            </div>
            </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jika diberi pengecualian, nyatakan sebab dan bukti pengecualian/If given the exemption, state the reasons and evidence exclusion:  
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?= $form->field($model, 'induksi_skip')->textInput(['style'=>'width:500px','readonly'=>true])->label(false); ?>
            </div> 
        </div>
<!--        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Have you taken the Assessment Examination (PTK)?: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?php// $form->field($model, 'ptk_status')->radioList(array(1 => 'Taken', 2 => 'Not yet'))->label(false); ?>
            </div> 
            </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">If Taken, when?:  
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?php
//                DatePicker::widget([
//                    'model' => $model,
//                    'attribute' => 'ptk_date',
//                    'template' => '{input}{addon}',
//                    'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12', 'placeholder' => 'Start Date'],
//                    'clientOptions' => [
//                        'autoclose' => true,
//                        'format' => 'yyyy-mm-dd',
//                        'readonly'=>true
//                    ]
//                ]);
                ?> 
            </div>
            </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Result:  
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?php
//                $form->field($model, 'ptk_result')->textInput(['style'=>'width:500px'])->label(false)->widget(Select2::classname(), [
//                    'data' => ArrayHelper::map(\app\models\cv\RefPtkOutput::find()->all(), 'id', 'aras'),
//                    'options' => ['placeholder' => 'SELECT', 'class' => 'form-control col-md-7 col-xs-12'],
//                    'pluginOptions' => [
//                        'allowClear' => FALSE,
//                        'readonly'=>true
//                    ],
//                ]);
                ?> 
            </div>  
            </div>-->
<!--        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">If given the exemption, state the reasons and evidence exclusion:  
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?php// $form->field($model, 'ptk_skip')->textInput(['style'=>'width:500px','readonly'=>true])->label(false); ?>
            </div>
        </div> -->
        <?php ActiveForm::end(); ?> 
    </div>
</div>   
