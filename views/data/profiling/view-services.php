<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;
use app\models\hronline\Kumpkhidmat;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use app\models\hronline\Kumpulankhidmat;
/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

error_reporting(0);
?>



<?php
$forms = ActiveForm::begin([
    'action' => ['view-services',  'page' => Yii::$app->getRequest()->getQueryParam('page')],
    'method' => 'post',
]);
?>


   
        
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Services Community</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>

            </div>
     
            
            <div class="x_content">
                <?=
                GridView::widget([

                    'options' => [
                        'class' => 'table-responsive',
                    ],

                    'dataProvider' => $senarai,
                    'layout' => "{summary}\n{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Akhir'
                    ],
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',

                        ],
                        [
                            'label' => 'ACTIVITY',
                            'value' => 'service'
                        ],
                       
                        [
                            'label' => 'ROLE',
                            'value' => 'role'
                        ],

                        [
                            'label' => 'ROLE KEY',
                            'value' => 'role_key'
                        ],

                        [
                            'label' => 'DATE',
                            'value' => 'year'
                        ],
//                        [
//                            'label' => 'Kategori Aktiviti',
//                            'format' => 'raw',
//                            'value' => function ($data) {
//
//                                $status = $data->kategori_servis;
//                                $list = [1 => '<span class="label label-success">KEPIMPINAN</span>', 0 => '<span class="label label-danger">BUKAN KEPIMPINAN</span>',];
//
//                                return  $list[$status];
//                            },
//
//                            'hAlign' => 'center',
//
//
//                        ],

//                        [
//                            'label' => 'Kemaskini',
//                            'format' => 'raw',
//                            //'attribute' => 'statuspelulus',
//                            'value' => function ($data) {
//
//                                $pelulusId = $data->fid;
//
//                                return Html::radioList("kategori_servis[$pelulusId]", '', ([1 => 'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN']));
//                            },
//
//                            'hAlign' => 'center',
//                            'vAlign' => 'middle',
//
//
//                        ],
                                    
                                     [
                            'label' => 'CATEGORY',
                            'format' => 'raw',
                
                                       'value' => function ($data) {
                                if ($data->kategori_servis == '1') {
                                    return '<span class="label label-success">KEPIMPINAN</span>';
                                }
                                if ($data->kategori_servis == '0') {
                                   return  '<span class="label label-danger">BUKAN KEPIMPINAN</span>';
                                }
                              
                            },
                        
                               'hAlign' => 'center',
                              'vAlign' => 'middle',
                          

                        ],
                                

                                
                                
                                       [
                            'label' => 'LEVEL',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'contentOptions' => ['style' => 'width: 150px;'],
                            'value' => function ($data) {
                              
                                    return '<span class="label label-success">'.$data->peringkatKomuniti->nama. '</span>';
                                    
                                
                            },
                        ],
                                
                                
                             

                        // [
                        //     'class' => 'yii\grid\CheckboxColumn',
                        //     'checkboxOptions' => function ($data) {
                        //         return ['value' => $data->uid];
                        //     },
                        // ],

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
                <?php ActiveForm::end(); ?>
        </div>

<?php
$forms = ActiveForm::begin([
    'action' => ['view-services',  'page' => Yii::$app->getRequest()->getQueryParam('page')],
    'method' => 'post',
]);
?>


   
        
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Services University</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>

            </div>
     
            
            <div class="x_content">
                <?=
                GridView::widget([

                    'options' => [
                        'class' => 'table-responsive',
                    ],

                    'dataProvider' => $senarai1,
                    'layout' => "{summary}\n{items}\n{pager}",
                    'pager' => [
                        'firstPageLabel' => 'Halaman Pertama',
                        'lastPageLabel'  => 'Halaman Akhir'
                    ],
                    'columns' => [
                        [
                            'class' => 'kartik\grid\SerialColumn',
                            'header' => 'Bil',
                            'hAlign' => 'center',
                            'vAlign' => 'middle',

                        ],
                        [
                            'label' => 'ACTIVITY',
                            'value' => 'service'
                        ],
                        
                        [
                            'label' => 'ROLE',
                            'value' => 'role'
                        ],

                        [
                            'label' => 'ROLE KEY',
                            'value' => 'role_key'
                        ],

                        [
                            'label' => 'DATE',
                            'value' => 'year'
                        ],
//                        [
//                            'label' => 'Kategori Aktiviti',
//                            'format' => 'raw',
//                            'value' => function ($data) {
//
//                                $status = $data->kategori_servis;
//                                $list = [1 => '<span class="label label-success">KEPIMPINAN</span>', 0 => '<span class="label label-danger">BUKAN KEPIMPINAN</span>',];
//
//                                return  $list[$status];
//                            },
//
//                            'hAlign' => 'center',
//
//
//                        ],

//                        [
//                            'label' => 'Kemaskini',
//                            'format' => 'raw',
//                            //'attribute' => 'statuspelulus',
//                            'value' => function ($data) {
//
//                                $pelulusId = $data->fid;
//
//                                return Html::radioList("kategori_servis[$pelulusId]", '', ([1 => 'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN']));
//                            },
//
//                            'hAlign' => 'center',
//                            'vAlign' => 'middle',
//
//
//                        ],
                                    
                                     [
                            'label' => 'CATEGORY',
                            'format' => 'raw',
                
                                       'value' => function ($data) {
                                if ($data->kategori_servis == '1') {
                                    return '<span class="label label-success">KEPIMPINAN</span>';
                                }
                                if ($data->kategori_servis == '0') {
                                   return  '<span class="label label-danger">BUKAN KEPIMPINAN</span>';
                                }
                              
                            },
                        
                               'hAlign' => 'center',
                              'vAlign' => 'middle',
                          

                        ],
                                

                                
                                
                                       [
                            'label' => 'LEVEL',
                            'format' => 'raw',
                            'vAlign' => 'middle',
                            'contentOptions' => ['style' => 'width: 150px;'],
                            'value' => function ($data) {
                              
                                    return '<span class="label label-success">'.$data->peringkatKomuniti->nama. '</span>';
                                    
                                
                            },
                        ],
                                
                                
                             

                        // [
                        //     'class' => 'yii\grid\CheckboxColumn',
                        //     'checkboxOptions' => function ($data) {
                        //         return ['value' => $data->uid];
                        //     },
                        // ],

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
                <?php ActiveForm::end(); ?>
        </div>