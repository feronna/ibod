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
                <h2><i class="fa fa-info-circle"></i>&nbsp;<strong>Maklumat Cuti Bersalin / <i>Leave Info</i></strong></h2>
                <ul class="nav navbar-right panel_toolbox ">
                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
           

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="tile-stats" style='padding:10px'>
                        <div class="x_content">
                            <?php echo Yii::$app->controller->renderPartial('_list_cuti_bersalin', ['bil' => 1, 'cuti_rekod' => $cuti_rekod,]); ?>

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