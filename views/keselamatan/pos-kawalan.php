<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\hronline\GredJawatan;
use app\models\keselamatan\RefPosKawalan;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use kartik\grid\GridView;
use app\widgets\TopMenuWidget;
use kartik\widgets\TimePicker;
use yii\helpers\Url;
error_reporting(0);
/* @var $this yii\web\View */
/* @var $model app\models\mohonjawatan\TblPermohonan */
/* @var $form ActiveForm */
$this->registerJs(
    "$('#save-draft-btn').on('click', function (e) {
    $.ajax({
       type: 'POST',
       url: draftUrl,
       data: $('#report-index').serialize()
    });      
})",
    'my-button-handler'
);
?>
<?= $this->render('/keselamatan/_topmenu') ?>


<div class="control-label col-md-12">
    <div class="x_panel">

        <div class="x_title">
            <h2>Selenggara Senarai Syif</h2>

            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Pos Kawalan: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($pos, 'pos_kawalan')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                    <p style="color:red;">Sila Pastikan tiada Jarak dan Pastikan Pos Kawalan yang di tambah sama dengan yang digunakan di dalam jadual yang diupload ke dalam sistem. Contoh : A1</p>

                </div>
            </div>

            <!-- <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Pecahan Pos Kawalan : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($pos, 'pecahan_pos')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div> -->

            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Kampus: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                        $form->field($pos, 'kampus_id')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(app\models\hronline\Campus::find()->all(), 'campus_id', 'campus_name'),
                            'options' => ['placeholder' => '-- Pilih Kampus --', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                    ?>

                </div>
            </div>

            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'url' => ['index']]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div> <!-- end of xpanel-->

<div class="control-label col-md-12">

    <div class="x_panel">

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
                        'label' => 'Pos Kawalan',
                        'value' => 'pos_kawalan',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Pecahan Pos Kawalan',
                        'value' => 'pecahan_pos',
                      
                    ],
                    [
                        'label' => 'Kampus',
                        'value' => 'campus.campus_name',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'Status',
                        'format' => 'raw',
                        'value' => 'status',
                        'vAlign' => 'middle',
                        'hAlign' => 'center',
                    ],
                    [
                        'label' => 'KemasKini',
                        'format' => 'raw',
                        'value' => function ($data) {

                            return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['update-pos', 'id' => $data->id]), 'class' => 'fa fa-edit mapBtn']);
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

    </div> <!-- end of xpanel-->
</div> <!-- end of md-->