<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use kartik\spinner\Spinner;
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
                                'id' => 'att-rpt',
                                'action' => ['kehadiran/att-rpt'],
                                'method' => 'POST',
                            ])
                    ?>


                    <?= Html::dropDownList('tahun', $tahun, ['2019' => '2019'], ['class' => 'form-control col-md-3 col-sm-3 col-xs-3', 'id' => 'tahun']); ?>
                    <br>
                    <br>
                    <?= Html::dropDownList('bulan', $bulan, ['01' => 'January', '02' => 'February', '03' => 'Mac', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'], ['class' => 'form-control col-md-1 col-sm-1 col-xs-12', 'id' => 'bulan']); ?>
                    <br>
                    <br>
                    <?= Html::submitButton('<i class="fa fa-search"></i>&nbsp;Search', ['class' => 'btn btn-primary', 'id' => 'search']) ?>

                    <?= Html::a('<i class="fa fa-print"></i> Print', ['kehadiran/att-rpt'], ['class' => 'btn btn-warning', 'id' => 'print-rpt']) ?>
                    <?php ActiveForm::end() ?>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Attendance Report</strong></h2>
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




<?php $url = Yii::$app->urlManager->createUrl("kehadiran/load-att-rpt"); ?>
<?php $print = Yii::$app->urlManager->createUrl("kehadiran/print-att-rpt"); ?>

<?php
$script = <<< JS
        
    $(document).ready(function () {
        $('#loading').hide();
        $("#stat").load('$url');
        
        function processForm(e) {
            $.ajax({
                url: '$url',
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

    $('#att-rpt').submit(processForm);
        
        
        $( "#print-rpt" ).on( "click", function(e) {
            e.preventDefault();
            var tahun = $( "#tahun" ).val();
            var bulan = $( "#bulan" ).val();
            //alert(tahun+bulan);
            window.open("/staff/web/kehadiran/print-att-rpt?tahun="+tahun+"&bulan="+bulan);
          });
        
        
        
    });

JS;
$this->registerJs($script, View::POS_END);
?>
