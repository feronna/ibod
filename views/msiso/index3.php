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
<?= $this->render('menu') ?> 

<div class="row">
    
           
 <div class="x_panel">
   <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> MISO-AUDIT DALAM </strong></h2>
            
            <div class="clearfix"></div>
        </div>
<div class="well well-lg">  
<div class="row">
                
              
                <div class="col-xs-12 col-md-4">
                    <?php
                    $semakan = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'certificate',
                                        'header' => 'Tambah Klausa',
                                         'text' => '<br>',
                                        'number' => '1',
                                    ]
                    );
                    echo Html::a($semakan, ['clause/tambah-klausa']);
                    ?>
           </div>
      
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'check',
                                        'header' => 'Senarai Klausa',
                                        'text' => '<br>',
                                        'number' => '2',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['clause/senarai-klausa']);
                    ?>
                </div>

                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'user-secret',
                                        'header' => 'Auditor',
                                        'text' => '<br>',
                                        'number' => '3',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['msiso/tambah-auditor']);
                    ?>
                </div>

                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'th-list',
                                        'header' => 'OFI',
                                        'text' => '<br>',
                                        'number' => '4',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['msiso/ofi-general']);
                    ?>
                </div>

                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'th-list',
                                        'header' => 'Paparan OFI',
                                        'text' => '<br>',
                                        'number' => '5',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['msiso/senarai-ofi']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'th-list',
                                        'header' => 'NCR',
                                        'text' => '<br>',
                                        'number' => '6',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['msiso/ncr-form']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'th-list',
                                        'header' => 'Paparan NCR',
                                        'text' => '<br>',
                                        'number' => '6',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['msiso/senarai-ncr']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'th-list',
                                        'header' => 'Notification Letter',
                                        'text' => '<br>',
                                        'number' => '7',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['msiso/notification-letter']);
                    ?>
                </div>
                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'th-list',
                                        'header' => 'Audit Plan',
                                        'text' => '<br>',
                                        'number' => '8',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['msiso/audit-plan']);
                    ?>
                </div>

                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'th-list',
                                        'header' => 'List Audit Plan',
                                        'text' => '<br>',
                                        'number' => '9',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['msiso/senarai-audit-plan']);
                    ?>
                </div>

                <div class="col-xs-12 col-md-4">
                    <?php
                    $dokumen = \yiister\gentelella\widgets\StatsTile::widget(
                                    [
                                        'icon' => 'th-list',
                                        'header' => 'User Access',
                                        'text' => '<br>',
                                        'number' => '10',
                                    ]
                    ); 
                    echo Html::a($dokumen, ['msiso/akses']);
                    ?>
                </div>
        </div> 
        </div>
                </div></div>
 
 