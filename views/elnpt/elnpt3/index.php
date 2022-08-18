<?php
$str = 'Processing data, please wait &hellip;';
$str2 = '<div style="text-align: center;"><b>Error processing data. Please contact the System Administrator.</b></div>';

$js = <<< JS
var refrshk1_k2 = true;
var refrshk3_k4 = true;
var refrshk5 = true;
var refrshk6 = true;


$(document).ready(function (){
    $('#loader').hide();
    $('#refresh_k1_k2, #refresh_k3_k4, #refresh_k5, #refresh_k6, #refresh_k7').hide();

    $.ajax({
        url: "maklumat-guru?lppid="+$lpp->lpp_id,
        type: 'GET',
        beforeSend: function() { $('#loader').show(); },
        success: function (data) {
            if(data) {
                $('#loader').hide();
                $("#info_guru").html(data);
            } 
        },
        error: function(jqXHR, errMsg) {
            $('#loader').hide();
            $("#info_guru").html('$str2');
        }
     });
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    var target = $(e.target).attr("href") // activated tab
    //   alert(target);

    if(target != '#1'){
        $('#refresh_k1_k2, #refresh_k3_k4, #refresh_k5, #refresh_k6, #refresh_k7').show();
    }else{
        $('#refresh_k1_k2, #refresh_k3_k4, #refresh_k5, #refresh_k6, #refresh_k7').hide();
    }

    if(target == '#2'){
        $('#refresh_k1_k2').show();
        $('#refresh_k3_k4, #refresh_k5, #refresh_k6, #refresh_k7').hide();
        if(refrshk1_k2){
            $.ajax({
                url: "pengajaran-penyeliaan?lppid="+$lpp->lpp_id,
                type: 'GET',
                beforeSend: function() { $('#loader1').show(); },
                success: function (data) {
                    $('#loader1').hide();
                    $("#pengajaran_penyeliaan").html(data);
                },
                error: function(jqXHR, errMsg) {
                    $('#loader1').hide();
                    $("#pengajaran_penyeliaan").html('$str2');
                }
            });
        }
        refrshk1_k2 = false;
    }

    if(target == '#3'){
        $('#refresh_k3_k4').show();
        $('#refresh_k1_k2, #refresh_k5, #refresh_k6, #refresh_k7').hide();
        if(refresh_k3_k4){
            $.ajax({
                url: "penyelidikan-penerbitan?lppid="+$lpp->lpp_id,
                type: 'GET',
                beforeSend: function() { $('#loader2').show(); },
                success: function (data) {
                    $('#loader2').hide();
                    $("#penyelidikan_penerbitan").html(data);
                },
                error: function(jqXHR, errMsg) {
                    $('#loader2').hide();
                    $("#penyelidikan_penerbitan").html('$str2');
                }
            });
        }
        refresh_k3_k4 = false;
    }

    if(target == '#5'){
        $('#refresh_k5').show();
        $('#refresh_k1_k2, #refresh_k3_k4, #refresh_k6, #refresh_k7').hide();
        if(refrshk5){
            $.ajax({
                url: "perkhidmatan?lppid="+$lpp->lpp_id,
                type: 'GET',
                beforeSend: function() { $('#loader3').show(); },
                success: function (data) {
                    $('#loader3').hide();
                    $("#perkhidmatan").html(data);
                },
                error: function(jqXHR, errMsg) {
                    $('#loader3').hide();
                    $("#perkhidmatan").html('$str2');
                }
            });
        }
        refrshk5 = false;
    }

    if(target == '#6'){
        $('#refresh_k6').show();
        $('#refresh_k1_k2, #refresh_k3_k4, #refresh_k5, #refresh_k7').hide();
        if(refrshk6){
            $.ajax({
                url: "klinikal?lppid="+$lpp->lpp_id,
                type: 'GET',
                beforeSend: function() { $('#loader4').show(); },
                success: function (data) {
                    $('#loader4').hide();
                    $("#klinikal").html(data);
                },
                error: function(jqXHR, errMsg) {
                    $('#loader4').hide();
                    $("#klinikal").html('$str2');
                }
            });
        }
        refrshk6 = false;
    }

    if(target == '#7'){
        $('#refresh_k7').show();
        $('#refresh_k1_k2, #refresh_k3_k4, #refresh_k5, #refresh_k6').hide();
        $.ajax({
            url: "ringkasan-markah?lppid="+$lpp->lpp_id,
            type: 'GET',
            beforeSend: function() { $('#loader7').show(); },
            success: function (data) {
                $('#loader7').hide();
                $("#ringkasan").html(data);
            },
            error: function(jqXHR, errMsg) {
                $('#loader7').hide();
                $("#ringkasan").html('$str2');
            }
        });
    }

    if(target == '#8'){
        $('#refresh_k1_k2, #refresh_k3_k4, #refresh_k5, #refresh_k6, #refresh_k7').hide();
        // if(refrshk6){
            $.ajax({
                url: "sahsiah?lppid="+$lpp->lpp_id,
                type: 'GET',
                // beforeSend: function() { $('#loader4').show(); },
                success: function (data) {
                    // $('#loader4').hide();
                    $("#sahsiah").html(data);
                },
                error: function(jqXHR, errMsg) {
                    // $('#loader4').hide();
                    $("#sahsiah").html('$str2');
                }
            });
        // }
        // refrshk6 = false;
    }

    if(target == '#9'){
        $('#refresh_k1_k2, #refresh_k3_k4, #refresh_k5, #refresh_k6, #refresh_k7').hide();
        // if(refrshk6){
            $.ajax({
                url: "my-tickets?lppid="+$lpp->lpp_id,
                type: 'GET',
                // beforeSend: function() { $('#loader4').show(); },
                success: function (data) {
                    // $('#loader4').hide();
                    $("#tickets").html(data);
                },
                error: function(jqXHR, errMsg) {
                    // $('#loader4').hide();
                    $("#tickets").html('$str2');
                }
            });
        // }
        // refrshk6 = false;
    }
});

