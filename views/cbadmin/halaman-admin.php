<?php
$js = <<<js
    $('.modalButton').on('click', function () {
        $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
    });
js;
$this->registerJs($js);
$this->registerJsFile('@web/js/circleprogress.js');

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
error_reporting(0);
$this->title = 'Halaman Utama';

?> 

<style>
    @media screen and (min-width: 701px) {
        .app1 {
          width: 280px;}}
     @media screen and (max-width: 700px) {
        .app1 {
          width: 200px;}}
    .app1{
        background-color: #efefef;
        height: 50px;
        white-space: normal;
    }
    div.scrollmenu {
  overflow: auto;
  white-space: nowrap;
}

.labelc{
    font-size: 18px;
}
.canvasc {
    display: block;
    position:absolute;
    top:0;
    left:0;
}
.spanc {
    color:#555;
    display:grid;
    text-align:center;
    font-family:sans-serif;
    font-size:16px;
    height: 100px;
    align-items: center;
    width: 100px;
    
}

.appname{
        white-space: normal;
    
}

.table > tbody > tr > td, .table > tfoot > tr > td{
    border-top: none;
}
</style>
 <div class="row">
       <?php echo $this->render('/cutibelajar/_topmenu'); ?>

   <div class="col-xs-12 col-md-12 col-lg-12">

<!--    <div class="x_panel scrollmenu">
                     <div class="x_content">    

        <div class="x_title">
            <h2><i class="fa fa-pie-chart"></i><b> STATISTIK DILULUS</b></h2>
            <div class="clearfix"></div>
        </div>
            <table class="table">
                <tr>
                    <td><h2><b>AKADEMIK</b></h2></td>
                    <td><h2><b>PENTADBIRAN</b></h2></td>
                    <td><h2><b>JUMLAH KESELURUHAN</b></h2></td>

                </tr>
                <tr>
                    <td width="320px">
                        <div class="col-md-12 col-sm-12 col-xs-12 app1" style="padding-left:0px">
                            <div class="col-md-4 col-sm-4 col-xs-4" style="height: 100%; background-color: #0ED1AB!important; color:white;"><br>
                            </div>
                            <div class="appname"><center><b><h4>TIDAK AKTIF CUTI BELAJAR</h4></center></b></div>
                        </div>
                    </td>
                     
               
                 
                      
                    <td width="320px">
                        <div class="col-md-12 col-sm-12 col-xs-12 app1" style="padding-left:0px">
                            <div class="col-md-4 col-sm-4 col-xs-4" style="height: 100%; background-color: #0ED1AB!important; color:white;"><br>
                            </div>
                            
                            <div class="appname"><center><b><h4>TIDAK AKTIF CUTI BELAJAR</h4></center></b></div>
                        </div>
                    </td>
                    
                    <td >
                        <div class="col-md-12 col-sm-12 col-xs-12 app1" style="padding-left:0px">
                            <div class="col-md-4 col-sm-4 col-xs-4" style="height: 100%; background-color: #0ED1AB!important; color:white;"><br>
                            </div>
                            
                            <div class="appname"><center><b><h4>PERMOHONAN KESELURUHAN</h4></center></b></div>
                        </div>
                    </td>
                </tr>
                
                
            </table>
    </div>
    </div>-->
          <div class="col-xs-12 col-md-12 col-lg-12">

<div class="row">

       <div class=" scrollmenu ">
    <div class="x_panel">
        <div class="x_title">
            <h6><i class="fa fa-pie-chart" style="color:blueviolet"></i><b> STATISTIK DILULUSKAN PENGAJIAN LANJUTAN</b></h6>
            <div class="clearfix"></div>
        </div>
            <table class="table" style="text-align: center">
                <tr>
                    <td width="500px;">
                        <div class="labelc"><i class="fa fa-book"  style="color:green"></i><h5> AKADEMIK</h5></div>
                        
                       
                        <a href="../lkk/senarai-all-study?category=0" target="_blank"  title="Senarai Akademik"><strong><div class="chart" id="graph" data-color="green" data-text="<?= $lulus ?> / <?= $p ?> " data-size="100" data-line="10" data-percent="<?= (($lulus / $p) * 100)  ;?>"></div></strong></a>
