<?php

use dosamigos\highcharts\HighCharts;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use yii\helpers\Html;
use kartik\spinner\Spinner;
use yii\web\View;
?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian JFPIB</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-xs-12 col-md-12 col-lg-12"> 
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'statistik',
//                            'options' => ['class' => 'form-horizontal'],
                                'action' => ['kehadiran/admin-mth-rpt'],
                                'method' => 'POST',
                            ])
                    ?>


                    <div class="form-group">
                        <?=
                        $form->field($model, 'id')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname'),
                            'options' => ['placeholder' => 'J / F / P / I / B', 'class' => 'form-control col-md-5 col-xs-5', 'id' => 'dept_id', 'value' => $dept_id, 'name' => 'dept_id'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'multiple' => true,
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="form-group">
                        <?= Html::dropDownList('bulan', $month, ['01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun', '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember'], ['class' => 'form-control col-md-4 col-sm-4 col-xs-12', 'id' => 'bulan']); ?>
                        <br><br>
                        <?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;Search', ['class' => 'btn btn-primary', 'id' => 'search']) ?>
                        <?php ActiveForm::end() ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Statistik</strong></h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <div id="stat">
                    <?= Spinner::widget(['preset' => 'small', 'align' => 'center']); ?>
                </div>
                <div id="loading">
                    <?= Spinner::widget(['preset' => 'small', 'align' => 'center']); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $url_zone = Yii::$app->urlManager->createUrl("kehadiran/load-rpt-admin"); ?>

<?php
$script = <<< JS
        
    $(document).ready(function () {
         $('#loading').hide();
        $("#stat").load('$url_zone');
        
        function processForm(e) {
            $.ajax({
                url: '$url_zone',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                data: $(this).serialize(),
                beforeSend: function() {
                    // setting a timeout
                        $("#search").attr("disabled", true);
                        $('#stat').hide();
                        $('#loading').show();
                },
                success: function (data, textStatus, jQxhr) {
                    $("#search").attr("disabled", false);
                    $('#loading').hide();
                    $('#stat').show();
                    $('#stat').html(data);
                },
                error: function (jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

            e.preventDefault();
        }

    $('#statistik').submit(processForm);
        
        
        
//        $("#search").on( "click", function(e) {
//             $("#stat").load('$url_zone', {
//                   bulan: $("#bulan").val(),
//                   dept_id: $("#dept_id").val(),
//                   tahun: 2019,
//               });
//        
//        e.preventDefault();
//          });
        
    });

JS;
$this->registerJs($script, View::POS_END);
?>
