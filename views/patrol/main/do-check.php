<?php

use app\models\hronline\Tblprcobiodata;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\TblRekod;
use app\models\keselamatan\TblShiftKeselamatan;
use app\models\keselamatan\TblStaffKeselamatan;
use app\models\patrol\PatrolReportDo;
use app\models\patrol\PatrolTblReport;
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
                <h2><strong>Carian Mengikut Syif</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="collapse-link"><i class="fa fa fa-wrench"></i></a></li>

                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?= Html::beginForm(['do-check-index'], 'GET'); ?>


                <div class="col-xs-12 col-md-6 col-lg-6">


                    <?php echo  Select2::widget([
                        // 'model' => $pos,
                        'name' => 'syif',
                        'data' => ['3' => 'Syif A', '5' => 'Syif B', '4' => 'Syif C'],
                        'options' => ['placeholder' => 'Syif ...'],
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
                            <th class="column-title text-center">Pos Kawalan</th>
                            <th class="column-title text-center">Jumlah Rondaan</th>
                            <th class="column-title text-center">Pengesahan Anggota</th>

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
                                    <td class="column-title text-center"><?= RefPosKawalan::namapos($admins['pos_kawalan_id']); ?></td>

                                    <td><?=  Rekod::countpatrol($admins['icno'], $today,$admins['shift_id']) ?> / <?= RefBit::patroltotal($admins['pos_kawalan_id'],$admins['shift_id'] ,$admins['icno'],$today) ?>
                                    </td>
                                    <td class="text-center"><?= PatrolTblReport::getreport($admins['icno'], $admins['pos_kawalan_id'], $admins['shift_id'], $admins['tarikh']) ?></td>


                            <?php
                            }
                        }
                            ?>

                    </tbody>

                </table>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

                <div class="form-group">
                    <h6><strong></i> Ulasan Penyelia Bertugas : </strong></h6>

                    <?= $form->field($do, 'remark_do')->textarea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>

                <div class="form-group" style="text-align:left; float:left;">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?= Html::submitButton('<i class="fa fa-floppy-o"></i>&nbsp;Hantar', ['class' => 'btn btn-success', 'data' => ['disabled-text' => 'Please Wait.. ']]) ?>
                        
                    </div>
                </div>

                <?php ActiveForm::end(); ?>


                <div class="x_content">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm jambo_table table-bordered">
                                <thead>
                                    <tr class="headings">
                                        <th class="text-center">Ulasan</th>
                                        <th class="text-center">Kemaskini</th>

                                    </tr>
                                </thead>
                                <?php foreach ($ulasan as $k) { ?>
                                    <tr>
                                        <td class="text-center" style="text-align:left"><?= $k->remark_do ?></td>
                                        <td class="text-center" style="text-align:center"><?= Html::button('', ['value' => Url::to([
									'/patrol/main/update-remark-do', 'syif' => $syif,
									'date' => $today
								]), 'class' => 'fa fa-edit mapBtn ', 'id' => 'modalButton']);?></td>

                                    </tr>
                                <?php } ?>


                            </table>
                        </div>
                    </div>

                <div class="form-group">

                    <div class="div1" style="text-align:left; float:right; width:40%;">

                        <input style="text-align:center;" type="text" class="form-control" value="<?php echo PatrolReportDo::namado(Yii::$app->getRequest()->getQueryParam('syif'),$today,$campus) ?>" disabled="">

                        <label style="text-align:center;" class="control-label col-md-6 col-sm-6 col-xs-12">

                            <?= PatrolReportDo::namado(Yii::$app->getRequest()->getQueryParam('syif'),$today,$campus) ? "" : Html::a('Klik Untuk Hantar Laporan', [
                                '/patrol/main/send-to-verify', 'syif' => Yii::$app->getRequest()->getQueryParam('syif'), 'date' => $today
                            ], [
                                'name' => 'verify', 'class' => 'text',
                                'data' => ['confirm' => 'Hantar Laporan Ke Pegawai Medan ??']
                            ]); ?></label>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>