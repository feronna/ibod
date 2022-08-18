<?php

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
    <div class="col-md-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-bar-chart"></i>&nbsp;<strong>Monthly Leave Taken</strong></h2>
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