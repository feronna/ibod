<?php
$js=<<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
use kartik\export\ExportMenu;
use yii\web\JsExpression;

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
?>
<script src="/pace/pace.js"></script>
<link href="/pace/themes/pace-theme-barber-shop.css" rel="stylesheet" />
<?php
error_reporting(0); 
?>

<?= $this->render('/cutibelajar/_topmenu') ?>
    <?= \yiister\gentelella\widgets\FlashAlert::widget(['showHeader' => true]) ?>

    <?php 

$gridColumns = [
    
                        ['class' => 'yii\grid\SerialColumn',
                            'header' => 'BIL',],

                        [   
                            
                            'label' => 'NAMA KAKITANGAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->kakitangan->CONm));
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                             [   
                            
                            'label' => 'NO KAD PENGENALAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->icno));
                            },
                            'format' => 'raw'
                            
                        ],
                         [
                'label' => 'JFPIB',
                'value'=>function ($data) {
                    return $data->kakitangan->department->shortname;
                },
                
                                            'format' => 'raw'

                          
            ],
                        
                         [   
                            
                            'label' => 'INSTITUT/UNIVERSITI',
                            'value' => function ($data) {
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return Html::a(strtoupper($data->InstNm));
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                           [   
                            
                            'label' => 'PERINGKAT PENGAJIAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->tahapPendidikan);
                            },
                            'format' => 'raw'
                            
                        ],          
                        [   
                            
                            'label' => 'NEGARA',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->negara->Country);
                            },
                            'format' => 'raw'
                            
                        ],
                                    
                           [   
                            
                            'label' => 'BIDANG',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                              
                                if(($data->MajorCd == NULL) && ($data->MajorMinor != NULL))
                        {
                                return  strtoupper($data->MajorMinor);
                        }
                        elseif (($data->MajorCd != NULL) && ($data->MajorMinor != NULL))  {
                            return   strtoupper($data->MajorMinor);

                        }
                        else
                        {
                          return   strtoupper($data->major->MajorMinor);
                        }
                            },
                            'format' => 'raw'
                            
                        ],
                        
                         [   
                            
                            'label' => 'TARIKH PENGAJIAN',
                            'value' => function ($data){
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
                                return strtoupper($data->tarikhmula).' HINGGA '.strtoupper($data->tarikhtamat);
                            },
                            'format' => 'raw'
                            
                        ],   
                        [   
                            
                            'label' => 'LANJUTAN 01',
                            'value' => function ($data){
                                
//                             if($data->lanjutan->idLanjutan == 1)
//                             {
//                                 return $data->lanjutan->stlanjutan;
//                             }
                       
                             return strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno'=>$data->pengajiansemasa->icno,'idLanjutan'=>1,'HighestEduLevelCd'=>$data->pengajiansemasa->HighestEduLevelCd])->one()->stlanjutan)
                             . ' HINGGA '.strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno'=>$data->pengajiansemasa->icno,'idLanjutan'=>1,'HighestEduLevelCd'=>$data->pengajiansemasa->HighestEduLevelCd])->one()->ndlanjutan) ;
                     
                             
                    
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
//                                return  $data->tajaan->penajaan->penajaan.' - '.strtoupper($data->tajaan->nama_tajaan);

                            },
                            'format' => 'raw'
                            
                        ],
                                     [   
                            
                            'label' => 'LANJUTAN 02',
                            'value' => function ($data){
                                
//                             if($data->lanjutan->idLanjutan == 1)
//                             {
//                                 return $data->lanjutan->stlanjutan;
//                             }
                       
                             return strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno'=>$data->pengajiansemasa->icno,'idLanjutan'=>2,'HighestEduLevelCd'=>$data->pengajiansemasa->HighestEduLevelCd])->one()->stlanjutan)
                             . ' HINGGA '.strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno'=>$data->pengajiansemasa->icno,'idLanjutan'=>2,'HighestEduLevelCd'=>$data->pengajiansemasa->HighestEduLevelCd])->one()->ndlanjutan) ;
                       
                             
                    
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
//                                return  $data->tajaan->penajaan->penajaan.' - '.strtoupper($data->tajaan->nama_tajaan);

                            },
                            'format' => 'raw'
                            
                        ],
                                    [   
                            
                            'label' => 'LANJUTAN 03',
                            'value' => function ($data){
                                
//                             if($data->lanjutan->idLanjutan == 1)
//                             {
//                                 return $data->lanjutan->stlanjutan;
//                             }
                        
                             return strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno'=>$data->pengajiansemasa->icno,'idLanjutan'=>3,'HighestEduLevelCd'=>$data->pengajiansemasa->HighestEduLevelCd])->one()->stlanjutan)
                             . ' HINGGA '.strtoupper(\app\models\cbelajar\TblLanjutan::find()->where(['icno'=>$data->pengajiansemasa->icno,'idLanjutan'=>3,'HighestEduLevelCd'=>$data->pengajiansemasa->HighestEduLevelCd])->one()->ndlanjutan) ;
                        
                    
                                //return Html::a(ucwords(strtoupper($data->sasaran3->tajukLatihan)));
//                                return  $data->tajaan->penajaan->penajaan.' - '.strtoupper($data->tajaan->nama_tajaan);

                            },
                            'format' => 'raw'
                            
                        ],          
                        
                        
                       
                                 
                        
                    ];


