 <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\hronline\GredJawatan;
use app\models\keselamatan\RefShifts;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile; 
use kartik\grid\GridView;
use app\widgets\TopMenuWidget;
use kartik\widgets\TimePicker;
/* @var $this yii\web\View */
/* @var $model app\models\mohonjawatan\TblPermohonan */
/* @var $form ActiveForm */
$this->registerJs(
    "$('#save-draft-btn').on('click', function (e) {
    $.ajax({
       type: 'POST',
       url: draftUrl,
       data: $('#report-index').serialize()
    });      
})",
    'my-button-handler'
);
?>
<?= $this->render('/keselamatan/_topmenu') ?>


  <div class="control-label col-md-12"> 
    <div class="x_panel">
        
          <div class="x_title">
            <h2>Selenggara Senarai Syif</h2>
            
            </ul>
            <div class="clearfix"></div>
        </div>  

           <div class="x_content">
               
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
               <div class="form-group">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">Nama Syif : <span class="required" style="color:red;">*</span>
                   </label>
                   <div class="col-md-6 col-sm-6 col-xs-12">
                       <?= $form->field($refshift, 'jenis_shifts')->textInput(['maxlength' => true, 'rows' => 4])->label(false); ?>
                   </div>
               </div>
               <div class="form-group">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">Syif Mula : <span class="required" style="color:red;">*</span>
                   </label>

                   <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                       <?=
                       TimePicker::widget([
                           'model' => $refshift,
                           'attribute' => 'start_time',
                           'pluginOptions' => [
                               'showSeconds' => true,
                               'showMeridian' => false,
                               'minuteStep' => 1,
                               'secondStep' => 5,
                           ]
                       ]);
                       ?>
                   </div>
               </div>
               <div class="form-group">
                   <label class="control-label col-md-4 col-sm-6 col-xs-12">Syif Tamat : <span class="required" style="color:red;">*</span>
                   </label>

                   <div class="col-md-3 col-md-3 col-sm-6 col-xs-12">
                       <?=
                       TimePicker::widget([
                           'model' => $refshift,
                           'attribute' => 'end_time',
                           'pluginOptions' => [
                               'showSeconds' => true,
                               'showMeridian' => false,
                               'minuteStep' => 1,
                               'secondStep' => 5,
                           ]
                       ]);
                       ?>
                   </div>
               </div>
               
               <div class="form-group">
                <label class="control-label col-md-4 col-sm-6 col-xs-12">Spesifikasi Syif : <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?= $form->field($refshift, 'details')->textArea(['maxlength' => true, 'rows' => 4])->label(false); ?>
                </div>
            </div>          
               
                <div class="ln_solid"></div>

            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-success', 'url' => ['index']]) ?>
                </div>
            </div>
          
            <?php ActiveForm::end(); ?>
           </div>
                  </div>
    </div>  <!-- end of xpanel-->
    <div class="x_panel">

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'class' => 'table-responsive',
            ],
            /*   'filterModel' => $searchModel, */ //to hide the search row
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'label' => 'Nama Syif',
                    'value' => 'jenis_shifts',
                ],
                [
                    'label' => 'Spesifikasi Syif',
                    'value' => 'details',
                ],
                [
                    'label' => 'Masa Mula Syif',
                    'value' => 'start_time',
                ],
                 [
                    'label' => 'Masa Tamat Syif',
                    'value' => 'end_time',
                ],
                [
                    'label'=> 'Status',
                    'format'=> 'raw',
                    'value'=>'active',
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => 'Actions',
                    'template' => '{update} | {delete}',
                    'hAlign' => 'center',
                ],
            ],
             'headerRowOptions' => ['class' => 'kartik-sheet-style'],  
                'resizableColumns' => true,
                'responsive' => false,
                'responsiveWrap' => false,
                    'hover' => true,
                    'floatHeader' => true,
                    'floatHeaderOptions' => [
                        'position' => 'absolute',
                    ],
        ]);
        ?>
    </div>  <!-- end of xpanel-->
</div> <!-- end of md-->
