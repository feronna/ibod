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
   <div class="col-xs-12 col-md-12 col-lg-12">
       <?php echo $this->render('/cutibelajar/_topmenu'); ?>

  

         <div class="x_content"> 
              <div class="x_panel">
                   <div class="x_title">
            <h2><strong><i class="fa fa-user-secret"></i> DASHBOARD</strong></h2>
            <p align="right"><?= Html::a('Kembali', ['cbadmin/halaman-admin'], 
         ['class' => 'btn btn-primary btn-sm']) ?></p>
            
            <div class="clearfix"></div>
        </div>
                                      
<div class="well well-lg"> 


          
<div class="row">
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'calendar',
                                        'header' => 'JAN-MAC ',
                                        'text' => 'Pembayaran Elaun Kakitangan',
                                        'number' => '1',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['cbadmin/search-cb']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'calendar',
                                        'header' => 'APRIL-JUN ',
                                        'text' => 'Pembayaran Elaun Kakitangan',
                                        'number' => '2',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['cbadmin/senaraitindakanlapor']);
                    ?>
                </div>

                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'calendar',
                                        'header' => 'JUL-SEPT ',
                                        'text' => 'Pembayaran Elaun Kakitangan',
                                        'number' => '3',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['cbadmin/search-lapor']);
                    ?>
                </div>
    
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'calendar',
                                        'header' => 'OKT-DISEMBER ',
                                        'text' => 'Pembayaran Elaun Kakitangan',
                                        'number' => '4',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['cbadmin/search-lapor']);
                    ?>
                </div>

                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'university',
                                        'header' => 'BAYARAN UMS',
                                        'text' => 'Pembayaran Yuran Pengajian & Tiket Penerbangan',
                                        'number' => '5',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['cbadmin/search-lapor']);
                    ?>
                </div>
    
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'th-list',
                                        'header' => 'LAIN-LAIN PERKARA',
                                        'text' => 'Elaun Tesis/Visa/Insurans',
                                        'number' => '5',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['cbadmin/search-lapor']);
                    ?>
                </div>
                 
    
           
                
            
                
               
       </div>
                


        </div>
                </div></div>
    </div>
</div>
