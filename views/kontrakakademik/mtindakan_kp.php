<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\kontrak\TblKpi;
use app\models\kontrak\TblKpiByYear;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

error_reporting(0);
$bil=1;

//Pjax::begin(['enablePushState' => false, 'id' => 'newmodel','clientOptions' => ['method' => 'POST']]);
$form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>
<script>
    var id = '<?= $model->id?>';
    $(document).ready(function(){
        $("#mod").on('hidden.bs.modal', function(){
            $('#submitdiv').load('mtindakan_kp?id='+id+' #submitdiv');
  });
    });
</script>
<script>$(function(){
    
    $('.mapB').click(function (){
       $('#mod').modal('show')
               .find('#content')
               .load($(this).attr('value'));
    });
    
    
    
});</script>

        <div class="row"> 
            <div class="x_panel">
                <div class="x_title">
                    <div class="clearfix"></div>
                </div> <br>
                <div id="pop" class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-3" for="wp_id"></label>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                <button value = "/staff/web/kontrakakademik/kpi_kp?id=<?= $model->id?>&modal=mod" id="op" type="button" class="btn btn-primary btn-md fa fa-edit mapB" style=" width : 100%;"> Key Performance Indicators</button></div>
                                <br>   <br>         
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Status of Endorsement<span class="required" style="color : red"> *</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-6"><div style="display: none"><button value = "<?= $model->id?>" id="id" type="button"></button></div>
                       <?=
                    $form->field($model, 'status_pp')->label(false)->widget(Select2::classname(), [
                        'data' => ['4' => 'APPROVE', '5' => 'REJECT'],
                        'options' => ['required' => true,'placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'statusapproval($(this).val())'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                    </div>
                </div>
                <script>
                function statusapproval(val){
                    var perakuan = "<?=$model->kpi_kp?>";
                        if (val === "4"){
                        document.getElementById("kontrak-tempoh_l_pp").required = true;
                        document.getElementById("kontrak-cadangan_jawatan_ver").required = true;
                        $("#post").show();
                        $("#kpiwarning").show();
                        $('#submitdiv').load('mtindakan_kp?id='+id+' #submitdiv');
                        }
                        else{
                        document.getElementById("submit").disabled = false;
                        $("#kontrak-cadangan_jawatan_ver").val("").trigger("change");
                        document.getElementById("kontrak-cadangan_jawatan_ver").required = false;
                        document.getElementById("kontrak-tempoh_l_pp").required = false;
                        $("#post").hide();
                        $("#tempoh").hide();
                        $("#kpiwarning").hide();
                        }
                    }
                </script>
                
                <div id="post" style="display: <?php echo $model->status_pp === 4? '':'none';?>" class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Suggestion Post
                        <span class="required" style="color : red"> *</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <?=
                    $form->field($model, 'cadangan_jawatan_ver')->label(false)->widget(Select2::classname(), [
                        'data' => $model->cadanganjawatan,
                        'options' => ['required' => true,'placeholder' => 'Pilih', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'jawatan($(this).val())'
                           ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                ?></div>
                </div>
       
                <div class="form-group" id="tempoh" style="display: <?php echo $model->status_pp === 4? '':'none';?>">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="wp_id">Proposed Contract Re-appointment Period<span class="required" style="color : red"> *</span>
                </label>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <?php 
                    $tempoh =$model->layaktempohakademik;
                    ?>
                    <?=
                    $form->field($model, 'tempoh_l_pp')->label(false)->widget(Select2::classname(), [
                        'data' => $tempoh,
                        'options' => ['required' => true,'placeholder' => 'Choose', 'class' => 'form-control col-md-7 col-xs-12',
                            'onchange' => 'javascript:
                        if ($(this).val() == "Others"){
                        $("#lain").show();
                        }
                        else{
                        $("#lain").hide();
                        }'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);?>
                    <div id="lain" style="display:none">
                     <div class="col-md-3 col-sm-3 col-xs-3">
                       <input onchange="myFunction(this.value)" type="number" min="1" max="12" id="place-holder" name="tempohs" class="form-control" maxlength="2" value="<?php if($lain){echo (float)$lain;}else{echo '1';}?>">
                     </div>
                    <div style="margin-top: 50px;margin: 0px; font-size: 14px;padding:0px;float: left;" class="col-md-3 col-sm-6 col-xs-6">Months   
                    </div></div>
                </div>
                    <script>
                    function jawatan(val) {
                        var post = "<?= strtoupper($model->kakitangan->jawatan->namaenglish.' '.$model->kakitangan->jawatan->gred)?>";
                        var umur = "<?= $model->kakitangan->umur?>";
                        if(val === post && umur>=65){
                            $("#kontrak-tempoh_l_pp").val("1 Year").trigger("change");
                            $("#kontrak-tempoh_l_pp option[value*='2 Years']").prop('disabled', true);
                            $("#kontrak-tempoh_l_pp option[value*='3 Years']").prop('disabled', true);
                        }
                        else{
                            $("#kontrak-tempoh_l_pp option[value*='2 Years']").prop('disabled', false);
                            $("#kontrak-tempoh_l_pp option[value*='3 Years']").prop('disabled', false);
                        }
                        if(val===''){
                            $("#tempoh").hide();
                        }
                        else{
                            $("#tempoh").show();
                        }
                    }
                    </script>
            </div>
                
                <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Attachement
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?= $form->field($model, 'file')->fileInput()->label(false) ?>
            </div>
        </div>
                
                <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Comment<span class="required" style="color : red"> *</span></label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <textarea id="kontrak-ulasan_pp" class="form-control" name="comment" rows="4" required></textarea>
                    </div>
                </div>
                
                <div id="submitdiv" class="form-group">
                    <div align="center" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <?php $buttondisable= $model->kpi_kp ==1? false: true?>
                        <?= Html::submitButton('<i class="fa fa-paper-plane"></i> Submit', ['class' => 'btn btn-primary', 'id'=>'submit','disabled' => $buttondisable]) ?>
                    </div>
                </div>
                <div id="kpiwarning" class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                    <div style="color:green" class="col-md-6 col-sm-6 col-xs-12">
                       **Please approve the Key Performance Indicators to enable the submit button
                    </div>
                </div>
            </div>
        </div>
            <?php ActiveForm::end(); 
//            Pjax::end();
            ?>