?>
<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12 ">
    <p align="right">  <?= Html::a('Kembali', ['lkk/statistik-jabatan'], 
                        ['class' => 'btn btn-primary btn-sm']) ?></p>
    <div class="x_panel" id="rcorners2">
<!--         <div class="x_title">
          <h4><strong><i class="fa fa-home"></i> Halaman Utama</strong></h4> 
         </div>-->

    <div class="x_title">
            <h5><i class="fa fa-graduation-cap"></i><strong> SENARAI KAKITANGAN BELUM CAPAI TEMPOH 6 BULAN PENGHANTARAN LKP</strong></h5>
            
            <div class="clearfix"></div>
        </div>


    </div>
      </div>
    
   


    <div class="col-md-12 col-sm-12 col-xs-12 ">

        <div class="x_panel">
            <p align ="left">  <?=
                        ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $gridColumns,
                            'filename' => '_senarai_belum_mula_cb'.date('Y-m-d'),
                            'clearBuffers' => true,
                            'stream' => false,
                            'folder' => '@app/web/files/cb/.',
                            'linkPath' => '/files/cb/',
                            'batchSize' => 10,
                        ]);
                        ?></p>
            <div class="x_content">

                <div class="x_title">
<!--                    <h5><strong><i class="fa fa-graduation-cap"></i> SENARAI KAKITANGAN</strong></h5>-->

                    <div class="clearfix"></div>
                </div>
                <div class="table-responsive">
                    <?=
                    GridView::widget([
                        'dataProvider' => $dataProvider,
                        'summary' => '',
                        'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                        'options' => [
                            'class' => 'table-responsive',
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn',
                                'header' => 'BIL.',
                                'headerOptions' => ['style' => 'width:1%', 'class' => 'text-left'],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
//                        [
//                                            'label' => 'NAMA MESYUARAT',
//                                            'value' => function($model) {
//                                             if ($model->mesyuarat->kategori->id == 1) {
//                                               return 'Mesyuarat Jawatankuasa Pengajian Lanjutan Pentadbiran Bil. ' ." ". $model->mesyuarat->nama_mesyuarat." ".'(Kali Ke -' ." ". $model->mesyuarat->kali_ke.")";
//                                                }
//                                                else {
//                                               return 'Mesyuarat Jawatankuasa Pengajian Lanjutan Akademik Bil. ' ." ". $model->mesyuarat->nama_mesyuarat." ".'(Kali Ke -' ." ". $model->mesyuarat->kali_ke.")";
//                                                }
//                                            }
//                                                
//                                        ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'NAMA KAKITANGAN',
                                'options' => ['style' => 'width:40%'],
                                'headerOptions' => ['class' => 'column-title'],
                                'value' => function($model) {
                            $ICNO = $model->icno;
                            $id = $model->id;


                            return Html::a('<strong>' . $model->kakitangan->CONm . '</strong>') . '<br><small>'.
                                    $model->icno.'<br>'.
                                    
                                    $model->kakitangan->department->fullname . '</small>' .
                                    '<br><small>' . $model->kakitangan->jawatan->nama . ' ' .
                                    $model->kakitangan->jawatan->gred ;
                                    
                            ;
                        },
                                'format' => 'html',
                            ],
                            [
                                //'attribute' => 'CONm',
                                'label' => 'MAKLUMAT PENGAJIAN',
                                'headerOptions' => ['style' => 'width:40%', 'class' => 'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                                'value' => function($model) {

                            return Html::a('<strong><small>' . strtoupper($model->InstNm) . '</small></strong><br>' .
                                            '<small>' . $model->tahapPendidikan . '</small><br>' .
                                            '<small>' . strtoupper($model->tarikhmula) . ' HINGGA</small> ' .
                                            '<small>' . strtoupper($model->tarikhtamat) . '</small> ' .
                                            '<small>(' . strtoupper($model->tempohtajaan) . ')</small><br>');
                        },
                                'format' => 'html',
                            ],
                                
                             [
                                //'attribute' => 'CONm',
                                'label' => 'MAKLUMAT BIASISWA',
                                'headerOptions' => ['style' => 'width:40%', 'class' => 'text-left'],
//                            'contentOptions' => ['class'=>'text-center'],
                                'value' => function($model) {

                                return Html::a('<strong><small>' . strtoupper($model->tajaan->penajaan->penajaan) . 
                               '</small></strong><br>');
//                                echo $b->tajaan->penajaan->penajaan.' - '. $b->tajaan->nama_tajaan;
                        },
                                'format' => 'html',
                            ],
//                        [
//                'label' => 'NAMA',
//                'value' => 'kakitangan.CONm',                  
//                ],
//                [
//                'label' => 'TARIKH MOHON',
//                                                'headerOptions' => ['class'=>'column-title'],
//
//                'value' => 'tarikhmohon'
//                ],
//                                   [
//                           //'attribute' => 'CONm',
//                            'label' => 'TINDAKAN',
//                             'options' => ['style' => 'width:10%'],
//                            'headerOptions' => ['class'=>'column-title'],
//                            'value' => function($model) {
//                                $ICNO = $model->icno;
//                                $id = $model->id;
//                                
//                                
//                                return Html::a('<i class="fa fa-graduation-cap">', ['/cutisabatikal/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id'=>$model->iklan_id]);
//                                      
//                            }, 
//                                    'format' => 'html',
//
//                        ],
//                            [
//                                'label' => 'PERINCIAN',
//                                'value' => function($model) {
//                                    $ICNO = $model->icno;
//                                    $id = $model->id;
//
//                                    return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', ['/cutisabatikal/adminview', 'id' => $id, 'ICNO' => $ICNO, 'takwim_id' => $model->iklan_id], [
//                                                'class' => 'btn btn-default',
//                                                'target' => '_blank',
//                                    ]);
//                                },
//                                        'format' => 'raw',
//                                        'contentOptions' => ['class' => 'text-center', 'style' => 'width: 15%;'],
//                                        'vAlign' => 'middle',
//                                        'hAlign' => 'center',
//                                    ],
//                [
//                'label' => 'UMS (PER)',
//                'value' => 'kakitangan.COOldID'
//                ],
//                [
//                'label' => 'JAWATAN & GRED',
//                'value' => 'kakitangan.jawatan.fname'
//                ],
//                [
//                'label' => 'JFPIB',
//                'value' => 'kakitangan.department.fullname'
//                ],
                                ],
                            ]);
                            ?>
                </div>
            </div>
        </div>
    </div>
</div>