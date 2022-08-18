<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\grid\GridView;
use kartik\form\ActiveForm;
?>

<?= $this->render('_menu',['model'=>$model]) ?>


<div class="row"> 
    <div class="col-xs-12 col-md-12 col-lg-10 center-margin">
    <div class="x_panel">
        <div class="x_content">
            <p align="justify">
			   <u><b>BAHAGIAN B</b></u><br>
               Soal selidik ini bertujuan untuk mengenal pasti tahap integriti dan kesejahteraan Universiti Malaysia Sabah. Anda dipohon untuk menjawab semua soalan dengan teliti dan jujur. Sebarang maklumat yang diperoleh akan dirahsiakan. Segala kerjasama daripada YBhg. Datuk/ Prof./ Dr. / Tuan/ Puan diucapkan terima kasih.
			   <br>
			   <i>The purpose of this survey is to identify the level of integrity values amongst UMS staff and the level of organisational integrity at UMS. You are requested to answer all questions carefully and honestly.
			   <br>All information provided will be kept confidential. Thank you for your cooperation.</i>
            </p>
            <hr>
            <p>
                Skala permarkahan adalah seperti berikut: / The rating scale is as follows:
            </p>
            
			1 - Sangat Tidak Setuju. / <i>Strongly Disagree </i><br>
			2 - Tidak Setuju. / <i>Disagree </i><br>
			3 - Agak Setuju. / <i>Somewhat Agree </i><br>
			4 - Setuju. / <i>Agree </i><br>
			5 - Sangat Setuju. / <i>Strongly Agree</i>
            
            
            <?php 
                $form = ActiveForm::begin(['action' => ['bahagianb?id='.$model->id], 'method' => 'post', ]);
                
            ?>
					
            <div class="table-responsive">
            <?=
                GridView::widget([
                    'summary' => '',
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'label' => 'Bil. / No.',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:5%'],
                            'value' => 'id',
                        ],
                        [
                            'label' => 'Penyataan / Statement',
                            'headerOptions' => ['class'=>'text-center'],
                            //'contentOptions' => ['style'=>'width:75%'],
                            'value' => 'soalan',
                            'format' => 'html'
                                    
                        ],
                        [
                            'label' => 'Skala / Scale',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:20%'],
                            'value' => function($model) use ($form, $model2) {
                                //return Html::radio('skor['.$model->id.']', false, ['value' => $model->id]);
                                $data = [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'];
                                return $form->field($model2, "q$model->id")->radioButtonGroup($data, ['onchange' => 'test(this.id)', 'id' => "q$model->id", 'name' => "q$model->id"])->label(false);
                            },
                                    'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
            </div>
            <div class="form-group pull-right">
                <div class="">
                    <?= Html::submitButton('Teruskan ke Bahagian C / Continue to Part C', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div> 
    </div></div>
</div>
<script>
var idp = "<?= $model2->id_penilaian ?>";
function test(id) {
    var val = $('input[name='+id+']:checked').val();
    $.ajax({
           timeout: 0,
           url: "save-b?id="+id+"&val="+val+"&idpenilaian="+idp,
           success: function() {
               document.getElementById(id).style.border = "thick solid green";
               $('#'+id).attr('data-content', 'saved');
               $('#'+id).attr('data-trigger', 'hover');
               $('#'+id).popover();
    }
      });
}
    
    function button(){
          var radios = document.querySelectorAll('input[type="radio"]:checked');
          if(radios.length != 41){
              alert('Please complete all the questions');
          }
          else{
              window.open("bahagianc?id="+idp, "_self");
          }
    }

 </script>