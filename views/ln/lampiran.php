<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
error_reporting(0);
/* @var $this yii\web\View */
/* @var $model app\models\ln\Ln */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal form-label-left disable-submit-buttons', 'id' => 'dynamic-form']]); ?>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<?php echo $this->render('/ln/_topmenu'); ?> 
</div>
</div>

<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><strong><i class="fa fa-list"></i> LAMPIRAN A</strong></h2>
            <p align="right"><?= \yii\helpers\Html::a('Kembali', ['lampiran-a'], ['class' => 'btn btn-primary']) ?></p>      
            <div class="clearfix"></div>
        </div>
    <div class="col-md-12 col-xs-12">
        
    <div class="row">    
    <div class="x_panel">
        <div class="x_content">
        <div class="table-responsive">
        <div class="col-md-10 col-sm-10 col-xs-12">
            
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Lampiran A :<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12" style="color: green;">
                <a href="<?php echo Url::to('@web/'.'uploads/LAMPIRAN A_KPT.pdf', true); ?>" target="_blank" ><i class="fa fa-download"></i> Klik Sini Untuk Muat Turun</a><br> 
                    <p>Lampiran A ini perlu dimuat turun dan diisi oleh setiap pemohon.</p>
            </div>
            </div>
        </div>
        
        <div class="form-group" id="file4">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="uploadfile">Muat Naik Dokumen: <span class="required" style="color:red;">*</span>
            </label>
            <span data-toggle="tooltip" ><i class="fa fa-info-circle fa-lg"></i></span>
            <div class="col-md-3">
                <?= $form->field($model, 'file4')->fileInput()->label(false) ?>
                <div class="col-md-12 col-sm-12 col-xs-12" style="color: green; margin-top: -15px;">
                    <p>Sila muat naik Lampiran A yang anda telah anda isi dan lengkapkan.</p>
                </div> 
            </div>
        </div>
                
        </div>
        </div>
        </div>
    </div>
    </div> 

    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <button class="btn btn-primary" type="reset">Reset</button>
            <?= Html::submitButton('Hantar',['class' => 'btn btn-success', 'data'=>['disabled-text' => 'Please Wait..' , 'confirm'=>'Sila pastikan maklumat permohonan adalah tepat. Permohonan yang telah dihantar tidak boleh dipinda atau dikemaskini. Teruskan?' ]]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
        
    </div>   
    </div>
</div>
</div>