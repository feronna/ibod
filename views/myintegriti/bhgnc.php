<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use app\models\myintegriti\TblBhgnC;
//use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TblBhgnB */
/* @var $form ActiveForm */
?>

<?= $this->render('_menu',['model'=>$model1]) ?>
 
<div class="row"> 
    <div class="col-xs-12 col-md-12 col-lg-10 center-margin">
    <div class="x_panel">
        <div class="x_content">
		<p align="justify">
		   <u><b>BAHAGIAN C / <i>PART C</i></b></u><br>
		   Anda dipohon untuk menjawab semua soalan dengan teliti dan jujur. <br>
		   Sebarang maklumat yang diperoleh akan dirahsiakan. Segala kerjasama daripada YBhg. Datuk/ Prof./ Dr. / Tuan/ Puan diucapkan terima kasih.
		   <br>
		   <i>You are requested to answer all questions carefully and honestly.<br>
		   All information provided will be kept confidential. Thank you for your cooperation.</i>
		</p>
		<hr>         
		
		<?php 
			$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]);
			$list = [1 => 'Ya / <i>Yes</i>', 0 => 'Tidak / <i>No</i>'];
		?>

		<div class="table-responsive">
		<table class="table table-striped table-bordered">
		<tr>
		<th class="text-center">BIL./NO.</th>
		<th class="text-center">PERNYATAAN/STATEMENT</th>
		<th class="text-center">JAWAPAN/ANSWER</th>
		</tr>
		<tr>
		<td class="text-center" style="width:5%">1</td>
		<td>Saya akan mengadukan sebarang salah laku berkaitan rasuah kepada Ketua Jabatan atau Universiti. / <i>I will report any corruption-related misconduct to the Head of Department or University.</i></td>
		<td><?= $form->field($model, 'b1')->radioList($list, ['onchange' => 'test(this.id)', 'id' => "b1", 'name' => "b1", 'encode' =>false])->label(false); ?></td>
		</tr>
		<tr>
		<td class="text-center" style="width:5%">2</td>
		<td>Saya akan memaklumkan konflik kepentingan kepada mesyuarat atau Ketua Jabatan sekiranya saya mempunyai kepentingan terhadap tugasan. / <i>I will inform of any conflict of interest in a meeting or to the Head of Department in the event that I have vested interest in a task.</i></td>
		<td><?= $form->field($model, 'b2')->radioList($list, ['onchange' => 'test(this.id)', 'id' => "b2", 'name' => "b2", 'encode' =>false])->label(false); ?></td>
		</tr>
		<tr>
		<td class="text-center" style="width:5%">3</td>
		<td>Saya tahu terdapatnya saluran untuk membuat aduan berhubung salah laku atau perlanggaran integriti di UMS. / <i>I am aware of the available channels to file reports of misconduct or integrity violation in UMS.</i></td>
		<td><?= $form->field($model, 'b3')->radioList($list, ['onchange' => 'test(this.id)', 'id' => "b3", 'name' => "b3", 'encode' =>false])->label(false); ?></td>
		</tr>
		<tr>
		<td class="text-center" style="width:5%">4</td>
		<td>Saya tahu terdapat program/ aktiviti kesedaran (awareness) berkaitan integriti di UMS. / <i>I know there are integrity-related awareness programmes/activities in UMS. </i></td>
		<td><?= $form->field($model, 'b4')->radioList($list, ['onchange' => 'test(this.id)', 'id' => "b4", 'name' => "b4", 'encode' =>false])->label(false); ?></td>
		</tr>
		<tr>
		<td class="text-center" style="width:5%">5</td>
                <td>Saya pernah menghadiri program/ aktiviti kesedaran (awareness) berkaitan integriti yang dianjurkan oleh UMS./ <i>I have attended integrity-related awareness programmes/activities organised by UMS.</i></td>
		<td><?= $form->field($model, 'b5')->radioList([1 => 'Ya / <i>Yes</i>', 0 => 'Tidak / <i>No</i>', 2 => 'Tidak berkaitan / <i>Not relevant</i>'], ['onchange' => 'test(this.id)', 'id' => "b5", 'name' => "b5", 'encode' =>false])->label(false); ?></td>
		</tr>
		<tr>
		<td class="text-center" style="width:5%">6</td>
		<td>Saya memaklumkan Ketua Jabatan berhubung tindakan mahkamah (jenayah/sivil) terhadap diri saya. / <i>I have informed my Head of Department of any court action (criminal/civil) against me. </i></td>
		<td><?= $form->field($model, 'b6')->radioList([1 => 'Ya / <i>Yes</i>', 0 => 'Tidak / <i>No</i>', 2 => 'Tidak berkaitan / <i>Not relevant</i>'], ['onchange' => 'test(this.id)', 'id' => "b6", 'name' => "b6", 'encode' =>false])->label(false); ?></td>
		</tr>
		<tr>
		<td class="text-center" style="width:5%">7</td>
		<td>Saya pernah dikenakan tindakan tatatertib oleh Universiti. (Jika tiada, sila terus ke soalan 10). / <i>The University has in the past exercised disciplinary action against me. (If no, please proceed to question 10)</i></td>
		<td><?= $form->field($model, 'b7')->radioList($list, ['onchange' => 'test(this.id)', 'id' => "b7", 'name' => "b7", 'encode' =>false])->label(false); ?></td>
		</tr>
		<tr>
		<td class="text-center" style="width:5%">8</td>
		<td>Berdasarkan soalan 7, saya berpuas hati dengan keputusan Jawatankuasa Tatatertib.  / <i>Based on question 7, I am satisfied with decision of the Disciplinary Committee. </i>  </td>
		<td><?= $form->field($model, 'b8')->radioList($list, ['onchange' => 'test(this.id)', 'id' => "b8", 'name' => "b8", 'encode' =>false])->label(false); ?></td>
		</tr>
		<tr>
		<td class="text-center" style="width:5%">9</td>
		<td colspan='2'>Saya tidak berpuas hati dengan hukuman yang dikenakan terhadap saya kerana / <i>I am dissatisfied with my punishment because</i><br><br>
		<?php $list10 = [1 => 'Hukuman adalah terlalu berat / the punishment was too heavy', 2 => 'Hukuman adalah terlalu ringan / the punishment was too light.', 3 => 'Hukuman tidak efektif / the punishment was not effective.', 0 => 'Lain-lain / Others']; ?>
                    <div class = "col-xs-1 col-md-1 col-lg-9">
                <?= $form->field($model, 'b9')->radioList($list10, ['onchange' => 'test9(this.id)', 'id' => "b9", 'name' => "b9", 'encode' =>false])->label(false); ?>
                <div id="lain9" style="display: <?= $model->b9===0? :'none'?>">
                    <?= $form->field($model, 'b9_others')->textInput(['maxlength' => true, 'rows' => 4, 'onchange' => 'savelain9(this.value)'])->label(false); ?>
                </div></div>
                    </td>
		</tr>
		<tr>
		<td class="text-center" style="width:5%">10</td>
		<td>Adakah anda tahu wujudnya Pejabat Penasihat Undang-Undang di UMS yang mengendalikan kes integriti di UMS? / <i>Are you aware of the existence of the Office of the UMS Legal Advisor which manages integrity cases in UMS?</i></td>
		<td><?= $form->field($model, 'b10')->radioList($list, ['onchange' => 'test(this.id)', 'id' => "b10", 'name' => "b10", 'encode' =>false])->label(false); ?></td>
		</tr>
		</table>
		</div>
		
		<div class="form-group">
		<label>Apakah pandangan anda berkaitan dengan pelaksanaan MyIntegrity@UMS ini? / <i>What is your opinion on the implementation of MyIntegrity@UMS?</i></label>
		<div>
		<?= $form->field($model, 'komen')->textArea(['maxlength' => true, 'rows' => 4, 'id' => 'komen','onchange' => 'savekomen(this.value)'])->label(false); ?>
		</div>
		</div>
			
		<div class="form-group pull-right">
		<div class="">
                    <?= Html::submitButton('Hantar / Submit', ['class' => 'btn btn-success']) ?>
                </div>
		</div>
		<?php ActiveForm::end(); ?>
        </div> 
    </div>
	</div>