<!--                                <span class="name"><a href="senarai-all-study?category=0" target=_blank" class="btn btn-primary btn-sm"> Waiting <i class="fa fa-edit"></i></a> </span>-->

                    </td>
                    
                    <td width="500px;">
                        <div class="labelc"><i class="fa fa-user"  style="color:blue"></i><h5> PENTADBIRAN</h5></div>
                        <a href="../lkk/senarai-all-study?category=1" target="_blank" title="Senarai Pentadbiran"><strong><div class="chart" id="graph" data-color="blue" data-text="<?= $status_p?> / <?= $q ?>" data-size="100" data-line="10" data-percent="<?= $status_p / $q * 100?>"></div></strong></a>
                        
                    </td>
                    
                    <td width="500px;">
                        <div class="labelc"><i class="fa fa-users"  style="color:yellowgreen"></i> <h5>JUMLAH PERMOHONAN</h5></div>
                        <a href="../lkk/senarai-all-study?category=2" target="_blank"  title="Senarai Keseluruhan"><strong><div class="chart" id="graph" data-color="yellowgreen"  data-text="<?= $jumlah_permohonan ?> / <?=$p + $q?>" data-size="100" data-line="10" data-percent="<?= (($jumlah_permohonan / ($p+$q)) * 100) ;?>"></div></strong></a>

                    </td>
                    

                </tr>
            </table>
        </div>
</div>
          </div>
</div>
    <div class="x_panel">
        
<!--        <div class="x_title">
            <strong><h2>Halaman Utama</strong></h2>
            <div class="clearfix"></div>
        </div>-->

<?php $year = date('Y'); ?>
                <div class="x_title">
            <h6><i class="fa fa-calendar" style="color:blueviolet"></i><b> TAKWIM SEMASA MESYUARAT PENGAJIAN LANJUTAN <?= $year?></b></h6>
            <div class="clearfix"></div>
        </div>

     <p align="left"><?= Html::a('TAMBAH TAKWIM', ['cbelajar/tambah-iklan'], ['class' => 'btn btn-primary btn-xs']) ?></p>
             <div class="x_content">    
                                    <div class="table-responsive">
                                        <?=
                                        GridView::widget([
                                            'dataProvider' => $iklan_semasa,
                                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                                            'layout' => "{items}\n{pager}",
                                            'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => ''],
                                            'columns' => [
                                                ['class' => 'yii\grid\SerialColumn','header' => 'BIL.'],
                                                
                                                  [
                                            'label' => 'NAMA MESYUARAT',
                                            'value' => function($model) {
                                             if ($model->kategori->id == 1) {
                                               return
                                                 'MESYUARAT JAWATANKUASA PENGAJIAN LANJUTAN PENTADBIRAN BIL. ' ." ". $model->nama_mesyuarat." ".''
                                                       . '(KALI KE -' ." ". $model->kali_ke.")";
                                                }
                                                else {
                                               return 'MESYUARAT JAWATANKUASA PENGAJIAN LANJUTAN AKADEMIK BIL. ' ." ". $model->nama_mesyuarat." ".'(KALI KE -' ." ". $model->kali_ke.")";
                                                }
                                            }
                                                
                                        ],

                                        [
                                            'label' => 'KATEGORI',
                                            'value' => function($model) {
                                                if ($model->kategori->id == 1) {
                                                    return 'PENTADBIRAN';
                                                } else {
                                                    return 'AKADEMIK';
                                                }
                                            },
                                        ],

                                        [
                                            'label' => 'TARIKH MESYUARAT ',
                                            'value' => function($model) {
                                               return strtoupper($model->getTarikh($model->tarikh_mesyuarat));
                                            },
                                        ],
                                      
                                        [
                                            'label' => 'TARIKH BUKA',
                                            'value' => function($model) {
                                                return strtoupper($model->getTarikh($model->tarikh_buka));
                                            },
                                        ],
                                        [
                                            'label' => 'TARIKH TUTUP',
                                            'value' => function($model) {
                                                return strtoupper($model->getTarikh($model->tarikh_tutup));
                                            },
                                        ],
//                                                       [
//                                    'label' => 'Jumlah Permohonan',
//                                    'value' => function($model) { 
//                                        return '<b><u><a href=' . Url::to(['cutibelajar/senarai', 'id' => $model->id]) . '>' . $model->jumlahPermohonanbySemasa($model->id). '</span></b>';
//                                    },
//                                    'format' => 'raw',
//                                    'contentOptions' => ['class' => 'text-center'],
//                                ], 
                                           [
                                            'label' => 'TINDAKAN',
                                            'headerOptions' => ['class' => 'text-center'],
                                            'value' => function($model) {

                                                $url = Url::to(['/cbelajar/nyahaktif-takwim', 'id' => $model->id]);
                                                return Html::button('NYAHAKTIFKAN', ['value' => $url, 'class' => 'btn btn-danger btn-xs modalButton']);
                                            },
                                                    'format' => 'raw',
                                                    'contentOptions' => ['class' => 'text-center'],
                                                ],
                                                    
                                            

                                                                
                                                                    ],
                                                                ]);
                                                                ?>
                                                            </div>           

                                                        </div>
