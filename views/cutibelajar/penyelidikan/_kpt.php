<?php
$this->registerJs('$(function () {
  $(\'[data-toggle="tooltip"]\').tooltip()
})');
use yii\helpers\Html;
use yii\helpers\Url;    
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Dropdown;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
error_reporting(0); 
$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html((index + 1))
    });
});
';

$this->registerJs($js);
$title = $this->title = 'Pembiayaan / Pinjaman';

?>
<p align ="right">
               
                <?php echo Html::a('Kembali',['tambah-biasiswa', 'id'=>$iklan->id], ['class' => 'btn btn-primary btn-sm']); ?>  
    
            </p>
<div class="col-xs-12 col-md-12 col-lg-12">

<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <center><?= strtoupper('
     UNIT PENGEMBANGAN PROFESIONALISME | BAHAGIAN SUMBER MANUSIA<br/><u> 
     PERMOHONAN PENGAJIAN LANJUTAN SUB KEPAKARAN
 '); ?>
                </strong> </center>
            </span> 
        </div>
    </div>

</div>


<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left', 'id' => 'dynamic-form']]); ?>

     
       
<div class="col-xs-12 col-md-12 col-lg-12">
 <div class="x_panel">
<!--     <strong><p><i>Sila lengkapkan Borang Kementerian Pendidikan Malaysia (KPM) dan muatnaik dokumen tersebut di bahagian menu "Muat Naik Dokumen"</i></p></strong><br>-->
     <i style="color: red;"><b>Permohonan KPT hanya layak diisi sekiranya memiliki Ijazah Sarjana Muda dengan PNGK 3.0 atau Kelas Dua Atas.</b></i>
  <div class="table-responsive">

                    <table class="table table-sm jambo_table table-striped">
                               <tr>
                              <th>1. Lampiran A1:</th>
                          <td style="color: green;" colspan="5"><a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/'
                                  . 'Lampiran A1.2 - BORANG SENARAI SEMAKAN SKPD 2021.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                                A1.2 Borang Senarai Semakan SK 
                         </td>
                        </tr>
                          <tr>
                              <th>1. Lampiran A2:</th>
                          
                         <td style="color: green;" colspan="5">
                              <a href="<?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/'
                                      . 'Lampiran A2.1 - Borang Kursus Dalam Perkhidmatan SKPD 2021.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>
                                A2.1 Bahagian Biasiswa dan Pembiayaan
                         </td>
                          
                        </tr>
                     
                   <tr>
                            <th>2. Lampiran A3:</th>
                            
                             <td style="color: green;" colspan="5"><a href="
                                 <?php echo Url::to('@web/'.'uploads-cutibelajar/cbelajar/dokumen/'
                                         . 'Lampiran A3.1 - COVER DEPAN PENGESAHAN PELAN PENGAJIAN (SARJANA PERUBATAN-SK) 2021.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> 
                                     Klik Sini Untuk Muat Turun</a><br>A3.1 Pengesahan Pelan Pengajian </td>
                   </tr>
                   
                   
    <tr>
                            <th>4. Lampiran A5:</th>
                             <td style="color: green;" colspan="5"><a href="
                                 <?php echo Url::to
                                         ('@web/'.'uploads-cutibelajar/cbelajar/dokumen/'
                                         . 'Lampiran A5 - CV SLAB_SLAI_SK_PD 2021.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br>CV SLAB/SLAI/SK/PD


</td>
                   </tr>
                    </table>
  </div>

      
      
        
</div>
    <div class="x_panel">
    <div class="x_content">
            <?php
            $dataProvider = new ActiveDataProvider([
                'query' => app\models\cbelajar\TblDokumenKpm::find()->where(['status' => 1, 'kategori' => 1]),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            ?> 
            <p style="color:red">Borang KPT yang telah ditandatangan dan disahkan hendaklah dihantar kepada Puan Dayang di Bahagian Sumber Manusia.</p>
            <h4><strong>DOKUMEN BAGI PERMOHONAN KPT</strong></h4>
            <div class="table-responsive ">        
                <?=
                GridView::widget([
                    'dataProvider' => $senarai_dokumenkpm,
                    'options' => ['style' => 'width:100%'],
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['style' => 'width:5%'],
                            'header' => 'NO.'
                        ],
                        [
                            'label' => 'NAMA DOKUMEN',
                            'headerOptions' => ['style' => 'width:60%'],
                            'value' => function($model) {
                        return strtoupper($model->nama_dokumen);
                    },
                        ],
//                                         [
//                                            'header' => 'TINDAKAN',
//                                            'class' => 'yii\grid\ActionColumn',
//                                            'template' => '{muatnaik}',
//                                            'buttons' => [
//                                                'muatnaik' => function($url, $model, $key) use ( $iklan)
//                                                {
//                                                    if ($model->checkUpload($model->id, $iklan->id)) {
//                                                        return '<i class="fa fa-check-circle  fa-lg" aria-hidden="true" style="color: green"></i>';
//                                                    } else {
//                                                        return Html::a('Muatnaik', ['muat-naik-dokumen', 'id' => $model->id,'iklan_id' => $iklan->id], ['class' => 'btn  btn-primary btn-xs']);
//                                                    }
//                                                }
//                                        ],
//                                                
//                                        
//                                          'contentOptions' => ['class' => 'text-center'],
//                                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            //'attribute' => 'CONm',
                            'header' => 'TINDAKAN',
                            'headerOptions' => ['class' => 'text-center'],
                            'contentOptions' => ['class' => 'text-center'],
                            'template' => '{update}',
                            //'header' => 'TINDAKAN',
                            'buttons' => [
                                'update' => function ($url, $model) use ($iklan) {
                                    if ($model->checkUpload($model->id, $iklan->id)) {
                                        return
                                                '<i class="fa fa-check-circle fa-lg" aria-hidden="true" style="color: green"></i>';
                                    } else {
                                        $url = Url::to(['muat-naik-dokumen-kpt', 'id' => $model->id, 'iklan_id' => $iklan->id]);
                                        return Html::button('<span class="glyphicon glyphicon-edit"></span>', ['value' => $url, 'class' => 'btn btn-primary btn-xs modalButton']);
                                    }
                                },
                                    ],
                                ],
//                                [
//                                    'label' => 'MUAT TURUN',
//                                    'format' => 'raw',
//                                    'headerOptions' => ['class' => 'text-center'],
//                                    'contentOptions' => ['class' => 'text-center'],
//                                    'value' => function ($data) {
//
//                                        if((!empty($data->nama_dokumen))&& (!empty($data->sokongan->namafile))) {
//                                    return Html::a('', (Yii::$app->FileManager->DisplayFile($data->sokongan->namafile)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']);
//                                } else {
//                                    return '<b><small>TIADA BUKTI</small></b>';
//                                }
//                            },
//                                ],
                                    [
                                            'label' => 'MUAT TURUN',
                                            'format' => 'raw',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'contentOptions' => ['class' => 'text-center'],
                                            'value' => function ($data) {

                                        if((!empty($data->nama_dokumen))&& (!empty($data->sokongan->namafile))) {
                                            return Html::a('', (Yii::$app->FileManager->DisplayFile($data->sokongan->namafile)), ['class' => 'fa fa-download fa-lg', 'target' => '_blank']). ' | '.
                                                 Html::a('<i class="fa fa-trash fa-lg" aria-hidden="true"></i>',['delete-dokumen-kpt?id='.$data->sokongan->id.'&i='.$data->sokongan->iklan_id], [
                                        'data' => [
                                        'confirm' => 'Anda ingin membuang rekod ini?',
                                        'method' => 'post',
                                        ],
                                    ]);
                                        } 
                                        else {
                                            return '<b><small>TIADA BUKTI</small></b>';
                                        }
                                    },
                                        ],
//                                    [
//                            'class' => 'yii\grid\ActionColumn',
//                            //'attribute' => 'CONm',
//                            'header' => 'TINDAKAN',
//                            'headerOptions' => ['class' => 'text-center'],
//                            'contentOptions' => ['class' => 'text-center'],
//                            'template' => '{delete}',
//                            //'header' => 'TINDAKAN',
//                            'buttons' => [
//                                'delete' => function ($url, $model) {
//                                  $url = Url::to(['cbelajar/delete-dokumen-kpm?id='.$model->id,]);
//                                        return Html::button('<span class="glyphicon glyphicon-trash"></span>', ['value' => $url, 'class' => 'btn btn-default btn-xs']);
//                                   
//                                },
//                                    ],
//                                ],
                                    
                            // [
                            //     'label' => 'Status',
                            // ],
                            ],
                        ]);
                        ?>
                    </div>

                </div>
    </div>

</div>

        <?php ActiveForm::end(); ?>
  
  



