<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
//use app\assets\AppAsset;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


error_reporting(0);

//$bundle = yiister\gentelella\assets\Asset::register($this);
//AppAsset::register($this);

/* * * for popover PENCERAMAH & INFO **** */
$js = <<< 'SCRIPT'
/* To initialize BS3 tooltips set this below */
$(function () { 
    $("[data-toggle='tooltip']").tooltip(); 
});
/* To initialize BS3 popovers set this below */
$(function () { 
   $("[data-toggle='popover']").popover();
//    $("[data-trigger='focus']").popover();
//    $('.popover-dismiss').popover({
//        trigger: 'focus'
//        })
});
//$(function() {
//    // use the popoverButton plugin
//    $('#kv-btn-1').popoverButton({
//        placement: 'left', 
//        target: '#myPopover5'
//    });
//});
$(function() {
    $('#testHover').popoverButton({
        trigger: 'hover focus',
        target: '#myPopover6'
    });
});
SCRIPT;
// Register tooltip/popover initialization javascript
$this->registerJs($js);
?>
<!---- Hide previous modal screen ---->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        $("#modal").on('hidden.bs.modal', function(){
        $('#modalContent').empty();
  });
    });
</script>
<!--- /Hide previous modal screen ---->
<!--<style>
a:link {
  color: green;
  background-color: transparent;
  text-decoration: none;
}
a:visited {
  color: indigo;
  background-color: transparent;
  text-decoration: none;
}
a:hover {
  color: red;
  background-color: transparent;
  text-decoration: underline;
}
a:active {
  color: yellow;
  background-color: transparent;
  text-decoration: underline;
}
</style>-->
    <?php echo $this->render('/cutibelajar/_topmenu'); ?>

<p align="right"> <?= Html::a('Back', ['cb-lkk/halaman-penyelia-ums'], ['class' => 'btn btn-primary btn-sm']) ?></p>
  <div class="x_content">

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">

<div class="x_panel">
        <div class="x_content">  
            <span class="required" style="color:#062f49;">
                <strong>
                    <i class="fa fa-list"></i> STUDENT (UMS STAFF) UNDER SUPERVISED 
                   </strong> 

            </span> 
        </div>
</div>  </div></div></div>
            <div class="x_content">
                
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
<!--            <div class="x_title">
                <h2>Staf Pentadbiran</h2>
                <div class="clearfix"></div>
            </div>-->
            <div class="x_title">
                <h5><b> <i class="fa fa-th-list"></i> LIST OF STUDENTS</b></h5><div  class="pull-right">
            </div>
            
        </div>
            <div class="x_content">
               <?= 
                        GridView::widget([
                            'dataProvider' => $dataProvider,
                            //'filterModel' => $kursusJemputan,
                            'emptyText' => 'No Record Found.',
                            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => '<i><b>TIADA DATA</b></i>'], 
                            'headerRowOptions' => ['style' => 'background: rgba(52, 73, 94, 0.94); color: #ECF0F1;'],
                            'columns' => [
                                ['class' => 'kartik\grid\SerialColumn',
                                    'header' => 'BIL',
                                    'vAlign' => 'middle',
                                    'hAlign' => 'center',
                                ],
//                                [
//                                    'label' => 'Nama',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'left',
//                                    'format' => 'raw',
//                                    'value' => 'biodata.CONm',
//                                    'contentOptions' => ['style' => 'width:150px; white-space: normal;'],
//                                ],
                                [
                           //'attribute' => 'CONm',
                            'label' => 'NAME',
                            'headerOptions' => ['class'=>'column-title'],
//                             'filter' => Select2::widget([
//                            'name' => 'icno',
//                            'value' => isset(Yii::$app->request->queryParams['icno'])? Yii::$app->request->queryParams['icno']:'',
//                            'data' => ArrayHelper::map(\app\models\cbelajar\TblPengajian::find()->where(['cb_tbl_pengajian.status'=>1])->joinWith('kakitangan.department')->all(), 'icno', 'kakitangan.CONm'),
//                            'options' => ['placeholder' => ''],
//                            'pluginOptions' => [
//                                'allowClear' => true
//                            ],
//                        ]),
                            'value' => function($model) {
                                $ICNO = $model->icno;
                                return Html::a('<strong>'.$model->kakitangan->CONm.'</strong>').
                                        '<br><small>'.$model->kakitangan->jawatan->nama.' '.
                                        '('.$model->kakitangan->jawatan->gred.')';
                            }, 
                                    
                                    'format' => 'html',
                        ],
//                                [
//                                    'label' => 'GRED',
//                                    'vAlign' => 'middle',
//                                    'hAlign' => 'center',
//                                    'format' => 'raw',
//                                    'value' => 'kakitangan.jawatan.gred',
//                                    'contentOptions' => ['style' => 'width:75px; white-space: normal;'],
//                                ],
                                    [
                        'label' => 'UNIVERSITY & EDUCATION LEVEL',
                        'format' => 'raw',
                    
                            
                             'value'=>function ($model)  {
                    
                             if($model->pengajian->HighestEduLevel)
                             {
                             return strtoupper($model->pengajian->InstNm). ' <br> '. $model->pengajian->HighestEduLevel;}
                             else
                             {
                                return strtoupper($model->pengajian->InstNm). ' '. strtoupper($model->pengajian->tahapPendidikan);
                             }
                },
                            
                     
                        'vAlign' => 'middle',
                'hAlign' => 'center', 
                     
                    ],
                        [
                        'label' => 'STUDY PERIOD',
                        'format' => 'raw',
                    
                            
                             'value'=>function ($model)  {
                    
                                 return strtoupper($model->pengajian->tarikhmula). ' - '. strtoupper($model->pengajian->tarikhtamat);
                             },
                   
                     
                        'vAlign' => 'middle',
                'hAlign' => 'center', 
                     
                    ],
                        [
                        'label' => 'SPONSOR',
                        'format' => 'raw',
                    
                            
                             'value'=>function ($model)  {
                    
                            return $model->biasiswa->nama_tajaan;
                },
                            
                     
                        'vAlign' => 'middle',
                'hAlign' => 'center', 
                     
                    ],
                                              
                              [
                                            'header' => 'REPORT',
                                            'headerOptions' => ['class'=>'text-center'],
                                            'class' => 'yii\grid\ActionColumn',
                                            'template' => '{mohon}',
                                            'buttons' => [
                                                'mohon' => function($url, $model) 
                                                {
                                                        $ICNO = $model->icno;
                                                        $url = Url::to(['view-lkk-ums', 'id'=>$model->pengajian->icno]);
                                                       return 
                                                        Html::a('<i class="fa fa-bar-chart fa-xs"></i>', $url, ['title' => 'VIEW']); 
                                                    
                                                },
                                                        
                                                
                                                
                                        ],
                                                
                                            'contentOptions' => ['class' => 'text-center'],
                                        ],
                                
                            ],
                        ]); ?> 
            </div> <!-- x_content -->
        </div>
    </div>
