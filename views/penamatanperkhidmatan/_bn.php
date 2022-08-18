<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\models\kontrak\Kontrak;
use yii\helpers\ArrayHelper;

error_reporting(0);
$bil=1;

?>
<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left']]); ?>


        <div class="row">  
    <div class="x_panel">
        <h2><strong>Berdasarkan rekod jabatan, sila sahkan perkara berikut: </strong></h2>
        <br>
        <div class="x_content">
            <div class="table-responsive">
            <table class="table table-striped jambo_table table-bordered" style="text-align:center;">
               
                    <th class="text-center">BIL</th>
                    <th class=" text-center">PERKARA</th>
                    <th class=" text-center">TIDAK</th>
                    <th class="text-center">YA</th>
                    <th id="baki" style="display:none" class="text-center">BAKI (RM)</th>
          
                <tbody
                    <?php
                    $bil=1;
                    foreach($refbn as $refbn){
                        if($refbn->id != 5){?>
                    <tr>
                        <td><?= $bil?></td>
                        <td><?= $refbn->perkara?></td>
                        <td>
                            <input onchange="myFunction(this.value)" type="radio" name=<?=$refbn->id?> value=<?= "n".$refbn->id?>>
                        </td>
                        <td>
                            <input onchange="myFunction(this.value)" type="radio" name=<?=$refbn->id?> value=<?= "y".$refbn->id?>>
                        </td>
                        <td style="display:none" id=<?= "baki".$refbn->id?>>
                            <input type="number" step=".01" name="radio">
                        </td>
                    </tr>
                    
                    <?php $bil++;}}?>
                    </tbody>
            </table>
        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Lain-lain :
                            </label>
                            <div class="col-md-9 col-sm-9 col-xs-12">
                                <textarea style="width:90%;" name="radio"></textarea>
                            </div>
                        </div>
        </div>
        <script>
            function myFunction(val) {
                var id = val.substr(1);
                var status = val.substr(0,1);
                if(val === "y"+id){
                    $("#baki"+id).show();
                    $("#baki1"+id).show();
                }
                else{
                    $("#baki"+id).hide();
                    $("#baki1"+id).hide();
                }
                if(status === "y"){
                    $("#baki").show();
                }
            }
        </script>
        
         <div class="ln_solid"></div>

            <div class="form-group" align="center">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <?= Html::submitButton('Hantar', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
            <?php ActiveForm::end(); ?>

