<?php

$this->registerJs(
    '$(function(){
        $(".ReplyButton").click(function (){
            $("#modal").modal("show")
            .find("#modalContent")
            .load($(this).attr("value"));
        });
});'
);

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\elnpt\RefPnpKursus;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\bootstrap\Modal;

use igorvolnyi\widgets\modal\ModalAjaxMultiple;

switch ($model->tahun) {
    case 2020:
        $u = 'elnpt2/markah-tidak-setuju';
        break;
    case 2021:
        $u = 'elnpt2/markah-tidak-setuju';
        break;
    default:
        $u = 'elnpt/markah-tidak-setuju';
}

/* @var $this yii\web\View */
/* @var $model app\models\lnpt\TblTandatangan */
/* @var $form ActiveForm */
?>

<?php
//    Modal::begin([
////        'header' => 'Permohonan Rayuan Semakan Semula Markah Laporan Penilaian Prestasi Tahun '.$lpp->tahun.'',
//        'id' => 'modal',
//        'size' => 'modal-lg',
//    ]);
//    echo "<div id='createCompany'></div>";
//    Modal::end();
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">

            <div class="panel-body">

                <?php if (is_null($alasan)) { ?>
                    <p align="center">
                        Permohonan rayuan semakan semula markah LNPT bagi Tahun <?= $model->tahun ?> dibuka bermula 1 Mei <?= $model->tahun + 1 ?> sehingga 31 Mei <?= $model->tahun + 1 ?>.<br>
                        Permohonan hendaklah dikemukakan kepada Ketua Bahagian Sumber Manusia sebelum tamat tempoh rayuan.<br>
                        Sebarang permohonan rayuan selepas tempoh yang ditetapkan tidak akan dilayan.
                    </p>
                <?php } else { ?>
                    <p align="center">
                        Permohonan rayuan semakan semula anda telah berjaya dihantar.
                    </p>
                <?php } ?>

                <p align="center">
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Kembali</span></button>
                    <?=
                    is_null($alasan) ? Html::button('Mohon Semakan Semula', ['value' => Url::to([$u, 'lppid' => $model->lpp_id]), 'class' => 'btn btn-warning ReplyButton', 'id' => 'ReplyButton', 'title' => 'Reply'])
                        : '';
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>