<?php 

use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\TopMenuWidget;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
$this->title = 'Create File';
$this->params['breadcrumbs'][] = $this->title;

?>
  <div class="x_title">
            <h5>Permohonan KPM</h5>
            
            </ul>
            <div class="clearfix"></div>
        </div>  

 <div class="x_panel">
        
        

           <div class="x_content">
               
               <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
            
   <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muat Naik Dokumen: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-10">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php
                    if (!empty($model->namafile) && $model->namafile != 'deleted') {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->namafile));
                        echo '&nbsp&nbsp&nbsp&nbsp';
                        if($model->id){
                            echo Html::a('Padam', ['deletegambar', 'id' => $model->id], ['class' => 'btn btn-danger']) . '<p>';
                        }
                        
                    }
                    else{
                       echo $form->field($model, 'namafile')->fileInput()->label(false);
                    }
                    ?>
                </div>
                <!--<span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>-->
        </div>   
            <div class="form-group">
               <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button class="btn btn-primary btn-sm" type="reset">Reset</button>
                    <?= Html::submitButton('Muat Naik ', ['class' => 'btn btn-success btn-sm','url' => ['index']]) ?>
                </div>
            </div>
 <?= $form->field($model, 'dokumenCd')->hiddenInput(['value' =>  $id = Yii::$app->request->get('id')])->label(false)?>
 <?= $form->field($model, 'iklan_id')->hiddenInput(['value' => $iklan->id])->label(false); ?>
            <?php ActiveForm::end(); ?>
           </div>   </div>