<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\grid\GridView;
use app\models\hronline\Department;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\GredJawatan;
use yii\helpers\Url;
?>



<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian Kakitangan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                $form = ActiveForm::begin([
                            'action' => ['staff-all'],
                            'method' => 'get',
                            'options' => [
                                'data-pjax' => 1
                            ],
                ]);
                ?>

                <?= $form->field($searchModel, 'CONm')->textInput()->input('name', ['placeholder' => "Nama Kakitangan"])->label(false); ?>
                <?=
                $form->field($searchModel, 'gredJawatan')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(GredJawatan::find()->where(['isActive' => 1])->all(), 'id', 'fname'),
                    'options' => ['placeholder' => 'Gred & Jawatan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                <?=
                $form->field($searchModel, 'DeptId')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Department::find()->where(['isActive' => 1])->all(), 'id', 'fullname'),
                    'options' => ['placeholder' => 'J / F / P / I / B', 'class' => 'form-control col-md-5 col-xs-5'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>


                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::resetButton('<i class="fa fa-repeat"></i> Reset', ['class' => 'btn btn-default']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12"> 
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Kakitangan</strong></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="table-responsive">

                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                            'CONm',
                            'department.shortname',
                            'jawatan.gred',
                                [
                                'label' => 'Yearly Report',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::a('<i class="fa fa-line-chart"></i>', ['kehadiran/summary-by-year', 'icno' => $data->ICNO], ['class' => 'btn btn-primary btn-sm', 'target'=>'_blank']);
                                },
                            ],
                                [
                                'label' => 'Kesalahan',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::button('<i class="fa fa-list"></i>', ['value' => Url::to(['kehadiran/staff_history', 'icno'=>$data->ICNO]), 'class' => 'mapBtn btn btn-warning', 'id' => 'modalButton'] );
                                },
                            ],
                            [
                                'label' => 'Prestasi Warna Kad',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::a('<i class="fa fa-bar-chart"></i>', ['kehadiran/prestasi-warna-kad-staff', 'id' => $data->ICNO], ['class' => 'btn btn-success btn-sm', 'target'=>'_blank']);
                                },
                            ],
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
