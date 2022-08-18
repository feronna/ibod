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
			   <u><b>BAHAGIAN A / <i>PART A</i></b></u><br>
               Soal selidik ini bertujuan untuk mengenal pasti tahap nilai integriti kakitangan Universiti Malaysia Sabah. Anda dipohon untuk menjawab semua soalan dengan teliti dan jujur.<br>
               Sebarang maklumat yang diperoleh akan dirahsiakan. Segala kerjasama daripada YBhg. Datuk/ Prof./ Dr. / Tuan/ Puan diucapkan terima kasih.
			   <br>
			   <i>The purpose of this survey is to identify the level of integrity values amongst UMS staff and the level of organisational integrity at UMS. You are requested to answer all questions carefully and honestly. All information provided will be kept confidential.<br>
			   Thank you for your cooperation.</i>
            </p>
            <hr>
            <p>
                Skala permarkahan adalah seperti berikut: / The rating scale is as follows:
            </p>
            
			1 - Tidak Tepat Dengan Diri Saya. / <i>Not True to Myself.</i><br>
			2 - Kurang Tepat Dengan Diri Saya. / <i>Less True to Myself</i><br>
			3 - Hampir Tepat Dengan Diri Saya. / <i>Almost True to Myself</i><br>
			4 - Tepat Dengan Diri Saya. / <i>True to Myself </i><br>
			5 - Sangat Tepat Dengan Diri Saya. / <i>Very True to Myself </i><br><br>
            
            
            <?php 
                $form = ActiveForm::begin(['action' => ['bahagiana?id='.$model->id], 'method' => 'post', ]);
                
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
                            'format' => 'raw'
                        ],
                        [
                            'label' => 'Penyataan / Statement',
                            'headerOptions' => ['class'=>'text-center'],
                            //'contentOptions' => ['style'=>'width:75%'],
                            'value' => 'soalan',
                            'format' => 'raw'
                                    
                        ],
                        [
                            'label' => 'Skala / Scale',
                            'headerOptions' => ['class'=>'text-center'],
                            'contentOptions' => ['class'=>'text-center', 'style'=>'width:22%'],
                            'value' => function($model) use ($form, $model1) {
                                //return Html::radio('skor['.$model->id.']', false, ['value' => $model->id]);
                                $data = [1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5'];
                                return $form->field($model1, "q$model->id")->radioButtonGroup($data, ['onchange' => 'test(this.id)', 'id' => "q$model->id", 'name' => "q$model->id"])->label(false);
                            },
                                    'format' => 'raw'
                        ],
                    ],
                ]);
            ?>
            </div>
            <div class="form-group pull-right">
                <div class="">
                    <?= Html::submitButton('Teruskan ke Bahagian B / Continue to Part B', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div> 
    </div></div>
</div><script>
var idp = "<?= $model1->id_penilaian ?>";
function test(id) {
    var val = $('input[name='+id+']:checked').val();
    $.ajax({
           timeout: 0,
           url: "save-a?id="+id+"&val="+val+"&idpenilaian="+idp,
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
          if(radios.length != 69){
              alert('Please complete all the questions');
          }
          else{
              window.open("bahagianb?id="+idp, "_self");
          }
    }

 </script>