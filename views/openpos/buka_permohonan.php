<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
use app\models\hronline\GredJawatan;
use kartik\grid\GridView;
use app\widgets\TopMenuWidget;
/* @var $this yii\web\View */
/* @var $model app\models\mohonjawatan\TblOpenpos */
//
//$this->title = 'Create Tbl Openpos';
//$this->params['breadcrumbs'][] = ['label' => 'Tbl Openpos', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<?= TopMenuWidget::widget(['top_menu' => [18,44,45,51], 'vars' => [
    ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]); ?>

<!--list permohonanan yang telah dibuka-->

<div class="col-md-12"> 
    <div class="x_panel">

        <div class="x_title">
            <h2>Pembukaan Permohonan Jawatan</h2>
            <ul class="nav navbar-right panel_toolbox">

            </ul>
            <div class="clearfix"></div>
        </div>  
        <div class="x_content">

        <?php $form = ActiveForm::begin(['enableAjaxValidation' => true, 'options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'enctype' => 'multipart/form-data']]); ?>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date_start">Tarikh Mula <span class="required">*</span>
                </label>
                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'date_start',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="end_date">Tarikh Akhir <span class="required">*</span>
                </label>
                <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                    <?=
                    DatePicker::widget([
                        'model' => $model,
                        'attribute' => 'date_end',
                        'template' => '{input}{addon}',
                        'options' => ['class' => 'form-control col-lg-4 col-md-7 col-xs-12'],
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Remark<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($model, 'remark')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>                 
            <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'url' => ['index']]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>  <!-- end of xpanel-->
</div> <!-- end of md-->

<div class="col-md-12"> 

    <div class="x_content">
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
                    'label' => 'Tarikh Buka',
                    'value' => 'entry_dt',
                ],
                [
                    'label' => 'Tarikh Mula',
                    'value' => 'tarikhMula',
                ],
                [
                    'label' => 'Tarikh Tamat',
                    'value' => 'tarikhTamat',
                ],
                [
                    'label'=> 'Status',
                    'format'=> 'raw',
                    'value'=>'stat',
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => 'Actions',
                    'template' => '{update} | {delete}',
                    'hAlign' => 'center',
                ],
            ],
        ]);
        ?>
    </div>  <!-- end of xpanel-->
</div> <!-- end of md-->
<!--<div class="col-md-12"> 
    <div class="x_panel">
        <div class="x_title">
            <h2><strong>Senarai Permohonan Jawatan</strong></h2>
            <ul class="nav navbar-right panel_toolbox">
              
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <table class="table table-striped jambo_table">
                <tr>
                    <th class="text-center">Bil</th>
                    <th class="text-center">Tarikh Buka</th>
                    <th class="text-center">Tarikh Mula</th>
                    <th class="text-center">Tarikh Tamat</th>
                    <th class="text-center">Kemaskini</th>
                    <th class="text-center">Padam</th>
                   
                </tr>
<?php if ($models) { ?>
    <?php foreach ($models as $v_list) { ?>
                                        <tr>
                                            <td class="text-center"  style="text-align:center"><?php echo $bil++ ?></td>
                                            <td class="text-center"><?php echo $v_list->entry_dt; ?></td>
                                            <td class="text-center"><?php echo $v_list->date_start; ?></td>
                                            <td class="text-center"><?php echo $v_list->date_end; ?></td>
                                            <td class="text-center"><?= Html::a('<i class="fa fa-trash">', ["delete", 'id' => $v_list->id]) . '' . Html::a('<i class="fa fa-edit">', ["update", 'id' => $v_list->id]); ?></td>
                                        </tr>
    <?php } ?>
<?php } else { ?>
                            <tr>
                                <td colspan="3" class="align-center text-center"><i>Belum ada Tindakan lagi</i></td>
                            </tr>
<?php } ?>
            </table>
        </div>
    </div>
</div>    -->