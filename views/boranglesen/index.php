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
use yii\helpers\ArrayHelper; 
use app\models\kemudahan\Reftujuan;
error_reporting(0);
$tujuan = ArrayHelper::map(Reftujuan::find()->all(), 'id', 'tujuan');
 
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
<?php $this->title = 'Borang Online';?>
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86], 'vars' => []]); ?>
  
<div class="row">
   <div class="col-xs-12 col-md-12 col-lg-12">
        
 
<div class="x_content"> 
 <div class="x_panel">
   <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Permohonan Tuntutan Staf Secara Atas Talian(On-line): Bayaran Balik</strong></h2>
            <p align="right"><?= Html::a('Kembali', ['kemudahan/lihattuntutan'],['class' =>'btn btn-default btn-sm']) ?></p>
            
            <div class="clearfix"></div>
        </div>
<div class="well well-lg"> 


          
<div class="row">
                
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'drivers-license-o',
                                        'header' => 'Lesen Memandu',
                                        'text' => '<br>',
                                        'number' => '1',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['boranglesen/form_lesen']);
                    ?>
                </div>

                <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'id-badge',
                                        'header' => 'Pasport',
                                         'text' => '<br>',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($semakan, ['borangpasport/form_pasport ']);
                    ?>
           </div>
    
                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'angle-double-right',
                                        'header' => 'Pakaian Istiadat',
                                         'text' => '<br>',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($semakan, ['pakaian-istiadat/form_pakaian']);
                    ?>
           </div>
    <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'list',
                                        'header' => 'Tambang Belas Ehsan',
                                        'text' => '<br>',
                                        'number' => '4',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['borangehsan/form_pemohon']);
                    ?>
                </div>

                <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'mobile',
                                        'header' => 'Alat Komunikasi',
                                         'text' => '<br>',
                                        'number' => '5',
                                    ]
                    );
                    echo Html::a($semakan, ['borang-alat/maklumat-pembelian']);
                    ?>
           </div>
    
                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'bars',
                                        'header' => 'Yuran / Badan Ikhtisas',
                                         'text' => '<br>',
                                        'number' => '6',
                                    ]
                    );
                    echo Html::a($semakan, ['borangyuran/maklumat-yuran']);
                    ?>
           </div>
    <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'black-tie',
                                        'header' => 'Pakaian Seragam',
                                        'text' => '<br>',
                                        'number' => '7',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['boranguniform/maklumat-seragam']);
                    ?>
                </div>

                <!-- <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'home',
                                        'header' => 'Perpindahan Rumah',
                                         'text' => '(LPPSA)',
                                        'number' => '8',
                                    ]
                    );
                    echo Html::a($semakan, ['borangperpindahan/maklumat-perpindahan', 'id' => 1 ]);
                    ?>
           </div>
    
                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'truck',
                                        'header' => ' Pengangkutan Barang',
                                         'text' => '<br>',
                                        'number' => '9',
                                    ]
                    );
                    echo Html::a($semakan, ['borangpengangkutan/maklumat-pengangkutan', 'id' => 4 ]);
                    ?>
           </div> -->
    
          
            
                
               
       </div>
                


        </div>
                </div></div>
    </div>
</div>
