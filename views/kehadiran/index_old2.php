<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\widgets\OpenLayers\OpenLayers;
use kartik\spinner\Spinner;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?>

<style>
    ul {
        list-style-type: none;
        padding: 0;
    }
</style>

<div class="row">
    <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-clock-o"></i> <?php echo date('l, jS \of F Y'); ?>&nbsp;</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php if ($wp_id) { ?>
                    <div class="col-md-6 col-sm-6 col-xs-12 text-center"> 
                        <h1 class="text-center align-center"><p class="text-monospace" id="clock"></p></h1>
                        <hr>
                        <?php $form = ActiveForm::begin(); ?>
                        <?= $form->field($model, 'latlng')->textInput(['maxlength' => true, 'readonly' => true])->label(false)->hiddenInput(); ?>
                        <?php if ($model->isNewRecord) { ?>

                            <?= Html::submitButton('<i class="fa fa-sign-in"></i><br>Clock In<br>-', ['class' => 'btn btn-lg btn-success']) ?>
                            <?= Html::a("<i class='fa fa-sign-in'></i><br>Clock Out<br> $time_out", ['site/index'], ['class' => 'btn btn-lg btn-danger disabled']) ?>
                        <?php } else { ?>
                            <?= Html::a("<i class='fa fa-sign-in'></i><br>Clock In<br> $time_in", ['site/index'], ['class' => 'btn btn-lg btn-success disabled']) ?>
                            <?= Html::submitButton("<i class='fa fa-sign-in'></i><br>Clock Out<br>$time_out", ['class' => 'btn btn-lg btn-danger']) ?>
                        <?php } ?>

                        <?php ActiveForm::end(); ?>

                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12"> 
                        <h5><i class="fa fa-briefcase"></i>&nbsp; Waktu Bekerja : <strong><?php echo $model_wp->jenis_wp; ?></strong></h5>
                        <h5><i class="fa fa-briefcase"></i>&nbsp;Status : <?= $status_in ? '<span class="label label-danger">' . $status_in . '</span>' : '-'; ?></h5>
    <!--                        <h5><i class="fa fa-sign-in"></i>&nbsp;Clock In : <strong><?= $time_in ?>&nbsp;<?= $status_in ? '<span class="label label-danger">' . $status_in . '</span>' : ''; ?></strong></h5>
                        <h5><i class="fa fa-sign-out"></i>&nbsp;Clock Out : <strong><?= $time_out ?>&nbsp;<?= $status_out ? '<span class="label label-danger">' . $status_out . '</span>' : ''; ?></strong></h5>-->
                        <h5><i class="fa fa-clock-o"></i>&nbsp;Jumlah Jam Bekerja : <strong><?= $total_hours ?></strong></h5>
                        <h5><i class="fa fa-address-card-o"></i>&nbsp;Alamat IP : <?= $ip ?></h5>
                        <p id="demo"> </p>
                        <a href="https://www.google.com/maps" class="btn-sm btn-primary" target="_blank"><i class="fa fa-map-marker"></i>&nbsp;Location</a>
                    </div>
                <?php } else { ?>
                    <h3 class="text-center">Anda belum mempunyai waktu jam bekerja</h3>
                    <hr>
                    <?= Html::a('Mohon WBB', ['kehadiran/wbb'], ['class' => 'btn btn-warning btn-block']) ?>

                <?php } ?>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-file"></i> Warna Kad Kehadiran</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
               
                <div class="tile-stats" style="width:auto; height: 150px; background-color:  <?=$color; ?>">

                </div>
                <p style="font-size:11px; color:green;">* Warna kad kehadiran akan berubah setiap <strong>1hb pada setiap bulan</strong> berdasarkan ketidakpatuhan pada bulan terdahulu.</p>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-user"></i> Tindakan Individu</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <ul>
                    <li><?= Html::a('<i class="fa fa-exchange"></i> Waktu Bekerja Berperingkat (WBB)', ['kehadiran/wbb'], ['class' => 'btn btn-primary btn-sm']) ?></li>
                    <li><?= Html::a('<i class="fa fa-list"></i> Senarai Kehadiran', ['kehadiran/laporan_kehadiran'], ['class' => 'btn btn-primary btn-sm']) ?></li>
                    <!--<li><?= Html::a('<i class="fa fa-stack-overflow"></i> Overtime', ['site/index'], ['class' => 'btn btn-primary btn-sm']) ?></li>-->
                    <li><?= Html::a('<i class="fa fa-list"></i> Tindakan Ketidakpatuhan', ['kehadiran/tindakan_ketidakpatuhan'], ['class' => 'btn btn-primary btn-sm']) ?></li>
                    <li><?= Html::button('<i class="fa fa-book"></i> Ruj. Pekeliling Warna Kad', ['value' => Url::to("index.php?r=kehadiran/kad_warna"), 'class' => 'mapBtn btn btn-sm btn-primary', 'id' => 'modalButton']); ?></li>
                    <li><a href="https://staff.ums.edu.my" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-automobile"></i> Keluar Pejabat</a></li>
                    <li><a href="https://www.youtube.com/watch?v=gjuKEkfIS8c" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-file-video-o"></i> Manual Pengguna</a></li>
                    <li><a href="<?php echo Url::to('@web/files/garis_panduan_kehadiran.pdf', true); ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-book"></i> Garis Panduan</a></li></li>
                    <li><a href="https://goo.gl/forms/lN70aPnLQhk3xX1D3" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-question-circle"></i> Borang Soal Selidik</a></li></li>
                </ul>

            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12 col">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-user"></i> Tindakan Pegawai</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <ul>
                    <li><?= Html::a('<i class="fa fa-exclamation-triangle"></i> Tindakan Ketidakpatuhan', ['kehadiran/senarai_tindakan'], ['class' => 'btn btn-info btn-sm']) ?></li>
                    <li><?= Html::a('<i class="fa fa-pencil-square-o"></i> Tindakan WBB', ['kehadiran/s_tindakan_wbb'], ['class' => 'btn btn-info btn-sm']) ?></li>
                    <li><?= Html::a('<i class="fa fa-file-o"></i> Pantau Warna Kad Staf', ['kehadiran/pantau_warna_kad'], ['class' => 'btn btn-info btn-sm']) ?></li>
                    <li><?= Html::a('<i class="fa fa-list"></i> Pantau Kehadiran Staf', ['kehadiran/pantau_kehadiran'], ['class' => 'btn btn-info btn-sm']) ?></li>
                    <li><?= Html::a('<i class="fa fa-area-chart"></i> Monthly Summary', ['kehadiran/monthly_summary'], ['class' => 'btn btn-info btn-sm']) ?></li>
                </ul>


            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-user"></i> Tindakan Penyelia J/F/P/I/B</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <ul>
                    <li><?= Html::a('<i class="fa fa-address-book-o"></i> Senarai Staf Seliaan', ['kehadiran/senarai_kakitangan'], ['class' => 'btn btn-warning btn-sm']) ?></li>
                </ul>
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