</div>

<script>
var idp = "<?= $model->id_penilaian ?>";
function test(id) {
    var val = $('input[name='+id+']:checked').val();
    $.ajax({
           timeout: 0,
           url: "save-c?id="+id+"&val="+val+"&idpenilaian="+idp,
           success: function() {
               document.getElementById(id).style.border = "solid green";
               $('#'+id).attr('data-content', 'saved');
               $('#'+id).attr('data-trigger', 'hover');
               $('#'+id).popover();
    }
      });
    if( id === 'b7'){
        if(val === '0'){
            $('input[name=b8]').attr('checked', false);
            $('input[name=b8]').attr('disabled', true);
             $('input[name=b9]').attr('checked', false);
            $('input[name=b9]').attr('disabled', true);
        }else{
            $('input[name=b8]').attr('disabled', false);
            $('input[name=b9]').attr('disabled', false);
        }
    }
}

function savekomen(val){
    $.ajax({
            timeout: 0,
            url: "save-c?id=komen&val="+val+"&idpenilaian="+idp,
            success: function() {
               document.getElementById('komen').style.border = "solid green";
               $('#komen').attr('data-content', 'saved');
               $('#komen').attr('data-trigger', 'hover');
               $('#komen').popover();
             }
               });
}
function savelain9(val){
    $.ajax({
           timeout: 0,
           url: "save-c?id=b9_others&val="+val+"&idpenilaian="+idp,
           success: function() {
               document.getElementById('tblbhgnc-b9_others').style.border = "solid green";
               $('#tblbhgnc-b9_others').attr('data-content', 'saved');
               $('#tblbhgnc-b9_others').attr('data-trigger', 'hover');
               $('#tblbhgnc-b9_others').popover();
    }
      });
}
            
function test9(id) {
    var val = $('input[name='+id+']:checked').val();
    if(val == 0){
        $("#lain9").show();
    }else{$("#lain9").hide();}
    $.ajax({
           timeout: 0,
           url: "save-c?id="+id+"&val="+val+"&idpenilaian="+idp,
           success: function() {
               document.getElementById(id).style.border = "solid green";
               $('#'+id).attr('data-content', 'saved');
               $('#'+id).attr('data-trigger', 'hover');
               $('#'+id).popover();
    }
      });
}

 </script>
