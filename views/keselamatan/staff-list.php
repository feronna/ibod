<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use app\models\keselamatan\RefPosKawalan;
use app\models\keselamatan\RefUnit;
use app\models\hronline\Tblprcobiodata;
use app\widgets\TopMenuWidget;
?>
<?= $this->render('/keselamatan/_topmenu') ?>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix">
                <?php
                $form = ActiveForm::begin([
                    'action' => ['staff-list'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>

                <?=
                $form->field($searchModel, 'staff_icno')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Tblprcobiodata::find()->where(['status' => 1])->all(), 'ICNO', 'CONm'),
                    'options' => ['placeholder' => 'Nama Kakitangan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>

                <?=
                $form->field($searchModel, 'unit_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(RefUnit::find()->where(['active' => 1])->all(), 'id', 'unit_name'),
                    'options' => ['placeholder' => 'Unit', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
                <?=
                $form->field($searchModel, 'pos_kawalan_id')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(RefPosKawalan::find()->where(['active' => 1])->all(), 'id', 'pos_kawalan'),
                    'options' => ['placeholder' => 'Pos Kawalan', 'class' => 'form-control col-md-7 col-xs-12'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
             

                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-microchip"></i> Search', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<div class="x_panel">

    <div class="clearfix">
        <!--// Control your pjax options-->
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'class' => 'table-responsive',
            ],
            /*   'filterModel' => $searchModel, */ //to hide the search row
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'label' => 'Nama',
                    'value' => 'staff.CONm',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                ],
                [
                    'label' => 'Unit',
                    'value' => 'unitname.unit_name',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                ],
                [
                    'label' => 'Pos Kawalan',
                    'format' => 'raw',
                    'value' => 'pos.pos_kawalan',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                ],
                [
                    'label' => 'Kampus',
                    'format' => 'raw',
                    'value' => 'campus.campus_name',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                ],

      
                [
                    'label' => 'STARS / SKB',
                    'format' => 'raw',
                    'value' => 'clockin',
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                ],

      
                [
                    'label' => 'Actions',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['update', 'id' => $data->id]), 'class' => 'fa fa-pencil mapBtn']);
                    },
                    'vAlign' => 'middle',
                    'hAlign' => 'center',
                ],
            ],
            'headerRowOptions' => ['class' => 'kartik-sheet-style'],
            'resizableColumns' => true,
            'responsive' => false,
            'responsiveWrap' => false,
            'hover' => true,
            'floatHeader' => true,
            'floatHeaderOptions' => [
                'position' => 'absolute',
            ],
        ]);
        ?>


    </div>
</div>

<?php
$script = <<< JS

          $('.confirmation').on('click', function () {
        return confirm('Are you sure?');
    });
              
  $(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
JS;
$this->registerJs($script);
?>