<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use app\widgets\TopMenuWidget;
use kartik\widgets\TimePicker;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use aryelds\sweetalert\sweetalert;

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
})", 'my-button-handler'
);
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<?php
    echo SweetAlert::widget([
        'options' => [
            'title' => "Info",
            'text' => "Sila Ke Langkah 2 sekiranya Menggunakan Syif Asal (A,B,C).",
            'type' => SweetAlert::TYPE_INFO,
            'animation' => 'slide-from-top',
//        'showCancelButton' => true,
//        'confirmButtonColor' => "#DD6B55",
            'confirmButtonText' => "Ok",
            'closeOnConfirm' => true,
        ],
    ]);

?>
<div class="col-xs-12 col-md-12 col-lg-12"> 
    <div class="x_panel">
        <div class="x_content">

            <div class="row">

                <!-- <div style="background-color:lightblue" class="col-xs-12 col-md-3">
                    <br>
                    <?php
                    $cr = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'plus-square',
                                        'header' => 'Tambah Syif',
                                        'text' => '',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($cr, ['keselamatan/lmt-keselamatan']);
                    ?>
                </div> -->
                <div class="col-xs-12 col-md-3">
                    <br>
                    <?php
                    $ck = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'plus-square',
                                        'header' => 'Tambah Anggota',
                                        'text' => '',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($ck, ['keselamatan/lmt-shift-list']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-3">
                    <br>
                    <?php
                    $c = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'clock-o',
                                        'header' => 'Tambah Syif',
                                        'text' => '',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($c, ['keselamatan/lmt-setup']);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="control-label col-md-12"> 
    <div class="x_panel">

        <div class="x_title">
            <h2>Lebihan Masa Tambahan</h2>
            <div class="clearfix"></div>
        </div>  

        <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Nama Syif : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($refshift, 'jenis_shifts')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Syif Mula : <span class="required" style="color:red;">*</span>
                </label>

                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    TimePicker::widget([
                        'model' => $refshift,
                        'attribute' => 'start_time',
                        'pluginOptions' => [
                            'showSeconds' => true,
                            'showMeridian' => false,
                            'minuteStep' => 1,
                            'secondStep' => 5,
                        ]
                    ]);
                    ?>
                </div>

                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $refshift,
                        'attribute' => 'start_date',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div> 

            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Syif Tamat : <span class="required" style="color:red;">*</span>
                </label>

                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    TimePicker::widget([
                        'model' => $refshift,
                        'attribute' => 'end_time',
                        'pluginOptions' => [
                            'showSeconds' => true,
                            'showMeridian' => false,
                            'minuteStep' => 1,
                            'secondStep' => 5,
                        ]
                    ]);
                    ?>

                </div>
                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">

                    <?=
                    DatePicker::widget([
                        'model' => $refshift,
                        'attribute' => 'end_date',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Spesifikasi Syif : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($refshift, 'details')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
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
</div>  <!-- end of xpanel-->
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
                'label' => 'Nama Syif',
                'value' => 'jenis_shifts',
            ],
            [
                'label' => 'Spesifikasi Syif',
                'value' => 'details',
            ],
            [
                'label' => 'Masa Mula Syif',
                'value' => 'start_time',
            ],
            [
                'label' => 'Tarikh Mula',
                'value' => 'start_date',
            ],
            [
                'label' => 'Masa Tamat Syif',
                'value' => 'end_time',
            ],
            [
                'label' => 'Tarikh Tamat',
                'value' => 'end_date',
            ],
            [
                'label' => 'Status',
                'format' => 'raw',
                'value' => 'status',
            ],
            [
                'label' => 'Actions',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['update-syif-lmt', 'id' => $data->id]), 'class' => 'fa fa-pencil mapBtn']);
                },
                'vAlign' => 'middle',
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
</div>  <!-- end of xpanel-->
</div> <!-- end of md-->