$("#refresh_k1_k2").click(function(){
    $.ajax({
        url: "pengajaran-penyeliaan?lppid="+$lpp->lpp_id,
        type: 'GET',
        beforeSend: function() { $('#loader1').show(); },
        success: function (data) {
            $('#loader1').hide();
            $("#pengajaran_penyeliaan").html(data);
            var btns = $("[data-toggle=\'popover-x\']"); 
            if (btns.length) 
                 btns.popoverButton(); 
        },
        error: function(jqXHR, errMsg) {
            $('#loader1').hide();
            $("#pengajaran_penyeliaan").html('$str2');
        }
     });
});

$("#refresh_k3_k4").click(function(){
    $.ajax({
        url: "penyelidikan-penerbitan?lppid="+$lpp->lpp_id,
        type: 'GET',
        beforeSend: function() { $('#loader2').show(); },
        success: function (data) {
            $('#loader2').hide();
            $("#penyelidikan_penerbitan").html(data);
        },
        error: function(jqXHR, errMsg) {
            $('#loader2').hide();
            $("#penyelidikan_penerbitan").html('$str2');
        }
     });
});

$("#refresh_k5").click(function(){
    $.ajax({
        url: "perkhidmatan?lppid="+$lpp->lpp_id,
        type: 'GET',
        beforeSend: function() { $('#loader3').show(); },
        success: function (data) {
            $('#loader3').hide();
            $("#perkhidmatan").html(data);
        },
        error: function(jqXHR, errMsg) {
            $('#loader3').hide();
            $("#perkhidmatan").html('$str2');
        }
     });
});

$("#refresh_k6").click(function(){
    $.ajax({
        url: "klinikal?lppid="+$lpp->lpp_id,
        type: 'GET',
        beforeSend: function() { $('#loader4').show(); },
        success: function (data) {
            $('#loader4').hide();
            $("#klinikal").html(data);
        },
        error: function(jqXHR, errMsg) {
            $('#loader4').hide();
            $("#klinikal").html('$str2');
        }
     });
});

$("#refresh_k7").click(function(){
    $.ajax({
        url: "ringkasan-markah?lppid="+$lpp->lpp_id,
        type: 'GET',
        beforeSend: function() { $('#loader7').show(); },
        success: function (data) {
            $('#loader7').hide();
            $("#ringkasan").html(data);
        },
        error: function(jqXHR, errMsg) {
            $('#loader7').hide();
            $("#ringkasan").html('$str2');
        }
     });
});
JS;
$this->registerJs($js);
?>

