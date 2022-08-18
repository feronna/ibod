<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Department;
use app\models\Pergigian\Klinik;

error_reporting(0);

/* @var $this yii\web\View */
/* @var $searchModel app\models\Pergigian\KlinikSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [1261, 1264, 1291], 'vars' => []]); ?>
<div class="pergigian-create">

    <div class="x_panel">
        <div class="table-responsive">
            <div class="x_title">
                <h2><i class="fa fa-list"></i><strong> Senarai Rekod Tuntutan</strong></h2>
                <ul class="nav navbar-right panel_toolbox">

                </ul>
                <div class="clearfix"></div>
            </div>

            <?php $form = ActiveForm::begin([
                'action' => ['rekod-tuntutan'],
                'method' => 'get',
                'options' => ['class' => 'form-horizontal form-label-left']
            ]); ?>

            <div class="col-md-5 col-sm-3 col-xs-6">
                <?=
                $form->field($searchModel, 'name')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\hronline\Tblprcobiodata::find()->where(['IN', 'statLantikan', [1, 3]])->all(), 'CONm', 'CONm'),
                    'options' => ['placeholder' => 'Nama Kakitangan'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <?= $form->field($searchModel, 'icno')->textInput(['placeholder' => 'Carian No.KP Kakitangan'])->label(false); ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Cari', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>


            <h1><?= Html::encode($this->title) ?></h1>

            <?= GridView::widget([

                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'kakitangan.CONm',
                    [
                        'label' => 'No. KP',
                        'attribute' => 'icno',
                        'format' => 'text',
                    ],

                    [
                        'label' => 'JAFPIB',
                        'attribute' => 'department.fullname',
                        'format' => 'text',
                    ],
                    [
                        'label' => 'Klinik Pergigian/Kedai Kacamata',
                        'value' => function ($model) {
                            if ($model->jenis_tuntutan_id == 1) {
                                $info = $model->klinik->klinik_nama;
                            }

                            if ($model->jenis_tuntutan_id == 2) {
                                $info = $model->kacamata;
                            }
                            return $info;
                        },
                        'format' => 'text',
                    ],

                    'used_dt',
                    'jumlah_tuntutan',


                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => '',
                        'template' => '{view} | {delete}',

                    ]
                ],
            ]); ?>

        </div>
    </div>
</div>