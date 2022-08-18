<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;

$name = $this->title = 'Gambar';
?>
<div class="row">


<div class="col-md-12 col-sm-12 col-xs-12"> 

    <div class="x_panel">
        <div class="x_title">
            <h2><?= Html::encode($this->title) ?></h2>

            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <span class="required" style="color:red;">*</span><span style="color:blue;"> Saiz gambar mengikut ukuran gambar paspot dalam format JPG.</span> <br/>
            <span class="required" style="color:red;">*</span><span style="color:blue;"> Sila pastikan gambar paspott 4R yang dimuat naik adalah yang terkini.</span> 
            <br/><br/> 
                 <?php
            $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data']
            ]);

            $title = isset($model->filename) && !empty($model->filename) ? $model->filename : 'Avatar';
            ?>


<!--            <div class="col-md-6 col-sm-6 col-xs-12"></div>-->
            <div class="col-md-6 col-sm-6 col-xs-12"> 
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Muat Naik</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                       
                        <div class="form-group"> 

                            <?php
                            $preview = '';
                            if ($model) {
                                $preview = Html::img($model->getImageUrl().$title, [
                                            'class' => 'img-thumbnail',
                                            'alt' => $title,
                                            'title' => $title,
                                            'width' => '400',
                                            'height' => '500',
                                ]);
                            }

                            echo $form->field($model, 'image')->widget(FileInput::classname(), [
                                'options' => ['accept' => 'image/*'],
                                'pluginOptions' => [
                                    'allowedFileExtensions' => ['jpg'],
                                    'showPreview' => true,
                                    'initialPreview' => $preview,
                                    'browseLabel' => 'Cari',
                                    'removeLabel' => 'Padam',
                                    'uploadLabel' => 'Simpan',
                                ]
                            ])->label(false);
                            ?>
                            <div align ="center">
<!--                                <//?php
                                if (!$model->isNewRecord) {
                                    echo Html::a('<span class="glyphicon glyphicon glyphicon-trash"></span>', ['/cbelajar/padam-gambar', 'id'=>$iklan->id], ['class' => 'btn btn-default btn-sm']);
                                    
                                    echo Html::submitButton('Seterusnya', ['maklumat-peribadi',  'id' => $iklan->id], ['class' => 'btn btn-info btn-sm']);
                                }
                                ?> -->

                            </div>

                        </div>
                    </div>
                </div>
            </div>
 <?= $form->field($model, 'iklan_id')->hiddenInput(['value' => $iklan->id])->label(false); ?>

<?php ActiveForm::end(); ?>

<!--  <p align ="right">
               
                <?= Html::a('Seterusnya', ['maklumat-peribadi','id'=>$iklan->id], ['class' => 'btn btn-info btn-sm']);?>
    
            </p>-->

</div>
    </div>
   
</div>
<!--<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>-->

</div>