</div>

                             
                                                </div>  
                                            </div>
                                         
                                        <?php
                                        Modal::begin([
                                            'header' => '<strong>KEMASKINI MESYUARAT PENGAJIAN LANJUTAN</strong>',
                                            'id' => 'modal',
                                            'size' => 'modal-lg',
                                        ]);
                                        echo "<div id='modalContent'></div>";
                                        Modal::end();
      
                                        ?>

<div class="x_panel">
       <div class="x_title">
            <h6><i class="fa fa-user-md" style="color:blueviolet"></i><b> DASHBOARD ADMIN</b></h6>
            <div class="clearfix"></div>
        </div>
<div class="well well-lg"> 
    
                <div class="row ">
<div class="x_content"> 


            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list-alt',
                                        'header' => '                                                                                           PERMOHONAN<br>BAHARU',
                                        'text' => 'Pengajian Lanjutan',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($resume, ['cbadmin/page-semak']);
        
                    ?>

                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'address-card',
                                        'header' => 'REKOD PENGAJIAN<br>LANJUTAN ',
                                        'text' => 'Data Kakitangan Diluluskan',
                                        'number' => '2',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['cbadmin/search']);
                    ?>
                </div>

                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'bar-chart',
                                        'header' => 'LAPORAN KEMAJUAN<br>PENGAJIAN (LKP)',
                                        'text' => 'Rekod Penghantaran LKP',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($semakan, ['cbadmin/search-lkk']);
                    ?>
           </div>
                
            
                
               
       </div>
    
<div class="row">
                <div class="col-xs-12 col-md-4">
                    <?php
                    $resume = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'suitcase',
                                        'header' => 'LAPOR DIRI',
                                        'text' => 'Kakitangan Akademik & Pentadbiran',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($resume, ['cbadmin/page-lapor']);
        
                    ?>

                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'calculator',
                                        'header' => 'BON PERKHIDMATAN',
                                        'text' => 'Nominal Damages & Pecah Kontrak',
                                        'number' => '5',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['page']);
                    ?>
                </div>

                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'money',
                                        'header' => 'BIASISWA / BAYARAN',
                                        'text' => 'Rekod Berkaitan Kewangan & Saraan',
                                        'number' => '6',
                                    ]
                    );
                    echo Html::a($semakan, ['cbadmin/page-tuntutan']);
                    ?>
           </div>
                
            
                
               
       </div>
                


        </div>
                </div></div>
</div>