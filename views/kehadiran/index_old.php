<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\widgets\OpenLayers\OpenLayers;
use kartik\spinner\Spinner;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$url = Yii::$app->urlManager->createUrl("kehadiran/test");
?>


<style>
    #map {
        visibility: hidden;
        height: 100px;
    }

</style>

<ol class="breadcrumb">
    <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['site/index']) ?></li>
    <li>Kehadiran</li>
</ol>

<!--<div class="row top_tiles">
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-exclamation-circle" style="color: #00329B"></i></div>
            <div class="count">30</div>
            <h3>Kesalahan</h3>
            <p>Bulan Oktober</p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-file-o" style="color:red;"></i></div>
            <div class="count">179</div>
            <h3>Status Kad</h3>
            <p style="color:red">Merah</p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-check-circle-o" style="color:green;"></i></div>
            <div class="count">32 Hari</div>
            <h3>Kelayakan Cuti</h3>
            <p>Cuti 2018</p>
        </div>
    </div>
    <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="tile-stats">
            <div class="icon"><i class="fa fa-heartbeat" style="color:blueviolet"></i></div>
            <div class="count">2</div>
            <h3>Jumlah Cuti Sakit</h3>
            <p>Bulan Oktober</p>
        </div>
    </div>
</div>-->
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Pautan Lain</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= Html::a('<i class="fa fa-exchange"></i> WBB', ['kehadiran/wbb'], ['class' => 'btn btn-success btn-sm']) ?>
                <?= Html::a('<i class="fa fa-list"></i> Kehadiran', ['kehadiran/attd_list'], ['class' => 'btn btn-success btn-sm']) ?>
                <?php //echo Html::a('<i class="fa fa-exclamation-triangle"></i> Senarai Ketidakpatuhan', ['site/index'],['class'=>'btn btn-default btn-sm']) ?>
                <?= Html::a('<i class="fa fa-stack-overflow"></i> Overtime', ['site/index'], ['class' => 'btn btn-success btn-sm']) ?>
                <?= Html::a('<i class="fa fa-exclamation-triangle"></i> Tindakan Ketindakpatuhan', ['kehadiran/senarai_tindakan'], ['class' => 'btn btn-success btn-sm']) ?>
                <?= Html::a('<i class="fa fa-pencil-square-o"></i> Tindakan WBB', ['kehadiran/s_tindakan_wbb'], ['class' => 'btn btn-success btn-sm']) ?>
                <?= Html::a('<i class="fa fa-address-book-o"></i> Staf Seliaan', ['kehadiran/senarai_kakitangan'], ['class' => 'btn btn-success btn-sm']) ?>
                <?= Html::button('<i class="fa fa-book"></i> Ruj. Pekeliling Warna Kad', ['value' => Url::to("index.php?r=kehadiran/kad_warna"), 'class' => 'mapBtn btn btn-sm btn-success', 'id' => 'modalButton']); ?>

            </div>
        </div>


    </div>

