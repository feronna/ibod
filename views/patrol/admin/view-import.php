<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
use app\models\keselamatan\RefPosKawalan;
use app\models\patrol\RefBit;
use yii\helpers\Url;
// as a widget
?>


<div class="col-md-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Bit Yang Akan Dimuat Naik</strong></h2>

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
                            <th class="column-title">Pos Kawalan </th>
                            <th class="column-title">Nama Bit</th>
                            <th class="column-title">Kedudukan Bit</th>
                            <th class="column-title">Latitude</th>
                            <th class="column-title">Longitude</th>
                            <th class="column-title">Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $models) { ?>
                            <tr>
                                <td><?= $bil++; ?></td>
                                <td><?= RefPosKawalan::namapos($models->pos) ?></td>
                                <td><?= $models->name; ?></td>
                                <td><?= $models->pos; ?></td>
                                <td><?= $models->lat; ?></td>
                                <td><?= $models->lng; ?></td>
                                <td><?= $models->status; ?></td>


                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
            <?= Html::a('Submit', [
                'patrol/admin/upload', 'id' => $id, 'route' => Yii::$app->getRequest()->getQueryParam('ids')
            ], ['class' => 'btn btn-primary', 'style' => "float: right"]) ?>

        </div>
    </div>
</div>
<script>
    function checkTerms() {
        // Get the checkbox
        var checkBox = document.getElementById("checkbox1");

        // If the checkbox is checked, display the output text
        if (checkBox.checked === true) {
            //   alert(( "checkBox.checked" ).length);
            // if(( "checkBox.checked" ).length > 2){

            $("#temp").show();
            $("#temp1").hide();

        }


        // document.getElementById("btn").disabled = false;

        if (checkBox.checked === false) {
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