<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\View;

$this->title = 'Set Staf yang bertugas di PPV';
?>
<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-home"></i>&nbsp;<strong><?= Html::encode($this->title) ?></strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>
        <?= $form->errorSummary($model); ?>

        <div class="form-group">
            <label class="col-sm-3 control-label"><i class="fa fa-user"></i>&nbsp;Nama Kakitangan</label>

            <div class="col-md-6 col-sm-6 col-xs-6">
                <?=
                $form->field($model, 'icno')->label(false)->widget(Select2::class, [
                    'data' => ArrayHelper::map($dropdown_list_name, 'ICNO', 'CONm'),
                    'options' => ['placeholder' => '-- Select Staff --', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'multiple' => true,
                    ],
                ]);
                ?>
            </div>
        </div>


        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Kembali', ['kehadiran/wfh-by-mth', 'tahun' => date("Y", strtotime($date)), 'bulan' => date("m", strtotime($date))], ['class' => 'btn btn-danger']) ?>
                <?= Html::submitButton('<i class="fa fa-arrow-down"></i>&nbsp;Masukkan ke Senarai PPV', ['class' => 'btn btn-primary', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-list"></i>&nbsp;<strong>Senarai Bertugas di PPV pada <?= Yii::$app->formatter->asDate($date, 'php:d/m/Y') ?></strong></h2>

                <ul class="nav navbar-right panel_toolbox ">

                    <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>

                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="table-responsive">
                    <table class="table table-striped table-sm jambo_table table-bordered">
                        <thead>
                            <tr class="headings">
                                <th class="text-center">Select</th>
                                <th class="text-center">Bil</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jawatan</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <?php if ($today_wfh_list) { ?>
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'login-form-1',
                                'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons'],
                            ])
                            ?>
                            <?php foreach ($today_wfh_list as $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?= $form->field($v, 'id[]')->checkbox(['value' => $v->id, 'label' => '', 'class' => 'checkId']); ?></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                    <td><strong><?= $v->kakitangan->CONm ?></strong></td>
                                    <td><strong><?= $v->kakitangan->jawatan->fname ?></strong></td>
                                    <td class="text-center" style="text-align:center"><?= Html::a('<i class="fa fa-trash"></i>', ['kehadiran/ppv-remove-staff', 'id' => $v->id, 'date' => $date], [
                                                                                            'class' => 'btn btn-danger btn-sm',
                                                                                            'data' => [
                                                                                                'confirm' => 'Buang ?',
                                                                                                'method' => 'post',
                                                                                            ],
                                                                                        ]); ?></td>
                                </tr>
                            <?php } ?>
                            <button type="button" class="checkall btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Select All</button>
                            <?= Html::submitButton('<i class="fa fa-trash"></i>&nbsp;Delete', ['class' => 'btn btn-danger', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                            <?php ActiveForm::end() ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="5" class="align-center text-center"><i>No Record Found!</i></td>
                            </tr>
                        <?php } ?>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($ppv_tetap) { ?>
    <div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-list"></i>&nbsp;<strong>Sukarelawan Tetap bertugas di PPV</strong></h2>

                    <ul class="nav navbar-right panel_toolbox ">

                        <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm jambo_table table-bordered">
                            <thead>
                                <tr class="headings">
                                    <th class="text-center">Bil</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Jawatan</th>
                                </tr>
                            </thead>
                            <?php foreach ($ppv_tetap as $tetap) { ?>
                                <tr>
                                    <td><?php echo $bil2++; ?></td>
                                    <td><?php echo $tetap->kakitangan->CONm; ?></td>
                                    <td><?php echo $tetap->kakitangan->jawatan->fname; ?></td>
                                </tr>
                            <?php } ?>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php
$script = <<< JS
        
       $(document).ready(function () {
        
        var clicked = false;
        $(".checkall").on("click", function() {
          $(".checkId").prop("checked", !clicked);
          clicked = !clicked;
        });

    });

JS;
$this->registerJs($script, View::POS_END);
?>