</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-clock-o"></i> Kehadiran</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if ($wp_id) { ?>
                    <h4 class="text-center align-center"><?php echo date('l jS \of F Y'); ?></h4>
                    <h1 class="text-center align-center"><p class="text-monospace" id="clock"></p></h1>
                    <hr>
                    <table class="table table-bordered">
                        <tr>

                            <td class="text-center" colspan="3"><strong><i class="fa fa-list-alt"> </i> <?php echo $model_wp->detail; ?></strong></td>
                        </tr>
                        <tr>
                            <td><strong> <i class="fa fa-sign-in"></i> Check In</strong></td>
                            <td class="text-center"><?= $time_in ?></td>
                            <td class="text-center"><span class="label label-danger"><?= $status_in ?></span></td>
                        </tr>
                        <tr>
                            <td><strong><i class="fa fa-sign-out"></i> Check Out</strong></td>
                            <td class="text-center"><?= $time_out ?></td>
                            <td class="text-center"><span class="label label-danger"><?= $status_out ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-center"><strong><i class="fa fa-clock-o"></i> Total Working Hours</strong></td>
                            <td colspan="2" class="text-center"><strong><?= $total_hours ?></strong></td>
                        </tr>
                    </table>

                    Current IP Address: <?= $ip ?>

                    <p id="demo"> </p>
                    <a href="https://www.google.com/maps" class="btn-sm btn-success" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;Location</a>



                    <?php $form = ActiveForm::begin(); ?>

                    <?php if ($model->time_out == NULL) { ?>
                        <?= $form->field($model, 'latlng')->textInput(['maxlength' => true, 'readonly' => true])->label(false)->hiddenInput(); ?>
                                                                    <!--<input type="text" id="tblrekod-latlng" class="form-control" name="TblRekod[latlng]" value="6.0362763,116.11521990000001">-->
                        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-sign-in"></i>&nbsp;Check In' : '<i class="fa fa-sign-out"></i>&nbsp;Check Out', ['class' => 'btn btn-block btn-primary']) ?>
                    <?php } ?>

                    <?php ActiveForm::end(); ?>

                <?php } else { ?>
                    <h3 class="text-center">Anda belum mempunyai waktu jam bekerja</h3>
                    <hr>
                    <?= Html::a('Mohon WP', ['/kehadiran/wbb'], ['class' => 'btn btn-warning btn-block']) ?>

                <?php } ?>
              
                    <h5>Peringatan Mesra :</h5>
                    <p style="color:green;">
                        <i>
                            1. Anda Wajib untuk menggunakan Wifi/Network yang berada didalam kawasan UMS semasa membuat Check In & Check Out.<br>
                            2. Sila buat Remark/catatan sekiranya melakukan ketidakpatuhan Kehadiran.<br>
                        </i>
                    </p>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Ketidakpatuhan <small>Remark</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-sm table-bordered">
                    <tr>
                        <th class="text-center">Bil</th>
                        <th class="text-center">Tarikh</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Remark</th>
                    </tr>
                    <?php if ($model_pending) { ?>
                        <?php foreach ($model_pending as $pr) { ?>
                            <tr>
                                <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                <td class="text-center"><?php echo $pr->formatTarikh; ?></td>
                                <td class="text-center"><?php echo $pr->statusAll; ?></td>
                                <td class="text-center"><?= Html::a('<i class="fa fa-edit">', ["kehadiran/remark", 'id' => $pr->id]); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7" class="align-center text-center"><i>Tidak Berkenaan</i></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Kerja Lebih Masa <small>Overtime</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if ($wp_id) { ?>
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Overtime In</strong></td>
                            <td><?= $ot_in ?></td>
                        </tr>
                        <tr>
                            <td><strong>Overtime Out</strong></td>
                            <td><?= $ot_out ?></td>
                        </tr>
                        <tr>
                            <td><strong>Total Overtime Hours</strong></td>
                            <td colspan="2" class="text-center"><strong><?= $total_ot ?></strong></td>
                        </tr>
                    </table>
                    <?php $form = ActiveForm::begin(); ?>

                    <?php if ($model->ot_in == NULL && $model->time_out != NULL) { ?>
                        <?= $form->field($model, 'latlng')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-clock-o"></i>&nbsp;OT In' : '<i class="fa fa-sign-in"></i>&nbsp;OT In', ['class' => 'btn btn-block btn-primary']) ?>
                    <?php } else if ($model->ot_out == NULL && $model->ot_in != NULL) { ?>
                        <?= $form->field($model, 'latlng')->textInput(['maxlength' => true, 'readonly' => true]) ?>
                        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-clock-o"></i>&nbsp;OT Out' : '<i class="fa fa-sign-out"></i>&nbsp;OT Out', ['class' => 'btn btn-block btn-primary']) ?>
                    <?php } ?>
                    <?php ActiveForm::end(); ?>
                <?php } else { ?>
                    <h3 class="text-center">Anda belum mempunyai waktu jam bekerja</h3>
                    <hr>
                    <?= Html::a('Mohon WP', ['/kehadiran/wbb'], ['class' => 'btn btn-warning btn-block']) ?>

                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    
        

var myVar = setInterval(function () {
    myTimer();
}, 1000);

function myTimer() {
    var d = new Date();
    document.getElementById("clock").innerHTML = d.toLocaleTimeString();
}

//$(document).ready(function(){
//        
//        
//        function initiate_geolocation() {
//            navigator.geolocation.getCurrentPosition(handle_geolocation_query);
//        }
// 
//        function handle_geolocation_query(position){
//         console.log('$url' + '&id=' + position.coords.latitude + ', ' + position.coords.longitude);
//           $("#latlng").load('$url' + '&id=' + position.coords.latitude + ',' + position.coords.longitude);
//        }
//        
//        initiate_geolocation();
//        
//
//});
     

JS;
$this->registerJs($script, View::POS_END);
?>
<script>
    var x = document.getElementById("demo");

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function showPosition(position) {
        x.innerHTML = "Latitude: " + position.coords.latitude +
                "<br>Longitude: " + position.coords.longitude;

        document.getElementById("tblrekod-latlng").value = position.coords.latitude + ',' + position.coords.longitude;

    }

    function showError(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                x.innerHTML = "User denied the request for Geolocation."
                break;
            case error.POSITION_UNAVAILABLE:
                x.innerHTML = "Location information is unavailable."
                break;
            case error.TIMEOUT:
                x.innerHTML = "The request to get user location timed out."
                break;
            case error.UNKNOWN_ERROR:
                x.innerHTML = "An unknown error occurred."
                break;
        }
    }


    getLocation();
</script>

<?php
Modal::begin([
    'header' => '<h4>Pengurusan Warna kad Kehadiran</h4>',
    'id' => 'modal',
    'size' => 'modal-md',
]);

echo "<div id='modalContent'></div>";

Modal::end();
?>