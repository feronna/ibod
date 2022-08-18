<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\popover\PopoverX;
?> 
<?= $this->render('menu') ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="x_panel"> 
        <div class="x_title">
            <h2>Kemaskini Pegawai</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">    
            <?php
            $content = Html::img('@web/uploads-gl/gl.jpg', ['class' => 'pull-left img-responsive']);
            ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Pegawai:  
                    <?=
                    PopoverX::widget([
                        'header' => 'Surat Jaminan Hospital',
                        'size' => PopoverX::SIZE_X_SMALL,
                        'placement' => PopoverX::ALIGN_RIGHT,
                        'content' => $content,
                        'toggleButton' => ['label' => '<i class="fa fa-info-circle" aria-hidden="true"></i></button>', 'class' => 'btn btn-default btn-sm'],
                    ]);
                    ?>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-12">   
                    <?=
                    $form->field($model, 'icno')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['Status' => 1])->all(), 'ICNO', 'CONm'),
                        'options' => ['placeholder' => 'Nama Staff'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])->label(false);
                    ?>
                </div>
            </div> 
            <div class="form-group text-center">
                <?= \yii\helpers\Html::a('Batal', Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
            </div>

        </div>
    </div>   

    <?php ActiveForm::end(); ?> 

</div>  

