
<?php
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\form\ActiveForm;
use dosamigos\tinymce\TinyMce;


?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
               <p align="right" >
                    <?php echo Html::a('Kembali', ['tambah-maklumbalas-urusetia', 'id' => $model->id_rekod], ['class' => 'btn btn-primary btn-sm']); ?>  
               
                </p>
                <h2><i class="fa fa-book"></i>&nbsp;<strong>Kemaskini Maklumbalas Memorandum Urusetia</strong></h2>
                <hr>
            <div class="x_content">


                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>


    
                
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Maklumbalas JAFPIB:<span class="required" style="color:red;">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
               <?= $form->field($model, 'maklumbalas')->widget(TinyMce::className(), [
                            'options' => ['rows' => 15],
                            'language' => 'en',
                            'clientOptions' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table contextmenu paste"
                                ],
                                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                            ]
                        ])->label(false); ?>
                </div>
            </div>
                
                
             <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Lampiran :<span class="required" style="color:red;">*</span></label>
           
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php
                            echo  Html::a(''  . $model->doc_name, Url::to('https://mediahost.ums.edu.my/api/v1/viewFile/' . $model->hashcode, $schema = true), ['target' => '_blank', 'style' =>  'text-decoration: underline; color:green' ]);
                     
                        echo $form->field($model, 'file', ['enableAjaxValidation' => false])->label(false)->widget(FileInput::class, [
                            'options' => [
                                'accept' => ['image/*', 'application/pdf'],
                            ],
                            'pluginOptions' => [
                                'showUpload' => false
                            ],

                        ]);
                        ?>
                    </div>
                    <?= Html::error($model, 'file3'); ?>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <p>Attachment *Only images (jpg, jpeg, png) or PDF is allowed (Max upload: 2MB)</p>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                    </div>
                </div>

          
                  <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::resetButton('<span class="fa fa-repeat"></span>&nbsp;Reset', ['class' => 'btn btn-danger', 'name' => 'reset-button']) ?>
                        <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp;Kemaskini', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>

