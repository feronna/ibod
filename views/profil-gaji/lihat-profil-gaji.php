<?php
use yii\widgets\DetailView;
$statusLabel = [
        '1' => 'Monthly',
        '2' => 'Part-time/Claims-based Salary',
        '3' => 'Bonus/Cash Assist (Separate)',
        '4' => 'BOD'
];
?>


<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><strong><i class="fa fa-money"></i> Maklumat Profil Gaji</strong></h2>

                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                
<div class="table-responsive">
    <?= DetailView::widget([
        'model' => $detail,
        'attributes' => [
          
            ['label'=> 'Tarikh Mula',
             'value' =>  strtoupper($detail->tarikhMula),
             'contentOptions' => ['style'=>'width:auto'],
             'captionOptions' => ['style'=>'width:26%'],],
            ['label'=> 'Tarikh Akhir',
                    'value' => function($data){
                              if($data->SS_END_DATE == '0000-00-00 00:00:00'){
                                return '';
                             }else{
                               return $data->tarikhTamat;
                             }
                            },
                    
             'format' => 'raw',
              ],
             ['label'=> 'Jenis Gaji',
             'value' =>  strtoupper($statusLabel[$detail->SS_SALARY_TYPE])],
             ['label'=> 'Status Gaji',
            'value' => function($data){
                              if($data->SS_SALARY_STATUS == 'Y'){
                                return '<span class="label label-success">&#10004</span>';
                              }if($data->SS_SALARY_STATUS == 'N'){
                               return '<span class="label label-danger">&#10006</span>';
                              }
                            },
                    
             'format' => 'raw',
              ],
             ['label'=> 'Kadar Harian/Jam',
             'value' =>  $detail->SS_RATE],
             ['label'=> 'Cukai',
               'value' => function($data){
                              if($data->SS_EPF_STATUS == 'Y'){
                                return '<span class="label label-success">&#10004</span>';
                              }if($data->SS_EPF_STATUS == 'N'){
                               return '<span class="label label-danger">&#10006</span>';
                              }
                            },
                    
             'format' => 'raw',
             ],
             ['label'=> 'Kategori Cukai',
             'value' => strtoupper($detail->kategoriCukai->TC_CATEGORY_DESC)],
             ['label'=> 'Formula Cukai',
             'value' => strtoupper($detail->formulaCukai->TFT_DESC)],
            ['label'=> 'Cukai Bayar Zakat?',
              'value' => function($data){
                              if($data->SS_ZAKAT_STATUS == 'Y'){
                                return '<span class="label label-success">&#10004</span>';
                              }if($data->SS_ZAKAT_STATUS == 'N'){
                               return '<span class="label label-danger">&#10006</span>';
                              }
                            },
                    
             'format' => 'raw',
             ],
            ['label'=> 'Zakat Bayar Kepada',
             'value' => strtoupper($detail->SS_ZAKAT_CODE) ],
            ['label'=> 'KWSP',
             'value' => function($data){
                              if($data->SS_TAX_STATUS == 'Y'){
                                return '<span class="label label-success">&#10004</span>';
                              }if($data->SS_TAX_STATUS == 'N'){
                               return '<span class="label label-danger">&#10006</span>';
                              }
                            },
                    
             'format' => 'raw',
             ],
               ['label'=> 'Jenis KWSP',
             'value' => strtoupper($detail->jenisKwsp->ET_DESC) ],
              ['label'=> 'Kaedah Kiraan',
             'value' => strtoupper($detail->SS_EPF_METHOD)  ],
              ['label'=> 'Pekerja %',
             'value' => strtoupper($detail->SS_EPF_EMPYEE_PCT) ],
              ['label'=> 'Majikan %',
             'value' => strtoupper($detail->SS_EPF_EMPYER_PCT) ],
            ['label'=> 'PERKESO?',
            'value' => function($data){
                              if($data->SS_SOCSO_STATUS == 'Y'){
                                return '<span class="label label-success">&#10004</span>';
                              }if($data->SS_SOCSO_STATUS == 'N'){
                               return '<span class="label label-danger">&#10006</span>';
                              }
                            },
                    
             'format' => 'raw',
             ],
            ['label'=> 'Jenis PERKESO',
             'value' => strtoupper($detail->jenisPerkeso->ST_DESC)],
            ['label'=> 'Pencen?',
            'value' => function($data){
                              if($data->SS_PENSION_STATUS == 'Y'){
                                return '<span class="label label-success">&#10004</span>';
                              }if($data->SS_PENSION_STATUS == 'N'){
                               return '<span class="label label-danger">&#10006</span>';
                              }
                            },
                    
             'format' => 'raw',
             ],
            ['label'=> 'Sebab Perubahan',
             'value' => strtoupper($detail->SS_CHANGE_REASON)  ],
       
        ],
    ]) ?>
               </div>
          
               
            </div>
        </div>
    </div>
</div>
