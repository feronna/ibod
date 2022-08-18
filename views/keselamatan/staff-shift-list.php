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
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Add New Staff</h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Unit: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'unit_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefUnit::find()->where(['active' => 1])->all(), 'id', 'unit_name'),
                        'options' => ['placeholder' => 'Pilih Unit', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Pos Kawalan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'pos_kawalan_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(RefPosKawalan::find()->where(['active' => 1])->all(), 'id', 'pos_kawalan'),
                        'options' => ['placeholder' => 'Pilih Pos Kawalan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Staff Name: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'staff_icno')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map($biodata, 'ICNO', 'CONm'),
                        'options' => ['placeholder' => '-- Pilih Staf --', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Bulan :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?=
                    $form->field($model, 'month')->label(false)->widget(Select2::classname(), [
                        'data' => ['01' => 'January', '02' => 'February', '03' => 'Mac', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'],
                        'options' => ['placeholder' => 'Pilih Bulan', 'class' => 'form-control col-md-7 col-xs-12'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Ketua Pos / Penyelia:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?= $form->field($model, 'ketua_pos')->checkbox(['label' => 'Ya'])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Penolong Ketua Pos / Penolong Penyelia:
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">

                    <?= $form->field($model, 'penolong_ketua_pos')->checkbox(['label' => 'Ya'])->label(false) ?>
                </div>
            </div>


            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Add Staff', ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
            <br>

            <div class="row"></div>


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
                        'value' => 'unitname.unit_name',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Pos Kawalan',
                        'format' => 'raw',
                        'value' => 'pos.pos_kawalan',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'header' => 'Actions',
                        'template' => '{update} | {delete}',
                        'hAlign' => 'center',
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



        </div>
    </div>
</div>
