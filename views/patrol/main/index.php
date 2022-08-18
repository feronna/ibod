<?php

use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\TblShiftKeselamatan;
use app\models\keselamatan\TblStaffKeselamatan;
use app\models\patrol\RefBit;
use app\models\patrol\RefRoute;
use app\models\patrol\Rekod;
use dosamigos\datepicker\DatePicker;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;


$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('/patrol/_menu') ?>

<?php // echo $this->render('_search', ['model' => $searchModel]);      
$today = Yii::$app->getRequest()->getQueryParam('date');

?>

<div class="col-md-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Rondaan <?= Rekod::staff(Yii::$app->getRequest()->getQueryParam('icno')).' ('. TblShiftKeselamatan::gred(Yii::$app->getRequest()->getQueryParam('icno')).')'?></strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped table-sm jambo_table table-bordered" style="text-align:center">
                <thead>
                    <tr class="headings">
                        <th class="column-title text-center">BIL </th>
                        <th class="column-title text-center">Pos Kawalan</th>
                        <th class="column-title text-center">Bit</th>
                        <th class="column-title text-center">Tarikh & Masa Rondaan</th>
                        <th class="column-title text-center">Status</th>
                        <th class="column-title text-center">Count</th>
                        <th class="column-title text-center">Location</th>
                
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $bil = 1;
                    if ($model) {
                        foreach ($model as $q) {
                    ?>
                            <tr>
                                <td><?= $bil++; ?></td>
                                <td class="column-title text-center"><?= $q->route->pos_kawalan ?></td>
                                <td class="column-title text-left"><?= $q->bit->bit_name ?></td>
                                <td class="column-title text-center"><?= $q->change ?></td>
                                <td class="column-title text-center"><?= $q->status ?></td>
                                <td class="column-title text-center"><?= $q->patrol_count ?></td>
                                <td class="column-title text-center"><?= Rekod::DisplayLoc($q->id) ?></td>

                            <?php
                        }
                    } else {
                            ?>
                            <td colspan="5"><?= 'Tiada Rekod Ditemui' ?></td>

                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>