<?php 

use yii\helpers\Url;
use yii\helpers\Html;
use app\widgets\TopMenuWidget;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
$this->title = 'Create File';
$this->params['breadcrumbs'][] = $this->title;

?>
<?= TopMenuWidget::widget(['top_menu' => [18,44,45,51], 'vars' => [
    ['label' => ''],
//    ['label' => app\models\kontrak\Kontrak::totalPending(Yii::$app->user->getId())]
]]); ?>

 <div class="x_panel">
        
          <div class="x_title">
            <h2>Permohonan Jawatan</h2>
            
            </ul>
            <div class="clearfix"></div>
        </div>  

           <div class="x_content">
               
               <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
            
   <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Upload File: <span class="required" style="color:red;">*</span>
                </label>
                <div class="col-md-4 col-sm-4 col-xs-10">
                    <span class="required" style="color:red;"><?= Yii::$app->session->getFlash('Gagal'); ?></span>
                    <?php
                    if (!empty($model->filename) && $model->filename != 'deleted') {
                        echo Html::a(Yii::$app->FileManager->NameFile($model->filename));
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
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <?= Html::submitButton('Hantar ', ['class' => 'btn btn-success','url' => ['index']]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
           </div>