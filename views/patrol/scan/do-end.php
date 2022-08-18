<?php

use app\models\keselamatan\RefShifts;
use app\models\patrol\Rekod;
use kartik\form\ActiveForm;
use kartik\spinner\Spinner;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

error_reporting(0);
if (date('H:i:s') >= "00:00:00" && date('H:i:s') <= "08:00:00") {
    $shift = '3';
}
if (date('H:i:s') >= "08:00:00" && date('H:i:s') <= "16:00:00") {
    $shift = '4';
}
if (date('H:i:s') >= "16:00:00" && date('H:i:s') <= "00:59:00") {
    $shift = '5';
}
?>
<style>
    .bimg {
        /* background-image: url('https://www.ums.edu.my/v5/images/stories/berita_attach/Mac_2016/keselamatanUMS2.jpg'); */
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        height: 100%;
    }

    .table {
        opacity: 0.1;
        background-color: rgba(0, 0, 0, 0.4);

    }
</style>

<body>
    <table>
        <div class="container text-center" style="background-color: rgba(0, 0, 0, 0.4)">
            <?php
            if ($status == 1) { ?>
                <div class="row">
                    <div class="col-xs-12 col-md-offset-2 col-md-8">
                        <div class="profile_img">
                            <div id="crop-avatar"> <br />
                                <center><img src="https://hronline.ums.edu.my/picprofile/picstf/<?= strtoupper(sha1($pegawai->ICNO)); ?>.jpeg" width="120" height="150"></center>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <?php $form = ActiveForm::begin(['action' => ['patrol/scan/end-do', 'id' => $id, 'latlng' => Yii::$app->request->post()['Rekod']['latlng'],$shift], 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>
                <font style="font-size:10px">
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-4 col-md-4" style="background-color:#081b26;color: white; padding:10px;">TAMAT RONDAAN</div>
                    </div>
                   
                    <div class="row">
                        <div class="col-xs-6 col-md-offset-4 col-md-2" style="background-color:#081b26;color: white; padding:10px;">NAMA PERONDA</div>
                        <div class="col-xs-6 col-md-2" style="background-color:white; padding:10px;"><strong><?= $pegawai->gelaran->Title . " " . ucwords(strtolower($pegawai->CONm)); ?></strong></div>
                    </div>


                    <div class="row">
                        <div class="col-xs-6 col-md-offset-4 col-md-2" style="background-color:#081b26;color: white; padding:10px;">JAWATAN</div>
                        <div class="col-xs-6 col-md-2" style="background-color:white; padding:10px;"><strong><?= $pegawai->jawatan->nama; ?> (<?= $pegawai->jawatan->gred; ?>)</strong></div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-md-offset-4 col-md-2" style="background-color:#081b26;color: white; padding:10px;">KAMPUS</div>
                        <div class="col-xs-6 col-md-2" style="background-color:white; padding:10px;"><strong><?= $pegawai->kampus->campus_name; ?></strong></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-offset-4 col-md-2" style="background-color:#081b26;color: white; padding:10px;">Syif</div>
                        <div class="col-xs-6 col-md-2" style="background-color:white; padding:10px;"><strong>
                                <?= Html::dropDownList('shift', $shift, ArrayHelper::map(
                                    Rekod::switch($key, date('Y-m-d')),
                                    'shift_id',
                                    function ($shift_id) {
                                        $model = RefShifts::findOne(['id' => $shift_id['shift_id']]);
                                        return $model->jenis_shifts;
                                    }
                                ), ['class' => 'form-control col-md-3 col-sm-3 col-xs-12']) ?>
                            </strong></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-md-offset-4 col-md-2" style="background-color:#081b26;color: white; padding:10px;">Status</div>
                        <div class="col-xs-6 col-md-2" style="background-color:white; padding:10px;">
                            <div id="zone">
                                <?= Spinner::widget(['preset' => 'small', 'align' => 'center']); ?>
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="row">
                        <div class="col-xs-12 col-md-offset-4 col-md-4" style="background-color:#081b26;color: white; padding:10px;">MAKLUMAT BIT</div>
                    </div>

                    <div class="row">
                        <div class="col-xs-6 col-md-offset-4 col-md-2" style="background-color:#081b26;color: white; padding:10px;">NAMA POS KAWALAN</div>
                        <div class="col-xs-6 col-md-2" style="background-color:white; padding:10px;"><strong><?= $bit->pos_kawalan; ?> </strong></div>
                    </div>
                   
                    <div class="row">
                        <div class="col-xs-12 col-md-offset-4 col-md-4" style="background-color:#081b26;color: white; padding:10px;">YOUR LOCATION <p id="demo"> </p>
                        </div>
                    </div>

                    <?= $form->field($model, 'latlng')->textInput(['maxlength' => true, 'readonly' => true])->label(false)->hiddenInput(); ?>


                    <!-- <div class="row">
                    <div class="col-xs-12 col-md-offset-4 col-md-4" style="background-color:#000000;color: white; padding:5px;">
                        <iframe width="355" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=116.12370461225511%2C6.0379523977715035%2C116.12818390130998%2C6.040406335163184&amp;layer=mapnik&amp;marker=6.039179367857246%2C116.12594425678253" style="border: 1px solid black"></iframe><br /><small><a href="https://www.openstreetmap.org/?mlat=6.03918&amp;mlon=116.12594#map=19/6.03918/116.12594">View Larger Map</a></small>

                    </div>
                </div> -->
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <?= Html::submitButton('<i class="fa fa-arrow-right"></i>&nbsp;Tamat Rondaan', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                        </div>
                    </div><?php ActiveForm::end(); ?>



                </font>
            <?php } else { ?>
                Maaf, maklumat tidak wujud.
            <?php } ?>

            <br>
        </div>
    </table>
</body>


<?php
$script = <<< JS
        
       $(document).ready(function () {
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

            document.getElementById("rekod-latlng").value = position.coords.latitude + ',' + position.coords.longitude;
        
            $("#zone").load('$url_zone', {
                latlng: position.coords.latitude + ',' + position.coords.longitude,
                id : $id,
            });
      
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
       
        var myVar = setInterval(function () {
            myTimer();
        }, 1000);

        function myTimer() {
            var d = new Date();
            document.getElementById("clock").innerHTML = d.toLocaleTimeString();
        }
                

    });

JS;
$this->registerJs($script, View::POS_END);
?>