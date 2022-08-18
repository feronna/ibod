<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2; 
?>

<div class="tblprcobiodata-search">
    <div class="x_panel">
        <div class="x_title">
            <h2>Carian</h2> 
            <div class="clearfix"></div>
        </div>
        <div class="x_content"> 
            <?php
            $form = ActiveForm::begin([
                        'action' => ['carian-iklan'],
                        'method' => 'get',
                        'options' => [
                            'data-pjax' => 1
                        ],
                        'fieldConfig' => ['autoPlaceholder' => true,
                        ],
            ]);
            ?>

            <div class="col-md-4 col-sm-4 col-xs-4">
                <?=
                $form->field($iklan, 'jawatan_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\GredJawatan::find()->all(), 'id', 'fname'),
                    'options' => ['placeholder' => 'Pilih Jawatan'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <?=
                $form->field($iklan, 'klasifikasi_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\ejobs\KlasifikasiJawatan::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Pilih Klasifikasi'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <?=
                $form->field($iklan, 'penempatan_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Kampus::find()->all(), 'campus_id', 'campus_name'),
                    'options' => ['placeholder' => 'Pilih Penempatan'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <?=
                $form->field($iklan, 'kategori_iklan_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\ejobs\KategoriJawatan::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Pilih Kategori'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <div class="form-group">
                    <?= Html::submitButton('Cari', ['class' => 'btn btn-primary']) ?> 
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
