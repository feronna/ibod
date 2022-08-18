<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

error_reporting(0);

?>


<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_title">
        <h2><?= 'Kemaskini Senarai Penyakit' ?></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php //Html::a('Kembali', ['view'], ['class' => 'btn btn-primary']) 
        ?>
        <?= Html::button('Tambah', ['value' => Url::to(['keluarga/add-disease', 'id' => $FamilyId]), 'class' => 'showModalButton btn btn-success',]); ?>
        </br>
        <div class="table-responsive">

            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                    <tr class="headings">
                        <th>No. Kad Pengenalan</th>
                        <th>Nama Penyakit</th>
                        <th class="text-center">Tindakan</th>
                    </tr>
                </thead>
                <?php if ($disease) {

                    foreach ($disease as $disease) {

                ?>

                        <tr>
                            <td><?= $disease->FamilyId; ?></td>
                            <td><?= $disease->description; ?></td>
                            <td class="text-center"><?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-disease', 'id' => $disease->id], [
                                                        'data' => [
                                                            'confirm' => 'Anda ingin membuang rekod ini?',
                                                            'method' => 'post',
                                                        ],
                                                    ]) ?></td>
                        </tr>

                    <?php }
                } else {
                    ?>
                    <tr>
                        <td colspan="3" class="text-center">Tiada Rekod</td>
                    </tr>
                <?php
                } ?>
            </table>
        </div>
    </div>
</div>