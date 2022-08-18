<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefUnit;
use app\widgets\TopMenuWidget;
use yii\widgets\Pjax;
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<?php Pjax::begin(['id' => 'icno']) ?>
<div class="col-md-12 col-sm-12 col-xs-12"> 
    <div class="x_panel">    

        <div class="ln_solid"></div>

        <div class="x_title">


            <!--// Control your pjax options-->
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'options' => [
                    'class' => 'table-responsive',
                ],
                /*   'filterModel' => $searchModel, */ //to hide the search row
                'columns' => [
                    ['class' => 'kartik\grid\SerialColumn'],
                    [
                        'label' => 'Nama',
                        'value' => 'staff.CONm',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Unit',
                        'value' => 'unitname',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Syif',
                        'value' => 'syif',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Tarikh',
                        'value' => 'date',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Jenis Syif',
                        'value' => 'type',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Hadir Baris',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if ($data->THBH == 0) {
                                $checked1 = 'checked disabled';
                            } else {
                                $checked1 = 'disabled';
                            }


                            return Html::a('<input type="checkbox" name="' . $data->anggota_icno . '" value="yy' . $data->anggota_icno . '" ' . $checked1 . '>');
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Tidak Hadir Baris',
                        'format' => 'raw',
                        'value' => function ($data) {
                            if ($data->THBH == 1) {
                                $checked1 = 'checked disabled';
                            } else {
                                $checked1 = 'disabled';
                            }


                            return Html::a('<input type="checkbox" name="' . $data->anggota_icno . '" value="y' . $data->anggota_icno . '" ' . $checked1 . '>');
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                    [
                        'label' => 'Tindakan',
                        'format' => 'raw',
                        'value' => function ($data) {
                            return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['update-kesalahan', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn']);
                        },
                        'headerOptions' => ['class' => 'text-center'],
                        'contentOptions' => ['class' => 'text-center'],
                    ],
                ],
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
                'hover' => true,
                'floatHeader' => true,
                'floatHeaderOptions' => [
                    'position' => 'absolute',
                ],
            ]);
            ?>


            <div class="form-group" align="right">
                <?= Html::button('Odometer', ['id' => 'modalButton', 'value' => Url::to(['odometer']), 'class' => 'btn btn-info mapBtn']);
                ?>
                <?= Html::button('Ulasan Harian(DO)', ['id' => 'modalButton', 'value' => Url::to(['laporan-kejadian']), 'class' => 'btn btn-info mapBtn']);
                ?>

                <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1'])
                ?>
                <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Hantar'), ['class' => 'btn btn-primary', 'name' => 'hantar', 'value' => 'submit_2'])
                ?>


            </div>
        </div>
        <?php Pjax::end() ?>
        <?php ActiveForm::end(); ?>

    </div>

</div>
