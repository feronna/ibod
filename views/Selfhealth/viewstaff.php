<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\hronline\Tblprcobiodata;
?>
<?= $this->render('_topmenu') ?>
<div class="x_panel">
    <div class="x_title">
                <h2><strong><i class="fa fa-plus-square"></i> Staff's Self Health Declaration Report </strong></h2>
                <div class="clearfix"></div>
            </div>
    <div class="x_content">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'pager' => [
        'firstPageLabel' => 'First',
        'lastPageLabel'  => 'Last'
    ],
        'options' => [
                'class' => 'table-responsive',
                    ],
        'dataProvider' => $dataProvider,
        'filterModel' => true,
        'summary' => '',
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn',
            'header' => 'No',
            'vAlign' => 'middle',
            'hAlign' => 'center',
            ],
            [
                'label' => 'Name',
                'value'=>function ($data) {
                    return $data->kakitangan->CONm;
                },
                'vAlign' => 'middle',
                'hAlign' => 'center',
                'filter' => Select2::widget([
                    'name' => 'icno',
                    'value' => $icno,
                    'data' => ArrayHelper::map($query->all(), 'icno', 'kakitangan.CONm'),
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],          
            [
                'label' => 'Gred',
                'value'=>function ($data) {
                    return $data->kakitangan->jawatan->gred;
                },
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                'label' => 'Job Category',
                'value'=>function ($data) {
                    return $data->kakitangan->jawatan->job_category == 1? 'Academic':'Administration';
                },
                'filter' => Select2::widget([
                            'name' => 'category',
                            'value' => $category,
                            'data' => [1 => 'Academic', 2 => 'Administration'],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                        'visible' => $role,
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
                        [
                'label' => 'JFPIB',
                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                'filter' => Select2::widget([
                            'name' => 'jfpiu',
                            'value' => $jfpiu,
                            'data' => ArrayHelper::map(app\models\hronline\Department::find(['isActive' => 1])->all(), 'id', 'shortname'),
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                'label' => 'Campus',
                'value'=>function ($data) {
                    return $data->kakitangan->displayKampus;
                },
                'filter' => Select2::widget([
                            'name' => 'campus',
                            'value' => $campus,
                            'data' => [1=> 'Kota Kinabalu', 2 => 'Labuan', 3 => 'Sandakan'],
                            'options' => ['placeholder' => ''],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ]),
                'visible' => $role,
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                'label' => 'Date',
                'value'=>function ($data) {
                    return date_format(date_create($data->date), 'd M Y');
                },
                'filter' => DatePicker::widget([
                                        'name' => 'date',
                                        'value' => $date,
                                        'type' => DatePicker::TYPE_INPUT,
                                         'options' => ['placeholder' => 'Tahun','autocomplete' => 'off'
                                                ],
                                        'pluginOptions' => [
                                            'autoclose'=>true,
                                            'format' => 'd M yyyy',
                                        ]
                                    ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                'label' => 'Time',
                'value'=>function ($data) {
                    return date_format(date_create($data->date), 'h:i:s a');
                },
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                'label' => 'Day',
                'value'=>function ($data) {
                    return date_format(date_create($data->date), 'D');
                },
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                'label' => 'Have symptoms Fever, cough, or shortness of breath',
                'format' => 'raw',
                'value'=>function ($data) {
                    if($data->health_status){
                    return $data->health_status === 1? '<span class="label label-success">No</span>': '<span class="label label-danger">Yes</span>';}
                    else{
                        return '-';
                    }
                },
                'filter' => Select2::widget([
                    'name' => 'symptom',
                    'value' => $symptom,
                    'data' => [2 => 'Yes', 1 => 'No'],
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
              'label' => 'Temperature (°C)',
                'format' => 'raw',
               'value'=> 'suhu',
                'filter' => Select2::widget([
                    'name' => 'temp',
                    'value' => $temp,
                    'data' => ['< 36.0' => '< 36.0', '36.0 - 37.5' => '36.0 - 37.5','> 37.5' => '> 37.5'],
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [   
                'label' => 'Status',
                'format' => 'raw',
                'value'=>function ($data) use($date){
                    if(\app\models\kehadiran\TblWfh::find()->where(['icno' => $data->icno, 'start_date' => date_format(date_create($date), 'Y-m-d'), 'status' => 'APPROVED'])->exists()){
                       return 'Work from home';  
                    }
                    elseif(app\models\kehadiran\TblRekod::find()->where(['icno' => $data->icno, 'tarikh' => date_format(date_create($date), 'Y-m-d')])->exists() || app\models\keselamatan\TblRekod::find()->where(['icno' => $data->icno, 'tarikh' => date_format(date_create($date), 'Y-m-d')])->exists()){
                        return 'Work from office';
                    }else{
                        return "Work from office (Haven't clocked in)";
                    }
                    },
                'filter' => Select2::widget([
                    'name' => 'status',
                    'value' => $status,
                    'data' => ['Work from home' => 'Work from home', 'Work from office' => 'Work from office'],
                    'options' => ['placeholder' => ''],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'escapeMarkup' => new \yii\web\JsExpression('function (markup) { return markup; }'),
                    ],
                ]),
                'options' => ['style' => 'width:100px;'],
                'vAlign' => 'middle',
                'hAlign' => 'center',],
             [
                'label' => 'Treatment status',
                'format' => 'raw',
                'value'=>function ($data){
                        if($data->date_prw == '' && ($data->health_status == 2 || ($data->temperature > 37.5 || $data->temperature == '> 37.5'))){
                        return Html::button('', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['statusprw', 'id' => $data->id]),'style'=>'
                        border: none;', 'class' => 'fa fa-edit btn btn-primary mapBtn']);}
                        else{
                            return $data->statusprw.'<br>'.$data->places;
                        }
                      },
                              'visible' => $role,
                'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                'format' => 'raw',
                'label' => 'Monthly Report',
                'value' => function ($data){
                    return Html::a('<i class="fa fa-bar-chart"></i>', ['viewstaffreport', 'icno' => $data->icno], ['class' => 'btn btn-primary btn-sm', 'target'=>'_blank']);
                },
                        'vAlign' => 'middle',
                'hAlign' => 'center',
            ],
            [
                'format' => 'raw',
                'label' => 'Reset',
                'value' => function ($data){
                    return Html::button('<i class="fa fa-undo"></i>', ['id' => 'modalButton', 'value' => \yii\helpers\Url::to(['reset', 'id' => $data->id, 'url' => 'adminviewstaff']),'style'=>'
                        border: none;', 'class' => 'btn btn-primary mapBtn']);
                },
                        'visible' => $role,
                        'vAlign' => 'middle',
                'hAlign' => 'center',
            ] 
            
        ],
                'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'], 
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
    ]); ?>
    </div>
<!--    <ul>
        <li><i class="fa fa-check" style="color:green"></i> : Allowed to work</li>
        <li><i class="fa fa-close" style="color:red"></i> : Not allowed to work</li>
            </ul>-->
</div>
