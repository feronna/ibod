<?php

use app\models\hronline\BadanProfesional;
use app\models\hronline\KlasifikasiPerkhidmatan;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;

$this->title = 'Set Badan Profesional Skim';
?>
<div class="negeri-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="tblprcobiodata-form">
        <div class="x_panel">
            <?= $this->render('_search', [
                'carian' => $searchModel,
                'bp_id' => $bp_id,
            ]) ?>
        </div>
    </div>
    <?php Pjax::begin(['id' => 'countries']) ?>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
    <div class="x_panel">
        <div class="x_title">
            <h2><?= "Senarai Skim" ?></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="form-group">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'label' => 'Nama',
                            'value' => 'nama',
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['class' => 'text-left', 'style' => 'width:15%', 'bgcolor' => '#e8e9ea'],
                        ],
                        [
                            'label' => 'Gred',
                            'attribute' => 'gred_skim',
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['class' => 'text-left', 'style' => 'width:15%', 'bgcolor' => '#e8e9ea'],
                        ],
                        [
                            'label' => 'Status',
                            'value' => 'isActive',
                            'contentOptions' => ['class' => 'text-left'],
                            'headerOptions' => ['class' => 'text-left', 'style' => 'width:15%', 'bgcolor' => '#e8e9ea'],
                        ],
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'headerOptions' => ['class' => 'text-center', 'style' => 'width:5%', 'bgcolor' => '#e8e9ea'],
                            'contentOptions' => ['class' => 'text-center'],
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>

    <div class="form-group text-center">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-primary', 'name' => 'submit_1', 'id' => 'submit_1', 'value' => '2']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php Pjax::end() ?>

</div>