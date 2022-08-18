<?php

use app\models\cuti\CutiLog;
use app\models\cuti\JenisCuti;
use app\models\cuti\TblRecords;
use yii\helpers\Html;
use app\models\keselamatan\TblRekod;
use yii\helpers\Url;
use app\widgets\TopMenuWidget;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong> Senarai Cuti Tahunan / <i> Leave List by Year</i></strong></h2>

                <div class="clearfix"></div>
            </div>
            <div style="text-align:left; float:right; width:5%;">
                <a href="<?= Url::to(['cuti/supervisor/set-leave', 'id' => $id]); ?>" class="fa fa-calendar-check-o"></a>
                <a href="<?= Url::to(['cuti/supervisor/leave-list-sv', 'id' => $id]); ?>" class="fa fa-calendar-plus-o"></a>
                <a href="<?= Url::to(['cuti/supervisor/leave-statement', 'id' => $id]); ?>" class="fa fa-file"></a>
            </div>
            <?php echo Yii::$app->controller->renderPartial('_staff_details', ['biodata' => $biodata,]); ?>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><strong>Carian / <i>Searching</i></strong></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <?php
                            $form = ActiveForm::begin([
                                'action' => ['leave-list-sv', 'id' => $id],
                                'method' => 'get',
                                'options' => [
                                    'data-pjax' => 1
                                ],
                            ]);
                            ?>



                            <div class="form-group">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <?=
                                    $form->field($searchModel, 'jenis_cuti_id')->label(false)->widget(Select2::classname(), [
                                        'data' => ArrayHelper::map(JenisCuti::find()->where(['jenis_cuti_papar' => [1, 2]])->all(), 'jenis_cuti_id', 'jenis_cuti_catatan'),
                                        'options' => ['placeholder' => 'Choose leave type', 'class' => 'form-control col-md-7 col-xs-12'],
                                        'pluginOptions' => [
                                            'allowClear' => true
                                        ],
                                    ]);
                                    ?>
                                </div>
                            </div>


                            <div class="form-group">

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php
                                    echo $form->field($searchModel, 'carian_status')->dropDownList(
                                        ['ENTRY' => 'ENTRY', 'AGREED' => 'AGREED', 'CHECKED' => 'CHECKED', 'VERIFIED' => 'VERIFIED', 'APPROVED' => 'APPROVED', 'REJECTED' => 'REJECTED', 'RETURNED' => 'RETURNED'],
                                        ['prompt' => 'CHOOSE STATUS...']
                                        // ENTRY,AGREED,CHECKED,VERIFIED,APPROVED,REJECTED,RETURNED
                                    )->label(false);
                                    ?>
                                </div>

                            </div>
                            <div class="form-group">

                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <?php

                                    echo $form->field($searchModel, 'carian_tahun')->dropDownList(
                                        $data,
                                        ['prompt' => 'Choose Year...']
                                        // ENTRY,AGREED,CHECKED,VERIFIED,APPROVED,REJECTED,RETURNED
                                    )->label(false);
                                    ?>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                                    <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
                                </div>
                            </div>

                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>


            <div class="clearfix">
                <span class="badge" style="background-color :pink; font-size: 100%"><u><?= Html::a('[Permohonan Cuti Manual/Manual Leave Application]', ["cuti/supervisor/manual-leave-application", 'id' =>  $id]) ?>
                    </u></span>
                <?php if ($admin) { ?>

                    <span class="badge" style="float:right;background-color :pink; font-size: 100%"><u><?= Html::a('[Manual Leave Application (Admin Only, Still in Development)]', ["cuti/supervisor/creates", 'id' =>  $id]) ?>
                        </u></span>
                <?php } ?>

                <table class="table table-bordered table-condensed table-striped table-sm jambo_table">
                    <thead>
                        <!-- <tr class="headings"> -->
                        <!-- <th class="column-title text-center">ID</th> -->
                        <th class="column-title text-center">LEAVE TYPE</th>
                        <th class="column-title text-center">START</th>
                        <th class="column-title text-center">END</th>
                        <th class="column-title text-center">DURATION</th>
                        <th class="column-title text-center">STATUS</th>
                        <th class="column-title text-center">FILE</th>
                        <!-- <th class="column-title text-center">VERIFIER</th> -->
                        <th class="column-title text-center">ACTION</th>
                        <th class="column-title text-center">CANCEL</th>
                        <!-- <th class="column-title text-center">INSERT BY</th> -->
                        <!-- </tr> -->
                    </thead>
                    <?php
                    // if (!empty($data)) {

                    foreach ($model->getModels() as $data) {

                    ?>
                        <tr>
                            <!-- <td class="text-center"><?= $data->id ?></td> -->
                            <td class="text-center"><?= $data->jenisCuti->jenis_cuti_nama ?></td>
                            <td class="text-center"><?= $data->start_date ?></td>
                            <td class="text-center"><?= $data->end_date ?></td>
                            <td class="text-center"><?= $data->tempoh ?></td>
                            <td class="text-center"><?= $data->status ?></td>
                            <td class="text-center"><?= $data->displayLinks ?></td>
                            <td class="text-center"> <?= Html::button('<i class="fa fa-search"></i>  ', ['value' => Url::to(['cuti/supervisor/leave-details', 'id' => $data->id]), 'class' => 'mapBtn']); ?>
                                | <?= Html::a('', ["cuti/supervisor/update-staff-leave", 'id' =>  $data->id], ['class' => 'fa fa-pencil']) ?> | <?= Html::a('', ["cuti/supervisor/print-leave", 'id' =>  $data->id], ['class' => 'fa fa-print']) ?> </td>
                            <td class="text-center"> <span class="badge" style="background-color :pink"><u>
                                        <?= Html::a(
                                            'Cancel',
                                            ["cuti/supervisor/cancel-leave", 'id' =>  $data->id],
                                            ['class' => 'text', 'data' => ['confirm' => 'Are You Sure To Cancel This Data?']]
                                        ) ?> </u></span>
                            </td>

                        </tr>
                    <?php } ?>
                    <?php if($indi == 1){ ?>
                    <tr class="text-center">
                        <td colspan="3">Total </td>
                        <td><?= TblRecords::getSum($id,Yii::$app->request->queryParams['TblRecordsSearch']["carian_tahun"],  Yii::$app->request->queryParams['TblRecordsSearch']["jenis_cuti_id"]) ?> </td>
                        <td colspan="3"> <?= Html::a(' Print Me (Screen Capture) ', ["cuti/supervisor/print-capture", 'id' => $id,'type' => Yii::$app->request->queryParams['TblRecordsSearch']["jenis_cuti_id"]], ['class' => 'fa fa-print']) ?></td>

                    </tr>
                    <?php } ?>


                </table>
            </div>
        </div>
    </div>
</div>