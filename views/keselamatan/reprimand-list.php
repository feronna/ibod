<?php

use app\models\kehadiran\TblYears;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use app\widgets\TopMenuWidget;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

?>
<?= $this->render('/keselamatan/_topmenu') ?>


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
                    'action' => ['reprimand-list'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>

                <?= $form->field($searchModel, 'receiver_icno')->textInput()->input('name', ['placeholder' => "Nama Anggota"])->label(false); ?>
                <?=
                $form->field($searchModel, 'tahun')->label(false)->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(TblYears::find()->all(), 'year', 'year'),
                    'options' => ['placeholder' => 'Tahun', 'class' => 'form-control col-md-7 col-xs-12'],
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

                            [
                                'label' => 'Tarikh Teguran',
                                'value' => 'date',
                            ],
                            [
                                'label' => 'Nama Anggota',
                                'value' => 'receiver.CONm',
                            ],
                            [
                                'label' => 'Di Hantar Oleh',
                                'value' => 'sender.CONm',
                            ],
                            [
                                'label' => 'Teguran',
                                'value' => 'comment',
                            ],

                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
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