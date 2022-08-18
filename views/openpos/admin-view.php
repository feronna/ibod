<?php

use dosamigos\datepicker\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\kehadiran\RefWp;
//use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\grid\GridView;
use app\widgets\TopMenuWidget;

$this->title = 'Permohonan Jawatan';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= TopMenuWidget::widget(['top_menu' => [18,44,45,51], 'vars' => [
    ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]); ?>
<?php // echo $this->render('_search', ['model' => $searchModel]);      ?>

<?=

GridView::widget([
    'options' => [
        'class' => 'table-responsive',
    ],
    'dataProvider' => $dataProvider,
    'rowOptions' => function ($model) {
        if ($model) {
            return ['class' => 'info'];
        }
    },
    /*   'filterModel' => $searchModel, */ //to hide the search row
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'label' => 'Nama Pemohon',
            'value' => 'kakitangan.CONm',
            'format' => 'raw',
//            'headerOptions' => ['class' => 'text-center'],
//            'contentOptions' => ['class' => 'text-center'],
              'vAlign' => 'middle',
                        'hAlign' => 'center',
        ],
        [
            'label' => 'J/F/P/I/U shortname',
            'value' => 'dept.shortname',
            'format' => 'raw',
              'vAlign' => 'middle',
                        'hAlign' => 'center',
//            'headerOptions' => ['class' => 'text-center'],
//            'contentOptions' => ['class' => 'text-center'],
        ],
        [
            'label' => 'J/F/P/I/U fullname',
            'value' => 'dept.fullname',
            'format' => 'raw',
//            'headerOptions' => ['class' => 'text-center'],
//            'contentOptions' => ['class' => 'text-center'],
              'vAlign' => 'middle',
                        'hAlign' => 'center',
        ],
        [
            'label' => 'View',
            'format' => 'raw',
            'value' => function ($data) {
                return Html::a('<i class="fa fa-eye">', ["openpos/s_permohonan_diperaku", 'id' => $data->icno]);
                // return Html::button('', ['id' => 'modalButton', 'value' => Url::to(['tindakan_ketua_jabatan', 'id' => $data->id]), 'class' => 'fa fa-eye mapBtn']);
            },
//            'headerOptions' => ['class' => 'text-center'],
//            'contentOptions' => ['class' => 'text-center'],
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
            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disabled-submit-buttons']]); ?>

     <div class="col-md-12 col-sm-12 col-xs-12" align="right"> 
                    
                    <?= Html::submitButton(Yii::t('app', '<i class="fa fa-paper-plane"></i>&nbsp;Notifikasi Ketua Jabatan'), ['class' => 'btn btn-primary', 'name' => 'notikj', 'value' => 'submit_2','data' => ['disabled-text' => 'Please Wait.. ']]) ?>
                </div>
                 
            </div>
         
            <?php ActiveForm::end(); ?>