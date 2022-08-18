<?php

use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblShiftKeselamatan;
use app\models\keselamatan\TblStaffKeselamatan;
use app\models\patrol\RefBit;
use app\models\patrol\RefRoute;
use app\models\patrol\Rekod;
use app\models\patrol\TblExcused;
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

<?php // echo $this->render('_search', ['model' => $searchModel]);      
if (Yii::$app->getRequest()->getQueryParam('date') == NULL) {
    $today = date('Y-m-d');
} else {
    $today = Yii::$app->getRequest()->getQueryParam('date');
}
?>
<?= $this->render('/patrol/_menu') ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Search</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= Html::beginForm(['indexs'], 'GET'); ?>


                <div class="col-xs-12 col-md-6 col-lg-6">


                    <?php echo  Select2::widget([
                        // 'model' => $pos,
                        'name' => 'pos',
                        'data' => $data,
                        'options' => ['placeholder' => 'Pos Kawalan ...'],
                        'pluginOptions' => [
                            'allowClear' => false
                        ],
                    ]); ?>
                </div>
                <div class="col-xs-12 col-md-5 col-lg-3">
                    <?=
                    DatePicker::widget([
                        'name' => 'date',
                        'value' => $today,
                        'template' => '{input}{addon}',
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                        ],
                        'options' => ['readonly' => 'readonly'],
                    ]);
                    ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
                </div>

                <?= Html::endForm(); ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Peronda <?= RefPosKawalan::namapos($pos) ?>(<?php echo $today ? $today : date('Y-m-d') ?>)</strong></h2>
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
                            <th class="column-title text-left">Peronda</th>
                            <th class="column-title text-center">Status cuti</th>
                            <th class="column-title text-center">Syif</th>
                            <th class="column-title text-center">Jumlah Rondaan</th>
                            <th class="column-title text-center">Maklumat Rondaan</th>
                            <th class="column-title text-center">Catatan</th>
                            <th class="column-title text-center">Kebenaran Kepada anggota untuk Tidak Meronda (DO)</th>
                            <th class="column-title text-center">Tukar Pos Bertugas</th>
                            <!-- <th class="column-title text-center">KAMPUS</th>
                        <th class="column-title text-center">ACTIONS</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $bil = 1;
                        if ($query) {
                            foreach ($query as $admins) {
                        ?>
                                <tr>
                                    <td class="column-title text-left"><?= TblShiftKeselamatan::name($admins['icno']) . ' ( ' . TblShiftKeselamatan::gred($admins['icno']) . ' )'; ?></td>
                                    <td><?= TblRekod::DisplayCuti($admins['icno'], $today); ?></td>
                                    <td><?= TblShiftKeselamatan::syif($admins['shift_id']); ?></td>

                                    <td><?= Rekod::pcount($admins['icno'], $admins['pos_kawalan_id'], $admins['tarikh'], 1) . ' / ' .
                                            RefBit::countBit($admins['pos_kawalan_id']) ?>
                                    </td>
                                    <td> <?php
                                            echo Html::a('<i class="fa fa-eye"></i>', ['patrol/main/bit-report', 'id' => $admins['icno'], 'shift' => $admins['shift_id'], 'pos' => $admins['pos_kawalan_id'], 'date' => $admins['tarikh']]);
                                            ?></td>
                                    <td> <?= TblExcused::remark($admins['icno'], $admins['tarikh'], $admins['pos_kawalan_id'], $admins['shift_id']) ? TblExcused::remark($admins['icno'], $admins['tarikh'], $admins['pos_kawalan_id'], $admins['shift_id']) :
                                                ""
                                            ?></td>
                                    <td> <?= TblExcused::remarkdo($admins['icno'], $admins['tarikh'], $admins['pos_kawalan_id'], $admins['shift_id']) ? TblExcused::remarkdo($admins['icno'], $admins['tarikh'], $admins['pos_kawalan_id'], $admins['shift_id']) :
                                                Html::a('<i class="fa fa-edit"></i>', ['patrol/main/do-report', 'id' => $admins['icno'], 'shift' => $admins['shift_id'], 'pos' => $admins['pos_kawalan_id'], 'date' => $admins['tarikh']])
                                            ?></td>
                                    <td> <?php
                                            echo Html::a('<i class="fa fa-exchange"></i>', ['patrol/admin/exchange', 'icno' => $admins['icno'],'date'=>$admins['tarikh'],'pos'=>$pos,'shift'=>$admins['shift_id']]);
                                            ?></td>

                            <?php
                            }
                        }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>