</div>



            </div> <!-- x_content -->
            <div class="tile-stats" style='padding:10px'>
                        <div class="x_content">

                            <div style='padding: 15px;' class="table-bordered">
                                <font><u><strong>INFO</u> </strong></font><br><br>

                                <strong>
                                    
                                IF YOU HAVING TROUBLE ON SAVING STEP 1 OR STEP 3 SUCH AS WHEN YOU CLICK THE
                                BUTTON SAVE, IT MAKE YOU RETURN TO THE LOGIN PAGE, DO CLEAR YOU CACHE ON BROWSER SETTING
                                AND TRY TO LOGIN BACK.</strong>
                                
                                &nbsp;&nbsp;&nbsp;&nbsp;<br>

                            </div>
                                 
                        </div>

                    </div>
<div class="x_panel">
                <style>
.w3-table td,.w3-table th,.w3-table-all td,.w3-table-all th
{padding:2px 2px;display:table-cell;text-align:left;vertical-align:top}
</style>

                <div class="alert alert-info alert-dismissible fade in">
                        <table class="w3-table w3-bordered" style="font-size: 15px; color:white">
                          <h5 style="color:white">
                              <i class="fa fa-question-circle" style="color:white"></i> 
                              PLEASE MAKE SURE ALL THE FIELDS ARE FILLED IN CORRECTLY:</h5>
                          <tr>
                             <td width="50px" height="20px"><center>1.</center></td> 
                        <td><small>STEP 1:<strong> PROGRESS REPORT - PLEASE FILL THE FIELDS ON 
                                    THE ADVISOR'S/SUPERVISOR'S COMMENT SECTION, AND CLICK SAVE.</strong></small> </td>
                          </tr>
                            <tr>
                             <td width="50px" height="20px"><center>2.</center></td> 
                        <td><small>STEP 2: <strong>GOT SCHEDULE- 
                                    VIEW THE ACTIVITY SUBMISSION BY YOUR STUDENT .</strong></small></td>
                          </tr>
                         <tr>
                             <td width="50px" height="20px"><center>3.</center></td> 
                        <td><small>STEP 3: <strong>SUPERVISOR RATING - RATE 
                                    YOUR STUDENT PERFORMANCE IN THE CURRENT PROGRESS REPORT
                                    AND CHECK ALL THE FIELDS ARE FILLED IN CORRECTLY BEFORE SUBMIT.  </strong></small></td>
                          </tr>
                        
                         </table>
                </div>
            </div>

