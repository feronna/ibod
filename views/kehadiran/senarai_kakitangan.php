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



<!--<div class="col-md-12">
    <ol class="breadcrumb">
        <li><?= Html::a('<i class="fa fa-home"></i> Laman Utama', ['site/index']) ?></li>
        <li><?= Html::a('Tindakan Individu', ['site/index']) ?></li>
        <li><?= Html::a('Kehadiran', ['kehadiran/index']) ?></li>
        <li>Senarai Kakitangan Seliaan</li>
    </ol>
</div>-->





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
                            'action' => ['senarai_kakitangan'],
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
                <h2><strong>Senarai Kakitangan Seliaan</strong></h2>
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
                            'jawatan.fname',
                            'department.fullname',
                            [
                                'label' => 'WBB',
                                'format' => 'raw',
                                'value' => 'wbb_btn'
                            ],
                            [
                                'label' => 'Kehadiran',
                                'format' => 'raw',
                                'value' => 'attdn_btn'
                            ],
                            [
                                'label' => 'Wbb-List',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::a('<i class="fa fa-pencil"></i>', ['kehadiran/wbb-list', 'id' => $data->ICNO], ['class' => 'btn btn-default btn-sm', 'target'=>'_blank']);
                                },
                            ],
                            [
                                'label' => 'Peraku/Lulus',
                                'format' => 'raw',
                                'value' => function ($data) {
                                    return Html::a('<i class="fa fa-users"></i>', ['kehadiran/set-peg', 'id' => $data->ICNO], ['class' => 'btn btn-default btn-sm', 'target'=>'_blank']);
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