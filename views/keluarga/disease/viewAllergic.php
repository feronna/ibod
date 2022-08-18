<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;

error_reporting(0);

?>


<div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="x_content">

        </br>
        <div class="x_title">
            <?= Html::button('Tambah', ['value' => Url::to(['keluarga/add-allergic', 'id' => $new_disease->FamilyId]), 'class' => 'showModalButton btn btn-success',]); ?>
            <div class="clearfix"></div>
        </div>
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
                            <td class="text-center"><?= Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['edit-allergic', 'id' => $allergic->FamilyId], ['target' => '_blank']) ?></td>
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