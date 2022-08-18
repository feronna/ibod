<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use yii\web\View;
?>
<?= Yii::$app->controller->renderPartial('/survey/_menu'); ?>


<div class="x_panel">
    <div class="x_title">
        <h2><i class="fa fa-search"></i>&nbsp;<strong>Carian</strong></h2>
        <ul class="nav navbar-right panel_toolbox ">
            <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?= Html::beginForm(['senarai-pengundi', 'id' => $id], 'GET', ['class' => 'form-horizontal form-label-left disable-submit-buttons']); ?>

        <div class="form-group">
            <label class="col-sm-3 control-label">JFPIB</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <?php
                echo Select2::widget([
                    'name' => 'dept_id',
                    'data' => $department,
                    'value' => $dept_id,
                    'options' => [
                        'placeholder' => 'Select JFPIB',
                        'multiple' => false,
                    ],
                ]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Name</label>

            <div class="col-md-6 col-sm-6 col-xs-6">
                <?= Html::input('text', 'name', $name, ['class' => 'form-control']) ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Program Pengajaran</label>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <?php
                echo Select2::widget([
                    'name' => 'program',
                    'data' => $programPengajaran,
                    'value' => $program,
                    'options' => [
                        'placeholder' => 'Pilih Program Pengajaran',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
        </div>


        <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
                <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']); ?>
            </div>
        </div>

        <?= Html::endForm(); ?>



        <hr>
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Sebelumnya', ['update-aktiviti', 'id' => $id], ['class' => 'btn btn-warning']) ?>
            <?= Html::a('Seterusnya&nbsp;<i class="fa fa-arrow-right"></i>', ['overview', 'id' => $id], ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-xs-6 col-md-6 col-lg-6">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-users"></i>&nbsp;<strong>Senarai Kakitangan : <?= count($kakitangan) ?></strong></h2>
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
                            </tr>
                        </thead>
                        <?php if ($kakitangan) { ?>
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'login-form-1',
                                'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons'],
                            ])
                            ?>
                            <?php foreach ($kakitangan as $staf) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?= $form->field($staf, 'ICNO[]')->checkbox(['value' => $staf->ICNO, 'label' => '', 'class' => 'checkIcno']); ?></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $bil++ ?></strong></td>
                                    <td><strong><?= $staf->displayTitleName ?></strong></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $staf->jawatan->fname ?></strong></td>
                                </tr>
                            <?php } ?>
                            <button type="button" class="checkAllKakitangan btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Select All</button>
                            <?= Html::submitButton('Masukkan ke senarai Pengundi&nbsp;<i class="fa fa-arrow-right"></i>', ['class' => 'btn btn-primary pull-right', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                            <?php ActiveForm::end() ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="4" class="align-center text-center"><i>No Record Found!</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-6 col-md-6 col-lg-6">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-user"></i>&nbsp;<strong><?= $this->title ?> : <?= count($senarai_calon) ?></strong></h2>
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
                            </tr>
                        </thead>
                        <?php if ($senarai_calon) { ?>
                            <?php
                            $form = ActiveForm::begin([
                                'id' => 'login-form-1',
                                'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons'],
                            ])
                            ?>
                            <?php foreach ($senarai_calon as $v) { ?>
                                <tr>
                                    <td class="text-center" style="text-align:center"><?= $form->field($v, 'id[]')->checkbox(['value' => $v->id, 'label' => '', 'class' => 'checkId']); ?></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $bil_calon++ ?></strong></td>
                                    <td><strong><?= $v->kakitangan->displayTitleName ?></strong></td>
                                    <td class="text-center" style="text-align:center"><strong><?= $v->kakitangan->jawatan->fname ?></strong></td>
                                </tr>
                            <?php } ?>
                            <button type="button" class="checkall btn btn-warning"><i class="fa fa-edit"></i>&nbsp;Select All</button>
                            <?= Html::submitButton('<i class="fa fa-trash"></i>&nbsp;Buang Calon', ['class' => 'btn btn-danger pull-right', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                            <?php ActiveForm::end() ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="4" class="align-center text-center"><i>No Record Found!</i></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
        
       $(document).ready(function () {
        
        var clicked = false;
        $(".checkAllKakitangan").on("click", function() {
          $(".checkIcno").prop("checked", !clicked);
          clicked = !clicked;
        });

        var clicked2 = false;
        $(".checkall").on("click", function() {
          $(".checkId").prop("checked", !clicked2);
          clicked2 = !clicked2;
        });

    });

JS;
$this->registerJs($script, View::POS_END);
?>