<?= $this->render('//elnpt/_menuUtama'); ?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><?= $lpp->guru->CONm ?> - 2022</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <?php
                    echo \yii\bootstrap\Alert::widget([
                        'options' => ['class' => 'alert-warning'],
                        'body' => '<font color="black">
                            <h4>
                            <strong>Perhatian</strong><br>
                            <ul>
                                <li>Markah yang dipaparkan adalah tertakluk kepada perubahan selepas proses verifikasi oleh PPP dan penilaian kualiti peribadi oleh PPP, PPK dan PEER.</li>
                                </ul>
                            </h4>
                        </font>',
                    ]);
                    ?>

                    <ul class="nav nav-tabs">
                        <li class='active' role="presentation"><a data-toggle="tab" href="#1">Maklumat Guru</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#9">Cadangan & Aduan <sup><span class="label label-success">Baru</span></sup></a></li>
                        <li role="presentation"><a data-toggle="tab" href="#2">Pengajaran & Penyeliaan</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#3">Penyelidikan & Penerbitan</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#5">Perkhidmatan</a></li>
                        <?php if ((strpos($lpp->gredGuru->gred, 'DU') !== false)) { ?>
                            <li role="presentation"><a data-toggle="tab" href="#6">Klinikal</a></li>
                        <?php } ?>
                        <li role="presentation"><a data-toggle="tab" href="#8">Sahsiah</a></li>
                        <li role="presentation"><a data-toggle="tab" href="#7">Ringkasan Markah</a></li>
                    </ul>

                    <div class="tab-content">
                        <p><?= \yii\helpers\Html::button('<span class="glyphicon glyphicon-refresh"></span>', ['id' => 'refresh_k1_k2', 'class' => 'btn btn-default btn-xs pull-right']) ?></p>
                        <p><?= \yii\helpers\Html::button('<span class="glyphicon glyphicon-refresh"></span>', ['id' => 'refresh_k3_k4', 'class' => 'btn btn-default btn-xs pull-right']) ?></p>
                        <p><?= \yii\helpers\Html::button('<span class="glyphicon glyphicon-refresh"></span>', ['id' => 'refresh_k5', 'class' => 'btn btn-default btn-xs pull-right']) ?></p>
                        <?php if ((strpos($lpp->gredGuru->gred, 'DU') !== false)) { ?>
                            <p><?= \yii\helpers\Html::button('<span class="glyphicon glyphicon-refresh"></span>', ['id' => 'refresh_k6', 'class' => 'btn btn-default btn-xs pull-right']) ?></p>
                        <?php } ?>
                        <p><?= \yii\helpers\Html::button('<span class="glyphicon glyphicon-refresh"></span>', ['id' => 'refresh_k7', 'class' => 'btn btn-default btn-xs pull-right']) ?></p>
                        <div class="clearfix"></div>

                        <div id="1" class="tab-pane fade in active">
                            <div id="loader" style="text-align: center;"><img src="<?= \yii\helpers\Url::to('@web/files/elnpt/pulse.gif') ?>" alt="Loading" /><br /><?= $str; ?></div>
                            <div id="info_guru" style="padding: 25px">
                            </div>
                        </div>
                        <div id="2" class="tab-pane fade in">
                            <div id="loader1" style="text-align: center;"><img src="<?= \yii\helpers\Url::to('@web/files/elnpt/pulse.gif') ?>" alt="Loading" /><br /><?= $str; ?></div>
                            <div id="pengajaran_penyeliaan" style="padding: 25px">
                            </div>
                        </div>
                        <div id="3" class="tab-pane fade in">
                            <div id="loader2" style="text-align: center;"><img src="<?= \yii\helpers\Url::to('@web/files/elnpt/pulse.gif') ?>" alt="Loading" /><br /><?= $str; ?></div>
                            <div id="penyelidikan_penerbitan" style="padding: 25px">
                            </div>
                        </div>
                        <div id="5" class="tab-pane fade in">
                            <div id="loader3" style="text-align: center;"><img src="<?= \yii\helpers\Url::to('@web/files/elnpt/pulse.gif') ?>" alt="Loading" /><br /><?= $str; ?></div>
                            <div id="perkhidmatan" style="padding: 25px">
                            </div>
                        </div>
                        <?php if ((strpos($lpp->gredGuru->gred, 'DU') !== false)) { ?>
                            <div id="6" class="tab-pane fade in">
                                <div id="loader4" style="text-align: center;"><img src="<?= \yii\helpers\Url::to('@web/files/elnpt/pulse.gif') ?>" alt="Loading" /><br /><?= $str; ?></div>
                                <div id="klinikal" style="padding: 25px">
                                </div>
                            </div>
                        <?php } ?>
                        <div id="7" class="tab-pane fade in">
                            <div id="loader7" style="text-align: center;"><img src="<?= \yii\helpers\Url::to('@web/files/elnpt/pulse.gif') ?>" alt="Loading" /><br /><?= $str; ?></div>
                            <div id="ringkasan" style="padding: 25px">
                            </div>
                        </div>
                        <div id="8" class="tab-pane fade in">
                            <div id="sahsiah" style="padding: 25px">
                            </div>
                        </div>
                        <div id="9" class="tab-pane fade in">
                            <div id="tickets" style="padding: 25px">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>