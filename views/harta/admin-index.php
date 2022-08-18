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
// use app\models\kemudahan\Reftujuan;
error_reporting(0);
// $tujuan = ArrayHelper::map(Reftujuan::find()->all(), 'id', 'tujuan');
 
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

<div class="col-md-12 col-xs-12"> 
    <?php echo $this->render('/harta/_menu');?>
</div>

<div class="row">
   <div class="col-xs-12 col-md-12 col-lg-12">
        
      
<div class="x_content"> 
 <div class="x_panel">
   <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> ADMIN DASHBOARD</strong></h2>
            
            <div class="clearfix"></div>
        </div>
<div class="well well-lg"> 


          
<div class="row">
                
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'drivers-license-o',
                                        'header' => 'Senarai Permohonan',
                                        'text' => '<br>',
                                        'number' => '1',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['list-senarai']);
                    ?>
                </div>

                <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'id-badge',
                                        'header' => 'Data Mesyuarat',
                                         'text' => '<br>',
                                        'number' => '2',
                                    ]
                    );
                    echo Html::a($semakan, ['data-mesyuarat']);
                    ?>
           </div>
    
                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
//                                        'icon' => 'angle-double-right',
                                        'icon' => 'wpforms',
                                        'header' => 'Tambah Admin',
                                         'text' => '<br>',
                                        'number' => '3',
                                    ]
                    );
                    echo Html::a($semakan, ['tambah-admin']);
                    ?>
           </div>
    <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'edit',
                                        'header' => 'Tambah Ahli Mesyuarat',
                                        'text' => '<br>',
                                        'number' => '4',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['tambah-ahli-mesyuarat']);
                    ?>
                </div>

                <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'mobile-phone',
                                        'header' => 'Pengumuman',
                                         'text' => '<br>',
                                        'number' => '5',
                                    ]
                    );
                    echo Html::a($semakan, ['pengumuman']);
                    ?>
           </div>
    
                 <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'edit',
                                        'header' => 'Statistik',
                                         'text' => '<br>',
                                        'number' => '6',
                                    ]
                    );
                    echo Html::a($semakan, ['dashboard']);
                    ?>
           </div>
   

            
                
               
       </div>
                


        </div>
                </div></div>
    </div>
</div>