<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use app\models\e_perkhidmatan\TblEvent;
use app\models\e_perkhidmatan\RefApp;
//use dosamigos\grid\GridView;
use dosamigos\grid\behaviors\GroupColumnsBehavior;


echo $this->render('/idp/_topmenu');

$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    // [
    //     'class' => 'kartik\grid\ExpandRowColumn',
    //     'width' => '50px',
    //     'value' => function ($model, $key, $index, $column) {
    //         return GridView::ROW_COLLAPSED;
    //     },
    //     // uncomment below and comment detail if you need to render via ajax
    //     // 'detailUrl' => Url::to(['/site/book-details']),
    //     'detail' => function ($model, $key, $index, $column) {
    //         // return Yii::$app->controller->renderPartial('_expand-row-details', ['model' => $model]);
    //         //return Yii::$app->controller->renderPartial('view_event', ['model' => $model]);
    //     },
    //     'headerOptions' => ['class' => 'kartik-sheet-style'],
    //     'expandOneOnly' => true
    // ],
    [
        //'attribute' => 'supplier_id', 
        //'attribute' => 'event_id',
        'label' => 'Acara',
        'width' => '310px',
        'format' => 'raw',
        'value' => function ($model, $key, $index, $widget) {
            //return $model->supplier->company_name;
            return $model->event->event_name.''.Html::tag('span', '<i class="fa fa-info-circle"></i> INFO', [
                'data-html' => 'true',
                'data-title' => '<b>HVHVB</b>',
                'data-content' => '<b>Pemilik Modul : </b>'
                .'<br>'
                .'<br><b>Tahun Ditawarkan : </b>'
                .'<br>'
                .'<br><b>Sinopsis Kursus : </b>',
                'data-toggle' => 'popover',
                'data-placement' => 'right',
                'data-trigger' => 'hover',
                'class' => 'btn btn-info',
                'style' => 'text-decoration: underline: cursor:pointer;'
            ]);
        },
        'filterType' => GridView::FILTER_SELECT2,
        // 'filter' => ArrayHelper::map(Suppliers::find()->orderBy('company_name')->asArray()->all(), 'id', 'company_name'),
        'filter' => ArrayHelper::map(TblEvent::find()->orderBy('event_name')->asArray()->all(), 'event_id', 'event_name'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Mesyuarat/ Seminar/ Lawatan/ Kursus'],
        'group' => true,  // enable grouping,
        //'groupedRow' => true,                    // move grouped column to a single grouped row
        // 'groupOddCssClass' => 'kv-grouped-row',  // configure odd group cell css class
        // 'groupEvenCssClass' => 'kv-grouped-row', // configure even group cell css class
    ],
    
    [
        // 'attribute' => 'category_id', 
        //'attribute' => 'app_type',
        'label' => 'Jenis Permohonan',
        'width' => '250px',
        'value' => function ($model, $key, $index, $widget) {
            // return $model->category->category_name;
            if ($model->reference) {
                return $model->reference->type;
            } 
            else {
                return "";
            }
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => ArrayHelper::map(RefApp::find()->orderBy('id')->asArray()->all(), 'id', 'type'),
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        // 'filterInputOptions' => ['placeholder' => 'Jenis permohonan'],
        // 'group' => true,  // enable grouping
        // 'subGroupOf' => 1 // supplier column index is the parent group
    ],
    [
        //'class' => 'kartik\grid\BooleanColumn',
        'attribute' => 'appStatus',
        'label' => 'Status',
        'format' => 'raw',
        'vAlign' => 'middle',
        'hAlign' => 'center',
    ], 
    [
        'label' => ' ',
        'format' => 'raw',
        'value' => function ($model, $key, $index, $widget) {
            //return $model->supplier->company_name;
            
            return Html::a('MOHON', 'senarai-permohonan?event_id='.$model->event_id, ['class' => 'btn-sm btn-primary btn-block', 'target' => '_blank']);
            //$v = Html::button('PILIH SIRI', ['value' => 'mohon-latihan?id='.$lat2->kursusLatihanID.'&kategori=5', 'class' => 'mapBtn btn-sm btn-primary btn-block']);
        },
        'vAlign' => 'middle',
        'hAlign' => 'center',
        'group' => true,  // enable grouping
        'subGroupOf' => 1, // supplier column index is the parent group
    ],
];


?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons']]); ?>

<script type="text/javascript">
    function GetDays() {
        var dropdt = new Date(document.getElementById("date_to").value);
        var pickdt = new Date(document.getElementById("date_from").value);
        return parseInt((dropdt - pickdt) / (24 * 3600 * 1000));
    }

    function cal() {
        if (document.getElementById("date_to")) {
            document.getElementById("days").value = GetDays();
        }
    }
</script>

<?php
// display grid
// echo GridView::widget(
//     [
//         'behaviors' => [
//             [
//                 'class' => 'dosamigos\grid\behaviors\GroupColumnsBehavior',
//                 // You an use multiple columns for extra row but remember that will affect the merging
//                 // as both columns must be having same values for the extra row to title the records 
//                 'extraRowColumns' => ['event_id'],
//                 // you can use multiple columns here 
//                 'mergeColumns' => ['event_id'] 
//             ]

//         ],
//         'dataProvider' => $dataProvider,
//         'layout' => "{summary}\n{items}\n{pager}"
//     ]
// );
?>

<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-list"></i> Sistem Pengurusan Acara (Bahagian Keselamatan)</strong></h2>
                <p align="right"><?= \yii\helpers\Html::a('Kembali', Yii::$app->request->referrer, ['class' => 'btn btn-default btn-sm']) ?></p>
                <div class="clearfix"></div>
            </div>

            <div class="row">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><strong><i class="fa fa-book"></i> SENARAI ACARA DIMOHON</strong></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <?=
                    
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => 'Mesyuarat/ Seminar/ Lawatan/ Kursus'],
                        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        'columns' => $gridColumns,
                        // 'columns' => [
                        //     [
                        //         'class' => 'kartik\grid\SerialColumn',
                        //         'header' => 'Bil',
                        //         'vAlign' => 'middle',
                        //         'hAlign' => 'center',

                        //     ],
                        //     [
                        //         'label' => 'Tarikh',
                        //         'value' => 'entry_date'
                        //     ],
                        //     [
                        //         'label' => 'Program/Kursus',
                        //         'value' => 'event_name',
                        //     ],
                        //     [
                        //         'label' => 'Lokasi',
                        //         'value' => 'location'
                        //     ],
                        //     [
                        //         'label' => 'Pautan',
                        //         'hAlign' => 'center',
                        //         'format' => 'raw',
                        //         'value' => function ($data) {

                        //             $url = 'permit/senarai-permohonan';
                        //             return Html::a('<i class="fa fa-chevron-circle-right" aria-hidden="true" text-align="center"></i>', $url, ['class' => 'btn-sm btn-primary btn-block', 'target' => '_blank']);
                        //         },
                        //     ],

                        // ],
                    ]); 
                    
                    ?>

                </div>
            </div>

            <div class="row">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-book"></i><strong> TAMBAH ACARA</strong></h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="container">
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <th scope="col" colspan=12" width="30%" style="background-color:lightgrey;">
                                                <center>MAKLUMAT ACARA</center>
                                            </th>

                                            <!-- <tr>
                        <td valign="5">Butiran:<span class="required" style="color:red;">*</span></td>
                        <td colspan="5">  
                            <div class="col-md-6 col-sm-6 col-xs-10"> 
                            <?php

                            // $form->field($model, 'butiran')->label(false)->widget(Select2::classname(), [
                            //     'data' => ['Tugas Rasmi' => 'Tugas Rasmi', 
                            //     'Kursus Pendek' => 'Kursus Pendek',
                            //     'Kursus Panjang' => 'Kursus Panjang',
                            //  ],
                            //     'options' => [
                            //             'placeholder' => 'Sila Pilih'],

                            // ]); 
                            ?> 
                            </div>
                        </td>
                </tr> -->

                                            <tr>
                                                <td valign="5">Tujuan:<span class="required" style="color:red;">*</span></td>
                                                <td colspan="5">
                                                    <div class="col-md-12 col-sm-12 col-xs-10">
                                                        <?= $form->field($model, 'event_name')->textInput(['maxlength' => true, 'placeholder' => 'Mesyuarat/Seminar/Lawatan/Kursus yang diadakan'])->label(false); ?>
                                                    </div>
                                                </td>

                                            </tr>

                                            <tr>
                                                <td valign="5">Nama Tempat:<span class="required" style="color:red;">*</span></td>
                                                <td colspan="5">
                                                    <div class="col-md-12 col-sm-12 col-xs-10">
                                                        <?= $form->field($model, 'location')->textInput(['maxlength' => true])->label(false); ?>
                                                    </div>
                                                </td>
                                                <!-- <td valign="2">Negara:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="2"> 
                            <?php

                            // $form->field($model, 'negara')->widget(Select2::classname(), 
                            // ['data' => ArrayHelper::map(Negara::find()->orderBy(['CountryCd' => SORT_ASC,])->all(), 'Country', 'Country'),
                            // 'options' => [
                            // 'placeholder' => 'Pilh Negara'],
                            // ])->label(false); 
                            ?>
                        </td> -->

                                </div>
                                </tr>

                                <tr>
                                    <td valign="1">Dari:<span class="required" style="color:red;">*</span></td>
                                    <td colspan="1"><?= $form->field($model, 'date_start')->widget(
                                                        DatePicker::className(),
                                                        [
                                                            'clientOptions' => ['changeMonth' => true, 'yearRange' => '1996:2099', 'changeYear' => true, 'startDate' => date('date_from'), 'minDate' => '0', 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                                            'options' => ['placeholder' => 'Select Date ', 'onchange' => 'cal()', 'id' => 'date_from']
                                                        ]
                                                    )
                                                        ->label(false); ?> </td>
                                    <td valign="1">Hingga:<span class="required" style="color:red;">*</span></td>
                                    <td colspan="1"><?= $form->field($model, 'date_end')->widget(
                                                        DatePicker::className(),
                                                        [
                                                            'clientOptions' => ['changeMonth' => true, 'yearRange' => '1996:2099', 'changeYear' => true, 'startDate' => date('date_from'), 'minDate' => '0', 'format' => 'yyyy-mm-dd', 'autoclose' => true],
                                                            'options' => ['placeholder' => 'Select Date ', 'onchange' => 'cal()', 'id' => 'date_to']
                                                        ]
                                                    )
                                                        ->label(false); ?> </td>
                                    <!-- <td valign="1">Tempoh:<span class="required" style="color:red;">*</span></td> 
                        <td colspan="1">
                            <div class="col-md-6 col-sm-6 col-xs-12"> 
                             <?php //$form->field($model, 'days')->textInput(['maxlength' => true, 'id' => 'days', 'pattern'=>'[123456789]+', 'title'=>'Invalid Date!Please enter correct date.']) ->label(false);
                                ?>
                            </div>
                        </td> -->

                            </div>
                            </tr>


                            </thead>
                            </table>
                            <!--<table class="table table-sm table-bordered" >
        <thead>
                <tr>
                    <td valign="4">Dokumen LN 1:<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"> <?php //$form->field($model, 'file')->fileInput()->label(false);
                                        ?> </td>
                    <td valign="4">Dokumen Kelulusan:<span class="required" style="color:red;">*</span></td>
                    <td colspan="4"> <?php //$form->field($model, 'file2')->fileInput()->label(false);
                                        ?> </td> 
                </tr>
        </thead>
             </table>  -->

                            <div style="color: green; margin-top: 0px;">
                                <strong> Sila pastikan maklumat tuntutan adalah tepat sebelum klik hantar. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini.</strong>
                            </div>
                            <?php //$form->field($model, 'jeniskemudahan')->hiddenInput(['value' =>  $id = Yii::$app->request->get('id')])->label(false)
                            ?>
                        </div>
                        <div class="form-group" align="center">
                            <div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-3">
                                <br>
                                <?php // Html::submitButton('Hantar', ['class' => 'btn btn-success']) 
                                ?>
                                <?= Html::submitButton(Yii::t('app', '<i class=""></i>&nbsp;Hantar'), ['class' => 'btn btn-success', 'name' => 'simpan', 'value' => 'submit_1', 'data' => ['disabled-text' => 'Please Wait..']]) ?>
                                <button class="btn btn-primary" type="reset">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
</div>
</div>
</div>
</div>