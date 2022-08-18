
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

error_reporting(0);

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'label' => 'Tarikh Maklumbalas',
            'attribute' =>  'tarikhMaklumbalas',
        ],
          [
            'format' => 'raw',
            'label' => 'Pemaklumbalas',
           // 'attribute' =>  'kakitangan.CONm',
            'format' => 'raw',
            'value' => function ($data) {
            return  strtoupper($data->kakitangan->CONm);
         }
        ],
        
         [
            'label' => 'Jabatan',
         //   'attribute' =>  'kakitangan.department.fullname',
            'format' => 'raw',
            'value' => function ($data) {
            return  strtoupper($data->kakitangan->department->fullname);
         }
        ],
        
          [
            'label' => 'Maklumbalas',
               'format' => 'raw',
            'attribute' =>  'maklumbalas_ptj',
        ],
        
           [
            'label' => 'Pegawai Peraku',
           // 'attribute' =>  'namaChief.chiefBiodata.CONm',
            'format' => 'raw',
            'value' => function ($data) {
            return  strtoupper($data->pegawaiPeraku->CONm);
         }
        ],

           [
            'label' => 'Status Perakuan',
            'format' => 'raw',
           'value' => function ($data) {
          $statusLabel = [
           0 => '<span class="label label-danger">BELUM DIPERAKUKAN</span>',
           1 => '<span class="label label-success">DIPERAKUKAN</span>',
           2 => '<span class="label label-danger">DITOLAK</span>',
           ];
            return  $statusLabel[$data->status_kj];
         }
         
        ],
        

           [
            'label' => 'Tarikh Perakuan',
            'value' => function ($data) {
            if($data->tarikh_perakuan == null){
                return 'BELUM DIPERAKUKAN';
            }else{
                return  $data->tarikhPerakuan;
            }
         
         }
         
        ],
                
//                
//         [
//            'label' => 'Perakuan Ketua',
//            'value' => function ($data) {
//            if($data->perakuan_kj == null){
//                return '';
//            }else{
//                return  $data->perakuan_kj;
//            }
//         
//         }
//         
//        ],
        
// 
// 
//        
//                
//     [
//            'label' => 'Penyelia JAFPIB',
//            'format' => 'raw',
//            'value' => function ($data) {
//            return  strtoupper($data->penyeliaPtj->CONm);
//         }
//                 
//        ],  
  
//        
//        [
//            'label' => 'Maklumbalas',
//            'format' => 'raw',
//            'value' => function ($data) {
//            
//            return Html::a($data->TugasUtama($data->id) );
//         }
//         
//        ]
         

    ],
]);
        
   ?>

