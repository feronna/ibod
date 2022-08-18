<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use dosamigos\datepicker\DatePicker;
use dosamigos\tinymce\TinyMce;
?> 
<?php echo $this->render('menu'); ?> 

<div class="x_panel">  
    <div class="product_price"> 
        <p style="font-size:12px;font-weight: bold;"> <i class="fa fa-info-circle btn btn-default btn-sm" aria-hidden="true"></i> Maklumat permohonan tidak dapat dikemaskini sekiranya telah membuat permohonan baru. Sila pastikan maklumat permohonan adalah tepat sebelum membuat permohonan / Application information cannot be updated if a new application has been made. Please ensure that the application information is accurate before applying.</p> 
        <div class="clearfix"></div> 
    </div> 
</div>
<div class="x_panel"> 
    <div class="x_title">
        <p style="font-size:18px;font-weight: bold;">APPLICATION INFORMATION</p> 
        <div class="clearfix"></div>
    </div>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?> 
    <div class="x_content">   
        <?php if ($model->getGroupJawatan() == 1) { ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kenapa anda memohon jawatan ini/ Why did you apply this position?: <span class="required" style="color:red;">*</span>
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
                    ])->textInput(['maxlength' => true])->label(false);
                    ?>
                </div>  
            </div>
        <?php } else { ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sila nyatakan faktor-faktor yang boleh melayakan anda menjawat jawatan ini/ Please state the factors that can qualify you for this position: <span class="required" style="color:red;">*</span>
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
                    ])->textInput(['maxlength' => true])->label(false);
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
                    ])->textInput(['maxlength' => true])->label(false);
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
                    ])->textInput(['maxlength' => true])->label(false);
                    ?>
                </div>  
            </div> 

        <?php } ?>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sudah istihar harta?/ Already declared a property?: <span class="required" style="color:red;">*</span>
            </label>
            <div class="col-md-8 col-sm-8 col-xs-12"> 
                <?php
                if ($pengguna->sahHarta) {
                    echo $pengguna->sahHarta->ADDeclDt;
                } else {
                    echo '<span class="label label-danger">No information</span> Please declare your property before proceed to application. ' . Html::a('Click Here', ['harta/permohonan'], ['class' => 'btn btn-link btn-md', 'target' => '_blank']);
                }
                ?>
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
                        'readonly' => true
                    ]
                ]);
                ?> 
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Keputusan/ Result: 
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?= $form->field($model, 'induksi_result')->radioList(array(1 => 'Fail', 2 => 'Pass'))->label(false); ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jika diberi pengecualian, nyatakan sebab dan bukti pengecualian/ If given the exemption, state the reasons and evidence exclusion:  
            </label>
            <div class="col-md-3 col-sm-3 col-xs-12"> 
                <?= $form->field($model, 'induksi_skip')->textInput()->label(false); ?>
            </div> 
        </div> 
        <div class="hide">  
            <?php if (empty($model->added)) { ?>
                <?= $form->field($model, 'added')->hiddenInput(['value' => strtotime(date('Y-m-d H:i:s'))])->label(false); ?> 
            <?php } ?>
            <?= $form->field($model, 'lastupdate')->hiddenInput(['value' => strtotime(date('Y-m-d H:i:s'))])->label(false); ?>   
        </div>

        <div class="form-group text-center">
            <?= Html::submitButton('SAVE', ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?> 
    </div>
</div>   
