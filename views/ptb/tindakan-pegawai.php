<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>


<?php

$word = [
    1 => [
        'name' => 'Nama Ketua Pentadbiran',
        'tindakan' => 'Tindakan Ketua Pentadbiran',
        'status' => 'Status Persetujuan',
        'catatan' => 'Catatan Pensetuju'
    ],

    2 => [
        'name' => 'Nama Ketua JFPIU',
        'tindakan' => 'Tindakan Ketua JFPIU',
        'status' => 'Status Perakuan',
        'catatan' => 'Catatan Peraku'
    ]
];
$options = [
        1 => [1 => 'Dipersetujui', 0 => 'Tidak Dipersetujui'],
    2 => [1 => 'Diperaku', 0 => 'Tidak Diperaku']
];
?>
<div class="row">
<div class="col-md-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-users"></i><?= $word[$model->type]['tindakan'] ?></strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                  <div class="table-responsive">
                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id"><?= $word[$model->type]['status']?><span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <?=
                            $form->field($model, 'agree')->label(false)->widget(Select2::classname(), [
                                'data' => $options[$model->type],
                                'options' => ['placeholder' => 'Pilih Tindakan', 'class' => 'form-control col-md-7 col-xs-12'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $word[$model->type]['catatan'] ?><span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($model, 'notes')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                        </div>
                    </div>
                    <div class="ln_solid"></div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button class="btn btn-primary" type="reset">Reset</button>
                            <?= Html::submitButton('Hantar Jawapan', ['class' => 'btn btn-success', 'data'=>['confirm'=>'Adakah anda pasti dengan tindakan ini?']]) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
                <!--form-->
            </div>
            </div>
        </div>
    </div>
</div>

