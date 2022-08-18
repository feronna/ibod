<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

error_reporting(0);

?>


<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_title">
        <h2><?= 'Kemaskini Senarai Alahan' ?></h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <?php //Html::a('Kembali', ['view'], ['class' => 'btn btn-primary']) 
        ?>
        <?= Html::button('Tambah', ['value' => Url::to(['keluarga/add-allergic', 'id' => $FamilyId]), 'class' => 'showModalButton btn btn-success',]); ?>
        </br>
        <div class="table-responsive">

            <table class="table table-sm table-bordered jambo_table table-striped">
                <thead>
                    <tr class="headings">
                        <th>No. Kad Pengenalan</th>
                        <th>Nama Alahan</th>
                        <th class="text-center">Tindakan</th>
                    </tr>
                </thead>
                <?php if ($allergic) {

                    foreach ($allergic as $allergic) {

                ?>

                        <tr>
                            <td><?= $allergic->FamilyId; ?></td>
                            <td><?= $allergic->description; ?></td>
                            <td class="text-center"><?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete-disease', 'id' => $allergic->id], [
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