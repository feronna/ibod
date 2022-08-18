<?php

use app\models\cuti\TblRecords;
use aryelds\sweetalert\SweetAlert;
use yii\helpers\Html;

use kartik\spinner\Spinner;
use yii\web\View;
use yii\helpers\Url;
use yii\web\JsExpression;

?>

<?php


$JSEventClick = <<<EOF
function(calEvent, jsEvent, view) {
    alert(calEvent.title);
    // alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
    // alert('View: ' + view.name);
    // change the border color just for fun
    $(this).css('border-color', 'red');
}
EOF;

?>

<div class="row">
    <!-- <div class="col-md-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-bar-chart"></i>&nbsp;<strong>Cuti Bulanan / <i>Monthly Leave Taken</i></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="stat">
                    <?= Spinner::widget(['preset' => 'small', 'align' => 'center']); ?>
                </div>
            </div>
        </div>
    </div> -->
   


<div class="row">
    <div class="col-md-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-info-circle"></i>&nbsp;<strong>Maklumat Cuti / <i>Leave Info</i></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!-- <div class="tile-stats">
                        <div class="icon"><i class="fa fa-check-square-o"></i></div>
                        <div class="count">Mohon</div>
                        <h3>Cuti Rehat</h3>
                        <p><?= Html::a('<i class="text-success fa fa-check"></i> Klik untuk mohon', ['cuti/individu/pilih']) ?></p>
                    </div> -->
                    <div class="tile-stats">
                        <div class="icon"></div>
                        <div class="count"><?= $total ?> Hari/<i>Days</i></div>
                        <h3>Baki/<i> Balance</i></h3>
                    </div>
                    <?= Html::a('<i class="fa fa-check-circle-o"></i> Click to Apply Leave', ['cuti/individu/pilih'], ['class' => 'btn btn-primary btn-block']) ?>
                </div>

                <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                    <div class="tile-stats" style='padding:10px'>
                        <div class="x_content">
                            <?php echo Yii::$app->controller->renderPartial('_list_cuti', ['bil' => 1, 'cuti_rekod' => $cuti_rekod,]); ?>

                            <div style='padding: 15px;' class="table-bordered">
                                <font><u><strong>RUJUKAN /<i> REFERENCE</i></u> </strong></font><br><br>

                                <span class="label label-default">ENTRY</span> : Permohonan Baru / <i>New Leave Application</i> &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <span class="label label-primary">AGREED</span> : Pengganti Bersetuju / <i>Substitute Has Agreed</i> &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <span class="label label-info">VERIFIED</span> : Permohonan Cuti Diperaku / <i>Leave Application Has Been Verified</i>&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <span class="label label-success">APPROVED</span> : Permohonan Cuti Diluluskan / <i> Leave Application Has Been Approved</i>


                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-xs-12">
        <div class="x_panel">
          
            <div class="x_content">
            <h4>Pengganti Kepada /<i>My Substitute List</i></h4>
                        <?php echo Yii::$app->controller->renderPartial('_list_ganti', ['bil' => 1, 'model' => $model,]); ?>
                    
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-calendar-check-o"></i>&nbsp;<strong>Kalendar Cuti / <i>Leave Calender</i></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= yii2fullcalendar\yii2fullcalendar::widget([
                    'options' => [
                        'lang' => 'en',
                        //... more options to be defined here!
                    ],
                    'events' => Url::to(['cuti/individu/jsoncalendar']),
                    'clientOptions' => [
                        'selectable' => true,
                        'selectHelper' => true,
                        'droppable' => true,
                        // 'editable' => true,
                        'eventClick' => new JsExpression($JSEventClick),
                        'defaultDate' => date('Y-m-d')
                    ],

                ]);
                ?>

            </div>
        </div>
    </div>
</div>
<?php $url = Yii::$app->urlManager->createUrl("cuti/individu/load-mth-leave"); ?>

<?php
$script = <<< JS
        
    $(document).ready(function () {
         $('#loading').hide();
        $("#stat").load('$url');

    });

JS;
$this->registerJs($script, View::POS_END);
?>