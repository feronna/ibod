<?php

//use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\esticker\TblStickerStaf */
/* @var $form yii\widgets\ActiveForm */
$this->title = "Patrolling History";
?>
<?= $this->render('/patrol/_menu') ?>

<div class="x_panel">
<div class="x_title">
        <h2><i class="fa fa-plane"></i>&nbsp;<strong>(<?= $this->title ?>)</strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="table-responsive">

            <table class="table table-bordered table-info table-condensed table-hover table-striped jambo_table">
                <thead>
                    <tr class="headings">
                        <th>Bil</th>
                        <th class="text-center">Peronda</th>
                        <th class="text-center">Pos Kawalan</th>
                        <th class="text-center">Bit</th>
                        <th class="text-center">Tarikh Dan Masa</th>
                        <th class="text-center">Count</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($record as $rows) { ?>
                        <tr>
                            <td class="text-center"><?= $bil++ ?></td>
                            <td class="text-center"><?= $rows->peronda->CONm ?></td>
                            <td class="text-center"><?= $rows->route->pos_kawalan ?></td>
                            <td class="text-center"><?= $rows->bit != NULL ? $rows->bit->bit_name : "" ?></td>
                            <td class="text-center"><?= $rows->change ?></td>
                            <td class="text-center"><?= $rows->patrol_count ?></td>
                            <td class="text-center"><?= $rows->status ?></td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>