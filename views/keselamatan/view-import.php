<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
use yii\helpers\Url;
// as a widget
?>


<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Periksa Nama Anggota</strong></h2>
            
            <ul class="nav navbar-right panel_toolbox collapse">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <?php
    Yii::$app->session->setFlash('info', 'Sila Pastikan Semua Nama Anggota adalah sama seperti dalam jadual.Sekiranya Tidak Sama sila Tekan Butang "Periksa Semula" dan Muat Naik Semula Setelah Membetulkan UMSPER Tersebut.');
    ?>
    <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>
        <div class="x_content">

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background-color: navy; color: white;">
                        <tr class="headings">
                            <th class="column-title">Bil </th>
                            <th class="column-title">UMSPER</th>
                            <th class="column-title">Nama</th>
                            <th class="column-title">Pos Kawalan</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $models) { ?>
                            <tr>
                                <td><?= $bil++; ?></td>
                                <td><?= $models->no_pekerja; ?></td>
                                <td><?= $models->name; ?></td>
                                <td><?= $models->pos; ?></td>


                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <td> <span style="font-weight:bold;"><h4><input type="checkbox"  id="checkbox1" class="default-input sale-text-req" onclick="checkTerms();"/> Tanda Saya Sekiranya Sudah Selesai Memeriksa Nama Anggota</h4></span></td>

                <?php if ($verifier) { ?>

                    <?= Html::a('Periksa Semula', ['/keselamatan/reupload','c'=>1], ['class'=>'btn btn-warning']) ?>

                    </label>
                <?php } else { ?>
                    <div id="temp1" style="display:show" >

                    <?= Html::a('Periksa Semula', ['/keselamatan/reupload','c'=>1], ['class'=>'btn btn-warning']) ?>
                    </div>

                    <div id="temp" style="display:none" >
                    <?= Html::a('Periksa Semula', ['/keselamatan/reupload','c'=>1], ['class'=>'btn btn-warning']) ?>

                 
                    <?= Html::a('Langkah Seterusnya', ['/keselamatan/reupload','c'=>2], ['class'=>'btn btn-primary']) ?>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
                function checkTerms() {
                  // Get the checkbox
                  var checkBox = document.getElementById("checkbox1");

                  // If the checkbox is checked, display the output text
                  if (checkBox.checked === true ){
                    //   alert(( "checkBox.checked" ).length);
                    // if(( "checkBox.checked" ).length > 2){

                        $("#temp").show();
                        $("#temp1").hide();

                    }


                    // document.getElementById("btn").disabled = false;
                  
                  if (checkBox.checked === false){
                        $("#temp").hide();
                        $("#temp1").show();

                    // document.getElementById("btn").disabled = false;
                  } 
                }
                    </script>
<?php
$script = <<< JS
       
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
JS;
$this->registerJs($script);
?>