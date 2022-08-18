
<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Waktu Bekerja Berperingkat</strong><small><?= $biodata->CONm . ' (' . $biodata->COOldID . ')' ?></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">
                    <table class="table table-striped jambo_table table-sm" style="font-size: 12px">
                        <thead>
                            <tr class="headings">
                                <th class="column-title text-center">BIL </th>
                                <!--<th class="column-title text-center">TARIKH PERMOHONAN</th>-->
                                <th class="column-title text-center">WAKTU PILIHAN </th>
                                <th class="column-title text-center">TARIKH MULA </th>
                                <th class="column-title text-center">TARIKH TAMAT </th>
                                <th class="column-title text-center">STATUS </th>
                                <th class="column-title text-center">UPDATE </th>
                                <th class="column-title text-center">DELETE </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($model_wp) { ?>
                                <?php foreach ($model_wp as $wp) { ?>
                                    <tr>
                                        <td class="text-center"><?= $bil++; ?></td>
                                        <!--<td class="text-center"><?= $wp->tarikhMohon; ?></td>-->
                                        <td class="text-center"><?= $wp->wp->jenis_wp; ?></td>
                                        <td class="text-center"><?= $wp->tarikhMula; ?></td>
                                        <td class="text-center"><?= $wp->tarikhTamat; ?></td>
                                        <td class="text-center"><?= $wp->statusLabel; ?></td>
                                        <td class="text-center"><?= Html::a('<i class="fa fa-pencil"></i>', ['kehadiran/wbb-list', 'id' => $id, 'wp_id'=>$wp->id], ['class' => '']) ?></td>
                                        <td class="text-center"><?=
                                            Html::a('<i class="fa fa-trash"></i>', ['kehadiran/del-wbb', 'id' => $wp->id], [
                                                'class' => '',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this item?',
                                                    'method' => 'post',
                                                ],
                                            ])
                                            ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td class="text-center" colspan="7"><i>Tidak ada sebarang WBB setakat ini.</i></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>




            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><?php echo $model->isNewRecord ? 'Tambah WBB' : 'Kemaskini WBB' ?></strong><small><?= $biodata->CONm . ' (' . $biodata->COOldID . ')' ?></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Tambah WBB baru <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <?=
                        $form->field($model, 'wp_id')->label(false)->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(RefWp::find()->where(['status'=>1])->all(), 'id', 'detail'),
                            'options' => ['placeholder' => 'Pilih WP', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]);
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Tarikh Mula <span class="required">*</span>
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">

                        <?=
                        $form->field($model, 'start_date')->label(false)->widget(
                                DatePicker::className(), [
                            'template' => '{input}{addon}',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd/mm/yyyy'
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wp_id">Tarikh Tamat 
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">

                        <?=
                        $form->field($model, 'end_date')->label(false)->widget(
                                DatePicker::className(), [
                            'template' => '{input}{addon}',
                            'clientOptions' => [
                                'autoclose' => true,
                                'format' => 'dd/mm/yyyy'
                            ]
                        ]);
                        ?>
                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;KEMBALI', ['kehadiran/staff-wbb'], ['class' => 'btn btn-primary']) ?>
                        <?= Html::submitButton($model->isNewRecord ? 'Tambah WBB' : 'Kemaskini WBB', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>