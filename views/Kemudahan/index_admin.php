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
<?= \app\widgets\TopMenuWidget::widget(['top_menu' => [74,77,79,81,86,1183,1295,1297,1299,1314], 'vars' => []]); //1303 for admin is taken ?>  
 
           
 <div class="x_panel">
   <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> Dashboard Pentadbir Sistem E-Kemudahan </strong></h2>
            
            <div class="clearfix"></div>
        </div>
<div class="well well-lg">  
<div class="row">
                
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'edit',
                                        'header' => 'Daftar E-Kemudahan',
                                        'text' => '<br>',
                                        'number' => '1',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['kemudahan/new-ekemudahan']);
                    ?>
                </div>

                <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'edit',
                                        'header' => 'Buka / Tutup E-Kemudahan',
                                         'text' => '<br>',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($semakan, ['kemudahan/buka-permohonan']);
                    ?>
           </div> 
           <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'users',
                                        'header' => 'Tambah Admin',
                                         'text' => '<br>',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($semakan, ['kemudahan/tambah-admin']);
                    ?>
           </div>
           <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'line-chart',
                                        'header' => 'Laporan',
                                         'text' => '<br>',
                                        'number' => '4',
                                    ]
                    );
                    echo Html::a($semakan, ['kemudahan/index-laporan']);
                    ?>
           </div>
           <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'search',
                                        'header' => 'Carian Permohonan',
                                         'text' => '<br>',
                                        'number' => '5',
                                    ]
                    );
                    echo Html::a($semakan, ['kemudahan/carian']);
                    ?>
             </div>
    <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'plane',
                                        'header' => 'Penerbangan',
                                         'text' => '<br>',
                                        'number' => '6',
                                    ]
                    );
                    echo Html::a($semakan, ['kemudahan/penerbangan']);
                    ?>
             </div>
          <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'users',
                                        'header' => 'Akses E-kemudahan',
                                         'text' => '<br>',
                                        'number' => '7',
                                    ]
                    );
                    echo Html::a($semakan, ['kemudahan/akses']);
                    ?>
           </div> 

           <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'users',
                                        'header' => 'Akses Tempoh Masa', 
                                         'text' => 'Akses Lebih Tempoh Masa Permohonan',
                                        'number' => '7',
                                    ]
                    );
                    echo Html::a($semakan, ['kemudahan/aksess']);
                    ?>
           </div> 

        </div> 
        </div>
                </div></div>
 
 
    </div>
</div>