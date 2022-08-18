<?php

use yii\helpers\Html;
use app\models\keselamatan\TblWarnaKad;
use yii\bootstrap\ActiveForm;
use app\models\kehadiran\TblYears;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Warrant Lists</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th class="text-center">Bil</th>
                            <th class="text-center">Jawatan</th>
                            <th class="text-center">Grade</th>
                            <th class="text-center">Jumlah Waran</th>
                            <th class="text-center">Kategori</th>
                            <th class="text-center">Kumpulan Khidmat</th>
                            <th class="text-center">Tindakan</th>
                        </tr>
                        <?php if ($model) { ?>
                            <?php foreach ($model as $senarai) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:auto"><?php echo $bil++ ?></td>
                                    <td class="text-center" style="text-align:left"><?= $senarai->jawatan ?></td>
                                    <td class="text-center" style="text-align:left"><?= $senarai->gred ?></td>
                                    <td class="text-center" style="text-align:left"><?= $senarai->jumlah_waran ?></td>
                                    <td class="text-center" style="text-align:center"><?= $senarai->category ?></td>
                                    <td class="text-center" style="text-align:center"><?= $senarai->khidmat ?></td>
                                    <td class="text-center"><?= Html::a('<i class="fa fa-edit">', ["warrant/update-warrant", 'id' => $senarai->id], ['class' => '']); ?></td>

                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="7" class="align-center text-center"><i>Tiada Kakitangan Untuk Dipantau</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>