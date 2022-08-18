<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
use app\widgets\TopMenuWidget;
use app\models\keselamatan\RefUnit;
use app\models\hronline\Campus;
?>

<?= $this->render('/patrol/_menu') ?>


<div class="col-md-12"> 
    <div class="x_panel" >
        <div class="x_title">
            <h2><strong>Tambah DO/Pegawai</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Name<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?=
                    $form->field($adminbaru, 'icno')->label(false)->widget(Select2::classname(), [
                        'data' => $allBiodata,
                        'options' => ['placeholder' => 'Sila pilih nama', 'default' => 0],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>

                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Access Level<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($adminbaru, 'akses_level')->label(false)->widget(Select2::classname(), [
                        'data' => ['2' => 'Penyelia Unit/DO', '3' => 'Pegawai'],
                        'options' => ['placeholder' => 'Pilih Akses', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Dipersetujui"){
                        $("#tempoh").show();
                        }
                        else{
                        $("#tempoh").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id">Campus<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <?=
                    $form->field($adminbaru, 'campus_id')->label(false)->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Campus::find()->all(), 'campus_id', 'campus_name'),
                        'options' => ['placeholder' => 'Pilih Kampus', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:if ($(this).val() == "Dipersetujui"){
                        $("#tempoh").show();
                        }
                        else{
                        $("#tempoh").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>

            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Admin</strong></h2>
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
                        <th class="column-title text-center">NAME</th>
                        <th class="column-title text-center">ACCESS LEVEL</th>
                        <th class="column-title text-center">STATUS</th>
                        <th class="column-title text-center">KAMPUS</th>
                        <th class="column-title text-center">Role</th>
                        <th class="column-title text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $bil = 1;
                    if ($admin) {
                        foreach ($admin as $admins) {
                            ?>
                            <tr>
                                <td><?= $bil++; ?></td>
                                <td><?= $admins->kakitangan->CONm .' ( '.$admins->displaydepartment .' )' ; ?></td>
                                <td><?= $admins->accesslevel; ?></td>
                                <td><?= $admins->status; ?></td>
                                <td><?= $admins->campus->campus_name; ?></td>
                                <td><?= $admins->role; ?></td>

                                <td>
                                    <?=
                                    Html::a('<i class="fa fa-trash-o"></i>', ['deleted', 'id' => $admins->id], [
                                        'data' => [
                                            'confirm' => 'Anda Pasti untuk membuang data ini?',
                                            'method' => 'post',
                                        ],
                                    ])
                                    ?>
                                    |
                                    <?=
                                    Html::a('<i class="fa fa-pencil"></i>', ['update-akses', 'id' => $admins->id], [
//                                        'data' => [
//                                            'confirm' => 'Are you sure you want to delete this item?',
//                                            'method' => 'post',
//                                        ],
                                    ])
                                    ?>
                                </td>
                                <?php
                            }
                        }
                        ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


