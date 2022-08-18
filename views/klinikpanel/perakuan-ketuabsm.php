<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


$url1 = Url::to(['klinikpanel/kelulusan-pendaftar']);
$js = <<<js
    $('.hantar').on('click',function (){

        var keys = $('#grid').yiiGridView('getSelectedRows');
        $.post("$url1",
        {'keylist': keys},
        function(data){

        });

    });

js;
$this->registerJs($js);
?>

<div class="tblmaxtuntutan-search">
    <div class="x_panel">
        <h2><i class="fa fa-copy"></i><strong> Senarai Permohonan Menunggu Tindakan</strong></h2>
        <ul class="nav navbar-right panel_toolbox">
        </ul>
        <div class="clearfix"></div>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>

<div class="x_content">
<div class="table-responsive">
<?= GridView::widget([
    // 'id' => 'grid',
    'dataProvider' => $query,
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn'
        ],
        [
            'attribute' => 'entry_dt',
            'format' => 'text',
            'label' => 'Tarikh Mohon',
        ],
        [
            'attribute' => 'kakitangan.kakitangan.CONm',
            'format' => 'text',
            'label' => 'Nama Kakitangan',
        ],
        [
            'attribute' => 'icno',
            'format' => 'text',
            'label' => 'No.KP Kakitangan',
        ],
        [
            'attribute' => 'kakitangan.kakitangan.department.fullname',
            'format' => 'text',
            'label' => 'JAFPIB',
        ],
        [
            'label' => 'Tanggungan',
            'value' => 'dependent',
            'format' => 'text',
        ],
        [
            'label' => 'Status',
            'value' => 'kakitangan.kakitangan.tarafPerkahwinan.MrtlStatus',
            'format' => 'text',
        ],
        [
            'label' => 'Peruntukan Tahun Semasa (RM)',
            'value' => 'kakitangan.max_tuntutan',
            'format' => 'text',
        ],
        [
            'label' => 'Baki Semasa (RM)',
            'attribute' => 'kakitangan.current_balance',
            'format' => 'text',
        ],

        [
            'label' => 'Permohonan Kali',
            'attribute' => 'permohonan',
            'format' => 'raw',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '<span class="glyphicon glyphicon-info-sign"></span>',
            
            'template' => '{memo-lulus}',
            'buttons' => [
                'memo-lulus' => function ($url, $query) {
                    $url = Url::to(['klinikpanel/memo-lulus', 'id' => $query->id]);
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                }
            ]
        ],
        [
            'class' => 'yii\grid\CheckboxColumn',
            
        ],
    ],
]);
?>
<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-4">
<?= Html::resetButton('Reset', ['class' => 'btn btn-danger']) ?>
<?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>

</div>
</div>
</div>
</div>

</div>

<?php ActiveForm::end(); ?>