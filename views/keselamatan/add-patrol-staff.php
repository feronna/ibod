<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use dosamigos\datepicker\DatePicker;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use app\models\cuti\CutiRekod;
use app\models\keselamatan\RefPatrolPos;
use app\models\keselamatan\TblPatrolStaff;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\web\View;
use yii\helpers\ArrayHelper;
?>

<?= $this->render('/keselamatan/_topmenu') ?>

<!--<div class="col-md-12"> -->

<div class="x_panel">
    <div class="x_title">
        <h2><strong>Pilih Kawalan</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

        <?= Html::beginForm(['add-patrol-staff'], 'GET'); ?>

        <br>
        <?= Html::dropDownList('id', $id, ArrayHelper::map(RefPatrolPos::find()->where(['active' => 1, 'campus_id' => $campus->campus_id])->all(), 'id', 'jenis_shifts'), ['class' => 'form-control col-md-1 col-sm-1 col-xs-12']); ?>
        <br>
        <br>
        <div class="form-group" align="right">

            <button class="btn btn-primary" type="reset">Set Semula</button>
            <?= Html::submitButton('<i class="fa fa-plane"></i> Hantar', ['class' => 'btn btn-primary']); ?>
            <!--<a href="#" class ='btn btn-warning'><i class="fa fa-print"></i> Cetak Laporan</a>-->
            <?= Html::endForm(); ?>
        </div>

    </div>


</div>
<?php if ($var != null) { ?>

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
    <?php Pjax::begin(['id' => 'icno']) ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="ln_solid"></div>

            <div class="x_title">

                <!-- <button type="button" class="checkall btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Select All</button> -->

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
                                'hAlign' => 'left',

                            ],

                            [
                                'label' => 'Tambah Anggota',
                                'format' => 'raw',
                                'value' => function ($data) {

                                    // var_dump($data->staff_icno);
                                    $check = TblPatrolStaff::find()->where(['icno' => $data->staff_icno])->andWhere(['patrol_pos_id' => Yii::$app->getRequest()->getQueryParam('id')])->exists();

                                    if($check) {
                                        $validate = TblPatrolStaff::find()->where(['icno' => $data->staff_icno])->andWhere(['patrol_pos_id' => Yii::$app->getRequest()->getQueryParam('id')])->one();
                                        if ($validate->icno == $data->staff_icno) {
                                        $checked1 = 'checked disabled';
                                        //                                //npending utk rejected tp baru kena simpan
                                        } else {
                                            $checked1 = '';
                                        }
                                    } else {
                                        $checked1 = '';
                                    }

                                    return Html::a('<input type="checkbox" name="' . $data->staff_icno . '" value="patrol' . $data->staff_icno . '" ' . $checked1 . ' >');
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
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait.. ']])
                    ?>

                </div>
            </div>
            <?php Pjax::end() ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php } ?>
<!--</div>-->

<?php
$script = <<< JS
        
       $(document).ready(function () {
        
        var clicked = false;
        $(".checkall").on("click", function() {
          $(".checkId").prop("checked", !clicked);
          clicked = !clicked;
        });

    });
    $(window).scroll(function() {
  sessionStorage.scrollTop = $(this).scrollTop();
});

$(document).ready(function() {
  if (sessionStorage.scrollTop != "undefined") {
    $(window).scrollTop(sessionStorage.scrollTop);
  }
});
JS;
$this->registerJs($script, View::POS_END);
?>