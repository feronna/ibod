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

<div class="row">
<div class="col-md-12 col-xs-12"> 
    <div class="x_panel">
         <div class="x_content"> 
<?php
  echo Html::a(Yii::t('app',' SENARAI LATIHAN 2017-2019'), ['senarai-latihan-lama'], ['class' => 'btn btn-warning']);
  echo Html::a(Yii::t('app',' SENARAI LATIHAN 2020-2022'), ['senarai-latihan'], ['class' => 'btn btn-success']);
  echo Html::a(Yii::t('app',' SENARAI LATIHAN LUAR'), ['senarai-latihan-luar'], ['class' => 'btn btn-success']);
 
?>
         </div>
    </div>
</div>
</div>



<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Carian</strong></h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
              
            </div>
            <div class="x_content">
                
                <?php
                $form = ActiveForm::begin([
                    'action' => ['senarai-latihan-lama'],
                    'method' => 'get',
                    'options' => [
                        'data-pjax' => 1
                    ],
                ]);
                ?>
                
                                                    <?= $form->field($searchModel, 'vcsl_nama_latihan')->textInput(['placeholder' => 'Tajuk Latihan','style'=>'width:1000px'])->label(false) ?> 

                
                 
                
                            <?=
                            $form->field($searchModel, 'kategori_latihan')->label(false)->widget(Select2::classname(), [
                         //   'data' => ArrayHelper::map(Kumpulankhidmat::find()->all(), 'id', 'name'),
                              'data' => [1 => 'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN'],
                             'options' => ['placeholder' => 'Pilih Kategori Latihan', 'class' => 'form-control col-md-7 col-xs-12'],
                            'pluginOptions' => [
                                'allowClear' => true
                                ],
                            ]);
                            ?> 
                
                       <?=
                            $form->field($searchModel, 'vcsl_nama_peringkat')->label(false)->widget(Select2::classname(), [
                        //   'data' => ArrayHelper::map(app\models\hronline\Vcpdsenarailatihan::find()->all(), 'vcsl_kod_latihan', 'vcsl_nama_peringkat'),
                         'data' => ['UNIVERSITI' => 'UNIVERSITI', 'NEGARA' => 'NEGARA', 'NEGERI' => 'NEGERI' , 'PERINGKAT PTJ' => 'PERINGKAT PTJ', 'ANTARABANGSA' => 'ANTARABANGSA'],
                             'options' => ['placeholder' => 'Pilih Peringkat', 'class' => 'form-control col-md-7 col-xs-12'],
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

<?php
$forms = ActiveForm::begin([
    'action' => ['senarai-latihan-lama',  'page' => Yii::$app->getRequest()->getQueryParam('page')],
    'method' => 'post',
]);
?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong>Senarai Latihan 2017-2019 Dihadiri</strong></h2>
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
                            'header' => 'Bil',
                             'hAlign' => 'center',
                              'vAlign' => 'middle',
                            
                            
                            ],
   [
                        'label' => 'KOD LATIHAN',
                        'value' => 'vcsl_kod_latihan'
                    ],
                         [
                        'label' => 'TAJUK LATIHAN',
                        'value' => 'vcsl_nama_latihan'
                    ],

                    [
                        'label' => 'TAHUN',
                        'value' => 'vcsl_tkh_mula'
                    ],
                        
                       [
                        'label' => 'PERINGKAT',
                        'value' => 'vcsl_nama_peringkat'
                    ],


//                      [
//                            'label' => 'KATEGORI LATIHAN',
//                            'format' => 'raw',
//                            'value'=>function ($data) {
//                      
//                        $statuspelulus= $data->kategori_latihan;
//                        $list = [1 => '<span class="label label-success">KEPIMPINAN</span>', 0 => '<span class="label label-danger">BUKAN KEPIMPINAN</span>',];
//                    
//                        return  $list[$statuspelulus];
//                        }, 
//                        
//                             'hAlign' => 'center',
//                          
//
//                        ],
                        
                                                 [
                        'label' => 'PENGEMASKINI',
                        'value' => 'pengemaskini.CONm'
                    ],
                         [
                        'label' => 'TARIKH KEMASKINI',
                        'value' => 'updated'
                    ],
                        
                        
                       
[
                        'label' => 'KEMASKINI',
                        'format' => 'raw',
                        'headerOptions' => ['class'=>'text-center'],
                        'contentOptions' => ['class'=>'text-center'],
                        'value'=>function ($data) {
                        if($data->kategori_latihan == 1){
                            $checked = 'checked';
                        }
                        if($data->kategori_latihan == 0){
                            $checked1 = 'checked';
                        }
                       
                        return Html::a('<input type="radio" name="'.$data->vcsl_kod_latihan.'" value="1'.$data->vcsl_kod_latihan.'" '."$checked".'> <span class="label label-success">KEPIMPINAN</span>').'  '.Html::a('<input type="radio" name="'.$data->vcsl_kod_latihan.'" value="0'.$data->vcsl_kod_latihan.'" '.$checked1.'> <span class="label label-danger">BUKAN KEPIMPINAN</span>');
                      },
                       
                    ],
                                
//                       [
//                            'label' => 'KEMASKINI',
//                            'format' => 'raw',
//                            //'attribute' => 'statuspelulus',
//                            'value'=>function ($data) {
//
//                          $pelulusId = $data->vcsl_kod_latihan;
//     
//                          return Html::radioList("kategori_latihan[$pelulusId]", '',([1=>'KEPIMPINAN', 0 => 'BUKAN KEPIMPINAN']));
//                        
//
//                        }, 
//                        
//                               'hAlign' => 'center',
//                              'vAlign' => 'middle',
//                          
//
//                        ],


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
     
              <?= Html::submitButton(Yii::t('app', '<i class="fa fa-floppy-o"></i>&nbsp;Simpan'), ['class' => 'btn btn-primary', 'name' => 'simpan', 'value' => 'submit_1']) ?>
                </div>
            
            </div>
                <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
    

