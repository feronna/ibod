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
    'action' => ['view-latihan',  'page' => Yii::$app->getRequest()->getQueryParam('page')],
    'method' => 'post',
]);
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>List Of Training Attended</strong></h2>
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
                    
                    'dataProvider' => $dataProvider,
                    'layout'=>"{summary}\n{items}\n{pager}",
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn',
                            'header' => 'BIl',
                             'hAlign' => 'center',
                              'vAlign' => 'middle',
                            
                            
                            ],
//                    [
//                        'label' => 'STAFF NAME',
//                        'value' => 'CONm'
//                    ],
                        
                        
              
                        
                      [
                        'label' => 'DATE',
                       // 'value' => date("Y-m-d", strtotime($l->tarikhMasa))'tarikhMula'
                         'value'=>function ($data) {
                      if($data['tarikhMula'] != NULL){
                         return date("Y-m-d", strtotime($data['tarikhMula']));
                      }else{
                          return 'NO RECORD';
                      }
                         }
                    ],
                        
                         [
                        'label' => 'TOPICS',
                        'value' => 'tajukLatihan'
                    ],
                            
                    
                               
                         [
                        'label' => 'TYPE',
                              'value'=>function ($data) {
                      if($data['kategori_nama_bi'] != NULL){
                         return ($data['kategori_nama_bi']);
                      }else{
                          return 'NO RECORD';
                      }
                         }
            
                             
                    ],
                        
                  [
                        'label' => 'CATEGORY',
                        'format' => 'raw',
                         'value'=>function ($data) {
                                  if($data['kategori_latihan'] == 1){
                            return 'LEADERSHIP';
                           }else{
                               return 'NOT LEADERSHIP';
                           }
                         }
                   
                    ],
                

//                        [
//                            'class' => 'yii\grid\CheckboxColumn',
//                            'checkboxOptions' => function ($data) {
////                                if((is_null($data->pelulus->agree) || is_null($data->letter_reference))){
////                                    return ['disabled' => true];
////                                }
//                                return [ 'value' => $data->kursusLatihanID];
//                            },
//                        ],

                    ],
                 'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => true,
                'responsive' => true,
                              'pager' => [
                            'firstPageLabel' => 'Halaman Pertama',
                              'lastPageLabel'  => 'Halaman Terakhir'
    ],
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
                ]);
                            
                   
                            
                            
                ?>
                <div class="form-group" align="right">
     
               </div>
            
            </div>
                <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


